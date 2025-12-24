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


<legend><?php echo $title.' ( '.$kdasuransi.' ) '.$dtlmst['nmasuransi'];?></legend>
<?php echo $message; ?>
<!--a href="<?php echo site_url('ga/kendaraan/form_mstasuransi').'/'.$kdasuransi;?>" class="btn btn-default  btn-sm"> KEMBALI </a--->

<div class="row">
	<div class="col-sm-1">
		<a href="<?php echo site_url('ga/kendaraan/form_mstasuransi');?>" class="btn btn-default" style="margin:10px; color:#000000;" > KEMBALI </a>
	</div>
	<div class="col-sm-1">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li-->
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Sub Asuransi</a></li> 
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
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
								<tr>											
									<th width="2%">NO.</th>
									<th>KODE SUB ASURANSI</th>
									<th>NAMA ASURANSI</th>
									<th>KOTA</th>
									<th>ALAMAT</th>
									<th>HOLD</th>
									<th>KETERANGAN</th>
									<th>AKSI</th>		
								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_msubasuransi as $row): $no++;?>
						<tr>
							
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo $row->kdsubasuransi;?></td>
							<td><?php echo $row->nmsubasuransi;?></td>
							<td><?php echo $row->city;?></td>
							<td><?php echo $row->addsubasuransi;?></td>
							<td><?php echo $row->kdhold;?></td>
							<td><?php echo $row->keterangan;?></td>
							<td width="8%">
									<a title="DETAIL CABANG ASURANSI" href="#" data-toggle="modal" data-target="#DTL<?php echo str_replace('.','',trim($row->kdsubasuransi));?>" class="btn btn-default  btn-sm">
										<i class="fa fa-bars"></i>
									</a>
									<a title="UBAH NAMA DATA CABANG ASURANSI" href="#" data-toggle="modal" data-target="#ED<?php echo str_replace('.','',trim($row->kdsubasuransi));?>" class="btn btn-success  btn-sm">
										<i class="fa fa-gear"></i>
									</a>
                                <?PHP /*
									<a title="HAPUS DATA ASURANSI" href="#" data-toggle="modal" data-target="#DEL<?php echo str_replace('.','',trim($row->kdsubasuransi));?>" class="btn btn-danger  btn-sm">
										<i class="fa fa-trash-o"></i>
									</a>
								*/ ?>
							</td>
						</tr>
						<?php endforeach;?>	
							</tbody>		
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>

<!-- Modal Input Bengkel -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM INPUT SUB ASURANSI</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstsubasuransi');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>
				<input type="text" class="form-control input-sm" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" value="<?php echo $kdasuransi;?>" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			  </div>
			<!--div class="form-group">
				<label for="inputsm">KODE SUB ASURANSI</label>
				<input type="text" class="form-control input-sm" id="kdsubasuransi" name="kdsubasuransi" style="text-transform:uppercase" placeholder="INPUT KODE SUB ASURANSI.." maxlength="12" required>
			</div--->
			<div class="form-group">
				<label for="inputsm">NAMA ASURANSI</label>
				<input type="text" class="form-control input-sm" id="nmsubasuransi" name="nmsubasuransi" style="text-transform:uppercase" placeholder="NAMA ASURANSI" maxlength="80" required>
			</div>
			<div class="form-group">
				<label for="inputsm">KOTA ASURANSI</label>
				<input type="text" class="form-control input-sm" id="city" name="city" style="text-transform:uppercase" placeholder="KOTA ASURANSI" maxlength="20" required>
			</div>
			<div class="form-group">
				<label for="inputsm">ALAMAT ASURANSI</label>
				<input type="text" class="form-control input-sm" id="addsubasuransi" name="addsubasuransi" style="text-transform:uppercase" placeholder="ALAMAT LENGKAP" >
			</div>
			  <div class="form-group">
				<label for="inputsm">TELEPON 1</label>
				<input type="number" class="form-control input-sm" id="phone1" style="text-transform:uppercase" name="phone1" placeholder="PHONE 1 " maxlength="30" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">TELEPON 2</label>
				<input type="number" class="form-control input-sm" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="PHONE 2 " maxlength="30" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">FAX</label>
				<input type="number" class="form-control input-sm" id="fax" style="text-transform:uppercase" name="fax" placeholder="FAX " maxlength="30" >
			  </div>

			</div> <!---- col 1 -->
			<div class='col-sm-6'>	
			  <div class="form-group">
				<label for="inputsm">EMAIL</label>
				<input type="email" class="form-control input-sm" id="email" style="text-transform:uppercase" name="email" placeholder="EMAIL" maxlength="30" >
			  </div>
			<div class="form-group">
				<label for="inputsm">KODE CABANG TERDEKAT</label>
					<select class="form-control input-sm" name="kdcabang" id="kdcabang"  required>
					<option value="">---PILIH KANTOR CABANG WILAYAH--</option> 
					<?php foreach($list_kanwil as $sc){?>					  
					  <option value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div>
			<div class="form-group">
			<label for="inputsm">HOLD</label>	
				<select class="form-control input-sm" name="kdhold" id="kdhold">
				 <option value="NO">TIDAK</option> 
				 <option value="YES">YA</option> 
				</select>
			</div>
			<div class="form-group">
				<label for="inputsm">KETERANGAN</label>
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
<?php foreach ($list_msubasuransi as $ls){ ?>
<div class="modal fade" id="ED<?php echo str_replace('.','',trim($ls->kdsubasuransi));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DATA ASURANSI </h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstsubasuransi');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>
				<input type="text" class="form-control input-sm" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" value="<?php echo $kdasuransi;?>" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			  </div>
			 <div class="form-group">
				<label for="inputsm">KODE SUB ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->kdsubasuransi);?>" class="form-control input-sm" id="kdsubasuransi" name="kdsubasuransi" style="text-transform:uppercase" placeholder="INPUT KODE SUB ASURANSI.." maxlength="12" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">NAMA ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->nmsubasuransi);?>"  class="form-control input-sm" id="nmsubasuransi" name="nmsubasuransi" style="text-transform:uppercase" placeholder="NAMA ASURANSI" maxlength="20" required>
			</div>
			<div class="form-group">
				<label for="inputsm">KOTA ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->city);?>"  class="form-control input-sm" id="city" name="city" style="text-transform:uppercase" placeholder="KOTA ASURANSI" maxlength="20" required>
			</div>
			<div class="form-group">
				<label for="inputsm">ADDRESS ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->addsubasuransi);?>"  class="form-control input-sm" id="addsubasuransi" name="addsubasuransi" style="text-transform:uppercase" placeholder="ALAMAT LENGKAP" >
			</div>
			  <div class="form-group">
				<label for="inputsm">PHONE 1</label>
				<input type="number" value="<?php echo trim($ls->phone1);?>"  class="form-control input-sm" id="phone1" style="text-transform:uppercase" name="phone1" placeholder="PHONE 1 " maxlength="30" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">PHONE 2</label>
				<input type="number" value="<?php echo trim($ls->phone2);?>"  class="form-control input-sm" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="PHONE 2 " maxlength="30" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">FAX</label>
				<input type="number" value="<?php echo trim($ls->fax);?>"  class="form-control input-sm" id="fax" style="text-transform:uppercase" name="fax" placeholder="FAX " maxlength="30" >
			  </div>

			</div> <!---- col 1 -->
			<div class='col-sm-6'>	
			  <div class="form-group">
				<label for="inputsm">EMAIL</label>
				<input type="email" value="<?php echo trim($ls->email);?>"  class="form-control input-sm" id="email" style="text-transform:uppercase" name="email" placeholder="EMAIL" maxlength="30" >
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Cabang</label>	
					<select class="form-control input-sm" name="kdcabang" id="kdcabang"  required>
					<option <?php if (trim($ls->kdcabang)=='') { echo 'selected';}?>  value="">---PILIH KANTOR CABANG WILAYAH--</option> 
					<?php foreach($list_kanwil as $sc){?>					  
					  <option <?php if (trim($ls->kdcabang)==trim($sc->kdcabang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div>

			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="kdhold" id="kdhold">
					 <option <?php if (trim($ls->kdhold)=='NO') { echo 'selected';}?>  value="NO">TIDAK</option> 
					 <option <?php if (trim($ls->kdhold)=='YES') { echo 'selected';}?>  value="YES">YA</option> 
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
<!-- END INPUT SUB ASURANSI --->

<!-- DETAIL SUBASURANSI -->
<?php foreach ($list_msubasuransi as $ls){ ?>
<div class="modal fade" id="DTL<?php echo str_replace('.','',trim($ls->kdsubasuransi));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DATA ASURANSI </h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstsubasuransi');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>
				<input type="text" class="form-control input-sm" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" value="<?php echo $kdasuransi;?>" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
			  </div>
			 <div class="form-group">
				<label for="inputsm">KODE SUB ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->kdsubasuransi);?>" class="form-control input-sm" id="kdsubasuransi" name="kdsubasuransi" style="text-transform:uppercase" placeholder="INPUT KODE SUB ASURANSI.." maxlength="12" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">NAMA ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->nmsubasuransi);?>"  class="form-control input-sm" id="nmsubasuransi" name="nmsubasuransi" style="text-transform:uppercase" placeholder="NAMA ASURANSI" maxlength="20" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">KOTA ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->city);?>"  class="form-control input-sm" id="city" name="city" style="text-transform:uppercase" placeholder="KOTA ASURANSI" maxlength="20" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">ADDRESS ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->addsubasuransi);?>"  class="form-control input-sm" id="addsubasuransi" name="addsubasuransi" style="text-transform:uppercase" placeholder="ALAMAT LENGKAP" readonly >
			</div>
			  <div class="form-group">
				<label for="inputsm">PHONE 1</label>
				<input type="number" value="<?php echo trim($ls->phone1);?>"  class="form-control input-sm" id="phone1" style="text-transform:uppercase" name="phone1" placeholder="PHONE 1 " maxlength="30" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">PHONE 2</label>
				<input type="number" value="<?php echo trim($ls->phone2);?>"  class="form-control input-sm" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="PHONE 2 " maxlength="30" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">FAX</label>
				<input type="number" value="<?php echo trim($ls->fax);?>"  class="form-control input-sm" id="fax" style="text-transform:uppercase" name="fax" placeholder="FAX " maxlength="30" readonly>
			  </div>

			</div> <!---- col 1 -->
			<div class='col-sm-6'>	
			  <div class="form-group">
				<label for="inputsm">EMAIL</label>
				<input type="email" value="<?php echo trim($ls->email);?>"  class="form-control input-sm" id="email" style="text-transform:uppercase" name="email" placeholder="EMAIL" maxlength="30" readonly>
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Cabang</label>	
					<select class="form-control input-sm" name="kdcabang" id="kdcabang"  readonly disabled>
					<option <?php if (trim($ls->kdcabang)=='') { echo 'selected';}?>  value="">---PILIH KANTOR CABANG WILAYAH--</option> 
					<?php foreach($list_kanwil as $sc){?>					  
					  <option <?php if (trim($ls->kdcabang)==trim($sc->kdcabang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="kdhold" id="kdhold"  readonly disabled>
					 <option <?php if (trim($ls->kdhold)=='NO') { echo 'selected';}?>  value="NO">TIDAK</option> 
					 <option <?php if (trim($ls->kdhold)=='YES') { echo 'selected';}?>  value="YES">YA</option> 
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
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan..." maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ; text-transform:uppercase"  readonly disabled><?php echo trim($ls->keterangan);?></textarea>
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
<!-- END SUBASURANSI --->

<!-- HAPUS ASURANSI -->
<?php foreach ($list_msubasuransi as $ls){ ?>
<div class="modal fade" id="DEL<?php echo str_replace('.','',trim($ls->kdsubasuransi));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DATA ASURANSI </h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstsubasuransi');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>
				<input type="text" class="form-control input-sm" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" value="<?php echo $kdasuransi;?>" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
			  </div>
			 <div class="form-group">
				<label for="inputsm">KODE SUB ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->kdsubasuransi);?>" class="form-control input-sm" id="kdsubasuransi" name="kdsubasuransi" style="text-transform:uppercase" placeholder="INPUT KODE SUB ASURANSI.." maxlength="12" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">NAMA ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->nmsubasuransi);?>"  class="form-control input-sm" id="nmsubasuransi" name="nmsubasuransi" style="text-transform:uppercase" placeholder="NAMA ASURANSI" maxlength="20" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">KOTA ASURANSI</label>
				<input type="text" value="<?php echo trim($ls->city);?>"  class="form-control input-sm" id="city" name="city" style="text-transform:uppercase" placeholder="KOTA ASURANSI" maxlength="20" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">ADDRESS ASURANSI</label>
				<input type="number" value="<?php echo trim($ls->addsubasuransi);?>"  class="form-control input-sm" id="addsubasuransi" name="addsubasuransi" style="text-transform:uppercase" placeholder="ALAMAT LENGKAP" readonly >
			</div>
			  <div class="form-group">
				<label for="inputsm">PHONE 1</label>
				<input type="number" value="<?php echo trim($ls->phone1);?>"  class="form-control input-sm" id="phone1" style="text-transform:uppercase" name="phone1" placeholder="PHONE 1 " maxlength="30" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">PHONE 2</label>
				<input type="number" value="<?php echo trim($ls->phone2);?>"  class="form-control input-sm" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="PHONE 2 " maxlength="30" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">FAX</label>
				<input type="number" value="<?php echo trim($ls->fax);?>"  class="form-control input-sm" id="fax" style="text-transform:uppercase" name="fax" placeholder="FAX " maxlength="30" readonly>
			  </div>

			</div> <!---- col 1 -->
			<div class='col-sm-6'>	
			  <div class="form-group">
				<label for="inputsm">EMAIL</label>
				<input type="email" value="<?php echo trim($ls->email);?>"  class="form-control input-sm" id="email" style="text-transform:uppercase" name="email" placeholder="EMAIL" maxlength="30" readonly>
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Cabang</label>	
					<select class="form-control input-sm" name="kdcabang" id="kdcabang"  readonly disabled>
					<option <?php if (trim($ls->kdcabang)=='') { echo 'selected';}?>  value="">---PILIH KANTOR CABANG WILAYAH--</option> 
					<?php foreach($list_kanwil as $sc){?>					  
					  <option <?php if (trim($ls->kdcabang)==trim($sc->kdcabang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="kdhold" id="kdhold"  readonly disabled>
					 <option <?php if (trim($ls->kdhold)=='NO') { echo 'selected';}?>  value="NO">TIDAK</option> 
					 <option <?php if (trim($ls->kdhold)=='YES') { echo 'selected';}?>  value="YES">YA</option> 
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