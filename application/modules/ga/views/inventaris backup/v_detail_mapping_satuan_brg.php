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
		<a href="<?php echo site_url('ga/inventaris/master_mapping_satuan_brg');?>" class="btn btn-default  btn-sm" title="Kembali Ke Halaman Utama"> Kembali </a>
	</div>
	
</div>	
</br>

<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-header">
			 <legend><?php echo 'MAPPING SATUAN BARANG PERBANDINGAN DENGAN SATUAN DASAR ';?></legend>							
			</div><!-- /.box-header -->	
	  <div class="box-body">
		<form role="form" action="#" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 	<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			 	<input type="hidden" class="form-control input-sm" id="id" name="id" value="<?php echo trim($dtl_map['id']); ?>">
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm ch"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option  <?php if (trim($dtl_map['kdgroup'])==trim($sc->kdgroup)){ echo 'selected';} ?>   value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
					<input type="hidden" class="form-control input-sm" name="kdgroup" id="kdgroup" value="<?php echo trim($dtl_map['kdgroup']); ?>">
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm ch"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($dtl_map['kdsubgroup'])==trim($sc->kdsubgroup)){ echo 'selected';} ?>   value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
					<input type="hidden" class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" value="<?php echo trim($dtl_map['kdsubgroup']); ?>">
			</div>
			<div class="form-group ">
				<label for="inputsm">Kode Stock Barang</label>		
			
					<select class="form-control input-sm ch"  disabled readonly>
					 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
					  <?php foreach($list_mstbarang as $sc){?>					  
					  <option   <?php if (trim($dtl_map['stockcode'])==trim($sc->nodok)){ echo 'selected';} ?>   value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang);?></option>						  
					  <?php }?>
					</select>
				<input type="hidden" class="form-control input-sm" name="kdbarang" id="kdbarang"  value="<?php echo trim($dtl_map['stockcode']); ?>">
			</div>
			
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
			<div class="row">
				<label  class="col-sm-4">SATUAN DASAR BARANG</label>	
				<div class="col-sm-4">  
					<input type="text" class="form-control input-sm" id="qtykecil" name="qtykecil" value="<?php echo trim($dtl_map['qtykecil']); ?>" readonly>
				</div>
				<div class="col-sm-4"> 
					<input type="text" class="form-control input-sm" id="nmsatkecil" name="nmsatkecil"  value="<?php echo trim($dtl_map['nmsatkecil']); ?>" readonly>
				</div>
				<input type="hidden" class="form-control input-sm" id="satkecil" name="satkecil"  value="<?php echo trim($dtl_map['satkecil']); ?>" readonly>
			</div>	
			</div>
			<div class="form-group">
			<div class="row">
				<label  class="col-sm-4">SATUAN KONVERSI</label>
				<div class="col-sm-8">  
					<select class="form-control input-sm " name="satbesar" id="satbesar"  disabled readonly>
					 <option value="">---PILIH SATUAN PERMINTAAN MAPPING BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option  <?php if (trim($dtl_map['satbesar'])==trim($sc->kdtrx)){ echo 'selected';} ?>  value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
					</select>
				</div>
			</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label  class="col-sm-4">QTY KONVERSI</label>	
					<div class="col-sm-4">  
						<input type="text" class="form-control input-sm" id="qty" name="qty" value="<?php echo trim($dtl_map['qty']); ?>" disabled readonly>
					</div>
					<div class="col-sm-4"> 
						<input type="text" class="form-control input-sm" id="nmsatkecil" name="nmsatkecil"  value="<?php echo trim($dtl_map['nmsatkecil']); ?>" readonly>
					</div>
					
				</div>	
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="text-transform: uppercase; width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" disabled readonly><?php echo trim($dtl_map['keterangan']);?></textarea>
			  </div>
			</div> 
		</div>


	  </div>
	  
		</div><!-- /.box -->
	</form>
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