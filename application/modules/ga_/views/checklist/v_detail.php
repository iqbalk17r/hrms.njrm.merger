<script type="text/javascript">
    var t_parameter, t_jadwal;
    var $nik, $tanggal_mulai = '';

    $(function() {
        t_parameter = $("#table-list").DataTable({
            ordering: false,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            ajax: {
                url: "<?= site_url('ga/checklist/list_paramater_detail')?>",
                type: "POST",
                data: function(d) {
                    d.id_checklist = '<?= $checklist->id_checklist ?>',
                    d.nik = $nik,
                    d.tanggal_mulai = $tanggal_mulai
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
                    targets: 4
                }
            ]
        });

        $('#kode_periode')[0].selectize.setValue('<?= $checklist->kode_periode ?>');
        $('#kode_lokasi')[0].selectize.setValue('<?= $checklist->kode_lokasi ?>');
        $('#nik')[0].selectize.setValue(JSON.parse('<?= json_encode($list_user) ?>'));

        var id_checklist = '<?= $checklist->id_checklist ?>';
        var kode_periode = $("#kode_periode").val();
        var tanggal = $("#tanggal").val();
        var nik = $("#nik").val();
        var min = 0, max = 0;

        var nik_info = [];
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
                url: "<?= site_url('ga/checklist/list_jadwal_detail')?>",
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
                    class: "text-nowrap text-center jadwal",
                    style: "width: 35px;",
                    targets: "_all"
                }
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

    td.jadwal {
        cursor: pointer;
    }
</style>

<legend><?= $title ?></legend>

<div class="row">
    <div class="col-xs-5">
        <div class="box">
            <div class="box-header">
                <legend>Setup Jadwal</legend>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
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
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-7">
        <div class="box">
            <div class="box-header">
                <legend>Parameter Checklist<span id="parameter-label"></span></legend>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <table id="table-list" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th style="width: 1%;">No</th>
                                <th>Parameter</th>
                                <th>Departemen</th>
                                <th>Target</th>
                                <th>Hasil</th>
                                <th>Realisasi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
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
                                <th rowspan="2" style="vertical-align: middle; width: 1%;">No</th>
                                <th colspan="3">Penanggungjawab</th>
                                <th colspan="<?= sizeof($list_tanggal) ?>"><?= $checklist->tanggal_label ?></th>
                            </tr>
                            <tr>
                                <th style="vertical-align: middle;">NIK</th>
                                <th style="vertical-align: middle;">Nama Karyawan</th>
                                <th style="vertical-align: middle;">Departemen</th>
                                <?php foreach($list_tanggal as $v): ?>
                                    <?php
                                        $label = "";
                                        switch($checklist->kode_periode) {
                                            case "JAM":
                                                $label = date("H", strtotime($v->tanggal_mulai));
                                                break;
                                            case "HARI":
                                                $label = date("d", strtotime($v->tanggal_mulai));
                                                break;
                                            case "BULAN":
                                                $label = date("m", strtotime($v->tanggal_mulai));
                                                break;
                                            case "TAHUN":
                                                $label = date("Y", strtotime($v->tanggal_mulai));
                                                break;
                                        }
                                    ?>
                                    <th style="width: 35px; vertical-align: middle;<?= $v->off == 'T' ? ' background-color: red; color: white;' : ' background-color: white;' ?>"><?= $label ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">KETERANGAN</h5>
                        <div class="col-sm-3">
                            <p class="card-text"><i class="fa fa-clock-o text-info"></i>&nbsp; ADA JADWAL DAN HARUS DIREALISASI</p>
                            <p class="card-text"><i class="fa fa-check text-success"></i>&nbsp; ADA JADWAL DAN SUDAH DIREALISASI</p>
                            <p class="card-text"><i class="fa fa-times text-danger"></i>&nbsp; ADA JADWAL TAPI TIDAK DIREALISASI</p>
                        </div>
                        <div class="col-sm-3">
                            <p class="card-text"><i class="fa fa-square-o"></i>&nbsp; TIDAK ADA JADWAL DAN BISA DIREALISASI</p>
                            <p class="card-text"><i class="fa fa-check-circle text-success"></i>&nbsp; TIDAK ADA JADWAL TAPI SUDAH DIREALISASI</p>
                            <p class="card-text"><i class="fa fa-minus text-warning"></i>&nbsp; TIDAK ADA JADWAL DAN TIDAK DIREALISASI</p>
                        </div>
                        <div class="col-sm-3">
                            <p class="card-text"><i class="fa fa-ban text-danger"></i>&nbsp; LIBUR</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <a class="btn btn-default pull-right" href="<?= site_url('ga/checklist/jadwal') ?>" style="margin: 10px;"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var $tdClick;
    $(document).ready(function() {
        setTimeout(function() {
            $("tr td.jadwal").each(function(i) {
                var off = $(this)[0].children[3].value;
                if(off == "T") {
                    $(this).css("cursor", "not-allowed");
                    $(this).css("background-color", "red");
                }
            });
        }, 500);
        $("#jadwal-list").on("click", "td.jadwal", function() {
            var nik = $(this)[0].children[1].value;
            var tanggal_mulai = $(this)[0].children[2].value;
            var off = $(this)[0].children[3].value;

            if(off == "F") {
                if($tdClick !== undefined) {
                    $tdClick.css("background-color", "unset");
                }
                if(nik == $nik && tanggal_mulai == $tanggal_mulai) {
                    $nik = "";
                    tanggal_mulai = "";
                } else {
                    $nik = nik;
                    $tanggal_mulai = tanggal_mulai;
                    $(this).css("background-color", "#c1c1c1");
                }
                t_parameter.ajax.reload();
                setTimeout(function() {
                    $('#parameter-label').html(t_parameter.data()[0][7])
                }, 500);
                $tdClick = $(this);
            }
        });
    });
</script>
