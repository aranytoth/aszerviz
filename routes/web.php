<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GarageController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\WorksheetController;
use App\Models\Worksheet;
use Illuminate\Support\Facades\Route;


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/info', function(){
    phpinfo();
});

Route::get('/ajanlat/{worksheet}', [WorksheetController::class, 'view'])->name('worksheet.view');

Route::post('image/upload', [ImageController::class, 'upload'])->name('image.upload');

Route::group(['middleware' => ['auth:web']], function(){
    Route::get('/', [WorksheetController::class, 'index'])->name('worksheet');
    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/new', [UserController::class, 'create'])->name('users.create');
    Route::post('users/new', [UserController::class, 'store'])->name('users.store');
    Route::get('user/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/edit/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('munkalap', [WorksheetController::class, 'index'])->name('worksheet.index');
    Route::get('munkalap/new', [WorksheetController::class, 'create'])->name('worksheet.create');
    Route::post('munkalap/new', [WorksheetController::class, 'store'])->name('worksheet.store');
    Route::get('munkalap/edit/{worksheet}', [WorksheetController::class, 'edit'])->name('worksheet.edit');
    Route::put('munkalap/edit/{worksheet}', [WorksheetController::class, 'update'])->name('worksheet.update');

    Route::get('munkalap/pdf/{worksheet}', [WorksheetController::class, 'createPDF'])->name('worksheet.pdf');
    Route::post('munkalap/email/{worksheet}', [WorksheetController::class, 'sendOffer'])->name('worksheet.email');
    Route::post('munkalap/status/{worksheet}', [WorksheetController::class, 'setStatus'])->name('worksheet.status');
    Route::get('munkalap/garancia/{worksheet}', [WorksheetController::class, 'createWarranty'])->name('worksheet.warranty');

    Route::get('company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('company/new', [CompanyController::class, 'create'])->name('company.create');
    Route::post('company/new', [CompanyController::class, 'store'])->name('company.store');
    Route::get('company/edit/{company}', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('company/edit/{company}', [CompanyController::class, 'update'])->name('company.update');

    Route::get('garage', [GarageController::class, 'index'])->name('garage.index');
    Route::get('garage/new', [GarageController::class, 'create'])->name('garage.create');
    Route::post('garage/new', [GarageController::class, 'store'])->name('garage.store');
    Route::get('garage/edit/{garage}', [GarageController::class, 'edit'])->name('garage.edit');
    Route::put('garage/edit/{garage}', [GarageController::class, 'update'])->name('garage.update');

    Route::get('ugyfelek', [ClientsController::class, 'index'])->name('client.index');
    Route::get('ugyfelek/{client}', [ClientsController::class, 'view'])->name('client.view');

    Route::get('gepjarmuvek', [VehiclesController::class, 'index'])->name('vehicle.index');
    Route::get('gepjarmuvek/{vehicle}', [VehiclesController::class, 'view'])->name('vehicle.view');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

