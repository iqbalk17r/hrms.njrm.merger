<?php 
/*
	@author : hanif_anak_metal \m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example4").dataTable();
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("[data-mask]").inputmask();	                           
				$("#dateinput").datepicker();                               
            });	
$(function() {
			$('#colorselector').change(function(){
            $('.colors').hide();
            $('#' + $(this).val()).show();
			});
			
    });			
</script>

<legend><?php echo $title;?></legend>
<?php echo $message;?>

</br>
<form action="<?php echo site_url('trans/riwayat_keluarga/edit_riwayat_keluarga')?>" method="post">
<div class="row">
	<div class="col-sm-4">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo $nik; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>				
							<div class="form-group">
								<label class="col-sm-4">Status Di Keluarga</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdkeluarga" id="kodekomponen">
									  <?php foreach($list_keluarga as $listkan){?>
									  <option  <?php if (trim($listkan->kdkeluarga)==trim($list_rk['kdkeluarga'])){ echo 'selected';}?> value="<?php echo trim($listkan->kdkeluarga);?>" ><?php echo $listkan->nmkeluarga;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Keluarga</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['nama'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jenis Kelamin</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kelamin" id="kotakab">
									  
										<option  <?php if ('PRIA'==trim($list_rk['kelamin'])) { echo 'selected';}?> value="PRIA" >PRIA</option>	
										<option  <?php if ('WANITA'==trim($list_rk['kelamin'])) { echo 'selected';}?> value="WANITA" >WANITA</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">	
								<label class="col-sm-4">Tempat Lahir Negara</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodenegara" id="negara">
									  <?php foreach($list_negara as $listkan){?>
									  <option <?php if (trim($listkan->kodenegara)==trim($list_rk['kodenegara'])){ echo 'selected';}?> value="<?php echo trim($listkan->kodenegara);?>" ><?php echo $listkan->namanegara;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">		
								<label class="col-sm-4">Tempat Lahir Provinsi</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodeprov" id="prov">
									  <?php foreach($list_prov as $listkan){?>
									  <option  <?php if (trim($listkan->kodeprov)==trim($list_rk['kodeprov'])){ echo 'selected';}?> value="<?php echo trim($listkan->kodeprov);?>" ><?php echo $listkan->namaprov;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tempat Lahir Kota/Kab</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodekotakab" id="kotakab">
									  <?php foreach($list_kotakab as $listkan){?>
										<option  <?php if (trim($listkan->kodekotakab)==trim($list_rk['kodekotakab'])){ echo 'selected';}?> value="<?php echo trim($listkan->kodekotakab);?>" ><?php echo $listkan->namakotakab;?></option>	
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Lahir</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput" name="tgl_lahir"  value="<?php echo $list_rk['tgl_lahir1'];?>" data-date-format="dd-mm-yyyy" class="form-control">
								</div>
							</div>
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	
			<div class="col-sm-4">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Jenjang Pendidikan</label>	
								<div class="col-sm-8">
									<select class="form-control input-sm" name="kdjenjang_pendidikan" id="kode_bpjs">
									  <?php foreach($list_jenjang_pendidikan as $listkan){?>
									  <option   <?php if (trim($listkan->kdjenjang_pendidikan)==trim($list_rk['kdjenjang_pendidikan'])){ echo 'selected';}?> value="<?php echo trim($listkan->kdjenjang_pendidikan);?>" ><?php echo $listkan->nmjenjang_pendidikan;?></option>						  
									  <?php }?>
									</select>									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pekerjaan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="pekerjaan"  value="<?php echo $list_rk['pekerjaan'];?>" class="form-control" style="text-transform:uppercase" maxlength="30" >
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Status Hidup</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="status_hidup" id="kotakab">
									  
										<option  <?php if ('T'==trim($list_rk['status_hidup'])) { echo 'selected';}?> value="T" >MASIH HIDUP</option>	
										<option  <?php if ('F'==trim($list_rk['status_hidup'])) { echo 'selected';}?> value="F" >MENINGGAL</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Status Tanggungan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="status_tanggungan" id="colorselector">
									  
										<option <?php if ('T'==trim($list_rk['status_tanggungan'])) { echo 'selected';}?> value="T" >YA</option>	
										<option  <?php if ('F'==trim($list_rk['status_tanggungan'])) { echo 'selected';}?> value="F" >TIDAK</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">No. NPWP</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="no_npwp" value="<?php echo $list_rk['no_npwp'];?>" class="form-control" data-inputmask='"mask": "99.999.999.9-999.999"' data-mask="" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai Berlaku Npwp</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput1" name="npwp_tgl" value="<?php echo $list_rk['npwp_tgl1'];?>"  data-date-format="dd-mm-yyyy" class="form-control">
								</div>
							</div>	
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
			<div class="col-sm-4">
			<div id="T" class="colors" <?php if ($list_rk['status_tanggungan']=='F') { echo 'style="display:none;"';} ?>>
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Kode Bpjs</label>	
								<div class="col-sm-8">
									<select class="form-control input-sm" name="kode_bpjs" id="kode_bpjs">
									  <?php foreach($list_bpjs as $listkan){?>
									  <option  value="<?php echo trim($listkan->kode_bpjs).'|'.$listkan->nama_bpjs;?>" <?php if (trim($listkan->kode_bpjs)==trim($list_rk['kode_bpjs'])){ echo 'selected';}?>><?php echo $listkan->kode_bpjs.'|'.$listkan->nama_bpjs;?></option>						  
									  <?php }?>
									</select>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Kode Komponen Bpjs</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodekomponen" id="kodekomponen">
									  <?php foreach($list_bpjskomponen as $listkan){?>
									  <option <?php if (trim($listkan->kodekomponen)==trim($list_rk['kodekomponen'])){ echo 'selected';}?> value="<?php echo trim($listkan->kodekomponen).'|'.$listkan->namakomponen;?>" ><?php echo $listkan->kodekomponen.'|'.$listkan->namakomponen;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Kode Faskes Utama</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodefaskes" id="kodefaskes">
									  <?php foreach($list_faskes as $listkan){?>
									  <option  <?php if (trim($listkan->kodefaskes)==trim($list_rk['kodefaskes'])){ echo 'selected';}?> value="<?php echo trim($listkan->kodefaskes).'|'.$listkan->namafaskes;?>" ><?php echo $listkan->kodefaskes.'|'.$listkan->namafaskes;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Faskes Tambahan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodefaskes2" id="kodefaskes2">
									  <?php foreach($list_faskes as $listkan){?>
									  <option  <?php if (trim($listkan->kodefaskes)==trim($list_rk['kodefaskes2'])){ echo 'selected';}?> value="<?php echo trim($listkan->kodefaskes).'|'.$listkan->namafaskes;?>" ><?php echo $listkan->kodefaskes.'|'.$listkan->namafaskes;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Id Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="id_bpjs" name="id_bpjs"  value="<?php echo trim($list_rk['id_bpjs']);?>" class="form-control" style="text-transform:uppercase" 
									 maxlength="15" <?php if ($list_rk['status_tanggungan']=='T') { echo 'required';} ?>>
									<input type="hidden" id="kddept" name="no_urut"  value="<?php echo $list_rk['no_urut'];?>" class="form-control" style="text-transform:uppercase" readonly>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Kelas</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kelas" id="kelas">
									  <?php foreach($list_kelas as $listkan){?>
									  <option <?php if (trim($listkan->kdtrx)==trim($list_rk['kelas'])) {echo 'selected';}?> value="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->uraian;?></option>						  
									  <?php }?>
									</select>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai Berlaku Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput2" value="<?php echo $list_rk['tgl_berlaku1'];?>" name="tgl_berlaku"   data-date-format="dd-mm-yyyy" class="form-control">
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo $list_rk['keterangan'];?></textarea>
								</div>
							</div>		
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>	
			</div>	
</div>
<div class="row">
	<div class="col-sm-6">		
		<a href="<?php echo site_url("trans/riwayat_keluarga/index/$nik");?>" class="btn btn-primary" style="margin:10px">Kembali</a>
		<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

