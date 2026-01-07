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
									<th>KODE SATUAN</th>
									<th>JENIS SATUAN</th>
									<th>AKSI</th>		
								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_mastersatuan as $row): $no++;?>
						<tr>
							
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo $row->kdtrx;?></td>
							<td><?php echo $row->uraian;?></td>
							<td width="22%">
									<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->kdtrx).trim($row->jenistrx);?>" class="btn btn-default  btn-sm">
										<i class="fa fa-edit"></i> DETAIL
									</a>
									<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->kdtrx).trim($row->jenistrx);?>" class="btn btn-success  btn-sm">
										<i class="fa fa-edit"></i> EDIT
									</a>
									<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->kdtrx).trim($row->jenistrx);?>" class="btn btn-danger  btn-sm">
										<i class="fa fa-edit"></i> HAPUS
									</a>
									
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
		<h4 class="modal-title" id="myModalLabel">Input Master Satuan</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_master_satuan_brg');?>" method="post">
		<div class='row'>
			<div class='col-sm-12'>	
			 	<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			<div class="form-group">
				<label for="inputsm">KODE SATUAN BARANG</label>	
				<input type="text" class="form-control input-sm" id="kdtrx" name="kdtrx" required>
			</div>
			<div class="form-group">
				<label for="inputsm">DESKRIPSI SATUAN</label>
				<textarea  class="textarea" name="uraian" placeholder="Deskripsi Satuan Barang"   maxlength ="100" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
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
<?php foreach ($list_mastersatuan as $ls){ ?>
<div class="modal fade" id="ED<?php echo trim($ls->kdtrx).trim($ls->jenistrx);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT DATA KENDARAAN</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mapping_satuan_brg');?>" method="post">
		<div class='row'>
			<div class='col-sm-12'>	
			 	<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			<div class="form-group">
				<label for="inputsm">KODE SATUAN BARANG</label>	
				<input type="text" class="form-control input-sm" value="<?php echo $dtl['kdtrx'];?>" id="kdtrx" name="kdtrx" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">DESKRIPSI SATUAN</label>
				<textarea  class="textarea" name="uraian" placeholder="Deskripsi Satuan Barang"   maxlength ="100" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo $dtl['uraian'];?></textarea>
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
<?php } ?>
<!-- END KENDARAAN --->


<!-- DETAIL MASTER BARANG  -->
<?php foreach ($list_mastersatuan as $ls){ ?>
<div class="modal fade" id="DTL<?php echo trim($ls->kdtrx).trim($ls->jenistrx);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL MAPPING BARANG & ATK</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mapping_satuan_brg');?>" method="post">
		<div class='row'>
			<div class='col-sm-12'>	
			 	<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
			<div class="form-group">
				<label for="inputsm">KODE SATUAN BARANG</label>	
				<input type="text" class="form-control input-sm" value="<?php echo $dtl['kdtrx'];?>" id="kdtrx" name="kdtrx" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">DESKRIPSI SATUAN</label>
				<textarea  class="textarea" name="uraian" placeholder="Deskripsi Satuan Barang"   maxlength ="100" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" DISABLED READONLY><?php echo $dtl['uraian'];?></textarea>
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
<?php foreach ($list_mastersatuan as $ls){ ?>
<div class="modal fade" id="DEL<?php echo trim($ls->kdtrx).trim($ls->jenistrx);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL MAPPING BARANG & ATK</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mapping_satuan_brg');?>" method="post">
		<div class='row'>
			<div class='col-sm-12'>	
			 	<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
			<div class="form-group">
				<label for="inputsm">KODE SATUAN BARANG</label>	
				<input type="text" class="form-control input-sm" value="<?php echo $dtl['kdtrx'];?>" id="kdtrx" name="kdtrx" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">DESKRIPSI SATUAN</label>
				<textarea  class="textarea" name="uraian" placeholder="Deskripsi Satuan Barang"   maxlength ="100" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" DISABLED READONLY><?php echo $dtl['uraian'];?></textarea>
			  </div>
			</div> 
		</div>
		</div>
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-danger">Delete</button>
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