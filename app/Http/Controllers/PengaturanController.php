<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengaturan = Pengaturan::first();
        return view('pengaturan', compact('pengaturan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengaturan  $pengaturan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengaturan $pengaturan)
    {
        $request->validate([
            'nama_aplikasi' => 'required',
            'nama_toko' => 'required',
            'alamat' => 'required',
            'pengingat_stok' => 'required'
        ]);
        $pengaturan->update($request->all());

        return redirect()->route('pengaturan.index')->with('update', true);
    }
}
