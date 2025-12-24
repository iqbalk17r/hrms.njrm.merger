<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				/*    var table = $('#example1').DataTable({
					   lengthMenu: [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
					   pageLength: 4
					}); */
				var save_method; //for save method string
				var table;
		      table = $('#example2').DataTable({ 
        
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": "<?php echo site_url('ga/permintaan/bbmpagin')?>",
					"type": "POST"
				},

				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
				  "targets": [ -1 ], //last column
				  "orderable": false, //set not orderable
				},
				],

			  });

			  
			  
			  
			  
				$("#example3").dataTable();
				$("#example4").dataTable();
				$("#kdsubgroup").chained("#kdgroup");
				$("#kdbarang").chained("#kdsubgroup");

					  });
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>
<h4><?php echo $title2;?></h4>

<?php echo $message;?>

<div class="row">
				<div class="col-sm-1">		
					<a href="<?php echo site_url("pdca/pdca/form_master_plan")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
				</div>
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li>
					<?php if ($nik==trim($nama)) { ?>				  
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#ChoiceOfLetter"  href="#">INPUT MASTER</a></li> 
					<?php } ?>
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/ajustment/input_ajustment_in_trgd")?>">Input Transfer Antar Gudang</a></li-->		
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
</div>	
</br>
<div class="row">
<div class="col-sm-12">
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>DOKUMEN</th>
											<th>NAMA KARYAWAN</th>
											<th>PDCA TYPE</th>
											<th>DESKRIPSI</th>
											<th>LAST PERIOD</th>
											<th>STATUS</th>
											<th width="8%">AKSI</th>	
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_master_plan as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->docno;?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->nmdoctype;?></td>
									<td><?php echo $row->descplan;?></td>
									<td><?php echo $row->planperiod;?></td>
									<td><?php if(trim($row->status)=='F') { echo 'AKTIF'; } else { echo 'TIDAK AKTIF'; }?></td>
									<td width="15%">							
									
									<?php if(trim($row->status)=='F') { ?>
										<?php if ($nik==trim($nama)) { ?>
									<a href="#" data-toggle="modal" data-target="#EDIT<?php echo str_replace('.','',trim($row->nik)).trim($row->nomor);?>" class="btn btn-primary  btn-sm"  title="UBAH DATA LIST PLAN"><i class="fa fa-gear"></i></a>
									<a href="#" data-toggle="modal" data-target="#DEL<?php echo str_replace('.','',trim($row->nik)).trim($row->nomor);?>" class="btn btn-danger  btn-sm"  title="BATAL LIST PLAN"><i class="fa fa-trash-o"></i></a>
										<?php } ?>
									<?php } else { ?>
										<?php if ($nik==$nama) { ?>
									<a href="#" data-toggle="modal" data-target="#RES<?php echo str_replace('.','',trim($row->nik)).trim($row->nomor);?>" class="btn btn-warning  btn-sm"  title="RESTORE LIST PLAN"><i class="fa fa-bookmark"></i></a>
										<?php } ?>
									<?php } ?>		
									<a href="#" data-toggle="modal" data-target="#DETAIL<?php echo str_replace('.','',trim($row->nik)).trim($row->nomor);?>" class="btn btn-default  btn-sm"  title="DETAIL LIST PLAN"><i class="fa fa-bars"></i></a>
									
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
</div><!--/ nav -->	



<div class="modal fade" id="ChoiceOfLetter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> FORM INPUT MASTER PLAN DAILY UNTUK SATU PERIODE </h4>
	  </div>
<form action="<?php echo site_url('pdca/pdca/save_masterplan')?>" method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">NIK </label>	
									<div class="col-sm-8">  
										<input type="input" name="nik" id="nik" value="<?php echo trim($nik); ?>" class="form-control "  readonly>
										<input type="hidden" name="type" id="type" value="INPUTPLAN" class="form-control "  readonly>
									</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">DOCUMENT TYPE </label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm " name="doctype" disabled readonly>
									 <option <?php if ($doctype=='ISD'){ echo 'selected'; } ?> value="ISD"> ISIDENTIL </option> 
									 <option <?php if ($doctype=='BRK'){ echo 'selected'; } ?> value="BRK"> BERKALA </option> 
									</select>
									</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DESKRIPSI PLAN HARIAN</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="descplan" name="descplan"   style="text-transform:uppercase" class="form-control" required></textarea>
								</div>
							</div>	
						</div>
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

<?php foreach ($list_master_plan as $lb) { ?>
<div class="modal fade" id="EDIT<?php echo str_replace('.','',trim($lb->nik)).trim($lb->nomor);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> FORM EDIT MASTER PLAN DAILY UNTUK SATU PERIODE </h4>
	  </div>
<form action="<?php echo site_url('pdca/pdca/save_masterplan')?>" method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">NIK </label>	
									<div class="col-sm-8">  
										<input type="input" name="nik" id="nik" value="<?php echo trim($nik); ?>" class="form-control "  readonly>
										<input type="hidden" name="nomor" id="nomor" value="<?php echo trim($lb->nomor); ?>" class="form-control "  readonly>
										<input type="hidden" name="type" id="type" value="EDITPLAN" class="form-control "  readonly>
									</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">DOCUMENT TYPE </label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm " name="doctype" disabled readonly>
									 <option <?php if ($doctype=='ISD'){ echo 'selected'; } ?> value="ISD"> ISIDENTIL </option> 
									 <option <?php if ($doctype=='BRK'){ echo 'selected'; } ?> value="BRK"> BERKALA </option> 
									</select>
									</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DESKRIPSI PLAN HARIAN</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="descplan" name="descplan"   style="text-transform:uppercase" class="form-control" required><?php echo trim($lb->descplan);?></textarea>
								</div>
							</div>	
						</div>
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
<?php } ?>


<?php foreach ($list_master_plan as $lb) { ?>
<div class="modal fade" id="DETAIL<?php echo str_replace('.','',trim($lb->nik)).trim($lb->nomor);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> FORM DETAIL MASTER PLAN DAILY UNTUK SATU PERIODE </h4>
	  </div>
<form action="<?php echo site_url('pdca/pdca/save_masterplan')?>" method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">NIK </label>	
									<div class="col-sm-8">  
										<input type="input" name="nik" id="nik" value="<?php echo trim($nik); ?>" class="form-control "  readonly>
										<input type="hidden" name="nomor" id="nomor" value="<?php echo trim($lb->nomor); ?>" class="form-control "  readonly>
										<input type="hidden" name="type" id="type" value="EDITPLAN" class="form-control "  readonly>
									</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">DOCUMENT TYPE </label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm " name="doctype" disabled readonly>
									 <option <?php if ($doctype=='ISD'){ echo 'selected'; } ?> value="ISD"> ISIDENTIL </option> 
									 <option <?php if ($doctype=='BRK'){ echo 'selected'; } ?> value="BRK"> BERKALA </option> 
									</select>
									</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DESKRIPSI PLAN HARIAN</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="descplan" name="descplan"   style="text-transform:uppercase" class="form-control" readonly DISABLED><?php echo trim($lb->descplan);?></textarea>
								</div>
							</div>	
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
	  </form>
</div></div></div>
<?php } ?>


<?php foreach ($list_master_plan as $lb) { ?>
<div class="modal fade" id="DEL<?php echo str_replace('.','',trim($lb->nik)).trim($lb->nomor);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> FORM PEMBATALAN MASTER PLAN DAILY UNTUK SATU PERIODE </h4>
	  </div>
<form action="<?php echo site_url('pdca/pdca/save_masterplan')?>" method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">NIK </label>	
									<div class="col-sm-8">  
										<input type="input" name="nik" id="nik" value="<?php echo trim($nik); ?>" class="form-control "  readonly>
										<input type="hidden" name="nomor" id="nomor" value="<?php echo trim($lb->nomor); ?>" class="form-control "  readonly>
										<input type="hidden" name="type" id="type" value="DELETEPLAN" class="form-control "  readonly>
									</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">DOCUMENT TYPE </label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm " name="doctype" disabled readonly>
									 <option <?php if ($doctype=='ISD'){ echo 'selected'; } ?> value="ISD"> ISIDENTIL </option> 
									 <option <?php if ($doctype=='BRK'){ echo 'selected'; } ?> value="BRK"> BERKALA </option> 
									</select>
									</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DESKRIPSI PLAN HARIAN</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="descplan" name="descplan"   style="text-transform:uppercase" class="form-control" readonly DISABLED><?php echo trim($lb->descplan);?></textarea>
								</div>
							</div>	
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-danger">BATALKAN</button>
      </div>
	  </form>
</div></div></div>
<?php } ?>


<?php foreach ($list_master_plan as $lb) { ?>
<div class="modal fade" id="RES<?php echo str_replace('.','',trim($lb->nik)).trim($lb->nomor);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> FORM RESTORE MASTER PLAN DAILY UNTUK SATU PERIODE </h4>
	  </div>
<form action="<?php echo site_url('pdca/pdca/save_masterplan')?>" method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">NIK </label>	
									<div class="col-sm-8">  
										<input type="input" name="nik" id="nik" value="<?php echo trim($nik); ?>" class="form-control "  readonly>
										<input type="hidden" name="nomor" id="nomor" value="<?php echo trim($lb->nomor); ?>" class="form-control "  readonly>
										<input type="hidden" name="type" id="type" value="RESTOREPLAN" class="form-control "  readonly>
									</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">DOCUMENT TYPE </label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm " name="doctype" disabled readonly>
									 <option <?php if ($doctype=='ISD'){ echo 'selected'; } ?> value="ISD"> ISIDENTIL </option> 
									 <option <?php if ($doctype=='BRK'){ echo 'selected'; } ?> value="BRK"> BERKALA </option> 
									</select>
									</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DESKRIPSI PLAN HARIAN</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="descplan" name="descplan"   style="text-transform:uppercase" class="form-control" readonly DISABLED><?php echo trim($lb->descplan);?></textarea>
								</div>
							</div>	
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-warning">RESTORE</button>
      </div>
	  </form>
</div></div></div>
<?php } ?>
<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>