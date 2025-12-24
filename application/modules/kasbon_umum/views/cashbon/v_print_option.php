<?php
?>
<style>
</style>
<div class="modal-dialog modal-xl">
    <div class="modal-content" style="height: 80%">
        <form role="form" class="formprintoption" action="javascript:void(0)" method="post">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $title ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">Sesuaikan Ukuran</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <input type="text" name="fontsize" class="form-control autonumeric">
                                                <span class="input-group-btn"><button class="btn btn-default option" type="button">Font</button></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <input type="text" name="marginsize" class="form-control autonumeric">
                                                <span class="input-group-btn"><button class="btn btn-default option" type="button">Margin</button></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <input type="text" name="paddingsize" class="form-control autonumeric">
                                                <span class="input-group-btn"><button class="btn btn-default option" type="button">Padding</button></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Print Preview</div>
                                <div class="panel-body scroll">
                                    <div class="preview">
                                        <?php include APPPATH.'\modules\kasbon_umum\views\cashbon\v_read_pdf.php' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning print">Print</button>
                <button type="button" class="btn btn-success download">Download Pdf</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('div.scroll').slimScroll({
            width: '100%',
            height: '500px',
            size: '12px',
            allowPageScroll : true,
        });
        AutoNumeric.multiple('input.autonumeric', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: 0,
            unformatOnSubmit: true,
        });
        $('form.formprintoption').submit(function(e){
            e.preventDefault();
        });
        function printData()
        {
            var divToPrint=$('div.preview')[0];
            newWin= window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print({
                addGlobalStyles : false,
                rejectWindow : true,
                iframe : true,
            });
            newWin.close();
        }
        $('button.print').on('click', function () {
            printData();
            /*$('div.preview').print({
                addGlobalStyles : false,
                rejectWindow : true,
                iframe : true,
            });*/
        });
        $('button.download').on('click', function () {
            window.location.replace('<?php echo site_url('kasbon_umum/cashbon/exportpdf/'.bin2hex(json_encode(array('cashbonid' => $cashbon->cashbonid, )))) ?>?' + $('form.formprintoption').serialize())
        });
        $('button.option').on('click', function () {
            $('div.preview')
                .empty()
                .load('<?php echo site_url('kasbon_umum/cashbon/preview/'.bin2hex(json_encode(array('cashbonid' => $cashbon->cashbonid, )))) ?>', $('form.formprintoption').serialize(), function (response, status, xhr) {
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
                            title: 'Gagal Memuat Preview',
                            html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                            showCloseButton: true,
                            showConfirmButton: false,
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function(){ });
                    }
                });
        });
    });
</script>
