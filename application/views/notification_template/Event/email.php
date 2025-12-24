<?php
echo '<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Undangan Agenda</title>
</head>
<body>
  <p><font face="Times New Roman, Times, serif">Yang Terhormat,</font></p>
  <blockquote><font face="Times New Roman, Times, serif">'
    . $send_to .
  '</font></blockquote>

  <font face="Times New Roman, Times, serif">
    <br>Dijadwalkan undangan untuk <b>' . $transaction['Nama_Agenda'] . '</b><br>
    yang akan dilaksanakan pada:<br>
  </font>

  <table width="643" height="107" cellspacing="0" cellpadding="0" border="0">
    <tbody>
      <tr height="26">
        <td width="64"><font face="Times New Roman, Times, serif">Tanggal Mulai</font></td>
        <td width="390"><font face="Times New Roman, Times, serif">: ' . $transaction['Tanggal_Mulai'] . '</font></td>
      </tr>
      <tr height="26">
        <td width="64"><font face="Times New Roman, Times, serif">Tanggal Selesai</font></td>
        <td width="390"><font face="Times New Roman, Times, serif">: ' . $transaction['Tanggal_Selesai'] . '</font></td>
      </tr>
      <tr height="26">
        <td width="64"><font face="Times New Roman, Times, serif">Tipe agenda</font></td>
        <td width="390"><font face="Times New Roman, Times, serif">: ' . $transaction['Tipe_Agenda'] . '</font></td>
      </tr>
      <tr height="26">
        <td width="64"><font face="Times New Roman, Times, serif">Lokasi</font></td>
        <td width="390"><font face="Times New Roman, Times, serif">: ' . $transaction['Lokasi'] . '</font></td>
      </tr>';

if (!empty($transaction['Link'])) {
  echo '<tr height="26">
          <td><font face="Times New Roman, Times, serif">Tempat</font></td>
          <td><font face="Times New Roman, Times, serif">: <a href="' . $transaction['Link'] . '">' . $transaction['Link'] . '</a></font></td>
        </tr>';
}

echo '    </tbody>
  </table>

  <br>
  <font face="Times New Roman, Times, serif">
    Demikian informasi ini kami sampaikan. Atas perhatian dan kerjasama Bapak/Ibu, kami ucapkan terima kasih.
  </font>

  <pre class="moz-signature" cols="72">-- 
Best Regards,

PT. Nusa Unggul Sarana Adicipta
Jl. Margomulyo Indah II Blok A No. 15 Surabaya - Jawa Timur 
Phone : 0896 2694 1650 | Telp : (031) 7491856-58 | Email : <a href="mailto:odtraining.nusa@nusantarajaya.co.id">odtraining.nusa@nusantarajaya.co.id</a>
</pre>
</body>
</html>';
?>
