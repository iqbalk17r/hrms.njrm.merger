

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

<?php foreach ($detail as $dt){?>
<form name="autoSumForm" action="<?php echo site_url('payroll/generate/pdf_slipgaji_resign')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK : <?php echo $dt->nik; ?></label>	
								
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Lengkap : <?php echo $dt->nmlengkap; ?> </label>	
							
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Bagian : <?php echo $dt->nmdept; ?>  </label>	
								
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Masa Kerja : <?php echo $dt->lama_bekerja; ?></label>	
								
							</div>
							<div class="form-group">
								<label class="col-sm-4">Gaji Tetap : <?php echo 'Rp.'.$dt->gajitetap; ?> </label>	
							
							</div>
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<!--<div class="form-group">
								<label class="col-sm-4">Gaji Tetap</label>	
								<div class="col-sm-8">    
								<input type="number" id="type1" name="gajitetap" value="<?php echo $dt->gajitetap; ?>"  class="form-control" onFocus="startCalc();" onBlur="stopCalc();" readonly>				
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pesangon/Tali Asih</label>	
								<div class="col-sm-8">    
									<input type="number" id="type2" name="kom_pesangon"    value="<?php echo $dt->kom_pesangon;?>" class="form-control" readonly><label> x Gaji Tetap </label>
									<input type="number" id="ttlpesangon" name="ttlpesangon"  value="<?php echo $dt->tj_pesangon;?>" class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Penghargaan Masa Kerja</label>	
								<div class="col-sm-8">    
									<input type="number" id="type3" name="kom_masakerja"    value="<?php echo $dt->kom_masakerja;?>"  class="form-control" readonly ><label> x Gaji Tetap </label>
									<input type="number" id="ttlmasakerja" name="ttlmasakerja"   value="<?php echo $dt->tj_masakerja;?>"  class="form-control" readonly>
								</div>
							</div>-->
			<script type="text/javascript">
										  $(function() {	
										  	var nik=$('#nik').val();
											
											$.ajax({
													url : "<?php echo site_url('payroll/generate/ajax_cekstatusresign')?>/" + nik,
													type: "GET",
													dataType: "JSON",
													success: function(data)
													{
													    var statusnya=(data.status);   
																	//console.log(data.status);
																	//console.log(statusnya);
													},
													error: function (jqXHR, textStatus, errorThrown)
													{
														alert('Error get data from ajax');
													}
													
													
													
												});
							
							
									
													$("#ttlpenggantianhak").keyup(function(){
														
														var ttl_hak=parseInt($('#ttlpenggantianhak').val());
														var ttl_cuti=parseInt($('#ttlcuti').val());
														var ttl_absen=parseInt($('#ttlabsen').val());
														var lain_lain=parseInt($('#lain').val());
														var ttl_pesangon=ttl_hak + ttl_cuti + ttl_absen + lain_lain;
														
														
														
														$('[name="ttltarget"]').val(ttl_pesangon); 
													  });
										  });			
								</script>							
							<div class="form-group">
								<label class="col-sm-4">Penggantian Hak Pesangon + Masa Kerja</label>	
								<div class="col-sm-8">    
									<!--<input type="number"  id="type4" name="kom_penggantianhak"  value="<?php echo $dt->kom_penggantianhak;?>" class="form-control"   readonly><label> % </label>-->
									<input type="number" id="ttlpenggantianhak" name="ttlpenggantianhak"   value="<?php echo $dt->tj_penggantianhak;?>"  class="form-control" 
									<?php $stat=trim($dt->status); if ($stat=='P') { ?> readonly <?php } else { echo '';}?>>
								</div>
							</div>
	
			
							
							<div class="form-group">
								<label class="col-sm-4">Sisa Cuti</label>	
								<div class="col-sm-8">    
									<!--<input type="number"  id="type5" name="kom_cuti"   value="<?php echo $dt->kom_cuti;?>"  class="form-control" readonly ><label> x (Gaji Tetap / 25)</label>-->
									<input type="number" id="ttlcuti" name="ttlcuti"   value="<?php echo $dt->tj_cuti;?>" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Gaji Bulan Ini</label>	
								<div class="col-sm-8">    
									<!--<input type="number" id="type6" name="kom_absen"  value="<?php echo $dt->kom_absen;?>" class="form-control" readonly ><label> x (Gaji Tetap / 25)</label>-->
									<input type="number" id="ttlabsen" name="ttlabsen"  value="<?php echo $dt->tj_absen;?>" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Lain-lain</label>	
								<div class="col-sm-8">    
									<input type="number"  id="lain" name="tj_lain"  class="form-control" value="<?php echo $dt->tj_lain;?>" readonly>
								</div>
							</div>
							
					
							<div class="form-group">
								<label class="col-sm-4">Total Upah</label>	
								<div class="col-sm-8">    
									<input id="ttltarget" type="number"  name="ttltarget"  value="<?php echo $dt->total_upah;?>" class="form-control" readonly>
									<input type="hidden" id="nik" name="nik" value="<?php echo trim($dt->nik);?>" class="form-control">
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
			<a href="<?php echo site_url('payroll/generate/view_finalresign'); ?>" type="button" class="btn btn-default">Close</a>
			<button type="submit"  class="btn btn-primary">CETAK</button>
		</div>
      </div>
</form>
    


<?php } ?>

	


<script type="text/javascript">
/*
function startCalc(){interval=setInterval("calc()",1)}
function calc(){

}
function stopCalc(){clearInterval(interval)} */
</script>
