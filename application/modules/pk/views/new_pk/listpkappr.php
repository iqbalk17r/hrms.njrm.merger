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
							<th>No Dokumen</th>	
                            <th>No Kontrak</th>	
                            <th>Periode</th>
                            <th>Sts Kontrak</th>
							<th>Status persetujuan</th>
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
						<?php $enc_docno = $this->fiky_encryption->enkript(trim($row->kdcontract)); ?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>	
							<td>
								<a href="<?= base_url('trans/karyawan/cetak') . '/?enc_docno=' . $enc_docno ?>" 
								   class="btn btn-primary btn-sm">
									<i class="fa fa-file"></i> Lihat Dokumen
								</a>
							</td>
							<td><?php echo $row->namakaryawan;?></td>
							<td><?php echo $row->kddok; ?></td>
							<td><?php echo $row->kdcontract;?></td>
                            <td width="20%"><?php echo $row->periode;?></td>
                            <td><?php echo $row->nmkepegawaian;?></td>
							<td class="<?php echo (trim($row->status) == 'C') ? 'bg-danger text-white' : ''; ?>">
								<?php echo $row->deskappr; ?>
							</td>
							<td width="23%">
								<?php 
								if (
									$row->status != 'C' && (
										($nikuser == $row->nik_atasan2 && $row->status == 'N') ||
										($nikuser == $apprlist[trim('HRGA')] && $row->status == 'A2') ||
										($nikuser == $apprlist[trim('GM')] && $row->status == 'HR') ||
										($nikuser == $apprlist[trim('D')] && $row->status == 'GM')
									)
								): ?>
									<a href="<?php echo site_url('pk/approve_pk/?kddok=' . $row->kddok . '&status=' . $row->status); ?>" 
									   class="btn btn-sm btn-success" 
									   onclick="return confirm('Apakah Anda yakin ingin menyetujui dokumen ini?');">
										<i class="fa fa-check"></i> Setujui
									</a>
									<a href="<?php echo site_url('pk/cancel_pk/?kddok=' . $row->kddok . '&status=' . $row->status); ?>" 
									   class="btn btn-sm btn-danger" 
									   onclick="return confirm('Apakah Anda yakin ingin membatalkan dokumen ini?');">
										<i class="fa fa-times"></i> Batalkan
									</a>
									<a href="<?php echo site_url("pk/edit_pk_view/?nik=$row->nik&docno=$row->kdcontract&kddok=$row->kddok") ?>" 
									   class="btn btn-sm btn-warning" 
									   onclick="return confirm('Apakah Anda yakin ingin mengedit dokumen ini?');">
										<i class="fa fa-edit"></i> Edit
									</a>
								<?php endif; ?>
								<!-- Tombol Delete dengan link a -->
								 <!-- <form action="<?php echo site_url('pk/delete_pk') ?>" method="POST" style="display:inline;">
									<input type="hidden" name="docno" value="<?php echo $row->kddok; ?>">
									<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i class="fa fa-trash"></i>Delete</button>
								</form> -->
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>








