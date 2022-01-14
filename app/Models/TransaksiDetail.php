<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'transaksi_id',
        'qty',
        'diskon',
        'total_harga'
    ];
}
