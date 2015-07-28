<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tools\Misc\UserSettings;
use App\Tools\Webhooks\Webhooks;
use Auth;
use Illuminate\Http\Request;

/**
 * Class WebhookController
 * @package App\Http\Controllers
 */
class WebhookController extends Controller {

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request) {
        if (UserSettings::hasNode(auth()->user(), UserSettings::USE_WEBHOOKS)) {

            Webhooks::create($request->get('url'), $request->get('event'));
            return redirect()->back();
        } else
            abort(403);
    }
}