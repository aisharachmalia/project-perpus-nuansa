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
                                    <h6 class="font-extrabold mb-0">{{ $totalBuku }}<h6>
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
                <div class="col-12 col-xl-5">
                    {{-- BUKU TOP --}}
                    <div class="card">
                        <div class="card-body">
                            <h4>Kategori Terbanyak Di Baca</h4>
                            <div id="chart_profile"></div>
                        </div>
                    </div>
                   
                </div>
                {{-- PEMINJAM TOP --}}
                <div class="col-12 col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <h4>Peminjaman Terbanyak</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Peringkat</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Total Bacaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="col-2"><center><p>1</p></center></td>
                                            <td class="col-4">
                                                <div class="d-flex align-items-center">
                                                    {{-- <div class="avatar avatar-md">
                                                        <img src="assets/images/faces/5.jpg">
                                                    </div> --}}
                                                    <p class="font-bold ms-5 mb-0 text-center">Anindya Putri Nabila</p>
                                                </div>
                                            </td>
                                            <td class="col-3">
                                                <p class=" mb-0 text-center">35 Buku</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-2"><center><p>2</p></center></td>
                                            <td class="col-4">
                                                <div class="d-flex align-items-center">
                                                    {{-- <div class="avatar avatar-md">
                                                        <img src="assets/images/faces/2.jpg">
                                                    </div> --}}
                                                    <p class="font-bold ms-5 mb-0">Alvito Daffa Ramadan</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0 text-center">30 Buku</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-2"><center><p>3</p></center></td>
                                            <td class="col-4">
                                                <div class="d-flex align-items-center">
                                                    {{-- <div class="avatar avatar-md">
                                                        <img src="assets/images/faces/1.jpg">
                                                    </div> --}}
                                                    <p class="font-bold ms-5 mb-0 text-center">Alvin Purwo Ardianto</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0 text-center">29 Buku</p>
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
        {{-- INFO ADMIN/PUSTAKAWAN --}}
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-5">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="assets/images/faces/1.jpg" alt="Face 1">
                        </div>
                        <div class="ms-2 name">
                            <h5 class="font-bold">{{ Auth::user()->usr_nama }}</h5>
                            <h6 class="text-muted mb-0">{{Auth::user()->usr_email}}</h6>
                        </div>
                    </div>
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
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sugiarto Cokro</strong>, Pengunjung baru di PerPusWeb.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
           {{-- NOTIFIKASIII --}}
           
           <div class="card">
            <div class="card-header">
                <h4>Judul Buku Yang Banyak Terpinjam</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-lg">
                        <thead>
                            <tr>
                                <th class="text-center">Judul Buku</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-3">
                                    <div class="d-flex align-items-center">
                                        {{-- <div class="avatar avatar-md">
                                            <img src="assets/images/faces/5.jpg">
                                        </div> --}}
                                        <p class="font-bold ms-5 mb-0 ">Matahari</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-3">
                                    <div class="d-flex align-items-center">
                                        {{-- <div class="avatar avatar-md">
                                            <img src="assets/images/faces/2.jpg">
                                        </div> --}}
                                        <p class="font-bold ms-5 mb-0">Bulan</p>
                                    </div>
                            </tr>
                            <tr>
                                <td class="col-3">
                                    <div class="d-flex align-items-center">
                                        {{-- <div class="avatar avatar-md">
                                            <img src="assets/images/faces/1.jpg">
                                        </div> --}}
                                        <p class="font-bold ms-5 mb-0 ">Bumi</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </section>
</div>
@endsection
@push('scripts')
<script src="{{ URL::asset('assets/js/highcharts.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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
            text: ''
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
<script>
    Highcharts.chart('kategori_1', {
    data: {
        table: 'datatable'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'Live births in Norway'
    },
    subtitle: {
        text:
            'Source: <a href="https://www.ssb.no/en/statbank/table/04231" target="_blank">SSB</a>'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Amount'
        }
    }
});
</script>
<script>
// Chart untuk Kategori Komik
var optionsKategori1 = {
    series: [862], // Data Komik
    chart: {
        type: 'pie', // Tipe chart pie
        height: 200
    },
    labels: ['Komik'], // Label untuk chart
    colors: ['#007bff'], // Warna untuk kategori Komik
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

// Render chart ke div dengan ID 'chart_kategori1'
var chartKategori1 = new ApexCharts(document.querySelector("#chart_kategori1"), optionsKategori1);
chartKategori1.render();

// Chart untuk Kategori Novel
var optionsKategori2 = {
    series: [375], // Data Novel
    chart: {
        type: 'pie',
        height: 200
    },
    labels: ['Novel'],
    colors: ['#28a745']
};

var chartKategori2 = new ApexCharts(document.querySelector("#chart_kategori2"), optionsKategori2);
chartKategori2.render();

// Chart untuk Kategori Kamus
var optionsKategori3 = {
    series: [375], // Data Kamus
    chart: {
        type: 'pie',
        height: 200
    },
    labels: ['Kamus'],
    colors: ['#ffc107']
};

var chartKategori3 = new ApexCharts(document.querySelector("#chart_kategori3"), optionsKategori3);
chartKategori3.render();

</script>

@endpush