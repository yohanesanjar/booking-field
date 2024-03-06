<?php

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\AuthController;
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
    });
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});