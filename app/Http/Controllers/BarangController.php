<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('barang');
    }

    /**
     * Show the API.
     */
    public function api()
    {
        $barangs = Barang::with('kategori')->orderBy('id', 'desc')->get();

        $datatables = datatables()->of($barangs)->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|min:0',
            'kategori_id' => 'required',
            'diskon' => 'required|min:0|max:100',
            'stok' => 'required|min:0'
        ]);

        Barang::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|min:0',
            'kategori_id' => 'required',
            'diskon' => 'required|min:0|max:100',
            'stok' => 'required|min:0'
        ]);
        $barang->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
    }
}
