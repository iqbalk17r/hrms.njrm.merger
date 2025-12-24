<?php
/*
	@author : hanif_anak_metal \m/
*/

?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();
				$("#example4").dataTable();
				$("#example5").dataTable();
				$("#example6").dataTable();
				$("#example7").dataTable();


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
		<li><a href="#tab_1" data-toggle="tab">SMS</a></li>
		<li><a href="#tab_2" data-toggle="tab">Absen</a></li>
		<li class="active"><a href="#tab_3" data-toggle="tab">Cuti</a></li>
		<li><a href="#tab_4" data-toggle="tab">Reminder Status Karyawan</a></li>
		<li><a href="#tab_5" data-toggle="tab">Mail Receiver HRD</a></li>
	</ul>
</div>
<div class="tab-content">
	<div class="tab-pane" id="tab_1" style="position: relative; height: 300px;" >
        <legend><?php echo $title2;?></legend>
        <?php echo $message;?>
            <div class="col-xs-12">
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
									<td> <?php echo $row->nik;?></td>
									<td> <?php echo $row->nohp1;?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><a data-toggle="modal" data-target="#<?php echo substr($row->nik,5,3);?>" href="#" ><i class="fa  fa-envelope-o"><i> Detail</a></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
		</div>
	</div>

<!--data option absensi-->

	<div class="tab-pane " id="tab_2" style="position: relative; height: 300px;" >
		<legend><?php echo $title2;?></legend>
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-12">
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
								<th>Keterangan</th>
								<th>Status</th>
								<th>Tanggal Input</th>
								<th>Input By</th>
								<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($option_absen as $row1): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>
									<td> <?php echo $row1->kdoption;?></td>
									<td> <?php echo $row1->value1;?></td>
									<td> <?php echo $row1->value2;?></td>
									<td> <?php echo $row1->keterangan;?></td>
									<td> <?php echo $row1->t1;?></td>
									<td> <?php echo $row1->tanggal_input;?></td>
									<td><?php echo $row1->input_by;?></td>
									<td><a data-toggle="modal" data-target="#<?php echo str_replace(" ","",$row1->kdoption);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
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
		<div class="tab-pane " id="tab_4" style="position: relative; height: 300px;" >
		<legend><?php echo $title5;?></legend>
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example6" class="table table-bordered table-striped" >
							<thead>
								<tr>
								<th>No.</th>
								<th>Kode Option</th>
								<th>Nama Option</th>
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
									<td> <?php echo $row->kdoption;?></td>
									<td> <?php echo $row->nmoption;?></td>
									<td> H- or H+ <?php echo $row->value3;?></td>
									<td> <?php echo $row->t1;?></td>
									<td> <?php echo $row->input_by;?></td>
									<td><a data-toggle="modal" data-target="#<?php echo str_replace(" ","",$row->kdoption);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
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

	<div class="tab-pane active" id="tab_3" style="position: relative; height: 300px;" >
		<legend><?php echo $title4;?></legend>
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example5" class="table table-bordered table-striped" >
							<thead>
								<tr>
								<th>No.</th>
								<th>Deskripsi Option</th>
								<th>Tanggal Input</th>
								<th>Batas Akhir Pengajuan Cuti</th>
								<th>Status</th>
								<th>Input By</th>
								<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($option_cuti as $row): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>
									<td> <?php echo $row->kdoption;?></td>
									<td> <?php echo $row->tanggal_mulai;?></td>
									<td> H- <?php echo $row->value3;?></td>
									<td> <?php echo $row->t1;?></td>
									<td><?php echo $row->input_by;?></td>
									<td><a data-toggle="modal" data-target="#<?php echo str_replace(" ","",$row->kdoption);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>

    <!-- NOTIF RECEIVER-->
    <div class="tab-pane" id="tab_5" style="position: relative; height: 300px;" >
        <legend><?php echo $title5;?></legend>
        <?php echo $message;?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <button href="#" data-toggle="modal" data-target="#inputBroadcastHrd" class="btn btn-primary" style="margin:10px; color:#ffffff;"><i class="fa fa-plus"></i> INPUT</button>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" style='overflow-x:scroll;'>
                        <table id="example7" class="table table-bordered table-striped" >
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Lengkap</th>
                                <th>Nik</th>
                                <th>Doctype</th>
                                <th>Department</th>
                                <th>Sub Department</th>
                                <th>Jabatan</th>
                                <th>Kantor</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $no=0; foreach($option_broadcast as $row): $no++;?>
                                <tr>
                                    <td width='1%'><?php echo $no;?></td>
                                    <td> <?php echo $row->nmlengkap;?></td>
                                    <td> <?php echo $row->nik;?></td>
                                    <td> <?php echo $row->doctype;?></td>
                                    <td> <?php echo $row->nmdept;?></td>
                                    <td> <?php echo $row->nmsubdept;?></td>
                                    <td> <?php echo $row->nmjabatan;?></td>
                                    <td> <?php echo $row->nmcabang;?></td>
                                    <td> <?php echo $row->email;?></td>
                                    <td> <?php echo $row->nohp1;?></td>
                                    <td><a href="<?php echo site_url("master/option/del_option_mail_broadcast"."/".trim($row->nik)."/".trim($row->doctype)); ?>" onclick="return_confirm('Akan Hapus Data Ini?');"><i class="fa  fa-trash-o"><i>Hapus</a></td>
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
		<form role="form" action="<?php echo site_url('master/option/add_jam_absen');?>" method="post">
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
						  <option value="<?php echo $listkan->nmhari;?>" ><?php echo $listkan->nmhari;?></option>
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
					<input type="input" class="form-control" name="jam" id="jam">
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
	<div class="modal fade" id="<?php echo str_replace(" ","",$oa->kdoption);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit Option Jam Absen</h4>
	  </div>

		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/option/edit_jam_absen');?>" method="post">
			<div class="form-group">
							<label for="inputkode" class="col-sm-2 control-label">Kode Option</label>
							<div class="col-sm-6">
								<input type="text" class="form-control"  name="kodeopt" id="kodeopt" value="<?php echo $oa->kdoption;?>" readonly>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group">
							<label for="inputjenis" class="col-sm-2 control-label">Deskrisi Option</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="desc_opt" id="desc_opt"  value="<?php echo $oa->nmoption;?>" style="text-transform:uppercase">
							</div>
							<div class="col-sm-11"></div>
						</div>
							<div class="form-group">
					<label for="inputstatusrmh" class="col-sm-2 control-label">Hari Kerja</label>
					<div class="col-sm-10">
						<select class="form-control input-sm" name="hari" id="statusrmh" required>
						  <?php foreach($list_hari as $listkan){?>
						  <option value="<?php echo $listkan->nmhari;?>"<?php if (trim($oa->value1)==trim($listkan->nmhari)) { echo 'selected';}?>><?php echo $listkan->nmhari;?></option>
						  <?php }?>
						</select>
					</div>
					<div class="col-sm-11"></div>
				</div>
						<div class="form-group">
							<label for="inputtgl" class="col-sm-2 control-label">Tanggal Edit</label>
							<div class="col-sm-6">
								<input type="text" id="tgl5" name="tgl" class="form-control" value="<?php echo date('d-m-Y');?>" readonly>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group">
				<label for="inputjam" class="col-sm-2 control-label">Jam</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="jam" id="jam_edit" value="<?php echo $oa->value2;?>" required >
				</div>
				<div class="col-sm-11"></div>
			</div>

				<div class="form-group">

						<input name="aktif" type="checkbox" value="T"
						<?php if ($oa->status=='T') { echo 'checked';}?>/>
						Aktif</label>
						<label>

				</div>
						<div class="form-group">
							<label for="inputby" class="col-sm-2 control-label">Diinput oleh</label>
							<div class="col-sm-6">
							  <input type="text" value="<?php echo $this->session->userdata('nik');?>" name="input" id="input" class="form-control" readonly/>
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
	<div class="modal fade" id="<?php echo str_replace(" ","",$oc->kdoption);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
								<input type="text" class="form-control"  name="kodeopt" id="kodeopt" value="<?php echo $oc->kdoption;?>" readonly>
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
							<label for="inputtgl" class="col-sm-2 control-label">Tanggal Input</label>
							<div class="col-sm-6">
								<input type="text" id="tgl16" name="tgl" class="form-control" value="<?php echo date('Y-m-d');?>" data-date-format="dd-mm-yyyy" readonly>
							</div>
							<div class="col-sm-11"></div>
						</div>


						<div class="form-group">
								<label for="inputjam" class="col-sm-2 control-label">Batas Akhir Pengajuan</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="batas" id="jam" data-inputmask='"mask": "999"' data-mask="" value="<?php echo $oc->value4;?>"   required >
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
	<div class="modal fade" id="<?php echo str_replace(" ","",$or->kdoption);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit Option Reminder</h4>
	  </div>

		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/option/edit_option_reminder');?>" method="post">
						<div class="form-group">
							<label for="inputkode" class="col-sm-4 control-label">Kode Option</label>
							<div class="col-sm-6">
								<input type="text" class="form-control"  name="kodeopt" id="kodeopt" value="<?php echo $or->kdoption;?>" readonly>
							</div>
							<div class="col-sm-11"></div>
						</div>
						<div class="form-group">
							<label for="inputjenis" class="col-sm-4 control-label">Deskrisi Option</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="desc_opt" id="desc_opt"  value="<?php echo $or->nmoption;?>" style="text-transform:uppercase">
							</div>
							<div class="col-sm-11">
							</div>
						</div>
						<div class="form-group">
							<label for="inputtgl" class="col-sm-4 control-label">Waktu Reminder </label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="reminder1" id="reminder" value="<?php echo $or->value3;?>" data-inputmask='"mask": "99"' data-mask="" required>
							</div>
							<div class="col-sm-11"></div>
						</div>
				<div class="form-group">

						<input name="aktif" type="checkbox" value="T"
						<?php if ($or->status=='T') { echo 'checked';}?>/>
						Aktif</label>
						<label>

				</div>
						<div class="form-group">
							<label for="inputby" class="col-sm-4 control-label">Diinput oleh</label>
							<div class="col-sm-6">
							  <input type="text" value="<?php echo $this->session->userdata('nama');?>" name="input" id="input" class="form-control" readonly>
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
<div class="modal fade" id="<?php echo substr($os->nik,5,3);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Detail SMS <?php echo substr($os->nik,5,3);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('master/option/add_notifsms');?>" method="post">
		  <div class="form-group">
			<div class="col-sm-control-label-2">
			<label>NIK
			<input name="nik" type="text" value="<?php echo ($os->nik);?>"readonly /></label>
			<label>telepon
			<input name="telepon" type="text" value="<?php echo($os->nohp1);?>"readonly /></label>
		  </div>
		  </div>
		  <div class="form-group">
			<label><h4>Jenis SMS</h4></label><br>
			<label>
			<input name="ijin<?php echo substr($os->nik,5,3);?>" type="checkbox" value="Y"
			<?php if ($os->ijin=='Y') { echo 'checked';}?> />
			Ijin</label>
		  </div>
		  <div class="form-group">
			<label>
			<input name="cuti<?php echo substr($os->nik,5,3);?>" type="checkbox" value="Y"
			<?php if ($os->cuti=='Y') { echo 'checked';}?> />
			Cuti</label>
		  </div>
		    <div class="form-group">
			<label>
			<input name="lembur<?php echo substr($os->nik,5,3);?>" type="checkbox" value="Y"
			<?php if ($os->lembur=='Y') { echo 'checked';}?> />
			Lembur</label>
		  </div>
		  <div class="form-group">
			<label>
			<input name="dinas<?php echo substr($os->nik,5,3);?>" type="checkbox" value="Y"
			<?php if ($os->dinas=='Y') { echo 'checked';}?> />
			Dinas</label>
		  </div>
		  <div class="form-group">
			<label>
			<input name="dll<?php echo substr($os->nik,5,3);?>" type="checkbox"  value="Y"
			<?php if ($os->dll=='Y') { echo 'checked';}?> />
			Dll</label>
		  </div>
		  <div class="form-group">
			<label> <h4>Kantor Wilayah</h4></label>
			<br>
			<label>
			<input name="sby<?php echo substr($os->nik,5,3);?>" type="checkbox" value="Y"
			<?php if ($os->kanwil_sby=='Y') { echo 'checked';}?>/>
			Surabaya</label>
			<label>
			<input name="smg<?php echo substr($os->nik,5,3);?>" type="checkbox" value="Y"
			<?php if ($os->kanwil_smg=='Y') { echo 'checked';}?>/>
			Semarang</label>
			<label>
			<input name="dmk<?php echo substr($os->nik,5,3);?>" type="checkbox" value="Y"
			<?php if ($os->kanwil_dmk=='Y') { echo 'checked';}?>/>
			Demak</label>
			<label>
			<input name="jkt<?php echo substr($os->nik,5,3);?>" type="checkbox" value="Y"
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


<!--Modal untuk Filter-->
<div class="modal fade" id="inputBroadcastHrd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Input Karyawan Untuk Penerima Broadcast Mail</h4>
            </div>
            <form action="<?php echo site_url('master/option/input_option_mail_broadcast')?>" method="post">
                <div class="modal-body">
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">KARYAWAN</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" id="nik" name="nik">
                                <option value="">--PILIH KARYAWAN--</option>
                                <?php foreach ($list_karyawan as $ld){ ?>
                                    <option value="<?php echo trim($ld->nik);?>"><?php echo trim($ld->nik).'||'.$ld->nmlengkap;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Doctype</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name="doctype" required>
                                <option value='HRMS'>HRMS</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">ERP Type</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name="erptype" required>
                                <option value='MAIL_NOTIF'>MAIL_NOTIF</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Group Type</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name="grouptype" required>
                                <option value='MOBILE_NOTIF'>MOBILE_NOTIF</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Module</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name="module" required>
                                <option value='HRMS'>HRMS</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Hold</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name="chold" required>
                                <option value='NO'>NO</option>
                                <option value='YES'>YES</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
$("#jam_edit").clockpicker();
$("#nik").selectize();
</script>
