<html>
<head>
<title>Untitled Document</title>
</head>

<body>
<table>
	<tr>
    	<td colspan="6"><p>&nbsp;</p>
   	    <p>&nbsp;</p></td>
    </tr>
  <tr>
    <td colspan="6" align="center"><b><u>SURAT KEPUTUSAN</u><br>
      No : <?php echo $mts['kddokumen'];?><br>
      TENTANG<br>
      MUTASI KERJA DAN JABATAN</b><br>
      <br>
      DIREKSI PT. NUSA UNGGUL SARANA ADICIPTA</td>
  </tr>
  

  
  <tr>
    <td valign="top">MENIMBANG</td>
    <td width="2%"  align="center" valign="top">:</td>
    <td colspan="4">
        <ol type="a">
			<li>
				Bahwa dalam rangka mendukung perkembangan dan kemajuan perusahaan
				dipandang perlu untuk mengadakan mutasi kerja.
			</li>
			<li>
				Bahwa pekerjaan yang dimaksud memenuhi kriteria dan dapat dipertimbangkan <br>
				menduduki jabatan tersebut.
			</li>
			<li>
				Bahwa untuk kepentingan tersebut perlu diterbitkan surat keputusan.
			</li>
        </ol>
    </td>
  </tr>
  
  <tr>
    <td valign="top">MENGINGAT</td>
    <td align="center" valign="top">:</td>
    <td colspan="4">
      <ol type="a">
        <li>          
            SK Direksi <?php echo $mts['kdskdireksi'];?> tentang Struktur Organisasi PT. Nusa Unggul Sarana Adicipta.
        </li>
        <li>
          Hasil penilaian kerja yang bersangkutan.
        </li>
        <?php if ($mts['memo']=='Y' and !empty($mts['memo'])){ ?>
		<li>
          Internal memo direksi tanggal <?php echo $mts['tglmemo'];?>.
        </li>
		<?php } ?>
      </ol>
    </td>
  </tr>
  <tr>
    <td colspan="6" valign="top">MENETAPKAN</td>    
  </tr>
  <tr>
    <td valign="top">PERTAMA</td>
    <td valign="top" align="center">:</td>
    <td valign="top" colspan="4"><p>Mengangkat karyawan dengan identitas sebagai berikut:
    <table>
    <tr>
              <td>Nama</td>
          <td align="center">:</td>
          <td><?php echo $mts['nmlengkap'];?></td>
        </tr>
            <tr>
              <td>NIK</td>
              <td align="center">:</td>
              <td><?php echo $mts['nip'];?></td>
        </tr>
            <tr>
              <td>Jabatan Lama</td>
              <td align="center">:</td>
              <td><?php echo $mts['oldjabatan'];?></td>
        </tr>
            <tr>
              <td>Departement</td>
              <td align="center">:</td>
              <td><?php echo $mts['olddepartement'];?></td>
        </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td>Jabatan Baru</td>
              <td align="center">:</td>
              <td><?php echo $mts['jabatan'];?></td>
        </tr>
            <tr>
              <td>Departement</td>
              <td align="center">:</td>
              <td><?php echo $mts['departement'];?></td>
        </tr>
          </table>
    <p></p></td>
  </tr>
  <tr>
    <td>KEDUA</td>
    <td align="center">:</td>
    <td colspan="4">Dalam melaksanakan tugas, bertanggungjawab kepada <?php echo $mts['responbility'];?></td>
  </tr>
  <tr>
    <td>KETIGA</td>
    <td align="center">:</td>
    <td colspan="4">Melaksanakan tugas sebagaimana job deskripsi dan arahan dari atasan</td>
  </tr>
  <tr>
    <td width="11%">KEEMPAT</td>
    <td align="center">:</td>
    <td colspan="4">Surat Keputusan ini berlaku sejak tanggal 
	<?php //$date=date('d n Y',strtotime($mts['tglmutasi']));
	$date=$mts['tglmutasi'];
	$blnindo= array("","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl   = substr($date, 8, 2);

	$result = $tgl . " " . $blnindo[(int)$bulan] . " ". $tahun;
	
	echo $result; ?></td>
  </tr>
  <tr>
  		<td colspan="6"></td>
  </tr>
 

  <tr>

    <td colspan="4">&nbsp;</td>
    <td colspan="2" align="right"><p>
      <table align="right">
      <tr>
            <td>Ditetapkan di</td>
          <td>:</td>
          <td>Surabaya</td>
        </tr>
          <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td><?php 
			
			echo date('d').' '.$blnindo[date('n')].' '.date('Y');?></td>
        </tr>
          <tr>
            <td colspan="4">PT. Nusa Unggul Sarana Adicipta</td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4"><u>Yudi Prasetyo Utomo</u></td>
          </tr>
          <tr>
            <td colspan="4">Direktur Utama</td>
          </tr>
        </table>
    <p></p></td>
  </tr>
</table>
<p align="left">
</body>
</html>
