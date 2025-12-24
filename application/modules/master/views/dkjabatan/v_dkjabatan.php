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
											<th>Kode Jabatan</th>
											<th>Nama Jabatan</th>	
											<th>Nama Kompetensi</th>
											<th>Keterangan</th>
											<th>Input Date</th>
											<th>Input By</th>	
											<th>Update Date</th>
											<th>Update By</th>
											<th>Aksi</th>
											<th></th>		
										</tr>
									</thead>
                                    <tbody>
									<?php  foreach($list_dkjabatan as $row):;?>
								<tr>
									
									<td><?php echo $row->no_dk;?></td>
									<td><?php echo $row->kdjabatan;?></td>
									<td><?php echo $row->nmjabatan;?></td>
									<td><?php echo $row->nmkom;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td><?php echo $row->input_date;?></td>
									<td><?php echo $row->input_by;?></td>
									<td><?php echo $row->update_date;?></td>
									<td><?php echo $row->update_by;?></td>
									<td><a href="<?php echo site_url('master/kompetensi/hps_dkjabatan').'/'.$row->no_dk;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->no_dk);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a data-toggle="modal" data-target="#<?php echo trim($row->no_dk);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
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
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER DETAIL KOMPETENSI JABATAN</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/kompetensi/add_dkjabatan');?>" method="post">
			<div class="row">
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Kode Jabatan</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="kdjabatan" id="kdgrade">
						  <?php foreach($list_jabatan as $listkan){?>
						  <option value="<?php echo trim($listkan->kdjabatan);?>" ><?php echo trim($listkan->nmjabatan);?></option>						  
						  <?php }?>
					</select>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Kode Kompetensi</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="kdkom" id="kdgrade">
						  <?php foreach($list_kompetensi as $listkan){?>
						  <option value="<?php echo trim($listkan->kdkom);?>" ><?php echo $listkan->nmkom;?></option>						  
						  <?php }?>
					</select>
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
			<div class="row">
			<div class="form-group">
				 <label class="col-sm-12">Keterangan</label>
				<div class="col-sm-12">

						<textarea id="nmdept" name="keterangan"  style="text-transform:uppercase" class="form-control"  ></textarea>
					
					<!-- /.input group -->
				</div>
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
<?php foreach ($list_dkjabatan as $ld){?>

<div class="modal fade" id="<?php echo trim($ld->no_dk);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT MASTER DETAIL KOMPETENSI JABATAN</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/kompetensi/edit_dkjabatan');?>" method="post">
			<div class="row">
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Kode Jabatan</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="kdjabatan" id="kdgrade">
						  <?php foreach($list_jabatan as $listkan){?>
							 <option value="<?php echo $listkan->kdjabatan;?>"<?php if (trim($ld->kdjabatan)==trim($listkan->kdjabatan)) { echo 'selected';}?> class="<?php echo trim($listkan->kdjabatan);?>" ><?php echo $listkan->nmjabatan;?></option>						  
							 <?php }?>
					</select>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Kode Kompetensi</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="kdkom" id="kdgrade">
						  <?php foreach($list_kompetensi as $listkan){?>
						 <option value="<?php echo $listkan->kdkom;?>"<?php if (trim($ld->kdkom)==trim($listkan->kdkom)) { echo 'selected';}?> class="<?php echo trim($listkan->kdkom);?>" ><?php echo $listkan->nmkom;?></option>						  					  
						  <?php }?>
					</select>
				</div>
			</div>
			
			</div>
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">No. Detail Kompetensi</label>
				<div class="col-sm-4">
				
						<input type="text" id="inputby" name="no_dk"  value="<?php echo $ld->no_dk;?>" class="form-control" readonly >

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
			</div><!--row-->
			<div class="row">
			<div class="form-group">
				 <label class="col-sm-12">Keterangan</label>
				<div class="col-sm-12">

				<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo $ld->keterangan;?></textarea>
					
					<!-- /.input group -->
				</div>
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

  

</script>