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
					<a href="<?php echo site_url("payroll/report/excel_pphdetailbulanan/$bulan")?>"  class="btn btn-warning" style="margin:10px; color:#ffffff;">Download Excel</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>																	
							<th>NIK</th>																
							<th>NAMA</th>
							<th>GAJI POKOK</th>
							<th>TUNJANGAN JABATAN</th>
							<th>TUNJANGAN MASA KERJA</th>
							<th>TUNJANGAN PRESTASI</th>
							<th>TUNJANGAN SHIFT</th>
							<th>TUNJANGAN LAIN-LAIN</th>
							<th>UPAH BORONG PROGRESIF</th>
							<th>LEMBUR</th>
							<th>PENGOBATAN</th>
							<th>JKK</th>
							<th>JKM</th>
							<th>BPJS KESEHATAN - PERUSAHAAN</th>
							<th>SUBTOTAL PENGHASILAN REGULAR</th>
							<th>PENGHASILAN NON REGULAR</th>
							<th>SUBTOTAL PENGHASILAN BRUTO</th>
							<th>BIAYA JABATAN</th>
							<th>JHT - KARYAWAN</th>
							<th>JP - KARYAWAN</th>
							<th>SUBTOTAL POTONGAN</th>
							<th>TOTAL PENGHASILAN NETTO</th>
							<th>PENGHASILAN REGULAR S/D BULAN BERJALAN</th>
							<th>PROYEKSI SISA PENGHASILAN REGULAR TAHUN BERJALAN</th>
							<th>TOTAL PERKIRAAN PENGHASILAN REGULAR DISETAHUNKAN</th>
							<th>PENGHASILAN NON REGULAR S/D BULAN BERJALAN</th>
							<th>TOTAL PERKIRAAN PENGHASILAN BRUTO DISETAHUNKAN</th>
							<th>BIAYA JABATAN (DARI PENGHASILAN YANG DISETAHUNKAN)</th>
							<th>POTONGAN JHT S/D BULAN BERJALAN</th>
							<th>PROYEKSI SISA POTONGAN JHT S/D AKHIR TAHUN</th>
							<th>POTONGAN JP S/D BULAN BERJALAN</th>
							<th>PROYEKSI SISA POTONGAN JP S/D AKHIR TAHUN</th>
							<th>TOTAL POTONGAN DISETAHUNKAN</th>
							<th>TOTAL PENGHASILAN NETTO (DISETAHUNKAN)</th>
							<th>PTKP</th>
							<th>PKP DISETAHUNKAN</th>
							<th>PERHITUNGAN PPH 21 (SETAHUN)</th>
							<th>BIAYA JABATAN (REGULER)</th>
							<th>POTONGAN JHT REGULER</th>
							<th>PROYEKSI SISA POTONGAN JHT REGULER</th>
							<th>POTONGAN JP REGULER</th>
							<th>PROYEKSI SISA POTONGAN JP REGULER</th>
							<th>TOTAL POTONGAN DISETAHUNKAN(REGULER)</th>
							<th>TOTAL PENGHASILAN NETTO (DISETAHUNKAN) REGULER</th>
							<th>PTKP REGULER</th>
							<th>PKP DISETAHUNKAN REGULER</th>
							<th>PERHITUNGAN PPH 21 (SETAHUN) REGULER</th>
							<th>RATIO PENGHASILAN BRUTO BULAN BERJALAN</th>
							<th>RATIO PENGHASILAN BRUTO BULAN S/D BULAN BERJALAN</th>
							<th>PPH 21 BULAN BERJALAN</th>
							<th>PPH 21 S/D BULAN BERJALAN</th>
							<th>SELISIH</th>
							<th>PPH 21 BULAN BERJALAN (BELUM NORMALISASI)</th>
							<th>PPH 21 KURANG DIBAYAR S/D BULAN BERJALAN</th>
							<th>SELISIH (2-1)</th>
							<th>SISA BULAN AMORTISASI</th>
							<th>AMORTISASI BULAN BERJALAN</th>
							<th>PPH 21 BULAN BERJALAN DINORMALISASI</th>
							<th>PPH 21 PENGHASILAN DISETAHUNKAN (ALL)</th>
							<th>PPH 21 PENGHASILAN DISETAHUNKAN (REGULER)</th>
							<th>PPH 21 PENGHASILAN DISETAHUNKAN (NON REGULER)</th>
							<th>PPH 21 PENGHASILAN NON REGULAR BULAN BERJALAN</th>
							<th>PPH 21 PENGHASILAN REGULAR</th>
							<th>PPH 21 PENGHASILAN NON REGULAR</th>
							<th>TOTAL PPH 21</th>
																																																																																																																										
																																																																																																																											
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_payroll as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nama;?></td>
							<td><?php echo $lu->k01;?></td>
							<td><?php echo $lu->k02;?></td>
							<td><?php echo $lu->k03;?></td>
							<td><?php echo $lu->k04;?></td>
							<td><?php echo $lu->k05;?></td>
							<td><?php echo $lu->k06;?></td>
							<td><?php echo $lu->k07;?></td>
							<td><?php echo $lu->k08;?></td>
							<td><?php echo $lu->k09;?></td>
							<td><?php echo $lu->k10;?></td>
							<td><?php echo $lu->k11;?></td>
							<td><?php echo $lu->k12;?></td>
							<td><?php echo $lu->k13;?></td>
							<td><?php echo $lu->k14;?></td>
							<td><?php echo $lu->k15;?></td>
							<td><?php echo $lu->k16;?></td>
							<td><?php echo $lu->k17;?></td>
							<td><?php echo $lu->k18;?></td>
							<td><?php echo $lu->k19;?></td>
							<td><?php echo $lu->k20;?></td>
							<td><?php echo $lu->k21;?></td>
							<td><?php echo $lu->k22;?></td>
							<td><?php echo $lu->k23;?></td>
							<td><?php echo $lu->k24;?></td>
							<td><?php echo $lu->k25;?></td>
							<td><?php echo $lu->k26;?></td>
							<td><?php echo $lu->k27;?></td>
							<td><?php echo $lu->k28;?></td>
							<td><?php echo $lu->k29;?></td>
							<td><?php echo $lu->k30;?></td>
							<td><?php echo $lu->k31;?></td>
							<td><?php echo $lu->k32;?></td>
							<td><?php echo $lu->k33;?></td>
							<td><?php echo $lu->k34;?></td>
							<td><?php echo $lu->k35;?></td>
							<td><?php echo $lu->k36;?></td>
							<td><?php echo $lu->k37;?></td>
							<td><?php echo $lu->k38;?></td>
							<td><?php echo $lu->k39;?></td>
							<td><?php echo $lu->k40;?></td>
							<td><?php echo $lu->k41;?></td>
							<td><?php echo $lu->k42;?></td>
							<td><?php echo $lu->k43;?></td>
							<td><?php echo $lu->k44;?></td>
							<td><?php echo $lu->k45;?></td>
							<td><?php echo $lu->k46;?></td>
							<td><?php echo $lu->k47;?></td>
							<td><?php echo $lu->k48;?></td>
							<td><?php echo $lu->k49;?></td>
							<td><?php echo $lu->k50;?></td>
							<td><?php echo $lu->k51;?></td>
							<td><?php echo $lu->k52;?></td>
							<td><?php echo $lu->k53;?></td>
							<td><?php echo $lu->k54;?></td>
							<td><?php echo $lu->k55;?></td>
							<td><?php echo $lu->k56;?></td>
							<td><?php echo $lu->k57;?></td>
							<td><?php echo $lu->k58;?></td>
							<td><?php echo $lu->k59;?></td>
							<td><?php echo $lu->k60;?></td>
							<td><?php echo $lu->k61;?></td>
							<td><?php echo $lu->k62;?></td>
							<td><?php echo $lu->k63;?></td>
						
						
						</tr>
						<?php endforeach;?>
					</tbody>
				
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>







</body>



