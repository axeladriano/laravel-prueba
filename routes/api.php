<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\EventController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(ReservationController::class)->group(function(){
    Route::get('/reservation','index');
    Route::get('/reservation/{id}','show');
    Route::post('/reservation','store');
    Route::delete('/reservation','delete');
});

Route::controller(EventController::class)->group(function(){
    route::get('event','index');
    Route::post('/event','store');
    Route::get('/event/{id}','show');
    Route::put('/event/{id}','update');
    Route::delete('/event/{id}','destroy');
});
