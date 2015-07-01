<?php

namespace App\Http\Controllers;

use App\Services\Registrar;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

	public function login (Request $request) {
		$email = $request->email;
		$password = $request->password;
		$rememberMe = $request->rememberMe;

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
		$confirmation = $request->confirmation;

		if (Auth::validate(['id' => $user->id, 'password' => $confirmation])) {
			$validator = $this->validate($request,
				[
					'displayname' => 'required|max:16',
					'password' => 'confirmed'
				]
			);

			if ($validator && $validator->fails())
				return redirect()->back()->withErrors($validator->errors());

			if ($request->has('password'))
				$user->password = Hash::make($request->password);

			$displayname = $request->displayname;
			$user->displayname = $displayname;

			$user->save();
			return self::logout();
		} else
			return redirect()->back()->withErrors(['Invalid confirmation password.']);
	}

	public function createUser (Request $request) {
		if (Auth::user()->admin) {
			$password = $request->password;
			$registrar = new Registrar();

			$registrar->create([
				'email' => $request->email,
				'password' => $password,
				'displayname' => $request->displayname,
				'isadmin' => $request->isadmin
			]);

			Mail::send('emails.welcome', array(
				'password' => $password,
				'displayname' => $request->displayname
			), function ($message) use ($request) {
				$message->to($request->email, $request->displayname)->subject('BattleAdmin Registration Confirmation');
			});

			return redirect()->back()->with('success', 'User successfully created.');
		}
	}
}
