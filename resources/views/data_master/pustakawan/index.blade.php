@extends('master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="javascript:void(0)" class="btn btn-success mb-2 modalCreate" data-bs-toggle="modal"
                                    data-bs-target="#create">Add +</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No.Telp</th>
                                    <th>Alamat</th>
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
    @include('data_master.pustakawan.modal')
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                        data: 'id_dpustakawan'
                    },
                    {
                        data: 'dpustakawan_nama'
                    },
                    {
                        data: 'dpustakawan_email'
                    },
                    {
                        data: 'dpustakawan_no_telp'
                    },
                    {
                        data: 'dpustakawan_alamat'
                    },

                    {
                        data: 'dpustakawan_status',
                        render: function(data) {
                            if (data == 1) {
                                return '<p class = "text-success" > Aktif </p>';
                            } else {
                                return '<p class = "text-danger" > Inaktif </p>'
                            }
                        }
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

        })
    </script>
    <script>
        $('#store').off('click').on('click', '.modalCreate',function(e) {
            e.preventDefault();

            let dpustakawan_nama = $('#create').find('#dpustakawan_nama').val();
            let dpustakawan_email = $('#create').find('#dpustakawan_email').val();
            let dpustakawan_no_telp = $('#create').find('#dpustakawan_no_telp').val();
            let dpustakawan_alamat = $('#create').find('#dpustakawan_alamat').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $('#create').find('#nama-error').text('');
            $('#create').find('#email-error').text('');
            $('#create').find('#telp-error').text('');
            $('#create').find('#alamat-error').text('');

            // Clear previous error messages
            $('#create').find('.text-danger').text('');

            $.ajax({
                url: '{{ route('data_master.pustakawan.add') }}', // pastikan ini benar
                type: "POST",
                cache: false,
                data: {
                    "dpustakawan_nama": dpustakawan_nama,
                    "dpustakawan_email": dpustakawan_email,
                    "dpustakawan_no_telp": dpustakawan_no_telp,
                    "dpustakawan_alamat": dpustakawan_alamat,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message, // pastikan response.message ada
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#create').modal('toggle');
                    $('.modal-backdrop').remove();
                    $('#tbl_list').DataTable().ajax.reload(); // refresh tabel
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        if (xhr.responseText) {
                            var errors = JSON.parse(xhr.responseText);
                            errors = errors.errors;

                            // Show error messages for each field
                            if (errors.dpustakawan_nama) {
                                $('#create').find('#nama-error').text(errors.dpustakawan_nama[0]);
                            }
                            if (errors.dpustakawan_email) {
                                $('#create').find('#email-error').text(errors.dpustakawan_email[0]);
                            }
                            if (errors.dpustakawan_no_telp) {
                                $('#create').find('#telp-error').text(errors.dpustakawan_no_telp[0]);
                            }
                            if (errors.dpustakawan_alamat) {
                                $('#create').find('#alamat-error').text(errors.dpustakawan_alamat[0]);
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

    <script>
        $('body').on('click', '.modalEdit', function() {

            let id_ps = $(this).data('id');

            //fetch detail post with ajax
            $.ajax({
                url: `pustakawan/show/${id_ps}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response);

                    //fill data to form

                    $('#edit').find('#id_dpustakawan').val(id_ps);
                    $('#edit').find('#dpustakawan_nama').val(response.dpustakawan_nama);
                    $('#edit').find('#dpustakawan_email').val(response.dpustakawan_email);
                    $('#edit').find('#dpustakawan_no_telp').val(response.dpustakawan_no_telp);
                    $('#edit').find('#dpustakawan_status').val(response.dpustakawan_status);
                    $('#edit').find('#dpustakawan_alamat').val(response.dpustakawan_alamat);


                    $('#edit').find('#nama-error').text('');
                    $('#edit').find('#email-error').text('');
                    $('#edit').find('#telp-error').text('');
                    $('#edit').find('#alamat-error').text('');
                }
            });
        });

        //action update post
        $('#update').click(function(e) {
            e.preventDefault();

            //define variable
            let token = $('meta[name="csrf-token"]').attr('content');
            let id_ps = $('#edit').find('#id_dpustakawan').val();
            let dpustakawan_nama = $('#edit').find('#dpustakawan_nama').val();
            let dpustakawan_email = $('#edit').find('#dpustakawan_email').val();
            let dpustakawan_no_telp = $('#edit').find('#dpustakawan_no_telp').val();
            let dpustakawan_status = $('#edit').find('#dpustakawan_status').val();
            let dpustakawan_alamat = $('#edit').find('#dpustakawan_alamat').val();

            //clear error message
            $('#edit').find('#nama-error').text('');
            $('#edit').find('#email-error').text('');
            $('#edit').find('#telp-error').text('');
            $('#edit').find('#alamat-error').text('');

            //ajax
            $.ajax({
                url: `pustakawan/edit/${id_ps}`,
                type: "PUT",
                cache: false,
                data: {
                    "dpustakawan_nama": dpustakawan_nama,
                    "dpustakawan_email": dpustakawan_email,
                    "dpustakawan_no_telp": dpustakawan_no_telp,
                    "dpustakawan_status": dpustakawan_status,
                    "dpustakawan_alamat": dpustakawan_alamat,
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

                    $('#tbl_list').DataTable().ajax.reload()
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
                            if (errors.dpustakawan_nama) {
                                $('#edit').find('#nama-error').text(errors.dpustakawan_nama[
                                0]); // Ubah dari #create ke #edit
                            }

                            if (errors.dpustakawan_email) {
                                $('#edit').find('#email-error').text(errors.dpustakawan_email[
                                0]); // Ubah dari #create ke #edit
                            }
                            if (errors.dpustakawan_no_telp) {
                                console.log(errors.dpustakawan_no_telp);
                                $('#edit').find('#telp-error').text(errors.dpustakawan_no_telp[0]);
                            }
                            if (errors.dpustakawan_alamat) {
                                console.log(errors.dpustakawan_alamat);
                                $('#edit').find('#alamat-error').text(errors.dpustakawan_alamat[0]);
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
    <script>
        //button create post event
        $('body').on('click', '.modalShow', function() {

            let id_gr = $(this).data('id');

            //fetch detail post with ajax
            $.ajax({
                url: `pustakawan/show/${id_gr}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response)
                    //fill data to form
                    $('#show').find('#dpustakawan_nama').text(response.dpustakawan_nama);
                    $('#show').find('#dpustakawan_email').text(response.dpustakawan_email);
                    $('#show').find('#dpustakawan_no_telp').text(response.dpustakawan_no_telp);
                    $('#show').find('#dpustakawan_status').text(response.dpustakawan_status);
                    $('#show').find('#dpustakawan_alamat').text(response.dpustakawan_alamat);
                }
            });
        });
    </script>
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

                        url: `pustakawan/delete/${id_gr}`,
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
                            $('#tbl_list').DataTable().ajax.reload()
                        }
                    });
                }
            })
        });
    </script>
@endpush
