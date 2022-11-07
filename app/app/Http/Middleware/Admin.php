<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    private $uid,$auth;
    
    public function getAdmin(){
        if(array_key_exists('user',$_COOKIE)){
            $auth = app('firebase.auth');
            $verifiedSessionCookie = $auth->verifySessionCookie($_COOKIE['user']);
            $uid = $verifiedSessionCookie->claims()->get('sub');
            $admin = $auth->getUser($uid);
            if($admin->email == 'admin@mail.com' && !array_key_exists('admin',$admin->customClaims)){
                $auth->setCustomUserClaims($uid,['admin'=>true]);
            }
            if(array_key_exists('admin',$admin->customClaims)&&$admin->customClaims['admin']){
                return $admin;
            }
        }
        return false;
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
            $verifiedSessionCookie = $auth->verifySessionCookie($_COOKIE['user']);
            $uid = $verifiedSessionCookie->claims()->get('sub');
            $admin = $auth->getUser($uid);
            if(array_key_exists('admin',$admin->customClaims)&&!empty($admin->customClaims)&&$admin->customClaims['admin'])
                return $next($request);
        }
        return redirect()->route('welcome-error');
    }
}