@extends('layouts/main')

@section('content')
    <div class="container" id="pengguna">
        <div class="card shadow">
            <div class="card-body">
                <button class="btn btn-primary mb-4" @click="tambah_pengguna()">Tambah Pengguna</button>
                <table class="table table-bordered table-hover text-center" id="pengguna_table">
                    <thead>
                        <th width="6%">No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Posisi</th>
                        <th width="20%">Aksi</th>
                    </thead>
                </table>
            </div>
        </div>

        <!-------- Pengguna Modal ------->
        <div class="modal fade" id="pengguna_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@{{ keterangan }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form :action="actionUrl" method="post" @submit.prevent="submit_form($event, data.id)">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" v-if="edit_status" />
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control mb-2" name="nip" id="nip" required :value="data.nip" />
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control mb-2" name="nama" id="nama" required
                                :value="data.name" />
                            <label for="email">Email</label>
                            <input type="email" class="form-control mb-2" name="email" id="email" required
                                :value="data.email" />
                            <label for="posisi">Posisi</label>
                            <select class="form-control mb-2" name="posisi" id="posisi">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" :selected="data.role == '{{ $role->name }}'">
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                            <label for="kata_sandi">Kata Sandi</label>
                            <input type="text" name="password" id="kata_sandi" class="form-control mb-4"
                                :required="!edit_status" />
                            <button type="submit" class="btn btn-primary">@{{ keterangan }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>
        var columns = [{
                data: 'DT_RowIndex',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'nip',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'name',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'email',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'role',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                render: function(index, row, data, meta) {
                    return `
                        <a href="#" class="btn btn-info" onclick="pengguna.edit_data(event, ${meta.row})">
                            Ubah
                        </a>
                        <button class="btn btn-danger" onclick="pengguna.hapus_data(event, ${data.id})">
                            Hapus
                        </button>
                `
                },
                orderable: false,
                width: '200px',
                class: 'text-center align-middle'
            }
        ]
        const pengguna = new Vue({
            el: '#pengguna',
            data: {
                $datas: [],
                data: {},
                keterangan: '',
                actionUrl: "{{ url('api/pengguna') }}",
                edit_status: false,
            },
            mounted() {
                this.datatable()
            },
            methods: {
                datatable() {
                    const _this = this
                    _this.table = $('#pengguna_table').DataTable({
                        ajax: {
                            url: "{{ route('pengguna.api') }}",
                            type: 'GET'
                        },
                        columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    })
                },
                tambah_pengguna() {
                    this.keterangan = "Tambah Pengguna"
                    this.data = {}
                    this.edit_status = false
                    $('#pengguna_modal').modal('show')
                },
                hapus_data(event, id) {
                    console.log(id);
                    Swal.fire({
                        title: 'Apakah anda akan menghapus pengguna ini ?',
                        showCancelButton: true,
                        confirmButtonText: `Hapus`,
                        confirmButtonColor: 'red',
                        cancelButtonColor: '#2255a4',
                        icon: 'warning',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post(this.actionUrl + '/' + id, {
                                _method: 'DELETE'
                            }).then(response => {
                                console.log(response);
                                this.table.ajax.reload()
                                Swal.fire({
                                    title: 'Pengguna berhasil dihapus',
                                    confirmButtonText: 'Ok',
                                    confirmButtonColor: '#007bff',
                                    icon: 'success'
                                })
                            }).catch((error) => {
                                Swal.fire({
                                    title: 'Pengguna gagal dihapus',
                                    confirmButtonText: 'Ok',
                                    confirmButtonColor: '#007bff',
                                    icon: 'error'
                                })
                            })
                        }
                    })
                },
                edit_data(event, row) {
                    this.data = this.datas[row];
                    this.edit_status = true;
                    this.keterangan = 'Ubah Barang';
                    $('#pengguna_modal').modal('show');
                },
                submit_form(event, id) {
                    const _this = this
                    var actionUrl = !this.edit_status ? this.actionUrl : this.actionUrl + '/' + id
                    axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                        console.log(response);
                        this.table.ajax.reload()
                        $('#pengguna_modal').modal('hide')
                        Swal.fire({
                            title: 'Pengguna berhasil ditambahkan',
                            confirmButtonText: `Ok`,
                            confirmButtonColor: '#007bff',
                            icon: 'success'
                        })
                        this.data = {
                            password: ''
                        }
                    }).catch((error) => {
                        Swal.fire({
                            title: 'Pengguna gagal ditambahkan',
                            confirmButtonText: `Ok`,
                            confirmButtonColor: '#007bff',
                            icon: 'error'
                        })
                        this.data = {
                            password: ''
                        }
                    })
                },
            }
        })
    </script>
@endsection
