<?php 
/*
	@author : hanif_anak_metal \m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
            });
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Kecamatan</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode</th>
							<th>Negara</th>																	
							<th>Provinsi</th>																	
							<th>Kota / Kabupaten</th>																	
							<th>Kecamatan</th>																	
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_kec as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->kodekec;?></td>																															
							<td><?php echo $lu->namanegara;?></td>																																																																																													
							<td><?php echo $lu->namaprov;?></td>																																																																																													
							<td><?php echo $lu->namakotakab;?></td>																																																																																													
							<td><?php echo $lu->namakec;?></td>																																																																																													
							<td>
								<a href='<?php $neg=trim($lu->kodenegara); $prov=trim($lu->kodeprov); $kotakab=trim($lu->kodekotakab); 
									echo site_url("master/kec/edit/$neg/$prov/$kotakab/$lu->kodekec")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a href='<?php $neg=trim($lu->kodenegara); $prov=trim($lu->kodeprov); $kotakab=trim($lu->kodekotakab); 
									echo site_url("master/kec/hps/$lu->kodekec")?>' onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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

<!--Modal untuk Input SUB-kec-SUB-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Kecamatan</h4>
      </div>
	  <form action="<?php echo site_url('master/kec/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Kode Kecamatann</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>																								
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdkec" required>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Nama Kecamatan</label>	
								<div class="col-sm-8">    
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe" maxlength='25' name="namakec" required>
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Negara</label>	
								<div class="col-sm-8">    
									<select name="negara" id='negara' class="col-sm-12" required>										
										<?php foreach ($list_opt_neg as $lon){ ?>
										<option value="<?php echo trim($lon->kodenegara);?>"><?php echo trim($lon->namanegara);?></option>																																																			
										<?php };?>
									</select>
								</div>
							</div>
							<script type="text/javascript" charset="utf-8">
							  $(function() {	
								$("#provinsi").chained("#negara");		
								$("#kotakab").chained("#provinsi");		
							  });
							</script>
							<div class="form-group">
								<label class="col-sm-4">Provinsi</label>	
								<div class="col-sm-8">    
									<select name="provinsi" id='provinsi' class="col-sm-12" required>
										<option value="">-KOSONG-</option>
										<?php foreach ($list_opt_prov as $lop){ ?>
										<option value="<?php echo trim($lop->kodeprov);?>" class="<?php echo trim($lop->kodenegara);?>"><?php echo trim($lop->namaprov);?></option>																																																			
										<?php };?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kota/Kabupaten</label>	
								<div class="col-sm-8">    
									<select name="kotakab" id='kotakab' class="col-sm-12" required>
										<option value="">-KOSONG-</option>
										<?php foreach ($list_opt_kotakab as $lok){ ?>
										<option value="<?php echo trim($lok->kodekotakab);?>" class="<?php echo trim($lok->kodeprov);?>"><?php echo trim($lok->namakotakab);?></option>																																																			
										<?php };?>
									</select>
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