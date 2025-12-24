<style type="text/css">
<!--
.style2 {font-size: 8px}
-->
</style>
<table width="100%" border="1" cellpadding="0" cellspacing="1">
 
  <tr>
    <td height="30" colspan="34"><div align="center"><strong>PT NUSANTARA BUILDING INDUSTRIES</strong></div></td>
  </tr>
  <tr>
  <td height="20" colspan="34"><span class="style2"></span></td>
  </tr>
    <tr>
    <td style="border: 0px;" colspan="34"><blockquote>
      <p>SLIP LEMBUR (PERIODE) : <?php echo $ta;?> S/D <?php echo $tk;?></p>
      <p>&nbsp;</p>
    </blockquote></td>
    
    
  </tr>
  <tr>
    <td width="10%" style="border: 0px;">NAMA:<span class="style2"> </span></td>
    <td colspan="20"><?php echo $lo['nmlengkap'];?></span></td>
    <td style="border: 0px;" colspan="13"><span class="style2"></span></td>
  </tr>
  <tr>
    <td style="border: 0px;" colspan="22">&nbsp;</td>
    <td width="8%" colspan="12" style="border: 0px;">&nbsp;</td>
  </tr>
  <tr>
    <td style="border: 0px;">NIK:</td>
    <td colspan="20"><?php echo $lo['nik'];?></span></td>
    <td width="20%" style="border: 0px;"><span class="style2"></span></td>
   </tr>
    
  <tr>
    <td style="border: 0px;" colspan="34">&nbsp;</td>
  </tr>
  <tr>
    <td style="border: 0px;">DEPARTMENT:</td>
    <td colspan="20"><?php echo $lo['nmdept'];?></span></td>
    <td style="border: 0px;" colspan="13"><span class="style2"></span></td>
  </tr>
  <tr>
    <td style="border: 0px;" colspan="22">&nbsp;</td>
   </tr> 
  <tr>
    <td style="border: 0px;">JABATAN:</td>
    <td colspan="20"><?php echo $lo['nmjabatan'];?></span></td>
    </tr>
   <tr>
    <td style="border: 0px;" colspan="22">&nbsp;</td>
   </tr> 
	</table>
<table width="100%" border="1" cellpadding="0" cellspacing="1">
					<tbody>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
							
							<th>Nomer Dokumen</th>																				
							<th>NIK</th>										
							<th>Nama Karyawan</th>							
							<th>Tanggal Kerja</th>
							<th>Jam Mulai(Mesin)</th>
							<th>Jam Selesai(Mesin)</th>
							<th>Durasi Waktu SPL</th>								
							<th>Durasi Waktu Absen</th>																		
							<th>Nominal</th>																		
						
						</tr>
					
						<?php $no=0; foreach($list_lembur as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nodok_ref;?></a></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->tgl_kerja1;?></td>
							<td><?php echo $lu->jam_mulai_absen;?></td>
							<td><?php echo $lu->jam_selesai_absen;?></td>
							<td><?php echo $lu->jam;?></td>
							<td><?php echo $lu->jam2;?></td>
							<td><?php echo $lu->nominal1;?></td>
						
						</tr>
						<?php endforeach;?>
					</tbody>
	
	</table>

