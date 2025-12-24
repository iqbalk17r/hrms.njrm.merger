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
<div><a href="<?php echo site_url('ga/arsipdokumen/clear_arsipdokumen');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>

</div>
</br>


<div class="row">
	<div class="col-xs-12">
		<div class="box">
			  <div class="box-body">
					<form role="form" action="<?php echo site_url('ga/arsipdokumen/save_arsipdokumen');?>" method="post">
					<div class='row'>
						<div class='col-sm-6'>
						 <div class="form-group">
							<label for="inputsm">Kode Arsip Database</label>
							<input type="text" class="form-control input-sm" id="archives_id" name="archives_id" style="text-transform:uppercase" placeholder="Nomor Arsip" maxlength="30" value="<?php echo trim($dtlmst['archives_id']) ;?>" readonly>
							<input type="hidden" class="form-control input-sm" id="type" name="type" value="APPROVALARSIPDOKUMEN">
						  </div>
						  <div class="form-group">
							<label for="inputsm">Kode Arsip Asli (Lama)</label>
							<input type="text" class="form-control input-sm" id="old_archives_number" style="text-transform:uppercase" name="old_archives_number" placeholder="Nomor Dokumen Asli" maxlength="30" value="<?php echo trim($dtlmst['old_archives_number']) ;?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nama Arsip</label>
							<input type="text" class="form-control input-sm" id="archives_name" style="text-transform:uppercase" name="archives_name" placeholder="Nama Arsip" value="<?php echo trim($dtlmst['archives_name']) ;?>" maxlength="30" readonly>
						  </div>
                            <div class="form-group">
                                <label for="inputsm">Tanggal Terakhir Pembaharuan Arsip</label>
                                <input type="text" class="form-control input-sm" id="old_archives_exp" style="text-transform:uppercase" name="old_archives_exp"  value="<?php if(trim($dtlmst['old_archives_exp'])=='') { echo ''; } else { echo date('d-m-Y', strtotime(trim($dtlmst['old_archives_exp']))); } ?>" placeholder="Exp Archive" data-date-format="dd-mm-yyyy" disabled>
                            </div>

						  <div class="form-group">
							<label for="inputsm">Pemilik Arsip</label>
							<input type="text" class="form-control input-sm" id="archives_own" style="text-transform:uppercase" name="archives_own" placeholder="Pemilik Arsip" value="<?php echo trim($dtlmst['archives_own']) ;?>" maxlength="30" readonly>
						  </div>
                        <div class="form-group">
                            <label for="uploadFile">Upload Dokumen Lampiran Arsip Scan/Rar</label>
                            <input type="file" id="att_name" name="att_name" >
                            <a href="#" onclick="window.open('<?php echo site_url('assets/files/arsipDokumen').'/'.$dtlmst['att_name'];?>')"><?php echo $dtlmst['att_name'];?></a>
                        </div>
						</div> <!---- col 1 -->
						<div class='col-sm-6'>
                        <div class="form-group">
                            <label for="inputsm">Kode Arsip Asli Baru</label>
                            <input type="text" class="form-control input-sm" id="archives_number" style="text-transform:uppercase" name="archives_number" placeholder="Nomor Dokumen Asli" maxlength="30" value="<?php echo trim($dtlmst['archives_number']) ;?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Tanggal Pembaharuan Arsip</label>
                            <input type="text" class="form-control input-sm tgl" id="archives_exp" style="text-transform:uppercase" name="archives_exp"  value="<?php if(trim($dtlmst['archives_exp'])=='') { echo ''; } else { echo date('d-m-Y', strtotime(trim($dtlmst['archives_exp']))); } ?>" placeholder="Exp Archive" data-date-format="dd-mm-yyyy" disabled>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Total Biaya Pembaharuan Arsip</label>
                            <input type="text" class="form-control input-sm-2 ratakanan fikyseparator" id="ttlvalue" name="ttlvalue" value="<?php echo number_format(round($dtlmst['ttlvalue']),0,',','.');?>"  placeholder="0" maxlength="12" READONLY>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Nama Pengurus (Optional)</label>
                            <input type="text" class="form-control input-sm" id="namapengurus" style="text-transform:uppercase" name="namapengurus" placeholder="Nama Pengurus Kir" value="<?php echo trim($dtlmst['namapengurus']);?>" maxlength="100" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Contact Pengurus (Optional)</label>
                            <input type="number" class="form-control input-sm" id="contactpengurus" style="text-transform:uppercase" name="contactpengurus" placeholder="Contact Pengurus Kir"  value="<?php echo trim($dtlmst['contactpengurus']);?>" maxlength="25" readonly>
                        </div>
						<div class="form-group">
							<label for="inputsm">Keterangan</label>
							<textarea  class="textarea" name="description" placeholder="Keterangan"   maxlength ="159" style="text-transform: uppercase; width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" disabled><?php echo trim($dtlmst['description']);?></textarea>
                        </div>
						</div>
					</div>
					</div>
					<div class="box-footer">
					<button type="submit" class="btn btn-success">Approval</button>
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
