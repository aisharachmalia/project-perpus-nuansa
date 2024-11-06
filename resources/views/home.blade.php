@extends('master')
@section('content')
    <style>
        .alert {
            font-size: 0.85rem;
            padding: 8px;
            margin-bottom: 12px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card h6 {
            margin: 0;
        }

        .table-hover td,
        .table-hover th {
            text-align: center;
        }

        /* Adjusting card and content sizes */
        .card-body.d-flex {
            align-items: center;
            justify-content: space-between;
        }

        .stats-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
        }

        .stats-icon i {
            font-size: 2rem;
        }

        /* Ensure all charts and cards are aligned properly */
        /* Ensure both cards have the same height */
        .card.chart-container {
            height: 370px;
            /* Atur tinggi yang sama untuk kedua card */
        }

        .card h4 {
            margin-bottom: 15px;
            /* Tambah jarak di bawah heading */
        }

        .chart-container #chart_utama,
        .chart-container #chart_profile {
            width: 100%;
            height: 285px;
            /* Atur ukuran chart agar tidak terlalu besar */
        }

        .table-responsive {
            height: 100%;
            overflow: hidden;
        }

        #card-notifikasi {
            min-height: 380px;
            /* Jaga tinggi minimal untuk card */
        }

        #notification .alert {
            transition: visibility 0.3s, opacity 0.3s ease-in-out;
            opacity: 1;
            visibility: visible;
        }

        #notification .alert.hidden {
            visibility: hidden;
            opacity: 0;
            height: 0;
            margin: 0;
            padding: 0;
        }


        #no-notifications {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 20px 0;
        }

        .form-group {
            display: inline-block;
            /* Membiarkan form-group berdampingan */
            text-align: left;
            /* Menjaga label sejajar dengan dropdown */
        }

        .form-control {
            width: 200px;
            /* Mengatur lebar dropdown */
        }

        .btn {
            transition: background-color 0.3s ease;
            /* Animasi untuk tombol */
        }

        .btn:hover {
            background-color: #0056b3;
            /* Mengubah warna saat hover */
        }

        h5 {
            font-weight: bold;
            /* Membuat judul lebih menonjol */
        }
    </style>


    @php
        $role = App\Models\akses_usr::join('users', 'akses_usrs.id_usr', 'users.id_usr')
            ->where('users.id_usr', Auth::user()->id_usr)
            ->join('roles', 'akses_usrs.id_role', 'roles.id_role')
            ->first();
    @endphp
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">

    </div>
    <div class="containah">
        <div class="row mb-4 justify-content-end">
            <div class="col-8 mb-2">
                <h3 style="text-align: left">Dashboard Perpustakaan</h3>
            </div>
            <div class="col-4 mb-2">
                <div id="daterange" class="float-end"
                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align: center">
                    <input type="hidden" id="filter-tanggal-awal">
                    <input type="hidden" id="filter-tanggal-akhir">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span>
                    <i class="fa fa-caret-down"></i>
                </div>
            </div>
        </div>
    </div>


    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <a href="{{ route('data_master.buku') }}">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon purple">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Buku</h6>
                                        <h6 id="total_buku" class="font-extrabold mb-0">
                                            <h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <a href="{{route('transaksi')}}">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Peminjaman</h6>
                                        <h6 id="total_peminjaman" class="font-extrabold mb-0"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <a href="{{route('denda')}}">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon bg-warning">
                                            <i class="fas fa-coins"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Jumlah Denda</h6>
                                        <h6 id="total_denda" class="font-extrabold mb-0"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <a href="{{route('pageLaporan')}}">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">pelanggaran </h6>
                                        <h6 id="total_pelanggaran" class="font-extrabold mb-0"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>

                <!-- Statistik Peminjaman Buku -->
                <!-- Statistik Peminjaman Buku -->
                <div class="row">
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body chart-container">
                                <h4>Statistik Peminjaman Buku</h4>
                                <div id="chart_utama"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-3" id="card-notifikasi">
                        <div class="card-body">
                            <h4>Notifikasi</h4>
                            <div id="notification">
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sugiarto Cokro</strong>, Pengunjung baru di PerPusWeb.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                            onclick="hideNotification(this)"></button>
                                    </div>
                                @endfor
                            </div>
                            <div id="no-notifications" style="display: none;">Tidak ada notifikasi.</div>
                            <!-- Placeholder -->
                        </div>
                    </div>

                </div>

                <!-- Kategori dan Peminjaman Terbanyak -->
                <div class="row">
                    {{-- <div class="col-12 col-xl-5">
                        <div class="card chart-container">
                            <div class="card-body">
                                <h4>Kategori Favorit</h4>
                                <div id="chart_profile"></div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Peminjam Terbanyak -->
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <hr class="new5">
                            <div class="card-header">
                                <h4 class="text-center">Peminjam Terbanyak</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="">
                                    <table class="table table-hover" id="peminjaman_terbanyak">
                                        <thead>
                                            <tr>
                                                <th>Peringkat</th>
                                                <th>Nama Pengguna</th>
                                                <th>Jumlah Peminjaman</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data akan dimuat oleh AJAX -->
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <hr class="new5">
                            <div class="card-header text-center">
                                <h4>Buku Favorit</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="buku_terbanyak_dipinjam">
                                        <thead>
                                            <tr>
                                                <th>Cover</th>
                                                <th>Judul Buku</th>
                                                <th>Nama Penulis</th>
                                                <th>Total Pembaca</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
    </div>
    </div>

    </div>
    </section>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{ URL::asset('assets/js/highcharts.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    // Kategori Terbanyak Dibaca
    </script>
    <script>
        $(document).ready(function() {
            // Date Range Picker Initialization
            let start = moment().subtract(29, 'days');
            let end = moment();
            let token = $("meta[name='csrf-token']").attr("content");

            function cb(start, end) {
                $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#filter-tanggal-awal').val(start.format('YYYY-MM-DD'));
                $('#filter-tanggal-akhir').val(end.format('YYYY-MM-DD'));
            }

            $('#daterange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(start, end); // Initialize with default range

            // Event listener untuk onchange di daterangepicker
            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                let startDate = picker.startDate.format('YYYY-MM-DD');
                let endDate = picker.endDate.format('YYYY-MM-DD');

                $('#filter-tanggal-awal').val(startDate);
                $('#filter-tanggal-akhir').val(endDate);

                // Trigger AJAX call saat tanggal berubah
                totalDataDashboard(startDate, endDate);
            });

            var tanggal_awal = $('#filter-tanggal-awal').val();
            var tanggal_akhir = $('#filter-tanggal-akhir').val();
            totalDataDashboard(tanggal_awal, tanggal_akhir)
            // Fungsi AJAX untuk mengambil data berdasarkan tanggal

            function totalDataDashboard(tanggal_awal, tanggal_akhir) {

                $.ajax({
                    url: `total-data-dashboard`,
                    type: "GET",
                    data: {
                        tanggal_awal: tanggal_awal,
                        tanggal_akhir: tanggal_akhir,
                    },
                    cache: false,
                    success: function(response) {
                        console.log(response.statistik_peminjaman);
                        $('#total_buku').text(response.total_buku);
                        $('#total_peminjaman').text(response.total_peminjaman);
                        $('#total_denda').text('Rp ' + new Intl.NumberFormat('id-ID').format(response.total_denda));
                        $('#total_pelanggaran').text(response.total_pelanggaran);
                        $('#peminjaman_terbanyak tbody').html(response.peminjaman_terbanyak);
                        $('#buku_terbanyak_dipinjam tbody').html(response.buku_terbanyak_dipinjam);

                        Highcharts.chart('chart_utama', {
                            chart: {
                                type: 'area'
                            },
                            title: {
                                text: null
                            },
                            xAxis: {
                                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei',
                                    'Juni', 'Juli', 'Agustus', 'September',
                                    'Oktober', 'November', 'Desember'
                                ]
                            },
                            yAxis: {
                                title: {
                                    text: null
                                }
                            },
                            credits: {
                                enabled: false
                            },
                            series: [{
                                name: 'Total Siswa yang Meminjam Buku',
                                data: response.statistik_peminjaman // Mengambil data dari respons
                            }]
                        });
                    }
                });
            }

        });
    </script>
@endpush
