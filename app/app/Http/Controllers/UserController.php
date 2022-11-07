<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Throwable;

class UserController extends Controller
{
    private $database;
    public function __construct(Database $database){
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
        try{
            if($user->email != $request->email)
                $auth->changeUserEmail($user->uid,$request->email);
            if($user->displayName != $request->displayName){
                $updatedUser = $auth->updateUser($user->uid, ['displayName'=>$request->displayName]);
            }
            if($request->password)
                $auth->changeUserPassword($user->uid,$request->email);
        }
        catch(Throwable $e){
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
        return view('user.index')->with(['status'=>'Операция по изменению данных прошла успешно','user'=>\App\Http\Middleware\User::getUser()]);
    }

    public function list(){
        $auth = app('firebase.auth');
        $list = $auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        $users = array();
        foreach ($list as $key => $value) {
            $users[] = $value;
        }
        return view('user.list',compact('users'));
    }

    public function delete($id){
        $auth = app('firebase.auth');
        $removedResult = $auth->deleteUser($id);
        return view('user.list')->with('status',TableController::processDataAction('user','removed',isset($removedResult)));
    }
}