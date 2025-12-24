<?php 
/*
	@author : hanif_anak_metal \m/
*/
error_reporting(0);
?>
<script type="text/javascript">
            $(function() {
                $("#tbldept").dataTable();
                $("#tblsubdept").dataTable();
                $("#tbljabt").dataTable();
                $("#tblkantor").dataTable();
				$("#tbloption").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bInfo": true,
                    "bSort": true,
                    "bAutoWidth": false
                });
            });
</script>

<legend><?php echo $title;?></legend>
<?php echo $message;?>
<?php echo validation_errors();?>
<div class="row">
	<div class="col-sm-12">		
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">					
				<li class="active"><a href="#tab_1" data-toggle="tab">Departemen</a></li>
				<li><a href="#tab_2" data-toggle="tab">Sub Departemen</a></li>
				<li><a href="#tab_3" data-toggle="tab">Jabatan</a></li>														
				<li><a href="#tab_4" data-toggle="tab">Kantor</a></li>	
				<li><a href="#tab_5" data-toggle="tab">Option</a></li>
			</ul>
		</div>		
		<div class="tab-content">
			<div class="chart tab-pane active" id="tab_1" style="position: relative; height: 300px;" >								
				<div class="row">
				  <div class="col-sm-12">
					<table id="tbldept" class="table table-bordered table-striped" >
						<thead>
							<tr>																				
								<td width="3%">No</td>
								<td width="5%">Action</td>																																
								<td width="12%">Kode Departemen</td>												
								<td>Departemen</td>								
							</tr>
						</thead>
						<tbody>
							<?php 
							if(empty($list_dept))
								{
									echo "<tr><td colspan=\"4\">Data tidak tersedia</td></tr>";
								} else {
							$no=1;
							foreach ($list_dept as $listdept){ ?>
							<tr>																	
								<td><?php echo $no;?></td>
								<td><a href="#" data-toggle="modal" data-target=".edept<?php echo trim($listdept->kddept);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit">Edit</i></a>
								<!--|<a href="<?php echo site_url('hrd/hrd/hapus_mutasi/');?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Mutasi ini?')"><i class="glyphicon glyphicon-trash"></i></a>-->
								</td>								
								<td><?php echo $listdept->kddept;?></td>
								<td><?php echo $listdept->departement;?></td>								
							</tr>
								<?php $no++;}}?>
						</tbody>
					</table>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
						<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".inputdept">Input Departemen</a>						
						<div class="col-sm-9" style="margin-top: 10px">											
						</div>
						<div class="col-sm-10"></div>
					</div>
					</div>
				</div>
			</div><!-- ./tab 1-->
			<div class="tab-pane" id="tab_2">
				<div class="row">
				  <div class="col-sm-12">
					<table id="tblsubdept" class="table table-bordered table-striped" >
						<thead>
							<tr>						
								<td width="3%">No</td>
								<td width="5%">Action</td>												
								<td width="15%">Kode Subdepartemen</td>												
								<td width="35%">Departemen</td>												
								<td width="35%">Sub Departemen</td>								
							</tr>
						</thead>
						<tbody>
							<?php 
							if(empty($list_subdept))
								{
									echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								} else { $no=1;
							foreach ($list_subdept as $listsubd){?>
							<tr>	
								<td><?php echo $no;?></td>
								<td><a href="#" data-toggle="modal" data-target=".esub<?php echo trim($listsubd->kddept).trim($listsubd->kdsubdept);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit">Edit</i></a>
								<!--|<a href="<?php echo site_url('hrd/hrd/hapus_mutasi/').'/'.trim($listmut->nip).'/'.$listmut->nomor;?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Mutasi ini?')"><i class="glyphicon glyphicon-trash"></i></a>-->
								</td>
								<td><?php echo $listsubd->kdsubdept;?></td>
								<td><?php echo $listsubd->departement;?></td>
								<td><?php echo $listsubd->subdepartement;?></td>								
							</tr>
								<?php $no++;}}?>
						</tbody>
					</table>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
						<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".inputsubdept">Input Sub Departemen</a>						
						<div class="col-sm-9" style="margin-top: 10px">											
						</div>
						<div class="col-sm-10"></div>
					</div>
					</div>
				</div>
			</div>
			<!--Master Jabatan-->
			<div class="tab-pane" id="tab_3">
				<div class="row">
				  <div class="col-sm-12">
					<table id="tbljabt" class="table table-bordered table-striped" >
						<thead>
							<tr>																				
								<td width="3%">No</td>												
								<td width="5%">Action</td>												
								<td>Departemen</td>												
								<td>Sub Departemen</td>
								<td>Kode Jabatan</td>
								<td>Jabatan</td>								
							</tr>
						</thead>
						<tbody>
							<?php
							if(empty($list_jabt))
								{
									echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								} else {
								$no=1;	
							foreach ($list_jabt as $listjab){?>
							<tr>									
								<td><?php echo $no;?></td>
								<td><a href="#" data-toggle="modal" data-target=".ejabt<?php echo trim($listjab->kddept).trim($listjab->kdsubdept).trim($listjab->kdjabatan);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit">Edit</i></a>
								<!--|<a href="<?php echo site_url('hrd/hrd/hapus_keluarga/');?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Keluarga ini?')"><i class="glyphicon glyphicon-trash"></i></a>-->
								</td>								
								<td><?php echo $listjab->departement;?></td>
								<td><?php echo $listjab->subdepartement;?></td>
								<td><?php echo $listjab->kdjabatan;?></td>								
								<td><?php echo $listjab->deskripsi;?></td>												
							</tr>
							<?php $no++; }}?>
						</tbody>
					</table>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
						<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".inputjabt">Input Jabatan</a>						
						<div class="col-sm-9" style="margin-top: 10px">											
						</div>
						<div class="col-sm-10"></div>
					</div>
					</div>
				</div>
			</div>			
			<!--end of master jabatan-->
			
			<!--Master Kantor-->
			<div class="tab-pane" id="tab_4">
				<div class="row">
				  <div class="col-sm-12">
					<table id="tblkantor" class="table table-bordered table-striped" >
						<thead>
							<tr>																				
								<td width="3%">No</td>												
								<td width="5%">Action</td>												
								<td width="10%">Kode Cabang</td>												
								<td>Kantor</td>																																																				
							</tr>
						</thead>
						<tbody>
							<?php
							if(empty($list_kantor))
								{
									echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
								} else {
								$no=1;	
							foreach ($list_kantor as $likan){?>
							<tr>									
								<td><?php echo $no;?></td>
								<td><a href="#" data-toggle="modal" data-target=".ekan<?php echo trim($likan->kodecabang);?>" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
								|<a href="<?php echo site_url('hrd/master_hrd/hapus_kantor/').'/'.trim($likan->kodecabang);?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Kantor <?php echo trim($likan->desc_cabang);?> ini?')"><i class="glyphicon glyphicon-trash"></i></a></td>																
								<td><?php echo $likan->kodecabang;?></td>
								<td><?php echo $likan->desc_cabang;?></td>																			
							</tr>
							<?php $no++; }}?>
						</tbody>
					</table>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target=".inputkantor">Input Kantor</a>						
						<div class="col-sm-9" style="margin-top: 10px">											
						</div>
						<div class="col-sm-10"></div>
					</div>
					</div>
				</div>
			</div>
			
	<!--Master option-->
			<div class="tab-pane" id="tab_5">
				<div class="row">
				<div class="box-header">
					   <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> INPUT</a>
					</div><!-- /.box-header -->	
				  <div class="col-sm-12">
					<table id="tbloption" class="table table-bordered table-striped" >
						<thead>
							<tr>
								<th>No.</th>
								<th>Kode Option</th>
								<th>Deskripsi Option</th>
								<th>Wilayah</th>
								<th>Status</th>
								<th>Group</th>
								<th>Input By</th>
								<th>Aksi</th>
								<th></th>
								</tr>
						</thead>
						<tbody>
							<?php $no=0; foreach($option_absen as $row): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>
									<td> <?php echo $row->kodeopt;?></td>
									<td> <?php echo $row->desc_opt;?></td>
									<td> <?php echo $row->wilayah;?></td>
					
									<td> <?php echo $row->t1;?></td>
									<td> <?php echo $row->group_option;?></td>
									<td><?php echo $row->inputby;?></td>
									<td><a data-toggle="modal" data-target="#<?php echo str_replace(" ","",$row->kodeopt);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
									<td><a href="<?php echo site_url('hrd/master_hrd/hps_jam_absen').'/'.str_replace(" ","",$row->kodeopt);?>" OnClick="return confirm('Anda Yakin Hapus <?php echo 
									str_replace(" ","",$row->kodeopt);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>	
								</tr>
								<?php endforeach;?>
						</tbody>
					</table>
				  </div>
				</div>
	
			</div>
		</div>
	</div>	<!--end of tab_5-->			
		</div>
	</div>	

		
	

	<!--edit dan view Kantor-->
	<?php foreach ($list_kantor as $lk){?>
	<div class="modal fade ekan<?php echo trim($lk->kodecabang);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Edit Data Kantor</h4>
						</div>
						<div class="modal-body">
							<div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#vikan<?php echo trim($lk->kodecabang);?>tab_1" data-toggle="tab">View Data</a></li>
									<li><a href="#edkan<?php echo trim($lk->kodecabang);?>tab_2" data-toggle="tab">Edit Data</a></li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="vikan<?php echo trim($lk->kodecabang);?>tab_1" style="position: relative; height: 100px;">																																									  						
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Kode Cabang</label>
											<div class="col-sm-6">
												<input type="text" name="kddept" class="form-control input-sm" value="<?php echo trim($lk->kodecabang);?>" style="text-transform:uppercase" maxlength="2" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>								
										<div class="form-group">
											<label for="jabtm" class="col-sm-4 control-label">Nama Kantor</label>
											<div class="col-sm-6">
												<input type="text" name="namadept" style="text-transform:uppercase" value="<?php echo $lk->desc_cabang;?>" maxlength="30" class="form-control input-sm" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>										  										
									</div>
									<div class="chart tab-pane" id="edkan<?php echo trim($lk->kodecabang);?>tab_2" style="position: relative; height: 100px;">										
										<form action="<?php echo site_url('hrd/master_hrd/edit_kantor');?>" method="post">										  								  																		  										  								
											<div class="form-group">
												<label for="tujuan" class="col-sm-4 control-label">Kode Cabang</label>
												<div class="col-sm-6">
													<input type="text" name="kdcabang" class="form-control input-sm" style="text-transform:uppercase" value="<?php echo trim($lk->kodecabang);?>" maxlength="2" readonly>
												</div>
												<div class="col-sm-10"></div>
											</div>								
											<div class="form-group">
												<label for="jabtm" class="col-sm-4 control-label">Nama Kantor</label>
												<div class="col-sm-6">
													<input type="text" name="namacabang" style="text-transform:uppercase" maxlength="30" value="<?php echo trim($lk->desc_cabang);?>" class="form-control input-sm" required>
												</div>
												<div class="col-sm-10"></div>
											</div>
											<button onclick="return confirm('Simpan Perubahan Data Kantor ini?')" type="submit" class="btn btn-primary">Simpan</button>
											</form>
									</div>
								</div>
							</div>							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							
						</div>						
					</div>
				  </div>
			</div>
	<?php }?>
	<!--End Edit View Kantor-->
	
	<!--edit dan view departement-->
	<?php foreach ($list_dept as $listdept){?>
	<div class="modal fade edept<?php echo trim($listdept->kddept);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Edit Departemen</h4>
						</div>
						<div class="modal-body">
							<div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#vidept<?php echo trim($listdept->kddept);?>tab_1" data-toggle="tab">View Data</a></li>
									<li><a href="#eddept<?php echo trim($listdept->kddept);?>tab_2" data-toggle="tab">Edit Data</a></li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="vidept<?php echo $listdept->kddept;?>tab_1" style="position: relative; height: 100px;">																																									  						
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Kode Departemen</label>
											<div class="col-sm-6">
												<input type="text" name="kddept" class="form-control input-sm" value="<?php echo $listdept->kddept;?>" style="text-transform:uppercase" maxlength="2" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>								
										<div class="form-group">
											<label for="jabtm" class="col-sm-4 control-label">Nama Departemen</label>
											<div class="col-sm-6">
												<input type="text" name="namadept" style="text-transform:uppercase" value="<?php echo $listdept->departement;?>" maxlength="30" class="form-control input-sm" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>										  										
									</div>
									<div class="chart tab-pane" id="eddept<?php echo trim($listdept->kddept);?>tab_2" style="position: relative; height: 100px;">										
										<form action="<?php echo site_url('hrd/master_hrd/edit_dept');?>" method="post">										  								  								
										  <input type="hidden" name="kodedept" value="<?php echo trim($listdept->kddept);?>">										  								
											<div class="form-group">
												<label for="tujuan" class="col-sm-4 control-label">Kode Departemen</label>
												<div class="col-sm-6">
													<input type="text" name="kddept" class="form-control input-sm" style="text-transform:uppercase" value="<?php echo $listdept->kddept;?>" maxlength="2" readonly>
												</div>
												<div class="col-sm-10"></div>
											</div>								
											<div class="form-group">
												<label for="jabtm" class="col-sm-4 control-label">Nama Departemen</label>
												<div class="col-sm-6">
													<input type="text" name="namadept" style="text-transform:uppercase" maxlength="30" value="<?php echo $listdept->departement;?>" class="form-control input-sm" required>
												</div>
												<div class="col-sm-10"></div>
											</div>
											<button onclick="return confirm('Simpan Perubahan Departemen ini?')" type="submit" class="btn btn-primary">Simpan</button>
											</form>
									</div>
								</div>
							</div>							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							
						</div>						
					</div>
				  </div>
			</div>
	<?php }?>
	<!--End Edit View Departemen-->
	
	<!--edit dan view sub departement-->
	<?php foreach ($list_subdept as $ls){?>
	<div class="modal fade esub<?php echo trim($ls->kddept).trim($ls->kdsubdept);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Edit Sub Departemen</h4>
						</div>
						<div class="modal-body">
							<div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#visub<?php echo trim($ls->kddept).trim($ls->kdsubdept);?>tab_1" data-toggle="tab">View Data</a></li>
									<li><a href="#edsub<?php echo trim($ls->kddept).trim($ls->kdsubdept);?>tab_2" data-toggle="tab">Edit Data</a></li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="visub<?php echo trim($ls->kddept).trim($ls->kdsubdept);?>tab_1" style="position: relative; height: 100px;">																																									  						
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Departemen</label>
											<div class="col-sm-6">
												<input type="text" name="kddept" class="form-control input-sm" value="<?php echo $ls->departement;?>" style="text-transform:uppercase" maxlength="2" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Kode Sub Departemen</label>
											<div class="col-sm-6">
												<input type="text" name="kddept" class="form-control input-sm" value="<?php echo $ls->kdsubdept;?>" style="text-transform:uppercase" maxlength="2" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>								
										<div class="form-group">
											<label for="jabtm" class="col-sm-4 control-label">Nama Sub Departemen</label>
											<div class="col-sm-6">
												<input type="text" name="namadept" style="text-transform:uppercase" value="<?php echo $ls->subdepartement;?>" maxlength="30" class="form-control input-sm" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>										  										
									</div>
									<div class="chart tab-pane" id="edsub<?php echo trim($ls->kddept).trim($ls->kdsubdept);?>tab_2" style="position: relative; height: 100px;">										
										<form action="<?php echo site_url('hrd/master_hrd/edit_subdept');?>" method="post">										  								  								
										  <input type="hidden" name="kodedept" value="<?php echo trim($listdept->kddept);?>">										  								
											<div class="form-group">
												<label for="tujuan" class="col-sm-4 control-label">Departemen</label>
												<div class="col-sm-6">
													<input type="hidden" name="kddept" class="form-control input-sm" style="text-transform:uppercase" value="<?php echo $ls->kddept;?>" maxlength="2" readonly>
													<input type="text" class="form-control input-sm" style="text-transform:uppercase" value="<?php echo $ls->departement;?>" maxlength="2" readonly>
												</div>
												<div class="col-sm-10"></div>
											</div>								
											<div class="form-group">
												<label for="tujuan" class="col-sm-4 control-label">Kode Sub Departemen</label>
												<div class="col-sm-6">
													<input type="text" name="kdsubdept" class="form-control input-sm" style="text-transform:uppercase" value="<?php echo $ls->kdsubdept;?>" readonly>
												</div>
												<div class="col-sm-10"></div>
											</div>								
											<div class="form-group">
												<label for="jabtm" class="col-sm-4 control-label">Nama Sub Departemen</label>
												<div class="col-sm-6">
													<input type="text" name="namasubdept" style="text-transform:uppercase" maxlength="30" value="<?php echo $ls->subdepartement;?>" class="form-control input-sm" required>
												</div>
												<div class="col-sm-10"></div>
											</div>
											<button onclick="return confirm('Simpan Perubahan Sub Departemen ini?')" type="submit" class="btn btn-primary">Simpan</button>
											</form>
									</div>
								</div>
							</div>							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							
						</div>						
					</div>
				  </div>
			</div>
	<?php }?>
	<!--End Edit View Sub Departemen-->
	
	<!--edit dan view Jabatan-->
	<?php foreach ($list_jabt as $lj){?>
	<div class="modal fade ejabt<?php echo trim($lj->kddept).trim($lj->kdsubdept).trim($lj->kdjabatan);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Edit Jabatan</h4>
						</div>
						<div class="modal-body">
							<div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#vijab<?php echo trim($lj->kddept).trim($lj->kdsubdept).trim($lj->kdjabatan);?>tab_1" data-toggle="tab">View Data</a></li>
									<li><a href="#edjab<?php echo trim($lj->kddept).trim($lj->kdsubdept).trim($lj->kdjabatan);?>tab_2" data-toggle="tab">Edit Data</a></li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="vijab<?php echo trim($lj->kddept).trim($lj->kdsubdept).trim($lj->kdjabatan);?>tab_1" style="position: relative; height: 130px;">																																									  						
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Departemen</label>
											<div class="col-sm-6">
												<input type="text" class="form-control input-sm" value="<?php echo $lj->departement;?>" style="text-transform:uppercase" maxlength="2" readonly>
												<input type="hidden" name="kddept" class="form-control input-sm" value="<?php echo $lj->kddept;?>" style="text-transform:uppercase" maxlength="2">
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="tujuan" class="col-sm-4 control-label">Sub Departemen</label>
											<div class="col-sm-6">
												<input type="text" class="form-control input-sm" value="<?php echo $lj->subdepartement;?>" style="text-transform:uppercase" maxlength="2" readonly>
												<input type="hidden" name="kdsubdept" class="form-control input-sm" value="<?php echo $lj->kdsubdept;?>" style="text-transform:uppercase" maxlength="2" >
											</div>
											<div class="col-sm-10"></div>
										</div>								
										<div class="form-group">
											<label for="jabtm" class="col-sm-4 control-label">Kode Jabatan</label>
											<div class="col-sm-6">
												<input type="text" name="kdjabt" style="text-transform:uppercase" value="<?php echo $lj->kdjabatan;?>" maxlength="30" class="form-control input-sm" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>
										<div class="form-group">
											<label for="jabtm" class="col-sm-4 control-label">Nama Jabatan</label>
											<div class="col-sm-6">
												<input type="text" name="namajabt" style="text-transform:uppercase" value="<?php echo $lj->deskripsi;?>" maxlength="30" class="form-control input-sm" readonly>
											</div>
											<div class="col-sm-10"></div>
										</div>	
									</div>
									<div class="chart tab-pane" id="edjab<?php echo trim($lj->kddept).trim($lj->kdsubdept).trim($lj->kdjabatan);?>tab_2" style="position: relative; height: 130px;">										
										<form action="<?php echo site_url('hrd/master_hrd/edit_jabt');?>" method="post">										  								  								
											<input type="hidden" name="kddept" value="<?php echo trim($lj->kddept);?>">										  								
											<input type="hidden" name="kdsubdept" value="<?php echo trim($lj->kdsubdept);?>">										  								
											<input type="hidden" name="kdjabt" value="<?php echo trim($lj->kdjabatan);?>">										  								
											<div class="form-group">
												<label for="tujuan" class="col-sm-4 control-label">Departemen</label>
												<div class="col-sm-6">
													<input type="text" class="form-control input-sm" value="<?php echo $lj->departement;?>" style="text-transform:uppercase" maxlength="2" readonly>
												</div>
												<div class="col-sm-10"></div>
											</div>
											<div class="form-group">
												<label for="tujuan" class="col-sm-4 control-label">Sub Departemen</label>
												<div class="col-sm-6">
													<input type="text" class="form-control input-sm" value="<?php echo $lj->subdepartement;?>" style="text-transform:uppercase" maxlength="2" readonly>
												</div>
												<div class="col-sm-10"></div>
											</div>								
											<div class="form-group">
												<label for="jabtm" class="col-sm-4 control-label">Kode Jabatan</label>
												<div class="col-sm-6">
													<input type="text" style="text-transform:uppercase" value="<?php echo $lj->kdjabatan;?>" maxlength="30" class="form-control input-sm" readonly>
												</div>
												<div class="col-sm-10"></div>
											</div>
											<div class="form-group">
												<label for="jabtm" class="col-sm-4 control-label">Nama Jabatan</label>
												<div class="col-sm-6">
													<input type="text" name="namajabt" style="text-transform:uppercase" value="<?php echo $lj->deskripsi;?>" maxlength="30" class="form-control input-sm" required>
												</div>
												<div class="col-sm-10"></div>
											</div>
											<button onclick="return confirm('Simpan Perubahan Jabatan ini?')" type="submit" class="btn btn-primary">Simpan</button>
											</form>
									</div>
								</div>
							</div>							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							
						</div>						
					</div>
				  </div>
			</div>
	<?php }?>
	<!--End Edit View Jabatan-->
	
	<!--Inputan Modal Departemen-->
			<div class="modal fade inputdept" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Input Departemen</h4>
						</div>
						<div class="modal-body">							
							<div class="row">
							<form action="<?php echo site_url('hrd/master_hrd/input_dept');?>" method="post">							  
							  <div class="col-sm-12">																
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Kode Departemen</label>
									<div class="col-sm-6">
										<input type="text" name="kddept" class="form-control input-sm" style="text-transform:uppercase" maxlength="2" required>
									</div>
									<div class="col-sm-10"></div>
								</div>								
								<div class="form-group">
									<label for="jabtm" class="col-sm-4 control-label">Nama Departemen</label>
									<div class="col-sm-6">
										<input type="text" name="namadept" style="text-transform:uppercase" maxlength="30" class="form-control input-sm" required>
									</div>
									<div class="col-sm-10"></div>
								</div>								
							  </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button onclick="return confirm('Simpan data baru Departemen ini?')" type="submit" class="btn btn-primary">Simpan</button>
						</div>
						</form>
					</div>
				  </div>
			</div>
		
			
		
		
		<!--Input Sub Departemen-->
		<div class="modal fade inputsubdept" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Input Sub Departemen</h4>
						</div>
						<div class="modal-body">
							
							<div class="row">
							<form action="<?php echo site_url('hrd/master_hrd/input_subdept');?>" method="post">							
							  <div class="col-sm-12">								
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Departemen</label>
									<div class="col-sm-6">
									  <select class='form-control input-sm' name="dept" id="dept" required>		
										<option value="">-Pilih Departemen-</option>
										<?php foreach ($list_dept as $ld) {?>
										<option value="<?php echo $ld->kddept;?>"><?php echo $ld->departement;?></option>																				
										<?php }?>
									  </select>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Kode Sub Departemen</label>
									<div class="col-sm-6">									  
										<input type="text" class="form-control input-sm" name="kdsubdept" id="kdsubdept" maxlength="2" style="text-transform:uppercase" required>									  
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Nama Sub Departemen</label>
									<div class="col-sm-6">									  
										<input type="text" class="form-control input-sm" name="subdept" id="subdept" style="text-transform:uppercase" required>									  
									</div>
									<div class="col-sm-10"></div>
								</div>										
							  </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button onclick="return confirm('Simpan data Sub Departemen ini?')" type="submit" class="btn btn-primary">Simpan</button>
						</div>
						</form>
					</div>
				  </div>
		</div>
		
		<!--Input input jabatan-->
		<script type="text/javascript" charset="utf-8">
				  $(function() {	
					$("#csubdept").chained("#cdept");		
				  });
		</script>
		<div class="modal fade inputjabt" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Input Jabatan</h4>
						</div>
						<div class="modal-body">							
							<div class="row">
							<form action="<?php echo site_url('hrd/master_hrd/input_jabt');?>" method="post">							
							  <div class="col-sm-12">								
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Departemen</label>
									<div class="col-sm-6">
									  <select class='form-control input-sm' name="dept" id="cdept" required>		
										<option value="">-Pilih Departemen-</option>
										<?php foreach ($list_dept as $ld) {?>
										<option value="<?php echo $ld->kddept;?>"><?php echo $ld->departement;?></option>																				
										<?php }?>
									  </select>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Sub Departemen</label>
									<div class="col-sm-6">
									  <select class='form-control input-sm' name="subdept" id="csubdept" required>		
										<option value="">-Pilih Sub Departemen-</option>
										<?php foreach ($list_subdept as $ls) {?>
										<option value="<?php echo $ls->kdsubdept;?>" class="<?php echo $ls->kddept;?>"><?php echo $ls->subdepartement;?></option>																				
										<?php }?>
									  </select>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Kode Jabatan</label>
									<div class="col-sm-6">									  
										<input type="text" class="form-control input-sm" name="kdjabt" id="kdsubdept" maxlength="2" style="text-transform:uppercase" required>									  
									</div>
									<div class="col-sm-10"></div>
								</div>
								<!--
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Level Jabatan</label>
									<div class="col-sm-6">									  
										<select class="form-control input-sm" name="lvljabt" required>
											<>
											<option value="A">Direksi</option>
											<option value="B">Manager</option>
											<option value="C">Supervisor</option>
											<option value="D">Staff</option>											
										</select>
									</div>
									<div class="col-sm-10"></div>
								</div>
								-->
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Nama Jabatan</label>
									<div class="col-sm-6">									  
										<input type="text" class="form-control input-sm" name="jabt"  style="text-transform:uppercase" required>									  
									</div>
									<div class="col-sm-10"></div>
								</div>										
							  </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button onclick="return confirm('Simpan data Jabatan ini?')" type="submit" class="btn btn-primary">Simpan</button>
						</div>
						</form>
					</div>
				  </div>
		</div>
		
		<!--Inputan Modal Kantor-->
			<div class="modal fade inputkantor" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Input Kantor</h4>
						</div>
						<div class="modal-body">							
							<div class="row">
							<form action="<?php echo site_url('hrd/master_hrd/input_kantor');?>" method="post">							  
							  <div class="col-sm-12">																
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Kode Kantor</label>
									<div class="col-sm-6">
										<input type="text" name="kdkantor" class="form-control input-sm" style="text-transform:uppercase" maxlength="6" required>
									</div>
									<div class="col-sm-10"></div>
								</div>								
								<div class="form-group">
									<label for="jabtm" class="col-sm-4 control-label">Nama Kantor</label>
									<div class="col-sm-6">
										<input type="text" name="namakantor" style="text-transform:uppercase" maxlength="30" class="form-control input-sm" required>
									</div>
									<div class="col-sm-10"></div>
								</div>								
							  </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button onclick="return confirm('Simpan data baru Kantor ini?')" type="submit" class="btn btn-primary">Simpan</button>
						</div>
						</form>
					</div>
				  </div>
			</div>
	<!--input option absen--> 
	<div class="modal fade" id="myModal" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Input Master Option</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('hrd/master_hrd/add_jam_absen');?>" method="post">
			<div class="form-group">
							<label for="inputkode" class="col-sm-2 control-label">Kode Option</label>
							<div class="col-sm-6">
								<input type="text" class="form-control"  placeholder="FORMAT SINGKAT" name="kodeopt" id="kodeopt" style="text-transform:uppercase" required>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group">
							<label for="inputjenis" class="col-sm-2 control-label">Deskrisi Option</label>
							<div class="col-sm-6">
								<textarea input type="text" class="form-control"  row="3" name="desc_opt" id="desc_opt" style="text-transform:uppercase" required></textarea>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group">
					<label for="inputstatusrmh" class="col-sm-2 control-label">Kantor wilayah</label>
					<div class="col-sm-10">
						<select class="form-control input-sm" name="kantorcabang" id="statusrmh" required>
						  <option value="NAS">NATIONAL</option>
						  <?php foreach($list_kantor_option as $listkan){?>
						  <option value="<?php echo $listkan->kodecabang;?>" ><?php echo $listkan->desc_cabang;?></option>						  
						  <?php }?>
						</select>
					</div>
					<div class="col-sm-11"></div>
				</div>	
				<div class="form-group">
					<label for="inputgroup" class="col-sm-2 control-label">Group</label>
					<div class="col-sm-10">
						<select class="form-control input-sm" name="group" id="group" required>
						  <option value="absen">ABSEN</option>
						  <option value="cuti">CUTI</option>
						  <option value="reminder">REMINDER</option>
						</select>
					</div>
					<div class="col-sm-11"></div>
				</div>	
				<div class="form-group">
						<input name="aktif" type="checkbox" value="t" />
						Aktif</label>
						<label>	
				</div>
						<div class="form-group">
							<label for="inputby" class="col-sm-2 control-label">Diinput oleh</label>
							<div class="col-sm-6">
							  <input type="text" value="<?php echo $this->session->userdata('username');?>" name="input" id="input" class="form-control" readonly />
							</div>
						<div class="col-sm-11"></div>	
						</div>
			
		</div>
		<div class="modal-footer">
			<div class="form-group"> 
				<div class="col-sm-2 control-label">
					<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
				   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
				</div>
			</div>
		</div>
		</form>
  </div>
</div>
</div> 

<!-- Modal Edit Option Absen -->
<?php foreach ($option_absen as $oa){?>
	<div class="modal fade" id="<?php echo str_replace(" ","",$oa->kodeopt);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit Master Option</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('hrd/master_hrd/edit_jam_absen');?>" method="post">
			<div class="form-group">
							<label for="inputkode" class="col-sm-2 control-label">Kode Option</label>
							<div class="col-sm-6">
								<input type="text" class="form-control"  name="kodeopt" id="kodeopt" value="<?php echo $oa->kodeopt;?>" readonly>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group">
							<label for="inputjenis" class="col-sm-2 control-label">Deskrisi Option</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="desc_opt" id="desc_opt"  value="<?php echo $oa->desc_opt;?>" style="text-transform:uppercase">
							</div>
							<div class="col-sm-11"></div>
						</div>
		
						
						<div class="form-group">
					<label for="inputstatusrmh" class="col-sm-2 control-label">Kantor wilayah</label>
					<div class="col-sm-10">
						<select class="form-control input-sm" name="kantorcabang" id="statusrmh" required>
							<option value="NAS" >NATIONAL</option>
						  <?php foreach($list_kantor_option as $listkan){?>
						  <option value="<?php echo $listkan->kodecabang;?>" ><?php echo $listkan->desc_cabang;?></option>						  
						  <?php }?>
						</select>
					</div>
					<div class="col-sm-11"></div>
				</div>	
				<div class="form-group">
					<label for="inputgroup" class="col-sm-2 control-label">Group</label>
					<div class="col-sm-10">
						<select class="form-control input-sm" name="group" id="group" required>
						  <option value="absen">ABSEN</option>
						  <option value="cuti">CUTI</option>
						  <option value="reminder">REMINDER</option>
						</select>
					</div>
					<div class="col-sm-11"></div>
				</div>	
				<div class="form-group">
						
						<input name="aktif" type="checkbox" value="t"
						<?php if ($oa->status=='t') { echo 'checked';}?>/>
						Aktif</label>
						<label>
							
				</div>
				<div class="form-group">
					<label for="inputby" class="col-sm-2 control-label">Diinput oleh</label>
					<div class="col-sm-6">
					<input type="text" value="<?php echo $this->session->userdata('username');?>" name="input" id="input" class="form-control" readonly/>
					</div>
					<div class="col-sm-11"></div>	
				</div>
			
		</div>
		<div class="modal-footer">
			<div class="form-group"> 
				<div class="col-sm-2 control-label">
					<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
				   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
				</div>
			</div>
		</div>
		</form>
  </div>
</div>
</div>  
<?php } ?> 
			
</div>

<script>
	//Date picker
    $('#tanggal').datepicker();
    $('#tglmutasi').datepicker();
    $('#inputkeluarga').datepicker();
	$('#masuk').datepicker();
	$('#stskrjmulai').datepicker();
	$('#stskrjakhir').datepicker();
	$('#tglm').datepicker();
	$('#keluar').datepicker();
	$('#berlaku').daterangepicker();
	$("[data-mask]").inputmask();

</script>