<style>
.form-control {
  display: block;
  width: 100%;
  height: 20px;
  padding: 6px 12px;
  font-size: 8px;
  line-height: 1.428571429;
  color: #555555;
  vertical-align: middle;
  background-color: #ffffff;
  background-image: none;
  border: 1px solid #cccccc;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
          transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
}
table {
    width:100%;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
	font-size:10px;
}
th, td {
    padding: 5px;
    text-align: left;
}
.row {
  margin-right: -15px;
  margin-left: -15px;
}

.row:before,
.row:after {
  display: table;
  content: " ";
}

.row:after {
  clear: both;
}

.row:before,
.row:after {
  display: table;
  content: " ";
}

.row:after {
  clear: both;
}
</style>

<p><img src="http://www.nusaboard.co.id/wp-content/uploads/2015/02/newlogo-nusaboard.jpg" width="200" height="45" /><strong> Laporan Uang Makan Wilayah <?php echo $cabang['wilayah'];?> </strong></p></br>Periode: <?php echo $tgl1.' hingga '.$tgl2;?>
</br>
<div class="row">
<table >
	<thead>
		  <tr>
			<th bgcolor="#CCCCCC"><div align="center">No</div></th>
			<th bgcolor="#CCCCCC"><div align="center">Nama</div></th>
			<th bgcolor="#CCCCCC"><div align="center">Departement</div></th>
			<th bgcolor="#CCCCCC"><div align="center">Checktime</div></th>
			<th bgcolor="#CCCCCC"><div align="center">Status</div></th>
			<th bgcolor="#CCCCCC"><div align="center">Keterangan</div></th>
			<th bgcolor="#CCCCCC"><div align="center">Uang Makan</div></th>
		  </tr>
	</thead>
	<tbody>
		<?php $no=1; foreach($list_um as $ph){?>
		<?php if ($ph->badgenumber=='TOTAL') {?>
		<tr bgcolor="#66FF99">
			<td colspan='3'></td>						
			<td>TOTAL UANG MAKAN <?php echo $ph->nmlengkap;?>: <?php echo $ph->uangmakan;?></td>
			<td>Tanda Tangan</td>
			<td colspan="2"></td>
		</tr>
		<?php } else if ($ph->badgenumber=='GRAND TOTAL'){?>
		<tr bgcolor="#CCCCCC">
			<td colspan='3'></td>						
			<td><b>GRAND TOTAL UANG MAKAN:</b></td>			
			<td colspan="3"><b><?php echo $ph->uangmakan;?></b></td>
		</tr>
		<?php } else {?>
		<tr >
			<td><?php echo $no;?></td>
			<td><?php echo $ph->nmlengkap;?></td>
			<td><?php echo $ph->departement;?></td>
			<td><?php echo $ph->checkdate.', '.$ph->hari.' '.$ph->checkin.'|'.$ph->checkout;?></td>
			<td></td>
			<td><?php echo $ph->ket;?></td>
			<td><?php echo $ph->uangmakan;?></td>
		</tr>
		<?php }$no++; }?>		
	</tbody>
</table>
</div>
<p>&nbsp;</p>
<div style="margin-top:50px;">
	<p>
		<table border="0">
			<tbody>
				<tr>
					<td><td>
					<td><td>
					<td><td>
					<td><td>
					<td><td>
					<td style="font-size:14px;"><?php echo date('d F Y');?><td>				
				</tr>
				<tr>
					<td><td>
					<td style="font-size:14px;">Dibuat,<td>
					<td><td>
					<td style="font-size:14px;">Diperiksa,<td>
					<td><td>
					<td style="font-size:14px;">Disetujui,<td>				
				</tr>
				<tr>
					<td><td>
					<td><td>
					<td><td>
					<td><td>
					<td><td>
					<td><td>				
				</tr>
				<tr>
					<td><td>					
					<td><td>					
					<td><td>					
					<td><td>					
					<td><td>					
					<td><td>					
				</tr>
				<tr>
					<td><td>					
					<td><td>					
					<td><td>					
					<td><td>					
					<td><td>					
					<td><td>					
				</tr>
				<tr>					
					<td><td>				
					<td><td>				
					<td><td>				
					<td><td>				
					<td><td>				
					<td><td>				
				</tr>
				<tr>	
					<td><td>
					<td style="font-size:14px;"><?php $pembuat=strtolower($this->session->userdata('username'));
					$buatan=ucfirst($pembuat);
					echo $buatan; ?><td>
					<td><td>
					<td style="font-size:14px;">(.......................)<td>
					<td><td>
					<td style="font-size:14px;">(.......................)<td>				
				</tr>
			</tbody>
		</table>
	</p>	
</div>

<script type="text/php">

if ( isset($pdf) ) {

  $font = Font_Metrics::get_font("helvetica", "bold");
  $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));

}
</script>
