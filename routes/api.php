<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\VehiclesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/v1')->group(function(){
    Route::get('/search/vehicle', [VehiclesController::class, 'search'])->name('api.search.vehicle');
    Route::get('/search/client', [ClientsController::class, 'search'])->name('api.search.client');
});


