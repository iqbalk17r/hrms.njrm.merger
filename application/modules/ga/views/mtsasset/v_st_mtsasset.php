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
				
				$(".usertau").selectize(); 
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
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#modalInput"  href="#">Input Mutasi Asset</a></li--> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('ga/mtsasset/flist_mtassetfinal/PxwoOnoandoI');?>">Input Mutasi Asset</a></li> 
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
								<th>NODOK</th>
								<th>MEMO REF</th>
								<th>KODE ASSET</th>
								<th width="30%">NAMA ASSET</th>
								<th width="10%">NOPOL</th>
								<th width="30%">USER PAKAI</th>
								<th>WILAYAH</th>
								<th>NO SK</th>
								<th width="30%">OLD PEMAKAI</th>
								<th>OLD WILAYAH</th>
								<th width="30%">TGL EFEKTIF</th>
								<th>STATUS</th>
								<th>Aksi</th>			
							</tr>
				</thead>
						<tbody>
						<?php $no=0; foreach($list_mutasi_st as $row): $no++;?>
					<tr>
						
						<td width="2%"><?php echo $no;?></td>
						<td><?php echo $row->nodok;?></td>
						<td><?php echo $row->nodokref;?></td>
						<td><?php echo $row->kdbarang;?></td>
						<td width="30%"><?php echo $row->nmbarang;?></td>
						<td width="20%"><?php echo $row->nopol;?></td>
						<td width="30%"><?php echo $row->nmuserpakai;?></td>
						<td><?php echo $row->kdgudang;?></td>
						<td><?php echo $row->nosk;?></td>
						<td width="30%"><?php echo $row->nmolduserpakai;?></td>
						<td><?php echo $row->oldkdgudang;?></td>
						<td width="30%"><?php echo date('d-m-Y', strtotime(trim($row->tglev)));?></td>
						<td><?php echo $row->status;?></td>
						<td width="15%">
								<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> DETAIL
								</a>
								<?php if (trim($row->status)=='A') { ?>
								<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->nodok);?>" class="btn btn-success  btn-sm">
									<i class="fa fa-edit"></i> EDIT
								</a>
								<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->nodok);?>" class="btn btn-danger  btn-sm">
									<i class="fa fa-edit"></i> BATAL
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
<?php foreach($list_mutasi_st as $ls) { ?>
<div class="modal fade" id="ED<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM SERAH TERIMA ASSET <?php echo trim($ls->nodok);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/mtsasset/save_mtsasset_st');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			<input type="hidden" class="form-control input-sm" id="nodok" value="<?php echo trim($ls->nodok);?>" name="nodok">
			<div class="form-group">
				<input type="hidden" class="form-control input-sm" name="kdgroup" id="kdgrouped" value="<?php echo trim($ls->kdgroup);?>" >
				<label for="inputsm">Kode Group ASSET</label>	
					<select class="form-control input-sm "   required disabled>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group ASSET</label>	
				<input type="hidden" class="form-control input-sm"  name="kdsubgroup" id="kdsubgrouped" value="<?php echo trim($ls->kdsubgroup);?>" >
					<select class="form-control input-sm"  readonly disabled>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih ASSET</label>	
				<input type="hidden" class="form-control input-sm"  name="kdbarang"  id="kdbaranged" value="<?php echo trim($ls->kdbarang);?>" >
					<select class="form-control input-sm "  readonly disabled>
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option <?php if (trim($ls->kdbarang)==trim($sc->nodok)) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Lama</label>	
				<input type="hidden" class="form-control input-sm"  name="olduserpakai"  id="olduserpakaied" value="<?php echo trim($ls->olduserpakai);?>" >
					<select class="form-control input-sm " readonly disabled>
					<?php foreach($list_barang as $sc){?>					  
					  <option  <?php if (trim($ls->olduserpakai)==trim($sc->userpakai)) { echo 'selected';}?>  value="<?php echo trim($sc->userpakai);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->userpakai).' || '.trim($sc->nmuserpakai);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Barang</label>	
				<input type="hidden" class="form-control input-sm"  name="oldkdgudang"  id="oldkdgudanged" value="<?php echo trim($ls->oldkdgudang);?>" >
					<select class="form-control input-sm " name="oldkdgudang" id="oldkdgudanged"    readonly disabled>
						<?php foreach($list_barang as $sc){?>					  
						  <option  <?php if (trim($ls->oldkdgudang)==trim($sc->kdgudang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgudang);?>" class="<?php echo trim($sc->userpakai);?>" ><?php echo trim($sc->kdgudang);?></option>						  
						<?php }?>
					</select>
			</div>			
			<div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" value="<?php echo date('d-m-Y', strtotime(trim($ls->tglev)));?>" data-date-format="dd-mm-yyyy"  readonly disabled>
				<input type="hidden" class="form-control input-sm tgl" id="tglev" name="tglev" value="<?php echo date('d-m-Y', strtotime(trim($ls->tglev)));?>" data-date-format="dd-mm-yyyy"  readonly>
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">User Pengguna Baru</label>
				<input type="hidden" class="form-control input-sm"   name="userpakai" id="userpakaied"value="<?php echo trim($ls->userpakai);?>" >
					<select class="form-control input-sm " name="userpakai" id="userpakaied" readonly disabled>
					<option value="">---Pilih User Pengguna Baru--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option  <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Wilayah</label>
					<input type="hidden" class="form-control input-sm"   name="kdgudang" id="kdgudanged" value="<?php echo trim($ls->kdgudang);?>" >				
					<select class="form-control input-sm kdgudang" readonly disabled >
					<?php foreach($list_karyawan as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>"  class="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->kdcabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Input NO SK</label>
				<input type="text" class="form-control input-sm"  style="text-transform:uppercase"  value="<?php echo trim($ls->nosk);?>" placeholder="Input Nomor SK"  maxlength="20" readonly disabled>
				<input type="hidden" class="form-control input-sm" id="nosk" style="text-transform:uppercase"  value="<?php echo trim($ls->nosk);?>"  name="nosk" placeholder="Input Nomor SK"  maxlength="20" readonly >
			</div>
			<div class="form-group">
				<label for="inputsm">Mengetahui</label>
					<select class="form-control input-sm usertau" name="usertau" id="usertau" required>
					<option value="">---Pilih User Mengetahui Serah Terima--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option   <?php if (trim($ls->usertau)==trim($sc->nik)) { echo 'selected';}?> value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"> <?php echo trim($ls->keterangan); ?></textarea>
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
<?php foreach($list_mutasi_st as $ls) { ?>
<div class="modal fade" id="DTL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL MUTASI ASSET <?php echo trim($ls->nodok);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/mtsasset/save_mtsasset_st');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="APPROVAL">
			<input type="hidden" class="form-control input-sm" id="nodok" value="<?php echo trim($ls->nodok);?>" name="nodok">
			<div class="form-group">
				<input type="hidden" class="form-control input-sm" name="kdgroup" id="kdgrouped" value="<?php echo trim($ls->kdgroup);?>" >
				<label for="inputsm">Kode Group ASSET</label>	
					<select class="form-control input-sm "   required disabled>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group ASSET</label>	
				<input type="hidden" class="form-control input-sm"  name="kdsubgroup" id="kdsubgrouped" value="<?php echo trim($ls->kdsubgroup);?>" >
					<select class="form-control input-sm"  readonly disabled>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih ASSET</label>	
				<input type="hidden" class="form-control input-sm"  name="kdbarang"  id="kdbaranged" value="<?php echo trim($ls->kdbarang);?>" >
					<select class="form-control input-sm "  readonly disabled>
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option <?php if (trim($ls->kdbarang)==trim($sc->nodok)) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Lama</label>	
				<input type="hidden" class="form-control input-sm"  name="olduserpakai"  id="olduserpakaied" value="<?php echo trim($ls->olduserpakai);?>" >
					<select class="form-control input-sm " readonly disabled>
					<?php foreach($list_barang as $sc){?>					  
					  <option  <?php if (trim($ls->olduserpakai)==trim($sc->userpakai)) { echo 'selected';}?>  value="<?php echo trim($sc->userpakai);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->userpakai).' || '.trim($sc->nmuserpakai);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Barang</label>	
				<input type="hidden" class="form-control input-sm"  name="oldkdgudang"  id="oldkdgudanged" value="<?php echo trim($ls->oldkdgudang);?>" >
					<select class="form-control input-sm " name="oldkdgudang" id="oldkdgudanged"    readonly disabled>
						<?php foreach($list_barang as $sc){?>					  
						  <option  <?php if (trim($ls->oldkdgudang)==trim($sc->kdgudang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgudang);?>" class="<?php echo trim($sc->userpakai);?>" ><?php echo trim($sc->kdgudang);?></option>						  
						<?php }?>
					</select>
			</div>			
			<div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" value="<?php echo date('d-m-Y', strtotime(trim($ls->tglev)));?>" data-date-format="dd-mm-yyyy"  readonly disabled>
				<input type="hidden" class="form-control input-sm tgl" id="tglev" name="tglev" value="<?php echo date('d-m-Y', strtotime(trim($ls->tglev)));?>" data-date-format="dd-mm-yyyy"  readonly>
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">User Pengguna Baru</label>
				<input type="hidden" class="form-control input-sm"   name="userpakai" id="userpakaied"value="<?php echo trim($ls->userpakai);?>" >
					<select class="form-control input-sm " name="userpakai" id="userpakaied" readonly disabled>
					<option value="">---Pilih User Pengguna Baru--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option  <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Wilayah</label>
					<input type="hidden" class="form-control input-sm"   name="kdgudang" id="kdgudanged" value="<?php echo trim($ls->kdgudang);?>" >				
					<select class="form-control input-sm kdgudang" readonly disabled >
					<?php foreach($list_karyawan as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>"  class="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->kdcabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Input NO SK</label>
				<input type="text" class="form-control input-sm"  style="text-transform:uppercase"  value="<?php echo trim($ls->nosk);?>" placeholder="Input Nomor SK"  maxlength="20" readonly disabled>
				<input type="hidden" class="form-control input-sm" id="nosk" style="text-transform:uppercase"  value="<?php echo trim($ls->nosk);?>"  name="nosk" placeholder="Input Nomor SK"  maxlength="20" readonly >
			</div>
			<div class="form-group">
				<label for="inputsm">Mengetahui</label>
					<select class="form-control input-sm" name="usertau" id="usertau" readonly disabled>
					<option value="">---Pilih User Mengetahui Serah Terima--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option   <?php if (trim($ls->usertau)==trim($sc->nik)) { echo 'selected';}?> value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" readonly disabled> <?php echo trim($ls->keterangan); ?></textarea>
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
<?php foreach($list_mutasi_st as $ls) { ?>
<div class="modal fade" id="DEL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">BATAL MUTASI ASSET <?php echo trim($ls->nodok);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/mtsasset/save_mtsasset_st');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
			<input type="hidden" class="form-control input-sm" id="nodok" value="<?php echo trim($ls->nodok);?>" name="nodok">
			<div class="form-group">
				<input type="hidden" class="form-control input-sm" name="kdgroup" id="kdgrouped" value="<?php echo trim($ls->kdgroup);?>" >
				<label for="inputsm">Kode Group ASSET</label>	
					<select class="form-control input-sm "   required disabled>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group ASSET</label>	
				<input type="hidden" class="form-control input-sm"  name="kdsubgroup" id="kdsubgrouped" value="<?php echo trim($ls->kdsubgroup);?>" >
					<select class="form-control input-sm"  readonly disabled>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih ASSET</label>	
				<input type="hidden" class="form-control input-sm"  name="kdbarang"  id="kdbaranged" value="<?php echo trim($ls->kdbarang);?>" >
					<select class="form-control input-sm "  readonly disabled>
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option <?php if (trim($ls->kdbarang)==trim($sc->nodok)) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Lama</label>	
				<input type="hidden" class="form-control input-sm"  name="olduserpakai"  id="olduserpakaied" value="<?php echo trim($ls->olduserpakai);?>" >
					<select class="form-control input-sm " readonly disabled>
					<?php foreach($list_barang as $sc){?>					  
					  <option  <?php if (trim($ls->olduserpakai)==trim($sc->userpakai)) { echo 'selected';}?>  value="<?php echo trim($sc->userpakai);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->userpakai).' || '.trim($sc->nmuserpakai);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Barang</label>	
				<input type="hidden" class="form-control input-sm"  name="oldkdgudang"  id="oldkdgudanged" value="<?php echo trim($ls->oldkdgudang);?>" >
					<select class="form-control input-sm " name="oldkdgudang" id="oldkdgudanged"    readonly disabled>
						<?php foreach($list_barang as $sc){?>					  
						  <option  <?php if (trim($ls->oldkdgudang)==trim($sc->kdgudang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgudang);?>" class="<?php echo trim($sc->userpakai);?>" ><?php echo trim($sc->kdgudang);?></option>						  
						<?php }?>
					</select>
			</div>			
			<div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" value="<?php echo date('d-m-Y', strtotime(trim($ls->tglev)));?>" data-date-format="dd-mm-yyyy"  readonly disabled>
				<input type="hidden" class="form-control input-sm tgl" id="tglev" name="tglev" value="<?php echo date('d-m-Y', strtotime(trim($ls->tglev)));?>" data-date-format="dd-mm-yyyy"  readonly>
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">User Pengguna Baru</label>
				<input type="hidden" class="form-control input-sm"   name="userpakai" id="userpakaied"value="<?php echo trim($ls->userpakai);?>" >
					<select class="form-control input-sm " name="userpakai" id="userpakaied" readonly disabled>
					<option value="">---Pilih User Pengguna Baru--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option  <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Wilayah</label>
					<input type="hidden" class="form-control input-sm"   name="kdgudang" id="kdgudanged" value="<?php echo trim($ls->kdgudang);?>" >				
					<select class="form-control input-sm kdgudang" readonly disabled >
					<?php foreach($list_karyawan as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>"  class="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->kdcabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Input NO SK</label>
				<input type="text" class="form-control input-sm"  style="text-transform:uppercase"  value="<?php echo trim($ls->nosk);?>" placeholder="Input Nomor SK"  maxlength="20" readonly disabled>
				<input type="hidden" class="form-control input-sm" id="nosk" style="text-transform:uppercase"  value="<?php echo trim($ls->nosk);?>"  name="nosk" placeholder="Input Nomor SK"  maxlength="20" readonly >
			</div>
			<div class="form-group">
				<label for="inputsm">Mengetahui</label>
					<select class="form-control input-sm" name="usertau" id="usertau" readonly disabled>
					<option value="">---Pilih User Mengetahui Serah Terima--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option   <?php if (trim($ls->usertau)==trim($sc->nik)) { echo 'selected';}?> value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" readonly disabled> <?php echo trim($ls->keterangan); ?></textarea>
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