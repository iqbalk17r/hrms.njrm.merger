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
<form action="<?php echo site_url('master/kec/save')?>" method="post">
<div class="row">
	<div class="col-sm-6">
		<div class="box box-danger">
			<div class="box-body">
				<div class="form-horizontal">							
					<div class="form-group">
						<label class="col-sm-4">Kode Kecamatan</label>	
						<div class="col-sm-8">
							<input type="hidden" class="form-control input-sm" value="edit" id="tipe" name="tipe" required>									
							<input type="hidden" class="form-control input-sm" value="<?php echo trim($dtl_kec['kodenegara']);?>" id="tipe" name="oldnegara" required>									
							<input type="hidden" class="form-control input-sm" value="<?php echo trim($dtl_kec['kodeprov']);?>" id="tipe" name="oldprov" required>									
							<input type="hidden" class="form-control input-sm" value="<?php echo trim($dtl_kec['kodekotakab']);?>" id="tipe" name="oldkotakab" required>									
							<input type="text" class="form-control input-sm" value="<?php echo trim($dtl_kec['kodekec']);?>" id="tipe" maxlength='10' name="kdkec" readonly>									
						</div>
					</div>							
					<div class="form-group">
						<label class="col-sm-4">Nama Kecamatan</label>	
						<div class="col-sm-8">    
							<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="<?php echo trim($dtl_kec['namakec']);?>" id="tipe" maxlength='25' name="namakec" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Negara</label>	
						<div class="col-sm-8">    
							<select name="negara" id='negara' class="col-sm-12" required>										
								<?php foreach ($list_opt_neg as $lon){ ?>
								<option value="<?php echo trim($lon->kodenegara);?>" <?php if (trim($dtl_kec['kodenegara'])==trim($lon->kodenegara)) { echo 'selected';}?>><?php echo trim($lon->namanegara);?></option>																																																			
								<?php };?>
							</select>
						</div>
					</div>
					<script type="text/javascript" charset="utf-8">
					  $(function() {	
						$("#provinsi").chained("#negara");		
						$("#kotakab").chained("#provinsi");		
					  });
					</script>
					<div class="form-group">
						<label class="col-sm-4">Provinsi</label>	
						<div class="col-sm-8">    
							<select name="provinsi" id='provinsi' class="col-sm-12" required>
								<option value="">-KOSONG-</option>
								<?php foreach ($list_opt_prov as $lop){ ?>
								<option value="<?php echo trim($lop->kodeprov);?>" class="<?php echo trim($lop->kodenegara);?>" <?php if (trim($dtl_kec['kodeprov'])==trim($lop->kodeprov)) { echo 'selected';}?>><?php echo trim($lop->namaprov);?></option>																																																			
								<?php };?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Kota/Kabupaten</label>	
						<div class="col-sm-8">    
							<select name="kotakab" id='kotakab' class="col-sm-12" required>
								<option value="">-KOSONG-</option>
								<?php foreach ($list_opt_kotakab as $lok){ ?>
								<option value="<?php echo trim($lok->kodekotakab);?>" class="<?php echo trim($lok->kodeprov);?>" <?php if (trim($dtl_kec['kodekotakab'])==trim($lok->kodekotakab)) { echo 'selected';}?>><?php echo trim($lok->namakotakab);?></option>																																																			
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
		<a href="<?php echo site_url('master/kec');?>" class="btn btn-primary" style="margin:10px">Kembali</a>
		<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

