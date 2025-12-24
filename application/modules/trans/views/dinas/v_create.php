<?php
?>
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3 class="pull-left"><?php echo $title ?></h3>
        </div>
        <div class="col-sm-12">
            <a href="<?php echo site_url('trans/dinas') ?>" class="btn btn-warning pull-right">Kembali</a>
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
