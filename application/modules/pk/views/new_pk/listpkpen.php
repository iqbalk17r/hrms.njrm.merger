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
<script type="text/javascript">
    $(function() {
        $('#table1').dataTable({
            "paging": true,
            "searching": true,
            "ordering": false,
            "columnDefs": [
                { "defaultContent": "-", "targets": "_all" } // Allow null values by setting default content
            ]
        });
        $("#datatableMaster").dataTable();
    });
</script>

<legend><?php echo $title;?></legend>

<?php 

?>

<?php echo $message; ?>
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>	
							<th>Lihat Dokumen</th>	
							<th>Nama</th>
                            <th>No Kontrak</th>	
                            <th>Periode</th>
                            <th>Sts Kontrak</th>
							<th>Status Penilaian</th>
                            <th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($listpk as $row): $no++; ?>
						<?php 
							foreach ($row as $key => $value) {
								$row->$key = trim($value);
							}
						?>
						<?php $enc_docno = $this->fiky_encryption->enkript(trim($row->nodok)); ?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>	
							<td>
							<?php
								echo (empty($row->statuspen)) 
									? '-' 
									: '<a href="' . base_url('trans/karyawan/cetak') . '/?enc_docno=' . $enc_docno . '" class="btn btn-primary btn-sm">
											<i class="fa fa-file"></i> Lihat Dokumen
										</a>' ;
								?>
							</td>
							<td><?php echo $row->nmlengkap;?></td>
							<td><?php echo $row->nodok;?></td>
                            <td width="20%"><?php echo $row->periode;?></td>
                            <td><?php echo $row->nmkepegawaian;?></td>
							<td class="<?php echo (trim($row->status) == 'C') ? 'bg-danger text-white' : ''; ?>">
								<?php echo ($row->deskappr) ? $row->deskappr : 'MENUNGGU PENILAIAN ATASAN 1'; ?>
							</td>
							<td width="auto">
								<?php 
								if (empty($row->statuspen)): ?>
									<a href="<?php echo site_url("pk/penilaian_karyawan/?nik=$row->nik&docno=$row->nodok&type=y"); ?>" 
									class="btn btn-sm btn-success">
									<i class="fa fa-star"></i> Nilai karyawan
									</a>
								<?php elseif (trim($row->statuspen) == 'C'): ?>
									<a href="<?php echo site_url("pk/edit_pk_view/?nik=$row->nik&docno=$row->nodok&kddok=$row->kddok&type=n") ?>" 
									class="btn btn-sm btn-warning" 
									onclick="return confirm('Apakah Anda yakin ingin mengedit dokumen ini?');">
									<i class="fa fa-edit"></i> Edit Penilaian
									</a>
								<?php endif; ?>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>








