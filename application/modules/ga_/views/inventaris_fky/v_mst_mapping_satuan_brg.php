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
	<!--div class="col-sm-3">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Kendaraan</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div--->
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Mapping Satuan</a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("trans/cuti_karyawan/listkaryawan_iss")?>">Input Cuti</a></li-->
				  <!--li role="presentation" class="divider"></li>	
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Haduh Us</a></li---> 
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
	
</div>	
</br>

<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-header">
			 <legend><?php echo $title;?></legend>							
			</div><!-- /.box-header -->	
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
								<tr>											
									<th width="2%">NO.</th>
									<th>KD GROUP</th>
									<th>KD SUB GROUP</th>
									<th>ID BARANG</th>
									<th>NAMA BARANG</th>
									<th>SATUAN KECIL</th>
									<th>SATUAN BESAR</th>
									<th>AKSI</th>		
								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_mapping as $row): $no++;?>
						<tr>
							
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo $row->kdgroup;?></td>
							<td><?php echo $row->kdsubgroup;?></td>
							<td><?php echo $row->stockcode;?></td>
							<td><?php echo $row->nmbarang;?></td>
							<td><?php echo $row->nmsatkecil;?></td>
							<td><?php echo $row->nmsatbesar;?></td>
							<td width="25%">
									<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->id);?>" class="btn btn-default  btn-sm">
										<i class="fa fa-edit"></i> DETAIL
									</a>
								<?php if (trim($row->referensinya)==0) { ?>
									<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->id);?>" class="btn btn-success  btn-sm">
										<i class="fa fa-edit"></i> EDIT
									</a>
									<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->id);?>" class="btn btn-danger  btn-sm">
										<i class="fa fa-edit"></i> HAPUS
									</a>
								<?php } ?>
							</td>
						</tr>
						<?php endforeach;?>	
							</tbody>		
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>

<!-- Modal Input Master Mapping ATK -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Input Mapping Satuan</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mapping_satuan_brg');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 	<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			 <div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm ch" name="kdgroup" id="kdgroup" required>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm ch" name="kdsubgroup" id="kdsubgroup">
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group ">
				<label for="inputsm">Kode Stock Barang</label>		
			
					<select class="form-control input-sm ch" name="kdbarang" id="kdbarang">
					 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
					  <?php foreach($list_mstbarang as $sc){?>					  
					  <option  value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang);?></option>						  
					  <?php }?>
					</select>
				
			</div>
			
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
			<div class="row">
				<label  class="col-sm-4">SATUAN DASAR BARANG</label>	
				<div class="col-sm-4">  
					<input type="text" class="form-control input-sm" id="qtykecil" name="qtykecil" readonly>
				</div>
				<div class="col-sm-4"> 
					<input type="text" class="form-control input-sm" id="nmsatkecil" name="nmsatkecil" readonly>
				</div>
				<input type="hidden" class="form-control input-sm" id="satkecil" name="satkecil" readonly>
			</div>	
			</div>
			<div class="form-group">
				<label for="inputsm">QTY SATUAN DASAR DARI SATUAN BESAR</label>	
				<input type="number" class="form-control input-sm" id="qty" name="qty" required>
			</div>
			<div class="form-group">
				<label for="inputsm">SATUAN BESAR</label>	
					<select class="form-control input-sm " name="satbesar" id="satbesar" required>
					 <option value="">---PILIH SATUAN PERMINTAAN MAPPING BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
			  </div>
			</div> 
		</div>
		</div>
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Submit</button>
      </div>
		</form>
		
		</div>  
	  </div>
	</div>
		
<!-- -->

<!-- EDIT MASTER BARANG ATK -->
<?php foreach ($list_mapping as $ls){ ?>
<div class="modal fade" id="ED<?php echo trim($ls->id);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT DATA KENDARAAN</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mapping_satuan_brg');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 	<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			 	<input type="hidden" class="form-control input-sm" id="id" name="id" value="<?php echo trim($ls->id); ?>">
			 <div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm ch"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)){ echo 'selected';} ?>   value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
					<input type="hidden" class="form-control input-sm" name="kdgroup" id="kdgroup" value="<?php echo trim($ls->kdgroup); ?>">
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm ch"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)){ echo 'selected';} ?>   value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
					<input type="hidden" class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" value="<?php echo trim($ls->kdsubgroup); ?>">
			</div>
			<div class="form-group ">
				<label for="inputsm">Kode Stock Barang</label>		
			
					<select class="form-control input-sm ch"  disabled readonly>
					 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
					  <?php foreach($list_mstbarang as $sc){?>					  
					  <option   <?php if (trim($ls->stockcode)==trim($sc->nodok)){ echo 'selected';} ?>   value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang);?></option>						  
					  <?php }?>
					</select>
				<input type="hidden" class="form-control input-sm" name="kdbarang" id="kdbarang"  value="<?php echo trim($ls->stockcode); ?>">
			</div>
			
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
			<div class="row">
				<label  class="col-sm-4">SATUAN DASAR BARANG</label>	
				<div class="col-sm-4">  
					<input type="text" class="form-control input-sm" id="qtykecil" name="qtykecil" value="<?php echo trim($ls->qtykecil); ?>" readonly>
				</div>
				<div class="col-sm-4"> 
					<input type="text" class="form-control input-sm" id="nmsatkecil" name="nmsatkecil"  value="<?php echo trim($ls->nmsatkecil); ?>" readonly>
				</div>
				<input type="hidden" class="form-control input-sm" id="satkecil" name="satkecil"  value="<?php echo trim($ls->satkecil); ?>" readonly>
			</div>	
			</div>
			<div class="form-group">
				<label for="inputsm">QTY SATUAN DASAR DARI SATUAN BESAR</label>	
				<input type="number" class="form-control input-sm" id="qty" name="qty"  value="<?php echo trim($ls->qty); ?>"  required>
			</div>
			<div class="form-group">
				<label for="inputsm">SATUAN BESAR</label>	
					<select class="form-control input-sm " name="satbesar" id="satbesar" required>
					 <option value="">---PILIH SATUAN PERMINTAAN MAPPING BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option  <?php if (trim($ls->satbesar)==trim($sc->kdtrx)){ echo 'selected';} ?>  value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($ls->keterangan);?></textarea>
			  </div>
			</div> 
		</div>
		</div>
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Submit</button>
		</div>
		</form>
	  </div>
	</div>
  </div>
</div>									
<?php } ?>
<!-- END KENDARAAN --->


<!-- DETAIL MASTER BARANG  -->
<?php foreach ($list_mapping as $ls){ ?>
<div class="modal fade" id="DTL<?php echo trim($ls->id);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL MAPPING BARANG & ATK</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mapping_satuan_brg');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 	<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
			 	<input type="hidden" class="form-control input-sm" id="id" name="id" value="<?php echo trim($ls->id); ?>">
			 <div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm ch"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)){ echo 'selected';} ?>   value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
					<input type="hidden" class="form-control input-sm" name="kdgroup" id="kdgroup" value="<?php echo trim($ls->kdgroup); ?>">
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm ch"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)){ echo 'selected';} ?>   value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
					<input type="hidden" class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" value="<?php echo trim($ls->kdsubgroup); ?>">
			</div>
			<div class="form-group ">
				<label for="inputsm">Kode Stock Barang</label>		
			
					<select class="form-control input-sm ch"  disabled readonly>
					 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
					  <?php foreach($list_mstbarang as $sc){?>					  
					  <option   <?php if (trim($ls->stockcode)==trim($sc->nodok)){ echo 'selected';} ?>   value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang);?></option>						  
					  <?php }?>
					</select>
				<input type="hidden" class="form-control input-sm" name="kdbarang" id="kdbarang"  value="<?php echo trim($ls->stockcode); ?>">
			</div>
			
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
			<div class="row">
				<label  class="col-sm-4">SATUAN DASAR BARANG</label>	
				<div class="col-sm-4">  
					<input type="text" class="form-control input-sm" id="qtykecil" name="qtykecil"  value="<?php echo trim($ls->qtykecil); ?>" readonly>
				</div>
				<div class="col-sm-4"> 
					<input type="text" class="form-control input-sm" id="nmsatkecil" name="nmsatkecil"  value="<?php echo trim($ls->nmsatkecil); ?>" readonly>
				</div>
				<input type="hidden" class="form-control input-sm" id="satkecil" name="satkecil"  value="<?php echo trim($ls->satkecil); ?>" readonly>
			</div>	
			</div>	
			<div class="form-group">
				<label for="inputsm">QTY SATUAN DASAR DARI SATUAN BESAR</label>	
				<input type="number" class="form-control input-sm" id="qty" name="qty"  value="<?php echo trim($ls->qty); ?>"  readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">SATUAN BESAR</label>	
					<select class="form-control input-sm " name="satbesar" id="satbesar"  disabled readonly>
					 <option value="">---PILIH SATUAN PERMINTAAN MAPPING BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option  <?php if (trim($ls->satbesar)==trim($sc->kdtrx)){ echo 'selected';} ?>  value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  disabled readonly><?php echo trim($ls->keterangan);?></textarea>
			  </div>
			</div> 
		</div>
		</div>
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</form>
	  </div>
</div>
</div>									
<?php } ?>
<!---- DETAIL END --------->

<!-- DELETE MASTER BARANG  -->
<?php foreach ($list_mapping as $ls){ ?>
<div class="modal fade" id="DEL<?php echo trim($ls->id);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DELETE BARANG & ATK</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mapping_satuan_brg');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 	<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
			 	<input type="hidden" class="form-control input-sm" id="id" name="id" value="<?php echo trim($ls->id); ?>">
			 <div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm ch"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)){ echo 'selected';} ?>   value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
					<input type="hidden" class="form-control input-sm" name="kdgroup" id="kdgroup" value="<?php echo trim($ls->kdgroup); ?>">
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm ch"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)){ echo 'selected';} ?>   value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
					<input type="hidden" class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" value="<?php echo trim($ls->kdsubgroup); ?>">
			</div>
			<div class="form-group ">
				<label for="inputsm">Kode Stock Barang</label>		
			
					<select class="form-control input-sm ch"  disabled readonly>
					 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
					  <?php foreach($list_mstbarang as $sc){?>					  
					  <option   <?php if (trim($ls->stockcode)==trim($sc->nodok)){ echo 'selected';} ?>   value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang);?></option>						  
					  <?php }?>
					</select>
				<input type="hidden" class="form-control input-sm" name="kdbarang" id="kdbarang"  value="<?php echo trim($ls->stockcode); ?>">
			</div>
			
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
			<div class="row">
				<label  class="col-sm-4">SATUAN DASAR BARANG</label>	
				<div class="col-sm-4">  
					<input type="text" class="form-control input-sm" id="qtykecil" name="qtykecil"  value="<?php echo trim($ls->qtykecil); ?>" readonly>
				</div>
				<div class="col-sm-4"> 
					<input type="text" class="form-control input-sm" id="nmsatkecil" name="nmsatkecil"  value="<?php echo trim($ls->nmsatkecil); ?>" readonly>
				</div>
				<input type="hidden" class="form-control input-sm" id="satkecil" name="satkecil"  value="<?php echo trim($ls->satkecil); ?>" readonly>
			</div>	
			</div>	
			<div class="form-group">
				<label for="inputsm">QTY SATUAN DASAR DARI SATUAN BESAR</label>	
				<input type="number" class="form-control input-sm" id="qty" name="qty"  value="<?php echo trim($ls->qty); ?>"  readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">SATUAN BESAR</label>	
					<select class="form-control input-sm " name="satbesar" id="satbesar"  disabled readonly>
					 <option value="">---PILIH SATUAN PERMINTAAN MAPPING BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option  <?php if (trim($ls->satbesar)==trim($sc->kdtrx)){ echo 'selected';} ?>  value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  disabled readonly><?php echo trim($ls->keterangan);?></textarea>
			  </div>
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
<?php } ?>
<!-- END KENDARAAN --->



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