<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

Route::get('/', [WelcomeController::class,'show']);
Route::post('booking',[BookingController::class,'create']);
Route::get('booking/{id}',[BookingController::class,'show']);

Route::get('admin',[AdminController::class,'show']);

Route::post('admin/room/add',[RoomController::class,'add']);
Route::get('admin/rooms',[RoomController::class,'show']);
Route::get('admin/room/create',[RoomController::class,'create']);
Route::get('admin/room/add/service/{id}',[RoomController::class,'selectService']);
Route::put('admin/room/update/service/{id}',[RoomController::class,'addService']);

Route::post('admin/service/add',[ServiceController::class,'add']);
Route::get('admin/services',[ServiceController::class,'show']);
Route::get('admin/service/create',[ServiceController::class,'create']);

Route::post('admin/place/add',[PlaceController::class,'add']);
Route::get('admin/places',[PlaceController::class,'show']);
Route::get('admin/place/create',[PlaceController::class,'create']);

Route::post('admin/contact/add',[ContactController::class,'add']);
Route::get('admin/contacts',[ContactController::class,'show']);
Route::get('admin/contact/create',[ContactController::class,'create']);