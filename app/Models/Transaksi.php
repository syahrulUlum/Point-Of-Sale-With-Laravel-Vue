<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'invoice',
        'total_harga',
        'bayar',
        'kembalian'
    ];

    public function detail_transaksi()
    {
        return $this->hasMany('App\Models\TransaksiDetail', 'transaksi_id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
