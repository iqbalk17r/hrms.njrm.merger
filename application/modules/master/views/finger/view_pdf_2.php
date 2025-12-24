<!DOCTYPE html>
<html>
<head>
<h5>Laporan Uang Makan Wilayah Surabaya</h5>
<h5>Periode: <?php echo $tgl;?></h5>

</head>
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
<body>
<div class="row">	
		<table >
			<thead>
				<tr>
					<th width="5%">NO</th>
					<th >NAMA</th>
					<th width="60px">DEPT.</th>
					<th >CHECKTIME</th>					
					<th width="5%">Status</th>
					<th >Keterangan</th>
					<th >Makan</th>					
				</tr>
			</thead>
			<?php //foreach($list_peg as $peg){ ?>
			<tbody>
				<?php $no=1; foreach($list_um as $um){ ?>																
				<?php if ($um->checktype=='TOTAL') {echo '<tr style="background-color:#c3bcbc"> ';} else {echo '<tr>';}?>																							
					<?php
					$cektipe=trim($um->checktype);					
					if ($cektipe=='IN'){
						if ($um->checktime<'08:00:00'){
							$tglawal=explode(' - ',$tgl);	?>
							<td rowspan="1"><?php //echo $tglawal[0].' dan '.date('d-m-Y', strtotime($um->checkdate));
							if ($tglawal[0]==date('d-m-Y', strtotime($um->checkdate))) {echo $no;}?></td>
							<td><?php echo $um->nmlengkap;?></td>
							<td><?php echo $um->departement;?></td>												
							<td><?php 
							if ($um->checktype<>'TOTAL'){																							
								echo date('d-m-Y', strtotime($um->checkdate));
							}
							?> <?php echo $um->checktime;
							?></td>
							<?php	echo '<td>'.$um->checktype.'</td>';
								echo '<td>Berangkat Tepat Waktu</td>';
								echo '<td>'.$um->uangmakan.'</td>';
							} else {?>
								<td><?php //echo $no;?></td>
								<td><?php echo $um->nmlengkap;?></td>
								<td><?php echo $um->departement;?></td>												
								<td><?php 
								if ($um->checktype<>'TOTAL'){																							
									echo date('d-m-Y', strtotime($um->checkdate));
								}
								?> <?php echo $um->checktime;
								?></td>
							<?php
								echo '<td>'.$um->checktype.'</td>';
								echo '<td>Berangkat Terlambat</td>';
								if ($um->departement<>'SALES') {
									echo '<td>'.$um->uangmakan.'</td>';
									//echo '<td rowspan="7"></td>';															
								} else {
									echo '<td></td>';
								}															
							}
						} else if ($cektipe=='TOTAL'){
							$no++;
							if ($um->checktime<'08:00:00'){			
								//echo '<td>'.$no.'</td>';
								echo '<td colspan="3"></td>';
								echo '<td>Total Uang Makan: '.$um->uangmakan.'</td>';
								echo '<td>Tanda Tangan</td>';
								echo '<td colspan="2"></td>';															
							} else {
								echo '<td>'.$no.'</td>';
								echo '<td colspan="3"></td>';
								echo '<td colspan="2">Total Uang Makan</td>';
								echo '<td>'.$um->uangmakan.'</td>';
								echo '<td></td>';															
							}
						} else if ($cektipe=='GRANDTOTAL'){															
								echo '<td colspan="4"></td>';
								echo '<td colspan="2"><b>Grand Total Uang Makan</b></td>';
								echo '<td ><b>'.$um->uangmakan.'</b></td>';														
						} else if ($cektipe=='OUT'){
							if ($um->checktime<'16:00:00'){ ?>
								<td><?php //echo $no;?></td>
								<td><?php echo $um->nmlengkap;?></td>
								<td><?php echo $um->departement;?></td>												
								<td><?php 
								if ($um->checktype<>'TOTAL'){																							
									echo date('d-m-Y', strtotime($um->checkdate));
								}
								?> <?php echo $um->checktime;
								?></td>
							<?php
								echo '<td>'.$um->checktype.'</td>';
								echo '<td>Pulang Awal</td>';
								echo '<td></td>';
								
							} else if ($um->checktime>='17:00:00'){ ?>
								<td><?php //echo $no;?></td>
								<td><?php echo $um->nmlengkap;?></td>
								<td><?php echo $um->departement;?></td>												
								<td><?php 
								if ($um->checktype<>'TOTAL'){																							
									echo date('d-m-Y', strtotime($um->checkdate));
								}
								?> <?php echo $um->checktime;
								?></td>
							<?php
								echo '<td>'.$um->checktype.'</td>';
								echo '<td>Loyalitas</td>';
								echo '<td></td>';
								
							} else {?>
								<td><?php //echo $no;?></td>
								<td><?php echo $um->nmlengkap;?></td>
								<td><?php echo $um->departement;?></td>												
								<td><?php 
								if ($um->checktype<>'TOTAL'){																							
									echo date('d-m-Y', strtotime($um->checkdate));
								}
								?> <?php echo $um->checktime;
								?></td>
							<?php
								echo '<td>'.$um->checktype.'</td>';
								echo '<td>Pulang Tepat Waktu</td>';
								if ($um->departement=='SALES') {
									echo '<td>'.$um->uangmakan.'</td>';
								} else {
									echo '<td></td>';
								}
							}
						}	
					?>
					
				</tr>
				<?php  }?>
			</tbody>	
			<?php //}?>
		</table>			
</div>

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
					<td style="font-size:14px;">Dwi Yulianingsih<td>
					<td><td>
					<td style="font-size:14px;">Merry Chrissinda<td>				
				</tr>
			</tbody>
		</table>
	</p>	
</div>

</body>
</html>