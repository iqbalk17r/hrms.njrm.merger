
<legend><?php echo $title;?></legend>
		
				<div class="row">
                    <div class="col-xs-6">
					<?php echo $message;?>
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>DEKLARASI KARYAWAN</h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('trans/dinas/index_deklarasi');?>" name="form" role="form" method="post">										
	
										<div class="form-group ">		
											<label class="label-form col-sm-3">Type Transaksi</label>
											<div class="col-sm-9">
													<select type="text" class="form-control" name="tpdeclare" id="tpdeclare">
													<option  value="TMP">SEBELUM FINAL</option>
													<option  value="TRX">SESUDAH FINAL</option> 
													</select>
											</div>
										</div>
															
										<!--div class="form-group ">		
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
										</div--->
										
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
    $('#tgl2').daterangepicker();
    $('#tgl3').daterangepicker();
	$('#pilihkaryawan').selectize();
	$('#dept').selectize();
	$("#nik").selectize();
  

</script>