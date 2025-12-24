<legend><?php echo $title;?></legend>
<?php echo $message;?>

<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">					
		<!--li class="active"><a href="#tab_1" data-toggle="tab"><b>IMPORT KARYAWAN</b></a></li>
		<li><a href="#tab_2" data-toggle="tab"><b>IMPORT JADWAL KERJA</b></a></li>	
		<li><a href="#tab_3" data-toggle="tab"><b>IMPORT DATA REGU</b></a></li>	
		<li><a href="#tab_4" data-toggle="tab"><b>REKAP GAJI</b></a></li-->	
		<li  class="active"><a href="#tab_5" data-toggle="tab"><b>IMPORT FINGER ABSENSI</b></a></li>	
	</ul>
</div>




<div class="tab-content">
	<div class="chart tab-pane" id="tab_1" style="position: relative; height: 300px;" >
		<div class="row">
			<div class="col-md-6">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">IMPORT DATA KARYAWAN</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form action="<?php echo site_url('master/import/import_karyawan')?>" method="post" enctype="multipart/form-data" role="form">
						<div class="box-body">					
							
							<div class="form-group">
								<label for="exampleInputFile">File input Data Master</label>						
								<input type="file" id="import" name="import" required>
								<p class="help-block">Data Harus Berextensi xls (ms office 2003/Kingsoft 7/Open Office 2.x) atau xlsx (ms office 2007/Kingsoft 2013/Open Office 3.x).</p>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" required> Saya Bertanggung Jawab atas data yang saya Upload ke Sistem
								</label>
							</div>
						</div><!-- /.box-body -->

						<div class="box-footer">
							<button type="submit" value="Import" name="save" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div><!-- /.box -->
			</div>
			</div>
	</div>
	<div class="tab-pane" id="tab_2" style="position: relative; height: 300px;" >

			<div class="row">
			<div class="col-md-6">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">IMPORT DATA JADWAL KERJA</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form action="<?php echo site_url('master/import/import_jadwalkerja')?>" method="post" enctype="multipart/form-data" role="form">
						<div class="box-body">					
							
							<div class="form-group">
								<label for="exampleInputFile">File input Data Master</label>						
								<input type="file" id="import" name="import" required>
								<p class="help-block">Data Harus Berextensi xls (ms office 2003/Kingsoft 7/Open Office 2.x) atau xlsx (ms office 2007/Kingsoft 2013/Open Office 3.x).</p>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" required> Saya Bertanggung Jawab atas data yang saya Upload ke Sistem
								</label>
							</div>
						</div><!-- /.box-body -->

						<div class="box-footer">
							<button type="submit" value="Import" name="save" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div><!-- /.box -->
			</div>
			</div>
	</div>	

	<div class="tab-pane" id="tab_3" style="position: relative; height: 300px;" >

		<div class="row">
			<div class="col-md-6">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">IMPORT DATA REGU</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form action="<?php echo site_url('master/import/import_regu')?>" method="post" enctype="multipart/form-data" role="form">
						<div class="box-body">					
							
							<div class="form-group">
								<label for="exampleInputFile">File input Data Master</label>						
								<input type="file" id="import" name="import" required>
								<p class="help-block">Data Harus Berextensi xls (ms office 2003/Kingsoft 7/Open Office 2.x) atau xlsx (ms office 2007/Kingsoft 2013/Open Office 3.x).</p>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" required> Saya Bertanggung Jawab atas data yang saya Upload ke Sistem
								</label>
							</div>
						</div><!-- /.box-body -->

						<div class="box-footer">
							<button type="submit" value="Import" name="save" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div><!-- /.box -->
			</div>
		</div>
	</div>
	<div class="tab-pane" id="tab_4" style="position: relative; height: 300px;" >

		<div class="row">
			<div class="col-md-6">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">REKAP GAJI KARYAWAN</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form action="<?php echo site_url('master/import/rekap_gaji')?>" method="post" enctype="multipart/form-data" role="form">
						<div class="box-body">					
							
							<div class="form-group">
								<label for="exampleInputFile">File input Data Master</label>						
								<input type="file" id="import" name="import" required>
								<p class="help-block">Data Harus Berextensi xls (ms office 2003/Kingsoft 7/Open Office 2.x) atau xlsx (ms office 2007/Kingsoft 2013/Open Office 3.x).</p>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" required> Saya Bertanggung Jawab atas data yang saya Upload ke Sistem
								</label>
							</div>
						</div><!-- /.box-body -->

						<div class="box-footer">
							<button type="submit" value="Import" name="save" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div><!-- /.box -->
			</div>
		</div>
	</div>
	<div class="tab-pane active" id="tab_5" style="position: relative; height: 300px;" >

		<div class="row">
			<div class="col-md-6">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">IMPORT FINGER ABSENSI</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form action="<?php echo site_url('master/import/proses_absen')?>" method="post" enctype="multipart/form-data" role="form">
						<div class="box-body">					
							
							<div class="form-group">
								<label for="exampleInputFile">File input Data Master</label>						
								<input type="file" id="import" name="import" required>
								<p class="help-block">Data Harus Berextensi xls (ms office 2003/Kingsoft 7/Open Office 2.x) atau xlsx (ms office 2007/Kingsoft 2013/Open Office 3.x).</p>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" required> Saya Bertanggung Jawab atas data yang saya Upload ke Sistem
								</label>
							</div>
						</div><!-- /.box-body -->

						<div class="box-footer">
							<button type="submit" value="Import" name="save" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div><!-- /.box -->
			</div>
		</div>
	</div>
	
	
</div>