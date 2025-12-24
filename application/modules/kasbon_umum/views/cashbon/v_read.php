<?php
?>
<style>
    .table-bordered>tbody>tr>td {
        vertical-align: middle !important;
    }
    .mr-4{
        margin-right: 20px;
    }
    .ml-3{
        margin-left: 3px;
    }
    .select2-selection__rendered {
        line-height: 31px !important;
    }
    .select2-container .select2-selection--single {
        height: 35px !important;
    }
    .select2-selection__arrow {
        height: 34px !important;
    }
</style>
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3 class="pull-left"><?php echo $title ?></h3>

        </div>

        <div class="btn-group pull-right mr-5">
            <div class="row">
                <div class="col-sm-6">
                    <a href="javascript:void(0)" data-href="<?php echo $filterUrl ?>" data-action="filter" class="btn btn-md btn-twitter filter"><span><i class="fa fa-search"></i></span> Filter Pencarian</a>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-primary dropdown-toggle ml-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><i class="fa fa-plus"></i></span> Buat Kasbon <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu bg-primary ">
                        <?php
                        echo '<li><a href="'.site_url('kasbon_umum/cashbondinas/create_cashbon/'.bin2hex(json_encode(array('type'=>'DN')))).'">DINAS</a></li>';
                        foreach ($type as $type){
                            echo '<li><a href="'.site_url('kasbon_umum/cashbon/create_cashbon/'.bin2hex(json_encode(array('type'=>$type->id))) ).'">'.$type->text.'</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="box-body">
        <div class="col-sm-12 table-responsive">
            <?php
            $this->datatablessp->generatetable();
            $this->datatablessp->jquery();
            ?>
        </div>
    </div>
</div>
<div class="modal fade" id="printcashbon" role="dialog" aria-hidden="true"></div>
<div class="modal fade" id="modify-data" role="dialog" aria-hidden="true"></div>
<script>
    function filter(tableid,columnIndex,source){
        var table = $(tableid).DataTable();
        table
            .column([columnIndex])
            .search(source.val())
            .draw();
    }
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
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function () {
                    });
                } else {
                    $('div#modify-data').modal('show');
                }
            });
    }
    $(document).ready(function() {
        $('a.filter').on('click', function(){
            var row = $(this);
            loadmodal(row.attr('data-href'))
        })

        $('select#cashbonstatus').select2();
        $('select#cashbonstatus').on('change',function (){
            filter('table#table-cashbon',2,$(this));
        })

        $('table#table-cashbon tbody').on('click', 'td a.popup', function () {
            var row = $(this);
            $.getJSON(row.attr('data-href'), {})
                .done(function(data) {
                    if (data.cancreate) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statustext,
                            html: `Buat Kasbon dinas <b>${data.data.dutieid}</b> ?`,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Buat',
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                window.location.replace(data.next);
                            }
                        });
                    }
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
                            title: data.statustext,
                            html: `Ubah Kasbon <b>${data.data.cashbonid}</b> ?`,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Ubah / Batal',
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                window.location.replace(data.next);
                            }
                        });
                    }
                    if (data.canceled) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'info',
                            title: data.statustext,
                            html: `Kasbon <b>${data.data.cashbonid}</b> telah dibatalkan`,
                            showConfirmButton: true,
                            confirmButtonText: 'Tutup',

                        })
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
                            title: data.statustext,
                            html: `Ubah atau Setujui Kasbon <b>${data.data.cashbonid}</b> ?`,
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
                    if (data.canprint) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statustext,
                            html: `Cetak Kasbon <b>${data.data.cashbonid}</b> ?`,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Cetak',
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                $('div.modal#printcashbon')
                                    .empty()
                                    .load(data.next, {}, function (response, status, xhr) {
                                        if (status === 'error') {
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
                                                title: 'Gagal Memuat Printer',
                                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                                showCloseButton: true,
                                                showConfirmButton: false,
                                                showDenyButton: true,
                                                denyButtonText: `Tutup`,
                                            }).then(function(){ });
                                        } else {
                                            $('div.modal#printcashbon').modal('show');
                                        }
                                    });
                            }
                        });
                    }
                })
                .fail(function(xhr, status, thrown) {
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