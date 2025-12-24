<?php 
/*
	@author : junis 10-12-2012\m/
	@update : fiky 24-12-2016
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
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
					<a href="<?php echo site_url("trans/stspeg/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				</div>
				<div class="col-sm-6">
				<h5>NIK : <?php echo $nik;?><br>
				<h5>Nama : <?php echo $list_lk['nmlengkap'];?>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
							<th>No Dokumen</th>
							<th>Nama Status</th>							
							<th>Tanggal Mulai</th>							
							<th>Tanggal Berakhir</th>							
							<th>Keterangan</th>											
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_stspeg as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->nmkepegawaian;?></td>
							<td><?php echo $lu->tgl_mulai1;?></td>
							<td><?php echo $lu->tgl_selesai1;?></td>
							<td><?php echo $lu->keterangan;?></td>
							
							<td>
								<!--<a href='<?php  $nik=trim($lu->nik); echo site_url("trans/stspeg/detail/$nik/$lu->no_urut")?>' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>-->
								<a data-toggle="modal" data-target="#<?php echo trim($lu->nodok);?>" href='#' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/stspeg/hps_stspeg/$nik/$lu->nodok")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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


<!--Modal untuk status kepegawaian-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Status Kepegawaian <?php echo $nik.'|'.$list_lk['nmlengkap'];?></h4>
      </div>
	  <form action="<?php echo site_url('trans/stspeg/add_stspeg')?>" method="post">
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
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmdept"  value="<?php echo $list_lk['nmdept']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmsubdept"  value="<?php echo $list_lk['nmsubdept']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmjabatan"  value="<?php echo $list_lk['nmjabatan']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmatasan"  value="<?php echo $list_lk['nmatasan']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
								<label class="col-sm-4">Nama Kepegawaian</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdkepegawaian" id="kdkepegawaian1">
									  <?php foreach($list_kepegawaian as $listkan){?>
									  <!--option value=""> Masukkan Opsi </option-->
									  <option value="<?php echo trim($listkan->kdkepegawaian);?>" ><?php echo $listkan->nmkepegawaian;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<script type="text/javascript" charset="utf-8">
							$(function() {
		
											$('#kdkepegawaian1').change(function(){
												//$('.tglselesai').show();
												//$('#tglselesai' + $(this).val()).hide();											
												//$('#bolehcuti' + $(this).val()).hide();
												
												$('.tglselesai').hide();												
												$('#'+$(this).val()).show();																							
											
											});
										});	
							</script>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput" name="tgl_mulai" data-date-format="dd-mm-yyyy"  class="form-control">
								</div>
							</div>
							<div class="form-group">
							<div id="KO" class="tglselesai" >
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput1" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control">
								</div>
							</div>	
							</div>
							<div class="form-group">
							<div id="bolehcuti" class="bolehcuti" >
								<label class="col-sm-4">Boleh Cuti</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="cuti" id="kdbahasa">
										<option  value="T" >YA</option>	
										<option  value="F" >TIDAK</option>
									</select>	
								</div>
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



<!--Modal status kepegawaian-->
<?php foreach ($list_stspeg as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->nodok); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Riwayat Kesehatan</h4>
      </div>
	  <form action="<?php echo site_url('trans/stspeg/edit_stspeg')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">No.Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo $nik; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	

							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmdept"  value="<?php echo $list_lk['nmdept']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmsubdept"  value="<?php echo $list_lk['nmsubdept']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmjabatan"  value="<?php echo $list_lk['nmjabatan']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmatasan"  value="<?php echo $list_lk['nmatasan']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
								<label class="col-sm-4">Nama Kepegawaian</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdkepegawaian" id="kdkepegawaian">
									  <?php foreach($list_kepegawaian as $listkan){?>
									  <option <?php if(trim($listkan->kdkepegawaian)==trim($lb->kdkepegawaian)){ echo 'selected';} ?>
									  value="<?php echo trim($listkan->kdkepegawaian);?>" ><?php echo $listkan->nmkepegawaian;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<script type="text/javascript" charset="utf-8">
							$(function() {
		
											$('#kdkepegawaian').change(function(){
												$('.tglselesai').show();
												$('#tglselesai' + $(this).val()).hide();
												$('#bolehcuti' + $(this).val()).hide();
											
											});
										});	
							</script>
							
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput2" value="<?php echo $lb->tgl_mulai1;?>" name="tgl_mulai" data-date-format="dd-mm-yyyy"  class="form-control" required>
								</div>
							</div>
							<div class="form-group">
							<div id="tglselesaiKO" class="tglselesai" >
							
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput3" value="<?php echo $lb->tgl_selesai1;?>" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control">
								</div>
							</div>	
							</div>
							<div class="form-group">
							<div id="bolehcutiKO" class="bolehcuti" >
								<label class="col-sm-4">Boleh Cuti</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="cuti" id="kdbahasa">
										<option <?php if(trim($lb->cuti)=='T'){ echo 'selected';} ?>  value="T" >YA</option>	
										<option  <?php if(trim($lb->cuti)=='F'){ echo 'selected';} ?>  value="F" >TIDAK</option>
									</select>	
								</div>
							</div>
							</div>									
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo trim($lb->keterangan); ?></textarea>
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
<?php } ?>
