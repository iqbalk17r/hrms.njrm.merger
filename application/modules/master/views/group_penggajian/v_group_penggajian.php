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
											<th>Kode Group</th>
											<th>Nama Group</th>	
											<th>Input Date</th>
											<th>Input By</th>	
											<th>Update Date</th>
											<th>Update By</th>
											<th>Aksi</th>
											<th></th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_group_penggajian as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->kdgroup_pg;?></td>
									<td><?php echo $row->nmgroup_pg;?></td>
									<td><?php echo $row->input_date;?></td>
									<td><?php echo $row->input_by;?></td>
									<td><?php echo $row->update_date;?></td>
									<td><?php echo $row->update_by;?></td>
									<td><a href="<?php echo site_url('master/group_penggajian/hps_group_pg').'/'.$row->kdgroup_pg;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->kdgroup_pg);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a data-toggle="modal" data-target="#<?php echo trim($row->kdgroup_pg);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input Kompetensi -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT MASTER GROUP PENGGAJIAN</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/group_penggajian/add_group_pg');?>" method="post">
			<div class="row">
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Kode Group</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" name="kdgroup_pg"  style="text-transform:uppercase" maxlength="2" class="form-control" required>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Nama Group</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" name="nmgroup_pg"  style="text-transform:uppercase" maxlength="20" class="form-control" required>
				</div>
			</div>
			
			</div>
			<div class="col-sm-6">
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
			</div><!--row-->
			
			
		</div><!--modal body -->
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
<?php foreach ($list_group_penggajian as $pg){?>

<div class="modal fade" id="<?php echo trim($pg->kdgroup_pg);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER GROUP PENGGAJIAN</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/group_penggajian/edit_group_pg');?>" method="post">
			<div class="row">
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Kode Group</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" name="kdgroup_pg"  style="text-transform:uppercase" maxlength="2" value="<?php echo $pg->kdgroup_pg; ?>" class="form-control" readonly>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Nama Group</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" name="nmgroup_pg"  style="text-transform:uppercase"  maxlength="20" value="<?php echo trim($pg->nmgroup_pg); ?>" class="form-control">
				</div>
			</div>
			
			</div>
			<div class="col-sm-6">
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
			</div><!--row-->
			
			
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
 

<?php }?>
<script>

  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgl').datepicker();

  

</script>