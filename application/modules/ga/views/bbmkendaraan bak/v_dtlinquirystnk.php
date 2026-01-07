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
				$("#example1").dataTable({
					"autoWidth": false
				});
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				/*$('#example1').bootstrapTable({
						resizable: true,
						headerOnly: true,
						data: data
				});*/
			//	$("#tglrange").daterangepicker(); 
            });
					
			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
	
<div class="row">

	<div>
	 <form action="<?php echo site_url('ga/kendaraan/listmobil_inquirystnk')?>" method="post">
	 <input type="hidden" class="form-control input-sm" id="kdcabang" name="kdcabang" value="<?php echo trim($kdgudang);?>">
	 <button type="submit" style="margin:10px; color:#000000;" class="btn btn-default">Kembali</button>
	 </form>
	<!--a href="<?php echo site_url('ga/kendaraan/inquirystnk');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a-->
	</div>
</div>	
</br>

<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
	
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped uk-overflow-container" >
					<thead>
								<tr>											
									<th width="2%">No.</th>
									<th>NO DOKUMEN</th>
									<th class="col-lg-12">TGL DOKUMEN</th>
									<th>NAMA KENDARAAN</th>
									<th>NOPOL</th>
									<th>NO RANGKA</th>
									<th>NO MESIN</th>
									<th>PEMILIK STNK</th>
									<th>BIAYA PKB</th>
									<th width="900">BERLAKU STNKB</th>
									<th width="400px">BERLAKU PKB STNKB</th>
									<th>NOPOL LAMA</th>
									<th>PEMILIK STNK LAMA</th>
									<th width="200%">BERLAKU STNKB LAMA</th>
									<th width="20%">BERLAKU PKB STNKB LAMA</th>
									<th>BIAYA PKB LAMA</th>
									<th>STATUS</th>
									<th>AKSI</th>		
								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_histnkb as $row): $no++;?>
						<tr>
							
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo $row->nodok;?></td>
							<td class="col-md-5"><?php echo date('d-m-Y', strtotime(trim($row->tgldok)));?></td>
							<td><?php echo $row->nmkendaraan;?></td>
							<td><?php echo $row->nopol;?></td>
							<td><?php echo $row->kdrangka;?></td>
							<td><?php echo $row->kdmesin;?></td>
							<td><?php echo $row->nmpemilik;?></td>
							<td align='right'><?php echo $row->nominalpkb;?></td>
							<td  width="900"><?php echo date('d-m-Y', strtotime(trim($row->expstnkb)));?></td>
							<td width="400px"><?php echo date('d-m-Y', strtotime(trim($row->exppkbstnkb)));?></td>
							<td><?php echo $row->old_nopol;?></td>
							<td><?php echo $row->old_nmpemilik;?></td>
							<td width="200%"><?php echo date('d-m-Y', strtotime(trim($row->old_expstnkb)));?></td>
							<td width="20%"><?php echo date('d-m-Y', strtotime(trim($row->old_exppkbstnkb)));?></td>
							<td align='right'><?php echo $row->old_nominalpkb;?></td>
							<td><?php echo trim($row->status);?></td>
							<td width="15%">
				
									<a href="#" data-toggle="modal" data-target="#DETAIL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm">
										<i class="fa fa-edit"></i> DETAIL
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

<!-- EDIT DATA -->
<?php foreach ($list_histnkb as $ls){ ?>
<div class="modal fade" id="EDIT<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">UBAH DATA HISTORY STNKB</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/save_stnkbaru');?>" method="post">
		<div class='row'>
						<div class='col-sm-4'>	
						<div class="form-group">
							<label for="inputsm">Nomor Dokumen</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($ls->nodok);?>" readonly>
							<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
						  </div>
						 <div class="form-group">
							<label for="inputsm">Nomor Rangka</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($ls->kdrangka);?>" readonly>
						</div>
						  <div class="form-group">
							<label for="inputsm">Nomor Mesin</label>
							<input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" value="<?php echo trim($ls->kdmesin);?>"  readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">NOPOL</label>
							<input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB"  value="<?php echo trim($ls->nopol);?>" maxlength="20" required>
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
							<input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan"  value="<?php echo trim($ls->nmkendaraan);?>"  maxlength="30" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nama Pemilik</label>
							<input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="30"  value="<?php echo trim($ls->nmpemilik);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Alamat Pemilik</label>
							<input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  maxlength="100"  value="<?php echo trim($ls->addpemilik);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Contact Pemilik</label>
							<input type="text" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada"  maxlength="30"  value="<?php echo trim($ls->hppemilik);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Tahun Reg</label>
							<input type="text" class="form-control input-sm year" id="tahunreg" style="text-transform:uppercase" name="tahunreg" placeholder="Tahun Reg Pada STNK"  maxlength="30"  value="<?php echo trim($ls->tahunreg);?>" required>
						  </div>
						</div> <!---- col 1 -->
						<div class='col-sm-4'>	
						 <div class="form-group">
							<label for="inputsm">TYPE Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->typeid);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Jenis Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->jenisid);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Model Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->modelid);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Tahun Pembuatan</label>
							<input type="text" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"   value="<?php echo trim($ls->tahunpembuatan);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Volume Silinder</label>
							<input type="text" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20"  value="<?php echo trim($ls->silinder);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Warna Kendaraan</label>
							<input type="text" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20" value="<?php echo trim($ls->warna);?>" required >
						  </div>
						  <div class="form-group">
							<label for="inputsm">Bahan Bakar</label>
							<input type="text" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"   value="<?php echo trim($ls->bahanbakar);?>" required>
						  </div>
						   <div class="form-group">
							<label for="inputsm">Warna TNKB</label>
							<input type="text" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20"  value="<?php echo trim($ls->warnatnkb);?>" required>
						  </div>
						   <div class="form-group">
							<label for="inputsm">Nomor BPKB</label>
							<input type="text" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20"  value="<?php echo trim($ls->nobpkb);?>" required>
						  </div>
						  </div> <!---- col 2 -->
						<div class='col-sm-4'>	
						  <div class="form-group">
							<label for="inputsm">Lokasi Dari STNKB</label>
							<input type="text" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20"  value="<?php echo trim($ls->kdlokasi);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
							<input type="text" class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($ls->expstnkb)));?> required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
							<input type="text" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"   value=<?php echo date('d-m-Y', strtotime(trim($ls->exppkbstnkb)));?> required>
						  </div>
						  <!--div class="form-group">
							<label for="inputsm">Nomor PKB</label>
							<input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" value="<?php echo trim($ls->nopkb);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Total BIAYA Pajak Kendaraan (PKB)</label>
							<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb"  maxlength="20" value="<?php echo trim($ls->nominalpkb);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor SKUM</label>
							<input type="text" class="form-control input-sm" id="noskum" style="text-transform:uppercase" name="noskum" placeholder="Nomor SKUM"  maxlength="20" value="<?php echo trim($ls->noskum);?>" required>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor KOHIR</label>
							<input type="text" class="form-control input-sm" id="nokohir" style="text-transform:uppercase" name="nokohir" placeholder="Nomor KOHIR"  maxlength="20" value="<?php echo trim($ls->nokohir);?>" required>
						  </div--->
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
							<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($ls->keterangan);?></textarea>
						  </div>
		</div> 
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">UBAH DATA</button>
      </div>
		</form>
		
		</div>  
  </div>
</div>							
</div>							
</div>							
<?php } ?>
<!-- END  UBAH DATA STNKB --->

<!-- APROVAL DATA -->
<?php foreach ($list_histnkb as $ls){ ?>
<div class="modal fade" id="AP<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL APPROVAL</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/save_stnkbaru');?>" method="post">
		<div class='row'>
						<div class='col-sm-4'>	
						<div class="form-group">
							<label for="inputsm">Nomor Dokumen</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($ls->nodok);?>" readonly>
							<input type="hidden" class="form-control input-sm" id="type" name="type" value="APPROVAL">
						  </div>
						 <div class="form-group">
							<label for="inputsm">Nomor Rangka</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($ls->kdrangka);?>" readonly>
						</div>
						  <div class="form-group">
							<label for="inputsm">Nomor Mesin</label>
							<input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" value="<?php echo trim($ls->kdmesin);?>"  readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">NOPOL</label>
							<input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB"  value="<?php echo trim($ls->nopol);?>" maxlength="20" readonly>
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
							<input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan"  value="<?php echo trim($ls->nmkendaraan);?>"  maxlength="30" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nama Pemilik</label>
							<input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="30"  value="<?php echo trim($ls->nmpemilik);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Alamat Pemilik</label>
							<input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  maxlength="100"  value="<?php echo trim($ls->addpemilik);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Contact Pemilik</label>
							<input type="text" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada"  maxlength="30"  value="<?php echo trim($ls->hppemilik);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Tahun Reg</label>
							<input type="text" class="form-control input-sm year" id="tahunreg" style="text-transform:uppercase" name="tahunreg" placeholder="Tahun Reg Pada STNK"  maxlength="30"  value="<?php echo trim($ls->tahunreg);?>" readonly>
						  </div>
						</div> <!---- col 1 -->
						<div class='col-sm-4'>	
						 <div class="form-group">
							<label for="inputsm">TYPE Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->typeid);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Jenis Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->jenisid);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Model Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->modelid);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Tahun Pembuatan</label>
							<input type="text" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"   value="<?php echo trim($ls->tahunpembuatan);?>" readonly disabled>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Volume Silinder</label>
							<input type="text" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20"  value="<?php echo trim($ls->silinder);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Warna Kendaraan</label>
							<input type="text" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20" value="<?php echo trim($ls->warna);?>" readonly >
						  </div>
						  <div class="form-group">
							<label for="inputsm">Bahan Bakar</label>
							<input type="text" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"   value="<?php echo trim($ls->bahanbakar);?>" readonly>
						  </div>
						   <div class="form-group">
							<label for="inputsm">Warna TNKB</label>
							<input type="text" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20"  value="<?php echo trim($ls->warnatnkb);?>" readonly>
						  </div>
						   <div class="form-group">
							<label for="inputsm">Nomor BPKB</label>
							<input type="text" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20"  value="<?php echo trim($ls->nobpkb);?>" readonly>
						  </div>
						  </div> <!---- col 2 -->
						<div class='col-sm-4'>	
						  <div class="form-group">
							<label for="inputsm">Lokasi Dari STNKB</label>
							<input type="text" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20"  value="<?php echo trim($ls->kdlokasi);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
							<input type="text" class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($ls->expstnkb)));?> readonly disabled>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
							<input type="text" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"   value=<?php echo date('d-m-Y', strtotime(trim($ls->exppkbstnkb)));?> readonly disabled>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor PKB</label>
							<input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" value="<?php echo trim($ls->nopkb);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Total BIAYA Pajak Kendaraan (PKB)</label>
							<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb"  maxlength="20" value="<?php echo trim($ls->nominalpkb);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor SKUM</label>
							<input type="text" class="form-control input-sm" id="noskum" style="text-transform:uppercase" name="noskum" placeholder="Nomor SKUM"  maxlength="20" value="<?php echo trim($ls->noskum);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor KOHIR</label>
							<input type="text" class="form-control input-sm" id="nokohir" style="text-transform:uppercase" name="nokohir" placeholder="Nomor KOHIR"  maxlength="20" value="<?php echo trim($ls->nokohir);?>" readonly>
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
							<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" readonly disabled><?php echo trim($ls->keterangan);?></textarea>
						  </div>
		</div> 
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">APPROVAL</button>
      </div>
		</form>
		
		</div>  
  </div>
</div>							
</div>							
</div>							
<?php } ?>
<!-- END  APPROVAL DATA STNKB --->


<!-- HAPUS INPUT DATA STNKB -->
<?php foreach ($list_histnkb as $ls){ ?>
<div class="modal fade" id="DEL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL HAPUS INPUT</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/save_stnkbaru');?>" method="post">
		<div class='row'>
						<div class='col-sm-4'>	
						<div class="form-group">
							<label for="inputsm">Nomor Dokumen</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($ls->nodok);?>" readonly>
							<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
						  </div>
						 <div class="form-group">
							<label for="inputsm">Nomor Rangka</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($ls->kdrangka);?>" readonly>
						</div>
						  <div class="form-group">
							<label for="inputsm">Nomor Mesin</label>
							<input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" value="<?php echo trim($ls->kdmesin);?>"  readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">NOPOL</label>
							<input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB"  value="<?php echo trim($ls->nopol);?>" maxlength="20" readonly>
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
							<input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan"  value="<?php echo trim($ls->nmkendaraan);?>"  maxlength="30" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nama Pemilik</label>
							<input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="30"  value="<?php echo trim($ls->nmpemilik);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Alamat Pemilik</label>
							<input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  maxlength="100"  value="<?php echo trim($ls->addpemilik);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Contact Pemilik</label>
							<input type="text" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada"  maxlength="30"  value="<?php echo trim($ls->hppemilik);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Tahun Reg</label>
							<input type="text" class="form-control input-sm year" id="tahunreg" style="text-transform:uppercase" name="tahunreg" placeholder="Tahun Reg Pada STNK"  maxlength="30"  value="<?php echo trim($ls->tahunreg);?>" readonly>
						  </div>
						</div> <!---- col 1 -->
						<div class='col-sm-4'>	
						 <div class="form-group">
							<label for="inputsm">TYPE Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->typeid);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Jenis Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->jenisid);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Model Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->modelid);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Tahun Pembuatan</label>
							<input type="text" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"   value="<?php echo trim($ls->tahunpembuatan);?>" readonly disabled>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Volume Silinder</label>
							<input type="text" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20"  value="<?php echo trim($ls->silinder);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Warna Kendaraan</label>
							<input type="text" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20" value="<?php echo trim($ls->warna);?>" readonly >
						  </div>
						  <div class="form-group">
							<label for="inputsm">Bahan Bakar</label>
							<input type="text" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"   value="<?php echo trim($ls->bahanbakar);?>" readonly>
						  </div>
						   <div class="form-group">
							<label for="inputsm">Warna TNKB</label>
							<input type="text" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20"  value="<?php echo trim($ls->warnatnkb);?>" readonly>
						  </div>
						   <div class="form-group">
							<label for="inputsm">Nomor BPKB</label>
							<input type="text" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20"  value="<?php echo trim($ls->nobpkb);?>" readonly>
						  </div>
						  </div> <!---- col 2 -->
						<div class='col-sm-4'>	
						  <div class="form-group">
							<label for="inputsm">Lokasi Dari STNKB</label>
							<input type="text" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20"  value="<?php echo trim($ls->kdlokasi);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
							<input type="text" class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($ls->expstnkb)));?> readonly disabled>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
							<input type="text" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"   value=<?php echo date('d-m-Y', strtotime(trim($ls->exppkbstnkb)));?> readonly disabled>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor PKB</label>
							<input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" value="<?php echo trim($ls->nopkb);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Total BIAYA Pajak Kendaraan (PKB)</label>
							<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb"  maxlength="20" value="<?php echo trim($ls->nominalpkb);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor SKUM</label>
							<input type="text" class="form-control input-sm" id="noskum" style="text-transform:uppercase" name="noskum" placeholder="Nomor SKUM"  maxlength="20" value="<?php echo trim($ls->noskum);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor KOHIR</label>
							<input type="text" class="form-control input-sm" id="nokohir" style="text-transform:uppercase" name="nokohir" placeholder="Nomor KOHIR"  maxlength="20" value="<?php echo trim($ls->nokohir);?>" readonly>
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
							<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" readonly disabled><?php echo trim($ls->keterangan);?></textarea>
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
</div>									
<?php } ?>
<!-- END  HAPUS INPUT DATA STNKB --->



<!-- DETAIL PERUBAHAN STNKB -->
<?php foreach ($list_histnkb as $ls){ ?>
<div class="modal fade" id="DETAIL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL DATA</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="#" method="post">
		<div class='row'>
						<div class='col-sm-4'>	
						<div class="form-group">
							<label for="inputsm">Nomor Dokumen</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($ls->nodok);?>" readonly>
							<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
						  </div>
						 <div class="form-group">
							<label for="inputsm">Nomor Rangka</label>
							<input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($ls->kdrangka);?>" readonly>
						</div>
						  <div class="form-group">
							<label for="inputsm">Nomor Mesin</label>
							<input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" value="<?php echo trim($ls->kdmesin);?>"  readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">NOPOL</label>
							<input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB"  value="<?php echo trim($ls->nopol);?>" maxlength="20" readonly>
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
							<input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan"  value="<?php echo trim($ls->nmkendaraan);?>"  maxlength="30" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nama Pemilik</label>
							<input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="30"  value="<?php echo trim($ls->nmpemilik);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Alamat Pemilik</label>
							<input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  maxlength="100"  value="<?php echo trim($ls->addpemilik);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Contact Pemilik</label>
							<input type="text" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada"  maxlength="30"  value="<?php echo trim($ls->hppemilik);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Tahun Reg</label>
							<input type="text" class="form-control input-sm year" id="tahunreg" style="text-transform:uppercase" name="tahunreg" placeholder="Tahun Reg Pada STNK"  maxlength="30"  value="<?php echo trim($ls->tahunreg);?>" readonly>
						  </div>
						</div> <!---- col 1 -->
						<div class='col-sm-4'>	
						 <div class="form-group">
							<label for="inputsm">TYPE Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->typeid);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Jenis Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->jenisid);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Model Kendaraan STNKB</label>
							<input type="text" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20"  value="<?php echo trim($ls->modelid);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Tahun Pembuatan</label>
							<input type="text" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"   value="<?php echo trim($ls->tahunpembuatan);?>" readonly disabled>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Volume Silinder</label>
							<input type="text" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20"  value="<?php echo trim($ls->silinder);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Warna Kendaraan</label>
							<input type="text" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20" value="<?php echo trim($ls->warna);?>" readonly >
						  </div>
						  <div class="form-group">
							<label for="inputsm">Bahan Bakar</label>
							<input type="text" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"   value="<?php echo trim($ls->bahanbakar);?>" readonly>
						  </div>
						   <div class="form-group">
							<label for="inputsm">Warna TNKB</label>
							<input type="text" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20"  value="<?php echo trim($ls->warnatnkb);?>" readonly>
						  </div>
						   <div class="form-group">
							<label for="inputsm">Nomor BPKB</label>
							<input type="text" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20"  value="<?php echo trim($ls->nobpkb);?>" readonly>
						  </div>
						  </div> <!---- col 2 -->
						<div class='col-sm-4'>	
						  <div class="form-group">
							<label for="inputsm">Lokasi Dari STNKB</label>
							<input type="text" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20"  value="<?php echo trim($ls->kdlokasi);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
							<input type="text" class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($ls->expstnkb)));?> readonly disabled>
						  </div>
						  <div class="form-group">
							<label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
							<input type="text" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"   value=<?php echo date('d-m-Y', strtotime(trim($ls->exppkbstnkb)));?> readonly disabled>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor PKB</label>
							<input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" value="<?php echo trim($ls->nopkb);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Total BIAYA Pajak Kendaraan (PKB)</label>
							<input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb"  maxlength="20" value="<?php echo trim($ls->nominalpkb);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor SKUM</label>
							<input type="text" class="form-control input-sm" id="noskum" style="text-transform:uppercase" name="noskum" placeholder="Nomor SKUM"  maxlength="20" value="<?php echo trim($ls->noskum);?>" readonly>
						  </div>
						  <div class="form-group">
							<label for="inputsm">Nomor KOHIR</label>
							<input type="text" class="form-control input-sm" id="nokohir" style="text-transform:uppercase" name="nokohir" placeholder="Nomor KOHIR"  maxlength="20" value="<?php echo trim($ls->nokohir);?>" readonly>
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
							<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" readonly disabled><?php echo trim($ls->keterangan);?></textarea>
						  </div>
		</div> 
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<!--button type="submit" class="btn btn-DANGER">HAPUS</button--->
      </div>
		</form>
		
		</div>  
  </div>
</div>									
</div>									
</div>									
<?php } ?>
<!-- END  HAPUS INPUT DATA STNKB --->

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