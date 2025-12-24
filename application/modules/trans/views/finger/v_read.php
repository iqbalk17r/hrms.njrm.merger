<?php
?>
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3 class="pull-left"><?php echo $title ?></h3>
        </div>
		<div class="col-sm-12 table-responsive">
            <?php
            $this->datatablessp->generatetable();
            $this->datatablessp->jquery(3);
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    });
</script>