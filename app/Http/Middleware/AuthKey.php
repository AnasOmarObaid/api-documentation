<?php

namespace App\Http\Middleware;

use Closure;

class AuthKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('x-api-key');
        if ($token != 'abx12cr42ak42js21s@eka!kd*md@ma4kw#mw%58!sa') {
            return response()->json(['data' => null, 'status' => false, 'msg' => 'App Key Not Found'], 401);
        }
        return $next($request);
    }
}
