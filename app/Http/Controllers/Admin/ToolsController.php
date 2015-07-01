<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Models\Alert;
use App\Tools\Models\User;
use Auth;
use Illuminate\Http\Request;

class ToolsController extends Controller {

    function __construct() {
        $this->middleware('auth');
    }
    
    public function alert(Request $request) {
        foreach(User::all() as $user) {
            Alert::create([
                'user' => $user->id,
                'content' => $request->get('content'),
                'color' => strtolower($request->get('color'))
            ]);
        }

        return redirect()->back()->with('success', 'Users have been alerted.');
    }

    public function deleteAlert($id) {
        $alert = Alert::find($id);

        if($alert->user == Auth::user()->id)
            $alert->delete();

        return redirect()->back();
    }

}