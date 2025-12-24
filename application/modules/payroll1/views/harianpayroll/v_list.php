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



<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">	
				<div class="col-sm-6">
				
				<a href="<?php echo site_url("payroll/harianpayroll/index/")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				<a href="<?php echo site_url("payroll/harianpayroll/excel_sumlemburdept/$tglawal/$tglakhir/$kddept/$nik")?>"  class="btn btn-default" style="margin:10px;">Export Excel</a>
				</div>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
																										
							<th>NIK</th>
							<th>Nama Lengkap</th>							
							<th>Total Nominal Lembur</th>																		
																								
							<!--<th>Action</th>-->						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_lembur as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><a <?php $nik=trim($lu->nik);?> href="<?php echo site_url("payroll/harianpayroll/lihat_lembur_dtl/$nik/$tglawal/$tglakhir/$kddept/$tptr");?>"> <?php echo trim($lu->nik);?></a></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nominal;?></td>
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>



