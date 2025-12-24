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
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Provinsi</a>
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
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_prov as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->kodeprov;?></td>																								
							<td><?php echo $lu->namanegara;?></td>																																																																																													
							<td><?php echo $lu->namaprov;?></td>																																																																																													
							<td>
								<a href='<?php $neg=trim($lu->kodenegara); echo site_url("master/prov/edit/$neg/$lu->kodeprov")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a href='<?php $neg=trim($lu->kodenegara); echo site_url("master/prov/hps/$neg/$lu->kodeprov")?>' onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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


<!--Modal untuk Input Nama prov-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Provinsi</h4>
      </div>
	  <form action="<?php echo site_url('master/prov/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Kode Provinsi</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>									
									<input type="text" style="text-transform:uppercase ;" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdprov" required>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Negara</label>	
								<div class="col-sm-8">    
									<select name="negara" class="col-sm-12">
										<?php foreach ($list_opt_neg as $lon) {?>										
										<option value="<?php echo trim($lon->kodenegara);?>"><?php echo $lon->namanegara;?></option>;
										<?php }?>																																																															
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Provinsi</label>	
								<div class="col-sm-8">    
									<input type="text" style="text-transform:uppercase ;" class="form-control input-sm" value="" id="tipe" maxlength='25' name="namaprov" required>									
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