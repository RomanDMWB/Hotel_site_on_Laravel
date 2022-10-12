<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Request\CreateUser;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Auth as LaravelAuth;
use Kreait\Firebase\Exception\InvalidArgumentException; 
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use Kreait\Firebase\Auth\CreateSessionCookie\FailedToCreateSessionCookie;

class AuthController extends Controller
{
    private $auth;
    private $database;
    public function __construct(Auth $auth,Database $database)
    {
        $this->auth = $auth;
        $this->database = $database;
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $request){
        try{
            $signResult = $this->auth->signInWithEmailAndPassword($request->email,$request->password);
        }
        catch(FailedToSignIn $e){
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
        catch(InvalidArgumentException $e){
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
        $oneWeek = new \DateInterval('P7D');

        try {
            $sessionCookieString = $this->auth->createSessionCookie($signResult->idToken(), $oneWeek);
            setcookie('user',$sessionCookieString);
        } catch (FailedToCreateSessionCookie $e) {
            echo $e->getMessage();
        }
        return redirect('/');
    }

    public function logup(RegisterRequest $request){
        $newUser = CreateUser::new()
            ->withUnverifiedEmail($request->email)
            ->withClearTextPassword($request->password)
            ->withDisplayName($request->name.' '.$request->surname);
        try {
            $result = $this->auth->createUser($newUser);
        } catch (\Throwable $e) {
            return back()->withErrors(['errors'=>$e->getMessage()]);
        }
        return redirect('/');
    }

    public function logout(){
        setcookie('user','');
        return redirect('/');
    }
}