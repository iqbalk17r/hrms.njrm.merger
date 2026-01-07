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
<div><a href="<?php echo site_url('ga/kendaraan/form_stnkbaru');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
	
</div>	
</br>
<div class="col-sm-12">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">					
			<li class="active"><a href="#tab_1" data-toggle="tab">LIST KENDARAAN WILAYAH</a></li>
			<!--li><a href="#tab_2" data-toggle="tab">Schema Kendaraan2</a></li--->	
		</ul>
		
	<div class="tab-content">
		<div class="chart tab-pane active" id="tab_1" style="position: relative; height: 300px;" >
			
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
												<th>NAMA KENDARAAN</th>
												<th>NOPOL</th>
												<th>BASE</th>
												<th>BERLAKU STNKB</th>
												<th>BERLAKU PKB STNKB</th>
												<th>HOLD</th>
												<th>Aksi</th>		
											</tr>
								</thead>
										<tbody>
										<?php $no=0; foreach($list_mstkendaraan as $row): $no++;?>
									<tr>
										
										<td width="2%"><?php echo $no;?></td>
										<td><?php echo $row->nmbarang;?></td>
										<td><?php echo $row->nopol;?></td>
										<td><?php echo $row->kdgudang;?></td>
										<td><?php echo $row->expstnkb;?></td>
										<td><?php echo $row->exppkbstnkb;?></td>
										<td><?php echo $row->hold_item;?></td>
										<td width="15%">
												<!--a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->kdrangka);?>" class="btn btn-success  btn-sm">
													<i class="fa fa-edit"></i> GANTI STNK
												</a-->	
												<a href="<?php echo site_url('ga/kendaraan/input_stnkbaru').'/'.trim($row->kdrangka).'/'.trim($row->kdmesin);?>" type="button" class="btn btn-success"/> GANTI STNK</a>												
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


	</div>	
	</div>
</div>
<!--Modal untuk Filter ASET KENDARAAN WILAYAH-->
<div class="modal fade" id="filterinput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Filter ASET KENDARAAN WILAYAH</h4>
      </div>
	  <form action="<?php echo site_url('ga/kendaraan/list_kendaraanwil')?>" method="post">
      <div class="modal-body">
        <!--div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name='bulan'>
					
					<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
					<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
					<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
					<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
					<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
					<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
					<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
					<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
					<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
					<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
					<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
					<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
				</select>
			</div>			
		</div--->
		<div class="form-group">
				<label for="inputsm">PILIH WILAYAH</label>	
					<select class="form-control input-sm" name="kdcabang" id="kdcabang">
					<option value="">---PILIH KANTOR CABANG --</option> 
					<option value="ALL">---ALL --</option> 
					<?php foreach($list_kanwil as $sc){?>					  
						<option value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
		</div>
		<div class="form-group">
				<label for="inputsm">TAHUN</label>
				<select class="form-control input-sm" name="tahun">
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
				</select>		
		</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Filter</button>
      </div>
	  </form>
    </div>
  </div>
</div>


<!-- Modal Input Master Kendaraan & STNKB -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT KENDARAAN SESUAI STNK</h4>
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
				<label for="inputsm">NOPOL</label>
				<input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB" maxlength="20" required>
			  </div>
			<div class="form-group">
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
			</div>
			  <div class="form-group">
				<label for="inputsm">Nama Kendaraan</label>
				<input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan"  maxlength="30" required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nama Pemilik</label>
				<input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="30" required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Alamat Pemilik</label>
				<input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  maxlength="100" required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Contact Pemilik</label>
				<input type="text" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada"  maxlength="30" >
			  </div>
			</div> <!---- col 1 -->
			<div class='col-sm-4'>	
			 <div class="form-group">
				<label for="inputsm">TYPE Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20" required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Jenis Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20" required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Model Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20" required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Tahun Pembuatan</label>
				<input type="text" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"  required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Volume Silinder</label>
				<input type="text" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20" required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Warna Kendaraan</label>
				<input type="text" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20" required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Bahan Bakar</label>
				<input type="text" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"  required>
			  </div>
			   <div class="form-group">
				<label for="inputsm">Warna TNKB</label>
				<input type="text" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20"  required>
			  </div>
			   <div class="form-group">
				<label for="inputsm">Nomor BPKB</label>
				<input type="text" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20"  required>
			  </div>
			  </div> <!---- col 2 -->
			<div class='col-sm-4'>	
			  <div class="form-group">
				<label for="inputsm">Lokasi Dari STNKB</label>
				<input type="text" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20"  required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
				<input type="text" class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"  required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
				<input type="text" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"  required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor PKB</label>
				<input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Total Nominal Pajak Kendaraan</label>
				<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb"  maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor SKUM</label>
				<input type="text" class="form-control input-sm" id="noskum" style="text-transform:uppercase" name="noskum" placeholder="Nomor SKUM"  maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor KOHIR</label>
				<input type="text" class="form-control input-sm" id="nokohir" style="text-transform:uppercase" name="nokohir" placeholder="Nomor KOHIR"  maxlength="20" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="hold_stnk" id="hold_stnk">
					 <option value="NO">TIDAK</option> 
					 <option value="YES">YA</option> 
					</select>
			  </div>
			<div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>	
					<select class="form-control input-sm" name="kdasuransi" id="kdasuransi">
					<option value="">-----PILIH ASURANSI JIKA ADA-----</option> 
					  <?php foreach($list_asuransi as $sc){?>					  
					  <option value="<?php echo trim($sc->kdasuransi);?>" ><?php echo trim($sc->kdasuransi).' || '.trim($sc->nmasuransi);?></option>						  
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
  </div>
</div>	
</div>			
<!-- -->

<!-- EDIT KENDARAAN -->
<?php foreach ($list_mstkendaraan as $ls){ ?>
<div class="modal fade" id="ED<?php echo trim($ls->kdrangka);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
				<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" value="<?php echo trim($ls->kdrangka);?>" placeholder="Nomor Rangka Dari STNKB" maxlength="25" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor Mesin</label>
				<input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" value="<?php echo trim($ls->kdmesin);?>"  placeholder="Nomor Mesin Dari STNKB"  maxlength="25" readonly >
			  </div>
			  <div class="form-group">
				<label for="inputsm">NOPOL</label>
				<input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" value="<?php echo trim($ls->nopol);?>"  placeholder="Nomor Nopol Dari STNKB"  maxlength="20" >
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Group</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup">
					  <option <?php if (trim($ls->kdgroup)=='') { echo 'selected';}?>   value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_sckendaraan as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Cabang</label>	
					<select class="form-control input-sm" name="kdcabang" id="kdcabang">
					<option <?php if (trim($ls->kdgudang)=='') { echo 'selected';}?>  value="">---PILIH KANTOR CABANG PENEMPATAN--</option> 
					<?php foreach($list_kanwil as $sc){?>					  
						<option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">Nama Kendaraan</label>
				<input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan"  value="<?php echo trim($ls->nmbarang);?>" placeholder="Nama Kendaraan"  maxlength="30" required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nama Pemilik</label>
				<input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik"  value="<?php echo trim($ls->nmpemilik);?>" placeholder="Nama Pemilik"   maxlength="30" required>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Alamat Pemilik</label>
				<input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik"  value="<?php echo trim($ls->addpemilik);?>"  placeholder="Alamat Pemilik"   maxlength="100" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Contact Pemilik</label>
				<input type="text" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik"  value="<?php echo trim($ls->hppemilik);?>" placeholder="No HP Pemilik Jika Ada"  maxlength="30">
			  </div>
			</div> <!---- col 1 -->
			<div class='col-sm-4'>	
			 <div class="form-group">
				<label for="inputsm">TYPE Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase"  value="<?php echo trim($ls->typeid);?>" placeholder="Type Kendaraan Di STNKB"  maxlength="20">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Jenis Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid"  value="<?php echo trim($ls->jenisid);?>" placeholder="Jenis Kendaraan Di STNKB"  maxlength="20">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Model Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid"  value="<?php echo trim($ls->modelid);?>" placeholder="Model Kendaraan Di STNKB"  maxlength="20">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Tahun Pembuatan</label>
				<input type="text" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"  value="<?php echo trim($ls->tahunpembuatan);?>" >
			  </div>
			  <div class="form-group">
				<label for="inputsm">Volume Silinder</label>
				<input type="text" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder"  value="<?php echo trim($ls->silinder);?>" placeholder="Silinder CC di STNKB"  maxlength="20">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Warna Kendaraan</label>
				<input type="text" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna"  value="<?php echo trim($ls->warna);?>" placeholder="Warna Kendaraan"  maxlength="20">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Bahan Bakar</label>
				<input type="text" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar"  value="<?php echo trim($ls->bahanbakar);?>" placeholder="Bahan Bakar"  maxlength="20">
			  </div>
			   <div class="form-group">
				<label for="inputsm">Warna TNKB</label>
				<input type="text" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb"  value="<?php echo trim($ls->warnatnkb);?>"  placeholder="Warna TNKB"  maxlength="20">
			  </div>
			   <div class="form-group">
				<label for="inputsm">Nomor BPKB</label>
				<input type="text" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" value="<?php echo trim($ls->nobpkb);?>"  placeholder="Nomor BPKB"  maxlength="20">
			  </div>
			  </div> <!---- col 2 -->
			<div class='col-sm-4'>	
			  <div class="form-group">
				<label for="inputsm">Lokasi Dari STNKB</label>
				<input type="text" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi"  value="<?php echo trim($ls->kdlokasi);?>" placeholder="Lokasi Dari STNKB"  maxlength="20">
			  </div>
			  <div class="form-group">
				<label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
				<input type="text" class="form-control input-sm tgl" id="expstnkb1" name="expstnkb1"  data-date-format="dd-mm-yyyy"   value=<?php echo date('d-m-Y', strtotime(trim($ls->expstnkb)));?>  readonly disabled>
				<input type="hidden" class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"   value=<?php echo date('d-m-Y', strtotime(trim($ls->expstnkb)));?> >
			  </div>
			  <div class="form-group">
				<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
				<input type="text" class="form-control input-sm tgl" id="exppkbstnkb1" name="exppkbstnkb1"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($ls->exppkbstnkb)));?>  readonly disabled >
				<input type="hidden" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($ls->exppkbstnkb)));?>>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor PKB</label>
				<input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb"   value="<?php echo trim($ls->nopkb);?>" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="25">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Total Nominal Pajak Kendaraan</label>
				<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb"  value="<?php echo trim($ls->nominalpkb);?>" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor SKUM</label>
				<input type="text" class="form-control input-sm" id="noskum" style="text-transform:uppercase" name="noskum"  value="<?php echo trim($ls->noskum);?>" placeholder="Nomor SKUM"  maxlength="25">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor KOHIR</label>
				<input type="text" class="form-control input-sm" id="nokohir" style="text-transform:uppercase" name="nokohir"  value="<?php echo trim($ls->nokohir);?>" placeholder="Nomor KOHIR" maxlength="25">
			  </div>
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="hold_stnk" id="hold_stnk">
					 <option <?php if (trim($ls->hold_item)=='NO') { echo 'selected'; } ?> value="NO">TIDAK</option> 
					 <option <?php if (trim($ls->hold_item)=='YES') { echo 'selected'; } ?> value="YES">YA</option> 
					</select>
			  </div>
			<div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>	
					<select class="form-control input-sm" name="kdasuransi" id="kdasuransi">
					<option <?php if (trim($ls->kdasuransi)=='') { echo 'selected';}?>   value="">-----PILIH ASURANSI JIKA ADA-----</option> 
					  <?php foreach($list_asuransi as $sc){?>					  
					  <option <?php if (trim($ls->kdasuransi)==trim($sc->kdasuransi)) { echo 'selected';}?>  value="<?php echo trim($sc->kdasuransi);?>" ><?php echo trim($sc->kdasuransi).' || '.trim($sc->nmasuransi);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"  maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($ls->keterangan);?></textarea>
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

<!-- DELETE KENDARAAN -->
<?php foreach ($list_mstkendaraan as $ls){ ?>
<div class="modal fade" id="DEL<?php echo trim($ls->kdrangka);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
				<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" value="<?php echo trim($ls->kdrangka);?>" placeholder="Nomor Rangka Dari STNKB" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor Mesin</label>
				<input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" value="<?php echo trim($ls->kdmesin);?>"  placeholder="Nomor Mesin Dari STNKB"  readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">NOPOL</label>
				<input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" value="<?php echo trim($ls->nopol);?>"  placeholder="Nomor Nopol Dari STNKB" readonly>
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Group</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup" readonly disabled>
					  <?php foreach($list_sckendaraan as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)=='') { echo 'selected';}?>   value="">---PILIH KODE GROUP--</option> 
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Cabang</label>	
					<select class="form-control input-sm" name="kdcabang" id="kdcabang"  readonly disabled>
					<?php foreach($list_kanwil as $sc){?>					  
						<option <?php if (trim($ls->kdgudang)=='') { echo 'selected';}?>  value="">---PILIH KANTOR CABANG PENEMPATAN--</option> 
						<option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">Nama Kendaraan</label>
				<input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan"  value="<?php echo trim($ls->nmbarang);?>" placeholder="Nama Kendaraan"  readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nama Pemilik</label>
				<input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik"  value="<?php echo trim($ls->nmpemilik);?>" placeholder="Nama Pemilik" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Alamat Pemilik</label>
				<input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik"  value="<?php echo trim($ls->addpemilik);?>"  placeholder="Alamat Pemilik" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Contact Pemilik</label>
				<input type="text" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik"  value="<?php echo trim($ls->hppemilik);?>" placeholder="No HP Pemilik Jika Ada" readonly>
			  </div>
			</div> <!---- col 1 -->
			<div class='col-sm-4'>	
			 <div class="form-group">
				<label for="inputsm">TYPE Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase"  value="<?php echo trim($ls->typeid);?>" placeholder="Type Kendaraan Di STNKB" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Jenis Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid"  value="<?php echo trim($ls->jenisid);?>" placeholder="Jenis Kendaraan Di STNKB" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Model Kendaraan STNKB</label>
				<input type="text" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid"  value="<?php echo trim($ls->modelid);?>" placeholder="Model Kendaraan Di STNKB" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Tahun Pembuatan</label>
				<input type="text" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"  value="<?php echo trim($ls->tahunpembuatan);?>" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Volume Silinder</label>
				<input type="text" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder"  value="<?php echo trim($ls->silinder);?>" placeholder="Silinder CC di STNKB" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Warna Kendaraan</label>
				<input type="text" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna"  value="<?php echo trim($ls->warna);?>" placeholder="Warna Kendaraan" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Bahan Bakar</label>
				<input type="text" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar"  value="<?php echo trim($ls->bahanbakar);?>" placeholder="Bahan Bakar" readonly>
			  </div>
			   <div class="form-group">
				<label for="inputsm">Warna TNKB</label>
				<input type="text" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb"  value="<?php echo trim($ls->warnatnkb);?>"  placeholder="Warna TNKB" readonly>
			  </div>
			   <div class="form-group">
				<label for="inputsm">Nomor BPKB</label>
				<input type="text" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" value="<?php echo trim($ls->nobpkb);?>"  placeholder="Nomor BPKB" readonly>
			  </div>
			  </div> <!---- col 2 -->
			<div class='col-sm-4'>	
			  <div class="form-group">
				<label for="inputsm">Lokasi Dari STNKB</label>
				<input type="text" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi"  value="<?php echo trim($ls->kdlokasi);?>" placeholder="Lokasi Dari STNKB" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
				<input type="text" class="form-control input-sm tgl" id="expstnkb1" name="expstnkb1"  data-date-format="dd-mm-yyyy"   value=<?php echo date('d-m-Y', strtotime(trim($ls->expstnkb)));?>  readonly disabled>
				<input type="hidden" class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"   value=<?php echo date('d-m-Y', strtotime(trim($ls->expstnkb)));?> >
			  </div>
			  <div class="form-group">
				<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
				<input type="text" class="form-control input-sm tgl" id="exppkbstnkb1" name="exppkbstnkb1"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($ls->exppkbstnkb)));?>  readonly disabled >
				<input type="hidden" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($ls->exppkbstnkb)));?>>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor PKB</label>
				<input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb"   value="<?php echo trim($ls->nopkb);?>" placeholder="Nomor Pajak Kendaraan Bermotor" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Total Nominal Pajak Kendaraan</label>
				<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb"  value="<?php echo trim($ls->nominalpkb);?>" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor SKUM</label>
				<input type="text" class="form-control input-sm" id="noskum" style="text-transform:uppercase" name="noskum"  value="<?php echo trim($ls->noskum);?>" placeholder="Nomor SKUM" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">Nomor KOHIR</label>
				<input type="text" class="form-control input-sm" id="nokohir" style="text-transform:uppercase" name="nokohir"  value="<?php echo trim($ls->nokohir);?>" placeholder="Nomor KOHIR" readonly>
			  </div>
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="hold_stnk" id="hold_stnk" readonly disabled>
					 <option <?php if (trim($ls->hold_item)=='NO') { echo 'selected'; } ?> value="NO">TIDAK</option> 
					 <option <?php if (trim($ls->hold_item)=='YES') { echo 'selected'; } ?> value="YES">YA</option> 
					</select>
			  </div>
			<div class="form-group">
				<label for="inputsm">KODE ASURANSI</label>	
					<select class="form-control input-sm" name="kdasuransi" id="kdasuransi"  readonly disabled>
					  <?php foreach($list_asuransi as $sc){?>					  
					  <option <?php if (trim($ls->kdasuransi)=='') { echo 'selected';}?>   value="">-----PILIH ASURANSI JIKA ADA-----</option> 
					  <option <?php if (trim($ls->kdasuransi)==trim($sc->kdasuransi)) { echo 'selected';}?>  value="<?php echo trim($sc->kdasuransi);?>" ><?php echo trim($sc->kdasuransi).' || '.trim($sc->nmasuransi);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"  maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  readonly disabled><?php echo trim($ls->keterangan);?></textarea>
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