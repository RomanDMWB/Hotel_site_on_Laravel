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
        $this->roomTablenName = 'rooms';
        $this->serviceTableName = 'services';
    }

    public function show(){
        $rooms = $this->database->getReference($this->roomTablenName)->getValue();
        return view('admin.room.index',compact('rooms'));
    }

    public function form($id=null){
        if($id){
            $room = $this->database->getReference($this->roomTablenName)->getChild($id)->getValue();
            return view('admin.room.form',compact('room','id'));
        }
        else
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
        $addData = $this->database->getReference($this->roomTablenName)->push($createData);
        if($addData)
        return redirect('admin/rooms')->with('status','Room Added Successfully');
        else
        return redirect('admin/rooms')->with('status','Room Not Added');
    }

    public function update(RoomCreateRequest $request,$id){
        $updateData = [
            'name' => $request->name,
            'cost' => $request->cost,
            'size' => $request->size,
            'description'=>$request->description,
            'image'=>$request->image
        ];
        $updateResult = $this->database->getReference($this->roomTablenName.'/'.$id)->update($updateData);
        if($updateResult)
        return redirect('admin/rooms')->with('status','Room Updated Successfully');
        else
        return redirect('admin/rooms')->with('status','Room Not Updated');
    }

    public function selectService($id){
        $services = $this->database->getReference($this->serviceTableName)->getValue();
        $room = $this->database->getReference($this->roomTablenName)->getChild($id)->getValue();
        return view('admin.room.add-service',compact('room','services','id'));
    }

    public function addService(Request $request,$id){
        $service = $this->database->getReference($this->serviceTableName)->getChild($request->serviceId)->getValue();
        $serviceData = [
            'icon' => $service['icon'],
            'name' => $service['name']
        ];
        $updateData = $this->database->getReference($this->roomTablenName.'/'.$id.'/services')->push($serviceData);
        if($updateData)
        return redirect('admin/rooms')->with('status','Service Added Successfully');
        else
        return redirect('admin/rooms')->with('status','Service Not Added');
    }

    public function getInfo($id){
        $room = $this->database->getReference($this->roomTablenName)->getChild($id)->getValue();
        if($room)
        return view('room',compact('room'));
        else
        return view('error');
    }
}
