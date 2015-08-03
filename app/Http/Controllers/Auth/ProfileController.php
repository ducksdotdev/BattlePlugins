<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class ProfileController extends Controller {

    public function getProfile($user) {
        $user = User::whereDisplayname($user)->first();
        if (!$user) return null;

        return view('profiles.index', [
            'user' => $user
        ]);
    }

}