<?php 
/*
	@triomacan
*/
?>
<script>
$(function() {
$('#tgl').datepicker();
$('.tglan').datepicker();
});

/*
function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	if(rowCount < 5){							// limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i<colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
			
    $('.datepiker').datepicker();
		}
	}else{
		 alert("Maximum Passenger per ticket is 5.");
			   
	}
}

function deleteRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	for(var i=1; i<rowCount; i++) {
		var row = table.rows[i];
			if(rowCount <= 1) { 						// limit the user from removing all the fields
				alert("Cannot Remove all the Passenger.");
				break;
			}
			table.deleteRow(i);
			rowCount--;
			i--;
	}
}

*/

            $(function() {
                $("#table1").dataTable();
                $("#example1").dataTable();
                $("#example2").dataTable();     
                $("#example3").dataTable();     
                $(".tgl").datepicker();     
				$("[data-mask]").inputmask();	
            });

 
</script>
<legend><?php echo $title;

?></legend>
        
		<!--div><a href="<?php echo site_url('recruitment/calonkaryawan');?>" type="button" class="btn btn-primary"/> Kembali</a-->
		<div><a href="<?php echo site_url('recruitment/calonkaryawan');?>" type="button" class="btn btn-primary"/> Kembali</a>
		<form action="<?php echo site_url('recruitment/calonkaryawan/edit_master'); ?>" method='post' id="form"> 
		<div class="nav-tabs-custom">
			
			<ul class="nav nav-tabs">					
				<li class="active"><a href="#tab_1" data-toggle="tab">Profile Pelamar</a></li>
				<li><a href="#tab_2" data-toggle="tab">Riwayat Pekerjaan</a></li>
				<li><a href="#tab_3" data-toggle="tab">Riwayat Pendidkan</a></li>					
				<li><a href="#tab_4" data-toggle="tab">Lampiran</a></li>					
				
				
			</ul>
			
		</div>
		
<div class="tab-content">
			<div class="chart tab-pane active" id="tab_1" style="position: relative; height: 300px;" >				
			 
							<div class="col-sm-12">
									<h3> EDIT Data Umum Pelamar</h3>
									<div class="box box-header"> </div>
									<div class="row">
									<div class="col-sm-6 ">
										<div class="form-group">
											 <label class="control-label col-sm-3">No.KTP</label>
											<div class="col-sm-9">
												
													<input type="input" value="<?php echo $dtlpel['noktp'];?>" id="noktp1" name="noktp"  class="form-control" style="text-transform:uppercase" maxlength="20" required readonly >
												
												<!-- /.input group -->
											</div>
										</div>
										
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Nama Lengkap</label>
											<div class="col-sm-9">

													<input type="text"  id="nmlengkap1" value="<?php echo $dtlpel['nmlengkap'];?>" name="nmlengkap"  maxlength="30"  class="form-control" required>
												
												<!-- /.input group -->
											</div>
										</div>
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Tanggal Lahir</label>
											<div class="col-sm-9">

													<input type="text" value="<?php echo $dtlpel['tgllahir1'];?> " name="tgllahir" data-date-format="dd-mm-yyyy"  class="form-control tglan" >
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Jenis Kelamin</label>
											<div class="col-sm-9">

													<!--input type="text"  value="<?php echo $dtlpel['jk'];?>" name="jk"  maxlength="30" style="text-transform:uppercase" class="form-control" -->
													
													<select type="text" name="jk" id='jk' class="form-control col-sm-12" >										
																			
																			<option value="<?php echo $jk=$dtlpel['jk'];?>"><?php if($jk='L'){echo 'LAKI-LAKI';} else {echo 'PEREMPUAN';}?></option>																																																			
																			
													</select>
											</div>
										</div>
											
										<div class="form-group">
											 <label class="control-label col-sm-3">Negara Lahir</label>
											<div class="col-sm-9">											
													<select type="text" name="neglahir" id='negara' class="form-control col-sm-12" >										
																			<?php foreach ($list_opt_neg as $lon){ ?>																																																		
																			<option <?php if(trim($dtlpel['neglahir'])==trim($lon->kodenegara)){ echo 'selected';} ?> value="<?php echo trim($lon->kodenegara);?>"><?php echo trim($lon->namanegara);?></option>																																																			
																			<?php };?>
													</select>
											</div>
										</div>
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Provinsi Lahir</label>
											<div class="col-sm-9">
													<select type="text" name="provlahir" id='provinsi' class="form-control col-sm-12" >										
																			<?php foreach ($list_opt_prov as $lon){ ?>
																			<option <?php if(trim($dtlpel['provlahir'])==trim($lon->kodeprov)){ echo 'selected';} ?> value="<?php echo trim($lon->kodeprov);?>"><?php echo trim($lon->namaprov);?></option>
																			<?php };?>
													</select>
											</div>
										</div>
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Kota/Kab Lahir</label>
											<div class="col-sm-9">
													<select type="text" name="kotalahir" id='kotakab' class="form-control col-sm-12" >										
																			<?php foreach ($list_opt_kotakab as $lon){ ?>																																																	
																			<option <?php if(trim($dtlpel['kotalahir'])==trim($lon->kodekotakab)){ echo 'selected';} ?> value="<?php echo trim($lon->kodekotakab);?>"><?php echo trim($lon->namakotakab);?></option>																																																			
																			<?php };?>
													</select>
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Agama</label>
											<div class="col-sm-9">
													<select type="text" name="kdagama" id='kdagama' class="form-control col-sm-12" >										
																			<?php foreach ($list_opt_agama as $loa){ ?>																																																	
																			<option <?php if(trim($dtlpel['kd_agama'])==trim($loa->kdagama)){ echo 'selected';} ?> value="<?php echo trim($loa->kdagama);?>" ><?php echo trim($loa->nmagama);?></option>																																																		
																			<?php };?>
													</select>
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Status Nikah</label>
											<div class="col-sm-9">
													<select type="text" name="status_pernikahan" id='kdagama' class="form-control col-sm-12" >										
														<?php foreach ($list_opt_nikah as $lonikah){ ?>
														<option <?php if(trim($dtlpel['status_pernikahan'])==trim($lonikah->kdnikah)){ echo 'selected';}?> value="<?php echo trim($lonikah->kdnikah);?>" ><?php echo trim($lonikah->nmnikah);?></option>																																																			
														<?php };?>	
													</select>
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Tgl Lamaran</label>
											<div class="col-sm-9">

													<input type="text" value="<?php echo $dtlpel['tgllamaran1'];?>" id="tgllamaran2" name="tgllamaran2"  maxlength="30" style="text-transform:uppercase" class="form-control tglan" >
												
												<!-- /.input group -->
											</div>
										</div>
										
										<!--<div class="form-group">
											 <label class="col-sm-12">Tanggal Input</label>
											<div class="col-sm-12">
												
													<input type="text" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" >
												
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">Input By</label>
											<div class="col-sm-12">
											
													<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control"  >

												
											</div> 
										</div>-->
										</div>
										<div class="col-sm-6">
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Provinsi Tinggal</label>
											<div class="col-sm-8">
													<select type="text" name="provtinggal" id='provtinggal' class="form-control col-sm-12" >										
																			<?php foreach ($list_opt_prov as $lon){ ?>																	
																			<option <?php if(trim($dtlpel['provtinggal'])==trim(trim($lon->kodeprov))){ echo 'selected';}?> value="<?php  echo trim($lon->kodeprov);?>"><?php echo trim($lon->namaprov);?></option>
																			<?php };?>
													</select>
											</div>
										</div>
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Kota/Kab Tinggal</label>
											<div class="col-sm-8">
													<select type="text" name="kotatinggal" id='kotakabtinggal' class="form-control col-sm-12" >										
																			<?php foreach ($list_opt_kotakab as $lon){ ?>																																													
																			<option <?php if(trim($dtlpel['kotatinggal'])==trim($lon->kodekotakab)){echo 'selected';}?> value="<?php echo trim($lon->kodekotakab);?>"><?php echo trim($lon->namakotakab);?></option>																																																			
																			<?php };?>
													</select>
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Kecamatan Tinggal</label>
											<div class="col-sm-8">
													<select type="text" name="kecamatan" id='kecamatan' class="form-control col-sm-12" >										
																			<?php foreach ($list_opt_kecamatan as $lon){ ?>																																																		
																			<option <?php if(trim($dtlpel['kectinggal'])==trim($lon->kodekec)){echo 'selected';}?> value="<?php echo trim($lon->kodekec);?>"><?php echo trim($lon->namakec);?></option>																																																			
																			<?php };?>
													</select>
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Alamat Lengkap</label>
											<div class="col-sm-8">

													<input type="text" value="<?php echo $dtlpel['alamattinggal'];?>" id="alamat" name="alamat"   style="text-transform:uppercase" maxlength="200" class="form-control" ></input>
												
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">No. Hp 1</label>
											<div class="col-sm-8">

													<input type="text" id="nmdept" value="<?php echo $dtlpel['nohp1'];?>" name="nohp1"  maxlength="16" style="text-transform:uppercase" class="form-control" >
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">No. Hp 2</label>
											<div class="col-sm-8">

													<input type="text" value="<?php echo $dtlpel['nohp2'];?>" id="nmdept" name="nohp2"  maxlength="16" style="text-transform:uppercase" class="form-control" >
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Email</label>
											<div class="col-sm-8">

													<input type="text" value="<?php echo $dtlpel['email'];?>" id="nmdept" name="email"  maxlength="90" style="text-transform:uppercase" class="form-control">
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Posisi yang dilamar</label>
											<div class="col-sm-8">

													<input type="text" value="<?php echo $dtlpel['kdposisi'];?>" id="posisi" name="posisi"  maxlength="30" style="text-transform:uppercase" class="form-control" >
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Tgl Lowongan</label>
											<div class="col-sm-5">

													<input type="text" value="<?php echo trim($dtlpel['tgllowongan1']);?>" id="tgllowongan" name="tgllowongan2"  maxlength="30" style="text-transform:uppercase" class="form-control tglan" >
													<input type="hidden" name="tgllowongan"  class="form-control" data-date-format="dd-mm-yyyy" value="<?php echo $tgllowongan;?>">
													<input type="hidden" name="tgllamaran"  class="form-control"  data-date-format="dd-mm-yyyy" value="<?php echo $tgllamaran;?>" >
												<!-- /.input group -->
											</div>
										</div>

									</div>
									</div>		
							</div>
			</div>
			<div class="chart tab-pane" id="tab_2" style="position: relative; height: 300px;" >				
			  <div class="col-sm-12 ">
				<div class="col-sm-12">
				  <h3> Riwayat Pekerjaan</h3>
							<div class="row">
							<button href="#" data-toggle="modal" data-target="#riwayat_pekerjaan" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Riwayat Pekerjaan</button>
							  <div class="col-sm-12">
								<table id="example1" class="table table-bordered table-striped" >
									<thead>
										<tr>																				
											<td>No</td>												
											<td>Nama Perusahaan</td>	
											<td>Jabatan</td>
											<td>Bidang Usaha</td>
											<td width="100%">Tahun Masuk</td>												
											<td width="100%">Tahun Keluar</td>										
											<td>Keterangan</td>																
											<td>Action</td>																
										</tr>
									</thead>
									<tbody>
								<?php $no=1;foreach ($listpgl as $listker){?>
										<tr>									
											<td><?php echo $no;?></td>
											<td><?php echo $listker->nmperusahaan;?></td>
											<td><?php echo $listker->bidang_usaha;?></td>
											<td><?php echo $listker->jabatan;?></td>
											<td><?php echo $listker->tahun_masuk;?></td>											
											<td><?php echo $listker->tahun_keluar;?></td>											
											<td><?php echo $listker->keterangan;?></td>											
											<td><a href="<?php echo site_url('recruitment/calonkaryawan/hps_riwayat_pengalaman').'/'.trim($listker->noktp).'/'.$listker->tgllowongan.'/'.$listker->tgllamaran.'/'.$listker->nmperusahaan;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Pengalaman Kerja ini?')"><i class="glyphicon glyphicon-trash"></i></a></td>											
										
											<!--td><a href="#" data-toggle="modal" data-target=".ekerja<?php echo str_replace('.','',trim($listker->nir)).trim($listker->pglmke);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
											|<a href="<?php echo site_url('hrd/hrd/hapus_pglmkerja/').'/'.trim($listker->nir).'/'.$listker->pglmke;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Pengalaman Kerja ini?')"><i class="glyphicon glyphicon-trash"></i></a></td-->																			
										</tr>
										<?php $no++; }?>
									</tbody>
								</table>
							  </div>
							</div>
				  <!--/form-->
				  
				  <!--button class="btn btn-primary prevBtn btn-sm pull-left" type="button">Back</button>
				  <button class="btn btn-primary nextBtn btn-sm pull-right" type="button">Next</button-->
				  
				</div>
			  </div>
			</div>			
			<div class="chart tab-pane" id="tab_3" style="position: relative; height: 300px;" >				
			  <div class="col-sm-12 ">
				<div class="col-sm-12">
				  <h3> Riwayat Pendidikan</h3>
					<div class="row">
					<button href="#" data-toggle="modal" data-target="#riwayat_pendidikan" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Riwayat Pendidikan</button>
						  <div class="col-sm-12">
							<table id="example2" class="table table-bordered table-striped" >
									<thead>
										<tr>																				
											<td>No</td>												
											<td>Status Pendidikan</td>	
											<td>Nama Pendidikan</td>
											<td>Jurusan</td>
											<td>Program studi</td>
											<td>Kota</td>
											<td>IPK/Nilai</td>
											<td width="100%">Tahun Masuk</td>												
											<td width="100%">Tahun Lulus</td>										
											<td>Keterangan</td>																
											<td>Action</td>																
										</tr>
									</thead>
									<tbody>
								<?php $no=1;foreach ($listpdk as $listpdk){?>
										<tr>									
											<td><?php echo $no;?></td>
											<td><?php echo $listpdk->kdpendidikan;?></td>
											<td><?php echo $listpdk->nmsekolah;?></td>
											<td><?php echo $listpdk->jurusan;?></td>
											<td><?php echo $listpdk->program_studi;?></td>
											<td><?php echo $listpdk->kotakab;?></td>
											<td><?php echo $listpdk->nilai;?></td>
											<td><?php echo $listpdk->tahun_masuk;?></td>
											<td><?php echo $listpdk->tahun_keluar;?></td>
											<td><?php echo $listpdk->keterangan;?></td>											
											<td><a href="<?php echo site_url('recruitment/calonkaryawan/hps_riwayat_pendidikan').'/'.trim($listpdk->noktp).'/'.$listpdk->tgllowongan.'/'.$listpdk->tgllamaran.'/'.$listpdk->kdpendidikan;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Riwayat Pendidikan ini?')"><i class="glyphicon glyphicon-trash"></i></a></td>											
											<!--td><a href="#" data-toggle="modal" data-target=".ekerja<?php echo str_replace('.','',trim($listker->nir)).trim($listker->pglmke);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
											|<a href="<?php echo site_url('hrd/hrd/hapus_pglmkerja/').'/'.trim($listker->nir).'/'.$listker->pglmke;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Pengalaman Kerja ini?')"><i class="glyphicon glyphicon-trash"></i></a></td-->																			
										</tr>
										<?php $no++; }?>
									</tbody>
								</table>
						  </div>
					</div>
				  
				</div>
			  </div>
			</div>
			<div class="chart tab-pane" id="tab_4" style="position: relative; height: 300px;" >				
			  <div class="col-sm-12 ">
				<div class="col-sm-12">
				  <h3> Lampiran Lampiran</h3>
					<div class="row">
					<div class="col-sm-6 ">
						<div class="row"></br>	
						<label for="berlaku" class="col-sm-8 control-label" align="left">FOTO PROFILE</label>
						<div class="col-sm-10">
							
							<div>							
                                <!--form class="form-horizontal" action="<?php echo site_url('recruitment/calonkaryawan/up_foto');?>" method="post" enctype="multipart/form-data"--->						
                                    
									<div class="box-body">										
										
											
											<div class="col-sm-8">
												<img src="<?php $lp=$dtllamp_dp['file_name']; if ($lp<>'') { echo base_url('assets/attachment/fotoprofil/'.$lp);} else { echo base_url('assets/img/user.png');} ;?>" width="70%" height="70%" alt="User Image">
											</div>
											<!--a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".gantigambar">Ganti Foto</a-->	
											<div class="col-sm-10">
											<a href="<?php echo site_url('recruitment/calonkaryawan/replace_foto').'/'.trim($noktp).'/'.$tgllowongan.'/'.$tgllamaran;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus Lampiran Ini?')"><i class="glyphicon glyphicon-trash">Hapus Foto</i></a>
											</div>
																			
                                    </div><!-- /.box-body -->
								<!--button onclick="return confirm('Ubah Foto ini?')" type="submit" class="btn btn-primary">Simpan</button-->
                                <!--/form-->
                            </div>
							<br></br>
							<div class="col-sm-6 ">
								<div class="form-group">																					
									<p align="center"><input align="center" type="file" id="userfoto" name="gambar" value="<?php //echo $dtl['image'];?>"> </p>
								</div>						
							</div>
						</div>
					</div>
					</div>
						<div class="col-sm-6 ">
						<div class="row"></br>	
						<label for="berlaku" class="col-sm-7 control-label">BERKAS DAN LAMPIRAN</label>
							<div class="col-sm-12">
							<table id="example3" class="table table-bordered table-striped" >
									<thead>
										<tr>																				
											<td>No</td>												
											<td>Unduh Daftar Lampiran Pelamar</td>	
											<td>Action</td>	
																								
										</tr>
									</thead>
									<tbody>
								<?php $no=1;foreach ($dtllamp_at as $at){?>
										<tr>									
											<td><?php echo $no;?></td>
											<td><a href="<?php echo site_url('assets/attachment').'/'.$at->file_name;?>"><?php echo $at->file_name;?></a></td>
											<td><a href="<?php echo site_url('recruitment/calonkaryawan/hps_lampiran').'/'.trim($at->noktp).'/'.$at->tgllowongan.'/'.$at->tgllamaran.'/'.$at->file_name;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus Lampiran Ini?')"><i class="glyphicon glyphicon-trash"></i></a></td>	

											<!--td><a href="#" data-toggle="modal" data-target=".ekerja<?php echo str_replace('.','',trim($listker->nir)).trim($listker->pglmke);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
											|<a href="<?php echo site_url('hrd/hrd/hapus_pglmkerja/').'/'.trim($listker->nir).'/'.$listker->pglmke;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Pengalaman Kerja ini?')"><i class="glyphicon glyphicon-trash"></i></a></td-->																			
										</tr>
										<?php $no++; }?>
									</tbody>
								</table>
						  </div>
						  <div class="col-sm-6 ">
								<table id="dataTableLampiran" style="width:100%">
								<tr><td>
									<div class="form-group">	
										<label class="control-label col-sm-3">Berkas</label>	
										<div class="col-lg-12">
											<input type="file" class="form-control" name="userFiles[]" multiple/>
										</div>
									</div>
								</tr></td>
								</table>
							</div>
					</div>
					</div>
					
					
					<!--button class="btn btn-primary prevBtn btn-sm pull-left" type="button">Back</button-->
				
					<!--<button class="btn btn-success btn-sm pull-right" id="btnSave" onclick="save()" type="submit">Submit</button>-->
					<button class="btn btn-success btn-sm pull-right" type="submit">Simpan</button>
					
					</form>
				</div>
			  </div>
			</div>	
</div>  
<!--Modal Riwayat Pekerjaaan-->
<div class="modal fade" id="riwayat_pekerjaan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Riwayat Pekerjaan</h4>
		<?php// echo $tgllowongan;?>
		<?php// echo $tgllamaran;?>
      </div>
	  <form action="<?php echo site_url('recruitment/calonkaryawan/tambah_riwayat_pengalaman')?>" method="post">
      <div class="modal-body">
	  	
								  <table id="dataTablePekerjaan" class="box box-primary">
				  <tr><td>
				  <div class="row">
				  <div class="col-sm-12">
								<div class="box-header">									
								</div>
								<div class="box-body">
								<div class="col-sm-6 ">
								<div class="form-group">
									  <label class="control-label col-sm-4">Nama Perusahaan</label>
									  <div class="col-sm-8">
									<input type="text" id="kddept" name="pkj_nmperusahaan"  class="form-control" style="text-transform:uppercase" maxlength="50" required>
								</div>
							</div>	
						<br></br>							
							<div class="form-group">
									  <label class="control-label col-sm-4">Bidang Usaha</label>
									  <div class="col-sm-8">   
									<input type="text" id="kddept" name="pkj_bidang_usaha"  class="form-control" style="text-transform:uppercase" maxlength="40" required>
								</div>
							</div>		
						<br></br>							
							<div class="form-group">
									  <label class="control-label col-sm-4">Tanggal Masuk</label>
									  <div class="col-sm-8">   
									<input type="text" id="tgl" name="pkj_tahun_masuk" data-date-format="dd-mm-yyyy" class="form-control tgl" required>
								</div>
							</div>
						<br></br>	
							<div class="form-group">
									  <label class="control-label col-sm-4">Tanggal Keluar</label>
									  <div class="col-sm-8">   
									<input type="text" id="tgl2" name="pkj_tahun_keluar" data-date-format="dd-mm-yyyy" class="form-control tgl" required>
								</div>
							</div>
									
								</div>
							<div class="col-sm-6 ">
								<div class="form-group">
									  <label class="control-label col-sm-4">Bagian</label>
									  <div class="col-sm-8">    
									<input type="text" id="kddept" name="pkj_bagian"  class="form-control" style="text-transform:uppercase" maxlength="40" >
								</div>
							</div>
						<br></br>	
							<div class="form-group">
									  <label class="control-label col-sm-4">Jabatan</label>
									  <div class="col-sm-8">   
									<input type="text" id="kddept" name="pkj_jabatan"  class="form-control" style="text-transform:uppercase" maxlength="40" >
								</div>
							</div>
						<br></br>
							<div class="form-group">
									  <label class="control-label col-sm-4">Nama Atasan</label>
									  <div class="col-sm-8">  
									<input type="text" id="kddept" name="pkj_nmatasan"  class="form-control" style="text-transform:uppercase" maxlength="50" >
								</div>
							</div>
						<br></br>	
							<div class="form-group">
									  <label class="control-label col-sm-4">Jabatan Atasan</label>
									  <div class="col-sm-8">  
									<input type="text" id="kddept" name="pkj_jbtatasan"  class="form-control" style="text-transform:uppercase" maxlength="40" >
								</div>
							</div>
						<br></br>	
							<div class="form-group">
									  <label class="control-label col-sm-4">Keterangan</label>
									  <div class="col-sm-8">   
									<textarea type="text" id="nmdept" name="pkj_keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
											<input type="hidden" name="noktp"  class="form-control" value="<?php echo $noktp;?>">
											<input type="hidden" name="tgllowongan"  class="form-control" data-date-format="dd-mm-yyyy" value="<?php echo $tgllowongan;?>">
											<input type="hidden" name="tgllamaran"  class="form-control"  data-date-format="dd-mm-yyyy" value="<?php echo $tgllamaran;?>" >
								</div>
							</div>
								</div>
								</div>
					</div>
				  </div>
				  </td></tr>
				  </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>			
<!--Modal Riwayat Pendidkan-->
<div class="modal fade" id="riwayat_pendidikan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Riwayat Pendidikan</h4>
      </div>
	  <form action="<?php echo site_url('recruitment/calonkaryawan/tambah_riwayat_pendidikan')?>" method="post">
      <div class="modal-body">
	  	
				<table id="dataTablePendidikan" class="box box-primary">
				  <tr><td>
				  <div class="row">
				  <div class="col-sm-12">
								<div class="box-header">									
								</div>
								<div class="box-body">
								<div class="col-sm-6 ">
								<div class="form-group">
									  <label class="control-label col-sm-4">Nama Pendidikan</label>
									  <div class="col-sm-8">
										<select class="form-control" name="pdk_kdpendidikan" id="kdpendidikan" required>
										  <?php foreach($list_pendidikan as $listkan){?>
										  <option value="<?php echo trim($listkan->kdpendidikan);?>" ><?php echo $listkan->nmpendidikan;?></option>						  
										  <?php }?>
										</select>
									  </div>
								</div>
								<br></br>
								<div class="form-group">
									  <label class="control-label col-sm-4">Nama Sekolah</label>
									  <div class="col-sm-8">
										<input type="text" id="kddept" name="pdk_nmsekolah"  class="form-control" style="text-transform:uppercase" maxlength="40" required>
									  </div>
								</div>
								<br></br>
								<div class="form-group">
									  <label class="control-label col-sm-4">Kota/Kab</label>
									  <div class="col-sm-8">
										<input type="text" id="kddept" name="pdk_kotakab"  class="form-control" style="text-transform:uppercase" maxlength="30" required>
									  </div>
								</div>
								<br></br>
								<div class="form-group">
									  <label class="control-label col-sm-4">Jurusan</label>
									  <div class="col-sm-8">
										<input type="text" id="kddept" name="pdk_jurusan"  class="form-control" style="text-transform:uppercase" maxlength="30" required>
									  </div>
								</div>
									
								</div>
								<div class="col-sm-6 ">
								<div class="form-group">
									  <label class="control-label col-sm-4">Program Study</label>
									  <div class="col-sm-8">
											<input type="text" id="kddept" name="pdk_program_studi"  class="form-control" style="text-transform:uppercase" maxlength="30" required>
										</div>
									</div>
									<br></br>
									<div class="form-group">
									  <label class="control-label col-sm-4">Tahun Masuk</label>
									  <div class="col-sm-8">  
											<input type="text" id="year" name="pdk_tahun_masuk" class="form-control year" required>
										</div>
									</div>
									<br></br>
									<div class="form-group">
									  <label class="control-label col-sm-4">Tahun Lulus</label>
									  <div class="col-sm-8">  
											<input type="text" id="year" name="pdk_tahun_keluar" class="form-control year" required>
										</div>
									</div>
									<br></br>
									<div class="form-group">
									  <label class="control-label col-sm-4">Nilai/IPK</label>
									  <div class="col-sm-8">
										<input type="text" name="pdk_nilai"  class="form-control" placeholder="0" required>
									  </div>
									</div>
									<br></br>
									<div class="form-group">
									  <label class="control-label col-sm-4">Keterangan</label>
									  <div class="col-sm-8">   
											<textarea type="text" name="pdk_keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
											<input type="hidden" name="noktp"  class="form-control" value="<?php echo $noktp;?>">
											<input type="hidden" name="tgllowongan"  class="form-control" data-date-format="dd-mm-yyyy" value="<?php echo $tgllowongan;?>">
											<input type="hidden" name="tgllamaran"  class="form-control"  data-date-format="dd-mm-yyyy" value="<?php echo $tgllamaran;?>" >
										</div>
									</div>
								</div>
								</div>
					</div>
				  </div>
				  </td></tr>
				  </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>

		<script type="text/javascript">


  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgllahir').datepicker();
	
	$('#userfoto').picEdit({
		redirectUrl:false,
		formSubmitted: function(response){
			 $(location).attr('href','<?php echo site_url('recruitment/calonkaryawan/index/rep_succes');?>');
		  }
	});
	
    $('.tgl').datepicker();
	$('.year').datepicker({
		format: " yyyy",
		viewMode: "years", 
		minViewMode: "years"
	
	});
			
</script>
<script>

  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgllahir').datepicker();
    $('.datepiker').datepicker();
    $('#dateinput1').datepicker();

  

</script>
			
