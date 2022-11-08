<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use DateInterval;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Request\CreateUser;
use Kreait\Firebase\Contract\Database;
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
            $sessionCookie = $this->auth->createSessionCookie($signResult->idToken(),new DateInterval('P1W'));
            setcookie('user',$sessionCookie);
            return redirect('/');
        }
        catch(FailedToSignIn $e){
            return back()->withErrors(['error'=>"Ошибка при входе в систему"]);
        }
        catch(InvalidArgumentException $e){
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
        catch (FailedToCreateSessionCookie $e) {
            return back()->withErrors(['error'=>"Ошибка при создании cookie"]);
        }
    }

    public function logup(RegisterRequest $request){
        $newUser = CreateUser::new()
            ->withUnverifiedEmail($request->email)
            ->withClearTextPassword($request->password)
            ->withDisplayName($request->name.' '.$request->surname);
        try {
            $result = $this->auth->createUser($newUser);
            $this->database->getReference('users')->push([
                'email' => $request->email,
                'bookings' => "",
            ]);
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