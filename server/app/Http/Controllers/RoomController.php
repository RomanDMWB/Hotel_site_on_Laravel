<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use App\Http\Requests\RoomCreateRequest;

class RoomController extends Controller
{
    private $database;
    private $roomTableName;
    private $serviceTableName;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->roomTableName = 'rooms';
        $this->serviceTableName = 'services';
    }

    public function show(){
        $rooms = TableController::getRooms($this->database);
        return view('admin.room.index',compact('rooms'));
    }

    public function form($id=null){
        if($id){
            $room = TableController::getRooms($this->database,$id);
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
        $addData = $this->database->getReference($this->roomTableName)->push($createData);
        return redirect('admin/rooms')->with('status',TableController::processDataAction('room','added',isset($addData)));

    }

    public function update(RoomCreateRequest $request,$id){
        $updateData = [
            'name' => $request->name,
            'cost' => $request->cost,
            'size' => $request->size,
            'description'=>$request->description,
            'image'=>$request->image
        ];
        $updateResult = $this->database->getReference($this->roomTableName.'/'.$id)->update($updateData);
        return redirect('admin/rooms')->with('status',TableController::processDataAction('room','updated',isset($updateResult)));
    }

    public function selectService($id){
        $services = $this->database->getReference($this->serviceTableName)->getValue();
        $room = TableController::getRooms($this->database,$id);
        return view('admin.room.add-service',compact('room','services','id'));
    }

    public function addService(Request $request,$id){
        $updateData = $this->database->getReference($this->roomTableName.'/'.$id.'/services')->push($request->serviceId);
        $status = TableController::processDataAction('service','added',isset($updateData));
        return redirect('admin/rooms')->with('status',$status);
    }

    public function getInfo($id){
        $room = TableController::getRooms($this->database,$id);
        if($room)
        return view('room',compact('room'));
        else
        return view('error');
    }


    public function destroy($id){
        $deleteResult = $this->database->getReference($this->roomTableName.'/'.$id)->remove();
        $places = $this->database->getReference('places')->getValue();
        $bookings = $this->database->getReference('bookings')->getValue();
        foreach($places as $key=>$value)
            if($value['type']==$id)
                $this->database->getReference('places/'.$key)->remove();
            
        foreach($bookings as $key=>$value)
            if($value['type']==$id)
                $this->database->getReference('places/'.$key)->remove();

        return redirect('admin/rooms')->with('status',TableController::processDataAction('room','removed',isset($deleteResult)));
    }
}
