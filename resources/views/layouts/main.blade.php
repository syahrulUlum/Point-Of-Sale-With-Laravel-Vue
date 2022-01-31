@php
$pengaturan = \App\Models\Pengaturan::first();
$notif_barang = \App\Models\Barang::where('stok', '<=', $pengaturan->pengingat_stok)
    ->orderBy('updated_at', 'DESC')
    ->get();
@endphp
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $pengaturan->nama_aplikasi }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Datatables -->
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @yield('css')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{ $pengaturan->nama_toko }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item {{ request()->is('transaksi') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('transaksi') }}">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Transaksi</span></a>
            </li>

            <li class="nav-item {{ request()->is('barang') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('barang') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Barang</span></a>
            </li>
            <li class="nav-item {{ request()->is('detail_transaksi') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('detail_transaksi') }}">
                    <i class="fas fa-fw fa-clipboard"></i>
                    <span>Detail Transaksi</span></a>
            </li>
            <li class="nav-item {{ request()->is('pengguna') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('pengguna') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Pengguna</span></a>
            </li>
            <li class="nav-item {{ request()->is('pengaturan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('pengaturan') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Pengaturan</span></a>
            </li>


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                @if (count($notif_barang) > 0)
                                    @if (count($notif_barang) > 5)
                                        <span class="badge badge-danger badge-counter">5+</span>
                                    @else
                                        <span
                                            class="badge badge-danger badge-counter">{{ count($notif_barang) }}</span>
                                    @endif
                                @endif

                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifikasi
                                </h6>
                                @if (count($notif_barang) > 0)
                                    @foreach ($notif_barang as $key => $info_barang)
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div>
                                                <div class="small text-gray-500">
                                                    {{ convert_date($info_barang->updated_at) }}
                                                </div>
                                                <span class="font-weight-bold">{{ $info_barang->nama }} tersisa
                                                    <span class="text-danger">{{ $info_barang->stok }}</span>
                                                </span>
                                            </div>
                                        </a>

                                        @php
                                            if ($key + 1 == 5) {
                                                break;
                                            }
                                        @endphp
                                    @endforeach
                                @else
                                    <span class="dropdown-item d-flex align-items-center ">
                                        <span class="text-secondary">Tidak ada Notifikasi
                                        </span>
                                    </span>
                                @endif

                                <a class="dropdown-item text-center small text-gray-500"
                                    href="{{ route('notifikasi') }}">Lihat Semua
                                    Notifikasi</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('assets/img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalKeluar">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                @yield('content')
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; {{ $pengaturan->nama_aplikasi }}
                            {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="modalKeluar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keluar ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Keluar" jika anda ingin keluar</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Keluar</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Axios -->
    <script src="{{ asset('assets/vendor/axios/axios.min.js') }}"></script>

    <!-- VUE -->
    <script src="{{ asset('assets/vendor/Vue/vue.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/polyfill.js') }}"></script>
    @yield('js')


</body>

</html>
