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
					<a href="<?php echo site_url("trans/kompetensi_bahasa/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
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
							<th>Nama Bahasa</th>
							<th>Kemampuan Baca</th>
							<th>Kemampuan Mendengar</th>
							<th>Kemampuan Menulis</th>
							<th>Kemampuan Bicara</th>											
							<th>Keterangan</th>											
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_kompetensi_bahasa as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><?php echo $lu->nmbahasa;?></td>
							<td><?php echo $lu->kem_baca;?></td>
							<td><?php echo $lu->kem_dengar;?></td>
							<td><?php echo $lu->kem_tulis;?></td>
							<td><?php echo $lu->kem_bicara;?></td>
							<td><?php echo $lu->keterangan;?></td>
							
							<td>
								<!--<a href='<?php  $nik=trim($lu->nik); echo site_url("trans/kompetensi_bahasa/detail/$nik/$lu->no_urut")?>' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>-->
								<?php if($akses['aksesupdate']=='t') { ?>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->no_urut);?>" href='#' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<?php } ?>
								<?php if($akses['aksesdelete']=='t') { ?>
								<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/kompetensi_bahasa/hps_kompetensi_bahasa/$nik/$lu->no_urut")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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
        <h4 class="modal-title" id="myModalLabel">Input Kompetensi Bahasa <?php echo $nik.'|'.$list_lk['nmlengkap'];?></h4>
      </div>
	  <form action="<?php echo site_url('trans/kompetensi_bahasa/add_kompetensi_bahasa')?>" method="post">
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
								<label class="col-sm-4">Nama Bahasa</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdbahasa" id="kdbahasa">
									  <?php foreach($list_bahasa as $listkan){?>
									  <option value="<?php echo trim($listkan->kdbahasa);?>" ><?php echo $listkan->nmbahasa;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Kemampuan Membaca</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kem_baca" id="kdbahasa">
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>	
								</div>
							</div>
							
						<div class="form-group">
								<label class="col-sm-4">Kemampuan Menulis</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kem_tulis" id="kdbahasa">
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
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
								<label class="col-sm-4">Kemampuan Mendengar</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kem_dengar" id="kdbahasa">
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>	
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kemampuan Bicara</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kem_bicara" id="kdbahasa">
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>	
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
<?php foreach ($list_kompetensi_bahasa as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->no_urut); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Riwayat Pendidikan Non Formal</h4>
      </div>
	  <form action="<?php echo site_url('trans/kompetensi_bahasa/edit_kompetensi_bahasa')?>" method="post">
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
								<label class="col-sm-4">Nama Bahasa</label>	
								<div class="col-sm-8">    
									<input type="text" id="nmbahasa" name="nmbahasa"  value="<?php echo $lb->nmbahasa; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Kemampuan Membaca</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kem_baca" id="kdbahasa">
										<option <?php if ($lb->kem_baca==0) {echo 'selected';} ?> value="0">0</option>
										<option <?php if ($lb->kem_baca==1) {echo 'selected';} ?> value="1">1</option>
										<option <?php if ($lb->kem_baca==2) {echo 'selected';} ?> value="2">2</option>
										<option <?php if ($lb->kem_baca==3) {echo 'selected';} ?> value="3">3</option>
										<option <?php if ($lb->kem_baca==4) {echo 'selected';} ?> value="4">4</option>
										<option <?php if ($lb->kem_baca==5) {echo 'selected';} ?> value="5">5</option>
									</select>	
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Kemampuan Menulis</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kem_tulis" id="kdbahasa">
										<option <?php if ($lb->kem_tulis==0) {echo 'selected';} ?> value="0">0</option>
										<option <?php if ($lb->kem_tulis==1) {echo 'selected';} ?> value="1">1</option>
										<option <?php if ($lb->kem_tulis==2) {echo 'selected';} ?> value="2">2</option>
										<option <?php if ($lb->kem_tulis==3) {echo 'selected';} ?> value="3">3</option>
										<option <?php if ($lb->kem_tulis==4) {echo 'selected';} ?> value="4">4</option>
										<option <?php if ($lb->kem_tulis==5) {echo 'selected';} ?> value="5">5</option>
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
								<label class="col-sm-4">Kemampuan Mendengar</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kem_dengar" id="kdbahasa">
										<option <?php if ($lb->kem_dengar==0) {echo 'selected';} ?> value="0">0</option>
										<option <?php if ($lb->kem_dengar==1) {echo 'selected';} ?> value="1">1</option>
										<option <?php if ($lb->kem_dengar==2) {echo 'selected';} ?> value="2">2</option>
										<option <?php if ($lb->kem_dengar==3) {echo 'selected';} ?> value="3">3</option>
										<option <?php if ($lb->kem_dengar==4) {echo 'selected';} ?> value="4">4</option>
										<option <?php if ($lb->kem_dengar==5) {echo 'selected';} ?> value="5">5</option>
									</select>	
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kemampuan Bicara</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kem_bicara" id="kdbahasa">
										<option <?php if ($lb->kem_bicara==0) {echo 'selected';} ?> value="0">0</option>
										<option <?php if ($lb->kem_bicara==1) {echo 'selected';} ?> value="1">1</option>
										<option <?php if ($lb->kem_bicara==2) {echo 'selected';} ?> value="2">2</option>
										<option <?php if ($lb->kem_bicara==3) {echo 'selected';} ?> value="3">3</option>
										<option <?php if ($lb->kem_bicara==4) {echo 'selected';} ?> value="4">4</option>
										<option <?php if ($lb->kem_bicara==5) {echo 'selected';} ?> value="5">5</option>
									</select>	
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
