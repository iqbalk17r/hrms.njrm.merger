<?php 
/*
	@author : Junis
*/
?>
	
<script>
$(function() {
$("#provinsi").chained("#negara");								
$("#kotakab").chained("#provinsi");								
$("#kotakabtinggal").chained("#provtinggal");								
$("#kecamatan").chained("#kotakabtinggal");	
///alert("chained boss big");		
});

function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	if(rowCount < 5){							// limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i<colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
			$('.tgl').datepicker();
			$('.year').datepicker({
				format: " yyyy",
				viewMode: "years", 
				minViewMode: "years"
				});
		}
	}else{
		 alert("Maximum data per submit is 5.");
			   
	}
}

function deleteRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	for(var i=1; i<rowCount; i++) {
		var row = table.rows[i];
			if(rowCount <= 1) { 						// limit the user from removing all the fields
				alert("Cannot remove all the form.");
				break;
			}
			table.deleteRow(i);
			rowCount--;
			i--;
	}
}

$(function() {
$('#tgl').datepicker();
$('.year').datepicker({
	format: " yyyy",
    viewMode: "years", 
    minViewMode: "years"
	});	
});

</script>

<legend><?php echo $title;?></legend>
        <form role="form" enctype="multipart/form-data" action="<?php echo site_url('recruitment/calonkaryawan/add_master'); ?>" method='post'> 
		<div class="form-horizontal">
			<div class="stepwizard ">
				<div class="stepwizard-row setup-panel">				
					<div class="stepwizard-step col-sm-1">
						<a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
						<p>Step 1</p>
					</div>
					<div class="stepwizard-step col-sm-1">
						<a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
						<p>Step 2</p>
					</div>
						<div class="stepwizard-step col-sm-1">
						<a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
						<p>Step 3</p>
					</div>				
				  <div class="stepwizard-step col-sm-1">
					<a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
					<p>Step 4</p>
				  </div>
				</div>
			</div>
			<div class="row setup-content " id="step-1">
			  <div class="col-sm-12 ">
				<div class="col-sm-12">
				  <h3> Data Umum Pelamar</h3>
				  <div class="box box-primary">
<div class="row">
<div class="box-header">									
</div>
<div class="box-body">
<div class="col-sm-6 ">

						<!--form role="form" action="<?php //echo site_url('recruitment/calonkaryawan/add_master');?>" method="post" -->
			<div class="form-group">
				 <label class="control-label col-sm-3">No.KTP</label>
				<div class="col-sm-9">
					
						<input type="text" id="kddept" name="noktp"  class="form-control" style="text-transform:uppercase" maxlength="20" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="control-label col-sm-3">Nama Lengkap</label>
				<div class="col-sm-9">

						<input type="text" id="nmdept" name="nmlengkap"  maxlength="30" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			
			<div class="form-group">
				 <label class="control-label col-sm-3">Tanggal Lahir</label>
				<div class="col-sm-9">

						<input type="text" id="tgllahir" name="tgllahir" data-date-format="dd-mm-yyyy"  class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="control-label col-sm-3">Jenis Kelamin</label>
				<div class="col-sm-9">

						<select  name="jk" style="text-transform:uppercase;"  class="form-control" type="text" required>
											<option value="L">LAKI-LAKI</option>
											<option value="P">PEREMPUAN</option>
						</select>
				</div>
			</div>
							
			<div class="form-group">
				 <label class="control-label col-sm-3">Negara Lahir</label>
				<div class="col-sm-9">
						<select type="text" name="neglahir" id='negara' class="form-control col-sm-12" required>										
												<?php foreach ($list_opt_neg as $lon){ ?>
												<option value="<?php echo trim($lon->kodenegara);?>"><?php echo trim($lon->namanegara);?></option>																																																			
												<?php };?>
						</select>
				</div>
			</div>
			
			<div class="form-group">
				 <label class="control-label col-sm-3">Provinsi Lahir</label>
				<div class="col-sm-9">
						<select type="text" name="provlahir" id='provinsi' class="form-control col-sm-12" required>										
												<?php foreach ($list_opt_prov as $lon){ ?>
												<option value="<?php echo trim($lon->kodeprov);?>" class="<?php echo trim($lon->kodenegara);?>"><?php echo trim($lon->namaprov);?></option>
												<?php };?>
						</select>
				</div>
			</div>
			
			<div class="form-group">
				 <label class="control-label col-sm-3">Kota/ Kab. Lahir</label>
				<div class="col-sm-9">
						<select type="text" name="kotalahir" id='kotakab' class="form-control col-sm-12" required>										
												<?php foreach ($list_opt_kotakab as $lon){ ?>
												<option value="<?php echo trim($lon->kodekotakab);?>" class="<?php echo trim($lon->kodeprov);?>"><?php echo trim($lon->namakotakab);?></option>																																																			
												<?php };?>
						</select>
				</div>
			</div>
			<div class="form-group">
				 <label class="control-label col-sm-3">Agama</label>
				<div class="col-sm-9">
						<select type="text" name="kdagama" id='kdagama' class="form-control col-sm-12" required>										
												<?php foreach ($list_opt_agama as $loa){ ?>
												<option value="<?php echo trim($loa->kdagama);?>" ><?php echo trim($loa->nmagama);?></option>																																																		
												<?php };?>
						</select>
				</div>
			</div>
			<div class="form-group">
				 <label class="control-label col-sm-3">Status Nikah</label>
				<div class="col-sm-9">
						<select type="text" name="status_pernikahan" id='kdagama' class="form-control col-sm-12" required>										
							<?php foreach ($list_opt_nikah as $lonikah){ ?>
							<option value="<?php echo trim($lonikah->kdnikah);?>" ><?php echo trim($lonikah->nmnikah);?></option>																																																			
							<?php };?>	
						</select>
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
						<select type="text" name="provtinggal" id='provtinggal' class="form-control col-sm-12" required>										
												<?php foreach ($list_opt_prov as $lon){ ?>
												<option value="<?php echo trim($lon->kodeprov);?>" class="<?php echo trim($lon->kodenegara);?>"><?php echo trim($lon->namaprov);?></option>
												<?php };?>
						</select>
				</div>
			</div>
			
			<div class="form-group">
				 <label class="control-label col-sm-3">Kota/ Kab. Tinggal</label>
				<div class="col-sm-8">
						<select type="text" name="kotatinggal" id='kotakabtinggal' class="form-control col-sm-12" required>										
												<?php foreach ($list_opt_kotakab as $lon){ ?>
												<option value="<?php echo trim($lon->kodekotakab);?>" class="<?php echo trim($lon->kodeprov);?>"><?php echo trim($lon->namakotakab);?></option>																																																			
												<?php };?>
						</select>
				</div>
			</div>
			<div class="form-group">
				 <label class="control-label col-sm-3">Kecamatan Tinggal</label>
				<div class="col-sm-8">
						<select type="text" name="kecamatan" id='kecamatan' class="form-control col-sm-12" required>										
												<?php foreach ($list_opt_kecamatan as $lon){ ?>
												<option value="<?php echo trim($lon->kodekec);?>" class="<?php echo trim($lon->kodekotakab);?>"><?php echo trim($lon->namakec);?></option>																																																			
												<?php };?>
						</select>
				</div>
			</div>
			<div class="form-group">
				 <label class="control-label col-sm-3">Alamat Lengkap</label>
				<div class="col-sm-8">

						<textarea type="text" id="alamat" name="alamat"   style="text-transform:uppercase" maxlength="200" class="form-control" required></textarea>
					
				</div>
			</div>
			<div class="form-group">
				 <label class="control-label col-sm-3">No. Hp 1</label>
				<div class="col-sm-8">

						<input type="text" id="nmdept" name="nohp1"  maxlength="16" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="control-label col-sm-3">No. Hp 2</label>
				<div class="col-sm-8">

						<input type="text" id="nmdept" name="nohp2"  maxlength="16" style="text-transform:uppercase" class="form-control" >
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="control-label col-sm-3">Email</label>
				<div class="col-sm-8">

						<input type="text" id="nmdept" name="email"  maxlength="90" style="text-transform:uppercase" class="form-control">
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="control-label col-sm-3">Posisi yang dilamar</label>
				<div class="col-sm-8">

						<input type="text" id="posisi" name="posisi"  maxlength="30" style="text-transform:uppercase" class="form-control" required>
					
					<!-- /.input group -->
				</div>
			</div>
		
		
		</div>

		<!--/form-->
		</div>
</div>
</div>
		
					<button class="btn btn-primary nextBtn btn-sm pull-right" type="button">Next</button>
				  
				</div>
			  </div>
			</div>
			<div class="row setup-content" id="step-2">
			  <div class="col-sm-12 ">
				<div class="col-sm-12">
				  <h3> Riwayat Pendidikan</h3>
				  
				  <div class="col-sm-12 text-right">
				  <button type="button" class="btn btn-danger btn-sm" onClick="deleteRow('dataTablePendidikan')">Hapus Riwayat</button>
				  <button type="button" class="btn btn-primary btn-sm" onClick="addRow('dataTablePendidikan')">Tambah Riwayat</button>
				  </div>
				  <br /><br />
				  <!--form role="form" enctype="multipart/form-data" action="<?php //echo site_url('recruitment/calonkaryawan/add_riwayat_pendidikan');?>" method="post"-->
				  <table id="dataTablePendidikan" class="box box-primary">
				  <tr><td>
				  <div class="row">
				  <div class="col-sm-12">
								<div class="box-header">									
								</div>
								<div class="box-body">
								<div class="col-sm-6 ">
								<div class="form-group">
									  <label class="control-label col-sm-3">Nama Pendidikane</label>
									  <div class="col-sm-9">
										<select class="form-control" name="pdk_kdpendidikan[]" id="kdpendidikan" required>
										  <?php foreach($list_pendidikan as $listkan){?>
										  <option value="<?php echo trim($listkan->kdpendidikan);?>" ><?php echo $listkan->nmpendidikan;?></option>						  
										  <?php }?>
										</select>
									  </div>
								</div>
								<div class="form-group">
									  <label class="control-label col-sm-3">Nama Sekolah</label>
									  <div class="col-sm-9">
										<input type="text" id="kddept" name="pdk_nmsekolah[]"  class="form-control" style="text-transform:uppercase" maxlength="40" required>
									  </div>
								</div>
								<div class="form-group">
									  <label class="control-label col-sm-3">Kota/ Kab.</label>
									  <div class="col-sm-9">
										<input type="text" id="kddept" name="pdk_kotakab[]"  class="form-control" style="text-transform:uppercase" maxlength="30" required>
									  </div>
								</div>
								<div class="form-group">
									  <label class="control-label col-sm-3">Jurusan</label>
									  <div class="col-sm-9">
										<input type="text" id="kddept" name="pdk_jurusan[]"  class="form-control" style="text-transform:uppercase" maxlength="30" required>
									  </div>
								</div>
									
								</div>
								<div class="col-sm-6 ">
								<div class="form-group">
										<label class="control-label col-sm-3">Program Studi</label>	
										<div class="col-sm-8">    
											<input type="text" id="kddept" name="pdk_program_studi[]"  class="form-control" style="text-transform:uppercase" maxlength="30" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3">Tahun Masuk</label>	
										<div class="col-sm-8">    
											<input type="text" id="year" name="pdk_tahun_masuk[]" class="form-control year" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3">Tahun Lulus</label>	
										<div class="col-sm-8">    
											<input type="text" id="year" name="pdk_tahun_keluar[]" class="form-control year" required>
										</div>
									</div>
									<div class="form-group">
									  <label class="control-label col-sm-3">Nilai/ IPK.</label>
									  <div class="col-sm-8">
										<input type="text" name="pdk_nilai[]"  class="form-control" placeholder="0" required>
									  </div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-3">Keterangan</label>	
										<div class="col-sm-8">    
											<textarea type="text" name="pdk_keterangan[]"   style="text-transform:uppercase" class="form-control"></textarea>
										</div>
									</div>
								</div>
								</div>
					</div>
				  </div>
				  </td></tr>
				  </table>
				  
				  <!--/form-->
				  <button class="btn btn-primary prevBtn btn-sm pull-left" type="button">Back</button>
				  <button class="btn btn-primary nextBtn btn-sm pull-right" type="button">Next</button>
				  
				</div>
			  </div>
			</div>			
			<div class="row setup-content" id="step-3">
			  <div class="col-sm-12 ">
				<div class="col-sm-12">
				  <h3> Riwayat Pekerjaan</h3>
				  
				  <div class="col-sm-12 text-right">
				  <button type="button" class="btn btn-danger btn-sm" onClick="deleteRow('dataTablePekerjaan')">Hapus Riwayat</button>
				  <button type="button" class="btn btn-primary btn-sm" onClick="addRow('dataTablePekerjaan')">Tambah Riwayat</button>
				  </div>
				  <br /><br />
				  <!--form role="form" action="<?php //echo site_url('trans/wizard/test_insert'); ?>" method="post"-->
				  <table id="dataTablePekerjaan" class="box box-primary">
				  <tr><td>
				  <div class="row">
				  <div class="col-sm-12">
								<div class="box-header">									
								</div>
								<div class="box-body">
								<div class="col-sm-6 ">
							<div class="form-group">
								<label class="control-label col-sm-3">Nama Perusahaan</label>	
								<div class="col-sm-9">    
									<input type="text" id="kddept" name="pkj_nmperusahaan[]"  class="form-control" style="text-transform:uppercase" maxlength="50" required>
								</div>
							</div>		
							<div class="form-group">
								<label class="control-label col-sm-3">Bidang Usaha</label>	
								<div class="col-sm-9">    
									<input type="text" id="kddept" name="pkj_bidang_usaha[]"  class="form-control" style="text-transform:uppercase" maxlength="40" required>
								</div>
							</div>		
													
							<div class="form-group">
								<label class="control-label col-sm-3">Tanggal Masuk</label>	
								<div class="col-sm-9">    
									<input type="text" id="tgl" name="pkj_tahun_masuk[]" data-date-format="dd-mm-yyyy" class="form-control tgl" required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Tanggal Keluar</label>	
								<div class="col-sm-9">    
									<input type="text" id="tgl" name="pkj_tahun_keluar[]" data-date-format="dd-mm-yyyy" class="form-control tgl" required>
								</div>
							</div>
									
								</div>
								<div class="col-sm-6 ">
								<div class="form-group">	
								<label class="control-label col-sm-3">Bagian</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="pkj_bagian[]"  class="form-control" style="text-transform:uppercase" maxlength="40" >
								</div>
							</div>
							<div class="form-group">	
								<label class="control-label col-sm-3">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="pkj_jabatan[]"  class="form-control" style="text-transform:uppercase" maxlength="40" >
								</div>
							</div>
							<div class="form-group">	
								<label class="control-label col-sm-3">Nama Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="pkj_nmatasan[]"  class="form-control" style="text-transform:uppercase" maxlength="50" >
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Jabatan Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="pkj_jbtatasan[]"  class="form-control" style="text-transform:uppercase" maxlength="40" >
								</div>
							</div>														
							<div class="form-group">
								<label class="control-label col-sm-3">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="pkj_keterangan[]"   style="text-transform:uppercase" class="form-control"></textarea>
								</div>
							</div>
								</div>
								</div>
					</div>
				  </div>
				  </td></tr>
				  </table>
				  
				  <!--/form-->
				  <button class="btn btn-primary prevBtn btn-sm pull-left" type="button">Back</button>
				  <button class="btn btn-primary nextBtn btn-sm pull-right" type="button">Next</button>
				  
				</div>
			  </div>
			</div>	
			<div class="row setup-content" id="step-4">
			  <div class="col-sm-12 ">
				<div class="col-sm-12">
				  <h3> Lampiran Lampiran</h3>
				  
				  <!--div class="col-sm-12 text-right">
				  <button type="button" class="btn btn-danger btn-sm" onClick="deleteRow('dataTableLampiran')">Hapus Lampiran</button>
				  <button type="button" class="btn btn-primary btn-sm" onClick="addRow('dataTableLampiran')">Tambah Lampiran</button>
				  </div-->
				  <br /><br />
				  <!--form role="form" enctype="multipart/form-data" action="<?php //echo site_url('recruitment/calonkaryawan/add_foto');?>" method="post"-->
				<div class="box box-primary">
				  <div class="row">
				  <div class="col-sm-12">
						<div class="box-header">									
						</div>
						<div class="box-body">
							<div class="col-sm-6 ">
								<div class="form-group">																					
									<p align="center"><input align="center" type="file" id="userfoto" name="gambar" value="<?php //echo $dtl['image'];?>"> </p>
								</div>						
							</div>
							<div class="col-sm-6 ">
								<table id="dataTableLampiran" style="width:100%">
								<tr><td>
									<div class="form-group">	
										<label class="control-label col-sm-3">Berkas</label>	
										<div class="col-sm-8">
											<input type="file" class="form-control" name="userFiles[]" multiple/>
										</div>
									</div>
								</tr></td>
								</table>
							</div>
						</div>
					</div>
				  </div>
				</div>
				
				  <button class="btn btn-primary prevBtn btn-sm pull-left" type="button">Back</button>
				  <button class="btn btn-success nextBtn btn-sm pull-right" type="submit">Finish</button>
				  	
			  </div>
			</div>	
          </div>  
		</div>
		</form>
<script>

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
			
<!--- DATA KARYAWAN RESIGN -->	
<!--import department-->
