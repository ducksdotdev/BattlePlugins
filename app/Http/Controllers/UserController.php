<?php

namespace App\Http\Controllers;

use App\Tools\Models\User;
use App\Tools\Queries\CreateAlert;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    private $request;

    function __construct(Request $request) {

        $this->request = $request;
    }

    public function login() {
        $email = $this->request->input('email');
        $password = $this->request->input('password');
        $rememberMe = $this->request->input('rememberMe');

        if (Auth::attempt(['email' => $email, 'password' => $password], $rememberMe))
            return redirect('/');
        else
            return redirect('/')->with('error', 'There was an error logging you in. Please make sure your email is correct (and is an @battleplugins.com email). Also, remember that your password is case sensitive.');
    }

    public function logout() {
        Auth::logout();
        return redirect()->back();
    }

    public function changeSettings() {
        $user = Auth::user();
        $confirmation = $this->request->input('confirmation');

        if (Auth::validate(['id' => $user->id, 'password' => $confirmation])) {
            $validator = $this->validate($this->request,
                [
                    'displayname' => 'required|max:16',
                    'password'    => 'confirmed'
                ]
            );

            if ($validator && $validator->fails())
                return $this->redirectBackWithErrors($validator->errors());

            if ($this->request->has('password'))
                $user->password = Hash::make($this->request->input('password'));

            $displayname = $this->request->input('displayname');
            $user->displayname = $displayname;

            $user->save();
            return self::logout();
        } else
            return $this->redirectBackWithErrors(['Invalid confirmation password.']);
    }

    public function createUser() {
        if (Auth::user()->admin) {
            $password = $this->request->input('password');
            $email = $this->request->input('email');
            $displayname = $this->request->input('displayname');

            if (User::whereEmail($email)->first())
                return $this->redirectBackWithErrors('That email is already registered to a user.');
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
                return $this->redirectBackWithErrors('You must enter a proper email.');

            $id = User::insertGetId([
                'email'       => $email,
                'password'    => Hash::make($password),
                'displayname' => $displayname,
                'admin'       => $this->request->input('isadmin')
            ]);

            $message = "Welcome, $displayname This is the BattlePlugins admin panel. This is a portal for checking server information and website management. This panel is also a hub for all of the BattlePlugins websites. If you have any questions please talk to lDucks.";
            CreateAlert::make($id, $message);

            Mail::send('emails.welcome', array(
                'password'    => $password,
                'displayname' => $this->request->input('displayname')
            ), function ($message) use ($email, $displayname) {
                $message->to($email, $displayname)->subject('BattleAdmin Registration Confirmation');
            });

            return $this->redirectBackWithSuccess('User successfully created.');
        }
    }

    public function toggleAdmin($user) {
        $user = User::find($user);
        if ($user->id != 1 && Auth::user()->admin) {
            $user->admin = !$user->admin;
            $user->save();
        }

        return redirect()->back();
    }

    public function deleteUser($user) {
        $user = User::find($user);
        if ($user->id != 1 && Auth::user()->admin)
            $user->delete();

        return redirect()->back();
    }
}
