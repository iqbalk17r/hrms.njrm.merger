
<script>

  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgl').datepicker();
    $('#example1').dataTable();
	$('#nikatasan').selectize();
  

</script>

<legend><?php echo $title;?></legend>
<?php echo $message; ?>
				<div class="row">
                    <div class="col-xs-12">
						<div class="box">
							<div class="box-header">
					   <button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> INPUT</a>
					</div><!-- /.box-header -->	
                            <div class="box-body" style='overflow-x:scroll;'>
								<table id="example1" class="table table-striped table-bordered success">
                                    <thead>
										<tr>											
											<th>No.</th>
											<th>Kode Option</th>
											<th>Nama Option</th>
											<th>Hari Aktif</th>
											<th>Hari Libur</th>
											<th>Kondisi Activ 1</th>	
											<th>Kondisi Activ 2</th>
											<th>Max Week</th>
											<th>Ritme 1</th>
											<th>Ritme 2</th>
											<th>Ritme 3</th>
											<th>SF 1 All</th>
											<th>SF 1 Jumat</th>
											<th>SF 1 Sabtu</th>
											<th>SF 2 All</th>
											<th>SF 2 Jumat</th>
											<th>SF 2 Sabtu</th>
											<th>SF 3 All</th>
											<th>SF 3 Jumat</th>
											<th>SF 3 Sabtu</th>
											<th>Operator</th>	
											<th>Action</th>	
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_settemp as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->kd_opt;?></td>
									<td><?php echo $row->nm_opt;?></td>
									<td><?php echo $row->hr_aktif;?></td>
									<td><?php echo $row->hr_libur;?></td>
									<td><?php echo $row->kon_1;?></td>
									<td><?php echo $row->kon_2;?></td>
									<td><?php echo $row->maxweek;?></td>
									<td><?php echo $row->ritme_1;?></td>
									<td><?php echo $row->ritme_2;?></td>
									<td><?php echo $row->ritme_3;?></td>
									<td><?php echo $row->sf1_all;?></td>
									<td><?php echo $row->sf1_jumat;?></td>
									<td><?php echo $row->sf1_sabtu;?></td>
									<td><?php echo $row->sf2_all;?></td>
									<td><?php echo $row->sf2_jumat;?></td>
									<td><?php echo $row->sf2_sabtu;?></td>
									<td><?php echo $row->sf3_all;?></td>
									<td><?php echo $row->sf3_jumat;?></td>
									<td><?php echo $row->sf3_sabtu;?></td>									
									<td><?php echo $row->operatorlist;?></td>									
									<td width="500">
									<a href="<?php echo site_url('master/setupabsen/view_edit').'/'.$row->kd_opt;?>" OnClick="return confirm('Anda Yakin Edit ?')" class="btn btn-primary">Edit</a>	
									<a href="<?php echo site_url('master/setupabsen/del_setup').'/'.$row->kd_opt;?>" OnClick="return confirm('Anda Yakin Hapus ?')" class="btn btn-danger">Hapus</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input mesin -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg-12">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT TEMPLATE JADWAL KERJA</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/setupabsen/add_setup');?>" method="post">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						 <label class="col-sm-12">Kode Option</label>
						<div class="col-sm-12">
							
								<input type="text" id="kdopt" name="kdopt"  class="form-control" style="text-transform:uppercase" maxlength="6" required>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Nama Option</label>
						<div class="col-sm-12">

								<input type="text" id="nmopt" name="nmopt"  maxlength="40" style="text-transform:uppercase" class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Hari Aktif</label>
						<div class="col-sm-12">

								<input type="number" id="hraktif" name="hraktif"  maxlength="2" class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>			
					<div class="form-group">
						 <label class="col-sm-12">Hari Libur</label>
						<div class="col-sm-12">

								<input type="number" id="hrlibur" name="hrlibur"  maxlength="2" class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kondisi 1</label>
						<div class="col-sm-12">

								<input type="number" id="kondisi_1" name="kondisi_1"  maxlength="5"  class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kondisi 2</label>
						<div class="col-sm-12">

								<input type="number" id="kondisi_2" name="kondisi_2"  maxlength="5" class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Max Week</label>
						<div class="col-sm-12">

								<input type="number" id="maxweek" name="maxweek"  maxlength="5"  class="form-control" required>
							
							<!-- /.input group -->
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Ritme 1</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="ritme_1" id="ritme_1" required>
									 <option value="">--Ritme Awal--</option> 
									 <option value="3">3</option> 
									 <option value="2">2</option> 
									 <option value="1">1</option> 
							</select>
						</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Ritme 2</label>
						 <div class="col-sm-12">
							<select class="form-control input-sm" name="ritme_2" id="ritme_2">
										 <option value="">--Ritme Kedua--</option> 
										 <option value="3">3</option> 
										 <option value="2">2</option> 
										 <option value="1">1</option> 
							</select>
						</div>	
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Ritme 3</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="ritme_3" id="ritme_3">
									 <option value="">--Ritme Ketiga--</option> 
									 <option value="3">3</option> 
									 <option value="2">2</option> 
									 <option value="1">1</option> 
							</select>
						</div>
					</div>			

					<div class="form-group">
						 <label class="col-sm-12">Tanggal Input</label>
						<div class="col-sm-12">
							
								<input type="text" id="tglinput" name="tglinput"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
							
							<!-- /.input group -->
						</div>
					</div>
				
				</div>	
				<div class="col-sm-6">
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 1 All</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf1_all" id="sf1_all" >
									  <option value="">--PILIH JAM KERJA SHIFT 1--</option>
									  <?php foreach($list_sf1 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>" ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 1 Jumat</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf1_jumat" id="sf1_jumat" >
									  <option value="">--PILIH JAM KERJA SHIFT 1--</option>
									  <?php foreach($list_sf1 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>" ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 1 Sabtu</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf1_sabtu" id="sf1_sabtu" >
									  <option value="">--PILIH JAM KERJA SHIFT 1--</option>
									  <?php foreach($list_sf1 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>" ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>			
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 2 All</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf2_all" id="sf2_all" >
									  <option value="">--PILIH JAM KERJA SHIFT 2--</option>
									  <?php foreach($list_sf2 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>" ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 2 Jumat</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf2_jumat" id="sf2_jumat" >
									  <option value="">--PILIH JAM KERJA SHIFT 2--</option>
									  <?php foreach($list_sf2 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>" ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 2 Sabtu</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf2_sabtu" id="sf2_sabtu" >
									  <option value="">--PILIH JAM KERJA SHIFT 2--</option>
									  <?php foreach($list_sf2 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>" ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 3 All</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf3_all" id="sf3_all" >
									  <option value="">--PILIH JAM KERJA SHIFT 3--</option>
									  <?php foreach($list_sf3 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>" ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 3 Jumat</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf3_jumat" id="sf3_jumat" >
									  <option value="">--PILIH JAM KERJA SHIFT 3--</option>
									  <?php foreach($list_sf3 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>" ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Kode Jam Shift 3 Sabtu</label>
								<div class="col-sm-12">    
									<select class="form-control input-sm" name="sf3_sabtu" id="sf3_sabtu" >
									  <option value="">--PILIH JAM KERJA SHIFT 3--</option>
									  <?php foreach($list_sf3 as $ls){ ?>
									  <option value="<?php echo trim($ls->kdjam_kerja);?>" ><?php echo $ls->kdjam_kerja;?></option>						  
									  <?php }?>
									</select>
								</div>
					</div>
					<div class="form-group">
						 <label class="col-sm-12">Operator Ritme</label>
						<div class="col-sm-12">
							<select class="form-control input-sm" name="operatorlist" id="operatorlist" required="required">
									 <option value="">--Operator Ritme--</option> 
									 <option value="+">+</option> 
									 <option value="-">-</option> 
							</select>
						</div>
					</div>			
					<!--div class="form-group">
						 <label class="col-sm-12">Keterangan</label>
						<div class="col-sm-12">

								<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
						
						</div>
					</div-->
					<div class="form-group">
						 <label class="col-sm-12">Input By</label>
						<div class="col-sm-12">
						
								<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

							<!-- /.input group -->
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group"> 
					<div class="col-lg-12">
						<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
					</div>
				</div>
			</div>
			</div>
		</form>
  </div>
</div>
</div>  
</div>
