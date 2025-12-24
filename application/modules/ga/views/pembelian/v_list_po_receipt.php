<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				//$("#kdsubgroup").chained("#kdgroup");
				///$("#kdbarang").chained("#kdsubgroup");
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

<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>
<legend><?php echo $qtypo;?></legend>

<?php echo $message;?>

<div class="row">
	<div class="col-sm-1">	
	<a href="<?php echo site_url('ga/pembelian/inquiry_pembelian');?>" style="margin:10px; color:#000000;"  type="button" class="btn btn-default"/> Kembali</a>
	</div>
	<div class="col-sm-2">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input PO RECEIPT</a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/pembelian/input_po_receipt")?>">Input PO RECEIPT</a></li--->		
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
											<th>QTY RECEIPT</th>
											<th>QTY OUTSTANDING</th>
											<th>SATUAN</th>
											<th>STATUS</th>
											<th>KETERANGAN</th>
											<th width="8%">AKSI</th>	
										</tr>
							</thead>
						    <tbody>
									<?php $no=0; foreach($list_po_receipt as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodok;?></td>
									<td><?php echo $row->stockcode;?></td>
									<td><?php echo $row->nmbarang;?></td>
									<td><?php echo $row->desc_barang;?></td>
									<td align="right"><?php echo $row->qtyreceipt;?></td>
									<td align="right"><?php echo $row->qtysisa;?></td>
									<td><?php echo $row->qtyunit;?></td>
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
<!-- Modal Input Perawatan ASSET -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">RECEIPT PO BARANG ATK</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/pembelian/save_receipt_po');?>" method="post">
		<div class='row'>
			<div class='col-sm-12'>	
			 <div class="form-group">
				<label for="inputsm">Dokumen PO</label>
				<input type="text" class="form-control input-sm" id="nodokpo" style="text-transform:uppercase" name="nodokpo" placeholder="Nodok PO"  value="<?php echo trim($nodok);?>" readonly>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup" readonly disabled>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option <?php if (trim($sc->kdgroup)==trim($dtl_po['kdgroup'])) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm " name="kdsubgroup" id="kdsubgroup" readonly disabled>
					 <option  value="">---PILIH KODE SUB GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option  <?php if (trim($sc->kdsubgroup)==trim($dtl_po['kdsubgroup'])) { echo 'selected';}?> value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Pilih Barang</label>	
					<select class="form-control input-sm" name="kdbarang" id="kdbarang"  readonly disabled>
					 <option value="">---PILIH KODE BARANG--</option> 
					  <?php foreach($list_mstbarangatk as $sc){?>					  
					  <option  <?php if (trim($sc->nodok)==trim($dtl_po['stockcode'])) { echo 'selected';}?> value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>"  ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang);?></option>						  
					  <?php }?>
					</select>
			</div>
			 <div class="form-group">
				<label for="inputsm">RECEIPT</label>
				<input type="number" class="form-control input-sm" id="qtyreceipt" style="text-transform:uppercase" name="qtyreceipt" placeholder="QTY RECEIPT"  maxlength="12" required>
			</div>
			<div class="form-group">
				<label for="inputsm">KETERANGAN</label>
				<textarea  class="textarea" name="keterangan" placeholder="KETERANGAN"   maxlength ="159" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
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
<!-- -->


<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>