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
			///$("#kdbengkelin").chained("#kdcabangbengkelin");
			///$("#kdbengkeled").chained("#kdcabangbengkeled");
			//	//$("#tglrange").daterangepicker(); 
            });

			//empty string means no validation error

</script>

</br>


<legend><?php echo $title;?></legend>
<?php echo $message; ?>
	<div><a href="<?php echo site_url('ga/inventaris/filter_historyperawatan');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a><div>

<div class="row">
	<!--div class="col-sm-1">
			<form role="form" action="<?php echo site_url('ga/inventaris/history_perawatan');?>" method="post">
			<input type="hidden" class="form-control input-sm" name="nodok" value="<?php echo trim($nodok);?>">
			<input type="hidden" class="form-control input-sm" name="tgl" value="<?php echo trim($tgl);?>">
			<input type="hidden" class="form-control input-sm" name="kdcabang" value="<?php echo trim($kdcabang);?>">
			<input type="hidden" class="form-control input-sm" name="kdgroup" value="<?php echo trim($kdgroup);?>">
		<button type="submit" style="margin:10px; color:#000000;" class="btn btn-default">KEMBALI</button>
		</form>
	</div--->
	<div class="col-sm-1">	
		<!--div class="container"--->
		<?php /*<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#INPUT<?php echo trim($nodok);?>"  href="#">Input SPK</a></li> 
				</ul>
			</div> */ ?>
		<!--/div-->
	</div><!-- /.box-header -->
	
</div>	
</br>
<div class="row">                       
	<div class="box col-lg-12">
		<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<table id="example1" class="table table-bordered table-striped" >
				<thead>
							<tr>											
								<th width="2%">No.</th>
								<th>NODOK</th>
								<th>DESC BARANG</th>
								<th>KD BARANG</th>
								<th>NAMA BARANG</th>
								<th>KD BENGKEL</th>
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
						<?php $no=0; foreach($list_spk as $row): $no++;?>
					<tr>
						
						<td width="2%"><?php echo $no;?></td>
						<td><?php echo $row->nodok;?></td>
						<td><?php echo $row->descbarang;?></td>
						<td><?php echo $row->stockcode;?></td>
						<td><?php echo $row->nmbarang;?></td>
						<td><?php echo $row->kdbengkel;?></td>
						<td><?php echo $row->nmbengkel;?></td>
						<td><?php echo $row->tglawal;?></td>
						<td><?php echo $row->tglakhir;?></td>
						<td><?php echo $row->phone1;?></td>
						<td><?php echo $row->status;?></td>
						<td><?php echo $row->keterangan;?></td>
						<td width="15%">
								<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> DETAIL
								</a>
						</td>
					</tr>
					<?php endforeach;?>	
						</tbody>		
			</table>
		</div><!-- /.box-body -->
	</div><!-- /.box -->	

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
										<input type="hidden" class="form-control input-sm" name="nodok" value="<?php echo trim($nodok);?>">
										<input type="hidden" class="form-control input-sm" name="id" value="<?php echo trim($at->id);?>">
										<input type="hidden" class="form-control input-sm" name="file_name" value="<?php echo trim($at->file_name);?>">
										<input type="hidden" class="form-control input-sm" name="tgl" value="<?php echo trim($tgl);?>">
										<input type="hidden" class="form-control input-sm" name="kdcabang" value="<?php echo trim($kdcabang);?>">
										<?php /* <!--button class="btn" title="Hapus" onclick="return confirm('Hapus Lampiran Ini?')" style="color:#000055;"  type="submit"><i class="glyphicon glyphicon-trash"></i></button---> */ ?>
									</form>	
								</td>		
							</tr>
							<?php $no++; }?>
						</tbody>
					</table>
			  </div>
			 <div class="col-sm-6 ">
<?php /*			 
			<form role="form" enctype="multipart/form-data" action="<?php echo site_url('ga/inventaris/add_attachmentspk');?>" method="post">
					<table id="dataTableLampiran" style="width:100%" class="box-body">
					<tr><td>
						<div class="form-group">	
							<label class="control-label col-sm-3">Berkas</label>	
							<div class="col-lg-12">
								<input type="file" class="form-control" name="userFiles[]" multiple/>
							</div>
						</div>
					</tr></td>
					</table>
								<input type="hidden" class="form-control input-sm" name="nodok" value="<?php echo trim($nodok);?>">
								<input type="hidden" class="form-control input-sm" name="tgl" value="<?php echo trim($tgl);?>">
								<input type="hidden" class="form-control input-sm" name="kdcabang" value="<?php echo trim($kdcabang);?>">
						<button class="btn btn-success btn-sm pull-right" style="margin:10px; color:#ffffff;"  type="submit">Simpan</button>
			</form>	
			</div>

</div><!-- /.row --> */
	?>	

<!-- Modal DETAIL SURAT PERINTAH KERJA -->
<?php foreach ($list_spk as $ls){ ?>
<div class="modal fade" id="DTL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL PERAWATAN ASSET SPK (SURAT PERINTAH KERJA)</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/save_spk');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<div class="form-group">
				<label for="inputsm">NO DOKUMEN</label>	
				<input type="text" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($ls->nodok);?>" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
			</div>
			<div class="form-group">
				<label for="inputsm">DESC BARANG</label>	
				<input type="text" class="form-control input-sm" id="descbarang" name="descbarang" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($ls->descbarang);?>" readonly disabled>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm kdgroup" name="kdgroup" id="kdgrouped"  readonly disabled>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm " name="kdsubgroup" id="kdsubgrouped"  readonly disabled>
					 <option  value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih Barang</label>	
					<select class="form-control input-sm kdbarang" name="kdbarang" id="kdbaranged"  readonly disabled>
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option  <?php if (trim($ls->kdbarang)==trim($sc->nodok)) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<!--div class="form-group">
				<label for="inputsm">KANTOR CABANG PENEMPATAN</label>	
					<select class="form-control input-sm kdcabang" name="kdcabangbengkel" id="kdcabangbengkeled" >
					<option value="">---PILIH KANTOR CABANG PENEMPATAN BENGKEL--</option> 
					<?php foreach($list_kanwil as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					<?php }?>
					</select>
			</div-->
			<div class="form-group">
				<label for="inputsm">Kode Bengkel</label>	
					<select class="form-control input-sm " name="kdbengkel" id="kdbengkeled"  readonly disabled >
					<option value="">---PILIH BENGKEL--</option> 
					<?php foreach($list_bengkel as $sc){?>					  
					  <option <?php if (trim($ls->kdbengkel)==trim($sc->kdbengkel)) { echo 'selected';}?>  value="<?php echo trim($sc->kdbengkel);?>" ><?php echo trim($sc->kdbengkel).' || '.trim($sc->nmbengkel);?></option>						  
					<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Bengkel</label>	
					<select class="form-control input-sm " name="kdsubbengkel" id="kdsubbengkeled"  readonly disabled>
					<option value="">---PILIH SUB BENGKEL--</option> 
					<?php foreach($list_subbengkel as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubbengkel)==trim($sc->kdsubbengkel)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubbengkel);?>" class="<?php echo trim($sc->kdbengkel);?>" ><?php echo trim($sc->kdsubbengkel).' || '.trim($sc->nmbengkel).' || '.trim($sc->city);?></option>						  
					<?php }?>
					</select>
			</div>

			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">JENIS PERAWATAN</label>	
					<select class="form-control input-sm" readonly disabled>
					<option <?php if (trim($ls->jnsperawatan)=='') { echo 'selected';}?> value="">---PILIH JENIS PERAWATAN--</option> 
					<option <?php if (trim($ls->jnsperawatan)=='BK') { echo 'selected';}?> value="BK"><?php echo 'BK'.' || '.'BERKALA';?></option>						  
					<option <?php if (trim($ls->jnsperawatan)=='IS') { echo 'selected';}?> value="IS"><?php echo 'IS'.' || '.'ISIDENTIL';?></option>						  
					</select>
				<input type="hidden" class="form-control input-sm" name="jnsperawatan" id="jnsperawatan" style="text-transform:uppercase" maxlength="25" value="<?php echo trim($ls->jnsperawatan);?>" readonly>	
			</div>
			
			<div class="form-group">
				<label for="inputsm">KATEGORI PERAWATAN</label>	
					<select class="form-control input-sm" name="jnsperawatanref" id="jnsperawatanref"  disabled readonly>
					<?php foreach($list_trxtypespk as $sc){?>					  
					  <option <?php if (trim($ls->jnsperawatanref)==trim($sc->kdtrx)) { echo 'selected';}?> value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->kdtrx).' || '.trim($sc->uraian);?></option>						  
					<?php }?>
					</select>			
			</div>
			<div class="form-group">
				<label for="inputsm">UP BPK/IBU/Sdr</label>	
				<input type="text" class="form-control input-sm" id="upbengkel" name="upbengkel" style="text-transform:uppercase" maxlength="20" value="<?php echo trim($ls->upbengkel);?>"  readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Tanggal Masuk Bengkel</label>
				<input type="text" class="form-control input-sm tgl" id="tglawal" name="tglawal"  data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime(trim($ls->tglawal)));?>"  readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Tanggal Keluar Bengkel</label>
				<input type="text" class="form-control input-sm tgl" id="tglakhir" name="tglakhir"  data-date-format="dd-mm-yyyy"  value="<?php echo date('d-m-Y', strtotime(trim($ls->tglawal)));?>" readonly> 
			</div>

			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  readonly disabled> <?php echo trim($ls->keterangan);?></textarea>
				<input type="hidden" class="form-control input-sm" name="tgl" value="<?php echo trim($tgl);?>">
				<input type="hidden" class="form-control input-sm" name="kdcabang" value="<?php echo trim($kdcabang);?>">
			  </div>
			</div> 
		</div>
		</div>
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<!--button type="submit" class="btn btn-primary">Submit</button--->
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