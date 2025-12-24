<script type="text/javascript">
    $(function() {
        $("#example1").dataTable({
            order: [],
            columnDefs: [{
                orderable: false,
                targets: [0, 1]
            }]
        });
    });
</script>

<style>
    thead tr th {
        text-align: center;
        text-transform: uppercase;
        white-space: nowrap;
    }

    thead tr th:first-child,
    thead tr th:nth-child(2) {
        padding-right: 8px !important;
    }
</style>

<legend><?php echo $title; ?></legend>

<div class="row">
    <div class="col-sm-12">
        <a href="<?php echo site_url("trans/lembur/index"); ?>" class="btn btn-default" style="margin: 10px;"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
    </div>
	<div class="col-sm-12">
		<div class="box">
			<div class="box-body table-responsive" style='overflow-x: scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th style="width: 1%;">No</th>
							<th style="width: 5%;">Action</th>
							<th>NIK</th>
							<th>Nama Karyawan</th>					
							<th>Nama Department</th>					
						</tr>
					</thead>
					<tbody>
						<?php foreach($list_karyawan as $k => $lu): ?>
                            <tr>
                                <td class="text-nowrap text-center"><?php echo ($k + 1); ?></td>
                                <td class="text-nowrap">
                                    <a href="<?php echo site_url("trans/lembur/proses_input/$lu->nik"); ?>" class="btn btn-success btn-sm">
                                        <i class="fa fa-plus"></i>&nbsp; Input Lembur
                                    </a>
                                </td>
                                <td class="text-nowrap"><?php echo $lu->nik; ?></td>
                                <td><?php echo $lu->nmlengkap; ?></td>
                                <td><?php echo $lu->nmdept; ?></td>
                            </tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
