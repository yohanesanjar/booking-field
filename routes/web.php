<?php

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\AuthController;
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
    });
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});