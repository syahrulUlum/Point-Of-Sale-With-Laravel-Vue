<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = DB::table('roles')->get();

        return view('pengguna', compact('roles'));
    }

    public function api(Request $request)
    {
        if (isset($request->filter_posisi)) {
            $pengguna = User::select('users.id', 'users.nip', 'users.name', 'users.email', 'roles.name as role')
                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.name', $request->filter_posisi)
                ->get();
        } else {
            $pengguna = User::select('users.id', 'users.nip', 'users.name', 'users.email', 'roles.name as role')
                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->get();
        }

        foreach ($pengguna as $data_pengguna) {
            if ($data_pengguna->role == 'admin') {
                $data_pengguna->posisi = 'Admin';
            } else if ($data_pengguna->role == 'kasir') {
                $data_pengguna->posisi = 'Kasir';
            } else {
                $data_pengguna->posisi = 'Staff Gudang';
            }
        }

        $datatables = datatables()->of($pengguna)->addIndexColumn();

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
        $data = [
            'nip' => $request->nip,
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ];

        $user = User::create($data);

        $user->assignRole($request->posisi);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [
            'nip' => $request->nip,
            'name' => $request->nama,
            'email' => $request->email,
        ];
        if ($request->password) {
            $data += ['password' => bcrypt($request->password)];
        }
        $user = User::find($id);
        $user->update($data);
        $user->syncRoles($request->posisi);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
