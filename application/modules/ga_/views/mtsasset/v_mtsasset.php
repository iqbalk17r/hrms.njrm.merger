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
                $('#example1').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();

				$("#kdgroupin").chained(".nodokrefin");
				$("#kdsubgroupin").chained(".nodokrefin");
				$("#kdbarangin").chained(".nodokrefin");
				
			//	$("#tglrange").daterangepicker(); 
            });

			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>


<div class="row">
	<!--div class="col-sm-1">
		<a href="<?php echo site_url('ga/mtsasset/filter_mtsasset');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
	</div--->
	<div class="col-sm-1">	
		<div class="container">
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#FILTER_MODAL"  href="#">Filter Pencarian</a></li>
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#modalInput"  href="#">Input Mutasi Asset</a></li--> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('ga/mtsasset/flist_skfinal/PxwoOnoandoI');?>">Input Mutasi Asset</a></li> 
				</ul>
			</div>
		</div>
	</div><!-- /.box-header -->
</div>	
</br>
                       
<div class="box">
	<div class="box-body table-responsive" style='overflow-x:scroll;'>
		<table id="example1" class="table table-bordered table-striped" >
				<thead>
							<tr>											
								<th width="2%">No.</th>
								<th>DOCUMEN</th>
								<th>DOC MEMO</th>
								<th>TGL</th>
								<th width="30%">NAMA ASSET</th>
								<th width="30%">USER PAKAI</th>
								<th>NO SK</th>
								<th width="30%">PEMAKAI LAMA</th>
								<th width="30%">TGL EFEKTIF</th>
								<th>STATUS</th>
								<th>Aksi</th>			
							</tr>
				</thead>
						<tbody>
						<?php $no=0; foreach($list_mutasi as $row): $no++;?>
					<tr>
						
						<td width="2%"><?php echo $no;?></td>
						<td><?php echo $row->nodok;?></td>
						<td><?php echo $row->nodokref;?></td>
                        <td width="8%"><?php echo date('d-m-Y', strtotime(trim($row->tgldok)));?></td>
						<td width="30%"><?php echo $row->nmbarang;?></td>
						<td width="30%"><?php echo $row->nmuserpakai;?></td>
						<td><?php echo $row->nosk;?></td>
						<td width="30%"><?php echo $row->nmolduserpakai;?></td>
						<td width="8%"><?php echo date('d-m-Y', strtotime(trim($row->tglev)));?></td>
						<td><?php echo $row->nmstatus;?></td>
						<td width="8%">
                                <?php if(trim($row->status)=='A') { ?>
                                <a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-success  btn-sm" title="Persetujuan"><i class="fa fa-check"></i>
                                <?php } else { ?>
                                <a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm" title="Detail"><i class="fa fa-bars"></i>
                                <?php } ?>

								<?php if (trim($row->status)=='A') { ?>
								<a title="UBAH" href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->nodok);?>" class="btn btn-primary  btn-sm">
									<i class="fa fa-gear"></i>
								</a>
								<a title="BATAL" href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->nodok);?>" class="btn btn-danger  btn-sm">
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
<script type="text/javascript">
            $(function() {
				$("#kdsubgrouped").chained("#kdgrouped");	
				$("#kdbaranged").chained("#kdsubgrouped");
				$("#olduserpakaied").chained("#kdbaranged");	
				$("#oldkdgudanged").chained("#olduserpakaied");	
				$("#kdgudanged").chained("#userpakaied");
			});
</script>
			
<!-- EDIT MUTASI ASSET -->
<?php foreach($list_mutasi as $ls) { ?>
<div class="modal fade" id="ED<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT MUTASI ASSET <?php echo trim($ls->nodok);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/mtsasset/save_mtsasset');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			<div class="form-group">
				<label for="inputsm">Dokumen Mutasi</label>
				<input type="text" class="form-control input-sm" id="nodok" name="nodok" value="<?php echo trim($ls->nodok);?>" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Memo Referensi</label>
				<input type="text" class="form-control input-sm" id="nodokref" name="nodokref" value="<?php echo trim($ls->nodokref);?>" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Group ASSET</label>	
					<select class="form-control input-sm " name="kdgroup" id="kdgrouped"  required>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group ASSET</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgrouped" required>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih ASSET</label>	
					<select class="form-control input-sm " name="kdbarang"  id="kdbaranged" required>
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option <?php if (trim($ls->kdbarang)==trim($sc->nodok)) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Lama</label>	
					<select class="form-control input-sm " name="olduserpakai" id="olduserpakaied" readonly>
					<?php foreach($list_barang as $sc){?>					  
					  <option  <?php if (trim($ls->olduserpakai)==trim($sc->userpakai)) { echo 'selected';}?>  value="<?php echo trim($sc->userpakai);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->userpakai).' || '.trim($sc->nmuserpakai);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Barang</label>	
					<select class="form-control input-sm " name="oldkdgudang" id="oldkdgudanged"   readonly>
						<?php foreach($list_barang as $sc){?>					  
						  <option  <?php if (trim($ls->oldkdgudang)==trim($sc->kdgudang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgudang);?>" class="<?php echo trim($sc->userpakai);?>" ><?php echo trim($sc->kdgudang);?></option>						  
						<?php }?>
					</select>
			</div>			

			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" id="tglev" name="tglev" value="<?php echo date('d-m-Y', strtotime(trim($ls->tglev)));?>" data-date-format="dd-mm-yyyy">
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Baru</label>
					<select class="form-control input-sm userpakai" name="userpakai" id="userpakaied">
					<option value="">---Pilih User Pengguna Baru--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option  <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Wilayah</label>	
					<select class="form-control input-sm kdgudang" name="kdgudang" id="kdgudanged" readonly >
					<?php foreach($list_karyawan as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>"  class="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->kdcabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Input NO SK</label>
				<input type="text" class="form-control input-sm" id="nosk" style="text-transform:uppercase"  value="<?php echo trim($ls->nosk);?>"  name="nosk" placeholder="Input Nomor SK"  maxlength="20" >
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($ls->keterangan);?></textarea>
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
<?php } ?>							
<!-- END EDIT MUTASI ASSET --->	

<!-- DETAIL APPROVAL MUTASI ASSET --->	
<?php foreach($list_mutasi as $ls) { ?>
<div class="modal fade" id="DTL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL MUTASI ASSET <?php echo trim($ls->nodok);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/mtsasset/save_mtsasset');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="APPROVAL" >
			<div class="form-group">
				<label for="inputsm">Dokumen Mutasi</label>
				<input type="text" class="form-control input-sm" id="nodok" name="nodok" value="<?php echo trim($ls->nodok);?>" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Memo Referensi</label>
				<input type="text" class="form-control input-sm" id="nodokref" name="nodokref" value="<?php echo trim($ls->nodokref);?>" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Group ASSET</label>	
					<select class="form-control input-sm " name="kdgroup" id="kdgrouped"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group ASSET</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgrouped"  disabled readonly>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih ASSET</label>	
					<select class="form-control input-sm " name="kdbarang"  id="kdbaranged"  disabled readonly>
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option <?php if (trim($ls->kdbarang)==trim($sc->nodok)) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Lama</label>	
					<select class="form-control input-sm " name="olduserpakai" id="olduserpakaied"  disabled readonly>
					<?php foreach($list_barang as $sc){?>					  
					  <option  <?php if (trim($ls->olduserpakai)==trim($sc->userpakai)) { echo 'selected';}?>  value="<?php echo trim($sc->userpakai);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->userpakai).' || '.trim($sc->nmuserpakai);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Barang</label>	
					<select class="form-control input-sm " name="oldkdgudang" id="oldkdgudanged"    disabled readonly>
						<?php foreach($list_barang as $sc){?>					  
						  <option  <?php if (trim($ls->oldkdgudang)==trim($sc->kdgudang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgudang);?>" class="<?php echo trim($sc->userpakai);?>" ><?php echo trim($sc->kdgudang);?></option>						  
						<?php }?>
					</select>
			</div>			

			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" id="tglev" name="tglev" value="<?php echo date('d-m-Y', strtotime(trim($ls->tglev)));?>" data-date-format="dd-mm-yyyy"  disabled readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Baru</label>
					<select class="form-control input-sm userpakai" name="userpakai" id="userpakaied"  disabled readonly>
					<option value="">---Pilih User Pengguna Baru--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option  <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Wilayah</label>	
					<select class="form-control input-sm kdgudang" name="kdgudang" id="kdgudanged"  disabled readonly >
					<?php foreach($list_karyawan as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>"  class="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->kdcabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Input NO SK</label>
				<input type="text" class="form-control input-sm" id="nosk" style="text-transform:uppercase"  value="<?php echo trim($ls->nosk);?>"  name="nosk" placeholder="Input Nomor SK"  maxlength="20"  disabled readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  disabled readonly><?php echo trim($ls->keterangan);?></textarea>
			  </div>
			</div> 
		</div>
       </div>	
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<?php if (trim($ls->status)=='A') { ?>
			<button type="submit" class="btn btn-primary">APPROVAL</button>
		<?php } ?>
      </div>
		</form>
		
	</div>  
  </div>
</div>		
<?php } ?>						
<!-- END DETAIL MUTASI ASSET --->	

<!-- DETAIL HAPUS MUTASI ASSET --->	
<?php foreach($list_mutasi as $ls) { ?>
<div class="modal fade" id="DEL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">BATAL MUTASI ASSET <?php echo trim($ls->nodok);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/mtsasset/save_mtsasset');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE" >
			<div class="form-group">
				<label for="inputsm">Dokumen Mutasi</label>
				<input type="text" class="form-control input-sm" id="nodok" name="nodok" value="<?php echo trim($ls->nodok);?>" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Memo Referensi</label>
				<input type="text" class="form-control input-sm" id="nodokref" name="nodokref" value="<?php echo trim($ls->nodokref);?>" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Group ASSET</label>	
					<select class="form-control input-sm " name="kdgroup" id="kdgrouped"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group ASSET</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgrouped"  disabled readonly>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih ASSET</label>	
					<select class="form-control input-sm " name="kdbarang"  id="kdbaranged"  disabled readonly>
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option <?php if (trim($ls->kdbarang)==trim($sc->nodok)) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Lama</label>	
					<select class="form-control input-sm " name="olduserpakai" id="olduserpakaied"  disabled readonly>
					<?php foreach($list_barang as $sc){?>					  
					  <option  <?php if (trim($ls->olduserpakai)==trim($sc->userpakai)) { echo 'selected';}?>  value="<?php echo trim($sc->userpakai);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->userpakai).' || '.trim($sc->nmuserpakai);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Barang</label>	
					<select class="form-control input-sm " name="oldkdgudang" id="oldkdgudanged"    disabled readonly>
						<?php foreach($list_barang as $sc){?>					  
						  <option  <?php if (trim($ls->oldkdgudang)==trim($sc->kdgudang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgudang);?>" class="<?php echo trim($sc->userpakai);?>" ><?php echo trim($sc->kdgudang);?></option>						  
						<?php }?>
					</select>
			</div>			

			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" id="tglev" name="tglev" value="<?php echo date('d-m-Y', strtotime(trim($ls->tglev)));?>" data-date-format="dd-mm-yyyy"  disabled readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Baru</label>
					<select class="form-control input-sm userpakai" name="userpakai" id="userpakaied"  disabled readonly>
					<option value="">---Pilih User Pengguna Baru--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option  <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Wilayah</label>	
					<select class="form-control input-sm kdgudang" name="kdgudang" id="kdgudanged"  disabled readonly >
					<?php foreach($list_karyawan as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>"  class="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->kdcabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Input NO SK</label>
				<input type="text" class="form-control input-sm" id="nosk" style="text-transform:uppercase"  value="<?php echo trim($ls->nosk);?>"  name="nosk" placeholder="Input Nomor SK"  maxlength="20"  disabled readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  disabled readonly><?php echo trim($ls->keterangan);?></textarea>
			  </div>
			</div> 
		</div>
       </div>	
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<?php if (trim($ls->status)=='A') { ?>
			<button type="submit" class="btn btn-danger">BATAL</button>
		<?php } ?>
      </div>
		</form>
		
	</div>  
  </div>
</div>		
<?php } ?>						
<!-- END HAPUS MUTASI ASSET --->

<div class="modal fade" id="FILTER_MODAL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> FILTER PEMBUATAN SK UNTUK MEMO MUTASI ASSET </h4>
            </div>
            <form action="<?php echo site_url('ga/mtsasset/form_mtsasset')?>" method="post" name="inputformPbk">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
                                            <div class="col-sm-8">
                                                <input type="input" name="tgl"  class="form-control input-sm tglrange"  >
                                            </div>
                                        </div>
                                        <!--div class="form-group ">
									<label class="col-sm-4" for="inputsm">PILIH NAMA KARYAWAN </label>
									<div class="col-sm-8">
									<select class="form-control input-sm " name="nik" id="nik">
										<option value=""><tr><th width="20%">-- NIK |</th><th width="80%">| NAMA KARYAWAN --</th></tr></option>
										<?php foreach($list_nik as $sc){?>
										<option value="<?php echo trim($sc->nik);?>" ><tr><th width="20%"><?php echo trim($sc->nik);?>  |</th><th width="80%">| <?php echo trim($sc->nmlengkap);?></th></tr></option>
										<?php }?>
									</select>
									</div>
							</div--->

                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit"  class="btn btn-primary">PROSES</button>
                    </div>
            </form>
        </div></div></div>
				
<script>

	//Date range picker
    $(".tglrange").daterangepicker();
    	$("#tgl").datepicker(); 
    	$(".tgl").datepicker(); 
    	$(".tglan").datepicker(); 
				$('.year').datepicker({
					format: " yyyy",
					viewMode: "years", 
					minViewMode: "years"
				
				});

</script>