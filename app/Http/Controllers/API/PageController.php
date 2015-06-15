<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tools\API\Webhooks\Webhooks;
use App\Tools\Misc\GenerateApiKey;
use App\Tools\Models\User;
use App\Tools\Models\Webhook;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class PageController extends Controller {

	public function index(){
		if(Auth::check()) {
			$apiKey = Auth::user()->api_key;
			if (!$apiKey) {
				$apiKey = GenerateApiKey::generateKey();
				User::where('id', Auth::user()->id)->update([
					'api_key' => $apiKey
				]);
			}

			$webhooks = Webhook::where('user', Auth::user()->id)->get();

			return view('api.docs', [
				'apiKey' => $apiKey,
				'docs' => Config::get('api'),
				'webhooks' => Webhooks::getTypes(),
				'myHooks' => $webhooks
			]);
		} else
			return view('api.login');
	}

	public function generateKey(){
		$apiKey = GenerateApiKey::generateKey();

		User::where('id', Auth::user()->id)->update([
			'api_key' => $apiKey
		]);

		return redirect('/');
	}

	public function testPayload(Request $request){
		Log::info('Payload recieved.', $request->all());
		return response()->json($request->all());
	}

}