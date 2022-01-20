<?php

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiDetailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('kategori', KategoriController::class, [
    'only' => ['index', 'store', 'destroy']
]);

Route::get('barang', [BarangController::class, 'api'])->name('barang.api');
Route::resource('barang', BarangController::class, [
    'except' => ['index', 'show', 'edit', 'create']
]);

Route::get('transaksi', [TransaksiController::class, 'api'])->name('transaksi.api');
Route::post('transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

Route::get('detail_transaksi', [TransaksiDetailController::class, 'api'])->name('detail_transaksi.api');
Route::delete('detail_transaksi/{detail_transaksi}', [TransaksiDetailController::class, 'destroy'])->name('detail_transaksi.destroy');
