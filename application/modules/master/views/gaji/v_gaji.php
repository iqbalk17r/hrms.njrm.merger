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
											<th>Periode</th>
											<th>Kode Grade</th>
											<th>Gaji Pokok Eskalasi</th>
											<th>Gaji Minimal</th>
											<th>Gaji Maksimal</th>
											<th>Tunjangan Jabatan</th>
											<th>Total Upah</th>
											<th>Aksi</th>
											<th></th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_gaji as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->periode;?></td>
									<td><?php echo $row->kdgrade;?></td>
									<td><?php echo $row->gp_eskalasi;?></td>
									<td><?php echo $row->gp_min;?></td>
									<td><?php echo $row->gp_max;?></td>
									<td><?php echo $row->tunjangan_jbt;?></td>
									<td><?php echo $row->total_upah;?></td>
									<td><a href="<?php echo site_url('master/gaji/hps_gaji').'/'.$row->id;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->id);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a data-toggle="modal" data-target="#<?php echo trim($row->id);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
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
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER GAJI</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/gaji/add_gaji');?>" method="post">
			<div class="row">
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Kode Grade</label>
				<div class="col-sm-12">

					<select class="form-control input-sm" name="kdgrade" id="kdgrade">
							  <?php foreach($list_grade as $listkan){?>
							  <option value="<?php echo trim($listkan->kdgrade);?>" ><?php echo $listkan->kdgrade;?></option>						  
							  <?php }?>
					</select>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Gaji Pokok Eskalasi</label>
				<div class="col-sm-12">
					
						<input type="text" id="gp_eskalasi" name="gp_eskalasi"  data-inputmask='"mask": "9999999"' data-mask="" class="form-control">
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Gaji Pokok Minimal</label>
				<div class="col-sm-12">

						<input type="text" id="gp_min" name="gp_min"  data-inputmask='"mask": "9999999"' data-mask="" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			
			<div class="form-group">
				 <label class="col-sm-12">Gaji Pokok Maksimal</label>
				<div class="col-sm-12">

						<input type="text" id="gp_max" name="gp_max"  data-inputmask='"mask": "9999999"' data-mask="" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			</div>
			
			
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Tunjangan Jabatan</label>
				<div class="col-sm-12">

						<input type="text" id="tunjangan_jbt" name="tunjangan_jbt"  data-inputmask='"mask": "9999999"' data-mask="" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			
			
			<div class="form-group">
				 <label class="col-sm-12">Periode</label>
				<div class="col-sm-12">
				<select class="form-control input-sm" name="periode">
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')+1; echo $tgl; ?>'><?php $tgl=date('Y')+1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')+2; echo $tgl; ?>'><?php $tgl=date('Y')+2; echo $tgl; ?></option>					
				</select>
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
<?php foreach ($list_gaji as $lk){?>

<div class="modal fade" id="<?php echo trim($lk->id);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit MASTER GAJI</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/gaji/edit_gaji');?>" method="post">
			<div class="row">
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Kode Grade</label>
				<div class="col-sm-12">

					<input type="text" id="kdgrade" name="kdgrade" value="<?php echo trim($lk->kdgrade);?>" class="form-control" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Gaji Pokok Eskalasi</label>
				<div class="col-sm-12">
					
						<input type="text" id="gp_eskalasi" name="gp_eskalasi"  value="<?php echo $lk->gp_eskalasi;?>" data-inputmask='"mask": "9999999"' data-mask="" class="form-control">
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Gaji Pokok Minimal</label>
				<div class="col-sm-12">

						<input type="text" id="gp_min" name="gp_min"  value="<?php echo $lk->gp_min;?>" data-inputmask='"mask": "9999999"' data-mask="" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			
			<div class="form-group">
				 <label class="col-sm-12">Gaji Pokok Maksimal</label>
				<div class="col-sm-12">

						<input type="text" id="gp_max" name="gp_max"  value="<?php echo $lk->gp_max;?>" data-inputmask='"mask": "9999999"' data-mask="" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			</div>
			
			
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Tunjangan Jabatan</label>
				<div class="col-sm-12">

						<input type="text" id="tunjangan_jbt" name="tunjangan_jbt"  value="<?php echo $lk->tunjangan_jbt;?>" data-inputmask='"mask": "9999999"' data-mask="" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			
			
			<div class="form-group">
				 <label class="col-sm-12">Periode</label>
				<div class="col-sm-12">
				<input type="text" id="periode" name="periode" value="<?php echo trim($lk->periode);?>" class="form-control" readonly>
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