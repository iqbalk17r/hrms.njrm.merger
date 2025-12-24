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
                            <div class="box-body table-responsive">
                                <table id="example1" class="table table-bordered table-striped" >
                                    <thead>
										<tr>

											<th>No.</th>
											<th>Kode option</th>
											<th>Nama option</th>
											<th>Value 1</th>
											<th>Value 2</th>
											<th>Value 3</th>
											<th>Group Option</th>
											<th>Status</th>
											<th>Keterangan</th>
											<th>Aksi</th>
											<th></th>
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_option as $row): $no++;?>
								<tr>

									<td><?php echo $no;?></td>
									<td><?php echo $row->kdoption;?></td>
									<td><?php echo $row->nmoption;?></td>
									<td><?php echo $row->value1;?></td>
									<td><?php echo $row->value2;?></td>
									<td><?php echo $row->value3;?></td>
									<td><?php echo $row->group_option;?></td>
									<td><?php echo $row->status1;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td><a href="<?php echo site_url('master/option/hps_option').'/'.trim($row->kdoption).'/'.trim($row->group_option);?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->kdoption);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a data-toggle="modal" data-target="#<?php echo str_replace(' ', '', trim($row->kdoption_reformat).trim($row->group_option));?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input option -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER option</h4>
	  </div>

		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/option/add_option');?>" method="post">
			<div class="row">
			<div class="col-sm-6">

			<div class="form-group">
				 <label class="col-sm-12">Kode option</label>
				<div class="col-sm-12">

						<input type="text" id="kddept" name="kdoption"  class="form-control" style="text-transform:uppercase" maxlength="6" required>

					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Nama option</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept"  name="nmoption"  maxlength="30" style="text-transform:uppercase" class="form-control" required>

					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Value 1</label>
				<div class="col-sm-12">

						<input type="text" placeholder="character" id="nmdept" name="value1" style="text-transform:uppercase" class="form-control" >

					<!-- /.input group -->
				</div>
			</div>

			<div class="form-group">
				 <label class="col-sm-12">Value 2</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" placeholder="00:00" name="value2" data-inputmask='"mask": "99:99"' data-mask=""   style="text-transform:uppercase" class="form-control" >

					<!-- /.input group -->
				</div>
			</div>

			<div class="form-group">
				 <label class="col-sm-12">Value 3</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" placeholder="0" name="value3" data-inputmask='"mask": "9999999999999"' data-mask=""   style="text-transform:uppercase" class="form-control" >
						<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
						<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Keterangan</label>
				<div class="col-sm-12">

						<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>

					<!-- /.input group -->
				</div>
			</div>

			<div class="form-group">
				 <label class="col-sm-12">Group Option</label>
				<div class="col-sm-12">
                    <input type="text" id="group_option"  name="group_option" style="text-transform:uppercase" class="form-control" >
						<!--<select class="form-control input-sm" name="group_option" id="kotakab">
										<option value="CUTI" >CUTI</option>
										<option value="JAMKERJA" >JAM KERJA</option>
										<option value="LEMBUR" >LEMBUR</option>
										<option value="IJIN" >IJIN</option>
										<option value="DINAS" >DINAS</option>
						</select>-->
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12">Status</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="status" id="kotakab">
						<option value="T" >AKTIF</option>
						<option value="F" >TIDAK AKTIF</option>
					</select>
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
<?php foreach ($list_option as $lk){?>

<div class="modal fade" id="<?php echo str_replace(' ', '', trim($lk->kdoption_reformat).trim($lk->group_option));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit MASTER option</h4>
	  </div>

		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/option/edit_option');?>" method="post">
			<div class="row">
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Kode option</label>
				<div class="col-sm-12">

						<input type="text" id="kddept" value="<?php echo trim($lk->kdoption);?>" name="kdoption"  class="form-control" style="text-transform:uppercase" maxlength="6" readonly>

					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Nama option</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept"  value="<?php echo trim($lk->nmoption);?>" name="nmoption"  maxlength="30" style="text-transform:uppercase" class="form-control" required>

					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Value 1</label>
				<div class="col-sm-12">

						<input type="text" placeholder="character" value="<?php echo trim($lk->value1);?>" id="nmdept" name="value1" style="text-transform:uppercase" class="form-control" >

					<!-- /.input group -->
				</div>
			</div>

			<div class="form-group">
				 <label class="col-sm-12">Value 2</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" placeholder="00:00" name="value2" value="<?php echo trim($lk->value2);?>" data-inputmask='"mask": "99:99"' data-mask=""   style="text-transform:uppercase" class="form-control" >

					<!-- /.input group -->
				</div>
			</div>

			<div class="form-group">
				 <label class="col-sm-12">Value 3</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" placeholder="0" value="<?php echo trim($lk->value3);?>" name="value3" data-inputmask='"mask": "9999999999999"' data-mask=""   style="text-transform:uppercase" class="form-control" >
						<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
						<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Keterangan</label>
				<div class="col-sm-12">

						<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo trim($lk->keterangan);?></textarea>

					<!-- /.input group -->
				</div>
			</div>

			<div class="form-group">
				 <label class="col-sm-12">Group Option</label>
				<div class="col-sm-12">
                    <input type="text" id="group_option"  value="<?php echo trim($lk->group_option);?>" name="group_option" style="text-transform:uppercase" class="form-control" required>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12">Status</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="status" id="kotakab">
						<option <?php if (trim($lk->status)=='T'){echo 'selected';}?> value="T" >AKTIF</option>
						<option <?php if (trim($lk->status)=='F'){echo 'selected';}?> value="F" >TIDAK AKTIF</option>
					</select>
				</div>
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
