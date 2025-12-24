<script type="text/javascript">
    var t_parameter, t_jadwal;
    var optGroupKaryawan = [];
    var nik_info = [];
    var dept =  jQuery.parseJSON('<?= json_encode($list_departemen) ?>');
    $.each(dept, function(index, attribute) {
        var newElement = {};
        newElement["bag_dept"] = attribute.kddept.trim();
        newElement["nmdept"] = attribute.nmdept.trim();
        optGroupKaryawan.push(newElement);
    });

    $(function() {
        t_parameter = $("#table-list").DataTable({
            ordering: false,
        });

        $('#kode_periode')[0].selectize.setValue('<?= $checklist->kode_periode ?>');
        $('#kode_lokasi')[0].selectize.setValue('<?= $checklist->kode_lokasi ?>');
        $('#nik')[0].selectize.setValue(JSON.parse('<?= json_encode($list_user) ?>'));

        var id_checklist = '<?= $checklist->id_checklist ?>';
        var kode_periode = $("#kode_periode").val();
        var tanggal = $("#tanggal").val();
        var nik = $("#nik").val();
        var min = 0, max = 0;

        $.each(nik, function(index, attribute) {
            var newElement = {};
            newElement["nik"] = attribute.trim();
            newElement["nmlengkap"] = $('#nik')[0].selectize.options[attribute.trim()].nmlengkap.trim();
            newElement["bag_dept"] = $('#nik')[0].selectize.options[attribute.trim()].bag_dept.trim();
            newElement["nmdept"] = $('#nik')[0].selectize.options[attribute.trim()].nmdept.trim();
            nik_info.push(newElement);
        });

        if(kode_periode == "JAM") {
            min = 0;
            max = 23;
        } else if(kode_periode == "HARI") {
            min = 1;
            max = new Date(tanggal.split("-")[1], parseInt(tanggal.split("-")[0]), 0).getDate();
        } else if(kode_periode == "BULAN") {
            min = 1;
            max = 12;
        } else if(kode_periode == "TAHUN") {
            min = tanggal;
            max = parseInt(tanggal) + 9;
        }

        t_jadwal = $("#jadwal-list").DataTable({
            ordering: false,
            paging: false,
            searching: false,
            ajax: {
                url: "<?= site_url('ga/checklist/list_jadwal_edit')?>",
                type: "POST",
                data: function(d) {
                    d.id_checklist = id_checklist,
                    d.nik_info = nik_info,
                    d.min = min,
                    d.max = max
                }
            },
            columnDefs: [
                {
                    class: "text-nowrap text-center autonum-posint",
                    style: "width: 1%;",
                    targets: 0
                },
                {
                    class: "text-nowrap",
                    targets: [1, 2, 3]
                },
                {
                    class: "text-nowrap text-center",
                    style: "width: 35px;",
                    targets: "_all"
                },
            ]
        });
    });
</script>

<style>
    thead tr th {
        text-align: center;
        text-transform: uppercase;
        white-space: nowrap;
    }

    thead tr th {
        padding-right: 8px !important;
    }
</style>

<legend><?= $title ?></legend>

<div class="row">
    <form action="<?= site_url('ga/checklist/edit') ?>" id="formChecklist" name="form" role="form" method="post">
        <div class="col-xs-5">
            <div class="box">
                <div class="box-header">
                    <legend>Setup Jadwal</legend>
                </div>
                <div class="box-body">
                    <div class="form-horizontal">
                        <input type="hidden" id="id_checklist" name="id_checklist" value="<?= $checklist->id_checklist ?>">
                        <div class="form-group">
                            <label class="col-lg-3">Periode</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="kode_periode" name="kode_periode" placeholder="--- PERIODE ---" disabled>
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
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Lokasi</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="kode_lokasi" name="kode_lokasi" placeholder="--- LOKASI ---" disabled>
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
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Tanggal</label>
                            <div class="col-lg-9">
                                <input type="input" id="tanggal" name="tanggal" class="form-control input-sm" value="<?= $checklist->tanggal ?>" readonly required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Penanggungjawab</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="nik" name="nik[]" placeholder="--- PENANGGUNGJAWAB ---" multiple disabled>
                                    <option value="" class=""></option>
                                    <?php foreach($list_karyawan as $v): ?>
                                        <?php $row = array_map('trim', (array)$v); ?>
                                        <option value="<?= $row['nik'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                                <script type="text/javascript">
                                    $('#nik').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'nik',
                                        searchField: ['nik', 'nmlengkap'],
                                        sortField: 'nmlengkap',
                                        options: [],
                                        create: false,
                                        initData: true,
                                        render: {
                                            option: function(item, escape) {
                                                return '' +
                                                    '<div class=\'row\'>' +
                                                        '<div class=\'col-md-3 text-nowrap\'>' + escape(item.nik) + '</div>' +
                                                        '<div class=\'col-md-9 text-nowrap\'>' + escape(item.nmlengkap) + '</div>' +
                                                    '</div>' +
                                                '';
                                            },
                                            item: function(item, escape) {
                                                return '' +
                                                    '<div>' +
                                                        escape(item.nik) + ' - ' +
                                                        escape(item.nmlengkap) +
                                                    '</div>'
                                                ;
                                            }
                                        }
                                    });
                                    $("#nik").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Tambah Penanggungjawab</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="nikadd" name="nikadd[]" placeholder="--- PENANGGUNGJAWAB ---" multiple disabled>
                                    <option value="" class=""></option>
                                    <?php foreach($list_karyawan as $v): ?>
                                        <?php $row = array_map('trim', (array)$v); ?>
                                        <?php if(!in_array($row['nik'], $list_user)): ?>
                                            <option value="<?= $row['nik'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <script type="text/javascript">
                                    $('#nikadd').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'nik',
                                        searchField: ['nik', 'nmlengkap'],
                                        sortField: 'nmlengkap',
                                        optgroupField: 'bag_dept',
                                        optgroupValueField: "bag_dept",
                                        optgroupLabelField: "nmdept",
                                        options: [],
                                        optgroups: optGroupKaryawan,
                                        create: false,
                                        initData: true,
                                        render: {
                                            option: function(item, escape) {
                                                return '' +
                                                    '<div class=\'row\'>' +
                                                    '<div class=\'col-md-3 text-nowrap\'>' + escape(item.nik) + '</div>' +
                                                    '<div class=\'col-md-9 text-nowrap\'>' + escape(item.nmlengkap) + '</div>' +
                                                    '</div>' +
                                                '';
                                            },
                                            item: function(item, escape) {
                                                return '' +
                                                    '<div>' +
                                                    escape(item.nik) + ' - ' +
                                                    escape(item.nmlengkap) +
                                                    '</div>'
                                                    ;
                                            }
                                        }
                                    });
                                    $("#nikadd").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <a id="generateBtn" class="btn btn-info pull-right" onclick="generateJadwal()" style="display: none;"><i class="fa fa-refresh"></i>&nbsp; Generate Jadwal</a>
                            <a id="setupBtn" class="btn btn-warning pull-right" onclick="setupJadwal()"><i class="fa fa-wrench"></i>&nbsp; Setup Jadwal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-7">
            <div class="box">
                <div class="box-header">
                    <legend>Parameter Checklist</legend>
                </div>
                <div class="box-body">
                    <div class="form-horizontal">
                        <table id="table-list" class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th style="width: 1%;">No</th>
                                    <th>Parameter</th>
                                    <th>Departemen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list_parameter as $v): ?>
                                    <tr>
                                        <td class="text-nowrap text-center autonum-posint"><?= $v->urutan ?></td>
                                        <td><?= $v->nama_parameter ?></td>
                                        <td><?= $v->nmdept ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <legend>Jadwal Checklist</legend>
                </div>
                <div class="box-body">
                    <div class="form-horizontal" style="overflow-x: auto;">
                        <table id="jadwal-list" class="table table-bordered table-responsive table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="3" style="vertical-align: middle; width: 1%;">No</th>
                                    <th rowspan="2" colspan="4">Penanggungjawab</th>
                                    <th colspan="<?= sizeof($list_tanggal) ?>"><?= $checklist->tanggal ?></th>
                                </tr>
                                <tr>
                                    <?php foreach($list_tanggal as $v): ?>
                                        <?php
                                            $label = $i = "";
                                            switch($checklist->kode_periode) {
                                                case "JAM":
                                                    $label = date("H", strtotime($v->tanggal_mulai));
                                                    $i = date("G", strtotime($v->tanggal_mulai));
                                                    break;
                                                case "HARI":
                                                    $label = date("d", strtotime($v->tanggal_mulai));
                                                    $i = date("j", strtotime($v->tanggal_mulai));
                                                    break;
                                                case "BULAN":
                                                    $label = date("m", strtotime($v->tanggal_mulai));
                                                    $i = date("n", strtotime($v->tanggal_mulai));
                                                    break;
                                                case "TAHUN":
                                                    $label = date("Y", strtotime($v->tanggal_mulai));
                                                    $i = date("Y", strtotime($v->tanggal_mulai));
                                                    break;
                                            }
                                        ?>
                                        <?php if($v->tanggal_mulai > date("Y-m-d H:i:s")): ?>
                                            <th style="width: 35px; vertical-align: middle; cursor: pointer;<?= $v->off == 'T' ? ' background-color: red; color: white;' : ' background-color: white;' ?>" onclick='offJadwal(this, "j<?= $i ?>")'><?= $label ?><input type="hidden" id="j<?= $i ?>" name="off[]" value="<?= $v->off ?>"></th>
                                        <?php else: ?>
                                            <th style="width: 35px; vertical-align: middle;<?= $v->off == 'T' ? ' background-color: red; color: white;' : ' background-color: white;' ?>"><?= $label ?><input type="hidden" id="j<?= $i ?>" name="off[]" value="<?= $v->off ?>"></th>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle;">NIK</th>
                                    <th style="vertical-align: middle;">Nama Karyawan</th>
                                    <th style="vertical-align: middle;">Departemen</th>
                                    <th style="vertical-align: middle; width: 35px;"><input type="checkbox" class="all label-check" value="all" onclick="checkJadwal(this)"></th>
                                    <?php foreach($list_tanggal as $v): ?>
                                        <?php
                                            $i = "";
                                            $dis = $v->tanggal_mulai < date("Y-m-d H:i:s") ? "disabled" : "";
                                            switch($checklist->kode_periode) {
                                                case "JAM":
                                                    $i = date("G", strtotime($v->tanggal_mulai));
                                                    break;
                                                case "HARI":
                                                    $i = date("j", strtotime($v->tanggal_mulai));
                                                    break;
                                                case "BULAN":
                                                    $i = date("n", strtotime($v->tanggal_mulai));
                                                    break;
                                                case "TAHUN":
                                                    $i = date("Y", strtotime($v->tanggal_mulai));
                                                    break;
                                            }
                                        ?>
                                        <th style="vertical-align: middle;"><input type="checkbox" class="all label-check j<?= $i ?>" value="j<?= $i ?>" onclick="checkJadwal(this)" <?= $dis ?>></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <a id="simpanBtn" class="btn btn-success pull-right" onclick="saveJadwal()" style="margin: 10px;"><i class="fa fa-save"></i>&nbsp; Simpan Jadwal</a>
                            <a id="simpanBtnDis" class="btn btn-success pull-right" style="display: none; cursor: not-allowed; margin: 10px;" disabled><i class="fa fa-save"></i>&nbsp; Simpan Jadwal</a>
                            <a class="btn btn-default pull-right" href="<?= site_url('ga/checklist/jadwal') ?>" style="margin: 10px;"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function checkJadwal(that) {
        $('.' + that.value).not("[disabled]").prop('checked', that.checked);
    }

    function offJadwal(that, value) {
        var color = $(that).css("background-color");

        if(color == "rgb(255, 255, 255)") {
            $(that).css("background-color", "red");
            $(that).css("color", "white");
            $('.' + value).prop('checked', false);
            $('.' + value).prop('disabled', true);
            $('#' + value).val('T');
        } else {
            $(that).css("background-color", "white");
            $(that).css("color", "black");
            $('.' + value).prop('disabled', false);
            $('#' + value).val('F');
        }
    }

    function setupJadwal() {
        $('#nikadd')[0].selectize.enable();
        $('#setupBtn').hide();
        $('#generateBtn').show();
        $('#simpanBtn').hide();
        $('#simpanBtnDis').show();
    }

    function generateJadwal() {
        $('#nikadd')[0].selectize.disable();
        $('#generateBtn').hide();
        $('#setupBtn').show();
        $('#simpanBtnDis').hide();
        $('#simpanBtn').show();
        $('.label-check').not("[disabled]").prop('checked', false);

        var nikadd = $("#nikadd").val();
        $.each(nikadd, function(index, attribute) {
            var newElement = {};
            newElement["nik"] = attribute.trim();
            newElement["nmlengkap"] = $('#nikadd')[0].selectize.options[attribute.trim()].nmlengkap.trim();
            newElement["bag_dept"] = $('#nikadd')[0].selectize.options[attribute.trim()].bag_dept.trim();
            newElement["nmdept"] = $('#nikadd')[0].selectize.options[attribute.trim()].nmdept.trim();
            nik_info.push(newElement);
        });

        t_jadwal.ajax.reload();
    }

    function saveJadwal() {
        if(confirm('Apakah Anda Yakin ?')) {
            $('#nikadd')[0].selectize.enable();
            $('#formChecklist').submit();
        }
    }
</script>
