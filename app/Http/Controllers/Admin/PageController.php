<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;

class PageController extends Controller {
	function __construct () {
		$this->middleware('auth', ['except' => ['index']]);
	}

	public static function index () {
		if (Auth::check())
			return view('admin.index');
		else
			return view('admin.login');
	}

	public static function settings () {
		return view('admin.settings', [
			'email' => Auth::user()->email
		]);
	}
}