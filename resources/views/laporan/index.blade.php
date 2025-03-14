@extends('master')
@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                        <div class="col-12 d-flex justify-content-start">
                            <a href="javascript:;" class="btn btn-success mb-2" id="export"> Export Excel</a>
                            &nbsp;&nbsp;
                            <a href="javascript:;" class="btn btn-danger mb-2" id="printout"> Printout Pdf</a>
                        </div>
                        <!-- Filters Section -->
                        <div class="row">
                            <!-- Filter Buku -->
                            <div class="col-md-2 mb-2">
                                <span>Buku</span>
                                <select id="filter-buku" class="form-control">
                                    <option value="">Semua Buku</option>
                                    @php
                                        $buku = DB::table('dm_buku')->get();
                                    @endphp
                                    @foreach ($buku as $item)
                                        <option value="{{ Crypt::encrypt($item->id_dbuku) }}">{{ $item->dbuku_judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Siswa -->
                            <div class="col-md-2 mb-2">
                                <span>Siswa</span>
                                <select id="filter-siswa" class="form-control">
                                    <option value="">Semua Siswa</option>
                                    @php
                                        $siswa = DB::table('users')->leftJoin('akses_usrs', 'users.id_usr', '=', 'akses_usrs.id_usr')->whereNull('akses_usrs.id_usr')->select('users.id_usr', 'usr_nama')->get();
                                    @endphp
                                    @foreach ($siswa as $item)
                                        <option value="{{ Crypt::encrypt($item->id_usr) }}">{{ $item->usr_nama }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <!-- Filter Status -->
                            <div class="col-md-2 mb-2">
                                <span>Status</span>
                                <select id="filter-status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="1">Dikembalikan</option>
                                    <option value="0">Dipinjam</option>
                                    <option value="-1">Batal</option>
                                </select>
                            </div>

                            <!-- Filter Tanggal -->
                            <div class="col-md-6 mb-2">
                                <span>Tanggal</span>
                                <div id="daterange" class="float-end"
                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center">
                                    <input type="hidden" id="filter-tanggal-awal">
                                    <input type="hidden" id="filter-tanggal-akhir">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span>
                                    <i class="fa fa-caret-down"></i>
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

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script type="text/javascript">
        $(function() {
            let start = moment().subtract(29, 'days');
            let end = moment();

            function cb(start, end) {
                $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'));
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
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment()
                        .subtract(1, 'month').endOf('month')
                    ]
                }
            }, cb);

            cb(start, end); // Initialize with default range

            // Event listener untuk onchange
            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                let startDate = picker.startDate.format('YYYY-MM-DD');
                let endDate = picker.endDate.format('YYYY-MM-DD');

                $('#filter-tanggal-awal').val(startDate);
                $('#filter-tanggal-akhir').val(endDate);

                // Trigger AJAX call saat tanggal berubah
                filterByDate(startDate, endDate);
            });
        });

        // Fungsi AJAX untuk mengambil data berdasarkan tanggal
        function filterByDate(tanggalAwal, tanggalAkhir) {
            $.ajax({
                url: "{{ route('table_lap_trks') }}", // ganti dengan URL route yang sesuai
                method: 'GET',
                data: {
                    tanggal_awal: tanggalAwal,
                    tanggal_akhir: tanggalAkhir
                },
                success: function(response) {
                    // Misal, jika kamu menggunakan DataTables, refresh tabel di sini
                    $('#tbl_trks').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            var link_export = "{{ route('link_export_buku') }}";
            var link_printout = "{{ route('link_printout_buku') }}";
            var table = $('#tbl_trks').DataTable({
                scrollX: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "{{ route('table_lap_trks') }}",
                    data: function(d) {
                        d.tanggal_awal = $('#filter-tanggal-awal').val();
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
                        data: 'usr_nama'
                    },
                    {
                        data: 'trks_tgl_peminjaman'
                    },
                    {
                        data: 'trks_tgl_jatuh_tempo'
                    },
                    {
                        class: "text-center",
                        data: 'trks_tgl_pengembalian'
                    },
                    {
                        class: "text-center",
                        data: 'jumlah',
                    },
                    {
                        class: "text-center",
                        data: 'trks_status',
                        render: function(data) {
                            if (data == 0) {
                                return '<span class="badge bg-light-info"> Dipinjam </span>';
                            } else if (data == 1) {
                                return '<span class="badge bg-light-success"> Dikembalikan </span>';
                            } else if (data == '-1'){
                                return '<span class="badge bg-light-danger"> Batal </span>';
                            }
                        }
                    },
                ]
            });

            $('#filter-buku, #filter-siswa, #filter-status, #daterange, #filter-tanggal-awal, #filter-tanggal-akhir')
                .change()
                .on('change', function() {
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
