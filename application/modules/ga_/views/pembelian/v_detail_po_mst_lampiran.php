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
</script>

</br>


<legend><?php echo 'FAKTUR LAMPIRAN EXTERNAL        :  ' . trim($dtl_mst['idfaktur']); ?></legend>
<?php echo $message; ?>
<div class="row">
	<div class="col-sm-1">
		<a href="<?= $_SERVER['HTTP_REFERER'] ?>" type="button" style="margin:10px; color:#000000;"
			class="btn btn-default" /> Kembali</a>
	</div>
</div>
</br>
<div class="row">
	<div class="box col-lg-12">
		<div class="box-header">
			<legend><?php echo 'MASTER FAKTUR DAN RINCIAN TOTAL HARGA'; ?></legend>
		</div><!-- /.box-header -->
		<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th width="2%">No.</th>
						<th>NODOK</th>
						<th>NODOKREF</th>
						<th>ID FAKTUR</th>
						<th>NAMA BARANG</th>
						<th>NOMINAL</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 0;
					foreach ($po_detail_lampiran as $row):
						$no++; ?>
						<tr>
							<td width="2%"><?php echo $no; ?></td>
							<td><?php echo $row->nodok; ?></td>
							<td><?php echo $row->nodokref; ?></td>
							<td><?php echo $row->idfaktur; ?></td>
							<td><?php echo $row->keterangan; ?></td>
							<td align='right'><?php echo $row->nnetto; ?></td>
							<td width="15%">
								<a href="#" data-toggle="modal" data-target="#DTLRINCIAN<?php echo trim($row->id); ?>"
									class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> DETAIL
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div><!-- /.box-body -->
	</div><!-- /.box -->

	<div class="box col-lg-12">
		<label for="berlaku" class="col-sm-7 control-label">BERKAS DAN LAMPIRAN NOTA/FAKTUR/INVOICE</label>
		<table id="example3" class="box-body table table-bordered table-striped">
			<thead>
				<tr>
					<td>No</td>
					<td>Origin Name</td>
					<td>Unduh Daftar Lampiran Nota/Faktur/Invoice</td>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				foreach ($dtllamp_at as $at) { ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo trim($at->orig_name); ?></td>
						<td><a href="#"
								onclick="window.open('<?php echo site_url('assets/attachment/att_po') . '/' . $at->file_name; ?>')"><?php echo $at->file_name; ?></a>
						</td>
					</tr>
					<?php $no++;
				} ?>
			</tbody>
		</table>
	</div><!-- /.row -->

	<?php foreach ($po_detail_lampiran as $ls) { ?>
		<div class="modal fade" id="DTLRINCIAN<?php echo trim($ls->id); ?>" tabindex="-1" role="dialog"
			aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span
								aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">DETAIL RINCIAN FAKTUR </h4>
					</div>
					<div class="modal-body">
						<form role="form" action="<?php echo site_url('ga/inventaris/save_spk_lampiran'); ?>" method="post">
							<div class='row'>
								<div class='col-sm-6'>
									<div class="form-group">
										<label for="inputsm">NO DOKUMEN SPK</label>
										<input type="text" class="form-control input-sm" id="nodok" name="nodok"
											style="text-transform:uppercase" maxlength="25"
											value="<?php echo trim($dtl_mst['nodok']); ?>" readonly>
										<input type="hidden" class="form-control input-sm" id="strtrimref" name="strtrimref"
											style="text-transform:uppercase" maxlength="50"
											value="<?php echo bin2hex($this->encrypt->encode(trim($dtl_mst['strtrimref']))); ?>"
											readonly>
										<input type="hidden" class="form-control input-sm" id="id" name="id"
											style="text-transform:uppercase" maxlength="50"
											value="<?php echo trim($ls->id); ?>" readonly>
										<input type="hidden" class="form-control input-sm" id="type" name="type"
											value="DTLDTLEDITFAKTUR">
									</div>
									<div class="form-group">
										<label for="inputsm">NO DOKUMEN REFERENSI</label>
										<input type="text" class="form-control input-sm" id="nodokref" name="nodokref"
											style="text-transform:uppercase" maxlength="35"
											value="<?php echo trim($dtl_mst['nodokref']); ?>" readonly>
									</div>
									<div class="form-group">
										<label for="inputsm">NOMOR FAKTUR</label>
										<input type="text" class="form-control input-sm" id="idfaktur" name="idfaktur"
											value="<?php echo trim($dtl_mst['idfaktur']); ?>"
											style="text-transform:uppercase" maxlength="100" readonly>
									</div>
								</div> <!---- col 1 -->
								<div class='col-sm-6'>
									<div class="form-group">
										<label for="inputsm">Nama Barang</label>
										<input type="text" class="form-control input-sm" id="keterangan" name="keterangan"
											value="<?php echo trim($ls->keterangan); ?>" readonly>
									</div>
									<div class="form-group">
										<label for="inputsm">Nominal</label>
										<input type="number" class="form-control input-sm" id="nnetto" name="nnetto"
											style="text-transform:uppercase" value="<?php echo trim($ls->nnetto); ?>"
											maxlength="20" placeholder="0" readonly>
									</div>
									<?php ?>

								</div>
							</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	<?php } ?>

	<script>
		$("#tgl").datepicker();
		$(".tgl").datepicker();
		$(".tglan").datepicker();
		$('.year').datepicker({
			format: " yyyy",
			viewMode: "years",
			minViewMode: "years"

		});

		$('#inputfile').submit(function (e) {
			e.preventDefault();

			var formData = new FormData(this);

			$.ajax({
				type: 'POST',
				url: '<?php echo site_url('ga/pembelian/add_attachment_po'); ?>',
				data: formData,
				processData: false,
				contentType: false,
				success: function (response) {
					if (response.type === 'success') {
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
					Swal.fire('Error', 'An error occurred while uploading the file.', 'error');
				}
			});
		});

		function deleteAttachment(id, filename, strtrimref) {
			Swal.fire({
				title: 'Hapus Lampiran Ini?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Hapus!',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: 'POST',
						url: '<?php echo site_url('ga/pembelian/delete_attachment_po'); ?>',
						data: { id: id, filename: filename, strtrimref: strtrimref },
						success: function (response) {
							if (response.type === 'success') {
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
							Swal.fire('Error', 'An error occurred while deleting the attachment.', 'error');
						}
					});
				}
			});
		}

		$('#input-faktur-detail').submit(function (e) {
			e.preventDefault();
			var formData = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: '<?php echo site_url('ga/pembelian/save_po_lampiran'); ?>',
				data: formData,
				success: function (response) {
					if (response.type === 'success') {
						$('#INPUTRINCIAN').modal('hide');
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
			})
		})
		$('#edit-faktur-detail').submit(function (e) {
			e.preventDefault();
			var formData = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: '<?php echo site_url('ga/pembelian/update_po_lampiran'); ?>',
				data: formData,
				success: function (response) {
					if (response.type === 'success') {
						$('#INPUTRINCIAN').modal('hide');
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
			})
		})
		function delete_lampiran_detail(id) {
			Swal.fire({
				title: 'Hapus Faktur Ini?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Hapus!',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: 'POST',
						url: '<?php echo site_url('ga/pembelian/delete_po_lampiran'); ?>',
						data: { id: id },
						success: function (response) {
							if (response.type === 'success') {
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
							Swal.fire('Error', 'An error occurred while deleting the attachment.', 'error');
						}
					});
				}
			});
		}
	</script>