<?php 
/*
	@author : junis 10-12-2012\m/
*/
?>
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
					$('#stsseleksi').selectize();
            });
		
		
		
		
</script>



        <div class="modal-dialog modal-md">
            <div class="modal-content">

			<div class="modal-header">
			<button type="button" class="close closepp1" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>	
			<legend><?php echo $title.'</br>  No KTP: '.$noktp;?></legend>
			<!--?php echo $message;?-->
			
			<!--h4 class="modal-title" id="myModalLabel">Transaksi Bulan</h4--->
			</div>
			<form action="<?php echo site_url('recruitment/calonkaryawan/edit_status_seleksi')?>" method="post">
			<div class="modal-body">
			<div class="row">
				<div class="form-group">					
					<div class="col-sm-12">
								<div class="form-group input-sm ">		
									<label class="label-form col-sm-3">PILIH STATUS SELEKSI KARYAWAN</label>
									<div class="col-sm-9">
										<select class="form-control input-sm" id="stsseleksi" name="stsseleksi">
													<option value="">--PILIH STATUS--</option>
													<?php foreach ($jenis_seleksi as $lp){ ?>
													<option value="<?php echo trim($lp->kdtrx);?>"><?php echo trim($lp->kdtrx).'   ||   '.trim($lp->uraian);?></option>
													<?php } ?>																																					
										</select>
									</div>	
								<input type="hidden" name="noktp"  style="text-transform:uppercase" class="form-control" value="<?php echo trim($noktp);?>">
								<input type="hidden" name="tgllowongan"  class="form-control" value="<?php echo trim($tgllowongan);?>" >
								<input type="hidden" name="tgllamaran"  class="form-control" value="<?php echo trim($tgllamaran);?>" >
									
								</div>
					</div>				
				</div>
			</div>
								
	</div>
	
	      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-primary">Ubah</button>
      </div>
	  </form>
	
        </div>
    </div>

