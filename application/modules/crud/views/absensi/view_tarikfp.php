<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />

<legend><?php echo $title;?></legend>
				<div class="row">
                    <div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<a data-toggle="modal" data-target=".baru" class="btn btn-primary" style="margin-left:10px;  margin-top:5px">
								<i class="glyphicon glyphicon-edit"></i> Tambah</a>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped" >
                                    <thead>
										<tr>
											<th>Wilayah</th>
											<th>IP Address</th>
											<th colspan="3"><center>Action</center></th>
										</tr>
									</thead>
                                    <tbody>
										<?php foreach ($fingerprintwil as $fpwil){?>
										<tr>										
											<td><?php echo $fpwil->wilayah;?></td>
											<td><?php echo $fpwil->ipaddress;?></td>
											<td><?php
												exec("ping -n 4 $fpwil->ipaddress 2>&1", $output, $retval);
												if ($retval != 0) { 
													echo '<button class="btn-default">DISCONNECT</button>'; 															
												} 
												else 
												{ 
													echo '<button class="btn-default">CONNECTED</button>';
												?>
												<a href="<?php echo site_url('hrd/absensi/tarik_userfp/'.$fpwil->ipaddress);?>"  >
												<i class="glyphicon glyphicon-refresh"></i>Download User FP</a>|
												<a href="<?php echo site_url('hrd/absensi/tarik_logfp/'.$fpwil->ipaddress);?>"  >
												<i class="glyphicon glyphicon-refresh"></i>Download Cek Log FP</a>
												<?php
												}											
												?>												
												
											</td>
											<td>
												<a data-toggle="modal" data-target=".edit<?php echo trim($fpwil->wilayah);?>" >
												<i class="glyphicon glyphicon-edit"></i> Edit</a>
											</td>
											<td>
												<a href="<?php echo site_url('hrd/absensi/hapus');?>"  >
												<i class="glyphicon glyphicon-trash"></i> Hapus</a>
											</td>
										</tr>
										<?php }?>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>									
					<?php foreach ($fingerprintwil as $fpwil){?>
					<!--edit finger -->
						<div class="modal fade edit<?php echo trim($fpwil->wilayah);?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<form class="form-horizontal"  action="<?php echo site_url('hrd/absensi/edit_finger');?>" method="post">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
											<h4 class="modal-title" id="myModalLabel">Edit Finger Wilayah <?php echo trim($fpwil->wilayah);?></h4>
										</div>
										<div class="modal-body">										
											<div class="row">
												<div class="col-md-12">
													<div class="form-horizontal">
														<div class="form-group">
															<label class="col-md-3">Id Finger</label>	
															<div class="col-md-9">    
																<input type="text" name="fingerid" value="<?php echo trim($fpwil->fingerid);?>" id="fingerid" style="text-transform:uppercase" required readonly>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3">Wilayah</label>	
															<div class="col-md-9">    
																<input type="text" name="wilayah" value="<?php echo trim($fpwil->wilayah);?>" id="wilayah" style="text-transform:uppercase" required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3">IP Address</label>	
															<div class="col-md-9">    
																<input type="text" name="ipaddress" value="<?php echo trim($fpwil->ipaddress);?>" id="ipaddress" required>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary">Save</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					<!-- end of edit finger -->
					<?php }?>
				</div>
				
				
<!--input finger baru-->
						<div class="modal fade baru" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<form class="form-horizontal"  action="<?php echo site_url('hrd/absensi/add_finger');?>" method="post">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
											<h4 class="modal-title" id="myModalLabel">Input Finger Baru</h4>
										</div>
										<div class="modal-body">										
											<div class="row">
												<div class="col-md-12">
													<div class="form-horizontal">
														<div class="form-group">
															<label class="col-md-3">Id Finger</label>	
															<div class="col-md-9">    
																<input type="text" name="fingerid" id="fingerid" style="text-transform:uppercase" required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3">Wilayah</label>	
															<div class="col-md-9">    
																<input type="text" name="wilayah" id="wilayah" style="text-transform:uppercase" required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3">IP Address</label>	
															<div class="col-md-9">    
																<input type="text" name="ipaddress" id="ipaddress" required>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary">Save</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					<!-- end of input finger baru -->

<script>

  

	
	//Date range picker
    $('#tgl').daterangepicker();

  

</script>