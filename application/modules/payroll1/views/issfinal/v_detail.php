<?php 
/*
	@author : junis 10-12-2012\m/
	iss
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
            });
		

</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<?php echo '<h3>NIK : '.$nik.'<br>';?>
			<?php echo 'Nama : '.$nama.'</h3>';?>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="<?php echo site_url("payroll/issfinal_payroll/master/");?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
					<!--a href="<?php echo site_url("payroll/issfinal_payroll/excel_payroll_detail/$nik/$nodok")?>"  class="btn btn-default" style="margin:10px;">Download Excel</a-->
					<!--a href="<?php echo site_url("payroll/issfinal_payroll/download_pdf/$nik/$nodok")?>"  class="btn btn-danger" style="margin:10px;">Download PDF</a-->
				</div>
				
			</div>
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>								
							<th>Nama Komponen</th>
							<th>Keterangan</th>	
							<th>Nominal (Rp.)</th>								
							<th>Action</th>								
													
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_detail as $lu) {;?>
						<tr>										
							<td width="2%"><?php echo $lu->no_urut;?></td>																							
							<td><?php echo $lu->keterangan;?></td>
							<td><?php echo $lu->uraian;?></td>
							<td align="right"><?php echo $lu->nominal1;?></td>
							<td width="20">
							<?php if (trim($lu->no_urut)=='4' or trim($lu->no_urut)=='6' or trim($lu->no_urut)=='10' or trim($lu->no_urut)=='11') { ?>
								<a  <?php $nik=trim($lu->nik); $no_urut=trim($lu->no_urut); $nodok=trim($lu->nodok);?> data-url="<?php echo site_url("payroll/issfinal_payroll/detail_komponen/$nodok/$no_urut")?>" class="btn btn-success  btn-sm show"  data-toggle="modal" data-target=".pp">
									<i class="fa fa-cloud"></i> Detail
								</a>

							<?php } ?>	
							
							</td>
						</tr>
						<?php };?>
					</tbody>
					<tfoot>
						<tr>
							<td bgcolor="#88cc00" class="right" colspan="3">Total Upah:</td><td  bgcolor="#88cc00" align="right"><?php echo $total_upah;?></td> 
						</tr>
					</tfoot>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

<!--Modal Data Detail -->

    <div  class="modal fade pp">
                <!-- Content will be loaded here from "remote.php" file -->
    </div>

<!---End Modal Data --->






