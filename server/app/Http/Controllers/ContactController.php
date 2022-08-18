<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\View\View;
use App\Http\Requests\CreateContactRequest;

class ContactController extends Controller
{
    private $tablename;
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'contacts';
    }

    public function show(){
        $contacts = $this->database->getReference($this->tablename)->getValue();
        return view('admin.contact.index',compact('contacts'));
    }

    public function form($id=null){
        if($id){
            $contact = $this->database->getReference($this->tablename)->getChild($id)->getValue();
            return view('admin.contact.form',compact('contact','id'));
        }
        else
        return view('admin.contact.form');
    }

    public function add(CreateContactRequest $request){
        $createData = [
            'name' => $request->name,
            'content' => $request->content,
            'icon' => $request->icon,
        ];
        $addResult = $this->database->getReference($this->tablename)->push($createData);
        $status = TableController::processDataAction('contact','added',isset($addResult));
        return redirect('admin/contacts')->with('status',$status);
    }
    
    public function update(CreateContactRequest $request,$id){
        $updateResult = $this->database->getReference($this->tablename.'/'.$id)->update([
            'name' => $request->name,
            'content' => $request->content,
            'icon' => $request->icon,
        ]);
        $status = TableController::processDataAction('contact','updated',isset($updateResult));
        return redirect('admin/contacts')->with('status',$status);
    }

    public function destroy($id){
        $removeResult = $this->database->getReference($this->tablename.'/'.$id)->remove();
        $status = TableController::processDataAction('contact','removed',isset($removeResult));
        return redirect('admin/contacts')->with('status',$status);
    }
}
