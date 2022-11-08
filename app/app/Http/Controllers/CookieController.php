<?php

namespace App\Http\Controllers;
use Kreait\Firebase\Exception\Auth\FailedToVerifySessionCookie;

class CookieController extends Controller
{
    private $user,$auth,$uid;
    public function __construct()
    {
        if(!array_key_exists('user',$_COOKIE))
            $this->user = false;
        else{
            $this->auth = app('firebase.auth');
            try{
                $this->uid = $this->auth->verifySessionCookie($_COOKIE['user'])->claims()->get('sub');
                $this->user = $this->auth->getUser($this->uid);
            }
            catch(FailedToVerifySessionCookie $e){
                $this->user = $_COOKIE['user'];
            }
        }

    }

    public function isAdmin()
    {
        if(!$this->user || gettype($this->user) === 'string'){
            return false;
        }
        if($this->user->email == 'admin@mail.com' && !array_key_exists('admin',$this->user->customClaims)){
            $this->auth->setCustomUserClaims($this->uid,['admin'=>true]);
        }
        if(array_key_exists('admin',$this->user->customClaims)&&$this->user->customClaims['admin']){
            return $this->user;
        }
        return false;
    }

    public function isUser()
    {
        return $this->user;
    }
}