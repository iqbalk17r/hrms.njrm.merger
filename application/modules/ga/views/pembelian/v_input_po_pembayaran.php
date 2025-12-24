<script type="text/javascript">
	$(function () {
		$("#example1").dataTable({
			language: {
				aria: {
					sortAscending: ': activate to sort column ascending',
					sortDescending: ': activate to sort column descending',
				},
				emptyTable: 'Tidak ada data yang dapat ditampilkan dari tabel ini...',
				info: 'Menampilkan _START_  sampai _END_  dari _TOTAL_ baris data...',
				infoEmpty: 'Tidak ada baris data...',
				infoFiltered: '(_TOTAL_  terfilter dari _MAX_ total baris data)',
				lengthMenu: '_MENU_ baris...',
				search: 'Pencarian:',
				zeroRecords: 'Tidak ada baris data yang cocok...',
				buttons: {
					copyTitle: 'Menyalin ke clipboard',
					copySuccess: {
						_: 'Disalin %d baris ke clipboard...',
						1: 'Disalin 1 baris ke clipboard...',
					}
				},
				paginate: {
					first: '<i class=\'fa fa-angle-double-left\'></i>',
					previous: '<i class=\'fa fa-angle-left\'></i>',
					next: '<i class=\'fa fa-angle-right\'></i>',
					last: '<i class=\'fa fa-angle-double-right\'></i>',
				},
				processing: 'Memproses...',
			},
			orderCellsTop: true,
			stateSave: false, //state cache
			stateDuration: 60 * 60 * 2,
			responsive: false,
			select: false,
			pagingType: 'full_numbers',
			order: [
				[0, 'asc']
			],
			lengthMenu: [
				[5, 10, 15, 20, 50, 100, 500, 1000, -1],
				[5, 10, 15, 20, 50, 100, 500, 1000, 'Semua']
			],
			pageLength: 5,
			columnDefs: [{
				orderable: false,
				targets: [-1]
			}, {
				searchable: false,
				targets: [-1]
			}, {
				// visible: false,
				// targets: [5]
			}]
		});
		$("#example2").dataTable({
			language: {
				aria: {
					sortAscending: ': activate to sort column ascending',
					sortDescending: ': activate to sort column descending',
				},
				emptyTable: 'Tidak ada data yang dapat ditampilkan dari tabel ini...',
				info: 'Menampilkan _START_  sampai _END_  dari _TOTAL_ baris data...',
				infoEmpty: 'Tidak ada baris data...',
				infoFiltered: '(_TOTAL_  terfilter dari _MAX_ total baris data)',
				lengthMenu: '_MENU_ baris...',
				search: 'Pencarian:',
				zeroRecords: 'Tidak ada baris data yang cocok...',
				buttons: {
					copyTitle: 'Menyalin ke clipboard',
					copySuccess: {
						_: 'Disalin %d baris ke clipboard...',
						1: 'Disalin 1 baris ke clipboard...',
					}
				},
				paginate: {
					first: '<i class=\'fa fa-angle-double-left\'></i>',
					previous: '<i class=\'fa fa-angle-left\'></i>',
					next: '<i class=\'fa fa-angle-right\'></i>',
					last: '<i class=\'fa fa-angle-double-right\'></i>',
				},
				processing: 'Memproses...',
			},
			orderCellsTop: true,
			stateSave: false, //state cache
			stateDuration: 60 * 60 * 2,
			responsive: false,
			select: false,
			pagingType: 'full_numbers',
			order: [
				[0, 'asc']
			],
			lengthMenu: [
				[5, 10, 15, 20, 50, 100, 500, 1000, -1],
				[5, 10, 15, 20, 50, 100, 500, 1000, 'Semua']
			],
			pageLength: 5,
			columnDefs: [{
				orderable: false,
				targets: [-1]
			}, {
				searchable: false,
				targets: [-1]
			}, {
				// visible: false,
				// targets: [5]
			}]
		});
		$("#example3").dataTable();
		$("#table3").dataTable();
		$("#table4").dataTable();
		$("#dateinput").datepicker();
		$("#dateinput1").datepicker();
		$("#dateinput2").datepicker();
		$("#dateinput3").datepicker();
		$("[data-mask]").inputmask();

		$('#mpkdbarang').change(function () {
			console.log($('#loccode').val() != '');

			var param1 = $('#mpkdgroup').val();
			var param2 = $('#mpkdsubgroup').val();
			var param3 = $('#mpkdbarang').val();
			var param4 = $('#mploccode').val();
			console.log(param1 + param2 + param3 + param4);
			if ((param1 != '') && (param2 != '') && (param3 != '') && (param4 != '')) {
				$.ajax({
					url: "<?php echo site_url('ga/pembelian/js_viewstock_back') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
						console.log(data.conhand);
						console.log(data.satkecil);
						console.log(data.nmsatkecil);
						console.log("<?php echo site_url('ga/pembelian/js_viewstock_back') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4)
						$('[name="onhand"]').val(data.conhand);
						$('[name="satkecil"]').val(data.satkecil);
						$('[name="nmsatkecil"]').val(data.nmsatkecil);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});
			};
		});
	});
</script>

<legend><?php echo $title; ?></legend>
<span id="postmessages"></span>

<div class="row">
	<div class="col-sm-1">
		<a onclick="cancelPembayaran('<?= $nodok ?>')" class="btn btn-default" style="margin:10px; color:#000000;"><i
				class="fa fa-arrow-left"> </i>Kembali</a>
	</div>
	<button class="btn btn-primary pull-right" style="margin:10px; color:#ffffff;" id="saveButton"
		onclick="savePembayaran('<?= $nodok ?>')">Simpan</button>

	<div class="col-xs-12">
		<div class="box">
			<div class="box-header" align="center">
				<h5><b><strong>
							<?php echo 'MASTER INPUT SUPPLIER PURCHASING ORDER'; ?>
						</strong></b></h5>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="2%">No.</th>
							<th>NODOK</th>
							<th>PO DATE</th>
							<th>PO TYPE</th>
							<th>NAMA SUPPLIER</th>
							<th>CABANG SUPPLIER</th>
							<th>SUBTOTAL</th>
							<th>STATUS</th>
							<th>KETERANGAN</th>
							<!-- <th>AKSI</th> -->

						</tr>
					</thead>
					<tbody>
						<?php $totalnetto = 0;
						$no = 0;
						foreach ($list_trx_po_mst as $row):
							$no++; ?>
							<tr>

								<td width="2%"><?php echo $no; ?></td>
								<td><?php echo $row->nodok; ?></td>
								<td><?php echo date('d-m-Y', strtotime(trim($row->podate))); ?></td>
								<td><?php echo $row->itemtype; ?></td>
								<td><?php echo $row->nmsubsupplier; ?></td>
								<td><?php echo $row->kdcabangsupplier; ?></td>
								<td align="right"><?php $totalnetto = $row->ttlnetto;
								echo $row->ttlnetto; ?></td>
								<td><?php echo $row->ketstatus; ?></td>
								<td><?php echo $row->keterangan; ?></td>
								<!-- <td width="8%">
									<a href="<?php
									$enc_nodok = bin2hex($this->encrypt->encode(trim($row->nodok)));
									echo site_url("ga/pembelian/detail_supplier_po_mst/$enc_nodok"); ?>"
										onclick="return confirm('Detail Supplier')" class="btn btn-default  btn-sm-1"><i
											class="fa fa-check-square"></i></a>
								</td> -->
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- END ROW 1 --->
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header" align="center">
				<h5><b><strong>
							<?php echo 'DETAIL PURCHASING ORDER'; ?>
						</strong></b></h5>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="2%">No.</th>
							<th>NODOK</th>
							<th>NAMA BARANG</th>
							<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
								<th>QTYKECIL</th>
								<th>SATUAN KECIL</th>
								<th>QTYMINTA</th>
								<th>SATUAN MINTA</th>
							<?php } ?>
							<th>TOTAL NETTO</th>
							<th>STATUS</th>
							<th>KETERANGAN</th>
							<!-- <th>AKSI</th> -->
						</tr>
					</thead>
					<tbody>
						<?php $no = 0;
						foreach ($list_trx_po_dtl as $row):
							$no++; ?>
							<tr>
								<td width="2%"><?php echo $no; ?></td>
								<td><?php echo $row->nodok; ?></td>
								<td><?php echo $row->nmbarang; ?></td>
								<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
									<td align="right"><?php echo $row->qtykecil; ?></td>
									<td align="right"><?php echo $row->nmsatkecil; ?></td>
									<td align="right"><?php echo $row->qtyminta; ?></td>
									<td align="right"><?php echo $row->nmsatbesar; ?></td>
								<?php } ?>
								<td align="right"><?php echo $row->ttlnetto; ?></td>
								<td><?php echo $row->ketstatus; ?></td>
								<td><?php echo $row->keterangan; ?></td>
								<!-- <td width="8%">
									<a href="<?php
									$enc_rowid = bin2hex($this->encrypt->encode(trim($row->rowselect)));
									echo site_url("ga/pembelian/detail_po_dtl/$enc_rowid"); ?>"
										onclick="return confirm('Anda Akan Masuk Ke Menu Mapping Satuan Rekap?')"
										class="btn btn-default  btn-sm-1"><i class="fa fa-check-square"></i></a>
								</td> -->
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<form role="form" action="<?php echo site_url("ga/pembelian/kurang_itempo"); ?>" method="post">
			<div class="box">
				<div class="box-header">
					<h4 align="center"><?php echo 'LIST DETAIL REFERENSI'; ?></h4>
					<?php if ($cek_full_mappdtlref > 0) { ?>
						<!--button class="btn btn-primary pull-left" onClick="TEST" style="margin:10px; color:#ffffff;" type="submit"
										<?php if ($row_dtlref == 0) { ?> disabled <?php } ?>> << </button>
										<a href="<?php echo site_url('ga/pembelian/reset_po_dtlrev'); ?>" type="button" style="margin:10px; color:#000000;"   onclick="return confirm('Detail Akan Tereset seluruhnya apakah anda yakin?')"  class="btn btn-default  pull-right"/> RESET</a--->
					<?php } ?>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive" style='overflow-x:scroll;'>
					<table id="table3" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>DOKUMEN REV</th>
								<th>NAMA BARANG</th>
								<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
									<th>QTY</th>
									<th>SATUAN</th>
									<th>QTY BBM</th>
									<th>SATUAN</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php $no = 0;
							foreach ($list_trx_po_dtlref as $lu):
								$no++; ?>
								<tr>
									<td width="2%"><?php echo $no; ?></td>
									<!--td width="8%">
														 <input type="checkbox" name="centang[]" value="<?php echo trim($lu->rowid); ?>" ><br>
												</td--->
								<td>
									<?php echo $lu->nodokref; ?>
								</td>
								<td>
									<?php echo $lu->nmbarang; ?>
								</td>
								<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
								<td align="right">
									<?php echo $lu->qtyminta; ?>
								</td>
								<td align="right">
									<?php echo $lu->nmsatminta; ?>
								</td>
								<td align="right">
									<?php echo $lu->qtyterima; ?>
								</td>
								<td align="right">
									<?php echo $lu->nmsatminta; ?>
								</td>
								<?php } ?>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<input type="hidden" name="nik" value="<?php echo ''; ?>">
					<input type="hidden" name="username" value="<?php echo ''; ?>">
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</form>
	</div>
</div>
<div class="row">
	<div class="col-sm-1">
		<div class="dropdown ">
			<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1"
				type="button" data-toggle="dropdown">Menu Input<span class="caret"></span></button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
				<li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#INPUTPEMBAYARAN"
						tabindex="-1" href="#">Input Pembayaran</a></li>
			</ul>
		</div>
	</div><!-- /.box-header -->
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="box box-success">
			<div class="box-header">
				<h4 align="center">LIST PEMBAYARAN</h4>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table4" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>NOMOR PEMBAYARAN</th>
							<th>DOKUMEN REV</th>
							<th>TANGGAL PEMBAYARAN</th>
							<th>TIPE PEMBAYARAN</th>
							<th>KETERANGAN</th>
							<th>NOMINAL PEMBAYARAN</th>
							<th>AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php $tmpnetto = 0;
						$no = 0;
						foreach ($trx_po_pembayaran as $lu):
							$no++; ?>
							<tr>
								<td width="2%"><?php echo $no; ?></td>
								<td>
									<?php echo $lu->nodok; ?>
								</td>
								<td>
									<?php echo $lu->nodokref; ?>
								</td>
								<td>
									<?php echo date('d-m-Y', strtotime($lu->tgl)); ?>
								</td>
								<td>
									<?php echo $lu->payment_type; ?>
								</td>
								<td>
									<?php echo $lu->keterangan; ?>
								</td>
								<td>
									<?php $tmpnetto += $lu->nnetto;
									echo $lu->nnetto; ?>
								</td>
								<td>

								</td>
							</tr>
						<?php endforeach;
						foreach ($tmp_po_pembayaran as $lu):
							$no++; ?>
							<tr>
								<td width="2%"><?php echo $no; ?></td>
								<td>
									<?php echo $lu->nodok; ?>
								</td>
								<td>
									<?php echo $lu->nodokref; ?>
								</td>
								<td>
									<?php echo date('d-m-Y', strtotime($lu->tgl)); ?>
								</td>
								<td>
									<?php echo $lu->payment_type; ?>
								</td>
								<td>
									<?php echo $lu->keterangan; ?>
								</td>
								<td>
									<?php $tmpnetto += $lu->nnetto;
									echo $lu->nnetto; ?>
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#EDITPEMBAYARAN"
										class="btn btn-primary btn-sm" title="UBAH PEMBAYARAN"
										onclick="$('#EDITPEMBAYARAN #nodokref').val('<?php echo trim($lu->nodokref); ?>');$('#EDITPEMBAYARAN #id').val('<?php echo trim($lu->id); ?>');$('#EDITPEMBAYARAN #nomorpembayaran').val('<?php echo trim($lu->nodok); ?>');$('#EDITPEMBAYARAN #tgl').val('<?php echo date('d-m-Y', strtotime($lu->tgl)); ?>');$('#EDITPEMBAYARAN #tipe_pembayaran').val('<?php echo trim($lu->payment_type); ?>');$('#EDITPEMBAYARAN #nnetto').val('<?php echo $lu->nnetto; ?>');$('#EDITPEMBAYARAN #keterangan').val('<?php echo trim($lu->keterangan); ?>');"><i
											class="fa fa-gear"></i></a>
									<a onclick="deletePembayaran(<?php echo $lu->id; ?>)" class="btn btn-danger btn-sm"
										title="HAPUS PEMBAYARAN"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<input type="hidden" name="nik" value="<?php echo ''; ?>">
				<input type="hidden" name="username" value="<?php echo ''; ?>">
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>

<div class="modal fade" id="INPUTPEMBAYARAN" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
						class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">INPUT MASTER PEMBAYARAN</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="save_input_po_pembayaran" method="post">
					<div class='row'>
						<div class='col-sm-6'>
							<div class="form-group">
								<label for="inputsm">NO DOKUMEN REFERENSI</label>
								<input type="text" class="form-control input-sm" id="nodokref" name="nodokref"
									style="text-transform:uppercase" maxlength="35" value="<?php echo trim($nodok); ?>"
									readonly>
								<input type="hidden" class="form-control input-sm" id="nodoktmp" name="nodoktmp"
									style="text-transform:uppercase" maxlength="35" value="<?php echo trim($nodok); ?>"
									readonly>
							</div>
							<div class="form-group">
								<label for="inputsm">NOMOR PEMBAYARAN</label>
								<input type="text" class="form-control input-sm" id="nomorpembayaran"
									name="nomorpembayaran" style="text-transform:uppercase" maxlength="25" required
									oninput="this.value = this.value.replace(/\s/g, '')">
							</div>
							<div class="form-group">
								<label for="inputsm">KETERANGAN</label>
								<textarea class="textarea" name="keterangan" placeholder="Keterangan" maxlength="159"
									style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"
									onkeyup="this.value=this.value.toUpperCase();"></textarea>
							</div>
						</div> <!---- col 1 -->
						<div class='col-sm-6'>
							<div class="form-group">
								<label for="inputsm">TANGGAL PEMBAYARAN</label>
								<input type="text" class="form-control input-sm tglsm" id="tgl" name="tgl"
									data-date-format="dd-mm-yyyy" required>
							</div>
							<div class="form-group">
								<label for="inputsm">JENIS Pembayaran</label>
								<select class="form-control input-sm" name="tipe_pembayaran">
									<option value="TUNAI"> TUNAI </option>
									<option value="DP">
										DP
									</option>
								</select>
							</div>
							<div class="form-group">
								<label for="inputsm">NOMINAL</label>
								<input type="number" class="form-control input-sm" id="nnetto" name="nnetto"
									style="text-transform:uppercase" maxlength="20" placeholder="0" required>
							</div>

						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="EDITPEMBAYARAN" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
						class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">EDIT PEMBAYARAN</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="update_input_po_pembayaran" method="post">
					<div class='row'>
						<div class='col-sm-6'>
							<input type="hidden" id="id" name="id">
							<div class="form-group">
								<label for="inputsm">NO DOKUMEN REFERENSI</label>
								<input type="text" class="form-control input-sm" id="nodokref" name="nodokref"
									style="text-transform:uppercase" maxlength="35" value="<?php echo trim($nodok); ?>"
									readonly>
								<input type="hidden" class="form-control input-sm" id="nodoktmp" name="nodoktmp"
									style="text-transform:uppercase" maxlength="35" value="<?php echo trim($nodok); ?>"
									readonly>
							</div>
							<div class="form-group">
								<label for="inputsm">NOMOR PEMBAYARAN</label>
								<input type="text" class="form-control input-sm" id="nomorpembayaran"
									name="nomorpembayaran" style="text-transform:uppercase" maxlength="25" required
									oninput="this.value = this.value.replace(/\s/g, '')">
							</div>
							<div class="form-group">
								<label for="inputsm">KETERANGAN</label>
								<textarea class="textarea" name="keterangan" placeholder="Keterangan" maxlength="159"
									style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"
									onkeyup="this.value=this.value.toUpperCase();"></textarea>
							</div>
						</div> <!---- col 1 -->
						<div class='col-sm-6'>
							<div class="form-group">
								<label for="inputsm">TANGGAL PEMBAYARAN</label>
								<input type="text" class="form-control input-sm tglsm" id="tgl" name="tgl"
									data-date-format="dd-mm-yyyy" required>
							</div>
							<div class="form-group">
								<label for="inputsm">JENIS Pembayaran</label>
								<select class="form-control input-sm" id="tipe_pembayaran" name="tipe_pembayaran">
									<option value="TUNAI"> TUNAI </option>
									<option value="DP">
										DP
									</option>
								</select>
							</div>
							<div class="form-group">
								<label for="inputsm">NOMINAL</label>
								<input type="number" class="form-control input-sm" id="nnetto" name="nnetto"
									style="text-transform:uppercase" maxlength="20" placeholder="0" required>
							</div>

						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('#tgl').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true
		});
		$('#EDITPEMBAYARAN #tgl').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true
		});

		$('#save_input_po_pembayaran').submit(function (e) {
			e.preventDefault();
			var totalnetto = <?php echo (int) $totalnetto; ?>;
			var newPayment = parseInt($(this).find('input[name="nnetto"]').val()) || 0;
			var totalPayment = <?php echo (int) $tmpnetto; ?> + newPayment;

			if (totalPayment > totalnetto) {
				Swal.fire({
					title: 'Gagal!',
					text: `Total pembayaran (${totalPayment.toLocaleString('id-ID')}) tidak boleh melebihi total tagihan (${totalnetto.toLocaleString('id-ID')}).`,
					icon: 'error'
				});
				return;
			}

			var formData = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: '<?php echo site_url('ga/pembelian/save_input_po_pembayaran'); ?>',
				data: formData,
				success: function (response) {
					if (response.type === 'success') {
						$('#INPUTPEMBAYARAN').modal('hide');
						Swal.fire({
							title: 'Success',
							text: response.message,
							icon: response.type,
							timer: 3000,
							showConfirmButton: false
						}).then(() => {
							location.reload();
						});
					} else {
						Swal.fire('Error', response.message, response.type);
					}
				}
			});
		});
		$('#update_input_po_pembayaran').submit(function (e) {
			e.preventDefault();
			var formData = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: '<?php echo site_url('ga/pembelian/update_input_po_pembayaran'); ?>',
				data: formData,
				success: function (response) {
					if (response.type === 'success') {
						$('#EDITPEMBAYARAN').modal('hide');
						Swal.fire({
							title: 'Success',
							text: response.message,
							icon: response.type,
							timer: 3000,
							showConfirmButton: false
						}).then(() => {
							location.reload();
						});
					} else {
						Swal.fire('Error', response.message, response.type);
					}
				},
				error: function () {
					Swal.fire(
						'Gagal!',
						'Terjadi kesalahan saat menyimpan data.',
						'error'
					);
				}
			});
		});
	});
	function deletePembayaran(id) {
		Swal.fire({
			title: 'Anda yakin ingin menghapus data ini?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, hapus!',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: 'POST',
					url: '<?php echo site_url('ga/pembelian/delete_input_po_pembayaran_temp'); ?>',
					data: { id: id },
					success: function (response) {
						if (response.type === 'success') {
							Swal.fire('Deleted!', response.message, 'success').then(() => {
								location.reload();
							});
						} else {
							Swal.fire('Error', response.message, 'error');
						}
					},
					error: function () {
						Swal.fire(
							'Gagal!',
							'Terjadi kesalahan saat menyimpan data.',
							'error'
						);
					}
				});
			}
		});
	}
	function cancelPembayaran(nodokref) {
		<?php if (!empty(($tmp_po_pembayaran))): ?>
			Swal.fire({
				title: 'Anda yakin ingin membatalkan input?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya!',
				cancelButtonText: 'Tidak'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: 'POST',
						url: '<?php echo site_url('ga/pembelian/cancel_input_po_pembayaran_temp'); ?>',
						data: { nodokref: nodokref },
						success: function (response) {
							if (response.type === 'success') {
								Swal.fire('Deleted!', response.message, 'success').then(() => {
									window.location.href = response.link;
								});
							} else {
								Swal.fire('Error', response.message, response.type);
							}
						},
						error: function () {
							Swal.fire(
								'Gagal!',
								'Terjadi kesalahan saat menyimpan data.',
								'error'
							);
						}
					});
				}
			});
		<?php else: ?>
			window.location.href = '<?php echo site_url('ga/pembelian/form_pembelian'); ?>';
		<?php endif; ?>
	}
	function savePembayaran(nodokref) {
		Swal.fire({
			title: 'Anda Yakin Dengan Inputan Yang Anda Buat?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Simpan!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: "<?php echo site_url('ga/pembelian/final_save_po_pembayaran/') ?>",
					type: "POST",
					data: { nodokref: nodokref },
					success: function (response) {
						if (response.type === 'success') {
							Swal.fire({
								title: 'Success',
								text: response.message,
								icon: response.type,
								timer: 3000,
								showConfirmButton: false
							}).then(() => {
								window.location.href = response.link;
							});
						} else {
							Swal.fire('Error', response.message, response.type);
						}
					},
					error: function () {
						Swal.fire(
							'Gagal!',
							'Terjadi kesalahan saat menyimpan data.',
							'error'
						);
					}
				});
			}
		});
	}
</script>