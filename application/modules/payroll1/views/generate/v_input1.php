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
<form name="autoSumForm" action="<?php echo site_url('payroll/generate/add_gajiresign')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK : <?php echo $nik; ?></label>	
								
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Lengkap : <?php echo $nmlengkap; ?> </label>	
							
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Bagian : <?php echo $nmdept; ?>  </label>	
								
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Masa Kerja : <?php echo $pesan; ?></label>	
								
							</div>
							<div class="form-group">
								<label class="col-sm-4">Gaji Tetap : <?php echo 'Rp.'.$gajitetap; ?> </label>	
							
							</div>
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Gaji Tetap</label>	
								<div class="col-sm-8">    
								<input type="number" id="type1" name="gajitetap" value="<?php echo $gajitetap; ?>"  class="form-control" onFocus="startCalc();" onBlur="stopCalc();" required>				
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pesangon/Tali Asih</label>	
								<div class="col-sm-8">    
									<input type="number" id="type1" name="kom_pesangon"   class="col-sm-2" onFocus="startCalc();" onBlur="stopCalc();" ><label> x Gaji Tetap </label>
									<input type="number" id="ttlpesangon" name="ttlpesangon"   class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Penghargaan Masa Kerja</label>	
								<div class="col-sm-8">    
									<input type="number" id="type1" name="kom_masakerja"   class="col-sm-2" onFocus="startCalc();" onBlur="stopCalc();" ><label> x Gaji Tetap </label>
									<input type="number" id="ttlmasakerja" name="ttlmasakerja"   class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Penggantian Hak</label>	
								<div class="col-sm-8">    
									<input type="number"  id="type1" name="kom_penggantianhak"  class="col-sm-2" onFocus="startCalc();" onBlur="stopCalc();" ><label> % </label>
									<input type="number" id="ttlpenggantianhak" name="ttlpenggantianhak"   class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Sisa Cuti</label>	
								<div class="col-sm-8">    
									<input type="number"  id="type1" name="kom_cuti"  class="col-sm-2" onFocus="startCalc();" onBlur="stopCalc();" ><label> x (Gaji Tetap / 25)</label>
									<input type="number" id="ttlcuti" name="ttlcuti"   class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Hari Aktif Masuk Kerja</label>	
								<div class="col-sm-8">    
									<input type="number" id="type1" name="kom_absen" class="col-sm-2" onFocus="startCalc();" onBlur="stopCalc();" ><label> x (Gaji Tetap / 25)</label>
									<input type="hidden"  name="nik" value="<?php echo trim($nik)?>" class="form-control">
									<input type="hidden"  name="bln" value="<?php //echo trim($bln)?>" class="form-control">
									<input type="number" id="ttlabsen" name="ttlabsen"   class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Lain-lain</label>	
								<div class="col-sm-8">    
									<input type="number"  id="type1" name="tj_lain"  class="form-control" onFocus="startCalc();" onBlur="stopCalc();" >
									<input type="number" id="ttllain" name="ttllain"   class="form-control" readonly>
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
			<a href="<?php echo site_url('payroll/generate/payroll_resign'); ?>" type="button" class="btn btn-default">Close</a>
			<button type="submit"  class="btn btn-primary">SIMPAN</button>
		</div>
      </div>
</form>
    


<?php //} ?>

<script type="text/javascript">
function startCalc(){interval=setInterval("calc()",1)}
function calc(){
gajitetap=document.autoSumForm.gajitetap.value;
kom_pesangon=document.autoSumForm.kom_pesangon.value;
kom_masakerja=document.autoSumForm.kom_masakerja.value;
kom_penggantianhak=document.autoSumForm.kom_penggantianhak.value;
kom_cuti=document.autoSumForm.kom_cuti.value;
kom_absen=document.autoSumForm.kom_absen.value;
tj_lain=document.autoSumForm.tj_lain.value;


document.autoSumForm.ttlpesangon.value=(kom_pesangon*gajitetap)
document.autoSumForm.ttlmasakerja.value=(kom_masakerja*gajitetap)
document.autoSumForm.ttlpenggantianhak.value=(kom_penggantianhak/100.00*(kom_pesangon*gajitetap))+(kom_penggantianhak/100.00*(kom_masakerja*gajitetap))
document.autoSumForm.ttlcuti.value=(kom_cuti*(gajitetap/25))
document.autoSumForm.ttlabsen.value=((gajitetap/25)*kom_absen)
document.autoSumForm.ttllain.value=(tj_lain*1)
document.autoSumForm.ttltarget.value=(kom_penggantianhak/100.00*(kom_pesangon*gajitetap))+(kom_penggantianhak/100.00*(kom_masakerja*gajitetap))+(kom_cuti*(gajitetap/25))+((gajitetap/25)*kom_absen)+(tj_lain*1)
//document.autoSumForm.ttltarget.value=(ttlpesangon*1)+(ttlmasakerja*1)+(ttlpenggantianhak*1)+(ttlcuti*1)+(ttlabsen)+(ttllain*1)+(tj_lain*1)

}
function stopCalc(){clearInterval(interval)}
</script>
