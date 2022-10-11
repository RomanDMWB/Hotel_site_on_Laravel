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
        return view('welcome.index',compact('rooms','services'));
    }
    
    public function showWithError(){
        $services = $this->database->getReference('services')->getValue();
        $rooms = TableController::getRooms($this->database);
        $error = 'С начала необходимо войти в систему';
        return view('welcome.index',compact('rooms','services','error'));
    }
}