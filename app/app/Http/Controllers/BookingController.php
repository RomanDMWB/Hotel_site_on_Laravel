<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingCreateRequest;
use Kreait\Firebase\Contract\Database;

class BookingController extends Controller
{
    private $database;
    private $bookings;
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->bookings = User::getCurrentUser($database)->getChild('bookings');
    }

    public function create(BookingCreateRequest $request){
        $room = TableController::getRooms($this->database,$request->type);
        $place_number = $this->boookingInThePlace($room['name']);
        if(!$place_number)
            return back()->withErrors(['error'=>[
                'place_number' => 'Sorry, places on this type room do not be in the datebase'
            ]]);
        $createdData = [
            'type' => $request->type,
            'place' => $place_number,
            'date' => $request->date,
            'adults' => $request->adults,
            'childs' => $request->childs,
            'nights' => $request->nights,
            'cost' => $this->getCost($request,$room['cost'])
        ];
        $addData = $this->bookings->push($createdData);
        if($addData->getKey())
            return redirect('booking/'.$addData->getKey());
        else 
            return redirect('/')->with('status','Sorry, booking not completed');
    }
    
    public function getBookingInfo($id,$isFull = false){
        if($isFull){
            $infoArray = array();
            foreach ($this->bookings->getValue() as $key => $booking) {
                $info = array();
                $info['type'] = TableController::getTypeByCode($this->database,$booking['type'])['name'];
                $info['place'] = TableController::getPlaces($this->database,$booking['place'])['number'];
                $info['date'] = $booking['date'];
                $info['nights'] = $booking['nights'];
                $info['adults'] = $booking['adults'];
                $info['childs'] = $booking['childs'];
                $info['cost'] = $booking['cost'];
                $info['id'] = $id;
                $infoArray[$key] = $info;
            }
            return $infoArray;
        }

        foreach ($this->bookings->getValue() as $key => $booking) 
            if($id === $key)
            {
                $info = array();
                $info['type'] = TableController::getTypeByCode($this->database,$booking['type'])['name'];
                $info['place'] = TableController::getPlaces($this->database,$booking['place'])['number'];
                $info['booking'] = $booking;
                $info['id'] = $id;
                return $info;
            }
        return false;
    }
        
    public function bookings(){
        if($this->bookings)
            return view('user.bookings',['bookings'=>$this->getBookingInfo(null,true)]);

        return view('welcome.index')->withErrors(['error'=>'У вас пока нет бронирований! Поэтому забронируйте номер']);
    }
    
    public function showBooking($id){
        $info = $this->getBookingInfo($id);
        if($info)
        return view('booking_welcome',$info);
            
        return back()->withErrors([
            'errors'=>'Sorry this booking does not be in database'
        ]);
    }
    
    // public function form($id){
    //     // TODO full
    //     $places = $this->getPlace($booking['type']);
    //     $types = TableController::getRooms($this->database);
    //     return view('admin.booking.form',compact('booking','id','places','types'));
    // }

    public function show(){
        $bookings = TableController::getBookings($this->database);
        return view('admin.booking.index',compact('bookings'));
    }

    // public function update(BookingCreateRequest $request,$id){
    //     //todo full
    //     $updateResult = true;
    //     if($currentBooking['place']!=$request['place']){
    //         $places = TableController::getPlaces($this->database);
    //         foreach($places as $key=>$value){
    //             if($value['number']==$currentBooking['place'])
    //                 $updateResult = $updateResult && !!$this->database->getReference('places/'.$key)->update(['isOccupied'=>false]);
    //             if($value['number']==$request['place'])
    //                 $updateResult = $updateResult && !!$this->database->getReference('places/'.$key)->update(['isOccupied'=>true]);
    //         }
    //     }

    //     $place = null;
    //     foreach($this->database->getReference('places') as $key=>$value)
    //         if($value['number'] == $request->place){
    //             $place = $key;
    //             break 1;
    //         }

    //     $updateResult = $updateResult && !!$this->database->getReference($this->tablename.'/'.$id)->update([
    //         'adults'=>$request->adults,
    //         'childs'=>$request->childs,
    //         'place'=>$place,
    //         'cost'=>$this->getCost($request,$this->getTypeObject($request->type)['cost']),
    //         'nights'=>$request->nights,
    //     ]);
    //     $status = TableController::processDataAction('booking','updated',isset($updateResult));
    //     return redirect('admin/bookings')->with('status',$status);
    // }
    
    public function getPLacesOfType($type){
        $places = array();
        foreach(TableController::getPlaces($this->database) as $item)
            if($item['type']===$type)
                $places[]=$item;
        return response()->json([
            'places' => $places
        ],200);
    }
    
    // public function destroy($id){
    //     $places = TableController::getPlaces($this->database);
    //     // todo full
    //     foreach($places as $key=>$value){
    //         if($value['number']==$booking['place'])
    //             $this->database->getReference('places/'.$key)->update(['isOccupied'=>false]);
    //     }
    //     $removedData = $this->bookings->getChild->remove();
    //     $status = TableController::processDataAction('booking','removed',isset($removedData));
    //     return redirect('admin/bookings')->with('status',$status);
    // }

    public function formType($type){
        return view('formType',compact('type'));
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
}