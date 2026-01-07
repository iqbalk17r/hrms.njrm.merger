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
<div class="col-sm-1">
	<a href="<?php echo site_url('ga/mtsasset/penghapusan_asset');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
</div>
<div class="col-xs-12">                            
	<div class="box">
		<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<table id="example1" class="table table-bordered table-striped" >
				<thead>
							<tr>											
								<th width="2%">No.</th>
								<th>KODE ASSET</th>
								<th>NAMA ASSET</th>
								<th>WILAYAH</th>
								<th>NOPOL</th>
								<th>MERK/BRAND</th>
								<th>NAMA PENGGUNA</th>
								<th>AKSI</th>		
							</tr>
				</thead>
						<tbody>
						<?php $no=0; foreach($list_barang as $row): $no++;?>
					<tr>
						
						<td width="2%"><?php echo $no;?></td>
						<td><?php echo $row->nodok;?></td>
						<td><?php echo $row->nmbarang;?></td>
						<td><?php echo $row->namagudang;?></td>
						<td><?php echo $row->nopol;?></td>
						<td><?php echo $row->brand;?></td>
						<td><?php echo $row->nmuserpakai;?></td>
						<td width="15%">
								<a href="<?php echo site_url('ga/mtsasset/input_hapusasset').'/'.trim($row->nodok);?>" class="btn btn-primary  btn-sm"><i class="fa fa-edit"></i> INPUT</a>
						</td>
					</tr>
					<?php endforeach;?>	
						</tbody>		
			</table>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>
			

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