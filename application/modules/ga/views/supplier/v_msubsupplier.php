<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				//$("#kdsubgroup").chained("#kdgroup");	
			//	$("#tglrange").daterangepicker(); 
            });
					
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title.'   '.$dtl['kdsupplier'].' || '.$dtl['nmsupplier'];?></legend>
<?php echo $message;?>

<div class="row">
	<div class="col-sm-1">	
		<a href="<?php echo site_url('ga/supplier/form_msupplier');?>" style="margin:10px; color:#000000;" class="btn btn-default"> KEMBALI </a>
	</div>
	<div class="col-sm-1">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#inputModal"  href="#">Input Sub Supplier</a></li> 
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
<div class="col-sm-12">
	<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">					
		<li class="active"><a href="#tab_1" data-toggle="tab">LIST SUB SUPPLIER</a></li>
		<!--li><a href="#tab_2" data-toggle="tab">Schema Barang & Asset2</a></li-->	

	</ul>
</div>	
<div class="tab-content">
	<div class="chart tab-pane active" id="tab_1" style="position: relative; height: 300px;" >
		
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">NO.</th>
											<th>KODE SUB SUPPLIER</th>
											<th>NAMA SUPPLIER</th>
											<th>JENIS SUPPLIER</th>
											<th>WILAYAH</th>
											<th>ALAMAT SUPPLIER</th>
											<th>AKSI</th>		
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_subsupplier as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->kdsubsupplier;?></td>
									<td><?php echo $row->nmsubsupplier;?></td>
									<td><?php echo $row->nmjenis;?></td>
									<td><?php echo $row->desc_cabang;?></td>
									<td><?php echo $row->addsupplier;?></td>
									<td width="25%">
										<!--a href="<?php echo site_url('ga/kendaraan/form_msubbengkel').'/'.trim($row->kdsupplier);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL</a-->
											
											<a href="#" data-toggle="modal" data-target="#DTL<?php echo str_replace('.','',trim($row->kdsupplier).trim($row->kdsubsupplier));?>" class="btn btn-default  btn-sm">
												<i class="fa fa-edit"></i> DETAIL
											</a>
											<a href="#" data-toggle="modal" data-target="#ED<?php echo str_replace('.','',trim($row->kdsupplier).trim($row->kdsubsupplier));?>" class="btn btn-success  btn-sm">
												<i class="fa fa-edit"></i> EDIT
											</a>
											<?php if (trim($row->rowdtl)==0) { ?>
											<a href="#" data-toggle="modal" data-target="#DEL<?php echo str_replace('.','',trim($row->kdsupplier).trim($row->kdsubsupplier));?>" class="btn btn-danger  btn-sm">
												<i class="fa fa-trash"></i> HAPUS
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
		</div>
	</div>


</div>	
</div>
</div><!--/ nav -->	
<!-- Modal Input Skema Barang -->

<!-- Modal Input MASTER SUPPLIER -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER SUPPLIER<?php echo $dtl['kdsupplier'].' || '.$dtl['nmsupplier'];?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/supplier/save_subsupplier');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			<div class="form-group">
				<label for="inputsm">Kode Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($dtl['kdsupplier']);?>" id="kdsupplier" style="text-transform:uppercase" name="kdsupplier" placeholder="Kode Supplier Disarankan 4digit kode jenis dan 4digit nomor urut"  readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Nama/Deskripsi Sub Supplier</label>
				<input type="text" class="form-control input-sm" id="nmsubsupplier" style="text-transform:uppercase" name="nmsubsupplier" placeholder="Nama Sub Supplier"  maxlength="30" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Kantor Nusa</label>	
					<select class="form-control input-sm " name="kdcabang" id="kdcabang" required>
					 <option  value="">---PILIH KODE WILAYAH || CABANG--</option> 
					  <?php foreach($list_kanwil as $sc){?>					  
					  <option value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Alamat Supplier</label>
				<input type="text" class="form-control input-sm" id="addsupplier" style="text-transform:uppercase" name="addsupplier" placeholder="Alamat Supplier"  maxlength="160" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Pengusaha Kena Pajak (PKP)</label>	
					<select class="form-control input-sm " name="pkp" id="pkp" required>
					  <option  value="NO"> NO  </option> 
					 <option  value="YES"> YES </option> 
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">PKP NAME</label>
				<input type="text" class="form-control input-sm" id="pkpname" style="text-transform:uppercase" name="pkpname" placeholder="Nama PKP"  maxlength="50" >
			</div>
			</div>
			<div class='col-sm-6'>	
			<div class="form-group">
				<label for="inputsm">Nama Pemilik</label>
				<input type="text" class="form-control input-sm" id="ownsupplier" style="text-transform:uppercase" name="ownsupplier" placeholder="Nama Pemilik Supplier"  maxlength="50" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Phone 1</label>
				<input type="number" class="form-control input-sm" id="phone1" style="text-transform:uppercase" name="phone1" placeholder="Phone1 Supplier"  maxlength="25" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Phone 2</label>
				<input type="number" class="form-control input-sm" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="Phone2 Supplier"  maxlength="25" >
			</div>
			<div class="form-group">
				<label for="inputsm">FAX</label>
				<input type="number" class="form-control input-sm" id="fax" style="text-transform:uppercase" name="fax" placeholder="Fax Supplier"  maxlength="25" >
			</div>
			<div class="form-group">
				<label for="inputsm">EMAIL</label>
				<input type="email" class="form-control input-sm" id="email" style="text-transform:uppercase" name="email" placeholder="Email Supplier"  maxlength="25" >
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
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
		
<!-- EDIT-->
<?php foreach($list_subsupplier as $ls) { ?>
<div class="modal fade" id="ED<?php echo  str_replace('.','',trim($ls->kdsupplier).trim($ls->kdsubsupplier));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT MASTER SUPPLIER<?php echo $dtl['kdsupplier'].' || '.$dtl['nmsupplier'];?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/supplier/save_subsupplier');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
			<div class="form-group">
				<label for="inputsm">Kode Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->kdsupplier);?>" id="kdsupplier" style="text-transform:uppercase" name="kdsupplier" placeholder="Kode Supplier Disarankan 4digit kode jenis dan 4digit nomor urut"  readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->kdsubsupplier);?>"  id="kdsubsupplier" style="text-transform:uppercase" name="kdsubsupplier" placeholder="Kode Sub Supplier Disarankan Nomor URUT" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Nama/Deskripsi Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->nmsubsupplier);?>" id="nmsubsupplier" style="text-transform:uppercase" name="nmsubsupplier" placeholder="Nama nmsubsupplier"  maxlength="30" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Kantor Nusa</label>	
					<select class="form-control input-sm " name="kdcabang" id="kdcabang" required>
					 <option  value="">---PILIH KODE WILAYAH || CABANG--</option> 
					  <?php foreach($list_kanwil as $sc){?>					  
					  <option <?php if (trim($ls->kdcabang)==trim($sc->kdcabang)) { echo 'selected'; } ?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Alamat Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->addsupplier);?>" id="addsupplier" style="text-transform:uppercase" name="addsupplier" placeholder="Alamat Supplier"  maxlength="160" required>
			</div>
			<div class="form-group">
				<label for="inputsm">PKP</label>	
					<select class="form-control input-sm " name="pkp" id="pkp" required>
					  <option <?php if (trim($ls->pkp)=='NO') { echo 'selected'; } ?>  value="NO"> NO  </option> 
					 <option <?php if (trim($ls->pkp)=='YES') { echo 'selected'; } ?>  value="YES"> YES </option> 
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">PKP NAME</label>
				<input type="text" value="<?php echo trim($ls->pkpname);?>"  class="form-control input-sm" id="pkpname" style="text-transform:uppercase" name="pkpname" placeholder="Nama PKP"  maxlength="50" >
			</div>
			</div>
			<div class='col-sm-6'>	
			<div class="form-group">
				<label for="inputsm">Nama Pemilik</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->ownsupplier);?>" id="ownsupplier" style="text-transform:uppercase" name="ownsupplier" placeholder="Nama Pemilik Supplier"  maxlength="50" required >
			</div>
			<div class="form-group">
				<label for="inputsm">Phone 1</label>
				<input type="number" class="form-control input-sm" value="<?php echo trim($ls->phone1);?>" id="phone2" style="text-transform:uppercase" name="phone1" placeholder="Phone1 Supplier"  maxlength="25" required>
			</div>
			<div class="form-group">
				<label for="inputsm">Phone 2</label>
				<input type="number" class="form-control input-sm" value="<?php echo trim($ls->phone2);?>" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="Phone2 Supplier"  maxlength="25" >
			</div>
			<div class="form-group">
				<label for="inputsm">FAX</label>
				<input type="number" class="form-control input-sm" value="<?php echo trim($ls->fax);?>" id="fax" style="text-transform:uppercase" name="fax" placeholder="Fax Supplier"  maxlength="25" >
			</div>
			<div class="form-group">
				<label for="inputsm">EMAIL</label>
				<input type="email" class="form-control input-sm" value="<?php echo trim($ls->email);?>"  id="email" style="text-transform:uppercase" name="email" placeholder="Email Supplier"  maxlength="25" >
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($ls->keterangan);?></textarea>
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

<!-- DETAIL SUB SUPPLIER-->
<?php foreach($list_subsupplier as $ls) { ?>
<div class="modal fade" id="DTL<?php echo  str_replace('.','',trim($ls->kdsupplier).trim($ls->kdsubsupplier));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL MASTER SUPPLIER<?php echo $dtl['kdsupplier'].' || '.$dtl['nmsupplier'];?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/supplier/save_subsupplier');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
			<div class="form-group">
				<label for="inputsm">Kode Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->kdsupplier);?>" id="kdsupplier" style="text-transform:uppercase" name="kdsupplier" placeholder="Kode Supplier Disarankan 4digit kode jenis dan 4digit nomor urut"  readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->kdsubsupplier);?>"  id="kdsubsupplier" style="text-transform:uppercase" name="kdsubsupplier" placeholder="Kode Sub Supplier Disarankan Nomor URUT" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Nama/Deskripsi Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->nmsubsupplier);?>" id="nmsubsupplier" style="text-transform:uppercase" name="nmsubsupplier" placeholder="Nama nmsubsupplier"  maxlength="30"  readonly disabled>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Kantor Nusa</label>	
					<select class="form-control input-sm " name="kdcabang" id="kdcabang" readonly disabled>
					 <option  value="">---PILIH KODE WILAYAH || CABANG--</option> 
					  <?php foreach($list_kanwil as $sc){?>					  
					  <option <?php if (trim($ls->kdcabang)==trim($sc->kdcabang)) { echo 'selected'; } ?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Alamat Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->addsupplier);?>" id="addsupplier" style="text-transform:uppercase" name="addsupplier" placeholder="Alamat Supplier"  maxlength="160" readonly disabled >
			</div>
			<div class="form-group">
				<label for="inputsm">PKP</label>	
					<select class="form-control input-sm " name="pkp" id="pkp" disabled>
					  <option <?php if (trim($ls->pkp)=='NO') { echo 'selected'; } ?>  value="NO"> NO  </option> 
					 <option <?php if (trim($ls->pkp)=='YES') { echo 'selected'; } ?>  value="YES"> YES </option> 
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">PKP NAME</label>
				<input type="text" value="<?php echo trim($ls->pkpname);?>"  class="form-control input-sm" id="pkpname" style="text-transform:uppercase" name="pkpname" placeholder="Nama PKP"  maxlength="50" disabled>
			</div>
			</div>
			<div class='col-sm-6'>	
			<div class="form-group">
				<label for="inputsm">Nama Pemilik</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->ownsupplier);?>" id="ownsupplier" style="text-transform:uppercase" name="ownsupplier" placeholder="Nama Pemilik Supplier"  maxlength="50" readonly disabled >
			</div>
			<div class="form-group">
				<label for="inputsm">Phone 1</label>
				<input type="number" class="form-control input-sm" value="<?php echo trim($ls->phone1);?>" id="phone2" style="text-transform:uppercase" name="phone1" placeholder="Phone1 Supplier"  maxlength="25"  readonly disabled>
			</div>
			<div class="form-group">
				<label for="inputsm">Phone 2</label>
				<input type="number" class="form-control input-sm" value="<?php echo trim($ls->phone2);?>" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="Phone2 Supplier"  maxlength="25" readonly disabled >
			</div>
			<div class="form-group">
				<label for="inputsm">FAX</label>
				<input type="number" class="form-control input-sm" value="<?php echo trim($ls->fax);?>" id="fax" style="text-transform:uppercase" name="fax" placeholder="Fax Supplier"  maxlength="25" readonly disabled >
			</div>
			<div class="form-group">
				<label for="inputsm">EMAIL</label>
				<input type="email" class="form-control input-sm" value="<?php echo trim($ls->email);?>"  id="email" style="text-transform:uppercase" name="email" placeholder="Email Supplier"  maxlength="25"  readonly disabled>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  readonly disabled><?php echo trim($ls->keterangan);?></textarea>
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


<!-- HAPUS SUB SUPPLIER-->
<?php foreach($list_subsupplier as $ls) { ?>
<div class="modal fade" id="DEL<?php echo  str_replace('.','',trim($ls->kdsupplier).trim($ls->kdsubsupplier));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">HAPUS MASTER SUPPLIER<?php echo $dtl['kdsupplier'].' || '.$dtl['nmsupplier'];?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/supplier/save_subsupplier');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
			<div class="form-group">
				<label for="inputsm">Kode Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->kdsupplier);?>" id="kdsupplier" style="text-transform:uppercase" name="kdsupplier" placeholder="Kode Supplier Disarankan 4digit kode jenis dan 4digit nomor urut"  readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->kdsubsupplier);?>"  id="kdsubsupplier" style="text-transform:uppercase" name="kdsubsupplier" placeholder="Kode Sub Supplier Disarankan Nomor URUT" readonly>
			</div>
			<div class="form-group">
				<label for="inputsm">Nama/Deskripsi Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->nmsubsupplier);?>" id="nmsubsupplier" style="text-transform:uppercase" name="nmsubsupplier" placeholder="Nama nmsubsupplier"  maxlength="30"  readonly disabled>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah Kantor Nusa</label>	
					<select class="form-control input-sm " name="kdcabang" id="kdcabang" readonly disabled>
					 <option  value="">---PILIH KODE WILAYAH || CABANG--</option> 
					  <?php foreach($list_kanwil as $sc){?>					  
					  <option <?php if (trim($ls->kdcabang)==trim($sc->kdcabang)) { echo 'selected'; } ?> value="<?php echo trim($sc->kdcabang);?>" ><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Alamat Supplier</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->addsupplier);?>" id="addsupplier" style="text-transform:uppercase" name="addsupplier" placeholder="Alamat Supplier"  maxlength="160" readonly disabled >
			</div>
			<div class="form-group">
				<label for="inputsm">PKP</label>	
					<select class="form-control input-sm " name="pkp" id="pkp" disabled>
					  <option <?php if (trim($ls->pkp)=='NO') { echo 'selected'; } ?>  value="NO"> NO  </option> 
					 <option <?php if (trim($ls->pkp)=='YES') { echo 'selected'; } ?>  value="YES"> YES </option> 
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">PKP NAME</label>
				<input type="text" value="<?php echo trim($ls->pkpname);?>"  class="form-control input-sm" id="pkpname" style="text-transform:uppercase" name="pkpname" placeholder="Nama PKP"  maxlength="50" disabled>
			</div>
			</div>
			<div class='col-sm-6'>	
			<div class="form-group">
				<label for="inputsm">Nama Pemilik</label>
				<input type="text" class="form-control input-sm" value="<?php echo trim($ls->ownsupplier);?>" id="ownsupplier" style="text-transform:uppercase" name="ownsupplier" placeholder="Nama Pemilik Supplier"  maxlength="50" readonly disabled >
			</div>
			<div class="form-group">
				<label for="inputsm">Phone 1</label>
				<input type="number" class="form-control input-sm" value="<?php echo trim($ls->phone1);?>" id="phone2" style="text-transform:uppercase" name="phone1" placeholder="Phone1 Supplier"  maxlength="25"  readonly disabled>
			</div>
			<div class="form-group">
				<label for="inputsm">Phone 2</label>
				<input type="number" class="form-control input-sm" value="<?php echo trim($ls->phone2);?>" id="phone2" style="text-transform:uppercase" name="phone2" placeholder="Phone2 Supplier"  maxlength="25" readonly disabled >
			</div>
			<div class="form-group">
				<label for="inputsm">FAX</label>
				<input type="number" class="form-control input-sm" value="<?php echo trim($ls->fax);?>" id="fax" style="text-transform:uppercase" name="fax" placeholder="Fax Supplier"  maxlength="25" readonly disabled >
			</div>
			<div class="form-group">
				<label for="inputsm">EMAIL</label>
				<input type="email" class="form-control input-sm" value="<?php echo trim($ls->email);?>"  id="email" style="text-transform:uppercase" name="email" placeholder="Email Supplier"  maxlength="25"  readonly disabled>
			</div>
			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"  readonly disabled><?php echo trim($ls->keterangan);?></textarea>
			</div>
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
    	$(".tglan").datepicker(); 
</script>