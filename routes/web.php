<?php

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FieldsController;
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

Route::get('/', [AuthController::class, 'index'])->name('index');

Route::get('/login',[AuthController::class, 'index'])->name('login');
Route::post('/login',[AuthController::class, 'login'])->name('login.auth');

Route::middleware(['auth', 'inactivityTimeout:1800'])->group(function () {
    Route::prefix('owner')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('owner.dashboard'); 
        Route::get('/field/data', [FieldsController::class, 'indexField'])->name('owner.fieldIndex'); 
        Route::get('/field/data/create', [FieldsController::class, 'createField'])->name('owner.fieldCreate'); 
        Route::post('/field/data/store', [FieldsController::class, 'storeField'])->name('owner.fieldStore');
        Route::get('/field/data/edit/{id}', [FieldsController::class, 'editField'])->name('owner.fieldEdit');
        Route::put('/field/data/update/{id}', [FieldsController::class, 'updateField'])->name('owner.fieldUpdate');
        Route::delete('/field/data/delete/{id}', [FieldsController::class, 'destroyField'])->name('owner.fieldDelete'); 

        // Field Schedule
        Route::get('/field/schedule', [FieldsController::class, 'indexSchedule'])->name('owner.scheduleIndex');
        Route::get('/field/schedule-active', [FieldsController::class, 'indexScheduleActive'])->name('owner.scheduleActiveIndex');
        Route::put('/field/schedule/update/{id}', [FieldsController::class, 'updateSchedule'])->name('owner.scheduleUpdate');
        Route::delete('/field/schedule/delete', [FieldsController::class, 'destroyScheduleActive'])->name('owner.scheduleActiveDelete');

        // Booking
        Route::get('/booking', [BookingController::class, 'index'])->name('owner.bookingIndex');
        Route::get('/booking/choose-field', [BookingController::class, 'chooseField'])->name('owner.chooseField');
        Route::get('/booking/choose-field/{id}', [BookingController::class, 'create'])->name('owner.bookingCreate');
        Route::get('/filter', [BookingController::class, 'checkAvailability'])->name('check.availability');
        Route::post('/booking/get-session', [BookingController::class, 'getSession'])->name('owner.getSession');

        // Transaction
        Route::get('/transaction', [BookingController::class, 'transaction'])->name('owner.transaction');
        Route::get('/transaction/{id}', [BookingController::class, 'paymentTransaction'])->name('owner.paymentTransaction');
        Route::post('/transaction/store', [BookingController::class, 'storeTransaction'])->name('owner.storeTransaction');
    });
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});