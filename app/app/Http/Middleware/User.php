<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CookieController;
use Closure;
use Illuminate\Http\Request;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $op = new CookieController();
        if($op->isUser()){
            return $next($request);
        }
        return redirect()->route('welcome-error');
    }
}