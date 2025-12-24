<legend><?php echo $title;?></legend>
<?php //echo $message; ?>
				<div class="row">
                    <div class="col-xs-12">
						<div class="box">
                            <div class="box-body">
									<form role="form" action="<?php echo site_url('mail/mailserver/send_mail');?>" method="post">
										<div class="row">
										<div class="form-group">
											 <label class="col-sm-12">SENDER</label>
											<div class="col-sm-6">
												
													<input type="text" value="<?php echo $dtl_smtp['primarymail'];?>" id="sender" name="sender"  class="form-control" readonly>
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">TO RECIPIENTS</label>
											<div class="col-sm-6">
												
													<input type="text" id="recipients" name="recipients"  class="form-control" >
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">CC</label>
											<div class="col-sm-6">

													<input type="text" id="cc" name="cc"  maxlength="40" class="form-control" >
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">BCC</label>
											<div class="col-sm-6">

													<input type="text" id="bcc" name="bcc"  maxlength="40"  class="form-control" >
												
												<!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="col-sm-12">SUBJECT</label>
											<div class="col-sm-6">

													<input type="text" id="subject" name="subject"  maxlength="40" class="form-control" >
												
												<!-- /.input group -->
											</div>
										</div>
										 
										<div class="form-group">
											 <label class="col-sm-12">TEXT</label>
											<div class="col-sm-12">

												​<textarea id="textmail" name="textmail" rows="15" cols="120"></textarea>
												
												<!-- /.input group -->
											</div>
										</div>
								
										<div class="modal-footer">
											<div class="form-group"> 
												<div class="col-lg-12">
												<!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
													<a href="<?php echo site_url('mail/mailserver/');?>"  class="btn btn-dismiss" >Kembali</a>
													<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> KIRIM</button>
												   
												</div>
											</div>
										</div>
										</div>
									</form>

							</div>
						</div>
					</div>
				</div>	
							