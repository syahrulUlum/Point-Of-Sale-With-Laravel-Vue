@extends('layouts.main')
@section('content')
    <div class="container" id="dataBarang">
        <div class="card card-primary card-tabs shadow">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs ml-1" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="barang-tab" data-toggle="pill" href="#barang" role="tab"
                            aria-controls="barang" aria-selected="true">Barang <span
                                class="right badge badge-danger ml-2">@{{ datas . length }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="kategori-tab" data-toggle="pill" href="#kategori" role="tab"
                            aria-controls="kategori" aria-selected="false">Kategori <span
                                class="right badge badge-danger ml-2">@{{ kategoris . length }}</span></a>
                    </li>


                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <!-------- Barang ------->
                    <div class="tab-pane fade show active" id="barang" role="tabpanel" aria-labelledby="barang">
                        <button type="button" class="btn btn-primary mb-2" @click="tambah_barang()">Tambah Barang</button>
                        <table id="barangTable" class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th style="width:5%">No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Kategori</th>
                                    <th>Diskon</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-------- End Barang ------->

                    <!-------- Kategori ------->
                    <div class="tab-pane fade" id="kategori" role="tabpanel" aria-labelledby="kategori">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#kategori_modal">
                            Tambah Kategori
                        </button>
                        <div class="row">
                            <div class="col-lg-7">
                                <table class="table table-bordered mt-2">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Nama Kategori</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(kategori, index) of kategoris">
                                            <tr>
                                                <td>@{{ index + 1 }}</td>
                                                <td>@{{ kategori . nama }}</td>
                                                <td width="10%" class="align-middle">
                                                    <button class="btn btn-danger"
                                                        @click="hapus_kategori(kategori.nama)">Hapus</button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-1"></div>
                            <div class="col-lg-3 mt-2">
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                                    Sebelum menghapus kategori, mohon periksa dulu apakah ada barang yang masuk ke kategori
                                    tersebut
                                </div>
                            </div>
                        </div>
                        <!-------- Kategori Modal ------->
                        <div class="modal fade" id="kategori_modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Tambah Kategori</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('kategori.store') }}" @submit.prevent="tambah_kategori($event)"
                                        method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="text" class="form-control" id="kategori" name="nama"
                                                placeholder="Input Kategori" required>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <!-------- End Kategori Modal ------->
                    </div>
                    <!-------- End Kategori ------->
                </div>

                <!-------- Barang Modal ------->
                <div class="modal fade" id="barang_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">@{{ actionName }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form :action="actionUrl" @submit.prevent="submit_form($event, data.id)" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="PUT" v-if="edit_status" />
                                <div class="modal-body">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control mb-2 " id="nama_barang" name="nama"
                                        v-model="data.nama" required>

                                    <label for="harga_barang">Harga</label>
                                    <input type="number" min="0" class="form-control mb-2" id="harga_barang" name="harga"
                                        v-model="data.harga" required>

                                    <label for="kategori">Kategori</label>
                                    <select name="kategori_id" id="kategori" class="form-control mb-2">
                                        <template v-for="kategori of kategoris">
                                            <option :value="kategori.id">@{{ kategori . nama }}</option>
                                        </template>
                                    </select>

                                    <label for="diskon">Diskon (untuk 1 qty)</label>
                                    <div class="form-row">
                                        <div class="col-md-5 mb-1">
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="diskon" min="0" max="100"
                                                    name="diskon" v-model="data.diskon" required>
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rp.</div>
                                                </div>
                                                <input type="number" class="form-control"
                                                    :value="convert_diskon_rupiah(data.diskon, data.harga)" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <label for="stok">Stok</label>
                                    <input type="number" min="0" class="form-control" name="stok" v-model="data.stok"
                                        id="stok" required />
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="submit" class="btn btn-primary">@{{ actionName }}</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-------- End Barang Modal ------->

            </div>
            <!-- /.card -->
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
                data: 'nama',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'harga',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'kategori.nama',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'diskon',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'stok',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                render: function(index, row, data, meta) {
                    return `
                        <a href="#" class="btn btn-info" onclick="data.edit_data(event, ${meta.row})">
                            Edit
                        </a>
                        <button class="btn btn-danger" onclick="data.hapus_barang(event, ${data.id})">
                            Delete
                        </button>
                `
                },
                orderable: false,
                width: '200px',
                class: 'text-center align-middle'
            }
        ]
        const data = new Vue({
            el: '#dataBarang',
            data: {
                kategoris: [],
                datas: [],
                data: {
                    nama: '',
                    stok: '',
                    diskon: 0,
                    harga: 0,
                },
                actionUrl: "{{ url('api/barang') }}",
                actionName: '',
                edit_status: false,
                status: ''
            },
            mounted() {
                axios.get("{{ route('kategori.index') }}").then((response) => {
                    this.kategoris = response.data
                })
                this.datatable()
            },
            methods: {
                datatable() {
                    const _this = this
                    _this.table = $('#barangTable').DataTable({
                        ajax: {
                            url: "{{ route('barang.api') }}",
                            type: 'GET'
                        },
                        columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    })
                },
                tambah_kategori(event) {
                    let kategori = {
                        nama: event.target.kategori.value
                    }
                    axios.post("{{ route('kategori.store') }}", new FormData($(event.target)[0])).then(
                        response => {
                            // ambil kembali data kategori
                            axios.get("{{ route('kategori.index') }}").then((response) => {
                                this.kategoris = response.data
                            })
                            // menutup modal, menampilkan alert, mengosongkan input value
                            $('#kategori_modal').modal('hide')
                            Swal.fire({
                                title: 'Kategori berhasil ditambahkan',
                                confirmButtonText: `Ok`,
                                confirmButtonColor: '#007bff',
                                icon: 'success'
                            })
                            event.target.kategori.value = ''
                        }).catch((error) => {
                        Swal.fire({
                            title: 'Kategori sudah ada',
                            confirmButtonText: `Ok`,
                            confirmButtonColor: '#007bff',
                            icon: 'error'
                        })
                    })
                },
                hapus_kategori(nama) {
                    Swal.fire({
                        title: 'Apakah anda akan menghapus kategori <b>' + nama + '</b> ?',
                        showCancelButton: true,
                        confirmButtonText: `Hapus`,
                        confirmButtonColor: 'red',
                        cancelButtonColor: '#2255a4',
                        icon: 'warning'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete('api/kategori/' + nama).then((
                                response) => {
                                this.kategoris = this.kategoris.filter((kategori) =>
                                    kategori.nama != nama);
                                Swal.fire('Kategori <b>' + nama + '</b> berhasil dihapus', '',
                                    'success')
                            }).catch((error) => {
                                Swal.fire({
                                    title: 'Kategori <b>' + nama +
                                        '</b> Gagal dihapus',
                                    text: 'Kategori ini sedang digunakan',
                                    confirmButtonText: `Ok`,
                                    confirmButtonColor: '#007bff',
                                    icon: 'error'
                                })
                            })
                        }
                    });
                },
                convert_diskon_rupiah(diskon, harga) {
                    return harga * (diskon / 100)
                },
                tambah_barang() {
                    this.actionName = 'Tambah Barang'
                    this.edit_status = false;
                    this.status = 'ditambahkan'
                    this.data = {
                        nama: '',
                        stok: '',
                        diskon: 0,
                        harga: 0,
                    }
                    $('#barang_modal').modal('show')
                },
                edit_data(event, row) {
                    this.data = this.datas[row];
                    this.edit_status = true;
                    this.actionName = 'Update Barang';
                    this.status = 'diubah'
                    $('#barang_modal').modal('show');
                },
                hapus_barang(event, id) {
                    Swal.fire({
                        title: 'Apakah anda akan menghapus barang ini ?',
                        showCancelButton: true,
                        confirmButtonText: `Hapus`,
                        confirmButtonColor: 'red',
                        cancelButtonColor: '#2255a4',
                        icon: 'warning'
                    }).then((response) => {
                        axios.post(this.actionUrl + '/' + id, {
                            _method: 'DELETE'
                        }).then(response => {
                            this.table.ajax.reload()
                            Swal.fire({
                                title: 'Barang berhasil dihapus',
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#007bff',
                                icon: 'success'
                            })
                        }).catch((error) => {
                            Swal.fire({
                                title: 'Barang gagal dihapus',
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#007bff',
                                icon: 'error'
                            })
                        })
                    })
                },
                submit_form(event, id) {
                    const _this = this
                    var actionUrl = !this.edit_status ? this.actionUrl : this.actionUrl + '/' + id
                    axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                        $('#barang_modal').modal('hide')
                        _this.table.ajax.reload()
                        Swal.fire({
                            title: 'Barang berhasil ' + this.status,
                            confirmButtonText: `Ok`,
                            confirmButtonColor: '#007bff',
                            icon: 'success'
                        })
                    }).catch((error) => {
                        Swal.fire({
                            title: 'Barang gagal ' + this.status,
                            confirmButtonText: `Ok`,
                            confirmButtonColor: '#007bff',
                            icon: 'error'
                        })
                    })
                }
            }
        })
    </script>
@endsection
