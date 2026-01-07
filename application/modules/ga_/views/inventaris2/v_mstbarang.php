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
				$("#satkecil").selectize();
				
				$("#kdsubgroup").chained("#kdgroup");
				$("#edkdsubgroup").chained("#edkdgroup");
				
			//	$("#tglrange").daterangepicker(); 
            });
					
			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
	
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
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Barang</a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("trans/cuti_karyawan/listkaryawan_iss")?>">Input Cuti</a></li-->
				  <!--li role="presentation" class="divider"></li>	
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Haduh Us</a></li---> 
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
	
</div>	
</br>
<div class="col-sm-12">

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
												<th>NAMA GROUP</th>
												<th>NAMA SUBGROUP</th>
												<th>ID BARANG</th>
												<th>NAMA BARANG</th>
												<th>TIPE BARANG</th>
												<th>HOLD ITEM</th>
												<th>AKSI</th>		
											</tr>
								</thead>
										<tbody>
										<?php $no=0; foreach($list_mstbarang as $row): $no++;?>
									<tr>
										
										<td width="2%"><?php echo $no;?></td>
										<td><?php echo $row->nmgroup;?></td>
										<td><?php echo $row->nmsubgroup;?></td>
										<td><?php echo $row->nodok;?></td>
										<td><?php echo $row->nmbarang;?></td>
										<td><?php echo $row->nmtypebarang;?></td>
										<td><?php echo $row->hold_item;?></td>
										<td width="22%">
												<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm">
													<i class="fa fa-edit"></i> DETAIL
												</a>
											<?php if (trim($row->rowstock)==0) { ?>
												<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->nodok);?>" class="btn btn-success  btn-sm">
													<i class="fa fa-edit"></i> EDIT
												</a>
												<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->nodok);?>" class="btn btn-danger  btn-sm">
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
</div>
<!-- Modal Input Master Barang ATK -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER BARANG</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mstbarang');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <!--div class="form-group">
				<label for="inputsm">Nomor Dokumen Barang</label>
				<input type="text" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" placeholder="Dokumen Barang" maxlength="50" required>
				
			  </div--->
			  <div class="form-group">
				<label for="inputsm">NAMA BARANG</label>
				<input type="text" class="form-control input-sm" id="nmbarang" style="text-transform:uppercase" name="nmbarang" placeholder="Inputkan Nama Barang" maxlength="50" required>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup" required>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup">
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Type Barang</label>	
					<select class="form-control input-sm" name="typebarang" id="typebarang" >
					<option value="">---PILIH TYPE BARANG--</option> 
					<option value="LJ">LJ || BARANG BERKELANJUTAN </option> 
					<option value="SP">SP || BARANG SEKALI PAKAI </option> 
					</select>
			</div>	
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">SATUAN DASAR BARANG</label>	
					<select class="form-control input-sm satkecil" name="satkecil" id="satkecil" required>
					 <option value="">---PILIH SATUAN DASAR BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="hold_item" id="hold_item">
					 <option value="NO">TIDAK</option> 
					 <option value="YES">YA</option> 
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
<?php foreach ($list_mstbarang as $ls){ ?>
<div class="modal fade" id="ED<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT DATA KENDARAAN</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mstbarang');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <div class="form-group">
				<label for="inputsm">Nomor Dokumen Barang</label>
				<input type="text" value="<?php echo trim($ls->nodok);?>" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" placeholder="Dokumen Barang" maxlength="50" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			  </div>
			  <div class="form-group">
				<label for="inputsm">NAMA BARANG</label>
				<input type="text" value="<?php echo trim($ls->nmbarang);?>"  class="form-control input-sm" id="nmbarang" style="text-transform:uppercase" name="nmbarang" placeholder="Inputkan Nama Barang" maxlength="50" required>
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm" name="kdgroup" id="edkdgroup" required>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)){ echo 'selected';} ?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="edkdsubgroup" required>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)){ echo 'selected';} ?> value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Type Barang</label>	
					<select class="form-control input-sm" name="typebarang" id="typebarang" >
					<option value="">---PILIH TYPE BARANG--</option> 
					<option <?php if (trim($ls->typebarang)=='LJ'){ echo 'selected';} ?> value="LJ">LJ || BARANG BERKELANJUTAN </option> 
					<option <?php if (trim($ls->typebarang)=='SP'){ echo 'selected';} ?> value="SP">SP || BARANG SEKALI PAKAI </option> 
					</select>
			</div>	
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">SATUAN DASAR BARANG</label>	
					<select class="form-control input-sm satkecil" name="satkecil" id="satkecil" required>
					 <option value="">---PILIH SATUAN DASAR BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option <?php if (trim($ls->satkecil)==trim($sc->kdtrx)){ echo 'selected';} ?>  value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="hold_item" id="hold_item">
					 <option <?php if (trim($ls->hold_item)=='NO'){ echo 'selected';} ?>  value="NO">TIDAK</option> 
					 <option <?php if (trim($ls->hold_item)=='YES'){ echo 'selected';} ?>  value="YES">YA</option> 
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
<?php foreach ($list_mstbarang as $ls){ ?>
<div class="modal fade" id="DTL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL DETAIL BARANG & ATK</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mstbarang');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <div class="form-group">
				<label for="inputsm">Nomor Dokumen Barang</label>
				<input type="text" value="<?php echo trim($ls->nodok);?>" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" placeholder="Dokumen Barang" maxlength="50" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
			  </div>
			  <div class="form-group">
				<label for="inputsm">NAMA BARANG</label>
				<input type="text" value="<?php echo trim($ls->nmbarang);?>"  class="form-control input-sm" id="nmbarang" style="text-transform:uppercase" name="nmbarang" placeholder="Inputkan Nama Barang" maxlength="50" readonly>
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm" name="kdgroup" id="edkdgroup" readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)){ echo 'selected';} ?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="edkdsubgroup" readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)){ echo 'selected';} ?> value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Type Barang</label>	
					<select class="form-control input-sm" name="typebarang" id="typebarang" readonly>
					<option value="">---PILIH TYPE BARANG--</option> 
					<option <?php if (trim($ls->typebarang)=='LJ'){ echo 'selected';} ?> value="LJ">LJ || BARANG BERKELANJUTAN </option> 
					<option <?php if (trim($ls->typebarang)=='SP'){ echo 'selected';} ?> value="SP">SP || BARANG SEKALI PAKAI </option> 
					</select>
			</div>	
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">SATUAN DASAR BARANG</label>	
					<select class="form-control input-sm " name="satkecil"  disabled readonly>
					 <option value="">---PILIH SATUAN DASAR BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option <?php if (trim($ls->satkecil)==trim($sc->kdtrx)){ echo 'selected';} ?>  value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="hold_item" id="hold_item" readonly>
					 <option <?php if (trim($ls->hold_item)=='NO'){ echo 'selected';} ?>  value="NO">TIDAK</option> 
					 <option <?php if (trim($ls->hold_item)=='YES'){ echo 'selected';} ?>  value="YES">YA</option> 
					</select>
			  </div>

			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" disabled readonly><?php echo trim($ls->keterangan);?></textarea>
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
<?php foreach ($list_mstbarang as $ls){ ?>
<div class="modal fade" id="DEL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DELETE BARANG & ATK</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mstbarang');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <div class="form-group">
				<label for="inputsm">Nomor Dokumen Barang</label>
				<input type="text" value="<?php echo trim($ls->nodok);?>" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" placeholder="Dokumen Barang" maxlength="25" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
			  </div>
			  <div class="form-group">
				<label for="inputsm">NAMA BARANG</label>
				<input type="text" value="<?php echo trim($ls->nmbarang);?>"  class="form-control input-sm" id="nmbarang" style="text-transform:uppercase" name="nmbarang" placeholder="Inputkan Nama Barang" maxlength="50" readonly>
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm" name="kdgroup" id="edkdgroup" readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)){ echo 'selected';} ?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="edkdsubgroup" readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)){ echo 'selected';} ?> value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Type Barang</label>	
					<select class="form-control input-sm" name="typebarang" id="typebarang" readonly>
					<option value="">---PILIH TYPE BARANG--</option> 
					<option <?php if (trim($ls->typebarang)=='LJ'){ echo 'selected';} ?> value="LJ">LJ || BARANG BERKELANJUTAN </option> 
					<option <?php if (trim($ls->typebarang)=='SP'){ echo 'selected';} ?> value="SP">SP || BARANG SEKALI PAKAI </option> 
					</select>
			</div>	
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">SATUAN DASAR BARANG</label>	
					<select class="form-control input-sm " name="satkecil"  disabled readonly>
					 <option value="">---PILIH SATUAN DASAR BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option <?php if (trim($ls->satkecil)==trim($sc->kdtrx)){ echo 'selected';} ?>  value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="hold_item" id="hold_item" readonly>
					 <option <?php if (trim($ls->hold_item)=='NO'){ echo 'selected';} ?>  value="NO">TIDAK</option> 
					 <option <?php if (trim($ls->hold_item)=='YES'){ echo 'selected';} ?>  value="YES">YA</option> 
					</select>
			  </div>

			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" disabled readonly><?php echo trim($ls->keterangan);?></textarea>
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