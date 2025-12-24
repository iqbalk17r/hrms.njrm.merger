<?php 
/*
	@author : Junis pusaba
	@email	: junis_pusaba@mail.ugm.ac.id
	7-9-2014
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
				<?php foreach($userosin as $jvascpt){  
					echo	'$("#'.trim($jvascpt->userid).'").dataTable(); ';
					echo	'$("#tgl'.trim($jvascpt->userid).'").datepicker(); ';
				}?>
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
<legend>USER OSIN </legend>
<?php echo $message;?>

<div class="row">
                        <div class="col-xs-12">                            
                            <div class="box">								
                                <div class="box-header">
                                   <a data-toggle="modal" data-target=".baru" class="btn btn-primary" style="margin:5px"><i class="glyphicon glyphicon-plus"></i> Tambah</a>									
							   </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                                    <table id="example1" class="table table-bordered table-striped" >
                                        <thead>
											<tr>
											<th>NO.</th>
											<th>USER ID</th>											 														
											<th>BRANCH</th>											 														
											<th>Level</th>
											<th>NAMA USER</th>
											<th>NAMA PANJANG</th>																						
											<th>WILAYAH</th>																						
											<th>DIVISI</th>																						
											<th>LOKASI</th>																						
											<th>HOLD</th>																						
											</tr>
										</thead>
                                        <tbody>
                                            <?php $no=0; foreach($userosin as $row){ $no++;?>
											<tr>
												<td><?php echo $no;?></td>
												<td><a href="#" data-toggle="modal" data-target=".<?php echo trim($row->userid);?>"><?php echo $row->userid;?></a></td>
												<td><?php echo $row->branch;?></td>											
												<td><?php echo $row->level_id;?></td>
												<td><?php echo $row->usersname; ?></td>												
												<td><?php echo $row->userlname; ?></td>																																															
												<td><?php echo $row->areaname; ?></td>												
												<td><?php echo $row->divisiname; ?></td>																								
												<td><?php echo $row->locaname; ?></td>	
												<td><?php echo $row->hold_id; ?></td>												
											</tr>
											<?php }?>											
                                        </tbody>
                                    </table>
								<!--Modal untuk edit-->
								<?php $no=0; foreach($userosin as $row){ $no++;?>								
								<div class="modal fade <?php echo trim($row->userid,'');?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								  <div class="modal-dialog modal-lg">
									<div class="modal-content">
										<form class="form-horizontal" action="<?php echo site_url('dashboard/edit_user');?>" method="post">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<h4 class="modal-title" id="myModalLabel">EDIT <?php echo $row->userid;?></h4>
										</div>
										<div class="modal-body">
										<div class="row">
											<div class="col-sm-5">
												<div class="box box-danger">
													<div class="box-body">
														<div class="form-horizontal">															
															<div class="form-group">
																<label class="col-sm-4">ID USER</label>	
																	<div class="col-sm-8">    
																		<input type="text" name="userid" value="<?php echo $row->userid?>" readonly>
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">NAMA USER 1</label>	
																	<div class="col-sm-8">    
																		<input type="text" name="namauser" value="<?php echo $row->usersname?>">
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">NIP PEGAWAI</label>	
																	<div class="col-sm-8">    
																		<select name="nip" class="col-sm-12">
																			<option value="<?php echo $row->nip?>"><?php echo $row->nip?></option>
																			<?php
																				foreach ($list_peg as $lp){
																					echo '<option value="'.$lp->list_nip.'">'.$lp->nmlengkap.'|'.$lp->list_nip.'</option>';
																				}
																			?>																																					
																		</select>
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">NAMA PANJANG</label>	
																	<div class="col-sm-8">    
																		<input type="text" name="userpjg" value="<?php echo $row->userlname?>">
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">PASSWORD</label>	
																	<div class="col-sm-8">  
																		<input type="password" value="<?php echo $row->passwordweb?>" name="passwordweb" >
																		<input type="hidden" value="<?php echo $row->passwordweb?>" name="passwordwebasli" >
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">ULANG PASSWORD</label>	
																	<div class="col-sm-8">    
																		<input type="password" value="<?php echo $row->passwordweb?>" name="passwordweb2">
																	</div>
															</div>	
															<div class="form-group">
																<label class="col-sm-4">EXPIRED DATE</label>	
																	<div class="col-sm-8">    
																		<input type="text" name="end_date" value="<?php echo date('d-m-Y', strtotime($row->timelock));?>" id="<?php echo 'tgl'.trim($row->userid);?>"  required data-date-format="dd-mm-yyyy" data-date="12-02-2012"></input>
																	</div>
															</div>	
															<div class="form-group">																
																	<label class="col-sm-4">LOKASI GUDANG</label>	
															</div>
															<div class="form-group">
																	<div class="col-sm-8">    
																		<select name="gudang">
																			<option value="<?php echo $row->location_id?>"><?php echo $row->locaname?></option>
																			<?php foreach ($gudang as $gdg) {
																				if ($row->location_id<>$gdg->loccode){
																					echo '<option value="'.$gdg->loccode.'">'.$gdg->locaname.'</option>';
																				}
																			}?>																			
																		</select>
																	</div>															
															</div>
															<div class="form-group">
																<label class="col-sm-4">DIVISI BAGIAN</label>	
																	<div class="col-sm-8">    
																		<select name="divisi">
																			<option value="<?php echo $row->divisi?>"><?php echo $row->divisiname?></option>
																			<?php foreach ($divisi as $divusr) {
																				if ($row->divisi<>$divusr->divisi){
																					echo '<option value="'.$divusr->divisi.'">'.$divusr->divisiname.'</option>';
																				}
																			}?>
																		</select>
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-3">KUNCI</label>	
																	<div class="col-sm-3">    
																		<select name="kunci">
																			<option value="no">NO</option>
																			<option value="yes">YES</option>											
																		</select>
																	</div>												
																<label class="col-sm-3">LEVEL</label>	
																	<div class="col-sm-3">    
																		<select name="leveluser">
																			<option value="A">A</option>
																			<option value="B">B</option>
																			<option value="C">C</option>
																			<option value="D">D</option>
																			<option value="E">E</option>
																		</select>
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">WILAYAH</label>	
																	<div class="col-sm-8">    
																		<select name="wilayah">
																			<option value="<?php echo $row->custarea?>"><?php echo $row->areaname?></option>
																			<?php foreach ($wilayah as $wil) {
																				if ($row->custarea<>$wil->area) {
																				echo '<option value="'.$wil->area.'">'.$wil->areaname.'</option>';
																				}
																			}?>																																						
																		</select>
																	</div>
															</div>
														</div>
													</div><!-- /.box-body -->													
												</div><!-- /.box --> 
											</div>
											<div class="col-sm-7">
											
											<div class="row">
												<div class="box">
													<div class="box-body table-responsive">
														<table id="<?php echo trim($row->userid);?>"  class="table table-bordered table-striped" >
															<thead>
																<tr>																	
																	<th>Pilih</th> 
																	<th>Nama Modul</th>
																	<th>Deskripsi</th>
																	<th>Link</th>
																</tr>
															</thead>
															<tbody>
																<?php $no=0; foreach($progmodul as $col){ $no++;?>
																<tr>																	
																	<td><input name="<?php echo trim($col->mdlprg);?>" value="Y" type="checkbox" <?php foreach ($usermodul as $usr) {																		
																		if ($usr->userid==$row->userid and $usr->mdlprg==$col->mdlprg){
																			echo 'checked';
																		} 
																	}//if ($col->userid==$row->userid) { echo 'checked';}?>></td>															
																	<td><?php echo $col->namaprg;?></td>
																	<td><?php echo $col->description;?></td>
																	<td><?php echo $col->LINK;?></td>																	
																</tr>
																<?php }?>
															</tbody>
														</table>
													</div><!-- /.box-body -->
												</div>
											</div>
											</div>
										
										</div><!--row-->
										</div>
										<div class="modal-footer">											
											<button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Simpan Perubahan User: <?php echo $row->userid;?>?')">Simpan</button>	
											<a class="btn btn-primary" href="<?php echo site_url('dashboard/hapus_user/'.$row->userid);?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus User: <?php echo $row->userid;?>?')"><i class="glyphicon glyphicon-trash"></i>Hapus</a>											
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
										</form>
									</div>
								  </div>
								</div>
								<?php }?>
								
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
</div>

	<!--input baru-->
	<div class="modal fade baru" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								  <div class="modal-dialog modal-lg">
									<div class="modal-content">
										<form class="form-horizontal"  action="<?php echo site_url('dashboard/add_user');?>" method="post">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
											<h4 class="modal-title" id="myModalLabel">INPUT USER BARU</h4>
										</div>
										<div class="modal-body">										
										<div class="row">
											<div class="col-sm-5">
												<div class="box box-danger">
													<div class="box-body">
														<div class="form-horizontal">
															<div class="form-group">
																<label class="col-sm-4">ID USER</label>	
																	<div class="col-sm-8">    
																		<input type="text" name="userid" style="text-transform:uppercase" required>
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">NAMA USER 1</label>	
																	<div class="col-sm-8">    
																		<input type="text" name="namauser" style="text-transform:uppercase" required >
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">NIP PEGAWAI</label>	
																	<div class="col-sm-8">    
																		<select name="nip" class="col-sm-12">
																			<?php
																				foreach ($list_peg as $lp){
																					echo '<option value="'.$lp->list_nip.'">'.$lp->nmlengkap.'|'.$lp->list_nip.'</option>';
																				}
																			?>																																					
																		</select>
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">NAMA PANJANG</label>	
																	<div class="col-sm-8">    
																		<input type="text" name="userpjg" style="text-transform:uppercase" required>
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">PASSWORD</label>	
																	<div class="col-sm-8">    
																		<input type="password" id="password1" name="passwordweb" pattern=".{6,}" required title="Panjang minimal 6 Karakter, dan terdiri dari angka dan huruf">
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">ULANG PASSWORD</label>	
																	<div class="col-sm-8">    
																		<input type="password" id="password2" name="passwordweb2" pattern=".{6,}" required title="Masukan Ulang Password Sama dengan sebelumnya"></input>
																	</div>
															</div>	
															<div class="form-group">
																<label class="col-sm-4">EXPIRED DATE</label>	
																	<div class="col-sm-8">    
																		<input type="date" name="end_date" id="dateinput" required data-date-format="dd-mm-yyyy"></input>
																	</div>
															</div>	
															<div class="form-group">																
																	<label class="col-sm-4">LOKASI GUDANG</label>	
															</div>
															<div class="form-group">
																	<div class="col-sm-8">    
																		<select name="gudang">
																			<?php foreach ($gudang as $gdg) {
																				echo '<option value="'.$gdg->loccode.'">'.$gdg->locaname.'</option>';
																			}?>																			
																		</select>
																	</div>															
															</div>
															<div class="form-group">
																<label class="col-sm-4">DIVISI BAGIAN</label>	
																	<div class="col-sm-8">    
																		<select name="divisi">
																			<?php foreach ($divisi as $divusr) {
																				echo '<option value="'.$divusr->divisi.'">'.$divusr->divisiname.'</option>';
																			}?>
																		</select>
																	</div>
															</div>														
															<div class="form-group">
																<label class="col-sm-3">KUNCI</label>	
																	<div class="col-sm-3">    
																		<select name="kunci">
																			<option value="no">NO</option>
																			<option value="yes">YES</option>											
																		</select>
																	</div>												
																<label class="col-sm-3">LEVEL</label>	
																	<div class="col-sm-3">    
																		<select name="leveluser">
																			<option value="A">A</option>
																			<option value="B">B</option>
																			<option value="C">C</option>
																			<option value="D">D</option>
																			<option value="E">E</option>
																		</select>
																	</div>
															</div>
															<div class="form-group">
																<label class="col-sm-4">WILAYAH</label>	
																	<div class="col-sm-8">    
																		<select name="wilayah">
																			<?php foreach ($wilayah as $wil) {
																				echo '<option value="'.$wil->area.'">'.$wil->areaname.'</option>';
																			}?>	
																		</select>
																	</div>
															</div>
															
														</div>
													</div><!-- /.box-body -->													
												</div><!-- /.box --> 
											</div>
											<div class="col-sm-7">
											
											<div class="row">
												<div class="box">
													<div class="box-body table-responsive">
														<table id="example4"  class="table table-bordered table-striped" >
															<thead>
																<tr>																																	
																	<th>Pilih</th>
																	<th>Nama Modul</th>
																	<th>Deskripsi</th>
																	<th>Link</th>
																</tr>
															</thead>
															<tbody>
																<?php $no=0; foreach($progmodul as $col){ $no++;?>
																<tr>																	
																	<td><input name="<?php echo trim($col->mdlprg);?>" value="Y" type="checkbox"></td>															
																	<td><?php echo $col->namaprg;?></td>
																	<td><?php echo $col->description;?></td>
																	<td><?php echo $col->LINK;?></td>																	
																</tr>
																<?php }?>
															</tbody>
														</table>
													</div><!-- /.box-body -->
												</div>
											</div>
											</div>
										
										</div><!--row-->
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Akan Di Simpan?')">Simpan</button>											
										</div>
										</form>
									</div>
								  </div>
								</div>