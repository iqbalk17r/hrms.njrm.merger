<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$(".tgl").datepicker();                               
				$(".clock").clockpicker({
					autoclose: true
				});
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
				//$("#kdsubgroup").chained("#kdgroup");
				//$("#kdbarang").chained("#kdsubgroup");
			////	$("#onhand").chained("#kdbarang");
			//alert ($('#kdsubgroup').val() != '');
					$('.ch').change(function(){
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
									$('[name="satkecil"]').val(data.satkecil);                                                          
									$('[name="satminta"]').val(data.satkecil);                                                          
									$('[name="nmsatkecil"]').val(data.nmsatkecil);                                                          
									$('[name="nmsatminta"]').val(data.nmsatkecil);                                                          
									$('[name="desc_barang"]').val(data.nmbarang);                                                          
						
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							}); 
						};				
					});
				$('.drst').hide();
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
				$('#daristockED').on('click', function() {
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
				$('form').on('focus', 'input[type=number]', function (e) {
					  $(this).on('mousewheel.disableScroll', function (e) {
						e.preventDefault()
					  })
				})		
					
			});
</script>
<style>
.selectize-input {
    overflow: visible;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}
.selectize-input.dropdown-active {
    min-height: 30px;
    line-height: normal;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}
.selectize-dropdown, .selectize-input, .selectize-input input {
    min-height: 30px;
    line-height: normal;
}
.loading .selectize-dropdown-content:after {
    content: 'loading...';
    height: 30px;
    display: block;
    text-align: center;
}
</style>
<legend><?php echo $title;?></legend>
<h5><b><strong><?php echo '  DETAIL DATA PLAN DO CHECK ACTION (PDCA)';?></strong></b></h5>
<!--?php echo $message;?--->

<div class="row">							
		<div class="col-sm-12">		
			<a href="<?php echo site_url("pdca/pdca/form_pdca")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
			
		</div>
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header"  align="center">
					<h5><b><strong><?php echo 'MASTER PLAN DO CHECK ACTION (PDCA)';?></strong></b></h5>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>TANGGAL</th>
											<th>NAMA</th>
											<th>IDBU</th>
											<th>PLAN</th>
											<th>QTY/TIME</th>
											<th>DO</th>
											<th>%</th>
											<th>REMARK</th>
											
											<th>OLD_IDBU</th>
											<th>OLD_PLAN</th>
											<th>OLD_QTY/TIME</th>
											<th>OLD_DO</th>
											<th>OLD_%</th>
											<th>OLD_REMARK</th>
											
											<th>PENGUBAH</th>
											<th>TGL UBAH</th>
											<th>AKSI</th>		
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_pdca_log_dtl_activity as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php if (!empty($row->docdate)) { echo date('d-m-Y', strtotime(trim($row->docdate))); } else { echo '';} ;?></td>
									<td><?php echo trim($row->nmlengkap);?></td>
									<td><?php echo trim($row->idbu);?></td>
									<td><?php echo trim($row->descplan);?></td>
									<td><?php echo trim($row->qtytime);?></td>
									<td><?php echo trim($row->do_c);?></td>
									<td align="right"><?php echo trim($row->percentage);?></td>
									<td><?php echo trim($row->remark);?></td>
									
									<td><?php echo trim($row->old_idbu);?></td>
									<td><?php echo trim($row->old_descplan);?></td>
									<td><?php echo trim($row->old_qtytime);?></td>
									<td><?php echo trim($row->old_do_c);?></td>
									<td align="right"><?php echo trim($row->old_percentage);?></td>
									<td><?php echo trim($row->old_remark);?></td>
									
									<td><?php echo trim($row->nmubah);?></td>
									<td><?php echo trim($row->updatedate);?></td>

									<td width="15%">
									<?php if (trim($row->status)=='A') { ?>
									<a href="#" data-toggle="modal" data-target="#REJECT_APPROV_DTL<?php echo str_replace('.','',trim($row->docno)).trim($row->nomor);?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> REJECT</a>	
									<?php } else if (trim($row->status)=='C') { ?>
									<a href="#" data-toggle="modal" data-target="#RESET_APPROV_DTL<?php echo str_replace('.','',trim($row->docno)).trim($row->nomor);?>" class="btn btn-warning  btn-sm"><i class="fa fa-edit"></i> RESET</a>	
									<?php } ?>
									<a href="#" data-toggle="modal" data-target="#DETAIL_DTL<?php echo str_replace('.','',trim($row->docno)).trim($row->nomor);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>	
								
								
									</td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>			
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div><!-- END ROW 1 --->
		</div>
</div>	

	  