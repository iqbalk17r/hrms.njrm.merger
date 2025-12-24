
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
					<a href="<?php echo site_url("payroll/tetap")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;"><i class="fa fa-edit"></i> Input </a>
					
					
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
		
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>NIK</th>														
							<th>Nama Lengkap</th>								
							<th>Gaji Pokok(Rp.)</th>	
							<th>Tunjangan Jabatan (Rp.)</th>								
							<th>Tunjangan Masa Kerja (Rp.)</th>								
							<th>Tunjangan Prestasi (Rp.)</th>								
							<th>Gaji Tetap (Rp.)</th>								
							<th>Gaji BPJS KES (Rp.)</th>								
							<th>Gaji BPJS NAKER (Rp.)</th>								
							<!--<th>Action</th>-->						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_gaji as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td align="right"><?php echo $lu->gajipokok;?></td>
							<td align="right"><?php echo $lu->tj_jabatan;?></td>
							<td align="right"><?php echo $lu->tj_masakerja;?></td>
							<td align="right"><?php echo $lu->tj_prestasi;?></td>
							<td align="right"><?php echo $lu->gajitetap;?></td>
							<td align="right"><?php echo $lu->gajibpjs;?></td>
							<td align="right"><?php echo $lu->gajinaker;?></td>
							<!--<td>
								<a href="#"  data-toggle="modal" data-target="#<?php echo trim($lu->kdrumus);?>"  class="btn btn-warning btn-sm">
									<i class="fa fa-edit"></i> Input Detail
								</a>
								<a href="<?php //$nik=trim($lu->nik); echo site_url("payroll/detail_payroll/detail/$nik/$kdgroup_pg/$kddept/$periode/$keluarkerja")?>" class="btn btn-primary  btn-sm">
									<i class="fa fa-edit"></i> Detail
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













