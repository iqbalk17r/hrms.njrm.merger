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
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Negara</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>KODE</th>
							<th>Nama Negara</th>																	
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_negara as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->kodenegara;?></td>																								
							<td><?php echo $lu->namanegara;?></td>																																																																																													
							<td>
								<a href='<?php echo site_url("master/negara/edit/$lu->kodenegara")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a href='<?php echo site_url("master/negara/hps/$lu->kodenegara")?>' onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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


<!--Modal untuk Input Nama Negara-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Negara</h4>
      </div>
	  <form action="<?php echo site_url('master/negara/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">KODE Negara</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>									
									<input type="text" style="text-transform:uppercase ;" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdnegara" required>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">NAMA Negara</label>	
								<div class="col-sm-8">    
									<input type="text" style="text-transform:uppercase ;" class="form-control input-sm" value="" id="tipe" maxlength='25' name="namanegara" required>
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
