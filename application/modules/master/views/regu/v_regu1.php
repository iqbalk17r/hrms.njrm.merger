<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
			
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
<?php echo $message; ?>
				<div class="row">
                    <div class="col-xs-12">
						<div class="box">
							<div class="box-header">
					   <button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> INPUT</a>
					</div><!-- /.box-header -->	
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped" >
                                    <thead>
										<tr>											
											
											<th>No.</th>
											<th>Kode Regu</th>
											<th>Nama Regu</th>
											<th>Mesin</th>
											<th>Input Date</th>
											<th>Input By</th>	
											<th>Update Date</th>
											<th>Update By</th>
											<th>Aksi</th>
											<th></th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_regu as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->kdregu;?></td>
									<td><?php echo $row->nmregu;?></td>
									<td><?php echo $row->nmmesin;?></td>
									<td><?php echo $row->input_date;?></td>
									<td><?php echo $row->input_by;?></td>
									<td><?php echo $row->update_date;?></td>
									<td><?php echo $row->update_by;?></td>
									<td><a href="<?php echo site_url('master/regu/hps_regu').'/'.$row->kdregu;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->kdregu);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a data-toggle="modal" data-target="#<?php echo trim($row->kdregu);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input regu -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER REGU</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/regu/add_regu');?>" method="post">
			<div class="row">

			<div class="form-group">
				 <label class="col-sm-12">Kode Regu</label>
				<div class="col-sm-12">
					
						<input type="text" id="kddept" name="kdregu"  class="form-control" style="text-transform:uppercase" maxlength="3" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Nama Regu</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" name="nmregu"  maxlength="40" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Mesin</label>
				<div class="col-sm-12">

					<select class="form-control input-sm" name="keterangan" id="kdgrade">
							  <?php foreach($list_mesin as $listkan){?>
							  <option value="<?php echo trim($listkan->kdmesin);?>" ><?php echo $listkan->nmmesin;?></option>						  
							  <?php }?>
					</select>
					
					<!-- /.input group -->
				</div>
			</div>
			 <div class="form-group" style="width: 100%; margin-bottom: 10px;">
				 <label class="col-sm-12">Warna</label>
				<!--<button type="button" id="color-chooser-btn" class="btn btn-danger btn-block btn-sm dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>
				<!--<ul class="dropdown-menu" id="color-chooser">-->
				<!--<div class="col-sm-12">-->
				<!--<button type="button" id="color-chooser-btn" class="btn btn-danger btn-block btn-sm dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>
					<ul class="dropdown-menu" id="color-chooser">
						<li><a class="text-green" value="#00A65A"><i class="fa fa-square"></i> Green</a></li>
						<li><a class="text-blue" value="#0000FF"><i class="fa fa-square"></i> Blue</a></li>                                            
						<li><a class="text-navy" value="#001F3F"><i class="fa fa-square"></i> Navy</a></li>                                            
						<li><a class="text-yellow" value="#FFFF00"><i class="fa fa-square"></i> Yellow</a></li>
						<li><a class="text-orange" value="#FF851B"><i class="fa fa-square"></i> Orange</a></li>
						<li><a class="text-aqua" value="#00C0EF"><i class="fa fa-square"></i> Aqua</a></li>
						<li><a class="text-red" value="	#F56954"><i class="fa fa-square"></i> Red</a></li>
						<li><a class="text-fuchsia" value="#F012BE "><i class="fa fa-square"></i> Fuchsia</a></li>
						<li><a class="text-purple" value="#932AB6"><i class="fa fa-square"></i> Purple</a></li>
					</ul>-->
				<div class="col-sm-12">
				<select type="text" class="form-control" name="warna" id="warna">
					<option  class="text-green" value="#00A65A"><i class="fa fa-square"></i> Green</option>
					<option  class="text-blue" value="#0073B7"><i class="fa fa-square"></i> Blue   </option>
					<option  class="text-navy" value="#001F3F"><i class="fa fa-square"></i> Navy   </option>
					<option  class="text-yellow" value="#F39C12"><i class="fa fa-square"></i> Yellow   </option>
					<option  class="text-orange" value="#FF851B"><i class="fa fa-square"></i> Orange   </option>
					<option  class="text-aqua" value="#00C0EF"><i class="fa fa-square"></i> Aqua   </option>
					<option  class="text-red" value="#F56954"><i class="fa fa-square"></i> Red   </option>
					<option  class="text-fuchsia" value="#F012BE "><i class="fa fa-square"></i> Fuchsia   </option>
					<option  class="text-purple" value="#932AB6"><i class="fa fa-square"></i> Purple   </option>
				
				</select>
				</div>
			</div><!-- /btn-group -->
			
			<div class="form-group">
				 <label class="col-sm-12">Tanggal Input</label>
				<div class="col-sm-12">
					
						<input type="text" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Input By</label>
				<div class="col-sm-12">
				
						<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<div class="form-group"> 
					<div class="col-lg-12">
						<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
					   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
					</div>
				</div>
			</div>
			</div>
		</form>
  </div>
</div>
</div>  
</div>
<!--Edit Department -->
<?php foreach ($list_regu as $lk){?>

<div class="modal fade" id="<?php echo trim($lk->kdregu);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit MASTER REGU</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/regu/edit_regu');?>" method="post">
			<div class="row">
			
			<div class="form-group">
				 <label class="col-sm-12">Kode Regu</label>
				<div class="col-sm-12">
					
						<input type="text" id="kddept" name="kdregu"  class="form-control" value="<?php echo $lk->kdregu;?>" style="text-transform:uppercase" maxlength="3" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Nama Regu</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" name="nmregu"  maxlength="40" value="<?php echo $lk->nmregu;?>" style="text-transform:uppercase" class="form-control">
					
					<!-- /.input group -->
				</div>
			</div>
			
			<div class="form-group">
				 <label class="col-sm-12">Mesin</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="keterangan" id="kdgrade">
							  <?php foreach($list_mesin as $listkan){?>
							  <option <?php if(trim($lk->kdmesin)==trim($listkan->kdmesin)){ echo 'selected';} ?> value="<?php echo trim($listkan->kdmesin);?>" ><?php echo $listkan->nmmesin;?></option>						  
							  <?php }?>
					</select>
					<!-- /.input group -->
				</div>
			</div>
			 <div class="form-group" style="width: 100%; margin-bottom: 10px;">
				 <label class="col-sm-12">Warna</label>
				<!--<button type="button" id="color-chooser-btn" class="btn btn-danger btn-block btn-sm dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>
				<!--<ul class="dropdown-menu" id="color-chooser">-->
				<!--<div class="col-sm-12">-->
				<!--<button type="button" id="color-chooser-btn" class="btn btn-danger btn-block btn-sm dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>
					<ul class="dropdown-menu" id="color-chooser">
						<li><a class="text-green" value="#00A65A"><i class="fa fa-square"></i> Green</a></li>
						<li><a class="text-blue" value="#0000FF"><i class="fa fa-square"></i> Blue</a></li>                                            
						<li><a class="text-navy" value="#001F3F"><i class="fa fa-square"></i> Navy</a></li>                                            
						<li><a class="text-yellow" value="#FFFF00"><i class="fa fa-square"></i> Yellow</a></li>
						<li><a class="text-orange" value="#FF851B"><i class="fa fa-square"></i> Orange</a></li>
						<li><a class="text-aqua" value="#00C0EF"><i class="fa fa-square"></i> Aqua</a></li>
						<li><a class="text-red" value="	#F56954"><i class="fa fa-square"></i> Red</a></li>
						<li><a class="text-fuchsia" value="#F012BE "><i class="fa fa-square"></i> Fuchsia</a></li>
						<li><a class="text-purple" value="#932AB6"><i class="fa fa-square"></i> Purple</a></li>
					</ul>-->
				<div class="col-sm-12">
				<select type="text" class="form-control" name="warna" id="warna">
					<option <?php if (trim($lk->warna)=='#00A65A') { echo 'selected';}?> class="text-green" value="#00A65A"><i class="fa fa-square"></i> Green</option>
					<option  <?php if (trim($lk->warna)=='#0000FF') { echo 'selected';}?> class="text-blue" value="#0000FF"><i class="fa fa-square"></i> Blue   </option>
					<option  <?php if (trim($lk->warna)=='#001F3F') { echo 'selected';}?>  class="text-navy" value="#001F3F"><i class="fa fa-square"></i> Navy   </option>
					<option  <?php if (trim($lk->warna)=='#F39C12') { echo 'selected';}?>  class="text-yellow" value="#F39C12"><i class="fa fa-square"></i> Yellow   </option>
					<option  <?php if (trim($lk->warna)=='#FF851B') { echo 'selected';}?>  class="text-orange" value="#FF851B"><i class="fa fa-square"></i> Orange   </option>
					<option  <?php if (trim($lk->warna)=='#00C0EF') { echo 'selected';}?>  class="text-aqua" value="#00C0EF"><i class="fa fa-square"></i> Aqua   </option>
					<option  <?php if (trim($lk->warna)=='#F56954') { echo 'selected';}?>  class="text-red" value="#F56954"><i class="fa fa-square"></i> Red   </option>
					<option <?php if (trim($lk->warna)=='#F012BE ') { echo 'selected';}?>  class="text-fuchsia" value="#F012BE "><i class="fa fa-square"></i> Fuchsia   </option>
					<option <?php if (trim($lk->warna)=='#932AB6') { echo 'selected';}?>  class="text-purple" value="#932AB6"><i class="fa fa-square"></i> Purple   </option>
				
				</select>
				</div>
			</div><!-- /btn-group -->
			<div class="form-group">
				 <label class="col-sm-12">Tanggal Update</label>
				<div class="col-sm-12">
					
						<input type="text" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Update By</label>
				<div class="col-sm-12">
				
						<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<div class="form-group"> 
					<div class="col-lg-12">
						<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
					   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
					</div>
				</div>
			</div>
		</div>
		</form>
  </div>
</div>
</div> 
</div> 						
<?php }?>
<script>

  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgl').datepicker();
	$('#nikatasan').selectize();
  

</script>