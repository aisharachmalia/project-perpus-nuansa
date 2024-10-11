<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@extends('master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <!-- Title Section -->
                            <div class="col-12 mb-3">
                                <h4>Laporan Peminjaman</h4>
                            </div>
                        </div>

                        <!-- Filters Section -->
                        <div class="row">
                            <!-- Filter Buku -->
                            <div class="col-md-2 mb-2">
                                <select id="filter-buku" class="form-control">
                                    <option value="">All</option>
                                    @php
                                        $buku = DB::table('dm_buku')->get();
                                    @endphp
                                    @foreach ($buku as $item)
                                        <option value="{{ $item->id_dbuku }}">{{ $item->dbuku_judul }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Siswa -->
                            <div class="col-md-2 mb-2">
                                <select id="filter-siswa" class="form-control">
                                    <option value="">All</option>
                                    @php
                                        $siswa = DB::table('dm_siswas')->get();
                                    @endphp
                                    @foreach ($siswa as $item)
                                        <option value="{{ $item->id_dsiswa }}">{{ $item->dsiswa_nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Tanggal Awal -->
                            <div class="col-md-2 mb-2">
                                <input type="date" id="filter-tanggal-awal" class="form-control">
                            </div>

                            <!-- Filter Tanggal Akhir -->
                            <div class="col-md-2 mb-2">
                                <input type="date" id="filter-tanggal-akhir" class="form-control">
                            </div>

                            <!-- Filter Status -->
                            <div class="col-md-2 mb-2">
                                <select id="filter-status" class="form-control">
                                    <option value="">All</option>
                                    <option value="1">Sudah lunas</option>
                                    <option value="2">Dikembalikan</option>
                                    <option value="3">Dipinjam</option>
                                    <option value="0">Denda</option>
                                </select>
                            </div>

                            <!-- Export and Print Buttons Section -->
                            <div class="col-md-2 d-flex justify-content-end mb-2">
                                <a href="#" class="icon icon-left dropdown-toggle" data-bs-toggle="dropdown"><i
                                        class="bi bi-justify fs-3"></i></a>
                                <div class="dropdown-menu">
                                    <a href="javascript:void(0)" class="dropdown-item mb-2 text-end" id="export">
                                        <span class="badge bg-light-warning">Export Excel <i
                                                class="fas fa-file-excel"></i></span>
                                    </a>
                                    <a href="javascript:void(0)" class="dropdown-item mb-2 text-end" id="printout">
                                        <span class="badge bg-light-danger">Printout Pdf <i
                                                class="fas fa-file-pdf"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-body">
                        <table id="tbl_trks" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Buku</th>
                                    <th>Siswa</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tangal Jatuh Tempo</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Denda</th>
                                    <th>Status</th>
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
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var link_export = "{{ route('link_export_buku') }}";
            var link_printout = "{{ route('link_printout_buku') }}";

            var table = $('#tbl_trks').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ route('table_lap_trks') }}",
                    data: function(d) {
                        d.tanggal_awal = $('#filter-tanggal-awal').val();
                        console.log(d.tanggal_awal)
                        d.tanggal_akhir = $('#filter-tanggal-akhir').val();
                        d.siswa = $('#filter-siswa').val();
                        d.buku = $('#filter-buku').val();
                        d.status = $('#filter-status').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        data: 'dbuku_judul'
                    },
                    {
                        data: 'dsiswa_nama'
                    },
                    {
                        data: 'trks_tgl_peminjaman'
                    },
                    {
                        data: 'trks_tgl_jatuh_tempo'
                    },
                    {
                        data: 'trks_tgl_pengembalian'
                    },
                    {
                        data: 'tdenda_jumlah'
                    },
                    {
                        data: 'tdenda_status',
                        render: function(data) {
                            if (data == 1) {
                                return '<span class="badge bg-success">Lunas</span>';
                            } else if (data == 2) {
                                return '<span class="badge bg-danger">Dikembalikan</span>';
                            } else if (data == 3) {
                                return '<span class="badge bg-info">Dipinjam</span>';
                            } else if (data == 4) {
                                return '<span class="badge bg-secondary">Belum dikembalikan</span>';
                            } else {
                                return '<span class="badge bg-danger">Denda</span>';
                            }
                        }
                    },
                ]
            });

            $('#filter-buku, #filter-siswa, #filter-status, #filter-tanggal-awal, #filter-tanggal-akhir')
            .on('change',function() {
                    table.draw();
                });

            // Export functionality
            $(document).on('click', '#export', function() {
                var value_table = $('#tbl_trks').DataTable().data().count();
                var link_export = "{{ route('link_export_laporan') }}";
                if (value_table > 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: link_export,
                        dataType: 'json',
                        success: function(data) {
                            window.open(data.link, '_blank');
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Export failed! Please try again later.',
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        html: 'Tidak terdapat Data yang akan dicetak',
                        showCloseButton: true,
                        focusConfirm: false,
                        confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK',
                    });
                }
            });

            // Printout functionality
            $(document).on('click', '#printout', function() {
                var link_printout = "{{ route('link_printout_laporan') }}";
                var value_table = $('#tbl_trks').DataTable().data().count();
                if (value_table > 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: link_printout,
                        dataType: 'json',
                        success: function(data) {
                            window.open(data.link, '_blank');
                        },
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        html: 'Tidak terdapat Data yang akan dicetak',
                        showCloseButton: true,
                        focusConfirm: false,
                        confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK',
                    });
                }
            });
        });
    </script>
@endpush
