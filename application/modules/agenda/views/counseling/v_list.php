<style>
    .ml-3 {
        margin-left: 1rem;
    }
</style>
<legend><?php echo $title; ?></legend>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-12">
                    <!-- <?php //if ($this->useraccess->user($menuID,'aksesinput')){ ?> -->
                        <a href="<?php echo $inputUrl ?>" class="btn btn-md btn-success text-secondary text-uppercase margin" style="color: #ffffff"><i class="fa fa-fw fa-plus"></i> Input Konseling</a>
                    <?php// } ?>
                    <div class="bs-example pull-right margin" data-example-id="single-button-dropdown">
                        <div class="btn-group">
                            <a href="javascript:void(0)" class="btn btn-md btn-icon-only btn-twitter pull-right refresh" data-toggle="tooltip" title="Reset Filter" style=" color:#ffffff;"><i class="fa fa-fw fa-refresh"></i></a>
                        </div>
                        <div class="btn-group">
                            <a href="#" data-toggle="modal" data-target="#filter" class="btn btn-md btn-facebook pull-right" style=" color:#ffffff;">FILTER</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive" style='overflow-x:scroll;'>
                <div class="col-sm-12 table-responsive">
                    <?php
                    $this->datatablessp->generatetable();
                    $this->datatablessp->jquery();
                    ?>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
<!--Modal Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Periode Konseling Karyawan</h4>
            </div>
            <form class="form-search" action="<?php echo site_url('agenda/counseling/index') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Bulan</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name='month'>
                                <option value="01" <?php $tgl = date('m');if ($tgl == '01') echo "selected"; ?>>Januari</option>
                                <option value="02" <?php $tgl = date('m');if ($tgl == '02') echo "selected"; ?>>Februari</option>
                                <option value="03" <?php $tgl = date('m');if ($tgl == '03') echo "selected"; ?>>Maret</option>
                                <option value="04" <?php $tgl = date('m');if ($tgl == '04') echo "selected"; ?>>April</option>
                                <option value="05" <?php $tgl = date('m');if ($tgl == '05') echo "selected"; ?>>Mei</option>
                                <option value="06" <?php $tgl = date('m');if ($tgl == '06') echo "selected"; ?>>Juni</option>
                                <option value="07" <?php $tgl = date('m');if ($tgl == '07') echo "selected"; ?>>Juli</option>
                                <option value="08" <?php $tgl = date('m');if ($tgl == '08') echo "selected"; ?>>Agustus</option>
                                <option value="09" <?php $tgl = date('m');if ($tgl == '09') echo "selected"; ?>>September</option>
                                <option value="10" <?php $tgl = date('m');if ($tgl == '10') echo "selected"; ?>>Oktober</option>
                                <option value="11" <?php $tgl = date('m');if ($tgl == '11') echo "selected"; ?>>November</option>
                                <option value="12" <?php $tgl = date('m');if ($tgl == '12') echo "selected"; ?>>Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Tahun</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name="year">
                                <option value='<?php $tgl = date('Y');echo $tgl; ?>'><?php $tgl = date('Y');echo $tgl; ?></option>
                                <option value='<?php $tgl = date('Y') - 1;echo $tgl; ?>'><?php $tgl = date('Y') - 1;echo $tgl; ?></option>
                                <option value='<?php $tgl = date('Y') - 2;echo $tgl; ?>'><?php $tgl = date('Y') - 2;echo $tgl; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name="status">
                                <option value="">SEMUA</option>
                                <option value="P">DISETUJUI</option>
                                <option value="A">PERLU PERSETUJUAN</option>
                                <option value="C">DIBATALKAN</option>
                                <option value="I">BELUM DIJADWALKAN</option>
                                <option value="R">DIJADWALKAN ULANG</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Schedule-->
<div class="modal fade" id="modal-schedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
<script>
    function loadmodal(url) {
        $('div#modal-schedule')
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
                        title: 'Gagal Memuat Detail',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function () {
                    });
                } else {
                    $('div#modal-schedule').modal({
                        keyboard: false,
                        backdrop: 'static',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                    $('div#modal-schedule').modal('show');
                }
            });
    }
    $(document).ready(function () {
        $('form.form-search').on('submit', function (e){
            e.preventDefault();
            var year = $('select[name=\'year\']').val();
            var month = $('select[name=\'month\']').val();
            var status = $('select[name=\'status\']').val();
            $('#table-counseling')
                .DataTable()
                .ajax.url('<?php echo base_url('agenda/counseling/index')?>?year=' + year + '&month=' + month + '&status=' + status +'')
                .load();
            $('div#filter').modal('hide');
        })
        $('table.datatable').DataTable().on( 'draw', function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger : 'mouseover',
            })
        });
        $('a.refresh').on('click', function (){
            $('table#table-counseling tfoot ').find('input.form-filter').val('');
            $('table#table-counseling').DataTable().search('').columns().search('').draw();
            $('table#table-counseling').DataTable()
                .ajax.url('<?php echo base_url('agenda/counseling/index')?>')
                .order([1, 'asc']).draw();
        })
        $('table#table-counseling tbody').on('click', 'td a.detail', function () {
            var row = $(this);
            window.location.href = row.data('href')
        });
        $('table#table-counseling tbody').on('click', 'td a.cancel', function () {
            var row = $(this);
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                icon: 'question',
                title: `Konfirmasi`,
                html: `Apakah anda yakin ingin membatalkan dokumen ini ?`,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                showDenyButton: true,
                denyButtonText: `Batal`,
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.getJSON(row.attr('data-href'), {})
                        .done(function (data) {
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
                                title: 'Berhasil Dibatalkan',
                                html: data.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            }).then(function () {
                                $('table#table-counseling').DataTable().draw(false);
                            });
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
                                title: 'Gagal Memuat Status',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            }).then(function () {
                            });
                        });
                }
            })
        });
        $('table#table-counseling tbody').on('click', 'td a.schedule', function () {
            var row = $(this);
            $.getJSON(row.attr('data-href'), {})
                .done(function (data) {
                    if (data.canupdate) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statusText,
                            html: data.message,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Ubah jadwal',
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                loadmodal(data.next.update)
                            }else{
                                $.getJSON('<?php echo site_url('agenda/counseling/doreset') ?>', {})
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
                    }
                    if (data.canread) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statusText,
                            html: data.message,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Ubah jadwal',
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                loadmodal(data.next.update)
                            }else{
                                $.getJSON('<?php echo site_url('agenda/counseling/doreset') ?>', {})
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
                    }
                    if (data.cancreate) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-danger ml-3',
                                denyButton: 'btn btn-sm btn-primary ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statusText,
                            html: data.message,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Buat jadwal',
                            showCancelButton: true,
                            cancelButtonText: `Tutup`,

                        }).then(function (result) {
                            if (result.isConfirmed) {
                                loadmodal(data.next.create)
                            }else{
                                $.getJSON('<?php echo site_url('agenda/counseling/doreset') ?>', {})
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
                    }
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
                        title: 'Gagal Memuat Status',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function () {
                    });
                });
        });
        $('table#table-counseling tbody').on('click', 'td a.popup', function () {
            var row = $(this);
            $.getJSON(row.attr('data-href'), {})
                .done(function (data) {
                    if (data.canupdate) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statusText,
                            html: data.message,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Ubah / Batal',
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                window.location.replace(data.next.update);
                            }
                        });
                    }
                    if (data.canapprove) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-danger ml-3',
                                denyButton: 'btn btn-sm btn-primary ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statusText,
                            html: data.message,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Ubah / Batal',
                            showCancelButton: true,
                            cancelButtonText: `Tutup`,
                            showDenyButton: true,
                            denyButtonText: `Setujui`,

                        }).then(function (result) {
                            if (result.isConfirmed) {
                                window.location.replace(data.next.update);
                            }
                            if (result.isDenied) {
                                window.location.replace(data.next.approve);
                            }
                        });
                    }
                    if (data.cancreate){
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-danger ml-3',
                                denyButton: 'btn btn-sm btn-primary ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statusText,
                            html: data.message,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Lihat data',
                            showCancelButton: true,
                            cancelButtonText: `Tutup`,

                        }).then(function (result) {
                            if (result.isConfirmed) {
                                window.location.replace(data.next.read);
                            }
                        });
                    }
                    if (data.canread) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-danger ml-3',
                                denyButton: 'btn btn-sm btn-primary ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statusText,
                            html: data.message,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Rincian dokumen',
                            showCancelButton: true,
                            cancelButtonText: `Tutup`,

                        }).then(function (result) {
                            if (result.isConfirmed) {
                                window.location.replace(data.next.read);
                            }
                        });
                    }
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
                        title: 'Gagal Memuat Status',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function () {
                    });
                });
        });
    });
</script>