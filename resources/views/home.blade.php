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

    .table-hover td, .table-hover th {
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
    height: 370px; /* Atur tinggi yang sama untuk kedua card */
}

.card h4 {
    margin-bottom: 15px; /* Tambah jarak di bawah heading */
}

.chart-container #chart_utama, .chart-container #chart_profile {
    width: 100%;
    height: 285px; /* Atur ukuran chart agar tidak terlalu besar */
}

.table-responsive {
    height: 100%;
    overflow: hidden;
}
#card-notifikasi {
    min-height: 380px; /* Jaga tinggi minimal untuk card */
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
    <h3>Dashboard Perpustakaan</h3>
</div>
<div class="row mb-4">
    <div class="col-6">
        <form action="{{ route('home') }}" method="GET" class="form-inline">
            <div class="form-group">
                <label for="bulan">Bulan:</label>
                <select name="bulan" id="bulan" class="form-control mx-2" onchange="this.form.submit()">
                    <option value="">-- Pilih Bulan --</option>
                    @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $bulan)
                        <option value="{{ $index + 1 }}" {{ request('bulan') == ($index + 1) ? 'selected' : '' }}>{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        
    </div>
    <div class="col-6">
        <form action="{{ route('home') }}" method="GET" class="form-inline"> 
           
            <div class="form-group">
                <label for="tahun">Tahun:</label>
                <select name="tahun" id="tahun" class="form-control mx-2" onchange="this.form.submit()">
                    <option value="">-- Pilih Tahun --</option>
                    @for ($tahun = date('Y'); $tahun >= 2000; $tahun--)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endfor
                </select>
            </div>
        </form>
    </div>
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
                                        <h6 class="font-extrabold mb-0">183</h6>
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
                                        <h6 class="text-muted font-semibold">Peminjaman</h6>
                                        <h6 class="font-extrabold mb-0">{{$totalPeminjaman }}</h6>
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
                                            <i class="fas fa-coins"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">pelanggaran </h6>
                                        <h6 class="font-extrabold mb-0">{{$totalDenda}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Statistik Peminjaman Buku -->
          <!-- Statistik Peminjaman Buku -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body chart-container">
                <h4>Statistik Peminjaman Buku</h4>
                <div id="chart_utama"></div>
            </div>
        </div>
    </div>
</div>

<!-- Kategori dan Peminjaman Terbanyak -->
<div class="row">
    <div class="col-12 col-xl-5">
        <div class="card chart-container">
            <div class="card-body">
                <h4>Kategori Favorit</h4>
                <div id="chart_profile"></div>
            </div>
        </div>
    </div>
  <!-- Peminjam Terbanyak -->
  <div class="col-12 col-xl-7">
    <div class="card">
        <div class="card-header">
            <h4>Peminjam Terbanyak</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama</th>
                            <th>Total Bacaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($peminjaman_terbanyak->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">Belum ada peminjam.</td>
                            </tr>
                        @else
                            @foreach ($peminjaman_terbanyak->take(5) as $key => $peminjam)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $peminjam->dsiswa_nama }}</td>
                                    <td>{{ $peminjam->total_bacaan }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

        </div>

        <!-- Info Admin/Pustakawan & Notifikasi -->
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stats-icon red">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Jumlah Denda</h6>
                            <h6 class="font-extrabold mb-0">Rp.{{$totalDenda}}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Notifikasi -->
            <div class="card" id="card-notifikasi">
                <div class="card-body">
                    <h4>Notifikasi</h4>
                    <div id="notification">
                        @for ($i = 0; $i < 4; $i++)
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sugiarto Cokro</strong>, Pengunjung baru di PerPusWeb.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="hideNotification(this)"></button>
                        </div>
                        @endfor
                    </div>
                    <div id="no-notifications" style="display: none;">Tidak ada notifikasi.</div> <!-- Placeholder -->
                </div>           
            </div>
            
            <!-- Buku Terbanyak Terpinjam -->
<!-- Buku Terbanyak Terpinjam -->

    <div class="card" >
        <div class="card-header">
            <h4>Buku Terbanyak Terpinjam</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($bukuTerbanyakDipinjam->isEmpty())
                            <tr>
                                <td colspan="1" class="text-center">Belum ada buku yang dipinjam.</td>
                            </tr>
                        @else
                            @foreach($bukuTerbanyakDipinjam as $buku)
                                <tr>
                                    <td>{{ $buku->dbuku_judul }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
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
<script src="{{ URL::asset('assets/js/highcharts.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
// Statistik Peminjaman Buku
Highcharts.chart('chart_utama', {
        chart: { 
            type: 'area' 
        },
        title:  { text: null },
        xAxis: { 
            categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] 
        },
        yAxis: { 
            title: { text: null }
        },
        credits: { 
            enabled: false 
        },
        series: [{
            name: 'Total Siswa yang Meminjam Buku',
            data: {!! json_encode($data) !!} // Mengambil data dari controller
        }]
    });

// Kategori Terbanyak Dibaca
var chartData = @json($chartData); // Ambil data dari controller

Highcharts.chart('chart_profile', {
    title: { text: null },
    chart: {
        type: 'pie',
        height: 280,
        width: 280 // Sesuaikan dengan height card
    },
    series: [{
        name: 'Kategori',
        data: chartData // Data yang sudah diformat
    }]
});
</script>
<script>
    function hideNotification(element) {
        element.parentElement.classList.add('hidden'); // Tambahkan kelas hidden
        checkNotifications(); // Cek apakah semua notifikasi sudah dihapus
    }

    function checkNotifications() {
        var visibleNotifications = document.querySelectorAll('#notification .alert:not(.hidden)');
        if (visibleNotifications.length === 0) {
            document.getElementById('no-notifications').style.display = 'block'; // Tampilkan placeholder
        }
    }
</script>

@endpush
