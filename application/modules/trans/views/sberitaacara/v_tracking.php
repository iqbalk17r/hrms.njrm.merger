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
				<div class="row">
                    <div class="col-xs-12">
						<div class="box">
							<div class="box-header">
					   <button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> INPUT</a>
					</div><!-- /.box-header -->	
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped" >
                                    <thead>
										<tr>											
											
											<th>No.</th>
											<th>dokumen</th>
											<th>Nik</th>
											<th>Nama terlapor</th>
											<th>Tgl kejadian</th>
											<th>Nama saksi 1</th>
											<th>Nama saksi 2</th>
											<th>Teguran</th>
											<th>tgl selesai</th>
											<th>SP 1</th>
											<th>tgl selesai</th>
											<th>SP 2</th>
											<th>tgl selesai</th>
											<th>SP 3</th>
											<th>tgl selesai</th>
											
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_tracking as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->docno;?></td>
									<td><?php echo $row->nik;?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->tgl_dok;?></td>
									<td><?php echo $row->nmsaksi1;?></td>
									<td><?php echo $row->nmsaksi2;?></td>
									<td><?php echo $row->dokumen_tg;?></td>
									<td><?php echo $row->tgl_tg;?></td>
									<td><?php echo $row->dokumen_sp;?></td>
									<td><?php echo $row->tgl_sp;?></td>
									<td><?php echo $row->dokumen_sp2;?></td>
									<td><?php echo $row->tgl_sp2;?></td>
									<td><?php echo $row->dokumen_sp3;?></td>
									<td><?php echo $row->tgl_sp3;?></td>
									
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input agama -->


 						

<script>

  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgl').datepicker();

  

</script>
