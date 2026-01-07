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
	<a href="<?php echo site_url('ga/mtsasset/form_mtsasset');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
</div>
<div class="col-xs-12">                            
	<div class="box">
		<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<table id="example1" class="table table-bordered table-striped" >
				<thead>
							<tr>											
								<th width="2%">No.</th>
								<th>NO DOKUMEN</th>
								<th>KODE ASSET</th>
								<th>NAMA ASSET</th>
								<th>USER PAKAI</th>
								<th>WILAYAH</th>
								<th>NO SK</th>
								<th>OLD PEMAKAI</th>
								<th>OLD WILAYAH</th>
								<th width="20%">TGL EFEKTIF</th>
								<th>STATUS</th>
								<th>Aksi</th>		
							</tr>
				</thead>
						<tbody>
						<?php $no=0; foreach($list_skmemofinal as $row): $no++;?>
					<tr>
						
						<td width="2%"><?php echo $no;?></td>
						<td><?php echo $row->nodok;?></td>
						<td><?php echo $row->kdbarang;?></td>
						<td><?php echo $row->nmbarang;?></td>
						<td><?php echo $row->nmuserpakai;?></td>
						<td><?php echo $row->kdgudang;?></td>
						<td><?php echo $row->nosk;?></td>
						<td><?php echo $row->nmolduserpakai;?></td>
						<td><?php echo $row->oldkdgudang;?></td>
						<td  width="20%"><?php echo date('d-m-Y', strtotime(trim($row->tglev)));?></td>
						<td><?php echo $row->status;?></td>
						<td width="15%">
								<a href="<?php echo site_url('ga/mtsasset/inputmutasi_skfinal').'/'.trim($row->nodok);?>" class="btn btn-primary  btn-sm"><i class="fa fa-edit"></i> INPUT</a>
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