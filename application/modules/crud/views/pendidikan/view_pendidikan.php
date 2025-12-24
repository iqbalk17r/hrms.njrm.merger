<?php 
/*
	@author : hanif_anak_metal \m/
*/
error_reporting(0);
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
<legend>Riwayat Pendidikan Pegawai</legend>

<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-header">
			   <a href="<?php echo site_url('hrd/pendidikan/input');?>" class="btn btn-primary" style="margin:10px">
			   <i class="glyphicon glyphicon-edit"></i> Input</a>			   
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>NIP</th>
							<th>Nama Pegawai</th>
							<th>Nama Sekolah</th>
							<th>Kota</th>
							<th>Jurusan</th>
							<th>Tahun Masuk</th>
							<th>Tahun Lulus</th>
							<th>Nilai/IPK</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_pendidikan as $row): $no++;?>
						<tr>
							<td><?php echo $no;?></td>
							<td><a href="<?php echo site_url('hrd/hrd/detail_pen/').'/'.$row->nip;?>"><?php echo $row->nip;?></a></td>
							<td><a href="#" data-toggle="modal" data-target=".<?php echo $row->nip;?>"><?php echo $row->nmlengkap;?></a></td>
							<td><?php echo $row->nmsekolah;?></td>
							<td><?php echo $row->kota;?></td>
							<td><?php echo $row->jurusan;?></td>
							<td><?php echo $row->periodeaw;?></td>
							<td><?php echo $row->periodeak;?></td>
							<td><?php echo $row->nilai;?></td>
							<td><div align="center"><a href="<?php echo base_url() . "hrd/pendidikan/delete/". trim($row->kdpendidikan); ?>" class="glyphicon glyphicon-remove"></a></div></td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
							
		<!--Modal untuk edit-->
		<?php $no=0; foreach($list_pendidikan as $row){ $no++;?>
			<div class="modal fade <?php echo $row->nip;?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">RIWAYAT PENDIDIKAN PEGAWAI : <?php echo $row->nmlengkap;?></h4>
					</div>
					<div class="modal-body">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">					
								<li class="active"><a href="#<?php echo trim($row->nip);?>tab_1" data-toggle="tab">Riwayat Pendidikan</a></li>					
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane active" id="<?php echo trim($row->nip);?>tab_1">
								<div class="row">
								  <div class="col-sm-6">
									<div class="form-group">
										<label for="inputkddidik" class="col-sm-4 control-label">Kode Pendidikan</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="kddidik" name="kddidik" value="<?php echo $row->kdpendidikan;?>" readonly>
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputnip" class="col-sm-4 control-label">NIP</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="nip" name="nip" value="<?php echo $row->nip;?>" readonly>
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputnama" class="col-sm-4 control-label">Nama Lengkap</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="nama" name="nama" value="<?php echo $row->nmlengkap;?>" readonly>
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputsklah" class="col-sm-4 control-label">Nama Sekolah</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="sklah" name="sklah" value="<?php echo $row->nmsekolah;?>" readonly>
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputkota" class="col-sm-4 control-label">Kota</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="kota" name="kota" value="<?php echo $row->kota;?>" readonly>
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputjur" class="col-sm-4 control-label">Jurusan</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="jur" name="jur" value="<?php echo $row->jurusan;?>" readonly>
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputtm" class="col-sm-4 control-label">Tahun Masuk</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="tm" name="tm" value="<?php echo $row->periodeaw;?>" readonly>
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputtl" class="col-sm-4 control-label">Tahun Lulus</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="tl" name="tl" value="<?php echo $row->periodeak;?>" readonly>
										</div>
										
									</div>
									<div class="form-group">
										<label for="inputnilai" class="col-sm-4 control-label">Nilai/IPK</label>
										<div class="col-sm-8">
										  <input type="text" class="form-control input-sm" id="nilai" name="nilai" value="<?php echo $row->nilai;?>" readonly>
										</div>
										
									</div>
									<div class="form-group">
										<div class="col-sm-9" style="margin-top: 10px">											
											<form action="<?php echo site_url('hrd/pendidikan/edit');?>" method="post">						
												<input type="hidden" value="<?php echo $row->kdpendidikan;?>" name="edit_kd">
											<button type="submit" class="btn btn-primary">EDIT PROFILE PEGAWAI</button>
											<?php ?>
											</form>
										</div>
										<div class="col-sm-10"></div>
									</div>
								</div><!-- ./col -->
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				  </div>
				</div>
			</div>
		<?php }?>
	</div>
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