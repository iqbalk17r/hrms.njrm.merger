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

            });
					
			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
<?php echo $message; ?>	

<br class="row">
    <div class="col-xs-12">
    <a href="<?php echo site_url('ga/inventaris/inquiry_stock');?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> KEMBALI</a>
    </div>
</br>
</br>
</br>
	<div class="col-xs-12">
		<!--a href="<?php echo site_url('ga/inventaris/inquiry_stock');?>" class="btn btn-default  btn-sm"> KEMBALI !---->
		<div class="box">
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
								<tr>											
									<th width="2%">No.</th>
									<th>KODE BARANG</th>
									<th>NAMA BARANG</th>
									<th>GUDANG WILAYAH</th>
									<th>TRXDATE</th>
									<th>DOCTYPE</th>
									<th>DOCNO</th>
									<th>DOCREF</th>
									<th>QTY IN</th>
									<th>QTY OUT</th>
									<th>SALDO</th>
								

								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_stgblco as $row): $no++;?>
						<tr>
							
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo $row->stockcode;?></td>
							<td><?php echo $row->nmbarang;?></td>
							<td><?php echo $row->locaname;?></td>
							<td><?php echo $row->trxdate;?></td>
							<td><?php echo $row->doctype;?></td>
							<td><?php echo $row->docno;?></td>
							<td><?php echo $row->docref;?></td>
							<td><?php echo $row->qty_in;?></td>
							<td><?php echo $row->qty_out;?></td>
							<td><?php echo $row->qty_sld;?></td>
	
						</tr>
						<?php endforeach;?>	
							</tbody>		
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>

<!-- Modal Input Master Mapping ATK -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Input Master Satuan</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_master_satuan_brg');?>" method="post">
		<div class='row'>
			<div class='col-sm-12'>	
			 	<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			<div class="form-group">
				<label for="inputsm">KODE SATUAN BARANG</label>	
				<input type="text" class="form-control input-sm" id="kdtrx" name="kdtrx" required>
			</div>
			<div class="form-group">
				<label for="inputsm">DESKRIPSI SATUAN</label>
				<textarea  class="textarea" name="uraian" placeholder="Deskripsi Satuan Barang"   maxlength ="100" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
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
    	$(".tgl").datepicker(); 
    	$(".tglan").datepicker(); 
				$('.year').datepicker({
					format: " yyyy",
					viewMode: "years", 
					minViewMode: "years"
				
				});
  

</script>