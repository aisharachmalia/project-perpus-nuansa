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
                                    data-bs-target="#createBuku">+ Tambah</a>&nbsp;&nbsp;
                                <a href="javascript:;" class="btn btn-success mb-2" id="export"> Export Excel</a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tbl_dmbuku" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th>ISBN<br>Judul</th>
                                    <th>Penerbit<br>Penulis</th>
                                    <th>Kategori<br>Mata Pelajaran</th>
                                    <th width="10%"><center>Aksi</center></th>
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

            var table = $('#tbl_dmbuku').DataTable({
                serverSide: true,
                ajax: "{{ route('table_dm_buku') }}",
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
                            return '<strong>' + row.dbuku_isbn + '</strong><br>' + row.dbuku_judul;
                        }
                    },
                    {
                        class: "text-center",
                        data: 'null',
                        render: function(data, type, row) {
                            return '';
                        }
                    },
                    {
                        class: "text-center",
                        data: 'null',
                        render: function(data, type, row) {
                            return '';
                        }
                    },
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false,
                    }
                ]
            });

            $('#store').off('click').on('click', function(e) {
                e.preventDefault();

                var form = $("#form_buku")[0];
                var data = new FormData(form);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: crud_buku,
                    type: "POST",
                    data: data,
                    cache : false,
                    contentType : false,
                    processData : false,
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
                        $('#create').find('input').val(''); // Ini akan mengosongkan semua input
                        $('#create').find('select').val(''); // Ini akan mengosongkan semua dropdown
                        $('#create').find('textarea').val(''); // Ini akan mengosongkan semua textarea
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            if (xhr.responseText) {
                                var errors = JSON.parse(xhr.responseText);
                                errors = errors.errors;
                            } else {
                                console.log("Error structure not as expected:", xhr.responseJSON);
                            }
                        } else {
                            console.log("Unexpected error:", xhr);
                        }
                    }
                });
            });

            $(document).on('click','#export',function(){
                var value_table = $('#tbl_dmbuku').DataTable().data().count();
                if (value_table > 0) {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
                        confirmButtonText:
                        '<i class="fa fa-thumbs-up"></i> OK',
                    });
                }
            });
        });
    </script>
@endpush
