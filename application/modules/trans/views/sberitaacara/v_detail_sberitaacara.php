<style>
    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        cursor: default;
    }

    .selectize-input:after {
        display: none !important;
    }
</style>

<script type="text/javascript">
    $_saksi1 = '';
    $_saksi2 = '';
</script>

<legend><?= $title ?></legend>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Penanggung Jawab</label>
                            <select class="form-control input-sm" id="nik" name="nik" placeholder="--- PENANGGUNG JAWAB ---" disabled>
                                <option value="" class=""></option>
                                <?php foreach($list_karyawan as $v): ?>
                                    <?php $result = array_map('trim', $v); ?>
                                    <option value="<?= $v['nik'] ?>" data-data='<?= json_encode($result, JSON_HEX_APOS) ?>'></option>
                                <?php endforeach; ?>
                            </select>
                            <script type="text/javascript">
                                $('#nik').selectize({
                                    plugins: ['hide-arrow', 'selectable-placeholder'],
                                    valueField: 'nik',
                                    searchField: ['nik', 'nmlengkap'],
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
                                        $('#department').val(data.nmdept);
                                        $('#jabatan').val(data.nmjabatan);
                                        $('#atasan1').val(data.nik_atasan + ' - ' + data.nmatasan1);
                                        $('#atasan2').val(data.nik_atasan2 + ' - ' + data.nmatasan2);
                                        $('#alamattinggal').val(data.alamattinggal);
                                        $('#nohp1').val(data.nohp1);
                                        $('#email').val(data.email);
                                    } else {
                                        $('#department').val('');
                                        $('#jabatan').val('');
                                        $('#atasan1').val('');
                                        $('#atasan2').val('');
                                        $('#alamattinggal').val('');
                                        $('#nohp1').val('');
                                        $('#email').val('');
                                    }
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <label>Departemen</label>
                            <input type="text" class="form-control" id="department" name="department" placeholder="DEPARTEMEN" disabled>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="JABATAN" disabled>
                        </div>
                        <div class="form-group">
                            <label>Atasan 1</label>
                            <input type="text" class="form-control" id="atasan1" name="atasan1" placeholder="ATASAN 1" disabled>
                        </div>
                        <div class="form-group">
                            <label>Atasan 2</label>
                            <input type="text" class="form-control" id="atasan2" name="atasan2" placeholder="ATASAN 2" disabled>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" id="alamattinggal" name="alamattinggal" placeholder="ALAMAT" disabled style="resize: none;" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Kontak</label>
                            <input type="text" class="form-control" id="nohp1" name="nohp1" placeholder="KONTAK" disabled>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="EMAIL" disabled>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Dokumen</label>
                            <input type="text" class="form-control" value="<?= $dtl->docno ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Tanggal & Jam Kejadian</label>
                            <input type="text" class="form-control" id="docdate" name="docdate" placeholder="TANGGAL & JAM KEJADIAN" value="<?= date("d-m-Y H:i", strtotime($dtl->docdate)); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Perihal</label>
                            <input type="text" class="form-control" name="subjek" value="<?= $dtl->subjek ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Kepada</label>
                            <select class="form-control" id="todepartmen" name="todepartmen" placeholder="--- LAPORAN KEJADIAN ---" disabled>
                                <option value="" class=""></option>
                                <?php foreach($list_departmen as $v): ?>
                                    <?php $result = array_map('trim', $v);?>
                                    <option value="<?= $v['kddept'] ?>" data-data='<?= json_encode($result, JSON_HEX_APOS) ?>'></option>
                                <?php endforeach; ?>
                            </select>
                            <script type="text/javascript">
                                $('#todepartmen').selectize({
                                    plugins: ['hide-arrow', 'selectable-placeholder'],
                                    valueField: 'kddept',
                                    labelField: 'nmdept',
                                    searchField: ['nmdept'],
                                    options: [],
                                    create: false,
                                    initData: true
                                });
                                $("#todepartmen").addClass("selectize-hidden-accessible");
                            </script>
                        </div>
                        <div class="form-group">
                            <label>Laporan Kejadian</label>
                            <select class="form-control" id="laporan" name="laporan" placeholder="--- LAPORAN KEJADIAN ---" disabled>
                                <option value="" class=""></option>
                                <?php foreach($list_kejadian as $v): ?>
                                    <?php $result = array_map('trim', $v);?>
                                    <option value="<?= $v['kdkejadian'] ?>" data-data='<?= json_encode($result, JSON_HEX_APOS) ?>'></option>
                                <?php endforeach; ?>
                            </select>
                            <script type="text/javascript">
                                $('#laporan').selectize({
                                    plugins: ['hide-arrow', 'selectable-placeholder'],
                                    valueField: 'kdkejadian',
                                    labelField: 'nmkejadian',
                                    searchField: ['nmkejadian'],
                                    options: [],
                                    create: false,
                                    initData: true
                                });
                                $("#laporan").addClass("selectize-hidden-accessible");
                            </script>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Kejadian</label>
                            <textarea class="form-control" id="lokasi" name="lokasi" placeholder="LOKASI KEJADIAN" style=" resize: none;" rows="5" disabled><?= $dtl->lokasi ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Uraian Kejadian</label>
                            <textarea class="form-control" id="uraian" name="uraian" placeholder="URAIAN KEJADIAN" style=" resize: none;" rows="5" disabled><?= $dtl->uraian ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Solusi / Perbaikan</label>
                            <textarea class="form-control" id="solusi" name="solusi" placeholder="SOLUSI / PERBAIKAN" style=" resize: none;" rows="5" disabled><?= $dtl->solusi ?></textarea>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Apakah Ada Saksi?</label>
                            <select id="saksi" name="saksi" style="width: 100%;" class="form-control" disabled>
                                <option value="f">TIDAK</option>
                                <option value="t1">YA, ADA 1 SAKSI</option>
                                <option value="t2">YA, ADA 2 SAKSI</option>
                            </select>
                            <script type="text/javascript">
                                $('#saksi').selectize({
                                    plugins: ['hide-arrow'],
                                    options: [],
                                    create: false,
                                    initData: true
                                }).on('change', function() {
                                    $('.saksi01').hide();
                                    $('.saksi02').hide();
                                    document.getElementById("saksi1").required = false;
                                    document.getElementById("saksi2").required = false;

                                    if($('#saksi').val() == 't1') {
                                        $('.saksi01').show();
                                        document.getElementById("saksi1").required = true;
                                        if($_saksi2 !== '') {
                                            var nmlengkap = $('#saksi2')[0].selectize.options[$_saksi2].nmlengkap;
                                            $('#saksi1')[0].selectize.addOption({
                                                nik: $_saksi2,
                                                nmlengkap: nmlengkap
                                            });
                                        }
                                    } else if($('#saksi').val() == 't2') {
                                        $('.saksi01').show();
                                        $('.saksi02').show();
                                        document.getElementById("saksi1").required = true;
                                        document.getElementById("saksi2").required = true;
                                        $('#saksi2')[0].selectize.removeOption($('#saksi1').val());
                                        $('#saksi1')[0].selectize.removeOption($('#saksi2').val());
                                    }
                                });
                                $("#saksi").addClass("selectize-hidden-accessible");
                            </script>
                        </div>
                        <div class="form-group saksi01">
                            <label>Saksi 1</label>
                            <select class="form-control" name="saksi1" id="saksi1" placeholder="--- SAKSI 1 ---" disabled>
                                <option value="" class=""></option>
                                <?php foreach($list_karyawan as $v): ?>
                                    <?php $result = array_map('trim', $v); ?>
                                    <option value="<?= $v['nik'] ?>" data-data='<?= json_encode($result, JSON_HEX_APOS) ?>'></option>
                                <?php endforeach; ?>
                            </select>
                            <script type="text/javascript">
                                $('#saksi1').selectize({
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
                                    if($('#saksi1').val() === $('#saksi2').val()) {
                                        $_saksi2 = '';
                                    }
                                    $('#saksi2')[0].selectize.removeOption($('#saksi1').val());
                                    if($_saksi1 !== '') {
                                        var nmlengkap = $('#saksi1')[0].selectize.options[$_saksi1].nmlengkap;
                                        $('#saksi2')[0].selectize.addOption({
                                            nik: $_saksi1,
                                            nmlengkap: nmlengkap
                                        });
                                    }
                                    $_saksi1 = $('#saksi1').val();
                                });
                                $("#saksi1").addClass("selectize-hidden-accessible");
                            </script>
                        </div>
                        <div class="form-group saksi02">
                            <label>Saksi 2</label>
                            <select class="form-control" name="saksi2" id="saksi2" placeholder="--- SAKSI 2 ---" disabled>
                                <option value="" class=""></option>
                                <?php foreach($list_karyawan as $v): ?>
                                    <?php $result = array_map('trim', $v); ?>
                                    <option value="<?= $v['nik'] ?>" data-data='<?= json_encode($result, JSON_HEX_APOS) ?>'></option>
                                <?php endforeach; ?>
                            </select>
                            <script type="text/javascript">
                                $('#saksi2').selectize({
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
                                    $('#saksi1')[0].selectize.removeOption($('#saksi2').val());
                                    if($_saksi2 !== '') {
                                        var nmlengkap = $('#saksi2')[0].selectize.options[$_saksi2].nmlengkap;
                                        $('#saksi1')[0].selectize.addOption({
                                            nik: $_saksi2,
                                            nmlengkap: nmlengkap
                                        });
                                    }
                                    $_saksi2 = $('#saksi2').val();
                                });
                                $("#saksi2").addClass("selectize-hidden-accessible");
                            </script>
                        </div>
                        <?php if($dtl->peringatan != ''): ?>
                            <div class="form-group">
                                <label>Apakah Perlu Surat Peringatan?</label>
                                <select id="peringatan" name="peringatan" style="width: 100%;" class="form-control" disabled>
                                    <option value="n">TIDAK</option>
                                    <option value="y">YA</option>
                                </select>
                                <script type="text/javascript">
                                    $('#peringatan').selectize({
                                        plugins: ['hide-arrow'],
                                        options: [],
                                        create: false,
                                        initData: true
                                    }).on('change', function() {
                                        $('.tindakan').hide();
                                        $('.tindaklanjut').hide();
                                        document.getElementById("tindakan").required = false;
                                        document.getElementById("tindaklanjut").required = false;

                                        if($('#peringatan').val() == 'y') {
                                            $('.tindakan').show();
                                            document.getElementById("tindakan").required = true;
                                        } else if($('#peringatan').val() == 'n') {
                                            $('.tindaklanjut').show();
                                            document.getElementById("tindaklanjut").required = true;
                                        }
                                    });
                                    $("#peringatan").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                            <div class="form-group tindakan">
                                <label>Tindakan</label>
                                <select class="form-control" name="tindakan" id="tindakan" placeholder="--- TINDAKAN ---" disabled>
                                    <option value="" class=""></option>
                                    <?php foreach($list_tindakan as $v): ?>
                                        <?php $result = array_map('trim', $v); ?>
                                        <option value="<?= $v['docno'] ?>" data-data='<?= json_encode($result, JSON_HEX_APOS) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                                <script type="text/javascript">
                                    $('#tindakan').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'docno',
                                        labelField: 'docname',
                                        searchField: ['docname'],
                                        options: [],
                                        create: false,
                                        initData: true
                                    });
                                    $("#tindakan").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                            <div class="form-group tindaklanjut">
                                <label>Tindaklanjut</label>
                                <textarea class="form-control zz" id="tindaklanjut" name="tindaklanjut" placeholder="TINDAKLANJUT" style="text-transform: uppercase; resize: none;" rows="5" disabled><?= $dtl->tindaklanjut ?></textarea>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <a href="<?php echo site_url('trans/sberitaacara') ?>" class="btn btn-default" style="margin: 10px 5px;" type="button">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#nik')[0].selectize.setValue("<?= trim($dtl->nik) ?>");
    $('#laporan')[0].selectize.setValue("<?= trim($dtl->laporan) ?>");
    $('#todepartmen')[0].selectize.setValue("<?= trim($dtl->todepartmen) ?>");
    $('#saksi')[0].selectize.setValue("<?= trim($dtl->saksi) ?>");
    $('#saksi1')[0].selectize.setValue("<?= trim($dtl->saksi1) ?>");
    $('#saksi2')[0].selectize.setValue("<?= trim($dtl->saksi2) ?>");
    $('#peringatan')[0].selectize.setValue("<?= trim($dtl->peringatan) ?>");
    $('#tindakan')[0].selectize.setValue("<?= trim($dtl->tindakan) ?>");
</script>
