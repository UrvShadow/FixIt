<?php

use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Admin\RepairRequestController as AdminRepairRequestController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\RepairRequestController;
use App\Http\Controllers\ServiceController;
use App\Models\Payment;
use App\Models\RepairRequest;
use App\Models\Service;
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

Route::get('/services', [ServiceController::class, 'index']) 
    ->name('services.index'); 

Route::get('/services/{service}', [ServiceController::class, 'show']) 
    ->name('services.show');

Route::get('/', function () { 
    $services = Service::query() 
        ->where('is_active', true) 
        ->orderBy('name') 
        ->take(4) 
        ->get(); 
        
    return view('index', compact('services')); 
})->name('home');


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

    /*
    |--------------------------------------------------------------------------
    | Promo
    |--------------------------------------------------------------------------
    */

    Route::post('/invoices/{invoice}/promo', [PromoController::class, 'apply'])
        ->name('invoices.promo.apply');

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

        'activeServices' => Service::where(
            'is_active',
            true
        )->count(),
    ]);
})->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Service Management
        |--------------------------------------------------------------------------
        */ 
        Route::get('/services', [AdminServiceController::class, 'index'])
            ->name('services.index');

        Route::get('/services/create', [AdminServiceController::class, 'create'])
            ->name('services.create');

        Route::post('/services', [AdminServiceController::class, 'store'])
            ->name('services.store');

        Route::get('/services/{service}/edit', [AdminServiceController::class, 'edit'])
            ->name('services.edit');

        Route::put('/services/{service}', [AdminServiceController::class, 'update'])
            ->name('services.update');

        Route::patch('/services/{service}/toggle', [AdminServiceController::class, 'toggleStatus']) 
            ->name('services.toggle');

        /*
        |--------------------------------------------------------------------------
        | Promo Management
        |--------------------------------------------------------------------------
        */ 

        Route::get('/promos', [AdminPromoController::class, 'index'])
            ->name('promos.index');

        Route::get('/promos/create', [AdminPromoController::class, 'create'])
            ->name('promos.create');

        Route::post('/promos', [AdminPromoController::class, 'store'])
            ->name('promos.store');

        Route::get('/promos/{promo}/edit', [AdminPromoController::class, 'edit'])
            ->name('promos.edit');

        Route::put('/promos/{promo}', [AdminPromoController::class, 'update'])
            ->name('promos.update');

        Route::patch('/promos/{promo}/toggle', [AdminPromoController::class, 'toggleStatus'])
            ->name('promos.toggle');

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