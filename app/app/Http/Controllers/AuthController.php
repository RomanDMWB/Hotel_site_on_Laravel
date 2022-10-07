<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Auth;

class AuthController extends Controller
{
    private $auth;
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function login(LoginRequest $request){
        
    }

    public function logup(RegisterRequest $request){
    }
}