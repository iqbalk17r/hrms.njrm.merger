<legend><?php echo $title;?></legend>
<span id="postmessages"></span>
<?php echo $message; ?>
				<div class="row">
                    <div class="col-xs-12">
						<div class="box">
                            <div class="box-body">
									<form role="form" action="<?php echo site_url('mail/mailserver/save_smtp');?>" method="post">
										<div class="row">
										<div class="form-group">
											 <label class="col-sm-12">PROTOCOL</label>
											<div class="col-sm-6">
													<input type="text" value="<?php echo $dtl_smtp['protocol'];?>" id="protocol" name="protocol"  class="form-control" maxlength="30" required>
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">SMTP HOST</label>
											<div class="col-sm-6">
												
													<input value="<?php echo $dtl_smtp['smtp_host'];?>" type="text" id="smtp_host" name="smtp_host"  class="form-control" required >
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">SMTP PORT</label>
											<div class="col-sm-6">
												
													<input value="<?php echo $dtl_smtp['smtp_port'];?>" type="text" id="smtp_port" name="smtp_port"  class="form-control" required >
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">SMPT USER</label>
											<div class="col-sm-6">

													<input value="<?php echo $dtl_smtp['smtp_user'];?>" type="text" id="smtp_user" name="smtp_user"  class="form-control" required >
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">SMTP PASSOWORD</label>
											<div class="col-sm-6">
													<input value="" type="password" id="smtp_pass" name="smtp_pass"  class="form-control" required>
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">CONFIRM SMTP PASSOWORD</label>
											<div class="col-sm-6">
													<input value="" type="password" id="smtp_pass2" name="smtp_pass2"  class="form-control" required>
											</div>
										</div>
										<script>
											var password = document.getElementById("smtp_pass")
													  , confirm_password = document.getElementById("smtp_pass2");

													function validatePassword(){
													  if(password.value != confirm_password.value) {
														 $('#postmessages').empty().append("<div class='alert alert-success'>PERINGATAN PASSOWORD TIDAK SAMA !!!!</div>");
														//confirm_password.setCustomValidity("Password Tidak Sama !!!");
													  } else {
														 $('#postmessages').empty();
														//confirm_password.setCustomValidity('');
													  }
													}

													password.onchange = validatePassword;
													confirm_password.onkeyup = validatePassword;
										</script>					
										<div class="form-group">
											 <label class="col-sm-12">MAIL TYPE</label>
											<div class="col-sm-6">
													<input value="<?php echo $dtl_smtp['mail_type'];?>" type="text" id="mail_type" name="mail_type"  class="form-control" required >
												<!-- /.input group -->
											</div>
										</div>
										 
										<div class="form-group">
											 <label class="col-sm-12">CHARSET</label>
											<div class="col-sm-6">
												<input value="<?php echo $dtl_smtp['charset'];?>" type="text" id="charset" name="charset"  class="form-control" required >
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">Primary Email Sender</label>
											<div class="col-sm-6">
												<input value="<?php echo $dtl_smtp['primarymail'];?>" type="text" id="primarymail" name="primarymail"  class="form-control" required >
												<!-- /.input group -->
											</div>
										</div>
								
										<div class="modal-footer">
											<div class="form-group"> 
												<div class="col-lg-12">
												<!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
													<a href="<?php echo site_url('mail/mailserver/');?>"  class="btn btn-dismiss" >BATAL</a>
													<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-save"></i> SIMPAN</button>
												   
												</div>
											</div>
										</div>
										</div>
									</form>

							</div>
						</div>
					</div>
				</div>	
							