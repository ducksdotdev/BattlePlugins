<?php

namespace App\Http\Middleware;

use App\Tools\Misc\UserSettings;
use Closure;

/**
 * Class ApiAuthenticate
 * @package App\Http\Middleware
 */
class AdminAuthenticate {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (auth()->guest())
            return redirect()->guest('/auth/login');

        if (!UserSettings::hasNode(auth()->user(), UserSettings::ADMIN_PANEL))
            abort(403);

        return $next($request);
    }

}
