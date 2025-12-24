<style type="text/css">
<!--
.style2 {font-size: 11px}
-->
</style>
<table width="100%" border="1" cellpadding="0" cellspacing="1">
  <tr>
    <td style="border: 0px;" colspan="34" align="left" valign="top"></td>
  </tr>
  <tr>
    <td style="border: 0px;"  align="right" colspan="34"><span class="style2"><strong><h2 style="font-weight:big;">PT.    NUSANTARA BUILDING INDUSTRIES</h2></strong></span></td>
  </tr>
 
  <tr>
    <td style="border: 0px;" colspan="34"><div align="center" class="style2"><strong><h3>SLIP GAJI KARYAWAN PERIODE <?php echo $periode;?></h3></strong></div></td>
  </tr>
   <tr>
    <td style="border: 0px;" colspan="22"><span class="style2"><h5>NIK		: <?php echo $li['nik'];?> </h5></span></td>
  </tr>
  <tr>
  <td style="border: 0px;" colspan="22" ><span  class="style2"><h5>Nama	: <?php echo $li['nmlengkap'];?> </h5></span></td>
  </tr>
   <tr>
  <td style="border: 0px;" colspan="22" ><span  class="style2"><h5>Departmen	: <?php echo $li['nmdept'];?> </h5></span></td>
  </tr>
   <tr>
  <td style="border: 0px;" colspan="22" ><span  class="style2"><h5>Jabatan	: <?php echo $li['nmjabatan'];?> </h5></span></td>
  <br>
  </tr>
   <tr>
    <td style="border: 0px;" colspan="34"><span class="style2"> </span></td>
   <td style="border: 0px;" colspan="34" ><span align="right" class="style2"> </span></td>
   <td style="border: 0px;" colspan="34"><span class="style2"> </span></td>
  </tr>
  <tr>
    <td style="border: 0px;" colspan="22"><span class="style2"><p>Gaji Pokok		: Rp.<?php echo $lo['gajipokok'];?> </p></span></td>
   
   <td style="border: 0px;" colspan="13"><span class="style2"></span></td>
  </tr>
  
 
  <tr>
   <td style="border: 0px;" colspan="22"><span class="style2">Tunjangan Tetap : </span></td>
   <td style="border: 0px;" ><span align="right" class="style2">BPJS TK	 </span> </td>
   
  </tr>
  <tr>
   <td style="border: 0px;" colspan="22"><span class="style2">		1.Jabatan	: <?php echo $lo['tj_jabatan'];?></span></td>
   <td style="border: 0px;" colspan="22"><span align="right" class="style2">1. JHT	: Rp.<?php echo $lo['jht'];?></span></td>
   
  </tr>
  <tr>
   <td style="border: 0px;" colspan="22"><span class="style2">		2.Masa Kerja	: Rp.<?php echo $lo['tj_masakerja'];?></span></td>
   <td style="border: 0px;" colspan="22"><span align="right" class="style2">2. JP	: Rp.<?php echo $lo['jp'];?></span></td>
   
  </tr>
	<tr>
   <td style="border: 0px;" colspan="22"><span class="style2">		3.Prestasi	: Rp.<?php echo $lo['tj_prestasi'];?></span></td>
   <td style="border: 0px;" colspan="22"><span align="right" class="style2">BPJS KES	: Rp.<?php echo $lo['bpjs'];?></span></td>
   
  </tr>
	<tr>
   <td style="border: 0px;" colspan="22"><span class="style2"><p>Tunjangan Tidak Tetap :</span></td>
   <td style="border: 0px;" colspan="22"><span align="right" class="style2">Potongan	: </p></span></td>
   
  </tr>
  <tr>
   <td style="border: 0px;" colspan="22"><span class="style2">1.Shift	: Rp.<?php echo $lo['tj_shift'];?></span></td>
   <td style="border: 0px;" colspan="22"><span align="right" class="style2">1. Absensi	: Rp.<?php echo $lo['ptg_absensi'];?></span></td>
   
  </tr>
  <tr>
   <td style="border: 0px;" colspan="22"><span class="style2">2.Lembur	: Rp.<?php echo $lo['lembur'];?></span></td>
   <td style="border: 0px;" colspan="22"><span align="right" class="style2">2. Pinjaman	: Rp.<?php echo $lo['pinjaman'];?> </span></td>
   
  </tr>
  <tr>
   <td style="border: 0px;" colspan="22"><span class="style2">Lain - lain 	: Rp.<?php echo $lo['pen_lain'];?></span></td>
   <td style="border: 0px;" colspan="22"><span align="right" class="style2">3. Lain - lain	: Rp.<?php echo $lo['ptg_lain'];?>  </span></td>
   
   
  </tr>
  <tr>
   <td style="border: 0px;" colspan="22"><span class="style2">Total Gaji Kotor 	: Rp.<?php echo $lo['gajikotor'];?></span></td>
   <td style="border: 0px;" colspan="22"><span align="right" class="style2">PPH 21	: Rp.<?php echo $lo['pph21'];?> </span></td>
  </tr>
   <tr>
   <td style="border: 0px;" colspan="22"><span  class="style2"></span></td>
	<td style="border: 0px;" colspan="22"><span align="right" class="style2">Potongan Koprasi	: Rp.<?php echo $lo['ptg_koperasi'];?> </span></td>
   </tr>
  
  <tr>
   <td style="border: 0px;" colspan="22"><span  class="style2"></span></td>
	<td style="border: 0px;" colspan="22"><span align="right" class="style2">Total Potongan	: Rp.<?php echo $lo['total_ptg'];?> </span></td>
   </tr>
   <tr>
   <td style="border: 0px;" colspan="22"><span  class="style2"></span></td>
	<td style="border: 0px;" colspan="22"><span align="right" class="style2"><h4>Gaji Bersih 	: Rp.<?php echo $lo['totalupah'];?></h4></span></td>
   </tr>
   
   </table>
 <table>
 <tr>
    <td style="border: 0px;" colspan="23"><span class="style2"></span></td>
    <td colspan="11"><span class="style2">Demak, <?php echo date('Y-m-d') ;?> </span></td>
  </tr>
 </table> 