<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SigapController;

/*
|--------------------------------------------------------------------------
| SIGAP Routes
|--------------------------------------------------------------------------
*/

Route::get('/',           [SigapController::class, 'dashboard'])->name('dashboard');
Route::get('/input',      [SigapController::class, 'input'])->name('input');
Route::post('/input',     [SigapController::class, 'store'])->name('input.store');
Route::get('/data-kejadian',          [SigapController::class, 'dataKejadian'])->name('data-kejadian');
Route::get('/data-kejadian/{id}',     [SigapController::class, 'show'])->name('data-kejadian.show');
Route::delete('/data-kejadian/{id}',  [SigapController::class, 'destroy'])->name('data-kejadian.destroy');
Route::get('/grafik',     [SigapController::class, 'grafik'])->name('grafik');