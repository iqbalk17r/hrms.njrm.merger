<legend><?php echo $title;?></legend>
		
				<div class="row">
                    <div class="col-xs-6">
					<?php echo $message;?>
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>Detail PPH (Setahun)</h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/final_payroll/detail_setahun');?>" name="form" role="form" method="post">										
										<!--area-->
										<div class="form-group">
											 <label class="col-lg-3">Nama Karyawan</label>
											<div class="col-lg-9">
												<select id="pilihkaryawan" name="karyawan" required>
												<option value="">--Pilih Karyawan--</option>
												<?php foreach ($list_karyawan as $ld){ ?>
												<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nik.'||'.$ld->nmlengkap;?></option>
												<?php } ?>																																					
											</select>
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
				</div>
		
	

<script>

  

	
	//Date range picker
    $('#tgl').daterangepicker();
	$('#pilihkaryawan').selectize();
	$('#dept').selectize();
  

</script>