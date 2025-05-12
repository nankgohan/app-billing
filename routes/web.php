<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PengingatTagihanController;

// Public Routes
Route::get('/', function () {
    return view('home');
});

// Auth Routes
require __DIR__ . '/auth.php';

// Authenticated Routes (All Users)
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Redirect
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('member.dashboard');
    })->name('dashboard');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Pelanggan
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
        Route::get('/', [PelangganController::class, 'index'])->name('index');
        Route::get('/create', [PelangganController::class, 'create'])->name('create');
        Route::post('/', [PelangganController::class, 'store'])->name('store');
        Route::get('/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('edit');
        Route::put('/{pelanggan}', [PelangganController::class, 'update'])->name('update');
        Route::delete('/{pelanggan}', [PelangganController::class, 'destroy'])->name('destroy');
    });

    // Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/pembayaran', [TransaksiController::class, 'pembayaran'])->name('pembayaran');
        Route::get('/tagihan', [TransaksiController::class, 'tagihan'])->name('tagihan');
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
        Route::post('/{transaksi}/konfirmasi', [TransaksiController::class, 'sendWhatsApp'])->name('konfirmasi');
        Route::get('/{transaksi}/send-whatsapp-tagihan', [TransaksiController::class, 'sendWhatsAppTagihan'])->name('sendWhatsAppTagihan');
    });

    // Laporan (DIPINDAHKAN ke level yang sama dengan transaksi/pelanggan)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('harian', [LaporanController::class, 'harian'])->name('harian');
        Route::get('bulanan', [LaporanController::class, 'bulanan'])->name('bulanan');
    });

    // Pengaturan
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/', [PengaturanController::class, 'index'])->name('index');
        Route::get('/other-setting', [PengaturanController::class, 'otherSetting'])->name('other-setting');

        // Pengingat Tagihan
        Route::prefix('pengingat-tagihan')->name('pengingat-tagihan.')->group(function () {
            Route::get('/', [PengingatTagihanController::class, 'index'])->name('index');
            Route::post('/', [PengingatTagihanController::class, 'store'])->name('store');
            Route::put('/{id}', [PengingatTagihanController::class, 'update'])->name('update');
            Route::delete('/{id}', [PengingatTagihanController::class, 'destroy'])->name('destroy');
            Route::get('/create', [PengingatTagihanController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [PengingatTagihanController::class, 'edit'])->name('edit');
            Route::post('/{id}/toggle', [PengingatTagihanController::class, 'toggleStatus'])->name('toggle');
        });
    });
});

// Member Routes (jika ingin diaktifkan)
/*
Route::prefix('member')->middleware(['auth', 'member'])->name('member.')->group(function () {
    Route::get('/dashboard', [MemberController::class, '

    */