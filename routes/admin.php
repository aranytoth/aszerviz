<?php

use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GarageController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VehiclesController;
use App\Http\Controllers\Admin\WorksheetController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:web']], function(){
    Route::get('/', [DashboardController::class, 'index'])->name('admin.home');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::post('/calendar/events', [CalendarController::class, 'events'])->name('calendar.events');
    Route::post('/calendar/event', [CalendarController::class, 'store'])->name('calendar.create');
    Route::put('/calendar/event', [CalendarController::class, 'update'])->name('calendar.update');
    Route::delete('/calendar/event', [CalendarController::class, 'delete'])->name('calendar.delete');
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

    Route::get('pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('pages/new', [PageController::class, 'create'])->name('pages.create');
    Route::post('pages/new', [PageController::class, 'store'])->name('pages.store');
    Route::get('pages/edit/{page}', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/edit/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('pages/delete/{page}', [PageController::class, 'destroy'])->name('pages.delete');

    Route::get('post', [PostController::class, 'index'])->name('post.index');
    Route::get('post/new', [PostController::class, 'create'])->name('post.create');
    Route::post('post/new', [PostController::class, 'store'])->name('post.store');
    Route::get('post/edit/{page}', [PostController::class, 'edit'])->name('post.edit');
    Route::put('post/edit/{page}', [PostController::class, 'update'])->name('post.update');
    Route::delete('post/delete/{page}', [PostController::class, 'destroy'])->name('post.delete');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/new', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/new', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/edit/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/delete/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/translations', [TranslationController::class, 'index'])->name('translations.index');
    Route::get('translations/new', [TranslationController::class, 'create'])->name('translations.create');
    Route::post('translations/new', [TranslationController::class, 'store'])->name('translations.store');
    Route::get('/translations/{translation}', [TranslationController::class, 'edit'])->name('translations.edit');
    Route::put('/translations/{translation}', [TranslationController::class, 'update'])->name('translations.update');
    Route::post('/translations/clear-cache', [TranslationController::class, 'clearCache'])->name('translations.clear-cache');

     
    Route::resource('tags', TagController::class);

    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::get('/media/{media}', [MediaController::class, 'show'])->name('media.show');
    Route::get('/media/edit/{media}', [MediaController::class, 'edit'])->name('media.edit');
    Route::put('/media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::post('/media/upload', [MediaController::class, 'store'])->name('media.upload');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
   
});



?>