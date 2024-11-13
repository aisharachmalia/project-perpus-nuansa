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
                        <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>E-mail</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
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


    <div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable modal-lg"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Lihat User
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="usr_nama">Nama</label>
                                            <p id="usr_nama"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="usr_username">Username</label>
                                            <p id="usr_username"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="usr_email">E-Mail</label>
                                            <p id="usr_email"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="verified">Tanggal Daftar</label>
                                            <p id="verified"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="basicSelect">Status</label>
                                            <p id="status"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Perbarui User</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="usr_nama">Nama</label>
                                            <input type="hidden" id="usr_id" name="usr_id">
                                            <input type="text" id="usr_nama" class="form-control" placeholder="Nama"
                                                name="usr_nama">
                                            <span class="text-danger" id="usr_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="usr_username">Username</label>
                                            <input type="text" id="usr_username" class="form-control"
                                                placeholder="Username" name="usr_username">
                                            <span class="text-danger" id="username_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="usr_email">E-Mail</label>
                                            <input type="text" id="usr_email" class="form-control"
                                                placeholder="Email" name="usr_email">
                                            <span class="text-danger" id="email_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="basicSelect">Status</label>
                                            <br>
                                            <input type="radio" id="status" name="status" value="1">
                                            <label for="aktif">Aktif</label>
                                            &nbsp;
                                            <input type="radio" id="status" name="status" value="0">
                                            <label for="tidak_aktif">Tidak Aktif</label>
                                        </div>
                                        <small id="status_error" class="text-danger"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="update">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block" id="submit">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('setting.users.edit')
    @include('setting.users.delete')
    @include('setting.users.show')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl_list').DataTable({
                serverSide: true,
                scrollX: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                        data: 'id_usr',
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
                        className: "dt-center",
                        data: 'created_at',
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
