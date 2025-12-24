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
											<th>Tipe Lembur</th>
											<th>Rentang Bawah</th>
											<th>Rentang Atas</th>
											<th>Jumlah Pengkali</th>
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
									<?php $no=0; foreach($list_lembur as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->tplembur;?></td>
									<td><?php echo $row->rentang_bawah;?></td>
									<td><?php echo $row->rentang_atas;?></td>
									<td><?php echo $row->jml_pengkali;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td><?php echo $row->input_date;?></td>
									<td><?php echo $row->input_by;?></td>
									<td><?php echo $row->update_date;?></td>
									<td><?php echo $row->update_by;?></td>
									<td><a href="<?php echo site_url('master/lembur/hps_lembur').'/'.$row->kdlembur;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->kdlembur);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a data-toggle="modal" data-target="#<?php echo trim($row->kdlembur);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input lembur -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER LEMBUR</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/lembur/add_lembur');?>" method="post">
			<div class="row">

			<div class="form-group">
				 <label class="col-sm-12">Tipe Lembur</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="tplembur" id="kdgrade">
						  
						  <option value="biasa" class="form-control">HARI BIASA</option>						  
						  <option value="libur" class="form-control">HARI LIBUR</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Rentang Bawah</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" name="rentang_bawah"  data-inputmask='"mask": "99999999999"' data-mask=""  style="text-transform:uppercase" class="form-control" required>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Rentang Atas</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" name="rentang_atas"  data-inputmask='"mask": "99999999999"' data-mask=""  style="text-transform:uppercase" class="form-control" required>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Jumlah Pengkali</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" name="jml_pengkali"  data-inputmask='"mask": "9.9"' data-mask=""  style="text-transform:uppercase" class="form-control" required>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Keterangan</label>
				<div class="col-sm-12">

						<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
					
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
<?php foreach ($list_lembur as $lk){?>

<div class="modal fade" id="<?php echo trim($lk->kdlembur);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit MASTER LEMBUR</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/lembur/edit_lembur');?>" method="post">
			<div class="row">
			<input type="hidden" id="kddept" value="<?php echo trim($lk->kdlembur);?>" name="kdlembur" class="form-control">
			<div class="form-group">
				 <label class="col-sm-12">Tipe Lembur</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="tplembur" id="kdgrade">
						  
						  <option <?php if(trim($lk->tplembur=='BIASA')) {echo 'selected';} ?> value="biasa" class="form-control">HARI BIASA</option>						  
						  <option <?php if(trim($lk->tplembur=='LIBUR')) {echo 'selected';} ?> value="libur" class="form-control">HARI LIBUR</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Rentang Bawah</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" value="<?php echo $lk->rentang_bawah;?>" name="rentang_bawah"  data-inputmask='"mask": "9999999999"' data-mask=""  style="text-transform:uppercase" class="form-control" >
				</div>
			</div>
			
			<div class="form-group">
				 <label class="col-sm-12">Rentang Atas</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" value="<?php echo $lk->rentang_atas;?>" name="rentang_atas"  data-inputmask='"mask": "99999999999"' data-mask=""  style="text-transform:uppercase" class="form-control" >
				</div>
			</div>

			<div class="form-group">
				 <label class="col-sm-12">Jumlah Pengkali</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" name="jml_pengkali" value="<?php echo $lk->jml_pengkali;?>" data-inputmask='"mask": "9.9"' data-mask=""  style="text-transform:uppercase" class="form-control" required>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Keterangan</label>
				<div class="col-sm-12">

						<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo $lk->keterangan; ?></textarea>
					
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

  $("[data-mask]").inputmask();
 
	
	//Date range picker
    $('#tgl').datepicker();

  

</script>