<?php
//var_dump($dtl_user);die();
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
			//form validation
			
			window.onload = function () {
				document.getElementById("password1").onchange = validatePassword;
				document.getElementById("password2").onchange = validatePassword;
			}
			function validatePassword(){
			var pass2=document.getElementById("password2").value;
			var pass1=document.getElementById("password1").value;
			if(pass1!=pass2)
				document.getElementById("password2").setCustomValidity("Passwords Tidak Sama");
			else
				document.getElementById("password2").setCustomValidity(''); 			
			//empty string means no validation error
			}
			
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>

</br>
<form action="<?php echo site_url('master/user/save')?>" method="post">
<div class="row">
	<div class="col-sm-6">
		<div class="box box-danger">
			<div class="box-body">
				<div class="form-horizontal">							
					<div class="form-group">
						<label class="col-sm-4">NIK | NAMA PEGAWAI</label>	
						<div class="col-sm-8">
							<input type="hidden" class="form-control input-sm" value="edit" id="tipe" name="tipe" required>																	
							<input type="text" class="form-control input-sm" value="<?php echo trim($dtl_user['nik']);?>" name="nik" readonly>						
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-4">USERNAME</label>	
						<div class="col-sm-8">
						<input type="text" class="form-control input-sm" value="<?php echo $dtl_user['username'];?>" name="username" readonly>						
						</div>
					</div>					
					<div class="form-group">
						<label class="col-sm-4">PASSWORD</label>	
						<div class="col-sm-8">    
							<input type="password" class="form-control input-sm" id="password1" name="passwordweb" pattern=".{6,}"  title="Panjang minimal 6 Karakter, dan terdiri dari angka dan huruf" placeholder="Kosongkan Jika Tidak Ingin Merubah Password">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">ULANG PASSWORD</label>	
						<div class="col-sm-8">    
							<input type="password" class="form-control input-sm" id="password2" name="passwordweb2" pattern=".{6,}" title="Masukan Ulang Password Sama dengan sebelumnya" placeholder="Kosongkan Jika Tidak Ingin Merubah Password"></input>
						</div>
					</div>		
					<div class="form-group">
						<label class="col-sm-4">LEVEL ID</label>	
						<div class="col-sm-8">    
									<select class="form-control input-sm" name="lvlid" id="lvlid">
									  <?php foreach($list_lvljbt as $listkan){?>
									  <option <?php if (trim($listkan->kdlvl)==trim($dtl_user['level_id'])) { echo 'selected';}?> value="<?php echo trim($listkan->kdlvl);?>" ><?php echo $listkan->kdlvl.' || '.$listkan->nmlvljabatan;?></option>						  
									  <?php }?>
									</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">LEVEL AKSES</label>	
						<div class="col-sm-8">    
									<select class="form-control input-sm" name="lvlakses" id="lvlakses">
									  <?php foreach($list_lvljbt as $listkan){?>
									  <option <?php if (trim($listkan->kdlvl)==trim($dtl_user['level_akses'])) { echo 'selected';}?> value="<?php echo trim($listkan->kdlvl);?>" ><?php echo $listkan->kdlvl.' || '.$listkan->nmlvljabatan;?></option>						  
									  <?php }?>
									</select>
						</div>
					</div>					
					<div class="form-group">
						<label class="col-sm-4">HOLD</label>	
						<div class="col-sm-8">    
							<select class="form-control input-sm" name="hold" class="col-sm-12">
								<option value="N" <?php echo (TRIM($dtl_user['hold_id']) == 'N' ? 'selected' : '') ?> >TIDAK</option>;
								<option value="Y" <?php echo (TRIM($dtl_user['hold_id']) == 'Y' ? 'selected' : '') ?> >YA</option>;
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">EXPIRED DATE</label>	
							<div class="col-sm-8">    
								<input type="text" class="form-control input-sm" name="expdate" value="<?php echo $dtl_user['exdate'];?>" id="dateinput"  required data-date-format="dd-mm-yyyy"></input>
							</div>
					</div>
                    <div class="form-group">
                        <label class="col-sm-4">INITIAL</label>
                        <div class="col-sm-8">
                            <input type="input" class="form-control input-sm-4" id="initial" name="initial" value="<?php echo $dtl_user['initial'];?>" style="text-transform: uppercase" maxlength="3">
                        </div>
                    </div>
				</div>
			</div><!-- /.box-body -->													
		</div><!-- /.box --> 
	</div>					
</div>
<div class="row">
	<div class="col-sm-6">		
		<a href="<?php echo site_url('master/user');?>" class="btn btn-primary" style="margin:10px">Kembali</a>
		<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

