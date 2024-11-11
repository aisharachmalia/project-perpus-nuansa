@extends('master')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.min.css" />
@endpush

@section('content')
    <div class="col-12 col-md-12">
        <div class="card border-light">
            <div class="card-header">
                <h4 class="card-title text-center">Daftar Akses User</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <!-- Table with outer spacing -->
                    <div class="table-responsive">
                        <table id="example" class="table table-lg display hover">
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
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($usr as $item)
                                    @php
                                        // cek role
                                        $role = App\Models\User::join('akses_usrs', 'akses_usrs.id_usr', 'users.id_usr')
                                            ->where('users.id_usr', $item->id_usr)
                                            ->where('akses_usrs.id_role', '<=', 2)
                                            ->first();
                                        $roleAusr = App\Models\User::leftJoin(
                                            'akses_usrs',
                                            'akses_usrs.id_usr',
                                            'users.id_usr',
                                        )
                                            ->where('users.id_usr', $item->id_usr)
                                            ->where(function ($query) {
                                                $query
                                                    ->whereIn('akses_usrs.id_role', [1, 2])
                                                    ->orWhereNull('akses_usrs.id_usr');
                                            })
                                            ->first();

                                    @endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->usr_nama }}</td>
                                        <td>{{ $item->usr_username }}</td>
                                        <td>{{ $item->usr_email }}</td>
                                        <td>
                                            @if ($item->usr_stat == 1)
                                                <span class="badge bg-primary">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Inaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$roleAusr)
                                                <a href="javascript:void(0)" class="btn btn-success btn-sm modalAkses"
                                                    data-bs-toggle="modal" data-bs-target="#akses"
                                                    data-id="{{ \Illuminate\Support\Facades\Crypt::encryptString($item->id_usr) }}">Akses</a>&nbsp;
                                            @endif
                                            @if (!$role)
                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm defaultPassword"
                                                    data-bs-toggle="modal" data-bs-target="#reset"
                                                    data-id="{{ \Illuminate\Support\Facades\Crypt::encryptString($item->id_usr) }}">Reset
                                                    Password</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
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
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('setting.akses-users.akses')
    <script>
        new DataTable('#example', {});


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
