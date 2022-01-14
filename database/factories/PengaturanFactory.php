<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PengaturanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_toko' => 'POS Toko',
            'nama_aplikasi' => 'POS Aplikasi',
            'alamat' => 'Jl. POS',
            'pengingat_stok' => 3
        ];
    }
}
