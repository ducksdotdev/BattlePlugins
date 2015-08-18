<?php

namespace App\Http\Middleware;

use App\API\StatusCodes\StatusCode;
use App\Models\User;
use App\Tools\UserSettings;
use Auth;
use Closure;

/**
 * Class ApiAuthenticate
 * @package App\Http\Middleware
 */
class ApiAuthenticate {

    protected $statusCode;

    function __construct(StatusCode $statusCode) {
        $this->statusCode = $statusCode;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $key = $request->header('X-API-Key');
        if (!$key)
            $key = $request->input('_key');

        $result = User::where('api_key', $key)->first();
        if ($result) {
            if (UserSettings::hasNode($result->id, UserSettings::USE_API)) {
                auth()->loginUsingId($result->id);
                return $next($request);
            }
        }

        return $this->statusCode->respondValidationFailed('Failed to validate API-Key.');
    }

}
