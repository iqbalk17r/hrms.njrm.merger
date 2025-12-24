<legend><?php echo $title.' '.$ijin['desc_kdatt'];?> </legend>
	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">DATA PEGAWAI: <?php echo $peg['nmlengkap'];?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<form action="<?php echo site_url('hrd/ijin/save_ijin');?>" method="post">
					<input type="hidden" name="nip" value="<?php echo trim($peg['nip']);?>" readonly>
					<input type="hidden" name="ijin" value="<?php echo trim($ijin['kdatt']);?>" readonly>
					<input type="hidden" name="jabt" value="<?php echo $peg['kdjabatan'];?>">
					<input type="hidden" name="dept" value="<?php echo $peg['kddept'];?>">
					<div class="col-sm-12">																				
						<div class="form-group">
							<label for="tglm" class="col-sm-4 control-label">Tanggal</label>
							<div class="col-sm-6">
							  <input type="text" class="form-control input-sm" id="tgl" data-date-format="dd-mm-yyyy" name="tglijin" required>
							</div>
							<div class="col-sm-10"></div>
						</div>
						<?php if (trim($ijin['kdatt'])=='KD'){ } else {?>
						<div class="form-group">
							<label for="tglm" class="col-sm-4 control-label">Jam <?php if (trim($ijin['kdatt'])=='PA'){ echo 'Pulang';} else { if (trim($ijin['kdatt'])=='DT') { echo 'Telat';} else { echo 'Awal';}}?></label>
							<div class="col-sm-6">
								<select class="form-control" required="" name="mulai" type="text">
									<option value="08:00" type="text">08:00</option>
									<option value="09:00" type="text">09:00</option>
									<option value="10:00" type="text">10:00</option>
									<option value="11:00" type="text">11:00</option>
									<option value="12:00" type="text">12:00</option>
									<option value="13:00" type="text">13:00</option>
									<option value="14:00" type="text">14:00</option>
									<option value="15:00" type="text">15:00</option>
									<option value="16:00" type="text">16:00</option>
									<option value="17:00" type="text">17:00</option>
									<option value="18:00" type="text">18:00</option>											
								</select>
							</div>
							<div class="col-sm-10"></div>
						</div>
						
						<?php } if (trim($ijin['kdatt'])=='PA' or trim($ijin['kdatt'])=='DT' or trim($ijin['kdatt'])=='KD' ) {} else {?>
						<div class="form-group">
							<label for="tglm" class="col-sm-4 control-label">Jam Akhir</label>
							<div class="col-sm-6">
								<select class="form-control" required="" name="akhir" type="text">
									<option value="08:00" type="text">08:00</option>
									<option value="09:00" type="text">09:00</option>
									<option value="10:00" type="text">10:00</option>
									<option value="11:00" type="text">11:00</option>
									<option value="12:00" type="text">12:00</option>
									<option value="13:00" type="text">13:00</option>
									<option value="14:00" type="text">14:00</option>
									<option value="15:00" type="text">15:00</option>
									<option value="16:00" type="text">16:00</option>
									<option value="17:00" type="text">17:00</option>
									<option value="18:00" type="text">18:00</option>
								</select>
							</div>
							<div class="col-sm-10"></div>
						</div>						
						<div class="form-group">
							<label class="col-sm-4 control-label">Pendamping</label>
							<div class="col-sm-6">
							  <input type="text" class="form-control input-sm" name="pendamping" >
							</div>
							<div class="col-sm-10"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Kendaraan</label>
							<div class="col-sm-6">
							  <input type="text" class="form-control input-sm" name="kendaraan" >
							</div>
							<div class="col-sm-10"></div>
						</div>
						<?php } // jika pulang awal?>
						<div class="form-group">
							<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
							<div class="col-sm-6">
							  <textarea class="form-control input-sm" id="ketm" name="keterangan" required></textarea>
							</div>
							<div class="col-sm-10"></div>
						</div>
					</div>		
				</div>													
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default" onclick="return confirm('Simpan Data ini?')">Simpan Data</button>											
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>											
			</div>
			</form>
		</div>			
<script>

    $(function() {
		$("[data-mask]").inputmask();
		$('#tgl').datepicker();
		
		$('#masuk').datepicker();
		$('#keluar').datepicker();
		$('#tglm').datepicker();
		$('#berlaku').daterangepicker();
		});
		
</script>