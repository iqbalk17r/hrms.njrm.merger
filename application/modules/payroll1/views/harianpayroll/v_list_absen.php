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


<body >
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<!--<a href="<?php echo site_url("trans/lembur/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
				
				<div class="col-sm-6">
				
				<a href="<?php echo site_url("payroll/harianpayroll/absen")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				<a href="<?php echo site_url("payroll/harianpayroll/excel_sum_absen/$tglawal/$tglakhir/$kddept")?>"  class="btn btn-default" style="margin:10px;">Export Excel</a>
				</div>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>																	
							<th>NIK</th>										
							<th>Nama Karyawan</th>																											
							<th>Nominal</th>																		
							
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_sum_absen as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><a <?php $nik=trim($lu->nik);?> href="<?php echo site_url("payroll/harianpayroll/lihat_absen_dtl/$nik/$tglawal/$tglakhir/$kddept");?>"> <?php echo trim($lu->nik);?></a></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->cuti_nominal;?></td>
							
					
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>



</body>



