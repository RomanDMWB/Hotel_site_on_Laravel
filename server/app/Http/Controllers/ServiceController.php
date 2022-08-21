<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use App\Http\Requests\ServiceCreateRequest;

class ServiceController extends Controller
{
    private $database;
    private $tablename;
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'services';
    }

    public function show(){
        $services = $this->database->getReference($this->tablename)->getValue();
        return view('admin.service.index',compact('services'));
    }

    public function form($id=null){
        if($id){
            $service = $this->database->getReference($this->tablename)->getChild($id)->getValue();
            return view('admin.service.form',compact('service','id'));
        }
        else
        return view('admin.service.form');
    }

    public function add(ServiceCreateRequest $request){
        $createData = [
            'name' => $request->name,
            'icon' => $request->icon,
        ];
        $addResult = $this->database->getReference($this->tablename)->push($createData);
        return redirect('admin/services')->with('status',TableController::processDataAction('service','added',isset($addResult)));
    }
    
    public function update(ServiceCreateRequest $request,$id){
        $updateResult = $this->database->getReference($this->tablename.'/'.$id)->update([
            'name' => $request->name,
            'icon' => $request->icon,
        ]);
        return redirect('admin/services')->with('status',TableController::processDataAction('service','updated',isset($updateResult)));
    }
    
    public function destroy($id){
        $rooms = $this->database->getReference($this->tablename)->getValue();
        $removedResult = $this->database->getReference($this->tablename.'/'.$id)->remove();
        foreach ($rooms as $keyRoom => $room)
            foreach ($room['services'] as $keyService => $service)
                if($keyService==$id)
                    $this->database->getReference('rooms/'.$keyRoom.'/services/'.$keyService)->remove();

        return redirect('admin/services')->with('status',TableController::processDataAction('service','removed',isset($removedResult)));
    }
}
