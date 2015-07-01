<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        $rememberMe = $request->input('rememberMe');

        if (Auth::attempt(['email' => $email, 'password' => $password], $rememberMe)) {
            return redirect('/');
        } else {
            return redirect('/')->with('error', 'There was an error logging you in. Please make sure your email is correct (and is an @battleplugins.com email). Also, remember that your password is case sensitive.');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->back();
    }

    public function changeSettings(Request $request) {
        $user = Auth::user();
        $password = $request->input('password');

        if (Auth::validate(['id' => $user->id, 'password' => $password])) {
            if ($request->has('newpassword') && $request->has('newpassword2')) {
                $newpassword = $request->input('newpassword');
                $newpassword2 = $request->input('newpassword2');
                if ($newpassword == $newpassword2)
                    $user->password = Hash::make($newpassword);
                else
                    return redirect()->back()->withErrors(['Your passwords do not match']);

                $displayname = $request->input('displayname');
                $validator = Validator::make(
                    array('displayname' => $displayname),
                    array('displayname' => 'required|max:16')
                );

                if ($validator->fails())
                    return redirect()->back()->withErrors($validator->errors());

                $user->displayname = $displayname;
            }

            $user->save();
            Auth::logout();
            redirect('/');
        } else
            return redirect()->back()->withErrors(['Invalid password.']);
    }
}
