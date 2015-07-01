<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;

class PageController extends Controller {
	public static function index () {
		if (Auth::check())
			return view('admin.index');
		else
			return view('admin.login');
	}
}