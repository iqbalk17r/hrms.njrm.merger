<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />

<legend><?php echo $title;?></legend>
<?php echo $message;?>	
				<div class="row">
                    <div class="col-xs-6">
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>Tarik Data Absensi Wilayah</h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('bantuan/transfer/proses_tarik');?>" name="form" role="form" method="post">										
										<div class="form-group">
											<label class="col-lg-3">Wilayah</label>	
												<div class="col-lg-9">    
													<select class='form-control' name="kdcabang" id="kdcabang">
													<option value=""><?php echo '--PILIH FINGER IP WILAYAH--';?></option>
														<?php foreach ($ipwil as $kl){?>
															<option value="<?php echo $kl->fingerid;?>"><?php echo $kl->wilayah;?></option>
														<?php }?>
													</select>
												</div>
										</div>
										<!--area-->
									<script type="text/javascript" charset="utf-8">
										$(function() {
												$('#kdcabang').change(function(){
												
												var idfinger=$(this).val();
										
										     //Ajax Load data from ajax
												  $.ajax({
													url : "<?php echo site_url('bantuan/transfer/ajax_ipfinger')?>/" + $(this).val(),
													type: "GET",
													dataType: "JSON",
													success: function(data)
													{
														$('[name="fingerprint"]').val(data.ipaddress);	
														$('[name="dbabsen"]').val(data.dbname);	
														          									
													},
													error: function (jqXHR, textStatus, errorThrown)
													{
														alert('Error get data from ajax');
													}
												});
												
																			
											});
										});	
							</script>
										<div class="form-group">
											<label class="col-lg-3">IP Address</label>	
											<div class="col-lg-9">    
												<input type="text" id="fingerprint" name="fingerprint" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3">Database</label>	
											<div class="col-lg-9">    
												<input type="text" id="dbabsen" name="dbabsen" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>
										<div class="form-group">
											 <label class="col-lg-3">Tanggal</label>
											<div class="col-lg-9">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" id="tgl" name="tgl"  class="form-control pull-right">
												</div><!-- /.input group -->
											</div>
										</div>
										<div class="form-group"> 
											<div class="col-lg-4">
												<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
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

  

	
	//Date range picker
    $('#tgl').daterangepicker();

  

</script>