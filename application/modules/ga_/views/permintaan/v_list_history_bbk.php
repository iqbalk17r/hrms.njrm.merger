<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				$("#kdsubgroup").chained("#kdgroup");
				$("#kdbarang").chained("#kdsubgroup");
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
					});
				$('.drst').show();
				$('#daristock').on('click', function() {
					if ($(this).val()=='YES') {
						console.log($(this).val());
						$('.drst').prop('required',true);
						$('.drst').show();
					} else if ($(this).val()=='NO') {
						console.log($(this).val());
						$('.drst').prop('required',false);
						$('.drst').hide();
					}
				});
			
            });
					
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>
<!--?php echo $message;?--->

<div class="row">
		<div class="col-sm-12">		
			<a href="<?php echo site_url("ga/permintaan/filter_history_bbk")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
		</div>
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
									<th>NO REF</th>
									<th>TGL DOK</th>
									<th>NAMA BARANG</th>
									<th>NAMA USER</th>
									<th>DOC TYPE</th>
									<th>STATUS</th>
									<th>QTY</th>
									<th>KETERANGAN</th>	
								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_dtlbbk as $row): $no++;?>
						<tr>	
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo $row->nodok;?></td>
							<td><?php echo $row->nodokref;?></td>
							<td><?php echo date('d-m-Y', strtotime(trim($row->nodokdate)));?></td>
							<td><?php echo $row->nmbarang;?></td>
							<td><?php echo $row->nmlengkap;?></td>
							<td><?php echo $row->nodoktype;?></td>
							<td><?php echo $row->nmstatus;?></td>
							<td><?php echo $row->qtybbk;?></td>
							<td><?php echo $row->keterangan;?></td>

						</tr>
						<?php endforeach;?>	
							</tbody>		
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>

<!-- Modal Input Skema Barang -->


<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>