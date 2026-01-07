<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<style>
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


<legend><?php echo $title . trim($dtl_mst['nodok']); ?></legend>
<?php echo $message; ?>
<!--div><a href="<?php echo site_url('ga/inventaris/list_perawatan'); ?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
<div--->

<div class="row">
	<div class="col-sm-1">
		<form role="form" action="<?php echo site_url('ga/inventaris/index_spk'); ?>" method="post">
			<button type="submit" style="margin:10px; color:#000000;" class="btn btn-default">KEMBALI</button>
		</form>
	</div>
	<?php if ($approve['approve_access']) { ?>
	<div class="col">
		<button type="button" style="margin:10px; color:#ffffff;" class="btn btn-success pull-right"
			onclick="swalWarning('Setujui Perawatan', '<?= site_url('ga/inventaris/finalisasi_perawatan/' . $approve['next_status'] . '/' . $this->fiky_encryption->enkript(trim($nodokspk))); ?>');">
			<?= substr($dtl_mst['status'], 0, 2) == 'AF' ? 'Setujui Faktur' : 'Setujui Perawatan'; ?>
		</button>
	</div>
	<div class="col">
		<button type="button" style="margin:10px; color:#ffffff;" class="btn btn-danger pull-right"
			onclick="swalWarning('Tolak Perawatan', '<?= strlen(substr($dtl_mst['status'], 0, 2)) == 'AF' ? site_url('ga/inventaris/tolak_faktur/' . $this->fiky_encryption->enkript(trim($nodokspk))) : site_url('ga/inventaris/finalisasi_perawatan/C/' . $this->fiky_encryption->enkript(trim($nodokspk))) ?>');">
			<?= substr($dtl_mst['status'], 0, 2) == 'AF' ? 'Tolak Faktur' : 'Tolak Perawatan'; ?>
		</button>
	</div>

	<script>
		function swalWarning(title, url) {
			swal.fire({
				title: title,
				text: "Anda yakin dengan pilihan ini ?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#007ACC",
				confirmButtonText: "Ya",
				cancelButtonText: "Tidak"
			}).then(function (result) {
				if (result.value) {
					location.href = url;
				}
			});
		}
	</script>
	<?php } ?>


</div>
</br>
<div class="row">
	<div class="box col-lg-12">
		<div class="box-header">
			<legend>
				<?php echo $title; ?>
			</legend>
		</div><!-- /.box-header -->
		<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th width="2%">No.</th>
						<th>NODOK</th>
						<th>NODOK REF</th>
						<th>DESC BARANG</th>
						<th>NAMA BARANG</th>
						<th>NAMA BENGKEL</th>
						<th>TANGGAL MASUK</th>
						<th>TANGGAL SELESAI</th>
						<th>PHONE BENGKEL</th>
						<th>STATUS</th>
						<th>KETERANGAN</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 0;
					foreach ($list_spk as $row):
						$no++; ?>
						<tr>

							<td width="2%"><?php echo $no; ?></td>
							<td><?php echo $row->nodok; ?></td>
							<td><?php echo $row->nodokref; ?></td>
							<td><?php echo $row->descbarang; ?></td>
							<td><?php echo $row->nmbarang; ?></td>
							<td><?php echo $row->nmbengkel; ?></td>
							<td><?php if (empty($row->tglawal)) {
								echo '';
							} else {
								echo date('d-m-Y', strtotime(trim($row->tglawal)));
							} ?>
							</td>
							<td><?php if (empty($row->tglakhir)) {
								echo '';
							} else {
								echo date('d-m-Y', strtotime(trim($row->tglakhir)));
							} ?>
							</td>
							<td><?php echo $row->phone1; ?></td>
							<td><?php echo $row->uraian_status; ?></td>
							<td><?php echo $row->keterangan; ?></td>
							<td width="15%">
								<a href="#" data-toggle="modal"
									data-target="#DTL<?php echo str_replace('.', '', (trim($row->nodok) . trim($row->nodokref))); ?>"
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
	<div class="row">
		<div class="box col-lg-12">
			<div class="box-header">
				<legend><?php echo 'TAMBAHAN SPK'; ?></legend>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="2%">No.</th>
							<th>NODOK</th>
							<th>NODOK REF</th>
							<th>NAMA BARANG</th>
							<th>NAMA BENGKEL</th>
							<th>TANGGAL MASUK</th>
							<th>TANGGAL SELESAI</th>
							<th>PHONE BENGKEL</th>
							<th>KETERANGAN</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 0;
						foreach ($list_spk_tambahan as $row):
							$no++; ?>
							<tr>
								<td width="2%"><?php echo $no; ?></td>
								<td><?php echo $row->nodok; ?></td>
								<td><?php echo $row->nodokref; ?></td>
								<td><?php echo $row->nmbarang; ?></td>
								<td><?php echo $row->nmbengkel; ?></td>
								<td><?php if (empty($row->tglawal)) {
									echo '';
								} else {
									echo date('d-m-Y', strtotime(trim($row->tglawal)));
								} ?>
								</td>
								<td><?php if (empty($row->tglakhir)) {
									echo '';
								} else {
									echo date('d-m-Y', strtotime(trim($row->tglakhir)));
								} ?>
								</td>
								<td><?php echo $row->phone1; ?></td>
								<td><?php echo $row->keterangan; ?></td>
								<td width="15%">
									<a href="#" data-toggle="modal"
										data-target="#DTLT<?php echo str_replace('.', '', (trim($row->nodok) . trim($row->nodokref))); ?>"
										class="btn btn-default  btn-sm">
										<i class="fa fa-edit"></i> DETAIL
									</a>

									<!--?php/* if(trim($row->status)=='I' OR trim($row->status)=='A') { */?--->
								<!-- <a href="#" data-toggle="modal"
									data-target="#EDITSPK<?php echo str_replace('.', '', (trim($row->nodok) . trim($row->nodokref))); ?>"
									class="btn btn-success  btn-sm">
									<i class="fa fa-edit"></i> EDIT
								</a> -->
								<!--?php/* } */?---->
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div>
	</div>
	<div class="row">
		<div class="col-sm-1">
			<!--div class="container"--->

			<!--/div-->
		</div><!-- /.box-header -->
	</div>
	<div class="box col-lg-12">
		<div class="box-header">
			<legend><?php echo 'MASTER PEMBAYARAN'; ?></legend>
		</div><!-- /.box-header -->
		<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<table id="example2" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th width="2%">No.</th>
						<th>NODOK</th>
						<th>NODOKREF</th>
						<th>TIPE PEMBAYARAN</th>
						<th>TANGGAL PEMBAYARAN</th>
						<th>TOTAL PEMBAYARAN</th>
						<th>KETERANGAN</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 0;
					foreach ($perawatan_pembayaran as $row):
						$no++; ?>
						<tr>
							<td width="2%"><?php echo $no; ?></td>
							<td><?php echo $row->nodok; ?></td>
							<td><?php echo $row->nodokref; ?></td>
							<td><?php echo $row->tipe_pembayaran; ?></td>
							<td><?php if (empty($row->tgl)) {
								echo '';
							} else {
								echo date('d-m-Y', strtotime(trim($row->tgl)));
							} ?>
							</td>
							<td><?php echo $row->nnetto; ?></td>
							<td><?php echo $row->keterangan; ?></td>
							<td width="7%">

							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
	<div class="box col-lg-12">
		<div class="box-header">
			<legend><?php echo 'MASTER FAKTUR UPLOAD INVOICE'; ?></legend>
		</div><!-- /.box-header -->
		<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<table id="example2" class="table table-bordered table-striped">
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
								echo site_url('ga/inventaris/detail_perawatan_mst_lampiran') . '/' . $enc_strtrimref; ?>"
									class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> DETAIL
								</a>
								<?php /*
																																					<a href="#" data-toggle="modal" data-target="#DTLFAKTUR<?php echo trim($row->id);?>" class="btn btn-default  btn-sm">
																																						<i class="fa fa-edit"></i> DETAIL
																																					</a>
																																						*/ ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div><!-- /.row -->

<!-- Modal SURAT PERINTAH KERJA -->

<?php foreach ($list_spk_tambahan as $ls) { ?>
	<div class="modal fade" id="DTLT<?php echo str_replace('.', '', (trim($ls->nodok) . trim($ls->nodokref))); ?>"
		tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">DETAIL PERAWATAN ASSET SPK (SURAT PERINTAH KERJA)</h4>
				</div>
				<div class="modal-body">
					<form role="form" action="<?php echo site_url('ga/inventaris/save_spk'); ?>" method="post">
						<div class='row'>
							<div class='col-sm-6'>
								<div class="form-group">
									<label for="inputsm">NO DOKUMEN</label>
									<input type="text" class="form-control input-sm" id="nodok" name="nodok"
										style="text-transform:uppercase" maxlength="25"
										value="<?php echo trim($ls->nodok); ?>" readonly>
									<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
								</div>
								<div class="form-group">
									<label for="inputsm">NO DOKUMEN REF</label>
									<input type="text" class="form-control input-sm" id="nodokref" name="nodokref"
										style="text-transform:uppercase" maxlength="25"
										value="<?php echo trim($ls->nodokref); ?>" readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">DESC BARANG</label>
									<input type="text" class="form-control input-sm" id="descbarang" name="descbarang"
										style="text-transform:uppercase" maxlength="25"
										value="<?php echo trim($dtl_mst['descbarang']); ?>" readonly>
								</div>

								<div class="form-group">
									<label for="inputsm">Kode Group Barang</label>
									<select class="form-control input-sm" id="kdgroup" disabled readonly>
										<option value="">---PILIH KODE GROUP--</option>
										<?php foreach ($list_scgroup as $sc) { ?>
											<option <?php if (trim($dtl_mst['kdgroup']) == trim($sc->kdgroup)) {
												echo 'selected';
											} ?> value="<?php echo trim($sc->kdgroup); ?>">
												<?php echo trim($sc->kdgroup) . ' || ' . trim($sc->nmgroup); ?>
											</option>
										<?php } ?>
									</select>
									<input type="hidden" class="form-control input-sm" name="kdgroup"
										value="<?php echo trim($dtl_mst['kdgroup']); ?>">
								</div>
								<div class="form-group">
									<label for="inputsm">Kode Sub Group Barang</label>
									<select class="form-control input-sm " id="kdsubgroup" disabled readonly>
										<option value="">---PILIH KODE SUB GROUP--</option>
										<?php foreach ($list_scsubgroup as $sc) { ?>
											<option <?php if (trim($dtl_mst['kdsubgroup']) == trim($sc->kdsubgroup)) {
												echo 'selected';
											} ?> value="<?php echo trim($sc->kdsubgroup); ?>"
												class="<?php echo trim($sc->kdgroup); ?>">
												<?php echo trim($sc->kdsubgroup) . ' || ' . trim($sc->nmsubgroup); ?>
											</option>
										<?php } ?>
									</select>
									<input type="hidden" class="form-control input-sm" name="kdsubgroup"
										value="<?php echo trim($dtl_mst['kdsubgroup']); ?>">
								</div>
								<div class="form-group">
									<label for="inputsm">Pilih Barang</label>
									<select class="form-control input-sm" name="stockcode" id="stockcode" disabled readonly>
										<option value="">---PILIH KODE BARANG--</option>
										<?php foreach ($list_barang as $sc) { ?>
											<option <?php if (trim($dtl_mst['stockcode']) == trim($sc->nodok)) {
												echo 'selected';
											} ?> value="<?php echo trim($sc->nodok); ?>"
												class="<?php echo trim($sc->kdsubgroup); ?>">
												<?php echo trim($sc->nodok) . ' || ' . trim($sc->nmbarang) . ' || ' . trim($sc->nopol); ?>
											</option>
										<?php } ?>
									</select>
									<input type="hidden" class="form-control input-sm" name="stockcode"
										value="<?php echo trim($dtl_mst['stockcode']); ?>">
								</div>
								<!--div class="form-group">
				<label for="inputsm">KANTOR CABANG PENEMPATAN</label>	
					<select class="form-control input-sm " name="kdcabangbengkel" id="kdcabangbengkelin" >
					<option value="">---PILIH KANTOR CABANG PENEMPATAN BENGKEL--</option> 
					<?php foreach ($list_kanwil as $sc) { ?>					  
					  <option value="<?php echo trim($sc->kdcabang); ?>" ><?php echo trim($sc->kdcabang) . ' || ' . trim($sc->desc_cabang); ?></option>						  
					<?php } ?>
					</select>
			</div--->
							<div class="form-group">
								<label for="inputsm">Kode Bengkel</label>
								<select class="form-control input-sm " name="kdbengkel" disabled readonly>
									<option value="">---PILIH BENGKEL--</option>
									<?php foreach ($list_bengkel as $sc) { ?>
									<option <?php if (trim($ls->kdbengkel) == trim($sc->kdbengkel)) {
										echo 'selected';
									} ?>
										value="
										<?php echo trim($sc->kdbengkel); ?>" >
										<?php echo trim($sc->kdbengkel) . ' || ' . trim($sc->nmbengkel); ?>
									</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="inputsm">Kode Sub Bengkel</label>
								<select class="form-control input-sm " name="kdsubbengkel" id="kdsubbengkeled" disabled
									readonly>
									<option value="">---PILIH SUB BENGKEL--</option>
									<?php foreach ($list_subbengkel as $sc) { ?>
									<option <?php if (trim($ls->kdsubbengkel) == trim($sc->kdsubbengkel)) {
										echo 'selected';
									} ?> value="
										<?php echo trim($sc->kdsubbengkel); ?>" class="
										<?php echo trim($sc->kdbengkel); ?>" >
										<?php echo trim($sc->kdsubbengkel) . ' || ' . trim($sc->nmbengkel) . ' || ' . trim($sc->city); ?>
									</option>
									<?php } ?>
								</select>
							</div>

						</div> <!---- col 1 -->
							<div class='col-sm-6'>
								<div class="form-group">
									<label for="inputsm">Kilometer Awal</label>
									<input type="number" class="form-control input-sm" id="kmawal" name="kmawal"
										value="<?php echo trim($ls->km_awal); ?>" style="text-transform:uppercase"
										maxlength="20" disabled readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">Kilometer Akhir</label>
									<input type="number" class="form-control input-sm" id="kmakhir" name="kmakhir"
										value="<?php echo trim($ls->km_akhir); ?>" style="text-transform:uppercase"
										maxlength="20" disabled readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">UP Bpk/Ibu/Sdr</label>
									<input type="text" class="form-control input-sm" id="upbengkel" name="upbengkel"
										value="<?php echo trim($ls->upbengkel); ?>" style="text-transform:uppercase"
										maxlength="20" disabled readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">JENIS PERAWATAN</label>
									<select class="form-control input-sm" readonly disabled>
										<option <?php if (trim($dtl_mst['jnsperawatan']) == 'BK') {
											echo 'selected';
										} ?>
											value="BK"><?php echo 'BK' . ' || ' . 'BERKALA'; ?></option>
										<option <?php if (trim($dtl_mst['jnsperawatan']) == 'IS') {
											echo 'selected';
										} ?>
											value="IS"><?php echo 'IS' . ' || ' . 'ISIDENTIL'; ?></option>
									</select>
									<input type="hidden" class="form-control input-sm" name="jnsperawatan" id="jnsperawatan"
										style="text-transform:uppercase" maxlength="25"
										value="<?php echo trim($dtl_mst['jnsperawatan']); ?>">
								</div>
								<div class="form-group">
									<label for="inputsm">KATEGORI PERAWATAN</label>
									<select class="form-control input-sm" name="jnsperawatanref" id="jnsperawatanref"
										disabled readonly>
										<?php foreach ($list_trxtypespk as $sc) { ?>
											<option <?php if (trim($ls->jnsperawatanref) == trim($sc->kdtrx)) {
												echo 'selected';
											} ?> value="<?php echo trim($sc->kdtrx); ?>">
												<?php echo trim($sc->kdtrx) . ' || ' . trim($sc->uraian); ?>
											</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label for="inputsm">Total Biaya Servis</label>
									<input type="number" class="form-control input-sm" id="ttlservis" name="ttlservis"
										placeholder="0" value="<?php echo trim(trim($ls->ttlservis)); ?>" disabled readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">Tanggal Masuk/Keluar Bengkel</label>
									<input type="text" class="form-control input-sm tgl" id="tgl" name="tgl"
										data-date-format="dd-mm-yyyy" value="<?php if (empty($row->tglakhir)) {
											echo '';
										} else {
											echo date('d-m-Y', strtotime(trim($ls->tglawal))) . ' - ' . date('d-m-Y', strtotime(trim($ls->tglakhir)));
										} ?>" disabled readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">Keterangan</label>
									<textarea class="textarea" name="keterangan" placeholder="Keterangan" maxlength="159"
										style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"
										disabled readonly><?php echo trim($ls->keterangan); ?></textarea>
								</div>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<!--button type="submit" class="btn btn-danger">Hapus</button--->
			</div>
			</form>

		</div>
	</div>
</div>
<?php } ?>


<!-- Modal DETAIL -->
<?php foreach ($list_spk as $ls) { ?>
	<div class="modal fade" id="DTL<?php echo str_replace('.', '', (trim($ls->nodok) . trim($ls->nodokref))); ?>"
		tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">DETAIL PERAWATAN ASSET SPK (SURAT PERINTAH KERJA)</h4>
				</div>
				<div class="modal-body">
					<form role="form" action="<?php echo site_url('ga/inventaris/save_spk'); ?>" method="post">
						<div class='row'>
							<div class='col-sm-6'>
								<div class="form-group">
									<label for="inputsm">NO DOKUMEN</label>
									<input type="text" class="form-control input-sm" id="nodok" name="nodok"
										style="text-transform:uppercase" maxlength="25"
										value="<?php echo trim($ls->nodok); ?>" readonly>
									<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
								</div>
								<div class="form-group">
									<label for="inputsm">NO DOKUMEN REF</label>
									<input type="text" class="form-control input-sm" id="nodokref" name="nodokref"
										style="text-transform:uppercase" maxlength="25"
										value="<?php echo trim($ls->nodokref); ?>" readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">DESC BARANG</label>
									<input type="text" class="form-control input-sm" id="descbarang" name="descbarang"
										style="text-transform:uppercase" maxlength="25"
										value="<?php echo trim($dtl_mst['descbarang']); ?>" readonly>
								</div>

								<div class="form-group">
									<label for="inputsm">Kode Group Barang</label>
									<select class="form-control input-sm" id="kdgroup" disabled readonly>
										<option value="">---PILIH KODE GROUP--</option>
										<?php foreach ($list_scgroup as $sc) { ?>
											<option <?php if (trim($dtl_mst['kdgroup']) == trim($sc->kdgroup)) {
												echo 'selected';
											} ?> value="<?php echo trim($sc->kdgroup); ?>">
												<?php echo trim($sc->kdgroup) . ' || ' . trim($sc->nmgroup); ?>
											</option>
										<?php } ?>
									</select>
									<input type="hidden" class="form-control input-sm" name="kdgroup"
										value="<?php echo trim($dtl_mst['kdgroup']); ?>">
								</div>
								<div class="form-group">
									<label for="inputsm">Kode Sub Group Barang</label>
									<select class="form-control input-sm " id="kdsubgroup" disabled readonly>
										<option value="">---PILIH KODE SUB GROUP--</option>
										<?php foreach ($list_scsubgroup as $sc) { ?>
											<option <?php if (trim($dtl_mst['kdsubgroup']) == trim($sc->kdsubgroup)) {
												echo 'selected';
											} ?> value="<?php echo trim($sc->kdsubgroup); ?>"
												class="<?php echo trim($sc->kdgroup); ?>">
												<?php echo trim($sc->kdsubgroup) . ' || ' . trim($sc->nmsubgroup); ?>
											</option>
										<?php } ?>
									</select>
									<input type="hidden" class="form-control input-sm" name="kdsubgroup"
										value="<?php echo trim($dtl_mst['kdsubgroup']); ?>">
								</div>
								<div class="form-group">
									<label for="inputsm">Pilih Barang</label>
									<select class="form-control input-sm" name="stockcode" id="stockcode" disabled readonly>
										<option value="">---PILIH KODE BARANG--</option>
										<?php foreach ($list_barang as $sc) { ?>
											<option <?php if (trim($dtl_mst['stockcode']) == trim($sc->nodok)) {
												echo 'selected';
											} ?> value="<?php echo trim($sc->nodok); ?>"
												class="<?php echo trim($sc->kdsubgroup); ?>">
												<?php echo trim($sc->nodok) . ' || ' . trim($sc->nmbarang) . ' || ' . trim($sc->nopol); ?>
											</option>
										<?php } ?>
									</select>
									<input type="hidden" class="form-control input-sm" name="stockcode"
										value="<?php echo trim($dtl_mst['stockcode']); ?>">
								</div>
								<!--div class="form-group">
				<label for="inputsm">KANTOR CABANG PENEMPATAN</label>	
					<select class="form-control input-sm " name="kdcabangbengkel" id="kdcabangbengkelin" >
					<option value="">---PILIH KANTOR CABANG PENEMPATAN BENGKEL--</option> 
					<?php foreach ($list_kanwil as $sc) { ?>					  
					  <option value="<?php echo trim($sc->kdcabang); ?>" ><?php echo trim($sc->kdcabang) . ' || ' . trim($sc->desc_cabang); ?></option>						  
					<?php } ?>
					</select>
			</div--->
							<div class="form-group">
								<label for="inputsm">Kode Bengkel</label>
								<select class="form-control input-sm " name="kdbengkel" id="kdbengkeled" disabled
									readonly>
									<option value="">---PILIH BENGKEL--</option>
									<?php foreach ($list_bengkel as $sc) { ?>
									<option <?php if (trim($ls->kdbengkel) == trim($sc->kdbengkel)) {
										echo 'selected';
									} ?>
										value="
										<?php echo trim($sc->kdbengkel); ?>" >
										<?php echo trim($sc->kdbengkel) . ' || ' . trim($sc->nmbengkel); ?>
									</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="inputsm">Kode Sub Bengkel</label>
								<select class="form-control input-sm " name="kdsubbengkel" id="kdsubbengkeled" disabled
									readonly>
									<option value="">---PILIH SUB BENGKEL--</option>
									<?php foreach ($list_subbengkel as $sc) { ?>
									<option <?php if (trim($ls->kdsubbengkel) == trim($sc->kdsubbengkel)) {
										echo 'selected';
									} ?> value="
										<?php echo trim($sc->kdsubbengkel); ?>" class="
										<?php echo trim($sc->kdbengkel); ?>" >
										<?php echo trim($sc->kdsubbengkel) . ' || ' . trim($sc->nmbengkel) . ' || ' . trim($sc->city); ?>
									</option>
									<?php } ?>
								</select>
							</div>

						</div> <!---- col 1 -->
							<div class='col-sm-6'>
								<div class="form-group">
									<label for="inputsm">Kilometer Awal</label>
									<input type="number" class="form-control input-sm" id="kmawal" name="kmawal"
										value="<?php echo trim($ls->km_awal); ?>" style="text-transform:uppercase"
										maxlength="20" disabled readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">Kilometer Akhir</label>
									<input type="number" class="form-control input-sm" id="kmakhir" name="kmakhir"
										value="<?php echo trim($ls->km_akhir); ?>" style="text-transform:uppercase"
										maxlength="20" disabled readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">UP Bpk/Ibu/Sdr</label>
									<input type="text" class="form-control input-sm" id="upbengkel" name="upbengkel"
										value="<?php echo trim($ls->upbengkel); ?>" style="text-transform:uppercase"
										maxlength="20" disabled readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">JENIS PERAWATAN</label>
									<select class="form-control input-sm" readonly disabled>
										<option <?php if (trim($dtl_mst['jnsperawatan']) == 'BK') {
											echo 'selected';
										} ?>
											value="BK"><?php echo 'BK' . ' || ' . 'BERKALA'; ?></option>
										<option <?php if (trim($dtl_mst['jnsperawatan']) == 'IS') {
											echo 'selected';
										} ?>
											value="IS"><?php echo 'IS' . ' || ' . 'ISIDENTIL'; ?></option>
									</select>
									<input type="hidden" class="form-control input-sm" name="jnsperawatan" id="jnsperawatan"
										style="text-transform:uppercase" maxlength="25"
										value="<?php echo trim($dtl_mst['jnsperawatan']); ?>">
								</div>
								<div class="form-group">
									<label for="inputsm">KATEGORI PERAWATAN</label>
									<select class="form-control input-sm" name="jnsperawatanref" id="jnsperawatanref"
										disabled readonly>
										<?php foreach ($list_trxtypespk as $sc) { ?>
											<option <?php if (trim($ls->jnsperawatanref) == trim($sc->kdtrx)) {
												echo 'selected';
											} ?> value="<?php echo trim($sc->kdtrx); ?>">
												<?php echo trim($sc->kdtrx) . ' || ' . trim($sc->uraian); ?>
											</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group">
									<label for="inputsm">Total Biaya Servis</label>
									<input type="number" class="form-control input-sm" id="ttlservis" name="ttlservis"
										placeholder="0" value="<?php echo trim(trim($ls->ttlservis)); ?>" disabled readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">Tanggal Masuk/Keluar Bengkel</label>
									<input type="text" class="form-control input-sm tgl" id="tgl" name="tgl"
										data-date-format="dd-mm-yyyy" value="<?php if (empty($row->tglakhir)) {
											echo '';
										} else {
											echo date('d-m-Y', strtotime(trim($ls->tglawal))) . ' - ' . date('d-m-Y', strtotime(trim($ls->tglakhir)));
										} ?>" disabled readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">Keterangan</label>
									<textarea class="textarea" name="keterangan" placeholder="Keterangan" maxlength="159"
										style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"
										disabled readonly><?php echo trim($ls->keterangan); ?></textarea>
								</div>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<!--button type="submit" class="btn btn-danger">Hapus</button--->
			</div>
			</form>

		</div>
	</div>
</div>
<?php } ?>


<div class="modal fade" id="INPUTFAKTUR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
						class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">INPUT MASTER FAKTUR UPLOAD DOKUMEN </h4>
			</div>
			<div class="modal-body">
				<form role="form" action="<?php echo site_url('ga/inventaris/save_spk_lampiran'); ?>" method="post">
					<div class='row'>
						<div class='col-sm-6'>
							<div class="form-group">
								<label for="inputsm">NO DOKUMEN SPK</label>
								<input type="text" class="form-control input-sm" id="nodok" name="nodok"
									style="text-transform:uppercase" maxlength="25"
									value="<?php echo trim($nodokspk); ?>" readonly>
								<input type="hidden" class="form-control input-sm" id="type" name="type"
									value="INPUTTMPMSTFAKTUR">
							</div>
							<div class="form-group">
								<label for="inputsm">NO DOKUMEN REFERENSI</label>
								<input type="text" class="form-control input-sm" id="nodokref" name="nodokref"
									style="text-transform:uppercase" maxlength="35" value="<?php echo trim($nodok); ?>"
									readonly>
							</div>
							<div class="form-group">
								<label for="inputsm">NOMOR FAKTUR</label>
								<input type="text" class="form-control input-sm" id="idfaktur" name="idfaktur"
									style="text-transform:uppercase" maxlength="25" required>
							</div>
							<div class="form-group">
								<label for="inputsm">Keterangan</label>
								<textarea class="textarea" name="keterangan" placeholder="Keterangan" maxlength="159"
									style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
							</div>
						</div> <!---- col 1 -->
						<div class='col-sm-6'>
							<div class="form-group">
								<label for="inputsm">Tanggal Faktur</label>
								<input type="text" class="form-control input-sm tglsm" id="tgl" name="tgl"
									data-date-format="dd-mm-yyyy" required>
							</div>
							<div class="form-group">
								<label for="inputsm">JENIS PERAWATAN</label>
								<select class="form-control input-sm" readonly disabled>
									<option <?php if (trim($dtl_mst['jnsperawatan']) == '') {
										echo 'selected';
									} ?>
										value=""><?php echo '-------PILIH OPTIONS------'; ?></option>
									<option <?php if (trim($dtl_mst['jnsperawatan']) == 'BK') {
										echo 'selected';
									} ?>
										value="BK"><?php echo 'BK' . ' || ' . 'BERKALA'; ?></option>
									<option <?php if (trim($dtl_mst['jnsperawatan']) == 'IS') {
										echo 'selected';
									} ?>
										value="IS"><?php echo 'IS' . ' || ' . 'ISIDENTIL'; ?></option>
								</select>
								<input type="hidden" class="form-control input-sm" name="jnsperawatan" id="jnsperawatan"
									style="text-transform:uppercase" maxlength="25"
									value="<?php echo trim($dtl_mst['jnsperawatan']); ?>">
							</div>
							<div class="form-group">
								<label for="inputsm">Total Servis Brutto</label>
								<input type="number" class="form-control input-sm" id="nservis" name="nservis"
									style="text-transform:uppercase" maxlength="20" placeholder="0" required>
							</div>
							<div class="form-group">
								<label for="inputsm">Total Diskon</label>
								<input type="number" class="form-control input-sm" id="ndiskon" name="ndiskon"
									style="text-transform:uppercase" maxlength="20" placeholder="0" required>
							</div>
							<div class="form-group">
								<label for="inputsm">Total DPP</label>
								<input type="number" class="form-control input-sm" id="ndpp" name="ndpp"
									style="text-transform:uppercase" maxlength="20" placeholder="0" required>
							</div>
							<div class="form-group">
								<label for="inputsm">Total PPN</label>
								<input type="number" class="form-control input-sm" id="nppn" name="nppn"
									style="text-transform:uppercase" maxlength="20" placeholder="0" required>
							</div>
							<div class="form-group">
								<label for="inputsm">Total NETTO</label>
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


<?php foreach ($perawatan_mst_lampiran as $ls) { ?>
	<div class="modal fade" id="DTLFAKTUR<?php echo trim($ls->id); ?>" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">INPUT MASTER FAKTUR UPLOAD DOKUMEN </h4>
				</div>
				<div class="modal-body">
					<form role="form" action="<?php echo site_url('ga/inventaris/save_spk_lampiran'); ?>" method="post">
						<div class='row'>
							<div class='col-sm-6'>
								<div class="form-group">
									<label for="inputsm">NO DOKUMEN SPK</label>
									<input type="text" class="form-control input-sm" id="nodok" name="nodok"
										style="text-transform:uppercase" maxlength="25"
										value="<?php echo trim($nodokspk); ?>" readonly>
									<input type="hidden" class="form-control input-sm" id="id" name="id"
										style="text-transform:uppercase" maxlength="25" value="<?php echo trim($ls->id); ?>"
										readonly>
									<input type="hidden" class="form-control input-sm" id="type" name="type"
										value="DELTMPMSTFAKTUR">
								</div>
								<div class="form-group">
									<label for="inputsm">NO DOKUMEN REFERENSI</label>
									<input type="text" class="form-control input-sm" id="nodokref" name="nodokref"
										style="text-transform:uppercase" maxlength="35"
										value="<?php echo trim($ls->nodokref); ?>" readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">NOMOR FAKTUR</label>
									<input type="text" class="form-control input-sm" id="idfaktur" name="idfaktur"
										style="text-transform:uppercase" maxlength="25"
										value="<?php echo trim($ls->idfaktur); ?>" readonly>
								</div>
								<div class="form-group">
									<label for="inputsm">Keterangan</label>
									<textarea class="textarea" name="keterangan" placeholder="Keterangan" maxlength="159"
										style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"
										readonly disabled></textarea>
								</div>
							</div> <!---- col 1 -->
							<div class='col-sm-6'>
								<div class="form-group">
									<label for="inputsm">Tanggal Faktur</label>
									<input type="text" class="form-control input-sm tglsm" id="tgl" name="tgl"
										data-date-format="dd-mm-yyyy" readonly disabled>
								</div>
								<div class="form-group">
									<input type="hidden" class="form-control input-sm" name="jnsperawatan" id="jnsperawatan"
										style="text-transform:uppercase" maxlength="25"
										value="<?php echo trim($dtl_mst['jnsperawatan']); ?>">
								</div>
								<div class="form-group">
									<label for="inputsm">Total Servis Brutto</label>
									<input type="number" class="form-control input-sm" id="nservis" name="nservis"
										style="text-transform:uppercase" maxlength="20" placeholder="0" readonly disabled>
								</div>
								<div class="form-group">
									<label for="inputsm">Total Diskon</label>
									<input type="number" class="form-control input-sm" id="ndiskon" name="ndiskon"
										style="text-transform:uppercase" maxlength="20" placeholder="0" readonly disabled>
								</div>
								<div class="form-group">
									<label for="inputsm">Total DPP</label>
									<input type="number" class="form-control input-sm" id="ndpp" name="ndpp"
										style="text-transform:uppercase" maxlength="20" placeholder="0" readonly disabled>
								</div>
								<div class="form-group">
									<label for="inputsm">Total PPN</label>
									<input type="number" class="form-control input-sm" id="nppn" name="nppn"
										style="text-transform:uppercase" maxlength="20" placeholder="0" readonly disabled>
								</div>
								<div class="form-group">
									<label for="inputsm">Total NETTO</label>
									<input type="number" class="form-control input-sm" id="nnetto" name="nnetto"
										style="text-transform:uppercase" maxlength="20" placeholder="0" readonly disabled>
								</div>

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




	//Date range picker
	////$("#tgl").daterangepicker(); 
	$(".tgl").daterangepicker();
	$(".tglsm").datepicker();

	$(".tglan").datepicker();
	$('.year').datepicker({
		format: " yyyy",
		viewMode: "years",
		minViewMode: "years"

	});

</script>