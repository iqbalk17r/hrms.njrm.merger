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
<form action="<?php echo site_url('master/kotakab/save')?>" method="post">
<div class="row">
	<div class="col-sm-6">
		<div class="box box-danger">
			<div class="box-body">
				<div class="form-horizontal">							
					<div class="form-group">
						<label class="col-sm-4">Kode Kota/Kabupaten</label>	
						<div class="col-sm-8">
							<input type="hidden" class="form-control input-sm" value="edit" id="tipe" name="tipe" required>									
							<input type="text" class="form-control input-sm" value="<?php echo $dtl_kotakab['kodekotakab'];?>" id="tipe" maxlength='10' name="kdkotakab" readonly>									
						</div>
					</div>							
					<div class="form-group">
						<label class="col-sm-4">Nama Kota/Kabupaten</label>	
						<div class="col-sm-8">    
							<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="<?php echo trim($dtl_kotakab['namakotakab']);?>" id="tipe" maxlength='25' name="namakotakab" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Negara</label>	
						<div class="col-sm-8">    
							<select name="negara" id='pmnu' class="col-sm-12">										
								<?php foreach ($list_opt_neg as $lon){ ?>
								<option value="<?php echo trim($lon->kodenegara);?>" <?php if (trim($dtl_kotakab['kodenegara'])==trim($lon->kodenegara)) { echo 'selected';}?>><?php echo trim($lon->namanegara);?></option>																																																			
								<?php };?>
							</select>
						</div>
					</div>
					<script type="text/javascript" charset="utf-8">
					  $(function() {	
						$("#pmsu").chained("#pmnu");		
						$("#cjabt").chained("#csubdept");		
					  });
					</script>
					<div class="form-group">
						<label class="col-sm-4">Provinsi</label>	
						<div class="col-sm-8">    
							<select name="provinsi" id='pmsu' class="col-sm-12">
								<option value="">-KOSONG-</option>
								<?php foreach ($list_opt_prov as $lop){ ?>
								<option value="<?php echo trim($lop->kodeprov);?>" class="<?php echo trim($lop->kodenegara);?>" <?php if (trim($dtl_kotakab['kodeprov'])==trim($lop->kodeprov)) { echo 'selected';}?>><?php echo trim($lop->namaprov);?></option>																																																			
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
		<a href="<?php echo site_url('master/kotakab');?>" class="btn btn-primary" style="margin:10px">Kembali</a>
		<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

