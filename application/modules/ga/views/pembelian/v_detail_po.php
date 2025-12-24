<script type="text/javascript">
	$(document).ready(function () {
		function disableBack() { window.history.forward() }

		window.onload = disableBack();
		window.onpageshow = function (evt) { if (evt.persisted) disableBack() }
	});
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
		$("#dateinput").datepicker();
		$("#dateinput1").datepicker();
		$("#dateinput2").datepicker();
		$("#dateinput3").datepicker();
		$("[data-mask]").inputmask();
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

<div class="row">
	<div class="col-sm-1">
		<a href="<?php echo site_url("ga/pembelian/form_pembelian") ?>" class="btn btn-default"
			style="margin:10px; color:#000000;"><i class="fa fa-arrow-left"> </i>Kembali</a>
	</div>
	<!--a href="<?php echo site_url("ga/pembelian/final_input_po/$enc_nik") ?>"  onclick="return confirm('Anda Yakin Dengan Inputan Yang Anda Buat?')" class="btn btn-primary pull-right" style="margin:10px; color:#ffffff;">Simpan</a--->
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
							<th>AKSI</th>

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
								<td align="right"><?php echo $row->ttlnetto; ?></td>
								<td><?php echo $row->ketstatus; ?></td>
								<td><?php echo $row->keterangan; ?></td>
								<td width="8%">
									<!--a href="#" data-toggle="modal" data-target="#APPROVE<?php echo str_replace('.', '', trim($row->nodok)) . trim($row->nodoktmp); ?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> PROSES </a-->
									<a href="<?php
									$enc_nodok = bin2hex($this->encrypt->encode(trim($row->nodok)));
									echo site_url("ga/pembelian/detail_supplier_po_mst/$enc_nodok"); ?>"
										onclick="return confirm('Detail Supplier')" class="btn btn-default  btn-sm-1"><i
											class="fa fa-check-square"></i></a>
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
							<th>AKSI</th>
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
								<td width="8%">
									<a href="<?php
									$enc_rowid = bin2hex($this->encrypt->encode(trim($row->rowselect)));
									echo site_url("ga/pembelian/detail_po_dtl/$enc_rowid"); ?>"
										onclick="return confirm('Anda Akan Masuk Ke Menu Mapping Satuan Rekap?')"
										class="btn btn-default  btn-sm-1"><i class="fa fa-check-square"></i></a>
									<!--a href="#" data-toggle="modal" data-target="#APPNEXTMAP<?php echo trim($row->rowselect); ?>"  onclick="return confirm('Hapus Item Tersebut Akan Mengembalikan Dokumen SPPB / PBK')" class="btn btn-danger  btn-sm-1"><i class="fa fa-edit"></i></a-->
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
	<form role="form" action="<?php echo site_url("ga/pembelian/kurang_itempo"); ?>" method="post">
		<div class="col-sm-12">
			<div class="box box-danger">
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
								<th>NIK</th>
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
									<?php echo $lu->nik; ?>
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
		</div>
	</form>
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
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<input type="hidden" name="nik" value="<?php echo ''; ?>">
				<input type="hidden" name="username" value="<?php echo ''; ?>">
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
	<div class="col-lg-12">
		<div class="box">
			<div class="box-header">
				<legend><?php echo 'MASTER FAKTUR'; ?></legend>
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
						<?php $no = 0;
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
								<td><?php echo $row->nnetto; ?></td>
								<td width="7%">
									<a href="<?php
									$enc_strtrimref = bin2hex($this->encrypt->encode(trim($row->nodok) . trim($row->nodokref) . trim($row->idfaktur)));
									echo site_url('ga/pembelian/detail_po_mst_lampiran') . '/' . $enc_strtrimref; ?>"
										class="btn btn-success  btn-sm">
										<i class="fa fa-edit"></i> DETAIL
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>