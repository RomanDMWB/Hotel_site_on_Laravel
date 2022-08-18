<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableController extends Controller
{
    static public function processDataAction(string $tablename,string $actionName,bool $success=false){
        if($success)
        return ucfirst($tablename).' '.ucfirst($actionName).' Successfully';
        else
        return ucfirst($tablename).' Not '.ucfirst($actionName);
    }
}
