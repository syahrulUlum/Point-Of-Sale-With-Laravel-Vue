<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'stok',
        'harga',
        'kategori_id',
        'diskon'
    ];

    public function kategori()
    {
        return $this->belongsTo('App\Models\Kategori', 'kategori_id');
    }
}
