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
        $this->bookings = $this->getCurrentUser($database);
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

        return back()->withErrors(['error'=>'У вас пока нет бронирований! Поэтому забронируйте номер']);
    }
    
    public function showBooking($id){
        $info = $this->getBookingInfo($id);
        if($info)
        return view('booking_welcome',$info);
            
        return back()->withErrors([
            'errors'=>'Sorry this booking does not be in database'
        ]);
    }
    
    public function form($id){
        $booking = TableController::getBookings($this->database,$id);
        $currentType = $booking['type'];
        $places = TableController::getPlaces($this->database);
        $currentPlaces = array();
        foreach ($places as $key => $value) {
            if($value['type']===$currentType)
                $currentPlaces[$key]=$value;
        }
        $places = $currentPlaces;
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
        if($currentBooking['place']!=$request->place){
            $places = TableController::getPlaces($this->database);
            foreach($places as $key=>$value){
                if($value['number']==$currentBooking['place'])
                    $updateResult = $updateResult && !!$this->database->getReference('places/'.$key)->update(['isOccupied'=>false]);
                if($value['number']==$request->place)
                    $updateResult = $updateResult && !!$this->database->getReference('places/'.$key)->update(['isOccupied'=>true]);
            }
        }

        $place = null;
        $type = null;
        foreach($this->database->getReference('places')->getValue() as $key=>$value)
            if($value['number'] == $request->place){
                $place = $key;
                $type = $value['type'];
                break 1;
            }
        
        if($type)
            $type = TableController::getRooms($this->database,$type);
        
        $updateResult = $updateResult && !!TableController::getBookings($this->database,$id,true)->update([
            'adults'=>$request->adults,
            'childs'=>$request->childs,
            'place'=>$place,
            'cost'=>$this->getCost($request,$type['cost']),
            'nights'=>$request->nights,
        ]);
        $status = TableController::processDataAction('booking','updated',isset($updateResult));
        return redirect('admin/bookings')->with('status',$status);
    }
    
    public function destroy($id){
        $places = TableController::getPlaces($this->database);
        $booking = TableController::getBookings($this->database,$id);
        foreach($places as $key=>$value){
            if($value['number']==$booking['place'])
                $this->database->getReference('places/'.$key)->update(['isOccupied'=>false]);
        }
        $removedData = TableController::getBookings($this->database,$id,true)->remove();
        $status = TableController::processDataAction('booking','removed',isset($removedData));
        return redirect('admin/bookings')->with('status',$status);
    }

    public function formType($type){
        $name = $this->database->getReference('rooms')->getChild($type)->getValue()['name'];
        return view('formType',compact('type','name'));
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

    private function getCurrentUser($database){
        if(empty($_COOKIE)||!array_key_exists('user',$_COOKIE))return false;
        $auth = app('firebase.auth');
        $cookie = $auth->verifySessionCookie($_COOKIE['user']);
        $uid = $cookie->claims()->get('sub');
        $email = $auth->getUser($uid)->email;
        $users = $database->getReference('users')->getValue();
        foreach ($users as $key => $user) {
            if($user['email']===$email){
                return $database->getReference('users/'.$key)->getChild('bookings');
            }
        }
        return false;
    }
}