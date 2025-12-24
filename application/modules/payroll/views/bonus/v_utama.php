<legend><?php echo $title;?></legend>
				<div class="row">
                    <div class="col-xs-6">
					<?php echo $message;?>
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>Filter Data Karyawan</h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/bonus/detail');?>" name="form" role="form" method="post">										
										<!--area-->
										<div class="form-group">
											 <label class="col-lg-3">Nama Karyawan</label>
											<div class="col-lg-9">
												<select id="pilihkaryawan" name="nik" required>
												<option value="">--Pilih Karyawan--</option>
												<?php foreach ($list_karyawan as $ld){ ?>
												<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nik.'|'.$ld->nmlengkap;?></option>
												<?php } ?>																																					
											</select>
											</div>
										</div>
										<!--<div class="form-group">
											 <label class="label-form col-sm-3">Periode</label>
											<div class="col-sm-9">
												
													<select class="form-control input-sm" name='bulan'>
									
													<option value="01" <?php //$tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
													<option value="02" <?php //$tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
													<option value="03" <?php //$tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
													<option value="04" <?php //$tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
													<option value="05" <?php //$tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
													<option value="06" <?php //$tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
													<option value="07" <?php //$tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
													<option value="08" <?php //$tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
													<option value="09" <?php //$tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
													<option value="10" <?php //$tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
													<option value="11" <?php //$tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
													<option value="12" <?php //$tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
													</select>
												
											</div>
										</div>
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
				</div>
		
	

<script>

  

	
	//Date range picker
    $('#tgl').daterangepicker();
	$('#pilihkaryawan').selectize();
  

</script>