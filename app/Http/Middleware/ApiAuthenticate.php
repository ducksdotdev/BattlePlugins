<?php

namespace App\Http\Middleware;

use App\Tools\API\StatusCodes\StatusCode;
use Auth;
use Closure;
use Illuminate\Support\Facades\DB;

/**
 * Class ApiAuthenticate
 * @package App\Http\Middleware
 */
class ApiAuthenticate
{

    protected $statusCode;

    function __construct(StatusCode $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $key = $request->header('X-API-Key');
        if (!$key)
            $key = $request->input('_key');

        $result = DB::table('users')->where('api_key', $key)->first();
        if ($result) {
            Auth::loginUsingId($result->id);
            return $next($request);
        }

        return $this->statusCode->respondValidationFailed('Failed to validate API-Key.');
    }

}
