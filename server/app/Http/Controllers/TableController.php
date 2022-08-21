<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableController extends Controller
{
    static public function processDataAction(string $tablename,string $actionName,bool $success=false){
        if($success)
        return ucfirst($tablename).' '.ucfirst($actionName).' Successfully';
        else
        return ucfirst($tablename).' Not '.ucfirst($actionName);
    }

    static private function getRoomByCode($database,$value){
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

    static private function getPlaceByCode($database,$value){
        return [
            'isOccupied' => $value['isOccupied'],
            'number' => $value['number'],
            'type' => $database->getReference('rooms')->getChild($value['type'])->getValue()['name']
        ];
    }

    static public function getRooms($database,string $id=null){
        $rooms = array();
        if($id)
            return TableController::getRoomByCode($database,$database->getReference('rooms')->getChild($id)->getValue());

        foreach($database->getReference('rooms')->getValue() as $key => $value)
            $rooms[$key] = TableController::getRoomByCode($database,$value);

        return $rooms;
    }

    static public function getPlaces($database,string $id=null){
        $places = array();
        if($id)
            return TableController::getPlaceByCode($database,$database->getReference('places')->getChild($id)->getValue());

        foreach($database->getReference('places')->getValue() as $key=>$value)
            $places[$key]=TableController::getPlaceByCode($database,$value);
        
        return $places;
    } 
}