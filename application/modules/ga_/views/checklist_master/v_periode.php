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

    function editModal(data) {
        $('#ed_kode_periode').val(data.kode_periode);
        $('#ed_nama_periode').val(data.nama_periode);
        $('#ed_hold')[0].selectize.setValue(data.hold);
    }
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
            </div>
            <div class="box-body">
                <table id="table-list" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Periode</th>
                            <th>Nama Periode</th>
                            <th>Hold</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list_periode as $v): ?>
                            <?php $row = array_map("trim", (array)$v); ?>
                            <tr>
                                <td class="text-nowrap text-center autonum-posint"></td>
                                <td class="text-nowrap"><?= $v->kode_periode ?></td>
                                <td><?= $v->nama_periode ?></td>
                                <td><?= $v->hold == "T" ? "YA" : "TIDAK" ?></td>
                                <td class="text-nowrap">
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit" onclick='editModal(<?= json_encode($row, JSON_HEX_APOS) ?>)' title="Edit"><i class="fa fa-gear"></i></a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT PERIODE -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Master Periode</h4>
            </div>
            <form role="form" action="<?= site_url('ga/checklistmaster/edit_periode') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Kode Periode</label>
                                <input type="text" id="ed_kode_periode" name="kode_periode" placeholder="Kode Periode" class="form-control" style="text-transform: uppercase;" maxlength="6" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Periode</label>
                                <input type="text" id="ed_nama_periode" name="nama_periode" placeholder="Nama Periode" maxlength="30" style="text-transform: uppercase;" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>HOLD</label>
                                <select class="form-control input-sm" id="ed_hold" name="hold" placeholder="--- HOLD ---" required>
                                    <option value="" class=""></option>
                                    <option value="F">TIDAK</option>
                                    <option value="T">YA</option>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#ed_hold').selectize({
                                            plugins: ['hide-arrow', 'selectable-placeholder'],
                                            options: [],
                                            create: false,
                                            initData: true
                                        });
                                        $("#ed_hold").addClass("selectize-hidden-accessible");
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp; Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
