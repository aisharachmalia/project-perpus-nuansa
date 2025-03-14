<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@extends('master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                                <a href="javascript:void(0)" class="btn btn-primary mb-2 modalCreate " data-bs-toggle="modal"
                                    data-bs-target="#create">Tambah +</a>&nbsp;
                                <a href="javascript:;" class="btn btn-success mb-2" id="export"><i
                                        class="fas fa-file-excel"> </i> Export Excel</a>&nbsp;
                                <a href="javascript:;" class="btn btn-danger mb-2" id="printout"><i
                                        class="fas fa-file-pdf"> </i> Printout PDF </a>
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
                                    <th>No.Telepon</th>
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
            var link_export = "{{ route('link_export_pustakawan') }}"
            var link_printout = "{{ route('link_printout_pustakawan') }}"
            $('#tbl_list').DataTable({
                processing: false,
                scrollX: true,
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
                        class : 'text-center',
                        render: function(data) {
                            if (data == 1) {
                                return '<span class = "badge bg-success" > Aktif </span>';
                            } else {
                                return '<span class = "badge bg-danger" > Inaktif </span>'
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

            $(document).on('click', '#printout', function() {
                var value_table = $('#tbl_list').DataTable().data().count();
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
            $(document).on('click', '#export', function() {
                var value_table = $('#tbl_list').DataTable().data().count();
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
        })
    </script>
    <script>
        $('body').on('click', '.modalCreate', function() {
            $('#create').find('#dpustakawan_nama').val('');
            $('#create').find('#dpustakawan_email').val('');
            $('#create').find('#dpustakawan_no_telp').val('');
            $('#create').find('#dpustakawan_alamat').val('');

            $('#create').find('#nama-error').text('');
            $('#create').find('#email-error').text('');
            $('#create').find('#telp-error').text('');
            $('#create').find('#alamat-error').text('');
        });

        $('#store').off('click').on('click', function(e) {
            e.preventDefault();

            let dpustakawan_nama = $('#create').find('#dpustakawan_nama').val();
            let dpustakawan_email = $('#create').find('#dpustakawan_email').val();
            let dpustakawan_no_telp = $('#create').find('#dpustakawan_no_telp').val();
            let dpustakawan_alamat = $('#create').find('#dpustakawan_alamat').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let button = $(this);
            button.prop('disabled', true).html('Mohon Tunggu...');

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
                    $('#tbl_list').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        if (xhr.responseText) {
                            var errors = JSON.parse(xhr.responseText);
                            errors = errors.errors;

                            // Show error messages for each field
                            if (errors.dpustakawan_nama) {
                                $('#create').find('#nama-error').text(errors.dpustakawan_nama);
                            }
                            if (errors.dpustakawan_email) {
                                $('#create').find('#email-error').text(errors.dpustakawan_email);
                            }
                            if (errors.dpustakawan_no_telp) {
                                $('#create').find('#telp-error').text(errors.dpustakawan_no_telp);
                            }
                            if (errors.dpustakawan_alamat) {
                                $('#create').find('#alamat-error').text(errors.dpustakawan_alamat);
                            }
                        } else {
                            console.log("Error structure not as expected:", xhr.responseJSON);
                        }
                    } else {
                        console.log("Unexpected error:", xhr);
                    }
                },
                complete: function() {
                    button.prop('disabled', false).html('Simpan');
                }
            });

        });
    </script>

<script>
    $('body').on('click', '.modalEdit', function() {
        let id_ps = $(this).data('id');
        $('#edit').find('span').text('');
        // Fetch detail post with AJAX
        $.ajax({
            url: `pustakawan/show/${id_ps}`,
            type: "GET",
            cache: false,
            success: function(response) {
                console.log(response);

                // Fill data to form
                $('#edit').find('#id_dpustakawan').val(id_ps);
                $('#edit').find('#dpustakawan_nama').val(response.dpustakawan_nama);
                $('#edit').find('#dpustakawan_email').val(response.dpustakawan_email);
                $('#edit').find('#dpustakawan_no_telp').val(response.dpustakawan_no_telp);
                $('#edit').find('#dpustakawan_alamat').val(response.dpustakawan_alamat);

                // Set the radio button for dpustakawan_status
                let status = response.dpustakawan_status;
                $('#edit').find('input[name="dpustakawan_status"][value="' + status + '"]').prop('checked', true);

                // Clear previous errors
                $('#edit').find('.error-message').text('');
            }
        });
    });

    // Action to update post
    $('#update').click(function(e) {
        e.preventDefault();

        // Define variables
        let token = $('meta[name="csrf-token"]').attr('content');
        let id_ps = $('#edit').find('#id_dpustakawan').val();
        let dpustakawan_nama = $('#edit').find('#dpustakawan_nama').val();
        let dpustakawan_email = $('#edit').find('#dpustakawan_email').val();
        let dpustakawan_no_telp = $('#edit').find('#dpustakawan_no_telp').val();
        let dpustakawan_status = $('#edit').find('input[name="dpustakawan_status"]:checked').val();
        let dpustakawan_alamat = $('#edit').find('#dpustakawan_alamat').val();

        let button = $(this);
        button.prop('disabled', true).html('Mohon Tunggu...');

        // Clear error messages
        $('#edit').find('.error-message').text('');
        $('#tbl_list').DataTable().ajax.reload();

        // AJAX request
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
                // Success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });
                $('#edit').modal('toggle');
                $('#tbl_list').DataTable().ajax.reload();
                $('body').removeClass('modal-open');
                $('body').css('overflow', 'auto');
            },
            error: function(xhr) {
                console.log(xhr.status);
                if (xhr.status === 422) {
                    // Handle validation errors
                    var errors = JSON.parse(xhr.responseText).errors;

                    // Clear previous error messages
                    $('#edit').find('.error-message').text('');

                    if (errors.dpustakawan_nama) {
                        $('#edit').find('#nama-error').text(errors.dpustakawan_nama[0]);
                    } else {
                        $('#edit').find('#nama-error').text('');
                    }

                    if (errors.dpustakawan_email) {
                        $('#edit').find('#email-error').text(errors.dpustakawan_email[0]);
                    } else {
                        $('#edit').find('#email-error').text('');
                    }

                    if (errors.dpustakawan_no_telp) {
                        $('#edit').find('#telp-error').text(errors.dpustakawan_no_telp[0]);
                    } else {
                        $('#edit').find('#telp-error').text('');
                    }

                    if (errors.dpustakawan_alamat) {
                        $('#edit').find('#alamat-error').text(errors.dpustakawan_alamat[0]);
                    } else {
                        $('#edit').find('#alamat-error').text('');
                    }
                } else {
                    console.log("Unexpected error:", xhr);
                }
            },
            complete: function() {
                button.prop('disabled', false).html('Simpan');
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

                    //fill data to form
                    $('#show').find('#dpustakawan_nama').text(response.dpustakawan_nama);
                    $('#show').find('#dpustakawan_email').text(response.dpustakawan_email);
                    $('#show').find('#dpustakawan_no_telp').text(response.dpustakawan_no_telp);
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

                            if (response.success) {
                                //show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                $('#tbl_list').DataTable().ajax.reload();
                            } else {
                                //show error message if deletion is not allowed
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal Menghapus',
                                    text: response.message,
                                    showConfirmButton: true,
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Tidak dapat menghapus data.',
                            });
                        }
                    });
                }
            })
        });
    </script>
    <script></script>
@endpush
