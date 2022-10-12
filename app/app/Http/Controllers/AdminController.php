<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Kreait\Firebase\Contract\Database;

class AdminController extends Controller
{
    private $database;
    
    public function __construct(Database $database){
        $this->database = $database;
    }

    public function show(){
        $tables = $this->database->getReference()->getValue();
        return view('admin.index',compact('tables'));
    }
}