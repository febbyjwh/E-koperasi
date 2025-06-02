<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/modal', [ModalController::class, 'index'])->name('modal');

// Admin (Anggota)
Route::prefix('kelola_anggota')->name('kelola_anggota.')->group(function () {
    Route::get('/', [AnggotaController::class, 'index'])->name('kelola_anggota');
    Route::get('/create', [AnggotaController::class, 'create'])->name('create');
});

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');