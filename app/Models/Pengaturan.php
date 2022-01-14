<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_toko',
        'nama_aplikasi',
        'alamat',
        'pengingat_stok'
    ];
}
