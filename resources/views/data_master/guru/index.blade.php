@extends('master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="javascript:void(0)" class="btn btn-success mb-2" data-bs-toggle="modal"
                                    data-bs-target="#create">ADD</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Email</th>
                                    <th>No. Telp</th>
                                    <th>Alamat</th>
                                    <th>Mata Pelajaran</th>
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


    @include('data_master.guru.modal')
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var i = 1;
            var table = $('#tbl_list').DataTable({
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                        "render": function() {
                            return i++;
                        }
                    },
                    {
                        data: 'dguru_nama'
                    },
                    {
                        data: 'dguru_nip'
                    },
                    {
                        data: 'dguru_email'
                    },
                    {
                        data: 'dguru_no_telp'
                    },
                    {
                        data: 'dguru_alamat'
                    },
                    {
                        data: 'dmapel_nama_mapel'
                    },
                    {
                        data: 'dguru_status',
                        className: 'dt-body-center',
                        render: function(data) {
                            if (data == 1) {
                                return '<span class="badge bg-success">Aktif</span>';
                            } else {
                                return '<span class="badge bg-warning">Tidak Aktif</span>';
                            }
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

    {{-- delete --}}
    <script>
        $('body').on('click', '#btn-delete', function() {

            let id_gr = $(this).data('id');
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

                        url: `guru/delete/${id_gr}`,
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
            $('#tbl_list').DataTable().ajax.reload()
        });
    </script>

    {{-- create --}}
    <script>
        $('#store').off('click').on('click', function(e) {
            e.preventDefault();

            let dguru_nama = $('#create').find('#dguru_nama').val();
            let dguru_nip = $('#create').find('#dguru_nip').val();
            let dguru_email = $('#create').find('#dguru_email').val();
            let dguru_no_telp = $('#create').find('#dguru_no_telp').val();
            let dguru_alamat = $('#create').find('#dguru_alamat').val();
            let dmapel_nama_mapel = $('#create').find('#dmapel_nama_mapel').val();
            let id_mapel = $('#create').find('#id_mapel').val(); // Tambahkan ini
            let token = $("meta[name='csrf-token']").attr("content");

            $('#create').find('#nama-error').text('');
            $('#create').find('#nip-error').text('');
            $('#create').find('#email-error').text('');
            $('#create').find('#telp-error').text('');
            $('#create').find('#alamat-error').text('');
            $('#create').find('#mapel-error').text('');

            // Clear previous error messages
            $('#create').find('.text-danger').text('');

            $.ajax({
                url: `guru/add`,
                type: "POST",
                cache: false,
                data: {
                    "dguru_nama": dguru_nama,
                    "dguru_nip": dguru_nip,
                    "dguru_email": dguru_email,
                    "dguru_no_telp": dguru_no_telp,
                    "dguru_alamat": dguru_alamat,
                    "id_mapel": id_mapel, // Pastikan variabel ini ada
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#create').modal('toggle');
                    $('.modal-backdrop').remove();
                },
                error: function(xhr) {
                    console.log(xhr.status);
                    if (xhr.status === 422) {
                        // Pastikan responseJSON ada dan mengandung errors
                        console.log(xhr);
                        if (xhr.responseText) {
                            var errors = JSON.parse(xhr.responseText);
                            console.log(errors.errors);
                            var errors = errors.errors;
                            // Show error messages for each field
                            if (errors.dguru_nama) {
                                console.log(errors.dguru_nama);
                                $('#create').find('#nama-error').text(errors.dguru_nama[0]);
                            }
                            if (errors.dguru_nip) {
                                console.log(errors.dguru_nip);
                                $('#create').find('#nip-error').text(errors.dguru_nip[0]);
                            }
                            if (errors.dguru_email) {
                                console.log(errors.dguru_email);
                                $('#create').find('#email-error').text(errors.dguru_email[0]);
                            }
                            if (errors.dguru_no_telp) {
                                console.log(errors.dguru_no_telp);
                                $('#create').find('#telp-error').text(errors.dguru_no_telp[0]);
                            }
                            if (errors.dguru_alamat) {
                                console.log(errors.dguru_alamat);
                                $('#create').find('#alamat-error').text(errors.dguru_alamat[0]);
                            }
                            if (errors.id_mapel) {
                                console.log(errors.id_mapel);
                                $('#create').find('#mapel-error').text(errors.id_mapel[0]);
                            }
                        } else {
                            console.log("Error structure not as expected:", xhr.responseJSON);
                        }
                    } else {
                        console.log("Unexpected error:", xhr);
                    }
                }

            });
        });
    </script>

    {{-- show --}}
    <script>
        //button create post event
        $('body').on('click', '.modalShow', function() {

            let id_gr = $(this).data('id');

            //fetch detail post with ajax
            $.ajax({
                url: `guru/show/${id_gr}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response)
                    //fill data to form
                    $('#show').find('#dguru_nama').text(response.dguru_nama);
                    $('#show').find('#dguru_nip').text(response.dguru_nip);
                    $('#show').find('#dguru_email').text(response.dguru_email);
                    $('#show').find('#dguru_no_telp').text(response.dguru_no_telp);
                    $('#show').find('#dguru_status').text(response.dguru_status);
                    $('#show').find('#dguru_alamat').text(response.dguru_alamat);
                    $('#show').find('#dmapel_nama_mapel').text(response.dmapel_nama_mapel);
                }
            });
        });
    </script>

    {{-- edit --}}
    <script>
        $('body').on('click', '.modalEdit', function() {

            let id_gr = $(this).data('id');

            //fetch detail post with ajax
            $.ajax({
                url: `guru/show/${id_gr}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response);

                    //fill data to form

                    $('#edit').find('#id_dguru').val(id_gr);
                    $('#edit').find('#dguru_nama').val(response.dguru_nama);
                    $('#edit').find('#dguru_nip').val(response.dguru_nip);
                    $('#edit').find('#dguru_email').val(response.dguru_email);
                    $('#edit').find('#dguru_no_telp').val(response.dguru_no_telp);
                    $('#edit').find('#dguru_status').val(response.dguru_status);
                    $('#edit').find('#dguru_alamat').val(response.dguru_alamat);
                    $('#edit').find('#dmapel_nama_mapel').val(response.dmapel_nama_mapel);


                    $('#edit').find('#nama-error').text('');
                    $('#edit').find('#nip-error').text('');
                    $('#edit').find('#email-error').text('');
                    $('#edit').find('#telp-error').text('');
                    $('#edit').find('#alamat-error').text('');
                    $('#edit').find('#mapel-error').text('');
                }
            });
        });

        //action update post
        $('#update').click(function(e) {
            e.preventDefault();

            //define variable
            let token = $('meta[name="csrf-token"]').attr('content');
            let id_gr = $('#edit').find('#id_dguru').val();
            let dguru_nama = $('#edit').find('#dguru_nama').val();
            let dguru_nip = $('#edit').find('#dguru_nip').val();
            let dguru_email = $('#edit').find('#dguru_email').val();
            let dguru_no_telp = $('#edit').find('#dguru_no_telp').val();
            let dguru_status = $('#edit').find('#dguru_status').val();
            let dguru_alamat = $('#edit').find('#dguru_alamat').val();
            let id_mapel = $('#edit').find('#id_mapel').val();

            //clear error message
            $('#edit').find('#nama-error').text('');
            $('#edit').find('#nip-error').text('');
            $('#edit').find('#email-error').text('');
            $('#edit').find('#telp-error').text('');
            $('#edit').find('#alamat-error').text('');
            $('#edit').find('#mapel-error').text('');

            //ajax
            $.ajax({
                url: `guru/edit/${id_gr}`,
                type: "PUT",
                cache: false,
                data: {
                    "dguru_nama": dguru_nama,
                    "dguru_nip": dguru_nip,
                    "dguru_email": dguru_email,
                    "dguru_no_telp": dguru_no_telp,
                    "dguru_status": dguru_status,
                    "dguru_alamat": dguru_alamat,
                    "id_mapel": id_mapel,
                    "_token": token
                },
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
                    $('.modal-backdrop').remove();
                },
                error: function(xhr) {
                    console.log(xhr.status);
                    if (xhr.status === 422) {
                        // Pastikan responseJSON ada dan mengandung errors
                        console.log(xhr);
                        if (xhr.responseText) {
                            var errors = JSON.parse(xhr.responseText);
                            console.log(errors.errors);
                            var errors = errors.errors;
                            // Show error messages for each field
                            if (errors.dguru_nama) {
                                console.log(errors.dguru_nama);
                                $('#create').find('#nama-error').text(errors.dguru_nama[0]);
                            }
                            if (errors.dguru_nip) {
                                console.log(errors.dguru_nip);
                                $('#create').find('#nip-error').text(errors.dguru_nip[0]);
                            }
                            if (errors.dguru_email) {
                                console.log(errors.dguru_email);
                                $('#create').find('#email-error').text(errors.dguru_email[0]);
                            }
                            if (errors.dguru_no_telp) {
                                console.log(errors.dguru_no_telp);
                                $('#edit').find('#telp-error').text(errors.dguru_no_telp[0]);
                            }
                            if (errors.dguru_alamat) {
                                console.log(errors.dguru_alamat);
                                $('#edit').find('#alamat-error').text(errors.dguru_alamat[0]);
                            }
                            if (errors.id_mapel) {
                                console.log(errors.id_mapel);
                                $('#edit').find('#mapel-error').text(errors.id_mapel[0]);
                            }
                        } else {
                            console.log("Error structure not as expected:", xhr.responseJSON);
                        }
                    } else {
                        console.log("Unexpected error:", xhr);
                    }
                }
            });
        });
    </script>
@endpush
