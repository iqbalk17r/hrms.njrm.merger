<?php 
/*
	@author : hanif_anak_metal \m/
*/
error_reporting(0);
?>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<?php echo validation_errors();?>
<div id="tampil"></div>												
							<form action="<?php echo site_url('hrd/pendidikan/simpan_pen');?>" name="form" role="form" method="post">
							<div class="row clearfix">	
								<div class="col-lg-6">
								    <div class="form-group">			
										<label for="inputnip" class="col-sm-3 control-label">Kode Pendidikan</b></h3></label>
										<div class="col-sm-9">
										  <h3><b><?php echo $pen_edit['kdpendidikan'];?></b></h3>
										  <input type="hidden" class="form-control input-sm" value="editpen" id="tipe" name="tipe" required>
										  <input type="hidden" class="form-control input-sm" value="<?php echo $pen_edit['kdpendidikan'];?>" id="kddidik" name="kddidik" readonly>
										  
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">			
										<label for="inputnip" class="col-sm-3 control-label">NIP</b></h3></label>
										<div class="col-sm-9">
										  <h3><b><?php echo $pen_edit['nip'];?></b></h3>
										  <input type="hidden" class="form-control input-sm" value="editpen" id="tipe" name="tipe" required>
										  <input type="hidden" class="form-control input-sm" value="<?php echo $pen_edit['nip'];?>" id="nip" name="nip" readonly>
										  
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputnama" class="col-sm-3 control-label">Nama Lengkap</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" value="<?php echo $pen_edit['nmlengkap'];?>" id="nama" name="nama" style="text-transform:uppercase">
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputskolah" class="col-sm-3 control-label">Nama Sekolah</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" value="<?php echo $pen_edit['nmsekolah'];?>" id="skolah" name="skolah" style="text-transform:uppercase">
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputjurusan" class="col-sm-3 control-label">Jurusan</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" value="<?php echo $pen_edit['jurusan'];?>" id="jurusan" name="jurusan" style="text-transform:uppercase" required>
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputkota" class="col-sm-3 control-label">Kota</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" value="<?php echo $pen_edit['kota'];?>" id="kota" name="kota" style="text-transform:uppercase" required>
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputmasuk" class="col-sm-3 control-label">Tahun Masuk</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" value="<?php echo $pen_edit['periodeaw'];?>" id="masuk" name="masuk" style="text-transform:uppercase" required>
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputlulus" class="col-sm-3 control-label">Tahun Lulus</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" value="<?php echo $pen_edit['periodeak'];?>" id="lulus" name="lulus" style="text-transform:uppercase" required>
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputnilai" class="col-sm-3 control-label">Nilai/IPK</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" value="<?php echo $pen_edit['nilai'];?>" id="nilai" name="nilai" style="text-transform:uppercase" required>
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputket" class="col-sm-3 control-label">Keterangan</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" value="<?php echo $pen_edit['keterangan'];?>" id="ket" name="ket" style="text-transform:uppercase" required>
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputedit" class="col-sm-3 control-label">Diedit Oleh</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" value="<?php echo $pen_edit['editby'];?>" id="edit" name="edit" style="text-transform:uppercase" required>
										</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputttl" class="col-sm-3 control-label">Tanggal Edit</label>
											<div class="col-sm-6">
											  <input type="date" class="form-control input-sm" value="<?php echo $pen_edit['tgledit'];?>" id="tanggal" name="tanggaledit" required data-date-format="yyyy-mm-dd" required>
											</div>
										<div class="col-sm-10"></div>
									</div>
									<div class="form-group">
										<label for="inputstatus" class="col-sm-3 control-label">Status</label>
										<div class="col-sm-6">
										  <input type="text" class="form-control input-sm" value="<?php echo $pen_edit['keterangan'];?>" id="status" name="status" style="text-transform:uppercase" required>
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
						
			</div><!-- /.col -->
		</div>										
	  </div>

<script>
	
	//Date picker
    $('#tanggal').datepicker();

</script>