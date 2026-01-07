<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<style>
  /*-- change navbar dropdown color --*/
  .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu {
  	background-color: #008040;
    color:#ffffff;
  }

</style>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				//$(".kdbarang").chained(".kdgroup");
			///$("#kdbarangin").chained("#kdgroupin");
			///$("#kdbaranged").chained("#kdgrouped");
			///
			/////$(".kdbarang").chained(".kdgroup");
			/////$(".kdbengkel").chained(".kdcabang");
			$("#kdsubbengkelin").chained("#kdbengkelin");
			$("#kdsubbengkeled").chained("#kdbengkeled");
			//	//$("#tglrange").daterangepicker();
            });

			//empty string means no validation error

</script>

</br>


<legend><?php echo 'INPUT FAKTUR LAMPIRAN EXTERNAL        :  '.trim($dtl_mst['nodokref']);?></legend>
<?php echo $message; ?>
<div class="row">
	<div class="col-sm-1">
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				   <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#INPUTRINCIAN"  href="#">Input Rincian Penggantian</a></li>
				</ul>
			</div>
	</div><!-- /.box-header -->
    <div class="col-sm-11">
        <a href="<?php
        $enc_nodoktmp = $this->fiky_encryption->enkript(trim($nodoktmp));
        echo site_url('ga/inventaris/edit_inputspk').'/'.$enc_nodoktmp;?>" type="button"  style="margin:10px; color:#FFFFff;" class="btn btn-success pull-right"/><i class="fa fa-save"></i> Simpan</a>
    </div>
</div>
</br>
<div class="row">

<div class="box col-lg-12">
	<div class="box-header">
	 <legend><?php echo 'MASTER FAKTUR DAN RINCIAN TOTAL HARGA';?></legend>
	</div><!-- /.box-header -->
	<div class="box-body table-responsive" style='overflow-x:scroll;'>
		<table id="example1" class="table table-bordered table-striped" >
			<thead>
						<tr>
							<th width="2%">No.</th>
							<th>DOKUMEN</th>
							<th>REFERENSI</th>
							<th>ID FAKTUR</th>
							<th>NAMA BARANG</th>
							<th>PPN</th>
							<th>TYPE</th>
							<th>TTL BRUTTO</th>
							<th>POTONGAN</th>
							<th>TTL NETTO</th>
							<th>Aksi</th>
						</tr>
			</thead>
					<tbody>
					<?php $no=0; foreach($perawatan_detail_lampiran as $row): $no++;?>
				<tr>

					<td width="2%"><?php echo $no;?></td>
					<td><?php echo $row->nodok;?></td>
					<td><?php echo $row->nodokref;?></td>
					<td><?php echo $row->idfaktur;?></td>
					<td><?php echo $row->keterangan;?></td>
					<td><?php echo $row->pkp;?></td>
					<td><?php echo $row->exppn;?></td>
					<td align='right' width="8%"><?php echo number_format($row->nservis, 2,",",".");?></td>
					<td align='right' width="8%"><?php echo number_format($row->ndiskon, 2,",",".");?></td>
					<td align='right' width="8%"><?php echo number_format($row->nnetto, 2,",",".");?></td>
					<td width="8%">
							<a href="#" data-toggle="modal" data-target="#DTLRINCIAN<?php echo trim($row->id);?>" class="btn btn-default  btn-sm" title="Detail Rincian">
								<i class="fa fa-bars"></i>
							</a>
							<?php if(trim($row->status)=='I' OR trim($row->status)=='E') { ?>
							<a href="#" data-toggle="modal" data-target="#DELRINCIAN<?php echo trim($row->id);?>" class="btn btn-danger  btn-sm" title="Hapus Rincian Barang">
								<i class="fa fa-trash-o"></i>
							</a>
							<?php } ?>
					</td>
				</tr>
				<?php endforeach;?>
					</tbody>
		</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->

<div class="box col-lg-12">
	<div class="col-sm-6">
	<label for="berlaku" class="col-sm-7 control-label">BERKAS DAN LAMPIRAN NOTA/FAKTUR/INVOICE</label>
	<table id="example3" class="box-body table table-bordered table-striped" >
			<thead>
				<tr>
					<td>No</td>
					<td>Origin Name</td>
					<td>Unduh Daftar Lampiran Nota/Faktur/Invoice</td>
					<td>Action</td>

				</tr>
			</thead>
			<tbody>
		<?php $no=1;foreach ($dtllamp_at as $at){?>
				<tr>
					<td><?php echo $no;?></td>
					<td><a href="#" onclick="window.open('<?php echo site_url('assets/attachment/att_spkperawatan').'/'.$at->file_name;?>')"><?php echo $at->file_name;?></a></td>
					<td><?php echo trim($at->orig_name);?></td>
					<td><!--a href="<?php echo site_url('ga/inventaris/add_attachmentspk/hps_lampiranspk').'/'.trim($at->nodok).'/'.trim($at->id);?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus Lampiran Ini?')"><i class="glyphicon glyphicon-trash"></i></a-->
						<form action="<?php echo site_url('ga/inventaris/hps_lampiranspk'); ?>" method='post' id="form">
							<input type="hidden" class="form-control input-sm" name="nodok" value="<?php echo trim($at->nodok);?>">
							<input type="hidden" class="form-control input-sm" name="file_name" value="<?php echo trim($at->file_name);?>">
							<input type="hidden" class="form-control input-sm" name="strtrimref" value="<?php echo bin2hex($this->encrypt->encode(trim($at->strtrimref)));?>">
							<input type="hidden" class="form-control input-sm" name="type" value="DELDTLEDIT">
							<?php if (trim($dtl_mst['status'])!='X') { ?>
							<button class="btn" title="Hapus" onclick="return confirm('Hapus Lampiran Ini?')" style="color:#000055;"  type="submit"><i class="glyphicon glyphicon-trash"></i></button>
							<?php } ?>
						</form>
					</td>
				</tr>
				<?php $no++; }?>
			</tbody>
		</table>
	</div>
	<div class="col-sm-6 ">
		<form role="form" enctype="multipart/form-data" action="<?php echo site_url('ga/inventaris/add_attachmentspk');?>" method="post">
		<!--form action="<?php echo site_url('ga/inventaris/add_attachmentspk'); ?>" method='post' id="form"--->
			<table id="dataTableLampiran" style="width:100%" class="box-body">
			<tr><td>
				<div class="form-group">
					<label class="control-label col-sm-3">Berkas</label>
					<div class="col-lg-12">
						<input type="hidden" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($dtl_mst['nodok']);?>" readonly>
						<input type="hidden" class="form-control input-sm" id="nodokref" name="nodokref" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($dtl_mst['nodokref']);?>" readonly>
						<input type="hidden" class="form-control input-sm" id="idfaktur" name="idfaktur" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($dtl_mst['idfaktur']);?>" readonly>
						<input type="hidden" class="form-control input-sm" id="strtrimref" name="strtrimref" style="text-transform:uppercase" maxlength="50" value="<?php echo bin2hex($this->encrypt->encode(trim($dtl_mst['strtrimref'])));?>" readonly>
						<input type="hidden" class="form-control input-sm" name="type" value="SAVEEDITDTLLAMPIRAN">
						<input type="file" class="form-control" name="userFiles[]" multiple/>
					</div>
				</div>
			</tr></td>
			</table>
		<?php if (trim($dtl_mst['status'])!='X') { ?>
				<button class="btn btn-success btn-sm pull-right" style="margin:10px; color:#ffffff;"  type="submit">Upload Dokumen Perawatan</button>
		<?php } ?>
		</form>
	</div>
</div><!-- /.row -->

<script type="text/javascript">
$(function() {
    $('.checkexppn2').hide();
    $('#checkppn').change(function(){
        console.log($(this).val().trim()=="YES");

        if($(this).val().trim()=="YES"){
            $('.checkexppn2').show();
        } else {
            $('.checkexppn2').hide();
        }

    });
});
</script>
<!-- Modal SURAT PERINTAH KERJA -->

<div class="modal fade" id="INPUTRINCIAN" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT RINCIAN PENGGANTIAN FAKTUR </h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/save_spk_lampiran');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">NO DOKUMEN SPK</label>
				<input type="text" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($dtl_mst['nodok']);?>" readonly>
				<input type="hidden" class="form-control input-sm" id="strtrimref" name="strtrimref" style="text-transform:uppercase" maxlength="50" value="<?php echo bin2hex($this->encrypt->encode(trim($dtl_mst['strtrimref'])));?>" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUTEDITDTLFAKTUR">
			</div>
			<div class="form-group">
				<label for="inputsm">NO DOKUMEN REFERENSI</label>
				<input type="text" class="form-control input-sm" id="nodokref" name="nodokref" style="text-transform:uppercase" maxlength="35" value="<?php echo trim($dtl_mst['nodokref']);?>" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">NOMOR FAKTUR</label>
				<input type="text" class="form-control input-sm" id="idfaktur" name="idfaktur" value="<?php echo trim($dtl_mst['idfaktur']);?>" style="text-transform:uppercase" maxlength="100"  readonly>
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">Nama Barang /Jasa Servis</label>
				<input type="text" class="form-control input-sm" id="keterangan" name="keterangan" style="text-transform:uppercase" maxlength="20" required>
			</div>
            <div class="form-group">
                <label for="inputsm">PKP</label>
                <select class="form-control input-sm"  name="pkp" id="checkppn" >
                    <option  <?php if (trim($dtl_mst['pkp'])=='NO') { echo 'selected';}?>  value="NO"> NO  </option>
                    <option  <?php if (trim($dtl_mst['pkp'])=='YES') { echo 'selected';}?>  value="YES">  YES  </option>
                </select>
            </div>
            <div class="form-group checkexppn2">
                <label for="inputsm">JENIS PPN</label>
                <select class="form-control input-sm" name="exppn" id="checkexppn">
                    <option  <?php if ('INC'==trim($dtl_mst['exppn'])) { echo 'selected';}?>  value="INC"> INCLUDE </option>
                    <option  <?php if ('EXC'==trim($dtl_mst['exppn'])) { echo 'selected';}?> value="EXC"> EXCLUDE </option>
                </select>
            </div>
			<div class="form-group">
				<label for="inputsm">Total Servis Brutto</label>
				<input type="text" class="form-control input-sm ratakanan fikyseparator" id="nservis" name="nservis" style="text-transform:uppercase" maxlength="20" value="0" required>
			</div>
            <div class="form-group">
                <label for="inputsm">Potongan</label>
                <input type="text" class="form-control input-sm ratakanan fikyseparator" id="ndiskon" name="ndiskon" style="text-transform:uppercase" maxlength="20" value="0" required>
            </div>
			<?php /*
			<div class="form-group">
				<label for="inputsm">Total Diskon</label>
				<input type="number" class="form-control input-sm" id="ndiskon" name="ndiskon" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Total DPP</label>
				<input type="number" class="form-control input-sm" id="ndpp" name="ndpp" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Total PPN</label>
				<input type="number" class="form-control input-sm" id="nppn" name="nppn" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Total NETTO</label>
				<input type="number" class="form-control input-sm" id="nnetto" name="nnetto" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>*/
			?>

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
<!-- -->





<?php foreach ($perawatan_detail_lampiran as $ls){ ?>
<div class="modal fade" id="DTLRINCIAN<?php echo trim($ls->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL RINCIAN PENGGANTIAN FAKTUR </h4>
	  </div>
        <div class="modal-body">
            <form role="form" action="<?php echo site_url('ga/inventaris/save_spk_lampiran');?>" method="post">
                <div class='row'>
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <label for="inputsm">NO DOKUMEN SPK</label>
                            <input type="text" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($ls->nodok);?>" readonly>
                            <input type="hidden" class="form-control input-sm" id="strtrimref" name="strtrimref" style="text-transform:uppercase" maxlength="50" value="<?php echo bin2hex($this->encrypt->encode(trim($ls->strtrimref)));?>" readonly>
                            <input type="hidden" class="form-control input-sm" id="type" name="type" value="DTLEDITDTLFAKTUR">
                        </div>
                        <div class="form-group">
                            <label for="inputsm">NO DOKUMEN REFERENSI</label>
                            <input type="text" class="form-control input-sm" id="nodokref" name="nodokref" style="text-transform:uppercase" maxlength="35" value="<?php echo trim($ls->nodokref);?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">NOMOR FAKTUR</label>
                            <input type="text" class="form-control input-sm" id="idfaktur" name="idfaktur" value="<?php echo trim($ls->idfaktur);?>" style="text-transform:uppercase" maxlength="100"  readonly>
                        </div>
                    </div> <!---- col 1 -->
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <label for="inputsm">Nama Barang /Jasa Servis</label>
                            <input type="text" class="form-control input-sm" id="keterangan" name="keterangan" value="<?php echo trim($ls->keterangan);?>" style="text-transform:uppercase" maxlength="20" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">PKP</label>
                            <select class="form-control input-sm"  name="pkp" id="checkppn" disabled>
                                <option  <?php if (trim($ls->pkp)=='NO') { echo 'selected';}?>  value="NO"> NO  </option>
                                <option  <?php if (trim($ls->pkp)=='YES') { echo 'selected';}?>  value="YES">  YES  </option>
                            </select>
                        </div>
                        <div class="form-group checkexppn2">
                            <label for="inputsm">JENIS PPN</label>
                            <select class="form-control input-sm" name="exppn"  disabled>
                                <option  <?php if ('INC'==trim($ls->exppn)) { echo 'selected';}?>  value="INC"> INCLUDE </option>
                                <option  <?php if ('EXC'==trim($ls->exppn)) { echo 'selected';}?> value="EXC"> EXCLUDE </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Total Servis Brutto</label>
                            <input type="text" value="<?php echo number_format($ls->nservis, 2,",",".");?>" class="form-control input-sm ratakanan fikyseparator" id="nservis" name="nservis" style="text-transform:uppercase" maxlength="20" placeholder="0" readonly>
                        </div>
                        <?php /*
			<div class="form-group">
				<label for="inputsm">Total Diskon</label>
				<input type="number" class="form-control input-sm" id="ndiskon" name="ndiskon" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Total DPP</label>
				<input type="number" class="form-control input-sm" id="ndpp" name="ndpp" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Total PPN</label>
				<input type="number" class="form-control input-sm" id="nppn" name="nppn" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Total NETTO</label>
				<input type="number" class="form-control input-sm" id="nnetto" name="nnetto" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>*/
                        ?>

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


<?php foreach ($perawatan_detail_lampiran as $ls){ ?>
<div class="modal fade" id="DELRINCIAN<?php echo trim($ls->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">HAPUS RINCIAN PENGGANTIAN FAKTUR </h4>
	  </div>
        <div class="modal-body">
            <form role="form" action="<?php echo site_url('ga/inventaris/save_spk_lampiran');?>" method="post">
                <div class='row'>
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <label for="inputsm">NO DOKUMEN SPK</label>
                            <input type="text" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($ls->nodok);?>" readonly>
                            <input type="hidden" class="form-control input-sm" id="strtrimref" name="strtrimref" style="text-transform:uppercase" maxlength="50" value="<?php echo bin2hex($this->encrypt->encode(trim($ls->strtrimref)));?>" readonly>
                            <input type="hidden" class="form-control input-sm" id="id" name="id"  maxlength="50" value="<?php echo $ls->id ;?>" readonly>
                            <input type="hidden" class="form-control input-sm" id="type" name="type" value="DELDTLEDITFAKTUR">
                        </div>
                        <div class="form-group">
                            <label for="inputsm">NO DOKUMEN REFERENSI</label>
                            <input type="text" class="form-control input-sm" id="nodokref" name="nodokref" style="text-transform:uppercase" maxlength="35" value="<?php echo trim($ls->nodokref);?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">NOMOR FAKTUR</label>
                            <input type="text" class="form-control input-sm" id="idfaktur" name="idfaktur" value="<?php echo trim($ls->idfaktur);?>" style="text-transform:uppercase" maxlength="100"  readonly>
                        </div>
                    </div> <!---- col 1 -->
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <label for="inputsm">Nama Barang /Jasa Servis</label>
                            <input type="text" class="form-control input-sm" id="keterangan" name="keterangan" value="<?php echo trim($ls->keterangan);?>" style="text-transform:uppercase" maxlength="20" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">PKP</label>
                            <select class="form-control input-sm"  name="pkp" id="checkppn" disabled>
                                <option  <?php if (trim($ls->pkp)=='NO') { echo 'selected';}?>  value="NO"> NO  </option>
                                <option  <?php if (trim($ls->pkp)=='YES') { echo 'selected';}?>  value="YES">  YES  </option>
                            </select>
                        </div>
                        <div class="form-group checkexppn2">
                            <label for="inputsm">JENIS PPN</label>
                            <select class="form-control input-sm" name="exppn"  disabled>
                                <option  <?php if ('INC'==trim($ls->exppn)) { echo 'selected';}?>  value="INC"> INCLUDE </option>
                                <option  <?php if ('EXC'==trim($ls->exppn)) { echo 'selected';}?> value="EXC"> EXCLUDE </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Total Servis Brutto</label>
                            <input type="text" value="<?php echo number_format($ls->nservis, 2);?>" class="form-control input-sm ratakanan fikyseparator" id="nservis" name="nservis" style="text-transform:uppercase" maxlength="20" placeholder="0" readonly>
                        </div>
                        <?php /*
			<div class="form-group">
				<label for="inputsm">Total Diskon</label>
				<input type="number" class="form-control input-sm" id="ndiskon" name="ndiskon" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Total DPP</label>
				<input type="number" class="form-control input-sm" id="ndpp" name="ndpp" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Total PPN</label>
				<input type="number" class="form-control input-sm" id="nppn" name="nppn" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Total NETTO</label>
				<input type="number" class="form-control input-sm" id="nnetto" name="nnetto" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
			</div>*/
                        ?>

                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">HAPUS</button>
        </div>
        </form>
    </div>
  </div>
</div>
<?php } ?>



<script>
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
