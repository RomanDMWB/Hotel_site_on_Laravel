<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;

class WelcomeController extends Controller
{
    private $database;
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    
    public function show(){
        $services = $this->database->getReference('services')->getValue();
        $rooms = TableController::getRooms($this->database);
        return view('welcome.welcome',compact('rooms','services'));
    }
}
