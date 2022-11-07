<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

// User Routes
Route::get('/', [WelcomeController::class,'show'])->name('welcome');
Route::get('/welcome/error', [WelcomeController::class,'showWithError'])->name('welcome-error');

//All user info
Route::get('about',function(){
    $content = File::get('../resources/files/text.txt');
    return view('all.about',compact('content'));
});
Route::get('contacts',[UserController::class,'contacts']);
Route::get('room/{id}',[RoomController::class,'getInfo']);
Route::get('booking/form/{type}',[BookingController::class,'formType']);

//Auth Routes
Route::post('login',[AuthController::class,"login"]);
Route::post('logup',[AuthController::class,"logup"]);

//User Routes
Route::group(['middleware'=>['user']],function(){
    Route::get('logout',[AuthController::class,'logout']);
    Route::get('user/page',[UserController::class,'page']);
    Route::get('bookings',[BookingController::class,'bookings']);
    Route::post('booking',[BookingController::class,'create']);
    Route::get('booking/{id}',[BookingController::class,'showBooking']);
    Route::get('user/save',[UserController::class,'save']);
});

// Administration Routes
Route::group(['middleware'=>['admin']],function(){
    Route::get('admin',[AdminController::class,'show'])->name('admin');
    Route::get('admin/users',[UserController::class,'list']);
    Route::get('admin/user/destroy/{id}',[UserController::class,'delete']);
    
    Route::put('admin/booking/update/{id}',[BookingController::class,'update']);
    Route::post('admin/booking/destroy/{id}',[BookingController::class,'destroy']);
    Route::get('admin/bookings',[BookingController::class,'show']);
    Route::get('admin/booking/form/{id}',[BookingController::class,'form']);
    
    Route::post('admin/room/add',[RoomController::class,'add']);
    Route::post('admin/room/destroy/{id}',[RoomController::class,'destroy']);
    Route::post('admin/room/service/destroy/{room_id}/{service_id}',[RoomController::class,'destroyService']);
    Route::put('admin/room/update/{id}',[RoomController::class,'update']);
    Route::put('admin/room/update/service/{id}',[RoomController::class,'addService']);
    Route::get('admin/rooms',[RoomController::class,'show']);
    Route::get('admin/room/form',[RoomController::class,'form']);
    Route::get('admin/room/form/{id}',[RoomController::class,'form']);
    Route::get('admin/room/add-service/{id}',[RoomController::class,'selectService']);
    
    Route::post('admin/service/add',[ServiceController::class,'add']);
    Route::post('admin/service/destroy/{id}',[ServiceController::class,'destroy']);
    Route::post('admin/service/update/{id}',[ServiceController::class,'update']);
    Route::get('admin/services',[ServiceController::class,'show']);
    Route::get('admin/service/form',[ServiceController::class,'form']);
    Route::get('admin/service/form/{id}',[ServiceController::class,'form']);
    
    Route::post('admin/place/add',[PlaceController::class,'add']);
    Route::post('admin/place/destroy/{id}',[PlaceController::class,'destroy']);
    Route::put('admin/place/update/{id}',[PlaceController::class,'update']);
    Route::get('admin/places',[PlaceController::class,'show']);
    Route::get('admin/place/form',[PlaceController::class,'form']);
    Route::get('admin/place/form/{id}',[PlaceController::class,'form']);
    
    Route::post('admin/contact/add',[ContactController::class,'add']);
    Route::post('admin/contact/destroy/{id}',[ContactController::class,'destroy']);
    Route::patch('admin/contact/update/{id}',[ContactController::class,'update']);
    Route::get('admin/contacts',[ContactController::class,'show']);
    Route::get('admin/contact/form',[ContactController::class,'form']);
    Route::get('admin/contact/form/{id}',[ContactController::class,'form']);
});