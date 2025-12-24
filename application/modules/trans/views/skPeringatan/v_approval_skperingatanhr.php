<style>
    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        cursor: default;
    }

    .selectize-input:after {
        display: none !important;
    }
</style>

<script type="text/javascript">
    var firstLoad = true;
</script>

<legend><?= $title ?></legend>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <form action="<?php echo site_url('trans/skperingatan/saveEntryhr')?>" method="post" id="formSkPeringatan" enctype="multipart/form-data" role="form">
                <div class="box-body">
                    <div class="col-lg-6">
                        <input type="hidden" class="form-control" id="type" name="type" value="<?= $type ?>">
                        <input type="hidden" class="form-control" id="docno" name="docno" value="<?= $dtl->docno ?>">
                        <div class="form-group">
                            <label>Karyawan</label>
                            <select class="form-control input-sm" id="nik" name="nik" placeholder="--- KARYAWAN ---" disabled>
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
                                    $('#tindakan')[0].selectize.clearOptions();
                                    $.ajax({
                                        url: HOST_URL + "trans/skperingatan/get_tindakan",
                                        type: "post",
                                        data: {
                                            docno: "<?= trim($dtl->docnotmp) ?>",
                                            nik: $('#nik').val()
                                        },
                                        dataType  : 'json',
                                        success: function(data) {
                                            for(var i = 0; i < data.length; i++) {
                                                $('#tindakan')[0].selectize.addOption({
                                                    docno: data[i].docno.trim(),
                                                    docname: data[i].docname.trim()
                                                });
                                            }
                                            if(firstLoad) {
                                                $('#tindakan')[0].selectize.setValue("<?= trim($dtl->tindakan) ?>");
                                            }
                                        }
                                    });
                                    $('#docref')[0].selectize.clearOptions();
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
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Dokumen</label>
                            <input type="text" class="form-control" value="<?= $dtl->docnotmp ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Awal s/d Tanggal Selesai</label>
                            <input type="text" class="form-control" id="startdate" name="startdate" placeholder="TANGGAL" value="<?= $dtl->startdatex ?>" disabled>
                        </div>
                        <div class="form-group tindakan">
                            <label>Kategori SP</label>
                            <select class="form-control" id="tindakan" name="tindakan" placeholder="--- Kategori SP ---" disabled>
                                <option value="" class=""></option>
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
                                }).on('change', function() {
                                    $('#docref')[0].selectize.clearOptions();
                                    $.ajax({
                                        url: HOST_URL + "trans/skperingatan/get_docref",
                                        type: "post",
                                        data: {
                                            docno: "<?= trim($dtl->docnotmp) ?>",
                                            nik: $('#nik').val(),
                                            tindakan: $('#tindakan').val()
                                        },
                                        dataType  : 'json',
                                        success: function(data) {
                                            for(var i = 0; i < data.length; i++) {
                                                $('#docref')[0].selectize.addOption({
                                                    docno: data[i].docno.trim()
                                                });
                                            }
                                            if(firstLoad) {
                                                $('#docref')[0].selectize.setValue("<?= trim($dtl->docref) ?>");
                                                firstLoad = !firstLoad;
                                            }
                                        }
                                    });
                                });
                                $("#tindakan").addClass("selectize-hidden-accessible");
                            </script>
                        </div>
                        <div class="form-group tindakan">
                            <label>Dokumen Referensi SP</label>
                            <select class="form-control" id="docref" name="docref" placeholder="--- DOKUMEN REFERENSI SP ---" disabled>
                                <option value="" class=""></option>
                            </select>
                            <script type="text/javascript">
                                $('#docref').selectize({
                                    plugins: ['hide-arrow', 'selectable-placeholder'],
                                    valueField: 'docno',
                                    labelField: 'docno',
                                    searchField: ['docno'],
                                    options: [],
                                    create: false,
                                    initData: true
                                });
                                $("#docref").addClass("selectize-hidden-accessible");
                            </script>
                        </div>
                        <div class="form-group">
                            <label>Keterangan Peringatan / Alasan Teguran</label>
                            <textarea class="form-control" id="description" name="description" placeholder="KETERANGAN PERINGATAN / ALASAN TEGURAN" style=" resize: vertical;" rows="5" disabled><?= $dtl->description ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Solusi / Perbaikan</label>
                            <textarea class="form-control" id="solusi" name="solusi" placeholder="SOLUSI / PERBAIKAN" style=" resize: vertical;" rows="5" disabled><?= $dtl->solusi ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="uploadFile">Upload Dokumen Pendukung</label>
                            <br>
                            <?php if($dtl->att_name == ''): ?>
                                -
                            <?php else: ?>
                                <a href="#" onclick="window.open('<?= site_url('assets/files/skperingatan') . '/' . $dtl->att_name; ?>')"><?= $dtl->att_name ?></a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <a href="<?php echo site_url('trans/skperingatan/clearEntry') ?>" class="btn btn-default" style="margin: 10px 5px;" type="button">Kembali</a>
                            <button type="submit" class="btn btn-danger" style="margin: 10px 5px;" name="submit" value="batal">Batal</button>
                            <button type="submit" class="btn btn-success" style="margin: 10px 5px;" name="submit" value="setuju">Setuju</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $("#startdate").daterangepicker({
        dateLimit: {
            months: 6,
            days: -1
        }
    });

    $('#nik')[0].selectize.setValue("<?= trim($dtl->nik) ?>");
</script>
