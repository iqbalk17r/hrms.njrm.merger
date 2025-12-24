<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
        $("#example2").dataTable();
        $("#example3").dataTable();
        $("#dateinput").datepicker();
        $("#dateinput1").datepicker();
        $("#dateinput2").datepicker();
        $("#dateinput3").datepicker();
        $("[data-mask]").inputmask();
    });
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <legend>
            <?php echo $title;?>
        </legend>
        <ol class="breadcrumb">
            <div class="pull-right">Versi: <?php echo $version; ?></div>
            <?php foreach ($y as $y1) { ?>
                <?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>
                    <li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>
                <?php } else { ?>
                    <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
                <?php } ?>
            <?php } ?>
        </ol>
    </section>