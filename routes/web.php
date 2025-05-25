<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('admin/', [ModalController::class, 'index'])->name('modal');
Route::get('anggota/', [AnggotaController::class, 'index'])->name('anggota');

Route::get('/regist', [AuthController::class, 'index'])->name('regist');