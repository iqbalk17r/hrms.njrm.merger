<?php 
/*
	@author : hanif_anak_metal \m/
*/
error_reporting(0);
?>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<?php echo validation_errors();?>
<div class="col-sm-6">
	<div class="box box-info col-sm-6">
		<div class="box-body" style="padding:5px;">
			<form action="<?php echo site_url('hrd/hrd/simpan_peg');?>" name="form" role="form" method="post">
				<div class="form-group">
					<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>
					<label for="inputnip" class="col-sm-3 control-label">NIP</label>
					<div class="col-sm-6">
						<!--Untuk Sementara di non aktifkan -->
						<!--<b><?php echo $peg_edit['list_nip'];?></b>-->
						<input type="hidden" class="form-control input-sm" value="editpeg" id="tipe" name="tipe" required>
						<input type="text" class="form-control input-sm" value="<?php echo $peg_edit['list_nip'];?>" id="nip" name="nip" readonly>
						<input type="hidden" class="form-control input-sm" value="<?php echo $peg_edit['list_nip'];?>" id="nip" name="oldnip" readonly>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputnama" class="col-sm-3 control-label">Nama Lengkap</label>
					<div class="col-sm-6">
						<input type="text" class="form-control input-sm" value="<?php echo $peg_edit['nmlengkap'];?>" id="nama" name="nama" style="text-transform:uppercase">
					</div>
					<div class="col-sm-10"></div>
				</div>				
				<script type="text/javascript" charset="utf-8">
				  $(function() {	
					$("#csubdept").chained("#cdept");		
					$("#cjabt").chained("#csubdept");		
				  });
				</script>
				<div class="form-group">
					<label for="inputdept" class="col-sm-3 control-label">Departemen</label>
					<div class="col-sm-6">
						<select class='form-control input-sm' name="dept" id="cdept" required>		
							<option value="">-Pilih Departemen-</option>
							<?php
								if(empty($qdepartement))
								{
								echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								}else
								{
								foreach($qdepartement as $column)
								{
								?>
								<option value="<?php echo trim($column->kddept);?>" <?php if ($peg_edit['kddept']==$column->kddept){ echo 'selected';}?>><?php echo $column->departement; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputsub" class="col-sm-3 control-label">Sub Departemen</label>
					<div class="col-sm-6">
						<select class="form-control input-sm" name="sub" id="csubdept">
							
							<?php
								if(empty($qsubdepartement))
								{
								echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								}else
								{
								foreach($qsubdepartement as $column)
								{ 
								?>
								<option value="<?php echo trim($column->kddept).'|'.trim($column->kdsubdept);?>" <?php if ($peg_edit['kdsubdept']==$column->kdsubdept){ echo 'selected';}?> class="<?php echo trim($column->kddept);?>"><?php echo $column->subdepartement; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputjab" class="col-sm-3 control-label">Jabatan</label>
					<div class="col-sm-6">
						<select class="form-control input-sm" name="jabt" id="cjabt" required>
							<!--<option value="">-Pilih Jabatan-</option>-->
							<?php
								if(empty($qjabatan))
								{
								echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								}else
								{
								foreach($qjabatan as $column)
								{
								?>
								<option value="<?php echo $column->kdjabatan; ?>" <?php if ($peg_edit['kdjabatan']==$column->kdjabatan){ echo 'selected';}?> class="<?php echo trim($column->kddept).'|'.trim($column->kdsubdept);?>"><?php echo $column->deskripsi; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Level Jabatan</label>
					<div class="col-sm-6">
						<select class='form-control input-sm' name="lvljabt" id="atasan">	
							<?php foreach ($qlvljabt as $ljab){?>
								<option value="<?php echo trim($ljab->kdjabatan);?>" <?php if (trim($peg_edit['kduangmkn'])==trim($ljab->kdjabatan)){echo 'selected';}?>><?php echo $ljab->descjabatan;?></option>
							<?php }?>
						</select>
						<!--<input type="text" class="form-control input-sm" name="badgenumber" value="<?php echo $peg_edit['badgenumber'];?>" >-->
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputatasan" class="col-sm-3 control-label">Atasan Karyawan</label>
					<div class="col-sm-6">
						<select class='form-control input-sm' name="atasan" id="atasan">		
							<option value="">-Pilih Atasan-</option>
							<?php
								if(empty($qatasan))
								{
								echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								}else
								{
								foreach($qatasan as $column)
								{
								?>
								<option value="<?php echo $column->list_nip; ?>" <?php if ($peg_edit['nipatasan']==$column->list_nip){echo 'selected';}?>><?php echo $column->nmlengkap; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<!-- Hidden wilayah pegawai
				<div class="form-group">
					<label for="inputwil" class="col-sm-3 control-label">Wilayah</label>
					<div class="col-sm-6">
						<select class="form-control input-sm" name="wil" id="wil" required>
							<option value="">-Pilih Wilayah-</option>
							<?php
								if(empty($qwilayah))
								{
								echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								}else
								{
								foreach($qwilayah as $column)
								{
								?>
								<option value="<?php echo $column->area; ?>"><?php echo $column->areaname; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				-->
				<div class="form-group">
					<label for="inputjk" class="col-sm-3 control-label">Jenis Kelamin</label>
					<div class="col-sm-6">
						<select class="form-control input-sm" name="jk" id="jk">
						<?php if ($peg_edit['kdkelamin']=='B')							{
							echo '<option selected value="B">Laki-laki</option>';
							echo '<option value="A">Perempuan</option>';
						} else {
							echo '<option value="B">Laki-laki</option>';
							echo '<option selected value="A">Perempuan</option>';
						}
						?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputalamat" class="col-sm-3 control-label">Alamat</label>
					<div class="col-sm-6">
						<textarea class="form-control input-sm" rows="3" name="alamat" id="alamat" placeholder="alamat"><?php echo $peg_edit['alamat'];?></textarea>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputkota" class="col-sm-3 control-label">Kota</label>
						<div class="col-sm-6">
							<input type="text" class="form-control input-sm" value="<?php echo $peg_edit['kota'];?>" id="kota" name="kota">
						</div>
						<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputttl" class="col-sm-3 control-label">Tempat Lahir</label>
						<div class="col-sm-6">
							<input type="text" class="form-control input-sm" value="<?php echo $peg_edit['tempatlahir'];?>" id="tempat" name="tempatlhr">
						</div>
						<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputttl" class="col-sm-3 control-label">Tanggal Lahir</label>
						<div class="col-sm-6">							
							<input type="text" class="form-control input-sm" value="<?php
								$timestamp = strtotime($peg_edit['tgllahir']);
								$tanggal = date('d-m-Y',$timestamp);
								echo $tanggal;
							?>" id="tanggal" name="tanggallhr" required data-date-format="dd-mm-yyyy">						
						</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputstatusrmh" class="col-sm-3 control-label">Kantor</label>
					<div class="col-sm-6">
						<select class="form-control input-sm" name="kantorcabang" id="statusrmh" required>
						  <?php foreach($list_kantor as $listkan){?>
						  <option value="<?php echo $listkan->kodecabang;?>" <?php if ($peg_edit['kdcabang']==$listkan->kodecabang) { echo 'selected';}?>><?php echo $listkan->desc_cabang;?></option>						  
						  <?php }?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputstatusnikah" class="col-sm-3 control-label">Status Pernikahan</label>
					<div class="col-sm-6">
						<select class="form-control input-sm" name="statusnikah" id="statusnikah" required>
							<?php
								if(empty($qkawin))
								{
								echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								}else
								{
								foreach($qkawin as $column)
								{
								?>
								<option value="<?php echo $column->kdkawin; ?>" <?php if ($peg_edit['kdkawin']==$column->kdkawin) {echo 'selected';}?>><?php echo $column->desckawin; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputtelp" class="col-sm-3 control-label">No. Telp</label>
						<div class="col-sm-6">
							<input type="text" class="form-control input-sm" value="<?php echo $peg_edit['telepon'];?>" id="telp" name="telp" data-inputmask='"mask": "+6299999999999"' data-mask="">
						</div>
						<div class="col-sm-10"></div>
				</div>				
		</div>
		<div class="box-footer">
		</div>
	</div>
</div>
	
<div class="col-lg-6">
	<div class="box box-info col-sm-6">
		<div class="box-body">
			<!--
			<div class="form-group">
				<label for="foto" class="col-sm-3 control-label">Foto</label>
				<div class="col-sm-5">
					<img src="<?php echo base_url('assets/img/profile/'.$anggota['image']);?>" width="200px" height="200px" alt="User Image">
					
				</div>			
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
			<label for="uploadgbr" class="col-sm-3 control-label"></label>
				<div class="col-lg-6">
					<input type="file" name="gambar" accept="image/*;capture=camera">
				</div>			
			</div>
			<div class="col-sm-10"></div>
			-->
			<div class="form-group">
				<label for="agama" class="col-sm-3 control-label">Agama</label>
				<div class="col-sm-6">
					<select class="form-control input-sm" name="agama">
					<?php 
					foreach ($q_agama as $agama){
						if ($peg_edit['kdagama']==$agama->kode_agama){
							echo '<option selected value="'.$agama->kode_agama.'">'.$agama->desc_agama.'</option>';
						} else {
					?>
						<option value="<?php echo $agama->kode_agama;?>"><?php echo $agama->desc_agama;?></option>
						<?php }}?>				  
					</select>
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="inputnpwp" class="col-sm-3 control-label">No NPWP</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="npwp" id="npwp" value="<?php echo $peg_edit['npwp'];?>" data-inputmask='"mask": "99.999.999.9-999.999"' data-mask="">
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">No BJPS Tenaga Kerja</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="bpjs" id="bpjs" value="<?php echo $peg_edit['bpjs'];?>" data-inputmask='"mask": "99999999999"' data-mask="">
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">No BJPS Kesehatan</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="bpjskes" id="bpjskes" value="<?php echo $peg_edit['bpjskes'];?>" data-inputmask='"mask": "9999 9999 99999"' data-mask="">
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">No Rekening</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="norek" value="<?php echo $peg_edit['norek'];?>" id="norek">
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="inputmasuk" class="col-sm-3 control-label">Masuk Kerja</label>
					<div class="col-sm-6">
						<input type="text" class="form-control input-sm" value="<?php
							$masuk = strtotime($peg_edit['masukkerja']);
							$tanggalmasuk = date('d-m-Y',$masuk);
							echo $tanggalmasuk;
							?>" id="masuk" name="masukkrj" required data-date-format="dd-mm-yyyy">
					</div>
					<div class="col-sm-10"></div>
			</div>			
			<div class="form-group">
				<label for="inputkeluar" class="col-sm-3 control-label">Keluar Kerja</label>
					<div class="col-sm-6">
						<input type="text" class="form-control input-sm" <?php
							$keluar = strtotime($peg_edit['keluarkerja']);
							if (empty($peg_edit['keluarkerja'])){
								echo "placeholder='Masih Bekerja'";
							} else {
								$tanggalkeluar = date('d-m-Y',$keluar);
								if ($tangalkeluar=='01-01-1970'){
									echo "placeholder='Masih Bekerja'";
								} else {
									echo "value='$tanggalkeluar'";
									echo $peg_edit['keluarkerja'];
								}		
							}
							?> id="keluar" name="keluarkrj"  data-date-format="dd-mm-yyyy" >
					</div>
					<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="wn" class="col-sm-3 control-label">Kewarganegaraan</label>
				<div class="col-sm-6">					
					  <select class="form-control input-sm" name="wn" id="wn">
						  <?php if ($peg_edit['kdwn']=='A') {
							echo '<option selected value="A">WNI</option>';
							echo '<option value="B">WNA</option>';
						  } else {
							echo '<option value="A">WNI</option>';
							echo '<option selected value="B">WNA</option>';
						  } ?>
						</select>					
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="darah" class="col-sm-3 control-label">Gol. Darah:<?php echo $peg_edit['goldarah']?></label>
				<div class="col-sm-6">
					<select class="form-control input-sm" name="darah" id="darah">
					  <?php switch (trim($peg_edit['goldarah'])){
							case '-': 	echo '<option selected value="-">-</option>';
										echo '<option value="A">A</option>';
										echo '<option value="B">B</option>';
										echo '<option value="AB">AB</option>';
										echo '<option value="O">O</option>'; break;
							case 'A': 	echo '<option value="-">-</option>';
										echo '<option selected value="A">A</option>';
										echo '<option value="B">B</option>';
										echo '<option value="AB">AB</option>';
										echo '<option value="O">O</option>'; break;
							case 'B': 	echo '<option  value="-">-</option>';
										echo '<option value="A">A</option>';
										echo '<option selected value="B">B</option>';
										echo '<option value="AB">AB</option>';
										echo '<option value="O">O</option>'; break;
							case 'AB': 	echo '<option value="-">-</option>';
										echo '<option value="A">A</option>';
										echo '<option value="B">B</option>';
										echo '<option selected  value="AB">AB</option>';
										echo '<option value="O">O</option>'; break;
							case 'O': 	echo '<option value="-">-</option>';
										echo '<option value="A">A</option>';
										echo '<option selected value="B">B</option>';
										echo '<option value="AB">AB</option>';
										echo '<option selected  value="O">O</option>'; break;													
					  }?>
					</select>
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Id Absensi</label>
				<div class="col-sm-8">
					<input type="text" class="form-control input-sm" name="id_absen" value="<?php echo $peg_edit['idabsen'];?>" >
				</div>
				<div class="col-sm-10"></div>
			</div>			
			<div class="form-group">
				<label class="col-sm-3 control-label">Email</label>
				<div class="col-sm-8">
					<input type="text" class="form-control input-sm" name="email" value="<?php echo $peg_edit['email'];?>" >
				</div>
				<div class="col-sm-10"></div>
			</div>			
		</div>
	</div>
</div><!-- ./col -->	

<div class="col-sm-6">	
	<div class="box box-danger col-sm-6">
		<div class="box-body">
			<div class="form-group">
				<label for="ktp" class="col-sm-3 control-label">No. KTP</label>
					<div class="col-sm-6">
						<input type="text" class="form-control input-sm" value="<?php echo $peg_edit['ktp'];?>" id="ktp" name="ktp">
					</div>
					<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="tktp" class="col-sm-3 control-label">Dikeluarkan di</label>
					<div class="col-sm-6">
						<input type="text" class="form-control input-sm" value="<?php echo $peg_edit['kotaktp'];?>" id="tktp" name="tktp">
					</div>
					<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="berlaku" class="col-sm-3 control-label">Berlaku</label>
				<div class="col-sm-6">
					<input type="text" class="form-control input-sm" value='<?php
						$aktp = strtotime($peg_edit['tglmulaiktp']);
						$ektp = strtotime($peg_edit['tglakhirktp']);
						$awktp = date('d-m-Y',$aktp);
						$enktp = date('d-m-Y',$ektp);
						echo $awktp.' - '.$enktp;
						?>' id="berlaku" name="berlaku" required data-date-format="dd-mm-yyyy">
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">				
				<label>
					<input type="checkbox" value="Y" name="seumur-hidup" <?php if ($peg_edit['ktp_seumurhdp']=='Y') { echo 'checked';};?> > KTP Seumur HIDUP</input>
				</label>				
			</div>
		</div>	
	</div>
</div>					
	
<div class="row clearfix">
	<div class="col-lg-6" style="margin: 10px">
		<div class="form-group">		
		  <button type="submit" class="btn btn-primary">Simpan</button>
		  <button type="button" class="btn btn-default" onclick="history.back();">Kembali</button>
		</div>
	</div>
</div>

</form>

<div id="tampil"></div>

<script>
	
	//Date picker
    $('#tanggal').datepicker();
	$('#masuk').datepicker();
	$('#keluar').datepicker();
	$('#berlaku').daterangepicker();
	$("[data-mask]").inputmask();

</script>