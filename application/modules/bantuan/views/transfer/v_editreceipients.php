
<script>

  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgl').datepicker();
    $('#example1').dataTable();
	//$('#nik').selectize();
	$('.cl-select').selectize();
  

</script>

<?php //echo $message; ?>
	

	  <div class="box-header">
		<h4 class="box-title" id="myModalLabel"><?php echo $title;?></h4>
	  </div>
	  
		<div class="box-body">
		<form role="form" action="<?php echo site_url('mail/mailserver/save_edit_receipt');?>" method="post">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						 <label class="col-sm-12">Nik</label>
								<div class="col-sm-12 ">    
									<select class="form-control input-sm cl-select" name="nik" id="nik" required>
									  <option value="">--PILIH NIK KARYAWAN</option>
									  <?php foreach($list_nik as $ls){ ?>
									  <option value="<?php echo trim($ls->nik);?>" <?php if(trim($dtl_receipt['nik'])==trim($ls->nik)){echo 'selected';}?>><?php echo $ls->nik.'||'.$ls->nmlengkap;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Alamat Email</label>
						<div class="col-sm-12">

								<input value="<?php echo trim($dtl_receipt['mail_sender']);?>" type="text" id="mail_sender" name="mail_sender"  class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Nama Owner</label>
						<div class="col-sm-12">

								<input value="<?php echo trim($dtl_receipt['mail_owner']);?>" type="text" id="mail_owner" name="mail_owner" class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>			
					<div class="form-group">
						 <label class="col-sm-12">Type Reminder</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="type_receipt" id="type_receipt" required="required">
									 <option value="<?php echo trim($dtl_receipt['mail_status']);?>" <?php if(trim($dtl_receipt['mail_status'])=='REMDKT') { $mail_status=	'REMINDER KONTRAK';} else if(trim($dtl_receipt['mail_status'])=='REMDPEN') { $mail_status='REMINDER PENSIUN';} else{echo  $mail_status='';} ?>><?php echo $mail_status?></option> 
									 <option value="REMDKT">REMINDER KONTRAK</option> 
									 <option value="REMDPEN">REMINDER PENSIUN</option> 
							</select>
								
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Mail Status</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="mail_status" id="mail_status" required="required">
									 <option value="<?php echo trim($dtl_receipt['mail_status']);?>" <?php if(trim($dtl_receipt['mail_status'])=='yes') { $mail_status=	'Yes';} else { $mail_status='No';} ?>><?php echo $mail_status?></option> 
									 <option value="yes">Yes</option> 
									 <option value="no">No</option> 
							</select>
								
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Mail Hold</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="mail_hold" id="mail_hold" required="required">
									 <option value="<?php echo trim($dtl_receipt['mail_hold']);?>" <?php if(trim($dtl_receipt['mail_hold'])=='t') { $mail_hold=	'Yes';} else { $mail_hold='No';} ?>><?php echo $mail_hold?></option> 
									 <option value="t">Yes</option> 
									 <option value="f">No</option> 
							</select>

						</div>
					</div>
					<input value="<?php echo trim($dtl_receipt['no_dok']);?>" type="hidden" id="no_dok" name="no_dok">
			</div>
			<div class="modal-footer">
				<div class="form-group"> 
					<div class="col-lg-12">
					<a href="<?php echo site_url('mail/mailserver/');?>"  class="btn btn-dismiss" >Kembali</a>
						<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Kirim</button>
					</div>
				</div>
			</div>
			</div>
		</form>
  </div>


