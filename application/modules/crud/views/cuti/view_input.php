<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="col-xs-12">     
	<form action="<?php echo site_url('hrd/cuti/add_cuti');?>" name="Form" role="form" method="post">
		<div class="box">
			<div class="box-body" style="margin-top: 20px;">
				<div class="form-horizontal">
					<div class="col-sm-12">
						<div class="form-group input-sm input-sm">
							<label for="inputnama" class="col-sm-2 control-label">Nama Karyawan</label>
							<div class="col-sm-4">
								<input type="hidden" name="nip" value="<?php echo $peg_cuti['nip']?>" >
								<input type='text' name='nama_peg' class="form-control input-sm" value="<?php echo $peg_cuti['nmlengkap']?>" readonly>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group input-sm">
							<label for="inputdept" class="col-sm-2 control-label">Departemen</label>
							<div class="col-sm-4">							  
								<input type='text'  class="form-control input-sm" value="<?php echo $peg_cuti['departement']?>" readonly>							 
								<input type='hidden' name='dept' class="form-control input-sm" value="<?php echo $peg_cuti['kddept']?>" readonly>							 
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group input-sm">
							<label for="inputjabt" class="col-sm-2 control-label">Jabatan</label>
							<div class="col-sm-4">
								<input type='text'  class="form-control input-sm" value="<?php echo $peg_cuti['deskripsi']?>" readonly>							 
								<input type='hidden' name='jabt' class="form-control input-sm" value="<?php echo $peg_cuti['kdjabatan']?>" readonly>							 
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group input-sm">
							<label for="inputatasan" class="col-sm-2 control-label">Atasan</label>
							<div class="col-sm-4">
								<input type='text'  class="form-control input-sm" value="<?php echo $peg_cuti['nmatasan']?>" readonly>
								<input type='hidden' name='atasan' class="form-control input-sm" value="<?php echo $peg_cuti['nipatasan']?>" readonly>
							</div>
							<div class="col-sm-11"></div>
						</div>

						<div class="form-group input-sm">
							<label for="inputtgl" class="col-sm-2 control-label">Tanggal Awal Cuti</label>
							<div class="col-sm-4">
							  <input type="text" class="form-control input-sm" id="tglcuti" name="tglcuti" data-date-format="dd-mm-yyyy" required>
							  <!--<input type="text" id="tgl1" name="tgl1" class="form-control input-sm" data-date-format="dd-mm-yyyy"  required/>-->
							</div>
							<div class="col-sm-11"></div>
						</div>
						<!--
						<div class="form-group input-sm">
							<label for="inputtgl" class="col-sm-2 control-label">Tanggal Akhir Cuti</label>
							<div class="col-sm-4">
							  <input type="text" id="tgl2" name="tgl2" class="form-control input-sm" data-date-format="dd-mm-yyyy" >
							</div>
							<div class="col-sm-11"></div>
						</div>
						-->
						<div class="form-group input-sm">
							<label for="inputjml" class="col-sm-2 control-label">Jumlah Cuti</label>
							<div class="col-sm-1">							  
							  <input type="hidden" id="cuti" name="cuti" class="form-control input-sm" value="<?php echo $peg_cuti['sisacuti'];?>">
							  <input type="numeric" max="12" id="jml" name="jml" class="form-control input-sm" onFocus="startCalc();" onBlur="stopCalc();" required>
							</div>
							
							<label for="inputsisa" class="col-sm-1 control-label">Sisa Cuti</label>
							<div class="col-sm-1">
							  <input type="text" id="sisa" name="sisa" placeholder="<?php echo $peg_cuti['sisacuti'];?>" class="form-control input-sm" readonly>
							</div>

						</div>
						<div class="form-group input-sm">
							<label for="inputlimpah" class="col-sm-2 control-label">Pekerjaan dilimpahkan</label>
							<div class="col-sm-4">
							  <select class='form-control input-sm' name="limpah" id="limpah">		
								<?php
									if(empty($q_pegawai))
									{
									echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
									}else
									{
									foreach($q_pegawai as $column)
									{
									?>
									<option value="<?php echo $column->nip; ?>"><?php echo $column->nmlengkap; ?></option>
									<?php }} ?>
							  </select>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group input-sm">
							<label for="inputket" class="col-sm-2 control-label">Keterangan</label>
							<div class="col-sm-4">
								<textarea class="form-control input-sm" rows="3" name="ket" id="ket"></textarea>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<!--
						<div class="form-group input-sm">
							<label for="inputtelp" class="col-sm-2 control-label">No Telp</label>
							<div class="col-sm-4">
								<input type="text" id="telp" name="telp" class="form-control input-sm" data-inputmask='"mask": "+62 99999999999"' data-mask="" required/>
							</div>
							<div class="col-sm-11"></div>
						</div>
						-->
						<div class="form-group input-sm">
							<label for="inputby" class="col-sm-2 control-label">Diinput oleh</label>
							<div class="col-sm-4">
							  <input type="text" id="input" value="<?php echo $this->session->userdata('username');?>" name="input" class="form-control input-sm" disabled/>
							</div>
							<div class="col-sm-11"></div>
						</div>
					</div>											
				</div>
			</div>
			<div class="box-footer">
				<button type='submit' class='btn btn-primary' onclick="return confirm('Anda Yakin Input Cuti Ini?');" ><i class="glyphicon glyphicon-search"></i>Proses</button>
				<button type='reset' class='btn btn-default' onclick="history.go(-1);" >Kembali</button>
			</div>
		</div>
	</form>
</div>

<div id="tampil"></div>

<script>

    $(function() {
		$("[data-mask]").inputmask();
		$('#tgl1').datepicker();
		$('#tgl2').datepicker();
		$('#tglcuti').daterangepicker("setDate", new Date(2008,9,03));
		});
		
</script>


<script type="text/javascript">
function startCalc(){interval=setInterval("calc()",1)}
function calc(){
sisacuti=document.Form.cuti.value;
jmlcuti=document.Form.jml.value;

//sum perbulan
document.Form.sisa.value=(sisacuti*1)-(jmlcuti*1);

}
function stopCalc(){clearInterval(interval)}
</script>