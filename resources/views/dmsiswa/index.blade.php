@extends('master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-start">
                               <a href="javascript:void(0)" class="btn btn-custom btn-success mb-2" data-bs-toggle="modal" data-bs-target="#create">+ Tambah</a>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama & NIS</th>
                                    <th>Email & No Telp</th>
                                    <th>Alamat</th>
                                    <th>Kelas</th>
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

    <!-- Modal untuk Tambah Siswa -->
<div class="modal fade text-left" id="create" tabindex="-1" role="dialog" aria-labelledby="modalCreate">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCreate">Tambah Siswa</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form" data-action="{{ route('siswa.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="first-name-column">Nama</label>
                                <input type="text" id="dsiswa_nama" class="form-control" placeholder="Nama" name="dsiswa_nama">
                                <span id="nama-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="last-name-column">NIS</label>
                                <input type="text" name="angka" id="dsiswa_nis" class="form-control" placeholder="NIS">
                                <span id="nis-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="city-column">E-mail</label>
                                <input type="text" id="dsiswa_email" class="form-control" placeholder="E-mail" name="dsiswa_email">
                                <span id="email-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="country-floating">No Telpon</label>
                                <input type="text" class="form-control" placeholder="NO. Telpon" name="dsiswa_no_telp" id="dsiswa_no_telp">
                                <span id="telp-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="id_dkelas">Nama Kelas</label>
                                    @php
                                        $mpl = DB::table('dm_kelas')->get();    
                                    @endphp
                                    <select class="form-control" id="id_dkelas" name="id_dkelas" required>
                                        <option disabled value="0" selected>Pilih kelas</option>
                                        @foreach ($mpl as $item)
                                            <option value="{{ $item->id_dkelas }}">{{ $item->dkelas_nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    <span id="kelas-error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mt-4">
                            <div class="form-group">
                                <label for="country-floating">Alamat</label>
                                <textarea class="form-control" id="dsiswa_alamat" name="dsiswa_alamat" rows="3"></textarea>
                                <span id="alamat-error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </form>
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


<!-- Modal untuk Detail Siswa -->
<div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Detail Siswa</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="dsiswa_nama">Nama Siswa</label>
                                        <p id="dsiswa_nama"></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="dsiswa_nis">NIS</label>
                                        <p id="dsiswa_nis"></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="dsiswa_email">Email</label>
                                        <p id="dsiswa_email"></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="dsiswa_no_telp">No Telepon</label>
                                        <p id="dsiswa_no_telp"></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="dsiswa_alamat">Alamat</label>
                                        <p id="dsiswa_alamat"></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="dsiswa_sts">Status</label>
                                        <p id="dsiswa_sts"></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="dkelas_nama_kelas">ID Kelas</label>
                                        <p id="dkelas_nama_kelas"></p>
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
                    <span class="d-none d-sm-block">Tutup</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Edit Siswa -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Siswa</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="form-edit-siswa">
                @csrf <!-- CSRF Token -->
                @method('PUT') <!-- Method PUT untuk edit -->
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" id="id_dsiswa" name="id_dsiswa">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="edit_nama">Nama Siswa</label>
                                            <input type="text" id="dsiswa_nama" class="form-control" placeholder="Nama Siswa" name="dsiswa_nama">
                                            <span id="nama-error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="edit_nis">NIS</label>
                                            <input type="text" id="dsiswa_nis" class="form-control" placeholder="NIS" name="dsiswa_nis">
                                            <span id="nis-error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="edit_email">Email</label>
                                            <input type="email" id="dsiswa_email" class="form-control" placeholder="Email" name="dsiswa_email">
                                            <span id="email-error" class="text-danger"></span>
                                            <span id="email-error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="edit_no_telepon">No Telepon</label>
                                            <input type="text" id="dsiswa_no_telp" class="form-control" placeholder="No Telepon" name="dsiswa_no_telp">
                                            <span id="telp-error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="edit_alamat">Alamat</label>
                                            <textarea id="dsiswa_alamat" class="form-control" placeholder="Alamat" name="dsiswa_alamat"></textarea>
                                            <span id="alamat-error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="edit_status">Status</label>
                                            <select name="dsiswa_sts" id="dsiswa_sts" class="form-select" placeholder="Status">
                                                <option value="0">Tidak Aktif</option>
                                                <option value="1">Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="edit_kelas">Kelas</label>
                                            <select id="id_dkelas" class="form-control" name="id_dkelas">
                                                <!-- Options akan dimuat melalui AJAX -->
                                            </select>
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
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="update">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Perbarui</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#tbl_list').DataTable({
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
                        data: null,
                        render: function(data, type, row) {
                            return '<strong>' + row.dsiswa_nama + '</strong><br>' + row.dsiswa_nis;
                        }
                    },
                    {
                        class: "text-center",
                        data: null,
                        render: function(data, type, row) {
                            return '<strong>' + row.dsiswa_email + '</strong><br>' + row.dsiswa_no_telp;
                        }
                    },
                    {
                        class: "text-center",
                        data: 'dsiswa_alamat'
                    },
                    {
                        class: "text-center",
                        data: 'dkelas_nama_kelas'
                    },
                    {
                        data: 'dsiswa_sts',
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
            let id_siswa = $(this).data('id');
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
                        url: `siswa/delete/${id_siswa}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
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

    {{-- create --}}
    <script>
        $('#store').off('click').on('click', function(e) {
            e.preventDefault();

            let dsiswa_nama = $('#create').find('#dsiswa_nama').val();
            let dsiswa_nis = $('#create').find('#dsiswa_nis').val();
            let dsiswa_email = $('#create').find('#dsiswa_email').val();
            let dsiswa_no_telp = $('#create').find('#dsiswa_no_telp').val();
            let dsiswa_alamat = $('#create').find('#dsiswa_alamat').val();
            let id_dkelas = $('#create').find('#id_dkelas').val();
            let token = $("meta[name='csrf-token']").attr("content");

            // Clear previous error messages
            $('#create').find('#nama-error').text('');
            $('#create').find('#nis-error').text('');
            $('#create').find('#email-error').text('');
            $('#create').find('#telp-error').text('');
            $('#create').find('#alamat-error').text('');
            $('#create').find('#kelas-error').text('');

            $.ajax({
                url: `siswa/add`,
                type: "POST",
                cache: false,
                data: {
                    "dsiswa_nama": dsiswa_nama,
                    "dsiswa_nis": dsiswa_nis,
                    "dsiswa_email": dsiswa_email,
                    "dsiswa_no_telp": dsiswa_no_telp,
                    "dsiswa_alamat": dsiswa_alamat,
                    "id_dkelas": id_dkelas,
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
                    $('#tbl_list').DataTable().ajax.reload();

                    // Kosongkan form setelah berhasil disimpan
                    $('#create').find('input').val('');
                    $('#create').find('select').val('');
                    $('#create').find('textarea').val('');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        if (xhr.responseText) {
                            var errors = JSON.parse(xhr.responseText);
                            errors = errors.errors;

                            if (errors.dsiswa_nama) {
                                $('#create').find('#nama-error').text(errors.dsiswa_nama[0]);
                            }
                            if (errors.dsiswa_nis) {
                                $('#create').find('#nis-error').text(errors.dsiswa_nis[0]);
                            }
                            if (errors.dsiswa_email) {
                                $('#create').find('#email-error').text(errors.dsiswa_email[0]);
                            }
                            if (errors.dsiswa_no_telp) {
                                $('#create').find('#telp-error').text(errors.dsiswa_no_telp[0]);
                            }
                            if (errors.dsiswa_alamat) {
                                $('#create').find('#alamat-error').text(errors.dsiswa_alamat[0]);
                            }
                            if (errors.id_dkelas) {
                                $('#create').find('#kelas-error').text(errors.id_dkelas[0]);
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
        $('body').on('click', '.modalShow', function() {
            let id_siswa = $(this).data('id');

            $.ajax({
                url: `siswa/show/${id_siswa}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#show').find('#dsiswa_nama').text(response.siswa.dsiswa_nama);
                    $('#show').find('#dsiswa_nis').text(response.siswa.dsiswa_nis);
                    $('#show').find('#dsiswa_email').text(response.siswa.dsiswa_email);
                    $('#show').find('#dsiswa_no_telp').text(response.siswa.dsiswa_no_telp);
                    $('#show').find('#dsiswa_sts').text(response.siswa.dsiswa_sts);
                    $('#show').find('#dsiswa_alamat').text(response.siswa.dsiswa_alamat);
                    $('#show').find('#dkelas_nama_kelas').text(response.siswa.dkelas_nama_kelas);
                }
            });
        });
    </script>

    {{-- edit --}}
    <script>
     $(document).ready(function() {

    // Edit modal trigger
    $('body').on('click', '.modalEdit', function() {
        let id_siswa = $(this).data('id');

        $.ajax({
            url: `siswa/show/${id_siswa}`,
            type: "GET",
            cache: false,
            success: function(response) {
                $('#edit').find('#id_dsiswa').val(id_siswa);
                $('#edit').find('#dsiswa_nama').val(response.siswa.dsiswa_nama);
                $('#edit').find('#dsiswa_nis').val(response.siswa.dsiswa_nis);
                $('#edit').find('#dsiswa_email').val(response.siswa.dsiswa_email);
                $('#edit').find('#dsiswa_no_telp').val(response.siswa.dsiswa_no_telp);
                $('#edit').find('#dsiswa_sts').val(response.siswa.dsiswa_sts);
                $('#edit').find('#dsiswa_alamat').val(response.siswa.dsiswa_alamat);
                
                // Update select option for kelas
                $('#edit').find('#id_dkelas').html(response.slc); // Ensure the select options are updated
            },
            error: function(xhr) {
                console.log("Error fetching data:", xhr);
            }
        });
    });

    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Update student data
    $('#update').off('click').on('click', function(e) {
        e.preventDefault();
        
        // Ambil data dari form
        let id_siswa = $('#edit').find('#id_dsiswa').val();
        let dsiswa_nama = $('#edit').find('#dsiswa_nama').val();
        let dsiswa_nis = $('#edit').find('#dsiswa_nis').val();
        let dsiswa_email = $('#edit').find('#dsiswa_email').val();
        let dsiswa_no_telp = $('#edit').find('#dsiswa_no_telp').val();
        let dsiswa_sts = $('#edit').find('#dsiswa_sts').val();
        let dsiswa_alamat = $('#edit').find('#dsiswa_alamat').val();
        let id_dkelas = $('#edit').find('#id_dkelas').val();
        let token = $("meta[name='csrf-token']").attr("content");

        // Clear previous error messages
        $('#edit').find('#nama-error').text('');
        $('#edit').find('#nis-error').text('');
        $('#edit').find('#email-error').text('');
        $('#edit').find('#telp-error').text('');
        $('#edit').find('#alamat-error').text('');
        $('#edit').find('#kelas-error').text('');

        $.ajax({
            url: `/siswa/update/${id_siswa}`,
            type: "PUT",
            data: {
                "_method": "PUT",
                "dsiswa_nama": dsiswa_nama,
                "dsiswa_nis": dsiswa_nis,
                "dsiswa_email": dsiswa_email,
                "dsiswa_no_telp": dsiswa_no_telp,
                "dsiswa_sts": dsiswa_sts,
                "dsiswa_alamat": dsiswa_alamat,
                "id_dkelas": id_dkelas,
                "_token": token
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });
                $('#edit').modal('toggle');
                $('#tbl_list').DataTable().ajax.reload();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    if (xhr.responseText) {
                        var error = JSON.parse(xhr.responseText);
                        var errors = error.errors;
                        console.log(error.errors);
                        // Tampilkan error di form
                        if (errors.dsiswa_nama) {
                            $('#edit').find('#nama-error').text(errors.dsiswa_nama[0]);
                        }
                        if (errors.dsiswa_nis) {
                            $('#edit').find('#nis-error').text(errors.dsiswa_nis[0]);
                        }
                          if (errors.dsiswa_email) {
                             $('#edit').find('#email-error').text(errors.dsiswa_email[0]);
                        }
                        if (errors.dsiswa_no_telp) {
                            $('#edit').find('#telp-error').text(errors.dsiswa_no_telp[0]);
                        }
                        if (errors.dsiswa_alamat) {
                            $('#edit').find('#alamat-error').text(errors.dsiswa_alamat[0]);
                        }
                        if (errors.id_dkelas) {
                            $('#edit').find('#kelas-error').text(errors.id_dkelas[0]);
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
});

    </script>
@endpush

<style>
    .btn-custom {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    background-color: #007bff; /* Warna latar belakang biru */
    border: none;
    border-radius: 5px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-custom:hover {
    background-color: #0056b3; /* Warna biru gelap saat hover */
    box-shadow: 0 4px 20px rgba(0, 91, 255, 0.4); /* Bayangan saat hover */
}

.btn-custom:active {
    transform: translateY(2px); /* Efek tekan */
    box-shadow: none; /* Hapus bayangan saat ditekan */
}

.btn-success {
    background-color: #28a745; /* Hijau */
}

.btn-success:hover {
    background-color: #218838; /* Hijau gelap saat hover */
}

.btn-danger {
    background-color: #dc3545; /* Merah */
}

.btn-danger:hover {
    background-color: #c82333; /* Merah gelap saat hover */
}

.btn-primary {
    background-color: #007bff; /* Biru */
}

.btn-primary:hover {
    background-color: #0056b3; /* Biru gelap saat hover */
}

</style>