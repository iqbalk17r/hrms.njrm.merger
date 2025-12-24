<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example4").dataTable();
				//datemask
				//$("#datemaskinput").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});                               
				//$("#datemaskinput").daterangepicker();                              
				$("#tgl1").datepicker();                               
				$("#tgl2").datepicker();                               
				$("#tgl3").datepicker();                               
				$("#tgl4").datepicker();                               
				$("#tglmasuk").datepicker();
				$("#ktpkeluar").datepicker();	
            });			
</script>

<legend><?php echo $title;?></legend>

<form class="form-horizontal" action="<?php echo site_url('options/simpanconfig');?>" method="post">
			
			<div class="modal-body">										
			<div class="row">
				<div class="col-sm-12">
					<div class="box box-danger">
						<div class="box-body">
							<div class="form-horizontal">								
								<div class="form-group">
									<label class="col-sm-4">Tahun</label>	
										<div class="col-sm-8">    
										<input type="text" class="col-sm-12 form-control input-sm" name="tahunperiode" value="<?php echo $tahun['valchar'];?>">		
											
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Periode Awal</label>	
										<div class="col-sm-8"> 
											
											<input type="text" class="col-sm-12 form-control input-sm" name="tahunawal" value="<?php echo $awal['tgl'];?>" data-date-format="dd-mm-yyyy" class="form-control" id="tgl1">	
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Periode Akhir</label>	
										<div class="col-sm-8">    
											<input type="text" class="col-sm-12 form-control input-sm" name="tahunakhir" value="<?php echo $akhir['tgl'];?>" data-date-format="dd-mm-yyyy" class="form-control" id="tgl2">
										</div>
										
								</div>
								
								<div class="form-group">
									<label class="col-sm-4">Admin</label>	
										<div class="col-sm-8">    
											<select class="form-control input-sm" name="useradmin" required>
												<option value="">--Pilih User--></option>						
													<?php foreach ($list_admin as $db){?>
														<option value="<?php echo trim($db->userid);?>" <?php if (trim($admin['valchar'])==trim($db->userid)) {echo 'selected';};?>><?php echo str_pad($db->userlname,50);?></option>													
													<?php }?>
												</select>
										</div>
								</div><div class="form-group">
									<label class="col-sm-4">No Handphone Admin</label>	
										<div class="col-sm-8">  
										
											<input type="text" class="col-sm-12 form-control input-sm" name="handphone" value="<?php echo trim($hp['valchar']);?>">
										</div>
								</div>
								
							</div>
						</div><!-- /.box-body -->													
					</div><!-- /.box --> 
				</div>			
			</div><!--row-->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Akan Di Simpan?')">Simpan</button>											
			</div>
			</form>