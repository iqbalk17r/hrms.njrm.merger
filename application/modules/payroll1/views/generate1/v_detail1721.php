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
					<a href="<?php echo site_url("payroll/generate/lihattmp_p1721/$tahun/$kddept/$nodoktemp/$kdgroup_pg")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
					<a href="<?php echo site_url("payroll/generate/hitung_ulangp1721/$tahun/$kddept/$nodoktemp/$kdgroup_pg")?>"  class="btn btn-warning" style="margin:10px; color:#ffffff;">Hitung Ulang</a>
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
							<th>NIK</th>	
							<th>NAMA LENGKAP</th>
							<th>DEPARTMENT</th>
							<th>GROUP PG</th>					
							<th>BULAN MULAI</th>					
							<th>BULAN AKHIR</th>					
							<th>GAJI POKOK</th>					
							<th>TJ PPH</th>					
							<th>TJ LAIN</th>					
							<th>HONORARIUM</th>					
							<th>PREMIASURANSI</th>					
							<th>NATUNA</th>					
							<th>PENDAPATAN_NONREG</th>					
							<th>SUBTOTAL_BRUTO</th>					
							<th>BIAYA_JABATAN</th>					
							<th>PENSIUN</th>					
							<th>TOTAL_POTONGAN</th>					
							<th>TOTAL NETTO</th>					
							<th>NETTO MASA SEBELUM</th>					
							<th>TOTAL NETTO PPH21</th>					
							<th>PTKP</th>					
							<th>PKP</th>					
							<th>PPH21SETAHUN</th>					
							<th>PPH21SETAHUN MASA SEBELUM</th>					
							<th>PPH21 TERUTANG</th>					
							<th>PPH21 DIPOTONG</th>					
							<th>NOMOR_PELAPORAN</th>					
												
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_tmprekap1721 as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>
							<td><a href="<?php $nike=trim($lu->nik); echo site_url("payroll/generate/edit_nik1721/$tahun/$nike/$kddept/$kdgroup_pg")?>"><?php echo $lu->nik; ?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->bag_dept;?></td>
							<td><?php echo $lu->grouppenggajian;?></td>
							<td><?php echo $lu->periode_mulai;?></td>
							<td><?php echo $lu->periode_akhir;?></td>
							<td><?php echo $lu->gaji_pokok;?></td>
							<td><?php echo $lu->tj_pph;?></td>
							<td><?php echo $lu->tj_lain;?></td>
							<td><?php echo $lu->honorarium;?></td>
							<td><?php echo $lu->premiasuransi;?></td>
							<td><?php echo $lu->natuna;?></td>
							<td><?php echo $lu->p_nonreg;?></td>
							<td><?php echo $lu->subtotal_bruto;?></td>
							<td><?php echo $lu->biaya_jabatan;?></td>
							<td><?php echo $lu->pensiun;?></td>
							<td><?php echo $lu->subtotal_potongan;?></td>
							<td><?php echo $lu->sub_netto;?></td>
							<td><?php echo $lu->netto_sebelumnya;?></td>
							<td><?php echo $lu->netto_untukpph21;?></td>
							<td><?php echo $lu->ptkp_setahun;?></td>
							<td><?php echo $lu->pkp_setahun;?></td>
							<td><?php echo $lu->pph21_setahun;?></td>
							<td><?php echo $lu->pph21_masa_sebelumnya;?></td>
							<td><?php echo $lu->pph21_terutang;?></td>
							<td><?php echo $lu->pph21_dipotong;?></td>
							<td><?php echo $lu->nomor_pelaporan;?></td>
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


</body>




