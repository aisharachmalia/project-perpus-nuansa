$(document).ready(function() {
    $('#tbl_list').DataTable({
        processing: false,
        serverSide: true,
        ajax: url_kelas,
        columns: [
            { data: 'id_dkelas' },
            { data: 'dkelas_nama_kelas' },
            { data: 'dkelas_tingkat' },
            { data: 'dkelas_jurusan' },
        ]
    });
});
    
    // Edit modal
    $('body').on('click', '.modalEdit', function() {
        let id_dkelas = $(this).data('id');
        //fetch detail post with ajax
        $.ajax({
            url: `/kelas-detail/${id_dkelas}`,
            type: "GET",
            cache: false,
            success: function(response) {
                //fill data to form edit modal
                $('#edit').find('#dkelas_nama_kelas').val(response.dkelas_nama_kelas);
                $('#edit').find('#id_dkelas').val(id_dkelas);
                $('#edit').find('#dkelas_tingkat').val(response.dkelas_tingkat);
                $('#edit').find('#dkelas_jurusan').val(response.dkelas_jurusan);
            }
        });
    });

    // Update data
    $(document).on('click', '#update', function(e) {
        e.preventDefault();
        //define variables
        let id_dkelas = $('#edit').find('#id_dkelas').val();
        let namakelas = $('#edit').find('#dkelas_nama_kelas').val();
        let tingkat = $('#edit').find('#dkelas_tingkat').val();
        let jurusan = $('#edit').find('#dkelas_jurusan').val();

        //ajax
        $.ajax({
            url: `/kelas-update/${id_dkelas}`,
            type: "PUT",
            cache: false,
            data: {
                "namakelas": namakelas,
                "tingkat": tingkat,
                "jurusan": jurusan,
            },
            headers: {
                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content")
            },
            success: function(response) {
                //show success message
                Swal.fire({
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    });

    // Show modal
    $('body').on('click', '.modalShow', function() {
        let id_dkelas = $(this).data('id');
        //fetch detail post with ajax
        $.ajax({
            url: `/kelas-detail/${id_dkelas}`,
            type: "GET",
            cache: false,
            success: function(response) {
                //fill data to show modal
                $('#show').find('#dkelas_nama_kelas').html(response.dkelas_nama_kelas);
                $('#show').find('#dkelas_tingkat').html(response.dkelas_tingkat);
                $('#show').find('#dkelas_jurusan').html(response.dkelas_jurusan);
            }
        });
    });

    // Delete data
    $('body').on('click', '.deleteKelas', function() {
        let id_dkelas = $(this).data('id');
        let token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "Ingin menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!'
        }).then((result) => {
            if (result.isConfirmed) {
                //fetch to delete data
                $.ajax({
                    url: `/kelas-delete/${id_dkelas}`, // Ganti usr_id dengan id_dkelas
                    type: "DELETE",
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    success: function(response) {
                        //show success message
                        Swal.fire({
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });     
            }
        });
    });
    