<style>
    input.largerCheckbox {
        margin-top: 0px;
        width: 23px;
        height: 23px;
    }
</style>
<legend><?php echo $title; ?></legend>
<?php echo $message; ?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header">
                <div class="btn-toolbar">
                    <button data-href="<?php echo $backUrl ?>" class="btn btn-md btn-warning pull-left margin-right-10 back">Kembali</button>
                    <button data-href="<?php echo $eventUrl ?>" class="btn btn-md btn-info pull-left margin-right-10 schedule-info" data-toggle="tooltip" title="Detail Agenda"><i class="fa fa-info-circle"></i></button>
                    <button data-href="<?php echo $saveUrl ?>" class="btn btn-md btn-success pull-right margin-right-10 final-save">Simpan Final</button>
                </div>
            </div>
        </div>

        <!-- /. box -->
    </div>
    <div class="col-sm-12 ">
        <div class="box">
            <div class="box-header">
                <div class="btn-toolbar">
                    <center><h4><?php echo $employee['title'] ?></h4></center>
                    <button data-href="<?php echo $selectUrl ?>" class="btn btn-md btn-linkedin pull-right select-participant">Pilih</button>
                    <button data-href="<?php echo $addActiveUrl ?>" class="btn btn-md btn-google bg-maroon pull-right active-employee">Aktif</button>
                    <button class="btn btn-md btn-linkedin pull-left employeelist" id="scrollToParticipant">Lihat Peserta</button>
                    <button class="btn btn-md btn-github pull-left employee-filter" data-href="<?php echo $filterUrl ?>">Filter</button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive " style='overflow-x:scroll;'>

                <div class="col-sm-12 table-responsive ">
                    <?php
                    echo $employee['generatetable'];
                    echo $employee['jquery'];
                    ?>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class="col-sm-12 ">
        <div class="box">
            <div class="box-header">
                <div class="btn-toolbar">
                    <center><h4><?php echo $participant['title'] ?></h4></center>
                    <button data-href="<?php echo $removeUrl ?>" class="btn btn-md btn-github pull-right margin remove-participant ">Hapus Peserta</button>
                    <button data-href="<?php echo $resetUrl ?>" class="btn btn-md btn-google-plus pull-right margin clear-participant ">Hapus Semua</button>
                    <button class="btn btn-md btn-linkedin pull-left" id="scrollToEmployeeList">Daftar Karyawan</button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive" style='overflow-x:scroll;'>
                <div class="col-sm-12 table-responsive participant">
                    <?php
                    echo $participant['generatetable'];
                    echo $participant['jquery'];
                    ?>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
<div class="modal fade" id="modify-data" data-backdrop="static" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true"></div>
<script>
    function loadmodal(url) {
        $('div#modify-data')
            .empty()
            .load(url, {}, function (response, status, xhr) {
                if (status === 'error') {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success m-1',
                            cancelButton: 'btn btn-sm btn-warning m-1',
                            denyButton: 'btn btn-sm btn-danger m-1',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: true,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                    });
                } else {
                    Swal.close();
                    $('div#modify-data').modal('show');
                }
            });
    }
    $(document).ready(function (){
        $('table.dataTable').DataTable().on( 'draw', function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger : 'mouseover',
            })
        });
        $('[data-toggle="tooltip"]').tooltip({
            trigger : 'mouseover',
        });
        $('button.schedule-info').on('click', function (){
            var row = $(this);
            loadmodal(row.data('href'));
        });
        $('button.employee-filter').on('click', function(){
            var row = $(this);
            loadmodal(row.data('href'));
        })
        $('#scrollToParticipant').on('click', function(e) {
            e.preventDefault(); // Prevent the default action of the button
            $('html, body').animate({
                scrollTop: $('.participant').offset().top
            }, 1000); // Adjust the animation speed as needed
        });
        $('#scrollToEmployeeList').on('click', function(e) {
            e.preventDefault(); // Prevent the default action of the button
            $('html, body').animate({
                scrollTop: $('.employeelist').offset().top
            }, 1000); // Adjust the animation speed as needed
        });
        $('table#table-employee,table#table-participant').on('click','button.schedule', function (){
            var  row = $(this);
            Swal.fire({
                icon: 'info',
                position:'middle',
                title: "Harap tunggu data sedang di proses, jangan tutup halaman ini",
                allowEscapeKey: false,
                allowOutsideClick:false,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            loadmodal(row.data('href'));
        });
        $('table#table-employee').on('click','button.join', function(){
            var row = $(this)
            $.ajax({
                url: row.data('href'),
                type: 'POST',
                success: function (data) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Berhasil',
                        html: data.message,
                        timer: 3000,
                        timerProgressBar: true,
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                        $('table#table-employee').DataTable().draw(false);
                        $('table#table-participant').DataTable().draw(false);
                    });
                },
                error: function (xhr, status, thrown) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                    });
                },
            });
        });
        $('table#table-participant').on('click','button.leave', function(){
            var row = $(this)
            $.ajax({
                url: row.data('href'),
                type: 'POST',
                success: function (data) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Berhasil',
                        html: data.message,
                        timer: 3000,
                        timerProgressBar: true,
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                        $('table#table-employee').DataTable().draw(false);
                        $('table#table-participant').DataTable().draw(false);
                    });
                },
                error: function (xhr, status, thrown) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                    });
                },
            });
        });
        $('button.back').on('click', function (){
            var row = $(this)
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi Batal',
                html: 'Konfirmasi batal ubah data <b>Peserta</b> ?',
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.getJSON('<?php echo site_url('agenda/event/doreset/'.bin2hex(json_encode(array('agenda_id'=>$transaction->agenda_id)))) ?>', {})
                        .done(function (data) {
                            window.location.replace('<?php echo site_url('agenda/event/') ?>');
                        })
                        .fail(function (xhr, status, thrown) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Gagal Direset',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: true,
                                showDenyButton: false,
                                confirmButtonText: `Tutup`,
                            }).then(function () {
                            });
                        });
                }
            });
        });
        $('button.select-participant').on('click', function (){
            var row = $(this)
            var nik = [];
            $('.employee:checked').each(function(){
                nik.push($(this).val());
            });
            if(nik.length > 0) {
                $.ajax({
                    url: row.data('href'),
                    data: {employee:nik},
                    type: 'POST',
                    success: function (data) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Berhasil Ditambahkan',
                            html: data.message,
                            timer: 3000,
                            timerProgressBar: true,
                            showCloseButton: true,
                            showConfirmButton: true,
                            showDenyButton: false,
                            CONFIRMdenyButtonText: `Tutup`,
                        }).then(function () {
                            $('table#table-employee').DataTable().draw(false);
                            $('table#table-participant').DataTable().draw(false);
                        });
                    },
                    error: function (xhr, status, thrown) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            position: 'top',
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                            showCloseButton: true,
                            showConfirmButton: true,
                            showDenyButton: false,
                            confirmButtonText: `Tutup`,
                        }).then(function () {
                        });
                    },
                })
            }else{
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm btn-success ml-3',
                        cancelButton: 'btn btn-sm btn-warning ml-3',
                        denyButton: 'btn btn-sm btn-danger ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    html: '<b>BELUM ADA KARYAWAN YANG DIPILIH</b>',
                    showCloseButton: true,
                    showConfirmButton: true,
                    showDenyButton: false,
                    confirmButtonText: `Tutup`,
                }).then(function () {
                });
            }
        })
        $('button.remove-participant').on('click', function (){
            var row = $(this)
            var nik = [];
            $('.participant:checked').each(function(){
                nik.push($(this).val());
            });
            if(nik.length > 0) {
                $.ajax({
                    url: row.data('href'),
                    data: {participant:nik},
                    type: 'POST',
                    success: function (data) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Berhasil Dihapus',
                            html: data.message,
                            timer: 3000,
                            timerProgressBar: true,
                            showCloseButton: true,
                            showConfirmButton: true,
                            showDenyButton: false,
                            confirmButtonText: `Tutup`,
                        }).then(function () {
                            $('table#table-employee').DataTable().draw(false);
                            $('table#table-participant').DataTable().draw(false);
                        });
                    },
                    error: function (xhr, status, thrown) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            position: 'top',
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                            showCloseButton: true,
                            showConfirmButton: true,
                            showDenyButton: false,
                            confirmButtonText: `Tutup`,
                        }).then(function () {
                        });
                    },
                })
            }else{
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm btn-success ml-3',
                        cancelButton: 'btn btn-sm btn-warning ml-3',
                        denyButton: 'btn btn-sm btn-danger ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    html: '<b>BELUM ADA PESERTA YANG DIPILIH</b>',
                    showCloseButton: true,
                    showConfirmButton: true,
                    showDenyButton: false,
                    confirmButtonText: `Tutup`,
                }).then(function () {
                });
            }
        })
        $('button.clear-participant').on('click', function (){
            var row = $(this)
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi Reset',
                html: `Apakah anda yakin ingin menghapus <b>semua peserta</b> ?`,
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: row.data('href'),
                        type: 'POST',
                        success: function (data) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'success',
                                title: 'Berhasil',
                                html: data.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                showConfirmButton: true,
                                showDenyButton: false,
                                confirmButtonText: `Tutup`,
                            }).then(function () {
                                $('table#table-employee').DataTable().draw(false);
                                $('table#table-participant').DataTable().draw(false);
                            });
                        },
                        error: function (xhr, status, thrown) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: false,
                                confirmButtonText: `Tutup`,
                            }).then(function () {
                            });
                        },
                    });
                }
            })
        })
        $('button.final-save').on('click', function (){
            var row = $(this)
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi Simpan',
                html: `Apakah anda yakin ingin menyimpan <b>data peserta</b> ?`,
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: row.data('href'),
                        type: 'POST',
                        success: function (data) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'success',
                                title: 'Berhasil',
                                html: data.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: false,
                                confirmButtonText: `Tutup`,
                            }).then(function () {
                                window.location.replace('<?php echo site_url('agenda/event/') ?>')
                            });
                        },
                        error: function (xhr, status, thrown) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: false,
                                confirmButtonText: `Tutup`,
                            }).then(function () {
                            });
                        },
                    });
                }
            });
        });

        $('button.active-employee').on('click', function (){
            var row = $(this);
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                position: 'top',
                icon: 'question',
                title: 'Konfirmasi Tambah Peserta',
                html: 'Apakah anda yakin untuk menambahkan karyawan yang jadwal kerjanya sesuai jadwal agenda ?',
                showCloseButton: true,
                showConfirmButton: true,
                showDenyButton: true,
                confirmButtonText: `Ya, Lanjutkan`,
                denyButtonText: `Batal`,
            }).then(function (result) {
                if (result.isConfirmed){
                    $.ajax({
                        url: row.data('href'),
                        data: {config:'active'},
                        type: 'POST',
                        success: function (data) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'success',
                                title: 'Berhasil Ditambahkan',
                                html: data.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                showConfirmButton: true,
                                showDenyButton: false,
                                CONFIRMdenyButtonText: `Tutup`,
                            }).then(function () {
                                $('table#table-employee').DataTable().draw(false);
                                $('table#table-participant').DataTable().draw(false);
                            });
                        },
                        error: function (xhr, status, thrown) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: true,
                                showDenyButton: false,
                                confirmButtonText: `Tutup`,
                            }).then(function () {
                            });
                        },
                    })
                }
            });
        })
    })
</script>