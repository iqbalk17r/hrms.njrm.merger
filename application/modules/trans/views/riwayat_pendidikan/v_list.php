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
				
				<a href="<?php echo site_url("trans/riwayat_pendidikan/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
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
							<th>Nama Pendidikan</th>
							<th>Nama Sekolah</th>
							<th>Kota/Kab</th>
							<th>Jurusan</th>
							<th>Program Studi</th>
							<th>Tahun Masuk</th>
							<th>Tahun Keluar</th>											
							<th>Keterangan</th>											
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_riwayat_pendidikan as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><?php echo $lu->nmpendidikan;?></td>
							<td><?php echo $lu->nmsekolah;?></td>
							<td><?php echo $lu->kotakab;?></td>
							<td><?php echo $lu->jurusan;?></td>
							<td><?php echo $lu->program_studi;?></td>
							<td><?php echo $lu->tahun_masuk;?></td>
							<td><?php echo $lu->tahun_keluar;?></td>
							<td><?php echo $lu->keterangan;?></td>
							
							<td>
								<!--<a href='<?php  $nik=trim($lu->nik); echo site_url("trans/riwayat_pendidikan/detail/$nik/$lu->no_urut")?>' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>-->
								<?php if($akses['aksesupdate']=='t') { ?>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->no_urut);?>" href='#' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<?php } ?>
								<?php if($akses['aksesdelete']=='t') { ?>
								<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/riwayat_pendidikan/hps_riwayat_pendidikan/$nik/$lu->no_urut")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Riwayat Pendidikan Formal <?php echo $nik.'|'.$list_lk['nmlengkap'];?></h4>
      </div>
	  <form action="<?php echo site_url('trans/riwayat_pendidikan/add_riwayat_pendidikan')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
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
								<label class="col-sm-4">Nama Pendidikan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdpendidikan" id="kdpendidikan">
									  <?php foreach($list_pendidikan as $listkan){?>
									  <option value="<?php echo trim($listkan->kdpendidikan);?>" ><?php echo $listkan->nmpendidikan;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Sekolah</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nmsekolah"  class="form-control" style="text-transform:uppercase" maxlength="40" >
								</div>
							</div>
							
							<div class="form-group">	
								<label class="col-sm-4">Kota/Kab</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="kotakab"  class="form-control" style="text-transform:uppercase" maxlength="30" >
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-4">Jurusan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="jurusan"  class="form-control" style="text-transform:uppercase" maxlength="30" >
								</div>
							</div>
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">	
								<label class="col-sm-4">Program Studi</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="program_studi"  class="form-control" style="text-transform:uppercase" maxlength="30" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tahun Masuk</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="tahun_masuk"  data-inputmask='"mask": "9999"' data-mask="" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tahun keluar</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="tahun_keluar"  data-inputmask='"mask": "9999"' data-mask="" class="form-control">
								</div>
							</div>								
							<div class="form-group">
								<label class="col-sm-4">Nilai/IPK</label>	
								<div class="col-sm-8">    
									<input type="number" step="0.01" id="kddept" name="nilai"  class="form-control" placeholder="0" >
								</div>
							</div>								
							
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>					
							
						
				
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>



<!--Modal untuk Edit Bpjs Karyawan-->
<?php foreach ($list_riwayat_pendidikan as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->no_urut); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Riwayat Pendidikan Formal</h4>
      </div>
	  <form action="<?php echo site_url('trans/riwayat_pendidikan/edit_riwayat_pendidikan')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
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
								<label class="col-sm-4">Nama Pendidikan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdpendidikan"  value="<?php echo $lb->nmpendidikan; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Sekolah</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nmsekolah" value="<?php echo trim($lb->nmsekolah); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" >
								</div>
							</div>
							
							<div class="form-group">	
								<label class="col-sm-4">Kota/Kab</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="kotakab"  class="form-control" value="<?php echo trim($lb->kotakab); ?>" style="text-transform:uppercase" maxlength="30" >
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-4">Jurusan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="jurusan"  value="<?php echo trim($lb->jurusan); ?>" class="form-control" style="text-transform:uppercase" maxlength="30" >
								</div>
							</div>
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">	
								<label class="col-sm-4">Program Studi</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="program_studi" value="<?php echo trim($lb->program_studi); ?>" class="form-control" style="text-transform:uppercase" maxlength="30" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tahun Masuk</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="tahun_masuk"  value="<?php echo trim($lb->tahun_masuk); ?>" data-inputmask='"mask": "9999"' data-mask="" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tahun keluar</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="tahun_keluar" value="<?php echo trim($lb->tahun_keluar); ?>" data-inputmask='"mask": "9999"' data-mask="" class="form-control" >
								</div>
							</div>								
							<div class="form-group">
								<label class="col-sm-4">Nilai/IPK</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nilai" value="<?php echo $lb->nilai; ?>" class="form-control" >
								</div>
							</div>								
							
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo trim($lb->keterangan); ?></textarea>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
									<input type="hidden" id="inputby" name="no_urut"  value="<?php echo trim($lb->no_urut);?>" class="form-control" readonly>
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<?php } ?>
