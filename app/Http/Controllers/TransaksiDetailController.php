<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('detail_transaksi');
    }

    public function api()
    {
        $transaksis = Transaksi::with('detail_transaksi', 'users', 'detail_transaksi.barang')->orderBy('id', 'desc')->get();

        foreach ($transaksis as $transaksi) {
            $transaksi->jumlah_barang = count($transaksi->detail_transaksi);
            $transaksi->waktu = date('d/m/Y  H:i', strtotime($transaksi->created_at));
        }

        $datatables = datatables()->of($transaksis)->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransaksiDetail  $transaksiDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = Transaksi::where('id', $id)->first();
        $hapus->delete();
    }
}
