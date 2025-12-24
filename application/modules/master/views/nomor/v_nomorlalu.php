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
											<th>Dokumen</th>
											<th>Part</th>
											<th>Count3</th>
											<th>Prefix</th>	
											<th>Sufix</th>
											<th>Docno</th>
											<th>Modul</th>
											<th>Periode</th>
											<th>User Id</th>
											<th>Cekclose</th>
											<th>Aksi</th>	
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_nomor as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->dokumen;?></td>
									<td><?php echo $row->part;?></td>
									<td><?php echo $row->count3;?></td>
									<td><?php echo $row->prefix;?></td>
									<td><?php echo $row->sufix;?></td>
									<td><?php echo $row->docno;?></td>
									<td><?php echo $row->modul;?></td>
									<td><?php echo $row->periode;?></td>
									<td><?php echo $row->userid;?></td>
									<td><?php echo $row->cekclose1;?></td>
									<td>
									<a href="<?php echo site_url('master/nomor/hps_nomorlalu').'/'.$row->dokumen;?>" class="btn btn-default  btn-sm" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->dokumen);?>?')">
										<i class="fa fa-trash-o"></i> Hapus
									</a>
									<a data-toggle="modal" data-target="#<?php echo trim($row->dokumen);?>" href="#" class="btn btn-default  btn-sm">
										<i class="fa  fa-edit"></i>Edit</a>
									</td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input nomor -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER NOMOR LALU</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/nomor/add_nomorlalu');?>" method="post">
			<div class="row">
			<div class="col-sm-6">
	
			<div class="form-group">
				 <label class="col-sm-12">Dokumen</label>
				<div class="col-sm-12">
					
						<input type="text" id="kddept" name="dokumen"  class="form-control" style="text-transform:uppercase" maxlength="15" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Part</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept"  name="part"  maxlength="10" style="text-transform:uppercase" class="form-control" >
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Count 3</label>
				<div class="col-sm-12">

						<input type="text" placeholder="0" id="nmdept" name="count3" data-inputmask='"mask": "99"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			
			<div class="form-group">
				 <label class="col-sm-12">Prefix</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept"  name="prefix"  maxlength="20" style="text-transform:uppercase" class="form-control" >
					
					<!-- /.input group -->
				</div>
			</div>
		
			<div class="form-group">
				 <label class="col-sm-12">Sufix</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept"  name="sufix" maxlength="10"   style="text-transform:uppercase" class="form-control" >
						<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
						

					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Dokumen Number</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" placeholder="0" name="docno" data-inputmask='"mask": "999999"' data-mask="" style="text-transform:uppercase" class="form-control" >
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">User Id</label>
				<div class="col-sm-12">

				<input type="text" id="inputby" name="inputby"  value="<?php //echo $this->session->userdata('nik');?>" class="form-control" style="text-transform:uppercase" maxlength="12">
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Modul</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept"  name="modul" style="text-transform:uppercase" maxlength="20" class="form-control" >
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Periode</label>
				<div class="col-sm-12">
						<input type="text" id="nmdept" placeholder="YYYYMM" name="periode" data-inputmask='"mask": "999999"' data-mask="" style="text-transform:uppercase" class="form-control" >
					
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12">Cek Close</label>	
				<div class="col-sm-12">    
					<select class="form-control input-sm" name="cekclose" id="kotakab">
						<option value="T" >YA</option>	
						<option value="F" >TIDAK</option>
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
<?php foreach ($list_nomor as $lk){?>

<div class="modal fade" id="<?php echo trim($lk->dokumen);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT MASTER NOMOR LALU</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/nomor/edit_nomorlalu');?>" method="post">
			<div class="row">
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Dokumen</label>
				<div class="col-sm-12">
					
						<input type="text" id="kddept" value="<?php echo trim($lk->dokumen);?>" name="dokumen" maxlength="15" class="form-control" style="text-transform:uppercase" maxlength="6" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Part</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept"  value="<?php echo trim($lk->part);?>" name="part"  maxlength="10" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Count 3</label>
				<div class="col-sm-12">

						<input type="text" placeholder="0" value="<?php echo trim($lk->count3);?>" id="nmdept" name="count3"  data-inputmask='"mask": "999"' data-mask="" style="text-transform:uppercase" class="form-control" >
					
					<!-- /.input group -->
				</div>
			</div>
			
			<div class="form-group">
				 <label class="col-sm-12">Prefix</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept"  name="prefix" value="<?php echo trim($lk->prefix);?>" maxlength="20" style="text-transform:uppercase" class="form-control" >
					
					<!-- /.input group -->
				</div>
			</div>
		
			<div class="form-group">
				 <label class="col-sm-12">Sufix</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" maxlength="10" value="<?php echo trim($lk->sufix);?>" name="sufix"  style="text-transform:uppercase" class="form-control" >
						<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
						
					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="col-sm-6">
			<div class="form-group">
				 <label class="col-sm-12">Dokumen Number</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" value="<?php echo trim($lk->docno);?>" placeholder="0" name="docno" data-inputmask='"mask": "999999"' data-mask="" style="text-transform:uppercase" class="form-control" >
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">User Id</label>
				<div class="col-sm-12">

				<input type="text" id="inputby" name="inputby"  value="<?php echo trim($lk->userid);?>" class="form-control" maxlength="12" style="text-transform:uppercase" >
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Modul</label>
				<div class="col-sm-12">

				<input type="text" id="inputby" name="modul"  value="<?php echo trim($lk->modul);?>" maxlength="20" style="text-transform:uppercase" class="form-control" >
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Periode</label>
				<div class="col-sm-12">
						<input type="text" id="nmdept" placeholder="YYYYMM" value="<?php echo trim($lk->periode);?>" name="periode" data-inputmask='"mask": "999999"' data-mask="" style="text-transform:uppercase" class="form-control" >
					
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12">Cek Close</label>	
				<div class="col-sm-12">    
					<select class="form-control input-sm" name="cekclose" id="kotakab">
						<option <?php if (trim($lk->cekclose)=='T'){echo 'selected';}?> value="T" >YA</option>	
						<option <?php if (trim($lk->cekclose)=="F"){ echo 'selected';}?> value="F" >TIDAK</option>
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