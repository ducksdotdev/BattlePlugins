<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Models\Alert;
use App\Tools\Models\ServerSettings;
use App\Tools\Models\User;
use Auth;
use Illuminate\Http\Request;

class ToolsController extends Controller {

    function __construct() {
        $this->middleware('auth');
    }

    public function alert(Request $request) {
        if (Auth::user()->admin) {
            foreach (User::all() as $user) {
                Alert::create([
                    'user' => $user->id,
                    'content' => $request->get('content'),
                    'color' => strtolower($request->get('color'))
                ]);
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
            $value = ServerSettings::whereKey($setting)->pluck('value');
            ServerSettings::whereKey($setting)->update([
                'value'=> !$value
            ]);
        } else
            ServerSettings::create(['key'=>$setting,'value'=>true]);


        return redirect()->back();
    }

}