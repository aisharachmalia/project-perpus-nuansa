@extends('master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                              <a href="javascript:void(0)" class="btn btn-custom btn-success mb-2 modalCreate" data-bs-toggle="modal" data-bs-target="#tambahPeminjaman">
                                + Peminjaman
                            </a>
                            &nbsp; &nbsp;
                             <a href="javascript:void(0)" class="btn btn-custom btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#tambahPengembalian">
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
                                <th>Judul Buku</th>
                                <th>Nama Siswa</th>
                                <th>Tanggal Peminjaman & Tanggal Jatuh Tempo</th>
                                <th>Tanggal Pengembalian </th>
                                <th>Denda</th>
                                <th>Status</th>
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



    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4>Pengembalian</h4>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <a href="javascript:void(0)" class="btn btn-custom btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#tambahPengembalian">
                                Pengembalian
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tbl_pengembalian" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Nama Siswa</th>
                                <th>Nama Pustakawan</th>
                                <th>Tanggal Peminjaman & Tanggal Jatuh Tempo</th>
                                <th>Tanggal Pengembalian</th>
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
</div> --}}


    <!-- Modal untuk Tambah Peminjaman -->
<div class="modal fade text-left" id="tambahPeminjaman" tabindex="-1" role="dialog" aria-labelledby="modalCreate1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCreate">Tambah Peminjaman</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form" data-action="{{ route('pinjam.store') }}" method="POST" id="pinjamanForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Judul Buku</label>
                               <select id="id_dbuku" name="id_dbuku" class="form-control">
                    <option value="">Pilih Buku</option>
                    @foreach ($buku as $data)
                        <option value="{{ Crypt::encryptString($data->id_dbuku) }}">
                            {{ $data->dbuku_judul }}</option>
                    @endforeach
                </select>
                                <span id="buku-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="last-name-column">Nama Siswa</label>
                                <select id="id_dsiswa" name="id_dsiswa" class="form-control">
                    <option value="">Pilih Siswa</option>
                    @foreach ($siswa as $data)
                        <option value="{{ Crypt::encryptString($data->id_dsiswa) }}">
                            {{ $data->dsiswa_nama }}</option>
                    @endforeach
                </select>
                                <span id="siswa-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="city-column">Nama Pustakawan</label>
                                           <select id="id_dpustakawan" name="id_dpustakawan" class="form-control">
                    <option value="">Pilih Pustakawan</option>
                    @foreach ($pustakawan as $data)
                        <option value="{{ Crypt::encryptString($data->id_dpustakawan) }}">
                            {{ $data->dpustakawan_nama }}</option>
                    @endforeach
                </select>
                                <span id="pustakawan-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">Tanggal Peminjaman</label>
                                <input type="date" class="form-control" placeholder="tanggal pinjam" name="trks_tgl_peminjaman" id="trks_tgl_peminjaman">
                                <span id="tgl-pinjam-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">Tanggal Jatuh Tempo</label>
                                <input type="date" class="form-control" placeholder="tanggal jatuh tempo" name="trks_tgl_jatuh_tempo" id="trks_tgl_jatuh_tempo">
                                <span id="tgl-jatuh-tempo-error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-custom btn-primary ml-1" id="storePinjaman">
             <i class="bx bx-check d-block d-sm-none"></i>
             <span class="d-none d-sm-block">Simpan</span>
        </button>
            </div>
        </div>
    </div>
</div>

@include('transaksi.edit_trks')

    {{-- end modal peminjaman --}}



    {{-- create --}}
    <!-- Modal untuk Pengembalian -->
<div class="modal fade text-left" id="tambahPengembalian" tabindex="-1" role="dialog" aria-labelledby="modalPengembalian">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalPengembalian">Pengembalian</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="first-name-column">Judul Buku</label>
                            <select id="id_dbuku" name="id_dbuku" class="form-control">
                                <option value="">Pilih Buku</option>
                                @foreach ($buku as $data)
                                    <option value="{{ Crypt::encryptString($data->id_dbuku) }}">
                                        {{ $data->dbuku_judul }}</option>
                                @endforeach
                            </select>
                            <span id="buku-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="last-name-column">Nama Siswa</label>
                            <select id="id_dsiswa" name="id_dsiswa" class="form-control">
                                <option value="">Pilih Siswa</option>
                                @foreach ($siswa as $data)
                                    <option value="{{ Crypt::encryptString($data->id_dsiswa) }}">
                                        {{ $data->dsiswa_nama }}</option>
                                @endforeach
                            </select>
                            <span id="siswa-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="city-column">Nama Pustakawan</label>
                            <select id="id_dpustakawan" name="id_dpustakawan" class="form-control">
                                <option value="">Pilih Pustakawan</option>
                                @foreach ($pustakawan as $data)
                                    <option value="{{ Crypt::encryptString($data->id_dpustakawan) }}">
                                        {{ $data->dpustakawan_nama }}</option>
                                @endforeach
                            </select>
                            <span id="pustakawan-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="country-floating">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" name="trks_tgl_peminjaman" id="trks_tgl_peminjaman">
                            <span id="tgl-pinjam-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="country-floating">Tanggal Jatuh Tempo</label>
                            <input type="date" class="form-control" name="trks_tgl_jatuh_tempo" id="trks_tgl_jatuh_tempo">
                            <span id="tgl-jatuh-tempo-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="country-floating">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" name="trks_tgl_pengembalian" id="trks_tgl_pengembalian">
                            <span id="tgl-pengembalian-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="country-floating">Denda</label>
                            <input type="text" class="form-control" name="trks_denda" id="trks_denda">
                            <span id="denda-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="country-floating">Keterangan</label>
                            <input type="text" class="form-control" name="trks_keterangan" id="trks_keterangan">
                            <span id="keterangan-error" class="text-danger"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-custom btn-primary ml-1" id="store">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>
    {{-- end modal pengembalian --}}
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
        var table = $('#tbl_transaksi').DataTable({
    serverSide: true,
    ajax: '{{ url()->current() }}',
    columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            class: "text-center"
        },
        {
            class: "text-center",
            data: 'dbuku_judul',
            name: 'dbuku_judul'
        },
        {
            class: "text-center",
            data: 'dsiswa_nama',
            name: 'dsiswa_nama'
        },
        {
            class: "text-center",
            data: null,
            render: function(data, type, row) {
                return '<strong>' + row.trks_tgl_peminjaman + '</strong><br>' + row.trks_tgl_jatuh_tempo;
            }
        },
        {
                class: "text-center",
                data: 'trks_tgl_pengembalian'
            },
        {
                class: "text-center",
                data: 'trks_denda'   
        },
        {
                data: 'trks_status',
                className: 'dt-body-center',
                    render: function(data) {
                       if (data == 1) {
                            return '<span class="badge bg-warning">Dipinjam</span>';
                       } if (data == 2) {
                            return '<span class="badge bg-success">Dikembalikan</span>';
                       } if (data == 3) {
                            return '<span class="badge bg-danger">Denda</span>';
                       }
                        }
                    },
        {
            data: 'aksi',
            orderable: false
        }
    ]
});

    // var table = $('#tbl_pengembalian').DataTable({
    //     serverSide: true,
    //     ajax: '{{ url()->current() }}',
    //     columns: [{
    //             data: 'DT_RowIndex',
    //             orderable: false,
    //             searchable: false,
    //             class: "text-center"
    //         },
    //         {
    //         class: "text-center",
    //         data: 'dbuku_judul',
    //         name: 'dbuku_judul'
    //     },
    //     {
    //         class: "text-center",
    //         data: 'dsiswa_nama',
    //         name: 'dsiswa_nama'
    //     },
    //     {
    //         class: "text-center",
    //         data: 'dpustakawan_nama',
    //         name: 'dpustakawan_nama'
    //     },
    //         {
    //             class: "text-center",
    //             data: null,
    //             render: function(data, type, row) {
    //                 return '<strong>' + row.trks_tgl_peminjaman + '</strong><br>' + row.trks_tgl_jatuh_tempo;
    //             }
    //         },
    //         {
    //             class: "text-center",
    //             data: 'trks_tgl_pengembalian'
    //         },
    //          {
    //             class: "text-center",
    //             data: null,
    //             render: function(data, type, row) {
    //                 return '<strong>' + row.trks_denda + '</strong><br>' + row.trks_keterangan;
    //             }
    //         },
    //         {
    //             data: 'aksi',
    //             orderable: false
    //         }
    //     ]
    // });
     });
    </script>

    {{-- js ajax peminjaman --}}
    <script>
        // ajax edit
        $('body').on('click', '.modalEditPeminjaman', function() {
            let id_trks = $(this).data('id');
                $.ajax({
                url: `peminjaman/show/${id_trks}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#editPeminjaman').find('#id_trks').val(id_trks);
                    $('#editPeminjaman').find('#id_dbuku').val(response.peminjaman.id_dbuku);
                    $('#editPeminjaman').find('#id_dsiswa').val(response.peminjaman.id_dsiswa);
                    $('#editPeminjaman').find('#id_dpustakawan').val(response.peminjaman.id_dpustakawan);
                    $('#editPeminjaman').find('#trks_tgl_peminjaman').val(response.peminjaman.trks_tgl_peminjaman);
                    $('#editPeminjaman').find('#trks_tgl_jatuh_tempo').val(response.peminjaman.trks_tgl_jatuh_tempo);
                    $('#editPeminjaman').find('#trks_tgl_pengembalian').val(response.peminjaman.trks_tgl_pengembalian);
                    $('#editPeminjaman').find('#trks_denda').val(response.peminjaman.trks_denda);
                    $('#editPeminjaman').find('#trks_status').val(response.peminjaman.trks_status);
                    $('#editPeminjaman').find('#trks_keterangan').val(response.peminjaman.trks_keterangan);
                },
                error: function(xhr) {
                    console.log("Error fetching data:", xhr);
                }
            });
        });

        // Setup CSRF token untuk semua request AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Update peminjaman
        $('#updatePeminjaman').on('click', function(e) {
            e.preventDefault();

            let id_trks = $('#editPeminjaman').find('#id_trks').val();
            let id_dbuku = $('#editPeminjaman').find('#id_dbuku').val();
            let id_dsiswa = $('#editPeminjaman').find('#id_dsiswa').val();
            let id_dpustakawan = $('#editPeminjaman').find('#id_dpustakawan').val();
            let trks_tgl_peminjaman = $('#editPeminjaman').find('#trks_tgl_peminjaman').val();
            let trks_tgl_jatuh_tempo = $('#editPeminjaman').find('#trks_tgl_jatuh_tempo').val();
            let trks_tgl_pengembalian = $('#editPeminjaman').find('#trks_tgl_pengembalian').val();
            let trks_denda = $('#editPeminjaman').find('#trks_denda').val();
            let trks_status = $('#editPeminjaman').find('#trks_status').val();
            let trks_keterangan = $('#editPeminjaman').find('#trks_keterangan').val();
            let token = $("meta[name='csrf-token']").attr("content");
       
            $.ajax({
              url: `/peminjaman/update/${id_trks}`, // Menggunakan id peminjaman
              type: "PUT",
              data: {
                    "_method": "PUT",
                    "id_dbuku": id_dbuku,
                    "id_dsiswa": id_dsiswa,
                    "id_dpustakawan": id_dpustakawan,
                    "trks_tgl_peminjaman": trks_tgl_peminjaman,
                    "trks_tgl_jatuh_tempo": trks_tgl_jatuh_tempo,
                    "trks_tgl_pengembalian": trks_tgl_pengembalian,
                    "trks_denda": trks_denda,
                    "trks_status": trks_status,
                    "trks_keterangan": trks_keterangan,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#editPeminjaman').modal('toggle');
                    $('.modal-backdrop').remove();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        if (xhr.responseText) {
                            var errors = JSON.parse(xhr.responseText).errors;
                            // Tampilkan error di form
                            if (errors.id_dbuku) {
                                $('#editPeminjaman').find('#buku-error').text(errors.id_dbuku[0]);
                            }
                            if (errors.id_dsiswa) {
                                $('#editPeminjaman').find('#siswa-error').text(errors.id_dsiswa[0]);
                            }
                            if (errors.id_dpustakawan) {
                                $('#editPeminjaman').find('#pustakawan-error').text(errors.id_dpustakawan[0]);
                            }
                            if (errors.trks_tgl_peminjaman) {
                                $('#editPeminjaman').find('#tgl-pinjam-error').text(errors.trks_tgl_peminjaman[0]);
                            }
                            if (errors.trks_tgl_jatuh_tempo) {
                                $('#editPeminjaman').find('#tgl-jatuh-tempo-error').text(errors.trks_tgl_jatuh_tempo[0]);
                            }
                             if (errors.trks_tgl_pengembalian) {
                                $('#editPeminjaman').find('#tgl-pengembalian-error').text(errors.trks_tgl_pengembalian[0]);
                            }
                            if (errors.trks_denda) {
                                $('#editPeminjaman').find('#denda-error').text(errors.trks_denda[0]);
                            }
                            // if (errors.trks_status) {
                            //     $('#editPeminjaman').find('#status-error').text(errors.trks_status[0]);
                            // }
                            if (errors.trks_keterangan) {
                                $('#editPeminjaman').find('#keterangan-error').text(errors.trks_keterangan[0]);
                            }
                        } else {
                            console.log("Error structure not as expected :", xhr.responseJSON);
                        }
                    } else {
                        console.log("Unexpected error:", xhr);
                    }
                }
            });
            // Hapus pesan error sebelumnya
            $('#editPeminjaman').find('#buku-error').text('');
            $('#editPeminjaman').find('#siswa-error').text('');
            $('#editPeminjaman').find('#pustakawan-error').text('');
            $('#editPeminjaman').find('#tgl-pinjam-error').text('');
            $('#editPeminjaman').find('#tgl-jatuh-tempo-error').text('');
            $('#editPeminjaman').find('#tgl-pengembalian-error').text('');
            $('#editPeminjaman').find('#denda-error').text('');
            // $('#editPeminjaman').find('#status-error').text('');
            $('#editPeminjaman').find('#keterangan-error').text('');
        });

            
        // ajax add
        $('body').on('click', '.modalSimpanPeminjaman', function() {
            $('#buku-error').text('');
            $('#siswa-error').text('');
            $('#pustakawan-error').text('');
            $('#tgl-pinjam-error').text('');
            $('#tgl-jatuh-tempo-error').text('');

            $('#tambahPeminjaman').find('#id_dbuku').val();
            $('#tambahPeminjaman').find('#id_dsiswa').val();
            $('#tambahPeminjaman').find('#id_dpustakawan').val();
            $('#tambahPeminjaman').find('#trks_tgl_peminjaman').val();
            $('#tambahPeminjaman').find('#trks_tgl_jatuh_tempo').val();

        });

        $('#storePinjaman').off('click').on('click', function(e) {
    e.preventDefault();

    var form = $("#pinjamanForm")[0];
    var data = new FormData(form);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/peminjaman/add', // Pastikan URL benar sesuai rute Anda
        type: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: `${response.message}`,
                showConfirmButton: false,
                timer: 3000
            });
            // Tambahkan jika ingin melakukan refresh atau reset form
            $('#pinjamanForm')[0].reset(); // Reset form setelah sukses
        },
        error: function(xhr, status, error) {
            // Jika error, misalnya 422 (unprocessable entity)
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                // Tangani pesan error dan tampilkan sesuai kebutuhan Anda
                $.each(errors, function(key, value) {
                    // Misal tampilkan di alert atau di form sebagai pesan error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: value[0],
                        timer: 3000
                    });
                });
            } else {
                // Error lainnya, misalnya 500 (internal server error)
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server.',
                    timer: 3000
                });
            }
        }
    });
});


        $('#simpanPeminjaman').on('click','#store', function(e) {
            e.preventDefault();
            console.log('a');
            let id_dbuku = $('#tambahPeminjaman').find('#id_dbuku').val();
            let id_dsiswa = $('#tambahPeminjaman').find('#id_dsiswa').val();
            let id_pustakawan = $('#tambahPeminjaman').find('#id_dpustakawan').val();
            let trks_tgl_peminjaman = $('#tambahPeminjaman').find('#trks_tgl_peminjaman').val();
            let trks_tgl_jatuh_tempo = $('#tambahPeminjaman').find('#trks_tgl_jatuh_tempo').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `peminjaman/add`,
                type: "POST",
                cache: false,
                data: {
                    "id_dbuku": id_dbuku,
                    "id_dsiswa": id_dsiswa,
                    "id_pustakawan": id_pustakawan,
                    "trks_tgl_peminjaman": trks_tgl_peminjaman,
                    "trks_tgl_jatuh_tempo": trks_tgl_jatuh_tempo,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#tambahPeminjaman').modal('toggle');
                    $('.modal-backdrop').remove();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        // Tampilkan pesan error dari validasi
                        if (errors.id_dbuku) {
                                $('#tambahPeminjaman').find('#buku-error').text(errors.id_dbuku[0]);
                            }
                            if (errors.id_dsiswa) {
                                $('#tambahPeminjaman').find('#siswa-error').text(errors.id_dsiswa[0]);
                            }
                            if (errors.id_dpustakawan) {
                                $('#tambahPeminjaman').find('#pustakawan-error').text(errors.id_dpustakawan[0]);
                            }
                            if (errors.trks_tgl_peminjaman) {
                                $('#tambahPeminjaman').find('#tgl-pinjam-error').text(errors.trks_tgl_peminjaman[0]);
                            }
                            if (errors.trks_tgl_jatuh_tempo) {
                                $('#tambahPeminjaman').find('#tgl-jatuh-tempo-error').text(errors.trks_tgl_jatuh_tempo[0]);
                            }
                        } else {
                            console.log("Error structure not as expected :", xhr.responseJSON);
                        }
                }
            });
        });


        // ajax delete
        $('body').on('click', '#btn-delete-peminjaman', function() {

            let id_dsiswa = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {

                    console.log('test');

                    //fetch to delete data
                    $.ajax({

                        url: `peminjaman/delete/${id_dsiswa}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            })
            $('#tbl_peminjaman').DataTable().ajax.reload()
        });
    </script>
    {{-- end ajax peminjaman --}}


    {{-- js ajax pengembalian --}}
    <script>

        // $('body').on('click', '.modalEditPengembalian', function() {
        //     let id_trks = $(this).data('id');
        //         $.ajax({
        //         url: `pengembalian/show/${id_trks}`,
        //         type: "GET",
        //         cache: false,
        //         success: function(response) {
        //             $('#editPengembalian').find('#id_trks').val(id_trks);
        //             $('#editPengembalian').find('#id_dbuku').val(response.peminjaman.id_dbuku);
        //             $('#editPengembalian').find('#id_dsiswa').val(response.peminjaman.id_dsiswa);
        //             $('#editPengembalian').find('#id_dpustakawan').val(response.peminjaman.id_dpustakawan);
        //             $('#editPengembalian').find('#trks_tgl_peminjaman').val(response.peminjaman.trks_tgl_peminjaman);
        //             $('#editPengembalian').find('#trks_tgl_jatuh_tempo').val(response.peminjaman.trks_tgl_jatuh_tempo);
        //             $('#editPengembalian').find('#trks_tgl_pengembalian').val(response.peminjaman.trks_tgl_pengembalian);
        //             $('#editPengembalian').find('#trks_denda').val(response.peminjaman.trks_denda);
        //             $('#editPengembalian').find('#trks_keterangan').val(response.peminjaman.trks_keterangan);
        //         },
        //         error: function(xhr) {
        //             console.log("Error fetching data:", xhr);
        //         }
        //     });
        // });

        // // Setup CSRF token untuk semua request AJAX
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        // // Update peminjaman
        // $('#updatePeminjaman').off('click').on('click', function(e) {
        //     e.preventDefault();

        //     let id_trks = $('#editPengembalian').find('#id_trks').val();
        //     let id_dbuku = $('#editPengembalian').find('#id_dbuku').val();
        //     let id_dsiswa = $('#editPengembalian').find('#id_dsiswa').val();
        //     let id_dpustakawan = $('#editPengembalian').find('#id_dpustakawan').val();
        //     let trks_tgl_peminjaman = $('#editPengembalian').find('#trks_tgl_peminjaman').val();
        //     let trks_tgl_jatuh_tempo = $('#editPengembalian').find('#trks_tgl_jatuh_tempo').val();
        //     let trks_tgl_pengembalian = $('#editPengembalian').find('#trks_tgl_pengembalian').val();
        //     let trks_denda = $('#editPengembalian').find('#trks_denda').val();
        //     let trks_keterangan = $('#editPengembalian').find('#trks_keterangan').val();
        //     let token = $("meta[name='csrf-token']").attr("content");
            
        //     $.ajax({
        //       url: `/pengembalian/update/${id_trks}`, // Menggunakan id peminjam
        //       type: "PUT",
        //       data: {
        //             "_method": "PUT",
        //             "id_dbuku": id_dbuku,
        //             "id_dsiswa": id_dsiswa,
        //             "id_dpustakawan": id_dpustakawan,
        //             "trks_tgl_peminjaman": trks_tgl_peminjaman,
        //             "trks_tgl_jatuh_tempo": trks_tgl_jatuh_tempo,
        //             "trks_tgl_pengembalian": trks_tgl_pengembalian,
        //             "trks_denda": trks_denda,
        //             "trks_keterangan": trks_keterangan,
        //             "_token": token
        //         },
        //         success: function(response) {
        //             Swal.fire({
        //                 icon: 'success',
        //                 title: `${response.message}`,
        //                 showConfirmButton: false,
        //                 timer: 3000
        //             });
        //             $('#editPengembalian').modal('toggle');
        //             $('.modal-backdrop').remove();
        //         },
        //         error: function(xhr) {
        //             if (xhr.status === 422) {
        //                 if (xhr.responseText) {
        //                     var errors = JSON.parse(xhr.responseText).errors;
        //                     // Tampilkan error di form
        //                     if (errors.id_dbuku) {
        //                         $('#editPengembalian').find('#buku-error').text(errors.id_dbuku[0]);
        //                     }
        //                     if (errors.id_dsiswa) {
        //                         $('#editPengembalian').find('#siswa-error').text(errors.id_dsiswa[0]);
        //                     }
        //                     if (errors.id_dpustakawan) {
        //                         $('#editPengembalian').find('#pustakawan-error').text(errors.id_dpustakawan[0]);
        //                     }
        //                     if (errors.trks_tgl_peminjaman) {
        //                         $('#editPengembalian').find('#tgl-pinjam-error').text(errors.trks_tgl_peminjaman[0]);
        //                     }
        //                     if (errors.trks_tgl_jatuh_tempo) {
        //                         $('#editPengembalian').find('#tgl-jatuh-tempo-error').text(errors.trks_tgl_jatuh_tempo[0]);
        //                     }
        //                     if (errors.trks_tgl_pengembalian) {
        //                         $('#editPengembalian').find('#tgl-pengembalian-error').text(errors.trks_tgl_pengembalian[0]);
        //                     }
        //                     if (errors.trks_denda) {
        //                         $('#editPengembalian').find('#denda-error').text(errors.trks_denda[0]);
        //                     }
        //                     if (errors.trks_keterangan) {
        //                         $('#editPengembalian').find('#keterangan-error').text(errors.trks_keterangan[0]);
        //                     }
                            
        //                 } else {
        //                     console.log("Error structure not as expected :", xhr.responseJSON);
        //                 }
        //             } else {
        //                 console.log("Unexpected error:", xhr);
        //             }
        //         }
        //     });
        //     // Hapus pesan error sebelumnya
        //     $('#editPengembalian').find('#buku-error').text('');
        //     $('#editPengembalian').find('#siswa-error').text('');
        //     $('#editPengembalian').find('#pustakawan-error').text('');
        //     $('#editPengembalian').find('#tgl-pinjam-error').text('');
        //     $('#editPengembalian').find('#tgl-jatuh-tempo-error').text('');
        //     $('#editPengembalian').find('#tgl-pengembalian-error').text('');
        //     $('#editPengembalian').find('#denda-error').text('');
        //     $('#editPengembalian').find('#keterangan-error').text('');
        // });

           

        // ajax add

        // Kosongkan error saat membuka modal
                $('body').on('click', '.modalSimpanPengembalian', function() {
                $('#tambahPengembalian').find('#buku-error').text('');
                $('#tambahPengembalian').find('#siswa-error').text('');
                $('#tambahPengembalian').find('#pustakawan-error').text('');
                $('#tambahPengembalian').find('#tgl-pinjam-error').text('');
                $('#tambahPengembalian').find('#tgl-jatuh-tempo-error').text('');
                $('#tambahPengembalian').find('#tgl-pengembalian-error').text('');
                $('#tambahPengembalian').find('#denda-error').text('');
                $('#tambahPengembalian').find('#keterangan-error').text('');
            });

            // Ganti dari trigger modal ke tombol Simpan
            $('#store').on('click', function(e) {
                e.preventDefault();
                
                let id_dbuku = $('#tambahPengembalian').find('#id_dbuku').val();
                let id_dsiswa = $('#tambahPengembalian').find('#id_dsiswa').val();
                let id_dpustakawan = $('#tambahPengembalian').find('#id_dpustakawan').val();
                let trks_tgl_peminjaman = $('#tambahPengembalian').find('#trks_tgl_peminjaman').val();
                let trks_tgl_jatuh_tempo = $('#tambahPengembalian').find('#trks_tgl_jatuh_tempo').val();
                let trks_tgl_pengembalian = $('#tambahPengembalian').find('#trks_tgl_pengembalian').val();
                let trks_denda = $('#tambahPengembalian').find('#trks_denda').val();
                let trks_keterangan = $('#tambahPengembalian').find('#trks_keterangan').val();
                let token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: `{{ route('pengembalian.store') }}`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_dbuku": id_dbuku,
                        "id_dsiswa": id_dsiswa,
                        "id_dpustakawan": id_dpustakawan,
                        "trks_tgl_peminjaman": trks_tgl_peminjaman,
                        "trks_tgl_jatuh_tempo": trks_tgl_jatuh_tempo,
                        "trks_tgl_pengembalian": trks_tgl_pengembalian,
                        "trks_denda": trks_denda,
                        "trks_keterangan": trks_keterangan,
                        "_token": token
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                        $('#tambahPengembalian').modal('toggle');
                        $('.modal-backdrop').remove();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var error = $.parseJSON(xhr.responseText);
                            var errors = error.errors;
                            console.log(errors);
                            // Tampilkan pesan error dari validasi
                            if (errors.id_dbuku) {
                                $('#tambahPengembalian').find('#buku-error').text(errors.id_dbuku[0]);
                            }
                            if (errors.id_dsiswa) {
                                $('#tambahPengembalian').find('#siswa-error').text(errors.id_dsiswa[0]);
                            }
                            if (errors.id_dpustakawan) {
                                $('#tambahPengembalian').find('#pustakawan-error').text(errors.id_dpustakawan[0]);
                            }
                            if (errors.trks_tgl_peminjaman) {
                                $('#tambahPengembalian').find('#tgl-pinjam-error').text(errors.trks_tgl_peminjaman[0]);
                            }
                            if (errors.trks_tgl_jatuh_tempo) {
                                $('#tambahPengembalian').find('#tgl-jatuh-tempo-error').text(errors.trks_tgl_jatuh_tempo[0]);
                            }
                            if (errors.trks_tgl_pengembalian) {
                                $('#tambahPengembalian').find('#tgl-pengembalian-error').text(errors.trks_tgl_pengembalian[0]);
                            }
                            if (errors.trks_denda) {
                                $('#tambahPengembalian').find('#denda-error').text(errors.trks_denda[0]);
                            }
                            if (errors.trks_keterangan) {
                                $('#tambahPengembalian').find('#keterangan-error').text(errors.trks_keterangan[0]);
                            }
                        } else {
                            console.log("Error structure not as expected:", xhr.responseJSON);
                        }
                    }
                });
            });



        // ajax delete
        $('body').on('click', '#btn-delete-pengembalian', function() {

            let id_dsiswa = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({

                        url: `pengembalian/delete/${id_dsiswa}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            })
            $('#tbl_pengembalian').DataTable().ajax.reload()
        });
    </script>
    {{-- end ajax penerbit --}}
@endpush
