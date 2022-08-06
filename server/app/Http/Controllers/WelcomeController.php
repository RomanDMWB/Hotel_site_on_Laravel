<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;

class WelcomeController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function show(){
        $services = $this->database->getReference('services')->getValue();
        $rooms = $this->database->getReference('rooms')->getValue();
        $contacts = $this->database->getReference('contacts')->getValue();
        return view('welcome.welcome',compact('rooms','services','contacts'));
    }
}
