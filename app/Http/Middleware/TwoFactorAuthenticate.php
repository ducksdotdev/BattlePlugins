<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class TwoFactorAuthenticate
 * @package App\Http\Middleware
 */
class TwoFactorAuthenticate {

    protected $except_urls = [
        'auth/google2fa'
    ];

    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle($request, Closure $next) {
        $regex = '#' . implode('|', $this->except_urls) . '#';

        if (!preg_match($regex, $request->path()) && auth()->check() && auth()->user()->google2fa_secret && !session('2fa_authed'))
            return redirect('/auth/google2fa');

        return $next($request);
    }

}