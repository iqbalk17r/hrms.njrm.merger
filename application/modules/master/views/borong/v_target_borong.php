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
					   <a class="btn btn-primary" data-toggle="modal" data-target="#myModal1" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> INPUT</a>
					</div><!-- /.box-header -->	
                            <div class="box-body">
								<div class="box-body table-responsive" style='overflow-x:scroll;'>
                                <table id="example1" class="table table-bordered table-striped" >
                                    <thead>
										<tr>											
											
											<th>No.</th>
											<th>Nama Borong</th>
											<th>Nama Sub Borong</th>
											<th>Periode</th>
											<th>Target Bulan Ke-1</th>
											<th>Target Bulan Ke-2</th>
											<th>Target Bulan Ke-3</th>
											<th>Target Bulan Ke-4</th>
											<th>Target Bulan Ke-5</th>
											<th>Target Bulan Ke-6</th>
											<th>Target Bulan Ke-7</th>
											<th>Target Bulan Ke-8</th>
											<th>Target Bulan Ke-9</th>
											<th>Target Bulan Ke-10</th>
											<th>Target Bulan Ke-11</th>
											<th>Target Bulan Ke-12</th>
											<th>Total Target</th>
											<th>Aksi</th>
											<th></th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_target_borong as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->nmborong;?></td>
									<td><?php echo $row->nmsub_borong;?></td>
									<td><?php echo $row->periode;?></td>
									<td><?php echo $row->target1;?></td>
									<td><?php echo $row->target2;?></td>
									<td><?php echo $row->target3;?></td>
									<td><?php echo $row->target4;?></td>
									<td><?php echo $row->target5;?></td>
									<td><?php echo $row->target6;?></td>
									<td><?php echo $row->target7;?></td>
									<td><?php echo $row->target8;?></td>
									<td><?php echo $row->target9;?></td>
									<td><?php echo $row->target10;?></td>
									<td><?php echo $row->target11;?></td>
									<td><?php echo $row->target12;?></td>
									<td><?php echo $row->total_target;?></td>
									<td><a href="<?php echo site_url('master/borong/hps_target_borong').'/'.$row->no_urut;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->no_urut);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a href="<?php echo site_url("master/borong/edit/$row->no_urut");?>"  ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div>
							</div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input borong -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER TARGET BORONG</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" name="autoSumForm" action="<?php echo site_url('master/borong/add_target_borong');?>" method="post">
			<div class="row">
			<div class="col-sm-4">
			<script type="text/javascript" charset="utf-8">
				  $(function() {	
					$("#kdsub_borong").chained("#kdborong");		
					$("#cjabt").chained("#csubdept");	
									
				  });
				</script>
			<div class="form-group">
				 <label class="col-sm-12">Kode Kategori</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="kdborong" id="kdborong">
						  <?php foreach($list_borong as $listkan){?>
						  <option value="<?php echo trim($listkan->kdborong);?>" ><?php echo $listkan->nmborong;?></option>						  
						  <?php }?>
					</select>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Kode Sub kategori</label>
				<div class="col-sm-12">
						<select class="form-control input-sm" name="kdsub_borong" id="kdsub_borong">
						  <?php foreach($list_sub_borong as $listkan){?>
						  <option value="<?php echo trim($listkan->kdsub_borong);?>" class="<?php echo trim($listkan->kdborong);?>" ><?php echo $listkan->nmsub_borong;?></option>
						  <?php }?>
					</select>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Periode Tahun</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="periode" id="kotakab">
										<option value="2014" >2014</option>
										<option value="2015" >2015</option>
										<option value="2016" >2016</option>
										<option value="2017" >2017</option>
										<option value="2018" >2018</option>
										<option value="2019" >2019</option>
										<option value="2020" >2020</option>
										<option value="2021" >2021</option>
										<option value="2022" >2022</option>
										<option value="2023" >2023</option>
										<option value="2024" >2024</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-1</label>
				<div class="col-sm-12">

					<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target1" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-2</label>
				<div class="col-sm-12">
						<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target2" required>
					
					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="col-sm-4">
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-3</label>
				<div class="col-sm-12">

					<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target3" required>
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-4</label>
				<div class="col-sm-12">

					<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target4" required>
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-5</label>
				<div class="col-sm-12">

					<input type="number"  class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target5" required>
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-6</label>
				<div class="col-sm-12">

					<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target6" required>
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-7</label>
				<div class="col-sm-12">

					<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target7" required>
					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="col-sm-4">
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-8</label>
				<div class="col-sm-12">

					<input type="number" placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target8" required>
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-9</label>
				<div class="col-sm-12">

					<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target9" required>
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-10</label>
				<div class="col-sm-12">

					<input type="number" placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target10" required>
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-11</label>
				<div class="col-sm-12">

					<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target11" required>
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-12</label>
				<div class="col-sm-12">

					<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target12" required>
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Total Target</label>
				<div class="col-sm-12">

						<input type="text" id="ttltarget" name="total_target" value="" class="form-control" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			</div>
			</div>
			<div class="row">
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
<?php foreach ($list_target_borong as $lk){?>

<div class="modal fade" id="<?php echo trim($lk->no_urut);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit MASTER TARGET KATEGORI BORONG</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/borong/edit_target_borong');?>" method="post">
		<div class="row">
		<div class="col-sm-4">
		<input type="hidden" id="nmdept" name="no_urut"   value="<?php echo $lk->no_urut; ?>" style="text-transform:uppercase" class="form-control" readonly>
			<div class="form-group">
				 <label class="col-sm-12">Kode Kategori</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" name="kdborong" value="<?php echo $lk->kdborong;?>" maxlength="6" style="text-transform:uppercase" class="form-control" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Kode Sub kategori</label>
				<div class="col-sm-12">
						<input type="text" id="nmdept" name="kdsub_borong" value="<?php echo $lk->kdsub_borong;?>" maxlength="6" style="text-transform:uppercase" class="form-control" readonly>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Periode Tahun</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" name="periode" value="<?php echo $lk->periode;?>" data-inputmask='"mask": "9999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-1</label>
				<div class="col-sm-12">

						<input type="text" id="top" value="<?php echo $lk->target1;?>" name="target1" data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-2</label>
				<div class="col-sm-12">

						<input type="text" id="top1" value="<?php echo $lk->target2;?>" name="target2"   data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="col-sm-4">
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-3</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" name="target3" value="<?php echo $lk->target3;?>" data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-4</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" value="<?php echo $lk->target4;?>" name="target4" data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-5</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" value="<?php echo $lk->target5;?>" name="target5" data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-6</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" name="target6" value="<?php echo $lk->target6;?>" data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-7</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" name="target7" value="<?php echo $lk->target7;?>" data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="col-sm-4">
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-8</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" name="target8" value="<?php echo $lk->target8;?>" data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-9</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" name="target9" value="<?php echo $lk->target9;?>" data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-10</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" name="target10" value="<?php echo $lk->target10;?>" data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-11</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" name="target11" value="<?php echo $lk->target11;?>" data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Target Bulan Ke-12</label>
				<div class="col-sm-12">

						<input type="text" id="nmdept" name="target12" value="<?php echo $lk->target12;?>" data-inputmask='"mask": "9999999"' data-mask="" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			</div>
			</div>
			
			
			<div class="row">
			<div class="form-group">
				 <label class="col-sm-12">Total Target</label>
				<div class="col-sm-12">

						<input type="text" id="total" name="total_target" value="<?php echo $lk->total_target;?>" class="form-control" readonly>
					
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
<script type="text/javascript">
function startCalc(){interval=setInterval("calc()",1)}
function calc(){
target1=document.autoSumForm.target1.value;
target2=document.autoSumForm.target2.value;
target3=document.autoSumForm.target3.value;
target4=document.autoSumForm.target4.value;
target5=document.autoSumForm.target5.value;
target6=document.autoSumForm.target6.value;
target7=document.autoSumForm.target7.value;
target8=document.autoSumForm.target8.value;
target9=document.autoSumForm.target9.value;
target10=document.autoSumForm.target10.value;
target11=document.autoSumForm.target11.value;
target12=document.autoSumForm.target12.value;

document.autoSumForm.ttltarget.value=(target1*1)+(target2*1)+(target3*1)+(target4*1)+(target5*1)+(target6*1)+(target7*1)+(target8*1)+(target9*1)+(target10*1)+(target11*1)+(target12*1)

}
function stopCalc(){clearInterval(interval)}
</script>