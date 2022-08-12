<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use App\Http\Requests\RoomCreateRequest;

class RoomController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->roomtablename = 'rooms';
        $this->servicetablename = 'services';
    }

    public function show(){
        $rooms = $this->database->getReference($this->roomtablename)->getValue();
        return view('admin.room.index',compact('rooms'));
    }

    public function form(){
        return view('admin.room.form');
    }

    public function add(RoomCreateRequest $request){
        $createData = [
            'name' => $request->name,
            'cost' => $request->cost,
            'size' => $request->size,
            'description'=>$request->description,
            'image'=>$request->image,
            'services'=>""
        ];
        $addData = $this->database->getReference($this->roomtablename)->push($createData);
        if($addData)
        return redirect('admin/room')->with('status','Room Added Successfully');
        else
        return redirect('admin/room')->with('status','Room Not Added');
    }

    public function selectService($id){
        $services = $this->database->getReference($this->servicetablename)->getValue();
        $room = $this->database->getReference($this->roomtablename)->getChild($id)->getValue();
        return view('admin.room.add-service',compact('room','services','id'));
    }

    public function addService(Request $request,$id){
        $service = $this->database->getReference($this->servicetablename)->getChild($request->serviceId)->getValue();
        $serviceData = [
            'icon' => $service['icon'],
            'name' => $service['name']
        ];
        $updateData = $this->database->getReference($this->roomtablename.'/'.$id.'/services')->push($serviceData);
        if($updateData)
        return redirect('admin/rooms')->with('status','Service Added Successfully');
        else
        return redirect('admin/rooms')->with('status','Service Not Added');
    }
}
