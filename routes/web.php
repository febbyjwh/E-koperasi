<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;


Route::middleware(['isAdmin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/modal', [ModalController::class, 'index'])->name('modal');
});

// Admin (Anggota)
Route::prefix('kelola_anggota')->name('kelola_anggota.')->group(function () {
    Route::get('/', [AnggotaController::class, 'index'])->name('kelola_anggota');
    Route::get('/create', [AnggotaController::class, 'create'])->name('create');
});

// Auth
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'formlogin'])->name('formlogin');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
