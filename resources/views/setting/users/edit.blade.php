<script>
    $('body').on('click', '.modalEdit', function() {
    let id_usr = $(this).data('id');
    $.ajax({
        url: `user-detail/${id_usr}`,
        type: "GET",
        cache: false,
        success: function(response) {
            // Set nilai field lain
            $('#edit').find('#usr_nama').val(response['user'].usr_nama);
            $('#edit').find('#usr_id').val(id_usr);
            $('#edit').find('#usr_username').val(response['user'].usr_username);
            $('#edit').find('#usr_email').val(response['user'].usr_email);
            
            // Set status radio button
            if (response['user'].status === 1) {
                $('#edit').find('#status_active').prop('checked', true);
            } else {
                $('#edit').find('#status_inactive').prop('checked', true);
            }
        }
    });
});
 
    $(document).on('click', '#update', function(e) {
        e.preventDefault();
        //define variable
        let id_usr = $('#edit').find('#usr_id').val();
        let nama = $('#edit').find('#usr_nama').val();
        let username = $('#edit').find('#usr_username').val();
        let email = $('#edit').find('#usr_email').val();
        let status = $('#edit').find('#status').val();
        let token = $("meta[name='csrf-token']").attr("content");


        //ajax
        $.ajax({

            url: `user-update/${id_usr}`,
            type: "PUT",
            cache: false,
            data: {
                "nama": nama,
                "username": username,
                "email": email,
                "status": status,
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
                $('#edit').modal('hide');
                $('.modal-backdrop').remove();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = $.parseJSON(xhr.responseText);
                    // Tampilkan pesan error dari validasi
                    if (errors.errors.nama) {
                        $('#usr_error').text(errors.errors.nama[0]);
                    } else {
                        $('#usr_error').text('');
                    }
                    if (errors.errors.username) {
                        $('#username_error').text(errors.errors.username[0]);
                    } else {
                        $('#username_error').text('');
                    }
                    if (errors.errors.email) {
                        $('#email_error').text(errors.errors.email[0]);
                    } else {
                        $('#email_error').text('');
                    }
                }
            }
        });
    });
</script>
