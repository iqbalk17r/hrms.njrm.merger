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
				$(".userpakai").selectize();
				$(".kdasuransi").selectize();
				$("#kdsubasuransi").chained('#kdasuransi');
				$("#kdsubasuransied").chained('#kdasuransied');
			
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
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Kendaraan</a></li> 
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
												<th>NAMA KENDARAAN</th>
												<th>NO. POLISI</th>
												<th>NO. MESIN</th>
												<th>PENGGUNA FASILITAS</th>
												<th>MASA BERLAKU PKB</th>
												<th>HOLD</th>
												<th>AKSI</th>		
											</tr>
								</thead>
										<tbody>
										<?php $no=0; foreach($list_mstkendaraan as $row): $no++;?>
									<tr>
										
										<td width="2%"><?php echo $no;?></td>
										<td><?php echo $row->nmbarang;?></td>
										<td><?php echo $row->nopol;?></td>
										<td><?php echo $row->kdmesin;?></td>
										<td><?php echo $row->nmlengkap;?></td>
										<td><?php echo $row->exppkbstnkb;?></td>
										<td><?php echo $row->hold_item;?></td>
										<td width="25%">
												<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->kdrangka).trim($row->kdmesin);?>" class="btn btn-default  btn-sm">
													<i class="fa fa-edit"></i> DETAIL
												</a>
												<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->kdrangka).trim($row->kdmesin);?>" class="btn btn-success  btn-sm">
													<i class="fa fa-edit"></i> EDIT
												</a>
												<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->kdrangka).trim($row->kdmesin);?>" class="btn btn-danger  btn-sm">
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
		</div>

<!-- Modal Input Master Kendaraan & STNKB -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content ">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM INPUT KENDARAAN SESUAI STNK</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstkendaraan');?>" method="post">
		<div class='row'>
			<div class='col-sm-4'>	
			 <div class="form-group">
				<label for="inputsm">Nomor Rangka</label>
				<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" required>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor Mesin</label>
				<input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor Polisi</label>
				<input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB" maxlength="20" >
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Skema</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup" required>
					 <option value="">---PILIH KODE SKEMA--</option> 
					  <?php foreach($list_sckendaraan as $sc){?>					  
					  <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Skema</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" required>
					 <option value="">---PILIH KODE SUB SKEMA--</option> 
					  <?php foreach($list_scsubkendaraan as $sc){?>					  
					  <option value="<?php echo trim($sc->kdsubgroup);?>" class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Cabang</label>	
					<select class="form-control input-sm" name="kdgudang" id="kdgudang"  required>
					<option value="">---PILIH KANTOR CABANG PENEMPATAN--</option> 
					<?php foreach($list_kanwil as $sc){?>					  
					  <option value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Karyawan Pengguna Fasilitas</label>	
					<select class="form-control input-sm userpakai" name="userpakai" id="userpakai"  >
					<option value="">---PILIH NIK || NAMA KARYAWAN--</option> 
					<?php foreach($list_karyawan as $sc){?>					  
					  <option value="<?php echo trim($sc->nik);?>" ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
					<?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">Nama Kendaraan</label>
				<input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan"  maxlength="30" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Merk Kendaraan</label>
				<input type="text" class="form-control input-sm" id="brand" style="text-transform:uppercase" name="brand" placeholder="Merk Kendaraan"  maxlength="30" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nama Pemilik</label>
				<input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="50" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Alamat Pemilik</label>
				<input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  maxlength="100" >
			  </div>

			</div> <!---- col 1 -->
			<div class='col-sm-4'>	
			  <div class="form-group">
				<label for="inputsm">Telepon Pemilik</label>
				<input type="text" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada"  maxlength="30" >
			  </div>
			 <div class="form-group">
				<label for="inputsm">Tipe Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Jenis Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Model Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Tahun Pembuatan</label>
				<input type="text" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"  >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Volume Silinder</label>
				<input type="text" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Warna Kendaraan</label>
				<input type="text" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Bahan Bakar</label>
				<input type="text" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"  >
			  </div>
			   <div class="form-group">
				<label for="inputsm">Warna TNKB</label>
				<input type="text" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20"  >
			  </div>
			   <div class="form-group">
				<label for="inputsm">Nomor BPKB</label>
				<input type="text" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20"  >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Lokasi Dari STNKB</label>
				<input type="text" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20"  >
			  </div>
			  </div> <!---- col 2 -->
			<div class='col-sm-4'>	
			  <div class="form-group">
				<label for="inputsm">Tahun Registrasi STNK</label>
				<input type="text" id="tahunreg" name="tahunreg" class="form-control year"  >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Masa Pengurusan STNK 5 Tahunan</label>
				<input type="text" class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"  >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Masa Pengurusan PKB Tahunan</label>
				<input type="text" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"  >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor PKB</label>
				<input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" >
			  </div>
			  <!--div class="form-group">
				<label for="inputsm">Total Nominal Pajak Kendaraan</label>
				<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb" value="0"  maxlength="20" >
			  </div-->
			  <div class="form-group">
				<label for="inputsm">Pajak Progresif Ke</label>
				<input type="number" class="form-control input-sm" id="pprogresif" style="text-transform:uppercase" name="pprogresif" value="0"  maxlength="20" >
			  </div>

			<div class="form-group">
			<label for="inputsm">HOLD</label>	
				<select class="form-control input-sm" name="hold_item" id="hold_item">
				 <option value="NO">TIDAK</option> 
				 <option value="YES">YA</option> 
				</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Asuransi</label>	
					<select class="form-control input-sm " name="kdasuransi" id="kdasuransi">
					<option value="">-----PILIH ASURANSI JIKA ADA-----</option> 
					  <?php foreach($list_asuransi as $sc){?>					  
					  <option value="<?php echo trim($sc->kdasuransi);?>" ><?php echo trim($sc->kdasuransi).' || '.trim($sc->nmasuransi);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Sub Asuransi</label>	
					<select class="form-control input-sm " name="kdsubasuransi" id="kdsubasuransi">
					<option value="">-----PILIH SUB ASURANSI JIKA ADA-----</option> 
					  <?php foreach($list_subasuransi as $sc){?>					  
					  <option value="<?php echo trim($sc->kdsubasuransi);?>" class="<?php echo trim($sc->kdasuransi);?>"><?php echo trim($sc->kdsubasuransi).' || '.trim($sc->nmsubasuransi);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Masa Berlaku Asuransi</label>
				<input type="text" id="expasuransi" name="expasuransi" class="form-control tgl"  data-date-format="dd-mm-yyyy"   >
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
  </div>
</div>	
</div>			
<!-- -->

<!-- EDIT KENDARAAN -->
<?php foreach ($list_mstkendaraan as $ls){ ?>
<div class="modal fade" id="ED<?php echo trim($ls->kdrangka).trim($ls->kdmesin);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT DATA KENDARAAN</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstkendaraan');?>" method="post">
		<div class='row'>
			<div class='col-sm-4'>	
			 <div class="form-group">
				<label for="inputsm">Nomor Rangka</label>
				<input type="text" value="<?php echo trim($ls->kdrangka);?>" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" required readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor Mesin</label>
				<input type="text" value="<?php echo trim($ls->kdmesin);?>" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" required readonly>
			  </div>
			<div class="form-group">
				<label for="inputsm">NOPOL</label>
				<input type="text" value="<?php echo trim($ls->nopol);?>" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB" maxlength="20" >
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Group</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup" required>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_sckendaraan as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" required>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubkendaraan as $sc){?>					  
					  <option <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdsubgroup);?>" class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Cabang</label>	
					<select class="form-control input-sm" name="kdgudang" id="kdgudang"  required>
					<option value="">---PILIH KANTOR CABANG PENEMPATAN--</option> 
					<?php foreach($list_kanwil as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Karyawan Pengguna Fasilitas</label>	
					<select class="form-control input-sm userpakai" name="userpakai" id="userpakai"  >
					<option value="">---PILIH NIK || NAMA KARYAWAN--</option> 
					<?php foreach($list_karyawan as $sc){?>					  
					  <option <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>" ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
					<?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">Nama Kendaraan</label>
				<input type="text" value="<?php echo trim($ls->nmbarang);?>" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan"  maxlength="30" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Merk Kendaraan</label>
				<input type="text" value="<?php echo trim($ls->brand);?>" class="form-control input-sm" id="brand" style="text-transform:uppercase" name="brand" placeholder="Merk Kendaraan"  maxlength="30" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nama Pemilik</label>
				<input type="text" value="<?php echo trim($ls->nmpemilik);?>" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="50" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Alamat Pemilik</label>
				<input type="text" value="<?php echo trim($ls->addpemilik);?>" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  maxlength="100" >
			  </div>

			</div> <!---- col 1 -->
			<div class='col-sm-4'>	
			  <div class="form-group">
				<label for="inputsm">Contact Pemilik</label>
				<input type="text" value="<?php echo trim($ls->hppemilik);?>" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada"  maxlength="30" >
			  </div>
			 <div class="form-group">
				<label for="inputsm">TYPE Kendaraan STNKB</label>
				<input type="text" value="<?php echo trim($ls->typeid);?>" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Jenis Kendaraan STNKB</label>
				<input type="text" value="<?php echo trim($ls->jenisid);?>" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Model Kendaraan STNKB</label>
				<input type="text" value="<?php echo trim($ls->modelid);?>" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Tahun Pembuatan</label>
				<input type="text" value="<?php echo trim($ls->tahunpembuatan);?>" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"  >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Volume Silinder</label>
				<input type="text" value="<?php echo trim($ls->silinder);?>" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Warna Kendaraan</label>
				<input type="text" value="<?php echo trim($ls->warna);?>" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Bahan Bakar</label>
				<input type="text" value="<?php echo trim($ls->bahanbakar);?>" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"  >
			  </div>
			   <div class="form-group">
				<label for="inputsm">Warna TNKB</label>
				<input type="text" value="<?php echo trim($ls->warnatnkb);?>" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20"  >
			  </div>
			   <div class="form-group">
				<label for="inputsm">Nomor BPKB</label>
				<input type="text" value="<?php echo trim($ls->nobpkb);?>" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20"  >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Lokasi Dari STNKB</label>
				<input type="text" value="<?php echo trim($ls->kdlokasi);?>" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20"  >
			  </div>
			  </div> <!---- col 2 -->
			<div class='col-sm-4'>	
			  <div class="form-group">
				<label for="inputsm">Tahun Registrasi STNK</label>
				<input type="text" value="<?php echo trim($ls->tahunreg);?>" id="tahunreg" name="tahunreg" class="form-control year"  >
			  </div>
			  <div class="form-group">
				<label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
				<input type="text"   value="<?php echo date('d-m-Y', strtotime(trim($ls->expstnkb)));?>"  class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"  >
			  </div>
			  <div class="form-group">
				<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
				<input type="text" value="<?php echo date('d-m-Y', strtotime(trim($ls->exppkbstnkb)));?>" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"  >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor PKB</label>
				<input type="text" value="<?php echo trim($ls->nopkb);?>" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" >
			  </div>
			  <!--div class="form-group">
				<label for="inputsm">Total Nominal Pajak Kendaraan</label>
				<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb" value="0"  maxlength="20" >
			  </div-->
			  <div class="form-group">
				<label for="inputsm">Pajak Progresif Ke</label>
				<input type="number" value="<?php echo trim($ls->pprogresif);?>" class="form-control input-sm" id="pprogresif" style="text-transform:uppercase" name="pprogresif" value="0"  maxlength="20" >
			  </div>

			<div class="form-group">
			<label for="inputsm">HOLD</label>	
				<select class="form-control input-sm" name="hold_item" id="hold_item">
				 <option value="NO">TIDAK</option> 
				 <option value="YES">YA</option> 
				</select>
			</div>
			<div class="form-group">
				<label for="inputsm">ASURANSI</label>	
					<select class="form-control input-sm " name="kdasuransi" id="kdasuransied">
					<option value="">-----PILIH ASURANSI JIKA ADA-----</option> 
					  <?php foreach($list_asuransi as $sc){?>					  
					  <option  <?php if (trim($ls->kdasuransi)==trim($sc->kdasuransi)) { echo 'selected';}?>   value="<?php echo trim($sc->kdasuransi);?>" ><?php echo trim($sc->kdasuransi).' || '.trim($sc->nmasuransi);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">SUB ASURANSI</label>	
					<select class="form-control input-sm " name="kdsubasuransi" id="kdsubasuransied">
					<option value="">-----PILIH SUB ASURANSI JIKA ADA-----</option> 
					  <?php foreach($list_subasuransi as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubasuransi)==trim($sc->kdsubasuransi)) { echo 'selected';}?> value="<?php echo trim($sc->kdsubasuransi);?>" class="<?php echo trim($sc->kdasuransi);?>"><?php echo trim($sc->kdsubasuransi).' || '.trim($sc->nmsubasuransi);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Masa Berlaku Asuransi</label>
				<input type="text" value="<?php echo date('d-m-Y', strtotime(trim($ls->expasuransi)));?>" id="expasuransi" name="expasuransi" data-date-format="dd-mm-yyyy"  class="form-control tgl"  >
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
<!-- DETAIL KENDARAAN -->
<?php foreach ($list_mstkendaraan as $ls){ ?>
<div class="modal fade" id="DTL<?php echo trim($ls->kdrangka).trim($ls->kdmesin);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL KENDARAAN</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstkendaraan');?>" method="post">
		<div class='row'>
			<div class='col-sm-4'>	
			 <div class="form-group">
				<label for="inputsm">Nomor Rangka</label>
				<input type="text" value="<?php echo trim($ls->kdrangka);?>" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" required readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor Mesin</label>
				<input type="text" value="<?php echo trim($ls->kdmesin);?>" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" required readonly>
			  </div>
			<div class="form-group">
				<label for="inputsm">NOPOL</label>
				<input type="text" value="<?php echo trim($ls->nopol);?>" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB" maxlength="20" readonly>
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Skema</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup" readonly disabled>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_sckendaraan as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Skema</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup"  readonly disabled>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubkendaraan as $sc){?>					  
					  <option <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdsubgroup);?>" class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Cabang</label>	
					<select class="form-control input-sm" name="kdgudang" id="kdgudang"   readonly disabled>
					<option value="">---PILIH KANTOR CABANG PENEMPATAN--</option> 
					<?php foreach($list_kanwil as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Karyawan Pengguna Fasilitas</label>	
					<select class="form-control input-sm " name="userpakai" id="userpakai"   readonly disabled>
					<option value="">---PILIH NIK || NAMA KARYAWAN--</option> 
					<?php foreach($list_karyawan as $sc){?>					  
					  <option <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>" ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
					<?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">Nama Kendaraan</label>
				<input type="text" value="<?php echo trim($ls->nmbarang);?>" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan"  maxlength="30"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Merk Kendaraan</label>
				<input type="text" value="<?php echo trim($ls->brand);?>" class="form-control input-sm" id="brand" style="text-transform:uppercase" name="brand" placeholder="Merk Kendaraan"  maxlength="30"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nama Pemilik</label>
				<input type="text" value="<?php echo trim($ls->nmpemilik);?>" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="50"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Alamat Pemilik</label>
				<input type="text" value="<?php echo trim($ls->addpemilik);?>" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  maxlength="100"  readonly disabled>
			  </div>

			</div> <!---- col 1 -->
			<div class='col-sm-4'>	
			  <div class="form-group">
				<label for="inputsm">Nomor Telepon Pemilik</label>
				<input type="text" value="<?php echo trim($ls->hppemilik);?>" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada"  maxlength="30"  readonly disabled>
			  </div>
			 <div class="form-group">
				<label for="inputsm">Tipe Kendaraan STNKB</label>
				<input type="text" value="<?php echo trim($ls->typeid);?>" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Jenis Kendaraan STNKB</label>
				<input type="text" value="<?php echo trim($ls->jenisid);?>" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Model Kendaraan STNKB</label>
				<input type="text" value="<?php echo trim($ls->modelid);?>" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Tahun Pembuatan</label>
				<input type="text" value="<?php echo trim($ls->tahunpembuatan);?>" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"   readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Volume Silinder</label>
				<input type="text" value="<?php echo trim($ls->silinder);?>" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Warna Kendaraan</label>
				<input type="text" value="<?php echo trim($ls->warna);?>" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Bahan Bakar</label>
				<input type="text" value="<?php echo trim($ls->bahanbakar);?>" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"   readonly disabled>
			  </div>
			   <div class="form-group">
				<label for="inputsm">Warna TNKB</label>
				<input type="text" value="<?php echo trim($ls->warnatnkb);?>" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20"   readonly disabled>
			  </div>
			   <div class="form-group">
				<label for="inputsm">Nomor BPKB</label>
				<input type="text" value="<?php echo trim($ls->nobpkb);?>" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20"   readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Lokasi Dari STNKB</label>
				<input type="text" value="<?php echo trim($ls->kdlokasi);?>" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20"   readonly disabled>
			  </div>
			  </div> <!---- col 2 -->
			<div class='col-sm-4'>	
			  <div class="form-group">
				<label for="inputsm">Tahun Registrasi STNK</label>
				<input type="text" value="<?php echo trim($ls->tahunreg);?>" id="tahunreg" name="tahunreg" class="form-control year"   readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Masa Pengurusan STNK 5 Tahunan</label>
				<input type="text"   value="<?php echo date('d-m-Y', strtotime(trim($ls->expstnkb)));?>"  class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"   readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Masa Pengurusan PKB Tahunan</label>
				<input type="text" value="<?php echo date('d-m-Y', strtotime(trim($ls->exppkbstnkb)));?>" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"   readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor PKB</label>
				<input type="text" value="<?php echo trim($ls->nopkb);?>" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20"  readonly disabled >
			  </div>
			  <!--div class="form-group">
				<label for="inputsm">Total Nominal Pajak Kendaraan</label>
				<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb" value="0"  maxlength="20" >
			  </div-->
			  <div class="form-group">
				<label for="inputsm">Pajak Progresif Ke</label>
				<input type="number" value="<?php echo trim($ls->pprogresif);?>" class="form-control input-sm" id="pprogresif" style="text-transform:uppercase" name="pprogresif" value="0"  maxlength="20"  readonly disabled>
			  </div>

			<div class="form-group">
			<label for="inputsm">HOLD</label>	
				<select class="form-control input-sm" name="hold_item" id="hold_item"  readonly disabled>
				 <option value="NO">TIDAK</option> 
				 <option value="YES">YA</option> 
				</select>
			</div>
			<div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>	
					<select class="form-control input-sm " name="kdasuransi" id="kdasuransi"  readonly disabled>
					<option value="">-----PILIH ASURANSI JIKA ADA-----</option> 
					  <?php foreach($list_asuransi as $sc){?>					  
					  <option  <?php if (trim($ls->kdasuransi)==trim($sc->kdasuransi)) { echo 'selected';}?>   value="<?php echo trim($sc->kdasuransi);?>" ><?php echo trim($sc->kdasuransi).' || '.trim($sc->nmasuransi);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">KODE SUB ASURANSI</label>	
					<select class="form-control input-sm " name="kdsubasuransi" id="kdsubasuransi">
					<option value="">-----PILIH SUB ASURANSI JIKA ADA-----</option> 
					  <?php foreach($list_subasuransi as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubasuransi)==trim($sc->kdsubasuransi)) { echo 'selected';}?> value="<?php echo trim($sc->kdsubasuransi);?>" class="<?php echo trim($sc->kdasuransi);?>"><?php echo trim($sc->kdsubasuransi).' || '.trim($sc->nmsubasuransi);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Exp Asuransi</label>
				<input type="text" value="<?php echo date('d-m-Y', strtotime(trim($ls->expasuransi)));?>" id="expasuransi" name="expasuransi" data-date-format="dd-mm-yyyy"  class="form-control tgl"  readonly disabled >
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  readonly disabled><?php echo trim($ls->keterangan);?></textarea>
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
<!-- END KENDARAAN --->



<!-- DELETE KENDARAAN -->
<?php foreach ($list_mstkendaraan as $ls){ ?>
<div class="modal fade" id="DEL<?php echo trim($ls->kdrangka).trim($ls->kdmesin);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DELETE KENDARAAN</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstkendaraan');?>" method="post">
		<div class='row'>
			<div class='col-sm-4'>	
			 <div class="form-group">
				<label for="inputsm">Nomor Rangka</label>
				<input type="text" value="<?php echo trim($ls->kdrangka);?>" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" required readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor Mesin</label>
				<input type="text" value="<?php echo trim($ls->kdmesin);?>" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" required readonly>
			  </div>
			<div class="form-group">
				<label for="inputsm">NOPOL</label>
				<input type="text" value="<?php echo trim($ls->nopol);?>" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB" maxlength="20" readonly>
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Group</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup" readonly disabled>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_sckendaraan as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup"  readonly disabled>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubkendaraan as $sc){?>					  
					  <option <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdsubgroup);?>" class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Cabang</label>	
					<select class="form-control input-sm" name="kdgudang" id="kdgudang"   readonly disabled>
					<option value="">---PILIH KANTOR CABANG PENEMPATAN--</option> 
					<?php foreach($list_kanwil as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Karyawan Pengguna Fasilitas</label>	
					<select class="form-control input-sm " name="userpakai" id="userpakai"   readonly disabled>
					<option value="">---PILIH NIK || NAMA KARYAWAN--</option> 
					<?php foreach($list_karyawan as $sc){?>					  
					  <option <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>" ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
					<?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">Nama Kendaraan</label>
				<input type="text" value="<?php echo trim($ls->nmbarang);?>" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan"  maxlength="30"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Merk Kendaraan</label>
				<input type="text" value="<?php echo trim($ls->brand);?>" class="form-control input-sm" id="brand" style="text-transform:uppercase" name="brand" placeholder="Merk Kendaraan"  maxlength="30"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nama Pemilik</label>
				<input type="text" value="<?php echo trim($ls->nmpemilik);?>" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="50"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Alamat Pemilik</label>
				<input type="text" value="<?php echo trim($ls->addpemilik);?>" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  maxlength="100"  readonly disabled>
			  </div>

			</div> <!---- col 1 -->
			<div class='col-sm-4'>	
			  <div class="form-group">
				<label for="inputsm">Contact Pemilik</label>
				<input type="text" value="<?php echo trim($ls->hppemilik);?>" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada"  maxlength="30"  readonly disabled>
			  </div>
			 <div class="form-group">
				<label for="inputsm">TYPE Kendaraan STNKB</label>
				<input type="text" value="<?php echo trim($ls->typeid);?>" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Jenis Kendaraan STNKB</label>
				<input type="text" value="<?php echo trim($ls->jenisid);?>" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Model Kendaraan STNKB</label>
				<input type="text" value="<?php echo trim($ls->modelid);?>" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Tahun Pembuatan</label>
				<input type="text" value="<?php echo trim($ls->tahunpembuatan);?>" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"   readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Volume Silinder</label>
				<input type="text" value="<?php echo trim($ls->silinder);?>" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Warna Kendaraan</label>
				<input type="text" value="<?php echo trim($ls->warna);?>" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20"  readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Bahan Bakar</label>
				<input type="text" value="<?php echo trim($ls->bahanbakar);?>" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"   readonly disabled>
			  </div>
			   <div class="form-group">
				<label for="inputsm">Warna TNKB</label>
				<input type="text" value="<?php echo trim($ls->warnatnkb);?>" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20"   readonly disabled>
			  </div>
			   <div class="form-group">
				<label for="inputsm">Nomor BPKB</label>
				<input type="text" value="<?php echo trim($ls->nobpkb);?>" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20"   readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Lokasi Dari STNKB</label>
				<input type="text" value="<?php echo trim($ls->kdlokasi);?>" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20"   readonly disabled>
			  </div>
			  </div> <!---- col 2 -->
			<div class='col-sm-4'>	
			  <div class="form-group">
				<label for="inputsm">Tahun Registrasi STNK</label>
				<input type="text" value="<?php echo trim($ls->tahunreg);?>" id="tahunreg" name="tahunreg" class="form-control year"   readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
				<input type="text"   value="<?php echo date('d-m-Y', strtotime(trim($ls->expstnkb)));?>"  class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"   readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
				<input type="text" value="<?php echo date('d-m-Y', strtotime(trim($ls->exppkbstnkb)));?>" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"   readonly disabled>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor PKB</label>
				<input type="text" value="<?php echo trim($ls->nopkb);?>" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20"  readonly disabled >
			  </div>
			  <!--div class="form-group">
				<label for="inputsm">Total Nominal Pajak Kendaraan</label>
				<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb" value="0"  maxlength="20" >
			  </div-->
			  <div class="form-group">
				<label for="inputsm">Pajak Progresif Ke</label>
				<input type="number" value="<?php echo trim($ls->pprogresif);?>" class="form-control input-sm" id="pprogresif" style="text-transform:uppercase" name="pprogresif" value="0"  maxlength="20"  readonly disabled>
			  </div>

			<div class="form-group">
			<label for="inputsm">HOLD</label>	
				<select class="form-control input-sm" name="hold_item" id="hold_item"  readonly disabled>
				 <option value="NO">TIDAK</option> 
				 <option value="YES">YA</option> 
				</select>
			</div>
			<div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>	
					<select class="form-control input-sm " name="kdasuransi" id="kdasuransi"  readonly disabled>
					<option value="">-----PILIH ASURANSI JIKA ADA-----</option> 
					  <?php foreach($list_asuransi as $sc){?>					  
					  <option  <?php if (trim($ls->kdasuransi)==trim($sc->kdasuransi)) { echo 'selected';}?>   value="<?php echo trim($sc->kdasuransi);?>" ><?php echo trim($sc->kdasuransi).' || '.trim($sc->nmasuransi);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">KODE SUB ASURANSI</label>	
					<select class="form-control input-sm kdasuransi" name="kdsubasuransi" id="kdsubasuransi">
					<option value="">-----PILIH SUB ASURANSI JIKA ADA-----</option> 
					  <?php foreach($list_subasuransi as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubasuransi)==trim($sc->kdsubasuransi)) { echo 'selected';}?> value="<?php echo trim($sc->kdsubasuransi);?>" class="<?php echo trim($sc->kdasuransi);?>"><?php echo trim($sc->kdsubasuransi).' || '.trim($sc->nmsubasuransi);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Exp Asuransi</label>
				<input type="text" value="<?php echo date('d-m-Y', strtotime(trim($ls->expasuransi)));?>" id="expasuransi" name="expasuransi" data-date-format="dd-mm-yyyy"  class="form-control tgl"  readonly disabled >
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  readonly disabled><?php echo trim($ls->keterangan);?></textarea>
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