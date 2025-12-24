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
            <div class="box-header">
                <a class="btn btn-success" href="<?= site_url('ga/checklist/input') ?>" style="margin: 10px;"><i class="fa fa-plus"></i>&nbsp; Input</a>
            </div>
            <div class="box-body">
                <table id="table-list" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lokasi</th>
                            <th>Periode</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list_jadwal as $v): ?>
                            <?php $row = array_map("trim", (array)$v); ?>
                            <tr>
                                <td class="text-nowrap text-center autonum-posint"></td>
                                <td class="text-nowrap"><?= $v->nama_lokasi ?></td>
                                <td class="text-nowrap"><?= $v->nama_periode ?></td>
                                <td class="text-nowrap"><?= date("d-m-Y", strtotime($v->tanggal_mulai)) ?></td>
                                <td class="text-nowrap"><?= date("d-m-Y", strtotime($v->tanggal_selesai)) ?></td>
                                <td class="text-nowrap">
                                    <a class="btn btn-sm btn-default" href="<?= site_url('ga/checklist/detail') . "/" . $v->id_checklist ?>" title="Detail"><i class="fa fa-th-list"></i></a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
