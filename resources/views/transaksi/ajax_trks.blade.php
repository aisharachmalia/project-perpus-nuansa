<script>
      // ajax buat pinjaman
      $('body').on('click', '.modalCreate', function() {
            $('#tambahPeminjaman').find('span').text('');

            $('#tambahPeminjaman').find('#trks_tgl_peminjaman').val(new Date().toLocaleString('sv-SE', { timeZone: 'Asia/Jakarta' }).slice(0, 16));
        });

        $('body').on('click', '.pengembalian', function() {
            $('#pengembalian').find('span').text('');
            $('#pengembalian').find('input, select').val('');
            $('#pengembalian').find('#id_dbuku').empty();
            $('#pengembalian').find('#id_dbuku').append(
                '<option value="">Pilih Buku</option>');
        });

        $('#pengembalian').find('#id_dsiswa').on('change', function() {
            var id_usr = $(this).val();
            if (id_usr == '') {
                $('#pengembalian').find('input, select').val('');
                $('#pengembalian').find('#id_dbuku').empty();
                $('#pengembalian').find('#id_dbuku').append(
                    '<option value="">Pilih Buku</option>');
            } else {
                $.ajax({
                    url: `/transaksi/detail`,
                    type: 'GET',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id_usr": id_usr,
                        "type":"showUsr"
                    },
                    success: function(response) {
                        $('#pengembalian').find('#trks_tgl_pengembalian').val(new Date().toLocaleString('sv-SE', { timeZone: 'Asia/Jakarta' }).slice(0, 16));
                        $('#pengembalian').find('#id_dbuku').empty();
                        $('#pengembalian').find('#id_dbuku').append(
                            '<option value="">Pilih Buku</option>');
                        $.each(response, function(index, value) {
                            $('#pengembalian').find('#id_dbuku').append(
                                '<option value="' + value.id_trks + '">' +
                                value.dbuku_judul + '</option>');
                        });
                    }
                });
            }

        });
        $('body').on('click', '.modalShowTrks', function() {
        let id_trks = $(this).data('id');
        let token = $("meta[name='csrf-token']").attr("content");
        //fetch detail post with ajax
        $.ajax({
            url: `/transaksi/detail`,
            type: "GET",
            cache: false,
            data: {
                "id_trks": id_trks,
                "_token": token,
                "type":"showTrks"
            },
            success: function(response) {
                $('#showTrks').find('#usr_nama').html(response.usr_nama);
                $('#showTrks').find('#buku').html(response.dbuku_judul);
                $('#showTrks').find('#tgl_peminjaman').html(response.trks_tgl_peminjaman.slice(0, 16));
                $('#showTrks').find('#tgl_jatuh_tempo').html(response.trks_tgl_jatuh_tempo.slice(0, 16));
                $('#showTrks').find('#tgl_pengembalian').html(response.trks_tgl_pengembalian == null ?
                    "-" : response.trks_tgl_pengembalian.slice(0, 16));
                if (response.trks_status == -1) {
                    $('#showTrks').find('#status').html(`Dibatalkan`);
                } else if (response.trks_status == 0) {
                    $('#showTrks').find('#status').html(`Dipinjam`);
                } else {
                    $('#showTrks').find('#status').html(`Dikembalikan`);
                };
            }
        });
    });
        $('#pengembalian').find('#id_dbuku').on('change', function() {
            var id_trks = $(this).val();
            var tanggalKembali = $('#pengembalian').find('#trks_tgl_pengembalian').val();
            $.ajax({
                url: `/transaksi/detailBuku`,
                type: 'GET',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "id_trks": id_trks,
                    "trks_tgl_pengembalian": tanggalKembali
                },
                success: function(response) {
                    $('#pengembalian').find('#trks_tgl_peminjaman').val(response['buku']
                        .trks_tgl_peminjaman);
                    $('#pengembalian').find('#trks_tgl_jatuh_tempo').val(response['buku']
                        .trks_tgl_jatuh_tempo);
                    $('#pengembalian').find('#trks_denda').val(response['denda']);
                    $('#pengembalian').find('#id_trks').val(id_trks);
                }
            });
        });

        $('#pengembalian').find('#simpan').on('click', function(e) {
            e.preventDefault();
            let id_usr = $('#pengembalian').find('#id_dsiswa').val();
            let token = $('meta[name="csrf-token"]').attr('content');
            let denda = $('#pengembalian').find('#trks_denda').val();
            let id_trks = $('#pengembalian').find('#id_trks').val();
            let keterangan = $('#pengembalian').find('#trks_keterangan').val();
            let buku = $('#pengembalian').find('#id_dbuku').val();
            let jatuh_tempo = $('#pengembalian').find('#trks_tgl_jatuh_tempo').val();
            let peminjaman = $('#pengembalian').find('#trks_tgl_peminjaman').val();
            let tanggal_pengembalian = $('#pengembalian').find('#trks_tgl_pengembalian').val();
            $.ajax({
                url: `/pengembalian`,
                type: "POST",
                cache: false,
                data: {
                    "_token": token,
                    "id_trks": id_trks,
                    "id_usr": id_usr,
                    "denda": denda,
                    "buku": buku,
                    "jatuh_tempo": jatuh_tempo,
                    "peminjaman": peminjaman,
                    "keterangan": keterangan,
                    "tanggal_pengembalian": tanggal_pengembalian
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pengembalian Berhasil',
                        html: `<p>${response.message}</p>`,
                        confirmButtonText: 'Ok',
                        timer: 3000,
                    });
                    $('#pengembalian').modal('toggle');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        // Tampilkan pesan error dari validasi
                        if (errors.id_usr) {
                            $('#pengembalian').find('#siswa-error').text(errors.id_usr[0]);
                        } else {
                            $('#pengembalian').find('#siswa-error').text('');
                        }

                        if (errors.buku) {
                            $('#pengembalian').find('#buku-error').text(errors.buku[0]);
                        } else {
                            $('#pengembalian').find('#buku-error').text('');
                        }


                        if (errors.peminjaman) {
                            $('#pengembalian').find('#tgl-pinjam-error').text(errors.peminjaman[0]);
                        } else {
                            $('#pengembalian').find('#tgl-pinjam-error').text('');
                        }


                        if (errors.tanggal_pengembalian) {
                            $('#pengembalian').find('#tgl-pengembalian-error').text(errors
                                .tanggal_pengembalian[0]);
                        } else {
                            $('#pengembalian').find('#tgl-pengembalian-error').text('');
                        }


                        if (errors.jatuh_tempo) {
                            $('#pengembalian').find('#tgl-jatuh-tempo-error').text(errors.jatuh_tempo[
                                0]);
                        } else {
                            $('#pengembalian').find('#tgl-jatuh-tempo-error').text('');
                        }


                        if (errors.keterangan) {
                            $('#pengembalian').find('#keterangan-error').text(errors
                                .keterangan[0]);
                        } else {
                            $('#pengembalian').find('#keterangan-error').text('');
                        }


                        if (errors.denda) {
                            $('#pengembalian').find('#denda-error').text(errors.denda[0]);
                        } else {
                            $('#pengembalian').find('#denda-error').text('');
                        }

                    }
                }
            });
        });

        $('#storePinjaman').off('click').on('click', function(e) {
            e.preventDefault();
            // Mendapatkan nilai dari input
            let token = $('meta[name="csrf-token"]').attr('content');
            let id_dbuku = $('#pinjamanForm').find('#id_dbuku').val();
            let id_usr = $('#pinjamanForm').find('#id_dsiswa').val();
            let id_dpustakawan = $('#pinjamanForm').find('#id_dpustakawan').val();
            let trks_tgl_peminjaman = $('#pinjamanForm').find('#trks_tgl_peminjaman').val();
            let trks_tgl_jatuh_tempo = $('#pinjamanForm').find('#trks_tgl_jatuh_tempo').val();

            $.ajax({
                url: '/peminjaman/add',
                type: "POST",
                cache: false,
                data: {
                    "_token": token,
                    "id_dbuku": id_dbuku,
                    "id_usr": id_usr,
                    "id_dpustakawan": id_dpustakawan,
                    "trks_tgl_peminjaman": trks_tgl_peminjaman,
                    "trks_tgl_jatuh_tempo": trks_tgl_jatuh_tempo
                },
                success: function(response) {
                    if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            html: `<p>${response.message}</p>`,
                            confirmButtonText: 'Ok',
                            timer: 3000,
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Peminjaman Berhasil',
                            html: `<p>${response.message}</p>`,
                            confirmButtonText: 'Ok',
                            timer: 3000,
                        });
                        $('#tambahPeminjaman').modal('toggle');
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var error = $.parseJSON(xhr.responseText);
                        var errors = error.errors;
                        if (errors.id_dbuku) {
                            $('#tambahPeminjaman').find('#buku-error').text(errors.id_dbuku[0]);
                        } else {
                            $('#tambahPeminjaman').find('#buku-error').text('');
                        }

                        if (errors.id_usr) {
                            $('#tambahPeminjaman').find('#siswa-error').text(errors.id_usr[0]);
                        } else {
                            $('#tambahPeminjaman').find('#siswa-error').text('');
                        }

                        if (errors.id_dpustakawan) {
                            $('#tambahPeminjaman').find('#pustakawan-error').text(errors.id_dpustakawan[
                                0]);
                        } else {
                            $('#tambahPeminjaman').find('#pustakawan-error').text('');
                        }

                        if (errors.trks_tgl_peminjaman) {
                            $('#tambahPeminjaman').find('#tgl-pinjam-error').text(errors
                                .trks_tgl_peminjaman[0]);
                        } else {
                            $('#tambahPeminjaman').find('#tgl-pinjam-error').text('');
                        }

                        if (errors.trks_tgl_jatuh_tempo) {
                            $('#tambahPeminjaman').find('#tgl-jatuh-tempo-error').text(errors
                                .trks_tgl_jatuh_tempo[0]);
                        } else {
                            $('#tambahPeminjaman').find('#tgl-jatuh-tempo-error').text('');
                        }
                    }
                }
            });
        });

        // clear edit
        $('body').on('click', '.editPeminjaman', function() {
            $('#editPeminjaman').find('span').text('');
        });
        $('body').on('click', '.editPengembalian', function() {
            $('#editPengembalian').find('span').text('');
        });

        // AJAX Edit peminjaman
        $('body').on('click', '.editPeminjaman', function() {
            let id_trks = $(this).data('id');
            $.ajax({
                url: `transaksi/detail/update/${id_trks}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#editPeminjaman').find('#id_trks').val(id_trks);
                    $('#editPeminjaman').find('#id_dbuku').html(response['buku']);
                    $('#editPeminjaman').find('#id_dsiswa').html(response['usr']);
                    $('#editPeminjaman').find('#id_dpustakawan').html(response['pustakawan']);
                    $('#editPeminjaman').find('#trks_tgl_peminjaman').val(response['transaksi']
                        .trks_tgl_peminjaman);
                    $('#editPeminjaman').find('#trks_tgl_jatuh_tempo').val(response['transaksi']
                        .trks_tgl_jatuh_tempo);
                },
            });
        });
        $(document).on('click', '#simpanTransaksi', function(e) {
            e.preventDefault();
            let activeModal;
            if ($('#editPeminjaman').hasClass('show')) {
                activeModal = $('#editPeminjaman');
                type = 'peminjaman';
            } else if ($('#editPengembalian').hasClass('show')) {
                activeModal = $('#editPengembalian');
                type = 'pengembalian';
            }
            // Define variable
            let token = $('meta[name="csrf-token"]').attr('content');
            let id_trks = activeModal.find('#id_trks').val();
            let id_dbuku = activeModal.find('#id_dbuku').val();
            let id_dpustakawan = activeModal.find('#id_dpustakawan').val();
            let id_usr = activeModal.find('#id_dsiswa').val();
            let trks_tgl_peminjaman = activeModal.find('#trks_tgl_peminjaman').val();
            let trks_tgl_jatuh_tempo = activeModal.find('#trks_tgl_jatuh_tempo').val();
            let trks_tgl_pengembalian = activeModal.find('#trks_tgl_pengembalian').val();
            let trks_denda = activeModal.find('#trks_denda').val();
            let trks_keterangan = activeModal.find('#trks_keterangan').val();


            // Clear error messages
            activeModal.find('span').text('');

            // Ajax
            $.ajax({
                url: `/transaksi/update/${id_trks}`,
                type: "PUT",
                cache: false,
                data: {
                    "id_dbuku": id_dbuku,
                    "id_usr": id_usr,
                    "id_dpustakawan": id_dpustakawan,
                    "trks_tgl_peminjaman": trks_tgl_peminjaman,
                    "trks_tgl_jatuh_tempo": trks_tgl_jatuh_tempo,
                    "trks_tgl_pengembalian": trks_tgl_pengembalian,
                    "trks_denda": trks_denda,
                    "trks_keterangan": trks_keterangan,
                    "type": type,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Transaksi Berhasil Dirubah',
                        html: `<p>${response.message}</p>`,
                        confirmButtonText: 'Ok',
                        timer: 3000,
                    });
                    activeModal.modal('toggle');
                    $('#tbl_transaksi').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = JSON.parse(xhr.responseText).errors;
                        // Show error messages for each field
                        if (errors.id_dbuku) {
                            activeModal.find('#buku-error').text(errors.id_dbuku[0]);
                        } else {
                            activeModal.find('#buku-error').text("");
                        }
                        if (errors.id_usr) {
                            activeModal.find('#siswa-error').text(errors.id_usr[0]);
                        } else {
                            activeModal.find('#siswa-error').text("");
                        }
                        if (errors.trks_tgl_peminjaman) {
                            activeModal.find('#tgl-pinjam-error').text(errors.trks_tgl_peminjaman[0]);
                        } else {
                            activeModal.find('#tgl-pinjam-error').text("");
                        }
                        if (errors.trks_tgl_jatuh_tempo) {
                            activeModal.find('#tgl-jatuh-error').text(errors.trks_tgl_jatuh_tempo[0]);
                        } else {
                            activeModal.find('#tgl-jatuh-error').text("");
                        }
                        if (errors.trks_tgl_pengembalian) {
                            activeModal.find('#tgl-pengembalian-error').text(errors
                                .trks_tgl_pengembalian[0]);
                        } else {
                            activeModal.find('#tgl-pengembalian-error').text("");
                        }
                        if (errors.trks_denda) {
                            activeModal.find('#denda-error').text(errors.trks_denda[0]);
                        } else {
                            activeModal.find('#denda-error').text("");
                        }
                        if (errors.trks_keterangan) {
                            activeModal.find('#keterangan-error').text(errors.trks_keterangan[0]);
                        } else {
                            activeModal.find('#keterangan-error').text("");
                        }

                    }
                }
            });
        });


        //Ajax edit pengembalian
        $('body').on('click', '.editPengembalian', function(e) {
            let id_trks = $(this).data('id');
            $.ajax({
                url: `transaksi/detail/update/${id_trks}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#editPengembalian').find('#id_trks').val(id_trks);
                    $('#editPengembalian').find('#id_dbuku').html(response['buku']);
                    $('#editPengembalian').find('#id_dsiswa').html(response['usr']);
                    $('#editPengembalian').find('#id_dpustakawan').html(response['pustakawan']);
                    $('#editPengembalian').find('#trks_tgl_peminjaman').val(response['transaksi']
                        .trks_tgl_peminjaman);
                    $('#editPengembalian').find('#trks_tgl_jatuh_tempo').val(response['transaksi']
                        .trks_tgl_jatuh_tempo);
                    $('#editPengembalian').find('#trks_tgl_pengembalian').val(response['transaksi']
                        .trks_tgl_pengembalian);
                    $('#editPengembalian').find('#trks_denda').val(response['transaksi']
                        .trks_denda);
                },

            });
        });
</script>
