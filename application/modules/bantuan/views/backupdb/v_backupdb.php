<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />

<legend><?php echo $title;?></legend>
<?php echo $message;?>	
				<div class="row">
                    <div class="col-xs-6">
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>Backup Database </h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('bantuan/backupdb/proses_backup');?>" name="form" role="form" method="post">										
										<div class="form-group">
											<label class="col-lg-3">SCHEDULING BACKUP</label>	
												<div class="col-lg-9">    
													<select class='form-control' name="schedule" id="schedule">
													<option <?php if (trim($dtlbackupdb['schedule'])=='daily') { echo 'selected'; } ?> value="daily"><?php echo '-- HARIAN--';?></option>
													<option <?php if (trim($dtlbackupdb['schedule'])=='partially') { echo 'selected'; } ?>  value="partially"><?php echo '-- BAGIAN --';?></option>
													</select>
												</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3">DB NAME</label>	
											<div class="col-lg-9">    
												<input value="<?php echo trim($dtlbackupdb['dbname']); ?>" type="text" id="dbname" name="dbname" class="form-control" maxlength="10" readonly>
											</div>
										</div>
												
										<div class="form-group">
											<label class="col-lg-3">PASSWORD</label>	
											<div class="col-lg-9">    
												
												<input  value="<?php echo trim($dtlbackupdb['dbpassword']); ?>" type="password" id="dbpassword" name="dbpassword" class="form-control" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3">CONNECTION NAME</label>	
											<div class="col-lg-9">    
												<input  value="<?php echo trim($dtlbackupdb['dbuname']); ?>" type="text" id="dbuname" name="dbuname" class="form-control" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3">PATH PG BIN</label>	
											<div class="col-lg-9">    
												<input  value="<?php echo trim($dtlbackupdb['path_bin']); ?>" type="text" id="path_bin" name="path_bin" class="form-control" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3">PATH SOURCE</label>	
											<div class="col-lg-9">    
												<input  value="<?php echo trim($dtlbackupdb['path_source']); ?>" type="text" id="path_source" name="path_source" class="form-control" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3">BACKUP OUTPUT TYPE</label>	
												<div class="col-lg-9">    
													<select class='form-control' name="backuptype" id="backuptype">
													<option <?php if (trim($dtlbackupdb['path_source'])=='backup') { echo 'selected'; } ?> value="backup"><?php echo '-- DUMP--';?></option>
													<option <?php if (trim($dtlbackupdb['path_source'])=='sql') { echo 'selected'; } ?>  value="sql"><?php echo '-- SQL --';?></option>
													</select>
												</div>
										</div>
										
										<div class="form-group"> 
											<div class="col-lg-4 pull-right">
												<button type='submit' class='btn btn-primary prosesbackup'><i class="fa fa-gear"></i> PROSES BACKUP </button>
											   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
		
	

<script>

  
function download()
    {
	  $('.prosesbackup').text('Processing....Backup!!');
	  $('.prosesbackup').attr('disabled',true);
	}
	
	//Date range picker
    $('#tgl').daterangepicker();

  

</script>