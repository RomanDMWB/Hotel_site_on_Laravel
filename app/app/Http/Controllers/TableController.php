<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;

class TableController extends Controller
{
    static public function processDataAction(string $tablename,string $actionName,bool $success=false){
        if($success)
        return ucfirst($tablename).' '.ucfirst($actionName).' Successfully';
        else
        return ucfirst($tablename).' Not '.ucfirst($actionName);
    }

    static public function getRooms(Database $database,string $id=null){
        $rooms = array();
        if($id)
            return TableController::getRoomByCode($database,$database->getReference('rooms')->getChild($id)->getValue());

        foreach($database->getReference('rooms')->getValue() as $key => $value)
            $rooms[$key] = TableController::getRoomByCode($database,$value);

        return $rooms;
    }

    static public function getPlaces(Database $database,string $id=null){
        $places = array();
        if($id)
            return TableController::getPlaceByCode($database,$database->getReference('places')->getChild($id)->getValue());

        foreach($database->getReference('places')->getValue() as $key=>$value)
            $places[$key]=TableController::getPlaceByCode($database,$value);
        
        return $places;
    } 

    static public function getBookings(Database $database,$id = null,bool $link = false){
        $users = $database->getReference('users')->getValue();
        if($id){
            foreach($users as $userKey=>$user){
                $bookings = $database->getReference('users/'.$userKey.'/bookings');
                if($bookings->getSnapshot()->hasChild($id)){
                    if($link)
                        return $bookings->getChild($id);
                    return TableController::getBookingByCode($database,$bookings->getChild($id)->getValue());
                }
            }
        }
        $bookings = array();
        foreach($users as $userKey=>$user)
            if(array_key_exists('bookings',$user))
                foreach($user['bookings'] as $key=>$value){
                    $customKey = substr($userKey,0,strlen($userKey)/2).substr($key,0,strlen($key)/2);
                    $bookings[$customKey]=TableController::getBookingByCode($database,$value,$user['email'],$key);
                }
        
        return $bookings;
    }

    static private function getRoomByCode(Database $database,$value){
        $services = array();
        if($value['services']){
            foreach ($value['services'] as $key => $service) {
                $serviceObject = $database->getReference('services')->getChild($service)->getValue();
                $services[$key] = [
                    'name' => $serviceObject['name'],
                    'icon' => $serviceObject['icon']
                ];
            }   
        }
        $room = [
            'name' => $value['name'],
            'cost' => $value['cost'],
            'description' => $value['description'],
            'image' => $value['image'],
            'size' => $value['size'],
            'services' => $services
        ];
        return $room;
    }

    static private function getPlaceByCode(Database $database,$value){
        return [
            'isOccupied' => $value['isOccupied'],
            'number' => $value['number'],
            'type' => TableController::getTypeByCode($database,$value['type'])['name']
        ];
    }

    static private function getBookingByCode(Database $database,$value,$email = null,$key = null){
        $place = $database->getReference('places')->getChild($value['place'])->getValue();
        $booking = [
            'adults' => $value['adults'],
            'childs' => $value['childs'],
            'nights' => $value['nights'],
            'date' => $value['date'],
            'cost' => $value['cost'],
            'place' => $place['number'],
            'type' => TableController::getTypeByCode($database,$place['type'])['name']
        ];
        
        if(isset($email))
            $booking['email'] = $email;
        if(isset($key))
            $booking['booking'] = $key;
        return $booking;
    }

    static public function getTypeByCode(Database $database,$value){
        return $database->getReference('rooms')->getChild($value)->getValue();
    }
}