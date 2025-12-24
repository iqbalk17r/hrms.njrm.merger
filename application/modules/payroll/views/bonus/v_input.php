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
<form name="autoSumForm" action="<?php echo site_url('payroll/bonus/add_detail')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Gaji Pokok</label>	
								<div class="col-sm-8">    
								<input type="number" id="type1" name="gajipokok"  value="<?php echo $gajipokok;?>" class="form-control" onFocus="startCalc();" onBlur="stopCalc();" readonly>				
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Bonus</label>	
								<div class="col-sm-8">    
									<input type="number" id="type1" name="bonus"  value="<?php echo $gajibonus; ?>" class="form-control" onFocus="startCalc();" onBlur="stopCalc();" required>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Koreksi Bulan Lalu</label>	
								<div class="col-sm-8">    
									<input type="number" id="type1" name="koreksi"  value="<?php echo $koreksi; ?>" class="form-control" onFocus="startCalc();" onBlur="stopCalc();" required>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">THR</label>	
								<div class="col-sm-8">    
									<input type="number"  id="type1" name="thr"  value="<?php echo $thr; ?>" class="form-control" onFocus="startCalc();" onBlur="stopCalc();" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Insentif Produksi</label>	
								<div class="col-sm-8">    
									<input type="number" id="type1" name="insentif_pro"  value="<?php echo $insentif_pro; ?>"class="form-control" onFocus="startCalc();" onBlur="stopCalc();" required>
									<input type="hidden"  name="nik" value="<?php echo trim($nik)?>" class="form-control">
									<input type="hidden"  name="bln" value="<?php //echo trim($bln)?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total</label>	
								<div class="col-sm-8">    
									<input id="ttltarget" type="number"  name="ttltarget"  value="<?php //echo $gajitetap;?>" class="form-control" readonly>
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
			<a href="<?php echo site_url('payroll/bonus/index'); ?>" type="button" class="btn btn-default">Close</a>
			<button type="submit"  class="btn btn-primary">SIMPAN</button>
		</div>
      </div>
</form>
    


<?php //} ?>

<script type="text/javascript">
function startCalc(){interval=setInterval("calc()",1)}
function calc(){
gajipokok=document.autoSumForm.bonus.value;
tj_jabatan=document.autoSumForm.koreksi.value;
tj_masakerja=document.autoSumForm.thr.value;
tj_prestasi=document.autoSumForm.insentif_pro.value;


document.autoSumForm.ttltarget.value=(gajipokok*1)+(tj_jabatan*1)+(tj_masakerja*1)+(tj_prestasi*1)

}
function stopCalc(){clearInterval(interval)}
</script>
