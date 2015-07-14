<?php

namespace App\Http\Middleware;

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
        if (auth()->guest() || !auth()->user()->admin)
            return redirect('/login');

        return $next($request);
    }

}
