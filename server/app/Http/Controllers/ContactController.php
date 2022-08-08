<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'contacts';
    }

    public function show(){
        $contacts = $this->database->getReference($this->tablename)->getValue();
        return view('admin.contact.index',compact('contacts'));
    }

    public function create(){
        return view('admin.contact.create');
    }

    public function add(Request $request){
        $createData = [
            'name' => $request->name,
            'content' => $request->content,
            'icon' => $request->icon,
        ];
        $addData = $this->database->getReference($this->tablename)->push($createData);
        if($addData)
        return redirect('admin/contacts')->with('status','Contacts Added Successfully');
        else
        return redirect('admin/contacts')->with('status','Contacts Not Added');
    }

    public function compose(View $view){
        $view->with('contacts', $this->database->getReference('contacts')->getValue());
    }
}
