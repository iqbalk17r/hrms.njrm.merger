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
										    <th>IDBU</th>
											<th>Nama IDBU</th>
											<th>Wilayah</th>
											<th>Nama Wilayah</th>
											<th>Regional</th>
											<th>Nama Regional</th>
											<th>Pulau</th>
											<th>Nama Pulau</th>
											<th></th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_idbu as $row): $no++;?>
											<tr>
												<td><?php echo $no; ?></td>
												<td><?php echo $row->idbu; ?></td>
												<td><?php echo $row->idbuname; ?></td>
												<td><?php echo $row->wilayah; ?></td>
												<td><?php echo $row->wilayahname; ?></td>
												<td><?php echo $row->regional; ?></td>
												<td><?php echo $row->regionalname; ?></td>
												<td><?php echo $row->island; ?></td>
												<td><?php echo $row->islandname; ?></td>

												<td>
													<a href="<?php echo site_url('master/idbu/hps_idbu/'.$row->idbu); ?>"
													   onclick="return confirm('Anda Yakin Hapus <?php echo trim($row->idbu); ?>?')">
														<i class="fa fa-trash-o"></i> Hapus
													</a>
												</td>

												<td>
													<a href="#"
													   data-toggle="modal"
													   data-target="#<?php echo trim($row->idbu); ?>">
														<i class="fa fa-edit"></i> Edit
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
<!-- Modal Input Department -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER DEPARTMENT</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/department/add_department');?>" method="post">
			<div class="form-group">
				 <label class="col-sm-12">Kode Department</label>
				<div class="col-sm-24">
					
						<input type="text" id="kddept" name="kddept"  class="form-control" style="text-transform:uppercase" maxlength="2" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Nama Department</label>
				<div class="col-sm-24">

						<input type="text" id="nmdept" name="nmdept"  style="text-transform:uppercase" maxlength="40" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Tanggal Input</label>
				<div class="col-sm-24">
					
						<input type="text" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Input By</label>
				<div class="col-sm-24">
				
						<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

					<!-- /.input group -->
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group"> 
					<div class="col-lg-4">
						<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
					   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
					</div>
				</div>
			</div>
		</form>
  </div>
</div>
</div>  
</div>
<!--Edit Department -->
<?php foreach ($list_department as $ld){?>

<div class="modal fade" id="<?php echo trim($ld->kddept);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit MASTER DEPARTMENT</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/department/edit_department');?>" method="post">
			<div class="form-group">
				 <label class="col-sm-12">Kode Department</label>
				<div class="col-sm-24">
					
						<input type="text" id="kddept" name="kddept"  value="<?php echo $ld->kddept;?>" class="form-control" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Nama Department</label>
				<div class="col-sm-24">

						<input type="text" id="nmdept" name="nmdept"  value="<?php echo trim($ld->nmdept);?>" maxlength="20" style="text-transform:uppercase" class="form-control">
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Tanggal Update</label>
				<div class="col-sm-24">
					
						<input type="text" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Update By</label>
				<div class="col-sm-24">
				
						<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

					<!-- /.input group -->
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group"> 
					<div class="col-lg-4">
						<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
					   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
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

  

</script>