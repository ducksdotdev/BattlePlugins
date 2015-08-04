<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Auth
 */
class ProfileController extends Controller {

    /**
     * @param $user
     * @return \Illuminate\View\View|null
     */
    public function getProfile($user) {
        $user = User::whereDisplayname($user)->first();
        if (!$user) return null;

        return view('profiles.index', [
            'user' => $user
        ]);
    }

}