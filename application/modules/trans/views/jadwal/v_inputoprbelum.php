<legend xmlns="http://www.w3.org/1999/html"><?= $title ?></legend>
<?= $message ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <form action="<?= site_url('trans/jadwal_new/simpan_oprdtljadwal') ?>" method="post">
                <div class="box-body">
                    <div class="row">
                        <div class="form-body">
                            <div class="form-group input-sm ">
                                <label class="label-form col-sm-3">Periode</label>
                                <div class="col-sm-5">
                                    <input type="input" id="periode" name="periode" class="form-control input-sm" value="<?= date('m-Y') ?>" onchange="changePeriode();" required>
                                </div>
                            </div>
                            <div class="form-group input-sm">
                                <label class="control-label col-md-3">Karyawan</label>
                                <div class="col-md-5">
                                    <select class="form-control input-sm" id="nik" name="nik" placeholder="--- KARYAWAN ---" required>
                                        <option value="" class=""></option>
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
                                        }).on('change', function() {
                                            if($('#nik').val() != '') {
                                                var data = $('#nik')[0].selectize.options[$('#nik').val()];
                                                $('#kdregu_show')[0].selectize.setValue(data.kdregu);
                                                $('#kdregu').val(data.kdregu);
                                            } else {
                                                $('#kdregu_show')[0].selectize.setValue("");
                                                $('#kdregu').val(null);
                                            }
                                        });
                                        $("#nik").addClass("selectize-hidden-accessible");
                                    </script>
                                </div>
                            </div>
                            <div class="form-group input-sm">
                                <label class="control-label col-md-3">Regu Karyawan</label>
                                <div class="col-md-5">
                                    <input type="hidden" class="form-control" id="kdregu" name="kdregu">
                                    <select class="form-control input-sm" id="kdregu_show" placeholder="--- REGU KARYAWAN ---" disabled>
                                        <option value="" class=""></option>
                                        <?php foreach($list_regu as $v): ?>
                                            <?php $row = array_map('trim', (array)$v); ?>
                                            <option value="<?= $row['kdregu'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#kdregu_show').selectize({
                                            plugins: ['hide-arrow', 'selectable-placeholder'],
                                            valueField: 'kdregu',
                                            labelField: 'nmregu',
                                            searchField: ['nmregu'],
                                            sortField: 'nmregu',
                                            options: [],
                                            create: false,
                                            initData: true
                                        });
                                        $("#kdregu_show").addClass("selectize-hidden-accessible");
                                    </script>
                                </div>
                            </div>
                        </div>
                        <?php for($i = 1; $i <= 31; $i++): ?>
                            <div class="form-group input-sm tanggal<?= $i ?>">
                                <label class="label-form col-sm-3">Tanggal <?= $i ?></label>
                                <div class="col-sm-5">
                                    <select class="form-control input-sm" id="tgl<?= $i ?>" name="tgl<?= $i ?>" placeholder="--- TANGGAL <?= $i ?> ---" required>
                                        <option value="" class=""></option>
                                        <option value="OFF" selected>OFF</option>
                                        <?php foreach($list_jamkerja as $v): ?>
                                            <?php $row = array_map('trim', (array)$v); ?>
                                            <option value="<?= $row['kdjam_kerja'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#tgl<?= $i ?>').selectize({
                                            valueField: 'kdjam_kerja',
                                            labelField: 'nmjam_kerja',
                                            searchField: ['nmjam_kerja'],
                                            sortField: 'nmjam_kerja',
                                            options: [],
                                            create: false,
                                            initData: true
                                        });
                                        $("#tgl<?= $i ?>").addClass("selectize-hidden-accessible");
                                    </script>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-success pull-right" style="margin: 10px;">Simpan</button>
                        <a href="<?= site_url("trans/jadwal_new") ?>"  class="btn btn-default pull-right" style="margin: 10px;">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#periode').datepicker({
        format: "mm-yyyy",
        todayHighlight: true,
        viewMode: "months",
        minViewMode: "months",
        orientation: "bottom",
        autoclose: true,
        language: 'id'
    });

    function changePeriode() {
        var periode = $('#periode').val();
        var lastDay = new Date(periode.split("-")[1], periode.split("-")[0], 0).getDate();

        for(var i = 29; i <= 31; i++) {
            $('#tgl' + i)[0].selectize.setValue("OFF");
            $('#tgl' + i).prop('required', false);
            $('.tanggal' + i).hide();
        }
        for(var i = 29; i <= lastDay; i++) {
            $('#tgl' + i).prop('required', true);
            $('.tanggal' + i).show();
        }

        $('#nik')[0].selectize.clearOptions();
        $.ajax({
            url: HOST_URL + "trans/jadwal_new/get_karyawan",
            type: "post",
            data: {
                periode: periode
            },
            dataType: 'json',
            success: function (data) {
                for(var i = 0; i < data.length; i++) {
                    $('#nik')[0].selectize.addOption({
                        nik: data[i].nik.trim(),
                        nmlengkap: data[i].nmlengkap.trim(),
                        kdregu: data[i].kdregu.trim()
                    });
                }
            }
        });
    }

    $(function() {
        changePeriode();
    });
</script>
