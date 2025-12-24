<?php 
/*
	@author : hanif_anak_metal \m/
*/
error_reporting(0);
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $('#example3').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bInfo": true,
                    "bSort": true,
                    "bAutoWidth": false
                });
            });
</script>

<div class="row">
	<div class="col-xs-12">                            		
		<!-- Custom tabs (Charts with tabs)-->
		<div class="nav-tabs-custom">
			<!-- Tabs within a box -->
			<ul class="nav nav-tabs pull-right">				
				<li><a href="#keluarkerja" data-toggle="tab">Keluar</a></li>
				<li class="active"><a href="#aktifkerja" data-toggle="tab">Aktif</a></li>
				<li class="pull-left header"><i class="fa fa-inbox"></i>Daftar Pegawai</li>				
			</ul>
			<div class="tab-content no-padding">
				<!-- Morris chart - Sales -->				
				<div class="chart tab-pane active" id="aktifkerja">
					<div class="box box-succes">
						<div class="box-header">												
							<h3 class="box-title">Pegawai Aktif</h3>																					
						</div>
						<div class="box-body" ">
							<button class="btn btn-primary" onclick="window.location.href='/hrd/hrd/input'" style="margin:5px;" >Input Pegawai Baru</button>							
							<table id="example1" class="table table-bordered table-striped" style="position: relative; height: 300px;">
								<thead>
									<tr>
										<th>No.</th>
										<th>NIP</th>
										<th>Nama</th>
										<th>Foto</th>
										<th>Alamat</th>
										<th>Departemen</th>
										<th>Jabatan</th>
										<th>Kantor</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=0; foreach($list_pegawai as $row):  
									if (empty($row->keluarkerja)) {
									?>
									<tr>										
										<td width='2%'><?php $no++; echo $no;?></td>
										<td width='4%'><a href="<?php echo site_url('hrd/hrd/detail_peg/').'/'.$row->list_nip;?>"><?php echo $row->list_nip;?></a></td>									
										<td width='20%'><?php echo $row->nmlengkap;?></td>
										<td width='20%'>
											<?php if ($row->image<>'') { ?>
											<div class="pull-left image">
												<img height='100px' width='100px' alt="User Image" class="img-box" src="<?php echo base_url('/assets/img/profile/').'/'.$row->image;?>">
											</div>				
											<!--<img  alt="User Image" src="<?php echo base_url('/assets/img/profile/').'/'.$row->image;?>">-->
											<?php } else {?>
											<img height='100px' width='100px' alt="User Image" src="<?php echo base_url('/assets/img/user.png');?>">
											<?php }?>
										</td>
										<td width='35%'><?php echo $row->alamat;?></td>
										<td width='15%'><?php echo $row->departement;?></td>
										<td width='15%'><?php echo $row->deskripsi;?></td>										
										<td width='15%'><?php echo $row->kdcabang;?></td>										
									</tr>
									<?php } endforeach;?>
								</tbody>
							</table>
						</div>
					</div>
												
				</div>
				<div class="chart tab-pane" id="keluarkerja">
					<div class="box box-succes">
						<div class="box-header">												
							<h3 class="box-title">Pegawai Keluar</h3>																					
						</div>
						<div class="box-body" ">
							<table id="example2" class="table table-bordered table-striped" >
								<thead>
									<tr>
										<th width="2%">No.</th>
										<th>NIP</th>
										<th>Nama</th>
										<th>Alamat</th>
										<th>Departemen</th>
										<th>Jabatan</th>
										<th>Tgl Keluar</th>
										<th>Lama Bekerja</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=0; foreach($list_pegawai as $row): 
									if (!empty($row->keluarkerja) and $row->keluarkerja<>'1969-12-31') {
									?>
									<tr>
										<td width='2%'><?php $no++; echo $no;?></td>
										<td width='5%'><a href="<?php echo site_url('hrd/hrd/detail_peg/').'/'.$row->list_nip;?>"><?php echo $row->list_nip;?></a></td>
										<!--<td><a href="#" data-toggle="modal" data-target=".<?php echo $row->list_nip;?>"><?php echo $row->nmlengkap;?></a></td>-->
										<td><?php echo $row->nmlengkap;?></td>
										<td width='20%'><?php echo $row->alamat;?></td>
										<td><?php echo $row->departement;?></td>
										<td><?php echo $row->deskripsi;?></td>
										<td><?php echo $row->keluarkerja;?></td>
										<td><?php
											$kta_awal = array('years','year','mons','mon','days','day');
											$kta_akhir = array('tahun','tahun','bulan','bulan','hari','hari');
											$pesan= str_replace($kta_awal,$kta_akhir,$row->masakerja);
											echo $pesan;?>
										</td>
									</tr>
									<?php } endforeach;?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.nav-tabs-custom -->
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