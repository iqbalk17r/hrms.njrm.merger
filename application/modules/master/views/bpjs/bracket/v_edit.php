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
<form action="<?php echo site_url('master/bracket/save')?>" method="post">
<div class="row">
	<div class="col-sm-6">
		<div class="box box-danger">
			<div class="box-body">
				<div class="form-horizontal">							
					<div class="form-group">
						<label class="col-sm-4">Tipe</label>	
						<div class="col-sm-8">
							<input type="hidden" class="form-control input-sm" value="edit" id="tipe" name="tipe" required>									
							<input type="text" class="form-control input-sm" value="<?php echo $dtl_bracket['tipe'];?>" id="tipe" maxlength='10' name="kdtipe" readonly>									
						</div>
					</div>							
					<div class="form-group">
						<label class="col-sm-4">No Urut</label>	
						<div class="col-sm-8">    
							<input type="text" class="form-control input-sm" value="<?php echo trim($dtl_bracket['nourut']);?>" id="tipe" maxlength='25' name="nourut" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Batas Bawah</label>	
						<div class="col-sm-8">   
							<div class="input-group">
								<span class="input-group-addon">Rp</span>
								<input type="number" class="form-control input-sm" value="<?php echo trim($dtl_bracket['batasbawah']);?>" id="tipe" maxlength='25' name="batasbawah" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Batas Atas</label>	
						<div class="col-sm-8">    
							<div class="input-group">
								<span class="input-group-addon">Rp</span>
								<input type="number" class="form-control input-sm" value="<?php echo trim($dtl_bracket['batasatas']);?>" id="tipe" maxlength='25' name="batasatas" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Nominal</label>	
						<div class="col-sm-8">
							<div class="input-group">								
								<input type="number" class="form-control input-sm" value="<?php echo trim($dtl_bracket['nominal']);?>" id="tipe" maxlength='25' name="nominal" required>
								<span class="input-group-addon">%</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Keterangan</label>	
						<div class="col-sm-8">    
							<textarea type="text" class="form-control input-sm" id="tipe" maxlength='25' name="keterangan" required><?php echo trim($dtl_bracket['keterangan']);?></textarea>
						</div>
					</div>																																												
				</div>
			</div><!-- /.box-body -->													
		</div><!-- /.box --> 
	</div>					
</div>
<div class="row">
	<div class="col-sm-6">		
		<a href="<?php echo site_url('master/bracket');?>" class="btn btn-primary" style="margin:10px">Kembali</a>
		<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

