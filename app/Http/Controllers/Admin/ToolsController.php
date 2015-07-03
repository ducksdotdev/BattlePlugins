<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Models\Alert;
use App\Tools\Models\ServerSettings;
use App\Tools\Models\User;
use App\Tools\Queries\CreateAlert;
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
                CreateAlert::make($user->id, $this->request->get('content'), $this->request->get('color'));
            }

            return redirect()->back()->with('success', 'Users have been alerted.');
        } else
            return redirect()->back();
    }

    public function deleteAlert($id) {
        $alert = Alert::find($id);

        if ($alert->user == Auth::user()->id)
            $alert->delete();

        return redirect()->back();
    }

    public function toggleSetting($setting) {
        $settingVal = ServerSettings::whereKey($setting)->first();

        if (count($settingVal) > 0) {
            $value = ServerSettings::get($setting);
            ServerSettings::whereKey($setting)->update([
                'value' => !$value
            ]);
        } else
            ServerSettings::create(['key' => $setting, 'value' => true]);

        return redirect()->back();
    }

    public function jsonAlerts() {
        return response()->json(Alert::whereUser(Auth::user()->id)->latest()->get());
    }
}