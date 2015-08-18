<?php

namespace App\Http\Middleware;

use App\Tools\UserSettings;
use Closure;

/**
 * Class TwoFactorAuthenticate
 * @package App\Http\Middleware
 */
class TwoFactorAuthenticate {

    protected $except_urls = [
        'auth/google2fa',
        'user/settings/google2fa'
    ];

    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle($request, Closure $next) {
        $regex = '#' . implode('|', $this->except_urls) . '#';

        if (!preg_match($regex, $request->path())) {
            if (auth()->check() && auth()->user()->google2fa_secret && !session('2fa_authed') && !$request->has('_key'))
                return redirect('/auth/google2fa');
            else if (UserSettings::hasNode(auth()->user(), UserSettings::FORCE_2FA) && !auth()->user()->google2fa_secret)
                return redirect('/user/settings/google2fa');
        }

        return $next($request);
    }

}