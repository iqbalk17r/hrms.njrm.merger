<?php 
/*
	@author : Junis
*/
?>
<script>
$(function() {
$('#tgl').datepicker();
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
				$("[data-mask]").inputmask();	
            });

 
</script>
<legend><?php echo $title;

?></legend>
        <!--form action="<?php echo site_url('trans/wizard/test_insert'); ?>" method='post' id="form"--> 
		<div><a href="<?php echo site_url('recruitment/calonkaryawan');?>" type="button" class="btn btn-primary"/> Kembali</a>
		<a href="<?php echo site_url("recruitment/calonkaryawan/edit_pelamar/$noktp/$tgllowongan/$tgllamaran");?>" type="button" class="btn btn-success"/> Ubah Data</a></div></br>
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
									<h3> Data Umum Pelamar</h3>
									<div class="box box-header"> </div>
									<div class="row">
									<div class="col-sm-6 ">
										<div class="form-group">
											 <label class="control-label col-sm-3">No.KTP</label>
											<div class="col-sm-9">
												
													<input type="text" value="<?php echo $dtlpel['noktp'];?>" id="noktp1" name="noktp"  class="form-control" style="text-transform:uppercase" maxlength="20" required readonly>
												
												<!-- /.input group -->
											</div>
										</div>
										
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Nama Lengkap</label>
											<div class="col-sm-9">

													<input type="text"  id="nmlengkap1" value="<?php echo $dtlpel['nmlengkap'];?>" name="nmlengkap"  maxlength="30" style="text-transform:uppercase" class="form-control" required readonly>
												
												<!-- /.input group -->
											</div>
										</div>
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Tanggal Lahir</label>
											<div class="col-sm-9">

													<input type="text" value="<?php echo $dtlpel['tgllahir'];?> " name="tgllahir" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Jenis Kelamin</label>
											<div class="col-sm-9">

													<input type="text"  value="<?php echo $dtlpel['jk'];?>" name="jk"  maxlength="30" style="text-transform:uppercase" class="form-control" readonly>
											</div>
										</div>
											
										<div class="form-group">
											 <label class="control-label col-sm-3">Negara Lahir</label>
											<div class="col-sm-9">											
													<select type="text" name="neglahir" id='negara' class="form-control col-sm-12" disabled>										
																			<?php foreach ($list_opt_neg as $lon){ ?>																																																		
																			<option <?php if(trim($dtlpel['neglahir'])==trim($lon->kodenegara)){ echo 'selected';} ?> value="<?php echo trim($lon->kodenegara);?>"><?php echo trim($lon->namanegara);?></option>																																																			
																			<?php };?>
													</select>
											</div>
										</div>
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Provinsi Lahir</label>
											<div class="col-sm-9">
													<select type="text" name="provlahir" id='provinsi' class="form-control col-sm-12" readonly>										
																			<?php foreach ($list_opt_prov as $lon){ ?>
																			<option <?php if(trim($dtlpel['provlahir'])==trim($lon->kodeprov)){ echo 'selected';} ?> value="<?php echo trim($lon->kodeprov);?>"><?php echo trim($lon->namaprov);?></option>
																			<?php };?>
													</select>
											</div>
										</div>
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Kota/Kab Lahir</label>
											<div class="col-sm-9">
													<select type="text" name="kotalahir" id='kotakab' class="form-control col-sm-12" readonly>										
																			<?php foreach ($list_opt_kotakab as $lon){ ?>																																																	
																			<option <?php if(trim($dtlpel['kotalahir'])==trim($lon->kodekotakab)){ echo 'selected';} ?> value="<?php echo trim($lon->kodekotakab);?>"><?php echo trim($lon->namakotakab);?></option>																																																			
																			<?php };?>
													</select>
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Agama</label>
											<div class="col-sm-9">
													<select type="text" name="kdagama" id='kdagama' class="form-control col-sm-12" readonly>										
																			<?php foreach ($list_opt_agama as $loa){ ?>																																																	
																			<option <?php if(trim($dtlpel['kd_agama'])==trim($loa->kdagama)){ echo 'selected';} ?> value="<?php echo trim($loa->kdagama);?>" ><?php echo trim($loa->nmagama);?></option>																																																		
																			<?php };?>
													</select>
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Status Nikah</label>
											<div class="col-sm-9">
													<select type="text" name="status_pernikahan" id='kdagama' class="form-control col-sm-12" readonly>										
														<?php foreach ($list_opt_nikah as $lonikah){ ?>
														<option <?php if(trim($dtlpel['status_pernikahan'])==trim($lonikah->kdnikah)){ echo 'selected';}?> value="<?php echo trim($lonikah->kdnikah);?>" ><?php echo trim($lonikah->nmnikah);?></option>																																																			
														<?php };?>	
													</select>
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Tgl Lamaran</label>
											<div class="col-sm-9">

													<input type="text" value="<?php echo $dtlpel['tgllamaran'];?>" id="tgllamaran" name="tgllamaran"  maxlength="30" style="text-transform:uppercase" class="form-control" readonly>
												
												<!-- /.input group -->
											</div>
										</div>
										
										<!--<div class="form-group">
											 <label class="col-sm-12">Tanggal Input</label>
											<div class="col-sm-12">
												
													<input type="text" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
												
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">Input By</label>
											<div class="col-sm-12">
											
													<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

												
											</div> 
										</div>-->
										</div>
										<div class="col-sm-6">
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Provinsi Tinggal</label>
											<div class="col-sm-8">
													<select type="text" name="provtinggal" id='provtinggal' class="form-control col-sm-12" readonly>										
																			<?php foreach ($list_opt_prov as $lon){ ?>																	
																			<option <?php if(trim($dtlpel['provtinggal'])==trim(trim($lon->kodeprov))){ echo 'selected';}?> value="<?php  echo trim($lon->kodeprov);?>"><?php echo trim($lon->namaprov);?></option>
																			<?php };?>
													</select>
											</div>
										</div>
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Kota/Kab Tinggal</label>
											<div class="col-sm-8">
													<select type="text" name="kotatinggal" id='kotakabtinggal' class="form-control col-sm-12" readonly>										
																			<?php foreach ($list_opt_kotakab as $lon){ ?>																																													
																			<option <?php if(trim($dtlpel['kotatinggal'])==trim($lon->kodekotakab)){echo 'selected';}?> value="<?php echo trim($lon->kodekotakab);?>"><?php echo trim($lon->namakotakab);?></option>																																																			
																			<?php };?>
													</select>
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Kecamatan Tinggal</label>
											<div class="col-sm-8">
													<select type="text" name="kecamatan" id='kecamatan' class="form-control col-sm-12" readonly>										
																			<?php foreach ($list_opt_kecamatan as $lon){ ?>																																																		
																			<option <?php if(trim($dtlpel['kectinggal'])==trim($lon->kodekec)){echo 'selected';}?> value="<?php echo trim($lon->kodekec);?>"><?php echo trim($lon->namakec);?></option>																																																			
																			<?php };?>
													</select>
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Alamat Lengkap</label>
											<div class="col-sm-8">

													<input type="text" value="<?php echo $dtlpel['alamattinggal'];?>" id="alamat" name="alamat"   style="text-transform:uppercase" maxlength="200" class="form-control" disabled readonly></input>
												
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">No. Hp 1</label>
											<div class="col-sm-8">

													<input type="text" id="nmdept" value="<?php echo $dtlpel['nohp1'];?>" name="nohp1"  maxlength="16" style="text-transform:uppercase" class="form-control" readonly>
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">No. Hp 2</label>
											<div class="col-sm-8">

													<input type="text" value="<?php echo $dtlpel['nohp2'];?>" id="nmdept" name="nohp2"  maxlength="16" style="text-transform:uppercase" class="form-control" readonly>
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Email</label>
											<div class="col-sm-8">

													<input type="text" value="<?php echo $dtlpel['email'];?>" id="nmdept" name="email"  maxlength="90" style="text-transform:uppercase" class="form-control"readonly>
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="control-label col-sm-3">Posisi yang dilamar</label>
											<div class="col-sm-8">

													<input type="text" value="<?php echo $dtlpel['kdposisi'];?>" id="posisi" name="posisi"  maxlength="30" style="text-transform:uppercase" class="form-control" readonly>
												
												<!-- /.input group -->
											</div>
										</div>
										
										<div class="form-group">
											 <label class="control-label col-sm-3">Tgl Lowongan</label>
											<div class="col-sm-5">

													<input type="text" value="<?php echo $dtlpel['tgllowongan'];?>" id="tgllowongan" name="tgllowongan"  maxlength="30" style="text-transform:uppercase" class="form-control" readonly>
												
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
											<div class="col-sm-10"></div>
																			
                                    </div><!-- /.box-body -->
								<!--button onclick="return confirm('Ubah Foto ini?')" type="submit" class="btn btn-primary">Simpan</button-->
                                <!--/form-->
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
																								
										</tr>
									</thead>
									<tbody>
								<?php $no=1;foreach ($dtllamp_at as $at){?>
										<tr>									
											<td><?php echo $no;?></td>
											<td><a href="<?php echo site_url('assets/attachment').'/'.$at->file_name;?>"><?php echo $at->file_name;?></a></td>

											<!--td><a href="#" data-toggle="modal" data-target=".ekerja<?php echo str_replace('.','',trim($listker->nir)).trim($listker->pglmke);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
											|<a href="<?php echo site_url('hrd/hrd/hapus_pglmkerja/').'/'.trim($listker->nir).'/'.$listker->pglmke;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Pengalaman Kerja ini?')"><i class="glyphicon glyphicon-trash"></i></a></td-->																			
										</tr>
										<?php $no++; }?>
									</tbody>
								</table>
						  </div>
					</div>
					</div>
					
					
					<!--button class="btn btn-primary prevBtn btn-sm pull-left" type="button">Back</button-->
				
					<!--<button class="btn btn-success btn-sm pull-right" id="btnSave" onclick="save()" type="submit">Submit</button>-->
					<!--button class="btn btn-success btn-sm pull-right" type="submit">Edit</button-->
					<!--/form-->
				</div>
			  </div>
			</div>	
</div>  
			

		<script type="text/javascript">
			$(function() {
			  $('#gambaruser').picEdit({
				formSubmitted: function(ajax){
				  $('#message').html(ajax.response);
				 // $('#gbr').html(ajax.response);
				  //$("#gbr").load('#gbr1');
				 // $('.modal fade gantigambar').hide();
				}
			 });
			});
		</script>			

<script>

  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgllahir').datepicker();
    $('.datepiker').datepicker();
    $('#dateinput1').datepicker();

  

</script>
			
