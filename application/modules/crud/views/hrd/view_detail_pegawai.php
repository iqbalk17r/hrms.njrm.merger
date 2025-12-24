<?php 
/*
	@author : hanif_anak_metal \m/
*/
error_reporting(0);
?>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<?php echo validation_errors();?>
<div class="row">
	<div class="col-sm-12">
		
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">					
				<li class="active"><a href="#<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_1" data-toggle="tab">Profile Karyawan</a></li>
				<li><a href="#<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_2" data-toggle="tab">MUTASI/PROMOSI</a></li>
				<li><a href="#<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_3" data-toggle="tab">Keluarga</a></li>					
				<li><a href="#<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_4" data-toggle="tab">Status</a></li>					
				<li><a href="#<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_5" data-toggle="tab">Riwayat Kesehatan</a></li>					
				<li><a href="#<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_6" data-toggle="tab">Riwayat Kerja</a></li>					
				<li><a href="#<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_7" data-toggle="tab">Pelatihan</a></li>
				<li><a href="#<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_8" data-toggle="tab">Pendidikan</a></li>				
			</ul>
		</div>		
		<div class="tab-content">
			<div class="chart tab-pane active" id="<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_1" style="position: relative; height: 300px;" >				
				<div class="col-sm-6">
					<div class="box box-info col-sm-6">
						<div class="box-body" style="padding:5px;">
							<div class="form-group">
								<label for="inputnip" class="col-sm-4 control-label">NIP</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="nip" name="nip" value="<?php echo $lp['list_nip'];?>" readonly>
								</div>						
							</div>
							<div class="form-group">
								<label for="inputnama" class="col-sm-4 control-label">Nama Lengkap</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="nama" name="nama" value="<?php echo $lp['nmlengkap'];?>" readonly>
								</div>					
							</div>							
							<div class="form-group">
								<label for="inputdept" class="col-sm-4 control-label">Departemen</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="dept" name="dept" value="<?php echo $lp['departement'];?>" readonly>
								</div>						
							</div>
							<div class="form-group">
								<label for="inputsub" class="col-sm-4 control-label">Divisi</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="nama" name="nama" value="<?php echo $lp['subdepartement'];?>" readonly>
								</div>
								
							</div>
							<div class="form-group">
								<label for="inputjab" class="col-sm-4 control-label">Jabatan</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="jabt" name="jabt" value="<?php echo $lp['deskripsi'];?>" readonly>
								</div>								
							</div>			
							<div class="form-group">
								<label for="darah" class="col-sm-4 control-label">Level Jabatan</label>
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" value="<?php echo $lp['descjabatan'];?>" readonly>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<!-- Wilayah di hidden
							<div class="form-group">
								<label for="inputwil" class="col-sm-4 control-label">Wilayah</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="wil" name="wil" value="<?php echo $lp['areaname'];?>" readonly>
								</div>						
							</div>
							-->
							<div class="form-group">
								<label for="inputjk" class="col-sm-4 control-label">Jenis Kelamin</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="jk" name="jk" value="<?php if ($lp['kdkelamin']=='B') { echo 'Pria';} else {echo 'Wanita';}?>" readonly>						  
								</div>						
							</div>
							<div class="form-group">
								<label for="inputkota" class="col-sm-4 control-label">Kota</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="kota" name="kota" value="<?php echo $lp['kota'];?>" readonly>
								</div>								
							</div>
							<div class="form-group">
								<label for="inputalamat" class="col-sm-4 control-label">Alamat</label>
								<div class="col-sm-8">
								  <textarea class="form-control input-sm" rows="3" name="alamat" id="alamat" placeholder="alamat" readonly><?php echo $lp['alamat'];?></textarea>
								</div>								
							</div>	
							<div class="form-group">
								<label for="inputatasan" class="col-sm-4 control-label">Atasan Karyawan</label>
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" id="nama" name="nama" value="<?php echo $lp['nama_atasan'];?>" readonly>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="inputttl" class="col-sm-4 control-label">Tempat Lahir</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="tempat" name="tempat" value="<?php echo $lp['tempatlahir'];?>" readonly>
								</div>									
							</div>
							<div class="form-group">
								<label for="inputttl" class="col-sm-4 control-label">Tanggal Lahir</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="tgl" name="tgl" value="<?php echo date('d-m-Y', strtotime($lp['tgllahir']));?>" data-date-format="dd-mm-yyyy" readonly>
								</div>
								
							</div>							
							<div class="form-group">
								<label for="inputstatusrmh" class="col-sm-4 control-label">Kantor</label>								
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" id="kawin" name="kawin" value="<?php echo $lp['desc_cabang'];?>" readonly>
								</div>														
							</div>							
							<div class="form-group">
								<label for="inputstatusnikah" class="col-sm-4 control-label">Status Pernikahan</label>
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" id="kawin" name="kawin" value="<?php echo $lp['kawin'];?>" readonly>							  							
								</div>
								
							</div>
							<div class="form-group">
								<label for="inputtelp" class="col-sm-4 control-label">No. Telp</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="telp" name="telp" value="<?php echo $lp['telepon'];?>" readonly>
								</div>						
							</div>
							<div class="form-group">
								<label for="inputtelp" class="col-sm-4 control-label">NPWP</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="npwp" name="npwp" value="<?php echo $lp['npwp'];?>" readonly>
								</div>						
							</div>
							<div class="form-group">
								<label for="inputtelp" class="col-sm-4 control-label">BPJS</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="bpjs" name="bpjs" value="<?php echo $lp['bpjs'];?>" readonly>
								</div>						
							</div>
							<div class="form-group">
								<label for="inputtelp" class="col-sm-4 control-label">BPJS Kesehatan</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="bpjs" name="bpjskes" value="<?php echo $lp['bpjskes'];?>" readonly>
								</div>						
							</div>
							<div class="form-group">
								<label for="inputtelp" class="col-sm-4 control-label">No Rekening</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="norek" name="norek" value="<?php echo $lp['norek'];?>" readonly>
								</div>						
							</div>
						</div>
						<div class="box-footer">
						</div>
					</div>
				</div>
				
				<div class="col-sm-6">
					<div class="box box-info col-sm-6">
						<div class="box-body" style="padding:5px;">
							<div class="form-group">
								<label for="agama" class="col-sm-4 control-label">Agama</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="agama" name="agama" value="<?php echo $lp['desc_agama'];?>" disabled>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="inputmasuk" class="col-sm-4 control-label">Masuk Kerja</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="masuk" name="masuk" value="<?php echo date('d-m-Y', strtotime($lp['masukkerja']));?>" data-date-format="dd-mm-yyyy" disabled>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="inputkeluar" class="col-sm-4 control-label">Keluar Kerja</label>
								<div class="col-sm-8">
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
										?> id="keluar" name="keluarkrj"  data-date-format="dd-mm-yyyy"  disabled>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="wn" class="col-sm-4 control-label">Kewarganegaraan</label>
								<div class="col-sm-8">
									<?php
									 $kodewn=$lp['kdwn'];
									 switch ($kodewn){
										case 'A': echo '<input type="text" class="form-control input-sm" id="wn" name="wn" value="WNI" readonly>'; break;
										case 'B': echo '<input type="text" class="form-control input-sm" id="wn" name="wn" value="WNA" readonly>'; break;
									 }
									?>								  
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="darah" class="col-sm-4 control-label">Gol. Darah</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="darah" name="darah" value="<?php echo $lp['goldarah'];?>" readonly>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="darah" class="col-sm-4 control-label">Masa Kerja</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" value="<?php
									$kta_awal = array('years','year','mons','mon','days','day');
									$kta_akhir = array('tahun','tahun','bulan','bulan','hari','hari');
									$pesan= str_replace($kta_awal,$kta_akhir,$lp['masakerja']);
								  echo $pesan;//$lp['masakerja'];?>" readonly>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="darah" class="col-sm-4 control-label">Id Absensi</label>
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" value="<?php echo $lp['idabsensi'];?>" readonly>
								</div>
								<div class="col-sm-10"></div>
							</div>							
							<div class="form-group">
								<label for="darah" class="col-sm-4 control-label">Email</label>
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" value="<?php echo $lp['email'];?>" readonly>
								</div>
								<div class="col-sm-10"></div>
							</div>
						</div>
						<div class="box-footer">
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="box box-info col-sm-6">
						<div class="box-body" style="padding:5px;">
							<div class="form-group">
								<label for="ktp" class="col-sm-4 control-label">No. KTP</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="ktp" name="ktp" value="<?php echo $lp['ktp'];?>" readonly>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="tktp" class="col-sm-4 control-label">Dikeluarkan di</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control input-sm" id="tktp" name="tktp" value="<?php echo $lp['kotaktp'];?>" readonly>
								</div>
									<div class="col-sm-10"></div>
							</div>																			
							<div class="form-group">
								<label for="berlaku" class="col-sm-4 control-label">Berlaku</label>
								<div class="col-sm-8">
								  <?php if ($lp['ktp_seumurhdp']<>'Y'){ ?>
									<input type="text" class="form-control input-sm" id="berlaku" name="berlaku" value="<?php echo date('d-m-Y', strtotime($lp['tglmulaiktp']));?> - <?php echo date('d-m-Y', strtotime($lp['tglakhirktp']));?>" data-date-format="dd-mm-yyyy" readonly>									
								  <?php } else { ?>
									<input type="text" class="form-control input-sm" id="berlaku" name="berlaku" value="SEUMUR HIDUP"  readonly>
								  <?php } ?>
								</div>
								<div class="col-sm-10"></div>
							</div>							
							<div class="form-group">
								<label for="berlaku" class="col-sm-4 control-label">Foto</label>
								<div class="col-sm-8">
									<img src="<?php if ($lp['image']<>'') { echo base_url('assets/img/profile/'.$lp['image']);} else { echo base_url('assets/img/user.png');} ;?>" width="100%" height="100%" alt="User Image">
								</div>
								<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".gantigambar">Ganti Foto</a>	
								<div class="col-sm-10"></div>
							</div><br/>
						</div>
						<div class="box-footer">
						</div>
					</div>
				</div>
				<!--BUTTON-->
					<div class="form-group">
						<div class="col-sm-9" style="margin-top: 10px">											
							<form action="<?php echo site_url('hrd/hrd/edit');?>" method="post">						
							<input type="hidden" value="<?php echo $lp['list_nip'];?>" name="edit_nip">
							<button type="submit" class="btn btn-primary">EDIT PROFILE PEGAWAI</button>
							<?php ?>
							</form>
						</div>
						<div class="col-sm-10"></div>
					</div>
			<!--	</div><!-- ./col -->
				
			</div><!-- ./tab 1-->
			<div class="tab-pane" id="<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_2">
				<div class="row">
				  <div class="col-sm-12">
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>																				
								<td width="10%">Action</td>												
								<td>Departemen</td>												
								<td>No SK</td>												
								<td>Kantor</td>
								<td>Jabatan</td>
								<td>Tanggal</td>
								<td>Keterangan</td>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(empty($list_mutasi))
								{
									echo "<tr><td colspan=\"7\">Data tidak tersedia</td></tr>";
								} else {
							foreach ($list_mutasi as $listmut){?>
							
							<td><a href="#" data-toggle="modal" data-target=".mutasi<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listmut->nomor);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
								|<a href="<?php echo site_url('hrd/hrd/hapus_mutasi/').'/'.trim($listmut->nip).'/'.$listmut->nomor;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Mutasi ini?')"><i class="glyphicon glyphicon-trash"></i></a>
								|<a href="<?php echo site_url('hrd/hrd/mutasi_pdf/').'/'.trim($listmut->nip).'/'.$listmut->nomor;;?>" data-toggle="tooltip" data-placement="top" title="Pdf" onclick="return confirm('Buat Pdf SK ini?')"><i class="fa fa-fw fa-file-text"></i></a>								
								</td>
								<td><?php echo $listmut->departement;?></td>
								<td><?php echo $listmut->kddokumen;?></td>
								<td><?php echo $listmut->desc_cabang;?></td>
								<td><?php echo $listmut->jabatan;?></td>
								<td><?php echo $listmut->tglmutasi;?></td>
								<td><?php echo $listmut->ket_mutasi;?></td>												
							</tr>
								<?php }}?>
						</tbody>
					</table>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
						<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".inputmutasi">Mutasi</a>						
						<div class="col-sm-9" style="margin-top: 10px">											
						</div>
						<div class="col-sm-10"></div>
					</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_3">
				<div class="row">
				  <div class="col-sm-12">
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>																				
								<td width="3%">No</td>												
								<td width="5%">Action</td>												
								<td>Nama</td>												
								<td>Status Di keluarga</td>
								<td>Tanggungan</td>
								<td>Pekerjaan</td>								
							</tr>
						</thead>
						<tbody>
							<?php
							if(empty($list_keluarga))
								{
									echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								} else {
								$no=1;	
							foreach ($list_keluarga as $listkel){?>
							<tr>									
								<td><?php echo $no;?></td>
								<td><a href="#" data-toggle="modal" data-target=".keluarga<?php echo str_replace('.','',trim($listkel->nir)).trim($listkel->nomor);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
								|<a href="<?php echo site_url('hrd/hrd/hapus_keluarga/').'/'.trim($listkel->nir).'/'.$listkel->nomor;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Keluarga ini?')"><i class="glyphicon glyphicon-trash"></i></a></td>								
								<td><?php echo $listkel->nama;?></td>
								<td><?php switch ($listkel->kdstklg) {
									case 'A': echo 'Bapak'; break;
									case 'B': echo 'Ibu';break;
									case 'C': echo 'Kakak';break;
									case 'D': echo 'Adik';break;
									case 'E': echo 'Anak';break;
									case 'F': echo 'Suami';break;
									case 'G': echo 'Istri';break;							
								};								
									?></td>
								<td><?php switch ($listkel->tanggungan) {
									case 'Y': echo 'Menjadi Tanggungan'; break;
									case 'N': echo 'Bukan Tanggungan'; break;
								}?>
								</td>								
								<td><?php echo $listkel->pekerjaan;?></td>												
							</tr>
							<?php $no++; }}?>
						</tbody>
					</table>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
						<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".keluarga">Input Keluarga</a>						
						<div class="col-sm-9" style="margin-top: 10px">											
						</div>
						<div class="col-sm-10"></div>
					</div>
					</div>
				</div>
			</div>			
			<!--end of Keluarga-->
			
			<!--Status KErja-->
			<div class="tab-pane" id="<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_4">
				<div class="row">
				  <div class="col-sm-12">
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>																				
								<td width="3%">No</td>												
								<td width="5%">Action</td>												
								<td width="10%">Tanggal Awal</td>												
								<td width="10%">Tanggal Akhir</td>																													
								<td>Jenis Kontrak</td>																																		
							</tr>
						</thead>
						<tbody>
							<?php
							if(empty($list_kontrak))
								{
									echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								} else {
								$no=1;	
							foreach ($list_kontrak as $likon){?>
							<tr>									
								<td><?php echo $no;?></td>
								<td><a href="#" data-toggle="modal" data-target=".ekontrak<?php echo str_replace('.','',trim($likon->nip)).trim($likon->nomor);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
								|<a href="<?php echo site_url('hrd/hrd/hapus_stskerja/').'/'.trim($likon->nip).'/'.$likon->nomor;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Keluarga ini?')"><i class="glyphicon glyphicon-trash"></i></a></td>																
								<td><?php echo $likon->mulai;?></td>
								<td><?php echo $likon->akhir;?></td>																													
								<td><?php echo $likon->kontrak;?></td>											
							</tr>
							<?php $no++; }}?>
						</tbody>
					</table>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".inputstskerja">Input Status Kerja</a>						
						<div class="col-sm-9" style="margin-top: 10px">											
						</div>
						<div class="col-sm-10"></div>
					</div>
					</div>
				</div>
			</div>
			<!--end off Statu KErja-->
			
			<!---View UPdate Junis 22-08-2015-->
			<div class="tab-pane" id="<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_8">
				<div class="row">
				  <div class="col-sm-12">
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>
							<th>No.</th>
							<th>Action</th>
							<th>Grade</th>
							<th>Nama Sekolah</th>
							<th>Kota</th>
							<th>Jurusan</th>
							<th>Tahun Masuk</th>
							<th>Tahun Lulus</th>
							<th>Nilai/IPK</th>
							<th>Keterangan</th>
						</tr>
						</thead>
						<tbody>
							<?php
							if(empty($list_pendidikan))
								{
									echo "<tr><td colspan=\"10\">Data tidak tersedia</td></tr>";
								} else {
								$no=1;	
							foreach ($list_pendidikan as $didik){?>
							<tr>									
								<td><?php echo $no;?></td>
								<td><a href="#" data-toggle="modal" data-target=".pendidikan<?php echo str_replace('.','',trim($didik->nip)).trim($didik->nomor);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
								|<a href="<?php echo site_url('hrd/hrd/hapus_pen/').'/'.trim($didik->nip).'/'.$didik->nomor;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data pendidikan ini?')"><i class="glyphicon glyphicon-trash"></i></a></td>								
								<td><?php echo $didik->gradepen;?></td>
								<td><?php echo $didik->nmsekolah;?></td>
								<td><?php echo $didik->kota;?></td>
								<td><?php echo $didik->jurusan;?></td>
								<td><?php echo $didik->periodeaw;?></td>
								<td><?php echo $didik->periodeak;?></td>
								<td><?php echo $didik->nilai;?></td>
								<td><?php echo $didik->keterangan;?></td>
							</tr>
							<?php $no++; }}?>
						</tbody>
					</table>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".pendidikan">Input Pendidikan</a>						
						<div class="col-sm-9" style="margin-top: 10px">											
						</div>
						<div class="col-sm-10"></div>
					</div>
					</div>
				</div>
			</div>
			<!--End View Pendidikan-->
			
			<!--Insert Pendidikan Febri 16-04-2015-->
			<div class="modal fade pendidikan" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">Input Pendidikan</h4>
					</div>
					<div class="modal-body">					
						<div class="row">
						<form action="<?php echo site_url('hrd/hrd/simpan_pen');?>" method="post">
						  <input type="hidden" name="nip" value="<?php echo $lp['list_nip'];?>">
						  <div class="col-sm-12">
									<div class="form-group">
										<label for="grade" class="col-sm-4 control-label">Grade Pendidikan</label>
										<div class="col-sm-6">
										  <select class='form-control input-sm' name="kddidik" id="kddidik">		
											<?php
												if(empty($qgrade))
												{
													echo "<tr><td colspan=\"10\">Data tidak tersedia</td></tr>";
												} else {
													foreach($qgrade as $grade)
												{
												?>
												<option value="<?php echo $grade->kdpendidikan; ?>"><?php echo $grade->desc_pendidikan; ?></option>
												<?php }} ?>
										  </select>
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputsklah" class="col-sm-4 control-label">Nama Sekolah</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="sklah" name="sklah">
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputkota" class="col-sm-4 control-label">Kota</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="kota" name="kota">
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputjur" class="col-sm-4 control-label">Jurusan</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="jur" name="jur">
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputtm" class="col-sm-4 control-label">Tahun Masuk</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="tm" name="tm">
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputtl" class="col-sm-4 control-label">Tahun Lulus</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="tl" name="tl">
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputnilai" class="col-sm-4 control-label">Nilai/IPK</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" name="nilai">
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputket" class="col-sm-4 control-label">Keterangan</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="ket" name="ket">
										</div>
										
									</div>
						  </div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button onclick="return confirm('Simpan data Pendidikan ini?')" type="submit" class="btn btn-primary">Simpan</button>
					</div>
					</form>
				</div>
			</div>
			</div>
			<!--End Insert Pendidikan-->
			
			<!--View & Edit Pendidikan Febri 16-04-2015-->
			<?php foreach ($list_pendidikan as $row){ ?>
			<div class="modal fade pendidikan<?php echo str_replace('.','',trim($row->nip)).trim($row->nomor);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Data Pendidikan</h4>
						</div>
						<div class="modal-body">
							<div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#pendidikan<?php echo str_replace('.','',trim($row->nip)).trim($row->nomor);?>tab_1" data-toggle="tab">View Data</a></li>
									<li><a href="#pendidikan<?php echo str_replace('.','',trim($row->nip)).trim($row->nomor);?>tab_2" data-toggle="tab">Edit Data</a></li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="pendidikan<?php echo str_replace('.','',trim($row->nip)).trim($row->nomor);?>tab_1" style="position: relative; height: 300px;">
										<div class="form-group">
										<label for="inputsklah" class="col-sm-4 control-label">Nama Sekolah</label>
											<div class="col-sm-6">
											  <input type="text" class="form-control input-sm" id="sklah" name="sklah" value="<?php echo $row->nmsekolah;?>" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="inputkota" class="col-sm-4 control-label">Kota</label>
											<div class="col-sm-6">
											  <input type="text" class="form-control input-sm" id="kota" name="kota" value="<?php echo $row->kota;?>" readonly>
											</div>
											<div class="col-sm-10"></div>	
										</div>
										<div class="form-group">
											<label for="inputjur" class="col-sm-4 control-label">Jurusan</label>
											<div class="col-sm-6">
											  <input type="text" class="form-control input-sm" id="jur" name="jur" value="<?php echo trim($row->jurusan);?>" readonly>
											</div>
											<div class="col-sm-10"></div>	
										</div>
										<div class="form-group">
											<label for="inputtm" class="col-sm-4 control-label">Tahun Masuk</label>
											<div class="col-sm-6">
											  <input type="text" class="form-control input-sm" id="tm" name="tm" value="<?php echo $row->periodeaw;?>" readonly>
											</div>
										<div class="col-sm-10"></div>	
										</div>
										<div class="form-group">
											<label for="inputtl" class="col-sm-4 control-label">Tahun Lulus</label>
											<div class="col-sm-6">
											  <input type="text" class="form-control input-sm" id="tl" name="tl" value="<?php echo $row->periodeak;?>" readonly>
											</div>
										<div class="col-sm-10"></div>	
										</div>
										<div class="form-group">
											<label for="inputnilai" class="col-sm-4 control-label">Nilai/IPK</label>
											<div class="col-sm-6">
											  <input type="text" class="form-control input-sm" id="nilai" name="nilai" value="<?php echo $row->nilai;?>" readonly>
											</div>
										<div class="col-sm-10"></div>	
										</div>
										<div class="form-group">
											<label for="inputket" class="col-sm-4 control-label">Keterangan</label>
											<div class="col-sm-6">
											  <input type="text" class="form-control input-sm" id="ket" name="ket" value="<?php echo $row->keterangan;?>" readonly>
											</div>
										<div class="col-sm-10"></div>	
										</div>
									</div>
                                    <div class="chart tab-pane" id="pendidikan<?php echo str_replace('.','',trim($row->nip)).trim($row->nomor);?>tab_2" style="position: relative; height: 300px;">
										<form action="<?php echo site_url('hrd/hrd/edit_pen');?>" method="post">
										<input type="hidden" value="<?php echo $row->nip;?>" name="nip">
										<input type="hidden" value="<?php echo $row->nomor;?>" name="nomor">
										<div class="form-group">
											<label for="grade" class="col-sm-4 control-label">Grade Pendidikan</label>
											<div class="col-sm-6">
											  <select class='form-control input-sm' name="kddidik" id="kddidik">		
												<?php
													if(empty($qgrade))
													{
														echo "<tr><td colspan=\"10\">Data tidak tersedia</td></tr>";
													} else {
														foreach($qgrade as $grade)
													{
													?>
													<option value="<?php echo $grade->kdpendidikan; ?>" 
														<?php if (trim($row->kdpendidikan)==trim($grade->kdpendidikan)) { echo 'selected';} ?>
													><?php echo trim($grade->desc_pendidikan); ?></option>
													<?php }} ?>
											  </select>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="inputsklah" class="col-sm-4 control-label">Nama Sekolah</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="sklah" name="sklah" value="<?php echo $row->nmsekolah;?>" required>
												</div>
												<div class="col-sm-10"></div>
											</div>
										<div class="form-group">
											<label for="inputkota" class="col-sm-4 control-label">Kota</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="kota" name="kota" value="<?php echo $row->kota;?>" required>
												</div>
											<div class="col-sm-10"></div>	
										</div>
										<div class="form-group">
											<label for="inputjur" class="col-sm-4 control-label">Jurusan</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="jur" name="jur" value="<?php echo trim($row->jurusan);?>" required>
												</div>
												<div class="col-sm-10"></div>	
										</div>
										<div class="form-group">
											<label for="inputtm" class="col-sm-4 control-label">Tahun Masuk</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="tm" name="tm" value="<?php echo $row->periodeaw;?>" required>
												</div>
												<div class="col-sm-10"></div>	
										</div>
										<div class="form-group">
											<label for="inputtl" class="col-sm-4 control-label">Tahun Lulus</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="tl" name="tl" value="<?php echo $row->periodeak;?>" required>
												</div>
												<div class="col-sm-10"></div>	
										</div>
										<div class="form-group">
											<label for="inputnilai" class="col-sm-4 control-label">Nilai/IPK</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="nilai" name="nilai" value="<?php echo $row->nilai;?>" required>
												</div>
												<div class="col-sm-10"></div>	
										</div>
										<div class="form-group">
											<label for="inputket" class="col-sm-4 control-label">Keterangan</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="ket" name="ket" value="<?php echo $row->keterangan;?>">
												</div>
												<div class="col-sm-10"></div>	
										</div>
										<button type="submit" onclick="return confirm('Update data pendidikan ini?')" class="btn btn-primary"><i class="glyphicon glyphicon-refresh"></i> Update</button>
										</form>
									</div>
                                </div>
							</div>													
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							
						</div>
						
					</div>
				  </div>
			   </div>
			</div>
			<?php }?>
			<!--End View & Edit Pendidikan-->
			
			<!--Kesehatan-->
			<div class="tab-pane" id="<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_5">
				<div class="row">
				  <div class="col-sm-12">
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>																				
								<td width="3%">No</td>												
								<td width="5%">Action</td>												
								<td width="10%">Tahun Sakit</td>												
								<td>Sakit</td>																
							</tr>
						</thead>
						<tbody>
							<?php
							if(empty($list_kesehatan))
								{
									echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								} else {
								$no=1;	
							foreach ($list_kesehatan as $listkes){?>
							<tr>									
								<td><?php echo $no;?></td>
								<td><a href="#" data-toggle="modal" data-target=".kesehatan<?php echo str_replace('.','',trim($listkes->nip)).trim($listkes->nomor);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
								|<a href="<?php echo site_url('hrd/hrd/hapus_kesehatan/').'/'.trim($listkes->nip).'/'.$listkes->nomor;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Riwayat Kesehatan ini?')"><i class="glyphicon glyphicon-trash"></i></a></td>								
								<td><?php echo $listkes->thnsakit;?></td>
								<td><?php echo $listkes->desc_sakit;?></td>											
							</tr>
							<?php $no++; }}?>
						</tbody>
					</table>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".kesehatan">Input Kesehatan</a>						
						<div class="col-sm-9" style="margin-top: 10px">											
						</div>
						<div class="col-sm-10"></div>
					</div>
					</div>
				</div>
			</div>			
			<!--Riwayat Kerja-->
			<div class="tab-pane" id="<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_6">
				<div class="row">
				  <div class="col-sm-12">
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>																				
								<td width="3%">No</td>												
								<td width="3%">Action</td>												
								<td width="5%">Tahun Masuk</td>												
								<td width="5%">Tahun Keluar</td>												
								<td>Nama Perusahaan</td>												
								<td>Jabatan</td>												
								<td>Gaji</td>												
								<td>Keterangan</td>																
							</tr>
						</thead>
						<tbody>
							<?php
							if(empty($list_kerja))
								{
									echo "<tr><td colspan=\"8\">Data tidak tersedia</td></tr>";
								} else {
								$no=1;	
							foreach ($list_kerja as $listker){?>
							<tr>									
								<td><?php echo $no;?></td>
								<td><a href="#" data-toggle="modal" data-target=".ekerja<?php echo str_replace('.','',trim($listker->nir)).trim($listker->pglmke);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
								|<a href="<?php echo site_url('hrd/hrd/hapus_pglmkerja/').'/'.trim($listker->nir).'/'.$listker->pglmke;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Pengalaman Kerja ini?')"><i class="glyphicon glyphicon-trash"></i></a></td>								
								<td><?php echo $listker->tahunmasuk;?></td>
								<td><?php echo $listker->tahunkeluar;?></td>											
								<td><?php echo $listker->nmperusahaan;?></td>											
								<td><?php echo $listker->jabatan;?></td>											
								<td><?php echo $listker->gaji;?></td>											
								<td><?php echo $listker->keterangan;?></td>											
							</tr>
							<?php $no++; }}?>
						</tbody>
					</table>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".inputkerja">Input Riwayat Kerja</a>						
						<div class="col-sm-9" style="margin-top: 10px">											
						</div>
						<div class="col-sm-10"></div>
					</div>
					</div>
				</div>
			</div>
			<!--Pelatihan-->
			<div class="tab-pane" id="<?php echo str_replace('.','',trim($lp['list_nip']));?>tab_7">
				<div class="row">
				  <div class="col-sm-12">
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>																				
								<td width="3%">No</td>												
								<td width="3%">Action</td>												
								<td width="10%">Tanggal Pelatihan</td>												
								<td width="10%">Lama Pelatihan</td>												
								<td width="15%">Nama Pelatihan</td>												
								<td width="15%">Tempat</td>																				
								<td width="15%">Trainer</td>																				
								<td>Keterangan</td>																
							</tr>
						</thead>
						<tbody>
							<?php
							if(empty($list_pelatihan))
								{
									echo "<tr><td colspan=\"8\">Data tidak tersedia</td></tr>";
								} else {
								$no=1;	
							foreach ($list_pelatihan as $listpel){?>
							<tr>									
								<td><?php echo $no;?></td>
								<td><a href="#" data-toggle="modal" data-target=".epelatihan<?php echo str_replace('.','',trim($listpel->nip)).trim($listpel->kdpelatihan);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
								|<a href="<?php echo site_url('hrd/hrd/hapus_pelatihan/').'/'.trim($listpel->nip).':'.trim($listpel->kdpelatihan);?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Pelatihan ini?')"><i class="glyphicon glyphicon-trash"></i></a></td>								
								<td><?php echo $listpel->tglpelatihan;?></td>
								<td><?php echo $listpel->lamapelatihan;?></td>
								
								<td><?php echo $listpel->nmpelatihan;?></td>											
								<td><?php echo $listpel->tempatpelatihan;?></td>											
								<td><?php echo $listpel->trainer;?></td>											
								<td><?php echo $listpel->ketpelatihan;?></td>																			
							</tr>
							<?php $no++; }}?>
						</tbody>
					</table>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".inputpelatihan">Input Pelatihan</a>						
						<div class="col-sm-9" style="margin-top: 10px">											
						</div>
						<div class="col-sm-10"></div>
					</div>
					</div>
				</div>
			</div>
	</div>
	<div class="col-sm-12">
		<button type="button" class="btn btn-default" onclick="history.back();">Kembali</button>
	</div>
</div>	




	
	<!--Modal View dan Edit Keluarga-->
		<?php foreach ($list_keluarga as $listkel){ ?>
				<div class="modal fade keluarga<?php echo str_replace('.','',trim($listkel->nir)).trim($listkel->nomor);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Data Keluarga</h4>
						</div>
						<div class="modal-body">
							<div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#keluarga<?php echo str_replace('.','',trim($listkel->nir)).trim($listkel->nomor);?>tab_1" data-toggle="tab">View Data</a></li>
									<li><a href="#keluarga<?php echo str_replace('.','',trim($listkel->nir)).trim($listkel->nomor);?>tab_2" data-toggle="tab">Edit Data</a></li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="keluarga<?php echo str_replace('.','',trim($listkel->nir)).trim($listkel->nomor);?>tab_1" style="position: relative; height: 300px;">
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Status Di Keluarga</label>
											<div class="col-sm-6">												
												<input type="text" value="<?php switch($listkel->kdstklg) {
														case 'A': echo 'Bapak'; break; 
														case 'B': echo 'Ibu'; break; 
														case 'C': echo 'Kakak'; break; 
														case 'D': echo 'Adik'; break; 
														case 'E': echo 'Anak'; break; 
														case 'F': echo 'Suami'; break; 
														case 'G': echo 'Istri'; break; 
													}?>" class="form-control input-sm" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Nama</label>
											<div class="col-sm-6">									  
												<input type="text" class="form-control input-sm" name="nama" id="nama" value="<?php echo $listkel->nama;?>" readonly>									  
											</div>
											<div class="col-sm-10"></div>
										</div>		
										<div class="form-group">
											<label for="inputjk" class="col-sm-4 control-label">Jenis Kelamin</label>
											<div class="col-sm-6">
												<input type="text" class="form-control input-sm" name="nama" id="nama" value="<?php switch ($listkel->kdkelamin) { case 'B': echo 'PRIA'; break; case 'A': echo 'WANITA'; break;};?>" readonly>									  
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="inputttl" class="col-sm-4 control-label">Tempat Lahir</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="tempat" name="tempatlhr" value="<?php echo $listkel->tempatlahir;?>" readonly>
												</div>
												<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="inputttl" class="col-sm-4 control-label">Tanggal Lahir</label>
												<div class="col-sm-6">
												  <input type="date" class="form-control input-sm" id="tanggal" name="tanggallhr" value="<?php echo $listkel->tgllahir;?>" required data-date-format="dd-mm-yyyy" readonly>
												</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="inputttl" class="col-sm-4 control-label">Pendidikan</label>
												<div class="col-sm-6">
													<input class="form-control input-sm" value="<?php switch ($listkel->kdpendidikan){
														case 'A': echo 'SD/MI'; break;														
														case 'B': echo 'SMP/MTS'; break;														
														case 'C': echo 'SMA/MA'; break;														
														case 'D': echo 'Diploma'; break;														
														case 'E': echo 'Sarjana'; break;														
														case 'F': echo 'Magister'; break;														
													};?>" readonly>												  
												</div>
												<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="inputttl" class="col-sm-4 control-label">Pekerjaan</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="pekerjaan" name="pekerjaan" value="<?php echo $listkel->pekerjaan;?>" readonly>
												</div>
												<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="ketm" class="col-sm-4 control-label">Masih Hidup</label>
											<div class="col-sm-6">
												<input class="form-control input-sm" value="<?php switch ($listkel->sthidup){
														case 'A': echo 'Hidup'; break;														
														case 'B': echo 'Meninggal'; break;																												
													}?>" readonly>												  
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="ketm" class="col-sm-4 control-label">Tanggungan</label>
											<div class="col-sm-6">
												<input class="form-control input-sm" value="<?php switch ($listkel->sthidup){
														case 'Y': echo 'Menjadi Tanggungan'; break;														
														case 'N': echo 'Bukan Tanggungan'; break;																												
													}?>" readonly>												  
											</div>
											<div class="col-sm-10"></div>
										</div>
									</div>
                                    <div class="chart tab-pane" id="keluarga<?php echo str_replace('.','',trim($listkel->nir)).trim($listkel->nomor);?>tab_2" style="position: relative; height: 300px;">
										<form action="<?php echo site_url('hrd/hrd/edit_keluarga');?>" method="post">
										<input type="hidden" value="<?php echo $listkel->nir;?>" name="nip">
										<input type="hidden" value="<?php echo $listkel->nomor;?>" name="nourut">
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Status Di Keluarga</label>
											<div class="col-sm-6">
											  <select class='form-control input-sm' name="stskel" id="stskel">
												<?php switch ($listkel->kdstklg){												
													case 'A': echo '<option selected value="A">Bapak</option>';
															echo	'<option value="B">Ibu</option>';										
															echo	'<option value="C">Kakak</option>';										
															echo	'<option value="D">Adik</option>';										
															echo	'<option value="E">Anak</option>';										
															echo	'<option value="F">Suami</option>';										
															echo	'<option value="G">Istri</option>'; break;
													case 'B': echo '<option value="A">Bapak</option>';
															echo	'<option selected value="B">Ibu</option>';										
															echo	'<option value="C">Kakak</option>';										
															echo	'<option value="D">Adik</option>';										
															echo	'<option value="E">Anak</option>';										
															echo	'<option value="F">Suami</option>';										
															echo	'<option value="G">Istri</option>'; break;
													case 'C': echo '<option value="A">Bapak</option>';
															echo	'<option value="B">Ibu</option>';										
															echo	'<option selected value="C">Kakak</option>';										
															echo	'<option value="D">Adik</option>';										
															echo	'<option value="E">Anak</option>';										
															echo	'<option value="F">Suami</option>';										
															echo	'<option value="G">Istri</option>'; break;
													case 'D': echo '<option value="A">Bapak</option>';
															echo	'<option value="B">Ibu</option>';										
															echo	'<option value="C">Kakak</option>';										
															echo	'<option selected value="D">Adik</option>';										
															echo	'<option value="E">Anak</option>';										
															echo	'<option value="F">Suami</option>';										
															echo	'<option value="G">Istri</option>'; break;
													case 'E': echo '<option value="A">Bapak</option>';
															echo	'<option value="B">Ibu</option>';										
															echo	'<option value="C">Kakak</option>';										
															echo	'<option value="D">Adik</option>';										
															echo	'<option selected value="E">Anak</option>';										
															echo	'<option value="F">Suami</option>';										
															echo	'<option value="G">Istri</option>'; break;
													case 'F': echo '<option value="A">Bapak</option>';
															echo	'<option value="B">Ibu</option>';										
															echo	'<option value="C">Kakak</option>';										
															echo	'<option value="D">Adik</option>';										
															echo	'<option value="E">Anak</option>';										
															echo	'<option selected value="F">Suami</option>';										
															echo	'<option value="G">Istri</option>'; break;
													case 'G': echo '<option value="A">Bapak</option>';
															echo	'<option value="B">Ibu</option>';										
															echo	'<option value="C">Kakak</option>';										
															echo	'<option value="D">Adik</option>';										
															echo	'<option value="E">Anak</option>';										
															echo	'<option value="F">Suami</option>';										
															echo	'<option selected value="G">Istri</option>'; break;
													} ?>
																						
											  </select>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Nama</label>
											<div class="col-sm-6">									  
												<input type="text" class="form-control input-sm" value="<?php echo $listkel->nama;?>" name="nama" id="nama">									  
											</div>
											<div class="col-sm-10"></div>
										</div>		
										<div class="form-group">
											<label for="inputjk" class="col-sm-4 control-label">Jenis Kelamin</label>
											<div class="col-sm-6">
												<select class="form-control input-sm" name="jk" id="jk" required>
													<?php if ($listkel->kdkelamin=='A') { 
														echo '<option value="B">Pria</option>';
														echo '<option selected value="A">Wanita</option>';
													} else {
														echo '<option selected value="B">Pria</option>';
														echo '<option value="A">Wanita</option>';
													}?>
												</select>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="inputttl" class="col-sm-4 control-label">Tempat Lahir</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="tempat" value="<?php echo $listkel->tempatlahir; ?>" name="tempatlhr" required>
												</div>
												<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="inputttl" class="col-sm-4 control-label">Tanggal Lahir</label>
												<div class="col-sm-6">
												  <input type="date" class="form-control input-sm" id="<?php echo 'kelu'.trim($listkel->nir).trim($listkel->nomor);?>" name="tanggallhr" value="<?php echo $listkel->tgllahir;?>" required data-date-format="dd-mm-yyyy" required>
												</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="inputttl" class="col-sm-4 control-label">Pendidikan</label>
												<div class="col-sm-6">
												  <select class="form-control input-sm" id="pendidikan" name="pendidikan" required>
													<?php switch ($listkel->kdpendidikan){
														case 'A' : 	echo '<option selected value="A">SD/MI</option>';
																	echo '<option value="B">SMP/MTS</option>';
																	echo '<option value="C">SMA/MA</option>';
																	echo '<option value="D">Diploma</option>';
																	echo '<option value="E">Sarjana</option>';
																	echo '<option value="F">Magister</option>'; break;
														case 'B' : 	echo '<option value="A">SD/MI</option>';
																	echo '<option selected value="B">SMP/MTS</option>';
																	echo '<option value="C">SMA/MA</option>';
																	echo '<option value="D">Diploma</option>';
																	echo '<option value="E">Sarjana</option>';
																	echo '<option value="F">Magister</option>'; break;
														case 'C' : 	echo '<option value="A">SD/MI</option>';
																	echo '<option value="B">SMP/MTS</option>';
																	echo '<option selected value="C">SMA/MA</option>';
																	echo '<option value="D">Diploma</option>';
																	echo '<option value="E">Sarjana</option>';
																	echo '<option value="F">Magister</option>'; break;
														case 'D' : 	echo '<option value="A">SD/MI</option>';
																	echo '<option value="B">SMP/MTS</option>';
																	echo '<option value="C">SMA/MA</option>';
																	echo '<option selected value="D">Diploma</option>';
																	echo '<option value="E">Sarjana</option>';
																	echo '<option value="F">Magister</option>'; break;
														case 'E' : 	echo '<option value="A">SD/MI</option>';
																	echo '<option value="B">SMP/MTS</option>';
																	echo '<option value="C">SMA/MA</option>';
																	echo '<option value="D">Diploma</option>';
																	echo '<option selected value="E">Sarjana</option>';
																	echo '<option value="F">Magister</option>'; break;
														case 'F' : 	echo '<option value="A">SD/MI</option>';
																	echo '<option value="B">SMP/MTS</option>';
																	echo '<option value="C">SMA/MA</option>';
																	echo '<option value="D">Diploma</option>';
																	echo '<option value="E">Sarjana</option>';
																	echo '<option selected value="F">Magister</option>'; break;														
													}?>													
												  </select>
												</div>
												<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="inputttl" class="col-sm-4 control-label">Pekerjaan</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="pekerjaan" value="<?php echo $listkel->pekerjaan;?>" name="pekerjaan" required>
												</div>
												<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="ketm" class="col-sm-4 control-label">Masih Hidup</label>
											<div class="col-sm-6">
												<select class="form-control input-sm" name="stshdp">
												<?php if ($listkel->sthidup=='A') {
													echo '<option selected value="A">Hidup</option>';
													echo '<option value="B">Meninggal</option>';
												} else {
													echo '<option value="A">Hidup</option>';
													echo '<option selected value="B">Meninggal</option>';													
												}?>
													
												</select>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="ketm" class="col-sm-4 control-label">Tanggungan</label>
											<div class="col-sm-6">
												<select class="form-control input-sm" name="tanggungan">
												<?php if ($listkel->tanggungan=='Y') {
													echo '<option selected value="Y">Ya</option>';
													echo '<option value="N">Tidak</option>';
												} else {
													echo '<option value="Y">Ya</option>';
													echo '<option selected value="N">Tidak</option>';													
												}?>
													
												</select>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<button type="submit" onclick="return confirm('Simpan data Keluarga ini?')" class="btn btn-primary">Simpan</button>
										</form>
									</div>
                                </div>
							</div>													
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							
						</div>
						
					</div>
				  </div>
				 </div>
			</div>
		<?php }?>
	<!--end of edit dan view keluarga-->
	
	<!--edit dan view mutasi-->
	<?php foreach ($list_mutasi as $listmut){?>
	<div class="modal fade mutasi<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listmut->nomor);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">EDIT MUTASI/PROMOSI</h4>
						</div>
						<div class="modal-body">
							<div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#mutasi<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listmut->nomor);?>tab_1" data-toggle="tab">View Data</a></li>
									<li><a href="#mutasi<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listmut->nomor);?>tab_2" data-toggle="tab">Edit Data</a></li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="mutasi<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listmut->nomor);?>tab_1" style="position: relative; height: 400px;">
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Kantor Lama</label>
											<div class="col-sm-6">
												<input type="hidden" name="oldkantor" value="<?php echo trim($lp['kdcabang']);?>">
												<input type="text" class="form-control input-sm" value="<?php echo trim($listmut->kantorlama);?>" readonly>										
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Kantor</label>
											<div class="col-sm-6">
											  <input type="text" class="form-control input-sm" value="<?php echo trim($listmut->kantorbaru);?>" readonly>										
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Dept Lama</label>
											<div class="col-sm-6">
												<input type="hidden" name="olddept" value="<?php echo trim($lp['kddept']);?>">
												<input type="text" class="form-control input-sm" value="<?php echo trim($listmut->olddepartement);?>" readonly>										
											</div>
											<div class="col-sm-10"></div>
										</div>								
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Dept Tujuan</label>
											<div class="col-sm-6">
												<input type="text" class="form-control input-sm" value="<?php echo trim($listmut->departement);?>" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>
							
										<div class="form-group">
											<label for="jabtm" class="col-sm-4 control-label">Jabatan Lama</label>
											<div class="col-sm-6">
												<input type="hidden" name="oldjabt" value="<?php echo trim($lp['kdjabatan']);?>">
												<input type="text" class="form-control input-sm" value="<?php echo trim($listmut->oldjabatan);?>" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="jabtm" class="col-sm-4 control-label">Jabatan</label>
											<div class="col-sm-6">
												<input type="text" class="form-control input-sm" value="<?php echo trim($listmut->jabatan);?>" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Bertanggung Jawab Kepada</label>
											<div class="col-sm-6">
											  <input type="text" class="form-control input-sm" value="<?php echo trim($listmut->responbility);?>" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">No Dokumen SK DIREKSI</label>
											<div class="col-sm-6">
											  <input type="text" class="form-control input-sm" value="<?php echo trim($listmut->kdskdireksi);?>" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="tglm" class="col-sm-4 control-label">Tanggal</label>
											<div class="col-sm-6">
											  <input type="text" class="form-control input-sm" value="<?php echo trim($listmut->tglmutasi);?>" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="tglm" class="col-sm-4 control-label"><input type="checkbox" class="form-control input-sm" value="Y" name="memo" <?php if(trim($listmut->memo)=='Y') {echo 'checked';};?> disabled> Memo</label>									
											<div class="col-sm-6">									  										
												<input type="text" class="form-control input-sm" value="<?php echo trim($listmut->tglmemo);?>" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
											<div class="col-sm-6">
											  <textarea class="form-control input-sm"  readonly><?php echo trim($listmut->ket_mutasi);?></textarea>
											</div>
											<div class="col-sm-10"></div>
										</div>										  										
									</div>
									<div class="chart tab-pane" id="mutasi<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listmut->nomor);?>tab_2" style="position: relative; height: 400px;">
										
										<form action="<?php echo site_url('hrd/hrd/edit_mutasi');?>" method="post">
										  <input type="hidden" name="nip" value="<?php echo trim($lp['list_nip']);?>">										  								
										  <input type="hidden" name="nomor" value="<?php echo trim($listmut->nomor);?>">										  								
											<div class="form-group">
												<label for="tujuan" class="col-sm-4 control-label">Kantor Lama</label>
												<div class="col-sm-6">
													<input type="hidden" name="oldkantor" value="<?php echo trim($listmut->cabang);?>">
													<input type="text" class="form-control input-sm" value="<?php echo trim($listmut->kantorlama);?>" readonly>										
												</div>
												<div class="col-sm-10"></div>
											</div>
											<div class="form-group">
												<label for="tujuan" class="col-sm-4 control-label">Kantor</label>
												<div class="col-sm-6">
												  <select class='form-control input-sm' name="kantor" id="tujuan">		
													<?php
														if(empty($qkantor))
														{
															echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
														} else {
															foreach($qkantor as $kantor)
														{
														?>
														<option value="<?php echo $kantor->kodecabang; ?>" <?php if ($listmut->newcabang==$kantor->kodecabang) {echo 'selected';}?>><?php echo $kantor->desc_cabang; ?></option>
														<?php }} ?>
												  </select>
												</div>
												<div class="col-sm-10"></div>
											</div>
											<div class="form-group">
												<label for="tujuan" class="col-sm-4 control-label">Dept Lama</label>
												<div class="col-sm-6">
													<input type="hidden" name="olddept" value="<?php echo trim($listmut->kddept);?>">
													<input type="text" class="form-control input-sm" value="<?php echo trim($listmut->olddepartement);?>" readonly>
												</div>
												<div class="col-sm-10"></div>
											</div>								
											<div class="form-group">
												<label for="tujuan" class="col-sm-4 control-label">Dept Tujuan</label>
												<div class="col-sm-6">
												  <select class='form-control input-sm' name="deptujuan">		
													<?php
														if(empty($qdepartement))
														{
															echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
														} else {
															foreach($qdepartement as $column)
														{
														?>
														<option value="<?php echo trim($column->kddept); ?>" <?php if ($listmut->newkddept==$column->kddept) { echo 'selected';}?>><?php echo $column->departement; ?></option>
														<?php }} ?>
												  </select>
												</div>
												<div class="col-sm-10"></div>
											</div>																		
											<div class="form-group">
												<label for="jabtm" class="col-sm-4 control-label">Jabatan Lama</label>
												<div class="col-sm-6">
													<input type="hidden" name="oldjabt" value="<?php echo trim($lp['kdjabatan']);?>">
													<input type="text" class="form-control input-sm" value="<?php echo trim($listmut->oldjabatan);?>" readonly>
												</div>
												<div class="col-sm-10"></div>
											</div>
											<div class="form-group">
												<label for="jabtm" class="col-sm-4 control-label">Jabatan</label>
												<div class="col-sm-6">
												  <select class='form-control input-sm' name="jabatanmutasi">		
													<?php
														if(empty($qjabatan))
														{
															echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
														} else {
															foreach($qjabatan as $column)
														{
														?>
														<option value="<?php echo $column->kdjabatan; ?>" <?php if ($column->kdjabatan==$listmut->newkdjabatan) {echo 'selected';}?>><?php echo $column->deskripsi; ?></option>
														<?php }} ?>
												  </select>
												</div>
												<div class="col-sm-10"></div>
											</div>
											<div class="form-group">
												<label class="col-sm-4 control-label">Bertanggung Jawab Kepada</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" value="<?php echo trim($listmut->responbility);?>" name="tggjwb">
												</div>
												<div class="col-sm-10"></div>
											</div>
											<div class="form-group">
												<label class="col-sm-4 control-label">No Dokumen SK DIREKSI</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" value="<?php echo trim($listmut->kdskdireksi);?>" name="skdireksi">
												</div>
												<div class="col-sm-10"></div>
											</div>
											<div class="form-group">
												<label for="tglm" class="col-sm-4 control-label">Tanggal</label>
												<div class="col-sm-6">
												  <input type="text" class="form-control input-sm" id="tglmutasi" value="<?php echo trim($listmut->tglmutasi);?>"data-date-format="dd-mm-yyyy"  name="tglm">
												</div>
												<div class="col-sm-10"></div>
											</div>
											<div class="form-group">
												<label for="tglm" class="col-sm-4 control-label"><input type="checkbox" class="form-control input-sm" value="Y" name="memo" <?php if(trim($listmut->memo)=='Y') {echo 'checked';};?>> Memo</label>									
												<div class="col-sm-6">									  										
													<input type="text" class="form-control input-sm" id="tglmemo" data-date-format="dd-mm-yyyy" value="<?php echo trim($listmut->tglmemo);?>"  name="tglmemo">
												</div>
												<div class="col-sm-10"></div>
											</div>
											<div class="form-group">
												<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
												<div class="col-sm-6">
												  <textarea class="form-control input-sm" id="ketm" name="ketm"><?php echo trim($listmut->ket_mutasi);?></textarea>
												</div>
												<div class="col-sm-10"></div>
											</div>
											<button onclick="return confirm('Simpan data Mutasi ini?')" type="submit" class="btn btn-primary">Simpan</button>
											</form>
									</div>
								</div>
							</div>							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							
						</div>						
					</div>
				  </div>
			</div>
	<?php }?>
	<!--End Edit View Mutasi-->
	
	<!--Edit dan View Kesehatan-->
	<?php foreach ($list_kesehatan as $listkes){?>
	<div class="modal fade kesehatan<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listkes->nomor);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">EDIT Riwayat Kesehatan</h4>
			</div>
			<div class="modal-body">
				<div class="nav-tabs-custom">
					<!-- Tabs within a box -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#kesehatan<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listkes->nomor);?>tab_1" data-toggle="tab">View Data</a></li>
						<li><a href="#kesehatan<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listkes->nomor);?>tab_2" data-toggle="tab">Edit Data</a></li>
					</ul>
					<div class="tab-content no-padding">
						<!-- Morris chart - Sales -->
						<div class="chart tab-pane active" id="kesehatan<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listkes->nomor);?>tab_1" style="position: relative; height: 100px;">																																									  																				
							  <input type="hidden" name="nip" value="<?php echo $lp['list_nip'];?>">							  						
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Tahun</label>
									<div class="col-sm-6">
										<input type="text" class="form-control input-sm" value="<?php echo $listkes->thnsakit;?>" disabled>										
									</div>
									<div class="col-sm-10"></div>
								</div>						
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Sakit</label>
									<div class="col-sm-6">
									  <textarea class="form-control input-sm" id="sakit" name="sakit" disabled><?php echo $listkes->desc_sakit;?></textarea>
									</div>
									<div class="col-sm-10"></div>
								</div>							  													  								
						</div>
						<div class="chart tab-pane" id="kesehatan<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listkes->nomor);?>tab_2" style="position: relative; height: 100px;">							
							<form action="<?php echo site_url('hrd/hrd/edit_kesehatan');?>" method="post">
							  <input type="hidden" name="nip" value="<?php echo $lp['list_nip'];?>">							  							
							  <input type="hidden" name="nomor" value="<?php echo $listkes->nomor;?>">							  							
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Tahun</label>
									<div class="col-sm-6">
										<select class='form-control input-sm' name="tahun" id="tahun">											
											<option value='<?php echo $listkes->thnsakit; ?>' selected><?php echo $listkes->thnsakit; ?></option>
											<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
											<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
											<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>
											<option value='<?php $tgl=date('Y')-3; echo $tgl; ?>'><?php $tgl=date('Y')-3; echo $tgl; ?></option>
											<option value='<?php $tgl=date('Y')-4; echo $tgl; ?>'><?php $tgl=date('Y')-4; echo $tgl; ?></option>
											<option value='<?php $tgl=date('Y')-5; echo $tgl; ?>'><?php $tgl=date('Y')-5; echo $tgl; ?></option>
										</select>
									</div>
									<div class="col-sm-10"></div>
								</div>						
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Sakit</label>
									<div class="col-sm-6">
									  <textarea class="form-control input-sm" id="sakit" name="sakit"><?php echo $listkes->desc_sakit;?></textarea>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<button onclick="return confirm('Simpan data Riwayat Kesehatan ini?')" type="submit" class="btn btn-primary">Simpan</button>
							</form>
						</div>
					</div>
				</div>							
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							
			</div>						
		</div>
	  </div>
	</div>
	<?php }?>
	<!--End Edit dan View Kesehatan-->	
	
	<!--Edit dan View Pengalaman Kerja-->
	<?php foreach ($list_kerja as $listker){?>
	<div class="modal fade ekerja<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listker->pglmke);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">EDIT Riwayat Pengalaman Kerja</h4>
			</div>
			<div class="modal-body">
				<div class="nav-tabs-custom">
					<!-- Tabs within a box -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#kerjaku<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listker->pglmke);?>tab_1" data-toggle="tab">View Data</a></li>
						<li><a href="#kerjaku<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listker->pglmke);?>tab_2" data-toggle="tab">Edit Data</a></li>
					</ul>
					<div class="tab-content no-padding">
						<!-- Morris chart - Sales -->
						<div class="chart tab-pane active" id="kerjaku<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listker->pglmke);?>tab_1" style="position: relative; height: 300px;">																																									  																				
							<div class="form-group">
								<label for="tujuan" class="col-sm-4 control-label">Tahun Masuk</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" value="<?php echo $listker->tahunmasuk?>" disabled>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="tujuan" class="col-sm-4 control-label">Tahun Keluar</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" value="<?php echo $listker->tahunkeluar?>" disabled>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Nama Perusahaan</label>
								<div class="col-sm-6">
								  <input type="text" class="form-control input-sm" id="sakit" name="perusahaan" value="<?php echo $listker->nmperusahaan;?>" disabled>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Jabatan</label>
								<div class="col-sm-6">
								  <input type="text" class="form-control input-sm" id="sakit" name="jabatan" value="<?php echo $listker->jabatan;?>" disabled>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Gaji</label>
								<div class="col-sm-6">
								  <input type="text" class="form-control input-sm" id="sakit" name="gaji" value="<?php echo $listker->gaji;?>" disabled>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
								<div class="col-sm-6">
								  <textarea class="form-control input-sm" id="sakit" name="keterangan" disabled><?php echo $listker->keterangan;?></textarea>
								</div>
								<div class="col-sm-10"></div>
							</div>
						</div>
						<div class="chart tab-pane" id="kerjaku<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listker->pglmke);?>tab_2" style="position: relative; height: 300px;">														
							<form action="<?php echo site_url('hrd/hrd/edit_pglmkerja');?>" method="post">
							<input type="hidden" name="nip" value="<?php echo $lp['list_nip'];?>">												
							<input type="hidden" name="nomor" value="<?php echo $listker->pglmke;?>">												
							<div class="form-group">
								<label for="tujuan" class="col-sm-4 control-label">Tahun Masuk</label>
								<div class="col-sm-6">
									<select class='form-control input-sm' name="tahunmasuk" id="tahun">										
										<option value='<?php echo $listker->tahunmasuk; ?>' selected><?php echo $listker->tahunmasuk; ?></option>
										<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
										<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
										<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>									
									</select>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="tujuan" class="col-sm-4 control-label">Tahun Keluar</label>
								<div class="col-sm-6">
									<select class='form-control input-sm' name="tahunkeluar" id="tahun">	
										<option value='<?php echo $listker->tahunkeluar; ?>' selected><?php echo $listker->tahunkeluar; ?></option>
										<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
										<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
										<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>									
									</select>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Nama Perusahaan</label>
								<div class="col-sm-6">
								  <input type="text" class="form-control input-sm" id="sakit" name="perusahaan" value="<?php echo $listker->nmperusahaan;?>" required>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Jabatan</label>
								<div class="col-sm-6">
								  <input type="text" class="form-control input-sm" id="sakit" name="jabatan" value="<?php echo $listker->jabatan;?>" required>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Gaji</label>
								<div class="col-sm-6">
								  <input type="text" class="form-control input-sm" id="sakit" name="gaji" value="<?php echo $listker->gaji;?>" required>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
								<div class="col-sm-6">
								  <textarea class="form-control input-sm" id="sakit" name="keterangan"><?php echo $listker->keterangan;?></textarea>
								</div>
								<div class="col-sm-10"></div>
							</div>						  								
								<button onclick="return confirm('Simpan data Riwayat Pengalaman Pekerjaan ini?')" type="submit" class="btn btn-primary">Simpan</button>
							</form>
						</div>
					</div>
				</div>							
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							
			</div>						
		</div>
	  </div>
	</div>
	<?php }?>
	<!--End Edit dan View Pengalaman Kerja-->
	
	<!--Edit dan View status kontrak Kerja-->	
	<?php foreach ($list_kontrak as $listkon){?>
	<div class="modal fade ekontrak<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listkon->nomor);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">EDIT Status Kontrak Kerja</h4>
			</div>
			<div class="modal-body">
				<div class="nav-tabs-custom">
					<!-- Tabs within a box -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#ekontrak<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listkon->nomor);?>tab_1" data-toggle="tab">View Data</a></li>
						<li><a href="#ekontrak<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listkon->nomor);?>tab_2" data-toggle="tab">Edit Data</a></li>
					</ul>
					<div class="tab-content no-padding">
						<!-- Morris chart - Sales -->
						<div class="chart tab-pane active" id="ekontrak<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listkon->nomor);?>tab_1" style="position: relative; height: 125px;">																																									  																																									  						
							<div class="form-group">
								<label for="tujuan" class="col-sm-4 control-label">Tanggal Mulai</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" name="tglmulai" value="<?php
									$timestamp1 = strtotime($listkon->tanggal1);
									$tanggal1 = date('d-m-Y',$timestamp1);
									echo $tanggal1;
									?>" data-date-format="dd-mm-yyyy" disabled>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="tujuan" class="col-sm-4 control-label">Tanggal Selesai</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" name="tglakhir" value="<?php
									$timestamp2 = strtotime($listkon->tanggal2);
									$tanggal2 = date('d-m-Y',$timestamp2);
									echo $tanggal2;
									?>" data-date-format="dd-mm-yyyy" disabled>
								</div>
								<div class="col-sm-10"></div>
							</div>						
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Masa Kerja (Dalam Tahun)</label>
								<div class="col-sm-6">
								  <input type="text" class="form-control input-sm" value="<?php echo $listkon->masakerja;?>"name="masakerja" disabled>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Status Kerja</label>
								<div class="col-sm-6">
								  <select class="form-control input-sm" name="kdkontrak" disabled>
									<?php foreach ($list_kodekontrak as $likodekon){?>
										<option value="<?php echo $likodekon->kdkontrak;?>" <?php if ($likodekon->kdkontrak==$listkon->kdkontrak) {echo 'selected';}?>><?php echo $likodekon->desc_kontrak;?></option>
									<?php }?>
								  </select>
								</div>
								<div class="col-sm-10"></div>
							</div>
						</div>
						<div class="chart tab-pane" id="ekontrak<?php echo str_replace('.','',trim($lp['list_nip'])).trim($listkon->nomor);?>tab_2" style="position: relative; height: 125px;">							
							<form action="<?php echo site_url('hrd/hrd/edit_stskerja');?>" method="post">
							  <input type="hidden" name="nip" value="<?php echo $lp['list_nip'];?>">							  
							  <input type="hidden" name="nomor" value="<?php echo $listkon->nomor;?>">							  
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Tanggal Mulai</label>
									<div class="col-sm-6">
										<input type="text" class="form-control input-sm" name="tglmulai" value="<?php 
										$timestampb1 = strtotime($listkon->tanggal1);
										$tanggalb1 = date('d-m-Y',$timestampb1);
										echo $tanggalb1;
										?>" data-date-format="dd-mm-yyyy">
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Tanggal Selesai</label>
									<div class="col-sm-6">
										<input type="text" class="form-control input-sm" name="tglakhir" value="<?php
										$timestampb2 = strtotime($listkon->tanggal2);
										$tanggalb2 = date('d-m-Y',$timestampb2);
										echo $tanggalb2;
										?>"  data-date-format="dd-mm-yyyy">
									</div>
									<div class="col-sm-10"></div>
								</div>						
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Masa Kerja (Dalam Tahun)</label>
									<div class="col-sm-6">
									  <input type="text" class="form-control input-sm" value="<?php echo $listkon->masakerja;?>" name="masakerja">
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Status Kerja</label>
									<div class="col-sm-6">
									  <select class="form-control input-sm" name="kdkontrak">
										<?php foreach ($list_kodekontrak as $likodekon){?>
											<option value="<?php echo $likodekon->kdkontrak;?>" <?php if ($likodekon->kdkontrak==$listkon->kdkontrak) {echo 'selected';}?>><?php echo $likodekon->desc_kontrak;?></option>
										<?php }?>
									  </select>
									</div>
									<div class="col-sm-10"></div>
								</div>
									<button onclick="return confirm('Simpan data Status Kontrak Kerja ini?')" type="submit" class="btn btn-primary">Simpan</button>
								</form>	
						</div>
					</div>
				</div>							
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							
			</div>						
		</div>
	  </div>
	</div>
	<?php }?>
	<!--end Edit dan View status kontrak Kerja-->
	
	<!--Edit dan View Pelatihan-->	
	<?php foreach ($list_pelatihan as $lipel){?>
	<div class="modal fade epelatihan<?php echo str_replace('.','',trim($lp['list_nip'])).trim($lipel->kdpelatihan);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">EDIT Pelatihan</h4>
			</div>
			<div class="modal-body">
				<div class="nav-tabs-custom">
					<!-- Tabs within a box -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#epelatihan<?php echo str_replace('.','',trim($lp['list_nip'])).trim($lipel->kdpelatihan);?>tab_1" data-toggle="tab">View Data</a></li>
						<li><a href="#epelatihan<?php echo str_replace('.','',trim($lp['list_nip'])).trim($lipel->kdpelatihan);?>tab_2" data-toggle="tab">Edit Data</a></li>
					</ul>
					<div class="tab-content no-padding">
						<!-- Morris chart - Sales -->
						<div class="chart tab-pane active" id="epelatihan<?php echo str_replace('.','',trim($lp['list_nip'])).trim($lipel->kdpelatihan);?>tab_1" style="position: relative; height: 250px;">
							<div class="form-group">
							<label for="tujuan" class="col-sm-4 control-label">Tanggal Pelatihan</label>
							<div class="col-sm-6">
								<input type="text" class="form-control input-sm" name="tglpelatihan" value="<?php echo $lipel->tglpelatihan;?>" readonly>
							</div>
							<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="tujuan" class="col-sm-4 control-label">Lama Pelatihan</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" value="<?php echo $lipel->lamapelatihan;?>" name="lamapelatihan" readonly>
								</div>
								<div class="col-sm-10"></div>
							</div>						
							<div class="form-group">
								<label class="col-sm-4 control-label">Nama Pelatihan</label>
								<div class="col-sm-6">
								  <input type="text" class="form-control input-sm" value="<?php echo $lipel->nmpelatihan;?>" name="nmpelatihan" readonly>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Tempat/Lokasi</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" value="<?php echo $lipel->tempatpelatihan;?>" name="tempatpelatihan" readonly>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Trainer</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" value="<?php echo $lipel->trainer;?>" name="trainer" readonly>
								</div>
								<div class="col-sm-10"></div>
							</div>
							<div class="form-group">
								<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
								<div class="col-sm-6">
									<textarea class="form-control input-sm" name="ketpelatihan" readonly><?php echo $lipel->ketpelatihan;?></textarea>
								</div>
								<div class="col-sm-10"></div>
							</div>
						</div>
						<div class="chart tab-pane" id="epelatihan<?php echo str_replace('.','',trim($lp['list_nip'])).trim($lipel->kdpelatihan);?>tab_2" style="position: relative; height: 250px;">							
							<form action="<?php echo site_url('hrd/hrd/edit_pelatihan');?>" method="post">
							  <input type="hidden" name="nip" value="<?php echo $lp['list_nip'];?>">							  
							  <input type="hidden" name="kdpelatihan" value="<?php echo trim($lipel->kdpelatihan);?>">							  
								<div class="form-group">
								<label for="tujuan" class="col-sm-4 control-label">Tanggal Pelatihan</label>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" name="tglpelatihan" value="<?php echo $lipel->tglpelatihan;?>" id="tglpelatihan<?php echo trim($lipel->kdpelatihan);?>" data-date-format="dd-mm-yyyy">
								</div>
								<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Lama Pelatihan</label>
									<div class="col-sm-6">
										<input type="text" class="form-control input-sm" value="<?php echo $lipel->lamapelatihan;?>" name="lamapelatihan" required>
									</div>
									<div class="col-sm-10"></div>
								</div>						
								<div class="form-group">
									<label class="col-sm-4 control-label">Nama Pelatihan</label>
									<div class="col-sm-6">
									  <input type="text" class="form-control input-sm" value="<?php echo $lipel->nmpelatihan;?>" name="nmpelatihan" required>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Tempat/Lokasi</label>
									<div class="col-sm-6">
										<input type="text" class="form-control input-sm" value="<?php echo $lipel->tempatpelatihan;?>" name="tempatpelatihan" required>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Trainer</label>
									<div class="col-sm-6">
										<input type="text" class="form-control input-sm" value="<?php echo $lipel->trainer;?>" name="trainer" required>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
									<div class="col-sm-6">
										<textarea class="form-control input-sm" name="ketpelatihan"><?php echo $lipel->ketpelatihan;?></textarea>
									</div>
									<div class="col-sm-10"></div>
								</div>
									<button onclick="return confirm('Simpan perubahan Data Pelatihan ini?')" type="submit" class="btn btn-primary">Simpan</button>
								</form>	
						</div>
					</div>
				</div>							
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							
			</div>						
		</div>
	  </div>
	</div>
	<?php }?>
	<!--end Edit dan View Pelatihan-->	
	
	
	<!--Inputan Modal Mutasi-->
			<div class="modal fade inputmutasi" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Input Mutasi</h4>
						</div>
						<div class="modal-body">							
							<div class="row">
							<form action="<?php echo site_url('hrd/hrd/input_mutasi');?>" method="post">
							  <input type="hidden" name="nip" value="<?php echo trim($lp['list_nip']);?>">
							  <div class="col-sm-12">
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Kantor Lama</label>
									<div class="col-sm-6">
										<input type="hidden" name="oldkantor" value="<?php echo trim($lp['kdcabang']);?>">
										<input type="text" class="form-control input-sm" name="kdcabang" value="<?php echo trim($lp['desc_cabang']);?>" readonly>										
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Kantor</label>
									<div class="col-sm-6">
									  <select class='form-control input-sm' name="kantor" id="tujuan">		
										<?php
											if(empty($qkantor))
											{
												echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
											} else {
												foreach($qkantor as $kantor)
											{
											?>
											<option value="<?php echo $kantor->kodecabang; ?>" <?php if ($lp['kdcabang']==$kantor->kodecabang) {echo 'selected';}?>><?php echo $kantor->desc_cabang; ?></option>
											<?php }} ?>
									  </select>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Dept Lama</label>
									<div class="col-sm-6">
										<input type="hidden" name="olddept" value="<?php echo trim($lp['kddept']);?>">
										<input type="text" class="form-control input-sm" value="<?php echo trim($lp['departement']);?>" readonly>
									</div>
									<div class="col-sm-10"></div>
								</div>								
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Dept Tujuan</label>
									<div class="col-sm-6">
									  <select class='form-control input-sm' name="deptujuan">		
										<?php
											if(empty($qdepartement))
											{
												echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
											} else {
												foreach($qdepartement as $column)
											{
											?>
											<option value="<?php echo trim($column->kddept); ?>" <?php if ($lp['kddept']==$column->kddept) { echo 'selected';}?>><?php echo $column->departement; ?></option>
											<?php }} ?>
									  </select>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Sub Dept Lama</label>
									<div class="col-sm-6">
										<input type="hidden" name="oldsubdept" value="<?php echo trim($lp['kdsubdept']);?>">
										<input type="text" class="form-control input-sm" value="<?php echo trim($lp['subdepartement']);?>" readonly>
									</div>
									<div class="col-sm-10"></div>
								</div>								
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Sub Dept Tujuan</label>
									<div class="col-sm-6">
									  <select class='form-control input-sm' name="subdeptujuan">		
										<?php
											if(empty($qsubdepartement))
											{
												echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
											} else {
												foreach($qsubdepartement as $column)
											{
											?>
											<option value="<?php echo trim($column->kdsubdept); ?>" <?php if ($lp['kddept']==$column->kdsubdept) { echo 'selected';}?>><?php echo $column->subdepartement; ?></option>
											<?php }} ?>
									  </select>
									</div>
									<div class="col-sm-10"></div>
								</div>								
								<div class="form-group">
									<label for="jabtm" class="col-sm-4 control-label">Jabatan Lama</label>
									<div class="col-sm-6">
										<input type="hidden" name="oldjabt" value="<?php echo trim($lp['kdjabatan']);?>">
										<input type="text" class="form-control input-sm" value="<?php echo trim($lp['deskripsi']);?>" readonly>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="jabtm" class="col-sm-4 control-label">Jabatan</label>
									<div class="col-sm-6">
									  <select class='form-control input-sm' name="jabatanmutasi">		
										<?php
											if(empty($qjabatan))
											{
												echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
											} else {
												foreach($qjabatan as $column)
											{
											?>
											<option value="<?php echo $column->kdjabatan; ?>"><?php echo $column->deskripsi; ?></option>
											<?php }} ?>
									  </select>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Bertanggung Jawab Kepada</label>
									<div class="col-sm-6">
									  <input type="text" class="form-control input-sm" name="tggjwb">
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">No Dokumen SK DIREKSI</label>
									<div class="col-sm-6">
									  <input type="text" class="form-control input-sm" name="skdireksi">
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tglm" class="col-sm-4 control-label">Tanggal</label>
									<div class="col-sm-6">
									  <input type="text" class="form-control input-sm" id="tglmutasi" data-date-format="dd-mm-yyyy"  name="tglm">
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tglm" class="col-sm-4 control-label"><input type="checkbox" class="form-control input-sm" value="Y" name="memo"> Memo</label>									
									<div class="col-sm-6">									  										
										<input type="text" class="form-control input-sm" id="tglmemo" data-date-format="dd-mm-yyyy"  name="tglmemo">
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
									<div class="col-sm-6">
									  <textarea class="form-control input-sm" id="ketm" name="ketm"></textarea>
									</div>
									<div class="col-sm-10"></div>
								</div>
							  </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button onclick="return confirm('Simpan data Mutasi ini?')" type="submit" class="btn btn-primary">Simpan</button>
						</div>
						</form>
					</div>
				  </div>
			</div>
		
		<!--Input Keluarga-->
		<div class="modal fade keluarga" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Input Keluarga</h4>
						</div>
						<div class="modal-body">
							
							<div class="row">
							<form action="<?php echo site_url('hrd/hrd/input_keluarga');?>" method="post">
							<input type="hidden" name="nip" value="<?php echo trim($lp['list_nip']);?>">
							  <div class="col-sm-12">								
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Status Di Keluarga</label>
									<div class="col-sm-6">
									  <select class='form-control input-sm' name="stskel" id="stskel">		
										<option value="A">Bapak</option>										
										<option value="B">Ibu</option>										
										<option value="C">Kakak</option>										
										<option value="D">Adik</option>										
										<option value="E">Anak</option>										
										<option value="F">Suami</option>										
										<option value="G">Istri</option>										
									  </select>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Nama</label>
									<div class="col-sm-6">									  
										<input type="text" class="form-control input-sm" name="nama" id="nama">									  
									</div>
									<div class="col-sm-10"></div>
								</div>		
								<div class="form-group">
									<label for="inputjk" class="col-sm-4 control-label">Jenis Kelamin</label>
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
									<label for="inputttl" class="col-sm-4 control-label">Tempat Lahir</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" id="tempat" name="tempatlhr" required>
										</div>
										<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="inputttl" class="col-sm-4 control-label">Tanggal Lahir</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" id="inputkeluarga" name="tanggallhr" required data-date-format="dd-mm-yyyy">
										</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="inputttl" class="col-sm-4 control-label">Pendidikan</label>
										<div class="col-sm-6">
										  <select class="form-control input-sm" id="pendidikan" name="pendidikan" required>
											<option value="A">SD/MI</option>
											<option value="B">SMP/MTS</option>
											<option value="C">SMA/MA</option>
											<option value="D">Diploma</option>
											<option value="E">Sarjana</option>
											<option value="F">Magister</option>
										  </select>
										</div>
										<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="inputttl" class="col-sm-4 control-label">Pekerjaan</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" id="pekerjaan" name="pekerjaan" required>
										</div>
										<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Masih Hidup</label>
									<div class="col-sm-6">
										<select class="form-control input-sm" name="stshdp">
											<option value="A">Hidup</option>
											<option value="B">Meninggal</option>
										</select>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Tanggungan</label>
									<div class="col-sm-6">
										<select class="form-control input-sm" name="tanggungan">
											<option value="Y">Iya</option>
											<option value="N">Tidak</option>
										</select>
									</div>
									<div class="col-sm-10"></div>
								</div>
							  </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button onclick="return confirm('Simpan data Keluarga ini?')" type="submit" class="btn btn-primary">Simpan</button>
						</div>
						</form>
					</div>
				  </div>
		</div>
		
		<!--Input Kesehatan-->
		<div class="modal fade kesehatan<?php echo trim($row->list_nip);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Input Kesehatan</h4>
				</div>
				<div class="modal-body">					
					<div class="row">
					<form action="<?php echo site_url('hrd/hrd/input_kesehatan');?>" method="post">
					  <input type="hidden" name="nip" value="<?php echo $lp['list_nip'];?>">
					  <div class="col-sm-12">								
						<div class="form-group">
							<label for="tujuan" class="col-sm-4 control-label">Tahun</label>
							<div class="col-sm-6">
								<select class='form-control input-sm' name="tahun" id="tahun">										
									<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
									<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
									<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>
									<option value='<?php $tgl=date('Y')-3; echo $tgl; ?>'><?php $tgl=date('Y')-3; echo $tgl; ?></option>
									<option value='<?php $tgl=date('Y')-4; echo $tgl; ?>'><?php $tgl=date('Y')-4; echo $tgl; ?></option>
									<option value='<?php $tgl=date('Y')-5; echo $tgl; ?>'><?php $tgl=date('Y')-5; echo $tgl; ?></option>
								</select>
							</div>
							<div class="col-sm-10"></div>
						</div>						
						<div class="form-group">
							<label for="ketm" class="col-sm-4 control-label">Sakit</label>
							<div class="col-sm-6">
							  <textarea class="form-control input-sm" id="sakit" name="sakit"></textarea>
							</div>
							<div class="col-sm-10"></div>
						</div>
					  </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button onclick="return confirm('Simpan data Kesehatan ini?')" type="submit" class="btn btn-primary">Simpan</button>
				</div>
				</form>
			</div>
		  </div>
		</div>
		
	<!--input Riwayat Kerja-->
		<div class="modal fade inputkerja" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Input Riwayat Kerja</h4>
				</div>
				<div class="modal-body">					
					<div class="row">
					<form action="<?php echo site_url('hrd/hrd/input_pglmkerja');?>" method="post">
					  <input type="hidden" name="nip" value="<?php echo $lp['list_nip'];?>">
					  <div class="col-sm-12">								
						<div class="form-group">
							<label for="tujuan" class="col-sm-4 control-label">Tahun Masuk</label>
							<div class="col-sm-6">
								<select class='form-control input-sm' name="tahunmasuk" id="tahun">										
									<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
									<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
									<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>									
								</select>
							</div>
							<div class="col-sm-10"></div>
						</div>
						<div class="form-group">
							<label for="tujuan" class="col-sm-4 control-label">Tahun Keluar</label>
							<div class="col-sm-6">
								<select class='form-control input-sm' name="tahunkeluar" id="tahun">										
									<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
									<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
									<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>									
								</select>
							</div>
							<div class="col-sm-10"></div>
						</div>
						<div class="form-group">
							<label for="ketm" class="col-sm-4 control-label">Nama Perusahaan</label>
							<div class="col-sm-6">
							  <input type="text" class="form-control input-sm" id="sakit" name="perusahaan" required>
							</div>
							<div class="col-sm-10"></div>
						</div>
						<div class="form-group">
							<label for="ketm" class="col-sm-4 control-label">Jabatan</label>
							<div class="col-sm-6">
							  <input type="text" class="form-control input-sm" id="sakit" name="jabatan" required>
							</div>
							<div class="col-sm-10"></div>
						</div>
						<div class="form-group">
							<label for="ketm" class="col-sm-4 control-label">Gaji</label>
							<div class="col-sm-6">
							  <input type="text" class="form-control input-sm" id="sakit" name="gaji" required>
							</div>
							<div class="col-sm-10"></div>
						</div>
						<div class="form-group">
							<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
							<div class="col-sm-6">
							  <textarea class="form-control input-sm" id="sakit" name="keterangan"></textarea>
							</div>
							<div class="col-sm-10"></div>
						</div>
					  </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button onclick="return confirm('Simpan data Riwayat Kerja ini?')" type="submit" class="btn btn-primary">Simpan</button>
				</div>
				</form>
			</div>
		  </div>
		</div>
	<!--end input Riwayat Kerja-->
	
	<!--input status Kerja-->
	<div class="modal fade inputstskerja" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Input Status Kerja</h4>
				</div>
				<div class="modal-body">					
					<div class="row">
					<form action="<?php echo site_url('hrd/hrd/input_stskerja');?>" method="post">
					  <input type="hidden" name="nip" value="<?php echo $lp['list_nip'];?>">
					  <div class="col-sm-12">								
						<div class="form-group">
							<label for="tujuan" class="col-sm-4 control-label">Tanggal Mulai</label>
							<div class="col-sm-6">
								<input type="text" class="form-control input-sm" name="tglmulai" id="stskrjmulai" data-date-format="dd-mm-yyyy" required>
							</div>
							<div class="col-sm-10"></div>
						</div>
						<div class="form-group">
							<label for="tujuan" class="col-sm-4 control-label">Tanggal Selesai (Jika Karyawan Tetap Tidak Di isi)</label>
							<div class="col-sm-6">
								<input type="text" class="form-control input-sm" name="tglakhir" id="stskrjakhir" data-date-format="dd-mm-yyyy">
							</div>
							<div class="col-sm-10"></div>
						</div>						
						<div class="form-group">
							<label for="ketm" class="col-sm-4 control-label">Status Kerja</label>
							<div class="col-sm-6">
							  <select class="form-control input-sm" name="kdkontrak">
								<?php foreach ($list_kodekontrak as $likodekon){?>
									<option value="<?php echo trim($likodekon->kdkontrak);?>"><?php echo $likodekon->desc_kontrak;?></option>
								<?php }?>
							  </select>
							</div>
							<div class="col-sm-10"></div>
						</div>
					  </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button onclick="return confirm('Simpan data Status Kerja ini?')" type="submit" class="btn btn-primary">Simpan</button>
				</div>
				</form>
			</div>
		  </div>
		</div>
	<!--end input Status Kerja-->
	
	<!--input Pelatihan-->
	<div class="modal fade inputpelatihan" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Input Pelatihan</h4>
				</div>
				<div class="modal-body">					
					<div class="row">
					<form action="<?php echo site_url('hrd/hrd/input_pelatihan');?>" method="post">
					  <input type="hidden" name="nip" value="<?php echo $lp['list_nip'];?>">
					  <div class="col-sm-12">								
						<div class="form-group">
							<label for="tujuan" class="col-sm-4 control-label">Tanggal Pelatihan</label>
							<div class="col-sm-6">
								<input type="text" class="form-control input-sm" name="tglpelatihan" id="tglpelatihan" data-date-format="dd-mm-yyyy">
							</div>
							<div class="col-sm-10"></div>
						</div>
						<div class="form-group">
							<label for="tujuan" class="col-sm-4 control-label">Lama Pelatihan</label>
							<div class="col-sm-6">
								<input type="text" class="form-control input-sm" name="lamapelatihan" required>
							</div>
							<div class="col-sm-10"></div>
						</div>						
						<div class="form-group">
							<label class="col-sm-4 control-label">Nama Pelatihan</label>
							<div class="col-sm-6">
							  <input type="text" class="form-control input-sm" name="nmpelatihan" required>
							</div>
							<div class="col-sm-10"></div>
						</div>
						<div class="form-group">
							<label for="ketm" class="col-sm-4 control-label">Tempat/Lokasi</label>
							<div class="col-sm-6">
								<input type="text" class="form-control input-sm" name="tempatpelatihan" required>
							</div>
							<div class="col-sm-10"></div>
						</div>
						<div class="form-group">
							<label for="ketm" class="col-sm-4 control-label">Trainer</label>
							<div class="col-sm-6">
								<input type="text" class="form-control input-sm" name="trainer" required>
							</div>
							<div class="col-sm-10"></div>
						</div>
						<div class="form-group">
							<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
							<div class="col-sm-6">
								<textarea class="form-control input-sm" name="ketpelatihan"></textarea>
							</div>
							<div class="col-sm-10"></div>
						</div>
					  </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button onclick="return confirm('Simpan data Pelatihan ini?')" type="submit" class="btn btn-primary">Simpan</button>
				</div>
				</form>
			</div>
		  </div>
		</div>
	<!--end Pelatihan-->
	
	<!--Ganti Gambar-->
	<div class="modal fade gantigambar" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Ubah Foto</h4>
				</div>			
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
                                <!-- form start -->
                                <form class="form-horizontal" action="<?php echo site_url('hrd/hrd/up_foto');?>" method="post" enctype="multipart/form-data">						
                                    <div class="box-body">										
										<div class="col-md-12">
											<div class="form-group">												
												<img src="<?php if ($lp['image']<>'') { echo base_url('assets/img/profile/'.$lp['image']);} else { echo base_url('assets/img/user.png');} ;?>" width="100%" height="100%" alt="User Image" >                                            
											</div>											
											<div class="form-group">
												<label for="exampleInputFile">File input</label>											
												<input type="hidden" value="<?php echo $lp['nip'];?>" name="nip">
												<input type="file" id="exampleInputFile" name="gambar">
												<p class="help-block">Upload file jpg.</p>
												<button onclick="return confirm('Ubah Foto ini?')" type="submit" class="btn btn-primary">Simpan</button>
											</div>											
										</div>										
                                    </div><!-- /.box-body -->
                                </form>
                            </div>
						</div>
					</div>				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					
				</div>				
			</div>
		  </div>
		</div>
	<!--end Pelatihan-->
	

</div>

<script>
	//Date picker
    $('#tanggal').datepicker();
    $('#tglmutasi').datepicker();
    $('#tglmemo').datepicker();
	<?php
	foreach ($list_mutasi as $emut){
		echo "$('#emut".trim($emut->nip).trim($emut->nomor)."').datepicker();";
	}
	foreach ($list_keluarga as $kelu){
		echo "$('#kelu".trim($kelu->nir).trim($kelu->nomor)."').datepicker();";
	}
	?>
    $('#inputkeluarga').datepicker();
	$('#masuk').datepicker();
	$('#stskrjmulai').datepicker();
	$('#stskrjakhir').datepicker();
	$('#tglm').datepicker();
	$('#tglpelatihan').datepicker();	
	<?php foreach ($list_pelatihan as $lipel){?>
	$('#tglpelatihan<?php echo trim($lipel->kdpelatihan);?>').datepicker();
	<?php }?>
	$('#keluar').datepicker();
	$('#berlaku').daterangepicker();
	$("[data-mask]").inputmask();

</script>