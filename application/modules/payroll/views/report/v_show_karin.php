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
					<a href="<?php echo site_url("payroll/report/excel_karin/$periode")?>"  class="btn btn-warning" style="margin:10px; color:#ffffff;">Download Excel</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>																	
							<th>NIK</th>										
							<th>Nama Karyawan</th>							
							<th>Department/Bagian</th>
							<th>Tanggal Masuk Kerja</th>																																																																																																																							
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_karin as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							<td><?php echo $lu->tglmasukkerja;?></td>
								
							
						</tr>
						<?php endforeach;?>
					</tbody>
					<tfoot>
						<tr>
						<td class="right" colspan="4">Jumlah Karyawan:</td><td class="right"><?php echo $jumlah;?></td>
						
						</tr>
					</tfoot>	
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>







</body>



