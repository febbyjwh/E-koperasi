<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PelunasanController;


Route::get('/', [AuthController::class, 'formlogin'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::prefix('auth')->name('auth.')->group(function () {
    // Auth
    Route::post('/', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'store'])->name('store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['isAdmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Modal Utama
    Route::prefix('modal')->name('modal.')->group(function () {
        Route::get('/', [ModalController::class, 'index'])->name('index');
        Route::get('/create', [ModalController::class, 'create'])->name('create');
        Route::post('/', [ModalController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ModalController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ModalController::class, 'update'])->name('update');
        Route::delete('/{id}', [ModalController::class, 'destroy'])->name('destroy');
    });

    // Kelola Anggota
    Route::prefix('kelola_anggota')->name('kelola_anggota.')->group(function () {
        Route::get('/', [AnggotaController::class, 'index'])->name('kelola_anggota');
        Route::get('/create', [AnggotaController::class, 'create'])->name('create');
        Route::post('/', [AnggotaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AnggotaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AnggotaController::class, 'update'])->name('update');
        Route::delete('/{id}', [AnggotaController::class, 'destroy'])->name('destroy');
    });

    // Pelunasan anggota
    Route::prefix('pelunasan_anggota')->name('pelunasan_anggota.')->group(function () {
        Route::get('/', [PelunasanController::class, 'index'])->name('index');
        Route::get('/create', [PelunasanController::class, 'create'])->name('create');
        Route::post('/', [PelunasanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PelunasanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PelunasanController::class, 'update'])->name('update');
        Route::delete('/{id}', [PelunasanController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/konfirmasi', [PelunasanController::class, 'konfirmasi'])->name('konfirmasi');
    });
});

// Pengajuan pinjaman
Route::prefix('pengajuan_pinjaman')->name('pengajuan_pinjaman.')->group(function () {
    Route::get('/', [PengajuanController::class, 'index'])->name('index');
    Route::get('/create', [PengajuanController::class, 'create'])->name('create');
    Route::post('/', [PengajuanController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PengajuanController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PengajuanController::class, 'update'])->name('update');
    Route::delete('/{id}', [PengajuanController::class, 'destroy'])->name('destroy');
    Route::patch('/{id}/konfirmasi', [PengajuanController::class, 'konfirmasi'])->name('konfirmasi');
});

// Role Anggota
// Anggota
Route::middleware(['isAnggota'])->group(function () {
    Route::prefix('anggota')->name('anggota.')->group(function () {
        Route::get('/home', [AnggotaController::class, 'index_anggota'])->name('anggota');
    });
});
