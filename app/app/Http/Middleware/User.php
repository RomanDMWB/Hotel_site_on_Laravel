<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class User
{
    public static function isUser(){
        if(!array_key_exists('user',$_COOKIE))
            return false;
        $auth = app('firebase.auth');
        return $auth->verifySessionCookie($_COOKIE['user']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!array_key_exists('user',$_COOKIE))
        return redirect()->route('welcome-error');
        $auth = app('firebase.auth');
        if($auth->verifySessionCookie($_COOKIE['user']))
        return $next($request);
        return redirect()->route('welcome-error');
    }
}