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
<div><a href="<?php echo site_url('ga/inventaris/form_spk');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>

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
						<div class="box-header">
						 <legend><?php echo $title;?></legend>							
						</div><!-- /.box-header -->	
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
											<?php if(trim($row->spk)>0) { ?>	
												<a href="<?php echo site_url('ga/inventaris/inputspk_view/'.trim($row->nodok).'/'.$kdcabang.'/'.$tgl);?>" class="btn btn-default  btn-sm">
														<i class="fa fa-edit"></i> DETAIL SPK
												</a>
											<?php } else { ?>
												<a href="<?php echo site_url('ga/inventaris/inputspk_view/'.trim($row->nodok).'/'.$kdcabang.'/'.$tgl);?>" class="btn btn-primary  btn-sm">
														<i class="fa fa-edit"></i> INPUT SPK
												</a>
											<?php } ?>	
											</td>
										</tr>
										<?php endforeach;?>	
											</tbody>		
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->

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