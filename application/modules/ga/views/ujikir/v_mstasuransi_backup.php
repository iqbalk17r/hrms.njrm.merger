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
			
				$(".kodekotakab").chained(".kodeprov");	
				$(".kodekec").chained(".kodekotakab");	
				
				$(".edkodekotakab").chained(".edkodeprov");	
				$(".edkodekec").chained(".edkodekotakab");
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
								<th width="2%">No.</th>
								<th>KODE ASURANSI</th>
								<th>NAMA ASURANSI</th>
								<!--th>KODE GROUP</th-->
								<th>ALAMAT</th>
								<th>PHONE 1</th>
								<th>PHONE 2</th>
								<th>AKSI</th>		
							</tr>
				</thead>
						<tbody>
						<?php $no=0; foreach($list_mstasuransi as $row): $no++;?>
					<tr>
						
						<td width="2%"><?php echo $no;?></td>
						<td><?php echo $row->kdasuransi;?></td>
						<td><?php echo $row->nmasuransi;?></td>
						<!--td><?php echo $row->kdgroup;?></td-->
						<td><?php echo $row->addasuransi;?></td>
						<td><?php echo $row->phone1;?></td>
						<td><?php echo $row->phone2;?></td>
						<td width="15%">
								<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->kdasuransi);?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> DETAIL
								</a>
								<?php if (trim($row->rowdtl)==0) {?>
								<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->kdasuransi);?>" class="btn btn-success  btn-sm">
									<i class="fa fa-edit"></i> EDIT
								</a>
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

<!-- Modal Input Skema Barang -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">MASTER ASURANSI</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstasuransi');?>" method="post">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="besaran">Kode Asuransi</label>
						<input type="text" class="form-control input-sm" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" placeholder="NOMOR DOKUMEN ASURANSI"  maxlength="12" required>
						<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
					</div>
					<div class="form-group">
						<label for="besaran">Nama Asuransi</label>
						<input type="text" class="form-control input-sm" id="nmasuransi" style="text-transform:uppercase" name="nmasuransi" placeholder="NAMA ASURANSI"  required>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Provinsi</label>	
							<select class="form-control input-sm kodeprov" name="kodeprov" id="kodeprov"  required>
							 <option value="">---PILIH KODE || PROVINSI--</option> 
							  <?php foreach($list_opt_prov as $sc){?>					  
							  <option value="<?php echo trim($sc->kodeprov);?>" ><?php echo trim($sc->kodeprov).' || '.trim($sc->namaprov);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Kota Kabupaten</label>	
							<select class="form-control input-sm kodekotakab" name="kodekotakab" id="kodekotakab"  required>
							 <option value="">---PILIH KODE || KOTA KABUPATEN--</option> 
							  <?php foreach($list_opt_kotakab as $sc){?>					  
							  <option value="<?php echo trim($sc->kodekotakab);?>" class="<?php echo trim($sc->kodeprov);?>"><?php echo trim($sc->kodekotakab).' || '.trim($sc->namakotakab);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Kecamatan</label>	
							<select class="form-control input-sm kodekec" name="kodekec" id="namakec">
							 <option value="">---PILIH KODE || KECAMATAN--</option> 
							  <?php foreach($list_opt_kec as $sc){?>					  
							  <option value="<?php echo trim($sc->kodekec);?>" class="<?php echo trim($sc->kodekotakab);?>" ><?php echo trim($sc->kodekec).' || '.trim($sc->namakec);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="besaran">Alamat Asuransi</label>
						<input type="text" class="form-control input-sm" id="addasuransi" style="text-transform:uppercase" name="addasuransi" placeholder="ALAMAT ASURANSI"  required>
					</div>
					
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputsm">Pilih Kantor Cabang</label>	
							<select class="form-control input-sm " name="kdcabang" id="kdcabang"  required>
							 <option value="">---PILIH KODE || CABANG--</option> 
							  <?php foreach($list_kanwil as $sc){?>					  
							  <option  value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="besaran">Phone1 Asuransi</label>
						<input type="text" class="form-control input-sm" id="phone1" style="text-transform:uppercase" name="phone1" placeholder="PHONE 1 ASURANSI"  required>
					</div>
					<div class="form-group">
						<label for="besaran">Phone2 Asuransi</label>
						<input type="text" class="form-control input-sm" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="PHONE 2 ASURANSI"  required>
					</div>
					<div class="form-group">
					<label for="inputsm">HOLD</label>	
						<select class="form-control input-sm" name="kdhold" id="kdhold"  required>
						 <option value="NO">TIDAK</option> 
						 <option value="YES">YA</option> 
						</select>
					</div>
					<div class="form-group">
						<label for="besaran">Keterangan</label>
						<textarea  class="textarea input-sm" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
					</div>
				</div>
			</div>
		</div>  
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
		</form>
	  </div>
  </div>
</div>			
<!-- -->

<!-- EDIT ASURANSI -->
<?php foreach ($list_mstasuransi as $ls){ ?>
<div class="modal fade" id="ED<?php echo trim($ls->kdasuransi);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT MASTER ASURANSI</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstasuransi');?>" method="post">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="besaran">Kode Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->kdasuransi); ?>" class="form-control input-sm" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" placeholder="NOMOR DOKUMEN ASURANSI"  maxlength="12" readonly>
						<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
					</div>
					<div class="form-group">
						<label for="besaran">Nama Asuransi</label>
						<input type="text" value="<?php echo trim($ls->nmasuransi); ?>" class="form-control input-sm" id="nmasuransi" style="text-transform:uppercase" name="nmasuransi" placeholder="NAMA ASURANSI"  required>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Provinsi</label>	
							<select class="form-control input-sm edkodeprov" name="kodeprov" id="kodeprov"  required>
							 <option value="">---PILIH KODE || PROVINSI--</option> 
							  <?php foreach($list_opt_prov as $sc){?>					  
							  <option  <?php if (trim($ls->kodeprov)==trim($sc->kodeprov)) { echo 'selected';}?> value="<?php echo trim($sc->kodeprov);?>" ><?php echo trim($sc->kodeprov).' || '.trim($sc->namaprov);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Kota Kabupaten</label>	
							<select class="form-control input-sm edkodekotakab" name="kodekotakab" id="kodekotakab"  required>
							 <option value="">---PILIH KODE || KOTA KABUPATEN--</option> 
							  <?php foreach($list_opt_kotakab as $sc){?>					  
							  <option  <?php if (trim($ls->kodekotakab)==trim($sc->kodekotakab)) { echo 'selected';}?> value="<?php echo trim($sc->kodekotakab);?>" class="<?php echo trim($sc->kodeprov);?>"><?php echo trim($sc->kodekotakab).' || '.trim($sc->namakotakab);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Kecamatan</label>	
							<select class="form-control input-sm edkodekec" name="kodekec" id="kodekec"  required>
							 <option value="">---PILIH KODE || KECAMATAN--</option> 
							  <?php foreach($list_opt_kec as $sc){?>					  
							  <option  <?php if (trim($ls->kodekec)==trim($sc->kodekec)) { echo 'selected';}?> value="<?php echo trim($sc->kodekec);?>" class="<?php echo trim($sc->kodekotakab);?>" ><?php echo trim($sc->kodekec).' || '.trim($sc->namakec);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="besaran">Alamat Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->addasuransi); ?>" class="form-control input-sm" id="addasuransi" style="text-transform:uppercase" name="addasuransi" placeholder="ALAMAT ASURANSI"  required>
					</div>
					
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputsm">Pilih Kantor Cabang</label>	
							<select class="form-control input-sm " name="kdcabang" id="kdcabang" required>
							 <option value="">---PILIH KODE || CABANG--</option> 
							  <?php foreach($list_kanwil as $sc){?>					  
							  <option  <?php if (trim($ls->kdcabang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="besaran">Phone1 Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->phone1); ?>" class="form-control input-sm" id="phone1" style="text-transform:uppercase" name="phone1" placeholder="PHONE 1 ASURANSI" required>
					</div>
					<div class="form-group">
						<label for="besaran">Phone2 Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->phone2); ?>"class="form-control input-sm" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="PHONE 2 ASURANSI" required>
					</div>
					<div class="form-group">
					<label for="inputsm">HOLD</label>	
						<select class="form-control input-sm" name="kdhold" id="kdhold" required>
						 <option <?php if (trim($ls->kdhold)=='NO') { echo 'selected';}?> value="NO">TIDAK</option> 
						 <option <?php if (trim($ls->kdhold)=='YES') { echo 'selected';}?> value="YES">YA</option> 
						</select>
					</div>
					<div class="form-group">
						<label for="besaran">Keterangan</label>
						<textarea  class="textarea input-sm" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($ls->keterangan); ?></textarea>
					</div>
				</div>
			</div>
		</div> 
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
		</form>
  </div>
</div>
</div>									
<?php } ?>
<!-- END ASURANSI --->

<!-- DETAIL ASURANSI -->
<?php foreach ($list_mstasuransi as $ls){ ?>
<div class="modal fade" id="DTL<?php echo trim($ls->kdasuransi);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">APAKAH ANDA YAKIN AKAN HAPUS DATA INI</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstasuransi');?>" method="post">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="besaran">Kode Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->kdasuransi); ?>" class="form-control input-sm" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" placeholder="NOMOR DOKUMEN ASURANSI"  maxlength="12" readonly>
						<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
					</div>
					<div class="form-group">
						<label for="besaran">Nama Asuransi</label>
						<input type="text" value="<?php echo trim($ls->nmasuransi); ?>" class="form-control input-sm" id="nmasuransi" style="text-transform:uppercase" name="nmasuransi" placeholder="NAMA ASURANSI" readonly>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Provinsi</label>	
							<select class="form-control input-sm " name="kodeprov" id="kodeprov" readonly disabled>
							 <option value="">---PILIH KODE || PROVINSI--</option> 
							  <?php foreach($list_opt_prov as $sc){?>					  
							  <option  <?php if (trim($ls->kodeprov)==trim($sc->kodeprov)) { echo 'selected';}?> value="<?php echo trim($sc->kodeprov);?>" ><?php echo trim($sc->kodeprov).' || '.trim($sc->namaprov);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Kota Kabupaten</label>	
							<select class="form-control input-sm " name="kodekotakab" id="kodekotakab" readonly disabled>
							 <option value="">---PILIH KODE || KOTA KABUPATEN--</option> 
							  <?php foreach($list_opt_kotakab as $sc){?>					  
							  <option  <?php if (trim($ls->kodekotakab)==trim($sc->kodekotakab)) { echo 'selected';}?> value="<?php echo trim($sc->kodekotakab);?>" class="<?php echo trim($sc->kodeprov);?>"><?php echo trim($sc->kodekotakab).' || '.trim($sc->namakotakab);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Kecamatan</label>	
							<select class="form-control input-sm " name="kodekec" id="kodekec" readonly disabled>
							 <option value="">---PILIH KODE || KECAMATAN--</option> 
							  <?php foreach($list_opt_kec as $sc){?>					  
							  <option  <?php if (trim($ls->kodekec)==trim($sc->kodekec)) { echo 'selected';}?> value="<?php echo trim($sc->kodekec);?>" class="<?php echo trim($sc->kodekotakab);?>" ><?php echo trim($sc->kodekec).' || '.trim($sc->namakec);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="besaran">Alamat Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->addasuransi); ?>" class="form-control input-sm" id="addasuransi" style="text-transform:uppercase" name="addasuransi" placeholder="ALAMAT ASURANSI" readonly>
					</div>
					
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputsm">Pilih Kantor Cabang</label>	
							<select class="form-control input-sm " name="kdcabang" id="kdcabang" readonly disabled>
							 <option value="">---PILIH KODE || CABANG--</option> 
							  <?php foreach($list_kanwil as $sc){?>					  
							  <option  <?php if (trim($ls->kdcabang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="besaran">Phone1 Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->phone1); ?>" class="form-control input-sm" id="phone1" style="text-transform:uppercase" name="phone1" placeholder="PHONE 1 ASURANSI" readonly>
					</div>
					<div class="form-group">
						<label for="besaran">Phone2 Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->phone2); ?>"class="form-control input-sm" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="PHONE 2 ASURANSI" readonly>
					</div>
					<div class="form-group">
					<label for="inputsm">HOLD</label>	
						<select class="form-control input-sm" name="kdhold" id="kdhold" readonly disabled>
						 <option <?php if (trim($ls->kdhold)=='NO') { echo 'selected';}?> value="NO">TIDAK</option> 
						 <option <?php if (trim($ls->kdhold)=='YES') { echo 'selected';}?> value="YES">YA</option> 
						</select>
					</div>
					<div class="form-group">
						<label for="besaran">Keterangan</label>
						<textarea  class="textarea input-sm" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" readonly disabled><?php echo trim($ls->keterangan); ?></textarea>
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
</div>									
<?php } ?>
<!-- END ASURANSI --->

<!-- DELETE ASURANSI -->
<?php foreach ($list_mstasuransi as $ls){ ?>
<div class="modal fade" id="DEL<?php echo trim($ls->kdasuransi);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">APAKAH ANDA YAKIN AKAN HAPUS DATA INI</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstasuransi');?>" method="post">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="besaran">Kode Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->kdasuransi); ?>" class="form-control input-sm" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" placeholder="NOMOR DOKUMEN ASURANSI"  maxlength="12" readonly>
						<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
					</div>
					<div class="form-group">
						<label for="besaran">Nama Asuransi</label>
						<input type="text" value="<?php echo trim($ls->nmasuransi); ?>" class="form-control input-sm" id="nmasuransi" style="text-transform:uppercase" name="nmasuransi" placeholder="NAMA ASURANSI" readonly>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Provinsi</label>	
							<select class="form-control input-sm " name="kodeprov" id="kodeprov" readonly disabled>
							 <option value="">---PILIH KODE || PROVINSI--</option> 
							  <?php foreach($list_opt_prov as $sc){?>					  
							  <option  <?php if (trim($ls->kodeprov)==trim($sc->kodeprov)) { echo 'selected';}?> value="<?php echo trim($sc->kodeprov);?>" ><?php echo trim($sc->kodeprov).' || '.trim($sc->namaprov);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Kota Kabupaten</label>	
							<select class="form-control input-sm " name="kodekotakab" id="kodekotakab" readonly disabled>
							 <option value="">---PILIH KODE || KOTA KABUPATEN--</option> 
							  <?php foreach($list_opt_kotakab as $sc){?>					  
							  <option  <?php if (trim($ls->kodekotakab)==trim($sc->kodekotakab)) { echo 'selected';}?> value="<?php echo trim($sc->kodekotakab);?>" class="<?php echo trim($sc->kodeprov);?>"><?php echo trim($sc->kodekotakab).' || '.trim($sc->namakotakab);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="inputsm">Pilih Kecamatan</label>	
							<select class="form-control input-sm " name="kodekec" id="kodekec" readonly disabled>
							 <option value="">---PILIH KODE || KECAMATAN--</option> 
							  <?php foreach($list_opt_kec as $sc){?>					  
							  <option  <?php if (trim($ls->kodekec)==trim($sc->kodekec)) { echo 'selected';}?> value="<?php echo trim($sc->kodekec);?>" class="<?php echo trim($sc->kodekotakab);?>" ><?php echo trim($sc->kodekec).' || '.trim($sc->namakec);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="besaran">Alamat Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->addasuransi); ?>" class="form-control input-sm" id="addasuransi" style="text-transform:uppercase" name="addasuransi" placeholder="ALAMAT ASURANSI" readonly>
					</div>
					
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputsm">Pilih Kantor Cabang</label>	
							<select class="form-control input-sm " name="kdcabang" id="kdcabang" readonly disabled>
							 <option value="">---PILIH KODE || CABANG--</option> 
							  <?php foreach($list_kanwil as $sc){?>					  
							  <option  <?php if (trim($ls->kdcabang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
							  <?php }?>
							</select>
					</div>
					<div class="form-group">
						<label for="besaran">Phone1 Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->phone1); ?>" class="form-control input-sm" id="phone1" style="text-transform:uppercase" name="phone1" placeholder="PHONE 1 ASURANSI" readonly>
					</div>
					<div class="form-group">
						<label for="besaran">Phone2 Asuransi</label>
						<input type="text"  value="<?php echo trim($ls->phone2); ?>"class="form-control input-sm" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="PHONE 2 ASURANSI" readonly>
					</div>
					<div class="form-group">
					<label for="inputsm">HOLD</label>	
						<select class="form-control input-sm" name="kdhold" id="kdhold" readonly disabled>
						 <option <?php if (trim($ls->kdhold)=='NO') { echo 'selected';}?> value="NO">TIDAK</option> 
						 <option <?php if (trim($ls->kdhold)=='YES') { echo 'selected';}?> value="YES">YA</option> 
						</select>
					</div>
					<div class="form-group">
						<label for="besaran">Keterangan</label>
						<textarea  class="textarea input-sm" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" readonly disabled><?php echo trim($ls->keterangan); ?></textarea>
					</div>
				</div>
			</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-danger">HAPUS</button>
		</div>
		</form>
		</div> 
  </div>
</div>
</div>									
<?php } ?>
<!-- END ASURANSI --->



<script>

  

	
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 

  

</script>