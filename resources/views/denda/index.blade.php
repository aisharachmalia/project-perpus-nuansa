@extends('master')

@section('content')
    @push('css')
        <style>
            .container {
                background-color: #fff;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                padding: 30px;
                margin-top: 50px;
            }

            h2 {
                color: #8b4513;
                text-align: center;
                margin-bottom: 30px;
            }

            th {
                color: #8b4513;
            }

            .form-control {
                border-color: #d2b48c;
            }

            .form-control:focus {
                border-color: #8b4513;
                box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
            }

            .btn-primary {
                background-color: #8b4513;
                border-color: #8b4513;
            }

            .btn-primary:hover {
                background-color: #a0522d;
                border-color: #a0522d;
            }

            .btn-primary:focus {
                background-color: #a0522d;
                border-color: #a0522d;
                box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
            }

            .icon-input {
                position: relative;
                margin: 0;
            }

            .icon-input i {
                position: absolute;
                left: 10px;
                top: 33px;
                color: #8b4513;
            }


            .icon-input input {
                padding-left: 35px;
            }

            .icon-input p {
                padding-left: 35px;
                margin: 0;
            }

            .icon-input select {
                padding-left: 35px;
            }

        </style>
    @endpush


    <div class="container mb-5">
        <h2><i class="fas fa-book-reader"></i> Pembayaran Denda Perpustakaan</h2>
        <div id="pembayaran">
            <div class="mb-3 icon-input">
                <div class="form-group">
                    <label for="siswa">Nama Siswa</label>
                    <input type="hidden" id="id_denda">
                    <i class="bi bi-person-fill"></i>
                    <select id="siswa" name="siswa" class="form-control">
                        <option value="">Pilih Siswa</option>
                        @foreach ($siswa as $data)
                            <option value="{{ Crypt::encryptString($data->id_dsiswa) }}">
                                {{ $data->dsiswa_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 icon-input">
                <div class="form-group">
                    <label for="buku">Judul Buku</label>
                    <i class="bi bi-book-fill"></i>
                    <select id="buku" name="buku" class="form-control selectBuku">
                        <option value="">Pilih Buku</option>
                    </select>
                    <span id="buku_error" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-3 icon-input">
                <div class="form-group">
                    <label for="tanggalPeminjaman">Tanggal Pinjam</label>
                    <i class="bi bi-calendar-plus"></i>
                    <p class="form-control" id="tanggalPeminjaman">Tanggal Pinjam</p>
                    <span id="peminjaman_error" class="text-danger"></span>
                </div>
            </div>
            <div class=" mb-3 icon-input">
                <div class="form-group">
                    <label for="tanggalJatuhTempo">Tanggal Jatuh Tempo</label>
                    <i class="bi bi-calendar-x-fill"></i>
                    <p class="form-control" id="tanggalJatuhTempo">Jatuh Tempo</p>
                    <span id="jatuh_tempo_error" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-3 icon-input">
                <div class="form-group">
                    <label for="denda">Jumlah Denda</label>
                    <i class="bi bi-cash-stack"></i>
                    <input type="number" class="form-control" id="jumlahDenda" placeholder="Jumlah Denda" required>
                    <span id="denda_error" class="text-danger"></span>
                </div>
            </div>
            <div class="mb-3 icon-input">
                <div class="form-group">
                    <label for="tanggalPembayaran">Tanggal Pembayaran</label>
                    <i class="bi bi-calendar-check"></i>
                    <input type="date" class="form-control" id="tanggalPembayaran" required>
                    <span id="tgl_pembayaran_error" class="text-danger"></span>
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="bayar">
                <span class="d-none d-sm-block">Simpan</span>
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
                                    <th>Nama Siswa</th>
                                    <th>Buku</th>
                                    <th>Jumlah Denda</th>
                                    <th>Tanggal Pembayaran</th>
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
    <script>
        $(document).ready(function() {
            $('.selectBuku').select2({
                placeholder: "Pilih Buku",
                allowClear: true
            });
            var table = $('#tbl_denda').DataTable({
                serverSide: true,
                ajax: '{{ url('/table-denda') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        data: 'dsiswa_nama',
                        class: 'text-center'
                    },
                    {
                        data: 'dbuku_judul',
                        class: 'text-center'
                    },
                    {
                        data: 'tdenda_jumlah',
                        class: 'text-center'
                    },
                    {
                        data: 'tdenda_tgl_bayar',
                        class: 'text-center',
                        render: function(data) {
                            if (data == null) {
                                return '<span>Belum bayar</span>';
                            } else {
                                return new Date(data).toISOString().slice(0, 10);
                            }
                        }
                    },
                    {
                        data: 'tdenda_status',
                        render: function(data) {
                            if (data != null) {
                                return data;
                            } else {
                                return 'Belum bayar';
                            }
                        },
                        class: 'text-center'
                    }
                ]
            });

            $('#siswa').on('change', function() {
                var siswaId = $(this).val();
                if (siswaId) {
                    $.ajax({
                        url: `/denda-detail/${siswaId}`,
                        type: 'GET',
                        success: function(response) {
                            $('#pembayaran').find('#id_denda').val(response['buku'][0]
                                .id_tdenda);
                            $('#pembayaran').find('#tanggalPembayaran').val(new Date()
                                .toISOString().slice(0, 10));
                            $('#pembayaran').find('#buku').empty();
                            $('#pembayaran').find('#buku').append(
                                '<option value="">Pilih Buku</option>');
                            $.each(response.buku, function(index, value) {
                                $('#pembayaran').find('#buku').append(
                                    '<option value="' + value.id_tdenda + '">' +
                                    value.dbuku_judul + '</option>');
                            });
                        }
                    });
                } else {
                    $('#pembayaran').find('#buku').val('');
                    $('#pembayaran').find('#tanggalPeminjaman').text('Tanggal Pinjam');
                    $('#pembayaran').find('#id_denda').val('');
                    $('#pembayaran').find('#tanggalJatuhTempo').text('Jatuh Tempo');
                    $('#pembayaran').find('#jumlahDenda').val('');
                    $('#pembayaran').find('#tanggalPembayaran').val('');
                    $('#pembayaran').find('#buku').empty();
                    $('#pembayaran').find('#buku').append('<option value="">Pilih Buku</option>');
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
                                .trks_tgl_peminjaman.split(' ')[0]);
                            $('#pembayaran').find('#tanggalJatuhTempo').text(response
                                .trks_tgl_jatuh_tempo.split(' ')[0]);
                            $('#pembayaran').find('#jumlahDenda').val(response.tdenda_jumlah);
                            $('#pembayaran').find('#buku_error').text('');
                            $('#pembayaran').find('#denda_error').text('');
                            $('#pembayaran').find('#tgl_pembayaran_error').text('');
                        }
                    });
                } else {
                    $('#pembayaran').find('#tanggalPeminjaman').text('Tanggal Peminjaman');
                    $('#pembayaran').find('#tanggalJatuhTempo').text('Tanggal Jatuh Tempo');
                    $('#pembayaran').find('#jumlahDenda').val('');


                    $('#pembayaran').find('#buku_error').text('');
                    $('#pembayaran').find('#denda_error').text('');
                    $('#pembayaran').find('#tgl_pembayaran_error').text('');
                }
            });

            $('#bayar').click(function(e) {
                e.preventDefault();
                let siswaId = $('#siswa').val();
                if (!siswaId) {
                    Swal.fire({
                        icon: 'error',
                        title: `Gagal!`,
                        text: 'Siswa harus dipilih',
                        editConfirmButton: false,
                        timer: 3000
                    });
                    return;
                }
                let token = $('meta[name="csrf-token"]').attr('content');
                let denda = $('#pembayaran').find('#jumlahDenda').val();
                let id_denda = $('#pembayaran').find('#id_denda').val();
                let tanggal_pembayaran = $('#pembayaran').find('#tanggalPembayaran').val();
                let id_buku = $('#pembayaran').find('#buku').val();
                $.ajax({
                    url: `/denda-bayar/${id_denda}`,
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": token,
                        "buku": id_buku,
                        "denda": denda,
                        "tanggal_pembayaran": tanggal_pembayaran
                    },
                    success: function(response) {
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            editConfirmButton: false,
                            timer: 3000
                        });
                        $('#pembayaran').find('#siswa').val('');
                        $('#pembayaran').find('#tanggalPeminjaman').text('Tanggal Peminjaman');
                        $('#pembayaran').find('#id_denda').val('');
                        $('#pembayaran').find('#tanggalJatuhTempo').text('Tanggal Jatuh Tempo');
                        $('#pembayaran').find('#jumlahDenda').val('');
                        $('#pembayaran').find('#tanggalPembayaran').val('');
                        $('#pembayaran').find('#buku').empty();
                        $('#pembayaran').find('#buku').append(
                            '<option value="">Pilih Buku</option>');
                        // kosongin span err
                        $('#pembayaran').find('#buku_error').text('');
                        $('#pembayaran').find('#denda_error').text('');
                        $('#pembayaran').find('#tgl_pembayaran_error').text('');
                        location.reload();
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
                        }
                    }
                });
            });
        });
    </script>
@endpush
