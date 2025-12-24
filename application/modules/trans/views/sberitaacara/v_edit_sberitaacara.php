<style>
    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        cursor: default;
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
            <form action="<?php echo site_url('trans/sberitaacara/saveEntry')?>" method="post" id="formBeritaAcara" enctype="multipart/form-data" role="form">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="hidden" class="form-control" id="type" name="type" value="<?= $type ?>">
                            <input type="hidden" class="form-control" id="docno" name="docno" value="<?= $dtl->docno ?>">
                            <div class="form-group">
                                <label>Pihak Terlapor?</label>
                                <select id="category" name="category" style="width: 100%;" class="form-control" placeholder="--- PIHAK TERLAPOR? ---" required>
                                    <option value="<?= $dtl->category ?>"><?= strtoupper($dtl->category) ?></option>
                                </select>
                                <script type="text/javascript">
                                    $('#category').selectize({
                                        plugins: ['hide-arrow'],
                                        options: [],
                                        create: false,
                                        initData: true
                                    }).on('change', function() {
                                        if($('#category').val() == 'internal') {
                                            $("#internal").removeClass("hide");
                                            $("#external").addClass("hide");
                                            document.getElementById("nik").required = true;
                                            document.getElementById("fullname").required = false;
                                            document.getElementById("expedition").required = false;
                                            document.getElementById("nik").required = true;
                                        } else if($('#category').val() == 'external') {
                                            $("#internal").addClass("hide");
                                            $("#external").removeClass("hide");
                                            document.getElementById("nik").required = false;
                                            document.getElementById("fullname").required = true;
                                            document.getElementById("expedition").required = true;
                                        }
                                    });
                                </script>
                            </div>

                            <div id="internal"> 
                                <div class="form-group">
                                    <label>Karyawan Terlapor</label>
                                    <select class="form-control input-sm" id="nik" name="nik" placeholder="--- KARYAWAN TERLAPOR ---" required>
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
                                        $("#nik").addClass("selectize-hidden-accessible");
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
                            <div id="external">
                                <div class="form-group">
                                    <label>Karyawan</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?= $dtl->fullname ?>" style="text-transform: uppercase;" required>
                                </div>
                                <div class="form-group">
                                    <label>Ekspedisi</label>
                                    <input type="text" class="form-control" id="expedition" name="expedition" value="<?= $dtl->expedition ?>" style="text-transform: uppercase;" required>
                                </div>
                            </div> 
                        </div>
                        <div class="col-lg-4">
                            <?php if($type == "EDIT"): ?>
                                <div class="form-group">
                                    <label>Dokumen</label>
                                    <input type="text" class="form-control" value="<?= $dtl->docnotmp ?>" disabled>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label>Tanggal & Jam Kejadian</label>
                                <input type="text" class="form-control" id="docdate" name="docdate" placeholder="TANGGAL & JAM KEJADIAN" value="<?= date("d-m-Y H:i", strtotime($dtl->docdate)); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Laporan Kejadian</label>
                                <select class="form-control" id="laporan" name="laporan" placeholder="--- LAPORAN KEJADIAN ---" required>
                                    <option value="" class=""></option>
                                    <?php foreach($list_kejadian as $v): ?>
                                        <?php $result = array_map('trim', $v); ?>
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
                                <textarea class="form-control" id="lokasi" name="lokasi" placeholder="LOKASI KEJADIAN" style="text-transform: uppercase; resize: vertical;" rows="5" required><?= trim($dtl->lokasi) ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Uraian Kejadian</label>
                                <textarea class="form-control" id="uraian" name="uraian" placeholder="URAIAN KEJADIAN" style="text-transform: uppercase; resize: vertical;" rows="5" required><?= trim($dtl->uraian) ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Solusi / Perbaikan</label>
                                <textarea class="form-control" id="solusi" name="solusi" placeholder="SOLUSI / PERBAIKAN" style="text-transform: uppercase; resize: vertical;" rows="5" required><?= trim($dtl->solusi) ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Apakah Ada Saksi?</label>
                                <select id="saksi" name="saksi" style="width: 100%;" class="form-control" placeholder="--- APAKAH ADA SAKSI? ---" required>
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
                                <select class="form-control" name="saksi1" id="saksi1" placeholder="--- SAKSI 1 ---">
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
                                <select class="form-control" name="saksi2" id="saksi2" placeholder="--- SAKSI 2 ---">
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
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <a href="<?php echo site_url('trans/sberitaacara/clearEntry') ?>" class="btn btn-default" style="margin: 10px 5px;" type="button">Kembali</a>
                            <button type="submit" class="btn btn-primary" style="margin: 10px 5px;">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#docdate").datetimepicker({
        format: 'DD-MM-YYYY HH:mm',
    });
    
    $('#nik')[0].selectize.setValue("<?= trim($dtl->nik) ?>");
    $('#laporan')[0].selectize.setValue("<?= trim($dtl->laporan) ?>");
    $('#saksi')[0].selectize.setValue("<?= trim($dtl->saksi) ?>");
    $('#saksi1')[0].selectize.setValue("<?= trim($dtl->saksi1) ?>");
    $('#saksi2')[0].selectize.setValue("<?= trim($dtl->saksi2) ?>");
    $('#category')[0].selectize.setValue("<?= trim($dtl->category) ?>");
    $('#fullname')[0].selectize.setValue("<?= trim($dtl->fullname) ?>");
    $('#expedition')[0].selectize.setValue("<?= trim($dtl->expedition) ?>");
</script>