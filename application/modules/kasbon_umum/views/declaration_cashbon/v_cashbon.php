<?php

?>
<style>
    .table-bordered>tbody>tr>td {
        vertical-align: middle !important;
    }
    .ml-3{
        margin-left: 3px;
    }
    li.select2-selection__choice{
        background-color: blue !important;
    }
    span.select2-selection__choice__remove{
        color: white !important;
    }
</style>
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3><?php echo $title ?></h3><br>
            <a href="<?php echo site_url('kasbon_umum/declarationcashbon/employee') ?>" class="btn btn-md btn-warning pull-right">Kembali</a>
        </div>
    </div>
    <div class="box-body">

        <div class="col-sm-12 table-responsive">
            <?php
            $this->datatablessp->generatetable();
            $this->datatablessp->jquery(2);
            ?>
        </div>
    </div>
</div>
<div class="modal fade" id="printcashbon" role="dialog" aria-hidden="true"></div>
<script>
    function defaultFilter(){
        var status = $('select#declarationcashbonstatus')
        var table = $('table#table-declarationcashbon').DataTable();
        table
            .columns()
            .search('')
            .column([5])
            .search('')
            .column([7])
            .search(status.val())
            .draw();
    }
    $(document).ready(function() {
        // $('select.select2').select2();
        defaultFilter();

        $('select.dtsearch').select2();

        $('select.dtsearch').on('change',function (){
            var status = $('select#declarationcashbonstatus')
            var type = $('select#declarationcashbontype')
            var table = $('table#table-declarationcashbon').DataTable();
            table
                .columns()
                .search('')
                .column([5])
                .search(type.val())
                .column([7])
                .search(status.val())
                .draw();
        })

        $('table#table-declarationcashbon tbody').on('click', 'td a.read-detail', function () {
            var row = $(this);
            $.getJSON(row.attr('data-href'), {})
                .done(function (data) {
                    if (data.canread) {
                        window.location.replace(data.next);
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
                        title: 'Gagal Memuat Data',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function () {
                    });
                });
        })
        $('table#table-declarationcashbon tbody').on('click', 'td a.popup', function () {
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
                            html: `Buat deklarasi Kasbon <b>${data.data.cashbonid.length > 0 ? data.data.cashbonid : data.data.dutieid}</b> ?`,
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
                            html: `Ubah deklarasi Kasbon <b>${data.data.declarationid}</b> ?`,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Ubah',
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                window.location.replace(data.next);
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
                            title: data.statustext,
                            html: `Ubah atau Setujui deklarasi Kasbon <b>${data.data.declarationid}</b> ?`,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Ubah',
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
                            html: `Cetak Deklarasi Kasbon <b>${data.data.declarationid}</b> ?`,
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