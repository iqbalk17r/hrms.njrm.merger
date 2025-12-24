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
						<form action="<?php echo site_url('master/import/e_csvall')?>" method="post">
										<div class="box box-danger">
											<div class="box-body">
												<div class="form-horizontal">							
												
													
													<div class="form-group">
														 <label class="col-sm-4">Periode Awal</label>
														<div class="col-sm-8">
															
																<input type="text" id="tglawal1" name="tgl_awal" data-date-format="dd-mm-yyyy"  class="form-control">
															
															<!-- /.input group -->	
														</div>
													</div>
													<div class="form-group">
														 <label class="col-sm-4">Periode Akhir</label>
														<div class="col-sm-8">
															
																<input type="text" id="tglakhir1" name="tgl_akhir" data-date-format="dd-mm-yyyy"  class="form-control">
															
															<!-- /.input group -->	
														</div>
													</div>
														
												</div>
											</div>													
										</div>
								
							<div> 
								<a href="<?php echo site_url('master/e_csv');?>" type="button" class="btn btn-default"/> Kembali</a>
								<button type="submit"  class="btn btn-primary">PROSES</button>
							</div>
						</form>
						</div>
							</div>
						</div>
					</div>

                    <div class="col-xs-6">
				
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>EXPORT DATA LIST</h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
						<form action="<?php echo site_url('master/import/e_csv_detailcsv')?>" method="post">
										<div class="box box-danger">
											<div class="box-body">
												<div class="form-horizontal">							
												
													<div class="form-group">
														<label class="col-sm-4">PILIH KIRIM DATA</label>	
														<div class="col-sm-8">    
															<select class="form-control input-sm" name="nodokdir1" id="nodokdir" required>
															<option value="">--Cari Data Transaksi--</option>
															<?php foreach ($li_dir as $ld) { ?>
															<!--option value="<?php echo trim($ld->nodok); ?>"><?php echo trim($lk->nmlengkap).' || '.trim($lk->nik); ?></option--->
															<option value="<?php echo trim($ld->nodok); ?>" class="<?php echo trim($ld->nodok);?>"><?php echo trim($ld->nmlisting); ?></option>
															<?php } ?>
															</select>
														</div>
													</div>

													<script type="text/javascript">
														$(function() {                         
															//$("#tglmulai").datepicker();                               
															//$("#tglselesai").datepicker(); 
																							
														});
														
													</script>
											<script type="text/javascript" charset="utf-8">
													  $(function() {
												
													$("#tgl_awal1").chained("#docref1");
													$("#tgl_akhir1").chained("#docref1");
													$("#dirlist1").chained("#nodokdir");
												
												
													  });
											</script>
													<div class="form-group">
														 <label class="col-sm-4">Periode Awal</label>
														<div class="col-sm-8">
															
																<input type="text" id="tglawal" name="tgl_awal" data-date-format="dd-mm-yyyy"  class="form-control">
															
															<!-- /.input group -->	
														</div>
													</div>
													<div class="form-group">
														 <label class="col-sm-4">Periode Akhir</label>
														<div class="col-sm-8">
															
																<input type="text" id="tglakhir" name="tgl_akhir" data-date-format="dd-mm-yyyy"  class="form-control">
															
															<!-- /.input group -->	
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4">Dir Listing</label>	
														<div class="col-sm-8">    
															<!--input type="text" id="tglmulai" name="tgl_awal" data-date-format="dd-mm-yyyy"  class="form-control" required disabled-->
															<select class="form-control input-sm" name="dirlist" id="dirlist1" disabled readonly>
															<?php foreach ($li_dir as $ld) { ?>
															<!--option value="<?php echo trim($lcb->jumlahcuti);?>" class="<?php echo trim($lcb->nodok);?>"><?php echo trim($lcb->jumlahcuti);?></option-->
															<option value="<?php echo trim($ld->dir_list); ?>" class="<?php echo trim($ld->nodok);?>"><?php echo trim($ld->dir_list); ?></option>
															<?php } ?>
															</select>
														</div>	
													</div>
													<!--div class="form-group">
														 <label class="col-sm-4">Tanggal Input</label>
														<div class="col-sm-8">
															
																<input type="text" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
															
														</div>
													</div>
													<div class="form-group">
														 <label class="col-sm-4">Input By</label>
														<div class="col-sm-8">
														
																<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4">Keterangan</label>	
														<div class="col-sm-8">    
															<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
															<input type="hidden" id="tgl1" name="tgl_dok"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
															<input type="hidden" id="doctype1" name="doctype" value="Y" class="form-control" readonly>
														</div>
													</div-->		
												</div>
											</div>													
										</div>
								
							<div> 
								<a href="<?php echo site_url('master/e_csv');?>" type="button" class="btn btn-default"/> Kembali</a>
								<button type="submit"  class="btn btn-primary">PROSES</button>
							</div>
						</form>
						</div>
							</div>
						</div>
					</div>
</div>