<?php

namespace App\Http\Controllers\API;

use App\Tools\Misc\GenerateApiKey;
use App\Tools\Webhooks\Webhooks;
use App\Webhook;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\User;
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