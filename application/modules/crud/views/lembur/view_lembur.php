<?php 
/*
	@author : hanif_anak_metal \m/
*/

?>
<legend>Input Lembur</legend>

<div class="col-xs-12">     
	<form action="<?php echo site_url('hrd/lembur/add_lembur');?>" name="form" role="form" method="post">
		<div class="box">
			<div class="box-body" style="margin-top: 20px;">
				<div class="form-horizontal">
					<div class="col-lg-12">
						<div class="form-group">
							<label for="inputnama" class="col-sm-2 control-label">Nama Karyawan</label>
							<div class="col-sm-4">
							  <select class='form-control' name="nip" id="nip">		
								<?php
									if(empty($qpegawai))
									{
									echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
									}else
									{
									foreach($qpegawai as $column)
									{
									?>
									<option value="<?php echo $column->nip; ?>"><?php echo $column->nmlengkap; ?></option>
								<?php }} ?>
							  </select>
							</div>
							<div class="col-sm-11"></div>
						</div>
						
						<div class="form-group">
							<label for="inputtgl" class="col-sm-2 control-label">Tanggal</label>
							<div class="col-sm-4">
								<input type="text" id="tgllembur" name="tgl" class="form-control" data-date-format="dd-mm-yyyy" required>
							</div>
							<div class="col-sm-11"></div>
						</div>						
						<div class="form-group">
							<label for="inputmulai" class="col-sm-2 control-label">Mulai</label>
							<div class="col-sm-2">								
								<select type="text" class="form-control" name="mulai" required>
									<option type="text" value="16:00">16:00</option>
									<option type="text" value="17:00">17:00</option>
									<option type="text" value="18:00">18:00</option>
									<option type="text" value="19:00">19:00</option>
									<option type="text" value="20:00">20:00</option>
									<option type="text" value="21:00">21:00</option>
									<option type="text" value="22:00">22:00</option>
								</select>
							</div>
							<div class="col-sm-11"></div>
						</div>
						
						<div class="form-group">
							<label for="inputakhir" class="col-sm-2 control-label">Akhir</label>
							<div class="col-sm-2">
								<select  class="form-control" name="akhir" required>
									<option type="text" value="16:00">16:00</option>
									<option type="text" value="17:00">17:00</option>
									<option type="text" value="18:00">18:00</option>
									<option type="text" value="19:00">19:00</option>
									<option type="text" value="20:00">20:00</option>
									<option type="text" value="21:00">21:00</option>
									<option type="text" value="22:00">22:00</option>
								</select>
							</div>
							<div class="col-sm-11"></div>
						</div>
						
						<div class="form-group">
							<label for="inputjenis" class="col-sm-2 control-label">Jenis Pekerjaan</label>
							<div class="col-sm-4">
								<textarea class="form-control" rows="3" name="jenis" id="jenis" required></textarea>
							</div>
							<div class="col-sm-11"></div>
						</div>
						
						<div class="form-group">
							<label for="inputby" class="col-sm-2 control-label">Diinput oleh</label>
							<div class="col-sm-4">
							  <input type="text" value="<?php echo $this->session->userdata('username');?>" name="input" id="input" class="form-control" readonly/>
							</div>
							<div class="col-sm-11"></div>
						</div>
					</div>											
				</div>
			</div>
			<div class="box-footer">
				<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-envelope"></i> Simpan</button>
				<button type='button' class='btn btn-default' onclick="history.go(-1);" >Kembali</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
            $(function() {                
                //Timepicker
                $(".timepicker").timepicker({
                    showInputs: false
                });
				//tgllembur
				$('#tgllembur').datepicker();
				$('.form_time').datetimepicker({
					language:  'id',
					weekStart: 1,
					todayBtn:  1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 1,
					minView: 0,
					maxView: 1,
					forceParse: 0
				});
            });
	
</script>