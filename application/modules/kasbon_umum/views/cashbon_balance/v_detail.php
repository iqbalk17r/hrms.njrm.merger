<?php
?>
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3 class="pull-left"><?php echo $title ?></h3>
            <a href="<?php echo site_url('kasbon_umum/balancecashbon/index')?>" class="btn btn-sm btn-warning pull-right">Kembali</a>
        </div>

    </div>
    <div class="box-body">
        <div class="container row">
            <div class="col-sm-6">
                <span class="text-success"><h4><b><?=$emp_name?></b></h4></span>
                <span class="text-muted font-weight-bold"><h5><?=$emp_deptname?></h5></span>
            </div>
        </div>
        <div class="col-sm-12 table-responsive">
            <?php
            $this->datatablessp->generatetable();
            $this->datatablessp->jquery();
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('table#table-balance-cashbon-detail').DataTable().order([ [1,'asc'],[2,'asc'] ]).draw()
    });
    /*ordering :false*/
</script>