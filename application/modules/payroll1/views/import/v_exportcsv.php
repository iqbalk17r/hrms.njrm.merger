<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#tglawal").datepicker(); 
				$("#tglakhir").datepicker(); 	
				$("#tglawal1").datepicker(); 
				$("#tglakhir1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();
				$("#nodokdir").selectize();	
            });
		
</script>

<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
<div class="col-xs-6">
					
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>EXPORT DATA ALL</h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
						<form action="<?php echo site_url('payroll/import/e_csvall')?>" method="post">
										<div class="box box-danger">
											<div class="box-body">
												<div class="form-horizontal">							
												
													
													<div class="form-group">
														 <label class="col-sm-4">Periode Awal</label>
														<div class="col-sm-8">
															
																<input type="text" id="tglawal1" name="tgl_awal" data-date-format="dd-mm-yyyy"  class="form-control" disabled>
															
															<!-- /.input group -->	
														</div>
													</div>
													<div class="form-group">
														 <label class="col-sm-4">Periode Akhir</label>
														<div class="col-sm-8">
															
																<input type="text" id="tglakhir1" name="tgl_akhir" data-date-format="dd-mm-yyyy"  class="form-control" disabled>
															
															<!-- /.input group -->	
														</div>
													</div>
														
												</div>
											</div>													
										</div>
								
							<div> 
								<!--a href="<?php echo site_url('payroll/import/e_csv');?>" type="button" class="btn btn-default"/> Kembali</a--->
								<button type="submit"  class="btn btn-primary">PROSES</button>
							</div>
						</form>
						</div>
							</div>
						</div>
					</div>

  
</div>