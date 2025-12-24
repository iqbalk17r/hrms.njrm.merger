<?php 
/*
	@author : junis 10-12-2012\m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
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
									<th>No. Dokumen</th>								
									<th>NIK</th>								
									<th>Tanggal Kerja</th>																
									<th>Shift</th>																
									<th>Nominal (Rp.)</th>								
														
								</tr>
							</thead>
							<?php $no=0; foreach($detail_shift as $lu) {;?>
						<tr>										
							<td><?php echo $lu->nodok;?></td>																							
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->tgl_kerja;?></td>
							<td><?php echo $lu->tpshift;?></td>
							<td align="right"><?php echo $lu->nominal1;?></td>
						</tr>
						<?php };?>                                 
						</table>
					</div>				
				</div>
			</div>
								
	</div>
        </div>
    </div>

