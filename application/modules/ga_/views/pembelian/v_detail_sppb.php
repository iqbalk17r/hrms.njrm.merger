<script type="text/javascript">
	$(function () {
		$("#example1").dataTable();
		$("#example2").dataTable();
		$("#example3").dataTable();
		$("#dateinput").datepicker();
		$("#dateinput1").datepicker();
		$("#dateinput2").datepicker();
		$("#dateinput3").datepicker();
		$("[data-mask]").inputmask();
		$("#kdsubgroup").chained("#kdgroup");
		$("#kdbarang").chained("#kdsubgroup");
		$('.kdbarang').change(function () {
			console.log($('#kdbarang').val() != '');
			if ($('#kdbarang').val() != '') {
				var param1 = $(this).val();
				$.ajax({
					url: "<?php echo site_url('ga/pembelian/js_viewstock') ?>/" + param1,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
						$('[name="onhand"]').val(data.conhand);
						$('[name="loccode"]').val(data.loccode);

					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});
			};
		});
		$('.drst').hide();
		$('#daristock').on('click', function () {
			if ($(this).val() == 'YES') {
				console.log($(this).val());
				$('.drst').prop('required', true);
				$('.drst').show();
			} else if ($(this).val() == 'NO') {
				console.log($(this).val());
				$('.drst').prop('required', false);
				$('.drst').hide();
			}
		});
		$('#daristockED').on('click', function () {
			if ($(this).val() == 'YES') {
				console.log($(this).val());
				$('.drst').prop('required', true);
				$('.drst').show();
			} else if ($(this).val() == 'NO') {
				console.log($(this).val());
				$('.drst').prop('required', false);
				$('.drst').hide();
			}
		});


	});
</script>

<legend><?php echo $title; ?></legend>
<h5><b><strong><?php echo TRIM($dtlnik['nmlengkap']) . ' Detail SPPB'; ?></strong></b></h5>
<span id="postmessages"></span>
<?php echo $message; ?>

<div class="row">
	<div class="col-sm-12">
		<a href="<?php echo site_url("ga/pembelian/form_sppb") ?>" class="btn btn-default"
			style="margin:10px; color:#000000;">Kembali</a>
		<?php if (trim($sppb_mst['status']) == 'A') { ?>
			<!--a href="<!?php
			//$enc_nodok=bin2hex($this->encrypt->encode(trim($sppb_mst['nodok'])));
			//echo site_url("ga/pembelian/resend_sms_sppb/$enc_nodok")?>"  class="btn btn-default pull-right" style="margin:10px; color:#000000;"><i class="fa fa-repeat"></i> Resend SMS</a-->
		<?php } ?>
	</div>
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
								<th>NODOK</th>
								<th>NIK</th>
								<th>NAMA LENGKAP</th>
								<th>LOCCODE</th>
								<th>STATUS</th>
								<th>KETERANGAN</th>
								<th>SPPB TYPE</th>
								<th>INPUTBY</th>
								<th>INPUTDATE</th>
								<th>APPROVALBY</th>
								<th>APPROVALDATE</th>
								<!--th>AKSI</th-->
							</tr>
						</thead>
						<tbody>
							<?php $no = 0;
							foreach ($list_sppb_trx_mst as $row):
								$no++; ?>
								<tr>

									<td width="2%"><?php echo $no; ?></td>
									<td><?php echo $row->nodok; ?></td>
									<td><?php echo $row->nik; ?></td>
									<td><?php echo $row->nmlengkap; ?></td>
									<td><?php echo $row->loccode; ?></td>
									<td><?php echo trim($row->ketstatus); ?></td>
									<td><?php echo trim($row->keterangan); ?></td>
									<td><?php echo trim($row->itemtype); ?></td>
									<td><?php echo trim($row->inputby); ?></td>
									<td><?php echo date('d-m-Y', strtotime(trim($row->inputdate))); ?></td>
									<td><?php echo trim($row->approvalby); ?></td>
									<td><?php if (isset($row->approvaldate)) {
										echo date('d-m-Y', strtotime(trim($row->approvaldate)));
									} else {
										echo '';
									} ?>
									</td>
									<!--td>
									<a href="#" data-toggle="modal" data-target="#ED<?php echo str_replace('.', '', trim($row->nodok)) . trim($row->id); ?>" class="btn btn-success  btn-sm"><i class="fa fa-default"></i> Detail </a>
									<?php  /*if (trim($row->status)=='A'){ 
														  <a href="#" data-toggle="modal" data-target="#APPPBK1<?php echo trim($row->nodok); ?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> APROVAL </a>
														  php }  */ ?>
									</td--->
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- END ROW 1 --->
		<div class="col-xs-12">
			<div class="row">
				<!--div class="col-sm-1">	
						<div class="dropdown ">
							<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
							<span class="caret"></span></button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
							  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
							  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#inputModal"  href="#">INPUT PERMINTAAN</a></li> 
							</ul>
						</div>
				</div>.box-header -->

			</div>
			<div class="box">
				<div class="box-header" align="center">
					<h5><b><strong><?php echo 'DETAIL SPPB'; ?></strong></b></h5>
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
									<th>QTY SPPB</th>
									<th>SATUAN</th>
								<?php } ?>
								<th>STATUS</th>
								<th>KETERANGAN</th>
								<th>AKSI</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 0;
							foreach ($list_sppb_trx_dtl as $row):
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
									<td width="6%">
										<a href="#" data-toggle="modal"
											data-target="#DTL<?php echo str_replace('.', '', trim($row->nodok)) . trim($row->id); ?>"
											class="btn btn-default  btn-sm"><i class="fa fa-default"></i> Detail </a>
										<!--a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->nodok) . trim($row->kdgroup) . trim($row->kdsubgroup) . trim($row->stockcode); ?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT </a--->
									<!--a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->nodok) . trim($row->kdgroup) . trim($row->kdsubgroup) . trim($row->stockcode); ?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> HAPUS </a-->

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

<!------------------------------------------------------------------------------------------------------------------------------------------------------->

<?php foreach ($list_sppb_trx_dtl as $lb) { ?>
<div class="modal fade" id="DTL<?php echo str_replace('.', '', trim($lb->nodok)) . trim($lb->id); ?>" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
						class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">FORM DETAIL PERMINTAAN BARANG</h4>
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
													<select class="form-control input-sm" name="daristock" id="daristock"
														disabled readonly>
														<option <?php if ('NO' == trim($lb->fromstock)) {
															echo 'selected';
														} ?>
															value="NO"> TIDAK </option>
														<option <?php if ('YES' == trim($lb->fromstock)) {
															echo 'selected';
														} ?>
															value="YES"> YA </option>
													</select>
												</div>
											</div>
											<?php if ('YES' == trim($lb->fromstock)) { ?>
												<div class="form-group ">
													<label class="col-sm-4" for="inputsm">Kode Group Barang/Jasa</label>
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
													<label class="col-sm-4" for="inputsm">Kode Sub Group Barang/Jasa</label>
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
												<div class="form-group">
													<label class="col-sm-4">Nama Barang/Jasa</label>
													<div class="col-sm-8">
														<input type="text" id="desc_barang" name="desc_barang"
															value="<?php echo trim($lb->desc_barang); ?>"
															style="text-transform:uppercase" class="form-control" <?php if ('YES' == trim($lb->fromstock)) { ?> readonly <?php } ?>>
													</div>
												</div>
												<div class="form-group ">
													<label class="col-sm-4">LOKASI GUDANG</label>
													<div class="col-sm-8">
														<input type="text" id="loccode" name="loccode"
															value="<?php echo trim($lb->loccode); ?>" class="form-control "
															readonly>
													</div>
												</div>
											<?php } ?>

											<?php if ('YES' == trim($lb->fromstock)) { ?>
												<?php if (trim($dtlmst['itemtype']) == 'JSA') { ?>
													<input type="hidden" id="qtysppbkecil" name="qtysppbkecil" placeholder="0"
														class="form-control" value="<?php echo trim($lb->qtysppbkecil); ?>" readonly>
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
										<input type="hidden" id="satminta" name="satminta"
											value="<?php echo trim($lb->satminta); ?>" class="form-control " readonly>
										<input type="hidden" id="qtysppbminta" name="qtysppbminta"
											value="<?php echo trim($lb->qtysppbminta); ?>" placeholder="0"
											class="form-control" readonly>
										<?php } else { ?>
										<div class="form-group ">
											<label class="col-sm-4">QTY ONHAND</label>
											<div class="col-sm-8">
												<input type="number" id="onhand" name="onhand"
													value="<?php echo trim($lb->qtyrefonhand); ?>" placeholder="0"
													class="form-control " readonly>
											</div>
										</div>
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
													class="form-control" required>
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
													style="text-transform:uppercase" class="form-control " disabled
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
						<!--button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button--->
				</div>
			</form>
		</div>
	</div>
</div>
<?php } ?>


<script type="text/javascript">
	$(function () {
		/* 		var rad = document.inputformPbk.optradio;
				var prev = null;
				for(var i = 0; i < rad.length; i++) {
					rad[i].onclick = function() {
						(prev)? console.log(prev.value):null;
						if(this !== prev) {
							prev = this;
						}
						console.log(this.value)
					};
				}
		
		
			$('#lookstockno').on('click change', function(e) {
				console.log(e.type);
			});
			
			$('#lookstockyes').onclick(function(){
					console.log('yes1');
		
				});
				 */
	});

	//Date range picker
	$("#tgl").datepicker();
	$(".tgl").datepicker();
	$(".tglan").datepicker();
	$('.year').datepicker({
		format: " yyyy",
		viewMode: "years",
		minViewMode: "years"

	});

</script>