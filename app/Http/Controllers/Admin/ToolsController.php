<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Tools\Misc\Settings;
use App\Tools\Misc\UserSettings;
use App\Tools\Queries\CreateAlert;
use Auth;
use Illuminate\Http\Request;

class ToolsController extends Controller {

    private $request;

    /**
     * @param Request $request
     */
    function __construct(Request $request) {
        $this->middleware('auth.admin');
        $this->request = $request;
    }

    public function alert() {
        if (UserSettings::hasNode(auth()->user(), UserSettings::CREATE_ALERT)) {
            foreach (User::all() as $user) {
                CreateAlert::make($user, $this->request->get('content'));
            }

            return redirect()->back()->with('success', 'Users have been alerted.');
        } else
            abort(403);
    }

    public function deleteAlert($id) {
        auth()->user()->alerts()->detach($id);
        return redirect()->back();
    }

    public function toggleSetting($setting) {
        Settings::toggle($setting);
        return redirect()->back();
    }

    public function jsonAlerts() {
        $alerts = auth()->user()->alerts;
        return response()->json($alerts);
    }
}