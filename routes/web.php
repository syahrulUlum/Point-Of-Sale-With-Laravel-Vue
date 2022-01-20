<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiDetailController;

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');

    Route::get('barang', [BarangController::class, 'index'])->name('barang.index');

    Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('pengaturan/{pengaturan}', [PengaturanController::class, 'update'])->name('pengaturan.update');

    Route::get('detail_transaksi', [TransaksiDetailController::class, 'index'])->name('detail_transaksi.index');
});
