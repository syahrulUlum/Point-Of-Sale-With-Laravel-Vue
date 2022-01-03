<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembelianController;


Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::resource('pembelian', PembelianController::class, [
    'only' => ['index', 'store']
]);

Route::resource('barang', BarangController::class);
