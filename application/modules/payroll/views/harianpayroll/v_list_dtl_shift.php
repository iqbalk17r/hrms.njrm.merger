<?php 
/*
	@author : Junis
*/
?>

<legend><?php echo $title;?></legend>
<h3><?php echo ' Total Tunjangan Shift = Rp. '.$total_nominal;?></h3>
<div id="message" >	
</div>
<div><?php //echo 'Total data: '.$ttldata['jumlah']; ?></div>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="<?php echo site_url('payroll/harianpayroll/shift');?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
					<a href="<?php echo site_url("payroll/harianpayroll/excel_dtlshift/$tglawal/$tglakhir/$kddept/$nik")?>"  class="btn btn-default" style="margin:10px;">Export Excel</a>
					<!--a href="#" data-toggle="modal" data-target="#input" class="btn btn-success" style="margin:10px; color:#ffffff;">INPUT</a-->
					<!--<button class="btn btn-primary" onclick="add_person()" style="margin:10px; color:#ffffff;"><i class="glyphicon glyphicon-plus"></i> Data Mesin Absen</button>-->
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>							
																
							<th width="5%">No.</th>
							<th>NIK</th>
							<th>Nama</th>
							<th>Tanggal Kerja</th>
							<th>Shift</th>
							<th>Jam Masuk</th>
							<th>Jam Pulang</th>
							<th>Nominal</th>
							
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach ($list_shift as $la): $no++ ?>
							<tr>																					
								<td><?php echo $no;?></td>																
								<td><?php echo $la->nik;?></td>	
								<td><?php echo $la->nmlengkap;?></td>																
								<td><?php echo $la->tgl_kerja;?></td>								
								<td><?php echo $la->tpshift;?></td>								
								<td><?php echo $la->jam_mulai_absen;?></td>	
								<td><?php echo $la->jam_selesai_absen;?></td>	
								<td><?php echo $la->nominal1;?></td>	
							</tr>
						<?php endforeach ?>
					</tbody>
					
						
					
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

  
 
 <script>

  

	
	//Date range picker
    $('#tgl').datepicker();
	$('#pilihkaryawan').selectize();
	$("[data-mask]").inputmask();

</script>