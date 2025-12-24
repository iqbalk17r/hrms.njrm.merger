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
<script>
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
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
					<!--<a href="<?php echo site_url("trans/upah_borong/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
			
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode Rumus</th>								
							<th>Input By</th>								
							<th>Input Date</th>								
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_master as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->kdrumus;?></td>
							<td><?php echo $lu->input_by;?></td>
							<td><?php echo $lu->input_date;?></td>
							<td>
								<a href="#"  data-toggle="modal" data-target="#<?php echo trim($lu->kdrumus);?>"  class="btn btn-warning btn-sm">
									<i class="fa fa-edit"></i> Input Detail
								</a>
								<a href="<?php $nik=trim($lu->kdrumus); echo site_url("master/formula/detail/$lu->kdrumus")?>" class="btn btn-primary  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>
								<!--<a  href="<?php $nik=trim($lu->kdrumus); echo site_url("master/formula/hps_formula/$lu->kdrumus")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
								
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>






<!-- modal input data -->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Master Formula</h4>
      </div>
	  <form action="<?php echo site_url('master/formula/add_formula')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
						<div class="form-group">
								<label class="col-sm-4">Kode Rumus</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="kdrumus"  class="form-control" style="text-transform:uppercase" maxlength="12" >
									
								</div>
						</div>
						<div class="form-group">
							 <label class="col-sm-4">Tanggal Input</label>
							<div class="col-sm-8">
								
									<input type="text" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
								
								<!-- /.input group -->
							</div>
						</div>
						<div class="form-group">
							 <label class="col-sm-4">Input By</label>
							<div class="col-sm-8">
							
									<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

								<!-- /.input group -->
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


<!-- modal edit data -->
<?php foreach ($list_master as $lu) { ?>
<div class="modal fade" id="<?php echo trim($lu->kdrumus); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Detail Formula</h4>
      </div>
	  <form action="<?php echo site_url('master/formula/add_formula')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							
							<div class="form-group">
								<label class="col-sm-4">Kode Rumus</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdrumus"   class="form-control" value="<?php echo trim($lu->kdrumus);?>" style="text-transform:uppercase" maxlength="12" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tipe</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="tipe" id="tipe">
									  <option value="INPUT MANUAL">INPUT MANUAL</option>
									  <option value="LINK">LINK DATA</option>
									  <option value="OTOMATIS">OTOMATIS</option>
									  
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="keterangan"  class="form-control" style="text-transform:uppercase" maxlength="50" >
									
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Aksi</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="aksi" id="aksi">
									 <?php foreach($list_trxtype as $listkan){?>
									  <option value="<?php echo trim($listkan->kdtrx);?>"><?php echo trim($listkan->uraian);?></option>
									   <?php }?>
									</select>
								</div>
							</div>	
							
							<div class="form-group">
								<label class="col-sm-4">Aksi Tipe</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="aksi_tipe"  class="form-control"  maxlength="30" >
									
									
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
								<label class="col-sm-4">Tetap/Tidak Tetap</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="tetap" id="tetap">
									  <option value="T">TETAP</option>
									  <option value="F">TIDAK TETAP</option>
									  <option value="">N.A</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Taxable/Non Taxable</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="taxable" id="tetap">
									  <option value="T">Taxable</option>
									  <option value="F">Non Taxable</option>
									  <option value="">N.A</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Deductible/Non Deductible</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="deductible" id="tetap">
									  <option value="T">Deductible</option>
									  <option value="F">Non Deductible</option>
									  <option value="">N.A</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Regular/Non Regular</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="regular" id="tetap">
									  <option value="T">Regular</option>
									  <option value="F">Non Regular</option>
									  <option value="">N.A</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Cash/Non Cash</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="cash" id="tetap">
									  <option value="T">Cash</option>
									  <option value="F">Non Cash</option>
									  <option value="">N.A</option>
									</select>
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






