<?php
namespace App\Http\Controllers\Admin;

use Auth;

class PageController {
	public static function index () {
		if (Auth::check())
			return view('admin.index');
		else
			return view('admin.login');
	}
}