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
				$("#kdbarang").chained("#kdgroup");	
				$("#kdbengkel").chained("#kdcabang");	
				$(".kdbarang").chained(".kdgroup");	
				$(".kdbengkel").chained(".kdcabang");
			//	$("#tglrange").daterangepicker(); 
            });

			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title.'  '.$tgl.'  '.$kdcabang;?></legend>
<div><a href="<?php echo site_url('ga/inventaris/filter_historyperawatan');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>

<div class="row">
	<!--div class="col-sm-3">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Kendaraan</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div--->
	<div class="col-sm-3">	
		<!--div class="container"--->
			<!--div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Perawatan</a></li> 
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
	
</div>	
</br>
                       
<div class="box">
	<div class="box-body table-responsive" style='overflow-x:scroll;'>
		<table id="example1" class="table table-bordered table-striped" >
				<thead>
							<tr>											
								<th width="2%">No.</th>
								<th>NODOK</th>
								<th width="15%">DESC BARANG</th>
								<th width="10%">ITEM NO</th>
								<th width="10%">TANGGAL</th>
								<th>STATUS</th>
								<th>PENGGUNA</th>
								<th>PEMOHON</th>
								<th>BAGIAN</th>
								<th>KETERANGAN/KELUHAN</th>
								<th width="15%">AKSI</th>		
							</tr>
				</thead>
						<tbody>
						<?php $no=0; foreach($list_perawatan as $row): $no++;?>
					<tr>
						
						<td width="2%"><?php echo $no;?></td>
						<td><?php echo $row->nodok;?></td>
						<td><?php echo $row->descbarang;?></td>
						<td width="10%"><?php echo $row->numberitem;?></td>
						<td width="10%"><?php echo date('d-m-Y', strtotime(trim($row->tgldok)));?></td>
						<td><?php echo $row->status;?></td>
						<td><?php echo $row->nmlengkap;?></td>
						<td><?php echo $row->nmpemohon;?></td>
						<td><?php echo $row->jabpemohon;?></td>
						<td><?php echo $row->keterangan;?></td>
						<td width="15%">
							<!--form role="form" action="<?php echo site_url('ga/inventaris/inputspk_view');?>" method="post">
								<input type="hidden" class="form-control input-sm" name="nodok" value="<?php echo trim($row->nodok);?>">
								<input type="hidden" class="form-control input-sm" name="tgl" value="<?php echo trim($tgl);?>">
								<input type="hidden" class="form-control input-sm" name="kdcabang" value="<?php echo trim($kdcabang);?>">
								<button type="submit" class="btn btn-default btn-sm"><i class="fa fa-edit"></i>Detail SPK</button>
							</form--->
						<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm">
							<i class="fa fa-edit"></i> DTL Perawatan
						</a>
						<?php if(trim($row->spk)>0) { ?>	
							<a href="<?php echo site_url('ga/inventaris/history_spkperawatan/'.trim($row->nodok).'/'.$kdcabang.'/'.$tgl);?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> DETAIL SPK
							</a>
						<?php } ?>
						</td>
					</tr>
					<?php endforeach;?>	
						</tbody>		
		</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->

<?php foreach ($list_perawatan as $ls){ ?>
<div class="modal fade" id="DTL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL PERAWATAN ASSET || <?PHP echo trim($ls->nodok);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_perawatanasset');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="APPROVAL">
			<input type="hidden" class="form-control input-sm" id="nodok" name="nodok" value="<?php  echo trim($ls->nodok);?>">
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm kdgroup" name="kdgroup" id="kdgroup" readonly disabled>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih Barang</label>	
					<select class="form-control input-sm kdbarang" name="kdbarang" id="kdbarang" readonly disabled>
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option <?php if (trim($ls->kdbarang)==trim($sc->nodok)) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			 <div class="form-group">
				<label for="inputsm">Input Deskripsi Barang</label>
				<input type="text" class="form-control input-sm" id="descbarang" style="text-transform:uppercase" name="descbarang" placeholder="Deskripsi Barang"  maxlength="30"  value="<?php echo trim($ls->descbarang);?>" readonly>
			</div>
			<div class="form-group pengguna">
				<label for="inputsm">Karyawan Pengguna</label>	
					<select class="form-control input-sm userpakai" name="userpakai" id="userpakai" readonly disabled>
					  <?php foreach($list_karyawanbarang as $sc){?>					  
					  <option <?php if (trim($ls->nikpakai)==trim($sc->nik)) { echo 'selected';}?> value="<?php echo trim($sc->nik);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih Karyawan Pemohon Perawatan</label>	
					<select class="form-control input-sm" name="usermohon" id="usermohon"  readonly disabled>
					 <option value="">---PILIH KARYAWAN PEMOHON--</option> 
					  <?php foreach($list_karyawanbarang as $sc){?>					  
					  <option <?php if (trim($ls->nikmohon)==trim($sc->nik)) { echo 'selected';}?> value="<?php echo trim($sc->nik);?>"><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">JENIS PERAWATAN</label>	
					<select class="form-control input-sm" name="jnsperawatan" id="jnsperawatan"   readonly disabled>
					<option <?php if (trim($ls->jnsperawatan)=='') { echo 'selected';}?> value="">---PILIH JENIS PERAWATAN--</option> 
					<option <?php if (trim($ls->jnsperawatan)=='BK') { echo 'selected';}?> value="BK"><?php echo 'BK'.' || '.'BERKALA';?></option>						  
					<option <?php if (trim($ls->jnsperawatan)=='IS') { echo 'selected';}?> value="IS"><?php echo 'IS'.' || '.'ISIDENTIL';?></option>						  
					
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan/Keluhan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  readonly disabled><?php echo trim($ls->keterangan);?></textarea>
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">Tanggal Dokumen</label>
				<input type="text" value="<?php echo date('d-m-Y', strtotime(trim($ls->tgldok)));?>" class="form-control input-sm tgl" id="tgldok" name="tgldok"  data-date-format="dd-mm-yyyy"  readonly disabled > <!--value=?php echo date('d-m-Y', strtotime(trim($ls->tglmasuk)));?-->
			</div>

			<div class="form-group">
				<label for="inputsm">Penanganan Keluhan</label>
				<textarea  class="textarea" name="laporanpk" placeholder="Penanganan Keluhan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  readonly disabled><?php echo trim($ls->laporanpk);?></textarea>
			</div>
			<div class="form-group">
				<label for="inputsm">Penggantian Spare Part</label>
				<textarea  class="textarea" name="laporanpsp" placeholder="Penggantian Spare Part"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  readonly disabled><?php echo trim($ls->laporanpsp);?></textarea>
			</div>
			<div class="form-group">
				<label for="inputsm">Kondisi Setelah Penanganan</label>
				<textarea  class="textarea" name="laporanksp" placeholder="Kondisi Setelah Penanganan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  readonly disabled><?php echo trim($ls->laporanksp);?></textarea>
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
</div>									
<?php } ?>
<!-- END DETAIL PERAWATAN ASSET --->				
					
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