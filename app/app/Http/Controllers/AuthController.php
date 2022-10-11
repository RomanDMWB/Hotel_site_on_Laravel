<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Request\CreateUser;
use Kreait\Firebase\Auth\CreateSessionCookie\FailedToCreateSessionCookie;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use Kreait\Firebase\Contract\Database;

class AuthController extends Controller
{
    private $auth;
    private $database;
    public function __construct(Auth $auth,Database $database)
    {
        $this->auth = $auth;
        $this->database = $database;
    }

    public function login(LoginRequest $request){
        try{
            $signResult = $this->auth->signInWithEmailAndPassword($request->email,$request->password);
            try {
                $oneWeek = new \DateInterval('P7D');
                $sessionCookieString = $this->auth->createSessionCookie($signResult->idToken(), $oneWeek);
                setcookie('user',$sessionCookieString);
                return redirect('/');
            } catch (FailedToCreateSessionCookie $e) {
                return back()->withErrors(['error'=>$e->getMessage()]);
            }
        }
        catch (FailedToSignIn $e){
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
        catch (Kreait\Firebase\Exception\InvalidArgumentException $e){
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
        // try {
        //     $verifiedSessionCookie = $this->auth->verifySessionCookie($sessionCookieString);
        // } catch (FailedToVerifySessionCookie $e) {
        //     echo 'The Session Cookie is invalid: '.$e->getMessage();
        // }
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
        $this->database->getReference("users")->push([
            'email' => $request->email,
            'bookings' => ""
        ]);
    
        return redirect('/');
    }

    public function logout(){
        setcookie('user');
        return redirect('/');
    }
}