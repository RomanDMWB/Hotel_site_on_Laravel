<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

// User Routes
Route::get('/', [WelcomeController::class,'show']);

Route::post('booking',[BookingController::class,'create']);
Route::get('booking/{id}',[BookingController::class,'showBooking']);
Route::get('booking/form/{type}',[BookingController::class,'form']);

Route::get('room/{id}',[RoomController::class,'getInfo']);

// Administration Routes
Route::get('admin',[AdminController::class,'show']);

Route::put('admin/booking/update/{id}',[BookingController::class,'update']);
Route::get('admin/bookings',[BookingController::class,'show']);
Route::get('admin/booking/form/{id}',[BookingController::class,'form']);
Route::get('admin/booking/type/{type}',[BookingController::class,'getPLacesOfType']);

Route::post('admin/room/add',[RoomController::class,'add']);
Route::post('admin/room/update/{id}',[RoomController::class,'update']);
Route::get('admin/rooms',[RoomController::class,'show']);
Route::get('admin/room/form',[RoomController::class,'form']);
Route::get('admin/room/form/{id}',[RoomController::class,'form']);
Route::get('admin/room/add/service/{id}',[RoomController::class,'selectService']);
Route::put('admin/room/update/service/{id}',[RoomController::class,'addService']);

Route::post('admin/service/add',[ServiceController::class,'add']);
Route::get('admin/services',[ServiceController::class,'show']);
Route::get('admin/service/form',[ServiceController::class,'form']);

Route::post('admin/place/add',[PlaceController::class,'add']);
Route::get('admin/places',[PlaceController::class,'show']);
Route::get('admin/place/form',[PlaceController::class,'form']);

Route::post('admin/contact/add',[ContactController::class,'add']);
Route::get('admin/contacts',[ContactController::class,'show']);
Route::get('admin/contact/form',[ContactController::class,'form']);