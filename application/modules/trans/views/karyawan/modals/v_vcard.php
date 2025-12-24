<?php //var_dump();die(); ?>
<style>
    .ml-3{
        margin-left:3px;
    }
    textarea{
        resize: none;
    }
    .contact{
        border: dashed 2px forestgreen;
    }
    .mw-200{
        min-width: 200px !important;
        width: 80%;
    }
</style>
<div class="modal-dialog modal-dialog-scrollable <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <div class="modal-content">
        <form role="form" name="formfilter" id="formfilter" action="<?php echo $actionUrl ?>" method="post" class="m-0 formfilter">
            <div class="modal-header bg-success">
                <h4 class="modal-title"><?php echo(isset($modalTitle) ? $modalTitle : 'Header') ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="contact">
                        <center>
                            <img src="<?php echo base_url($vcard) ?>" alt="" class="img-fluid img-thumbnail">
                        </center>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left ml-3" data-toggle="modal" data-target="#modify-data">Tutup</button>
                <a href="<?php echo $downloadUrl ?>" class="btn btn-success pull-right ml-3" ><i class="fa fa-download"> Kartu Nama</i></a>
                <a href="<?php echo $downloadQR ?>" class="btn btn-primary pull-right ml-3" ><i class="fa fa-download"> Kode QR</i></a>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function (){

    })
</script>

