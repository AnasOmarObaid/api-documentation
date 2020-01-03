<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BasicAuth
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
        //-- to make auth with register and control the curd with for example laratrust
        if (Auth::onceBasic()) {
            return response()->json(['data' => null, 'status' => false, 'msg' => 'Not Auth'], 401);
            // } else {
            //-- edit for example
            // if (auth()->user()->can('edit')) {
            //     //-- ok do work
            //     return $next($request);
            // } else {
            //     //-- the user cant control the curd
            //     return response()->json(['msg' => 'cant modify', 'status' => false], 422);
            // }
        }
        return $next($request);
    }
}
