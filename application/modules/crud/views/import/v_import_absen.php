<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">IMPORT DATA ABSEN</h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			<form action="<?php echo site_url('hrd/import/proses_absen')?>" method="post" enctype="multipart/form-data" role="form">
				<div class="box-body">		
					<div class="box-body">					
		
					</div>				
					<div class="form-group">
						<label for="exampleInputFile">File input Data Absen</label>						
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