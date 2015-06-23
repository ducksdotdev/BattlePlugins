<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class UserController extends Controller {

	public function login (Request $request) {
		$email = $request->input('email');
		$password = $request->input('password');
		$rememberMe = $request->input('rememberMe');

		if (Auth::attempt(['email' => $email, 'password' => $password], $rememberMe)) {
			return redirect('/');
		} else {
			return redirect('/')->with('error', 'There was an error logging you in. Please make sure your email is correct (and is an @battleplugins.com email). Also, remember that your password is case sensitive.');
		}
	}

	public function logout () {
		Auth::logout();
		return redirect()->back();
	}

}
