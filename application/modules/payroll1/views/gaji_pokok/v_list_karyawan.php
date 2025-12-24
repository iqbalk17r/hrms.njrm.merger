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
					<!--<a href="<?php echo site_url("payroll/cuti/karyawan/")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>-->	
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
							<th>Action</th>	
							<th>NIK</th>
							<th>Nama Karyawan</th>					
							<th>Department</th>					
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_karyawan as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td>
								<a href="<?php $nik=trim($lu->nik); echo site_url("payroll/gaji_pokok/index/$nik")?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail Gaji Pokok 
								</a>
								<!--<a data-toggle="modal" data-target="#<?php echo trim($lu->nik);?>" href="#" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail Tunjangan Shift 
								</a>-->
							</td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


</body>




