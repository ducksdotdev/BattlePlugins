<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Tools\Misc\Settings;
use App\Tools\Queries\CreateAlert;
use App\Tools\Queries\ServerSetting;
use Auth;
use Illuminate\Http\Request;

class ToolsController extends Controller {

    private $request;

    /**
     * @param Request $request
     */
    function __construct(Request $request) {
        $this->middleware('auth');
        $this->request = $request;
    }

    public function alert() {
        if (Auth::user()->admin) {
            foreach (User::all() as $user) {
                CreateAlert::make($user, $this->request->get('content'));
            }

            return redirect()->back()->with('success', 'Users have been alerted.');
        } else
            return redirect()->back();
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