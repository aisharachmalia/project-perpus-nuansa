@extends('master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="javascript:void(0)" class="btn btn-custom btn-primary mb-2 modalCreate"
                                    data-bs-toggle="modal" data-bs-target="#tambahPeminjaman">
                                    Peminjaman
                                </a>
                                &nbsp; &nbsp;
                                <a href="javascript:void(0)" class="btn btn-custom btn-warning mb-2 pengembalian"
                                    data-bs-toggle="modal" data-bs-target="#pengembalian">
                                    Pengembalian
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_transaksi" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Buku & Nama Peminjam</th>
                                    <th>Tanggal Peminjaman & Tanggal Jatuh Tempo</th>
                                    <th>Tanggal Pengembalian & Status Pengembalian </th>
                                    <th>Denda</th>
                                    <th>Aksi</th>
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="javascript:void(0)" class="btn btn-custom btn-primary mb-2 reservasi"
                                    data-bs-toggle="modal" data-bs-target="#reservasi">
                                    Reservasi
                                </a>
                                &nbsp; &nbsp;
                                <a href="javascript:void(0)" class="btn btn-custom btn-success mb-2 pengambilan"
                                    data-bs-toggle="modal" data-bs-target="#pengambilan">
                                    Pengambilan
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_reservasi" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Buku & Nama Peminjam</th>
                                    <th>Tanggal Reservasi & Tanggal Kadaluarsa</th>
                                    <th>Tanggal Pengambilan & Tanggal Pemberitahuan </th>
                                    <th>Status Reservasi </th>
                                    <th>Aksi</th>
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
    @php
        $role = App\Models\Akses_usr::join('users', 'akses_usrs.id_usr', 'users.id_usr')
            ->where('users.id_usr', Auth::user()->id_usr)
            ->join('roles', 'akses_usrs.id_role', 'roles.id_role')
            ->first();
    @endphp
    {{-- include modal transaksi --}}
    @include('transaksi.modal_trks')
    {{-- include modal reservasi --}}
    @include('transaksi.modal_trsv')
    {{-- include edit transaksi dan reservasi --}}
    @include('transaksi.edit_trks')
    {{-- ajax transaksi --}}
    @include('transaksi.ajax_trks')
    {{-- ajax reservasi --}}
    @include('transaksi.ajax_trsv')
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#tbl_transaksi').DataTable({
                serverSide: true,
                scrollX: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            return '<strong>' + row.dbuku_judul + '</strong><br>' +
                                row.usr_nama;
                        }
                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            return '<strong>' + new Date(row.trks_tgl_peminjaman)
                                .toLocaleString('id-ID').slice(0, 17) + '</strong><br>' +
                                new Date(row.trks_tgl_jatuh_tempo).toLocaleString('id-ID').slice(0,
                                    17);
                        }

                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            let pengembalian = row.trks_tgl_pengembalian == null ?
                                'Belum dikembalikan' :
                                new Date(row.trks_tgl_pengembalian).toLocaleString('id-ID').slice(0,
                                    17);
                            let status = '';
                            if (row.trks_status == -1) {
                                status = '<span class="badge bg-danger">Dibatalkan</span>';
                            }
                            if (row.trks_status == 0) {
                                status = '<span class="badge bg-warning text-dark">Dipinjam</span>';
                            }
                            if (row.trks_status == 1) {
                                status = '<span class="badge bg-success">Dikembalikan</span>';
                            }
                            return "<strong>" + pengembalian + "</strong>" + '  <br>' + status;
                        }
                    },
                    {
                        class: "text-center",
                        data: 'trks_denda',
                        render: function(data) {
                            if (data == null) {
                                return '0';
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'aksi',
                        orderable: false
                    }
                ]
            });
            var table = $('#tbl_reservasi').DataTable({
                serverSide: true,
                scrollX: true,
                ajax: '{{ route('reservasi-table') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            return '<strong>' + row.dbuku_judul + '</strong><br>' + row.usr_nama;
                        }
                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            return '<strong>' + new Date(row.trsv_tgl_reservasi).toLocaleString(
                                    'id-ID').slice(0, 17) + '</strong><br>' +
                                new Date(row.trsv_tgl_kadaluarsa).toLocaleString('id-ID').slice(0,
                                    17);
                        }

                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            let pemberitahuan = row.trsv_tgl_pemberitahuan == null ?
                                'Belum ada pemberitahuan' :
                                new Date(row.trsv_tgl_pemberitahuan).toLocaleString('id-ID').slice(
                                    0, 17);
                            let pengambilan = row.trsv_tgl_pengambilan == null ?
                                'Belum diambil' :
                                new Date(row.trsv_tgl_pengambilan).toLocaleString('id-ID').slice(0,
                                    17);
                            return "<strong>" + pengambilan + "</strong>" + '<br>' + pemberitahuan;
                        }

                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            let status = '';
                            if (row.trsv_status == -1) {
                                status = '<span class="badge bg-danger">Dibatalkan</span>';
                            }
                            if (row.trsv_status == 0) {
                                status = '<span class="badge bg-secondary">Kadaluarsa</span>';
                            }
                            if (row.trsv_status == 1) {
                                status = '<span class="badge bg-info">Aktif</span>';
                            }
                            if (row.trsv_status == 2) {
                                status = '<span class="badge bg-success">Selesai</span>';
                            }
                            return status;
                        }

                    },
                    {
                        data: 'aksi',
                        orderable: false
                    }
                ]
            });
        });
    </script>
@endpush


<style>
    .swal2-html {
        font-size: 14px;
        /* Atur ukuran font */
        line-height: 1.5;
        /* Atur tinggi baris untuk spacing */
        max-width: 400px;
        /* Atur lebar maksimum */
        word-wrap: break-word;
        /* Memungkinkan teks panjang terputus */
    }

    .modal-content {
        background: linear-gradient(135deg, #f3f4f6, #e2e8f0);
        /* Gradasi warna lembut */
        border-radius: 12px;
        /* Membuat sudut modal melengkung */
        border: none;
        /* Menghilangkan border */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        /* Bayangan lembut */
    }

    .modal-header {
        border-bottom: 2px solid #cbd5e1;
        /* Garis bawah header */
    }

    .modal-title {
        color: #1f2937;
        /* Warna judul yang kontras */
        font-weight: bold;
        /* Membuat judul lebih menonjol */
    }

    .modal-body {
        padding: 20px;
        /* Ruang yang lebih besar untuk isi modal */
    }

    .form-control {
        border: 1px solid #cbd5e1;
        /* Border yang lebih halus */
        border-radius: 8px;
        /* Sudut input melengkung */
        transition: border-color 0.3s;
        /* Efek transisi border */
    }

    .form-control:focus {
        border-color: #3b82f6;
        /* Warna border saat fokus */
        box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
        /* Efek bayangan saat fokus */
    }

    .btn-custom {
        background-color: #3b82f6;
        /* Warna tombol */
        color: white;
        /* Warna teks tombol */
        border-radius: 8px;
        /* Sudut tombol melengkung */
        transition: background-color 0.3s;
        /* Efek transisi warna tombol */
    }

    .btn-custom:hover {
        background-color: #2563eb;
        /* Warna tombol saat hover */
    }
</style>
