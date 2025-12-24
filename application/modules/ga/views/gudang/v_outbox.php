<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
			
			window.onload = function () {
				document.getElementById("password1").onchange = validatePassword;
				document.getElementById("password2").onchange = validatePassword;
			}
			function validatePassword(){
			var pass2=document.getElementById("password2").value;
			var pass1=document.getElementById("password1").value;
			if(pass1!=pass2)
				document.getElementById("password2").setCustomValidity("Passwords Tidak Sama");
			else
				document.getElementById("password2").setCustomValidity(''); 			
			//empty string means no validation error
			}
</script>
<legend><?php echo $title;?></legend>
<?php echo $message; ?>
				<div class="row">
                    <div class="col-xs-12">
						<div class="box">
							<div class="box-header">
					   <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> INPUT</a>
					   <button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" style="margin:10px"><i class="glyphicon glyphicon-search"></i> FILTER</a>
					</div><!-- /.box-header -->	
					
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped" >
                                    <thead>
										<tr>											
											
											<th>No.</th>
											<th>Nomer Penerima</th>
											<th>Nama Penerima</th>
											<th>Keterangan</th>
											<th>Isi SMS</th>
											<th>Status</th>	
											<th>Tanggal kirim</th>
											<th>Aksi</th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_outbox as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->no_penerima;?></td>
									<td><?php echo $row->nama;?></td>
									<td><?php echo $row->ket;?></td>
									<td><?php echo $row->isi_sms;?></td>
									<td><?php echo $row->status;?></td>
									<td><?php echo $row->tanggal_kirim;?></td>
									<td><a href="<?php echo site_url('sms/hps_sentitem').'/'.$row->id;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->id);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input Kirim SMS -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Kirim SMS</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('sms/input_sms');?>" method="post">
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
<!-- Modal Filter  SMS -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Filter SMS</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('sms/outbox');?>" method="post">
			<div class="form-group">
				 <label class="col-sx-24">Tanggal</label>
				<div class="col-sx-24">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" id="tgl" name="tgl"  class="form-control pull-right">
					</div><!-- /.input group -->
				</div>
			</div>
			
		</div>
		<div class="modal-footer">
			<div class="form-group"> 
				<div class="col-lg-4">
					<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
				   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
				</div>
			</div>
		</div>
		</form>
  </div>
</div>
</div>  					

<script>

  

	
	//Date range picker
    $('#tgl').daterangepicker();

  

</script>