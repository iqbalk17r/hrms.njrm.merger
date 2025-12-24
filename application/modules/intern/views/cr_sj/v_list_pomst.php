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
					"url": "<?php echo site_url('intern/cr_sj/cr_sj_pomst_pagination')?>",
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
			  			$modal = $('.pp');
					    $('#example2').on('click', '.show', function () {
								//var data = $('#example1').DataTable().row( this ).data();
								//alert( 'You clicked on '+data[0]+'\'s row' );
								var el = $(this);
								//alert(el.attr('data-url'));
								$modal.load(el.attr('data-url'), '', function(){
								$modal.modal();
							
							
							} );
						} );
			  
			  
			  
			  
				$("#example3").dataTable();
				$("#example4").dataTable();
				$("#kdsubgroup").chained("#kdgroup");
				$("#kdbarang").chained("#kdsubgroup");
});
					
</script>
<!--div class="pull-right">Versi: <?php echo $version; ?></div--->
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>
<?php /*
<div class="row">
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#ChoiceOfLetter"  href="#">Input Data Pengiriman</a></a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("intern/cr_sj/i_cr_sj")?>">Input Data Pengiriman</a></li--->		
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
</div>	
</br>
*/ ?>
<div class="row">
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
											<th>NO DOKUMEN</th>
											<th>TGL DOKUMEN</th>
											<th>STATUS</th>
											<th>SUPPLIER</th>
											<th>TYPE</th>
											<th width="8%">AKSI</th>	
										</tr>
							</thead>
							<tbody>
								<?php /*	<?php $no=0; foreach($list_inmst as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->FC_TRXNO;?></td>
									<td><?php if (empty($row->FD_ENTRYDATE)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->FD_ENTRYDATE))); }?></td>
									<td width="15%">													
											<a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->FC_TRXNO);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>
				
									</td>
								</tr>
								<?php endforeach;?>	*/ ?>
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
		<h4 class="modal-title" id="myModalLabel"> PILIH DOKUMEN LOAD </h4>
	  </div>
<form action="<?php echo site_url('intern/cr_sj/chose_option_cr_sj')?>" method="post" name="inputform">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">PILIH TYPE LOAD</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm " name="inputfill" required>
									 <option value="PO"> PEMBELIAN LANGSUNG KIRIM</option> 
									 <!--option value="TRG"> TRANSFER GUDANG </option--> 
									 <!--option value="AJS"> AJUSTMENT IN</option---> 
									</select>
									</div>
									<input type="hidden" name="rr" id="rr" value="#" class="form-control "  >
									
									<!--select class="form-control input-sm "  readonly disabled>
									 <option value="">---PILIH KODE GROUP--</option> 
									  <?php foreach($list_scgroup as $sc){?>					  
									  <option  <?php if (trim($sc->kdgroup)==trim($lb->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
									  <?php }?>
									</select--->
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





<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>