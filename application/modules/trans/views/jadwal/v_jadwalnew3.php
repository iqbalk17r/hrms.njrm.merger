<?php 
/*
	@author : Fiky
*/
?>

<script type="text/javascript">
            $(function() {
                $("#table1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
            });
		
</script>
<legend><?php echo $title.' BULAN '.$bulan.' TAHUN '.$tahun;?></legend>
<?php echo $message;?>
<div id="message" >	
</div>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--button href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Jadwal Kerja</button-->
					<a href="<?php echo site_url("trans/jadwal_new/view_jadwalsebulan")?>"  class="btn btn-success" style="margin:10px; color:#ffffff;">Input Jadwal Kerja</a>
					<button href="#" data-toggle="modal" data-target="#filter" class="btn btn-primary" style="margin:10px; color:#ffffff;">Filter</button>
					<!--a href="<?php echo site_url("#");?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-danger">Hapus Jadwal</a-->
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table1" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>																
							<th>No.</th>
							<th>Nik</th>
							<th>NAMA LENGKAP</th>
							<th>KDREGU</th>
							<th>BULAN</th>
							<th>TAHUN</th>
							<th>1</th>
							<th>2</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
							<th>6</th>
							<th>7</th>
							<th>8</th>
							<th>9</th>
							<th>10</th>
							<th>11</th>
							<th>12</th>
							<th>13</th>
							<th>14</th>
							<th>15</th>
							<th>16</th>
							<th>17</th>
							<th>18</th>
							<th>19</th>
							<th>20</th>
							<th>21</th>
							<th>22</th>
							<th>23</th>
							<th>24</th>
							<th>25</th>
							<th>26</th>
							<th>27</th>
							<th>28</th>
							<th>29</th>
							<th>30</th>
							<th>31</th>
							
							<!--<th>Shift/Non Shift</th>-->
							<!--<th>Nama Regu</th>
							<th>Kode Jam Kerja</th>-->
							<!--<th>Action</th>-->
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach ($list_jadwal as $ls): $no++ ?>
							<tr>																													
								<td><?php echo $no;?></td>	
								<td><?php echo $ls->nik;?></td>								
								<td><?php echo $ls->nmlengkap;?></td>								
								<td><?php echo $ls->kdregu;?></td>								
								<td><?php echo $ls->bulan;?></td>								
								<td><?php echo $ls->tahun;?></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-01'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl1;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-02'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl2;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-03'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl3;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-04'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl4;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-05'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl5;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-06'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl6;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-06'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl7;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-08'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl8;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-09'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl9;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-10'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl10;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-11'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl11;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-12'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl12;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-13'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl13;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-14'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl14;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-15'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl15;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-16'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl16;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-17'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl17;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-18'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl18;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-19'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl19;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-20'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl20;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-21'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl21;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-22'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl22;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-23'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl23;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-24'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl24;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-25'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl25;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-26'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl26;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-27'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl27;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-28'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl28;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-29'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl29;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-30'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl30;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-31'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl31;?></a></td>								
									
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

 <!-- Bootstrap modal -->
 <form action="<?php echo site_url('trans/jadwal_new/input_jadwal')?>" method="post">
  <div class="modal fade" id="input" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
		<h3 class="modal-title">Input Jadwal Kerja</h3>
      </div>
      <div class="modal-body form">
          <div class="row">
		  <div class="form-body">
              <!--<div class="form-group">
              <label class="control-label col-md-3">Shift Tipe</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="shift" name="shift" required>
							<option value="t">SHIFT</option>																																			
							<option value="f">NON SHIFT</option>																																			
						</select>
              </div>
            </div>-->
			<div class="form-group">
              <label class="control-label col-md-3">Nama Regu</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="kdregu" name="kdregu" required>
							<option value="">--Pilih Nama Regu--</option>
							<?php foreach ($list_regu as $ld){ ?>
							<option value="<?php echo trim($ld->kdregu);?>"><?php echo $ld->nmregu;?></option>
							<?php } ?>																																					
						</select>
              </div>
            </div>
		 
			<div class="form-group">
              <label class="control-label col-md-3">Tanggal Jadwal Kerja</label>
              <div class="col-md-9">
                <input name="tanggal" id="tgl" data-date-format="dd-mm-yyyy" class="form-control"  type="text">
              </div>
            </div>
			 <div class="form-group">
              <label class="control-label col-md-3">Jadwal Jam Kerja</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="kdjamkerja1" name="kdjamkerja" required>
							<option value="">--Pilih Jam Kerja--</option>
							<?php foreach ($list_jamkerja as $ld){ ?>
							<option value="<?php echo trim($ld->kdjam_kerja);?>"><?php echo $ld->nmjam_kerja;?></option>
							<?php } ?>																																					
						</select>
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Jam Kerja</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="nmjamkerja1" name="nmjamkerja" readonly>
							<?php foreach ($list_jamkerja as $ld){ ?>
							<option class="<?php echo trim($ld->kdjam_kerja);?>"><?php echo $ld->jam_masuk.'-'.$ld->jam_pulang;?></option>
							<?php } ?>																																					
						</select>
              </div>
            </div>		
          </div>
          </div>
          </div>
		  
          <div class="modal-footer">
			<div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
	</form>
  
  <!-- Bootstrap modal -->
  
  <!-- Bootstrap modal -->
 <form action="<?php echo site_url('trans/jadwal_new/input_jadwal_ns')?>" method="post">
  <div class="modal fade" id="input2" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
		<h3 class="modal-title">Input Jadwal Kerja Non Shift</h3>
      </div>
      <div class="modal-body form">
          <div class="row">
		  <div class="form-body">
             <div class="form-group">
              <label class="control-label col-md-3">Shift Tipe</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="shift" name="shift" required>																																			
							<option value="f">NON SHIFT</option>																																			
						</select>
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Nama Karyawan</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="pilihkaryawan" name="nik" required>
							<option value="">--PILIH KARYAWAN--</option>
							<?php foreach ($list_karyawan as $ld){ ?>
							<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nmlengkap;?></option>
							<?php } ?>																																					
						</select>
              </div>
            </div>
		 
			<div class="form-group">
              <label class="control-label col-md-3">Tanggal</label>
              <div class="col-md-9">
                <input name="tanggal" id="tgl2" data-date-format="dd-mm-yyyy" class="form-control"  type="text">
              </div>
            </div>
			 <div class="form-group">
              <label class="control-label col-md-3">Jam Kerja</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="kdjamkerja" name="kdjamkerja" required>
							<option value="">--Pilih Jam Kerja--</option>
							<?php foreach ($list_jamkerja as $ld){ ?>
							<option value="<?php echo trim($ld->kdjam_kerja);?>"><?php echo $ld->nmjam_kerja;?></option>
							<?php } ?>																																					
						</select>
              </div>
            </div>	
          </div>
          </div>
          </div>
		  
          <div class="modal-footer">
			<div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
	</form>
  
  <!-- Bootstrap modal -->
  
  
  
  <!-- Bootstrap modal -->
 
 <!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Filter Jadwal Per Bulan</h4>
      </div>
	  <form action="<?php echo site_url('trans/jadwal_new/index')?>" method="post">
      <div class="modal-body">
        <div class="form-group input-sm ">		
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
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Tahun</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="thn" required>
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">KARYAWAN</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="pilihkaryawan2" name="nik">
							<option value="">--PILIH KARYAWAN--</option>
							<?php foreach ($list_karyawan as $ld){ ?>
							<option value="<?php echo trim($ld->nik);?>"><?php echo trim($ld->nik).'||'.$ld->nmlengkap;?></option>
							<?php } ?>																																					
						</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">REGU</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="kdregu2" name="kdregu">
							<option value="">--Pilih Nama Regu--</option>
							<?php foreach ($list_regu as $ld){ ?>
							<option value="<?php echo trim($ld->kdregu);?>"><?php echo $ld->nmregu;?></option>
							<?php } ?>																																					
						</select>
			</div>			
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-primary">Filter</button>
      </div>
	  </form>
    </div>
  </div>
</div>
 
 <script>
 
	//Date range picker
    $('#tgl').datepicker();
    $('#tgl2').datepicker();
	$('#pilihkaryawan').selectize();
	$('#pilihkaryawan2').selectize();
	$('#kdregu').selectize();
	$('#kdregu2').selectize();
	$("[data-mask]").inputmask();
	$("#nmjamkerja1").chained("#kdjamkerja1");		
	$("#disb").chained("#city");	

</script>