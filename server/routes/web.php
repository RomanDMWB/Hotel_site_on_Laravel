<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;

Route::get('/', [WelcomeController::class,'show']);

Route::post('admin/room/add',[RoomController::class,'add']);
Route::get('admin/room',[RoomController::class,'show']);
Route::get('admin/room/create',[RoomController::class,'create']);
Route::get('admin/room/add-service/{id}',[RoomController::class,'selectService']);
Route::put('admin/room/update/service/{id}',[RoomController::class,'addService']);

Route::post('admin/service/add',[ServiceController::class,'add']);
Route::get('admin/service',[ServiceController::class,'show']);
Route::get('admin/service/create',[ServiceController::class,'create']);

Route::post('booking',[BookingController::class,'create']);