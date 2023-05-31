<?php

use App\Http\Middleware\CheckHR;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'absences'], function() {
    Route::post('/clock-in', [App\Http\Controllers\AbsenceController::class, 'clockIn'])->name('absences.clock-in');
    Route::post('/clock-out', [App\Http\Controllers\AbsenceController::class, 'clockOut'])->name('absences.clock-out');

    Route::get('/', [App\Http\Controllers\AbsenceController::class, 'index'])->name('hr.monitor-absences')->middleware(CheckHR::class);
});
