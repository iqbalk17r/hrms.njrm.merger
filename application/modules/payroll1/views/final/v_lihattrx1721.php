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


<body onLoad="noBack();" onpageshow="if (event.persisted) noBack();" onUnload="">
<legend><?php echo $title;?></legend>

<div class="row">
				<div class="col-sm-12">		
					<a href="<?php echo site_url("payroll/final_payroll/utama_view_p1721")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				</div>
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>KDDEPT</th>	
							<th>TOTAL PAJAK</th>
							<th>TOTAL PENDAPATAN</th>
							<th>TOTAL POTONGAN</th>					
							<th>GROUPPENGGAJIAN</th>					
							<!--th>ACTION</th-->					
												
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_trxrekap1721 as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td>
								<a href="<?php $kddept=trim($lu->kddept);$group_pg=trim($lu->grouppenggajian); echo site_url("payroll/final_payroll/detail_1721/$tahun/$kddept/$group_pg")?>">
									 <?php echo $lu->kddept; ?> 
								</a>
							 <!--?php echo $lu->kddept; ?--> 
							</td>
							<td><?php echo $lu->total_pajak;?></td>
							<td><?php echo $lu->total_pendapatan;?></td>
							<td><?php echo $lu->total_potongan;?></td>
							<td><?php echo $lu->grouppenggajian;?></td>
							<!--td><a href="<?php $kddept=trim($lu->kddept);$group_pg=trim($lu->grouppenggajian); echo site_url("payroll/final_payroll/final_1721/$tahun/$kddept/$group_pg")?>" onclick="return confirm('APAKAH ANDA YAKIN AKAN DILAKUKAN FINAL ...?')" class="btn btn-danger  btn-sm">
									<i class="fa fa-edit"></i> FINAL
								</a></td-->
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


</body>




