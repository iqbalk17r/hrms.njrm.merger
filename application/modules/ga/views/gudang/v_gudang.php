<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
            });
					
			//empty string means no validation error
			}
</script>

<legend><?php echo $title;?></legend>
<div class="row">
	<div class="col-sm-12">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input SMS</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>

	</div>
</div>	
</br>
<div class="row">
	<div class="col-sm-12">
				<div class="box">
					<div class="box-header">
					 <h5><?php echo $title;?></h5>
						<!--?php echo $message;?--->
						
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th>No.</th>
											<th>Kode Gudang</th>
											<th>Nama Gudang</th>
											<th>Alamat Gudang</th>
											<th>Hold</th>
											<th>Aksi</th>
                                        </tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_gudang as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->loccode;?></td>
									<td><?php echo $row->locaname;?></td>
									<td><?php echo $row->locaadd;?></td>
									<td><?php echo $row->chold;?></td>
									<td><a data-toggle="modal" data-target="#<?php echo trim($row->loccode);?>" href="#" ><i class="fa  fa-envelope-o"><i> Ubah </a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>		
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Kirim SMS</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('sms/smscenter/input_sms');?>" method="post">
		  <div class="form-group">
			<label for="besaran">Nomer Penerima</label>
			<input type="number" class="form-control" id="penerima" name="penerima" placeholder="Masukan Nomer Penerima">
		  </div>
		  <div>
          <textarea  class="textarea" name="isi" placeholder="Message"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
          </div>
		  
		  <button type="submit" class="btn btn-primary">Kirim</button>
		  <button type="reset" class="btn btn-default">Reset</button>
		</form>
	  </div>
	</div>
  </div>
</div>				
<!--replay sms -->


<script>

  

	
	//Date range picker
    $('#tgl').daterangepicker();
	$('#tgl1').daterangepicker();

  

</script>