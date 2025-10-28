<?php

use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GarageController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VehiclesController;
use App\Http\Controllers\Admin\WorksheetController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

Route::get('/info', function(){
    phpinfo();
});

Route::get('/ajanlat/{worksheet}', [WorksheetController::class, 'view'])->name('worksheet.view');

Route::post('image/upload', [ImageController::class, 'upload'])->name('image.upload');

Route::group(['middleware' => ['auth:web']], function(){
    Route::prefix('admin')->group(function () {
        
    });
});

