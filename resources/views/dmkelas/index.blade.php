
@extends('master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center mb-3">Daftar Kelas</div>
                <div class="card-body">
                    <table class="table table-striped" id="tbl_list">
                        <thead>
                            <tr>
                                <th>ID Kelas</th>
                                <th>Nama Kelas</th>
                                <th>Tingkat</th>
                                <th>Jurusan</th>
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

<!-- Modal Show Kelas -->
<div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Show Kelas</h5>
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
                                        <label for="dkelas_nama_kelas">Nama Kelas</label>
                                        <p id="dkelas_nama_kelas"></p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="dkelas_tingkat">Tingkat</label>
                                        <p id="dkelas_tingkat"></p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="dkelas_jurusan">Jurusan</label>
                                        <p id="dkelas_jurusan"></p>
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

<!-- Modal Edit Kelas -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modalEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalEdit">Edit Kelas</h4>
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
                                        <label for="dkelas_nama_kelas">Nama Kelas</label>
                                        <input type="hidden" id="id_dkelas" name="id_dkelas">
                                        <input type="text" id="dkelas_nama_kelas" class="form-control" placeholder="Nama Kelas" name="dkelas_nama_kelas">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="dkelas_tingkat">Tingkat</label>
                                        <input type="text" id="dkelas_tingkat" class="form-control" placeholder="Tingkat" name="dkelas_tingkat">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="dkelas_jurusan">Jurusan</label>
                                        <input type="text" id="dkelas_jurusan" class="form-control" placeholder="Jurusan" name="dkelas_jurusan">
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
                    <span class="d-none d-sm-block">Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    var table = $('#tbl_list').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url()->current() }}',
        columns: [
            { data: 'id_dkelas' },
            { data: 'dkelas_nama_kelas' },
            { data: 'dkelas_tingkat' },
            { data: 'dkelas_jurusan' },
            { 
                data: null,
               render: function(data, type, row) {
                return `
                    <button class="btn btn-sm btn-outline-info me-1 show-btn" data-id="${row.id_dkelas}"><i class="bx bx-eye"></i> Lihat</button>
                    <button class="btn btn-sm btn-outline-warning me-1 edit-btn" data-id="${row.id_dkelas}"><i class="bx bx-pencil"></i> Edit</button>
                    <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${row.id_dkelas}"><i class="bx bx-trash"></i> Hapus</button>
                `;
            }

            }
        ]
    });

    // Fungsi untuk menampilkan modal Show
    $('#tbl_list').on('click', '.show-btn', function() {
        var id = $(this).data('id'); 
        $.ajax({
            url: `kelas-detail/${id}`,
            method: 'GET',
            success: function(response) {
                $('#show').find('#dkelas_nama_kelas').text(response.dkelas_nama_kelas);
                $('#show').find('#dkelas_tingkat').text(response.dkelas_tingkat);
                $('#show').find('#dkelas_jurusan').text(response.dkelas_jurusan);
                $('#show').modal('show');
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error');
            }
        });
    });

    // Fungsi untuk menampilkan modal Edit
    $('#tbl_list').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: `kelas-detail/${id}`,
            method: 'GET',
            success: function(response) {
                $('#edit').find('#id_dkelas').val(response.id_dkelas);  // Ambil id dengan benar
                $('#edit').find('#dkelas_nama_kelas').val(response.dkelas_nama_kelas);
                $('#edit').find('#dkelas_tingkat').val(response.dkelas_tingkat);
                $('#edit').find('#dkelas_jurusan').val(response.dkelas_jurusan);
                $('#edit').modal('show');  // Tampilkan modal edit
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error');
            }
        });
    });

    // Fungsi untuk mengupdate data
    $(document).on('click', '#update', function(e) {
        e.preventDefault();

        let id_dkelas = $('#edit').find('#id_dkelas').val();
        let dkelas_nama_kelas = $('#edit').find('#dkelas_nama_kelas').val();
        let dkelas_tingkat = $('#edit').find('#dkelas_tingkat').val();
        let dkelas_jurusan = $('#edit').find('#dkelas_jurusan').val();
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `kelas-update/${id_dkelas}`,  // Pastikan URL update benar
            type: "PUT",
            data: {
                "_token": token,
                "dkelas_nama_kelas": dkelas_nama_kelas,
                "dkelas_tingkat": dkelas_tingkat,
                "dkelas_jurusan": dkelas_jurusan
       },
       success: function(response) {
           Swal.fire({
               icon: 'success',
               title: `${response.message}`,
               showConfirmButton: false,
               timer: 1500
           });
           $('#tbl_list').DataTable().ajax.reload();
           $('#edit').modal('hide');
       },
       error: function(xhr) {
           Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan saat memperbarui data', 'error');
       }
   });
});



    // Fungsi untuk menghapus data
$('body').on('click', '.delete-btn', function() {
    let id_dkelas = $(this).data('id'); // Mengambil id_dkelas dari data-id tombol
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
            // Mengirim permintaan DELETE ke server
            $.ajax({
                url: `kelas/delete/${id_dkelas}`,  // Pastikan URL delete sesuai dengan route Anda
                type: "DELETE",
                data: {
                    "_token": token
                },
                success: function(response) {
                    // Menampilkan pesan sukses
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#tbl_list').DataTable().ajax.reload(); // Memperbarui tabel
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus data', 'error');
                }
            });
        }
    });
});




});
</script>
@endpush
