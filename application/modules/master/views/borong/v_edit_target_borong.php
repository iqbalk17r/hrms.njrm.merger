<?php 
/*
	@author : hanif_anak_metal \m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example4").dataTable();
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("[data-mask]").inputmask();	                           
				$("#dateinput").datepicker();                               
            });			
</script>

<legend><?php echo $title;?></legend>
<?php echo $message;?>

</br>
<form name="autoSumForm" action="<?php echo site_url('master/borong/edit_target_borong')?>" method="post">
<div class="row">
	<div class="col-sm-4">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<input type="hidden" id="nmdept" name="no_urut"   value="<?php echo $list_tb['no_urut']; ?>" style="text-transform:uppercase" class="form-control" readonly>
							<div class="form-group">
								 <label class="col-sm-12">Kode Kategori</label>
								<div class="col-sm-12">
									<input type="text" id="nmdept" name="kdborong" value="<?php echo $list_tb['kdborong'];?>" maxlength="6" style="text-transform:uppercase" class="form-control" readonly>
									
									<!-- /.input group -->
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Kode Sub kategori</label>
								<div class="col-sm-12">
										<input type="text" id="nmdept" name="kdsub_borong" value="<?php echo $list_tb['kdsub_borong'];?>" maxlength="6" style="text-transform:uppercase" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Periode Tahun</label>
								<div class="col-sm-12">

										<input type="text" id="nmdept" name="periode" value="<?php echo $list_tb['periode'];?>"  style="text-transform:uppercase" class="form-control" readonly>
									
									<!-- /.input group -->
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-1</label>
								<div class="col-sm-12">

										<input type="numeric" id="top" value="<?php echo $list_tb['target1'];?>" name="target1"  onFocus="startCalc();" onBlur="stopCalc();"  class="form-control" required>
									
									<!-- /.input group -->
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-2</label>
								<div class="col-sm-12">

										<input type="numeric" id="top" value="<?php echo $list_tb['target2'];?>" name="target2"  onFocus="startCalc();" onBlur="stopCalc();" style="text-transform:uppercase" class="form-control" required>
									
									<!-- /.input group -->
								</div>
							</div>
						</div>
					</div>
				</div>
	</div>
	<div class="col-sm-4">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-3</label>
								<div class="col-sm-12">

									<input type="numeric" id="top" value="<?php echo $list_tb['target3'];?>" name="target3"  onFocus="startCalc();" onBlur="stopCalc();" style="text-transform:uppercase" class="form-control" required>
									<!-- /.input group -->
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-4</label>
								<div class="col-sm-12">
									<input type="numeric" id="top" value="<?php echo $list_tb['target4'];?>" name="target4"  onFocus="startCalc();" onBlur="stopCalc();" style="text-transform:uppercase" class="form-control" required>
									<!-- /.input group -->
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-5</label>
								<div class="col-sm-12">

										<input type="numeric" id="nmdept" value="<?php echo $list_tb['target5'];?>" name="target5"  onFocus="startCalc();" onBlur="stopCalc();" style="text-transform:uppercase" class="form-control" required>
									
									<!-- /.input group -->
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-6</label>
								<div class="col-sm-12">

										<input type="numeric" id="nmdept" name="target6" value="<?php echo $list_tb['target6'];?>"  onFocus="startCalc();" onBlur="stopCalc();" style="text-transform:uppercase" class="form-control" required>
									
									<!-- /.input group -->
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-7</label>
								<div class="col-sm-12">

										<input type="numeric" id="nmdept" name="target7" value="<?php echo $list_tb['target7'];?>"  onFocus="startCalc();" onBlur="stopCalc();" style="text-transform:uppercase" class="form-control" required>
									
									<!-- /.input group -->
								</div>
							</div>
					</div>
					</div>
				</div>
	</div>
		
	<div class="col-sm-4">
			<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-8</label>
								<div class="col-sm-12">

										<input type="numeric" id="nmdept" name="target8" value="<?php echo $list_tb['target8'];?>"  onFocus="startCalc();" onBlur="stopCalc();" style="text-transform:uppercase" class="form-control" required>
									
									<!-- /.input group -->
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-9</label>
								<div class="col-sm-12">

										<input type="numeric" id="nmdept" name="target9" value="<?php echo $list_tb['target9'];?>"  onFocus="startCalc();" onBlur="stopCalc();" style="text-transform:uppercase" class="form-control" required>
									
									<!-- /.input group -->
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-10</label>
								<div class="col-sm-12">

										<input type="numeric" id="nmdept" name="target10" value="<?php echo $list_tb['target10'];?>"  onFocus="startCalc();" onBlur="stopCalc();" style="text-transform:uppercase" class="form-control" required>
									
									<!-- /.input group -->
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-11</label>
								<div class="col-sm-12">

										<input type="numeric" id="nmdept" name="target11" value="<?php echo $list_tb['target11'];?>"  onFocus="startCalc();" onBlur="stopCalc();" style="text-transform:uppercase" class="form-control" required>
									
									<!-- /.input group -->
								</div>
							</div>
							<div class="form-group">
								 <label class="col-sm-12">Target Bulan Ke-12</label>
								<div class="col-sm-12">

										<input type="numeric" id="nmdept" name="target12" value="<?php echo $list_tb['target12'];?>"  onFocus="startCalc();" onBlur="stopCalc();" style="text-transform:uppercase" class="form-control" required>
									
									<!-- /.input group -->
								</div>
							</div>
			</div>
			</div>
			</div>
	</div>
			<div class="row">
			<div class="form-group">
				 <label class="col-sm-12">Total Target</label>
				<div class="col-sm-12">

						<input type="text" id="total" name="ttltarget" value="<?php echo $list_tb['total_target'];?>" class="form-control" readonly>
					
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
			<div class="row">
				<div class="col-sm-6">		
					<a href="<?php echo site_url('master/borong/target_borong');?>" class="btn btn-primary" style="margin:10px">Kembali</a>
					<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
				</div>
				<div class="col-sm-6">		
					
				</div>
</div>
</form>
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

