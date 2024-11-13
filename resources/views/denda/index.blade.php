@extends('master')

@section('content')
    <style>
        .container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            border: 0.1px solid #ced4da;
            border-radius: .375rem;
        }
        .form-control{
            border: 0.1px solid #ced4da;
        }

        .select2-selection__rendered {
            line-height: 1.5;
        }

        .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }

        .select2-container .select2-selection--single {
            padding-left: 5px;
        }
    </style>
    <div class="container mb-5">
        <h2 class="text-center mb-3"><i class="fas fa-book-reader"></i> Pembayaran Denda Perpustakaan</h2>
        <div id="pembayaran">
            <div class="mb-3">
                <div class="form-group">
                    <label for="siswa">Nama Peminjam</label>&nbsp;
                    <i class="bi bi-person-fill"></i>
                    <select id="siswa" name="siswa" class="form-control choices">
                        <option value="">Pilih Peminjam</option>
                        @foreach ($peminjam as $data)
                            <option value="{{ Crypt::encryptString($data->id_usr) }}">
                                {{ $data->usr_nama }}</option>
                        @endforeach
                    </select>
                    <span id="user_error" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group position-relative has-icon-left">
                    <label for="buku">Judul Buku</label>&nbsp;
                    <i class="bi bi-book-fill"></i>
                    <select id="buku" name="buku" class="form-control">
                        <option value="">Pilih Buku</option>
                    </select>
                    <span id="buku_error" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="tanggalPeminjaman">Tanggal Pinjam</label>&nbsp;
                    <i class="bi bi-calendar-plus"></i>
                    <p class="form-control" id="tanggalPeminjaman">Tanggal Pinjam</p>
                    <span id="peminjaman_error" class="text-danger"></span>
                </div>
            </div>
            <div class=" mb-3">
                <div class="form-group">
                    <label for="tanggalJatuhTempo">Tanggal Jatuh Tempo</label>&nbsp;
                    <i class="bi bi-calendar-x-fill"></i>
                    <p class="form-control" id="tanggalJatuhTempo">Jatuh Tempo</p>
                    <span id="jatuh_tempo_error" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="denda">Jumlah Denda anda</label>&nbsp;
                    <i class="bi bi-cash-stack"></i>
                    <p class="form-control">Rp. <span id="jumlahDenda">0</span></p>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="denda">Jumlah Pembayaran</label>&nbsp;
                    <i class="bi bi-cash-coin"></i>
                    <input type="number" class="form-control" id="uang_pembayaran" placeholder="Rp. 0" required>
                    <span id="denda_error" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="tanggalPembayaran">Tanggal Pembayaran</label>&nbsp;
                    <i class="bi bi-calendar-check"></i>
                    <input type="date" class="form-control" id="tanggalPembayaran" required>
                    <span id="tgl_pembayaran_error" class="text-danger"></span>
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="bayar">
               Simpan
            </button>
        </div>
    </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title text-center">Daftar Denda</h2>
                    </div>
                    <div class="card-body">
                        <table id="tbl_denda" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peminjam</th>
                                    <th>Buku</th>
                                    <th>Jumlah Denda</th>
                                    <th>Jumlah Pembayaran</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Status Denda</th>
                                    <th>Status Pembayaran</th>
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
    <script>
        $(document).ready(function() {
            $('#buku').select2({
                placeholder: "Pilih Buku",
                allowClear: true,
            });
            $('#siswa').select2({
                placeholder: "Pilih Peminjam",
                allowClear: true,
            });


            var table = $('#tbl_denda').DataTable({
                serverSide: true,
                scrollX: true,
                ajax: '{{ url('/table-denda') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        data: 'usr_nama',
                        class: 'text-center'
                    },
                    {
                        data: 'dbuku_judul',
                        class: 'text-center'
                    },
                    {
                        data: 'jumlah',
                        class: 'text-center'
                    },
                    {
                        data: 'jumlah_bayar',
                        class: 'text-center'
                    },
                    {
                        data: 'tgl_pembayaran',
                        class: 'text-center',
                        render: function(data) {
                            if (data == null) {
                                return '-';
                            } else {
                                return new Date(data) .toLocaleDateString('id-ID');
                            }
                        }
                    },
                    {
                        data: 'status_denda',
                        render: function(data) {
                            if (data == 1) {
                                return 'Sudah bayar';
                            } else {
                                return 'Belum bayar';
                            }
                        },
                        class: 'text-center'
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            if (data == 0) {
                                return 'Belum Lunas';
                            } else if (data == 1) {
                                return 'Lunas';
                            } else {
                                return 'Belum Bayar';
                            }
                        },
                        class: 'text-center'
                    }
                ]
            });
            $('#pembayaran').find('#tanggalPembayaran').val('');
            $('#pembayaran').find('#uang_pembayaran').val('');
            $('#siswa').on('change', function() {
                var siswaId = $(this).val();
                if (siswaId) {
                    $.ajax({
                        url: `/denda-detail/${siswaId}`,
                        type: 'GET',
                        success: function(response) {
                            $('#pembayaran').find('#tanggalPembayaran').val(new Date().toISOString().slice(0, 10));
                            $('#pembayaran').find('#buku').empty();
                            $('#pembayaran').find('#buku').append(
                                '<option value="">Pilih Buku</option>');
                            $.each(response, function(index, value) {
                                $('#pembayaran').find('#buku').append(
                                    '<option value="' + value.id_tdenda + '">' +
                                    value.dbuku_judul + '</option>');
                            });
                        }
                    });
                } else {
                    $('#pembayaran').find('#buku').val('');
                    $('#pembayaran').find('#tanggalPeminjaman').text('Tanggal Pinjam');
                    $('#pembayaran').find('#tanggalJatuhTempo').text('Jatuh Tempo');
                    $('#pembayaran').find('#jumlahDenda').text('0');
                    $('#pembayaran').find('#tanggalPembayaran').val('');
                    $('#pembayaran').find('#buku').empty();
                }
            });

            $('#buku').on('change', function() {
                var dendaId = $(this).val();
                if (dendaId) {
                    $.ajax({
                        url: `/denda-buku-detail/${dendaId}`,
                        type: 'GET',
                        success: function(response) {
                            $('#pembayaran').find('#tanggalPeminjaman').text(response
                                .trks_tgl_peminjaman == null ? new Date().toLocaleDateString('id-ID') : response.trks_tgl_peminjaman.split(' ')[0]);
                            $('#pembayaran').find('#tanggalJatuhTempo').text(response
                                .trks_tgl_jatuh_tempo == null ? new Date().toLocaleDateString('id-ID') : response.trks_tgl_jatuh_tempo.split(' ')[0]);
                            $('#pembayaran').find('#jumlahDenda').text(response.jumlah);
                            $('#pembayaran').find('#buku_error').text('');
                            $('#pembayaran').find('#denda_error').text('');
                            $('#pembayaran').find('#tgl_pembayaran_error').text('');
                        }
                    });
                } else {
                    $('#pembayaran').find('#tanggalPeminjaman').text('Tanggal Peminjaman');
                    $('#pembayaran').find('#tanggalJatuhTempo').text('Tanggal Jatuh Tempo');
                    $('#pembayaran').find('#jumlahDenda').text('0');


                    $('#pembayaran').find('#buku_error').text('');
                    $('#pembayaran').find('#denda_error').text('');
                    $('#pembayaran').find('#tgl_pembayaran_error').text('');
                }
            });

            $('#bayar').click(function(e) {
                e.preventDefault();
                let siswaId = $('#siswa').val();
                let token = $('meta[name="csrf-token"]').attr('content');
                let uang_pembayaran = $('#pembayaran').find('#uang_pembayaran').val();
                let id_denda = $('#pembayaran').find('#buku').val();
                let buku = $('#pembayaran').find('#buku').val();
                let tanggal_pembayaran = $('#pembayaran').find('#tanggalPembayaran').val();
                $.ajax({
                    url: `/denda-bayar`,
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": token,
                        "id_denda": id_denda,
                        "user": siswaId,
                        "denda": uang_pembayaran,
                        "buku": buku,
                        "user": siswaId,
                        "tanggal_pembayaran": tanggal_pembayaran
                    },
                    success: function(response) {
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            editConfirmButton: false,
                            timer: 3000,
                        });
                        $('#pembayaran').find('#siswa').val('');
                        $('#pembayaran').find('#tanggalPeminjaman').text('Tanggal Peminjaman');
                        $('#pembayaran').find('#tanggalJatuhTempo').text('Tanggal Jatuh Tempo');
                        $('#pembayaran').find('#jumlahDenda').val('');
                        $('#pembayaran').find('#tanggalPembayaran').val('');
                        $('#pembayaran').find('#buku').empty();
                        // kosongin span err
                        $('#pembayaran').find('#buku_error').text('');
                        $('#pembayaran').find('#denda_error').text('');
                        $('#pembayaran').find('#user_error').text('');
                        $('#pembayaran').find('#tgl_pembayaran_error').text('');

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var error = $.parseJSON(xhr.responseText);
                            var errors = error.errors;
                            // Tampilkan pesan error dari validasi
                            if (errors.buku) {
                                $('#pembayaran').find('#buku_error').text(errors.buku[0]);
                            } else {
                                $('#pembayaran').find('#buku_error').text('');
                            }
                            if (errors.denda) {
                                $('#pembayaran').find('#denda_error').text(errors.denda[0]);

                            } else {
                                $('#pembayaran').find('#denda_error').text('');
                            }
                            if (errors.tanggal_pembayaran) {
                                $('#pembayaran').find('#tgl_pembayaran_error').text(errors
                                    .tanggal_pembayaran[0]);

                            } else {
                                $('#pembayaran').find('#tgl_pembayaran_error').text('');
                            }
                            if (errors.user) {
                                $('#pembayaran').find('#user_error').text(errors
                                    .user[0]);

                            } else {
                                $('#pembayaran').find('#user_error').text('');
                            }
                        }
                    }
                });
            });
        });
    </script>
@endpush
