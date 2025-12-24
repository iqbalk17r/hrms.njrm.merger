<?php 
/*
	@author : junis 10-12-2012\m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("[data-mask]").inputmask();	
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
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">	
					<?php if($akses['aksesinput']=='t') { ?>
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
					<?php } ?>
					<a href="<?php echo site_url("trans/riwayat_keluarga/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				</div>
				<div class="col-sm-6">
				<h5>NIK : <?php echo $nik;?><br>
				<h5>Nama : <?php echo $list_lk['nmlengkap'];?>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
							<th>Nama Keluarga</th>
							<th>Jenis Kelamin</th>
							<th>Status Di Keluarga</th>
							<th>Tempat Lahir</th>
							<th>Tanggal Lahir</th>
							<th>Jenjang Pendidikan</th>
							<th>Status Tanggungan</th>																
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_riwayat_keluarga as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><?php echo $lu->nama;?></td>
							<td><?php echo $lu->kelamin;?></td>
							<td><?php echo $lu->nmkeluarga;?></td>
							<td><?php echo $lu->namakotakab;?></td>
							<td><?php echo $lu->tgl_lahir;?></td>
							<td><?php echo $lu->nmjenjang_pendidikan;?></td>
							<td><?php echo $lu->status_tanggungan1;?></td>
							
							
							<td>
								<a href='<?php  $nik=trim($lu->nik); echo site_url("trans/riwayat_keluarga/detail/$nik/$lu->no_urut")?>' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>
							<?php if($akses['aksesupdate']=='t') { ?>	
								<a href='<?php  $nik=trim($lu->nik); echo site_url("trans/riwayat_keluarga/edit/$nik/$lu->no_urut")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
							<?php } ?>	
							<?php if($akses['aksesdelete']=='t') { ?>
								<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/riwayat_keluarga/hps_riwayat_keluarga/$nik/$lu->no_urut")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>
							<?php } ?>		
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


<!--Modal untuk Input Nama Bpjs-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Riwayat Keluarga <?php echo $nik.'|'.$list_lk['nmlengkap'];?></h4>
      </div>
	  <form action="<?php echo site_url('trans/riwayat_keluarga/add_riwayat_keluarga')?>" method="post">
      <div class="modal-body">										
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
									<select class="form-control input-sm" name="kdkeluarga" id="kdkeluarga">
									  <?php foreach($list_keluarga as $listkan){?>
									  <option value="<?php echo trim($listkan->kdkeluarga);?>" ><?php echo $listkan->nmkeluarga;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Keluarga</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nama"  class="form-control" style="text-transform:uppercase" maxlength="40" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jenis Kelamin</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kelamin" id="kotakab">
									  
										<option value="PRIA" >PRIA</option>	
										<option value="WANITA" >WANITA</option>
									</select>
								</div>
							</div>
							<script type="text/javascript" charset="utf-8">
							  $(function() {	
								$("#kodeprov").chained("#kodenegara");		
								$("#kodekotakab").chained("#kodeprov");	
								$("#kodekomponen").chained("#kode_bpjs");					
							  });
							</script>
							<div class="form-group">	
								<label class="col-sm-4">Tempat Lahir Negara</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodenegara" id="kodenegara">
									  <?php foreach($list_negara as $listkan){?>
									  <option value="<?php echo trim($listkan->kodenegara);?>" ><?php echo $listkan->namanegara;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">		
								<label class="col-sm-4">Tempat Lahir Provinsi</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodeprov" id="kodeprov">
									  <?php foreach($list_prov as $listkan){?>
									  <option value="<?php echo trim($listkan->kodeprov);?>" class="<?php echo trim($listkan->kodenegara);?>"><?php echo $listkan->namaprov;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tempat Lahir Kota/Kab</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodekotakab" id="kodekotakab">
									  <?php foreach($list_kotakab as $listkan){?>
										<option value="<?php echo trim($listkan->kodekotakab);?>" class="<?php echo trim($listkan->kodeprov);?>" ><?php echo $listkan->namakotakab;?></option>	
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Lahir</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput" name="tgl_lahir"   data-date-format="dd-mm-yyyy" class="form-control" required>
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
									<select class="form-control input-sm" name="kdjenjang_pendidikan" id="kdjenjang_pendidikan">
									  <?php foreach($list_jenjang_pendidikan as $listkan){?>
									  <option value="<?php echo trim($listkan->kdjenjang_pendidikan);?>" ><?php echo $listkan->nmjenjang_pendidikan;?></option>						  
									  <?php }?>
									</select>									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pekerjaan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="pekerjaan"  class="form-control" style="text-transform:uppercase" maxlength="30" >
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Status Hidup</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="status_hidup" id="kotakab">
									  
										<option value="T" >MASIH HIDUP</option>	
										<option value="F" >MENINGGAL</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Status Tanggungan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="status_tanggungan" id="colorselector">
									  
										<option value="F" >NO</option>
										<option value="T" >YES</option>	
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">No. NPWP</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="no_npwp"  class="form-control" data-inputmask='"mask": "99.999.999.9-999.999"' data-mask=""  >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai Berlaku Npwp</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput1" name="npwp_tgl"   data-date-format="dd-mm-yyyy" class="form-control" >
								</div>
							</div>	
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
			<div class="col-sm-4">
			<div id="T" class="colors" style="display:none;">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							
							<div  class="form-group">
								<label class="col-sm-4">Kode Bpjs</label>	
								<div class="col-sm-8">
									<select class="form-control input-sm" name="kode_bpjs" id="kode_bpjs">
									  <?php foreach($list_bpjs as $listkan){?>
									  <option value="<?php echo trim($listkan->kode_bpjs)?>" ><?php echo $listkan->kode_bpjs.'|'.$listkan->nama_bpjs;?></option>						  
									  <?php }?>
									</select>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Kode Komponen Bpjs</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodekomponen" id="kodekomponen">
									  <?php foreach($list_bpjskomponen as $listkan){?>
									  <option value="<?php echo trim($listkan->kodekomponen);?>" class="<?php echo trim($listkan->kode_bpjs);?>"><?php echo $listkan->kodekomponen.'|'.$listkan->namakomponen;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Faskes Utama</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodefaskes" id="kodefaskes">
									  <?php foreach($list_faskes as $listkan){?>
									  <option value="<?php echo trim($listkan->kodefaskes);?>" ><?php echo $listkan->kodefaskes.'|'.$listkan->namafaskes;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Faskes Tambahan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodefaskes2" id="kodefaskes2">
									  <?php foreach($list_faskes as $listkan){?>
									  <option value="<?php echo trim($listkan->kodefaskes);?>" ><?php echo $listkan->kodefaskes.'|'.$listkan->namafaskes;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Id Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="id_bpjs"  class="form-control" style="text-transform:uppercase" maxlength="15">
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Kelas</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kelas" id="kelas">
									  <?php foreach($list_kelas as $listkan){?>
									  <option value="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->uraian;?></option>						  
									  <?php }?>
									</select>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai Berlaku Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput2" name="tgl_berlaku"   data-date-format="dd-mm-yyyy" class="form-control" >
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
								</div>
							</div>		
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
			</div>		
		</div><!--row-->
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>




