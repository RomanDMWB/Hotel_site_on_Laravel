<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use App\Http\Requests\PlaceCreateRequest;

class PlaceController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'places';
    }

    public function show(){
        $places = $this->database->getReference($this->tablename)->getValue();
        return view('admin.place.index',compact('places'));
    }

    public function create(){
        $rooms = $this->database->getReference('rooms')->getValue();
        return view('admin.place.create',compact('rooms'));
    }

    public function add(PlaceCreateRequest $request){
        $error = $this->checkError($request);
        if($error)
            return response()->json($error,402);
        $is_occupied = !!$request->occupied;
        $room_type = $this->database->getReference('rooms')->getChild($request->room_type)->getValue();
        $createData = [
            'number' => $request->place_number,
            'isOccupied' => $is_occupied,
            'type' => $room_type['name'],
        ];
        $addData = $this->database->getReference($this->tablename)->push($createData);
        if($addData)
        return redirect('admin/place')->with('status','Place Added Successfully');
        else
        return redirect('admin/place')->with('status','Place Not Added');
    }

    private function checkError($request){
        $places = $this->database->getReference($this->tablename)->getValue();
        $is_unique = true;
        $is_type_exists = $this->database->getReference('rooms')->getSnapshot()->hasChild($request->room_type);
        if($places)
        foreach ($places as $key => $value) 
            if($value['number']==$request->place_number)
                $is_unique = false;
        if(!$is_unique)
            return [
                'place_number' => 'Number must be unique'
            ];
        if(!$is_type_exists)
            return [
                'room_type' => 'Room type must be exists'
            ];
    }
}
