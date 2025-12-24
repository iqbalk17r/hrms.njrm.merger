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
					<a href="<?php echo site_url("payroll/report/excel_report_absensi/$bln/$thn")?>"  class="btn btn-warning" style="margin:10px; color:#ffffff;">Download Excel</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>																	
							<th>Nik</th>										
							<th>Nama Karyawan</th>							
							<th>Department</th>
							<th>Jabatan</th>
							<th>Regu</th>
							<th>Tgl 1</th>																																																																																																																						
							<th>Tgl 2</th>																																																																																																																						
							<th>Tgl 3</th>																																																																																																																						
							<th>Tgl 4</th>																																																																																																																						
							<th>Tgl 5</th>																																																																																																																						
							<th>Tgl 6</th>																																																																																																																						
							<th>Tgl 7</th>																																																																																																																						
							<th>Tgl 8</th>																																																																																																																						
							<th>Tgl 9</th>																																																																																																																						
							<th>Tgl 10</th>																																																																																																																						
							<th>Tgl 11</th>																																																																																																																						
							<th>Tgl 12</th>																																																																																																																						
							<th>Tgl 13</th>																																																																																																																						
							<th>Tgl 14</th>																																																																																																																						
							<th>Tgl 15</th>																																																																																																																						
							<th>Tgl 16</th>																																																																																																																						
							<th>Tgl 17</th>																																																																																																																						
							<th>Tgl 18</th>																																																																																																																						
							<th>Tgl 19</th>																																																																																																																						
							<th>Tgl 20</th>																																																																																																																						
							<th>Tgl 21</th>																																																																																																																						
							<th>Tgl 22</th>																																																																																																																						
							<th>Tgl 23</th>																																																																																																																						
							<th>Tgl 24</th>																																																																																																																						
							<th>Tgl 25</th>																																																																																																																						
							<th>Tgl 26</th>																																																																																																																						
							<th>Tgl 27</th>																																																																																																																						
							<th>Tgl 28</th>																																																																																																																						
							<th>Tgl 29</th>																																																																																																																						
							<th>Tgl 30</th>																																																																																																																						
							<th>Tgl 31</th>																																																																																																																						
							<th>Total Shift 2</th>																																																																																																																						
							<th>Total Shift 3</th>																																																																																																																						
							<th>Alpha</th>																																																																																																																						
							<th>Cuti</th>																																																																																																																						
							<th>Ijin</th>																																																																																																																						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_absen as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							<td><?php echo $lu->nmjabatan;?></td>
							<td><?php echo $lu->kdregu;?></td>
							<td><?php echo $lu->tgl1;?></td>
							<td><?php echo $lu->tgl2;?></td>
							<td><?php echo $lu->tgl3;?></td>
							<td><?php echo $lu->tgl4;?></td>
							<td><?php echo $lu->tgl5;?></td>
							<td><?php echo $lu->tgl6;?></td>
							<td><?php echo $lu->tgl7;?></td>
							<td><?php echo $lu->tgl8;?></td>
							<td><?php echo $lu->tgl9;?></td>
							<td><?php echo $lu->tgl10;?></td>
							<td><?php echo $lu->tgl11;?></td>
							<td><?php echo $lu->tgl12;?></td>
							<td><?php echo $lu->tgl13;?></td>
							<td><?php echo $lu->tgl14;?></td>
							<td><?php echo $lu->tgl15;?></td>
							<td><?php echo $lu->tgl16;?></td>
							<td><?php echo $lu->tgl17;?></td>
							<td><?php echo $lu->tgl18;?></td>
							<td><?php echo $lu->tgl19;?></td>
							<td><?php echo $lu->tgl20;?></td>
							<td><?php echo $lu->tgl21;?></td>
							<td><?php echo $lu->tgl22;?></td>
							<td><?php echo $lu->tgl23;?></td>
							<td><?php echo $lu->tgl24;?></td>
							<td><?php echo $lu->tgl25;?></td>
							<td><?php echo $lu->tgl26;?></td>
							<td><?php echo $lu->tgl27;?></td>
							<td><?php echo $lu->tgl28;?></td>
							<td><?php echo $lu->tgl29;?></td>
							<td><?php echo $lu->tgl30;?></td>
							<td><?php echo $lu->tgl31;?></td>
							<td><?php echo $lu->shift2;?></td>
							<td><?php echo $lu->shift3;?></td>
							<td><?php echo $lu->alpha;?></td>
							<td><?php echo $lu->cuti;?></td>
							<td><?php echo $lu->ijin;?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
				
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>







</body>



