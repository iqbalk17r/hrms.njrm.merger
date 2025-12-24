<script type="text/javascript">
	$(function () {
		$("#example1").dataTable();
		$("#example2").dataTable();
		$("#example3").dataTable();
		$("#dateinput").datepicker();
		$("#dateinput1").datepicker();
		$("#dateinput2").datepicker();
		$(".tgl").datepicker();
		$("[data-mask]").inputmask();
		//	$("#kdsubgroup").chained("#kdgroup");
		//	$("#kdbarang").chained("#kdsubgroup");
		////	$("#onhand").chained("#kdbarang");
		//alert ($('#kdsubgroup').val() != '');
		$('.btninput').click(function () {
			console.log($('#daristock').val());
			console.log('HALO SEMUA');
			$('.drst').prop('required', true);
			$('.drst').show();
			$('.satap').hide();
			$('.satba').show(); $('#satminta2').prop('required', true); $('#satminta').prop('required', false); $('#desc_barang').prop('readonly', true);
			$('#submitinp').prop('disabled', false);
		});

		$('.ch').change(function () {
			// loading()
			console.log($('#loccode').val() != '');

			var param1 = $('#kdgroup_inp').val().trim();
			var param2 = $('#kdsubgroup_inp').val().trim();
			var param3 = $('#kdbarang_inp').val().trim();
			var param4 = $('#loccode').val().trim();
			console.log(param4);
			if ((param1 != '') && (param2 != '') && (param3 != '') && (param4 != '')) {
				$.ajax({
					url: "<?php echo site_url('ga/pembelian/js_viewstock_back') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
						console.log(data.conhand);
						console.log("<?php echo site_url('ga/pembelian/js_viewstock_back') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4)
						$('[name="onhand"]').val(data.conhand);
						$('[name="satkecil"]').val(data.satkecil);
						$('[name="satminta"]').val(data.satkecil);
						$('#satminta_2').val(data.satkecil);
						$('[name="nmsatkecil"]').val(data.nmsatkecil);
						$('[name="desc_barang"]').val(data.nmbarang);
						$('[name="qtykecil"]').val(data.qtymapkecil);
						//$('[name="loccode"]').val(data.loccode);                                                          
						Swal.close()
					},
					error: function (jqXHR, textStatus, errorThrown) {
						Swal.close()
						alert('Error get data from ajax');
					}
				});
			};

			var paramkocok = param1 + param2 + param3;
			var url = "<?php echo site_url('ga/pembelian/add_map_satuan'); ?>/" + paramkocok;
			$('#satminta2').load(url, function (response, status, xhr) {
				if (status === "success") {
					Swal.close();
				} else {
					console.error("Load gagal:", xhr.status, xhr.statusText);
					// Jika perlu, tampilkan pesan error dengan Swal.fire()
				}
			});
			return false;
		});

		$('#qtysppbminta').change(function () {
			//console.log($('#satminta2').val().trim());

			var param1 = $('#kdgroup_inp').val().trim();
			var param2 = $('#kdsubgroup_inp').val().trim();
			var param3 = $('#kdbarang_inp').val().trim();
			var param4 = $('#satkecil').val().trim();
			var param5 = $('#satminta2').val().trim();
			//var qtyMinta=parseInt($('#qtysppbminta').val().trim());
			if ($('#qtysppbminta').val() == 'undefined' || $('#qtysppbminta').val() == '') { var qtyMinta = 0; } else { var qtyMinta = parseInt($('#qtysppbminta').val().trim()); }

			///console.log(qtKecil);
			///console.log(param3!='');
			if (param3 != '') {
				$.ajax({
					url: "<?php echo site_url('ga/pembelian/js_mapping_satuan') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4 + '/' + param5,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
						console.log($('#qtysppbminta').val());
						//console.log(param1+param2+param3+param4+param5);
						console.log("<?php echo site_url('ga/pembelian/js_mapping_satuan') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4 + '/' + param5)
						//var dataqtybesar=$(this).val(data.qty);
						//console.log(data.qty);
						var qtymap = (data.qty);
						var hasil = (qtyMinta * qtymap);

						$('[name="qtykonversi"]').val(hasil);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});
			}
		});

		$('#satminta2').change(function () {
			console.log($('#satminta2').val().trim());

			var param1 = $('#kdgroup_inp').val().trim();
			var param2 = $('#kdsubgroup_inp').val().trim();
			var param3 = $('#kdbarang_inp').val().trim();
			var param4 = $('#satkecil').val().trim();
			var param5 = $('#satminta2').val().trim();
			//var qtyMinta=parseInt($('#qtysppbminta').val().trim());
			if ($('#qtysppbminta').val() == 'undefined' || $('#qtysppbminta').val() == '') { var qtyMinta = 0; } else { var qtyMinta = parseInt($('#qtysppbminta').val().trim()); }

			///console.log(qtKecil);
			///console.log(param3!='');
			if (param3 != '') {
				$.ajax({
					url: "<?php echo site_url('ga/pembelian/js_mapping_satuan') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4 + '/' + param5,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
						console.log(param1 + param2 + param3 + param4 + param5);
						console.log("<?php echo site_url('ga/pembelian/js_mapping_satuan') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4 + '/' + param5)
						//var dataqtybesar=$(this).val(data.qty);
						console.log(data.qty);
						var qtymap = (data.qty);
						var hasil = (qtyMinta * qtymap);

						$('[name="qtykonversi"]').val(hasil);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});
			}
		});


		$('#desc_barang').change(function () {
			var vdaristock = $('#daristock').val().trim();
			var vdesc_barang = $('#desc_barang').val().trim().toUpperCase();
			if (vdaristock == 'NO') {

				//	console.log(vdesc_barang);

				$.ajax({
					url: "<?php echo site_url('ga/pembelian/js_tmp_name') ?>" + '/' + vdesc_barang,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
						console.log(vdesc_barang);
						console.log(data.desc_barang.trim());
						console.log("<?php echo site_url('ga/pembelian/js_tmp_name') ?>" + '/' + vdesc_barang)
						var init_dbarang = (data.desc_barang.trim());
						console.log(init_dbarang === vdesc_barang);
						if (init_dbarang === vdesc_barang) {
							window.confirm('Nama Barang Sudah Ada Di Inputan, Apakah Mau Dilanjutkan');
						}

					},
					error: function (jqXHR, textStatus, errorThrown) {

					}
				});


				$.ajax({
					url: "<?php echo site_url('ga/pembelian/js_viewstock_name') ?>" + '/' + vdesc_barang,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
						//	console.log(vdesc_barang);
						//	console.log("<?php echo site_url('ga/pembelian/js_viewstock_name') ?>" +'/'+ vdesc_barang)

						/*	if (data.statusajax==true) {
								var vnamabarang='';
							}  else if (data.statusajax==false) {
								var vnamabarang=(data.nmbarang).trim().toString();
							}
							console.log(vnamabarang==vdesc_barang);
							console.log(vnamabarang); */


						//console.log('hey'=='hey');
						if (data.statusajax == false) {
							$('#submitinp').prop('disabled', false);
						}

					},
					error: function (jqXHR, textStatus, errorThrown) {
						window.confirm('Nama Barang Sudah Tersedia Silahkan Pilih Ya Untuk Memilih Stock Barang');
						$('#submitinp').prop('disabled', true);

					}
				});
			} else {
				$('#submitinp').prop('disabled', false);
			}
		});


		$('.drst').hide();
		$('.satba').hide(); $('#satminta2').prop('required', false); $('#desc_barang').prop('readonly', false);
		$('#daristock').on('click', function () {
			if ($(this).val() == 'YES') {
				console.log($(this).val());
				$('.drst').prop('required', true);
				$('.drst').show();
				$('.satap').hide();
				$('.satba').show(); $('#satminta2').prop('required', true); $('#satminta').prop('required', false); $('#desc_barang').prop('readonly', true);
				$('#submitinp').prop('disabled', false);
			} else if ($(this).val() == 'NO') {
				console.log($(this).val());
				$('.drst').prop('required', false);
				$('.drst').hide();
				$('.satba').hide();
				$('.satap').show(); $('#satminta').prop('required', true); $('#satminta2').prop('required', false); $('#desc_barang').prop('readonly', false);
				$('#submitinp').prop('disabled', false);

			}
		});

		$('form').on('focus', 'input[type=number]', function (e) {
			$(this).on('mousewheel.disableScroll', function (e) {
				e.preventDefault()
			})
		})

	});
</script>
<style>
	.selectize-input {
		overflow: visible;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}

	.selectize-input.dropdown-active {
		min-height: 30px;
		line-height: normal;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}

	.selectize-dropdown,
	.selectize-input,
	.selectize-input input {
		min-height: 30px;
		line-height: normal;
	}

	.loading .selectize-dropdown-content:after {
		content: 'loading...';
		height: 30px;
		display: block;
		text-align: center;
	}
</style>
<legend><?php echo $title; ?></legend>
<h5><b><strong><?php echo TRIM($dtlnik['nmlengkap']) . '  SILAHKAN INPUT PERMINTAAN BARANG/JASA'; ?></strong></b></h5>
<span id="postmessages"></span>
<?php echo $message; ?>
<div class="row">
	<div class="col-sm-12">
		<a href="<?php echo site_url("ga/pembelian/clear_tmp_sppb/$enc_nodok") ?>" class="btn btn-default"
			onclick="return confirm('Apakah Anda Yakin Akan Reset Data Ini??')" style="margin:0px; color:#000000;"><i
				class="fa fa-arrow-left"></i> KEMBALI</a>
		<a href="<?php echo site_url("ga/pembelian/final_input_sppb/$enc_nodok") ?>" class="btn btn-success pull-right"
			onclick="return confirm('Apakah Anda Simpan Data Ini??')" style="margin:0px; color:#ffffff;"
			title="SIMPAN SEMUA INPUTAN SPPB"><i class="fa fa-save"></i> </a>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header" align="center">
						<h5><b><strong><?php echo 'MASTER SPPB'; ?></strong></b></h5>
					</div><!-- /.box-header -->
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th width="2%">No.</th>
									<th>DOKUMEN</th>
									<th>NIK</th>
									<th>NAMA LENGKAP</th>
									<th>LOCCODE</th>
									<th>SPPBTYPE</th>
									<th>STATUS</th>
									<th>TANGGAL</th>
									<th>KETERANGAN</th>
									<th width="15%">AKSI</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 0;
								foreach ($list_sppb_tmp_mst as $row):
									$no++; ?>
									<tr>

										<td width="2%"><?php echo $no; ?></td>
										<td><?php echo $row->nodok; ?></td>
										<td><?php echo $row->nik; ?></td>
										<td><?php echo $row->nmlengkap; ?></td>
										<td><?php echo $row->loccode; ?></td>
										<td><?php echo $row->itemtype; ?></td>
										<td><?php echo $row->ketstatus; ?></td>
										<td><?php echo date('d-m-Y', strtotime(trim($row->tgldok))); ?></td>
										<td><?php echo $row->keterangan; ?></td>
										<td width="8%">
											<a href="#" data-toggle="modal"
												data-target="#EDMST<?php echo str_replace('.', '', trim($row->nodok)); ?>"
												class="btn btn-primary  btn-sm" title="SIMPAN MASTER SPPB"><i
													class="fa fa-gear"></i> </a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div><!-- END ROW 1 --->

			<div class="col-xs-12">
				<!--div class="container"--->
				<a href="#" data-toggle="modal" data-target="#inputModal" style="margin:0px; color:#ffffff;"
					class="btn btn-primary btninput" title="INPUT DETAIL SPPB"><i class="fa fa-plus"></i> </a>
				<a href="<?php echo site_url("ga/pembelian/cancel_tmp_sppb_dtl/$enc_nodok") ?>"
					class="btn btn-danger pull-right"
					onclick="return confirm('Apakah Anda Yakin Akan Membatalkan Semua Detail Data Ini??')"
					style="margin:0px; color:#ffffff;" title="CLEAR DETAIL SPPB"><i class="fa fa-repeat"></i></a>
			</div>


			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example2" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th width="2%">No.</th>
									<th>KODE BARANG</th>
									<th>NAMA BARANG</th>
									<?php if (trim($dtlmst['itemtype']) == 'JSA') { ?>
									<?php } else { ?>
										<th>QTY</th>
										<th>SATUAN</th>
									<?php } ?>
									<th>STATUS</th>
									<th>KETERANGAN</th>
									<!--th>ID</th-->
									<th>AKSI</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 0;
								foreach ($list_sppb_tmp_dtl as $row):
									$no++; ?>
									<tr>

										<td width="2%"><?php echo $no; ?></td>
										<td><?php echo $row->stockcode; ?></td>
										<td><?php echo $row->desc_barang; ?></td>
										<?php if (trim($dtlmst['itemtype']) == 'JSA') { ?>
										<?php } else { ?>
											<td align="right"><?php echo $row->qtysppbminta; ?></td>
											<td align="right"><?php echo $row->nmsatminta; ?></td>
										<?php } ?>
										<td><?php echo $row->ketstatus; ?></td>
										<td><?php echo $row->keterangan; ?></td>
										<!--td><?php echo $row->id; ?></td--->
									<td width="8%">

										<!--a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok); ?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a-->
											<?php //if (trim($row->status)=='A') { ?>
											<a href="#" data-toggle="modal"
												data-target="#ED<?php echo str_replace('.', '', trim($row->nodok)) . trim($row->id); ?>"
												class="btn btn-primary  btn-sm" title="UBAH DATA DETAIL SPPB"><i
													class="fa fa-gear"></i> </a>
											<a href="#" data-toggle="modal"
												data-target="#DEL<?php echo str_replace('.', '', trim($row->nodok)) . trim($row->id); ?>"
												class="btn btn-danger  btn-sm" title="HAPUS DATA DETAIL SPPB"><i
													class="fa fa-trash-o"></i> </a>
											<? php// } ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>
</div>



<?php foreach ($list_sppb_tmp_mst as $lb) { ?>
	<div class="modal fade" id="EDMST<?php echo str_replace('.', '', trim($lb->nodok)); ?>" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">FORM EDIT MASTER PERMINTAAN BARANG MASTER SPPB</h4>
				</div>
				<form action="<?php echo site_url('ga/pembelian/save_sppb') ?>" method="post" name="inputformPbk">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="box box-danger">
									<div class="box-body">
										<div class="form-horizontal">
											<div class="form-group">
												<label class="col-sm-4">NIK</label>
												<div class="col-sm-8">
													<input type="text" id="nik" name="nik"
														value="<?php echo trim($lb->nik); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
													<input type="hidden" id="type" name="type" value="EDITTMPMST"
														class="form-control" style="text-transform:uppercase">
													<input type="hidden" id="nodok" name="nodok"
														value="<?php echo trim($lb->nodok); ?>" class="form-control"
														style="text-transform:uppercase">
													<input type="hidden" id="nodok" name="nodok"
														value="<?php echo trim($lb->nodok); ?>" class="form-control"
														style="text-transform:uppercase">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Nama Karyawan</label>
												<div class="col-sm-8">
													<input type="hidden" id="nik" name="kdlvl1"
														value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
													<input type="text" id="nik" name="kdlvl1"
														value="<?php echo trim($lb->nmlengkap); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
													<input type="hidden" id="nik" name="kdlvl"
														value="<?php echo trim($lb->lvl_jabatan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Department</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmdept); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="department"
														value="<?php echo trim($lb->bag_dept); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Sub Department</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmsubdept); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="subdepartment"
														value="<?php echo trim($lb->subbag_dept); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>


											<div class="form-group">
												<label class="col-sm-4">Jabatan</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmjabatan); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="jabatan"
														value="<?php echo trim($lb->jabatan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Nama Atasan1</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmatasan); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="atasan"
														value="<?php echo trim($lb->nik_atasan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-4">Nama Atasan2</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmatasan2); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="atasan2"
														value="<?php echo trim($lb->nik_atasan2); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
										</div>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>

							<div class="col-sm-6">
								<div class="box box-danger">
									<div class="box-body">
										<div class="form-horizontal">
											<div class="form-group">
												<label class="col-sm-4" for="inputsm">Tanggal Dokumen</label>
												<div class="col-sm-8">
													<input type="text" id="tgldok" name="tgldok"
														value="<?php echo date('d-m-Y', strtotime(trim($lb->tgldok))); ?>"
														class="form-control tgl" style="text-transform:uppercase"
														data-date-format="dd-mm-yyyy" required>
												</div>
											</div>
											<div class="form-group ">
												<label class="col-sm-4" for="inputsm">Type SPPB</label>
												<div class="col-sm-8">
													<select class="form-control input-sm" name="itemtype" id="itemtype"
														required>
														<option value="">---KODE TYPE || DESC TYPE--</option>
														<?php foreach ($list_scgroup as $sc) { ?>
															<option <?php if (trim($lb->itemtype) == trim($sc->kdgroup)) {
																echo 'selected';
															} ?> value="<?php echo trim($sc->kdgroup); ?>">
																<?php echo trim($sc->kdgroup) . ' || ' . trim($sc->nmgroup); ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group ">
												<label class="col-sm-4" for="inputsm">Lokasi Gudang</label>
												<div class="col-sm-8">
													<select class="form-control input-sm" name="loccode" id="loccode"
														required>
														<option value="">---PILIH LOKASI || DESC WILAYAH--</option>
														<?php foreach ($list_kanwil as $sc) { ?>
															<option <?php if (trim($lb->loccode) == trim($sc->loccode)) {
																echo 'selected';
															} ?> value="<?php echo trim($sc->loccode); ?>">
																<?php echo trim($sc->loccode) . ' || ' . trim($sc->locaname); ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Keterangan</label>
												<div class="col-sm-8">
													<textarea type="text" id="keterangan" name="keterangan"
														style="text-transform:uppercase"
														class="form-control"><?php echo trim($lb->keterangan); ?></textarea>
												</div>
											</div>

										</div>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<!--a href="<?php echo site_url('ga/pembelian/list_personalnikpbk'); ?>" type="button" class="btn btn-default"/> Kembali</a-->
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>


<!-------------------------- DETAIL TEMPORARY UNTUK INPUT SPPB--------------------------------------------------------------------------------------------------------------------->
<?php foreach ($list_lk as $lb) { ?>
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
						class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">FORM PERMINTAAN PEMBELIAN BARANG/JASA</h4>
			</div>
			<form action="<?php echo site_url('ga/pembelian/save_sppb') ?>" method="post" name="inputformPbk">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="box box-danger">
								<div class="box-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label class="col-sm-4">NIK</label>
											<div class="col-sm-8">
												<input type="text" id="nik" name="nik"
													value="<?php echo trim($lb->nik); ?>" class="form-control"
													style="text-transform:uppercase" maxlength="40" readonly>
												<input type="hidden" id="type" name="type" value="INPUTTMPDTLINPUT"
													class="form-control" style="text-transform:uppercase">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4">Nama Karyawan</label>
											<div class="col-sm-8">
												<input type="hidden" id="nik" name="kdlvl1"
													value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control"
													style="text-transform:uppercase" maxlength="40" readonly>
												<input type="text" id="nik" name="kdlvl1"
													value="<?php echo trim($lb->nmlengkap); ?>" class="form-control"
													style="text-transform:uppercase" maxlength="40" readonly>
												<input type="hidden" id="nik" name="kdlvl"
													value="<?php echo trim($lb->lvl_jabatan); ?>" class="form-control"
													style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4">Department</label>
											<div class="col-sm-8">
												<input type="text" value="<?php echo trim($lb->nmdept); ?>"
													class="form-control" style="text-transform:uppercase" maxlength="40"
													readonly>
												<input type="hidden" id="nik" name="department"
													value="<?php echo trim($lb->bag_dept); ?>" class="form-control"
													style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4">Sub Department</label>
											<div class="col-sm-8">
												<input type="text" value="<?php echo trim($lb->nmsubdept); ?>"
													class="form-control" style="text-transform:uppercase" maxlength="40"
													readonly>
												<input type="hidden" id="nik" name="subdepartment"
													value="<?php echo trim($lb->subbag_dept); ?>" class="form-control"
													style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>


										<div class="form-group">
											<label class="col-sm-4">Jabatan</label>
											<div class="col-sm-8">
												<input type="text" value="<?php echo trim($lb->nmjabatan); ?>"
													class="form-control" style="text-transform:uppercase" maxlength="40"
													readonly>
												<input type="hidden" id="nik" name="jabatan"
													value="<?php echo trim($lb->jabatan); ?>" class="form-control"
													style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4">Nama Atasan1</label>
											<div class="col-sm-8">
												<input type="text" value="<?php echo trim($lb->nmatasan); ?>"
													class="form-control" style="text-transform:uppercase" maxlength="40"
													readonly>
												<input type="hidden" id="nik" name="atasan"
													value="<?php echo trim($lb->nik_atasan); ?>" class="form-control"
													style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-4">Nama Atasan2</label>
											<div class="col-sm-8">
												<input type="text" value="<?php echo trim($lb->nmatasan2); ?>"
													class="form-control" style="text-transform:uppercase" maxlength="40"
													readonly>
												<input type="hidden" id="nik" name="atasan2"
													value="<?php echo trim($lb->nik_atasan2); ?>" class="form-control"
													style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>
										<div class="form-group ">
											<label class="col-sm-4" for="inputsm">Type SPPB</label>
											<div class="col-sm-8">
												<input type="text" name="itemtype"
													value="<?php echo trim($dtlmst['itemtype']); ?>"
													class="form-control" style="text-transform:uppercase" maxlength="40"
													readonly>

											</div>
										</div>
									</div>
								</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
							<div class="col-sm-6">
								<div class="box box-danger">
									<div class="box-body">
										<div class="form-horizontal">
											<div class="form-group">
												<label class="col-sm-4" for="inputsm">Pilih Dari Stock</label>
												<div class="col-sm-8">
													<input type="text" name="daristock" id="daristock" value="YES"
														class="form-control" style="text-transform:uppercase" maxlength="20"
														readonly>
												</div>
											</div>
											<?php /*
					   <div class="form-group">
						  <label class="col-sm-4" for="inputsm">Pilih Dari Stock</label>
							  <div class="col-sm-8">
							  <select class="form-control input-sm" name="daristock" id="daristock" required>
								  <option value="YES"> YA </option>
								  <!--option value="NO"> TIDAK </option--->


							  </select>
							  </div>
					  </div>
					  <div class="form-group drst">
						  <label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
							  <div class="col-sm-8">  
							  <select class="form-control input-sm drst ch" name="kdgroup" id="kdgroup" >
							   <option value="">---PILIH KODE GROUP--</option> 
								<?php foreach($list_scgroup as $sc){?>					  
								<option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
								<?php }?>
							  </select>
							  </div>
					  </div>
					  <div class="form-group drst">
						  <label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
						  <div class="col-sm-8"> 
							  <select class="form-control input-sm drst ch" name="kdsubgroup" id="kdsubgroup" >
							   <option  value="">---PILIH KODE SUB GROUP--</option> 
								<?php foreach($list_scsubgroup as $sc){?>					  
								<option value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
								<?php }?>
							  </select>
						  </div>
					  </div>
					  <div class="form-group drst">
						  <label class="col-sm-4" for="inputsm">Kode Barang</label>	
						  <div class="col-sm-8"> 
							  <select class="form-control input-sm kdbarang drst ch" name="kdbarang" id="kdbarang" >
							   <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
								<?php foreach($list_stkgdw as $sc){?>					  
								<option value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
								<?php }?>
							  </select>
						  </div>
					  </div>
					  */ ?>
											<div class="form-group drst">
												<label class="col-sm-4" for="inputsm">Kode Group Barang/Jasa</label>
												<div class="col-sm-8">
													<select name="kdgroup" class="form-control input-sm ch"
														placeholder="---KETIK KODE / NAMA GROUP---" id="kdgroup_inp"
														required>
														<option value="" class=""></option>
													</select>
												</div>
											</div>

											<script type="text/javascript">

												const loading = (message) => {
													if (typeof Swal !== 'undefined') {
														Swal.fire({
															title: message || 'Loading...',
															allowOutsideClick: false,
															didOpen: () => {
																Swal.showLoading();
															}
														});
													}
												}

												$(function () {
													var totalCount,
														page,
														perPage = 7;
													///$('[name=\'kdgroup_inp\']').selectize({
													$('#kdgroup_inp').selectize({
														plugins: ['hide-arrow', 'selectable-placeholder', 'infinite-scroll'],
														valueField: 'kdgroup',
														labelField: 'nmgroup',
														searchField: ['kdgroup', 'nmgroup'],
														options: [],
														create: false,
														render: {
															option: function (item, escape) {
																return '' +
																	'<div class=\'row\'>' +
																	'<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.kdgroup) + '</div>' +
																	'<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nmgroup) + '</div>' +
																	'</div>' +
																	'';
															}
														},
														load: function (query, callback) {
															query = JSON.parse(query);
															page = query.page || 1;

															if (!totalCount || totalCount > ((page - 1) * perPage)) {
																// loading()
																$.post(base('ga/instock/add_stock_ajax_kdgroup'), {
																	_search_: query.search,
																	_perpage_: perPage,
																	_page_: page,
																	_paramkdgroupmodul_: " and kdgroup in ('<?php echo trim($dtlmst['itemtype']); ?>') "
																})
																	.done(function (json) {
																		if (typeof Swal !== 'undefined') {
																			Swal.close();
																		}
																		console.log('JSON Data: ' + JSON.stringify(json, null, '\t'));
																		totalCount = json.totalcount;
																		callback(json.group);
																	})
																	.fail(function (jqxhr, textStatus, error) {
																		if (typeof Swal !== 'undefined') {
																			Swal.close();
																		}
																		callback();
																	});
															} else {
																callback();
															}
														}
													}).on('change click', function () {
														console.log('kdgroup_inp >> on.change');
														console.log('kdsubgroup_inp >> clear');
														//$('[name=\'kdsubgroup_inp\']')[0].selectize.clearOptions();
														$('#kdsubgroup_inp')[0].selectize.clearOptions();
													});


												});
											</script>
											<div class="form-group drst">
												<label class="col-sm-4" for="inputsm">Kode Sub Group Barang/Jasa</label>
												<div class="col-sm-8">
													<select name="kdsubgroup" class="form-control input-sm ch"
														placeholder="---KETIK / NAMA SUB GROUP---" id="kdsubgroup_inp"
														required>
														<option value="" class=""></option>
													</select>
												</div>
											</div>
											<script type="text/javascript">
												$(function () {
													var totalCount,
														page,
														perPage = 7;
													/// $('[name=\'kdsubgroup_inp\']').selectize({
													$('#kdsubgroup_inp').selectize({
														plugins: ['hide-arrow', 'selectable-placeholder', 'infinite-scroll'],
														valueField: 'kdsubgroup',
														labelField: 'nmsubgroup',
														searchField: ['kdsubgroup', 'nmsubgroup'],
														options: [],
														create: false,
														render: {
															option: function (item, escape) {
																return '' +
																	'<div class=\'row\'>' +
																	'<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.kdsubgroup) + '</div>' +
																	'<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nmsubgroup) + '</div>' +
																	'</div>' +
																	'';
															}
														},
														load: function (query, callback) {
															query = JSON.parse(query);
															page = query.page || 1;
															if (!totalCount || totalCount > ((page - 1) * perPage)) {
																$.post(base('ga/instock/add_stock_ajax_kdsubgroup'), {
																	_search_: query.search,
																	_perpage_: perPage,
																	_page_: page,
																	//_kdgroup_: $('[name=\'kdgroup_inp\']').val()
																	_kdgroup_: $('#kdgroup_inp').val()
																})
																	.done(function (json) {
																		console.log('JSON Data: ' + JSON.stringify(json, null, '\t'));
																		totalCount = json.totalcount;
																		callback(json.group);
																	})
																	.fail(function (jqxhr, textStatus, error) {
																		callback();
																	});
															} else {
																callback();
															}
														}
													}).on('change click', function () {
														console.log('_officeid_ >> on.change');
														console.log('kdgroup_inp >> clear');
														//$('[name=\'kdgroup_inp\']')[0].selectize.clearOptions();
														$('#kdbarang_inp')[0].selectize.clearOptions();
													});


												});
											</script>
											<div class="form-group drst">
												<label class="col-sm-4" for="inputsm">Nama Barang/Jasa</label>
												<div class="col-sm-8">
													<select name="kdbarang" class="form-control input-sm ch"
														placeholder="---KETIK / NAMA BARANG--" id="kdbarang_inp" required>
														<option value="" class=""></option>
													</select>
												</div>
											</div>
											<script type="text/javascript">
												$(function () {
													var totalCount,
														page,
														perPage = 7;
													//$('[name=\'kdbarang_inp\']').selectize({
													$('#kdbarang_inp').selectize({
														plugins: ['hide-arrow', 'selectable-placeholder', 'infinite-scroll'],
														valueField: 'nodok',
														labelField: 'nmbarang',
														searchField: ['nodok', 'nmbarang'],
														options: [],
														create: false,
														render: {
															option: function (item, escape) {
																return '' +
																	'<div class=\'row\'>' +
																	/*  '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.nodok) + '</div>' +*/
																	'<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nmbarang) + '</div>' +
																	'</div>' +
																	'';
															}
														},
														load: function (query, callback) {
															query = JSON.parse(query);
															page = query.page || 1;
															// loading()
															if (!totalCount || totalCount > ((page - 1) * perPage)) {
																$.post(base('ga/instock/add_stock_ajax_mbarang'), {
																	_search_: query.search,
																	_perpage_: perPage,
																	_page_: page,
																	_kdgroup_: $('#kdgroup_inp').val(),
																	_kdsubgroup_: $('#kdsubgroup_inp').val()
																})
																	.done(function (json) {
																		console.log('JSON Data: ' + JSON.stringify(json, null, '\t'));
																		totalCount = json.totalcount;
																		callback(json.group);
																		Swal.close()
																	})
																	.fail(function (jqxhr, textStatus, error) {
																		callback();
																	});
															} else {
																callback();
															}
														}
													});
													/*.on('change', function() {
														console.log('_officeid_ >> on.change');
														console.log('kdgroup_inp >> clear');
														$('[name=\'kdgroup_inp\']')[0].selectize.clearOptions();
													}); */


												});
											</script>
											<div class="form-group drst">
												<label class="col-sm-4">LOKASI GUDANG</label>
												<div class="col-sm-8">
													<input type="input" id="loccode" name="loccode"
														value="<?php echo trim($dtlmst['loccode']); ?>" class="form-control"
														readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Deskripsi Barang/Jasa</label>
												<div class="col-sm-8">
													<input type="text" id="desc_barang" name="desc_barang"
														style="text-transform:uppercase" class="form-control" required>
												</div>
											</div>
											<?php if (trim($dtlmst['itemtype']) == 'JSA') { ?>
												<div class="form-group" style="display: none;">
													<label class="col-sm-4">Quantity Permintaan</label>
													<div class="col-sm-8">
														<input type="number" id="qtysppbminta" name="qtysppbminta"
															placeholder="0" value="1" min="1" class="form-control">
													</div>
												</div>
												<div class="form-group " style="display: none;>
								<label class=" col-sm-4">SATUAN TERKECIL</label>
													<div class="col-sm-8">
														<input type="text" id="nmsatkecil" name="nmsatkecil"
															class="form-control drst" readonly>
														<input type="text" id="satkecil" name="satkecil"
															class="form-control drst" readonly>
														<input type="text" id="satminta_2" name="satminta2"
															class="form-control drst" readonly>
													</div>
												</div>


											<?php } else { ?>

												<div class="form-group drst">
													<label class="col-sm-4">QTY ONHAND</label>
													<div class="col-sm-8">
														<input type="number" id="onhand" name="onhand" placeholder="0"
															class="form-control drst" readonly>
													</div>
												</div>
												<div class="form-group drst">
													<label class="col-sm-4">SATUAN TERKECIL</label>
													<div class="col-sm-8">
														<input type="text" id="nmsatkecil" name="nmsatkecil"
															class="form-control drst" readonly>
														<input type="hidden" id="satkecil" name="satkecil"
															class="form-control drst" readonly>
													</div>
												</div>
												<div class="form-group drst">
													<label class="col-sm-4">Quantity Konversi</label>
													<div class="col-sm-8">
														<input type="text" id="qtykonversi" name="qtykonversi" placeholder="0"
															class="form-control drst" readonly>
														<!--input type="text" id="qtykecil" name="qtykecil"   placeholder="0" class="form-control" readonly --->
											</div>
										</div>
										<div class="form-group satap">
											<label class="col-sm-4" for="inputsm">Kode Satuan</label>
											<div class="col-sm-8">
												<select class="form-control input-sm" name="satminta" id="satminta"
													required>
													<option value="">---PILIH JENIS SATUAN || NAMA SATUAN--</option>
													<?php foreach ($trxqtyunit as $sc) { ?>
													<option value="<?php echo trim($sc->kdtrx); ?>">
														<?php echo trim($sc->uraian); ?>
													</option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-4">Quantity Permintaan</label>
											<div class="col-sm-8">
												<input type="number" id="qtysppbminta" name="qtysppbminta"
													placeholder="0" min="1" class="form-control" required>
											</div>
										</div>

										<div class="form-group satba">
											<label class="col-sm-4" for="inputsm">Kode Satuan</label>
											<div class="col-sm-8">
												<select class="form-control input-sm" name="satminta2" id="satminta2"
													required>
													<option value="">---PILIH JENIS SATUAN || NAMA SATUAN--</option>
													<!--?php foreach($trxqtyunit as $sc){ ?>
														  <option value="<?php echo trim($sc->kdtrx); ?>"><?php echo trim($sc->uraian); ?></option>
														  <!--?php } ?---->
														</select>
													</div>
												</div>

											<?php } ?>
											<div class="form-group">
												<label class="col-sm-4">Keterangan</label>
												<div class="col-sm-8">
													<textarea type="text" id="keterangan" name="keterangan"
														style="text-transform:uppercase" class="form-control"
														required></textarea>
												</div>
											</div>

										</div>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<!--a href="<?php echo site_url('ga/pembelian/list_personalnikpbk'); ?>" type="button" class="btn btn-default"/> Kembali</a-->
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" id="submitinp" class="btn btn-primary">SIMPAN</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>




<?php foreach ($list_sppb_tmp_dtl as $lb) { ?>
	<div class="modal fade" id="ED<?php echo str_replace('.', '', trim($lb->nodok)) . trim($lb->id); ?>" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">FORM EDIT PERMINTAAN BARANG</h4>
				</div>
				<form action="<?php echo site_url('ga/pembelian/save_sppb') ?>" method="post" name="inputformPbk">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="box box-danger">
									<div class="box-body">
										<div class="form-horizontal">
											<div class="form-group">
												<label class="col-sm-4">NIK</label>
												<div class="col-sm-8">
													<input type="text" id="nik" name="nik"
														value="<?php echo trim($lb->nik); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
													<input type="hidden" id="type" name="type" value="EDITTMPDTLINPUT"
														class="form-control" style="text-transform:uppercase">
													<input type="hidden" id="nodok" name="nodok"
														value="<?php echo trim($lb->nodok); ?>" class="form-control"
														style="text-transform:uppercase">
													<input type="hidden" id="id" name="id"
														value="<?php echo trim($lb->id); ?>" class="form-control"
														style="text-transform:uppercase">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Nama Karyawan</label>
												<div class="col-sm-8">
													<input type="hidden" id="nik" name="kdlvl1"
														value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
													<input type="text" id="nik" name="kdlvl1"
														value="<?php echo trim($lb->nmlengkap); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
													<input type="hidden" id="nik" name="kdlvl"
														value="<?php echo trim($lb->lvl_jabatan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Department</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmdept); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="department"
														value="<?php echo trim($lb->bag_dept); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Sub Department</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmsubdept); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="subdepartment"
														value="<?php echo trim($lb->subbag_dept); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>


											<div class="form-group">
												<label class="col-sm-4">Jabatan</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmjabatan); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="jabatan"
														value="<?php echo trim($lb->jabatan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Nama Atasan1</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmatasan); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="atasan"
														value="<?php echo trim($lb->nik_atasan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-4">Nama Atasan2</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmatasan2); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="atasan2"
														value="<?php echo trim($lb->nik_atasan2); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
										</div>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>

							<div class="col-sm-6">
								<div class="box box-danger">
									<div class="box-body">
										<div class="form-horizontal">
											<div class="form-group">
												<label class="col-sm-4" for="inputsm">Pilih Dari Stock</label>
												<div class="col-sm-8">
													<select class="form-control input-sm" name="daristock" disabled
														readonly>
														<option <?php if ('NO' == trim($lb->fromstock)) {
															echo 'selected';
														} ?> value="NO"> TIDAK </option>
														<option <?php if ('YES' == trim($lb->fromstock)) {
															echo 'selected';
														} ?> value="YES"> YA </option>
													</select>
												</div>
											</div>
											<?php if ('YES' == trim($lb->fromstock)) { ?>
												<div class="form-group ">
													<label class="col-sm-4" for="inputsm">Kode Group Barang</label>
													<div class="col-sm-8">
														<select class="form-control input-sm " disabled readonly>
															<option value="">---PILIH KODE GROUP--</option>
															<?php foreach ($list_scgroup as $sc) { ?>
																<option <?php if (trim($sc->kdgroup) == trim($lb->kdgroup)) {
																	echo 'selected';
																} ?> value="<?php echo trim($sc->kdgroup); ?>">
																	<?php echo trim($sc->kdgroup) . ' || ' . trim($sc->nmgroup); ?>
																</option>
															<?php } ?>
														</select>
													</div>
													<input type="hidden" name="kdgroup" id="kdgroup"
														value="<?php echo trim($lb->kdgroup); ?>" class="form-control ">
												</div>
												<div class="form-group ">
													<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>
													<div class="col-sm-8">
														<select class="form-control input-sm " disabled readonly>
															<option value="">---PILIH KODE SUB GROUP--</option>
															<?php foreach ($list_scsubgroup as $sc) { ?>
																<option <?php if (trim($sc->kdsubgroup) == trim($lb->kdsubgroup)) {
																	echo 'selected';
																} ?> value="<?php echo trim($sc->kdsubgroup); ?>"
																	class="<?php echo trim($sc->kdgroup); ?>">
																	<?php echo trim($sc->kdsubgroup) . ' || ' . trim($sc->nmsubgroup); ?>
																</option>
															<?php } ?>
														</select>
													</div>
													<input type="hidden" name="kdsubgroup" id="kdsubgroup"
														value="<?php echo trim($lb->kdsubgroup); ?>" class="form-control ">
												</div>
												<div class="form-group ">
													<label class="col-sm-4" for="inputsm">Kode Barang</label>
													<div class="col-sm-8">
														<select class="form-control input-sm kdbarang " name="kdbarang"
															id="kdbarang" disabled readonly>
															<option value="">---PILIH KDBARANG || NAMA BARANG--</option>
															<?php foreach ($list_stkgdw as $sc) { ?>
																<option <?php if (trim($sc->stockcode) == trim($lb->stockcode)) {
																	echo 'selected';
																} ?> value="<?php echo trim($sc->stockcode); ?>"
																	class="<?php echo trim($sc->kdsubgroup); ?>">
																	<?php echo trim($sc->stockcode) . ' || ' . trim($sc->nmbarang); ?>
																</option>
															<?php } ?>
														</select>
													</div>
													<input type="hidden" name="kdbarang" id="kdbarang"
														value="<?php echo trim($lb->stockcode); ?>" class="form-control ">
												</div>
												<div class="form-group ">
													<label class="col-sm-4">LOKASI GUDANG</label>
													<div class="col-sm-8">
														<input type="text" id="loccode" name="loccode"
															value="<?php echo trim($lb->loccode); ?>" class="form-control "
															readonly>
													</div>
												</div>
												<?php if (trim($dtlmst['itemtype']) == 'JSA') { ?>
													<input type="hidden" id="onhand" name="onhand"
														value="<?php echo trim($lb->qtyrefonhand); ?>" placeholder="0"
														class="form-control " readonly>
													<input type="hidden" id="desc_barang" name="desc_barang"
														value="<?php echo trim($lb->desc_barang); ?>"
														style="text-transform:uppercase" class="form-control" <?php if ('YES' == trim($lb->fromstock)) { ?> readonly <?php } ?>>
												<?php } else { ?>
													<div class="form-group ">
														<label class="col-sm-4">QTY ONHAND</label>
														<div class="col-sm-8">
															<input type="number" id="onhand" name="onhand"
																value="<?php echo trim($lb->qtyrefonhand); ?>" placeholder="0"
																class="form-control " readonly>
														</div>
													</div>

												<?php }
											} ?>
											<div class="form-group">
												<label class="col-sm-4">Nama Barang</label>
												<div class="col-sm-8">
													<input type="text" id="desc_barang" name="desc_barang"
														value="<?php echo trim($lb->desc_barang); ?>"
														style="text-transform:uppercase" class="form-control" <?php if ('YES' == trim($lb->fromstock)) { ?> readonly <?php } ?>>
												</div>
											</div>
											<?php if ('YES' == trim($lb->fromstock)) { ?>
												<?php if (trim($dtlmst['itemtype']) == 'JSA') { ?>
													<input type="hidden" id="qtysppbkecil" name="qtysppbkecil" placeholder="0"
														class="form-control" value="<?php echo trim($lb->qtysppbkecil); ?>"
														readonly>
												<?php } else { ?>
													<div class="form-group ">
														<label class="col-sm-4">Quantity Konversi</label>
														<div class="col-sm-8">
															<input type="text" id="qtysppbkecil" name="qtysppbkecil" placeholder="0"
																class="form-control" value="<?php echo trim($lb->qtysppbkecil); ?>"
																readonly>
															<!--input type="text" id="qtykecil" name="qtykecil"   placeholder="0" class="form-control" readonly --->
											</div>
										</div>
										<?php }
											} ?>

										<?php if (trim($dtlmst['itemtype']) == 'JSA') { ?>
										<input type="hidden" id="nmsatkecil" name="nmsatkecil"
											value="<?php echo trim($lb->nmsatkecil); ?>" class="form-control " readonly>
										<input type="hidden" id="satkecil" name="satkecil"
											value="<?php echo trim($lb->satkecil); ?>" class="form-control " readonly>
										<input type="hidden" id="qtysppbminta" name="qtysppbminta"
											value="<?php echo trim($lb->qtysppbminta); ?>" placeholder="0"
											class="form-control" readonly>
										<?php } else { ?>
										<div class="form-group ">
											<label class="col-sm-4">SATUAN TERKECIL</label>
											<div class="col-sm-8">
												<input type="text" id="nmsatkecil" name="nmsatkecil"
													value="<?php echo trim($lb->nmsatkecil); ?>" class="form-control "
													readonly>
												<input type="hidden" id="satkecil" name="satkecil"
													value="<?php echo trim($lb->satkecil); ?>" class="form-control "
													readonly>
											</div>
										</div>
										<!--div class="form-group ">
								<label class="col-sm-4">QTY KECIL</label>	
								<div class="col-sm-8">    
									<input type="number" id="qtysppbkecil" name="qtysppbkecil"  value="<?php echo trim($lb->qtysppbkecil); ?>"   placeholder="0" class="form-control " readonly >
								</div>
							</div--->

										<div class="form-group">
											<label class="col-sm-4">Quantity Permintaan</label>
											<div class="col-sm-8">
												<input type="number" id="qtysppbminta" name="qtysppbminta"
													value="<?php echo trim($lb->qtysppbminta); ?>" placeholder="0"
													class="form-control" min="1" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4" for="inputsm">Kode Satuan</label>
											<div class="col-sm-8">
												<select class="form-control input-sm" name="satminta" id="satminta"
													required>
													<!--option  value="">---PILIH KDSATUAN || NAMA SATUAN--</option--->
													<!--?php foreach($trxqtyunit as $sc){?--->
													<option value="<?php echo trim($lb->satminta); ?>">
														<?php echo trim($lb->nmsatminta); ?>
													</option>
													<!--?php }?--->
												</select>
											</div>
										</div>

										<?php } ?>
										<div class="form-group">
											<label class="col-sm-4">Keterangan</label>
											<div class="col-sm-8">
												<textarea type="text" id="keterangan" name="keterangan"
													style="text-transform:uppercase"
													class="form-control"><?php echo trim($lb->keterangan); ?></textarea>
											</div>
										</div>

									</div>
								</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<!--a href="<?php echo site_url('ga/pembelian/list_personalnikpbk'); ?>" type="button" class="btn btn-default"/> Kembali</a-->
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>





<?php foreach ($list_sppb_tmp_dtl as $lb) { ?>
	<div class="modal fade" id="DEL<?php echo str_replace('.', '', trim($lb->nodok)) . trim($lb->id); ?>" tabindex="-1"
		role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">HAPUS PERMINTAAN BARANG</h4>
				</div>
				<form action="<?php echo site_url('ga/pembelian/save_sppb') ?>" method="post" name="inputformPbk">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="box box-danger">
									<div class="box-body">
										<div class="form-horizontal">
											<div class="form-group">
												<label class="col-sm-4">NIK</label>
												<div class="col-sm-8">
													<input type="text" id="nik" name="nik"
														value="<?php echo trim($lb->nik); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
													<input type="hidden" id="type" name="type" value="DELETETMPDTLINPUT"
														class="form-control" style="text-transform:uppercase">
													<input type="hidden" id="nodok" name="nodok"
														value="<?php echo trim($lb->nodok); ?>" class="form-control"
														style="text-transform:uppercase">
													<input type="hidden" id="id" name="id"
														value="<?php echo trim($lb->id); ?>" class="form-control"
														style="text-transform:uppercase">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Nama Karyawan</label>
												<div class="col-sm-8">
													<input type="hidden" id="nik" name="kdlvl1"
														value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
													<input type="text" id="nik" name="kdlvl1"
														value="<?php echo trim($lb->nmlengkap); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
													<input type="hidden" id="nik" name="kdlvl"
														value="<?php echo trim($lb->lvl_jabatan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Department</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmdept); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="department"
														value="<?php echo trim($lb->bag_dept); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Sub Department</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmsubdept); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="subdepartment"
														value="<?php echo trim($lb->subbag_dept); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>


											<div class="form-group">
												<label class="col-sm-4">Jabatan</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmjabatan); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="jabatan"
														value="<?php echo trim($lb->jabatan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Nama Atasan1</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmatasan); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="atasan"
														value="<?php echo trim($lb->nik_atasan); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-4">Nama Atasan2</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo trim($lb->nmatasan2); ?>"
														class="form-control" style="text-transform:uppercase" maxlength="40"
														readonly>
													<input type="hidden" id="nik" name="atasan2"
														value="<?php echo trim($lb->nik_atasan2); ?>" class="form-control"
														style="text-transform:uppercase" maxlength="40" readonly>
												</div>
											</div>
										</div>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>

							<div class="col-sm-6">
								<div class="box box-danger">
									<div class="box-body">
										<div class="form-horizontal">
											<?php if ('YES' == trim($lb->fromstock)) { ?>
												<div class="form-group ">
													<label class="col-sm-4" for="inputsm">Kode Group Barang</label>
													<div class="col-sm-8">
														<select class="form-control input-sm " readonly disabled>
															<option value="">---PILIH KODE GROUP--</option>
															<?php foreach ($list_scgroup as $sc) { ?>
																<option <?php if (trim($sc->kdgroup) == trim($lb->kdgroup)) {
																	echo 'selected';
																} ?> value="<?php echo trim($sc->kdgroup); ?>">
																	<?php echo trim($sc->kdgroup) . ' || ' . trim($sc->nmgroup); ?>
																</option>
															<?php } ?>
														</select>
													</div>
													<input type="hidden" name="kdgroup" id="kdgroup"
														value="<?php echo trim($lb->kdgroup); ?>" class="form-control ">
												</div>

												<div class="form-group ">
													<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>
													<div class="col-sm-8">
														<select class="form-control input-sm " readonly disabled>
															<option value="">---PILIH KODE SUB GROUP--</option>
															<?php foreach ($list_scsubgroup as $sc) { ?>
																<option <?php if (trim($sc->kdsubgroup) == trim($lb->kdsubgroup)) {
																	echo 'selected';
																} ?> value="<?php echo trim($sc->kdsubgroup); ?>"
																	class="<?php echo trim($sc->kdgroup); ?>">
																	<?php echo trim($sc->kdsubgroup) . ' || ' . trim($sc->nmsubgroup); ?>
																</option>
															<?php } ?>
														</select>
													</div>
													<input type="hidden" name="kdsubgroup" id="kdsubgroup"
														value="<?php echo trim($lb->kdsubgroup); ?>" class="form-control ">
												</div>
												<div class="form-group ">
													<label class="col-sm-4" for="inputsm">Kode Barang</label>
													<div class="col-sm-8">
														<select class="form-control input-sm kdbarang " name="kdbarang"
															id="kdbarang" readonly disabled>
															<option value="">---PILIH KDBARANG || NAMA BARANG--</option>
															<?php foreach ($list_stkgdw as $sc) { ?>
																<option <?php if (trim($sc->stockcode) == trim($lb->stockcode)) {
																	echo 'selected';
																} ?> value="<?php echo trim($sc->stockcode); ?>"
																	class="<?php echo trim($sc->kdsubgroup); ?>">
																	<?php echo trim($sc->stockcode) . ' || ' . trim($sc->nmbarang); ?>
																</option>
															<?php } ?>
														</select>
													</div>
													<input type="hidden" name="kdbarang" id="kdbarang"
														value="<?php echo trim($lb->stockcode); ?>" class="form-control ">
												</div>
												<div class="form-group ">
													<label class="col-sm-4">LOKASI GUDANG</label>
													<div class="col-sm-8">
														<input type="text" id="loccode" name="loccode"
															value="<?php echo trim($lb->loccode); ?>" class="form-control "
															readonly disabled>
													</div>
												</div>
											<?php } ?>
											<div class="form-group drst">
												<label class="col-sm-4">SATUAN TERKECIL</label>
												<div class="col-sm-8">
													<input type="text" id="satkecil" name="satkecil"
														value="<?php echo trim($lb->satkecil); ?>" class="form-control drst"
														readonly>
												</div>
											</div>
											<div class="form-group drst">
												<label class="col-sm-4">QTY KECIL</label>
												<div class="col-sm-8">
													<input type="number" id="qtysppbkecil" name="qtysppbkecil"
														value="<?php echo trim($lb->qtysppbkecil); ?>" placeholder="0"
														class="form-control drst" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Quantity Permintaan</label>
												<div class="col-sm-8">
													<input type="number" id="qtysppbminta" name="qtysppbminta"
														value="<?php echo trim($lb->qtysppbminta); ?>" placeholder="0"
														class="form-control" min="1" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4" for="inputsm">Kode Satuan</label>
												<div class="col-sm-8">
													<select class="form-control input-sm" name="satminta" id="satminta"
														disabled readonly>
														<option value="">---PILIH KDSATUAN || NAMA SATUAN--</option>
														<?php foreach ($trxqtyunit as $sc) { ?>
															<option <?php if (trim($sc->kdtrx) == trim($lb->satminta)) {
																echo 'selected';
															} ?> value="<?php echo trim($sc->kdtrx); ?>">
																<?php echo trim($sc->kdtrx) . ' || ' . trim($sc->uraian); ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Nama Barang</label>
												<div class="col-sm-8">
													<input type="text" id="desc_barang" name="desc_barang"
														value="<?php echo trim($lb->desc_barang); ?>"
														style="text-transform:uppercase" class="form-control" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Keterangan</label>
												<div class="col-sm-8">
													<textarea type="text" id="keterangan" name="keterangan"
														style="text-transform:uppercase" class="form-control" disabled
														readonly><?php echo trim($lb->keterangan); ?></textarea>
												</div>
											</div>

										</div>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<!--a href="<?php echo site_url('ga/pembelian/list_personalnikpbk'); ?>" type="button" class="btn btn-default"/> Kembali</a-->
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" id="submit" class="btn btn-danger">HAPUS</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>