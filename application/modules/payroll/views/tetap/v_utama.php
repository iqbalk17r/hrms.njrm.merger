<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
        <?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>
            <li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>
        <?php } else { ?>
            <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
        <?php } ?>
    <?php } ?>
</ol>
<h3><?php echo $title; ?></h3>
<div class="row">
    <div class="col-xs-6">
        <?php echo $message;?>
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12">
                    <h4>Filter Group Penggajian</h4>
                </div>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <form action="<?php echo site_url('payroll/tetap/detail');?>" name="form" role="form" method="post">
                        <div class="form-group">
                            <label class="col-lg-3">Pilih Group Penggajian</label>
                            <div class="col-lg-9">
                                <select id="kdgroup_pg" name="kdgroup_pg" required>
                                    <option value="">--Pilih Group Penggajian--</option>
                                    <?php foreach ($list_gp as $lg){ ?>
                                        <option value="<?php echo trim($lg->kdgroup_pg);?>"><?php echo $lg->nmgroup_pg;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!--area-->
                        <!--div class="form-group">
                             <label class="col-lg-3">Nama Karyawan</label>
                            <div class="col-lg-9">
                                <select id="pilihkaryawan" name="nik" required>
                                <option value="">--Pilih Karyawan--</option>
                                <!?php foreach ($list_karyawan as $ld){ ?>
                                <option value="<!?php echo trim($ld->nik);?>"><!?php echo $ld->nik.'|'.$ld->nmlengkap;?></option>
                                <!?php } ?>
                            </select>
                            </div>
                        </div-->
                        <!--<div class="form-group">
                             <label class="col-lg-3">Tanggal</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" id="tgl" name="tgl"   class="form-control pull-right">
                                </div>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <div class="col-lg-12">
                                <button type='submit' class='btn btn-primary pull-right' ><i class="glyphicon glyphicon-search"></i> Proses</button>
                                <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>




    //Date range picker
    $('#tgl').daterangepicker();
    $('#pilihkaryawan').selectize();
    $('#kdgroup_pg').selectize();


</script>