<?php

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\WorksheetController;
use App\Http\Controllers\Public\SiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;

$loginUrl = get_option('login', 'login');
$logoutUrl = get_option('logout', 'logout');
$resetPrefix = get_option('password_reset', '');
$verifyPrefix = get_option('email_verify', '');


Route::get('storage/{folder_id}/{dimensions}/{filename}', [ImageController::class, 'resize'])
    ->where([
        'folder_id'  => '[0-9]+',          // Pl: 52513 (csak számok)
        'dimensions' => '\d+x\d+',         // Pl: 310x440 (szám, x, szám)
        'filename'   => '.*'               // Bármilyen fájlnév (kiterjesztéssel együtt)
    ])
    ->name('image.resize');

//Auth::routes(['register' => false]);

// 2. BEJELENTKEZÉS ÉS KIJELENTKEZÉS
Route::group(['middleware' => ['web']], function () use ($loginUrl, $logoutUrl) {
    // Bejelentkezés
    Route::get($loginUrl, [LoginController::class, 'showLoginForm'])->name('login');
    Route::post($loginUrl, [LoginController::class, 'login']);

    // Kijelentkezés (POST metódus)
    Route::post($logoutUrl, [LoginController::class, 'logout'])->name('logout');
});


// 3. JELSZÓ-VISSZAÁLLÍTÁS (RESET)
// Az útvonalak a {$resetPrefix} (pl. 'pwd-security') prefixet használják.
Route::group(['prefix' => $resetPrefix, 'middleware' => ['web']], function () {
    // Kérés: űrlap megjelenítése az e-mailhez
    Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    
    // E-mail küldése a visszaállítási linkkel
    Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Visszaállítási űrlap token alapján
    Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

    // Jelszó frissítése
    Route::post('reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});


// 4. E-MAIL HITELESÍTÉS (VERIFY)
// Az útvonalak a {$verifyPrefix} (pl. 'email-confirm') prefixet használják.
// A 'auth' middleware-t hozzáadjuk, hogy csak bejelentkezett felhasználó hitelesíthessen.
Route::group(['prefix' => $verifyPrefix, 'middleware' => ['web', 'auth']], function () {
    // Értesítés (notice) az űrlaphoz (ha a felhasználó be van jelentkezve, de nincs hitelesítve)
    Route::get('email', [VerificationController::class, 'show'])->name('verification.notice');
    
    // A hitelesítési link kezelése
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

    // Újra küldés
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

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

