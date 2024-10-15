<script>
    $('body').on('click', '.modalAkses', function() {
            let id_usr = $(this).data('id');
            //fetch detail post with ajax
            $.ajax({
                url: `akses-user-show/${id_usr}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    //fill data to show modal
                    $('#menu').html(response['akses']);
                    $('#akses').find('#usr_nama').html(response['user'][0].usr_nama);
                    $('#akses').find('#usr_username').html(response['user'][0].usr_username);
                    $('#akses').find('#usr_email').html(response['user'][0].usr_email);
                    $('#akses').find('#id_role').val(response['user'][0].id_role);
                    $('#akses').find('#id_usr').val(id_usr);
                }
            });
        });

        $(document).ready(function() {
            var form = '#add-user-access-form';
            $(form).on('submit', function(event) {
                event.preventDefault();
                var url = $(this).attr('data-action');
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        $(form).trigger("reset");
                        $('#akses').modal('hide');
                        $('.modal-backdrop').remove();
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    },
                    error: function(response) {}
                });

            });
        });
</script>
