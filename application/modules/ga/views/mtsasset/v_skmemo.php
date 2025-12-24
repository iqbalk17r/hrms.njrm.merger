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
			$("#olduserpakai").chained("#kdbarang");	
			$("#oldkdgudang").chained("#olduserpakai");	
			$("#kdgudang").chained("#userpakai");
			
			$("#kdsubgrouped").chained("#kdgrouped");	
			$("#kdbaranged").chained("#kdsubgrouped");
			$("#olduserpakaied").chained("#kdbaranged");	
			$("#oldkdgudanged").chained("#olduserpakaied");	
			$("#kdgudanged").chained("#userpakaied");
			
			
			
			$("#userpakai").selectize();		
			$(".userpakai").selectize();				
			//	$("#tglrange").daterangepicker(); 
            });
					
			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
	
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
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#FILTER_MODAL"  href="#">Filter Pencarian</a></li>
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input SK MEMO</a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("trans/cuti_karyawan/listkaryawan_iss")?>">Input Cuti</a></li-->
				  <!--li role="presentation" class="divider"></li>	
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Haduh Us</a></li---> 
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
	
</div>	
</br>

<div class="col-xs-12">                            
	<div class="box">
		<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<table id="example1" class="table table-bordered table-striped" >
				<thead>
							<tr>											
								<th width="2%">No.</th>
								<th>NO DOKUMEN</th>
								<th>TGL</th>
								<th>NAMA ASSET</th>
								<th>PEMAKAI BARU</th>
								<th>NO SK</th>
								<th>PEMAKAI LAMA</th>
								<th width="8%">TGL EFEKTIF</th>
								<th>STATUS</th>
								<th>Aksi</th>		
							</tr>
				</thead>
						<tbody>
						<?php $no=0; foreach($list_skmemo as $row): $no++;?>
					<tr>
						
						<td width="2%"><?php echo $no;?></td>
						<td><?php echo $row->nodok;?></td>
                        <td  width="8%"><?php echo date('d-m-Y', strtotime(trim($row->tgldok)));?></td>
						<td><?php echo $row->nmbarang;?></td>
						<td><?php echo $row->nmuserpakai;?></td>
						<td><?php echo $row->nosk;?></td>
						<td><?php echo $row->nmolduserpakai;?></td>
						<td  width="8%"><?php echo date('d-m-Y', strtotime(trim($row->tglev)));?></td>
						<td><?php echo $row->nmstatus;?></td>
						<td width="8%">

                                   <?php if(trim($row->status)=='A') { ?>
                                <a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-success  btn-sm" title="Persetujuan"><i class="fa fa-check"></i>
                                   <?php } else { ?>
                                <a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm" title="Detail"><i class="fa fa-bars"></i>
                                   <?php } ?>


								</a>
								<?php if (trim($row->status)<>'P') { ?>
								<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->nodok);?>" class="btn btn-primary  btn-sm" title="Ubah">
									<i class="fa fa-gear"></i>
								</a>
								<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->nodok);?>" class="btn btn-danger  btn-sm" title="Batalkan">
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
</div>
			

<!-- Modal SKMEMO -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT SK MEMO MUTASI ASSET</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/mtsasset/save_skmemo');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			<div class="form-group">
				<label for="inputsm">Kode Group ASSET</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup" required>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group ASSET</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" required>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih ASSET</label>	
					<select class="form-control input-sm" name="kdbarang" id="kdbarang" required>
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Lama</label>	
					<select class="form-control input-sm" name="olduserpakai" id="olduserpakai" readonly>
					<?php foreach($list_barang as $sc){?>					  
					  <option value="<?php echo trim($sc->userpakai);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->userpakai).' || '.trim($sc->nmuserpakai);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Barang</label>	
					<select class="form-control input-sm" name="oldkdgudang" id="oldkdgudang"  readonly>
						<?php foreach($list_barang as $sc){?>					  
						  <option value="<?php echo trim($sc->kdgudang);?>" class="<?php echo trim($sc->userpakai);?>" ><?php echo trim($sc->kdgudang);?></option>						  
						<?php }?>
					</select>
			</div>			
			<div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" id="tglev" name="tglev"  data-date-format="dd-mm-yyyy" required>
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">User Pengguna Baru</label>
					<select class="form-control input-sm" name="userpakai" id="userpakai" required >
					<option value="">---Pilih User Pengguna Baru--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Wilayah</label>	
					<select class="form-control input-sm" name="kdgudang" id="kdgudang" readonly >
					<?php foreach($list_karyawan as $sc){?>					  
					  <option value="<?php echo trim($sc->kdcabang);?>"  class="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->kdcabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Input NO SK</label>
				<input type="text" class="form-control input-sm" id="nosk" style="text-transform:uppercase" name="nosk" placeholder="Input Nomor SK"  maxlength="20" >
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
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
<!-- -->

<!-- EDIT SK MEMO -->
<?php foreach ($list_skmemo as $ls){ ?>
<div class="modal fade" id="ED<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL SK MEMO MUTASI ASSET doc: <?php echo trim($ls->nodok);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/mtsasset/save_skmemo');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			<input type="hidden" class="form-control input-sm" id="nodok" value="<?php echo trim($ls->nodok);?>" name="nodok">
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
			<div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" id="tglev" name="tglev" value="<?php echo date('d-m-Y', strtotime(trim($row->tglev)));?>" data-date-format="dd-mm-yyyy">
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
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
<!-- -->

<!-- DETAIL SK MEMO -->
<?php foreach ($list_skmemo as $ls){ ?>
<div class="modal fade" id="DTL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL DATA (SK) MEMO MUTASI ASSET doc: <?php echo trim($ls->nodok);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/mtsasset/save_skmemo');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="APPROVAL">
			<input type="hidden" class="form-control input-sm" id="nodok" value="<?php echo trim($ls->nodok);?>" name="nodok">
			<div class="form-group">
				<label for="inputsm">Kode Group ASSET</label>	
					<select class="form-control input-sm kdgroup" name="kdgroup"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group ASSET</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" disabled readonly>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih ASSET</label>	
					<select class="form-control input-sm kdbarang" name="kdbarang" disabled readonly >
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option <?php if (trim($ls->kdbarang)==trim($sc->nodok)) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Lama</label>	
					<select class="form-control input-sm olduserpakai" name="olduserpakai"  disabled readonly>
					<?php foreach($list_barang as $sc){?>					  
					  <option  <?php if (trim($ls->olduserpakai)==trim($sc->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->userpakai);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->userpakai).' || '.trim($sc->nmuserpakai);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Barang</label>	
					<select class="form-control input-sm oldkdgudang" name="oldkdgudang"  disabled readonly>
						<?php foreach($list_barang as $sc){?>					  
						  <option  <?php if (trim($ls->oldkdgudang)==trim($sc->kdgudang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgudang);?>" class="<?php echo trim($sc->userpakai);?>" ><?php echo trim($sc->kdgudang);?></option>						  
						<?php }?>
					</select>
			</div>			
			<div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" id="tglev" name="tglev" value="<?php echo date('d-m-Y', strtotime(trim($row->tglev)));?>" data-date-format="dd-mm-yyyy" disabled readonly>
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">User Pengguna Baru</label>
					<select class="form-control input-sm" name="userpakai" disabled readonly>
					<option value="">---Pilih User Pengguna Baru--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option  <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Wilayah</label>	
					<select class="form-control input-sm kdgudang" name="kdgudang" disabled readonly >
					<?php foreach($list_karyawan as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>"  class="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->kdcabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Input NO SK</label>
				<input type="text" class="form-control input-sm" id="nosk" style="text-transform:uppercase"  value="<?php echo trim($ls->nosk);?>"  name="nosk" placeholder="Input Nomor SK"  maxlength="20" disabled readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" disabled readonly><?php echo trim($ls->keterangan);?></textarea>
			  </div>
			</div> 
		</div>
		</div>
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<?php if (trim($ls->status)<>'P') { ?>
			<button type="submit" class="btn btn-primary">APPROVAL</button>
		<?php } ?>
      </div>
		</form>
	</div>  
  </div>
</div>
<?php } ?>		
<!-- -->

<!-- HAPUS SK MEMO -->
<?php foreach ($list_skmemo as $ls){ ?>
<div class="modal fade" id="DEL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">HAPUS SK MEMO MUTASI ASSET doc: <?php echo trim($ls->nodok);?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/mtsasset/save_skmemo');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
			<input type="hidden" class="form-control input-sm" id="nodok" value="<?php echo trim($ls->nodok);?>" name="nodok">
			<div class="form-group">
				<label for="inputsm">Kode Group ASSET</label>	
					<select class="form-control input-sm kdgroup" name="kdgroup"  disabled readonly>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih ASSET</label>	
					<select class="form-control input-sm kdbarang" name="kdbarang" disabled readonly >
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_barang as $sc){?>					  
					  <option <?php if (trim($ls->kdbarang)==trim($sc->nodok)) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang).' || '.trim($sc->nopol);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group ASSET</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" disabled readonly>
					 <option value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($ls->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Pengguna Lama</label>	
					<select class="form-control input-sm olduserpakai" name="olduserpakai"  disabled readonly>
					<?php foreach($list_barang as $sc){?>					  
					  <option  <?php if (trim($ls->olduserpakai)==trim($sc->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->userpakai);?>"  class="<?php echo trim($sc->nodok);?>" ><?php echo trim($sc->userpakai).' || '.trim($sc->nmuserpakai);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Barang</label>	
					<select class="form-control input-sm oldkdgudang" name="oldkdgudang"  disabled readonly>
						<?php foreach($list_barang as $sc){?>					  
						  <option  <?php if (trim($ls->oldkdgudang)==trim($sc->kdgudang)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgudang);?>" class="<?php echo trim($sc->userpakai);?>" ><?php echo trim($sc->kdgudang);?></option>						  
						<?php }?>
					</select>
			</div>			
			<div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" id="tglev" name="tglev" value="<?php echo date('d-m-Y', strtotime(trim($row->tglev)));?>" data-date-format="dd-mm-yyyy" disabled readonly>
			</div>
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">User Pengguna Baru</label>
					<select class="form-control input-sm" name="userpakai" disabled readonly>
					<option value="">---Pilih User Pengguna Baru--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option  <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Wilayah</label>	
					<select class="form-control input-sm kdgudang" name="kdgudang" disabled readonly >
					<?php foreach($list_karyawan as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>"  class="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->kdcabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Input NO SK</label>
				<input type="text" class="form-control input-sm" id="nosk" style="text-transform:uppercase"  value="<?php echo trim($ls->nosk);?>"  name="nosk" placeholder="Input Nomor SK"  maxlength="20" disabled readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" disabled readonly><?php echo trim($ls->keterangan);?></textarea>
			  </div>
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


<div class="modal fade" id="FILTER_MODAL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> FILTER PEMBUATAN SK UNTUK MEMO MUTASI ASSET </h4>
            </div>
            <form action="<?php echo site_url('ga/mtsasset/form_skmemo')?>" method="post" name="inputformPbk">
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
                        <button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
                    </div>
            </form>
        </div></div></div>
<!-- -->
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