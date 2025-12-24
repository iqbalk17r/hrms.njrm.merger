<style>
    .ml-3 {
        margin-left: 1rem;
    }
    div.row div.box{
        min-height: 75vh;
    }
</style>
<legend><?php echo $title; ?></legend>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-12">
                    <!-- <?php// if ($this->useraccess->user($menuID,'aksesinput')){ ?> -->
                        <button href="javascript:void(0)" data-href="<?php echo $inputUrl ?>" class="btn btn-md btn-success text-secondary text-uppercase margin create" data-toggle="tooltip" title="Tambah Data"><i class="fa fa-plus"></i></button>
                    <?php// } ?>
                    <div class="bs-example pull-right margin" data-example-id="single-button-dropdown">
                        <div class="btn-group">
                            <a href="javascript:void(0)" class="btn btn-md btn-icon-only btn-twitter pull-right refresh" data-toggle="tooltip" title="Reset Filter"><i class="fa fa-refresh"></i></a>
                        </div>
                        <div class="btn-group">
                            <!--<a href="#" data-target="#filter" class="btn btn-md btn-facebook pull-right" data-toggle="tooltip" title="Filter">
                                <i class="fa fa-search"></i>
                            </a>-->
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
<!-- Modal Modify-->
<div class="modal fade" id="modify-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
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
                        title: 'Gagal Memuat Detail',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: true,
                        showDenyButton: false,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                    });
                } else {
                    $('div#modify-data').modal({
                        keyboard: false,
                        backdrop: 'static',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                    $('div#modify-data').modal('show');
                }
            });
    }
    $(document).ready(function(){
        $('button.create').on('click', function (){
            var row = $(this)
            loadmodal(row.data('href'))
        })
        $('table#table-room').on('click','a.update', function (){
            var row = $(this)
            loadmodal(row.data('href'))
        })

        $('table#table-room').on('click','a.delete', function (){
            var row = $(this)
            console.log(row.data('href'))
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah anda yakin ingin menghapus ruangan ini ?`,
                icon: 'question',
                showCloseButton: true,
                showDenyButton: true,
                confirmButtonText: 'Konfirmasi',
                denyButtonText: 'Batal',
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
                                $('div#modify-data').modal('hide');
                                $('table#table-room').DataTable().draw(false);
                            });
                        },
                        error: function (xhr, status, thrown) {
                            console.log(xhr)
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
                    });
                }
            });
        });

        $('button.create').on('click', function (){
            var row = $(this)
            loadmodal(row.data('href'))
        })
        $('a.refresh').on('click', function (){
            $('table#table-room tfoot ').find('input.form-filter').val('');
            $('table#table-room').DataTable().search('').columns().search('').draw();
            $('table#table-room').DataTable()
                //.ajax.url('<?php //echo base_url('agenda/counseling/index')?>//')
                .order([1, 'asc']).draw();
        })
    });
</script>