<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembelianController;

Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::resource('pembelian', PembelianController::class, [
    'only' => ['index', 'store']
]);
