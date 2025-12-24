<?php
?>
<style>
    .table-bordered>tbody>tr>td {
        vertical-align: middle !important;
    }
    .mr-4{
        margin-right: 20px;
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
                <a href="<?php echo site_url('kasbon_umum/cashbon') ?>" class="btn btn-md btn-warning mr-4"> Kembali</a>
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
<script>
    function filter(tableid,columnIndex,source){
        var table = $(tableid).DataTable();
        table
            .column([columnIndex])
            .search(source.val())
            .draw();
    }

    $(document).ready(function() {
        $('table#table-employee tbody').on('click', 'td a.popup', function () {
            var row = $(this);
            $.getJSON(row.attr('data-href'), {type:'DN'})
                .done(function(data) {
                    if (data.cancreate) {
                        window.location.href = data.next
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