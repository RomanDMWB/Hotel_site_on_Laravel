<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingCreateRequest;
use Kreait\Firebase\Contract\Database;

class BookingController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'bookings';
    }

    public function create(BookingCreateRequest $request){
        $is_type_exists = $this->database->getReference('rooms')->getSnapshot()->hasChild($request->room_type);
        if(!$is_type_exists)
            return back()->withErrors(['error'=>[
                'room_type' => 'Room Name must be exists in datebase'
            ]]);
        $room_type = $this->database->getReference('rooms')->getChild($request->room_type)->getValue();
        $room_type_name = $room_type['name'];
        $place_number = $this->boookingInTheRoom($room_type_name);
        if(!$place_number)
        return back()->withErrors(['error'=>[
            'place_number' => 'Sorry, places on this type room do not be in the datebase'
        ]]);
        $cost = $request->night_count*($request->adult_count+$request->child_count/2)*$room_type['cost'];
        $createdData = [
            'type' => $room_type_name,
            'place' => $place_number,
            'date' => $request->arrival_date,
            'adults' => $request->adult_count,
            'childs' => $request->child_count,
            'nights' => $request->night_count,
            'cost' => $cost
        ];
        $addData = $this->database->getReference($this->tablename)->push($createdData);
        if($addData->getKey())
        return redirect('booking/'.$addData->getKey());
        else 
        return redirect('/')->with('status','Sorry, booking not completed');
    }
    
    public function show($id){
        $booking = $this->database->getReference($this->tablename)->getChild($id)->getValue();
        if($booking)
        return view('booking_welcome',compact('booking','id'));
        else
        return back()->withErrors([
            'errors'=>'Sorry this booking does not be in database'
        ]);
    }

    private function boookingInTheRoom($room_type){
        $place_number = 0;
        $places = $this->database->getReference('places')->getValue();
        $place = "";
        foreach ($places as $key=>$value) {
            if($value['type']==$room_type&&!$value['isOccupied']){
                $place_number = $value['number'];
                $place = $key;
                break 1;
            }
        }
        if($place)
            $this->database->getReference('places/'.$place)->update(['isOccupied' => true]);
        return $place_number;
    }
}
