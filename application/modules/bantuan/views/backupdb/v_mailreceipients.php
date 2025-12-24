<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
					$('.cl-select').selectize();
					
            });
			

</script>
<legend><?php echo $title;?></legend>
<?php echo $message; ?>
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
											<th>Nik</th>
											<th>Alamat Email</th>
											<th>Nama Owner</th>
											<th>Mail Date</th>
											<th>Mail Status</th>
											<th>Type</th>
											<th>Last Receipt</th>
											<th>Mail Hold</th>
											<th>Input Date</th>
											<th>Input By</th>	
											<th>Update Date</th>
											<th>Update By</th>
											<th>Aksi</th>
											
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_receipt as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->nik;?></td>
									<td><?php echo $row->mail_sender;?></td>
									<td><?php echo $row->mail_owner;?></td>
									<td><?php echo $row->mail_date;?></td>
									<td><?php echo $row->mail_status;?></td>
									<td><?php echo $row->type_receipt;?></td>
									<td><?php echo $row->last_receipt;?></td>
									<td><?php echo $row->mail_hold;?></td>
									<td><?php echo $row->inputdate;?></td>
									<td><?php echo $row->inputby;?></td>
									<td><?php echo $row->updatedate;?></td>
									<td><?php echo $row->updateby;?></td>
									<td>
									<a href="<?php echo site_url('mail/mailserver/receipt_edit').'/'.$row->no_dok;?>" OnClick="return confirm('Anda Yakin Edit ?')" class="btn btn-primary">Edit</a>	
									<a href="<?php echo site_url('mail/mailserver/hapus_receipt').'/'.$row->no_dok;?>" OnClick="return confirm('Anda Yakin Hapus ?')" class="btn btn-danger">Hapus</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Setup  -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MAIL RECEIPIENTS</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('mail/mailserver/save_receipt');?>" method="post">
			<div class="row">
				<div class="form-group">
						 <label class="col-sm-12">Nik</label>
								<div class="col-sm-12 ">    
									<select class="form-control input-sm cl-select" name="nik" id="nik" required>
									  <option value="">--PILIH NIK KARYAWAN</option>
									  <?php foreach($list_nik as $ls){ ?>
									  <option value="<?php echo trim($ls->nik);?>"><?php echo $ls->nik.'||'.$ls->nmlengkap;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<script>							
					
											$('#nik').change(function(){
												
												var nik=$(this).val();
												
												  $.ajax({
													url : "<?php echo site_url('mail/mailserver/json_nik')?>/" + $(this).val(),
													type: "GET",
													dataType: "JSON",
													success: function(data)
													{
													   
														$('[name="mail_sender"]').val(data.email);                        
														$('[name="mail_owner"]').val(data.nmlengkap);                        
														//$('[name="email"]').val(data.email); 
														
													},
													error: function (jqXHR, textStatus, errorThrown)
													{
														alert('Error get data from ajax');
													}
												});
											});	
					</script>			
					<div class="form-group">
						 <label class="col-sm-12">Alamat Email</label>
						<div class="col-sm-12">

								<input value="" type="text" id="mail_sender" name="mail_sender"  class="form-control" required readonly>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Nama Owner</label>
						<div class="col-sm-12">

								<input value="" type="text" id="mail_owner" name="mail_owner" class="form-control" required readonly>
							
							<!-- /.input group -->
						</div>
					</div>			
					<div class="form-group">
						 <label class="col-sm-12">Type Reminder</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="type_receipt" id="type_receipt" required="required">
									 <option value=""><?php echo 'Pilih Type Reminder';?></option> 
									 <option value="REMDKT">REMINDER KONTRAK</option> 
									 <option value="REMDPEN">REMINDER PENSIUN</option> 
							</select>
								
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Mail Status</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="mail_status" id="mail_status" required="required">
									 <option value=""><?php echo 'Pilih Status';?></option> 
									 <option value="yes">Yes</option> 
									 <option value="no">No</option> 
							</select>
								
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Mail Hold</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="mail_hold" id="mail_hold" required="required">
									 <option value=""><?php echo 'Pilih Status';?></option> 
									 <option value="t">Yes</option> 
									 <option value="f">No</option> 
							</select>

						</div>
					</div>
			</div>
			<div class="modal-footer">
				<div class="form-group"> 
					<div class="col-sm-12">
					<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-save"></i> Simpan</button>
					</div>
				</div>
			</div>
			</div>
		</form>
  </div>
</div>
</div>  
</div>

<script>

  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgl').datepicker();
	$('#nikatasan').selectize();
  

</script>