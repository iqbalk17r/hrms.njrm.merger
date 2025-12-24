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
					<a href="<?php echo site_url("master/formula/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
			
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode Rumus</th>								
							<th>Tipe</th>								
							<th>Keterangan</th>								
							<th>Aksi Rumus</th>								
							<th>Aksi Tipe</th>								
							<th>Tetap/Tidak</th>								
							<th>Taxable/Non Taxable</th>								
							<th>Deductible/Non Deductible</th>								
							<th>Regular/Non Regular</th>								
							<th>Cash/Non Cash</th>								
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_detail as $lu) {;?>
						<tr>										
							<td width="2%"><?php echo $lu->no_urut;?></td>																							
							<td><?php echo $lu->kdrumus;?></td>
							<td><?php echo $lu->tipe;?></td>
							<td><?php echo $lu->keterangan;?></td>
							<td><?php echo $lu->aksi;?></td>
							<td><?php echo $lu->aksi_tipe;?></td>
							<td><?php echo $lu->tetap1;?></td>
							<td><?php echo $lu->taxable1;?></td>
							<td><?php echo $lu->deductible1;?></td>
							<td><?php echo $lu->regular1?></td>
							<td><?php echo $lu->cash1;?></td>
							<td>
								<a href="#" data-toggle="modal" data-target="#<?php echo $lu->no_urut;?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> edit
								</a>
								<a  href="<?php echo site_url("master/formula/hps_detail/$kdrumus/$lu->no_urut")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>
								
							</td>
						</tr>
						<?php };?>
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
									<input type="text" id="nik" name="kdrumus" value="<?php echo trim($kdrumus);?>" class="form-control" style="text-transform:uppercase" maxlength="12" readonly>
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
</div>
<!-- modal edit data -->
<?php foreach ($list_detail as $lu) { ?>
<div class="modal fade" id="<?php echo trim($lu->no_urut); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Detail Formula</h4>
      </div>
	  <form action="<?php echo site_url('master/formula/edit_detail')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
						<div class="form-group">
								<label class="col-sm-4">Kode Rumus</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdrumus" value="<?php echo trim($kdrumus);?>" class="form-control" style="text-transform:uppercase" maxlength="12" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tipe</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="tipe" id="tipe">
									  <option <?php if (trim($lu->tipe)=='INPUT MANUAL'){ echo 'selected';}?> value="INPUT MANUAL">INPUT MANUAL</option>
									  <option <?php if (trim($lu->tipe)=='LINK'){ echo 'selected';}?>  value="LINK">LINK DATA</option>
									  <option <?php if (trim($lu->tipe)=='OTOMATIS'){ echo 'selected';}?> value="OTOMATIS">OTOMATIS</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="keterangan"  value="<?php echo trim($lu->keterangan);?>" class="form-control" style="text-transform:uppercase" maxlength="50" >
									<input type="hidden" id="nik" name="no_urut"  value="<?php echo trim($lu->no_urut);?>" class="form-control">
									
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Aksi</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="aksi" id="aksi">
									 <?php foreach($list_trxtype as $listkan){?>
									  <option <?php if ($listkan->kdtrx==$lu->aksi){ echo 'selected';} ?> value="<?php echo trim($listkan->kdtrx);?>"><?php echo trim($listkan->uraian);?></option>
									   <?php }?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Aksi Tipe</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="aksi_tipe"  value="<?php echo trim($lu->aksi_tipe);?>" class="form-control"  maxlength="30" >
									
									
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
									  <option  <?php if (trim($lu->tetap)=='T'){ echo 'selected';}?> value="T">TETAP</option>
									  <option <?php if (trim($lu->tetap)=='F'){ echo 'selected';}?> value="F">TIDAK TETAP</option>
									  <option <?php if (trim($lu->tetap)==null){ echo 'selected';}?> value="">N.A</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Taxable/Non Taxable</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="taxable" id="tetap">
									  <option <?php if (trim($lu->taxable)=='T'){ echo 'selected';}?> value="T">Taxable</option>
									  <option  <?php if (trim($lu->taxable)=='F'){ echo 'selected';}?> value="F">Non Taxable</option>
									  <option <?php if (trim($lu->taxable)==null){ echo 'selected';}?> value="">N.A</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Deductible/Non Deductible</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="deductible" id="tetap">
									  <option <?php if (trim($lu->deductible)=='T'){ echo 'selected';}?> value="T">Deductible</option>
									  <option  <?php if (trim($lu->deductible)=='F'){ echo 'selected';}?> value="F">Non Deductible</option>
									  <option <?php if (trim($lu->deductible)==null){ echo 'selected';}?> value="">N.A</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Regular/Non Regular</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="regular" id="tetap">
									  <option <?php if (trim($lu->regular)=='T'){ echo 'selected';}?> value="T">Regular</option>
									  <option  <?php if (trim($lu->regular)=='F'){ echo 'selected';}?> value="F">Non Regular</option>
									  <option <?php if (trim($lu->regular)==null){ echo 'selected';}?> value="">N.A</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Cash/Non Cash</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="cash" id="tetap">
									  <option <?php if (trim($lu->cash)=='T'){ echo 'selected';}?> value="T">Cash</option>
									  <option  <?php if (trim($lu->cash)=='F'){ echo 'selected';}?> value="F">Non Cash</option>
									  <option <?php if (trim($lu->cash)==null){ echo 'selected';}?> value="">N.A</option>
									</select>
								</div>
							</div>
							
							
						</div><!-- /.box-body -->													
					</div><!-- /.box -->													
				</div>	
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






