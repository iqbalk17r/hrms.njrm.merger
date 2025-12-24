<?php 
/*
	@author : hanif_anak_metal \m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#disetujui").dataTable();
                $("#dibatalkan").dataTable();
            });
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">
		<a class="btn btn-primary" href='<?php echo site_url('hrd/cuti/sisa_cuti');?>'>Input Cuti</a>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div>
</div>
</br>
<div class="row">
	<div class="col-sm-12">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">					
				<li class="active"><a href="#tab_1" data-toggle="tab">MASIH INPUT</a></li>
				<li><a href="#tab_2" data-toggle="tab">DI SETUJUI</a></li>
				<li><a href="#tab_3" data-toggle="tab">BATAL</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">													
					<div class="box">
						<div class="box-header">
						</div><!-- /.box-header -->
						<div class="box-body table-responsive" style='overflow-x:scroll;'>
							<table id="example1" class="table table-bordered table-striped" >
								<thead>
									<tr>
									<th>No.</th>
									<th>Status</th>
									<th>No Dokumen</th>
									<th>Tgl Mulai</th>
									<th>Nama</th>											
									<th>Cuti (hari)</th>
									<th>Tgl Masuk</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=0; foreach($list_cuti_in as $icuti): $no++;?>
									<tr>										
										<td width="2%"><?php echo $no;?></td>												
										<td><?php													
											switch ($icuti->status){
												case "I": echo 'Masih Input'; break;
												case "F": echo 'Sudah Di Setujui'; break;													
											}?></td>				
										<td><a href="#" data-toggle="modal" data-target="#<?php $nodok=explode(';',trim($icuti->nodokumen));	echo $nodok[1];?>" ><?php echo $icuti->nodokumen;?></a></td>
										<td><?php echo $icuti->tglmulai;?></td>																								
										<td><?php echo $icuti->nmlengkap;?></td>																																																											
										<td><?php echo $icuti->jmlcuti;?></td>																								
										<td><?php echo $icuti->tglahir;?></td>											
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->															
				</div><!-- /.tab-pane -->   
				<div class="tab-pane" id="tab_2">
					<div class="box">
						<div class="box-header">
						</div><!-- /.box-header -->
						<div class="box-body table-responsive" style='overflow-x:scroll;'>
							<table id="disetujui" class="table table-bordered table-striped" >
								<thead>
									<tr>
									<th>No.</th>
									<th>Status</th>
									<th>No Dokumen</th>
									<th>Tgl Mulai</th>
									<th>Nama</th>											
									<th>Cuti (hari)</th>
									<th>Tgl Masuk</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=0; foreach($list_cuti_ap as $acuti): $no++;?>
									<tr>										
										<td width="2%"><?php echo $no;?></td>																								
										<td><?php													
											switch ($acuti->status){
												case "I": echo 'Masih Input'; break;
												case "F": echo 'Sudah Di Setujui'; break;													
											}?></td>				
										<td><a href="#" data-toggle="modal" data-target="#<?php $nodok=explode(';',trim($acuti->nodokumen));	echo $nodok[1];?>" ><?php echo $acuti->nodokumen;?></a></td>
										<td><?php echo $acuti->tglmulai;?></td>																								
										<td><?php echo $acuti->nmlengkap;?></td>																																																											
										<td><?php echo $acuti->jmlcuti;?></td>																								
										<td><?php echo $acuti->tglahir;?></td>																																														
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->	
				</div><!-- /.tab-pane -->
				
				<div class="tab-pane" id="tab_3">
					<div class="box">
						<div class="box-header">
						</div><!-- /.box-header -->
						<div class="box-body table-responsive" style='overflow-x:scroll;'>
							<table id="dibatalkan" class="table table-bordered table-striped" >
								<thead>
									<tr>
									<th>No.</th>
									<th>Status</th>
									<th>No Dokumen</th>
									<th>Tgl Mulai</th>
									<th>Nama</th>											
									<th>Cuti (hari)</th>
									<th>Tgl Masuk</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=0; foreach($list_cuti_ca as $ccuti): $no++;?>
									<tr>										
										<td width="2%"><?php echo $no;?></td>																								
										<td><?php													
											switch ($ccuti->status){
												case "I": echo 'Masih Input'; break;
												case "F": echo 'Sudah Di Setujui'; break;													
												case "C": echo 'Di Batalkan'; break;													
											}?></td>				
										<td><a href="#" data-toggle="modal" data-target="#<?php $nodok=explode(';',trim($ccuti->nodokumen));	echo $nodok[1];?>" ><?php echo $ccuti->nodokumen;?></a></td>
										<td><?php echo $ccuti->tglmulai;?></td>																								
										<td><?php echo $ccuti->nmlengkap;?></td>																																																											
										<td><?php echo $ccuti->jmlcuti;?></td>																								
										<td><?php echo $ccuti->tglahir;?></td>										
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!--end tab pane 3-->
						</div><!-- /.tab-content -->
		</div><!-- nav-tabs-custom -->
	</div>
</div>

								

<!-- Modal Cuti -->

<?php foreach($list_cuti as $mcuti){ ?>
<div class="modal fade" id="<?php $nodok=explode(';',trim($mcuti->nodokumen));	echo $nodok[1];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cuti :<?php echo trim($mcuti->nodokumen).' '.$mcuti->nmlengkap; ?></h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group input-sm">
					<label for="inputnama" class="col-sm-4 control-label">Nama </label>
					<div class="col-sm-8">						
						<input class='form-control input-sm' value="<?php echo $mcuti->nmlengkap;?>" readonly>
					</div>					
				</div>
				<div class="form-group input-sm">
					<label for="inputdept" class="col-sm-4 control-label">Departemen</label>
					<div class="col-sm-8">
						<input class='form-control input-sm' value="<?php echo $mcuti->departement;?>" readonly>
					</div>					
				</div>
				<div class="form-group input-sm">
					<label for="inputjabt" class="col-sm-4 control-label">Jabatan</label>
					<div class="col-sm-8">
						<input class='form-control input-sm' value="<?php echo $mcuti->deskripsi;?>" readonly>
					</div>					
				</div>
				<div class="form-group input-sm">
					<label for="inputatasan" class="col-sm-4 control-label">Atasan</label>
					<div class="col-sm-8">
						<input class='form-control input-sm' value="<?php echo $mcuti->atasan;?>" readonly>
					</div>					
				</div>

				<div class="form-group input-sm">
					<label for="inputtgl" class="col-sm-4 control-label">Tanggal Awal Cuti</label>
					<div class="col-sm-8">						
					  <input type="text" value="<?php echo $mcuti->tglmulai;?>" class="form-control input-sm" readonly>
					</div>
					<div class="col-sm-11"></div>
				</div>

				<div class="form-group input-sm">
					<label for="inputtgl" class="col-sm-4 control-label">Tanggal Akhir Cuti</label>
					<div class="col-sm-8">
					  <input type="text" value="<?php echo $mcuti->tglahir;?>" class="form-control input-sm" data-date-format="dd-mm-yyyy" readonly>
					</div>					
				</div>

				
			</div>
			<div class="col-sm-6">
				<div class="form-group input-sm">
					<label for="inputjml" class="col-sm-2 control-label">Jumlah Cuti</label>
					<div class="col-sm-4">							  					  
					  <input type="numeric" max="12" id="jml" name="jml" value="<?php echo $mcuti->jmlcuti;?>" class="form-control input-sm" readonly>
					</div>
					
					<label for="inputsisa" class="col-sm-2 control-label">Sisa Cuti</label>
					<div class="col-sm-4">
					  <input type="text" id="sisa" name="sisa" value="<?php echo $mcuti->sisacuti;?>" class="form-control input-sm" readonly>
					</div>

				</div>
				<div class="form-group input-sm">
					<label for="inputlimpah" class="col-sm-4 control-label">Pekerjaan dilimpahkan</label>
					<div class="col-sm-8">
						<input class='form-control input-sm' value="<?php echo $mcuti->pengganti;?>" readonly>
					</div>					
				</div>
				<div class="form-group input-sm">
					<label for="inputket" class="col-sm-4 control-label">Keterangan</label>
					<div class="col-sm-8">					
						<textarea class="form-control input-sm" rows="3" name="ket" id="ket" readonly><?php echo $mcuti->keterangan;?></textarea>
					</div>
					<div class="col-sm-11"></div>
				</div>
				<div class="form-group input-sm">
					<label for="inputtelp" class="col-sm-4 control-label">No Telp</label>
					<div class="col-sm-8">
						<input type="text" value="<?php echo $mcuti->notlpcuti;?>" class="form-control input-sm" readonly>
					</div>					
				</div>
				<div class="form-group input-sm">
					<label for="inputby" class="col-sm-4 control-label">Diinput oleh</label>
					<div class="col-sm-8">
					  <input type="text" id="input" value="<?php echo $this->session->userdata('username');?>" name="input" class="form-control input-sm" disabled/>
					</div>					
				</div>
			</div>
		</div>
      </div><!--end modal body-->
      <div class="modal-footer">		
		<div class="col-sm-12">					
			<?php if ($mcuti->status=='I') {?>
			<div class="col-sm-3">				
				<form action="<?php echo site_url('hrd/cuti/resendsms');?>" method="post">
					<input type="hidden" value="<?php echo trim($mcuti->nodokumen);?>" name="nodokumen">
					<button type="submit" class="btn btn-primary" OnClick="return confirm('Anda Yakin, Kirim Ulang SMS Cuti <?php echo $mcuti->nmlengkap;?>?')">Kirim Ulang SMS</button>
				</form>
			</div>
			<div class="col-sm-3">
				<form action="<?php echo site_url('hrd/cuti/approve');?>" method="post">
					<input type="hidden" value="<?php echo trim($mcuti->nodokumen);?>" name="nodokumen">
					<button type="submit" class="btn btn-primary" OnClick="return confirm('Anda Yakin, Menyetujui Cuti <?php echo $mcuti->nmlengkap;?>?')">Approval</button>
				</form>
			</div>
			<?php }?>
			<div class="col-sm-3">
				<?php if ($mcuti->status=='F'){?>
				<form action="<?php echo site_url('hrd/cuti/cancel');?>" method="post">			
					<input type="hidden" value="<?php echo trim($mcuti->nodokumen);?>" name="nodokumen">
					<button type="submit" class="btn btn-primary" OnClick="return confirm('Anda Yakin, Membatalkan Cuti <?php echo $mcuti->nmlengkap;?>?')">Batal</button>
				</form>				
				<?php }?>
				<?php if ($mcuti->status=='I'){?>
				<form action="<?php echo site_url('hrd/cuti/cancel');?>" method="post">			
					<input type="hidden" value="<?php echo trim($mcuti->nodokumen);?>" name="nodokumen">
					<button type="submit" class="btn btn-primary" OnClick="return confirm('Anda Yakin, Membatalkan Cuti <?php echo $mcuti->nmlengkap;?>?')">Batal</button>
				</form>				
				<?php }?>
				
			</div>
			<div class="col-sm-3">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>

<?php } ?>

<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode Cuti</h4>
      </div>
	  <form action="<?php site_url('hrd/cuti/index')?>" method="post">
      <div class="modal-body">
        <div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Bulan</label>
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
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Tahun</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="tahun">
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