<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaksi');
    }

    public function api()
    {
        $barangs = Barang::select('id', 'nama', 'harga', 'stok', 'diskon')
            ->where('stok', '>', 0)->get();

        foreach ($barangs as $barang) {
            $barang->qty = 1;
        }

        return response()->json($barangs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = [
            'user_id' => $request->user_id,
            'total_harga' => $request->total_harga,
            'bayar' => $request->bayar,
            'kembalian' => $request->kembalian
        ];

        $keranjang = $request->keranjang;

        // cek apakah pembelian tidak lebih dari stok
        for ($i = 0; $i < count($keranjang); $i++) {
            if ($keranjang[$i]['qty'] > $keranjang[$i]['stok']) {
                return response()->json(['Gagal' => $keranjang[$i]['nama']]);
                break;
            }
        }

        $transaksi = Transaksi::create($data);

        for ($j = 0; $j < count($keranjang); $j++) {
            $data = [
                'barang_id' => $keranjang[$j]['id'],
                'transaksi_id' => $transaksi->id,
                'qty' => $keranjang[$j]['qty'],
                'diskon' => $keranjang[$j]['diskon'],
                'total_harga' => $keranjang[$j]['total_harga']
            ];
            TransaksiDetail::create($data);

            // Kurangi stok barang
            Barang::select('*')
                ->where('id', $keranjang[$j]['id'])
                ->decrement('stok', $keranjang[$j]['qty']);
        }
    }
}
