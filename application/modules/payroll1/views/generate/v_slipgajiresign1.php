

<!-- <tr>
	<td style="border: 0px;"  align="right" colspan="34"><span class="style2"><strong><h2 style="font-weight:big;">PT.    NUSANTARA BUILDING INDUSTRIES</h2></strong></span></td>
</tr>-->

<?php foreach ($detail as $dt){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="1">									
			 
			 <tr>
				<td style="border: 0px;"  align="center" colspan="34"><span class="style2"><strong><h2 style="font-weight:big;">PT.    NUSANTARA BUILDING INDUSTRIES</h2></strong></span></td>
			</tr>
				<tr>
			<td>________________________________________________________________________________</td>
			</tr>	
			<tr>
			<td ><label class="col-sm-4">NIK : <?php echo $dt->nik; ?></label>	</td>
			</tr>
			<tr>
	
			<td><label class="col-sm-4">Nama Lengkap : <?php echo $dt->nmlengkap; ?> </label></td>	
			<td></td>
			</tr>
			<tr>
			<td><label class="col-sm-4">Bagian : <?php echo $dt->nmdept; ?>  </label></td>	
			<td></td>
			</tr>
			
			<tr>
			<td><label class="col-sm-4">Masa Kerja : <?php $kta_awal = array('years','year','mons','mon','days','day');
									$kta_akhir = array('tahun','tahun','bulan','bulan','hari','hari');
									$pesan= str_replace($kta_awal,$kta_akhir,$dt->lama_bekerja);
									echo $pesan; ?></label></td>	
			<td></td>
			</tr>
			
			<tr>
			<td><label class="col-sm-4">Gaji Tetap : <?php echo 'Rp.'.$dt->gajitetap; ?> </label></td>	
			<td></td>
			</tr>
			<tr>
			<td>================================================================================</td>
			
			</tr>
			<tr>
			<td><label class="col-sm-4">Penggantian Hak Pesangon + Masa Kerja : Rp. <?php echo $dt->tj_penggantianhak;?></label></td>	
			<td></td>
			</tr>
			
			<tr>	
			<td><label class="col-sm-4">Sisa Cuti : Rp.  <?php echo $dt->tj_cuti;?></label></td>
			<td> </td>
			</tr>	
			
			<tr>	
		
			<td><label class="col-sm-4">Gaji Bulan Ini : Rp. <?php echo $dt->tj_absen;?></label></td>
			<td> </td>
			</tr>
				
			<tr>
			<td><label class="col-sm-4">Lain-lain : Rp. <?php echo $dt->tj_lain;?></label></td>	
			<td></td>
			</tr>
				
		
			<tr>
			<td><label class="col-sm-4"><b>Total Upah : Rp. <?php echo $dt->total_upah;?> </b></label></td>	
			<td></td>
			</tr>
			<tr>
			<td>================================================================================</td>
			</tr>	
				

</table>   

<table>
 <tr>
		<td style="border: 0px;" colspan="23"><span class="style2"></span></td>
		<td colspan="4"><span class="style2">Demak, <?php echo $dt->tgl_dok ;?> </span></td>
</tr>
<tr>
		<td>
		</td>
</tr>
<tr>
		<td>
		</td>
</tr>

<tr>
		<td>
		</td>
</tr>
	<tr>
	<td>  Personalia </td>
  </tr>
 </table>  
    


<?php } ?>

