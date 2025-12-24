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
				$("#stockcode").chained("#kdsubgroup");	
				$("#userpakai").chained("#stockcode");	
				$(".stockcode").chained(".kdgroup");	
				$(".userpakai").chained(".stockcode");
				$(".pengguna").hide();
			//	$("#tglrange").daterangepicker(); 
			
			$("#usermohon").selectize();
	/*		
			$('.pengguna').hide();
			$('#userpakai').change(function(){
												$('.pengguna').hide();
												
												if ($(this).val() != '' || $(this).val() != null) {
													$('.pengguna').show(); 
												}
											
											});*/
            });

			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
	
                         
<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-content">
	  <div class="box-header">
		<button type="button" class="close" data-dismiss="box"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="box-title" id="myModalLabel">INPUT PERAWATAN ASSET</h4>
	  </div>
	  <div class="box-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_perawatanasset');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			<div class="form-group">
				<label for="inputsm">Skema Aset</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup" required>
					 <option value="">- PILIH SKEMA ASET -</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Sub Skema Aset</label>	
					<select class="form-control input-sm " name="kdsubgroup" id="kdsubgroup" required>
					 <option  value="">- PILIH SUB SKEMA ASET -</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Aset/Barang</label>	
					<select class="form-control input-sm" name="stockcode" id="stockcode" required>
					 <option value="">- PILIH ASET/BARANG -</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			 <!--div class="form-group">
				<label for="inputsm">Input Deskripsi Barang</label>
				<input type="text" class="form-control input-sm" id="descbarang" style="text-transform:uppercase" name="descbarang" placeholder="Deskripsi Barang"  maxlength="30" required>
			</div--->
			<div class="form-group pengguna">
				<label for="inputsm">Karyawan Pengguna</label>	
					<select class="form-control input-sm" name="userpakai" id="userpakai" readonly disabled>
					  <?php foreach($list_karyawanbarang as $sc){?>					  
					  <option value="<?php echo trim($sc->nik);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
					  <?php }?>
					</select>
			</div>
			
			<div class="form-group">
				<label for="inputsm">Karyawan Pemohon Perawatan</label>	
					<select class="form-control input-sm" name="usermohon" id="usermohon" required>
					 <option value="">- PILIH KARYAWAN PEMOHON PERAWATAN -</option> 
					  <?php foreach($list_karyawanparam as $sc){?>					  
					  <option value="<?php echo trim($sc->nik);?>"><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Jenis Perawatan</label>	
					<select class="form-control input-sm" name="jnsperawatan" id="jnsperawatan"  required>
					<option value="">- PILIH JENIS PERAWATAN -</option> 
					<option value="BK"><?php echo 'BK'.' || '.'BERKALA';?></option>						  
					<option value="IS"><?php echo 'IS'.' || '.'ISIDENTIL';?></option>						  
					
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keluhan/Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">Tanggal Dokumen</label>
				<input type="text" class="form-control input-sm tgl" id="tgldok" name="tgldok"  data-date-format="dd-mm-yyyy"  required> <!--value=?php echo date('d-m-Y', strtotime(trim($ls->tglmasuk)));?-->
			</div>
			<div class="form-group">
				<label for="inputsm">Kilo Meter Awal (KM)</label>
				<input type="text" class="form-control input-sm" id="km_awal" name="km_awal"  placeholder="0" > <!--value=?php echo date('d-m-Y', strtotime(trim($ls->tglmasuk)));?-->
			</div>
			<div class="form-group">
				<label for="inputsm">Kilo Meter Akhir (KM)</label>
				<input type="text" class="form-control input-sm" id="km_akhir" name="km_akhir"  placeholder="0" > <!--value=?php echo date('d-m-Y', strtotime(trim($ls->tglmasuk)));?-->
			</div>
			<div class="form-group">
				<label for="inputsm">Penanganan Keluhan</label>
				<textarea  class="textarea" name="laporanpk" placeholder="Penanganan Keluhan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
			</div>
			<div class="form-group">
				<label for="inputsm">Penggantian Spare Part</label>
				<textarea  class="textarea" name="laporanpsp" placeholder="Penggantian Spare Part"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
			</div>
			<!--div class="form-group">
				<label for="inputsm">Kondisi Setelah Penanganan</label>
				<textarea  class="textarea" name="laporanksp" placeholder="Kondisi Setelah Penanganan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
			</div--->
			</div> 
		</div>
		</div>
		<div class="box-footer">
        <!--button type="button" class="btn btn-default" data-dismiss="modal">KEMBALI</button-->
		<a href="<?php echo site_url('ga/inventaris/form_perawatan');?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> Kembali</a>
		<button type="submit" class="btn btn-primary pull-right">Submit</button>
      </div>
		</form>
		
		</div>  
	</div><!-- /.box-body -->
	</div><!-- /.box-body -->
</div><!-- /.box-body -->
</div><!-- /.box-body -->



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