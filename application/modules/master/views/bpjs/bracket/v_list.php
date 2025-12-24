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
            });
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input bracket</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Tipe</th>																						
							<th>Batas Bawah</th>																	
							<th>Batas Atas</th>																	
							<th>Nominal</th>																	
							<th>Keterangan</th>																	
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_bracket as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->tipe;?></td>							
							<td><?php echo $lu->batasbawah;?></td>
							<td><?php echo $lu->batasatas;?></td>
							<td><?php echo $lu->nominal.' %';?></td>
							<td><?php echo $lu->keterangan;?></td>
							<td>
								<a href='<?php echo site_url("master/bracket/edit/$lu->nourut")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a href='<?php echo site_url("master/bracket/hps/$lu->nourut")?>' onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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


<!--Modal untuk Input Nama bracket-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input bracket</h4>
      </div>
	  <form action="<?php echo site_url('master/bracket/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Tipe</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>																		
									<select type="text" class="form-control input-sm" id="tipe" name="kdtipe" required>
										<option value="REGULER">REGULER</option>
										<option value="PESANGON">PESANGON</option>
									</select>
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Batas Bawah</label>	
								<div class="col-sm-8"> 
									<div class="input-group">
                                        <span class="input-group-addon">Rp</span>
										<input type="number" class="form-control input-sm" value="" id="tipe"  name="batasbawah" required>                                        
                                    </div>									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Batas Atas</label>	
								<div class="col-sm-8"> 
									<div class="input-group">
                                        <span class="input-group-addon">Rp</span>
										<input type="number" class="form-control input-sm" value="" id="tipe"  name="batasatas" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nominal</label>	
								<div class="col-sm-8"> 
									<div class="input-group">                                        
										<input type="number" class="form-control input-sm" value="" id="tipe" max-length='3'  name="nominal" required>
										<span class="input-group-addon">%</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea class="form-control input-sm" value="" id="tipe"  name="keterangan" required></textarea>
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
