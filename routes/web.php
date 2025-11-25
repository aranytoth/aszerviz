<?php

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\WorksheetController;
use App\Http\Controllers\Public\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('storage/{folder_id}/{dimensions}/{filename}', [ImageController::class, 'resize'])
    ->where([
        'folder_id'  => '[0-9]+',          // Pl: 52513 (csak számok)
        'dimensions' => '\d+x\d+',         // Pl: 310x440 (szám, x, szám)
        'filename'   => '.*'               // Bármilyen fájlnév (kiterjesztéssel együtt)
    ])
    ->name('image.resize');


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

