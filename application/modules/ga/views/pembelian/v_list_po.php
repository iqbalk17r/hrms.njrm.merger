<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	$(document).ready(function () {
		function disableBack() { window.history.forward() }

		window.onload = disableBack();
		window.onpageshow = function (evt) { if (evt.persisted) disableBack() }
	});
	$(function () {
		$("#example1").dataTable();
		var save_method;
		var table;
		table = $('#example2').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "<?php echo site_url('ga/pembelian/cobapagin') ?>",
				"type": "POST"
			},
			"columnDefs": [
				{
					"targets": [-1],
					"orderable": false,
				},
			],

		});
		$modal = $('.pp');
		$('#example2').on('click', '.show', function () {
			var el = $(this);
			$modal.load(el.attr('data-url'), '', function () {
				$modal.modal();
			});
		});

		$("#example3").dataTable();
		$("#example4").dataTable();
		$("#kdsubgroup").chained("#kdgroup");
		$("#kdbarang").chained("#kdsubgroup");

		$('#qtyunitprice').change(function () {
			if ($(this).val() == '') { var param1 = parseInt(0); } else { var param1 = parseInt($(this).val()); }
			if ($('#qtypo').val() == '') { var param2 = parseInt(0); } else { var param2 = parseInt($('#qtypo').val()); }

			$('#qtytotalprice').val(param1 * param2);
		});
		//////////////////////////////////////////////
		$('#qtypo').change(function () {
			if ($(this).val() == '') { var param2 = parseInt(0); } else { var param2 = parseInt($(this).val()); }
			if ($('#qtyunitprice').val() == '') { var param1 = parseInt(0); } else { var param1 = parseInt($('#qtyunitprice').val()); }

			$('#qtytotalprice').val(param1 * param2);
		});
	});

	function reload_table() {
		table.ajax.reload(null, false);
	}
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<legend><?php echo $title; ?></legend>

<?php echo $message; ?>

<div class="row">
	<div class="col-sm-3">
		<div class="dropdown ">
			<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1"
				type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
				<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"
						href="#"><i class="fa fa-search"></i> Filter Pencarian</a></li>
				<!-- <li role="presentation"><a role="menuitem" tabindex="-1"
						href="<?php //echo site_url("ga/pembelian/input_po") ?>"><i class="fa fa-plus"></i> Input PO</a>
				</li> -->
			</ul>
		</div>
		<!--/div-->
	</div><!-- /.box-header -->
</div>
</br>
<div class="row">
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
			</div>
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="2%">No.</th>
							<th>DOKUMEN</th>
							<th>NAMA SUPPLIER</th>
							<th>TOTAL HARGA</th>
							<th>NAMA BARANG</th>
							<!--th>INPUTDATE</th>
							<th>APPROVALBY</th>
							<th>APPROVALDATE</th-->
							<th>KETERANGAN</th>
							<th>STATUS</th>
							<th width="10%">AKSI</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div>
	</div>
</div><!--/ nav -->

<script>
	$("#tgl").datepicker();
	$(".tglan").datepicker(); 
</script>