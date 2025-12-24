<?php 
/*
	@author : junis 10-12-2012\m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $(".grid").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
				
				
			//	$('.closepp1').on('click',function () {
			//		//alert('mbot');
			//		$('.modal.pp1').modal('hide');
			//		//$('.pp1').();
			//		
			//	});
			//
			//
			
            });
</script>



        <div class="modal-dialog modal-lg">
            <div class="modal-content">

			<div class="modal-header">
			<button type="button" class="close closepp1" aria-label="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>	
			<legend><?php echo $title;?></legend>
			<!--?php echo $message;?-->
			
			<!--h4 class="modal-title" id="myModalLabel">Transaksi Bulan</h4--->
			</div>
			<div class="modal-body">
			<div class="row">
				<div class="form-group">					
					<div class="col-sm-12">
						<table class="table table-bordered grid" >
							<thead>
								<tr>												
									<th align="justify">Kategori</th>									
									<th align="justify">Nama Produk</th>									
									<th align="justify">Document</th>								
									<th align="justify">Qty</th>								
													
								</tr>
							</thead>
							<tbody>
								<?php
									 /*Menampilkan data Temp Upload yang Ada yang ada
									 if(empty($list_outletdtl))
									 {
										echo "<tr><td colspan=\"9\">Data tidak tersedia</td></tr>";
									 } else
									 {*/
										foreach($list_outletdtl as $lodtl){
										if($lodtl->urut=='1') {
								?>
								
								<tr  style="background-color: #00ff00;">									
									<td><b><?php echo trim($lodtl->kdproduk);?></b></td>									
									<td><b><?php echo trim($lodtl->produk);?></b></td>	
									<td><b><?php echo trim($lodtl->kodetrans);?></b></td>	
									<td><b><?php echo trim($lodtl->qty);?></b></td>	
								</tr>
										<?php } else { ?>
								<tr  style="background-color: #5F9EA0;">									
									<td><b><?php echo trim($lodtl->kdproduk);?></b></td>									
									<td><b><?php echo trim($lodtl->produk);?></b></td>	
									<td><b><?php echo trim($lodtl->kodetrans);?></b></td>	
									<td><b><?php echo trim($lodtl->qty);?></b></td>	
								</tr>
										
										<?php }} ?>
							</tbody>                                        
						</table>
					</div>				
				</div>
			</div>
								
	</div>
        </div>
    </div>


