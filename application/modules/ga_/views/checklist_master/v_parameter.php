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
        $('#ed_kode_parameter').val(data.kode_parameter);
        $('#ed_kode_periode')[0].selectize.setValue(data.kode_periode);
        $('#ed_kode_lokasi')[0].selectize.setValue(data.kode_lokasi);
        $('#ed_kddept')[0].selectize.setValue(data.kddept.split(", "));
        AutoNumeric.set('#ed_urutan', data.urutan);
        $('#ed_nama_parameter').val(data.nama_parameter);
        $('#ed_target_parameter').val(data.target_parameter);
        $('#ed_hold').val(data.hold);
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
                <a class="btn btn-success" data-toggle="modal" data-target="#modal-add" style="margin: 10px;"><i class="fa fa-plus"></i>&nbsp; Input</a>
            </div>
            <div class="box-body">
                <table id="table-list" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Parameter</th>
                            <th>Periode</th>
                            <th>Lokasi</th>
                            <th style="width: 1%;">Urutan</th>
                            <th>Nama Parameter</th>
                            <th>Target</th>
                            <th>Departemen</th>
                            <th>Hold</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list_parameter as $v): ?>
                            <?php $row = array_map("trim", (array)$v); ?>
                            <tr>
                                <td class="text-nowrap text-center autonum-posint"></td>
                                <td class="text-nowrap"><?= $v->kode_parameter ?></td>
                                <td><?= $v->nama_periode ?></td>
                                <td><?= $v->nama_lokasi ?></td>
                                <td class="text-nowrap autonum-posint"><?= $v->urutan ?></td>
                                <td><?= $v->nama_parameter ?></td>
                                <td><?= $v->target_parameter ?></td>
                                <td><?= $v->nmdept ?></td>
                                <td><?= $v->hold == "T" ? "YA" : "TIDAK" ?></td>
                                <td class="text-nowrap">
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit" onclick='editModal(<?= json_encode($row, JSON_HEX_APOS) ?>)' title="Edit"><i class="fa fa-gear"></i></a>
                                    <?php if(is_null($v->used)): ?>
                                        <a class="btn btn-sm btn-danger" href="<?= site_url('ga/checklistmaster/hapus_parameter') . "/" . $v->kode_parameter ?>" onclick="return confirm('Anda Yakin Hapus <?= trim($v->kode_parameter) ?>?')" title="Hapus"><i class="fa fa-trash-o"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL INPUT PARAMETER -->
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Input Master Parameter</h4>
            </div>
            <form role="form" action="<?= site_url('ga/checklistmaster/add_parameter') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Periode</label>
                                <select class="form-control input-sm" id="kode_periode" name="kode_periode" placeholder="--- PERIODE ---" required>
                                    <option value="" class=""></option>
                                    <?php foreach($list_periode as $v): ?>
                                        <?php $row = array_map('trim', (array)$v); ?>
                                        <option value="<?= $row['kode_periode'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                                <script type="text/javascript">
                                    $('#kode_periode').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'kode_periode',
                                        labelField: 'nama_periode',
                                        searchField: ['nama_periode'],
                                        options: [],
                                        create: false,
                                        initData: true
                                    });
                                    $("#kode_periode").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                            <div class="form-group">
                                <label>Lokasi</label>
                                <select class="form-control input-sm" id="kode_lokasi" name="kode_lokasi" placeholder="--- LOKASI ---" required>
                                    <option value="" class=""></option>
                                    <?php foreach($list_lokasi as $v): ?>
                                        <?php $row = array_map('trim', (array)$v); ?>
                                        <option value="<?= $row['kode_lokasi'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                                <script type="text/javascript">
                                    $('#kode_lokasi').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'kode_lokasi',
                                        labelField: 'nama_lokasi',
                                        searchField: ['nama_lokasi'],
                                        sortField: 'nama_lokasi',
                                        options: [],
                                        create: false,
                                        initData: true
                                    });
                                    $("#kode_lokasi").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                            <div class="form-group">
                                <label>Departemen</label>
                                <select class="form-control input-sm" id="kddept" name="kddept[]" placeholder="--- DEPARTEMEN ---" multiple required>
                                    <option value="" class=""></option>
                                    <?php foreach($list_departemen as $v): ?>
                                        <?php $row = array_map('trim', (array)$v); ?>
                                        <option value="<?= $row['kddept'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                                <script type="text/javascript">
                                    $('#kddept').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'kddept',
                                        labelField: 'nmdept',
                                        searchField: ['nmdept'],
                                        sortField: 'nmdept',
                                        options: [],
                                        create: false,
                                        initData: true
                                    });
                                    $("#kddept").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="text" id="urutan" name="urutan" placeholder="Urutan" style="text-transform: uppercase;" class="form-control autonum-posint" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Parameter</label>
                                <textarea id="nama_parameter" name="nama_parameter" placeholder="Nama Parameter" style="text-transform: uppercase; resize: vertical;" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Target Parameter</label>
                                <input type="text" id="target_parameter" name="target_parameter" maxlength="30" placeholder="Target Parameter" style="text-transform: uppercase;" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>HOLD</label>
                                <select class="form-control input-sm" id="hold" name="hold" placeholder="--- HOLD ---" required>
                                    <option value="" class=""></option>
                                    <option value="F" selected>TIDAK</option>
                                    <option value="T">YA</option>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#hold').selectize({
                                            plugins: ['hide-arrow', 'selectable-placeholder'],
                                            options: [],
                                            create: false,
                                            initData: true
                                        });
                                        $("#hold").addClass("selectize-hidden-accessible");
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

<!-- MODAL EDIT PARAMETER -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Master Parameter</h4>
            </div>
            <form role="form" action="<?= site_url('ga/checklistmaster/edit_parameter') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Kode Parameter</label>
                                <input type="text" id="ed_kode_parameter" name="kode_parameter" placeholder="Kode Parameter" class="form-control" style="text-transform: uppercase;" maxlength="6" readonly>
                            </div>
                            <div class="form-group">
                                <label>Periode</label>
                                <select class="form-control input-sm" id="ed_kode_periode" name="kode_periode" placeholder="--- PERIODE ---" required>
                                    <option value="" class=""></option>
                                    <?php foreach($list_periode as $v): ?>
                                        <?php $row = array_map('trim', (array)$v); ?>
                                        <option value="<?= $row['kode_periode'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                                <script type="text/javascript">
                                    $('#ed_kode_periode').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'kode_periode',
                                        labelField: 'nama_periode',
                                        searchField: ['nama_periode'],
                                        options: [],
                                        create: false,
                                        initData: true
                                    });
                                    $("#ed_kode_periode").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                            <div class="form-group">
                                <label>Lokasi</label>
                                <select class="form-control input-sm" id="ed_kode_lokasi" name="kode_lokasi" placeholder="--- LOKASI ---" required>
                                    <option value="" class=""></option>
                                    <?php foreach($list_lokasi as $v): ?>
                                        <?php $row = array_map('trim', (array)$v); ?>
                                        <option value="<?= $row['kode_lokasi'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                                <script type="text/javascript">
                                    $('#ed_kode_lokasi').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'kode_lokasi',
                                        labelField: 'nama_lokasi',
                                        searchField: ['nama_lokasi'],
                                        sortField: 'nama_lokasi',
                                        options: [],
                                        create: false,
                                        initData: true
                                    });
                                    $("#ed_kode_lokasi").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                            <div class="form-group">
                                <label>Departemen</label>
                                <select class="form-control input-sm" id="ed_kddept" name="kddept[]" placeholder="--- DEPARTEMEN ---" multiple required>
                                    <option value="" class=""></option>
                                    <?php foreach($list_departemen as $v): ?>
                                        <?php $row = array_map('trim', (array)$v); ?>
                                        <option value="<?= $row['kddept'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                                <script type="text/javascript">
                                    $('#ed_kddept').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'kddept',
                                        labelField: 'nmdept',
                                        searchField: ['nmdept'],
                                        sortField: 'nmdept',
                                        options: [],
                                        create: false,
                                        initData: true
                                    });
                                    $("#ed_kddept").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="text" id="ed_urutan" name="urutan" placeholder="Urutan" style="text-transform: uppercase;" class="form-control autonum-posint" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Parameter</label>
                                <textarea id="ed_nama_parameter" name="nama_parameter" placeholder="Nama Parameter" style="text-transform: uppercase; resize: vertical;" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Target Parameter</label>
                                <input type="text" id="ed_target_parameter" name="target_parameter" maxlength="30" placeholder="Target Parameter" style="text-transform: uppercase;" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>HOLD</label>
                                <select class="form-control input-sm" id="ed_hold" name="hold" placeholder="--- HOLD ---" required>
                                    <option value="" class=""></option>
                                    <option value="F">TIDAK</option>
                                    <option value="T">YA</option>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#hold').selectize({
                                            plugins: ['hide-arrow', 'selectable-placeholder'],
                                            options: [],
                                            create: false,
                                            initData: true
                                        });
                                        $("#hold").addClass("selectize-hidden-accessible");
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
