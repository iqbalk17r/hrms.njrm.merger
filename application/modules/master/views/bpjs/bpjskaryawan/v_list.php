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
            });
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Bpjs</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode Bpjs</th>
							<th>Kode Komponen Bpjs</th>
							<th>Kode Faskes Utama</th>
							<th>Kode Faskes Tambahan</th>
							<th>NIK</th>
							<th>Nama Karyawan</th>
							<th>Id Bpjs</th>
							<th>Kelas</th>
							<th>Tanggal Berlaku</th>
							<th>Keterangan</th>																	
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_bpjskaryawan as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->kode_bpjs;?></td>
							<td><?php echo $lu->namakomponen;?></td>
							<td><?php echo $lu->namafaskes;?></td>
							<td><?php echo $lu->namafaskes2;?></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->id_bpjs;?></td>
							<td><?php echo $lu->kelas;?></td>
							<td><?php echo $lu->tgl_berlaku;?></td>
							<td><?php echo $lu->keterangan;?></td>
							<td>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->id_bpjs);?>" href='#' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a  href="<?php echo site_url("master/bpjskaryawan/hps_bpjs/$lu->id_bpjs")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>
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
        <h4 class="modal-title" id="myModalLabel">Input Bpjs</h4>
      </div>
	  <form action="<?php echo site_url('master/bpjskaryawan/add_bpjs')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Kode Bpjs</label>	
								<div class="col-sm-8">
									<select class="form-control input-sm" name="kode_bpjs" id="kode_bpjs">
									  <?php foreach($list_bpjs as $listkan){?>
									  <option value="<?php echo trim($listkan->kode_bpjs).'|'.$listkan->nama_bpjs;?>" ><?php echo $listkan->kode_bpjs.'|'.$listkan->nama_bpjs;?></option>						  
									  <?php }?>
									</select>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Kode Komponen Bpjs</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodekomponen" id="kodekomponen">
									  <?php foreach($list_bpjskomponen as $listkan){?>
									  <option value="<?php echo trim($listkan->kodekomponen).'|'.$listkan->namakomponen;?>" ><?php echo $listkan->kodekomponen.'|'.$listkan->namakomponen;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Kode Faskes Utama</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodefaskes" id="kodefaskes">
									  <?php foreach($list_faskes as $listkan){?>
									  <option value="<?php echo trim($listkan->kodefaskes).'|'.$listkan->namafaskes;?>" ><?php echo $listkan->kodefaskes.'|'.$listkan->namafaskes;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Faskes Tambahan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodefaskes2" id="kodefaskes2">
									  <?php foreach($list_faskes as $listkan){?>
									  <option value="<?php echo trim($listkan->kodefaskes).'|'.$listkan->namafaskes;?>" ><?php echo $listkan->kodefaskes.'|'.$listkan->namafaskes;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="nik" id="nik">
									  <?php foreach($list_karyawan as $listkan){?>
									  <option value="<?php echo trim($listkan->nik).'|'.$listkan->nmlengkap;?>" ><?php echo $listkan->nik.'|'.$listkan->nmlengkap;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Id Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="id_bpjs"  class="form-control" style="text-transform:uppercase" maxlength="6" required>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Kelas</label>	
								<div class="col-sm-8">    
									<input type="text" id="nmdept" name="kelas"  maxlength="20" style="text-transform:uppercase" class="form-control">
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Expired</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput" name="tgl_berlaku"   data-date-format="dd-mm-yyyy" class="form-control">
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

<!--Modal untuk Edit Bpjs Karyawan-->
<?php foreach ($list_bpjskaryawan as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->id_bpjs); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Bpjs</h4>
      </div>
	  <form action="<?php echo site_url('master/bpjskaryawan/edit_bpjs')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Kode Bpjs</label>	
								<div class="col-sm-8">
									<select class="form-control input-sm" name="kode_bpjs" id="kode_bpjs">
									  <?php foreach($list_bpjs as $listkan){?>
									  <option <?php if (trim($lb->kode_bpjs)==trim($listkan->kode_bpjs)) { echo 'selected';} ?> value="<?php echo trim($listkan->kode_bpjs).'|'.$listkan->nama_bpjs;?>" ><?php echo $listkan->kode_bpjs.'|'.$listkan->nama_bpjs;?></option>						  
									  <?php }?>
									</select>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Kode Komponen Bpjs</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodekomponen" id="kodekomponen">
									  <?php foreach($list_bpjskomponen as $listkan){?>
									  <option <?php if (trim($lb->kodekomponen)==trim($listkan->kodekomponen)) { echo 'selected';} ?> value="<?php echo trim($listkan->kodekomponen).'|'.$listkan->namakomponen;?>" ><?php echo $listkan->kodekomponen.'|'.$listkan->namakomponen;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Kode Faskes Utama</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodefaskes" id="kodefaskes">
									  <?php foreach($list_faskes as $listkan){?>
									  <option <?php if (trim($lb->kodefaskes)==trim($listkan->kodefaskes)) { echo 'selected';} ?> value="<?php echo trim($listkan->kodefaskes).'|'.$listkan->namafaskes;?>" ><?php echo $listkan->kodefaskes.'|'.$listkan->namafaskes;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Faskes Tambahan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodefaskes2" id="kodefaskes2">
									  <?php foreach($list_faskes as $listkan){?>
									  <option <?php if (trim($lb->kodefaskes2)==trim($listkan->kodefaskes)) { echo 'selected';} ?> value="<?php echo trim($listkan->kodefaskes).'|'.$listkan->namafaskes;?>" ><?php echo $listkan->kodefaskes.'|'.$listkan->namafaskes;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="nik" id="nik">
									  <?php foreach($list_karyawan as $listkan){?>
									  <option <?php if (trim($lb->nik)==trim($listkan->nik)) { echo 'selected';} ?> value="<?php echo trim($listkan->nik).'|'.$listkan->nmlengkap;?>" ><?php echo $listkan->nik.'|'.$listkan->nmlengkap;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Id Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="id_bpjs"  value="<?php echo $lb->id_bpjs;?>" class="form-control" style="text-transform:uppercase" maxlength="6" readonly>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Kelas</label>	
								<div class="col-sm-8">    
									<input type="text" id="nmdept" name="kelas" value="<?php echo $lb->kelas;?>" maxlength="20" style="text-transform:uppercase" class="form-control">
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Expired</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput1" name="tgl_berlaku"  value="<?php echo $lb->tgl_berlaku;?>" data-date-format="dd-mm-yyyy" class="form-control">
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo $lb->keterangan;?></textarea>
								</div>
							</div>		
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
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
<?php } ?>
