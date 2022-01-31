<?php
function invoice($transaksi, $nama_aplikasi)
{
    $jumlah_transaksi = str_pad($transaksi, 4, '0', STR_PAD_LEFT);
    $pisah_kata = explode(' ', $nama_aplikasi);
    $huruf = '';
    for ($i = 0; $i < count($pisah_kata); $i++) {
        $karakter = substr($pisah_kata[$i], 0, 1);
        $huruf .= $karakter;
    }

    return $huruf . date('Ymd') . $jumlah_transaksi;
}

function convert_rupiah($data)
{
    return "Rp. " . number_format($data, 0, '', '.');
}

function convert_date($value)
{
    return date('d M Y', strtotime($value));
}
