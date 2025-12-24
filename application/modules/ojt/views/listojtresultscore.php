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

<?php if ($this->session->flashdata('message')): ?>
	<div id="flash-message">
		<?= $this->session->flashdata('message'); ?>
	</div>
	<script>
		setTimeout(function() {
			$('#flash-message').fadeOut('slow');
		}, 2000);
	</script>
	<script>
		$(function() {
			setTimeout(function() {
				$('.alert.alert-d').fadeOut('fast');
			}, 0);
		});
	</script>
<?php endif; ?>

<?php 

?>

<?php echo $message; ?>
<?php if ($this->input->get('event') === 'y'): ?>
	<a href="<?= site_url('/agenda/event') ?>" class="btn btn-success" style="margin-left:10px; margin-bottom:10px;">
		<i class="fa fa-arrow-left"></i> kembali
	</a>
<?php else: ?>
	<a href="javascript:history.back()" class="btn btn-success" style="margin-left:10px; margin-bottom:10px;">
		<i class="fa fa-arrow-left"></i> kembali
	</a>
<?php endif; ?>
<!-- Button to trigger modal -->
<?php if (!$checkrekap): ?>
<button type="button" class="btn btn-success" style="margin-left:10px; margin-bottom:10px;" data-toggle="modal" data-target="#rekapModal">
	<i class="fa fa-plus"></i> Tambahkan Rekap
</button>
<?php else:?>
<?php $enc_kddok = $this->fiky_encryption->enkript(trim($kddok)); ?>
<button type="button" class="btn btn-warning" style="margin-left:10px; margin-bottom:10px;" id="editRekapBtn">
	<i class="fa fa-edit"></i> Edit Rekap
</button>
<a href="<?= base_url('ojt/cetak2') . '/?enc_docno=' . $enc_kddok ?>" class="btn btn-primary" style="margin-left:10px; margin-bottom:10px;">
	<i class="fa fa-file"></i> Lihat Rekap
</a>
<script>
$(function() {
	$('#editRekapBtn').on('click', function() {
		// You can pass data if needed, or leave null for empty form
		openRekapModal();
	});
});
</script>
<?php endif; ?>
<!-- Modal -->
<div class="modal fade" id="rekapModal" tabindex="-1" role="dialog" aria-labelledby="rekapModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width:700px;">
		<form method="post" action="<?= site_url('ojt/addOrUpdateRekap') ?>">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title" id="rekapModalLabel">Tambah / Edit Rekap <?php echo $name; ?></h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" id="rekap_id" value="">
					<input type="hidden" name="kddok" id="rekap_kddok" value="">
					<div class="form-group row">
						<label for="presentation_date" class="col-sm-3 col-form-label">Tanggal Presentasi</label>
						<div class="col-sm-9">
							<input type="text" class="form-control datepicker" id="presentation_date" name="presentation_date" required autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="knowledge" class="col-sm-3 col-form-label">A. Knowledge</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="knowledge" name="knowledge" rows="2" required></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="skill" class="col-sm-3 col-form-label">B. Skill</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="skill" name="skill" rows="2" required></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="attitude" class="col-sm-3 col-form-label">C. Attitude</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="attitude" name="attitude" rows="2" required></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="recommendation" class="col-sm-3 col-form-label">Rekomendasi</label>
						<div class="col-sm-9">
							<?php $i = 0; ?>
							<?php foreach ($datamodal as $item): ?>
								<!-- Input NIK -->
								<input type="text" class="form-control mb-2" name="nik_rekomendasi[]" value="<?= htmlspecialchars($item->nmpanelist) ?>" placeholder="Nama" />

								<!-- Input Notes (readonly) -->
								<input type="text" class="form-control mb-2" name="notes_rekomendasi[]" value="<?= htmlspecialchars($item->notes) ?>" placeholder="Rekomendasi" readonly />

								<div class="input-group-append ml-2">
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="opsi-<?= $i ?>" value="Direkomendasikan">
										<label class="form-check-label">Direkomendasikan</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="opsi-<?= $i ?>" value="Direkomendasikan dengan catatan monitoring">
										<label class="form-check-label">Direkomendasikan dengan catatan monitoring</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="opsi-<?= $i ?>" value="Tidak Direkomendasikan">
										<label class="form-check-label">Tidak Direkomendasikan</label>
									</div>
								</div>
							<?php $i++; endforeach; ?>
							<!-- Kontainer input dinamis -->
							<div id="recommendation-inputs"></div>
								<!-- Tombol tambah dan gabungkan -->
								<button type="button" class="btn btn-sm btn-primary mt-2" onclick="addRecommendationInput()">Tambah Rekomendasi</button>
								<button type="button" class="btn btn-sm btn-success mt-2" onclick="combineRecommendations()">Gabungkan ke Textarea</button>

								<!-- Textarea hasil gabungan -->
								<textarea class="form-control mt-3" id="recommendation" name="recommendation" rows="4" required></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="conclusion" class="col-sm-3 col-form-label">Kesimpulan</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="conclusion" name="conclusion" rows="3" required></textarea>
						</div>
					</div>
				</div>
				<input type="hidden" name="kddok" value="<?php echo $kddok; ?>">
				<input type="hidden" name="nik" value="<?php echo $param; ?>">
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Example Edit Button (add this in your table row where you want edit functionality) -->
<!--
<td>
	<button type="button" class="btn btn-warning btn-sm edit-rekap-btn"
		data-id="<?= $row->rekap_id ?>"
		data-toggle="modal"
		data-target="#rekapModal">
		<i class="fa fa-edit"></i> Edit
	</button>
</td>
-->

<script>
function openRekapModal(data = null) {
	// Reset form
	$('#rekapModal form')[0].reset();
	$('#rekap_id').val('');
	$('#rekap_kddok').val('');

	if (data) {
		$('#rekap_id').val(data.id || '');
		$('#rekap_kddok').val(data.kddok || '');
		$('#presentation_date').val(data.presentation_date || '');
		$('#knowledge').val(data.knowledge || '');
		$('#skill').val(data.skill || '');
		$('#attitude').val(data.attitude || '');
		$('#recommendation').val(data.recommendation || '');
		$('#conclusion').val(data.conclusion || '');
		$('#rekapModalLabel').text('Edit Rekap');
	} else {
		$('#rekapModalLabel').text('Tambah Rekap');
	}
	$('#rekapModal').modal('show');
}

// Make sure the edit button exists in your table and has the class 'edit-rekap-btn'
// Example: <button class="edit-rekap-btn" data-id="...">Edit</button>
$(document).on('click', '.edit-rekap-btn, #editRekapBtn', function() {
	var kddok = '<?php echo $kddok; ?>';
	$.ajax({
		url: '<?= site_url('ojt/modal_rekap_ojt') ?>',
		type: 'POST',
		data: {kddok: kddok},
		dataType: 'json',
		success: function(json) {
			if (json && json.rekap) {
				openRekapModal(json.rekap);
			} else {
				alert('Data tidak ditemukan atau format data salah.');
			}
		},
		error: function(xhr, status, error) {
			alert('Terjadi kesalahan saat mengambil data: ' + error);
		}
	});
});


</script>

<script>
    let rekomendasiIndex = <?= $i ?>;

		function addRecommendationInput() {
		const container = document.getElementById('recommendation-inputs');

		const wrapper = document.createElement('div');
		wrapper.classList.add('mb-3');
		wrapper.innerHTML = `
			<input type="text" class="form-control mb-2" name="nik_rekomendasi[]" placeholder="Nama" />

			<div class="input-group-append ml-2">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="opsi-${rekomendasiIndex}" value="Direkomendasikan">
					<label class="form-check-label">Direkomendasikan</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="opsi-${rekomendasiIndex}" value="Direkomendasikan dengan catatan monitoring">
					<label class="form-check-label">Direkomendasikan dengan catatan monitoring</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="opsi-${rekomendasiIndex}" value="Tidak Direkomendasikan">
					<label class="form-check-label">Tidak Direkomendasikan</label>
				</div>
			</div>
		`;

			container.appendChild(wrapper);
			rekomendasiIndex++; // Naikkan indeks untuk input berikutnya
		}


	function combineRecommendations() {
	const totalSpacesBeforeColon = 25;
	let hasil = '';

	const namaInputs = document.querySelectorAll('input[name="nik_rekomendasi[]"]');
	const notesInputs = document.querySelectorAll('input[name="notes_rekomendasi[]"]');

		namaInputs.forEach((namaInput, index) => {
			const nama = namaInput.value.trim();
			const radioName = `opsi-${index}`;
			const radio = document.querySelector(`input[name="${radioName}"]:checked`);
			const pilihan = radio ? radio.value : 'Belum dipilih';

			let spasiBeforeColon = totalSpacesBeforeColon - nama.length;
			if (spasiBeforeColon < 0) spasiBeforeColon = 0;

			const leftPart = nama + ' '.repeat(spasiBeforeColon) + ': ';
			hasil += leftPart + pilihan + '\n';
		});

		document.getElementById('recommendation').value = hasil.trim();
	}



</script>

<script>
$(function() {
	// Initialize datepicker for modal input
	$('.datepicker').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd'
	});
});
</script>
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>	
							<th>Nama Penilai</th>
                            <th>No Kontrak</th>	
                            <th>Tgl penilaian</th>
                            <th>Lihat Dokumen Penilaian</th>	
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_result as $row): $no++; ?>
						<?php 
							foreach ($row as $key => $value) {
								$row->$key = trim($value);
							}
						?>
						<?php $enc_docno = $this->fiky_encryption->enkript(trim($row->kdcontract)); ?>
						<?php $enc_kddok = $this->fiky_encryption->enkript(trim($row->kddok)); ?>

						<tr>										
							<td width="2%"><?php echo $no;?></td>	
							<td><?php echo $row->nmpenilai;?></td>
							<td><?php echo $row->kdcontract;?></td>
                            <td width="20%"><?php echo $row->inputdate;?></td>
							<td>
                                	<?php
								echo ($row->status != 'P') 
									? '-' 
									: '<a href="' . base_url('ojt/cetak') . '/?enc_docno=' . $enc_docno . '&enc_kddok=' . $enc_kddok . '" class="btn btn-primary btn-sm">
											<i class="fa fa-file"></i> Lihat Dokumen
										</a>' ;
								?>
                            </td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>








