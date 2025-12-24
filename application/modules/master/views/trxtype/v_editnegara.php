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
<form action="<?php echo site_url('master/negara/save')?>" method="post">
<div class="row">
	<div class="col-sm-6">
		<div class="box box-danger">
			<div class="box-body">
				<div class="form-horizontal">							
					<div class="form-group">
						<label class="col-sm-4">KODE negara</label>	
						<div class="col-sm-8">
							<input type="hidden" class="form-control input-sm" value="edit" id="tipe" name="tipe" required>									
							<input type="text" class="form-control input-sm" style="text-transform:uppercase ;" value="<?php echo $dtl_negara['kodenegara'];?>" id="tipe" maxlength='10' name="kdnegara" readonly>									
						</div>
					</div>							
					<div class="form-group">
						<label class="col-sm-4">NAMA negara</label>	
						<div class="col-sm-8">    
							<input type="text" class="form-control input-sm" style="text-transform:uppercase ;" value="<?php echo trim($dtl_negara['namanegara']);?>" id="tipe" maxlength='25' name="namanegara" required>
						</div>
					</div>																																												
				</div>
			</div><!-- /.box-body -->													
		</div><!-- /.box --> 
	</div>					
</div>
<div class="row">
	<div class="col-sm-6">		
		<a href="<?php echo site_url('master/negara');?>" class="btn btn-primary" style="margin:10px">Kembali</a>
		<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

