<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tools\API\GenerateApiKey;
use App\Tools\Misc\UserSettings;
use App\Tools\Webhooks\Webhooks;
use Auth;
use Illuminate\Support\Facades\Config;

class PageController extends Controller {

    function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::USE_API)) {
            return view('api.docs', [
                'apiKey' => Auth::user()->api_key,
                'docs' => Config::get('api.docs'),
                'webhooks' => Webhooks::getTypes(),
                'myHooks' => auth()->user()->webhooks
            ]);
        } else abort(403);
    }

    public
    function generateKey() {
        GenerateApiKey::changeKey(auth()->user());
        return redirect()->back();
    }

}