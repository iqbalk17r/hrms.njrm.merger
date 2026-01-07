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
					"url": "<?php echo site_url('ga/inventaris/perawatanspk_pagin')?>",
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
			
function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

					
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>

<div class="row">
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li-->
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/inventaris/form_spk")?>">Input SPK</a></li>		
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
		<li class="active"><a href="#tab_1" data-toggle="tab"><h6>Note: Finalisasi Keseluruhan Perawatan Pada Detail SPK</h6></a></li>
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
						<table id="example2" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>NODOK</th>
											<th>NODOKREF</th>
											<th>NAMA ASSET</th>
											<th>NOPOL</th>
											<th>NAMA BENGKEL</th>
											<th>STATUS</th>
											<th width="8%">AKSI</th>	
										</tr>
							</thead>
                                    <tbody>
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


<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>