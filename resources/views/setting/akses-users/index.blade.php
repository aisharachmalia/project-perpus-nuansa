@extends('master')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Daftar User</h4>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
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


    <div class="modal fade text-left" id="akses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Akses Menu</h4>
                </div>
                <div class="modal-body">
                    <form data-action="{{ route('setting.user-access-store') }}" method="POST" id="add-user-access-form">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <b>Nama</b> : <br>
                                <p id="usr_nama"></p>
                            </div>
                            <div class="col-4">
                                <b>Username</b> : <br>
                                <p id="usr_username"></p>
                            </div>
                            <div class="col-4">
                                <b>E-mail</b> : <br>
                                <p id="usr_email"></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="table-responsive">
                                <input type="hidden" name="id_usr" id="id_usr">
                                <input type="hidden" name="id_role" id="id_role">
                                <table class="p-4 table table-borderless" id="menu">

                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="reset" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Default Password</h4>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <b>Nama</b> : <br>
                            <span id="usr_nama"></span>
                        </div>
                        <div class="col-4">
                            <b>Username</b> : <br>
                            <span id="usr_username"></span>
                        </div>
                        <div class="col-4">
                            <b>E-mail</b> : <br>
                            <span id="usr_email"></span>
                        </div>
                    </div>
                    <div class="row justify-content-start mt-4">
                        <div class="col-sm-4">
                            <b>Default Password</b> : <br>
                            <input type="hidden" id="password">
                            <input type="hidden" id="usr_id">
                            <span class="password"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal" id="update">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('setting.akses-users.akses')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                serverSide: true,
                scrollX: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                        data:  'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'usr_nama',
                    },
                    {
                        data: 'usr_username',
                    },
                    {
                        data: 'usr_email',
                    },
                    {
                        data: 'usr_stat',
                        className: "dt-center",
                        render: function(data) {
                            if (data == 1) {
                                return '<span class="badge bg-success">Aktif</span>';
                            } else {
                                return '<span class="badge bg-danger">Tidak Aktif</span>';
                            }
                        }
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });


        $('body').on('click', '.defaultPassword', function() {
            let id_usr = $(this).data('id');
            //fetch detail post with ajax
            $.ajax({
                url: `akses-user-show/${id_usr}`,
                type: "GET",
                cache: false,
                data: {
                    "type": "default"
                },
                success: function(response) {
                    //fill data to show modal
                    $('#reset').find('#usr_nama').html(response['user'][0].usr_nama);
                    $('#reset').find('#usr_username').html(response['user'][0].usr_username);
                    $('#reset').find('#usr_email').html(response['user'][0].usr_email);
                    $('#reset').find('.password').html(response['password']);
                    $('#reset').find('#password').val(response['password']);
                    $('#reset').find('#usr_id').val(id_usr);
                }
            });
        });

        $(document).on('click', '#update', function(e) {
            e.preventDefault();
            //define variable
            let id_usr = $('#reset').find('#usr_id').val();
            let password = $('#reset').find('#password').val();
            let token = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({
                url: `default-password/${id_usr}`,
                type: "PUT",
                cache: false,
                data: {
                    "password": password,
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
        });
    </script>
@endpush
