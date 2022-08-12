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
        $place_number = $this->boookingInThePlace($room_type_name);
        if(!$place_number)
            return back()->withErrors(['error'=>[
                'place_number' => 'Sorry, places on this type room do not be in the datebase'
            ]]);
        $createdData = [
            'type' => $room_type_name,
            'place' => $place_number,
            'date' => $request->date,
            'adults' => $request->adults,
            'childs' => $request->childs,
            'nights' => $request->nights,
            'cost' => $this->getCost($request,$room_type['cost'])
        ];
        $addData = $this->database->getReference($this->tablename)->push($createdData);
        if($addData->getKey())
            return redirect('booking/'.$addData->getKey());
        else 
            return redirect('/')->with('status','Sorry, booking not completed');
    }

    private function getCost($request,$cost){
        return $request->night_count*($request->adult_count+$request->child_count/2)*$cost;
    }
    
    public function showBooking($id){
        $booking = $this->database->getReference($this->tablename)->getChild($id)->getValue();
        if($booking)
            return view('booking_welcome',compact('booking','id'));
        else
            return back()->withErrors([
                'errors'=>'Sorry this booking does not be in database'
            ]);
    }

    private function boookingInThePlace($room_type){
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

    public function form($id){
        $booking = $this->database->getReference($this->tablename)->getChild($id)->getValue();
        $placesNumber = array();
        $places = $this->database->getReference('places')->getValue();
        foreach ($places as $key => $value) {
            if($value['type']===$booking['type'])
                $placesNumber[] = $value['number'];
        }
        dd($placesNumber);
        return view('admin.booking.form',compact('booking','id'));
    }

    public function show(){
        $bookings = $this->database->getReference($this->tablename)->getValue();
        return view('admin.booking.index',compact('bookings'));
    }

    private function getTypeObject($typename){
        $types = $this->database->getReference('rooms')->getValue();
        $type = null;
        foreach ($types as $value) 
            if($value['name']===$typename)
                $type = $value['cost'];
        return $type;
    }

    public function update(BookingCreateRequest $request,$id){
        $updateResult = $this->database->getReference($this->tablename.'/'.$id)->update([
            'adults'=>$request->adults,
            'childs'=>$request->childs,
            'place'=>$request->place,
            'cost'=>$this->getCost($request,$this->getTypeObject($request->type)['cost']),
            'type'=>$request->type,
            'nights'=>$request->nights,
        ]);
        if($updateResult)
        return redirect('admin/bookings')->with('status','Booking Updated Successfully');
        else
        return redirect('admin/bookings')->with('status','Booking Not Updated');
    }
}
