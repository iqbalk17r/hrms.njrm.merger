<?php
/*
	@author : junis 10-12-2012\m/
	@update : fiky 24-12-2016
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

<legend><?php echo $title;?></legend>
<?php //echo $message;?>
<div class="row">
	<div class="col-sm-12">
        <a href="<?php echo site_url("trans/stspeg/excel_ojt");?>"   class="btn btn-default">
            <i class="fa fa-download"></i> XLS
        </a>
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">	
					
				</div>
				<div class="col-sm-6">
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>NIK</th>
							<th>Nama Karyawan</th>
							<th>No Dokumen</th>
							<th>Nama Status</th>
							<th>Tanggal Mulai</th>
							<th>Tanggal Berakhir</th>
							<th>No SK</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_ojt as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->nmkepegawaian;?></td>
							<td><?php echo date('d-m-Y',strtotime($lu->tgl_mulai));?></td>
							<td><?php echo date('d-m-Y',strtotime($lu->tgl_selesai));?></td>
							<td><?php echo $lu->nosk;?></td>
							<td><?php echo $lu->eventketerangan;?></td>
							<!--td>

								<a <!?php echo $nik=trim($lu->nik);$nodok=trim($lu->nodok);?> href="<!?php echo site_url("trans/stspeg/index/$nik");?>"   class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>

							</td-->
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>






