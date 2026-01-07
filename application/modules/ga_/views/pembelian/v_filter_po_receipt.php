<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />

<legend><?php echo $title;?></legend>
<div class="row">
	<div class="col-xs-6">
		<div class="box">
			<div class="box-body">
				<div class="form-horizontal">
					<form action="<?php echo site_url('ga/pembelian/dtl_po_receipt');?>" name="form" role="form" method="post">										
					<div class="form-group">
						<label class="col-sm-4" for="inputsm"> TANGGAL</label>	
						<div class="col-sm-8">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" id="tgl" name="tgl"  class="form-control pull-right">
							</div><!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4" for="inputsm"> KANTOR WILAYAH</label>	
						<div class="col-sm-8"> 
							<select class="form-control input-sm " name="loccode" id="loccode" required>
							 <option  value="">---PILIH KANWIL || DESC KANWIL--</option> 
							  <?php foreach($kanwil as $sc){?>					  
								<!--option><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>-->	
								<option value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  							  
							  <?php }?>
							</select>
						</div>
					</div>
						<!--area-->
						<div class="form-group"> 
							<div class="col-lg-4">
								<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> PROSES</button>
							   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

  

	
	//Date range picker
    $('#tgl').daterangepicker();

  

</script>