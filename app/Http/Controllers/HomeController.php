<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pengaturan;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hari_ini = Transaksi::select(DB::raw('SUM(total_harga) as total'), DB::raw('DATE(created_at) as date'))
            ->groupBy('date')
            ->whereDate('created_at', Carbon::today())
            ->first();

        $bulan_ini = Transaksi::select(DB::raw('SUM(total_harga) as total'), DB::raw('MONTH(created_at) as month'))
            ->groupBy('month')
            ->whereMonth('created_at', date('m'))
            ->first();

        $barang_terjual = TransaksiDetail::select(DB::raw('SUM(qty) as total'), DB::raw('DATE(created_at) as date'))
            ->groupBy('date')
            ->whereDate('created_at', Carbon::today())
            ->first();

        $barang_habis = Barang::where('stok', 0)->get();

        $statistik_pendapatan = Transaksi::select(DB::raw('SUM(total_harga) as total'), DB::raw('DATE(created_at) as date'))
            ->groupBy('date')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();

        $data_statistik = [];
        foreach ($statistik_pendapatan as $pendapatan) {
            array_push($data_statistik, $pendapatan->total);
        }

        $data_barang_dijual = TransaksiDetail::select(DB::raw('SUM(qty) as total'), 'barangs.nama')
            ->join('barangs', 'barangs.id', '=', 'transaksi_details.barang_id')
            ->groupBy('barangs.nama')
            ->whereMonth('transaksi_details.created_at', date('m'))
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->get();

        $label_barang_dijual = [];
        $banyak_barang_dijual = [];
        foreach ($data_barang_dijual as $barang) {
            array_push($label_barang_dijual, $barang->nama);
            array_push($banyak_barang_dijual, $barang->total);
        }

        $data_barang_diminati = TransaksiDetail::select(DB::raw('count(barang_id) as barang'), 'barangs.nama')
            ->join('barangs', 'barangs.id', '=', 'transaksi_details.barang_id')
            ->groupBy('barangs.nama')
            ->whereMonth('transaksi_details.created_at', date('m'))
            ->orderBy('barang', 'DESC')
            ->limit(10)
            ->get();

        $label_barang_diminati = [];
        $banyak_barang_diminati = [];
        foreach ($data_barang_diminati as $barang) {
            array_push($label_barang_diminati, $barang->nama);
            array_push($banyak_barang_diminati, $barang->barang);
        }

        return view('dashboard', compact('hari_ini', 'bulan_ini', 'barang_terjual', 'barang_habis', 'data_statistik', 'label_barang_dijual', 'banyak_barang_dijual', 'label_barang_diminati', 'banyak_barang_diminati'));
    }

    public function notifikasi()
    {
        $batas_notif = Pengaturan::first();
        $data_notif = Barang::where('stok', '<=', $batas_notif->pengingat_stok)->get();
        return view('notifikasi', compact('data_notif'));
    }
}
