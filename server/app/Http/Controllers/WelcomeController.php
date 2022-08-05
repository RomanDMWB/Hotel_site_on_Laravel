<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;

class WelcomeController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'rooms';
    }

    public function show(){
        $services = $this->database->getReference('services')->getValue();
        $rooms = $this->database->getReference($this->tablename)->getValue();
        return view('welcome.welcome',compact('rooms','services'));
    }
}
