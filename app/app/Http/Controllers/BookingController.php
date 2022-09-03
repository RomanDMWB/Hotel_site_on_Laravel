<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingCreateRequest;
use Kreait\Firebase\Contract\Database;

class BookingController extends Controller
{
    private $database;
    private $tablename;
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'bookings';
    }

    public function create(BookingCreateRequest $request){
        $room = TableController::getRooms($this->database,$request->type);
        $room_name = $room['name'];
        $place_number = $this->boookingInThePlace($room_name);
        if(!$place_number)
            return back()->withErrors(['error'=>[
                'place_number' => 'Sorry, places on this type room do not be in the datebase'
            ]]);
        $createdData = [
            'type' => $room_name,
            'place' => $place_number,
            'date' => $request->date,
            'adults' => $request->adults,
            'childs' => $request->childs,
            'nights' => $request->nights,
            'cost' => $this->getCost($request,$room['cost'])
        ];
        $addData = $this->database->getReference($this->tablename)->push($createdData);
        if($addData->getKey())
            return redirect('booking/'.$addData->getKey());
        else 
            return redirect('/')->with('status','Sorry, booking not completed');
    }
    
    public function showBooking($id){
        $booking = TableController::getBookings($this->database,$id);
        if($booking)
            return view('booking_welcome',compact('booking','id'));
        else
            return back()->withErrors([
                'errors'=>'Sorry this booking does not be in database'
            ]);
    }
    
    public function form($id){
        $booking = TableController::getBookings($this->database,$id);
        $places = $this->getPlace($booking['type']);
        $types = TableController::getRooms($this->database);
        return view('admin.booking.form',compact('booking','id','places','types'));
    }

    public function show(){
        $bookings = TableController::getBookings($this->database);
        return view('admin.booking.index',compact('bookings'));
    }

    public function update(BookingCreateRequest $request,$id){
        $currentBooking = TableController::getBookings($this->database,$id);
        $updateResult = true;
        if($currentBooking['place']!=$request['place']){
            $places = TableController::getPlaces($this->database);
            foreach($places as $key=>$value){
                if($value['number']==$currentBooking['place'])
                    $updateResult = $updateResult && !!$this->database->getReference('places/'.$key)->update(['isOccupied'=>false]);
                if($value['number']==$request['place'])
                    $updateResult = $updateResult && !!$this->database->getReference('places/'.$key)->update(['isOccupied'=>true]);
            }
        }

        $place = null;
        foreach($this->database->getReference('places') as $key=>$value)
            if($value['number'] == $request->place){
                $place = $key;
                break 1;
            }

        $updateResult = $updateResult && !!$this->database->getReference($this->tablename.'/'.$id)->update([
            'adults'=>$request->adults,
            'childs'=>$request->childs,
            'place'=>$place,
            'cost'=>$this->getCost($request,$this->getTypeObject($request->type)['cost']),
            'nights'=>$request->nights,
        ]);
        $status = TableController::processDataAction('booking','updated',isset($updateResult));
        return redirect('admin/bookings')->with('status',$status);
    }
    
    public function getPLacesOfType($type){
        $places = $this->getPLace($type);
        return response()->json([
            'places' => $places
        ],200);
    }
    
    public function destroy($id){
        $places = TableController::getPlaces($this->database);
        $booking = $this->database->getReference($this->tablename)->getChild($id)->getValue();
        foreach($places as $key=>$value){
            if($value['number']==$booking['place'])
                $this->database->getReference('places/'.$key)->update(['isOccupied'=>false]);
        }
        $removedData = $this->database->getReference($this->tablename.'/'.$id)->remove();
        $status = TableController::processDataAction('booking','removed',isset($removedData));
        return redirect('admin/bookings')->with('status',$status);
    }
    
    private function getPlace($type){
        $places = TableController::getPlaces($this->database);
        $placesOfType = array();
        foreach($places as $item)
            if($item['type']===$type)
                $placesOfType[]=$item;
        return $placesOfType;
    }

    private function getCost($request,$cost){
        return $request->nights*($request->adults+$request->childs/2)*$cost;
    }

    private function boookingInThePlace($room){
        $places = TableController::getPlaces($this->database);
        $place = "";
        foreach ($places as $key=>$value) {
            if($value['type']==$room&&!$value['isOccupied']){
                $place = $key;
                break 1;
            }
        }
        if($place)
            $this->database->getReference('places/'.$place)->update(['isOccupied' => true]);
        return $place;
    }

    private function getTypeObject($typename){
        $types = TableController::getRooms($this->database);
        $type = null;
        foreach ($types as $value) 
            if($value['name']===$typename)
                $type = $value;
        return $type;
    }
}
