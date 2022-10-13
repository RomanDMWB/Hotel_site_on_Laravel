<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class Admin
{

    public static function isAdmin(){
        if(!array_key_exists('user',$_COOKIE))
            return false;
        $auth = app('firebase.auth');
        $verifiedSessionCookie = $auth->verifySessionCookie($_COOKIE['user']);
        $uid = $verifiedSessionCookie->claims()->get('sub');
        $claims = $auth->getUser($uid)->customClaims;
        if(!array_key_exists('admin',$claims)||empty($claims))
            return false;
        return true;
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
        $verifiedSessionCookie = $auth->verifySessionCookie($_COOKIE['user']);
        $uid = $verifiedSessionCookie->claims()->get('sub');
        $claims = $auth->getUser($uid)->customClaims;
        if(!array_key_exists('admin',$claims)||empty($claims))
        return redirect()->route('welcome-error');
        if($claims['admin'])
            return $next($request);
        return redirect()->route('welcome-error');
    }
}