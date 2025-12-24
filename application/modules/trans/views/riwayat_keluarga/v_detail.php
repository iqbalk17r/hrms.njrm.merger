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
</script>

<legend><?php echo $title;?></legend>
<?php echo $message;?>

</br>
<form action="<?php echo site_url("trans/riwayat_keluarga/index/$nik")?>" method="post">
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
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['nmkeluarga'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Keluarga</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['nama'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-4">Tempat Lahir Negara</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['namanegara'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">		
								<label class="col-sm-4">Tempat Lahir Provinsi</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['namaprov'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tempat Lahir Kota/Kab</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['namakotakab'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Lahir</label>	
								<div class="col-sm-8">    
									<input type="text" id="1" name="tgl_lahir"  value="<?php echo $list_rk['tgl_lahir'];?>" data-date-format="dd-mm-yyyy" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jenis Kelamin</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['kelamin'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['nmjenjang_pendidikan'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pekerjaan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="pekerjaan"  value="<?php echo $list_rk['pekerjaan'];?>" class="form-control" style="text-transform:uppercase" maxlength="30" readonly>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Status Hidup</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['status_hidup1'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Status Tanggungan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['status_tanggungan1'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">No. NPWP</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="no_npwp" value="<?php echo $list_rk['no_npwp'];?>" class="form-control" data-inputmask='"mask": "99.999.999.9-999.999"' data-mask="" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai Berlaku Npwp</label>	
								<div class="col-sm-8">    
									<input type="text" id="1" name="npwp_tgl" value="<?php echo $list_rk['npwp_tgl'];?>"  data-date-format="dd-mm-yyyy" class="form-control" readonly>
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
								<label class="col-sm-4">Kode Bpjs</label>	
								<div class="col-sm-8">
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['nama_bpjs'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Kode Komponen Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['namakomponen'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Kode Faskes Utama</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['namafaskes'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Faskes Tambahan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['namafaskes2'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Id Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="id_bpjs"  value="<?php echo $list_rk['id_bpjs'];?>" class="form-control" style="text-transform:uppercase" maxlength="6" readonly>
									<input type="hidden" id="kddept" name="no_urut"  value="<?php echo $list_rk['no_urut'];?>" class="form-control" style="text-transform:uppercase" readonly>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Kelas</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  value="<?php echo $list_rk['uraian'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai Berlaku Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="1" value="<?php echo $list_rk['tgl_berlaku'];?>" name="tgl_berlaku"   data-date-format="dd-mm-yyyy" class="form-control" readonly>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" readonly><?php echo $list_rk['keterangan'];?></textarea>
								</div>
							</div>		
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>					
</div>
<div class="row">
	<div class="col-sm-6">		
		<a href="<?php echo site_url("trans/riwayat_keluarga/index/$nik");?>" class="btn btn-primary" style="margin:10px">Kembali</a>

	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

