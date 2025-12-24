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
			$("#kdsubgroup").chained("#kdgroup");	
			$("#kdbarang").chained("#kdsubgroup");
			$("#olduserpakai").chained("#kdbarang");	
			$("#oldkdgudang").chained("#olduserpakai");	
			$("#kdgudang").chained("#userpakai");
			
			$("#kdsubgrouped").chained("#kdgrouped");	
			$("#kdbaranged").chained("#kdsubgrouped");
			$("#olduserpakaied").chained("#kdbaranged");	
			$("#oldkdgudanged").chained("#olduserpakaied");	
			$("#kdgudanged").chained("#userpakaied");
			
			
			
			$("#userpakai").selectize();		
			$(".userpakai").selectize();				
			//	$("#tglrange").daterangepicker(); 
            });
					
			//empty string means no validation error

</script>
<!--div class="pull-right">Versi: <?php echo $version; ?></div-->
</br>


<legend><?php echo $title;?></legend>

<!-- EDIT SK MEMO -->
	
<a href="<?php echo site_url('ga/mtsasset/flist_skfinal/PxwoOnoandoI');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
	<div class="box">
	  <div class="box-body">
		<form role="form" action="<?php echo site_url('ga/mtsasset/save_mtsasset');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			<input type="hidden" class="form-control input-sm" id="nodok" value="<?php echo trim($dtl['nodok']);?>" name="nodok">
			<div class="form-group">
				<label for="inputsm">Kode Group ASSET</label>	
					<select class="form-control input-sm " name="kdgroup" id="kdgrouped"  required>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($dtl['kdgroup'])==trim($sc->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group ASSET</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgrouped" required>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($dtl['kdsubgroup'])==trim($sc->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih ASSET</label>	
					<select class="form-control input-sm " name="kdbarang"  id="kdbaranged" required>
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option <?php if (trim($dtl['kdbarang'])==trim($sc->nodok)) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Lama</label>	
					<select class="form-control input-sm " name="olduserpakai" id="olduserpakaied" readonly>
					<?php foreach($list_barang as $sc){?>					  
					  <option  <?php if (trim($dtl['olduserpakai'])==trim($sc->userpakai)) { echo 'selected';}?>  value="<?php echo trim($sc->userpakai);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->userpakai).' || '.trim($sc->nmuserpakai);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Barang</label>	
					<select class="form-control input-sm " name="oldkdgudang" id="oldkdgudanged"   readonly>
						<?php foreach($list_barang as $sc){?>					  
						  <option  <?php if (trim($dtl['oldkdgudang'])==trim($sc->kdgudang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgudang);?>" class="<?php echo trim($sc->userpakai);?>" ><?php echo trim($sc->kdgudang);?></option>						  
						<?php }?>
					</select>
			</div>			
			<div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" id="tglev" name="tglev" value="<?php echo date('d-m-Y', strtotime(trim($dtl['tglev'])));?>" data-date-format="dd-mm-yyyy">
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">User Pengguna Baru</label>
					<select class="form-control input-sm userpakai" name="userpakai" id="userpakaied">
					<option value="">---Pilih User Pengguna Baru--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option  <?php if (trim($dtl['userpakai'])==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Wilayah</label>	
					<select class="form-control input-sm kdgudang" name="kdgudang" id="kdgudanged" readonly >
					<?php foreach($list_karyawan as $sc){?>					  
					  <option  <?php if (trim($dtl['kdgudang'])==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>"  class="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->kdcabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Input NO SK</label>
				<input type="text" class="form-control input-sm" id="nosk" style="text-transform:uppercase"  value="<?php echo trim($dtl['nosk']);?>"  name="nosk" placeholder="Input Nomor SK"  maxlength="20" >
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($dtl['keterangan']);?></textarea>
			  </div>
			</div> 
		</div>
       </div>	
	</div> 

	<div class="row">
		<div class='col-sm-12'>		   
			<button type="submit" class="btn btn-primary pull-right">Submit</button>
			</form>
		</div>	
	</div>  

<!-- -->

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