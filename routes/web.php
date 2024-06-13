<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\FieldsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentMethodController;

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
Route::get('/storage-link', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    dd('storage link');
});

Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'forgotPasswordView'])->name('forgotPassword');
Route::get('/new-password/{token}', [AuthController::class, 'newPasswordView'])->name('newPassword');
Route::post('/register', [AuthController::class, 'register'])->name('register.auth');
Route::post('/login', [AuthController::class, 'login'])->name('login.auth');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword.auth');
Route::post('/new-password', [AuthController::class, 'newPassword'])->name('newPassword.auth');
Route::prefix('/article')->group(function () {
    Route::get('/', [PostController::class, 'getArticle'])->name('getArticle');
    Route::get('/{id}', [PostController::class, 'showArticle'])->name('detailArticle');
});
Route::prefix('/information')->group(function () {
    Route::get('/', [PostController::class, 'getInformation'])->name('getInformation');
    Route::get('/{id}', [PostController::class, 'showInformation'])->name('detailInformation');
});

Route::middleware(['auth', 'inactivityTimeout:1800'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('/field/data', [FieldsController::class, 'indexField'])->name('admin.fieldIndex');
            Route::get('/field/data/create', [FieldsController::class, 'createField'])->name('admin.fieldCreate');
            Route::post('/field/data/store', [FieldsController::class, 'storeField'])->name('admin.fieldStore');
            Route::get('/field/data/edit/{id}', [FieldsController::class, 'editField'])->name('admin.fieldEdit');
            Route::put('/field/data/update/{id}', [FieldsController::class, 'updateField'])->name('admin.fieldUpdate');
            Route::delete('/field/data/delete/{id}', [FieldsController::class, 'destroyField'])->name('admin.fieldDelete');

            // Field Schedule
            Route::get('/field/schedule', [FieldsController::class, 'indexSchedule'])->name('admin.scheduleIndex');
            Route::get('/field/schedule-active', [FieldsController::class, 'indexScheduleActive'])->name('admin.scheduleActiveIndex');
            Route::put('/field/schedule/update/{id}', [FieldsController::class, 'updateSchedule'])->name('admin.scheduleUpdate');
            Route::delete('/field/schedule/delete', [FieldsController::class, 'destroyScheduleActive'])->name('admin.scheduleActiveDelete');

            // Booking
            Route::get('/booking', [BookingController::class, 'index'])->name('admin.bookingIndex');
            Route::get('/booking/choose-field', [BookingController::class, 'chooseField'])->name('admin.chooseField');
            Route::get('/booking/choose-field/{id}', [BookingController::class, 'create'])->name('admin.bookingCreate');
            Route::get('/filter', [BookingController::class, 'checkAvailability'])->name('check.availability');
            Route::post('/booking/get-session', [BookingController::class, 'getSession'])->name('admin.getSession');

            // Booking Transaction
            Route::get('/booking/transaction', [BookingController::class, 'transaction'])->name('admin.transaction');
            Route::get('/booking/transaction/{id}', [BookingController::class, 'paymentTransaction'])->name('admin.paymentTransaction');
            Route::post('/booking/transaction/store', [BookingController::class, 'storeTransaction'])->name('admin.storeTransaction');

            Route::put('/booking/dp-success/{id}', [BookingController::class, 'confirmPaymentDP'])->name('admin.confirmPaymentDP');
            Route::put('/booking/remaining-success/{id}', [BookingController::class, 'confirmPaymentRemaining'])->name('admin.confirmPaymentRemaining');
            Route::put('/booking/canceled/{id}', [BookingController::class, 'canceledBooking'])->name('admin.canceledBooking');
            Route::put('/booking/invalidate/{id}', [BookingController::class, 'invalidatePaymentDP'])->name('admin.invalidatePaymentDP');

            // Transaction
            Route::get('/transaction', [BookingController::class, 'transactionIndex'])->name('admin.transactionIndex');
            Route::get('/transaction/load-transactions', [BookingController::class, 'loadTransactions'])->name('admin.loadTransactions');
            Route::get('/transaction/export-pdf', [BookingController::class, 'transactionExportPDF'])->name('admin.transactionExportPDF');

            // User
            Route::get('/user', [UserController::class, 'index'])->name('admin.userIndex');
            Route::get('/user/create', [UserController::class, 'create'])->name('admin.userCreate');
            Route::post('/user/store', [UserController::class, 'store'])->name('admin.userStore');
            Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('admin.userEdit');
            Route::put('/user/update/{id}', [UserController::class, 'update'])->name('admin.userUpdate');
            Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('admin.userDelete');

            // Payment Method
            Route::get('/payment-method', [PaymentMethodController::class, 'index'])->name('admin.paymentMethodIndex');
            Route::get('/payment-method/create', [PaymentMethodController::class, 'create'])->name('admin.paymentMethodCreate');
            Route::post('/payment-method/store', [PaymentMethodController::class, 'store'])->name('admin.paymentMethodStore');
            Route::get('/payment-method/edit/{id}', [PaymentMethodController::class, 'edit'])->name('admin.paymentMethodEdit');
            Route::put('/payment-method/update/{id}', [PaymentMethodController::class, 'update'])->name('admin.paymentMethodUpdate');
            Route::delete('/payment-method/delete/{id}', [PaymentMethodController::class, 'destroy'])->name('admin.paymentMethodDelete');

            // Post
            Route::get('/post', [PostController::class, 'index'])->name('admin.postIndex');
            Route::get('/post/create', [PostController::class, 'create'])->name('admin.postCreate');
            Route::get('/post/detail/{id}', [PostController::class, 'show'])->name('admin.postDetail');
            Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('admin.postEdit');
            Route::post('/post/store', [PostController::class, 'store'])->name('admin.postStore');
            Route::put('/post/update/{id}', [PostController::class, 'update'])->name('admin.postUpdate');
            Route::delete('/post/delete/{id}', [PostController::class, 'destroy'])->name('admin.postDelete');

            // Profile
            Route::get('/profile', [AuthController::class, 'profile'])->name('admin.profile');
            Route::get('/profile/edit/{id}', [AuthController::class, 'editProfile'])->name('admin.editProfile');
            Route::put('/profile/update/{id}', [AuthController::class, 'updateProfile'])->name('admin.updateProfile');

            // Index Data
            Route::get('/index-data', [IndexController::class, 'indexData'])->name('admin.indexData');
            Route::put('/index-data/update/{id}', [IndexController::class, 'updateIndexData'])->name('admin.updateIndexData');
        });
    });
    Route::middleware('role:user')->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/home', [IndexController::class, 'index'])->name('user.index');
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

            // Profile
            Route::get('/profile', [AuthController::class, 'profile'])->name('user.profile');
            Route::get('/profile/edit/{id}', [AuthController::class, 'editProfile'])->name('user.editProfile');
            Route::put('/profile/update/{id}', [AuthController::class, 'updateProfile'])->name('user.updateProfile');
        });
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
