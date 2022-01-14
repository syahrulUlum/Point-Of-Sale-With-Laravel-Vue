@extends('layouts/main')

@section('content')
    <div class="container-fluid">
        <div class="card shadow" style="width:50%;">
            <form action="{{ route('pengaturan.update', $pengaturan->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card-body">
                    <label for="nama_aplikasi">Nama Aplikasi</label>
                    <input type="text" name="nama_aplikasi" id="nama_aplikasi" value="{{ $pengaturan->nama_aplikasi }}"
                        class="form-control mb-2" required />
                    <label for="nama_toko">Nama Toko</label>
                    <input type="text" name="nama_toko" id="nama_toko" value="{{ $pengaturan->nama_toko }}"
                        class="form-control mb-2" required />
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control mb-2"
                        required>{{ $pengaturan->alamat }}</textarea>
                    <label for="pengingat_stok">Notifikasi Ketika Stok Kurang dari : </label>
                    <input type="text" name="pengingat_stok" id="pengingat_stok" value="{{ $pengaturan->pengingat_stok }}"
                        class="form-control mb-4" required />
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>


@endsection
@section('js')
    @if (session('update'))
        <script>
            Swal.fire({
                title: 'Pengaturan berhasil disimpan',
                confirmButtonText: `Ok`,
                confirmButtonColor: '#007bff',
                icon: 'success'
            })
        </script>
    @endif
@endsection
