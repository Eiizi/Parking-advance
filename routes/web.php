<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingTicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route public
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Rute Logout if logut
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route must login
Route::middleware('auth')->group(function () {
    
    // Route cashier (user)
    Route::get('/', [ParkingTicketController::class, 'index'])->name('parking.index');
    Route::post('/check-in', [ParkingTicketController::class, 'checkIn'])->name('parking.checkin');
    Route::post('/check-out', [ParkingTicketController::class, 'checkOut'])->name('parking.checkout');

    // Route Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/transaksi', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::get('/admin/laporan', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/pegawai', [AdminController::class, 'employees'])->name('admin.employees');

    //crud admin
    Route::get('/admin/pegawai/tambah', [AdminController::class, 'createEmployee'])->name('admin.employees.create');
    Route::post('/admin/pegawai', [AdminController::class, 'storeEmployee'])->name('admin.employees.store');
    Route::delete('/admin/pegawai/{id}', [AdminController::class, 'destroyEmployee'])->name('admin.employees.destroy');
    Route::get('/admin/laporan/export', [AdminController::class, 'exportExcel'])->name('admin.laporan.export');

});