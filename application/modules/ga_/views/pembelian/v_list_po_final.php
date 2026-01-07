<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				$("#kdsubgroup").chained("#kdgroup");
				$("#kdbarang").chained("#kdsubgroup");
/*						if 	($('#kdbarang').val() != '') {						
							var param1=$('#kdbarang').val();
							  $.ajax({
								url : "<?php echo site_url('ga/permintaan/js_viewstock')?>/" + param1,
								type: "GET",
								dataType: "JSON",
								success: function(data)
								{			   
									$('[name="onhand"]').val(data.conhand);                        
									$('[name="loccode"]').val(data.loccode);                                                          
						
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							}); 
						};	
			////	$("#onhand").chained("#kdbarang");
			//alert ($('#kdsubgroup').val() != '');
					$('.kdbarang').change(function(){
						console.log($('#kdbarang').val() != '');
						if 	($('#kdbarang').val() != '') {						
							var param1=$(this).val();
							  $.ajax({
								url : "<?php echo site_url('ga/permintaan/js_viewstock')?>/" + param1,
								type: "GET",
								dataType: "JSON",
								success: function(data)
								{			   
									$('[name="onhand"]').val(data.conhand);                        
									$('[name="loccode"]').val(data.loccode);                                                          
						
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							}); 
						};				
					});*/
								//////////////////////////////////////////////
					$('#qtyunitprice').change(function(){
						if ($(this).val()=='') {	var param1 = parseInt(0); } else { var param1 = parseInt($(this).val()); }
						if ($('#qtypo').val()=='') {	var param2 = parseInt(0); } else { var param2 = parseInt($('#qtypo').val()); }
						
						$('#qtytotalprice').val(param1 * param2);   
					});
					//////////////////////////////////////////////
					$('#qtypo').change(function(){
						if ($(this).val()=='') {	var param2 = parseInt(0); } else { var param2 = parseInt($(this).val()); }
						if ($('#qtyunitprice').val()=='') {	var param1 = parseInt(0); } else { var param1 = parseInt($('#qtyunitprice').val()); }
						
						$('#qtytotalprice').val(param1 * param2);      
					});
            });
			
					
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>

<div class="row">
	<div class="col-sm-1">	
	<a href="<?php echo site_url('ga/pembelian/inquiry_pembelian');?>" style="margin:10px; color:#000000;"  type="button" class="btn btn-default"/> Kembali</a>
	</div>
	<?php /*
	<div class="col-sm-2">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/pembelian/input_po")?>">Input PO</a></li>		
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->*/ ?>
</div>	
</br>
<div class="row">
<div class="col-sm-12">
	<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">					
		<li class="active"><a href="#tab_1" data-toggle="tab">LIST PURCHASE ORDER</a></li>
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
											<th width="2%">No.</th>
											<th>NODOK</th>
											<th>KODE BARANG</th>
											<th>NAMA BARANG</th>
											<th>DESC BARANG</th>
											<th>QTY PO</th>
											<th>QTY RECEIPT</th>
											<th>QTY OUTSTANDING</th>
											<th>SATUAN</th>
											<th>SATUAN HARGA</th>
											<th>TOTAL</th>
											<th>STATUS</th>
											<th>KETERANGAN</th>
											<th width="8%">AKSI</th>	
										</tr>
							</thead>
						    <tbody>
									<?php $no=0; foreach($list_po as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodok;?></td>
									<td><?php echo $row->stockcode;?></td>
									<td><?php echo $row->nmbarang;?></td>
									<td><?php echo $row->desc_barang;?></td>
									<td align="right"><?php echo $row->qtypo;?></td>
									<td align="right"><?php echo $row->qtyreceipt;?></td>
									<td align="right"><?php echo $row->qtysisa;?></td>
									<td><?php echo $row->qtyunit;?></td>
									<td align="right"><?php echo $row->qtyunitprice;?></td>
									<td align="right"><?php echo $row->qtytotalprice;?></td>
									<td><?php echo $row->status;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td width="15%">
									
										<a class="btn btn-sm btn-default" href="<?php 
										$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
										echo site_url('ga/pembelian/po_receipt').'/'.$enc_nodok; ?>" title="PO RECEIPT"><i class="glyphicon glyphicon-pencil"></i> RECEIPT </a>
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
<!--Modal Data Detail -->
    <div  class="modal fade pp">
                <!-- Content will be loaded here from "remote.php" file -->
    </div>
<!---End Modal Data --->
<input type="hidden" id="tgl1" name="tgl1" value="<?php echo $tgl1;?>">
<input type="hidden" id="tgl2" name="tgl2" value="<?php echo $tgl2;?>">
<input type="hidden" id="loccode" name="loccode" value="<?php echo $kdcabang;?>">

<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>