<?php 
/*
	@author : hanif_anak_metal \m/
*/
?>
<script>
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example4").dataTable();
				//datemask
				//$("#datemaskinput").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});                               
				//$("#datemaskinput").daterangepicker();                              
				$("#dateinput").datepicker();                               
            });
			//form validation
			
			
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>

</br>
<form action="<?php echo site_url('master/user/saveprofile')?>" method="post">
<div class="row">
	<div class="col-sm-8">
		<div class="box box-danger">
			<div class="box-body">
				<div class="form-horizontal">							
					<div class="form-group">
						<label class="col-sm-4">NIK | NAMA PEGAWAI</label>	
						<div class="col-sm-8">
							<input type="hidden" class="form-control input-sm" value="edit" id="tipe" name="tipe" required>																	
							<input type="input" class="form-control input-sm" value="<?php echo trim($dtl_user['nik']).' | '.trim($dtl_user['username']);?>" name="user" readonly>						
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4">PASSWORD</label>	
						<div class="col-sm-8">    
							<input type="password" class="form-control input-sm" id="password1" name="passwordweb" pattern=".{6,}"  title="Panjang minimal 6 Karakter, dan terdiri dari angka dan huruf" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">ULANG PASSWORD</label>	
						<div class="col-sm-8">    
							<input type="password" id="password2" class="form-control input-sm" name="passwordweb2" pattern=".{6,}" title="Masukan Ulang Password Sama dengan sebelumnya" required>
						</div>
					</div>	
						<script>
							var password = document.getElementById("password1")
									  , confirm_password = document.getElementById("password2");

									function validatePassword(){
									  if(password.value != confirm_password.value) {
										confirm_password.setCustomValidity("Password Tidak Sama !!!");
									  } else {
										confirm_password.setCustomValidity('');
									  }
									}

									password.onchange = validatePassword;
									confirm_password.onkeyup = validatePassword;
						</script>					
					<!--div class="form-group">
						<label class="col-sm-4">HOLD</label>	
						<div class="col-sm-8">    
							<select name="hold" class="col-sm-12">
								<option value="N">TIDAK</option>;																																													
								<option value="Y">IYA</option>;																																																							
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">EXPIRED DATE</label>	
							<div class="col-sm-8">    
								<input type="text" name="expdate" value="<?php echo $dtl_user['exdate'];?>" id="dateinput"  required data-date-format="dd-mm-yyyy"></input>
							</div>
					</div-->																																			
				</div>
			</div><!-- /.box-body -->													
		</div><!-- /.box --> 
	</div>					
</div>
<div class="row">
	<div class="col-sm-6">		
		<a href="<?php echo site_url('dashboard');?>" class="btn btn-danger" style="margin:10px">Close</a>
		<button type="submit" onclick="return confirm('Anda Yakin Password Akan Dirubah?')" class="btn btn-primary" style="margin:10px">Ubah Password</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

