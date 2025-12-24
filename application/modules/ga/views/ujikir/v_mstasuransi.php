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
			
			//	$("#tglrange").daterangepicker(); 
            });
					
			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
<?php echo $message;?>
	
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
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Asuransi</a></li> 
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
									<th>KODE ASURANSI</th>
									<th>NAMA ASURANSI</th>
									<th>HOLD</th>
									<th>KETERANGAN</th>
									<th>AKSI</th>		
								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_mstasuransi as $row): $no++;?>
						<tr>
							
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo $row->kdasuransi;?></td>
							<td><?php echo $row->nmasuransi;?></td>
							<td><?php echo $row->kdhold;?></td>
							<td><?php echo $row->keterangan;?></td>
							<td width="15%">
									<a href="<?php echo site_url('ga/kendaraan/form_msubasuransi').'/'.trim($row->kdasuransi);?>" class="btn btn-info  btn-sm">
										<i class="fa fa-edit"></i> DETAIL
									</a>
									<?php if (trim($row->rowdtl)==0) { ?>
									<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->kdasuransi);?>" class="btn btn-success  btn-sm">
										<i class="fa fa-edit"></i> EDIT
									</a>
									<br>
									<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->kdasuransi);?>" class="btn btn-danger  btn-sm">
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

<!-- Modal Input ASURANSI -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM INPUT MASTER ASURANSI</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstasuransi');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>
				<input type="text" class="form-control input-sm" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" placeholder="INPUT KODE ASURANSI" maxlength="12" required>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			  </div>
			  <div class="form-group">
				<label for="inputsm">NAMA GROUP ASURANSI</label>
				<input type="text" class="form-control input-sm" id="nmasuransi" style="text-transform:uppercase" name="nmasuransi" placeholder="INPUT NAMA ASURANSI" maxlength="30" required>
			  </div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>	
			<!--div class="form-group">
				<label for="inputsm">Kode Cabang</label>	
					<select class="form-control input-sm" name="kdcabang" id="kdcabang"  required>
					<option value="">---PILIH KANTOR CABANG WILAYAH--</option> 
					<?php foreach($list_kanwil as $sc){?>					  
					  <option value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div-->
			  
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="kdhold" id="kdhold">
					 <option value="NO">TIDAK</option> 
					 <option value="YES">YA</option> 
					</select>
			  </div>
			<!--div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>	
					<select class="form-control input-sm" name="kdasuransi" id="kdasuransi">
					<option value="">-----PILIH ASURANSI JIKA ADA-----</option> 
					  <?php foreach($list_asuransi as $sc){?>					  
					  <option value="<?php echo trim($sc->kdasuransi);?>" ><?php echo trim($sc->kdasuransi).' || '.trim($sc->nmasuransi);?></option>						  
					  <?php }?>
					</select>
			</div--->
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan" maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ; text-transform:uppercase"></textarea>
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

<!-- EDIT KENDARAAN -->
<?php foreach ($list_mstasuransi as $ls){ ?>
<div class="modal fade" id="ED<?php echo trim($ls->kdasuransi);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DATA ASURANSI </h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstasuransi');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->kdasuransi);?>" class="form-control input-sm" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" placeholder="INPUT KODE ASURANSI.." maxlength="12" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			  </div>
			  <div class="form-group">
				<label for="inputsm">NAMA GROUP ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->nmasuransi);?>" class="form-control input-sm" id="nmasuransi" style="text-transform:uppercase" name="nmasuransi" placeholder="INPUT NAMA ASURANSI..." maxlength="30" >
			  </div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>	
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="kdhold" id="kdhold">
					 <option  <?php if (trim($ls->kdhold)=='NO') { echo 'selected';}?> value="NO">TIDAK</option> 
					 <option  <?php if (trim($ls->kdhold)=='YES') { echo 'selected';}?> value="YES">YA</option> 
					</select>
			  </div>

			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan..." maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ; text-transform:uppercase"><?php echo trim($ls->keterangan);?></textarea>
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

<!-- HAPUS ASURANSI -->
<?php foreach ($list_mstasuransi as $ls){ ?>
<div class="modal fade" id="DEL<?php echo trim($ls->kdasuransi);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DATA ASURANSI </h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstasuransi');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->kdasuransi);?>" class="form-control input-sm" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" placeholder="INPUT KODE ASURANSI.." maxlength="12" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
			  </div>
			  <div class="form-group">
				<label for="inputsm">NAMA GROUP ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->nmasuransi);?>" class="form-control input-sm" id="nmasuransi" style="text-transform:uppercase" name="nmasuransi" placeholder="INPUT NAMA ASURANSI..." maxlength="30" readonly>
			  </div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>	

			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="kdhold" id="kdhold"  readonly disabled>
					 <option  <?php if (trim($ls->kdhold)=='NO') { echo 'selected';}?> value="NO">TIDAK</option> 
					 <option  <?php if (trim($ls->kdhold)=='YES') { echo 'selected';}?> value="YES">YA</option> 
					</select>
			  </div>

			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan..." maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ; text-transform:uppercase"  readonly disabled><?php echo trim($ls->keterangan);?></textarea>
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