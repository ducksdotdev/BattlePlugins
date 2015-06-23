<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tools\API\GenerateApiKey;
use App\Tools\Models\User;
use App\Tools\Models\Webhook;
use App\Tools\Webhooks\Webhooks;
use Auth;

class PageController extends Controller {

	function __construct(){
		if(!Auth::check())
			return view('api.login');
	}

	public function index(){
		$apiKey = Auth::user()->api_key;
		if (!$apiKey) {
			$apiKey = GenerateApiKey::generateKey();
			User::find(Auth::user()->id)->update([
				'api_key' => $apiKey
			]);
		}

		$webhooks = Webhook::whereUser(Auth::user()->id)->get();

		return view('api.docs', [
			'apiKey' => $apiKey,
			'docs' => Config::get('api.docs'),
			'webhooks' => Webhooks::getTypes(),
			'myHooks' => $webhooks
		]);
	}

	public function generateKey(){
		$user = Auth::user();
		$user->api_key = GenerateApiKey::generateKey();
		$user->save();

		return redirect('/');
	}

}