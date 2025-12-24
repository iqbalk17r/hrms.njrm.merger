<style>
    .ml-3{
        margin-left: 3px;
    }
</style>
<div class="modal-dialog modal-dialog-scrollable <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <div class="modal-content">
        <form role="form" name="create-outlet-period" id="create-outlet-period" action="<?php echo $formAction ?>" method="post" class="m-0">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php echo(isset($modalTitle) ? $modalTitle : 'Header') ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>BULAN</label>
                    <select name="month" id="month" class="form-control">
                        <?php foreach ($months as $index => $month) {
                            echo '<option value="'.$index.'" '.(date('m')==$index ? 'selected':'').'>'.strtoupper($month).'</option>';
                        } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>TAHUN</label>
                    <select name="year" id="year" class="form-control select2">
                        <?php foreach ($years as $index => $year) {
                            echo '<option value="'.$year.'">'.$year.'</option>';
                        } ?>
                    </select>
                </div>
                <div class="form-group mt-2 mb-2">
                    <label class="form-label" for="type">TIPE</label>
                    <select class="form-control dtsearch select2" name="declarationcashbontype" id="declarationcashbontype" >
                        <?php
                        echo '<option value="">SEMUA</option>';
                        echo '<option value="TANPA KASBON">TANPA KASBON</option>';
                        foreach ($type as $key => $row){
                            echo '<option value="'.$row->text.'">'.$row->text.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mt-2 mb-2">
                    <label class="form-label" for="declarationcashbonstatus">STATUS</label>
                    <select class="form-control dtsearch select2" name="declarationcashbonstatus" id="declarationcashbonstatus" >
                        <?php
                        foreach ($status as $key => $row){
                            echo '<option value="'.$key.'">'.strtoupper($row).'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function (){

    })
</script>