<script>
    $('body').on('click', '.modalShow', function() {
        let id_usr = $(this).data('id');
        //fetch detail post with ajax
        $.ajax({
            url: `user-detail/${id_usr}`,
            type: "GET",
            cache: false,
            success: function(response) {
                //fill data to show modal
                $('#show').find('#usr_nama').html(response['user'].usr_nama);
                $('#show').find('#usr_username').html(response['user'].usr_username);
                $('#show').find('#usr_email').html(response['user'].usr_email);
                $('#show').find('#status').html(response['user'].usr_stat==0?'Tidak Aktif':'Aktif');
                $('#show').find('#verified').html(response['user'].email_verified);
            }
        });
    });
</script>
