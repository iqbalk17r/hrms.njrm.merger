<?php 
/*
	@author : hanif_anak_metal \m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example4").dataTable();
				//datemask
				//$("#datemaskinput").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});                               
				//$("#datemaskinput").daterangepicker();                              
				$("#dateinput").datepicker();                               
            });			
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
</br>
<form action="<?php echo site_url('master/prov/save')?>" method="post">
<div class="row">
	<div class="col-sm-6">
		<div class="box box-danger">
			<div class="box-body">
				<div class="form-horizontal">							
					<div class="form-group">
						<label class="col-sm-4">KODE PROVINSI</label>	
						<div class="col-sm-8">
							<input type="hidden" class="form-control input-sm" value="edit" id="tipe" name="tipe" required>									
							<input type="text" class="form-control input-sm" value="<?php echo $dtl_prov['kodeprov'];?>" id="tipe" maxlength='10' name="kdprov" readonly>									
						</div>
					</div>							
					<div class="form-group">
						<label class="col-sm-4">NAMA PROVINSI</label>	
						<div class="col-sm-8">    
							<input type="text" style="text-transform:uppercase ;" class="form-control input-sm" value="<?php echo trim($dtl_prov['namaprov']);?>" id="tipe" maxlength='25' name="namaprov" required>
						</div>
					</div>						
					<div class="form-group">
						<label class="col-sm-4">NEGARA</label>	
						<div class="col-sm-8">    
							<select name="negara" id='pmnu' class="col-sm-12">								
								<?php foreach ($list_opt_neg as $lom){ ?>
								<option value="<?php echo trim($lom->kodenegara);?>" <?php if (trim($dtl_prov['kodenegara'])==trim($lom->kodenegara)) { echo 'selected';}?>><?php echo trim($lom->namanegara);?></option>																																																			
								<?php };?>
							</select>
						</div>
					</div>																								
				</div>
			</div><!-- /.box-body -->													
		</div><!-- /.box --> 
	</div>					
</div>
<div class="row">
	<div class="col-sm-6">		
		<a href="<?php echo site_url('master/prov');?>" class="btn btn-primary" style="margin:10px">Kembali</a>
		<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

