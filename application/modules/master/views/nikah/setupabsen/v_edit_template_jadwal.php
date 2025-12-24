
<script>

  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgl').datepicker();
    $('#example1').dataTable();
	$('#nikatasan').selectize();
  

</script>

<?php echo $message; ?>
	

<div class="row">
  
	<div class="modal-content">
	  <div class="modal-header">
		<h4 class="modal-title" id="myModalLabel"><?php echo $title;?></h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/setupabsen/save_edit');?>" method="post">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						 <label class="col-sm-12">Kode Option</label>
						<div class="col-sm-12">
							
								<input value="<?php echo trim($dtl['kd_opt']);?>" type="text" id="kdopt" name="kdopt"  class="form-control" style="text-transform:uppercase" maxlength="6" readonly>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Nama Option</label>
						<div class="col-sm-12">

								<input value="<?php echo trim($dtl['nm_opt']);?>" type="text" id="nmopt" name="nmopt"  maxlength="40" style="text-transform:uppercase" class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Hari Aktif</label>
						<div class="col-sm-12">

								<input value="<?php echo trim($dtl['hr_aktif']);?>" type="number" id="hraktif" name="hraktif"  maxlength="2" class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>			
					<div class="form-group">
						 <label class="col-sm-12">Hari Libur</label>
						<div class="col-sm-12">

								<input value="<?php echo trim($dtl['hr_libur']);?>" type="number" id="hrlibur" name="hrlibur"  maxlength="2" class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kondisi Hari Aktif 1</label>
						<div class="col-sm-12">

								<input value="<?php echo trim($dtl['kon_1']);?>" type="number" id="kondisi_1" name="kondisi_1"  maxlength="5"  class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kondisi Hari Aktif 2</label>
						<div class="col-sm-12">

								<input value="<?php echo trim($dtl['kon_2']);?>" type="number" id="kondisi_2" name="kondisi_2"  maxlength="5" class="form-control">
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Max Active Per Week</label>
						<div class="col-sm-12">

								<input value="<?php echo trim($dtl['maxweek']);?>" type="number" id="maxweek" name="maxweek"  maxlength="5"  class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Ritme 1</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="ritme_1" id="ritme_1" required>
									 <option value=""<?php if(trim($dtl['ritme_1'])==''){echo 'selected';}?>>--Ritme Awal--</option> 
									 <option value="3"<?php if(trim($dtl['ritme_1'])==3){echo 'selected';}?>>3</option> 
									 <option value="2"<?php if(trim($dtl['ritme_1'])==2){echo 'selected';}?>>2</option> 
									 <option value="1"<?php if(trim($dtl['ritme_1'])==1){echo 'selected';}?>>1</option> 
							</select>
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Ritme 2</label>
						 <div class="col-sm-12">
							<select class="form-control input-sm" name="ritme_2" id="ritme_2">
									 <option value=""<?php if(trim($dtl['ritme_2'])==''){echo 'selected';}?>>--Ritme Kedua--</option> 
									 <option value="3"<?php if(trim($dtl['ritme_2'])==3){echo 'selected';}?>>3</option> 
									 <option value="2"<?php if(trim($dtl['ritme_2'])==2){echo 'selected';}?>>2</option> 
									 <option value="1"<?php if(trim($dtl['ritme_2'])==1){echo 'selected';}?>>1</option> 
							</select>
						</div>	
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Ritme 3</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="ritme_3" id="ritme_3">
									 <option value=""<?php if(trim($dtl['ritme_3'])==''){echo 'selected';}?>>--Ritme Ketiga--</option> 
									 <option value="3"<?php if(trim($dtl['ritme_3'])==3){echo 'selected';}?>>3</option> 
									 <option value="2"<?php if(trim($dtl['ritme_3'])==2){echo 'selected';}?>>2</option> 
									 <option value="1"<?php if(trim($dtl['ritme_3'])==1){echo 'selected';}?>>1</option> 
							</select>
						</div>
					</div>			

					<div class="form-group">
						 <label class="col-sm-12">Tanggal Input</label>
						<div class="col-sm-12">
							
								<input type="text" id="tglinput" name="tglinput"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
							
							<!-- /.input group -->
						</div>
					</div>
				
				</div>	
				<div class="col-sm-6">
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 1 All</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf1_all" id="sf1_all" required>
									  <option value="">--PILIH JAM KERJA SHIFT 1--</option>
									  <?php foreach($list_sf1 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>" <?php if(trim($dtl['sf1_all'])==trim($ls->kdjam_kerja)){echo 'selected';}?>><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 1 Jumat</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf1_jumat" id="sf1_jumat" >
									  <option value="">--PILIH JAM KERJA SHIFT 1--</option>
									  <?php foreach($list_sf1 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>"  <?php if(trim($dtl['sf1_jumat'])==trim($ls->kdjam_kerja)){echo 'selected';}?> ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 1 Sabtu</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf1_sabtu" id="sf1_sabtu" >
									  <option value="">--PILIH JAM KERJA SHIFT 1--</option>
									  <?php foreach($list_sf1 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>"  <?php if(trim($dtl['sf1_sabtu'])==trim($ls->kdjam_kerja)){echo 'selected';}?> ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>			
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 2 All</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf2_all" id="sf2_all" >
									  <option value="">--PILIH JAM KERJA SHIFT 2--</option>
									  <?php foreach($list_sf2 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>"  <?php if(trim($dtl['sf2_all'])==trim($ls->kdjam_kerja)){echo 'selected';}?> ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 2 Jumat</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf2_jumat" id="sf2_jumat" >
									  <option value="">--PILIH JAM KERJA SHIFT 2--</option>
									  <?php foreach($list_sf2 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>"  <?php if(trim($dtl['sf2_jumat'])==trim($ls->kdjam_kerja)){echo 'selected';}?> ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 2 Sabtu</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf2_sabtu" id="sf2_sabtu" >
									  <option value="">--PILIH JAM KERJA SHIFT 2--</option>
									  <?php foreach($list_sf2 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>"  <?php if(trim($dtl['sf2_sabtu'])==trim($ls->kdjam_kerja)){echo 'selected';}?> ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 3 All</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf3_all" id="sf3_all" >
									  <option value="">--PILIH JAM KERJA SHIFT 3--</option>
									  <?php foreach($list_sf3 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>"  <?php if(trim($dtl['sf3_all'])==trim($ls->kdjam_kerja)){echo 'selected';}?> ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 3 Jumat</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf3_jumat" id="sf3_jumat" >
									  <option value="">--PILIH JAM KERJA SHIFT 3--</option>
									  <?php foreach($list_sf3 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>"  <?php if(trim($dtl['sf3_jumat'])==trim($ls->kdjam_kerja)){echo 'selected';}?> ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 3 Sabtu</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf3_sabtu" id="sf3_sabtu" >
									  <option value="">--PILIH JAM KERJA SHIFT 3--</option>
									  <?php foreach($list_sf3 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>"  <?php if(trim($dtl['sf3_sabtu'])==trim($ls->kdjam_kerja)){echo 'selected';}?> ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Operator Ritme</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="operatorlist" id="operatorlist" required="required">
									 <option value="<?php echo trim($dtl['operatorlist']);?>"><?php echo trim($dtl['operatorlist']);?></option> 
									 <option value="+">+</option> 
									 <option value="-">-</option> 
							</select>
						</div>
					</div>			
					<!--div class="form-group">
						 <label class="col-sm-12">Keterangan</label>
						<div class="col-sm-12">

								<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
						
						</div>
					</div-->
					<div class="form-group">
						 <label class="col-sm-12">Input By</label>
						<div class="col-sm-12">
						
								<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

							<!-- /.input group -->
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group"> 
					<div class="col-lg-12">
					<a href="<?php echo site_url('master/setupabsen/setup_template_jadwal');?>" class="btn btn-default">Kembali</a>	
						<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
					</div>
				</div>
			</div>
			</div>
		</form>
  </div>
</div>  

