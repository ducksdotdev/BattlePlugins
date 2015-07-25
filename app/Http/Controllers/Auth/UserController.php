<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Tools\API\GenerateApiKey;
use App\Tools\Misc\UserSettings;
use App\Tools\Queries\CreateAlert;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller {

    use ThrottlesLogins;

    private $request;

    function __construct(Request $request) {
        $this->request = $request;
    }

    public function getLogin() {
        return view('auth.login');
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
                UserSettings::modify($user, 'password', $this->request->input('password'));

            if ($this->request->has('displayname'))
                UserSettings::modify($user, 'displayname', $this->request->input('displayname'));

            auth()->logout();
            return redirect()->back();
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
                'admin'       => $this->request->has('isadmin'),
                'api_key'     => GenerateApiKey::generateKey()
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
        if ($user->id != 1 && Auth::user()->admin)
            UserSettings::modify($user, 'admin', !$user->admin);

        return redirect()->back();
    }

    public function deleteUser($user) {
        if ($user->id != 1 && Auth::user()->admin)
            UserSettings::delete($user);
        
        return redirect()->back();
    }
}
