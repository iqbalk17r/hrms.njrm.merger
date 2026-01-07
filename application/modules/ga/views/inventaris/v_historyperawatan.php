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


<legend><?php echo $title;?></legend>
<div><a href="<?php echo site_url('ga/inventaris/filter_historyperawatan');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a></div>

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
								<th width="1%">No.</th>
								<th width="3%">DOKUMEN</th>
								<th width="8%">NAMA BARANG</th>
								<th width="8%">ITEM NO</th>
								<th width="5%">TANGGAL</th>
								<th width="8%">PEMOHON</th>
								<th width="15%">KETERANGAN/KELUHAN</th>
								<th width="5%">AWAL</th>
								<th width="5%">AKHIR</th>
								<th width="1%">AKSI</th>
							</tr>
				</thead>
						<tbody>
						<?php $no=0; foreach($list_perawatan as $row): $no++;?>
					<tr>
						
						<td width="1%"><?php echo $no;?></td>
						<td width="3%"><?php echo $row->nodok;?></td>
						<td width="3%"><?php echo $row->nmbarang;?></td>
						<td width="8%"><?php echo $row->nopol;?></td>
						<td width="5%"><?php echo trim($row->tgldok);?></td>
						<td width="8%"><?php echo $row->nmmohon;?></td>
						<td width="15%"><?php echo $row->keterangan;?></td>
                        <td width="5%"><?php echo trim($row->tglawal);?></td>
                        <td width="5%"><?php echo trim($row->tglakhir);?></td>
						<td width="1%">
							<!--form role="form" action="<?php echo site_url('ga/inventaris/inputspk_view');?>" method="post">
								<input type="hidden" class="form-control input-sm" name="nodok" value="<?php echo trim($row->nodok);?>">
								<input type="hidden" class="form-control input-sm" name="tgl" value="<?php echo trim($tgl);?>">
								<input type="hidden" class="form-control input-sm" name="kdcabang" value="<?php echo trim($kdcabang);?>">
								<button type="submit" class="btn btn-default btn-sm"><i class="fa fa-edit"></i>Detail SPK</button>
							</form--->
						<!--a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm">
							<i class="fa fa-edit"></i> DTL Perawatan
						</a---->
						<a href="<?php echo site_url('ga/inventaris/history_spkperawatan/'.$this->fiky_encryption->enkript(trim($row->nodok)));?>" class="btn btn-default  btn-sm">
                            <i class="fa fa-bars"></i>
						</a>
	
						</td>
					</tr>
					<?php endforeach;?>	
						</tbody>		
		</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->

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