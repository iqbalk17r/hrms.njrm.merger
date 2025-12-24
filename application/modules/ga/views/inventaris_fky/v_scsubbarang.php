<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				$(".kdgroup").selectize();
			
			//	$("#tglrange").daterangepicker(); 
            });
					
			//empty string means no validation error
			}
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<div class="row">
	<!--div class="col-sm-12">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Schema Barang & Asset</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>

	</div--->
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Sub Skema Barang</a></li> 
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
			<li class="active"><a href="#tab_1" data-toggle="tab">Sub Skema Barang</a></li>
			<!--li><a href="#tab_2" data-toggle="tab">Schema Barang & Asset2</a></li-->	
		</ul>
	</div>	
<div class="tab-content">
	<div class="chart tab-pane active" id="tab_1" style="position: relative; height: 300px;" >
		
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header">
					 <legend><?php echo $title;?></legend>
						<?php echo $message;?>
						
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">NO.</th>
											<th>NAMA SKEMA</th>
											<th>KODE SUBSKEMA</th>
											<th>NAMA SUBSKEMA BARANG</th>
											<th>UJI KIR</th>
											<th>HOLD</th>
											<th>KETERANGAN</th>
											<th>AKSI</th>		
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_msubgroup as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nmgroup;?></td>
									<td><?php echo $row->kdsubgroup;?></td>
									<td><?php echo $row->nmsubgroup;?></td>
									<td><?php echo $row->ujikir;?></td>
									<td><?php echo $row->grouphold;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td width="21%">
											<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->kdgroup);?>" class="btn btn-default  btn-sm">
												<i class="fa fa-edit"></i> DETAIL
											</a>
											<?php if ($row->rowdtl==0) { ?>	
											<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->kdgroup);?>" class="btn btn-success  btn-sm">
												<i class="fa fa-edit"></i> EDIT
											</a>
											<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->kdgroup);?>" class="btn btn-danger  btn-sm">
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
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM MASTER SUB SKEMA BARANG</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_msubgroup');?>" method="post">
		<div class="form-group">
				<label for="inputsm">Kode Skema Barang & Aset</label>	
					<select class="form-control input-sm kdgroup" name="kdgroup" id="kdgroup" required>
					<option value="">---PILIH KODE GRUP || NAMA GROUP --</option> 
					<?php foreach($list_mgroup as $sc){?>					  
						<option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					<?php }?>
					</select>
		</div>
		  <div class="form-group">
			<label for="inputsm">Kode Sub Skema Barang & Aset</label>
			<input type="text" class="form-control input-sm" id="kdsubgroup" name="kdsubgroup" style="text-transform:uppercase" placeholder="Input Kode Sub Skema Barang" maxlength="6" required>
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
		  </div>
		  <div class="form-group">
			<label for="inputsm">Nama Skema</label>
			<input type="text" class="form-control input-sm" id="nmgroup" style="text-transform:uppercase" name="nmgroup" placeholder="Input Nama Sub Skema Barang & Aset" required>
		  </div>
		<div class="form-group">
			<label for="inputsm">Uji KIR</label>	
				<select class="form-control input-sm" name="ujikir" id="ujikir" required>
				  <option value="NO">TIDAK</option>						  
				  <option value="YES">YA</option>	
				</select>
		</div>
		<div class="form-group">
			<label for="inputsm">Hold Skema</label>	
				<select class="form-control input-sm" name="grouphold" id="grouphold" required>
				 <option value="NO">TIDAK</option> 
				 <option value="YES">YA</option> 
				</select>
		</div>
		<!--div class="form-group">
			<label for="inputsm">Group Reminder</label>	
				<select class="form-control input-sm" name="groupreminder" id="groupreminder">
				 <option value="KENDARAAN">KENDARAAN</option> 
				 <option value="ATK">ALAT TULIS KANTOR</option> 
				</select>
		</div-->
		<div class="form-group">
			<label for="inputsm">Keterangan</label>
			<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
		</div>
		  
		  <button type="submit" class="btn btn-primary">Simpan</button>
		  <!---button type="reset" class="btn btn-default">Reset</button--->
		</form>
	  </div>
	</div>
  </div>
</div>	
</div>			
<!-- -->

<!-- EDIT KENDARAAN -->
<?php foreach ($list_msubgroup as $ls){ ?>
<div class="modal fade" id="ED<?php echo trim($ls->kdgroup);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT BARANG</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_msubgroup');?>" method="post">
		<div class="form-group">
				<input type="hidden" class="form-control input-sm" id="kdgroup" name="kdgroup" style="text-transform:uppercase" value="<?php echo trim($ls->kdgroup);?>" readonly>
				<label for="inputsm">Kode Skema Barang & Asset</label>	
					<select class="form-control input-sm kdgroup" name="kdgroupxx" id="kdgroupxx" readonly disabled>
					<option value="">---PILIH KODE GRUP || NAMA GROUP --</option> 
					<?php foreach($list_mgroup as $sc){?>					  
						<option  <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)){ echo 'selected';} ?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					<?php }?>
					</select>
		</div>
		  <div class="form-group">
			<label for="inputsm">Kode Sub Skema Barang & Aset</label>
			<input type="text" class="form-control input-sm" id="kdsubgroup" name="kdsubgroup" style="text-transform:uppercase" value="<?php echo trim($ls->kdsubgroup);?>" placeholder="Input Kode Group Skema Barang & Asset" maxlength="6" readonly>
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
		  </div>
		  <div class="form-group">
			<label for="inputsm">Nama Skema</label>
			<input type="text" class="form-control input-sm" id="nmgroup" style="text-transform:uppercase" name="nmgroup" value="<?php echo trim($ls->nmsubgroup);?>" placeholder="Input Nama Group Skema Barang & Asset">
		  </div>
		<div class="form-group">
			<label for="inputsm">Uji KIR</label>	
				<select class="form-control input-sm" name="ujikir" id="ujikir" >
				  <option <?php if (trim($ls->ujikir)=='NO'){ echo 'selected';} ?> value="NO">TIDAK</option>						  
				  <option <?php if (trim($ls->ujikir)=='YES'){ echo 'selected';} ?> value="YES">YA</option>	
				</select>
		</div>
		<div class="form-group">
			<label for="inputsm">Hold Skema</label>	
				<select class="form-control input-sm" name="grouphold" id="grouphold">
				  <option <?php if (trim($ls->grouphold)=='NO'){ echo 'selected';} ?> value="NO">TIDAK</option>						  
				  <option <?php if (trim($ls->grouphold)=='YES'){ echo 'selected';} ?> value="YES">YA</option>	
				</select>
		</div>
		<!--div class="form-group">
			<label for="inputsm">Group Reminder</label>	
				<select class="form-control input-sm" name="groupreminder" id="groupreminder">
				 <option <?php if (trim($ls->groupreminder)=='KENDARAAN'){ echo 'selected';} ?>  value="KENDARAAN">KENDARAAN</option> 
				 <option <?php if (trim($ls->groupreminder)=='ATK'){ echo 'selected';} ?> value="ATK">ALAT TULIS KANTOR</option> 
				</select>
		</div--->
		<div class="form-group">
			<label for="inputsm">Keterangan</label>
			<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($ls->keterangan); ?></textarea>
		</div>
		  
		  <button type="submit" class="btn btn-primary">Simpan</button>
		 </form>
	  </div>
	</div>
  </div>
</div>									
<?php } ?>
<!-- END EDIT BARANG --->

<!-- DETAIL SUB SKEMA BARANG -->
<?php foreach ($list_msubgroup as $ls){ ?>
<div class="modal fade" id="DTL<?php echo trim($ls->kdgroup);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL SUB SKEMA BARANG</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_msubgroup');?>" method="post">
		<div class="form-group">
				<input type="hidden" class="form-control input-sm" id="kdgroup" name="kdgroup" style="text-transform:uppercase" value="<?php echo trim($ls->kdgroup);?>" readonly>
				<label for="inputsm">Kode Skema Barang & Asset</label>	
					<select class="form-control input-sm kdgroup" name="kdgroupxx" id="kdgroupxx" readonly disabled>
					<option value="">---PILIH KODE GRUP || NAMA GROUP --</option> 
					<?php foreach($list_mgroup as $sc){?>					  
						<option  <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)){ echo 'selected';} ?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					<?php }?>
					</select>
		</div>
		  <div class="form-group">
			<label for="inputsm">Kode Sub Skema Barang & asset</label>
			<input type="text" class="form-control input-sm" id="kdsubgroup" name="kdsubgroup" style="text-transform:uppercase" value="<?php echo trim($ls->kdsubgroup);?>" placeholder="Input Kode Group Skema Barang & Asset" maxlength="6" readonly>
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="DETAIL">
		  </div>
		  <div class="form-group">
			<label for="inputsm">Nama Skema</label>
			<input type="text" class="form-control input-sm" id="nmgroup" style="text-transform:uppercase" name="nmgroup" value="<?php echo trim($ls->nmsubgroup);?>" placeholder="Input Nama Group Skema Barang & Asset" readonly>
		  </div>
		<div class="form-group">
			<label for="inputsm">Uji KIR</label>	
				<select class="form-control input-sm" name="ujikir" id="ujikir" disabled>
				  <option <?php if (trim($ls->ujikir)=='NO'){ echo 'selected';} ?> value="NO">TIDAK</option>						  
				  <option <?php if (trim($ls->ujikir)=='YES'){ echo 'selected';} ?> value="YES">YA</option>	
				</select>
		</div>
		<div class="form-group">
			<label for="inputsm">Hold Skema</label>	
				<select class="form-control input-sm" name="grouphold" id="grouphold" disabled>
				  <option <?php if (trim($ls->grouphold)=='NO'){ echo 'selected';} ?> value="NO">TIDAK</option>						  
				  <option <?php if (trim($ls->grouphold)=='YES'){ echo 'selected';} ?> value="YES">YA</option>	
				</select>
		</div>
		<!--div class="form-group">
			<label for="inputsm">Group Reminder</label>	
				<select class="form-control input-sm" name="groupreminder" id="groupreminder">
				 <option <?php if (trim($ls->groupreminder)=='KENDARAAN'){ echo 'selected';} ?>  value="KENDARAAN">KENDARAAN</option> 
				 <option <?php if (trim($ls->groupreminder)=='ATK'){ echo 'selected';} ?> value="ATK">ALAT TULIS KANTOR</option> 
				</select>
		</div--->
		<div class="form-group">
			<label for="inputsm">Keterangan</label>
			<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" disabled><?php echo trim($ls->keterangan); ?></textarea>
		</div>
		  
		  <button type="submit" class="btn btn-primary">Simpan</button>
		 </form>
	  </div>
	</div>
  </div>
</div>									
<?php } ?>
<!-- END DELETE BARANG --->

<!-- DELETE BARANG-->
<?php foreach ($list_msubgroup as $ls){ ?>
<div class="modal fade" id="DEL<?php echo trim($ls->kdgroup);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DELETE SUB SKEMA BARANG</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_msubgroup');?>" method="post">
		<div class="form-group">
				<input type="hidden" class="form-control input-sm" id="kdgroup" name="kdgroup" style="text-transform:uppercase" value="<?php echo trim($ls->kdgroup);?>" readonly>
				<label for="inputsm">Kode Skema Barang & Asset</label>	
					<select class="form-control input-sm kdgroup" name="kdgroupxx" id="kdgroupxx" readonly disabled>
					<option value="">---PILIH KODE GRUP || NAMA GROUP --</option> 
					<?php foreach($list_mgroup as $sc){?>					  
						<option  <?php if (trim($ls->kdgroup)==trim($sc->kdgroup)){ echo 'selected';} ?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					<?php }?>
					</select>
		</div>
		  <div class="form-group">
			<label for="inputsm">Kode Sub Skema Barang & asset</label>
			<input type="text" class="form-control input-sm" id="kdsubgroup" name="kdsubgroup" style="text-transform:uppercase" value="<?php echo trim($ls->kdsubgroup);?>" placeholder="Input Kode Group Skema Barang & Asset" maxlength="6" readonly>
			<input type="hidden" class="form-control input-sm" id="type" name="type" value="DELETE">
		  </div>
		  <div class="form-group">
			<label for="inputsm">Nama Skema</label>
			<input type="text" class="form-control input-sm" id="nmgroup" style="text-transform:uppercase" name="nmgroup" value="<?php echo trim($ls->nmsubgroup);?>" placeholder="Input Nama Group Skema Barang & Asset" readonly>
		  </div>
		  		<div class="form-group">
			<label for="inputsm">Uji KIR</label>	
				<select class="form-control input-sm" name="ujikir" id="ujikir" disabled>
				  <option <?php if (trim($ls->ujikir)=='NO'){ echo 'selected';} ?> value="NO">TIDAK</option>						  
				  <option <?php if (trim($ls->ujikir)=='YES'){ echo 'selected';} ?> value="YES">YA</option>	
				</select>
		</div>
		<div class="form-group">
			<label for="inputsm">Hold Skema</label>	
				<select class="form-control input-sm" name="grouphold" id="grouphold" disabled>
				  <option <?php if (trim($ls->grouphold)=='NO'){ echo 'selected';} ?> value="NO">TIDAK</option>						  
				  <option <?php if (trim($ls->grouphold)=='YES'){ echo 'selected';} ?> value="YES">YA</option>	
				</select>
		</div>
		<!--div class="form-group">
			<label for="inputsm">Group Reminder</label>	
				<select class="form-control input-sm" name="groupreminder" id="groupreminder">
				 <option <?php if (trim($ls->groupreminder)=='KENDARAAN'){ echo 'selected';} ?>  value="KENDARAAN">KENDARAAN</option> 
				 <option <?php if (trim($ls->groupreminder)=='ATK'){ echo 'selected';} ?> value="ATK">ALAT TULIS KANTOR</option> 
				</select>
		</div--->
		<div class="form-group">
			<label for="inputsm">Keterangan</label>
			<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" disabled><?php echo trim($ls->keterangan); ?></textarea>
		</div>
		  
		  <button type="submit" class="btn btn-danger">Hapus</button>
		 </form>
	  </div>
	</div>
  </div>
</div>									
<?php } ?>
<!-- END OF DELETE KENDARAAN -->


<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode Cuti</h4>
      </div>
	  <form action="<?php site_url('hrd/sms/index')?>" method="post">
      <div class="modal-body">
        <div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name='bulan'>
					
					<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
					<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
					<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
					<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
					<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
					<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
					<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
					<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
					<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
					<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
					<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
					<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
				</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Tahun</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="tahun">
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Filter</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<script>

  

	
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 

  

</script>