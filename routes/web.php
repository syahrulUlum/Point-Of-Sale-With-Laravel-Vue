<?php

use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\TransaksiDetailController;

Auth::routes();

Route::get('transaksi', [TransaksiController::class, 'index'])->middleware(['auth', 'role:admin|kasir'])->name('transaksi.index');

Route::get('barang', [BarangController::class, 'index'])->middleware(['auth', 'role:admin|staff_gudang'])->name('barang.index');

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('pengaturan/{pengaturan}', [PengaturanController::class, 'update'])->name('pengaturan.update');

    Route::get('detail_transaksi', [TransaksiDetailController::class, 'index'])->name('detail_transaksi.index');

    Route::get('pengguna', [UserController::class, 'index'])->name('pengguna.index');

    Route::get('notifikasi', [HomeController::class, 'notifikasi'])->name('notifikasi');
});
