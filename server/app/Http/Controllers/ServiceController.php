<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use App\Http\Requests\ServiceCreateRequest;

class ServiceController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'services';
    }

    public function show(){
        $services = $this->database->getReference($this->tablename)->getValue();
        return view('admin.service.index',compact('services'));
    }

    public function create(){
        return view('admin.service.create');
    }

    public function add(ServiceCreateRequest $request){
        $createData = [
            'name' => $request->name,
            'icon' => $request->icon,
        ];
        $addData = $this->database->getReference($this->tablename)->push($createData);
        if($addData)
        return redirect('admin/services')->with('status','Service Added Successfully');
        else
        return redirect('admin/services')->with('status','Service Not Added');
    }
}
