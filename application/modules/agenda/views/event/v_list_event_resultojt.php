<legend><?php echo $title;?></legend>
<?php echo $message;?>

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-12">
                    <!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
                    <a href="<?php echo $backUrl ?>" class="btn btn-md btn-warning text-secondary text-uppercase margin pull-right " style="color: #ffffff">Kembali</a>
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
<!-- Modal Schedule-->
<div class="modal fade" id="modal-event-result" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
<script>
    function loadmodal(url) {
        $('div#modal-event-result')
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
                    $('div#modal-event-result').modal({
                        keyboard: false,
                        backdrop: 'static',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                    $('div#modal-event-result').modal('show');
                }
            });
    }
    $(document).ready(function (){
        $('table.datatable').DataTable().on( 'draw', function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger : 'mouseover',
            })
        });
        $('table#table-event-result tbody').on('click', 'td a.create', function () {
            var row = $(this);
            loadmodal(row.data('href'))
        })
        $('table#table-event-result tbody').on('click', 'td a.read', function () {
            var row = $(this);
            loadmodal(row.data('href'))
        })
    })
</script>