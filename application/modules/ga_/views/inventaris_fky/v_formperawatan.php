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
				$("#kdsubgroup").chained("#kdgroup");	
				$("#kdbarang").chained("#kdsubgroup");	
				$("#userpakai").chained("#kdbarang");	
				$(".kdbarang").chained(".kdgroup");	
				$(".userpakai").chained(".kdbarang");
			//	$("#tglrange").daterangepicker(); 
			
			$("#usermohon").selectize();
	/*		
			$('.pengguna').hide();
			$('#userpakai').change(function(){
												$('.pengguna').hide();
												
												if ($(this).val() != '' || $(this).val() != null) {
													$('.pengguna').show(); 
												}
											
											});*/
            });

			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
	<?php echo $message; ?>
<div class="row">
	<!--div class="col-sm-3">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Kendaraan</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div--->
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/inventaris/input_view_perawatanasset")?>">Input Perawatan Aset</a></li> 
					<!--a href="<?php echo site_url('ga/kendaraan/form_msubbengkel').'/'.trim($row->kdbengkel);?>" class="btn btn-info  btn-sm">
					<i class="fa fa-edit"></i> DETAIL
					</a--->
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("trans/cuti_karyawan/listkaryawan_iss")?>">Input Cuti</a></li-->
				  <!--li role="presentation" class="divider"></li>	
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Haduh Us</a></li---> 
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
	
</div>	
</br>
                         
<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
		<table id="example1" class="table table-bordered table-striped" >
			<thead>
						<tr>											
							<th width="2%">NO.</th>
							<th>NO. DOK.</th>
							<th>NO. ASET</th>
							<th>TANGGAL</th>
							<th>PENGGUNA</th>
							<th>PEMOHON</th>
							<th>BAGIAN</th>
							<th>KETERANGAN/KELUHAN</th>
							<th>STATUS</th>
							<th>SPK</th>
							<th width="15%">AKSI</th>		
						</tr>
			</thead>
					<tbody>
					<?php $no=0; foreach($list_perawatan as $row): $no++;?>
				<tr>
					
					<td width="2%"><?php echo $no;?></td>
					<td><?php echo $row->nodok;?></td>
					<td width="7%"><?php echo $row->numberitem;?></td>
					<td width="7%"><?php echo date('d-m-Y', strtotime(trim($row->tgldok)));?></td>
					<td><?php echo $row->nmlengkap;?></td>
					<td><?php echo $row->nmpemohon;?></td>
					<td><?php echo $row->jabpemohon;?></td>
					<td><?php echo $row->keterangan;?></td>
					<td><?php echo $row->nmstatus;?></td>
					<td><?php echo $row->nmspk;?></td>
					<td width="21%">
							<a href="<?php echo site_url('ga/inventaris/detail_view_perawatanasset').'/'.trim($row->nodok);?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> DETAIL</a>
							<?php if (trim($row->status)=='P') { ?>
							<!--a href="<?php echo site_url('ga/inventaris/sti_perawatan_asset/'.trim($row->nodok));?>" class="btn btn-warning  btn-sm">	<i class="fa fa-edit"></i> CETAK </a--->
							<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php echo site_url('ga/inventaris/sti_perawatan_asset/'.trim($row->nodok));?>');">CETAK</button>
							<?php } ?>
							<?php if (trim($row->status)=='A' and (trim($userhr)>'0' or trim($ceknikatasan1)>'0' )) { ?>
							<a href="<?php echo site_url('ga/inventaris/approval_view_perawatanasset').'/'.trim($row->nodok);?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> APPROVAL</a>
							<?php } else if (trim($row->status)=='A1' and (trim($userhr)>'0'))  { ?>
							<a href="<?php echo site_url('ga/inventaris/approval_view_perawatanasset').'/'.trim($row->nodok);?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> APPROVAL</a>
							<?php } ?>
							<?php if(trim($row->status)=='I' OR trim($row->status)=='A') { ?>
							<a href="<?php echo site_url('ga/inventaris/edit_view_perawatanasset').'/'.trim($row->nodok);?>" class="btn btn-primary  btn-sm"><i class="fa fa-edit"></i> EDIT</a>
							<a href="<?php echo site_url('ga/inventaris/hapus_view_perawatanasset').'/'.trim($row->nodok);?>" class="btn btn-danger btn-sm"><i class="fa fa-edit"></i> BATAL</a>
							<?php } ?>
					</td>
				</tr>
				<?php endforeach;?>	
					</tbody>		
		</table>
	</div><!-- /.box-body -->
	</div><!-- /.box-body -->
	</div><!-- /.box-body -->
</div><!-- /.box-body -->
</div><!-- /.box-body -->

<!-- Modal Input Perawatan ASSET -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT PERAWATAN ASSET</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_perawatanasset');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup">
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm " name="kdsubgroup" id="kdsubgroup">
					 <option  value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih Barang</label>	
					<select class="form-control input-sm" name="kdbarang" id="kdbarang">
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			 <div class="form-group">
				<label for="inputsm">Input Deskripsi Barang</label>
				<input type="text" class="form-control input-sm" id="descbarang" style="text-transform:uppercase" name="descbarang" placeholder="Deskripsi Barang"  maxlength="30" required>
			</div>
			<div class="form-group pengguna">
				<label for="inputsm">Karyawan Pengguna</label>	
					<select class="form-control input-sm" name="userpakai" id="userpakai">
					  <?php foreach($list_karyawanbarang as $sc){?>					  
					  <option value="<?php echo trim($sc->nik);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih Karyawan Pemohon Perawatan</label>	
					<select class="form-control input-sm" name="usermohon" id="usermohon" required>
					 <option value="">---PILIH KARYAWAN PEMOHON--</option> 
					  <?php foreach($list_karyawanparam as $sc){?>					  
					  <option value="<?php echo trim($sc->nik);?>"><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">JENIS PERAWATAN</label>	
					<select class="form-control input-sm" name="jnsperawatan" id="jnsperawatan"  required>
					<option value="">---PILIH JENIS PERAWATAN--</option> 
					<option value="BK"><?php echo 'BK'.' || '.'BERKALA';?></option>						  
					<option value="IS"><?php echo 'IS'.' || '.'ISIDENTIL';?></option>						  
					
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan/Keluhan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">Tanggal Dokumen</label>
				<input type="text" class="form-control input-sm tgl" id="tgldok" name="tgldok"  data-date-format="dd-mm-yyyy"  > <!--value=?php echo date('d-m-Y', strtotime(trim($ls->tglmasuk)));?-->
			</div>

			<div class="form-group">
				<label for="inputsm">Penanganan Keluhan</label>
				<textarea  class="textarea" name="laporanpk" placeholder="Penanganan Keluhan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
			</div>
			<div class="form-group">
				<label for="inputsm">Penggantian Spare Part</label>
				<textarea  class="textarea" name="laporanpsp" placeholder="Penggantian Spare Part"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
			</div>
			<div class="form-group">
				<label for="inputsm">Kondisi Setelah Penanganan</label>
				<textarea  class="textarea" name="laporanksp" placeholder="Kondisi Setelah Penanganan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
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
  </div>
</div>	
</div>			
<!-- -->



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