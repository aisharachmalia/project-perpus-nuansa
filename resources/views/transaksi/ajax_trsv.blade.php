<script>
    // Clear edit fields
    $('body').on('click', '.editReservasi', function() {
        $('#editReservasi').find('#buku-error').text('');
        $('#editReservasi').find('#siswa-error').text('');
        $('#editReservasi').find('#tgl-reservasi-error').text('');
        $('#editReservasi').find('#tgl-kadaluarsa-error').text('');
        $('#editReservasi').find('#tgl-pemberitahuan-error').text('');
    });

    // AJAX Edit reservasi
    $(document).on('click', '.editReservasi', function() {
        let id_tsrv = $(this).data('id');

        $.ajax({
            url: `reservasi/detail/${id_tsrv}`,
            type: "GET",
            cache: false,
            success: function(response) {
                $('#editReservasi').find('#id_trsv').val(id_tsrv);
                $('#editReservasi').find('#id_dbuku').html(response["buku"]);
                $('#editReservasi').find('#id_dsiswa').html(response["usr"]);
                $('#editReservasi').find('#trsv_tgl_reservasi').val(response.reservasi
                    .trsv_tgl_reservasi);
                $('#editReservasi').find('#trsv_tgl_kadaluarsa').val(response.reservasi
                    .trsv_tgl_kadaluarsa);
                $('#editReservasi').find('#trsv_tgl_pemberitahuan').val(response.reservasi
                    .trsv_tgl_pemberitahuan);

            },
        });
    });

    $('body').on('click', '#simpanReservasi', function(e) {
        e.preventDefault();
        let button = $(this);
        let token = $('meta[name="csrf-token"]').attr('content');
        let id_trsv = $('#editReservasi').find('#id_trsv').val();
        let id_dbuku = $('#editReservasi').find('#id_dbuku').val();
        let id_dsiswa = $('#editReservasi').find('#id_dsiswa').val();
        let trsv_tgl_reservasi = $('#editReservasi').find('#trsv_tgl_reservasi').val();
        let trsv_tgl_kadaluarsa = $('#editReservasi').find('#trsv_tgl_kadaluarsa').val();
        let trsv_tgl_pemberitahuan = $('#editReservasi').find('#trsv_tgl_pemberitahuan').val();
        button.prop('disabled', true).text('Mohon Tunggu...');

        // Clear error messages
        $('#editReservasi').find('#buku-error').text('');
        $('#editReservasi').find('#siswa-error').text('');
        $('#editReservasi').find('#tgl-reservasi-error').text('');
        $('#editReservasi').find('#tgl-kadaluarsa-error').text('');
        $('#editReservasi').find('#tgl-pemberitahuan-error').text('');

        // Ajax request to update reservasi
        $.ajax({
            url: `/reservasi/update/${id_trsv}`,
            type: "PUT",
            cache: false,
            data: {
                "id_dbuku": id_dbuku,
                "id_usr": id_dsiswa,
                "trsv_tgl_reservasi": trsv_tgl_reservasi,
                "trsv_tgl_kadaluarsa": trsv_tgl_kadaluarsa,
                "trsv_tgl_pemberitahuan": trsv_tgl_pemberitahuan,
                "_token": token
            },
            success: function(response) {
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    timer: 3000
                });
                $('#editReservasi').modal('toggle');
                $('#tbl_reservasi').DataTable().ajax.reload();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = JSON.parse(xhr.responseText).errors;
                    if (errors.id_dbuku) {
                        $('#editReservasi').find('#buku-error').text(errors.id_dbuku[0]);
                    }
                    if (errors.id_dsiswa) {
                        $('#editReservasi').find('#siswa-error').text(errors.id_dsiswa[0]);
                    }
                    if (errors.trsv_tgl_reservasi) {
                        $('#editReservasi').find('#tgl-reservasi-error').text(errors
                            .trsv_tgl_reservasi[0]);
                    }
                    if (errors.trsv_tgl_kadaluarsa) {
                        $('#editReservasi').find('#tgl-kadaluarsa-error').text(errors
                            .trsv_tgl_kadaluarsa[0]);
                    }
                    if (errors.trsv_tgl_pemberitahuan) {
                        $('#editReservasi').find('#tgl-pemberitahuan-error').text(errors
                            .trsv_tgl_pemberitahuan[0]);
                    }
                }
            },
            complete: function() {
                button.prop('disabled', false).text('Simpan Perubahan');
            }
        });
    });

    $('body').on('click', '#btn-batal', function() {
        let id_trsv = $(this).data('id');
        let token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "ingin membatalkan reservasi ini!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, BATALKAN!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/transaksi/batal`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_trsv": id_trsv,
                        "_token": token,
                        'type': 'reservasi'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Reservasi Telah Dibatalkan',
                            html: `<p>${response.message}</p>`,
                            confirmButtonText: 'Ok',
                            timer: 3000,
                        });
                        $('#tbl_reservasi').DataTable().ajax.reload();
                    }
                });
            }
        })
    });
    // ajax Create Reservasi
    $('#storeReservasi').on('click', function(e) {
        e.preventDefault();
        // Ambil nilai dari form
        let id_dbuku = $('#reservasi').find('#id_dbuku').val();
        let id_usr = $('#reservasi').find('#id_dsiswa').val();
        let trks_tgl_reservasi = $('#reservasi').find('#trks_tgl_reservasi').val();
        let trsv_tgl_kadaluarsa = $('#reservasi').find('#trsv_tgl_kadaluarsa').val();
        let token = $("meta[name='csrf-token']").attr("content");
        let button = $(this);
        button.prop('disabled', true).text('Mohon Tunggu...');
        // Proses AJAX
        $.ajax({
            url: `reservasi/store`,
            type: "POST",
            cache: false,
            data: {
                "id_dbuku": id_dbuku,
                "id_usr": id_usr,
                "trks_tgl_reservasi": trks_tgl_reservasi,
                "trsv_tgl_kadaluarsa": trsv_tgl_kadaluarsa,
                "_token": token
            },
            success: function(response) {
                if (response.success === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Reservasi Berhasil',
                        html: `<p>${response.message}</p>`,
                        confirmButtonText: 'Ok',
                        timer: 3000,
                    });
                    // Tutup modal dan reload DataTable
                    $('#reservasi').modal('toggle');
                    $('#tbl_reservasi').DataTable().ajax.reload();

                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak Ada Buku Tersedia',
                        html: `<p>${response.message}</p>`,
                        confirmButtonText: 'Tutup',
                        timer: 3000,
                    });
                    $('#reservasi').modal('toggle');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var error = $.parseJSON(xhr.responseText);
                    var errors = error.errors;

                    if (errors.id_dbuku) {
                        $('#reservasi').find('#buku-error').text(errors.id_dbuku[0]);
                    } else {
                        $('#reservasi').find('#buku-error').text('');
                    }

                    if (errors.id_usr) {
                        $('#reservasi').find('#siswa-error').text(errors.id_usr[0]);
                    } else {
                        $('#reservasi').find('#siswa-error').text('');
                    }

                    if (errors.trks_tgl_reservasi) {
                        $('#reservasi').find('#tgl-reservasi-error').text(errors.trks_tgl_reservasi[
                            0]);
                    } else {
                        $('#reservasi').find('#tgl-reservasi-error').text('');
                    }

                    if (errors.trsv_tgl_kadaluarsa) {
                        $('#reservasi').find('#tgl-kadaluarsa-error').text(errors
                            .trsv_tgl_kadaluarsa[0]);
                    } else {
                        $('#reservasi').find('#tgl-kadaluarsa-error').text('');
                    }

                }
            },
            complete: function() {
                button.prop('disabled', false).text('Simpan');
            }
        });
    });

    // show reservasi
    $('body').on('click', '.modalShow', function() {
        let id_trsv = $(this).data('id');
        let token = $("meta[name='csrf-token']").attr("content");
        //fetch detail post with ajax
        $.ajax({
            url: `/reservasi/detail`,
            type: "GET",
            cache: false,
            data: {
                "id_trsv": id_trsv,
                "type": 'show',
                "_token": token
            },
            success: function(response) {
                $('#show').find('#usr_nama').html(response.usr_nama);
                $('#show').find('#buku').html(response.dbuku_judul);
                $('#show').find('#tgl_reservasi').html(response.trsv_tgl_reservasi.slice(0, 16));
                $('#show').find('#tgl_kadaluarsa').html(response.trsv_tgl_kadaluarsa.slice(0, 16));
                $('#show').find('#tgl_pemberitahuan').html(response.trsv_tgl_pemberitahuan == null ?
                    "-" : response.trsv_tgl_pemberitahuan.slice(0, 16));
                $('#show').find('#tgl_pengambilan').html(response.trsv_tgl_pengambilan == null ?
                    "-" : response.trsv_tgl_pengambilan.slice(0, 16));
                if (response.trsv_status == -1) {
                    $('#show').find('#status').html(`Dibatalkan`);
                } else if (response.trsv_status == 0) {
                    $('#show').find('#status').html(`Kadaluarsa`);
                } else if (response.trsv_status == 1) {
                    $('#show').find('#status').html(`Aktif`);
                } else {
                    $('#show').find('#status').html(`Selesai`);
                };
            }
        });
    });

    // clear modal reservasi
    $('.pengambilan').on('click', function() {
        $('#pengambilan').find('input, select').not('#id_dpustakawan').val('');
        $('#pengambilan').find('span').text('');
        $('#pengambilan').find('#trsv_tgl_pengambilan').val(new Date().toLocaleString('sv-SE', {
            timeZone: 'Asia/Jakarta'
        }).slice(0, 16));
    });
    $('.reservasi').on('click', function() {
        $('#reservasi').find('input, select').val('');
        $('#reservasi').find('span').text('');
    });

    // reservasi ajax
    $('#pengambilan').find('#id_dsiswa').on('change', function() {
        let id_usr = $(this).val();
        let token = $("meta[name='csrf-token']").attr("content");
        if (id_usr == "") {
            $('#pengambilan').find('input, select').not('#id_dpustakawan').val('');
            $('#pengambilan').find('#trsv_tgl_pengambilan').val(new Date().toLocaleString('sv-SE', {
                timeZone: 'Asia/Jakarta'
            }).slice(0, 16));
            $('#pengambilan').find('#id_dbuku').empty();
            $('#pengambilan').find('#id_dbuku').append(
                '<option value="">Pilih Buku</option>');
        } else {
            $.ajax({
                url: `reservasi/detail`,
                type: "GET",
                cache: false,
                data: {
                    "id_peminjam": id_usr,
                    'type': 'peminjam',
                    "_token": token
                },
                success: function(response) {
                    $('#pengambilan').find('#id_dbuku').empty();
                    $('#pengambilan').find('#id_dbuku').append(
                        '<option value="">Pilih Buku</option>');
                    $.each(response, function(index, value) {
                        $('#pengambilan').find('#id_dbuku').append(
                            '<option value="' + value.id_dbuku + '">' +
                            value.dbuku_judul + '</option>');
                    });
                }
            });
        }

    });

    $('#pengambilan').find('#id_dbuku').on('change', function() {
        let id_dbuku = $(this).val();
        let token = $("meta[name='csrf-token']").attr("content");
        if (id_dbuku == '') {
            $('#pengambilan').find('#trsv_tgl_reservasi').val('');
            $('#pengambilan').find('#trsv_tgl_kadaluarsa').val('');
        } else {
            $.ajax({
                url: `reservasi/detail`,
                type: "GET",
                cache: false,
                data: {
                    "id_dbuku": id_dbuku,
                    'type': 'buku',
                    "_token": token
                },
                success: function(response) {
                    $('#pengambilan').find('#trsv_tgl_reservasi').val(response
                        .trsv_tgl_reservasi);
                    $('#pengambilan').find('#trsv_tgl_kadaluarsa').val(response
                        .trsv_tgl_kadaluarsa);
                    $('#pengambilan').find('#id_trsv').val(response.id_trsv);
                }
            });
        }

    });

    // ajax Create Pengambilan
    $('#storePengambilan').on('click', function(e) {
        e.preventDefault();
        let button = $(this);
        // Ambil nilai dari form
        let id_dbuku = $('#pengambilan').find('#id_dbuku').val();
        let id_usr = $('#pengambilan').find('#id_dsiswa').val();
        let trks_tgl_reservasi = $('#pengambilan').find('#trsv_tgl_reservasi').val();
        let trsv_tgl_kadaluarsa = $('#pengambilan').find('#trsv_tgl_kadaluarsa').val();
        let trsv_tgl_pengambilan = $('#pengambilan').find('#trsv_tgl_pengambilan').val();
        let trks_tgl_jth_tempo = $('#pengambilan').find('#trsv_jatuh_tempo').val();
        let id_trsv = $('#pengambilan').find('#id_trsv').val();
        let id_dpustakawan = $('#pengambilan').find('#id_dpustakawan').val();
        let token = $("meta[name='csrf-token']").attr("content");
        button.prop('disabled', true).text('Mohon Tunggu...');
        // Proses AJAX
        $.ajax({
            url: `pengambilan/store`,
            type: "POST",
            cache: false,
            data: {
                "id_dbuku": id_dbuku,
                "id_trsv": id_trsv,
                "id_dpustakawan": id_dpustakawan,
                "id_peminjam": id_usr,
                "trks_tgl_reservasi": trks_tgl_reservasi,
                "trks_tgl_jth_tempo": trks_tgl_jth_tempo,
                "trsv_tgl_kadaluarsa": trsv_tgl_kadaluarsa,
                "trsv_tgl_pengambilan": trsv_tgl_pengambilan,
                "_token": token
            },
            success: function(response) {
                if (response.status == 'error') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Buku Belum Tersedia untuk Pengambilan',
                        html: `<p>${response.message}</p>`,
                        confirmButtonText: 'Ok',
                        timer: 3000,
                    });
                    $('#pengambilan').modal('toggle');
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pengambilan Buku Berhasil',
                        html: `<p>${response.message}</p>`,
                        confirmButtonText: 'Ok',
                        timer: 3000,
                    });
                    $('#pengambilan').modal('toggle');
                    $('#tbl_reservasi').DataTable().ajax.reload();
                    $('#tbl_transaksi').DataTable().ajax.reload();
                }


                // Tutup modal dan reload DataTable
                $('#pengambilan').modal('toggle');
                $('#tbl_reservasi').DataTable().ajax.reload();
                $('#tbl_transaksi').DataTable().ajax.reload();
                setTimeout(() => {
                    location.reload();
                }, 2000);

            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var error = $.parseJSON(xhr.responseText);
                    var errors = error.errors;
                    // Menampilkan pesan error di bawah input yang sesuai
                    if (errors.id_dbuku) {
                        $('#pengambilan').find('#buku-error').text(errors.id_dbuku[0]);
                    } else {
                        $('#pengambilan').find('#buku-error').text('');
                    }

                    if (errors.id_peminjam) {
                        $('#pengambilan').find('#siswa-error').text(errors.id_peminjam[0]);
                    } else {
                        $('#pengambilan').find('#siswa-error').text('');
                    }

                    if (errors.trks_tgl_reservasi) {
                        $('#pengambilan').find('#tgl-reservasi-error').text(errors
                            .trks_tgl_reservasi[0]);
                    } else {
                        $('#pengambilan').find('#tgl-reservasi-error').text('');
                    }

                    if (errors.trsv_tgl_kadaluarsa) {
                        $('#pengambilan').find('#tgl-kadaluarsa-error').text(errors
                            .trsv_tgl_kadaluarsa[0]);
                    } else {
                        $('#pengambilan').find('#tgl-kadaluarsa-error').text('');
                    }

                    if (errors.trks_tgl_pemberitahuan) {
                        $('#pengambilan').find('#tgl-pemberitahuan-error').text(errors
                            .trks_tgl_pemberitahuan[0]);
                    } else {
                        $('#pengambilan').find('#tgl-pemberitahuan-error').text('');
                    }

                    if (errors.trsv_tgl_pengambilan) {
                        $('#pengambilan').find('#tgl-pengambilan-error').text(errors
                            .trsv_tgl_pengambilan[0]);
                    } else {
                        $('#pengambilan').find('#tgl-pengambilan-error').text('');
                    }
                    if (errors.trks_tgl_jth_tempo) {
                        $('#pengambilan').find('#trsv-jatuh-tempo-error').text(errors
                            .trks_tgl_jth_tempo[0]);
                    } else {
                        $('#pengambilan').find('#trsv-jatuh-tempo-error').text('');
                    }
                    if (errors.id_dpustakawan) {
                        $('#pengambilan').find('#pustakawan-error').text(errors
                            .id_dpustakawan[0]);
                    } else {
                        $('#pengambilan').find('#pustakawan-error').text('');
                    }

                }
            },
            complete: function() {
                button.prop('disabled', false).text('Simpan');
            }
        });
    });
</script>
