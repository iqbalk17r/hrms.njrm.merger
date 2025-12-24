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
					<a href="<?php echo site_url("trans/riwayat_rekam_medis/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
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
							<th>Nama Rekam Medis</th>
							<th>Tipe Rekam Medis</th>
							<th>Level</th>
							<th>Dokter Periksa</th>
							<th>Tempat Periksa</th>
							<th>Tanggal Periksa</th>											
							<th>Keterangan</th>											
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_riwayat_rekam_medis as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><?php echo $lu->nmrekam_medis;?></td>
							<td><?php echo $lu->uraian;?></td>
							<td><?php echo $lu->uraian2;?></td>
							<td><?php echo $lu->dokter_periksa;?></td>
							<td><?php echo $lu->tempat_periksa;?></td>
							<td><?php echo $lu->tgl_tes1;?></td>
							<td><?php echo $lu->keterangan;?></td>
							
							<td>
								<!--<a href='<?php  $nik=trim($lu->nik); echo site_url("trans/riwayat_rekam_medis/detail/$nik/$lu->no_urut")?>' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>-->
								<?php if($akses['aksesupdate']=='t') { ?>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->no_urut);?>" href='#' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<?php } ?>
								<?php if($akses['aksesdelete']=='t') { ?>
								<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/riwayat_rekam_medis/hps_riwayat_rekam_medis/$nik/$lu->no_urut")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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
        <h4 class="modal-title" id="myModalLabel">Input Riwayat Rekam Medis <?php echo $nik.'|'.$list_lk['nmlengkap'];?></h4>
      </div>
	  <form action="<?php echo site_url('trans/riwayat_rekam_medis/add_riwayat_rekam_medis')?>" method="post">
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
							<script type="text/javascript" charset="utf-8">
							  $(function() {	
								$("#kdrekam_medis").chained("#kdtipe");											
							  });
							</script>
							<div class="form-group">
								<label class="col-sm-4">Tipe Rekam Medis</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdtipe" id="kdtipe">
									  <?php foreach($list_tipe_medis as $listkan){?>
									  <option value="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->uraian;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Nama Rekam Medis</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdrekam_medis" id="kdrekam_medis">
									  <?php foreach($list_rekam_medis as $listkan){?>
									  <option value="<?php echo trim($listkan->kdrekam_medis);?>" class="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->nmrekam_medis;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
													
							<div class="form-group">
								<label class="col-sm-4">level Rekam Medis</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdlevel" id="kdrekam_medis">
									  <?php foreach($list_level_medis as $listkan){?>
									  <option value="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->uraian;?></option>						  
									  <?php }?>
									</select>
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
								<label class="col-sm-4">Dokter Periksa</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="dokter_periksa"  class="form-control" style="text-transform:uppercase" maxlength="40" >
								</div>
							</div>
							<div class="form-group">	
								<label class="col-sm-4">Tempat Periksa</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="tempat_periksa"  class="form-control" style="text-transform:uppercase" maxlength="50" >
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Tanggal Periksa</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput" name="tgl_tes"   data-date-format="dd-mm-yyyy" class="form-control" required>
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
<?php foreach ($list_riwayat_rekam_medis as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->no_urut); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Riwayat Rekam Medis</h4>
      </div>
	  <form action="<?php echo site_url('trans/riwayat_rekam_medis/edit_riwayat_rekam_medis')?>" method="post">
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
							<script type="text/javascript" charset="utf-8">
							  $(function() {						
								$("#kdrekam_medis1<?php echo trim($lb->no_urut);?>").chained("#kdtipe1<?php echo trim($lb->no_urut);?>");						
							  });
							</script>
							<script type="text/javascript">
								$(function() {                         
									$("#dateinput<?php echo trim($lb->no_urut);?>").datepicker();                               
								});
							</script>
							<div class="form-group">
								<label class="col-sm-4">Tipe Rekam Medis</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdtipe" id="kdtipe1<?php echo trim($lb->no_urut);?>">
									  <?php foreach($list_tipe_medis as $listkan){?>
									  <option <?php if (trim($lb->kdtipe)==trim($listkan->kdtrx)){echo 'selected';}?> value="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->uraian;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Nama Rekam Medis</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdrekam_medis" id="kdrekam_medis1<?php echo trim($lb->no_urut);?>">
									  <?php foreach($list_rekam_medis as $listkan){?>
									  <option <?php if (trim($listkan->kdrekam_medis)==trim($lb->kdrekam_medis)){echo 'selected';}?> value="<?php echo trim($listkan->kdrekam_medis);?>" class="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->nmrekam_medis;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
													
							<div class="form-group">
								<label class="col-sm-4">level Rekam Medis</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdlevel" id="kdrekam_medis">
									  <?php foreach($list_level_medis as $listkan){?>
									  <option <?php if (trim($lb->kdlevel)==trim($listkan->kdtrx)){echo 'selected';}?> value="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->uraian;?></option>						  
									  <?php }?>
									</select>
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
								<label class="col-sm-4">Dokter Periksa</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="dokter_periksa" value="<?php echo trim($lb->dokter_periksa); ?>" class="form-control" style="text-transform:uppercase" maxlength="50" >
								</div>
							</div>			
							<div class="form-group">	
								<label class="col-sm-4">Tempat Periksa</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="tempat_periksa" value="<?php echo trim($lb->tempat_periksa); ?>" class="form-control" style="text-transform:uppercase" maxlength="50" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Periksa</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput<?php echo trim($lb->no_urut);?>" name="tgl_tes"  value="<?php echo trim($lb->tgl_tes1); ?>" data-date-format="dd-mm-yyyy" class="form-control" required>
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
