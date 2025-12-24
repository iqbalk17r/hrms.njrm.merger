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
<form action="<?php echo site_url('master/bpjskomponen/save')?>" method="post">
<div class="row">
	<div class="col-sm-6">
		<div class="box box-danger">
			<div class="box-body">
				<div class="form-horizontal">							
					<div class="form-group">
						<label class="col-sm-4">Kode Komponen Bpjs</label>	
						<div class="col-sm-8">
							<input type="hidden" class="form-control input-sm" value="edit" id="tipe" name="tipe" required>									
							<input type="text" class="form-control input-sm" value="<?php echo $dtl_bpjs['kodekomponen'];?>" id="tipe" maxlength='10' name="kdkompbpjs" readonly>									
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Kode Bpjs</label>	
						<div class="col-sm-8">									
							<select type="text" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdbpjs" required>
								<?php foreach ($list_opt_bpjs as $lob){?>
								<option value='<?php echo trim($lob->kode_bpjs);?>' <?php if (trim($lob->kode_bpjs)==trim($dtl_bpjs['kode_bpjs'])){ echo 'selected';}?>><?php echo trim($lob->nama_bpjs);?></option>
								<?php }?>
							</select>
						</div>
					</div>											
					<div class="form-group">
						<label class="col-sm-4">Nama Bpjs</label>	
						<div class="col-sm-8">    
							<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="<?php echo trim($dtl_bpjs['namakomponen']);?>" id="tipe"  name="namakompbpjs" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Besaran Perusahan</label>	
						<div class="col-sm-8">    
							<div class="input-group">	
								<input type="number" step="0.01" min="0" class="form-control input-sm" value="<?php echo $dtl_bpjs['besaranperusahaan'];?>" id="type1" onkeyup="kalkulatorTambah(this.value,getElementById('type2').value);"  name="perusahaan" required>
								<span class="input-group-addon">%</span>
							</div>
						</div>
					</div>
					<script>
						function kalkulatorTambah(type1,type2){
							var hasil = eval(type1) + eval(type2);										
							document.getElementById('ttlbesaran').value = hasil;										
						}
					</script>
					<div class="form-group">
						<label class="col-sm-4">Besaran Karyawan</label>	
						<div class="col-sm-8"> 
							<div class="input-group">
								<input type="number" step="0.01" min="0" class="form-control input-sm" value="<?php echo $dtl_bpjs['besarankaryawan'];?>" id="type2" onkeyup="kalkulatorTambah(getElementById('type1').value,this.value);"  name="karyawan" required>
								<span class="input-group-addon">%</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">Total Besaran</label>	
						<div class="col-sm-8">   
							<div class="input-group">
								<input type="number" step="0.01" min="0" class="form-control input-sm" value="<?php echo $dtl_bpjs['totalbesaran'];?>" id="ttlbesaran"  name="total" required readonly>
								<span class="input-group-addon">%</span>
							</div>
						</div>
					</div>																																												
				</div>
			</div><!-- /.box-body -->													
		</div><!-- /.box --> 
	</div>					
</div>
<div class="row">
	<div class="col-sm-6">		
		<a href="<?php echo site_url('master/bpjskomponen');?>" class="btn btn-primary" style="margin:10px">Kembali</a>
		<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

