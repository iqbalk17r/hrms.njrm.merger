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
<?php //echo $message;?>
<div class="row">
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="<?php echo site_url("payroll/report/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<a href="<?php echo site_url("payroll/report/excel_pph_detail/$nik")?>"  class="btn btn-warning" style="margin:10px; color:#ffffff;">Download Excel</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>																	
							<th>Keterangan</th>																
							<th>Januari</th>
							<th>Februari</th>
							<th>Maret</th>
							<th>April</th>
							<th>Mei</th>
							<th>Juni</th>
							<th>Juli</th>
							<th>Agustus</th>
							<th>September</th>
							<th>Oktober</th>
							<th>November</th>
							<th>Desember</th>
																																																																																																																										
																																																																																																																											
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_payroll as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->keterangan;?></td>
							<td><?php echo $lu->januari;?></td>
							<td><?php echo $lu->februari;?></td>
							<td><?php echo $lu->maret;?></td>
							<td><?php echo $lu->april;?></td>
							<td><?php echo $lu->mei;?></td>
							<td><?php echo $lu->juni;?></td>
							<td><?php echo $lu->juli;?></td>
							<td><?php echo $lu->agustus;?></td>
							<td><?php echo $lu->september;?></td>
							<td><?php echo $lu->oktober;?></td>
							<td><?php echo $lu->november;?></td>
							<td><?php echo $lu->desember;?></td>
						
						
						</tr>
						<?php endforeach;?>
					</tbody>
				
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>







</body>



