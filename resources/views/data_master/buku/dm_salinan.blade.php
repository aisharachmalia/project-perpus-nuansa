@extends('master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-1">

            </div>
            <div class="col-10">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="dbuku_cover" alt="Book Cover" src="{{ asset( $bk->dbuku_cover) }}"
                                style="width: 100%; object-fit: cover; object-position: center;padding: 2rem"
                                onerror="this.src='/storage/cover/default.jpg';">
                        </div>

                        <!-- Book Details -->
                        <div class="col-md-6 p-4">
                            <h2 id="dbuku_judul">{{ $bk->dbuku_judul }}</h2>
                            <b class="text-muted">ISBN: <label id="dbuku_isbn">{{ $bk->dbuku_isbn }}</label></b>
                            <table class="table-borderless table-sm mb-3 mt-2">
                                <tr>
                                    <td>Penulis</td>
                                    <td>:</td>
                                    <td id="id_penulis">{{ $bk->dpenulis_nama_penulis }}</td>
                                </tr>
                                <tr>
                                    <td>Penerbit</td>
                                    <td>:</td>
                                    <td id="id_penerbit">{{ $bk->dpenerbit_nama_penerbit }}</td>
                                </tr>
                                <tr>
                                    <td>Tahun Terbit</td>
                                    <td>:</td>
                                    <td id="dbuku_thn_terbit">{{ $bk->dbuku_thn_terbit }}</td>
                                </tr>
                                <tr>
                                    <td>Bahasa</td>
                                    <td>:</td>
                                    <td id="dbuku_bahasa">{{ $bk->dbuku_bahasa }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Buku</td>
                                    <td>:</td>
                                    <td id="dbuku_jml_total">{{ $bk->dbuku_jml_total }}</td>
                                </tr>
                                <tr>
                                    <td>Edisi Buku</td>
                                    <td>:</td>
                                    <td id="dbuku_edisi">{{ $bk->dbuku_edisi }}</td>
                                </tr>
                            </table>
                            <a href="{{ route('data_master.buku') }}" class="icon icon-left"
                                style="text-decoration: none"><i class="bi bi-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                    <!-- Book Cover -->

                </div>
            </div>
        </div>
        <div class="col-1"></div>
    </div>

    <!-- Salinan Buku Table -->
    <div class="container">
        <h3 class="mt-5">Salinan Buku</h3>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="javascript:;" class="btn btn-success mb-2" id="export"> Export Excel</a>
                                &nbsp;&nbsp;
                                <a href="javascript:;" class="btn btn-danger mb-2" id="printout"> Printout Pdf</a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <table id="TableSalinan" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="20%">Nama Salinan</th>
                                    <th width="10%">kondisi</th>
                                    <th width="10%">status</th>
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
    </div>
    @include('data_master.buku.modalSalinan')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        //Salinan Buku
        $(document).ready(function() {
            var table = $('#TableSalinan').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('table_dm_salinan_buku', ['id' => Crypt::encryptString($bk->id_dbuku)]) }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: "text-center"
                    },
                    {
                        data: 'dsbuku_no_salinan',
                        name: 'dsbuku_no_salinan'
                    },
                    {
                        class: 'text-center',
                        data: 'dsbuku_kondisi',
                        render: function(data) {
                            if (data == "Baik") {
                                return '<span class="badge bg-light-success">Baik</span>';
                            } else if (data == "Rusak") {
                                return '<span class="badge bg-light-danger">Rusak</span>';
                            } else {
                                return '<span class="badge bg-light-warning">' + data + '</span>';
                            }
                        }
                    },
                    {
                        class: 'text-center',
                        data: 'dsbuku_status',
                        render: function(data) {
                            if (data == 0) {
                                return '<span class="badge bg-light-success">Tersedia</span>';
                            } else if (data == 1) {
                                return '<span class="badge bg-light-warning">Dipinjam</span>';
                            } else {
                                return '<span class="badge bg-light-info">reservasi</span>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            var link_export = "{{ route('link_export_salinan_buku') }}";
            var link_printout = "{{ route('link_printout_salinan_buku') }}";

            var bookId = '{{ $bk->id_dbuku }}';

            $(document).on('click', '#export', function() {
                var value_table = $('#TableSalinan').DataTable().data().count();
                if (value_table > 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: link_export,
                        data: {
                            "id": bookId
                        },
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
                var value_table = $('#TableSalinan').DataTable().data().count();
                if (value_table > 0) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: link_printout,
                        dataType: 'json',
                        data: {
                            "id": bookId
                        },
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

        $('body').on('click', '.modalEditSalinan', function() {
            let id_dsbk = $(this).data('id');
            let url = "{{ route('buku-salinan', ':id') }}";
            url = url.replace(':id', id_dsbk);
            console.log(url);


            // Fetch detail post with ajax
            $.ajax({
                url: url,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response);
                    $('#editSalinan').find('#id_dsbk').val(id_dsbk);
                    $('#editSalinan').find('#dsbuku_no_salinan').val(response.dsbk[0]
                        .dsbuku_no_salinan);
                    $('#editSalinan').find('#dsbuku_kondisi').html(response.radioButtons);
                },
                error: function(error) {
                    console.log("Error:", error);
                }
            });
        });

        //action update post
        $(document).on('click', '#updateS', function(e) {
            e.preventDefault();

            //define variable
            var form = $("#form_buku_salinan_upd")[0];
            var id_dsbk = $('#id_dsbk').val();
            var data = new FormData(form);
            console.log(data);

            let url = "{{ route('crud_dm_salinan_buku', ':id') }}";
            url = url.replace(':id', id_dsbk);
            //ajax
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
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
                    $('#editSalinan').modal('toggle');
                    $('#TableSalinan').DataTable().ajax.reload()
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    console.log(xhr);

                    // Parse the response text to get the error message
                    if (xhr.status === 403) {
                        let response = JSON.parse(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: `${response.message}`,
                            editConfirmButton: false,
                            timer: 3000
                        });
                    } else if (xhr.status === 422) {
                        // Parse the JSON response
                        var response = JSON.parse(xhr.responseText);
                        console.log(response.errors);
                        var errors = response.errors;
                        if (errors.dsbuku_no_salinan) {
                            $('#editSalinan').find('#no-error').text(errors.dsbuku_no_salinan[0]);
                        } else {
                            $('#editSalinan').find('#no-error').text('');
                        }
                        if (errors.dbuku_isbn) {
                            $('#editSalinan').find('#kondisi-error').text(errors.dsbuku_kondisi[0]);
                        } else {
                            $('#editSalinan').find('#kondisi-error').text('');
                        }
                    } else {
                        console.log("Unexpected error structure:", xhr);
                    }
                }
            });
        });

        $('body').on('click', '#btn-delete', function() {

            let id_dsbk = $(this).data('id');
            let url = "{{ route('crud_dm_salinan_buku', ':id') }}";
            url = url.replace(':id', id_dsbk);

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
                    //fetch to delete data
                    $.ajax({

                        url: url,
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
                                timer: 2000
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        },
                        error: function(xhr) {
                            // Parse the response text to get the error message
                            let response = JSON.parse(xhr.responseText);

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            })
        });
    </script>
@endpush
