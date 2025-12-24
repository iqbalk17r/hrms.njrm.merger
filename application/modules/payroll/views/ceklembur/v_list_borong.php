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

<?php echo $message;?>
<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
        <?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>
            <li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>
        <?php } else { ?>
            <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
        <?php } ?>
    <?php } ?>
</ol>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<!--<a href="<?php echo site_url("trans/upah_borong/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
				
				<div class="col-sm-6">
				<a href="<?php echo site_url("payroll/ceklembur/upah_borong")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
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
							<td><a <?php $nik=trim($lu->nik);?> href="<?php echo site_url("payroll/ceklembur/lihat_borong_detail/$tglawal/$tglakhir/$nik/$kddept");?>"> <?php echo trim($lu->nik);?></a></td>
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



