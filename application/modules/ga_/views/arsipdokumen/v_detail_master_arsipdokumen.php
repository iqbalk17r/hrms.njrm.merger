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
<div><a href="<?php echo site_url('ga/arsipdokumen/form_master_arsip');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
	
</div>	
</br>


<div class="row">
        <div class='col-sm-6'>
            <div class="form-group">
                <label for="inputsm">KODE ARSIP ASLI</label>
                <input type="text" class="form-control input-sm"  style="text-transform:uppercase" id="archives_id" style="text-transform:uppercase" name="archives_id" placeholder="Inputkan Kode Dokumen Arsip" maxlength="30" value="<?php echo $dtlmst['archives_id'];?>" disabled>
            </div>
            <div class="form-group">
                <label for="inputsm">NAMA ARSIP</label>
                <input type="text" class="form-control input-sm"  style="text-transform:uppercase" id="archives_name" style="text-transform:uppercase" name="archives_name" placeholder="Inputkan Nama Dokumen Arsip" maxlength="30" value="<?php echo $dtlmst['archives_name'];?>" disabled>
                <input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
            </div>
            <div class="form-group">
                <label for="inputsm">Lokasi Arsip</label>
                <select class="form-control input-sm" name="loccode" id="loccode" disabled>
                    <option value="">---PILIH LOKASI ARSIP---</option>
                    <?php foreach($list_gudang as $sc){?>
                        <option <?php if (trim($dtlmst['loccode'])==trim($sc->loccode)) { echo 'selected'; };?> ><?php echo trim($sc->loccode).' || '.trim($sc->locaname);?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="inputsm">Kode Group</label>
                <select class="form-control input-sm" name="kdgroup" id="kdgroup" disabled>
                    <option value="">---PILIH KODE GROUP--</option>
                    <?php foreach($list_scgroup as $sc){?>

                        <option <?php if (trim($dtlmst['kdgroup'])==trim($sc->kdgroup)) { echo 'selected'; };?> ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="inputsm">Kode Sub Group</label>
                <select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" disabled>
                    <option value="">---PILIH KODE SUB GROUP--</option>
                    <?php foreach($list_scsubgroup as $sc){?>
                        <option <?php if (trim($dtlmst['kdsubgroup'])==trim($sc->kdsubgroup)) { echo 'selected'; };?> ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>
                    <?php }?>
                </select>
            </div>
        </div> <!---- col 1 -->
        <div class='col-sm-6'>
            <div class="form-group">
                <label for="inputsm">Nama Pemilik Arsip</label>
                <input type="text" class="form-control input-sm"  style="text-transform:uppercase" id="archives_own" style="text-transform:uppercase" name="archives_own" placeholder="Inputkan Nama Pemilik Arsip" maxlength="30" value="<?php echo $dtlmst['archives_own'];?>" disabled>
            </div>
            <div class="form-group">
                <label for="inputsm">Tanggal Pembaharuan Arsip</label>
                <input type="text" class="form-control input-sm tgl" id="archives_exp" style="text-transform:uppercase" name="archives_exp"   placeholder="Exp Archive" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y',strtotime($dtlmst['archives_exp']));?>" disabled>
            </div>
            <div class="form-group">
                <label for="inputsm">HOLD</label>
                <select class="form-control input-sm" name="chold" id="chold" disabled>
                    <option  <?php if (trim($dtlmst['chold'])=='NO') { echo 'selected'; };?> value="NO">TIDAK</option>
                    <option  <?php if (trim($dtlmst['chold'])=='NO') { echo 'selected'; };?>  value="YES">YA</option>
                </select>
            </div>

            <div class="form-group">
                <label for="inputsm">Keterangan</label>
                <textarea  class="textarea" name="description" placeholder="Keterangan"  maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ; text-transform: uppercase" disabled>  <?php echo $dtlmst['description'];?> </textarea>
            </div>
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