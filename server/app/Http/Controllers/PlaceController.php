<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use App\Http\Requests\PlaceCreateRequest;

class PlaceController extends Controller
{
    private $tablename;
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'places';
    }

    public function show(){
        $places = $this->database->getReference($this->tablename)->getValue();
        return view('admin.place.index',compact('places'));
    }

    public function form(){
        $rooms = $this->database->getReference('rooms')->getValue();
        return view('admin.place.form',compact('rooms'));
    }

    public function add(PlaceCreateRequest $request){
        $error = $this->checkError($request);
        if($error)
            return back()->withErrors(['error'=> $error]);
        $room_type = $this->database->getReference('rooms')->getChild($request->room_type)->getValue();
        $createData = [
            'number' => $request->place_number,
            'isOccupied' => false,
            'type' => $room_type['name'],
        ];
        $addData = $this->database->getReference($this->tablename)->push($createData);
        $status = TableController::processDataAction('place','added',isset($addData));
        return redirect('admin/places')->with('status',$status);
    }

    public function update(PlaceCreateRequest $request,$id){
        $currentPlace = $this->database->getReference($this->tablename)->getChild($id)->getValue();
        $isUpdated = true;
        if($currentPlace['number']!=$request['number']){
            $bookings = $this->database->getReference('bookings')->getValue();
            foreach ($bookings as $key => $value) {
                if($value['place']==$currentPlace['number']){
                    $updatedResult = $this->database->getReference('bookings'.'/'.$key)->update(['place'=>$request['number']]);
                    $isUpdated = $isUpdated && isset($updatedResult);
                }
            }
            $updatedResult = $this->database->getReference($this->tablename.'/'.$id)->update(['number'=>$request['number']]);
            $isUpdated = $isUpdated && isset($updatedResult);
        }
        if($currentPlace['type']!=$request['type']){
            $bookings = $this->database->getReference('bookings')->getValue();
            foreach ($bookings as $key => $value) {
                if($value['type']==$currentPlace['type']){
                    $updatedResult = $this->database->getReference('bookings'.'/'.$key)->update(['type'=>$request['type']]);
                    $isUpdated = $isUpdated && isset($updatedResult);
                }
            }
            $updatedResult = $this->database->getReference($this->tablename.'/'.$id)->update(['type'=>$request['type']]);
            $isUpdated = $isUpdated && isset($updatedResult);
        }
        $status = TableController::processDataAction('place','updated',$isUpdated);
        return redirect('admin/places')->with('status',$status);
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
