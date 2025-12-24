<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<div class="pull-right">Versi: <?php echo $version; ?></div>
<legend><?php echo $title;?></legend>
				<div class="row">
                    <div class="col-xs-6">
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>FILTER WILAYAH & PERIODE</h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('ga/inventaris/history_perawatan');?>" name="form" role="form" method="post">										
										<div class="form-group">
											<label class="col-lg-3">Wilayah</label>	
												<div class="col-lg-9">    
												<select class="form-control input-sm" name="kdcabang" id="kdcabang" >
													<!----option value="">---PILIH KANTOR CABANG PENEMPATAN--</option---> 
													<option value="ALL">---ALL --</option> 
													<?php foreach($list_kanwil as $sc){?>					  
													  <option value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
													<?php }?>
												</select>
												</div>
										</div>
										<!--area-->
										<div class="form-group">
											<label class="col-lg-3">Jenis & Kode Perawatan</label>	
												<div class="col-lg-9">    
												<select class="form-control input-sm" name="kdgroup" id="kdgroup"  >
													<!--option value="">---PILIH JENIS & KODE PERAWATAN--</option---> 
													<option value="ALL">---ALL --</option> 
													<?php foreach($list_scgroup as $sc){?>					  
													  <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
													<?php }?>
												</select>
												</div>
										</div>
										<div class="form-group">
											 <label class="col-lg-3">Tanggal</label>
											<div class="col-lg-9">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" id="tgl" name="tgl"  class="form-control pull-right" required>
												</div>
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

  

</script>