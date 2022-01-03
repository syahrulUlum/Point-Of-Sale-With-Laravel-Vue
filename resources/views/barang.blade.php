@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="card card-primary card-tabs shadow">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="barang-tab" data-toggle="pill" href="#barang" role="tab"
                            aria-controls="barang" aria-selected="true">Barang <span
                                class="right badge badge-warning ml-2">20</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="kategori-tab" data-toggle="pill" href="#kategori" role="tab"
                            aria-controls="kategori" aria-selected="false">Kategori <span
                                class="right badge badge-warning ml-2">30</span></a>
                    </li>


                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <!-------- Barang ------->
                    <div class="tab-pane fade show active" id="barang" role="tabpanel" aria-labelledby="barang">
                        <a href="" class="btn btn-primary mb-3">Tambah Barang</a>
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
                            <tbody class="text-center">
                                <tr>
                                    <td class="align-middle">1</td>
                                    <td class="align-middle">
                                        <p style="color: white; background-color: #ffc107;">Draft</p>
                                    </td>
                                    <td class="align-middle">wadad</td>
                                    <td class="align-middle">
                                        Uncategory
                                    </td>
                                    <td width="10%" class="align-middle">
                                        <p class="bg-success">Barang</p>
                                    </td>
                                    <td class="align-middle">
                                        151515
                                    </td>
                                    <td width="20%" class="align-middle">
                                        <a href="/panel/post/edit/" class="btn btn-primary">Edit</a>
                                        <button class="btn btn-danger">Delete</button>
                                        <a href="/" class="btn btn-secondary">Visit</a>
                                    </td>
                                </tr>

                            </tbody>
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
                                                    <button class="btn btn-danger">Delete</button>
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
                                        <h4 class="modal-title">Add Kategori</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" @submit.prevent="tambah_kategori">
                                        <div class="modal-body">
                                            <input type="text" class="form-control" id="kategori" name="kategori"
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

            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#barangTable').DataTable();
        });
    </script>
@endsection
