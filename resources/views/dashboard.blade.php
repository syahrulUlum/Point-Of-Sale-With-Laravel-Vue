@extends('layouts/main')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pendapatan hari ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $hari_ini ? convert_rupiah($hari_ini->total) : 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-coins fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pendapatan bulan ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $bulan_ini ? convert_rupiah($bulan_ini->total) : 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-coins fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Barang terjual hari ini
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ $barang_terjual ? $barang_terjual->total : 0 }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Barang Habis</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($barang_habis) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box-open fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Penjualan Barang Terbanyak -->
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Banyak barang yang terjual bulan ini</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <canvas id="chart-line"></canvas>
                    </div>
                </div>
            </div>
            <!-- Penjualan Barang Paling Diminati -->
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Banyak barang yang diminati bulan ini</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <canvas id="chart-line2"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Pendapatan -->
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Pendapatan Harian</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection
@section('js')
    <script>
        var data_statistik = '{!! json_encode($data_statistik) !!}';
        var label_barang_dijual = '{!! json_encode($label_barang_dijual) !!}'
        var banyak_barang_dijual = '{!! json_encode($banyak_barang_dijual) !!}'
        var label_barang_diminati = '{!! json_encode($label_barang_diminati) !!}'
        var banyak_barang_diminati = '{!! json_encode($banyak_barang_diminati) !!}'
    </script>
    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/js/demo/chart-area.js') }}"></script>
    <script src="{{ asset('assets/js/demo/chart-pie.js') }}"></script>
@endsection
