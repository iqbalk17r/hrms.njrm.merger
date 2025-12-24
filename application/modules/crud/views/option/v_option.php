<?php 
/*
	@author : hanif_anak_metal \m/
*/

?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example3").dataTable();
				$("#example4").dataTable();
				$("#example5").dataTable();
				$("#example6").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bInfo": true,
                    "bSort": true,
                    "bAutoWidth": false
                });
				//tgllembur
				
				$('#tgl').datepicker();
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
			//$("[data-mask]").inputmask();
</script>

<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">					
		<li class="active"><a href="#tab_1" data-toggle="tab">SMS</a></li>
		<li><a href="#tab_2" data-toggle="tab">Absen</a></li>	
		<li><a href="#tab_3" data-toggle="tab">Tanggal Libur Nasional</a></li>
		<li><a href="#tab_4" data-toggle="tab">Cuti</a></li>	
		<li><a href="#tab_5" data-toggle="tab">Reminder Status Karyawan</a></li>
	</ul>
</div>	
<div class="tab-content">
	<div class="chart tab-pane active" id="tab_1" style="position: relative; height: 300px;" >
		<legend><?php echo $title1;?></legend>
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-8">                            
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
								<tr>
								<th>No.</th>
								<th>NIP</th>
								<th>Telepon</th>
								<th>Nama</th>
								<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($option_sms as $row): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>
									<td> <?php echo $row->nip;?></td>
									<td> <?php echo $row->telepon;?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><a data-toggle="modal" data-target="#<?php echo substr($row->nip,5,3);?>" href="#" ><i class="fa  fa-envelope-o"><i> Detail</a></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>

<!--data option absensi-->

	<div class="tab-pane" id="tab_2" style="position: relative; height: 300px;" >
		<legend><?php echo $title2;?></legend>
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-8">                            
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example4" class="table table-bordered table-striped" >
							<thead>
								<tr>
								<th>No.</th>
								<th>Deskripsi Option</th>
								<th>Hari</th>
								<th>Waktu</th>
								<th>Wilayah</th>
								<th>Status</th>
								<th>Tanggal Input</th>
								<th>Input By</th>
								<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($option_absen as $row): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>
									<td> <?php echo $row->desc_opt;?></td>
									<td> <?php echo $row->hari;?></td>
									<td> <?php echo $row->value3;?></td>
									<td> <?php echo $row->wilayah;?></td>
									<td> <?php echo $row->t1;?></td>
									<td> <?php echo $row->tanggal_input;?></td>
									<td><?php echo $row->inputby;?></td>
									<td><a data-toggle="modal" data-target="#<?php echo str_replace(" ","",$row->kodeopt);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>	
<!--data tanggal libur nasional-->

	<div class="tab-pane" id="tab_3" style="position: relative; height: 300px;" >
		<legend><?php echo $title3;?></legend>
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-8">                            
				<div class="box">
					<div class="box-header">
					   <button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> INPUT</a>
					   <button class="btn btn-primary" data-toggle="modal" data-target="#filter" style="margin:10px"><i class="glyphicon glyphicon-search"></i> FILTER PERIODE</a>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example3" class="table table-bordered table-striped" >
							<thead>
								<tr>
								<th>No.</th>
								<th>Tanggal Libur Nasional</th>
								<th>Keterangan Libur</th>
								<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($option_calendar as $row): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>
									<td> <?php echo $row->tanggal_libur;?></td>
									<td> <?php echo $row->ket_libur;?></td>
									<td><a href="<?php echo site_url('hrd/option/hps_tgl_libur').'/'.$row->tanggal_libur;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo ($row->tanggal_libur);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>
	
	<!-- data option reminder -->
		<div class="tab-pane" id="tab_5" style="position: relative; height: 300px;" >
		<legend><?php echo $title5;?></legend>
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-8">                            
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example6" class="table table-bordered table-striped" >
							<thead>
								<tr>
								<th>No.</th>
								<th>Deskripsi Option</th>
								<th>Kantor Wilayah</th>
								<th>Value Reminder</th>
								<th>Status</th>
								<th>Input By</th>
								<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($option_reminder as $row): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>
									<td> <?php echo $row->desc_opt;?></td>
									<td> <?php echo $row->wilayah;?></td>
									<td> H- or H+ <?php echo $row->value4;?></td>
									<td> <?php echo $row->t1;?></td>
									<td> <?php echo $row->inputby;?></td>
									<td><a data-toggle="modal" data-target="#<?php echo str_replace(" ","",$row->kodeopt);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>

<!--data option cuti-->

	<div class="tab-pane" id="tab_4" style="position: relative; height: 300px;" >
		<legend><?php echo $title4;?></legend>
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-8">                            
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example5" class="table table-bordered table-striped" >
							<thead>
								<tr>
								<th>No.</th>
								<th>Deskripsi Option</th>
								<th>Value Waktu</th>
								<th>Batas Akhir Pengajuan Cuti</th>
								<th>Wilayah</th>
								<th>Status</th>
								<th>Input By</th>
								<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($option_cuti as $row): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>
									<td> <?php echo $row->desc_opt;?></td>
									<td> <?php echo $row->tanggal_mulai;?></td>
									<td> H- <?php echo $row->value4;?></td>
									<td> <?php echo $row->wilayah;?></td>
									<td> <?php echo $row->t1;?></td>
									<td><?php echo $row->inputby;?></td>
									<td><a data-toggle="modal" data-target="#<?php echo str_replace(" ","",$row->kodeopt);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>	

	
	<!--input option absen--> 
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Input Jam Absen</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('hrd/option/add_jam_absen');?>" method="post">
			<div class="form-group">
							<label for="inputkode" class="col-sm-2 control-label">Kode Option</label>
							<div class="col-sm-6">
								<input type="text" class="form-control"  placeholder="FORMAT SINGKAT" name="kodeopt" id="kodeopt" style="text-transform:uppercase" required>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group">
							<label for="inputjenis" class="col-sm-2 control-label">Deskrisi Option</label>
							<div class="col-sm-6">
								<textarea input type="text" class="form-control"  row="3" name="desc_opt" id="desc_opt" style="text-transform:uppercase" required></textarea>
							</div>
							<div class="col-sm-11"></div>
						</div>
							<div class="form-group">
					<label for="inputstatusrmh" class="col-sm-2 control-label">Hari Kerja</label>
					<div class="col-sm-10">
						<select class="form-control input-sm" name="hari" id="statusrmh" required>
						  <?php foreach($list_hari as $listkan){?>
						  <option value="<?php echo $listkan->hari;?>" ><?php echo $listkan->hari;?></option>						  
						  <?php }?>
						</select>
					</div>
					<div class="col-sm-11"></div>
				</div>	
						<div class="form-group">
							<label for="inputtgl" class="col-sm-2 control-label">Tanggal</label>
							<div class="col-sm-6">
								<input type="text" id="tgl" name="tgl" class="form-control" data-date-format="dd-mm-yyyy" required>
							</div>
							<div class="col-sm-11"></div>
						</div>						
						<div class="form-group">
				<label for="inputjam" class="col-sm-2 control-label">jam</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="jam" id="jam" data-inputmask='"mask": "99:99"' data-mask="">
				</div>
				<div class="col-sm-11"></div>
			</div>
						<div class="form-group">
					<label for="inputstatusrmh" class="col-sm-2 control-label">Kantor wilayah</label>
					<div class="col-sm-10">
						<select class="form-control input-sm" name="kantorcabang" id="statusrmh" required>
						  <?php foreach($list_kantor as $listkan){?>
						  <option value="<?php echo $listkan->kodecabang;?>" ><?php echo $listkan->desc_cabang;?></option>						  
						  <?php }?>
						</select>
					</div>
					<div class="col-sm-11"></div>
				</div>	
				<div class="form-group">
						<input name="aktif" type="checkbox" value="t" />
						Aktif</label>
						<label>	
				</div>
						<div class="form-group">
							<label for="inputby" class="col-sm-2 control-label">Diinput oleh</label>
							<div class="col-sm-6">
							  <input type="text" value="<?php echo $this->session->userdata('username');?>" name="input" id="input" class="form-control" readonly/>
							</div>
						<div class="col-sm-11"></div>	
						</div>
			
		</div>
		<div class="modal-footer">
			<div class="form-group"> 
				<div class="col-sm-2 control-label">
					<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
				   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
				</div>
			</div>
		</div>
		</form>
  </div>
</div>
</div>  

<!-- Modal Edit Option Absen -->
<?php foreach ($option_absen as $oa){?>
	<div class="modal fade" id="<?php echo str_replace(" ","",$oa->kodeopt);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit Option Jam Absen</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('hrd/option/edit_jam_absen');?>" method="post">
			<div class="form-group">
							<label for="inputkode" class="col-sm-2 control-label">Kode Option</label>
							<div class="col-sm-6">
								<input type="text" class="form-control"  name="kodeopt" id="kodeopt" value="<?php echo $oa->kodeopt;?>" readonly>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group">
							<label for="inputjenis" class="col-sm-2 control-label">Deskrisi Option</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="desc_opt" id="desc_opt"  value="<?php echo $oa->desc_opt;?>" style="text-transform:uppercase">
							</div>
							<div class="col-sm-11"></div>
						</div>
							<div class="form-group">
					<label for="inputstatusrmh" class="col-sm-2 control-label">Hari Kerja</label>
					<div class="col-sm-10">
						<select class="form-control input-sm" name="hari" id="statusrmh" required>
						  <?php foreach($list_hari as $listkan){?>
						  <option value="<?php echo $listkan->hari;?>" ><?php echo $listkan->hari;?></option>						  
						  <?php }?>
						</select>
					</div>
					<div class="col-sm-11"></div>
				</div>	
						<div class="form-group">
							<label for="inputtgl" class="col-sm-2 control-label">Tanggal Input</label>
							<div class="col-sm-6">
								<input type="text" id="tgl5" name="tgl" class="form-control" value="<?php echo $oa->value2;?>" data-date-format="dd-mm-yyyy" >
							</div>
							<div class="col-sm-11"></div>
						</div>						
						<div class="form-group">
				<label for="inputjam" class="col-sm-2 control-label">jam</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="jam" id="jam" value="<?php echo $oa->value3;?>" data-inputmask='"mask": "99:99"' data-mask="">
				</div>
				<div class="col-sm-11"></div>
			</div>
						<div class="form-group">
					<label for="inputstatusrmh" class="col-sm-2 control-label">Kantor wilayah</label>
					<div class="col-sm-10">
						<select class="form-control input-sm" name="kantorcabang" id="statusrmh" required>
						  <?php foreach($list_kantor as $listkan){?>
						  <option value="<?php echo $listkan->kodecabang;?>" ><?php echo $listkan->desc_cabang;?></option>						  
						  <?php }?>
						</select>
					</div>
					<div class="col-sm-11"></div>
				</div>	
				<div class="form-group">
						
						<input name="aktif" type="checkbox" value="t"
						<?php if ($oa->status=='t') { echo 'checked';}?>/>
						Aktif</label>
						<label>
							
				</div>
						<div class="form-group">
							<label for="inputby" class="col-sm-2 control-label">Diinput oleh</label>
							<div class="col-sm-6">
							  <input type="text" value="<?php echo $this->session->userdata('username');?>" name="input" id="input" class="form-control" readonly/>
							</div>
						<div class="col-sm-11"></div>	
						</div>
			
		</div>
		<div class="modal-footer">
			<div class="form-group"> 
				<div class="col-sm-2 control-label">
					<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
				   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
				</div>
			</div>
		</div>
		</form>
  </div>
</div>
</div>  
<?php } ?>

<!-- Modal Edit Option Cuti -->
<?php foreach ($option_cuti as $oc){?>
	<div class="modal fade" id="<?php echo str_replace(" ","",$oc->kodeopt);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit Option Cuti</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('hrd/option/edit_option_cuti');?>" method="post">
						<div class="form-group">
							<label for="inputkode" class="col-sm-2 control-label">Kode Option</label>
							<div class="col-sm-6">
								<input type="text" class="form-control"  name="kodeopt" id="kodeopt" value="<?php echo $oc->kodeopt;?>" readonly>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group">
							<label for="inputjenis" class="col-sm-2 control-label">Deskrisi Option</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="desc_opt" id="desc_opt"  value="<?php echo $oc->desc_opt;?>" style="text-transform:uppercase">
							</div>
							<div class="col-sm-11">
							</div>
						</div>
						<div class="form-group">
							<label for="inputtgl" class="col-sm-2 control-label">Value Waktu</label>
							<div class="col-sm-6">
								<input type="text" id="tgl3" name="tgl" class="form-control" value="<?php echo $oc->tanggal_mulai;?>" data-date-format="dd-mm-yyyy">
							</div>
							<div class="col-sm-11"></div>
						</div>
												
							
						<div class="form-group">
								<label for="inputjam" class="col-sm-2 control-label">Batas Akhir Pengajuan</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="batas" id="jam" value="<?php echo $oc->value6;?>" data-inputmask='"mask": "99"' data-mask="">
							</div>
							<div class="col-sm-11"></div>
						</div>
						
				<div class="form-group">
						
						<input name="aktif" type="checkbox" value="t"
						<?php if ($oc->status=='t') { echo 'checked';}?>/>
						Aktif</label>
						<label>
							
				</div>
						<div class="form-group">
							<label for="inputby" class="col-sm-2 control-label">Diinput oleh</label>
							<div class="col-sm-6">
							  <input type="text" value="<?php echo $this->session->userdata('username');?>" name="input" id="input" class="form-control" readonly>
							</div>
						<div class="col-sm-11"></div>	
						</div>
			
		</div>
		<div class="modal-footer">
			<div class="form-group"> 
				<div class="col-sm-2 control-label">
					<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
				   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
				</div>
			</div>
		</div>
		</form>
  </div>
</div>
</div>  
<?php } ?>

<!-- Modal Edit Option Reminder -->
<?php foreach ($option_reminder as $or){?>
	<div class="modal fade" id="<?php echo str_replace(" ","",$or->kodeopt);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit Option Reminder</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('hrd/option/edit_option_reminder');?>" method="post">
						<div class="form-group">
							<label for="inputkode" class="col-sm-4 control-label">Kode Option</label>
							<div class="col-sm-6">
								<input type="text" class="form-control"  name="kodeopt" id="kodeopt" value="<?php echo $or->kodeopt;?>" readonly>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group">
							<label for="inputjenis" class="col-sm-4 control-label">Deskrisi Option</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="desc_opt" id="desc_opt"  value="<?php echo $or->desc_opt;?>" style="text-transform:uppercase">
							</div>
							<div class="col-sm-11">
							</div>
						</div>
						<div class="form-group">
							<label for="inputtgl" class="col-sm-4 control-label">Waktu Reminder </label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="reminder1" id="reminder" value="<?php echo $or->reminder1;?>" data-inputmask='"mask": "99"' data-mask="" required>
							</div>
							<div class="col-sm-11"></div>
						</div>
				<div class="form-group">
						
						<input name="aktif" type="checkbox" value="t"
						<?php if ($or->status=='t') { echo 'checked';}?>/>
						Aktif</label>
						<label>
							
				</div>
						<div class="form-group">
							<label for="inputby" class="col-sm-4 control-label">Diinput oleh</label>
							<div class="col-sm-6">
							  <input type="text" value="<?php echo $this->session->userdata('username');?>" name="input" id="input" class="form-control" readonly>
							</div>
						<div class="col-sm-11"></div>	
						</div>
			
		</div>
		<div class="modal-footer">
			<div class="form-group"> 
				<div class="col-sm-2 control-label">
					<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
				   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
				</div>
			</div>
		</div>
		</form>
  </div>
</div>
</div>  
<?php } ?>


<!-- Modal Detail SMS -->
<?php foreach ($option_sms as $os){?>
<div class="modal fade" id="<?php echo substr($os->nip,5,3);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Detail SMS <?php echo substr($os->nip,5,3);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('hrd/option/add_notifsms');?>" method="post">
		  <div class="form-group">
			<div class="col-sm-control-label-2">
			<label>NIP
			<input name="nip" type="text" value="<?php echo ($os->nip);?>"readonly /></label>
			<label>telepon														
			<input name="telepon" type="text" value="<?php echo($os->telepon);?>"readonly /></label>								
		  </div>
		  </div>
		  <div class="form-group">
			<label><h4>Jenis SMS</h4></label><br>
			<label>
			<input name="ijin<?php echo substr($os->nip,5,3);?>" type="checkbox" value="Y"
			<?php if ($os->ijin=='Y') { echo 'checked';}?> />
			Ijin</label>											
		  </div>
		  <div class="form-group">
			<label> 
			<input name="cuti<?php echo substr($os->nip,5,3);?>" type="checkbox" value="Y"
			<?php if ($os->cuti=='Y') { echo 'checked';}?> />
			Cuti</label>											
		  </div>
		    <div class="form-group">
			<label> 
			<input name="lembur<?php echo substr($os->nip,5,3);?>" type="checkbox" value="Y"
			<?php if ($os->lembur=='Y') { echo 'checked';}?> />
			Lembur</label>											
		  </div>
		  <div class="form-group">
			<label>
			<input name="dll<?php echo substr($os->nip,5,3);?>" type="checkbox"  value="Y" 
			<?php if ($os->dll=='Y') { echo 'checked';}?> />
			Dll</label>	
		  </div>
		  <div class="form-group">
			<label> <h4>Kantor Wilayah</h4></label>
			<br>
			<label>
			<input name="sby<?php echo substr($os->nip,5,3);?>" type="checkbox" value="Y" 
			<?php if ($os->kanwil_sby=='Y') { echo 'checked';}?>/>
			Surabaya</label>	
			<label>
			<input name="smg<?php echo substr($os->nip,5,3);?>" type="checkbox" value="Y" 
			<?php if ($os->kanwil_smg=='Y') { echo 'checked';}?>/>
			Semarang</label>
			<label>
			<input name="dmk<?php echo substr($os->nip,5,3);?>" type="checkbox" value="Y" 
			<?php if ($os->kanwil_dmk=='Y') { echo 'checked';}?>/>
			Demak</label>
			<label>
			<input name="jkt<?php echo substr($os->nip,5,3);?>" type="checkbox" value="Y" 
			<?php if ($os->kanwil_jkt=='Y') { echo 'checked';}?>/>
			Jakarta</label></br>
		  </div>
		  <button type="submit" class="btn btn-primary">Simpan</button>
		  <button type="reset" class="btn btn-default">Reset</button>
		</form>
	  </div>
	</div>
  </div>
</div>
<?php } ?>
	
<!-- Modal Input Tanggal Libur -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Input Tanggal Libur Nasional</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('hrd/option/add_tgl_libur');?>" method="post">
		  <div class="form-group">
			<label for="tgl">Tanggal Libur</label>
			<div class="col-sx-24">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" id="tgl2" name="tgl2"  class="form-control pull-right" data-date-format="dd-mm-yyyy">
					</div><!-- /.input group -->
				</div>
		  </div>
		  <div>
		  <label for="besaran">Keterangan Libur</label>
		  <input type ="text" class="form-control" name="ket_libur">
          </div>
		  </div>
		  <div class="modal-footer">
		  <div class="col-sm-control-label-2">
		  <button type="submit" class="btn btn-primary">Simpan</button>
		  <button type="reset" class="btn btn-default">Reset</button>
		  </div>
		  </div>
		</form>
	  </div>
	</div>
  </div>
</div>	
</div>

<!--modal filter periode tanggal libur -->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode Cuti</h4>
      </div>
	  <form action="<?php site_url('hrd/option/index')?>" method="post">
      <div class="modal-body">
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Tahun</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="tahun">
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')+1; echo $tgl; ?>'><?php $tgl=date('Y')+1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')+2; echo $tgl; ?>'><?php $tgl=date('Y')+2; echo $tgl; ?></option>					
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
$("[data-mask]").inputmask();
$('#tgl2').datepicker();
$('#tgl3').datepicker();
$('#tgl4').datepicker();
$('#tgl5').datepicker();
</script>