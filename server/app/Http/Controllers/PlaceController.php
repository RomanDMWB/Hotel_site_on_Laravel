<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use App\Http\Requests\PlaceCreateRequest;

class PlaceController extends Controller
{
    private $tablename;
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'places';
    }

    public function show(){
        $places = TableController::getPlaces($this->database);
        return view('admin.place.index',compact('places'));
    }

    public function form($id=null){
        $rooms = TableController::getRooms($this->database);
        if($id){
            $place = TableController::getPlaces($this->database,$id);
            return view('admin.place.form',compact('rooms','place','id'));
        }
        else{
            return view('admin.place.form',compact('rooms'));
        }
    }

    public function add(PlaceCreateRequest $request){
        $createData = [
            'number' => $request->number,
            'isOccupied' => false,
            'type' => $request->type,
        ];
        $addResult = $this->database->getReference($this->tablename)->push($createData);
        $status = TableController::processDataAction('place','added',isset($addResult));
        return redirect('admin/places')->with('status',$status);
    }

    public function update(PlaceCreateRequest $request,$id){
        $updateResult = $this->database->getReference($this->tablename.'/'.$id)->update([
            'number' => $request['number'],
            'type' => $request['type']
        ]);
        $status = TableController::processDataAction('place','updated',isset($updateResult));
        return redirect('admin/places')->with('status',$status);
    }

    public function destroy($id){
        $removeResult = $this->database->getReference($this->tablename.'/'.$id)->remove();
        return redirect('admin/places')->with('status',TableController::processDataAction('place','removed',isset($removeResult)));
    }
}
