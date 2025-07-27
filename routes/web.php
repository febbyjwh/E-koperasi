<?php

use App\Events\DataAnggotaUpdate;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TabunganWajibController;
use App\Http\Controllers\TabunganManasukaController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PelunasanController;
use App\Http\Controllers\LaporanController;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Controllers\PinjamanAnggotaController;
use App\Http\Controllers\CicilanAnggotaController;
use App\Http\Controllers\TabWajibAnggotaController;
use App\Http\Controllers\TabManasukaAnggotaController;
use Pusher\Pusher;

Route::get('/', [AuthController::class, 'formlogin'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::prefix('auth')->name('auth.')->group(function () {
    // Auth
    Route::post('/', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'store'])->name('store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['isAdmin'])->group(function () {
    // DataAnggotaUpdate::dispatch('lorem ipsum dolor sit amet');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/simulasi', [SimulasiController::class, 'calculate'])->name('simulasi.calculate');
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

    // Tabungan Wajib
    Route::prefix('tabungan_wajib')->name('tabungan_wajib.')->group(function () {
        Route::get('/', [TabunganWajibController::class, 'index'])->name('tabungan_wajib');
        Route::get('/create', [TabunganWajibController::class, 'create'])->name('create');
        Route::post('/', [TabunganWajibController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TabunganWajibController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TabunganWajibController::class, 'update'])->name('update');
        Route::delete('/{id}', [TabunganWajibController::class, 'destroy'])->name('destroy');
    });

    // Tabungan Manasuka
    Route::prefix('tabungan_manasuka')->name('tabungan_manasuka.')->group(function () {
        Route::get('/', [TabunganManasukaController::class, 'index'])->name('tabungan_manasuka');
        Route::get('/create', [TabunganManasukaController::class, 'create'])->name('create');
        Route::post('/', [TabunganManasukaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TabunganManasukaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TabunganManasukaController::class, 'update'])->name('update');
        Route::delete('/{id}', [TabunganManasukaController::class, 'destroy'])->name('destroy');
    });

    // Pelunasan anggota
    Route::prefix('pelunasan_anggota')->name('pelunasan_anggota.')->group(function () {
        Route::get('/', [PelunasanController::class, 'index'])->name('index');
        Route::get('/create', [PelunasanController::class, 'create'])->name('create');
        Route::post('/', [PelunasanController::class, 'store'])->name('store');
        Route::get('/{id}', [PelunasanController::class, 'show'])->name('show');
        Route::post('/{id}/bayar', [PelunasanController::class, 'bayar'])->name('bayar');
        Route::get('/{id}/edit', [PelunasanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PelunasanController::class, 'update'])->name('update');
        Route::get('/{id}/invoice', [PelunasanController::class, 'invoice'])->name('invoice');
        Route::get('/{id}/invoicepdf', [PelunasanController::class, 'exportPdfInvoice'])->name('invoicepdf');
        Route::delete('/{id}', [PelunasanController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/konfirmasi', [PelunasanController::class, 'konfirmasi'])->name('konfirmasi');
    });

    // Pengajuan pinjaman
    Route::prefix('pengajuan_pinjaman')->name('pengajuan_pinjaman.')->group(function () {
        Route::get('/', [PengajuanController::class, 'index'])->name('index');
        Route::get('/create', [PengajuanController::class, 'create'])->name('create');
        Route::post('/', [PengajuanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PengajuanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PengajuanController::class, 'update'])->name('update');
        Route::delete('/{id}', [PengajuanController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/invoice', [PengajuanController::class, 'invoice'])->name('invoice');
        Route::get('/{id}/invoicepdf', [PengajuanController::class, 'exportPdfInvoice'])->name('invoicepdf');
        Route::patch('/{id}/konfirmasi', [PengajuanController::class, 'konfirmasi'])->name('konfirmasi');
    });

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/neraca', [LaporanController::class, 'neraca'])->name('neraca');
        Route::get('/arus_kas', [LaporanController::class, 'arusKas'])->name('arus_kas');
        Route::get('/shu', [LaporanController::class, 'laporanSHU'])->name('shu');
        Route::get('/anggota', [LaporanController::class, 'anggota']);
        
        // Export
        Route::get('/neraca/export-pdf', [LaporanController::class, 'exportNeracaPdf'])->name('exportpdf');
        Route::get('/export/excel/{jenis}', [LaporanController::class, 'exportExcel'])->name('exportexcel');
        Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcelArusKas'])->name('exportexcelaruskas');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdfArusKas'])->name('exportpdfaruskas');
        Route::get('/laporan/shu-pdf', [LaporanController::class, 'exportPdfShu'])->name('laporan.exportpdfshu');
        Route::get('/laporan/shu-excel', [LaporanController::class, 'exportPdfShu'])->name('laporan.exportshu');

    });
});


// Role Anggota
// Anggota
Route::middleware(['isAnggota'])->group(function () {
    Route::prefix('anggota')->name('anggota.')->group(function () {
        Route::get('/home', [AnggotaController::class, 'index_anggota'])->name('anggota');
    });

    Route::prefix('pinjaman_anggota')->name('pinjaman_anggota.')->group(function () {
        Route::get('/', [PinjamanAnggotaController::class, 'index'])->name('index');
        Route::get('/create', [PinjamanAnggotaController::class, 'create'])->name('create');
        Route::post('/', [PinjamanAnggotaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PinjamanAnggotaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PinjamanAnggotaController::class, 'update'])->name('update');
        Route::get('/{id}/bukti', [PengajuanController::class, 'invoice'])->name('bukti');
        Route::get('/{id}/bukti-pdf', [PengajuanController::class, 'exportPdfInvoice'])->name('bukti_pdf');     
        Route::delete('/{id}', [PinjamanAnggotaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('cicilan_anggota')->name('cicilan_anggota.')->group(function () {
        Route::get('/', [CicilanAnggotaController::class, 'index'])->name('index');
        Route::get('/create', [CicilanAnggotaController::class, 'create'])->name('create');
        Route::post('/', [CicilanAnggotaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CicilanAnggotaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CicilanAnggotaController::class, 'update'])->name('update');
        Route::get('/cicilan_anggota/pelunasan_anggota/{id}', [PelunasanController::class, 'show'])->name('pelunasan_anggota.show');    
        Route::get('/pelunasan/{id}/bukti', [PelunasanController::class, 'invoice'])->name('bukti');
        Route::get('/pelunasan/{id}/bukti-pdf', [PelunasanController::class, 'exportPdfInvoice'])->name('bukti_pdf');     
        Route::delete('/{id}', [CicilanAnggotaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('tab_wajib_anggota')->name('tab_wajib_anggota.')->group(function () {
        Route::get('/', [TabWajibAnggotaController::class, 'index'])->name('index');
        Route::get('/create', [TabWajibAnggotaController::class, 'create'])->name('create');
        Route::post('/', [TabWajibAnggotaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TabWajibAnggotaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TabWajibAnggotaController::class, 'update'])->name('update');
        Route::delete('/{id}', [TabWajibAnggotaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('tab_manasuka_anggota')->name('tab_manasuka_anggota.')->group(function () {
        Route::get('/', [TabManasukaAnggotaController::class, 'index'])->name('index');
        Route::get('/create', [TabManasukaAnggotaController::class, 'create'])->name('create');
        Route::post('/', [TabManasukaAnggotaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TabManasukaAnggotaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TabManasukaAnggotaController::class, 'update'])->name('update');
        Route::delete('/{id}', [TabManasukaAnggotaController::class, 'destroy'])->name('destroy');
    });
});
