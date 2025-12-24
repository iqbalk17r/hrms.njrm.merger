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
				$("#dateinput3").datepicker(); 
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
					<a href="<?php echo site_url("trans/riwayat_pendidikan_nf/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
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
							<th>Nama Keahlian</th>
							<th>Nama Kursus</th>
							<th>Nama Institusi</th>
							<th>Tanggal Mulai</th>
							<th>Tanggal Selesai</th>											
							<th>Keterangan</th>											
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_riwayat_pendidikan_nf as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><?php echo $lu->nmkeahlian;?></td>
							<td><?php echo $lu->nmkursus;?></td>
							<td><?php echo $lu->nminstitusi;?></td>
							<td><?php echo $lu->tahun_masuk1;?></td>
							<td><?php echo $lu->tahun_keluar1;?></td>
							<td><?php echo $lu->keterangan;?></td>
							
							<td>
								<!--<a href='<?php  $nik=trim($lu->nik); echo site_url("trans/riwayat_pendidikan_nf/detail/$nik/$lu->no_urut")?>' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>-->
								<?php if($akses['aksesupdate']=='t') { ?>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->no_urut);?>" href='#' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<?php } ?>
								<?php if($akses['aksesdelete']=='t') { ?>
								<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/riwayat_pendidikan_nf/hps_riwayat_pendidikan_nf/$nik/$lu->no_urut")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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


<!--INPUT PELATIHAN-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Riwayat keahlian Non Formal <?php echo $nik.'|'.$list_lk['nmlengkap'];?></h4>
      </div>
	  <form action="<?php echo site_url('trans/riwayat_pendidikan_nf/add_riwayat_pendidikan_nf')?>" method="post">
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
								<label class="col-sm-4">Bidang Keahlian</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdkeahlian" id="kdkeahlian">
									  <?php foreach($list_keahlian as $listkan){?>
									  <option value="<?php echo trim($listkan->kdkeahlian);?>" ><?php echo $listkan->nmkeahlian;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Kursus</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nmkursus"  class="form-control" style="text-transform:uppercase" maxlength="40" required>
								</div>
							</div>
							
							<div class="form-group">	
								<label class="col-sm-4">Nama Institusi</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nminstitusi"  class="form-control" style="text-transform:uppercase" maxlength="30" required>
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
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput" name="tahun_masuk" data-date-format="dd-mm-yyyy"  class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput1" name="tahun_keluar" data-date-format="dd-mm-yyyy"  class="form-control" required>
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



<!--Modal untuk Edit PELATIHAN---->
<?php foreach ($list_riwayat_pendidikan_nf as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->no_urut); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Riwayat Pendidikan Non Formal</h4>
      </div>
	  <form action="<?php echo site_url('trans/riwayat_pendidikan_nf/edit_riwayat_pendidikan_nf')?>" method="post">
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
								<label class="col-sm-4">Bidang Keahlian</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdkeahlian" id="kdkeahlian">
									  <?php foreach($list_keahlian as $listkan){?>
									  <option <?php if (trim($lb->kdkeahlian)==trim($listkan->kdkeahlian)) { echo 'selected';}?> value="<?php echo trim($listkan->kdkeahlian);?>" ><?php echo $listkan->nmkeahlian;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Kursus</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nmkursus" value="<?php echo trim($lb->nmkursus); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" required>
								</div>
							</div>
							
							<div class="form-group">	
								<label class="col-sm-4">Nama Institusi</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nminstitusi"  value="<?php echo trim($lb->nminstitusi); ?>" class="form-control" style="text-transform:uppercase" maxlength="30" required>
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
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput2" name="tahun_masuk"  value="<?php echo trim($lb->tahun_masuk1); ?>" data-date-format="dd-mm-yyyy" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput3" name="tahun_keluar" value="<?php echo trim($lb->tahun_keluar1); ?>" data-date-format="dd-mm-yyyy" class="form-control" required>
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
