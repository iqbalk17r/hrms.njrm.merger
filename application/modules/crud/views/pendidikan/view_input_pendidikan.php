<?php 
/*
	@author : hanif_anak_metal \m/
*/
error_reporting(0);
?>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<?php echo validation_errors();?>
<form action="<?php echo site_url('hrd/pendidikan/simpan_pen');?>" name="form" role="form" method="post">
<div class="row clearfix">	
	<div class="col-lg-6">
		<div class="form-group">
			<label for="inputkddidik" class="col-sm-3 control-label">Kode Pendidikan</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="kddidik" name="kddidik" style="text-transform:uppercase" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>
			<label for="inputnip" class="col-sm-3 control-label">NIP</label>
			<div class="col-sm-6">
			  <input type="numeric" class="form-control input-sm" id="nip" name="nip" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputskolah" class="col-sm-3 control-label">Nama Sekolah</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="skolah" name="skolah" style="text-transform:uppercase" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputjurusan" class="col-sm-3 control-label">Jurusan</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="jurusan" name="jurusan" style="text-transform:uppercase" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputkota" class="col-sm-3 control-label">Kota</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="kota" name="kota" style="text-transform:uppercase" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputmasuk" class="col-sm-3 control-label">Tahun Masuk</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="masuk" name="masuk" style="text-transform:uppercase" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputlulus" class="col-sm-3 control-label">Tahun Lulus</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="lulus" name="lulus" style="text-transform:uppercase" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputnilai" class="col-sm-3 control-label">Nilai/IPK</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="nilai" name="nilai" style="text-transform:uppercase" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputket" class="col-sm-3 control-label">Keterangan</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="ket" name="ket" style="text-transform:uppercase" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputedit" class="col-sm-3 control-label">Diedit Oleh</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="edit" name="edit" style="text-transform:uppercase" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputttl" class="col-sm-3 control-label">Tanggal Edit</label>
				<div class="col-sm-6">
				  <input type="date" class="form-control input-sm" id="tanggal" name="tanggaledit" required data-date-format="dd-mm-yyyy" required>
				</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputstatus" class="col-sm-3 control-label">Status</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="status" name="status" style="text-transform:uppercase" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
	</div><!-- ./col -->						
</div><!-- /.row -->
	
<div class="row clearfix">
	<div class="col-lg-6" style="margin: 10px">
		<div class="form-group">		
		  <button type="submit" class="btn btn-primary">Simpan</button>
		  <button type="button" class="btn btn-default" onclick="history.back();">Kembali</button>
		</div>
	</div>
</div>

</form>

<div id="tampil"></div>

<script>
	
	//Date picker
    $('#tanggal').datepicker();

</script>