@extends('layouts.main')
@section('content')
    <div class="container" id="transaksi">
        <div class="card shadow">
            <div class="card-body">
                <table id="transaksiTable" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th style="width:5%">No</th>
                            <th>Waktu Transaksi</th>
                            <th>Banyak Jenis Barang</th>
                            <th>Total Harga</th>
                            <th>Bayar</th>
                            <th>Kembalian</th>
                            <th>Kasir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="transaksi_modal">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Transaksi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover">
                            <thead>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Diskon</th>
                                <th>Total Harga</th>
                            </thead>
                            <tbody v-for="item of data.detail_transaksi">
                                <tr>
                                    <td>@{{ item.barang.nama }}</td>
                                    <td>@{{ item.qty }}</td>
                                    <td>@{{ item.diskon }}%</td>
                                    <td>@{{ item.total_harga }}</td>
                                </tr>
                            </tbody>
                        </table>
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
                data: 'waktu',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'jumlah_barang',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'total_harga',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'bayar',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'kembalian',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                data: 'users.name',
                class: 'text-center align-middle',
                orderable: true
            },
            {
                render: function(index, row, data, meta) {
                    return `
                        <a href="#" class="btn btn-info" onclick="data.detail(event, ${meta.row})">
                            Detail
                        </a>
                        <button class="btn btn-danger" onclick="data.hapus_transaksi(event, ${data.id})">
                            Hapus
                        </button>
                `
                },
                orderable: false,
                width: '200px',
                class: 'text-center align-middle'
            }
        ]

        const data = new Vue({
            el: '#transaksi',
            data: {
                datas: [],
                actionUrl: "{{ url('api/detail_transaksi') }}",
                data: {}
            },
            mounted() {
                this.datatable()
            },
            methods: {
                datatable() {
                    const _this = this
                    _this.table = $('#transaksiTable').DataTable({
                        ajax: {
                            url: "{{ route('detail_transaksi.api') }}",
                            type: 'GET'
                        },
                        columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    })
                },
                detail(event, row) {
                    this.data = this.datas[row]
                    $('#transaksi_modal').modal('show');
                },
                hapus_transaksi(event, id) {
                    Swal.fire({
                        title: 'Apakah anda akan menghapus transaksi ini ?',
                        showCancelButton: true,
                        confirmButtonText: `Hapus`,
                        confirmButtonColor: 'red',
                        cancelButtonColor: '#2255a4',
                        reverseButtons: true,
                        icon: 'warning'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post(this.actionUrl + '/' + id, {
                                _method: 'DELETE'
                            }).then(response => {
                                this.table.ajax.reload()
                                Swal.fire({
                                    title: 'Transaksi berhasil dihapus',
                                    confirmButtonText: 'Ok',
                                    confirmButtonColor: '#007bff',
                                    icon: 'success'
                                })
                            }).catch((error) => {
                                Swal.fire({
                                    title: 'Transaksi gagal dihapus',
                                    confirmButtonText: 'Ok',
                                    confirmButtonColor: '#007bff',
                                    icon: 'error'
                                })
                            })
                        }
                    })
                },
            }
        })
    </script>
@endsection
