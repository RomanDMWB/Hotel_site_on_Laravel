<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $database;
    private $tablename;
    public function __construct(Database $database){
        $this->database = $database;
        $this->tablename = 'users';
    }

    public function login(LoginRequest $request){

    }

    public function register(RegisterRequest $request){
        // $this->database->getReference($this->tablename)->push([
        //     'name' => $request->name,
        //     'surname' => $request->surname,
        //     'email' => $request->mail,
        //     'login' => $request->login,
        //     'password' => $request->password,
        // ]);
        if (Auth::attempt(['email' => $request->mail, 'password' => $request->password])) {
            return redirect('/');
        }
    }
}
