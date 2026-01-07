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
		$("#example2,#example3, #example4").dataTable({
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

		$("#dateinput").datepicker();
		$("#dateinput1").datepicker();
		$("#dateinput2").datepicker();
		$("#dateinput3").datepicker();
		$("[data-mask]").inputmask();
		$('#tgl').daterangepicker();
		//	$("#kdsubgroup").chained("#kdgroup");
		//	$("#kdbarang").chained("#kdsubgroup");
		//	
		//	$("#mpkdsubgroup").chained("#mpkdgroup");
		//	$("#mpkdbarang").chained("#mpkdsubgroup");
		////	$("#onhand").chained("#kdbarang");
		//alert ($('#kdsubgroup').val() != '');

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
						//$('#mpsatkecil').val(data.satkecil);                        
						//$('#mpnmsatkecil').val(data.nmsatkecil);                        
						$('[name="nmsatkecil"]').val(data.nmsatkecil);
						//$('[name="loccode"]').val(data.loccode);                                                          

					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});
			};
		});


		<?php foreach ($list_tmp_po_dtlref as $lb) { ?>
			$("#qtyminta_appmapping<?php echo trim($lb->rowid); ?>").keyup(function () {
				$("#qtykecil_appmapping<?php echo trim($lb->rowid); ?>").val($(this).val());
				if (parseInt($(this).val().trim()) > parseInt($("#qtyminta_appmapping_cek<?php echo trim($lb->rowid); ?>").val().trim()) || (parseInt($(this).val().trim())) <= 0) {
					$("#postmessagesmodal<?php echo trim($lb->rowid); ?>").empty().append("<div class='alert alert-danger'>PERINGATAN QTY TIDAK BOLEH LEBIH BESAR DARI PERMINTAAN ATAU NOL</div>");
					$("#submitmodal<?php echo trim($lb->rowid); ?>").prop('disabled', true);
					console.log(<?php echo trim($lb->rowid); ?>);
					console.log((parseInt($(this).val().trim())) <= 0);
					console.log((parseInt($(this).val().trim())) <= 0);
				} else {
					$("#postmessagesmodal<?php echo trim($lb->rowid); ?>").empty();
					$("#submitmodal<?php echo trim($lb->rowid); ?>").prop('disabled', false);
					console.log(<?php echo trim($lb->rowid); ?>);
				}
			});
		<?php } ?>
		/*			//////////////////////////////////////////////
					$('#qtyunitprice').change(function(){
						if ($(this).val()=='') {	var param1 = parseInt(0); } else { var param1 = parseInt($(this).val()); }
						if ($('#qtypo').val()=='') {	var param2 = parseInt(0); } else { var param2 = parseInt($('#qtypo').val()); }
						
						$('#qtytotalprice').val(param1 * param2);   
					});
					//////////////////////////////////////////////
					$('#qtypo').change(function(){
						if ($(this).val()=='') {	var param2 = parseInt(0); } else { var param2 = parseInt($(this).val()); }
						if ($('#qtyunitprice').val()=='') {	var param1 = parseInt(0); } else { var param1 = parseInt($('#qtyunitprice').val()); }
						
						$('#qtytotalprice').val(param1 * param2);      
					}); 
			*/

	});
</script>

<legend><?php echo $title; ?></legend>
<span id="postmessages"></span>
<?php echo $message; ?>

<div class="row">
	<div class="col-sm-1">
		<a href="<?php echo site_url("ga/pembelian/clear_tmp_po/$enc_nik") ?>"
			onclick="return confirm('PERINGATAN KEMBALI AKAN MENGHAPUS SEMUA INPUTAN YG TELAH ANDA BUAT, TEKAN (OK) JIKA ANDA SETUJU, JIKA TIDAK TEKAN (BATAL)')"
			class="btn btn-default" style="margin:10px; color:#000000;"><i class="fa fa-arrow-left"></i> Kembali</a>
	</div>
	<a href="<?php echo site_url("ga/pembelian/final_input_po/$enc_nik/A1") ?>"
		onclick="return confirm('Anda Yakin Dengan Inputan Yang Anda Buat?')" class="btn btn-success pull-right"
		style="margin:10px; color:#ffffff;" title="SIMPAN UBAH DATA PO"><i class="fa fa-save"></i></a>
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header" align="center">
				<h5><b><strong><?php echo 'MASTER PO SUPPLIER DAN TYPE BARANG'; ?></strong></b></h5>
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
							<th>TOTAL NETTO</th>
							<th>STATUS</th>
							<th>KETERANGAN</th>
							<th>AKSI</th>

						</tr>
					</thead>
					<tbody>
						<?php $no = 0;
						foreach ($list_tmp_po_mst as $row):
							$no++; ?>
							<tr>

								<td width="2%"><?php echo $no; ?></td>
								<td><?php echo $row->nodok; ?></td>
								<td><?php echo date('d-m-Y', strtotime(trim($row->podate))); ?></td>
								<td><?php echo $row->itemtype; ?></td>
								<td><?php echo $row->nmsubsupplier; ?></td>
								<td><?php echo $row->kdcabangsupplier; ?></td>
								<td align="right"><?php echo number_format($row->ttlnetto, 2); ?></td>
								<td><?php echo $row->ketstatus; ?></td>
								<td><?php echo $row->keterangan; ?></td>
								<td width="10%">
									<!--a href="#" data-toggle="modal" data-target="#APPROVE<?php echo str_replace('.', '', trim($row->nodok)) . trim($row->nodoktmp); ?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> PROSES </a-->
									<a href="<?php
									$enc_nodok = bin2hex($this->encrypt->encode(trim($row->nodok)));
									echo site_url("ga/pembelian/input_supplier_po_mst/$enc_nodok"); ?>"
										onclick="return confirm('Anda Akan Masuk Input Ke Supplier?')"
										class="btn btn-primary  btn-sm-1" title="Ubah Supplier PO & Type PO"><i
											class="fa fa-cogs"></i> </a>
								</td>
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
							<?php echo 'DETAIL PERMINTAAN PER SATUAN STOCK'; ?>
						</strong></b></h5>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="2%">No.</th>
							<!--th>NODOK</th-->
							<th>NAMA BARANG</th>
							<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
								<th>QTYKECIL</th>
								<th>SATUAN KECIL</th>
								<th>QTYMINTA</th>
								<th>SATUAN MINTA</th>
							<?php } ?>
							<th>TOTAL HARGA</th>
							<th>STATUS</th>
							<th>KETERANGAN</th>
							<th>AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 0;
						foreach ($list_tmp_po_dtl as $row):
							$no++; ?>
							<tr>

								<td width="2%"><?php echo $no; ?></td>
								<!--td><!?php echo $row->nodok;?></td-->
								<td><?php echo $row->nmbarang; ?></td>
								<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
									<td align="right"><?php echo $row->qtykecil; ?></td>
									<td align="right"><?php echo $row->nmsatkecil; ?></td>
									<td align="right"><?php echo $row->qtyminta; ?></td>
									<td align="right"><?php echo $row->nmsatbesar; ?></td>
								<?php } ?>
								<td align="right"><?php echo number_format($row->ttlnetto, 2); ?></td>
								<td><?php echo $row->ketstatus; ?></td>
								<td><?php echo $row->keterangan; ?></td>
								<td width="10%">
									<a href="<?php
									$enc_rowid = bin2hex($this->encrypt->encode(trim($row->id)));
									echo site_url("ga/pembelian/remapping_po_dtl/$enc_rowid"); ?>"
										onclick="return confirm('Anda Akan Masuk Ke Menu Mapping Satuan Rekap?')"
										class="btn btn-primary  btn-sm-1" title="Ubah Harga Barang PO"><i
											class="fa fa-cogs"></i></a>

								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>
<div class="row">
	<div class="col-xs-6">
		<form role="form" action="<?php echo site_url("ga/pembelian/tambah_itempo"); ?>" method="post">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-header">
						<h4 align="center"><?php echo 'LIST DOKUMEN PERMINTAAN & OUTSTANDING PERMINTAAN'; ?></h4>
						<?php /*	 
												 <a href="#" data-toggle="modal" data-target="#FILTEROUTSTANDING" style="margin:10px; color:#000000;" class="btn btn-default  btn-sm-1  pull-left"><i class="fa fa-edit"></i></a>
													 <!--button class="btn btn-primary pull-left" onClick="TEST" style="margin:10px; color:#ffffff;" type="MODAL"> FILTER </button-->
													 <button class="btn btn-primary pull-right" onClick="TEST" style="margin:10px; color:#ffffff;" type="submit"
													 <?php if($row_dtlref_query==0) { ?> disabled <?php }?>> >> </button>
												 */ ?>
					</div><!-- /.box-header -->
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example3" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>No.</th>
									<th>Act</th>
									<th>NODOK</th>
									<th>NIK</th>
									<th>NAMA BARANG</th>
									<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
										<th>QTY DOC</th>
										<!--th>QTY PO</th-->
										<th>SATUAN</th>
										<!--th>SATUAN</th-->
									<?php } ?>
									<th>DETAIL</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 0;
								foreach ($list_tmp_po_dtlref_query as $lu):
									$no++; ?>
									<tr>
										<td width="2%"><?php echo $no; ?></td>
										<td width="8%">
											<input type="checkbox" name="centang[]"
												value="<?php echo trim($lu->strtrimref); ?>"><br>
										</td>
										<td><?php echo $lu->nodok; ?></td>
										<td><?php echo $lu->nik; ?></td>
										<td><?php echo $lu->desc_barang; ?></td>
										<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
											<td><?php echo $lu->qtyminta; ?></td>
											<!--td><?php echo $lu->qtypo; ?></td--->
									<td>
										<?php echo $lu->nmsatminta; ?>
									</td>
									<!--td><?php echo $lu->strtrimref; ?></td-->
										<?php } ?>
										<td>
											<a href="#" data-toggle="modal"
												data-target="#DTLREVITEMQUERY<?php echo trim($lu->rowid); ?>"
												onclick="return confirm('Lihat Detail ?')"
												class="btn btn-default  btn-sm-1"><i class="fa fa-edit"></i></a>
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
		</form>
	</div>
	<div class="col-xs-6">
		<form role="form" action="<?php echo site_url("ga/pembelian/kurang_itempo"); ?>" method="post">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-header">
						<h4 align="center"><?php echo 'LIST DETAIL REFERENSI'; ?></h4>
						<?php /* if($cek_full_mappdtlref>0) { ?--->
													 <button class="btn btn-primary pull-left" onClick="TEST" style="margin:10px; color:#ffffff;" type="submit"> << </button> 
													 <!---?php if($row_dtlref==0) { ?> disabled <!?php }?>> << ----/button---->
													 <a href="<?php echo site_url('ga/pembelian/reset_po_dtlrev');?>" type="button" style="margin:10px; color:#000000;"   onclick="return confirm('Detail Akan Tereset seluruhnya apakah anda yakin?')"  class="btn btn-default  pull-right"/> RESET</a>
												 <!--?php } */ ?>
					</div><!-- /.box-header -->
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example4" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th>DOKUMEN REV</th>
									<th>NIK</th>
									<th>NAMA BARANG</th>
									<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
										<th>QTY</th>
										<th>SATUAN</th>
									<?php } ?>
									<th>DETAIL</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 0;
								foreach ($list_tmp_po_dtlref as $lu):
									$no++; ?>
									<tr>
										<td width="2%"><?php echo $no; ?></td>
										<td width="8%">
											<input type="checkbox" name="centang[]"
												value="<?php echo trim($lu->rowid); ?>"><br>
										</td>
										<td><?php echo $lu->nodokref; ?></td>
										<td><?php echo $lu->nik; ?></td>
										<td><?php echo $lu->nmbarang; ?></td>
										<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
											<td><?php echo $lu->qtyminta; ?></td>
											<td><?php echo $lu->nmsatminta; ?></td>
										<?php } ?>
										<td>
											<?php if ((trim($lu->stockcode) == '') and trim($lu->status) == 'I' or (trim($lu->qtykecil) == 0)) { ?>
												<a href="<?php
												$enc_rowid = bin2hex($this->encrypt->encode(trim($lu->rowid)));
												echo site_url("ga/pembelian/mapping_po_dtlrev/$enc_rowid"); ?>" class="btn btn-primary  btn-sm-1"><i
														class="fa fa-cogs"></i></a>
											<?php } else if (trim($lu->stockcode) <> '' and trim($lu->status) == 'I' and trim($lu->qtyminta) > 0) { ?>
													<a href="#" data-toggle="modal"
														data-target="#APPMAPING<?php echo trim($lu->rowid); ?>"
														class="btn btn-warning  btn-sm-1"><i class="fa fa-check-square"></i></a>
											<?php } else if (trim($lu->stockcode) <> '' and trim($lu->status) == 'M') { ?>
														<a href="#" data-toggle="modal"
															data-target="#DTLREVITEM<?php echo trim($lu->rowid); ?>"
															class="btn btn-success  btn-sm-1"><i class="fa fa-check-square"></i></a>
											<?php } ?>

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
		</form>
	</div>
</div>

<?php foreach ($list_tmp_po_dtlref_query as $lb) { ?>
	<div class="modal fade" id="DTLREVITEMQUERY<?php echo trim($lb->rowid); ?>" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">PERMINTAAN BARANG</h4>
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
													<input type="hidden" id="type" name="type" value="DTLREVITEMQUERY"
														class="form-control" style="text-transform:uppercase">
													<input type="hidden" id="nodok" name="nodok"
														value="<?php echo trim($lb->nodok); ?>" class="form-control"
														style="text-transform:uppercase">
													<input type="hidden" id="id" name="id"
														value="<?php echo trim($lb->rowid); ?>" class="form-control"
														style="text-transform:uppercase">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Nama Karyawan</label>
												<div class="col-sm-8">
													<input type="text" id="nik" name="kdlvl1"
														value="<?php echo trim($lb->nmlengkap); ?>" class="form-control"
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
												<label class="col-sm-4">NO DOKUMEN</label>
												<div class="col-sm-8">
													<input type="text" id="nodok" name="nodok"
														value="<?php echo trim($lb->nodok); ?>" class="form-control"
														style="text-transform:uppercase" readonly>
												</div>
											</div>
											<div class="form-group ">
												<label class="col-sm-4" for="inputsm">Kode Barang</label>
												<div class="col-sm-8">
													<input type="input" name="kdbarang" id="kdbarang"
														value="<?php echo trim($lb->stockcode); ?>" class="form-control "
														readonly>
													<input type="hidden" name="kdgroup" id="kdgroup"
														value="<?php echo trim($lb->kdgroup); ?>" class="form-control ">
													<input type="hidden" name="kdsubgroup" id="kdsubgroup"
														value="<?php echo trim($lb->kdsubgroup); ?>" class="form-control ">
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
											<div class="form-group ">
												<label class="col-sm-4">LOKASI GUDANG</label>
												<div class="col-sm-8">
													<input type="text" id="loccode" name="loccode"
														value="<?php echo trim($lb->loccode); ?>" class="form-control "
														readonly>
												</div>
											</div>
											<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
												<div class="form-group drst">
													<label class="col-sm-4">SATUAN TERKECIL</label>
													<div class="col-sm-8">
														<input type="text" id="satkecil" name="satkecil"
															value="<?php echo trim($lb->satkecil); ?>" class="form-control drst"
															readonly>
													</div>
												</div>
												<div class="form-group drst">
													<label class="col-sm-4">Quantity Permintaan</label>
													<div class="col-sm-8">
														<input type="number" id="qtyminta" name="qtyminta"
															value="<?php echo trim($lb->qtyminta); ?>" placeholder="0"
															class="form-control drst" readonly>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-4" for="inputsm">Kode Satuan</label>
													<div class="col-sm-8">
														<input type="input" id="satminta" class="form-control drst"
															value="<?php echo trim($lb->nmsatminta); ?>" readonly>
													</div>
												</div>
											<?php } ?>
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
						<!--a href="<?php echo site_url('ga/pembelian/list_niksppb'); ?>" type="button" class="btn btn-default"/> Kembali</a-->
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<!--button type="submit" id="submit"  class="btn btn-danger">RESET</button-->
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>



<!---------- DETAIL VIEW DTLREF PO -------------->
<?php foreach ($list_tmp_po_dtlref as $lb) { ?>
	<div class="modal fade" id="APPMAPING<?php echo trim($lb->rowid); ?>" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">PERSETUJUAN ITEM BARANG</h4>
					<span id="postmessagesmodal<?php echo trim($lb->rowid); ?>"></span>
				</div>
				<form action="<?php echo site_url('ga/pembelian/save_po') ?>" method="post" name="inputformPbk">
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
													<input type="hidden" id="type" name="type" value="APPMAPING"
														class="form-control" style="text-transform:uppercase">
													<input type="hidden" id="nodok" name="nodok"
														value="<?php echo trim($lb->nodok); ?>" class="form-control"
														style="text-transform:uppercase">
													<input type="hidden" name="nodokref"
														value="<?php echo trim($lb->nodokref); ?>" class="form-control"
														style="text-transform:uppercase">
													<input type="hidden" name="kdgroup"
														value="<?php echo trim($lb->kdgroup); ?>" class="form-control"
														style="text-transform:uppercase">
													<input type="hidden" name="kdsubgroup"
														value="<?php echo trim($lb->kdsubgroup); ?>" class="form-control"
														style="text-transform:uppercase">
													<input type="hidden" name="stockcode"
														value="<?php echo trim($lb->stockcode); ?>" class="form-control"
														style="text-transform:uppercase">
													<input type="hidden" id="id" name="id"
														value="<?php echo trim($lb->id); ?>" class="form-control"
														style="text-transform:uppercase">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Nama Karyawan</label>
												<div class="col-sm-8">
													<input type="text" id="nik" name="kdlvl1"
														value="<?php echo trim($lb->nmlengkap); ?>" class="form-control"
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
												<label class="col-sm-4">NO DOKUMEN</label>
												<div class="col-sm-8">
													<input type="text" id="nodok" name="nodok"
														value="<?php echo trim($lb->nodok); ?>" class="form-control"
														style="text-transform:uppercase" readonly>
												</div>
											</div>
											<div class="form-group ">
												<label class="col-sm-4" for="inputsm">Kode Barang</label>
												<div class="col-sm-8">
													<input type="input" name="kdbarang" id="kdbarang"
														value="<?php echo trim($lb->stockcode); ?>"
														class="form-control kdbarang " readonly>
													<input type="hidden" name="kdgroup" id="kdgroup"
														value="<?php echo trim($lb->kdgroup); ?>" class="form-control ">
													<input type="hidden" name="kdsubgroup" id="kdsubgroup"
														value="<?php echo trim($lb->kdsubgroup); ?>" class="form-control ">
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
											<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
												<div class="form-group drst">
													<label class="col-sm-4">SATUAN TERKECIL</label>
													<div class="col-sm-8">
														<input type="text" id="satkecil" name="satkecil"
															value="<?php echo trim($lb->satkecil); ?>" class="form-control drst"
															readonly>
													</div>
												</div>
												<div class="form-group drst">
													<label class="col-sm-4">Quantity Permintaan</label>
													<div class="col-sm-4">
														<input type="number"
															id="qtyminta_appmapping<?php echo trim($lb->rowid); ?>"
															name="qtyminta" value="<?php echo trim($lb->qtyminta); ?>"
															placeholder="0" class="form-control drst">
													</div>
													<div class="col-sm-4">
														<input type="number"
															id="qtyminta_appmapping_cek<?php echo trim($lb->rowid); ?>"
															value="<?php echo trim($lb->qtyminta); ?>" placeholder="0"
															class="form-control drst" readonly>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-4" for="inputsm">Kode Satuan</label>
													<div class="col-sm-8">
														<input type="input" id="satminta" class="form-control drst"
															value="<?php echo trim($lb->nmsatminta); ?>" readonly>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-4" for="inputsm">Kode Satuan Permintaan</label>
													<div class="col-sm-8">
														<input type="input" id="satminta" class="form-control drst"
															value="<?php echo trim($lb->nmsatminta); ?>" readonly>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4">Nama Barang Dari User</label>
													<div class="col-sm-8">
														<input type="text" id="desc_barang" name="desc_barang"
															value="<?php echo trim($lb->desc_barang); ?>"
															style="text-transform:uppercase" class="form-control" readonly>
													</div>
												</div>
												<div class="form-group ">
													<label class="col-sm-4">Quantity Terkecil</label>
													<div class="col-sm-8">
														<input type="number" id="qtykecil_appmapping" name="qtykecil"
															value="<?php echo trim($lb->qtykecil); ?>" placeholder="0"
															class="form-control drst" readonly>
													</div>
												</div>
												<div class="form-group drst">
													<label class="col-sm-4">SATUAN TERKECIL</label>
													<div class="col-sm-8">
														<input type="text" name="mpnmsatkecil" class="form-control"
															value="<?php echo trim($lb->nmsatkecil); ?>" readonly>
														<input type="hidden" id="mpsatkecil" name="satkecil"
															value="<?php echo trim($lb->satkecil); ?>" class="form-control drst"
															readonly>
													</div>
												</div>
											<?php } else { ?>
												<div class="form-group drst" style="display:none;">
													<label class="col-sm-4">SATUAN TERKECIL</label>
													<div class="col-sm-8">
														<input type="text" id="satkecil" name="satkecil"
															value="<?php echo trim($lb->satkecil); ?>" class="form-control drst"
															readonly>
													</div>
												</div>
												<div class="form-group drst" style="display:none;">
													<label class="col-sm-4">Quantity Permintaan</label>
													<div class="col-sm-4">
														<input type="number"
															id="qtyminta_appmapping<?php echo trim($lb->rowid); ?>"
															name="qtyminta" value="<?php echo trim($lb->qtyminta); ?>"
															placeholder="0" class="form-control drst">
													</div>
													<div class="col-sm-4">
														<input type="number"
															id="qtyminta_appmapping_cek<?php echo trim($lb->rowid); ?>"
															value="<?php echo trim($lb->qtyminta); ?>" placeholder="0"
															class="form-control drst" readonly>
													</div>
												</div>

												<div class="form-group" style="display:none;">
													<label class="col-sm-4" for="inputsm">Kode Satuan</label>
													<div class="col-sm-8">
														<input type="input" id="satminta" class="form-control drst"
															value="<?php echo trim($lb->nmsatminta); ?>" readonly>
													</div>
												</div>

												<div class="form-group" style="display:none;">
													<label class="col-sm-4" for="inputsm">Kode Satuan Permintaan</label>
													<div class="col-sm-8">
														<input type="input" id="satminta" class="form-control drst"
															value="<?php echo trim($lb->nmsatminta); ?>" readonly>
													</div>
												</div>
												<div class="form-group" style="display:none;">
													<label class="col-sm-4">Nama Barang Dari User</label>
													<div class="col-sm-8">
														<input type="text" id="desc_barang" name="desc_barang"
															value="<?php echo trim($lb->desc_barang); ?>"
															style="text-transform:uppercase" class="form-control" readonly>
													</div>
												</div>
												<div class="form-group " style="display:none;">
													<label class="col-sm-4">Quantity Terkecil</label>
													<div class="col-sm-8">
														<input type="number" id="qtykecil_appmapping" name="qtykecil"
															value="<?php echo trim($lb->qtykecil); ?>" placeholder="0"
															class="form-control drst" readonly>
													</div>
												</div>
												<div class="form-group drst" style="display:none;">
													<label class="col-sm-4">SATUAN TERKECIL</label>
													<div class="col-sm-8">
														<input type="text" name="mpnmsatkecil" class="form-control"
															value="<?php echo trim($lb->nmsatkecil); ?>" readonly>
														<input type="hidden" id="mpsatkecil" name="satkecil"
															value="<?php echo trim($lb->satkecil); ?>" class="form-control drst"
															readonly>
													</div>
												</div>
											<?php } ?>
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
						<!--a href="<?php echo site_url('ga/pembelian/list_niksppb'); ?>" type="button" class="btn btn-default"/> Kembali</a-->
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-success">SETUJUI ITEM PEMBELIAN</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>



<!---------- DETAIL VIEW DTLREF PO -------------->
<?php foreach ($list_tmp_po_dtlref as $lb) { ?>
	<div class="modal fade" id="DTLREVITEM<?php echo trim($lb->rowid); ?>" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">PEMBELIAN BARANG</h4>
				</div>
				<form action="#" method="post" name="inputformPbk">
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
													<input type="hidden" id="type" name="type" value="DTLREVITEMQUERY"
														class="form-control" style="text-transform:uppercase">
													<input type="hidden" id="nodok" name="nodok"
														value="<?php echo trim($lb->nodok); ?>" class="form-control"
														style="text-transform:uppercase">
													<input type="hidden" id="id" name="id"
														value="<?php echo trim($lb->rowid); ?>" class="form-control"
														style="text-transform:uppercase">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-4">Nama Karyawan</label>
												<div class="col-sm-8">
													<input type="text" id="nik" name="kdlvl1"
														value="<?php echo trim($lb->nmlengkap); ?>" class="form-control"
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
												<label class="col-sm-4">NO DOKUMEN</label>
												<div class="col-sm-8">
													<input type="text" id="nodok" name="nodok"
														value="<?php echo trim($lb->nodok); ?>" class="form-control"
														style="text-transform:uppercase" readonly>
												</div>
											</div>
											<div class="form-group ">
												<label class="col-sm-4" for="inputsm">Kode Barang</label>
												<div class="col-sm-8">
													<input type="text" name="kdbarang" id="kdbarang"
														value="<?php echo trim($lb->stockcode); ?>"
														class="form-control kdbarang " readonly>
												</div>

												<input type="hidden" name="kdgroup" id="kdgroup"
													value="<?php echo trim($lb->kdgroup); ?>" class="form-control ">
												<input type="hidden" name="kdsubgroup" id="kdsubgroup"
													value="<?php echo trim($lb->kdsubgroup); ?>" class="form-control ">

											</div>
											<div class="form-group ">
												<label class="col-sm-4">LOKASI GUDANG</label>
												<div class="col-sm-8">
													<input type="text" id="loccode" name="loccode"
														value="<?php echo trim($lb->loccode); ?>" class="form-control "
														readonly>
												</div>
											</div>
											<?php if (trim($dtlmst['itemtype']) != 'JSA') { ?>
												<div class="form-group drst">
													<label class="col-sm-4">SATUAN TERKECIL</label>
													<div class="col-sm-8">
														<input type="text" id="satkecil" name="satkecil"
															value="<?php echo trim($lb->satkecil); ?>" class="form-control drst"
															readonly>
													</div>
												</div>
												<div class="form-group drst">
													<label class="col-sm-4">Quantity Permintaan</label>
													<div class="col-sm-8">
														<input type="number" id="qtyminta" name="qtyminta"
															value="<?php echo trim($lb->qtyminta); ?>" placeholder="0"
															class="form-control drst" readonly>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-4" for="inputsm">Kode Satuan Permintaan</label>
													<div class="col-sm-8">
														<input type="input" id="satminta" class="form-control drst"
															value="<?php echo trim($lb->nmsatminta); ?>" readonly>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4">Nama Barang Dari User</label>
													<div class="col-sm-8">
														<input type="text" id="desc_barang" name="desc_barang"
															value="<?php echo trim($lb->desc_barang); ?>"
															style="text-transform:uppercase" class="form-control" readonly>
													</div>
												</div>
												<div class="form-group ">
													<label class="col-sm-4">Quantity Terkecil</label>
													<div class="col-sm-8">
														<input type="number" id="qtykecil" name="qtykecil"
															value="<?php echo trim($lb->qtykecil); ?>" placeholder="0"
															class="form-control drst" readonly>
													</div>
												</div>
												<div class="form-group drst">
													<label class="col-sm-4">SATUAN TERKECIL</label>
													<div class="col-sm-8">
														<input type="text" name="mpnmsatkecil" class="form-control"
															value="<?php echo trim($lb->nmsatkecil); ?>" readonly>
														<input type="hidden" id="mpsatkecil" name="satkecil"
															value="<?php echo trim($lb->satkecil); ?>" class="form-control drst"
															readonly>
													</div>
												</div>
											<?php } ?>
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
						<!--a href="<?php echo site_url('ga/pembelian/list_niksppb'); ?>" type="button" class="btn btn-default"/> Kembali</a-->
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<!--button type="submit" id="submit"  class="btn btn-danger">RESET</button--->
				</div>
			</form>
		</div>
	</div>
</div>
<?php } ?>



<div class="modal fade" id="FILTEROUTSTANDING" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
						class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">FILTER OUTSTANDING</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('ga/pembelian/edit_po_atk') . '/' . $enc_nodok; ?>"
										name="form" role="form" method="post">

										<div class="form-group">
											<label class="label-form col-lg-12">Periode Load Referensi</label>
											<div class="col-lg-12">
												<input type="text" name="tgl" id="tgl" class="form-control" required>
											</div>
										</div>

										<div class="form-group">
											<div class="col-lg-12">
												<button type='submit' class='btn btn-primary pull-right'><i
														class="glyphicon glyphicon-search"></i> FILTER</button>
												<!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--div class="modal-footer">
		<!--a href="<?php echo site_url('ga/pembelian/list_niksppb'); ?>" type="button" class="btn btn-default"/> Kembali</a-->
				<!--button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
		<!--button type="submit" id="submit"  class="btn btn-danger">RESET</button--->
				<!--/div--->
			</div>
		</div>
	</div>
</div>

<!--                                       ===================================================================================================================  -------->