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
<legend><?php echo $title;?></legend>


<!--Modal untuk Detail Bpjs Karyawan-->
<a href="<?php echo site_url("trans/dinas/")?>"  class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
<?php foreach ($list_dinas_karyawan as $lb){?>
<form action="<?php echo site_url('trans/dinas/approval')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">No. Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="status" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="A" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>								
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="department"  value="<?php echo trim($lb->nmdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="subdepartment"  value="<?php echo trim($lb->nmsubdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							<!--<div class="form-group">
								<label class="col-sm-4">Level Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlvl"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="jabatan"  value="<?php echo trim($lb->nmjabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan"  value="<?php echo trim($lb->nmatasan1); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
									
						<div class="form-horizontal">	
							<div class="form-group">
								<label class="col-sm-4">Kategori Keperluan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdkategori" id="kdkategori" disabled>
									  <option value="">--PILIH KATEGORI KEPERLUAN--</option>
									  <?php foreach($list_kategori as $listkan){ ?>
									  <option <?php if (trim($lb->kdkategori)==trim($listkan->kdkategori)) { echo 'selected';}?> value="<?php echo trim($listkan->kdkategori);?>" ><?php echo $listkan->kdkategori.' || '.$listkan->nmkategori;?></option>						  
									  <!--option <?php if (trim($lb->kdlembur)==trim($listkan->tplembur)) { echo 'selected';}?> value="<?php echo trim($listkan->tplembur);?>" ><?php echo $listkan->tplembur;?></option--->						  
									  <?php }?>
									</select>
								</div>
							</div>						
							<div class="form-group">
								<label class="col-sm-4">Keperluan Dinas</label>	
								<div class="col-sm-8">    
									<input value="<?php echo trim($lb->keperluan); ?>" type="text" id="kepdinas" name="kepdinas"   style="text-transform:uppercase" class="form-control" readonly >
									
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Tujuan Dinas</label>	
								<div class="col-sm-8">    
									<input value="<?php echo trim($lb->tujuan); ?>" type="text" id="tujdinas" name="tujdinas"   style="text-transform:uppercase" class="form-control" readonly >
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Berangkat</label>	
								<div class="col-sm-8">    
									<input type="hidden" value="<?php echo trim($lb->tgl_mulai); ?>" id="tglberangkat" name="tglberangkat" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
									<input type="text" value="<?php echo date('d-m-Y',strtotime(trim($lb->tgl_mulai)));?>"  data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Kembali</label>	
								<div class="col-sm-8">    
									<input type="hidden"  value="<?php echo trim($lb->tgl_selesai); ?>" id="tglkembali" name="tglkembali" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
									<input type="text" value="<?php echo date('d-m-Y',strtotime(trim($lb->tgl_selesai)));?>"  data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>								
						</div>
																	
				</div><!-- /.box --> 
			</div>	
	
			</div>
		</div>	
	</div>	
     <div> 
         <?php if ((trim($lb->status)=='A' and $userhr>0) OR (trim($lb->status)=='A' and $level_akses==='A') OR (trim($lb->status)=='A' and trim($lb->nik_atasan)===$nama) ){ ?>
		 <button type="submit"  class="btn btn-primary"><i class="fa fa-check"></i> APPROVAL</button>
		 <input type="hidden" id="status" name="status" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>	
	  </form>
	</div>  

	
	<?php } ?>
    
<?php } ?>
