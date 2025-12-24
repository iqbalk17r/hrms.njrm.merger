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
				$("#menu").selectize();
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
<legend><?php echo $title;//.' | '.$dtl_user['username'];?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">		
		<a href="<?php echo site_url("master/user");?>" class="btn btn-default" style="margin:10px">Kembali</a>
		<a href="<?php echo site_url("master/user/input_view_akses/$nik/$username");?>" class="btn btn-primary" style="margin:10px">Input Hak Akses User</a>
	
	</div>
</div>
</br>
<div class="row">
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode</th>
							<th>Menu</th>
							<th>Hold</th>											
							<th>View</th>											
							<th>Input</th>						
							<th>Update</th>						
							<th>Delete</th>						
							<th>Approve</th>													
							<th>Approve2</th>													
							<th>Approve3</th>													
							<th>Convert</th>													
							<th>Print</th>													
							<th>Download</th>
							<th>Filter</th>	>													
							<th>Action</th>						
												
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_akses as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>															
							<td><?php echo $lu->kodemenu;?></td>																								
							<td><?php echo $lu->namamenu;?></td>																																																																											
							<td><?php echo $lu->hold_id;?></td>											
							<td><?php echo $lu->aksesview;?></td>											
							<td><?php echo $lu->aksesinput;?></td>											
							<td><?php echo $lu->aksesupdate;?></td>											
							<td><?php echo $lu->aksesdelete;?></td>											
							<td><?php echo $lu->aksesapprove;?></td>											
							<td><?php echo $lu->aksesapprove2;?></td>											
							<td><?php echo $lu->aksesapprove3;?></td>											
							<td><?php echo $lu->aksesconvert;?></td>											
							<td><?php echo $lu->aksesprint;?></td>											
							<td><?php echo $lu->aksesdownload;?></td>											
							<td><?php echo $lu->aksesfilter;?></td>											
							<td>
								<a href='<?php $nik=trim($lu->nik); $username=trim($lu->username); echo site_url("master/user/edit_akses/$nik/$username/$lu->kodemenu")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
                                    <i class="fa fa-edit"></i> Edit
                                </a>								
								<a href='<?php  echo site_url("master/user/hps_akses/$nik/$lu->kodemenu")?>' onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
                                    <i class="fa fa-trash-o"></i> Hapus
                                </a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->				
	</div>
</div>


<!--Modal untuk Input-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg-5">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><b>INPUT USER</b></h4>
      </div>
	  <form action="<?php echo site_url('master/user/save_akses')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label  class="col-sm-4">MENU</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>
									<input type="hidden" class="form-control input-sm" value="<?php echo $nik;?>" name="nik" required>
									<input type="hidden" class="form-control input-sm" value="<?php echo $username;?>" name="username" required>
									<select id="menu" name="menu" class="col-sm-12" required>
										<?php
											foreach ($list_menu as $lk){
												echo '<option value="'.trim($lk->kodemenu).'">'.$lk->kodemenu.'|'.$lk->namamenu.'</option>';
											}
										?>																																					
									</select>
								</div>
							</div>																				
							<div class="form-group">
								<label class="col-sm-4">HOLD</label>	
								<div class="col-sm-8"> 
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="true" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="hold" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="hold" id="optionsRadios2" value="f" type="radio"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
											<div aria-disabled="true" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="view" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="view" id="optionsRadios2" value="f" type="radio"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
											<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="input" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="input" id="optionsRadios2" value="f" type="radio" ><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
											<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="update" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="update" id="optionsRadios2" value="f" type="radio"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
											<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="delete" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="delete" id="optionsRadios2" value="f" type="radio" ><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
											<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve" id="optionsRadios2" value="f" type="radio" ><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
											<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve2" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve2" id="optionsRadios2" value="f" type="radio" ><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
											<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve3" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="approve3" id="optionsRadios2" value="f" type="radio" ><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
											<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal" ><input style="position: absolute; opacity: 0;" name="convert" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="convert" id="optionsRadios2" value="f" type="radio"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
											<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal" ><input style="position: absolute; opacity: 0;" name="print" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="print" id="optionsRadios2" value="f" type="radio"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
											<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal" ><input style="position: absolute; opacity: 0;" name="download" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="download" id="optionsRadios2" value="f" type="radio"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
											<div aria-disabled="false" aria-checked="true" style="position: relative;" class="iradio_minimal" ><input style="position: absolute; opacity: 0;" name="aksesfilter" id="optionsRadios2" value="t" type="radio" checked><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
											YES
										</label>
									</div>
									<div class="radio col-sm-6">
										<label class="">
											<div aria-disabled="false" aria-checked="false" style="position: relative;" class="iradio_minimal"><input style="position: absolute; opacity: 0;" name="aksesfilter" id="optionsRadios2" value="f" type="radio"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div>
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
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>