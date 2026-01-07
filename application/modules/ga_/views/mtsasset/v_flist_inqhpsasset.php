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
<?php echo $message; ?>

<legend><?php echo $title;?></legend>
<!--div class="col-sm-1">
	<a href="<?php echo site_url('ga/mtsasset/penghapusan_asset');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
</div-->
<div class="col-xs-12">                            
	<div class="box">
		<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<table id="example1" class="table table-bordered table-striped" >
				<thead>
							<tr>											
								<th width="2%">No.</th>
								<th>NOMOR PENGHAPUSAN</th>
								<th>KODE ASSET</th>
								<th>NAMA ASSET</th>
								<th>WILAYAH</th>
								<th width="8%">NOPOL</th>
								<th>MERK/BRAND</th>
								<th>NAMA PENGGUNA</th>
								<th>STATUS</th>
								<th>AKSI</th>		
							</tr>
				</thead>
						<tbody>
						<?php $no=0; foreach($list_mbarang_hps as $row): $no++;?>
					<tr>
						
						<td width="2%"><?php echo $no;?></td>
						<td><?php echo $row->nodok;?></td>
						<td><?php echo $row->kdbarang;?></td>
						<td><?php echo $row->nmbarang;?></td>
						<td><?php echo $row->namagudang;?></td>
						<td width="8%"><?php echo $row->nopol;?></td>
						<td><?php echo $row->brand;?></td>
						<td><?php echo $row->nmuserpakai;?></td>
						<td><?php echo $row->status;?></td>
						<td width="15%">
								<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> DETAIL
								</a>
								<!--a href="<?php echo site_url('ga/mtsasset/input_hapusasset').'/'.trim($row->nodok);?>" class="btn btn-primary  btn-sm"><i class="fa fa-edit"></i> INPUT</a-->
						</td>
					</tr>
					<?php endforeach;?>	
						</tbody>		
			</table>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>
			
<!-- DETAIL APPROVAL PENGHAPUSAN ASSET --->	
<?php foreach($list_mbarang_hps as $ls) { ?>
<div class="modal fade" id="DTL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL MUTASI ASSET <?php echo trim($ls->nodok);?></h4>
	  </div>
	  <div class='modal-body'>
			<form role="form" action="<?php echo site_url('ga/mtsasset/save_input_hapusasset');?>" method="post">
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
				<label for="inputsm">NOPOL</label>
				<input type="text" class="form-control input-sm"  style="text-transform:uppercase"  value="<?php echo trim($ls->nopol);?>" placeholder="Input Nomor SK"  maxlength="20" readonly disabled>
				<input type="hidden" class="form-control input-sm" id="nopol" style="text-transform:uppercase"  value="<?php echo trim($ls->nopol);?>"  name="nopol" placeholder="Input Nomor SK"  maxlength="20" readonly >
			</div>			
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">User Pengguna</label>
				<input type="hidden" class="form-control input-sm"   name="userpakai" id="userpakaied"value="<?php echo trim($ls->userpakai);?>" >
					<select class="form-control input-sm " name="userpakai" id="userpakaied" readonly disabled>
					<option value="">---Pilih User Pengguna Baru--</option> 	
						<?php foreach($list_karyawan as $sc){?>					  
						<option  <?php if (trim($ls->userpakai)==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Wilayah</label>
					<input type="hidden" class="form-control input-sm"   name="kdgudang" id="kdgudanged" value="<?php echo trim($ls->kdgudang);?>" >				
					<select class="form-control input-sm kdgudang" readonly disabled >
					<?php foreach($list_karyawan as $sc){?>					  
					  <option  <?php if (trim($ls->kdgudang)==trim($sc->kdcabang)) { echo 'selected';}?> value="<?php echo trim($sc->kdcabang);?>"  class="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->kdcabang);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">User Mengetahui</label>
				<input type="hidden" class="form-control input-sm"   name="usertau" id="usertau" value="<?php echo trim($ls->usertau);?>" >
				<select class="form-control input-sm usertau"  readonly disabled>
					<option value="">---Pilih User Mengetahui--</option > 	
						<?php foreach($list_karyawan as $sc){?>					  
					<option   <?php if (trim($ls->usertau)==trim($sc->nik)) { echo 'selected';}?> value="<?php echo trim($sc->nik);?>"  ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>						  
						<?php }?>
				</select>
			</div>
				<!--div class="form-group">
				<label for="inputsm">Tanggal Efektif</label>
				<input type="text" class="form-control input-sm tgl" value="<?php echo date('d-m-Y', strtotime(trim($dtl['tglev'])));?>" data-date-format="dd-mm-yyyy"  readonly disabled>
				<input type="hidden" class="form-control input-sm tgl" id="tglev" name="tglev" value="<?php echo date('d-m-Y', strtotime(trim($dtl['tglev'])));?>" data-date-format="dd-mm-yyyy"  readonly>
			</div-->
			<div class="form-group">
				<label for="inputsm">Keterangan Penghapusan Asset</label>
				<input type="hidden" class="form-control input-sm"   name="keterangan" id="keterangan" value="<?php echo trim($ls->keterangan);?>" >
				<textarea  class="textarea" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" disabled readonly><?php echo trim($row->keterangan_hps); ?></textarea>
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