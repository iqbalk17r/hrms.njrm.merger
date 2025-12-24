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
					<div class="col-sm-6">
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputnama" class="col-sm-3 control-label">Nama Lengkap</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control input-sm" id="nama" name="nama" style="text-transform:uppercase" required>
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
								<option value="<?php echo trim($column->kddept);?>"><?php echo $column->departement; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputsub" class="col-sm-3 control-label">Sub Departemen</label>
					<div class="col-sm-6">
						<select class="form-control input-sm" name="sub" id="csubdept">
							<option value="">-Pilih Sub Departemen-</option>
							<?php
								if(empty($qsubdepartement))
								{
								echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								}else
								{
								foreach($qsubdepartement as $column)
								{
								?>
								<option value="<?php echo trim($column->kddept).'|'.trim($column->kdsubdept);?>" class="<?php echo trim($column->kddept);?>"><?php echo $column->subdepartement; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputjab" class="col-sm-3 control-label">Jabatan</label>
					<div class="col-sm-6">
						<select class="form-control input-sm" name="jabt" id="cjabt" required>
							<option value="">-Pilih Jabatan-</option>
							<?php
								if(empty($qjabatan))
								{
								echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								}else
								{
								foreach($qjabatan as $column)
								{
								?>
								<option value="<?php echo $column->kdjabatan; ?>" class="<?php echo trim($column->kddept).'|'.trim($column->kdsubdept);?>"><?php echo $column->deskripsi; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="darah" class="col-sm-3 control-label">Level Jabatan</label>
					<div class="col-sm-6">
						<select class='form-control input-sm' name="lvljabt" id="atasan">	
							<?php foreach ($qlvljabt as $ljab){?>
								<option value="<?php echo $ljab->kdjabatan;?>"><?php echo $ljab->descjabatan;?></option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputatasan" class="col-sm-3 control-label">Atasan Karyawan</label>
					<div class="col-sm-6">
						<select class='form-control input-sm' name="atasan" id="atasan">		
							<option value="">-Pilih Atasan-</option>
							<?php
								if(empty($qdepartement))
								{
								echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								}else
								{
								foreach($qatasan as $column)
								{
								?>
								<option value="<?php echo $column->list_nip; ?>"><?php echo $column->nmlengkap; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<!-- Hidde pegawai
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
						<select class="form-control input-sm" name="jk" id="jk" required>
							<option value="">-Pilih Jenis Kelamin-</option>
							<option value="B">Pria</option>
							<option value='A'>Wanita</option>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputalamat" class="col-sm-3 control-label">Alamat</label>
					<div class="col-sm-6">
					  <textarea class="form-control input-sm" rows="3" name="alamat" id="alamat" placeholder="alamat" style="text-transform:uppercase" required></textarea>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputkota" class="col-sm-3 control-label">Kota</label>
						<div class="col-sm-6">
						  <input type="text" class="form-control input-sm" id="kota" name="kota" style="text-transform:uppercase" required>
						</div>
						<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputttl" class="col-sm-3 control-label">Tempat Lahir</label>
						<div class="col-sm-6">
						  <input type="text" class="form-control input-sm" id="tempat" name="tempatlhr" style="text-transform:uppercase" required>
						</div>
						<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputttl" class="col-sm-3 control-label">Tanggal Lahir</label>
						<div class="col-sm-6">
						  <input type="text" class="form-control input-sm" id="tanggal" name="tanggallhr" required data-date-format="dd-mm-yyyy" required>
						</div>
					<div class="col-sm-10"></div>
				</div>				
				<div class="form-group">
					<label for="inputstatusrmh" class="col-sm-3 control-label">Kantor</label>
					<div class="col-sm-6">
						<select class="form-control input-sm" name="kantorcabang" id="statusrmh" required>
						  <?php foreach($list_kantor as $listkan){?>
						  <option value="<?php echo $listkan->kodecabang;?>" ><?php echo $listkan->desc_cabang;?></option>						  
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
								if(empty($qwilayah))
								{
								echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								}else
								{
								foreach($qkawin as $column)
								{
								?>
								<option value="<?php echo $column->kdkawin; ?>"><?php echo $column->desckawin; ?></option>
							<?php }} ?>
						</select>
					</div>
					<div class="col-sm-10"></div>
				</div>
				<div class="form-group">
					<label for="inputtelp" class="col-sm-3 control-label">No. Telp</label>
						<div class="col-sm-6">
						  <input type="text" class="form-control input-sm" id="telp" name="telp" data-inputmask='"mask": "+6299999999999"' data-mask="" required>
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
					<input type="file" accept="image/*;capture=camera">
				</div>			
			</div>
			<div class="col-sm-10"></div>
			-->
			<div class="form-group">
				<label for="agama" class="col-sm-3 control-label">Agama</label>
				<div class="col-sm-6">
					<select class="form-control input-sm" name="agama" required>
					<?php foreach ($q_agama as $agama){?>
						<option value="<?php echo $agama->kode_agama;?>"><?php echo $agama->desc_agama;?></option>
					<?php }?>				  
					</select>
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="inputnpwp" class="col-sm-3 control-label">No NPWP</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="npwp" id="npwp" data-inputmask='"mask": "99.999.999.9-999.999"' data-mask="">
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">No BJPS Tenaga Kerja</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="bpjs" id="bpjs" data-inputmask='"mask": "99999999999"' data-mask="">
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">No BJPS Kesehatan</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="bpjskes" id="bpjskes" data-inputmask='"mask": "9999 9999 99999"' data-mask="">
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">No Rekening</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="norek" id="norek">
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="inputmasuk" class="col-sm-3 control-label">Masuk Kerja</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control input-sm" id="masuk" name="masukkrj" required data-date-format="dd-mm-yyyy" required>
					</div>
					<div class="col-sm-10"></div>
			</div>
			<!--
			<div class="form-group">
				<label for="inputkeluar" class="col-sm-3 control-label">Keluar Kerja</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control input-sm" id="keluar" name="keluarkrj" required data-date-format="dd-mm-yyyy">
					</div>
					<div class="col-sm-10"></div>
			</div>
			-->
			<div class="form-group">
				<label for="wn" class="col-sm-3 control-label">Kewarganegaraan</label>
				<div class="col-sm-6">
					<select class="form-control input-sm" name="wn" id="wn" required>
					  <option value="A">WNI</option>
					  <option value="B">WNA</option>
					</select>
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="darah" class="col-sm-3 control-label">Gol. Darah</label>
				<div class="col-sm-6">
					<select class="form-control input-sm" name="darah" id="darah" required>
					  <option value="-">-Tidak Di Ketahui-</option>
					  <option value="A">A</option>
					  <option value="B">B</option>
					  <option value="AB">AB</option>
					  <option value="O">O</option>
					</select>
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="darah" class="col-sm-3 control-label">Id Absensi</label>
				<div class="col-sm-6">
					<input type="text" class="form-control input-sm" name="id_absen" >
				</div>
				<div class="col-sm-10"></div>
			</div>			
			<div class="form-group">
				<label for="email" class="col-sm-3 control-label">Email</label>
				<div class="col-sm-6">
					<input type="text" class="form-control input-sm" name="email" >
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
					  <input type="text" class="form-control input-sm" id="ktp" name="ktp">
					</div>
					<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="tktp" class="col-sm-3 control-label">Dikeluarkan di</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control input-sm" id="tktp" name="tktp" style="text-transform:uppercase">
					</div>
					<div class="col-sm-10"></div>
			</div>
			<div class="form-group">
				<label for="berlaku" class="col-sm-3 control-label">Berlaku</label>
				<div class="col-sm-6">
					<input type="text" class="form-control input-sm" id="berlaku" name="berlaku" data-date-format="dd-mm-yyyy">
				</div>
				<div class="col-sm-10"></div>
			</div>
			<div class="form-group">				
				<label>
					<input type="checkbox" value="Y" name="seumur-hidup"> KTP Seumur HIDUP</input>
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