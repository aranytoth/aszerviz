<?php

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\WorksheetController;
use App\Http\Controllers\Public\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes(['register' => false]);

Route::get('/',[SiteController::class, 'index'])->name('public.home');

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

