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
<script>
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<!--a href="<?php///echo site_url("payroll/final_payroll/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
					<!--a href="<?php///echo site_url("payroll/final_payroll/excel_report/$nodok")?>"  class="btn btn-default" style="margin:10px;">Export Excel</a>
					<!--a href="<?php///echo site_url("payroll/final_payroll/excel_report_detail/$nodok")?>"  class="btn btn-warning" style="margin:10px;">Detail Excel</a>
					<!--a href="<?php///echo site_url("payroll/final_payroll/edit_final/$nodok")?>"  onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-danger" style="margin:10px;">Edit</a--->
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<?php //echo '<h2>NIK : '.$nik.'<br>';?>
			<?php //echo 'Nama : '.$nama.'</h2>';?>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Nomer Dokumen</th>								
							<th>Nik</th>								
							<th>Nama Lengkap</th>								
							<th>Total Gaji (Rp.)</th>															
							<th>No. Rekening</th>															
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_master as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td align="right"><?php echo $lu->total_upah1;?></td>
							<td><?php echo $lu->norek;?></td>
							<td>
								<a href="<?php $nodok=trim($lu->nodok); $nik=trim($lu->nik); echo site_url("payroll/issfinal_payroll/detail/$nodok/$nik")?>" class="btn btn-primary  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>













