<?php

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FieldsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TransactionController;
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

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.auth');
Route::prefix('/article')->group(function () {
    Route::get('/', [PostController::class, 'getArticle'])->name('getArticle');
    Route::get('/{id}', [PostController::class, 'showArticle'])->name('detailArticle');
});
Route::prefix('/information')->group(function () {
    Route::get('/', [PostController::class, 'getInformation'])->name('getInformation');
    Route::get('/{id}', [PostController::class, 'showInformation'])->name('detailInformation');
});

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

        // Booking Transaction
        Route::get('/booking/transaction', [BookingController::class, 'transaction'])->name('owner.transaction');
        Route::get('/booking/transaction/{id}', [BookingController::class, 'paymentTransaction'])->name('owner.paymentTransaction');
        Route::post('/booking/transaction/store', [BookingController::class, 'storeTransaction'])->name('owner.storeTransaction');

        Route::put('/booking/dp-success/{id}', [BookingController::class, 'confirmPaymentDP'])->name('owner.confirmPaymentDP');
        Route::put('/booking/remaining-success/{id}', [BookingController::class, 'confirmPaymentRemaining'])->name('owner.confirmPaymentRemaining');
        Route::put('/booking/canceled/{id}', [BookingController::class, 'canceledBooking'])->name('owner.canceledBooking');
        Route::put('/booking/invalidate/{id}', [BookingController::class, 'invalidatePaymentDP'])->name('owner.invalidatePaymentDP');

        // Transaction
        Route::get('/transaction', [BookingController::class, 'transactionIndex'])->name('owner.transactionIndex');
        Route::get('/transaction/load-transactions', [BookingController::class, 'loadTransactions'])->name('owner.loadTransactions');
        Route::get('/transaction/export-pdf', [BookingController::class, 'transactionExportPDF'])->name('owner.transactionExportPDF');

        // User
        Route::get('/user', [UserController::class, 'index'])->name('owner.userIndex');
        Route::get('/user/create', [UserController::class, 'create'])->name('owner.userCreate');
        Route::post('/user/store', [UserController::class, 'store'])->name('owner.userStore');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('owner.userEdit');
        Route::put('/user/update/{id}', [UserController::class, 'update'])->name('owner.userUpdate');
        Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('owner.userDelete');

        // Payment Method
        Route::get('/payment-method', [PaymentMethodController::class, 'index'])->name('owner.paymentMethodIndex');
        Route::get('/payment-method/create', [PaymentMethodController::class, 'create'])->name('owner.paymentMethodCreate');
        Route::post('/payment-method/store', [PaymentMethodController::class, 'store'])->name('owner.paymentMethodStore');
        Route::get('/payment-method/edit/{id}', [PaymentMethodController::class, 'edit'])->name('owner.paymentMethodEdit');
        Route::put('/payment-method/update/{id}', [PaymentMethodController::class, 'update'])->name('owner.paymentMethodUpdate');
        Route::delete('/payment-method/delete/{id}', [PaymentMethodController::class, 'destroy'])->name('owner.paymentMethodDelete');

        // Post
        Route::get('/post', [PostController::class, 'index'])->name('owner.postIndex');
        Route::get('/post/create', [PostController::class, 'create'])->name('owner.postCreate');
        Route::get('/post/detail/{id}', [PostController::class, 'show'])->name('owner.postDetail');
        Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('owner.postEdit');
        Route::post('/post/store', [PostController::class, 'store'])->name('owner.postStore');
        Route::put('/post/update/{id}', [PostController::class, 'update'])->name('owner.postUpdate');
        Route::delete('/post/delete/{id}', [PostController::class, 'destroy'])->name('owner.postDelete');
    });

    Route::prefix('user')->group(function () {
        Route::get('/home', function () {
            return view('user.index');
        })->name('user.index');
        Route::get('/booking', [BookingController::class, 'chooseField'])->name('user.booking');
        Route::get('/booking/choose-field/{id}', [BookingController::class, 'create'])->name('user.bookingCreate');
        Route::get('/filter', [BookingController::class, 'checkAvailability'])->name('user.checkAvailability');
        Route::get('/booking/search', [BookingController::class, 'search'])->name('user.search');
        Route::post('/booking/get-session', [BookingController::class, 'getSession'])->name('user.getSession');

        Route::get('/transaction', [BookingController::class, 'transaction'])->name('user.transaction');
        Route::get('/transaction/payment/{id}', [BookingController::class, 'paymentTransaction'])->name('user.paymentTransaction');
        Route::get('/transaction/notice/{id}', [BookingController::class, 'noticeTransaction'])->name('user.noticeTransaction');
        Route::post('/transaction/store', [BookingController::class, 'storeTransaction'])->name('user.storeTransaction');
        Route::put('/transaction/payment-store/{id}', [BookingController::class, 'paymentTransactionStore'])->name('user.paymentTransactionStore');

        // Transaction History
        Route::get('/transaction/history', [TransactionController::class, 'transactionHistory'])->name('user.transactionHistory');
        Route::get('/transaction/history/{id}', [TransactionController::class, 'transactionHistoryShow'])->name('user.transactionHistoryDetail');
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
