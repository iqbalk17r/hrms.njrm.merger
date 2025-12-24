<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
					<script type="text/javascript" charset="utf-8">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				$(".tgl").datepicker();   
					
			});



		
				
</script>
<!--div class="pull-right">Versi: <?php echo $version; ?></div--->
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>


</br>
<div class="row">
		<div class="col-sm-12">		
			<a href="<?php echo site_url("intern/cr_sj/form_list_po")?>"  onclick="return confirm('Anda akan kembali ??')" class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
			
		</div>
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
											<th>TGL DOKUMEN</th>
											<th>STATUS</th>
											<th>TIPE</th>
											<th>NAMA SUPPLIER</th>
											<th>KOTA SUPPLIER</th>
											<th>DESKRIPSI</th>
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_trx_t_pomst as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo TRIM($row->fc_pono);?></td>
									<td><?php if (empty($row->fd_podate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->fd_podate))); }?></td>
									<td><?php echo TRIM($row->status);?></td>	
									<td><?php echo TRIM($row->tipe);?></td>	
									<td><?php echo TRIM($row->fv_suppname);?></td>	
									<td><?php echo TRIM($row->fv_suppcity);?></td>	
									<td><?php echo TRIM($row->ft_note);?></td>	
								</tr>
								<?php endforeach;?>	
							</tbody>		
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>	
</div>
<?php /*<div class="row">
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#INPUT_IN_TRGD_DTL"  href="#">Input Barang Transfer Gudang</a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/ajustment/input_ajustment_in_trgd")?>">Input Transfer Antar Gudang</a></li--->		
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
</div>	 

		<a href="<?php echo site_url("intern/cr_sj/reset_input")?>"  class="btn btn-danger pull-right" onclick="return confirm('Reset info Qty Data Ini?? Akan Otomatis Kembali Ke 0 ')" style="margin:10px; color:#ffffff;">RESET</a>
*/ ?>
<div class="col-sm-12">
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example2" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>Nama Barang</th>
											<th>Satuan</th>
											<th>Extra</th>
											<th>Qty</th>
											
											
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_trx_t_podtl as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->stockname;?></td>
									<td><?php echo $row->packname;?></td>
									<td align="right"><?php echo $row->fn_extra;?></td>
									<td align="right"><?php echo $row->fn_qty;?></td>
									
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



<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>