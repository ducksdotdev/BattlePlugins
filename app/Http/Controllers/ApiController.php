<?php

namespace App\Http\Controllers;

use App\Tools\API\GenerateApiKey;
use App\Tools\Misc\UserSettings;
use App\Tools\Webhooks\Webhooks;
use Auth;
use Illuminate\Support\Facades\Config;

/**
 * Class ApiController
 * @package App\Http\Controllers\API
 */
class ApiController extends Controller {

    /**
     *
     */
    function __construct() {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::USE_API)) {
            return view('api.docs', [
                'apiKey' => Auth::user()->api_key,
                'docs' => Config::get('api.docs'),
                'webhooks' => Webhooks::getTypes(),
                'myHooks' => auth()->user()->webhooks
            ]);
        } else abort(403);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postGenerateKey() {
        GenerateApiKey::changeKey(auth()->user());
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateWebhook(Request $request) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::USE_WEBHOOKS)) {
            Webhooks::create($request->get('url'), $request->get('event'));
            return redirect()->back();
        } else
            abort(403);
    }

}