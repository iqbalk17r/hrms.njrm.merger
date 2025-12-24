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
											<th>Nama Department</th>
											<th>Nama Sub Department</th>
											<th>Nama Level Grade</th>
											<th>Kode Jabatan</th>
											<th>Nama Jabatan</th>
											<th>Cost Center</th>
											<th>Uraian Jabatan</th>
											<th>Shift</th>
											<th>Lembur</th>
											<th>Input Date</th>
											<th>Input By</th>	
											<th>Update Date</th>
											<th>Update By</th>
											<th>Aksi</th>
											<th></th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_jabatan as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->nmdept;?></td>
									<td><?php echo $row->nmsubdept;?></td>
									<td><?php echo $row->nmgrade;?></td>
									<td><?php echo $row->kdjabatan;?></td>
									<td><?php echo $row->nmjabatan;?></td>
									<td><?php echo $row->costcenter;?></td>
									<td><?php echo $row->uraian;?></td>
									<td><?php echo $row->shift1;?></td>
									<td><?php echo $row->lembur1;?></td>
									<td><?php echo $row->input_date;?></td>
									<td><?php echo $row->input_by;?></td>
									<td><?php echo $row->update_date;?></td>
									<td><?php echo $row->update_by;?></td>
									<td><a href="<?php echo site_url('master/jabatan/hps_jabatan').'/'.$row->kdjabatan;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->kdjabatan);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a data-toggle="modal" data-target="#<?php echo trim($row->kdjabatan);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input SubDepartment -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER JABATAN</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/jabatan/add_jabatan');?>" method="post">
		<div class="row">
		<div class="col-sm-6">
				<script type="text/javascript" charset="utf-8">
				  $(function() {	
					$("#csubdept").chained("#cdept");		
					$("#cgrade").chained("#csubdept");
									
				  });
				</script>		
				<div class="form-group">
					<label  class="col-sm-12">Department</label>
					<div class="col-sm-12">
						<select class="form-control input-sm" name="kddept" id="cdept" required>
						  <?php foreach($list_department as $listkan){?>
						  <option value="<?php echo trim($listkan->kddept);?>" ><?php echo $listkan->nmdept;?></option>						  
						  <?php }?>
						</select>
					</div>
					
				</div>	
				<div class="form-group">
					<label  class="col-sm-12">Sub Department</label>
					<div class="col-sm-12">
						<select class="form-control input-sm" name="kdsubdept" id="csubdept" required>
						  <?php foreach($list_subdepartment as $listkan){?>
						  <option value="<?php echo trim($listkan->kddept).'|'.trim($listkan->kdsubdept);?>" class="<?php echo trim($listkan->kddept);?>" ><?php echo $listkan->nmsubdept;?></option>						  
						  <?php }?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label  class="col-sm-12">Level Grade</label>
					<div class="col-sm-12">
						<select class="form-control input-sm" name="kdgrade" id="kdgrade" required>
						  <?php foreach($list_jobgrade as $listkan){?>
						  <option value="<?php echo trim($listkan->kdgrade);?>" class="<?php echo trim($listkan->kdgrade);?>" ><?php echo $listkan->nmgrade;?></option>						  
						  <?php }?>
						</select>
					</div>
				</div>
				<div class="form-group">
						 <label class="col-sm-12">Cost Center</label>
						<div class="col-sm-12">

								<input type="text" id="nmjbt" name="costcenter"  class="form-control" maxlength="6" style="text-transform:uppercase" >
							
							<!-- /.input group -->
						</div>
				</div>
				</div>
			<div class="col-sm-6">
				<div class="form-group">
				 <label class="col-sm-12">Kode Jabatan</label>
				<div class="col-sm-12">
					
						<input type="text" id="kdjb" name="kdjb"  class="form-control" maxlength="6" style="text-transform:uppercase" required>
					
					<!-- /.input group -->
				</div>
				</div>				
				<div class="form-group">
						 <label class="col-sm-12">Nama Jabatan</label>
						<div class="col-sm-12">

								<input type="text" id="nmjbt" name="nmjbt"  class="form-control" style="text-transform:uppercase" required>
							
							<!-- /.input group -->
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12">Shift
				

						<input type="checkbox" id="nmjbt" name="shift"  class="form-control" value="t">
					
					<!-- /.input group -->
					</label>
				</div>
				<div class="form-group">
					<label class="col-sm-12">Lembur
				

						<input type="checkbox" id="nmjbt" name="lembur"  class="form-control" value="t">
					
					<!-- /.input group -->
					</label>
			</div>
			</div>
			</div><!-- row -->
			<div class="row">
			<div class="form-group">
				 <label class="col-sm-12">Uraian Jabatan</label>
				<div class="col-sm-12">

						<textarea id="nmjbt" name="uraian"  class="form-control" style="text-transform:uppercase"></textarea>
					
					<!-- /.input group -->
				</div>
			</div>
			
			
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
<?php foreach ($list_jabatan as $lj){?>

<div class="modal fade" id="<?php echo trim($lj->kdjabatan);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit MASTER JABATAN</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/jabatan/edit_jabatan');?>" method="post">
		<div class="row">
		<div class="col-sm-6">
			
			<div class="form-group">
					<label  class="col-sm-12">Department</label>
					<div class="col-sm-12">
						<select class="form-control input-sm" name="kddept" id="cdept" required>
						  <?php foreach($list_department as $listkan){?>
						  <option value="<?php echo $listkan->kddept;?>"<?php if (trim($lj->kddept)==trim($listkan->kddept)) { echo 'selected';}?> class="<?php echo trim($listkan->kddept);?>" ><?php echo $listkan->nmdept;?></option>						  
						  <?php }?>
						</select>
					</div>
					
				</div>
				<div class="form-group">
					<label  class="col-sm-12">SubDepartment</label>
					<div class="col-sm-12">
						<select class="form-control input-sm" name="kdsubdept" id="csubdept" required>
						  <?php foreach($list_subdepartment as $listkan){?>
						  <option value="<?php echo trim($listkan->kddept).'|'.trim($listkan->kdsubdept);?>"<?php if (trim($lj->kdsubdept)==trim($listkan->kdsubdept)) { echo 'selected';}?> ><?php echo $listkan->nmsubdept;?></option>						  
						  <?php }?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label  class="col-sm-12">Level Grade</label>
					<div class="col-sm-12">
						<select class="form-control input-sm" name="kdgrade" id="kdgrade" required>
						  <?php foreach($list_jobgrade as $listkan){?>
						  <option value="<?php echo trim($listkan->kdgrade);?>"<?php if (trim($lj->kdgrade)==trim($listkan->kdgrade)) {echo 'selected';}?> class="<?php echo trim($listkan->kdgrade);?>" ><?php echo $listkan->nmgrade;?></option>						  
						  <?php }?>
						</select>
					</div>
				</div>
				<div class="form-group">
						 <label class="col-sm-12">Cost Center</label>
						<div class="col-sm-12">

								<input type="text" id="nmjbt" name="costcenter"  value="<?php echo trim($lj->costcenter);?>" class="form-control" maxlength="6" style="text-transform:uppercase" >
							
							<!-- /.input group -->
						</div>
				</div>
			
			</div>
			<div class="col-sm-6">	
			<div class="form-group">
				 <label class="col-sm-12">Kode  Jabatan</label>
				<div class="col-sm-12">
					
						<input type="text" id="kdlvl" name="kdjb"  value="<?php echo $lj->kdjabatan;?>" class="form-control" readonly>
					
					<!-- /.input group -->
				</div>
			</div>	
			<div class="form-group">
				 <label class="col-sm-12">Nama Jabatan</label>
				<div class="col-sm-12">

						<input type="text" id="nmjbt" name="nmjbt"  value="<?php echo $lj->nmjabatan;?>" class="form-control" style="text-transform:uppercase">
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Shift
				

						<input type="checkbox" id="nmjbt" name="shift"  class="form-control" value="t"
						<?php if ($lj->shift=='T') { echo 'checked';}?>/>
					<!-- /.input group -->
				</label>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Lembur
				

						<input type="checkbox" id="nmjbt" name="lembur"  class="form-control" value="t"
						<?php if ($lj->lembur=='T') { echo 'checked';}?>/>
					<!-- /.input group -->
				</label>
			</div>
			</div>
			</div><!-- row -->
			<div class="row">
			<div class="form-group">
				 <label class="col-sm-12">Uraian Jabatan</label>
				<div class="col-sm-12">

						<textarea id="nmjbt" name="uraian"   class="form-control" style="text-transform:uppercase"><?php echo $lj->uraian;?></textarea>
					
					<!-- /.input group -->
				</div>
			</div>

			
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

  

	
	//Date range picker
    $('#tgl').datepicker();

  

</script>
