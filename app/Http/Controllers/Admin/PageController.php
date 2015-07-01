<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Models\Alert;
use App\Tools\Models\User;
use Auth;

class PageController extends Controller {
    function __construct() {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public static function index() {
        if (Auth::check())
            return view('admin.index', [
                'alerts' => Alert::whereUser(Auth::user()->id)->latest()->get()
            ]);
        else
            return view('admin.login');
    }

    public static function settings() {
        return view('admin.settings');
    }

    public static function createUser() {
        return view('admin.createuser');
    }

    public static function modifyUser() {
        return view('admin.modifyuser', [
            'users' => User::all()
        ]);
    }

    public function alerts() {
        return view('admin.alerts', [
            'users' => User::all()
        ]);
    }
}