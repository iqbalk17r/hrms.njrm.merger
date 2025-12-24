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
			//form validation
</script>
<legend><?php echo $title;?>: <?php echo trim($dtl_user['nik']).' | '.$dtl_user['username'];?></legend>
<?php echo $message;?>

</br>
<form action="<?php echo site_url('master/user/save_akses')?>" method="post">
<div class="row">
		<div class="col-sm-6">
			<div class="box box-danger">
				<div class="box-body">
					<div class="form-horizontal">							
						<div class="form-group">
							<label class="col-sm-4">MENU</label>	
							<div class="col-sm-8">
								<input type="hidden" class="form-control input-sm" value="edit" id="tipe" name="tipe" required>								
								<input type="hidden" class="form-control input-sm" value="<?php echo trim($akses['nik']);?>" id="tipe" name="nik" required>								
								<input type="text" class="form-control input-sm" value="<?php echo trim($akses['kodemenu']);?>" name="menu" readonly>																
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">NAMA MENU</label>	
							<div class="col-sm-8">								
								<input type="text" class="form-control input-sm" value="<?php echo trim($akses['namamenu']);?>" name="namamenu" readonly>																
								<input type="hidden" class="form-control input-sm" value="<?php echo trim($akses['username']);?>" name="username" readonly>																
							</div>
						</div>																				
						<div class="form-group">
							<label class="col-sm-4">HOLD MODUL</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="true" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="hold" id="optionsRadios2" value="t" type="radio" <?php if ($akses['hold_id']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="hold" id="optionsRadios2" value="f" type="radio" <?php if ($akses['hold_id']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">AKSES VIEW</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="true" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="view" id="optionsRadios2" value="t" type="radio" <?php if ($akses['aksesview']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="view" id="optionsRadios2" value="f" type="radio" <?php if ($akses['aksesview']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">INPUT</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="input" id="optionsRadios2" value="t" type="radio" <?php if ($akses['aksesinput']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="input" id="optionsRadios2" value="f" type="radio" <?php if ($akses['aksesinput']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>								
						</div>
						<div class="form-group">
							<label class="col-sm-4">UPDATE</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="update" id="optionsRadios2" value="t" type="radio" <?php if ($akses['aksesupdate']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="update" id="optionsRadios2" value="f" type="radio" <?php if ($akses['aksesupdate']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">DELETE</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="delete" id="optionsRadios2" value="t" type="radio" <?php if ($akses['aksesdelete']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="delete" id="optionsRadios2" value="f" type="radio" <?php if ($akses['aksesdelete']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">APROVE</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve" id="optionsRadios2" value="t" type="radio" <?php if ($akses['aksesapprove']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve" id="optionsRadios2" value="f" type="radio" <?php if ($akses['aksesapprove']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>
						</div>						
						
						<div class="form-group">
							<label class="col-sm-4">APROVE2</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve2" id="optionsRadios2" value="t" type="radio" <?php if ($akses['aksesapprove2']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve2" id="optionsRadios2" value="f" type="radio" <?php if ($akses['aksesapprove2']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>
						</div>						
						<div class="form-group">
							<label class="col-sm-4">APROVE3</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve3" id="optionsRadios2" value="t" type="radio" <?php if ($akses['aksesapprove3']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve3" id="optionsRadios2" value="f" type="radio" <?php if ($akses['aksesapprove3']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">CONVERT</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal" ><input style="position: absolute; opacity: 0;" name="convert" id="optionsRadios2" value="t" type="radio" <?php if ($akses['aksesconvert']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="convert" id="optionsRadios2" value="f" type="radio" <?php if ($akses['aksesconvert']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">PRINT</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal" ><input style="position: absolute; opacity: 0;" name="print" id="optionsRadios2" value="t" type="radio" <?php if ($akses['aksesprint']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="print" id="optionsRadios2" value="f" type="radio" <?php if ($akses['aksesdelete']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">DOWNLOAD</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal" ><input style="position: absolute; opacity: 0;" name="download" id="optionsRadios2" value="t" type="radio" <?php if ($akses['aksesdownload']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="download" id="optionsRadios2" value="f" type="radio" <?php if ($akses['aksesdownload']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4">FILTER</label>	
							<div class="col-sm-8"> 
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal" ><input style="position: absolute; opacity: 0;" name="aksesfilter" id="optionsRadios2" value="t" type="radio" <?php if ($akses['aksesfilter']=='t') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										YES
									</label>
								</div>
								<div class="radio col-sm-6">
									<label class="">
										<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="aksesfilter" id="optionsRadios2" value="f" type="radio" <?php if ($akses['aksesfilter']=='f') { echo 'checked';}?>><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
										NO
									</label>
								</div>									
							</div>
						</div>
						
						
					</div>
				</div><!-- /.box-body -->													
			</div><!-- /.box --> 
		</div>					
	</div><!--row-->
<div class="row">
	<div class="col-sm-6">		
		<a href="<?php echo site_url('master/user');?>" class="btn btn-primary" style="margin:10px">Kembali</a>
		<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

