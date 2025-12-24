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
								<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target1" required>			
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tunjangan Jabatan</label>	
								<div class="col-sm-8">    
									<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target2" required>
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
									<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target3" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tunjangan Prestasi</label>	
								<div class="col-sm-8">    
									<input type="number"  placeholder="0" class="form-control input-sm" value="" id="type1" onFocus="startCalc();" onBlur="stopCalc();"  name="target4" required>
									<input type="hidden"  name="nik" value="<?php echo trim($nik)?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total</label>	
								<div class="col-sm-8">    
									<input type="text" id="total" name="ttltarget" value="" class="form-control" readonly>
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
target1=document.autoSumForm.target1.value;
target2=document.autoSumForm.target2.value;
target3=document.autoSumForm.target3.value;
target4=document.autoSumForm.target4.value;


document.autoSumForm.ttltarget.value=(target1*1)+(target2*1)+(target3*1)+(target4*1)

}
function stopCalc(){clearInterval(interval)}
</script>