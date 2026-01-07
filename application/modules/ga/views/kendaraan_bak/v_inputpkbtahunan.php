<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<style>
  /*-- change navbar dropdown color --*/
  .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu {
  	background-color: #008040;
    color:#ffffff;
  }

</style>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
			
			//	$("#tglrange").daterangepicker(); 
            });
					
			//empty string means no validation error

</script>
<!--div class="pull-right">Versi: <?php echo $version; ?></div--->
</br>


<legend><?php echo $title;?></legend>
	
<div class="row">
	<!--div class="col-sm-3">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Kendaraan</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div--->
<div><a href="<?php echo site_url('ga/kendaraan/form_stnkbaru');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
	
</div>	
</br>


<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			  <div class="box-body">
					<form role="form" action="<?php echo site_url('ga/kendaraan/save_stnkbaru');?>" method="post">
					<div class='row'>
						<div class='col-sm-8'>	
						 <div class="form-group">
							<label for="inputsm">Nomor Rangka</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo $kdrangka ;?>" readonly>
							<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
							<input type="hidden" class="form-control input-sm" id="jenispengurusan" name="jenispengurusan" value="1T">
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor Mesin</label>
							<input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" value="<?php echo $kdmesin ;?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">NOPOL</label>
							<input type="text" value="<?php echo trim($nopol);?>"class="form-control input-sm" maxlength="20" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN BARU</label>
							<input type="text" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"  required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor PKB BARU</label>
							<input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" >
						  </div>
						  <div class="form-group">
							<label for="inputsm">Total BIAYA Pajak Kendaraan (PKB)</label>
							<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb"  maxlength="20" >
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor SKUM</label>
							<input type="text" class="form-control input-sm" id="noskum" style="text-transform:uppercase" name="noskum" placeholder="Nomor SKUM"  maxlength="20" >
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor KOHIR</label>
							<input type="text" class="form-control input-sm" id="nokohir" style="text-transform:uppercase" name="nokohir" placeholder="Nomor KOHIR"  maxlength="20" >
						  </div>
						
						<div class="form-group">
							<label for="inputsm">Keterangan</label>
							<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
						  </div>
						</div> 
					</div>
					</div>
					<div class="box-footer">
					<button type="submit" class="btn btn-primary" align="right">Submit</button>
				  </div>
			</form>  
		</div><!-- /.box -->
	</div>
</div>



<script>

  

	
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tgl").datepicker(); 
    	$(".tglan").datepicker(); 
				$('.year').datepicker({
					format: " yyyy",
					viewMode: "years", 
					minViewMode: "years"
				
				});
  

</script>