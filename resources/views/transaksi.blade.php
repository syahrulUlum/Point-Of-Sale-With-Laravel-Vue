@extends('layouts/main')

@section('content')
    <div class="container-fluid" id="app">
        <div class="row">
            <!-- Detail -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addDataModal"><i
                                class="fas fa-shopping-cart"></i> Add
                            Data</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered text-dark" width="100%" cellspacing="0">
                            <thead class="text-center">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Diskon</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(barang, index) of keranjang" v-if="keranjang">
                                    <tr>
                                        <td>@{{ index + 1 }}</td>
                                        <td>@{{ barang.nama }}</td>
                                        <td align="center">@{{ convert_harga(barang.harga) }}</td>
                                        <td width="15%"><input type="number" min="0" :max="barang.stok"
                                                class="form-control" v-model="barang.qty" />
                                        </td>
                                        <td align="center">@{{ barang.diskon }}%</td>
                                        <td align="center">
                                            @{{ convert_harga(total_harga_barang_tabel(index + 1, barang.harga, barang.qty, barang.diskon)) }}
                                        </td>
                                        <td align="center"><button class="btn btn-danger"
                                                @click="hapus_barang(barang.id)"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>

                        </table>
                    </div>
                </div>
                <!-- End Detail -->
            </div>
            <!-- COL FOR PROFIL -->
            <div class="col-md-4">
                <div class="card shadow border-top-primary text-dark">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="tanggal">Tanggal</label>
                            </div>
                            <div class="col-md-8">
                                <p>{!! Carbon\Carbon::now()->isoFormat('D MMMM Y') !!}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="tanggal">Kasir</label>
                            </div>
                            <div class="col-md-8">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="tanggal">NIP</label>
                            </div>
                            <div class="col-md-8">
                                {{ Auth::user()->NIP }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Invoice -->
                <div class="card shadow border-top-primary mt-2">
                    <div class="card-body text-right">
                        <h5>Invoice <b class="text-dark">{{ $invoice }}</b></h5>
                        <p style="font-size: 60px; margin-bottom: 8px; font-weight: bold;" class="text-dark">
                            @{{ convert_harga(total_harga()) }}</p>
                    </div>
                </div>
                <!-- Cash -->
                <div class="card shadow border-top-primary text-dark mt-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="bayar">Bayar</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class="form-control" v-model="bayar" />
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="kembalian">Kembalian</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" :value="convert_harga(kembalian())" disabled />
                            </div>
                        </div>

                    </div>
                </div>
                <!-- button -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <button class="btn btn-secondary" style="width: 100%; height: 55px;" @click="reset()">Reset</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary" style="width: 100%; height: 55px;"
                            :disabled="kembalian() < 0 ? true : false" @click="kirim_ke_database()">Selesai</button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current
                        session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Data Modal-->
        <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Data</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" @submit.prevent="tambah_data">
                        <div class="modal-body">
                            <label>Nama Barang</label>
                            <select name="id" class="form-control mb-2" v-model="pilih_barang">
                                <template v-for="barang of data_barang">
                                    <option :value="barang.id" v-if="!cek_keranjang(barang.id)">
                                        @{{ barang.nama }}</option>
                                </template>
                            </select>
                            <input type="hidden" name="nama" :value="barang_dipilih().nama" />
                            <label>Harga Barang</label>
                            <input type="text" class="form-control mb-2" :value="convert_harga(barang_dipilih().harga)"
                                disabled name="harga" />
                            <label>Qty</label>
                            <input type="number" class="form-control mb-2" v-model="barang_dipilih().qty" min="0"
                                :max="barang_dipilih().stok" name="qty" />
                            <label>Stok</label>
                            <input type="text" class="form-control mb-2" disabled :value="barang_dipilih().stok"
                                name="stok" />
                            <label>Diskon</label>
                            <input type="text" class="form-control mb-2" disabled :value="barang_dipilih().diskon + '%'"
                                name="diskon" />
                            <label>Total Harga</label>
                            <input type="text" class="form-control mb-2"
                                :value="total_harga_barang_modal(barang_dipilih().harga, barang_dipilih().qty, barang_dipilih().diskon)"
                                name="total_harga" disabled />
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" :disabled="barang_dipilih().id == 0">Add
                                Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- For Print -->
        <div id="print" style="display: none;">
            <table border="0" cellspacing="10" width="45%">
                <tr>
                    <td colspan="5" align="center">
                        <h2 style="font-weight: bold;">UPStore</h2>
                        <p>Jl. Parungpung - pamarayan</p>
                        <hr style="margin-top: 7px;" />
                    </td>
                </tr>
                <tr>
                    <td colspan="5" align="center">{{ $invoice }}</td>
                </tr>
                <tr>
                    <td width="50%">{{ date('d/m/Y H:i') }}</td>
                    <td width="20%"></td>
                    <td align="right">Kasir</td>
                    <td align="center">:</td>
                    <td align="center">{{ Auth::user()->name }}</td>
                </tr>
                <tr>
                    <td colspan="5">
                        <hr />
                    </td>
                </tr>
                <template v-for="(barang, index) of keranjang">
                    <tr>
                        <td>@{{ barang.nama }}</td>
                        <td>@{{ barang.qty }}</td>
                        <td align="right">@{{ barang.harga }}</td>
                        <td></td>
                        <td align="right">
                            @{{ convert_harga(barang.qty * barang.harga) }}
                        </td>
                    </tr>
                    <template v-if="barang.diskon > 0">
                        <tr>
                            <td></td>
                            <td></td>
                            <td align="right">Diskon</td>
                            <td>@{{ barang.diskon }}%</td>
                            <td align="right">
                                @{{ convert_harga(barang.qty * (barang.harga * barang.diskon / 100)) }}</td>
                        </tr>
                    </template>
                </template>
                <tr>
                    <td colspan="5">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="right">Total</td>
                    <td></td>
                    <td align="right">@{{ convert_harga(total_harga()) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="3">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="right">Bayar</td>
                    <td></td>
                    <td align="right">@{{ convert_harga(bayar) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="right">Kembalian</td>
                    <td></td>
                    <td align="right">@{{ convert_harga(kembalian()) }}</td>
                </tr>
                <tr>
                    <td colspan="5">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td colspan="5" align="center">TERIMA KASIH</td>
                </tr>

            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const vm = new Vue({
            el: "#app",
            data: {
                data_barang: [],
                keranjang: [],
                pilih_barang: 0,
                data_harga: [],
                bayar: 0,
                kembali: 0
            },
            mounted() {
                axios.get("{{ route('transaksi.api') }}").then((response) => {
                    this.data_barang = response.data
                })
            },
            methods: {
                reset() {
                    this.keranjang.splice(this.keranjang);
                    this.data_harga.splice(this.data_harga);
                },
                total_harga_barang_tabel(index, harga = 0, qty = 0, diskon = 0) {
                    let hasil = qty * harga - (qty * harga * diskon) / 100;

                    if (qty <= 0) {
                        hasil = 0;
                    }
                    this.data_harga[index] = parseInt(hasil);

                    return hasil;
                },
                total_harga_barang_modal(harga = 0, qty = 0, diskon = 0) {
                    let hasil = qty * harga - (qty * harga * diskon) / 100;

                    if (qty <= 0) {
                        hasil = 0;
                    }

                    return hasil;
                },
                hapus_barang(id) {
                    this.keranjang = this.keranjang.filter((barang) => barang.id != id);
                    this.data_harga.splice(0);
                },
                total_harga() {
                    return this.data_harga.reduce((a, b) => a + b, 0);
                },
                kembalian() {
                    var kembalian = this.bayar - this.total_harga()
                    this.kembali = kembalian
                    return kembalian
                },
                convert_harga(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                },
                barang_dipilih() {
                    var filter_barang = this.data_barang.find(
                        (o) => o.id == this.pilih_barang
                    );
                    if (filter_barang) {
                        return filter_barang;
                    } else {
                        return {
                            id: 0,
                            nama: "",
                            harga: 0,
                            stok: 0,
                            qty: 0,
                            diskon: 0,
                        };
                    }
                },
                cek_keranjang(id) {
                    var filter_keranjang = this.keranjang.find((o) => o.id == id);
                    if (filter_keranjang) {
                        return true;
                    } else {
                        return false;
                    }
                },
                tambah_data(data) {
                    var harga = data.target.elements.harga.value.replace(
                        /[^\w\s]/gi,
                        ""
                    );
                    var total_harga = data.target.elements.total_harga.value.replace(
                        /[^\w\s]/gi,
                        ""
                    );

                    var input = {
                        id: parseInt(data.target.elements.id.value),
                        nama: data.target.elements.nama.value,
                        harga: parseInt(harga),
                        stok: parseInt(data.target.elements.stok.value),
                        qty: parseInt(data.target.elements.qty.value),
                        diskon: parseInt(data.target.elements.diskon.value),
                        total_harga: parseInt(data.target.elements.total_harga.value)
                    };
                    this.keranjang.unshift(input);
                    $("#addDataModal").modal("hide");
                    this.pilih_barang = 0;
                },
                print() {
                    var printContents = document.getElementById("print").innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    location.reload();
                },
                kirim_ke_database() {
                    let keranjang = this.keranjang
                    let bayar = parseInt(this.bayar)
                    let kembalian = this.kembali
                    let total_harga = this.total_harga()
                    let _token = "{{ Session::token() }}"
                    let user_id = "{{ Auth::user()->id }}"
                    let invoice = "{{ $invoice }}"

                    let data = {
                        _token,
                        user_id,
                        invoice,
                        bayar,
                        kembalian,
                        total_harga,
                        keranjang
                    }

                    Swal.fire({
                        title: 'Apakah pesanan sudah benar?',
                        showCancelButton: true,
                        cancelButtonText: '<b>Check lagi</b>',
                        confirmButtonText: `<b>Ok</b>`,
                        confirmButtonColor: '#2255a4',
                        cancelButtonColor: '#6c757d',
                        reverseButtons: true,
                        icon: 'warning'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post("{{ route('transaksi.store') }}", data).then((response) => {
                                if (response['data']['Gagal']) {
                                    Swal.fire({
                                        title: 'Stok <b>' + response['data']['Gagal'] +
                                            '</b> tidak cukup',
                                        confirmButtonText: `Ok`,
                                        confirmButtonColor: '#007bff',
                                        icon: 'error'
                                    })
                                } else {
                                    this.print()
                                }
                            })
                        }
                    })

                }
            },
        });
    </script>
@endsection
