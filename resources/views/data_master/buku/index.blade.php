@extends('master')
<style>

</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="javascript:void(0)" class="btn btn-success mb-2 modalCreate" data-bs-toggle="modal"
                                    data-bs-target="#createBuku">+ Tambah</a>
                                &nbsp;&nbsp;
                                <a href="javascript:;" class="btn btn-success mb-2" id="export"> Export Excel</a>
                                &nbsp;&nbsp;
                                <a href="javascript:;" class="btn btn-danger mb-2" id="printout"> Printout Pdf</a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_dmbuku" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="10%">cover</th>
                                    <th>ISBN<br>Judul</th>
                                    <th>Penerbit<br>Penulis</th>
                                    <th width="10%">Jumlah Tersedia</th>
                                    <th width="10%">Jumlah Total</th>
                                    <th width="10%">
                                        <center>Aksi</center>
                                    </th>
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
    @include('data_master.buku.modal')
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var crud_buku = "{{ route('crud_dm_buku') }}";

            var link_export = "{{ route('link_export_buku') }}";
            var link_printout = "{{ route('link_printout_buku') }}";

            var table = $('#tbl_dmbuku').DataTable({
                serverSide: true,
                scrollX: true,
                ajax: "{{ route('table_dm_buku') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        data: 'dbuku_cover',
                        class: 'object-fit-cover',
                        render: function(data, type, row) {
                            // Use the asset() helper function to get the full URL
                            var defaultImage = '/assets/images/buku/default.jpg';
                            return '<img src="' + data +
                                '" width="100px" height="100px" onerror="this.onerror=null;this.src=\'' + defaultImage + '\';" style="width: 100%; height: 100%; object-fit: cover; object-position: center">'; // Optional: default image on error
                        }
                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            let isbn = row.dbuku_isbn ? row.dbuku_isbn : '-';
                            let judul = row.dbuku_judul ? row.dbuku_judul : '-';
                            return '<strong>' + isbn + '</strong><br>' + judul;
                        }
                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            let penerbit = row.dpenerbit_nama_penerbit ? row
                                .dpenerbit_nama_penerbit : '-';
                            let penulis = row.dpenulis_nama_penulis ? row.dpenulis_nama_penulis :
                                '-';
                            return '<strong>' + penerbit + '</strong><br>' + penulis;
                        }
                    },
                    {
                        class: "text-center",
                        data: 'dbuku_jml_tersedia',
                    },
                    {
                        class: "text-center",
                        data: 'dbuku_jml_total',
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false,
                    }
                ]
            });


            $(document).on('click', '#export', function() {
                var value_table = $('#tbl_dmbuku').DataTable().data().count();
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

            $(document).on('click', '#printout', function() {
                var value_table = $('#tbl_dmbuku').DataTable().data().count();
                if (value_table > 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: link_printout,
                        dataType: 'json',
                        data: {},
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

        // Show modal
        $('body').on('click', '.modalShow', function() {
            let id_bk = $(this).data('id');

            // Fetch detail post with ajax
            $.ajax({
                url: `buku/show/${id_bk}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response);

                    // Fill data into the modal
                    $('#show').find('#dbuku_isbn').text(response.bk[0].dbuku_isbn);
                    $('#show').find('#dbuku_cover').attr('src', response.img).on('error', function() {
                        $(this).attr('src', '/storage/cover/default.jpg');
                    });
                    $('#show').find('#dbuku_judul').text(response.bk[0].dbuku_judul);
                    $('#show').find('#id_penerbit').text(response.bk[0].dpenerbit_nama_penerbit);
                    $('#show').find('#id_penulis').text(response.bk[0].dpenulis_nama_penulis);
                    $('#show').find('#dbuku_thn_terbit').text(response.bk[0].dbuku_thn_terbit);
                    $('#show').find('#dbuku_jml_total').text(response.bk[0]
                        .dbuku_jml_total); // Available quantity
                    $('#show').find('#dbuku_bahasa').text(response.bk[0].dbuku_bahasa);
                    $('#show').find('#dbuku_edisi').text(response.bk[0].dbuku_edisi);
                    $('#show').find('#dbuku_lokasi_rak').text(response.bk[0]
                        .dbuku_lokasi_rak);
                },
                error: function(error) {
                    console.log("Error:", error);
                }
            });
        });

        $('body').on('click', '.modalCreate', function() {
            $('#createBuku').find('input, textarea, select').val('');
            $('#createBuku').find('img').attr('src', '');
            $('#createBuku').find('#file-error').text('');
            $('#createBuku').find('#cover-error').text('');
            $('#createBuku').find('#isbn-error').text('');
            $('#createBuku').find('#judul-error').text('');
            $('#createBuku').find('#penerbit-error').text('');
            $('#createBuku').find('#penulis-error').text('');
            $('#createBuku').find('#thn_terbit-error').text('');
            $('#createBuku').find('#jml_total-error').text('');
            $('#createBuku').find('#bahasa-error').text('');
            $('#createBuku').find('#edisi-error').text('');
            $('#createBuku').find('#lokasi_rak-error').text('');
        });

        $('#store').off('click').on('click', function(e) {
            e.preventDefault();

            var form = $("#form_buku")[0];
            var data = new FormData(form);
            let button = $(this);
            button.prop('disabled', true).html('Mohon Tunggu...');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'crud-buku',
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
                    $('#createBuku').modal('toggle');
                    $('#tbl_dmbuku').DataTable().ajax.reload();

                    $('#createBuku')[0].reset();
                },
                error: function(xhr) {
                    console.log(xhr.status);
                    if (xhr.status === 422) {
                        // Parse the JSON response
                        var response = JSON.parse(xhr.responseText);
                        var errors = response.errors;
                        if (errors.dbuku_cover) {
                            $('#createBuku').find('#cover-error').text(errors.dbuku_cover[0]);
                        } else {
                            $('#createBuku').find('#cover-error').text('');
                        }
                        if (errors.dbuku_isbn) {
                            $('#createBuku').find('#isbn-error').text(errors.dbuku_isbn[0]);
                        } else {
                            $('#createBuku').find('#isbn-error').text('');
                        }
                        if (errors.dbuku_judul) {
                            $('#createBuku').find('#judul-error').text(errors.dbuku_judul[0]);
                        } else {
                            $('#createBuku').find('#judul-error').text('');
                        }
                        if (errors.dbuku_bahasa) {
                            $('#createBuku').find('#bahasa-error').text(errors.dbuku_bahasa[0]);
                        } else {
                            $('#createBuku').find('#bahasa-error').text('');
                        }
                        if (errors.dbuku_file) {
                            $('#createBuku').find('#file-error').text(errors.dbuku_file[0]);
                        } else {
                            $('#createBuku').find('#file-error').text('');
                        }
                        if (errors.dbuku_lokasi_rak) {
                            $('#createBuku').find('#lokasi_rak-error').text(errors.dbuku_lokasi_rak[0]);
                        } else {
                            $('#createBuku').find('#lokasi_rak-error').text('');
                        }
                        if (errors.dbuku_thn_terbit) {
                            $('#createBuku').find('#thn_terbit-error').text(errors.dbuku_thn_terbit[0]);
                        } else {
                            $('#createBuku').find('#thn_terbit-error').text('');
                        }
                        if (errors.dbuku_edisi) {
                            $('#createBuku').find('#edisi-error').text(errors.dbuku_edisi[0]);
                        } else {
                            $('#createBuku').find('#edisi-error').text('');
                        }
                        if (errors.dbuku_jml_total) {
                            $('#createBuku').find('#jml_total-error').text(errors.dbuku_jml_total[0]);
                        } else {
                            $('#createBuku').find('#jml_total-error').text('');
                        }
                        if (errors.dbuku_edisi) {
                            $('#createBuku').find('#edisi-error').text(errors.dbuku_edisi[0]);
                        } else {
                            $('#createBuku').find('#edisi-error').text('');
                        }
                        if (errors.id_dpenerbit) {
                            $('#createBuku').find('#penerbit-error').text(errors.id_dpenerbit[0]);
                        } else {
                            $('#createBuku').find('#penerbit-error').text('');
                        }
                        if (errors.id_dpenulis) {
                            $('#createBuku').find('#penulis-error').text(errors.id_dpenulis[0]);
                        } else {
                            $('#createBuku').find('#penulis-error').text('');
                        }
                        // Continue handling other fields similarly...
                    } else {
                        console.log("Unexpected error structure:", xhr);
                    }
                },
                complete: function() {
                    button.prop('disabled', false).html('Simpan');
                }
            });
        });

        $('body').on('click', '.modalEdit', function() {
            let id_bk = $(this).data('id');

            $('#edit').find('input, textarea, select').val('');
            $('#edit').find('img').attr('src', '');
            // Clear previous error messages
            $('#edit').find('span').text('');

            // Fetch detail post with ajax
            $.ajax({
                url: `buku/show/${id_bk}`,
                type: "GET",
                cache: false,
                success: function(response) {

                    // Fill data into the modal
                    $('#edit').find('#id_bk').val(id_bk);
                    $('#edit').find('#dbuku_isbn').val(response.bk[0].dbuku_isbn);
                    $('#edit').find('#dbuku_cover').attr("src", response
                        .img); // Assuming dbuku_cover is an image URL
                    $('#edit').find('#dbuku_judul').val(response.bk[0].dbuku_judul);
                    $('#edit').find('#id_penerbit').html(response.slc3);
                    $('#edit').find('#id_penulis').html(response.slc4);
                    $('#edit').find('#dbuku_thn_terbit').html(response.slc5);
                    $('#edit').find('#dbuku_bahasa').html(response.slc6);
                    $('#edit').find('#dbuku_lokasi_rak').html(response.slc7);
                    $('#edit').find('#dbuku_edisi').html(response.slc8);
                    $('#edit').find('#dbuku_jml_total').val(response.bk[0]
                        .dbuku_jml_total); // Available quantity
                    $('#edit').find('#dbuku_file').attr("src", response.bk[0].dbuku_file);
                },
                error: function(error) {
                    console.log("Error:", error);
                }
            });
        });

        //action update post
        $('#update').click(function(e) {
            e.preventDefault();

            $('.text-danger').text('');
            var form = $("#form_buku_upd")[0];
            var id_bk = $('#id_bk').val();
            var data = new FormData(form);

            let button = $(this);
            button.prop('disabled', true).html('Mohon Tunggu...');

            //ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `crud-buku/${id_bk}`,
                type: "POST",
                cache: false,
                data: data,
                cache: false,
                contentType: false,
                processData: false,

                success: function(response) {

                    //edit success message
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        editConfirmButton: false,
                        timer: 3000
                    });
                    $('#edit').modal('toggle');
                    $('#edit').find('#dbuku_cover').val('');
                    $('#tbl_dmbuku').DataTable().ajax.reload()
                },
                error: function(xhr) {
                    if (xhr.status === 403) {
                        var response = JSON.parse(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else if (xhr.status === 422) {
                        // Parse the JSON response
                        var response = JSON.parse(xhr.responseText);
                        console.log(response);
                        var errors = response.errors;

                        if (response.message) {
                            $('#edit').find('#global-error').text(response.message);
                        } else {
                            $('#edit').find('#global-error').text('');
                        }

                        if (errors.dbuku_cover) {
                            $('#edit').find('#cover-error').text(errors.dbuku_cover[0]);
                        } else {
                            $('#edit').find('#cover-error').text('');
                        }
                        if (errors.dbuku_isbn) {
                            $('#edit').find('#isbn-error').text(errors.dbuku_isbn[0]);
                        } else {
                            $('#edit').find('#isbn-error').text('');
                        }
                        if (errors.dbuku_judul) {
                            $('#edit').find('#judul-error').text(errors.dbuku_judul[0]);
                        } else {
                            $('#edit').find('#judul-error').text('');
                        }
                        if (errors.dbuku_bahasa) {
                            $('#edit').find('#bahasa-error').text(errors.dbuku_bahasa[0]);
                        } else {
                            $('#edit').find('#bahasa-error').text('');
                        }
                        if (errors.dbuku_file) {
                            $('#edit').find('#file-error').text(errors.dbuku_file[0]);
                        } else {
                            $('#edit').find('#file-error').text('');
                        }
                        if (errors.dbuku_lokasi_rak) {
                            $('#edit').find('#lokasi_rak-error').text(errors.dbuku_lokasi_rak[0]);
                        } else {
                            $('#edit').find('#lokasi_rak-error').text('');
                        }
                        if (errors.dbuku_thn_terbit) {
                            $('#edit').find('#thn_terbit-error').text(errors.dbuku_thn_terbit[0]);
                        } else {
                            $('#edit').find('#thn_terbit-error').text('');
                        }
                        if (errors.dbuku_edisi) {
                            $('#edit').find('#edisi-error').text(errors.dbuku_edisi[0]);
                        } else {
                            $('#edit').find('#edisi-error').text('');
                        }
                        if (errors.dbuku_jml_total) {
                            $('#edit').find('#jml_total-error').text(errors.dbuku_jml_total[0]);
                        } else {
                            $('#edit').find('#jml_total-error').text('');
                        }
                        if (errors.dbuku_edisi) {
                            $('#edit').find('#edisi-error').text(errors.dbuku_edisi[0]);
                        } else {
                            $('#edit').find('#edisi-error').text('');
                        }
                        if (errors.id_dpenerbit) {
                            $('#edit').find('#penerbit-error').text(errors.id_dpenerbit[0]);
                        } else {
                            $('#edit').find('#penerbit-error').text('');
                        }
                        if (errors.id_dpenulis) {
                            $('#edit').find('#penulis-error').text(errors.id_dpenulis[0]);
                        } else {
                            $('#edit').find('#penulis-error').text('');
                        }
                    } else {
                        console.log("Unexpected error structure:", xhr);
                    }
                },
                complete: function() {
                    button.prop('disabled', false).html('Simpan');
                }
            });
        });

        //delete
        $('body').on('click', '#btn-delete', function() {

            let id_bk = $(this).data('id');
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

                        url: `crud-buku/${id_bk}`,
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
                            $('#tbl_dmbuku').DataTable().ajax.reload()
                        },
                        error: function(xhr) {
                            // Parse the response text to get the error message
                            let response = JSON.parse(xhr.responseText);

                            if (xhr.status === 404) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan!',
                                    text: `${response.message}`,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            } else if (xhr.status === 403) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Peringatan!',
                                    text: `${response.message}`,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }

                        }
                    });
                }
            })
        });
    </script>
@endpush
