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
			////	$("#satkecil").selectize();
				
				$("#kdsubgroup").chained("#kdgroup");
				$("#kdbarang").chained("#kdsubgroup");
				$("#edkdsubgroup").chained("#edkdgroup");
				
			//	$("#tglrange").daterangepicker(); 
			
			
						$('.ch').change(function(){
							var param1=$('#kdgroup').val().trim();
							var param2=$('#kdsubgroup').val().trim();
							var param3=$('#kdbarang').val().trim();
							console.log(param1+param2+param3);
							  $.ajax({
								url : "<?php echo site_url('ga/inventaris/js_master_stock')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3,
								type: "GET",
								dataType: "JSON",
								success: function(data)
								{		
									
									console.log(data.satkecil);
									console.log(data.nmsatkecil);
									console.log("<?php echo site_url('ga/inventaris/js_master_stock')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3)
									//$('[name="onhand"]').val(data.conhand);                        
									$('[name="satkecil"]').val(data.satkecil);                                                                              
									$('[name="nmsatkecil"]').val(data.nmsatkecil);                                                                              
									$('[name="qtykecil"]').val(data.qtykecilmap);                                                                              
								
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							}); 
					});
            });
					
			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
<?php echo $message; ?>	
	
<div class="row">
	<div class="col-sm-3">
		<a href="<?php echo site_url('ga/inventaris/form_mstbarang');?>" class="btn btn-default  btn-sm" title="Kembali Ke Halaman Utama"> Kembali </a>
	</div>
	
</div>	
</br>

<div class="row">
	<div class="col-xs-12">                            
	<div class="box">
	  <div class="box-header">
	  </div>
	  <div class="box-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mstbarang');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <div class="form-group">
				<label for="inputsm">Nomor Dokumen Barang</label>
				<input type="text" value="<?php echo trim($dtl_mstbarang['nodok']);?>" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" placeholder="Dokumen Barang" maxlength="50" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="HAPUS">
			  </div>
			  <div class="form-group">
				<label for="inputsm">NAMA BARANG</label>
				<input type="text" value="<?php echo trim($dtl_mstbarang['nmbarang']);?>"  class="form-control input-sm" id="nmbarang" style="text-transform:uppercase" name="nmbarang" placeholder="Inputkan Nama Barang" maxlength="50" readonly>
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm" name="kdgroup" id="edkdgroup"  readonly disabled>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($dtl_mstbarang['kdgroup'])==trim($sc->kdgroup)){ echo 'selected';} ?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="edkdsubgroup" readonly disabled>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option <?php if (trim($dtl_mstbarang['kdsubgroup'])==trim($sc->kdsubgroup)){ echo 'selected';} ?> value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Type Barang</label>	
					<select class="form-control input-sm" name="typebarang" id="typebarang" readonly>
					<option value="">---PILIH TYPE BARANG--</option> 
					<option <?php if (trim($dtl_mstbarang['typebarang'])=='LJ'){ echo 'selected';} ?> value="LJ">LJ || BARANG BERKELANJUTAN </option> 
					<option <?php if (trim($dtl_mstbarang['typebarang'])=='SP'){ echo 'selected';} ?> value="SP">SP || BARANG SEKALI PAKAI </option> 
					</select>
			</div>	
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">SATUAN DASAR BARANG</label>	
					<select class="form-control input-sm satkecil" name="satkecil" id="satkecil" readonly disabled>
					 <option value="">---PILIH SATUAN DASAR BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option <?php if (trim($dtl_mstbarang['satkecil'])==trim($sc->kdtrx)){ echo 'selected';} ?>  value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="hold_item" id="hold_item" readonly>
					 <option <?php if (trim($dtl_mstbarang['hold_item'])=='NO'){ echo 'selected';} ?>  value="NO">TIDAK</option> 
					 <option <?php if (trim($dtl_mstbarang['hold_item'])=='YES'){ echo 'selected';} ?>  value="YES">YA</option> 
					</select>
			  </div>

			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" readonly disabled><?php echo trim($dtl_mstbarang['keterangan']);?></textarea>
			  </div>
			</div> 
		</div>
		
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-danger">Hapus</button>
		</div>
		</form>
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