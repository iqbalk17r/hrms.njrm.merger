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
							<a button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" style="margin:10px"><i class="glyphicon glyphicon-search"></i> FILTER</a>
							<a button class="btn btn-primary"  href="<?php echo site_url('sms/empty_trash_inbox');?>" style="margin:10px" OnClick="return confirm('Anda Yakin Hapus semua?')"><i class="glyphicon glyphicon-trash"></i> EMPTY TRASH</a>
       
							</div>
							
							<div class="box-body">
                                <table id="example1" class="table table-bordered table-striped" >
                                    <thead>
										<tr>											
											<th>No.</th>
											<th>Nomer Pengirim</th>
											<th>Nama Pengirim</th>
											<th>Isi SMS</th>
											<th>Tanggal Masuk</th>
											<th>Aksi</th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_trash_inbox as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->no_pengirim;?></td>
									<td><?php echo $row->nama;?></td>
									<td><?php echo $row->isi_sms;?></td>									
									<td><?php echo $row->tanggal_masuk;?></td>
									<td><a href="<?php echo site_url('sms/hps_trash_inbox').'/'.$row->id;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->id);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
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
		<form role="form" action="<?php echo site_url('sms/list_trash_inbox');?>" method="post">
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