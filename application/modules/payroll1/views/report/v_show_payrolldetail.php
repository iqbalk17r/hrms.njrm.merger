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
					<a href="<?php echo site_url("payroll/report/excel_report_detail/$periode")?>"  class="btn btn-warning" style="margin:10px; color:#ffffff;">Download Excel</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>																	
							<th>Nik</th>																
							<th>Nama Karyawan</th>
							<th>Department/Bagian</th>
							<th>Rekening</th>
							<th>Gaji Pokok (Rp.)</th>
							<th>Tunjangan Jabatan (Rp.)</th>
							<th>Tunjangan Masa Kerja (Rp.)</th>
							<th>Tunjangan Prestasi (Rp.)</th>
							<th>Tunjangan Shift (Rp.)</th>
							<th>Lembur (Rp.)</th>
							<th>Upah Borong (Rp.)</th>
							<th>Insentif Produksi (Rp.)</th>
							<th>Bonus (Rp.)</th>
							<th>THR (Rp.)</th>
							<th>Koreksi Bulan Lalu (Rp.)</th>
							<th>JKK (Rp.)</th>
							<th>JKM (Rp.)</th>
							<th>Total Gaji Bruto (Rp.)</th>
							<th>JHT (Rp.)</th>
							<th>JP (Rp.)</th>
							<th>BPJS Kesehatan (Rp.)</th>
							<th>Potongan Absen (Rp.)</th>
							<th>Potongan ID Card (Rp.)</th>
							<th>Potongan Lain-lain (Rp.)</th>
							<th>PPH 21 (Rp.)</th>
							<th>THP (Rp.)</th>
																																																																																																																										
																																																																																																																											
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_payroll as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							<td><?php echo $lu->norek;?></td>
							<td><?php echo $lu->gajipokok;?></td>
							<td><?php echo $lu->tj_jabatan;?></td>
							<td><?php echo $lu->tj_masakerja;?></td>
							<td><?php echo $lu->tj_prestasi;?></td>
							<td><?php echo $lu->tj_shift;?></td>
							<td><?php echo $lu->lembur;?></td>
							<td><?php echo $lu->upah_borong;?></td>
							<td><?php echo $lu->insentif_produksi;?></td>
							<td><?php echo $lu->bonus;?></td>
							<td><?php echo $lu->thr;?></td>
							<td><?php echo $lu->koreksibulanlalu;?></td>
							<td><?php echo $lu->jkk;?></td>
							<td><?php echo $lu->jkm;?></td>
							<td><?php echo $lu->gajikotor;?></td>
							<td><?php echo $lu->jht;?></td>
							<td><?php echo $lu->jp;?></td>
							<td><?php echo $lu->bpjs;?></td>
							<td><?php echo $lu->ptg_absensi;?></td>
							<td><?php echo $lu->ptg_idcard;?></td>
							<td><?php echo $lu->ptg_lain;?></td>
							<td><?php echo $lu->pph21;?></td>
							<td><?php echo $lu->totalupah;?></td>
						
						
						</tr>
						<?php endforeach;?>
					</tbody>
				
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>







</body>



