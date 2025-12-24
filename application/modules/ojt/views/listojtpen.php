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
                            <th>Sts Kontrak</th>
							<th>Sts penilaian</th>
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
						<?php $enc_docno = $this->fiky_encryption->enkript(trim($row->nodok_ojt)); ?>
						<?php $enc_kddok = $this->fiky_encryption->enkript(trim($row->kddok)); ?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>	
							<td>
							<?php
								echo (empty($row->statusnew)) 
									? '-' 
									: '<a href="' . base_url('ojt/cetak') . '/?enc_docno=' . $enc_docno . '&enc_kddok=' . $enc_kddok . '" class="btn btn-primary btn-sm">
											<i class="fa fa-file"></i> Lihat Dokumen
										</a>' ;
								?>
							</td>
							<td><?php echo $row->nama_ojt;?></td>
							<td><?php echo $row->nodok_ojt;?></td>
                            <td><?php echo $row->nmkepegawaian;?></td>
							<td class="<?php echo (trim($row->status) == 'C') ? 'bg-danger text-white' : ''; ?>">
								<?php echo ($row->deskappr) ? $row->deskappr : 'MENUNGGU PENILAIAN PANELIST'; ?>
							</td>
							<td width="auto">
								<?php 
								if (empty($row->statusnew)): ?>
									<a href="<?php echo site_url("ojt/penilaian_karyawan/?nik=$row->nik_ojt&docno=$row->nodok_ojt&type=y"); ?>" 
									class="btn btn-sm btn-success">
									<i class="fa fa-star"></i> Nilai karyawan
									</a>
								<?php elseif (!empty($row->statusnew) && trim($row->statusnew) != 'P'): ?>
									<a href="<?php echo site_url("ojt/edit_ojt_view/?nik=$row->nik_ojt&docno=$row->nodok_ojt&kddok=$row->kddok&type=n") ?>" 
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








