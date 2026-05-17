<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SigapController;

/*
|--------------------------------------------------------------------------
| SIGAP Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [SigapController::class, 'dashboard'])->name('dashboard');
    Route::get('/input', [SigapController::class, 'input'])->name('input');
    Route::post('/input', [SigapController::class, 'store'])->name('input.store');
    Route::get('/data-kejadian', [SigapController::class, 'dataKejadian'])->name('data-kejadian');
    Route::get('/data-kejadian/{kejadian}', [SigapController::class, 'show'])->name('data-kejadian.show');
    Route::delete('/data-kejadian/{kejadian}', [SigapController::class, 'destroy'])->middleware('admin')->name('data-kejadian.destroy');
    Route::get('/grafik', [SigapController::class, 'grafik'])->name('grafik');
});
