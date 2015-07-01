<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

	public function changeSettings (Request $request) {
		$user = Auth::user();
		$confirmation = $request->input('confirmation');

		if (Auth::validate(['id' => $user->id, 'password' => $confirmation])) {
			$validator = $this->validate($request,
				[
					'displayname' => 'required|max:16',
					'password' => 'confirmed'
				]
			);

			if ($validator->fails())
				return redirect()->back()->withErrors($validator->errors());

			if ($request->has('password'))
				$user->password = $request->input('password');

			$displayname = $request->input('displayname');
			$user->displayname = $displayname;

			$user->save();
			Auth::logout();
			redirect('/');
		} else
			return redirect()->back()->withErrors(['Invalid confirmation password.']);
	}
}
