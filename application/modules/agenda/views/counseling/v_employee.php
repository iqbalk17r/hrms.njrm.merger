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