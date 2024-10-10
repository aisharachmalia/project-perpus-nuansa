@extends('master')
@section('content')
<style>
 .alert {
    font-size: 0.85rem; /* Ukuran teks lebih kecil */
    padding: 10px; /* Mengurangi padding */
    margin-bottom: 8px; /* Jarak antar alert */
}

</style>
@php
    $role = App\Models\akses_usr::join('users', 'akses_usrs.id_usr', 'users.id_usr','users.usr_email')
        ->where('users.id_usr', Auth::user()->id_usr,)
        ->join('roles', 'akses_usrs.id_role', 'roles.id_role')
        ->first();
@endphp
<header class="">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading">
    <h3>Dashboard Perpustakaan</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
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
                                    <h6 class="font-extrabold mb-0">112.000</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="fas fa-file"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total E-Book</h6>
                                    <h6 class="font-extrabold mb-0">183.000</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Buku Masuk</h6>
                                    <h6 class="font-extrabold mb-0">80.000</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                        <i class="fas fa-undo"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Peminjaman</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalSiswa }} </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Statistik Peminjaman Buku</h4>
                            <div id="chart_utama"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Kategori Teratas</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-primary" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Komik</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0">862</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-europe"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-success" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Novel</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0">375</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-america"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <svg class="bi text-warning" width="32" height="32" fill="blue"
                                            style="width:10px">
                                            <use
                                                xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill" />
                                        </svg>
                                        <h5 class="mb-0 ms-3">Kamus</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h5 class="mb-0">375</h5>
                                </div>
                                <div class="col-12">
                                    <div id="chart-america"></div>
                                </div>
                            </div>             
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Peminjaman Terbanyak</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>Peringkat</th>
                                            <th>Name</th>
                                            <th>Total Bacaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="col-3"><center><p>1</p></center></td>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="assets/images/faces/5.jpg">
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0">Anindya Putri</p>
                                                </div>
                                            </td>
                                            <td class="col-3">
                                                <p class=" mb-0">35 Buku</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3"><center><p>2</p></center></td>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="assets/images/faces/2.jpg">
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0">Alvito Daffa</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0">30 Buku</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3"><center><p>3</p></center></td>
                                            <td class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="assets/images/faces/1.jpg">
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0">Alvin Purwo</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0">29 Buku</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-5">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="assets/images/faces/1.jpg" alt="Face 1">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">{{ Auth::user()->usr_nama }}</h5>
                            <h6 class="text-muted mb-0">{{Auth::user()->usr_email}}</h6>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h4>Statistik kategori</h4>
                    <div id="chart_profile"></div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4>Notifikasi</h4>
                    <div id="notification">
                        <!-- Hardcoded Notification -->
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sugiarto Cokro</strong>, Pengunjung baru di PerPusWeb.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sugiarto Cokro</strong>, Pengunjung baru di PerPusWeb.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sugiarto Cokro</strong>, Pengunjung baru di PerPusWeb.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sugiarto Cokro</strong>, Pengunjung baru di PerPusWeb.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sugiarto Cokro</strong>, Pengunjung baru di PerPusWeb.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script src="{{ URL::asset('assets/js/highcharts.js') }}" type="text/javascript"></script>
<script>
    Highcharts.chart('chart_profile', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: '',
        align: 'left'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Kategori',
        colorByPoint: true,
        data: [{
            name: 'komik',
            y: 74.77,
            sliced: true,
            selected: true
        },  {
            name: 'novel',
            y: 12.82
        }, {
            name: 'kamus',
            y: 4.63
        }, {
            name: 'dongeng',
            y: 2.44
        }, {
            name: 'buku ilmiah',
            y: 2.02
        }, {
            name: 'Ensiklopedia',
            y: 3.28
        }]
    }]
});

</script>
<script>
    Highcharts.chart('chart_utama', {
    chart: {
        type: 'area'
    },
    title: {
        text: '',
        align: 'left'
    },
    subtitle: {
        text: '',
        align: 'left'
    },
    xAxis: {
        categories: [
            '2019', '2019', '2019', '2019', '2020', '2020',
            '2020', '2020', '2021', '2021', '2021'
        ]
    },
    yAxis: {
        title: {
            text: 'TWh'
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Total siswa yang meminjam buku',
        data: [
            37, 29, 30, 36, 40, 35, 34, 43, 45, 35, 52
        ]
    }]
});

</script>
@endpush