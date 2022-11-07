<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class User
{
    public static function getUser(){
        if(!array_key_exists('user',$_COOKIE))
            return false;
        $auth = app('firebase.auth');
        $uid = $auth->verifySessionCookie($_COOKIE['user'])->claims()->get('sub');
        return $auth->getUser($uid);
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

        if(array_key_exists('user',$_COOKIE)){
            $auth = app('firebase.auth');
            if($auth->verifySessionCookie($_COOKIE['user']))
            return $next($request);
        }
        return redirect()->route('welcome-error');
    }
}