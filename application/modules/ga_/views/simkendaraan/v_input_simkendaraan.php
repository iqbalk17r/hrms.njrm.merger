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

                $('.currency').formatCurrency({symbol: ''});
                $('.currency').blur(function()
                {
                    $('.currency').formatCurrency({symbol: ''});
                });
			/*	$("#tglrange").daterangepicker();
                $('form').on('focus', 'input[type=number]', function (e) {
                    $(this).on('mousewheel.disableScroll', function (e) {
                        e.preventDefault()
                    })
                })*/
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
<div><a href="<?php echo site_url('ga/simkendaraan/clear_simkendaraan');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
	
</div>	
</br>


<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			  <div class="box-body">
					<form role="form" action="<?php echo site_url('ga/simkendaraan/save_sim');?>" method="post">
					<div class='row'>
						<div class='col-sm-4'>
						 <div class="form-group">
							<label for="inputsm">Nik Pemilik SIM</label>
							<input type="text" class="form-control input-sm" id="nik" name="nik" style="text-transform:uppercase" placeholder="Nik Karyawan" maxlength="25" value="<?php echo trim($dtlmst['nik']) ;?>" readonly>
							<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUTSIMKENDARAAN">
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nama Lengkap</label>
							<input type="text" class="form-control input-sm" id="nmlengkap" style="text-transform:uppercase" name="nmlengkap" placeholder="Nama Lengkap" maxlength="50" value="<?php echo trim($dtlmst['nmlengkap']) ;?>" readonly>

						  </div>
						  <div class="form-group">
							<label for="inputsm">Departement</label>
							<input type="text" class="form-control input-sm" id="nmdept" style="text-transform:uppercase" name="nmdept" placeholder="Departement" value="<?php echo trim($dtlmst['nmdept']) ;?>" maxlength="30" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Sub Departement</label>
							<input type="text" class="form-control input-sm" id="nmsubdept" style="text-transform:uppercase" name="nmsubdept" placeholder="Sub Department" value="<?php echo trim($dtlmst['nmsubdept']) ;?>" maxlength="30" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Jabatan</label>
							<input type="text" class="form-control input-sm" id="nmjabatan" style="text-transform:uppercase" name="nmjabatan" placeholder="Nama Jabatan" maxlength="30" value="<?php echo trim($dtlmst['nmjabatan']) ;?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Level Jabatan</label>
							<input type="text" class="form-control input-sm" id="nmlvljabatan" style="text-transform:uppercase" name="nmlvljabatan" placeholder="Nama Level Jabatan"  value="<?php echo trim($dtlmst['nmlvljabatan']) ;?>" maxlength="50" readonly>
						  </div>
						</div> <!---- col 1 -->
						<div class='col-sm-4'>
                        <div class="form-group">
                            <label for="inputsm">Dokumen Surat Ijin Mengemudi</label>
                            <input type="text" class="form-control input-sm " id="docsim" name="docsim" style="text-transform:uppercase" value="<?php echo trim($dtlmst['docsim']);?>" placeholder="Nomor SIM" maxlength="50" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Type Surat Ijin</label>
                            <input type="text" class="form-control input-sm " id="typesim" name="typesim" style="text-transform:uppercase" value="<?php echo trim($dtlmst['typesim']);?>" placeholder="Nomor SIM" maxlength="50" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Tanggal Pembuatan SIM</label>
                            <input type="text" class="form-control input-sm tgl" id="datecreate" style="text-transform:uppercase" name="datecreate"  value="<?php if (empty($dtlmst['datecreate'])){ echo ''; } else { echo date('d-m-Y', strtotime(trim($dtlmst['datecreate']))); } ?>" placeholder="Create Sim" data-date-format="dd-mm-yyyy" required>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Tanggal Expired SIM</label>
                            <input type="text" class="form-control input-sm tgl" id="expsim" style="text-transform:uppercase" name="expsim"  value="<?php  if (empty($dtlmst['expsim'])){ echo ''; } else { echo date('d-m-Y', strtotime(trim($dtlmst['expsim']))); } ?>" placeholder="Expired Sim" data-date-format="dd-mm-yyyy" required>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Total Biaya SIM</label>
                            <input type="text" class="form-control input-sm ratakanan currency" id="ttlvalue" name="ttlvalue" value="<?php echo trim($dtlmst['ttlvalue']);?>"  placeholder="Total Biaya Pengurusan SIM" maxlength="12" required>
                        </div>
                        </div> <!---- col 2 -->
						<div class='col-sm-4'>	
                        <div class="form-group">
                            <label for="inputsm">Nama Pengurus SIM (Optional)</label>
                            <input type="text" class="form-control input-sm" id="namapengurus" style="text-transform:uppercase" name="namapengurus" placeholder="Nama Pengurus Kir" value="<?php echo trim($dtlmst['namapengurus']);?>" maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Contact Pengurus SIM(Optional)</label>
                            <input type="number" class="form-control input-sm" id="contactpengurus" style="text-transform:uppercase" name="contactpengurus" placeholder="Contact Pengurus Kir"  value="<?php echo trim($dtlmst['contactpengurus']);?>" maxlength="25">
                        </div>
						<div class="form-group">
							<label for="inputsm">Keterangan</label>
							<textarea  class="textarea" name="description" placeholder="Keterangan"   maxlength ="159" style="text-transform: uppercase; width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($dtlmst['description']);?></textarea>
                        </div>
						</div> 
					</div>
					</div>
					<div class="box-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
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