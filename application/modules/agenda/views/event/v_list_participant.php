<style>
    button.ml-3{
        margin-left: 3px;
    }
</style>
<legend><?php echo $title;?></legend>
<?php echo $message;?>

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">

                <div class="col-sm-12">
                    <div class="bs-example pull-right margin" data-example-id="single-button-dropdown">
                        <div class="btn-group">
                            <a href="javascript:void(0)" class="btn btn-md btn-icon-only btn-twitter pull-right refresh" data-toggle="tooltip" title="Reset Filter" style=" color:#ffffff;"><i class="fa fa-fw fa-refresh"></i></a>
                        </div>
                        <div class="btn-group">
                            <a href="<?php echo $backUrl ?>" class="btn btn-md btn-warning text-secondary text-uppercase margin pull-right " style="color: #ffffff">Kembali</a>
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
<script>
    $(document).ready(function (){
        $('table.datatable').DataTable().on( 'draw', function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger : 'mouseover',
            })
        });
        $('a.refresh').on('click', function (){
            $('table#table-event-participant tfoot ').find('input.form-filter').val('');
            $('table#table-event-participant').DataTable().search('').columns().search('').draw();
            $('table#table-event-participant').DataTable()
                .ajax.url('<?php echo $refreshUrl ?>')
                .order([1, 'asc']).draw();
        })
        $('table#table-event-participant tbody').on('click', 'td a.send-notification', function () {
            var row = $(this)
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                icon: 'question',
                title: `Konfirmasi kirim notifikasi`,
                // html: `Apakah anda yakin ingin membatalkan dokumen ini ?`,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                showDenyButton: true,
                denyButtonText: `Batal`,
            }).then(function (result) {
                if (result.isConfirmed){
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
                                title: 'Berhasil Disimpan',
                                html: data.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                showConfirmButton: true,
                                showDenyButton: false,
                                confirmButtonText: `Tutup`,
                            }).then(function () {
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
                                icon: (xhr.responseJSON && xhr.responseJSON.icon ? 'warning' : 'error'),
                                title: (xhr.responseJSON && xhr.responseJSON.statusText ? xhr.responseJSON.statusText : 'Terjadi Kesalahan'),
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: true,
                                confirmButtonText: `Tutup`,
                            }).then(function () {
                            });
                        });
                }
            })
        })
    })

    /**/
</script>

