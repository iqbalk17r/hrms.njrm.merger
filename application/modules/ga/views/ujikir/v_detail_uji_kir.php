<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<style>
  /*-- change navbar dropdown color --*/
  .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu {
  	background-color: #008040;
    color:#ffffff;
  }
  .ratakanan { text-align : right; }
</style>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
			
			//	$("#tglrange").daterangepicker();
                $('.currency').formatCurrency({symbol: ''});
                $('.currency').blur(function()
                {
                    $('.currency').formatCurrency({symbol: ''});
                });
            });
					
			//empty string means no validation error

</script>
<!--div class="pull-right">Versi: <!?php echo $version; ?></div--->
</br>


<legend><?php echo $title;?></legend>

<!--?php echo $message;?>
<div class="row">
	<!--div class="col-sm-3">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Kendaraan</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div--->
<div><a href="<?php echo site_url('ga/ujikir/form_ujikir');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
	
</div>	
</br>


<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			  <div class="box-body">
					<!--form role="form" action="<?php echo site_url('ga/ujikir/save_ujikir');?>" method="post"--->
					<div class='row'>
						<div class='col-sm-4'>	
						 <div class="form-group">
							<label for="inputsm">Nomor Rangka</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($dtlmst['kdrangka']) ;?>" readonly>
							<input type="hidden" class="form-control input-sm" id="type" name="type" value="APPROVALUJIKIR">
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor Mesin</label>
							<input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" value="<?php echo trim($dtlmst['kdmesin']) ;?>" readonly>
							<input type="hidden" class="form-control input-sm" id="stockcode" style="text-transform:uppercase" name="stockcode" value="<?php echo trim($dtlmst['stockcode']) ;?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">NOPOL</label>
							<input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB" value="<?php echo trim($dtlmst['nopol']) ;?>" maxlength="20" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nama Kendaraan</label>
							<input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan" value="<?php echo trim($dtlmst['nmbarang']) ;?>" maxlength="30" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nama Pemilik</label>
							<input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="30" value="<?php echo trim($dtlmst['nmpemilik']) ;?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Alamat Pemilik</label>
							<input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  value="<?php echo trim($dtlmst['addpemilik']) ;?>" maxlength="100" readonly>
						  </div>
						</div> <!---- col 1 -->
						<div class='col-sm-4'>	
						 <div class="form-group">
                            <label for="inputsm">Dokumen Uji Kir Lama</label>
                            <input type="text" class="form-control input-sm " id="old_docujikir" name="old_docujikir" style="text-transform:uppercase" value="<?php echo trim($dtlmst['old_docujikir']);?>" placeholder="Nomor Dokumen Uji Kir" maxlength="50" readonly>
                          </div>
                          <div class="form-group">
                            <label for="inputsm">Tanggal Expired Uji Kir Lama</label>
                            <input type="text" class="form-control input-sm" id="old_expkir" style="text-transform:uppercase" name="old_expkir"  value="<?php echo date('d-m-Y', strtotime(trim($dtlmst['old_expkir'])));?>" placeholder="Expired Kir" data-date-format="dd-mm-yyyy" readonly>
                          </div>

                        <div class="form-group">
                            <label for="inputsm">Dokumen Uji Kir Baru</label>
                            <input type="text" class="form-control input-sm " id="docujikir" name="docujikir" style="text-transform:uppercase" value="<?php echo trim($dtlmst['docujikir']);?>"  placeholder="Nomor Dokumen Uji Kir" maxlength="30" disabled>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Tanggal Expired Uji Kir Baru</label>
                            <input type="text" class="form-control input-sm tgl" id="expkir" style="text-transform:uppercase" name="expkir" value="<?php echo trim($dtlmst['expkir']);?>"  placeholder="Expired Kir" data-date-format="dd-mm-yyyy" disabled>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Total Biaya Uji Kir</label>
                            <input type="text" class="form-control input-sm ratakanan currency " id="ttlvalue" name="ttlvalue" style="text-transform:uppercase" value="<?php echo trim($dtlmst['ttlvalue']);?>"  placeholder="Total Biaya Pengurusan Uji Kir" maxlength="12" disabled>
                        </div>
                        </div> <!---- col 2 -->
						<div class='col-sm-4'>	
                        <div class="form-group">
                            <label for="inputsm">Nama Pengurus Kir (Optional)</label>
                            <input type="text" class="form-control input-sm" id="namapengurus" style="text-transform:uppercase" name="namapengurus" placeholder="Nama Pengurus Kir" value="<?php echo trim($dtlmst['namapengurus']);?>" maxlength="100" disabled>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Contact Pengurus (Optional)</label>
                            <input type="number" class="form-control input-sm" id="contactpengurus" style="text-transform:uppercase" name="contactpengurus" placeholder="Contact Pengurus Kir"  value="<?php echo trim($dtlmst['contactpengurus']);?>" maxlength="25" disabled>
                        </div>
						<div class="form-group">
							<label for="inputsm">Keterangan</label>
							<textarea  class="textarea" name="description" placeholder="Keterangan"   maxlength ="159" style="text-transform: uppercase; width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" disabled><?php echo trim($dtlmst['description']);?></textarea>
                        </div>
						</div> 
					</div>
					</div>
					<!--div class="box-footer">
					<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Approve </button>
				    </div>
			</form--->
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