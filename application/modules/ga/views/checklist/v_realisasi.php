<script type="text/javascript">
    $(function() {
        var t = $("#table-list").DataTable({
            order: [],
            columnDefs: [{
                orderable: false,
                targets: [0, -1]
            }],
        });
        t.on("order.dt search.dt", function() {
            t.column(0, {
                search: "applied", order: "applied"
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>

<style>
    thead tr th {
        text-align: center;
        text-transform: uppercase;
        white-space: nowrap;
    }

    thead tr th:first-child,
    thead tr th:last-child {
        padding-right: 8px !important;
        width: 1%;
    }
</style>

<legend><?= $title ?></legend>
<?= $message ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table id="table-list" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lokasi</th>
                            <th>Periode</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Wajib</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list_realisasi as $v): ?>
                            <?php $row = array_map("trim", (array)$v); ?>
                            <tr>
                                <td class="text-nowrap text-center autonum-posint"></td>
                                <td class="text-nowrap"><?= $v->nama_lokasi ?></td>
                                <td class="text-nowrap"><?= $v->nama_periode ?></td>
                                <td class="text-nowrap"><?= date("d-m-Y H:i:s", strtotime($v->tanggal_mulai)) ?></td>
                                <td class="text-nowrap"><?= date("d-m-Y H:i:s", strtotime($v->tanggal_selesai)) ?></td>
                                <td class="text-nowrap text-center">
                                    <h4 style="margin: 0;">
                                        <?= $v->off_user == "F" ? "<span class='label label-success'>YA</span>" : "<span class='label label-default'>TIDAK</span>" ?>
                                    </h4>
                                </td>
                                <td class="text-nowrap">
                                    <a class="btn btn-sm btn-warning" href="<?= site_url('ga/checklist/answer') . "/" . $v->id_checklist ?>" title="Isi Checklist"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
