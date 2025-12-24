<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
            });
</script>

<legend><?php echo $title;?></legend>
<h5>NIK : <?php echo $nik;?> || NAMA : <?php echo $nmlengkap;?> </h5> 
<?php //foreach ($list_lk as $lb){?>
<form name="autoSumForm" action="<?php echo site_url('payroll/tetap/add_detail')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Gaji Pokok</label>	
								<div class="col-sm-8">    
								<input type="number" id="type1" name="gajipokok"  value="<?php echo $gajipokok;?>" class="form-control" onFocus="startCalc();" onBlur="stopCalc();" required>				
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tunjangan Jabatan</label>	
								<div class="col-sm-8">    
									<input type="number" id="type1" name="tj_jabatan"   class="form-control" onFocus="startCalc();" onBlur="stopCalc();" required>
								</div>
							</div>	
							<!--<div class="form-group">
								<label class="col-sm-4">Tunjangan Jobgrade</label>	
								<div class="col-sm-8">    
									<input type="text"  name="tj_jobgrade" data-inputmask='"mask": "999999999"' data-mask="" class="form-control">
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Tunjangan Masa Kerja</label>	
								<div class="col-sm-8">    
									<input type="number"  id="type1" name="tj_masakerja"   class="form-control" onFocus="startCalc();" onBlur="stopCalc();" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tunjangan Prestasi</label>	
								<div class="col-sm-8">    
									<input type="number" id="type1" name="tj_prestasi"  class="form-control" onFocus="startCalc();" onBlur="stopCalc();" required>
									<input type="hidden"  name="nik" value="<?php echo trim($nik)?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total</label>	
								<div class="col-sm-8">    
									<input id="ttltarget" type="number"  name="ttltarget"   class="form-control" readonly>
								</div>
							</div>
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <div class="col-sm-6">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit"  class="btn btn-primary">SIMPAN</button>
		</div>
      </div>
</form>
    


<?php //} ?>

<script type="text/javascript">
function startCalc(){interval=setInterval("calc()",1)}
function calc(){
gajipokok=document.autoSumForm.gajipokok.value;
tj_jabatan=document.autoSumForm.tj_jabatan.value;
tj_masakerja=document.autoSumForm.tj_masakerja.value;
tj_prestasi=document.autoSumForm.tj_prestasi.value;


document.autoSumForm.ttltarget.value=(gajipokok*1)+(tj_jabatan*1)+(tj_masakerja*1)+(tj_prestasi*1)

}
function stopCalc(){clearInterval(interval)}
</script>
