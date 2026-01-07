<script type="text/javascript">
    var t_parameter, t_jadwal;
    var optGroupKaryawan = [];
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
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            ajax: {
                url: "<?= site_url('ga/checklist/list_paramater')?>",
                type: "POST",
                data: function(d) {
                    d.kode_periode = $("#kode_periode").val(),
                    d.kode_lokasi = $("#kode_lokasi").val()
                }
            },
            columns: [
                {
                    data: "urut",
                    class: "text-nowrap text-center autonum-posint"
                },
                {
                    data: "nama_parameter",
                },
                {
                    data: "nmdept",
                },
                {
                    data: "target_parameter",
                }
            ]
        });

        t_jadwal = $("#jadwal-list").DataTable({
            ordering: false,
            paging: false,
            searching: false
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
    <form action="<?= site_url('ga/checklist/add') ?>" id="formChecklist" name="form" role="form" method="post">
        <div class="col-xs-5">
            <div class="box">
                <div class="box-header">
                    <legend>Setup Jadwal</legend>
                </div>
                <div class="box-body">
                    <div class="form-horizontal">
                        <input type="hidden" id="min" name="min">
                        <input type="hidden" id="max" name="max">
                        <div class="form-group">
                            <label class="col-lg-3">Periode</label>
                            <div class="col-lg-9">
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
                                    }).on('change', function() {
                                        t_parameter.ajax.reload();
                                        changeTanggal();
                                        changeKaryawan();
                                    });
                                    $("#kode_periode").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Lokasi</label>
                            <div class="col-lg-9">
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
                                    }).on('change', function() {
                                        t_parameter.ajax.reload();
                                        changeTanggal();
                                        changeKaryawan();
                                    });
                                    $("#kode_lokasi").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Tanggal</label>
                            <div class="col-lg-9">
                                <input type="input" id="tanggal" name="tanggal" class="form-control input-sm" readonly required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Penanggungjawab</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="nik" name="nik[]" placeholder="--- PENANGGUNGJAWAB ---" multiple required>
                                    <option value="" class=""></option>
                                </select>
                                <script type="text/javascript">
                                    $('#nik').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'nik',
                                        searchField: ['nik', 'nmlengkap'],
                                        sortField: [{field: 'nmdept'}, {field: 'nmlengkap'}],
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
                                    $("#nik").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <a id="generateBtn" class="btn btn-info pull-right" onclick="generateJadwal()"><i class="fa fa-refresh"></i>&nbsp; Generate Jadwal</a>
                            <a id="setupBtn" class="btn btn-warning pull-right" onclick="setupJadwal()" style="display: none;"><i class="fa fa-wrench"></i>&nbsp; Setup Jadwal</a>
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
                                    <th>Target</th>
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
                                <tr style="display: none;">
                                    <th rowspan="3" style="vertical-align: middle; width: 1%;">No</th>
                                    <th style="vertical-align: middle;">Penanggungjawab</th>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle; width: 1%;" class="remove-th-jadwal">No</th>
                                    <th colspan="4" class="remove-th-jadwal">Penanggungjawab</th>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle;">NIK</th>
                                    <th style="vertical-align: middle;">Nama Karyawan</th>
                                    <th style="vertical-align: middle;">Departemen</th>
                                    <th style="vertical-align: middle; width: 35px;"><input type="checkbox" class="all" value="all" onclick="checkJadwal(this)"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <a id="simpanBtn" class="btn btn-success pull-right" onclick="saveJadwal()" style="display: none; margin: 10px;"><i class="fa fa-save"></i>&nbsp; Simpan Jadwal</a>
                            <a id="simpanBtnDis" class="btn btn-success pull-right" style="cursor: not-allowed; margin: 10px;" disabled><i class="fa fa-save"></i>&nbsp; Simpan Jadwal</a>
                            <a class="btn btn-default pull-right" href="<?= site_url('ga/checklist/jadwal') ?>" style="margin: 10px;"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function formatDate(d) {
        var day = String(d.getDate())

        if(day.length == 1) {
            day = '0' + day
        }
        var month = String((d.getMonth()+1))
        if(month.length == 1) {
            month = '0' + month
        }
        return d.getFullYear() + '-' + month + "-" + day;
    }

    function changeKaryawan() {
        $.ajax({
            url: HOST_URL + "ga/checklist/list_karyawan",
            type: "post",
            data: {
                kode_periode: $('#kode_periode').val(),
                kode_lokasi: $('#kode_lokasi').val()
            },
            dataType: 'json',
            success: function(data) {
                $('#nik')[0].selectize.clearOptions();
                for(var i = 0; i < data.length; i++) {
                    $('#nik')[0].selectize.addOption({
                        nik: data[i].nik.trim(),
                        nmlengkap: data[i].nmlengkap.trim(),
                        bag_dept: data[i].bag_dept.trim(),
                        nmdept: data[i].nmdept.trim()
                    });
                }
            }
        });
    }

    function changeTanggal() {
        $("#tanggal").datepicker("destroy");
        $("#tanggal").prop('readonly', true);
        $("#tanggal").val('');
        var id_checklist = 0;
        var kode_periode = $('#kode_periode').val();
        var kode_lokasi = $('#kode_lokasi').val();

        if(kode_periode != "" && kode_lokasi != "") {
            $.ajax({
                url: HOST_URL + "ga/checklist/list_tanggal",
                type: "post",
                data: {
                    id_checklist: id_checklist,
                    kode_periode: kode_periode,
                    kode_lokasi: kode_lokasi
                },
                dataType: 'json',
                success: function(data) {
                    $("#tanggal").prop('readonly', false);

                    if($('#kode_periode').val() == "JAM") {
                        $('#tanggal').datepicker({
                            format: "dd-mm-yyyy",
                            todayBtn: true,
                            todayHighlight: true,
                            viewMode: "days",
                            minViewMode: "days",
                            orientation: "bottom",
                            autoclose: true,
                            language: 'id',
                            beforeShowDay: function(date) {
                                if(formatDate(date), data.findIndex(x => x.tanggal_mulai == formatDate(date)) >= 0) {
                                    return false;
                                }
                                return true;
                            }
                        });
                    } else if($('#kode_periode').val() == "HARI") {
                        $('#tanggal').datepicker({
                            format: "mm-yyyy",
                            todayBtn: true,
                            todayHighlight: true,
                            viewMode: "months",
                            minViewMode: "months",
                            orientation: "bottom",
                            autoclose: true,
                            language: 'id',
                            beforeShowMonth: function(date) {
                                if(formatDate(date), data.findIndex(x => x.tanggal_mulai == formatDate(date)) >= 0) {
                                    return false;
                                }
                                return true;
                            }
                        });
                    } else if($('#kode_periode').val() == "BULAN") {
                        $('#tanggal').datepicker({
                            format: "yyyy",
                            todayBtn: true,
                            todayHighlight: true,
                            viewMode: "years",
                            minViewMode: "years",
                            orientation: "bottom",
                            autoclose: true,
                            language: 'id',
                            beforeShowYear: function(date) {
                                if(formatDate(date), data.findIndex(x => x.tanggal_mulai == formatDate(date)) >= 0) {
                                    return false;
                                }
                                return true;
                            }
                        });
                    } else if($('#kode_periode').val() == "TAHUN") {
                        $('#tanggal').datepicker({
                            format: "yyyy",
                            todayBtn: true,
                            todayHighlight: true,
                            viewMode: "decades",
                            minViewMode: "decades",
                            orientation: "bottom",
                            autoclose: true,
                            language: 'id',
                            beforeShowDecade: function(date) {
                                if(formatDate(date), data.findIndex(x => x.tanggal_mulai == formatDate(date)) >= 0) {
                                    return false;
                                }
                                return true;
                            }
                        });
                    }
                }
            });
        }
    }

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
        $('#kode_periode')[0].selectize.enable();
        $('#kode_lokasi')[0].selectize.enable();
        $("#tanggal").prop('disabled', false);
        $('#nik')[0].selectize.enable();
        $('#setupBtn').hide();
        $('#generateBtn').show();
        $('#simpanBtn').hide();
        $('#simpanBtnDis').show();
    }

    function generateJadwal() {
        var applicationForm = document.getElementById('formChecklist');
        if(applicationForm.checkValidity()) {
            $('#kode_periode')[0].selectize.disable();
            $('#kode_lokasi')[0].selectize.disable();
            $("#tanggal").prop('disabled', true);
            $('#nik')[0].selectize.disable();
            $('#generateBtn').hide();
            $('#setupBtn').show();
            $('#simpanBtnDis').hide();
            $('#simpanBtn').show();

            $('#jadwal-list thead tr:first-child').hide();
            t_jadwal.clear().draw();
            t_jadwal.destroy();
            $(".add-jadwal").remove();
            $(".remove-th-jadwal").remove();
            $('#jadwal-list thead tr:first-child th:nth-child(2)').attr('rowspan', '2');
            $('#jadwal-list thead tr:first-child th:nth-child(2)').attr('colspan', '4');

            var kode_periode = $("#kode_periode").val();
            var tanggal = $("#tanggal").val();
            var nik = $("#nik").val();
            var min = 0, max = 0, tanggalHead = tanggal;

            var nik_info = [];
            $.each(nik, function(index, attribute) {
                var newElement = {};
                newElement["nik"] = attribute.trim();
                newElement["nmlengkap"] = $('#nik')[0].selectize.options[attribute.trim()].nmlengkap.trim();
                newElement["bag_dept"] = $('#nik')[0].selectize.options[attribute.trim()].bag_dept.trim();
                newElement["nmdept"] = $('#nik')[0].selectize.options[attribute.trim()].nmdept.trim();
                nik_info.push(newElement);
            });

            $('#jadwal-list thead tr:first-child').show();
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
                tanggalHead = min + "-" + max;
            }
            $('#min').val(min);
            $('#max').val(max);

            for(let i = min; i <= max; i++) {
                $('#jadwal-list thead tr:nth-child(2)').append("<th class='add-jadwal' style='vertical-align: middle; cursor: pointer; background-color: white;' onclick='offJadwal(this, \"j" + i + "\")'>" + i.toString().padStart(2, '0') + "<input type='hidden' id='j" + i + "' name='off[]' value='F'></th>");
                $('#jadwal-list thead tr:nth-child(3)').append("<th class='add-jadwal' style='vertical-align: middle;'><input type='checkbox' class='all j" + i + "' value='j" + i + "' onclick='checkJadwal(this)'></th>");
            }
            $('#jadwal-list thead tr:first-child').append("<th class='add-jadwal' colspan='" + (max - min) + "'>" + tanggalHead + "</th>");

            var columnJadwal = [
                {
                    data: "no",
                    class: "text-nowrap text-center autonum-posint",
                    style: "width: 1%;",
                },
                {
                    data: "nik",
                    class: "text-nowrap",
                },
                {
                    data: "nmlengkap",
                    class: "text-nowrap"
                },
                {
                    data: "nmdept",
                    class: "text-nowrap",
                },
                {
                    data: "elnik",
                    class: "text-nowrap text-center",
                }
            ];
            for(let i = min; i <= max; i++) {
                var newElement = {};
                newElement["data"] = "el" + i;
                newElement["class"] = "text-nowrap text-center";
                newElement["style"] = "width: 35px;";
                columnJadwal.push(newElement);
            }

            t_jadwal = $("#jadwal-list").DataTable({
                ordering: false,
                paging: false,
                searching: false,
                ajax: {
                    url: "<?= site_url('ga/checklist/list_jadwal')?>",
                    type: "POST",
                    data: function(d) {
                        d.nik_info = nik_info,
                        d.min = min,
                        d.max = max
                    }
                },
                columns: columnJadwal
            });
        } else {
            applicationForm.reportValidity();
        }
    }

    function saveJadwal() {
        if(confirm('Apakah Anda Yakin ?')) {
            $('#kode_periode')[0].selectize.enable();
            $('#kode_lokasi')[0].selectize.enable();
            $("#tanggal").prop('disabled', false);
            $('#nik')[0].selectize.enable();
            $('#formChecklist').submit();
        }
    }
</script>
