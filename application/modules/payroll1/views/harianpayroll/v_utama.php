
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
<?php echo $message;?>
		
<div class="row">
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12">
                    <h4>LIHAT LEMBUR PER DEPARTMENT</h4>
                </div>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <form action="<?php echo site_url('payroll/harianpayroll/lihat_lembur');?>" name="form" role="form" method="post">
                        <!--area-->
                        <!--div class="form-group ">
                            <label class="label-form col-sm-3">Group Penggajian</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="kdgroup_pg">
                                    <?php foreach ($list_group as $ld){ ?>
                                    <option value='<?php echo trim($ld->kdgroup_pg); ?>'><?php  echo $ld->nmgroup_pg; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div-->
                        <div class="form-group ">
                            <label class="label-form col-sm-3">Type Transaksi</label>
                            <div class="col-sm-9">
                                     <select type="text" class="form-control" name="tptr" id="tptr">
                                    <option  value="tmp">SEBELUM FINAL</option>
                                    <option  value="trx">SESUDAH FINAL</option>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="label-form col-sm-3">Department/Bagian</label>
                            <div class="col-sm-9">
                                <select id="dept" class="form-control input-sm" name="kddept" required>
                                    <option value="">--PILIH DEPARTMENT--</option>
                                    <?php foreach ($list_dept as $ld){ ?>
                                    <option value='<?php echo trim($ld->kddept); ?>'><?php  echo $ld->nmdept; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                             <label class="label-form col-sm-3">Periode</label>
                            <div class="col-sm-9">
                                <input type="text" name="tgl" id="tgl" class="form-control pull-right">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-4">
                                <button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
                               <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6">
    <?php echo $message;?>
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12">
                    <h4>LIHAT LEMBUR PER KARYAWAN</h4>
                </div>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <form action="<?php echo site_url('payroll/harianpayroll/lihat_lembur_nik');?>" name="form" role="form" method="post">
                        <!--area-->
                        <!--div class="form-group ">
                            <label class="label-form col-sm-3">Group Penggajian</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="kdgroup_pg">
                                    <?php foreach ($list_group as $ld){ ?>
                                    <option value='<?php echo trim($ld->kdgroup_pg); ?>'><?php  echo $ld->nmgroup_pg; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div-->
                        <div class="form-group ">
                            <label class="label-form col-sm-3">Type Transaksi</label>
                            <div class="col-sm-9">
                                     <select type="text" class="form-control" name="tptr" id="tptr">
                                    <option  value="tmp">SEBELUM FINAL</option>
                                    <option  value="trx">SESUDAH FINAL</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="label-form col-sm-3">Nama Karyawan</label>
                            <div class="col-sm-9">
                                <select id="nik" class="form-control input-sm" name="nik" required>
                                    <option value="">--Pilih Karyawan--</option>
                                    <?php foreach ($list_kary as $ld){ ?>
                                    <option value='<?php echo trim($ld->nik); ?>'><?php echo str_pad($ld->nik,50).' | '.str_pad($ld->nmlengkap,50)?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                             <label class="label-form col-sm-3">Periode</label>
                            <div class="col-sm-9">
                                <input type="text" name="tglnik" id="tgl2" class="form-control pull-right">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-4">
                                <button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
                               <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

     <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12">
                    <h4>DOWNLOAD REPORT LEMBUR ALL BAGIAN</h4>
                </div>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <form action="<?php echo site_url('payroll/harianpayroll/report_lembur');?>" name="form" role="form" method="post">
                        <div class="form-group ">
                            <label class="label-form col-sm-3">Type Transaksi</label>
                            <div class="col-sm-9">
                                     <select type="text" class="form-control" name="tptr" id="tptr">
                                    <option  value="tmp">SEBELUM FINAL</option>
                                    <option  value="trx">SESUDAH FINAL</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                             <label class="label-form col-sm-3">Periode</label>
                            <div class="col-sm-9">
                                <input type="text" name="tgl" id="tgl3" class="form-control pull-right">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-4">
                                <button type='submit' class='btn btn-success' ><i class="glyphicon glyphicon-search"></i> Download</button>
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
    $('#tgl2').daterangepicker();
    $('#tgl3').daterangepicker();
	$('#pilihkaryawan').selectize();
	$('#dept').selectize();
	$("#nik").selectize();
  

</script>