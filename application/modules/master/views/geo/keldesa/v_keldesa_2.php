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
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Kelurahan / Desa</a>
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
							<th>Kelurahan / Desa</th>																	
							<th>Kode Pos</th>																	
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_keldesa as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->kodekeldesa;?></td>																															
							<td><?php echo $lu->namanegara;?></td>																																																																																													
							<td><?php echo $lu->namaprov;?></td>																																																																																													
							<td><?php echo $lu->namakotakab;?></td>																																																																																													
							<td><?php echo $lu->namakec;?></td>																																																																																													
							<td><?php echo $lu->namakeldesa;?></td>																																																																																													
							<td><?php echo $lu->kodepos;?></td>																																																																																													
							<td>
								<a href='<?php $neg=trim($lu->kodenegara); $prov=trim($lu->kodeprov); $kotakab=trim($lu->kodekotakab); $kec=trim($lu->kodekec);
									echo site_url("master/keldesa/edit/$neg/$prov/$kotakab/$kec/$lu->kodekeldesa")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a href='<?php $neg=trim($lu->kodenegara); $prov=trim($lu->kodeprov); $kotakab=trim($lu->kodekotakab); 
									echo site_url("master/keldesa/hps/$lu->kodekeldesa")?>' onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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

<!--Modal untuk Input SUB-keldesa-SUB-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Kelurahan/ Desa</h4>
      </div>
	  <form action="<?php echo site_url('master/keldesa/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Kode Kelurahan / Desa</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>																								
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdkeldesa" required>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Nama Kelurahan / Desa</label>	
								<div class="col-sm-8">    
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe" maxlength='75' name="namakeldesa" required>
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Kode Pos</label>	
								<div class="col-sm-8">    
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe" maxlength='75' name="kodepos">
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
								$("#kec").chained("#kotakab");		
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
							<div class="form-group">
								<label class="col-sm-4">Kecamatan</label>	
								<div class="col-sm-8">    
									<select name="kec" id='kec' class="col-sm-12" required>
										<option value="">-KOSONG-</option>
										<?php foreach ($list_opt_kec as $lokc){ ?>
										<option value="<?php echo trim($lokc->kodekec);?>" class="<?php echo trim($lokc->kodekotakab);?>"><?php echo trim($lokc->namakec);?></option>																																																			
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