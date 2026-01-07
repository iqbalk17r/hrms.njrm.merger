<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<style>
	/*-- change navbar dropdown color --*/
	.navbar-default .navbar-nav .open .dropdown-menu>li>a,
	.navbar-default .navbar-nav .open .dropdown-menu {
		background-color: #008040;
		color: #ffffff;
	}
</style>
<script type="text/javascript">
	$(function () {
		$("#example1").dataTable();
		$("#example2").dataTable();
		$("#example3").dataTable();
		$("#example4").dataTable();

		$("#kdsubbengkelin").chained("#kdbengkelin");
		$("#kdsubbengkeled").chained("#kdbengkeled");
	});
	history.pushState(null, null, location.href);
	window.onpopstate = function () {
		history.go(1);
	};

</script>

</br>


<legend><?php echo $title . ' ' . trim($nodok); ?></legend>
<?php echo $message; ?>
<!--div><a href="<?php echo site_url('ga/inventaris/list_perawatan'); ?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
<div--->

<div class="row">
	<div class="col-sm-1">
		<a onclick="cancelInputFaktur('<?= $nodok ?>')" class="btn btn-default" style="margin:10px; color:#000000;"><i
				class="fa fa-arrow-left"> </i>Kembali</a>
	</div>
	<button class="btn btn-primary pull-right" style="margin:10px; color:#ffffff;" id="saveButton"
		onclick="saveFinalFaktur('<?= $nodok ?>')">Simpan</button>
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
						<?php $no = 0;
						foreach ($list_trx_po_mst as $row):
							$no++; ?>
							<tr>
								<td width="2%"><?php echo $no; ?></td>
								<td><?php echo $row->nodok; ?></td>
								<td><?php echo date('d-m-Y', strtotime(trim($row->podate))); ?></td>
								<td><?php echo $row->itemtype; ?></td>
								<td><?php echo $row->nmsubsupplier; ?></td>
								<td><?php echo $row->kdcabangsupplier; ?></td>
								<td align="right"><?php $ttlnetto = $row->ttlnetto;
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
						<?php $no = 0;
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
									<?php echo $lu->nnetto; ?>
								</td>
								<td>

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
<div class="row">
	<div class="col-sm-1">
		<div class="dropdown ">
			<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1"
				type="button" data-toggle="dropdown">Menu Input<span class="caret"></span></button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
				<li role="presentation"><a role="menuitem" data-toggle="modal" data-target="#INPUTFAKTUR" tabindex="-1"
						href="#">INPUT FAKTUR</a></li>
			</ul>
		</div>
	</div><!-- /.box-header -->
</div>
<div class="row">
	<div class="box col-lg-12">
		<div class="box-header">
			<legend><?php echo 'MASTER FAKTUR UPLOAD INVOICE'; ?></legend>
		</div><!-- /.box-header -->
		<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<table id="example3" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th width="2%">No.</th>
						<th>NODOK</th>
						<th>NODOKREF</th>
						<th>ID FAKTUR</th>
						<th>TANGGAL FAKTUR</th>
						<th>TOTAL BIAYA</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $tmpnetto = 0;
					$no = 0;
					foreach ($perawatan_mst_lampiran as $row):
						$no++; ?>
						<tr>
							<td width="2%"><?php echo $no; ?></td>
							<td><?php echo $row->nodok; ?></td>
							<td><?php echo $row->nodokref; ?></td>
							<td><?php echo $row->idfaktur; ?></td>
							<td><?php if (empty($row->tgl)) {
								echo '';
							} else {
								echo date('d-m-Y', strtotime(trim($row->tgl)));
							} ?>
							</td>
							<td><?php $tmpnetto += $row->nnetto;
							echo $row->nnetto; ?></td>
							<td width="7%">
								<a href="<?php
								$enc_strtrimref = bin2hex($this->encrypt->encode(trim($row->nodok) . trim($row->nodokref) . trim($row->idfaktur)));
								echo site_url('ga/pembelian/edit_po_mst_lampiran') . '/' . $enc_strtrimref; ?>"
									class="btn btn-success  btn-sm">
									<i class="fa fa-edit"></i> DETAIL
								</a>
								<a href="#" data-toggle="modal" data-target="#EDITFAKTUR" class="btn btn-primary  btn-sm"
									onclick="$('#EDITFAKTUR #nodokref').val('<?php echo trim($row->nodokref); ?>');$('#EDITFAKTUR #id').val('<?php echo trim($row->id); ?>');$('#EDITFAKTUR #idfaktur').val('<?php echo trim($row->idfaktur); ?>');$('#EDITFAKTUR #nomorpembayaran').val('<?php echo trim($row->nodok); ?>');$('#EDITFAKTUR #tgl').val('<?php echo date('d-m-Y', strtotime($row->tgl)); ?>');$('#EDITFAKTUR #tipe_pembayaran').val('<?php echo trim($row->payment_type); ?>');$('#EDITFAKTUR #nnetto').val('<?php echo $row->nnetto; ?>');$('#EDITFAKTUR #keterangan').val('<?php echo trim($row->keterangan); ?>');">
									<i class="fa fa-edit"></i> EDIT
								</a>
								<?php if (trim($row->rowcount) == 0) { ?>
									<a onclick="deletePembayaran(<?php echo $row->id; ?>)" class="btn btn-danger btn-sm"
										title="HAPUS PEMBAYARAN"><i class="fa fa-trash"></i> HAPUS
									</a>
								<?php } ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div><!-- /.row -->

<div class="modal fade" id="INPUTFAKTUR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form role="form" method="post" id="form-input-faktur">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span
							aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">INPUT MASTER FAKTUR UPLOAD DOKUMEN </h4>
				</div>
				<div class="modal-body">
					<div class='row'>
						<div class='col-sm-6'>
							<div class="form-group">
								<label for="inputsm">NO DOKUMEN PO</label>
								<input type="text" class="form-control input-sm" id="nodok" name="nodok"
									style="text-transform:uppercase" maxlength="25" value="<?php echo trim($nodok); ?>"
									readonly>
								<input type="hidden" class="form-control input-sm" id="type" name="type"
									value="INPUTEDITTMPMSTFAKTUR">
							</div>
							<div class="form-group">
								<label for="inputsm">NO DOKUMEN PEMBAYARAN</label>
								<input type="text" class="form-control input-sm" id="nodokref" name="nodokref"
									style="text-transform:uppercase" maxlength="35" readonly>
								<input type="hidden" class="form-control input-sm" id="nodoktmp" name="nodoktmp"
									style="text-transform:uppercase" maxlength="35" value="<?php echo trim($nodok); ?>"
									readonly>
							</div>
							<div class="form-group">
								<label for="inputsm">PEMBAYARAN</label>
								<select class="form-control input-sm" id="pembayaran" name="pembayaran"
									onchange="set_val_pembayaran(this.value)">
									<option value="" data-tgl="" data-keterangan="" data-nservis="" data-ndiskon=""
										data-ndpp="" data-nppn="" data-nnetto="">---PILIH PEMBAYARAN--</option>
									<?php foreach ($trx_po_pembayaran as $sc) { ?>
										<option value="<?= $sc->id ?>" data-tgl="<?= $sc->tgl ?>"
											data-keterangan="<?= $sc->keterangan ?>" data-nodok="<?= $sc->nodok ?>"
											data-nnetto="<?= $sc->nnetto ?>">
											<?= $sc->tipe_pembayaran . ' ' . $sc->nnetto ?>
										</option>
									<?php } ?>
								</select>
							</div>

							<script>
								function set_val_pembayaran(val) {
									var option = $("#INPUTFAKTUR #pembayaran option:selected");
									$("#INPUTFAKTUR #tgl").val(option.data("tgl"));
									$("#INPUTFAKTUR #keterangan").val(option.data("keterangan"));
									$("#INPUTFAKTUR #nnetto").val(option.data("nnetto"));
									$("#INPUTFAKTUR #nodokref").val(option.data("nodok"));
								}
							</script>
							<div class="form-group">
								<label for="inputsm">NOMOR FAKTUR</label>
								<input type="text" class="form-control input-sm" id="idfaktur" name="idfaktur"
									style="text-transform:uppercase" maxlength="25" required>
							</div>
						</div> <!---- col 1 -->
						<div class='col-sm-6'>
							<div class="form-group">
								<label for="inputsm">TANGGAL FAKTUR</label>
								<input type="text" class="form-control input-sm tglsm" id="tgl" name="tgl"
									data-date-format="dd-mm-yyyy" required>
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control input-sm" name="jnsperawatan" id="jnsperawatan"
									style="text-transform:uppercase" maxlength="25"
									value="<?php echo trim($dtl_mst['jnsperawatan']); ?>">
							</div>
							<div class="form-group">
								<label for="inputsm">TOTAL NETTO</label>
								<input type="number" class="form-control input-sm" id="nnetto" name="nnetto"
									style="text-transform:uppercase" maxlength="20" placeholder="0" required>
							</div>
							<div class="form-group">
								<label for="inputsm">KETERANGAN</label>
								<textarea class="textarea" id="keterangan" name="keterangan" placeholder="Keterangan"
									maxlength="159"
									style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btn-submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="EDITFAKTUR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form role="form" method="post" id="form-edit-faktur">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span
							aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">EDIT MASTER FAKTUR UPLOAD DOKUMEN </h4>
				</div>
				<div class="modal-body">
					<div class='row'>
						<div class='col-sm-6'>
							<div class="form-group">
								<label for="inputsm">NO DOKUMEN PO</label>
								<input type="text" class="form-control input-sm" id="nodok" name="nodok"
									style="text-transform:uppercase" maxlength="25" value="<?php echo trim($nodok); ?>"
									readonly>
								<input type="hidden" class="form-control input-sm" id="type" name="type"
									value="EDITEDITTMPMSTFAKTUR">
								<input type="hidden" class="form-control input-sm" id="id" name="id">
							</div>
							<div class="form-group">
								<label for="inputsm">NO DOKUMEN PEMBAYARAN</label>
								<input type="text" class="form-control input-sm" id="nodokref" name="nodokref"
									style="text-transform:uppercase" maxlength="35" readonly>
								<input type="hidden" class="form-control input-sm" id="nodoktmp" name="nodoktmp"
									style="text-transform:uppercase" maxlength="35" value="<?php echo trim($nodok); ?>"
									readonly>
							</div>
							<div class="form-group">
								<label for="inputsm">PEMBAYARAN</label>
								<select class="form-control input-sm" id="pembayaran" name="pembayaran"
									onchange="set_val_pembayaran_edit(this.value)">
									<option value="" data-tgl="" data-keterangan="" data-nservis="" data-ndiskon=""
										data-ndpp="" data-nppn="" data-nnetto="">---PILIH PEMBAYARAN--</option>
									<?php foreach ($trx_po_pembayaran as $sc) { ?>
										<option value="<?= $sc->id ?>" data-tgl="<?= $sc->tgl ?>"
											data-keterangan="<?= $sc->keterangan ?>" data-nodok="<?= $sc->nodok ?>"
											data-nnetto="<?= $sc->nnetto ?>">
											<?= $sc->tipe_pembayaran . ' ' . $sc->nnetto ?>
										</option>
									<?php } ?>
								</select>
							</div>

							<script>
								function set_val_pembayaran_edit(val) {
									var option = $("#EDITFAKTUR #pembayaran option:selected");
									$("#EDITFAKTUR #tgl").val(option.data("tgl"));
									$("#EDITFAKTUR #keterangan").val(option.data("keterangan"));
									$("#EDITFAKTUR #nnetto").val(option.data("nnetto"));
									$("#EDITFAKTUR #nodokref").val(option.data("nodok"));
								}
							</script>
							<div class="form-group">
								<label for="inputsm">NOMOR FAKTUR</label>
								<input type="text" class="form-control input-sm" id="idfaktur" name="idfaktur"
									style="text-transform:uppercase" maxlength="25" required>
							</div>
						</div> <!---- col 1 -->
						<div class='col-sm-6'>
							<div class="form-group">
								<label for="inputsm">TANGGAL FAKTUR</label>
								<input type="text" class="form-control input-sm tglsm" id="tgl" name="tgl"
									data-date-format="dd-mm-yyyy" required>
							</div>
							<div class="form-group">
								<input type="hidden" class="form-control input-sm" name="jnsperawatan" id="jnsperawatan"
									style="text-transform:uppercase" maxlength="25"
									value="<?php echo trim($dtl_mst['jnsperawatan']); ?>">
							</div>
							<div class="form-group">
								<label for="inputsm">TOTAL NETTO</label>
								<input type="number" class="form-control input-sm" id="nnetto" name="nnetto"
									style="text-transform:uppercase" maxlength="20" placeholder="0" required>
							</div>
							<div class="form-group">
								<label for="inputsm">KETERANGAN</label>
								<textarea class="textarea" id="keterangan" name="keterangan" placeholder="Keterangan"
									maxlength="159"
									style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btn-submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(".tgl").daterangepicker();
	$(".tglsm").datepicker();

	$(".tglan").datepicker();
	$('.year').datepicker({
		format: " yyyy",
		viewMode: "years",
		minViewMode: "years"

	});

	$('#form-input-faktur').submit(function (e) {
		e.preventDefault();
		var formData = new FormData(this);

		var totalnetto = <?php echo (int) $ttlnetto; ?>;
		var newPayment = parseInt(formData.get('nnetto')) || 0;
		var totalPayment = <?php echo (int) $tmpnetto; ?> + newPayment;

		if (totalPayment > totalnetto) {
			Swal.fire({
				title: 'Gagal!',
				text: `Total faktur (${totalPayment.toLocaleString('id-ID')}) tidak boleh melebihi total tagihan (${totalnetto.toLocaleString('id-ID')}).`,
				icon: 'error'
			});
			return;
		}

		$.ajax({
			type: 'POST',
			url: '<?php echo site_url('ga/pembelian/save_input_po_faktur'); ?>',
			data: formData,
			processData: false, // penting!
			contentType: false, // penting!
			success: function (response) {
				if (response.type === 'success') {
					$('#INPUTFAKTUR').modal('hide');
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

	$('#form-edit-faktur').submit(function (e) {
		e.preventDefault();
		var formData = $(this).serialize();
		$.ajax({
			type: 'POST',
			url: '<?php echo site_url('ga/pembelian/update_input_po_faktur'); ?>',
			data: formData,
			success: function (response) {
				if (response.type === 'success') {
					$('#EDITTFAKTUR').modal('hide');
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
					url: '<?php echo site_url('ga/pembelian/delete_input_po_faktur_temp'); ?>',
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
	function cancelInputFaktur(nodok) {
		Swal.fire({
			title: 'Anda yakin ingin membatalkan transaksi ini?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, batalkan!',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: 'POST',
					url: '<?php echo site_url('ga/pembelian/cancel_input_po_faktur'); ?>',
					data: { nodok: nodok },
					success: function (response) {
						if (response.type === 'success') {
							Swal.fire({
								title: 'Deleted!',
								text: response.message,
								icon: response.type,
								timer: 3000,
								showConfirmButton: false
							}).then(() => {
								window.location.href = response.link;
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
	function saveFinalFaktur(nodok) {
		Swal.fire({
			title: 'Anda yakin ingin menyimpan transaksi ini?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, simpan!',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: 'POST',
					url: '<?php echo site_url('ga/pembelian/save_final_po_faktur'); ?>',
					data: { nodok: nodok },
					success: function (response) {
						if (response.type === 'success') {
							Swal.fire('Success', response.message, 'success').then(() => {
								window.location.href = response.link;
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
</script>