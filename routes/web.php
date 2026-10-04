<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RepairRequestController;
use App\Http\Controllers\Admin\RepairRequestController as AdminRepairRequestController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('home');

Route::get('/device/{device_code}', [DeviceController::class, 'publicShow'])
    ->name('devices.public-show');

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
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
| User Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'role:user'])->name('dashboard');

Route::middleware(['auth', 'role:user'])->group(function () {

    // Devices
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

    // Repairs
    Route::get('/repairs', [RepairRequestController::class, 'index'])
        ->name('repairs.index');

    Route::get('/repairs/create', [RepairRequestController::class, 'create'])
        ->name('repairs.create');

    Route::post('/repairs', [RepairRequestController::class, 'store'])
        ->name('repairs.store');

    Route::get('/repairs/{repair}', [RepairRequestController::class, 'show'])
        ->name('repairs.show');

    // Payments
    Route::post('/payments/{invoice}', [PaymentController::class, 'store'])
        ->name('payments.store');
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard', [
        'totalUsers' => User::where('role', 'user')->count(),

        'activeRepairs' => \App\Models\RepairRequest::whereNotIn('status', [
            'completed',
            'rejected',
            'cancelled',
        ])->count(),

        'completedRepairs' => \App\Models\RepairRequest::where(
            'status',
            'completed'
        )->count(),

        'totalTransactions' => \App\Models\Payment::where(
            'status',
            'paid'
        )->count(),
    ]);
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/repairs', [AdminRepairRequestController::class, 'index'])
            ->name('repairs.index');

        Route::get('/repairs/{repair}', [AdminRepairRequestController::class, 'show'])
            ->name('repairs.show');

        Route::put('/repairs/{repair}/status', [AdminRepairRequestController::class, 'updateStatus'])
            ->name('repairs.update-status');

        Route::post('/repairs/{repair}/invoice', [AdminRepairRequestController::class, 'createInvoice'])
            ->name('repairs.create-invoice');
    });