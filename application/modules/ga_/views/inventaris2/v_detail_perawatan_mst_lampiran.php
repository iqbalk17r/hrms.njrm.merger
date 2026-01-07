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
		<a href="<?php echo site_url('ga/inventaris/detail_inputspk/').'/'.trim($dtl_mst['nodok']);?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
		<!--form role="form" action="<?php echo site_url('ga/inventaris/list_perawatan');?>" method="post">
		<button type="submit" style="margin:10px; color:#000000;" class="btn btn-default">KEMBALI</button>
		</form--->
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
							<th>NODOK</th>
							<th>NODOKREF</th>
							<th>ID FAKTUR</th>
							<th>NAMA BARANG</th>
							<th>BIAYA SERVIS</th>
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
					<td align='right'><?php echo $row->nservis;?></td>
					<td width="15%">
							<a href="#" data-toggle="modal" data-target="#DTLRINCIAN<?php echo trim($row->id);?>" class="btn btn-default  btn-sm">
								<i class="fa fa-edit"></i> DETAIL
							</a>
						
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
							<input type="hidden" class="form-control input-sm" name="type" value="DELDTLINPUT">
							<?php if (trim($dtl_mst['status'])!='X') { ?>
							<!--button class="btn" title="Hapus" onclick="return confirm('Hapus Lampiran Ini?')" style="color:#000055;"  type="submit"><i class="glyphicon glyphicon-trash"></i></button--->
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
						<input type="file" class="form-control" name="userFiles[]" multiple/>
					</div>
				</div>
			</tr></td>
			</table>
		<?php if (trim($dtl_mst['status'])!='X') { ?>
				<!--button class="btn btn-success btn-sm pull-right" style="margin:10px; color:#ffffff;"  type="submit">Simpan</button-->
		<?php } ?>
		</form>	
	</div>
</div><!-- /.row -->
				

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
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUTDTLFAKTUR">
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
				<input type="text" class="form-control input-sm" id="keterangan" name="keterangan" required>
			</div>
			<div class="form-group">
				<label for="inputsm">JENIS PERAWATAN</label>	
					<select class="form-control input-sm" readonly disabled>
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='') { echo 'selected';}?> value=""><?php echo '-------PILIH OPTIONS------';?></option>						  
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='BK') { echo 'selected';}?> value="BK"><?php echo 'BK'.' || '.'BERKALA';?></option>						  
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='IS') { echo 'selected';}?> value="IS"><?php echo 'IS'.' || '.'ISIDENTIL';?></option>						  
					</select>
				<input type="hidden" class="form-control input-sm" name="jnsperawatan" id="jnsperawatan" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($dtl_mst['jnsperawatan']);?>" >	
			</div>
			<div class="form-group">
				<label for="inputsm">Total Servis Brutto</label>	
				<input type="number" class="form-control input-sm" id="nservis" name="nservis" style="text-transform:uppercase" maxlength="20" placeholder="0" required>
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
<div class="modal fade" id="EDITRINCIAN<?php echo trim($ls->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">UBAH RINCIAN PENGGANTIAN FAKTUR </h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/save_spk_lampiran');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<div class="form-group">
				<label for="inputsm">NO DOKUMEN SPK</label>	
				<input type="text" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($dtl_mst['nodok']);?>" readonly>
				<input type="hidden" class="form-control input-sm" id="strtrimref" name="strtrimref" style="text-transform:uppercase" maxlength="50" value="<?php echo bin2hex($this->encrypt->encode(trim($dtl_mst['strtrimref'])));?>" readonly>
				<input type="hidden" class="form-control input-sm" id="id" name="id" style="text-transform:uppercase" maxlength="50" value="<?php echo trim($ls->id);?>" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDITDTLFAKTUR">
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
				<input type="text" class="form-control input-sm" id="keterangan" name="keterangan" value="<?php echo trim($ls->keterangan);?>" required>
			</div>
			<div class="form-group">
				<label for="inputsm">JENIS PERAWATAN</label>	
					<select class="form-control input-sm" readonly disabled>
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='') { echo 'selected';}?> value=""><?php echo '-------PILIH OPTIONS------';?></option>						  
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='BK') { echo 'selected';}?> value="BK"><?php echo 'BK'.' || '.'BERKALA';?></option>						  
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='IS') { echo 'selected';}?> value="IS"><?php echo 'IS'.' || '.'ISIDENTIL';?></option>						  
					</select>
				<input type="hidden" class="form-control input-sm" name="jnsperawatan" id="jnsperawatan" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($dtl_mst['jnsperawatan']);?>" >	
			</div>
			<div class="form-group">
				<label for="inputsm">Total Servis Brutto</label>	
				<input type="number" class="form-control input-sm" id="nservis" name="nservis" style="text-transform:uppercase" value="<?php echo trim($ls->nservis);?>" maxlength="20" placeholder="0" required>
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
<?php } ?>	



<?php foreach ($perawatan_detail_lampiran as $ls){ ?>
<div class="modal fade" id="DTLRINCIAN<?php echo trim($ls->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">UBAH RINCIAN PENGGANTIAN FAKTUR </h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/save_spk_lampiran');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<div class="form-group">
				<label for="inputsm">NO DOKUMEN SPK</label>	
				<input type="text" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($dtl_mst['nodok']);?>" readonly>
				<input type="hidden" class="form-control input-sm" id="strtrimref" name="strtrimref" style="text-transform:uppercase" maxlength="50" value="<?php echo bin2hex($this->encrypt->encode(trim($dtl_mst['strtrimref'])));?>" readonly>
				<input type="hidden" class="form-control input-sm" id="id" name="id" style="text-transform:uppercase" maxlength="50" value="<?php echo trim($ls->id);?>" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDITDTLFAKTUR">
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
				<input type="text" class="form-control input-sm" id="keterangan" name="keterangan" value="<?php echo trim($ls->keterangan);?>" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">JENIS PERAWATAN</label>	
					<select class="form-control input-sm" readonly disabled>
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='') { echo 'selected';}?> value=""><?php echo '-------PILIH OPTIONS------';?></option>						  
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='BK') { echo 'selected';}?> value="BK"><?php echo 'BK'.' || '.'BERKALA';?></option>						  
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='IS') { echo 'selected';}?> value="IS"><?php echo 'IS'.' || '.'ISIDENTIL';?></option>						  
					</select>
				<input type="hidden" class="form-control input-sm" name="jnsperawatan" id="jnsperawatan" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($dtl_mst['jnsperawatan']);?>" >	
			</div>
			<div class="form-group">
				<label for="inputsm">Total Servis Brutto</label>	
				<input type="number" class="form-control input-sm" id="nservis" name="nservis" style="text-transform:uppercase" value="<?php echo trim($ls->nservis);?>" maxlength="20" placeholder="0" readonly>
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
		<h4 class="modal-title" id="myModalLabel">UBAH RINCIAN PENGGANTIAN FAKTUR </h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/save_spk_lampiran');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<div class="form-group">
				<label for="inputsm">NO DOKUMEN SPK</label>	
				<input type="text" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($dtl_mst['nodok']);?>" readonly>
				<input type="hidden" class="form-control input-sm" id="strtrimref" name="strtrimref" style="text-transform:uppercase" maxlength="50" value="<?php echo bin2hex($this->encrypt->encode(trim($dtl_mst['strtrimref'])));?>" readonly>
				<input type="hidden" class="form-control input-sm" id="id" name="id" style="text-transform:uppercase" maxlength="50" value="<?php echo trim($ls->id);?>" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELDTLFAKTUR">
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
				<input type="text" class="form-control input-sm" id="keterangan" name="keterangan" value="<?php echo trim($ls->keterangan);?>" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">JENIS PERAWATAN</label>	
					<select class="form-control input-sm" readonly disabled>
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='') { echo 'selected';}?> value=""><?php echo '-------PILIH OPTIONS------';?></option>						  
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='BK') { echo 'selected';}?> value="BK"><?php echo 'BK'.' || '.'BERKALA';?></option>						  
					<option <?php if (trim($dtl_mst['jnsperawatan'])=='IS') { echo 'selected';}?> value="IS"><?php echo 'IS'.' || '.'ISIDENTIL';?></option>						  
					</select>
				<input type="hidden" class="form-control input-sm" name="jnsperawatan" id="jnsperawatan" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($dtl_mst['jnsperawatan']);?>" >	
			</div>
			<div class="form-group">
				<label for="inputsm">Total Servis Brutto</label>	
				<input type="number" class="form-control input-sm" id="nservis" name="nservis" style="text-transform:uppercase" value="<?php echo trim($ls->nservis);?>" maxlength="20" placeholder="0" readonly>
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
		<button type="submit" class="btn btn-danger">Hapus</button>
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