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
<?php echo $message;?>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<!--<a href="<?php echo site_url("trans/upah_borong/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
				
				<div class="col-sm-6">
				<a href="<?php echo site_url("payroll/harianpayroll/upah_borong")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				<a href="<?php echo site_url("payroll/harianpayroll/excel_sum_borong/$tglawal/$tglakhir/$kddept")?>"  class="btn btn-default" style="margin:10px;">Export Excel</a>
				</div>
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>
							
							<th>Nomer Dokumen</th>										
							<th>Tanggal Kerja</th-->										
							<th>NIK</th>										
							<th>Nama Karyawan</th>										
							<th>Total Upah</th>											
							<!--<th>Action</th>-->						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_borong as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><!?php echo $lu->nik;?></td>
							<td><!?php echo $lu->nmlengkap;?></td>-->
							<!--<td><a href="#" data-toggle="modal" data-target="#dtl<!?php echo trim($lu->nodok_ref);?>"><!?php echo $lu->nodok_ref;?></a></td>-->
							<!--td><a <!?php echo $nodok=trim($lu->nodok_ref);?> href="<!?php echo site_url("payroll/ceklembur/edit_borong/$nodok/$tglawal/$tglakhir/$kddept/$kdgroup_pg");?>"><!?php echo $lu->nodok_ref;?></a></td>
							<td><!?php echo $lu->tgl_kerja;?></td-->
							<!--td><?php echo $lu->nik;?></td-->
							<td><a <?php $nik=trim($lu->nik);?> href="<?php echo site_url("payroll/harianpayroll/lihat_borong_detail/$tglawal/$tglakhir/$nik/$kddept");?>"> <?php echo trim($lu->nik);?></a></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->total_upah1;?></td>
							
						</tr>
						<?php endforeach;?>
					</tbody>
						
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>



</body>



