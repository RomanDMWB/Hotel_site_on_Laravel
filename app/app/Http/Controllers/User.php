<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Symfony\Component\CssSelector\Node\FunctionNode;

class User extends Controller
{
    private $database;
    public function __construct(Database $database){
        $this->database = $database;
    }

    public function contacts(){
        $contacts = $this->database->getReference('contacts')->getValue();
        return view('all.contacts',compact('contacts'));
    }

    public static function getCurrentUser($database){
        $auth = app('firebase.auth');
        $cookie = $auth->verifySessionCookie($_COOKIE['user']);
        $uid = $cookie->claims()->get('sub');
        $email = $auth->getUser($uid)->email;
        $users = $database->getReference('users')->getValue();
        foreach ($users as $key => $user) {
            if($user['email']===$email){
                return $database->getReference('users/'.$key);
            }
        }
        return false;
    }
}