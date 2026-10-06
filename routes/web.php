<?php

use App\Http\Controllers\Admin\RepairRequestController as AdminRepairRequestController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RepairRequestController;
use App\Models\Payment;
use App\Models\RepairRequest;
use App\Models\User;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'index')->name('home');

Route::get('/device/{device_code}', [DeviceController::class, 'publicShow'])
    ->name('devices.public-show');


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);
});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Devices
    |--------------------------------------------------------------------------
    */

    Route::get('/devices', [DeviceController::class, 'index'])
        ->name('devices.index');

    Route::get('/devices/create', [DeviceController::class, 'create'])
        ->name('devices.create');

    Route::post('/devices', [DeviceController::class, 'store'])
        ->name('devices.store');

    Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])
        ->name('devices.edit');

    Route::put('/devices/{device}', [DeviceController::class, 'update'])
        ->name('devices.update');

    Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])
        ->name('devices.destroy');


    /*
    |--------------------------------------------------------------------------
    | Repairs
    |--------------------------------------------------------------------------
    */

    Route::get('/repairs', [RepairRequestController::class, 'index'])
        ->name('repairs.index');

    Route::get('/repairs/create', [RepairRequestController::class, 'create'])
        ->name('repairs.create');

    Route::post('/repairs', [RepairRequestController::class, 'store'])
        ->name('repairs.store');


    /*
    |--------------------------------------------------------------------------
    | Payments
    |--------------------------------------------------------------------------
    */

    // Payment method selection
    Route::get('/repairs/{repair}/payment', [PaymentController::class, 'create'])
        ->name('payments.create');

    // QRIS
    Route::get('/repairs/{repair}/payment/qris', [PaymentController::class, 'qris'])
        ->name('payments.qris');

    Route::post('/payments/{invoice}/qris', [PaymentController::class, 'processQris'])
        ->name('payments.qris.process');

    // Bank Transfer
    Route::get('/repairs/{repair}/payment/bank-transfer', [PaymentController::class, 'bankTransfer'])
        ->name('payments.bank-transfer');

    Route::get('/repairs/{repair}/payment/bank-transfer/{bank}', [PaymentController::class, 'bankAccount'])
        ->name('payments.bank-account');

    Route::get('/repairs/{repair}/payment/bank-transfer/{bank}/verification', [PaymentController::class, 'bankVerification'])
        ->name('payments.bank-verification');

    Route::post('/payments/{invoice}/bank-transfer/verify', [PaymentController::class, 'processBankTransfer'])
        ->name('payments.bank-transfer.verify');

    // Legacy / direct payment endpoint
    Route::post('/payments/{invoice}', [PaymentController::class, 'store'])
        ->name('payments.store');


    /*
    |--------------------------------------------------------------------------
    | Repair Detail
    |--------------------------------------------------------------------------
    */

    Route::get('/repairs/{repair}', [RepairRequestController::class, 'show'])
        ->name('repairs.show');

    /*
    |--------------------------------------------------------------------------
    | Invoice Download
    |--------------------------------------------------------------------------
    */

    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])
        ->name('invoices.download');

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', function () {

            return view('admin.dashboard', [
                'totalUsers' => User::where('role', 'user')->count(),

                'activeRepairs' => RepairRequest::whereNotIn('status', [
                    'completed',
                    'rejected',
                    'cancelled',
                ])->count(),

                'completedRepairs' => RepairRequest::where(
                    'status',
                    'completed'
                )->count(),

                'totalTransactions' => Payment::where(
                    'status',
                    'paid'
                )->count(),
            ]);

        })->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Repair Management
        |--------------------------------------------------------------------------
        */

        Route::get('/repairs', [AdminRepairRequestController::class, 'index'])
            ->name('repairs.index');

        Route::get('/repairs/{repair}', [AdminRepairRequestController::class, 'show'])
            ->name('repairs.show');

        Route::put('/repairs/{repair}/status', [AdminRepairRequestController::class, 'updateStatus'])
            ->name('repairs.update-status');

        Route::post('/repairs/{repair}/invoice', [AdminRepairRequestController::class, 'createInvoice'])
            ->name('repairs.create-invoice');
    });