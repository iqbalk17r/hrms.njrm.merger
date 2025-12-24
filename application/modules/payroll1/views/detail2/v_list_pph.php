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
					<!--<a href="<?php echo site_url("payroll/detail_payroll/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>-->
					<a href="<?php echo site_url("payroll/detail_payroll/excel_pph/$nodok")?>"  class="btn btn-default" style="margin:10px;">Export Excel</a>
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
							<th>Total Pajak (Rp.)</th>	
							<th>Total Pendapatan (Rp.)</th>								
							<th>Total Potongan (Rp.)</th>								
							<th>Gaji Netto (Rp.)</th>								
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
							<td align="right"><?php echo $lu->total_pajak1;?></td>
							<td align="right"><?php echo $lu->total_pendapatan1;?></td>
							<td align="right"><?php echo $lu->total_potongan1;?></td>
							<td align="right"><?php echo $lu->gaji_netto1;?></td>
							<td>
								<!--<a href="#"  data-toggle="modal" data-target="#<?php echo trim($lu->kdrumus);?>"  class="btn btn-warning btn-sm">
									<i class="fa fa-edit"></i> Input Detail
								</a>-->
								<a href="<?php $nik=trim($lu->nik); echo site_url("payroll/detail_payroll/detail_pph/$lu->nik")?>" class="btn btn-primary  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>
								<!--<a  href="<?php $nik=trim($lu->kdrumus); echo site_url("master/formula/hps_formula/$lu->kdrumus")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
								
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<!--<a href="<?php echo site_url("payroll/detail_payroll/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>-->
					
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<?php echo '<h2><center>TOTAL REKAP PPH 21</center></h2>';?>
			<?php //echo 'Nama : '.$nama.'</h2>';?>
				<table id="example3" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>								
							<th>Nomer Dokumen</th>								
							<th>Total Pajak</th>								
							<th>Total Pendapatan</th>								
							<th>Total Potongan</th>								
							<!--<th>Action</th>	-->					
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_rekap as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->total_pajak1;?></td>
							<td><?php echo $lu->total_pendapatan1;?></td>
							<td><?php echo $lu->total_potongan1;?></td>
							<!--<td>
								<!--<a href="#"  data-toggle="modal" data-target="#<?php echo trim($lu->kdrumus);?>"  class="btn btn-warning btn-sm">
									<i class="fa fa-edit"></i> Input Detail
								</a>
								<a href="<?php echo site_url("payroll/detail_payroll/final_payroll/$lu->nodok")?>" onclick="return confirm('Anda Yakin Final Data ini?')" class="btn btn-warning  btn-sm">
									<i class="fa fa-edit"></i> FINAL
								</a>
								<!--<a  href="<?php $nik=trim($lu->kdrumus); echo site_url("master/formula/hps_formula/$lu->kdrumus")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>
								
							</td>-->
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>











