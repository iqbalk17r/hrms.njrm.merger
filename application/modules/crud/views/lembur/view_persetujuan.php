<?php 
/*
	@author : hanif_anak_metal \m/
*/

?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
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
<div class="row">
	<div class="col-sm-12">
		<a class="btn btn-primary" href='<?php echo site_url('hrd/lembur/input');?>'>Input Lembur</a>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div>
</div>
</br>
<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-body table-responsive" >
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>No Dok Lembur</th>
							<th>Tanggal</th>
							<th>Jam Mulai</th>
							<th>Jam Selesai</th>
							<th>Jenis Pekerjaan</th>
							<th>Status</th>
						</tr>
					</thead>					
					<tbody>
					<?php $no=0; foreach($list_lembur as $lembur){ $no++;?>
						<tr>
							<td><?php echo $no;?></td>
							<td><a href="#" data-toggle="modal" data-target=".<?php $nom=explode(':',$lembur->notransaksi); echo $nom[0].$nom[1];?>"><?php echo $lembur->nmlengkap;?></a></td>							
							<td><?php echo $lembur->notransaksi;?></td>
							<td><?php echo date('d-m-Y', strtotime($lembur->tanggal));?></td>
							<td><?php echo $lembur->jam_mulai;?></td>
							<td><?php echo $lembur->jam_selesai;?></td>
							<td><?php echo $lembur->jenis_pekerjaan;?></td>
							<td><?php switch ($lembur->status){
									case 'I': echo 'Pengajuan'; break;
									case 'A': echo 'Di Setujui'; break;
									case 'C': echo 'Di Tolak Atasan'; break;
									case 'H': echo 'Proses Hitung Lembur'; break;
								}								
							?></td>
						</tr>
					<?php }?>	
					</tbody>					
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>
				
<!-- Modal -->
<?php $no=0; foreach($list_lembur as $lembur){ $no++;?>
	<div class="modal fade <?php $nom=explode(':',$lembur->notransaksi); echo $nom[0].$nom[1];?>" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				
		  <div class="modal-dialog">
			<div class="modal-content">
			<form action="<?php echo site_url('hrd/lembur/approve');?>" method="post">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Persetujuan Lembur</h4>
			  </div>
			  <div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label for="inputnama" class="col-sm-3 control-label">Nama Karyawan</label>
							<div class="col-sm-8">
								<input type="hidden" value="<?php echo trim($lembur->nip);?>" name="nip">
								<input type="hidden" value="<?php echo trim($lembur->idabsensi);?>" name="idabsen">
								<input type="hidden" value="<?php echo trim($lembur->badgenumber);?>" name="badgenumber">
								<input type="hidden" value="<?php echo trim($lembur->notransaksi);?>" name="notransaksi">
								<input type="text" id="nama" name="nama" class="form-control input-sm" value="<?php echo $lembur->nmlengkap;?>" readonly>								
							</div>							
						</div>
						<div class="form-group">
							<label for="inputnama" class="col-sm-3 control-label">No Lembur</label>
							<div class="col-sm-8">
								<input type="text" id="nolembur" name="nolembur" class="form-control input-sm" value="<?php echo $lembur->notransaksi;?>" readonly>
							</div>							
						</div>
						
						<div class="form-group">
							<label for="inputtgl" class="col-sm-3 control-label">Tanggal</label>
							<div class="col-sm-3">
							  <input type="text" id="tgl" name="tglku" class="form-control input-sm" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($lembur->tanggal));?>" readonly>
							</div>				
							<div class="col-sm-11"></div>
						</div>

						<div class="form-group">
							<label for="inputmulai" class="col-sm-3 control-label">Jam </label>
							<div class="col-sm-4">
							  <input type="text" id="mulai" name="mulai" class="form-control input-sm" value="<?php echo $lembur->jam_mulai;?>" readonly>
							</div>
							<label for="inputmulai" class="col-sm-1 control-label">Hingga </label>
							<div class="col-sm-4">
							  <input type="text" id="selesai" name="selesai" class="form-control input-sm" value="<?php echo $lembur->jam_selesai;?>" readonly>
							</div>
						</div>			
						<div class="form-group">
							<label for="inputjenis" class="col-sm-3 control-label">Jenis Pekerjaan</label>
							<div class="col-sm-9">
								<textarea class="form-control input-sm" rows="3" name="jenis" id="jenis" readonly><?php echo $lembur->jenis_pekerjaan;?></textarea>
							</div>							
						</div>
						
						<div class="form-group">
							<label for="inputby" class="col-sm-3 control-label">Diinput oleh</label>
							<div class="col-sm-4">
							  <input type="text" id="input" value="<?php echo $this->session->userdata('username');?>" name="input" class="form-control input-sm" readonly/>
							</div>
							<div class="col-sm-11"></div>
						</div>
					</div>
				</div>
			  </div>
			  <div class="modal-footer">					
				<?php 
					if ($lembur->status=='A') {
				?>
				<button type="submit" class="btn btn-primary" OnClick="return confirm('Anda Yakin, Menghitung Lembur <?php echo $lembur->nmlengkap;?>?')">Hitung</button>
					<?php }?>
				</form>			
				<button class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>		
	</div>
<?php }?>
<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode Lembur</h4>
      </div>
	  <form action="<?php site_url('hrd/lembur/index')?>" method="post">
      <div class="modal-body">
        <div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm input-sm" name='bulan'>
					
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
				<select class="form-control input-sm input-sm" name="tahun">
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Filter</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<script>

	//Date picker
    $('#tgl').datepicker();

</script>