<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;

class AdminController extends Controller
{
    public function __construct(Database $database){
        $this->database = $database;
    }

    public function show(){
        $tables = $this->database->getReference()->getValue();
        return view('admin.index',compact('tables'));
    }
}
