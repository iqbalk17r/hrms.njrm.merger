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
<!--div class="pull-right">Versi: <?php echo $version; ?></div--->
</br>


<legend><?php echo $title;?></legend>
	
<div class="row">
	<!--div class="col-sm-3">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Kendaraan</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div--->
<div><a href="<?php echo site_url('ga/kendaraan/clear_tmp_stnkb');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
	
</div>	
</br>

<?php if (trim($dtlstnk['jenispengurusan'])=='1T') { ?>
<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
		<div class="box-content">
			  <div class="box-body">
					<form role="form" action="<?php echo site_url('ga/kendaraan/save_stnkbaru');?>" method="post">
					<div class='row'>
						<div class='col-sm-6'>	
						 <div class="form-group">
							<label for="inputsm">Nomor Rangka</label>
							<input type="text" class="form-control input-sm" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($dtlstnk['kdrangka']) ;?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor Mesin</label>
							<input type="text" class="form-control input-sm" style="text-transform:uppercase" placeholder="Nomor Mesin Dari STNKB" maxlength="25" value="<?php echo trim($dtlstnk['kdmesin']) ;?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">NOPOL</label>
							<input type="text" value="<?php echo trim($dtlstnk['nopol']) ;?>" class="form-control input-sm" maxlength="20" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN LALU</label>
							<input type="text" class="form-control input-sm"  data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime(trim($dtlstnk['old_exppkbstnkb'])));?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor PKB LALU</label>
							<input type="text" class="form-control input-sm" value="<?php echo trim($dtlstnk['old_nopkb']);?>" style="text-transform:uppercase" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Total BIAYA Pajak Kendaraan (PKB) LALU</label>
							<input type="number" class="form-control input-sm" maxlength="20" value="<?php echo trim($dtlstnk['old_nominalpkb']);?>"  readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor SKUM</label>
							<input type="text" class="form-control input-sm" style="text-transform:uppercase" placeholder="Nomor SKUM" value="<?php echo trim($dtlstnk['old_noskum']);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor KOHIR</label>
							<input type="text" class="form-control input-sm" style="text-transform:uppercase" placeholder="Nomor KOHIR" value="<?php echo trim($dtlstnk['old_nokohir']);?>" readonly>
						  </div>
						</div> 
						<div class='col-sm-6'>	
						 <div class="form-group">
							<label for="inputsm">Nomor Rangka</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($dtlstnk['kdrangka']) ;?>" readonly>
							<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT_1T">
							<input type="hidden" class="form-control input-sm" id="jenispengurusan" name="jenispengurusan" value="1T">
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor Mesin</label>
							<input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" value="<?php echo trim($dtlstnk['kdmesin']) ;?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">NOPOL</label>
							<input type="text" value="<?php echo trim($dtlstnk['nopol']) ;?>" class="form-control input-sm" maxlength="20" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN BARU</label>
							<input type="text" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime(trim($dtlstnk['exppkbstnkb'])));?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor PKB BARU</label>
							<input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor" value="<?php echo trim($dtlstnk['nopkb']) ;?>"  maxlength="20" >
						  </div>
						  <div class="form-group">
							<label for="inputsm">Total BIAYA Pajak Kendaraan (PKB)</label>
							<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb"  maxlength="20"  value="<?php echo trim($dtlstnk['nominalpkb']) ;?>" >
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor SKUM</label>
							<input type="text" class="form-control input-sm" id="noskum" style="text-transform:uppercase" name="noskum" placeholder="Nomor SKUM"  value="<?php echo trim($dtlstnk['noskum']) ;?>">
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor KOHIR</label>
							<input type="text" class="form-control input-sm" id="nokohir" style="text-transform:uppercase" name="nokohir" placeholder="Nomor KOHIR" value="<?php echo trim($dtlstnk['noskum']) ;?>">
						  </div>
						
						<div class="form-group">
							<label for="inputsm">Keterangan</label>
							<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 10px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($dtlstnk['keterangan']) ;?></textarea>
						  </div>
						</div> 
					</div>
						<button type="submit" class="btn btn-primary pull-right" >Submit</button>
					</div>
					<!--div class="box-footer"--->
					
					<!--/div--->
			</form>  
		</div><!-- /.box -->
		</div><!-- /.box -->
	</div>
</div>
<?php } else if (trim($dtlstnk['jenispengurusan'])=='5T') { ?>
<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			  <div class="box-body">
					<form role="form" action="<?php echo site_url('ga/kendaraan/save_stnkbaru');?>" method="post">
					<div class='row'>
						<div class='col-sm-4'>	
						 <div class="form-group">
							<label for="inputsm">Nomor Rangka</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($dtlstnk['kdrangka']) ;?>" readonly>
							<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT_5T">
							<input type="hidden" class="form-control input-sm" id="jenispengurusan" name="jenispengurusan" value="5T">
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor Mesin</label>
							<input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" value="<?php echo trim($dtlstnk['kdmesin']) ;?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">NOPOL</label>
							<input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB" value="<?php echo trim($dtlstnk['kdmesin']) ;?>" maxlength="10" required>
						  </div>
						<!--div class="form-group">
							<label for="inputsm">Kode Group</label>	
								<select class="form-control input-sm" name="kdgroup" id="kdgroup">
								 <option value="">---PILIH KODE GROUP--</option> 
								  <?php foreach($list_sckendaraan as $sc){?>					  
								  <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
								  <?php }?>
								</select>
						</div>
						<div class="form-group">
							<label for="inputsm">Kode Cabang</label>	
								<select class="form-control input-sm" name="kdcabang" id="kdcabang"  required>
								<option value="">---PILIH KANTOR CABANG PENEMPATAN--</option> 
								<?php foreach($list_kanwil as $sc){?>					  
								  <option value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
								<?php }?>
								</select>
						</div--->
						  <div class="form-group">
							<label for="inputsm">Nama Kendaraan</label>
							<input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan" value="<?php echo trim($dtlstnk['nmkendaraan']) ;?>" maxlength="30" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nama Pemilik</label>
							<input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="30" value="<?php echo trim($dtlstnk['nmpemilik']) ;?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Alamat Pemilik</label>
							<input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  maxlength="100" value="<?php echo trim($dtlstnk['addpemilik']) ;?>"required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Contact Pemilik</label>
							<input type="text" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada" value="<?php echo trim($dtlstnk['hppemilik']) ;?>" maxlength="30" >
						  </div>
						  <div class="form-group">
							<label for="inputsm">Tahun Reg</label>
							<input type="text" class="form-control input-sm year" id="tahunreg" style="text-transform:uppercase" name="tahunreg" placeholder="Tahun Reg Pada STNK" value="<?php echo trim($dtlstnk['tahunreg']) ;?>" maxlength="30" >
						  </div>
						</div> <!---- col 1 -->
						<div class='col-sm-4'>	
						 <div class="form-group">
							<label for="inputsm">TYPE Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20" value="<?php echo trim($dtlstnk['typeid']) ;?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Jenis Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20" value="<?php echo trim($dtlstnk['jenisid']) ;?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Model Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20" value="<?php echo trim($dtlstnk['modelid']) ;?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Tahun Pembuatan</label>
							<input type="text" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"  value="<?php echo trim($dtlstnk['tahunpembuatan']) ;?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Volume Silinder</label>
							<input type="text" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20" value="<?php echo trim($dtlstnk['silinder']) ;?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Warna Kendaraan</label>
							<input type="text" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20" value="<?php echo trim($dtlstnk['warna']) ;?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Bahan Bakar</label>
							<input type="text" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"  value="<?php echo trim($dtlstnk['bahanbakar']) ;?>" required>
						  </div>
						   <div class="form-group">
							<label for="inputsm">Warna TNKB</label>
							<input type="text" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20" value="<?php echo trim($dtlstnk['warnatnkb']) ;?>"  required>
						  </div>
						   <div class="form-group">
							<label for="inputsm">Nomor BPKB</label>
							<input type="text" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20" value="<?php echo trim($dtlstnk['nobpkb']) ;?>" required>
						  </div>
						  </div> <!---- col 2 -->
						<div class='col-sm-4'>	
						  <div class="form-group">
							<label for="inputsm">Lokasi Dari STNKB</label>
							<input type="text" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20" value="<?php echo trim($dtlstnk['kdlokasi']) ;?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
							<input type="text" class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime(trim($dtlstnk['expstnkb'])));?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
							<input type="text" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime(trim($dtlstnk['exppkbstnkb'])));?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor PKB</label>
							<input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" value="<?php echo trim($dtlstnk['nopkb']) ;?>">
						  </div>
						  <div class="form-group">
							<label for="inputsm">Total BIAYA Pajak Kendaraan (PKB)</label>
							<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb"  min="0" max="999999999999" value="<?php echo trim($dtlstnk['nominalpkb']) ;?>">
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor SKUM</label>
							<input type="text" class="form-control input-sm" id="noskum" style="text-transform:uppercase" name="noskum" placeholder="Nomor SKUM"  maxlength="20" value="<?php echo trim($dtlstnk['noskum']) ;?>" >
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor KOHIR</label>
							<input type="text" class="form-control input-sm" id="nokohir" style="text-transform:uppercase" name="nokohir" placeholder="Nomor KOHIR"  maxlength="20" value="<?php echo trim($dtlstnk['nokohir']) ;?>">
						  </div>
						  <!--div class="form-group">
							<label for="inputsm">HOLD</label>	
								<select class="form-control input-sm" name="hold_stnk" id="hold_stnk">
								 <option value="NO">TIDAK</option> 
								 <option value="YES">YA</option> 
								</select>
						  </div-->
						<!--div class="form-group">
							<label for="inputsm">KODE ASURANSI</label>	
								<select class="form-control input-sm" name="kdasuransi" id="kdasuransi">
								<option value="">-----PILIH ASURANSI JIKA ADA-----</option> 
								  <?php foreach($list_asuransi as $sc){?>					  
								  <option value="<?php echo trim($sc->kdasuransi);?>" ><?php echo trim($sc->kdasuransi).' || '.trim($sc->nmasuransi);?></option>						  
								  <?php }?>
								</select>
						</div-->
						<div class="form-group">
							<label for="inputsm">Keterangan</label>
							<textarea  class="textarea" name="keterangan" placeholder="Keterangan"  style="text-transform:uppercase"  maxlength ="100" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($dtlstnk['keterangan']) ;?></textarea>
						  </div>
						</div> 
					</div>
					</div>
					<div class="box-footer">
					<button type="submit" class="btn btn-primary pull-right" align="right">Submit</button>
				  </div>
			</form>  
		</div><!-- /.box -->
	</div>
</div>
<?php } ?>


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