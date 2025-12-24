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
<form action="<?php echo site_url('master/keldesa/save')?>" method="post">
<div class="row">
	<div class="col-sm-6">
		<div class="box box-danger">
			<div class="box-body">
				<div class="form-horizontal">							
					<div class="form-group">
						<label class="col-sm-4">Kode Kelurahan / Desa</label>	
						<div class="col-sm-8">
							<input type="hidden" class="form-control input-sm" value="edit" id="tipe" name="tipe" required>									
							<input type="hidden" class="form-control input-sm" value="<?php echo trim($dtl_keldesa['kodenegara']);?>" id="tipe" name="oldnegara" required>									
							<input type="hidden" class="form-control input-sm" value="<?php echo trim($dtl_keldesa['kodeprov']);?>" id="tipe" name="oldprov" required>									
							<input type="hidden" class="form-control input-sm" value="<?php echo trim($dtl_keldesa['kodekotakab']);?>" id="tipe" name="oldkotakab" required>									
							<input type="hidden" class="form-control input-sm" value="<?php echo trim($dtl_keldesa['kodekec']);?>" id="tipe" name="oldkec" required>									
							<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="<?php echo trim($dtl_keldesa['kodekeldesa']);?>" id="tipe" maxlength='10' name="kdkeldesa" readonly>									
						</div>
					</div>							
					<div class="form-group">
						<label class="col-sm-4">Nama Kelurahan / Desa</label>	
						<div class="col-sm-8">    
							<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="<?php echo trim($dtl_keldesa['namakeldesa']);?>" id="tipe" maxlength='25' name="namakeldesa" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Kode Pos</label>	
						<div class="col-sm-8">    
							<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="<?php echo trim($dtl_keldesa['kodepos']);?>" id="tipe" maxlength='25' name="kodepos">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Negara</label>	
						<div class="col-sm-8">    
							<select name="negara" id='negara' class="col-sm-12" required>										
								<?php foreach ($list_opt_neg as $lon){ ?>
								<option value="<?php echo trim($lon->kodenegara);?>" <?php if (trim($dtl_keldesa['kodenegara'])==trim($lon->kodenegara)) { echo 'selected';}?>><?php echo trim($lon->namanegara);?></option>																																																			
								<?php };?>
							</select>
						</div>
					</div>
					<script type="text/javascript" charset="utf-8">
					  $(function() {	
						$("#provinsi").chained("#negara");		
						$("#kotakab").chained("#provinsi");		
						$("#kec").chained("#kotakab");		
					  });
					</script>
					<div class="form-group">
						<label class="col-sm-4">Provinsi</label>	
						<div class="col-sm-8">    
							<select name="provinsi" id='provinsi' class="col-sm-12" required>
								<option value="">-KOSONG-</option>
								<?php foreach ($list_opt_prov as $lop){ ?>
								<option value="<?php echo trim($lop->kodeprov);?>" class="<?php echo trim($lop->kodenegara);?>" <?php if (trim($dtl_keldesa['kodeprov'])==trim($lop->kodeprov)) { echo 'selected';}?>><?php echo trim($lop->namaprov);?></option>																																																			
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
								<option value="<?php echo trim($lok->kodekotakab);?>" class="<?php echo trim($lok->kodeprov);?>" <?php if (trim($dtl_keldesa['kodekotakab'])==trim($lok->kodekotakab)) { echo 'selected';}?>><?php echo trim($lok->namakotakab);?></option>																																																			
								<?php };?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Kecamatan</label>	
						<div class="col-sm-8">    
							<select name="kec" id='kec' class="col-sm-12" required>
								<option value="">-KOSONG-</option>
								<?php foreach ($list_opt_kec as $lokc){ ?>
								<option value="<?php echo trim($lokc->kodekec);?>" class="<?php echo trim($lokc->kodekotakab);?>" <?php if (trim($dtl_keldesa['kodekec'])==trim($lokc->kodekec)) { echo 'selected';}?>><?php echo trim($lokc->namakec);?></option>																																																			
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
		<a href="<?php echo site_url('master/keldesa');?>" class="btn btn-primary" style="margin:10px">Kembali</a>
		<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

