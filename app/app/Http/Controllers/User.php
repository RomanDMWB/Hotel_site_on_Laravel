<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Contract\Database;
use Throwable;

class User extends Controller
{
    private $database;
    public function __construct(Database $database,Auth $auth){
        $this->database = $database;
    }

    public function contacts(){
        $contacts = $this->database->getReference('contacts')->getValue();
        return view('all.contacts',compact('contacts'));
    }

    public function page(){
        $user = \App\Http\Middleware\User::getUser();
        return view('user.index',compact('user'));
    }

    public function save(Request $request){
        $user = \App\Http\Middleware\User::getUser();
        $auth = app('firebase.auth');
        dd($request);
        try{
            if($user->email != $request->email)
                $auth->changeUserEmail($user->uid,$request->email);
            if($user->displayName != $request->displayName){
                dd($user);
                // $updatedUser = $auth->updateUser($uid, ['displayName'=>$request->displayName]);
            }
            if($request->password)
                $auth->changeUserPassword($user->uid,$request->email);
        }
        catch(Throwable $e){
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
    }
}