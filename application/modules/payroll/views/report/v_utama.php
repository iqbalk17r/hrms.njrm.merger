<legend><?php echo $title;?></legend>
		
				<div class="row">
                    
					<div class="col-sm-12">
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>Master Report</h4>
								</div>
							</div>
						<div class="box-body table-responsive" style='overflow-x:scroll;'>
							<table id="example2" class="table table-bordered table-striped" >
								<thead>
									<tr>
										<th>No.</th>																		
										<th>Jenis</th>										
										<th>Deskripsi Jenis</th>													
									</tr>
								</thead>
								<tbody>
										<?php $no=0; foreach($list_master as $lu): $no++;?>
										<tr>										
											<td width="2%"><?php echo $no;?></td>																							
											<td><a href="#" data-toggle="modal" data-target="#dtl<?php echo trim($lu->idrpt);?>"><?php echo $lu->jenis; ?></a></td>
											<td><?php echo $lu->desc_jenis;?></td>
										
										</tr>
										<?php endforeach;?>
								</tbody>
							</table>
						</div><!-- /.box-body -->
						</div>
					</div>
				</div>
						<div class="modal fade" id="dtl1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  <div class="modal-dialog modal-md">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Filter Laporan Karyawan Keluar</h4>
								  </div>
                            <div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/show_karout');?>" name="form" role="form" method="post">										
										
										<div class="form-group">
											 <label class="label-form col-sm-3">Periode</label>
											<div class="col-sm-9">
												
													<select class="form-control input-sm" name='bulan'>
									
													<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
													<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
													<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
													<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
													<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
													<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
													<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
													<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
													<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
													<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
													<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
													<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
													</select>
												
											</div>
										</div>
										<div class="form-group ">		
											<label class="label-form col-sm-3">Tahun</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name="tahun">
													<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
													<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
													<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
												</select>
											</div>			
										</div>
										<!--
										<div class="form-group ">		
											<label class="label-form col-sm-3">Department/Bagian</label>
											<div class="col-sm-9">
												<select id="dept" class="form-control input-sm" name="kddept" required>
													<option value="">--PILIH DEPARTMENT--</option>
													<?php foreach ($list_dept as $ld){ ?>
													<option value='<?php echo trim($ld->kddept); ?>'><?php  echo $ld->nmdept; ?></option>
													<?php } ?>					
												</select>
											</div>			
										</div>-->
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
					<div class="modal fade" id="dtl2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  <div class="modal-dialog modal-md">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Filter Laporan Karyawan Masuk</h4>
								  </div>
                            <div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/show_karin');?>" name="form" role="form" method="post">										
										
										<div class="form-group">
											 <label class="label-form col-sm-3">Periode</label>
											<div class="col-sm-9">
												
													<select class="form-control input-sm" name='bulan'>
									
													<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
													<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
													<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
													<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
													<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
													<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
													<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
													<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
													<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
													<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
													<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
													<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
													</select>
												
											</div>
										</div>
										<div class="form-group ">		
											<label class="label-form col-sm-3">Tahun</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name="tahun">
													<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
													<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
													<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
												</select>
											</div>			
										</div>
										<!--
										<div class="form-group ">		
											<label class="label-form col-sm-3">Department/Bagian</label>
											<div class="col-sm-9">
												<select id="dept" class="form-control input-sm" name="kddept" required>
													<option value="">--PILIH DEPARTMENT--</option>
													<?php foreach ($list_dept as $ld){ ?>
													<option value='<?php echo trim($ld->kddept); ?>'><?php  echo $ld->nmdept; ?></option>
													<?php } ?>					
												</select>
											</div>			
										</div>-->
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
				<div class="modal fade" id="dtl3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-md">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Filter Laporan Presensi Karyawan</h4>
						  </div>
						<div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/show_transready');?>" name="form" role="form" method="post">										
										<!--area-->
										<div class="form-group">
											 <label class="col-lg-3">Nama Karyawan</label>
											<div class="col-lg-9">
												<select id="pilihkaryawan" name="nik" required>
												<option value="">--Pilih Karyawan--</option>
												<?php foreach ($list_karyawan as $ld){ ?>
												<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nik.' || '.$ld->nmlengkap;?></option>
												<?php } ?>																																					
											</select>
											</div>
										</div>
										<div class="form-group">
											 <label class="label-form col-sm-3">Periode</label>
											<div class="col-sm-9">
												
												<input type="text" name="tgl" id="tgl" class="form-control">
												
											</div>
										</div>
										<div class="form-group">
											 <label class="col-lg-3">Keterangan</label>
											<div class="col-lg-9">
												<select id="joss" name="ketsts" class="form-control input-group" >
												<option value="">--ALL--</option>
												<option value="TIDAK MASUK KERJA">TIDAK MASUK KERJA</option>
												<option value="TERLAMBAT">TERLAMBAT</option>																																				
											</select>
											</div>
										</div>		
										<!--<div class="form-group ">		
											<label class="label-form col-sm-3">Department/Bagian</label>
											<div class="col-sm-9">
												<select id="dept" class="form-control input-sm" name="kddept" required>
													<option value="">--PILIH DEPARTMENT--</option>
													<?php foreach ($list_dept as $ld){ ?>
													<option value='<?php echo trim($ld->kddept); ?>'><?php  echo $ld->nmdept; ?></option>
													<?php } ?>					
												</select>
											</div>			
										</div>-->
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
				<div class="modal fade" id="dtl4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-md">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Filter Laporan Presensi Department</h4>
						  </div>
						<div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/show_transreadydept');?>" name="form" role="form" method="post">										
										<!--area-->
										<div class="form-group ">		
											<label class="label-form col-sm-3">Department/Bagian</label>
											<div class="col-sm-9">
												<select id="dept" class="form-control input-sm" name="kddept" required>
													<option value="">--PILIH DEPARTMENT--</option>
													<?php foreach ($list_dept as $ld){ ?>
													<option value='<?php echo trim($ld->kddept); ?>'><?php  echo $ld->nmdept; ?></option>
													<?php } ?>					
												</select>
											</div>			
										</div>
										<div class="form-group">
											 <label class="label-form col-sm-3">Periode</label>
											<div class="col-sm-9">
												
												<input type="text" name="tgl" id="tgl3" class="form-control">
												
											</div>
										</div>
										<div class="form-group">
											 <label class="col-lg-3">Keterangan</label>
											<div class="col-lg-9">
												<select id="joss" name="ketsts" class="form-control input-group" >
												<option value="">--ALL--</option>
												<option value="TIDAK MASUK KERJA">TIDAK MASUK KERJA</option>
												<option value="TERLAMBAT">TERLAMBAT</option>																																				
											</select>
											</div>
										</div>
										
										<!--<div class="form-group ">		
											<label class="label-form col-sm-3">Department/Bagian</label>
											<div class="col-sm-9">
												<select id="dept" class="form-control input-sm" name="kddept" required>
													<option value="">--PILIH DEPARTMENT--</option>
													<?php foreach ($list_dept as $ld){ ?>
													<option value='<?php echo trim($ld->kddept); ?>'><?php  echo $ld->nmdept; ?></option>
													<?php } ?>					
												</select>
											</div>			
										</div>-->
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
				<div class="modal fade" id="dtl5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-md">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Filter Laporan Absensi (Dari Mesin)</h4>
						  </div>
						<div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/show_checkinout');?>" name="form" role="form" method="post">										
										<!--area-->
										<!--<div class="form-group">
											 <label class="col-lg-3">Nama Karyawan</label>
											<div class="col-lg-9">
												<select id="pilihkaryawan2" name="nik" required>
												<option value="">--Pilih Karyawan--</option>
												<?php foreach ($list_karyawan as $ld){ ?>
												<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nik.' || '.$ld->nmlengkap;?></option>
												<?php } ?>																																					
											</select>
											</div>
										</div>-->
										<div class="form-group">
											 <label class="label-form col-sm-3">Periode</label>
											<div class="col-sm-9">
												
												<input type="text" name="tgl" id="tgl4" class="form-control">
												
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
				<div class="modal fade" id="dtl6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-md">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Filter Laporan Presensi Bulanan</h4>
						  </div>
						<div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/show_report_absensi');?>" name="form" role="form" method="post">										
										<!--area-->
										<!--<div class="form-group">
											 <label class="col-lg-3">Nama Karyawan</label>
											<div class="col-lg-9">
												<select id="pilihkaryawan2" name="nik" required>
												<option value="">--Pilih Karyawan--</option>
												<?php foreach ($list_karyawan as $ld){ ?>
												<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nik.' || '.$ld->nmlengkap;?></option>
												<?php } ?>																																					
											</select>
											</div>
										</div>-->
									<div class="form-group">
											<label class="label-form col-sm-3">Bulan</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name='bln' required>
													
													<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
													<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
													<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
													<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
													<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
													<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
													<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
													<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
													<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
													<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
													<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
													<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="label-form col-sm-3">Tahun</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name="thn" required>
													<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
													<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
													<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
												</select>
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
				<div class="modal fade" id="dtl7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-md">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Filter Laporan Payroll Tahunan</h4>
						  </div>
						<div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/show_payrollsetahun');?>" name="form" role="form" method="post">										
										<!--area-->
										<!--<div class="form-group">
											 <label class="col-lg-3">Nama Karyawan</label>
											<div class="col-lg-9">
												<select id="pilihkaryawan2" name="nik" required>
												<option value="">--Pilih Karyawan--</option>
												<?php foreach ($list_karyawan as $ld){ ?>
												<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nik.' || '.$ld->nmlengkap;?></option>
												<?php } ?>																																					
											</select>
											</div>
										</div>-->
								
										<div class="form-group ">		
											<label class="label-form col-sm-3">Tahun</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name="tahun">
													<option value='<?php $tgl=date('y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
												</select>
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
				<div class="modal fade" id="dtl8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-md">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Filter Laporan Payroll Tahunan Per Karyawan</h4>
						  </div>
						<div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/show_detail_payrollnik');?>" name="form" role="form" method="post">										
										<!--area-->
										<div class="form-group">
											 <label class="col-lg-3">Nama Karyawan</label>
											<div class="col-lg-9">
												<select id="pilihkaryawan3" name="nik" required>
												<option value="">--Pilih Karyawan--</option>
												<?php foreach ($list_karyawan as $ld){ ?>
												<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nik.' || '.$ld->nmlengkap;?></option>
												<?php } ?>																																					
											</select>
											</div>
										</div>
								
										<div class="form-group ">		
											<label class="label-form col-sm-3">Tahun</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name="tahun">
													<option value='<?php $tgl=date('y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
												</select>
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
				<div class="modal fade" id="dtl9" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-md">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Filter Laporan Detail Payroll Bulanan</h4>
						  </div>
						<div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/show_report_detail');?>" name="form" role="form" method="post">										
										<!--area-->
										<div class="form-group ">		
											<label class="label-form col-sm-3">Tahun</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name="tahun">
													<option value='<?php $tgl=date('y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
												</select>
											</div>			
										</div>
										<div class="form-group">
											<label class="label-form col-sm-3">Bulan</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name='bulan' required>
													
													<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
													<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
													<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
													<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
													<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
													<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
													<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
													<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
													<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
													<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
													<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
													<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
												</select>
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
				<div class="modal fade" id="dtl10" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-md">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Filter Slip Gaji</h4>
						  </div>
						<div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/pdf_slipgaji');?>" name="form" role="form" method="post">										
										<!--area-->
										<div class="form-group">
											 <label class="col-lg-3">Nama Karyawan</label>
											<div class="col-lg-9">
												<select id="pilihkaryawan2" name="nik" required>
												<option value="">--Pilih Karyawan--</option>
												<?php foreach ($list_karyawan as $ld){ ?>
												<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nik.' || '.$ld->nmlengkap;?></option>
												<?php } ?>																																					
											</select>
											</div>
										</div>
										
										<div class="form-group ">		
											<label class="label-form col-sm-3">Tahun</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name="tahun">
													<option value='<?php $tgl=date('y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
												</select>
											</div>			
										</div>
										<div class="form-group">
											<label class="label-form col-sm-3">Bulan</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name='bulan' required>
													
													<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
													<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
													<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
													<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
													<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
													<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
													<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
													<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
													<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
													<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
													<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
													<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
												</select>
											</div>
										</div>
										<!--
										<div class="form-group ">		
											<label class="label-form col-sm-3">Department/Bagian</label>
											<div class="col-sm-9">
												<select id="dept" class="form-control input-sm" name="kddept" required>
													<option value="">--PILIH DEPARTMENT--</option>
													<?php foreach ($list_dept as $ld){ ?>
													<option value='<?php echo trim($ld->kddept); ?>'><?php  echo $ld->nmdept; ?></option>
													<?php } ?>					
												</select>
											</div>			
										</div>-->
										<div class="form-group"> 
											<div class="col-lg-4">
												<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-download"></i> Download</button>
											   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="dtl11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-md">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Filter Detail PPH Bulanan Semua Karyawan</h4>
						  </div>
						<div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/show_pphdetailbulanan');?>" name="form" role="form" method="post">										
										
										
										
										<div class="form-group ">		
											<label class="label-form col-sm-3">Tahun</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name="tahun">
													<option value='<?php $tgl=date('y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
												</select>
											</div>			
										</div>
										<div class="form-group">
											<label class="label-form col-sm-3">Bulan</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name='bulan' required>
													
													<option value="1" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
													<option value="2" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
													<option value="3" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
													<option value="4" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
													<option value="5" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
													<option value="6" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
													<option value="7" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
													<option value="8" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
													<option value="9" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
													<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
													<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
													<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
												</select>
											</div>
										</div>
										<!--
										<div class="form-group ">		
											<label class="label-form col-sm-3">Department/Bagian</label>
											<div class="col-sm-9">
												<select id="dept" class="form-control input-sm" name="kddept" required>
													<option value="">--PILIH DEPARTMENT--</option>
													<?php foreach ($list_dept as $ld){ ?>
													<option value='<?php echo trim($ld->kddept); ?>'><?php  echo $ld->nmdept; ?></option>
													<?php } ?>					
												</select>
											</div>			
										</div>-->
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
				<div class="modal fade" id="dtl12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-md">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Filter Report SPT Tahunan </h4>
						  </div>
						<div class="modal-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('payroll/report/show_pph_detail');?>" name="form" role="form" method="post">										
										
										
										
										<div class="form-group">
											 <label class="col-lg-3">Nama Karyawan</label>
											<div class="col-lg-9">
												<select id="pilihkaryawan4" name="nik" required>
												<option value="">--Pilih Karyawan--</option>
												<?php foreach ($list_karyawan as $ld){ ?>
												<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nik.' || '.$ld->nmlengkap;?></option>
												<?php } ?>																																					
											</select>
											</div>
										</div>
										
										<div class="form-group ">		
											<label class="label-form col-sm-3">Tahun</label>
											<div class="col-sm-9">
												<select class="form-control input-sm" name="tahun">
													<option value='<?php $tgl=date('y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
													<option value='<?php $tgl=date('y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
												</select>
											</div>			
										</div>
										<!--
										<div class="form-group ">		
											<label class="label-form col-sm-3">Department/Bagian</label>
											<div class="col-sm-9">
												<select id="dept" class="form-control input-sm" name="kddept" required>
													<option value="">--PILIH DEPARTMENT--</option>
													<?php foreach ($list_dept as $ld){ ?>
													<option value='<?php echo trim($ld->kddept); ?>'><?php  echo $ld->nmdept; ?></option>
													<?php } ?>					
												</select>
											</div>			
										</div>-->
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
				
<script type="text/javascript">

  

  $(function() {
	//Date range picker
	$("#example1").dataTable();
	$("#example2").dataTable();
	$("#example3").dataTable();
	$('#tgl').daterangepicker();
    $('#tgl2').daterangepicker();
    $('#tgl3').daterangepicker();
    $('#tgl4').daterangepicker();
	$('#pilihkaryawan').selectize();
	$('#pilihkaryawan2').selectize();
	$('#pilihkaryawan3').selectize();
	$('#pilihkaryawan4').selectize();
	$('#dept').selectize();
	
	
	});

</script>