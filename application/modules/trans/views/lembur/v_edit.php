<script type="text/javascript">
    var $jenis_lembur;


    $(function() {
        $("#tgl_kerja").datepicker({
            startDate: '<?= $opsi_lembur ?>'
        });
        $("[data-mask]").inputmask();
        $('.tgllin').hide();
        $('#durasi').val("0 Jam 0 Menit");
        $('#durasi_istirahat').val(0);
        showLintasHari();
    });

    function showLintasHari() {
        $('#durasi').val("0 Jam 0 Menit");
        $('#durasi_istirahat').val(0);
        $('#postmessages').empty();
        $('#submit').prop('disabled', false);

        var tplintas = $('#lintashari').val();
        if(tplintas == 't') {
            $('.tgllin').show();
            $jenis_lembur = $('#jenis_lembur').val();
            $('#jenis_lembur')[0].selectize.disable();
            document.getElementById("jenis_lembur").required = false;
            $('#jenis_lembur')[0].selectize.setValue("D2");
            changeLintasHari();
        } else {
            $('.tgllin').hide();
            $('#jenis_lembur')[0].selectize.enable();
            document.getElementById("jenis_lembur").required = true;
            if($jenis_lembur !== undefined) {
                $('#jenis_lembur')[0].selectize.setValue($jenis_lembur);
            }
            checkConflict();
        }
    }

    function changeLintasHari() {
        $('#durasi').val("0 Jam 0 Menit");
        $('#durasi_istirahat').val(0);
        $('#postmessages').empty();
        $('#submit').prop('disabled', false);

        var tglkerja = $('#tgl_kerja').val();
        if(tglkerja != '') {
            var tglArr = tglkerja.split("-");
            var today = new Date(tglArr[1] + "/" + tglArr[0] + "/" + tglArr[2]);
            var tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 1);
            tomorrow = ("0" + tomorrow.getDate()).slice(-2) + "-" + ("0" + (tomorrow.getMonth() + 1)).slice(-2) + "-" + tomorrow.getFullYear();
            $('#tgllin').val(tomorrow);
            checkConflict();
        }
    }

    function checkConflict() {
        $('#durasi').val("0 Jam 0 Menit");
        $('#durasi_istirahat').val(0);
        $('#postmessages').empty();
        $('#submit').prop('disabled', false);

        var nodok = $('#nodok').val();
        var nik = $('#nik').val();
        var tplintas = $('#lintashari').val();
        var tglkerja = $('#tgl_kerja').val();
        var tgllin = $('#tgl_kerja').val();
        if(tplintas == 't') {
            tgllin = $('#tgllin').val();
        }
        var jam_awal = $('#jam_awal').val();
        var jam_selesai = $('#jam_selesai').val();
        console.log(jam_awal);
        if(jam_awal != '' && jam_selesai != '') {
            if(tplintas == 'f' && jam_awal > jam_selesai) {
                $('#postmessages').empty().append("<div class='alert alert-danger'>PERINGATAN!! JAM SELESAI HARUS LEBIH BESAR DARI JAM AWAL.</div>");
                $('#submit').prop('disabled', true);
                return false;
            }
            if(tglkerja != '') {
                var tglkerjaArr = tglkerja.split("-");
                tglkerja = tglkerjaArr[2] + "-" + tglkerjaArr[1] + "-" + tglkerjaArr[0];
                var tgllinArr = tgllin.split("-");
                tgllin = tgllinArr[2] + "-" + tgllinArr[1] + "-" + tgllinArr[0];

                var date1 = new Date(tglkerjaArr[1] + "/" + tglkerjaArr[0] + "/" + tglkerjaArr[2] + " " + jam_awal);
                var date2 = new Date(tgllinArr[1] + "/" + tgllinArr[0] + "/" + tgllinArr[2] + " " + jam_selesai);
                var durasi = Math.floor(Math.abs(date1 - date2) / 36e5);

                if(isNaN(durasi)) {
                    $('#postmessages').empty().append("<div class='alert alert-danger'>PERINGATAN!! INPUT JAM TIDAK SESUAI.</div>");
                    $('#submit').prop('disabled', true);
                    return false;
                }
                var istirahat = durasi == 0 ? 0 : (Math.ceil(durasi / 4) - 1) * 60;
                var durasi_lembur = Math.abs(date1 - date2) / 6e4 - istirahat;
                $('#durasi_istirahat').val(istirahat);
                $('#durasi').val(Math.floor(durasi_lembur / 60) + " Jam " + Math.floor(durasi_lembur % 60) + " Menit");

                var fillData = {
                    "nik": nik,
                    "nodok": nodok,
                    "jam_awal": tglkerja + ' ' + jam_awal,
                    "jam_selesai": tgllin + ' ' + jam_selesai
                };

                $.ajax({
                    type: "POST",
                    url: HOST_URL + "trans/lembur/checkConflict",
                    dataType: "json",
                    contentType: "application/json",
                    data: JSON.stringify(fillData),
                    success: function(data) {
                        if(!data.status) {
                            $('#postmessages').empty().append("<div class='alert alert-danger'>" + data.message + "</div>");
                            $('#submit').prop('disabled', true);
                            return false;
                        }
                    }
                });
            }
        }
    }
    $(document).ready(function (){
        $('#jam_awal,#jam_selesai').clockpicker({
            autoclose: true,
        });
    })
</script>

<legend><?php echo $title; ?></legend>
<span id="postmessages"></span>
<?php foreach ($list_lembur_dtl as $lb) { ?>
    <form action="<?php echo site_url('trans/lembur/edit_lembur'); ?>" method="post">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-4">Nomor Dokumen</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nodok" name="nodok" value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">NIK</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nik" name="nik" value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                        <input type="hidden" id="status" name="status" value="I" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Nama Karyawan</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" id="nik" name="kdlvl1" value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                        <input type="text" id="nik" name="kdlvl1" value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                        <input type="hidden" id="nik" name="kdlvl" value="<?php echo trim($lb->lvl_jabatan); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Department</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nik" name="department1" value="<?php echo trim($lb->nmdept); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                        <input type="hidden" id="nik" name="department" value="<?php echo trim($lb->bag_dept); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Sub Department</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nik" name="subdepartment1" value="<?php echo trim($lb->nmsubdept); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                        <input type="hidden" id="nik" name="subdepartment" value="<?php echo trim($lb->subbag_dept); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Jabatan</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nik" name="jabatan1" value="<?php echo trim($lb->nmjabatan); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                        <input type="hidden" id="nik" name="jabatan" value="<?php echo trim($lb->jabatan); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Nama Atasan</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" id="nik" name="atasan" value="<?php echo trim($lb->nik_atasan); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                        <input type="text" id="nik" name="atasan1" value="<?php echo trim($lb->nmatasan1); ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-4">Tanggal Dokumen</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="tgl1" name="tgl_dok" value="<?php echo trim($lb->tgl_dok1); ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Lintas Hari</label>
                                    <div class="col-sm-8">
                                        <select class="form-control input-sm" name="lintashari" id="lintashari" required>
                                            <option <?php echo trim($lb->tgl_kerja1) == trim($lb->tgl_kerja2) ? 'selected' : ''; ?> value="f">TIDAK</option>
                                            <option <?php echo trim($lb->tgl_kerja1) <> trim($lb->tgl_kerja2) ? 'selected' : ''; ?> value="t">YA</option>
                                        </select>
                                        <script type="text/javascript">
                                            $('#lintashari').selectize({
                                                plugins: ['hide-arrow'],
                                                options: [],
                                                create: false,
                                                initData: true
                                            }).on('change', function() {
                                                showLintasHari();
                                            });
                                            $("#lintashari").addClass("selectize-hidden-accessible");
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Tipe Lembur</label>
                                    <div class="col-sm-8">
                                        <select class="form-control input-sm" name="kdlembur" id="kdgrade" required>
                                            <?php foreach($list_lembur_edit as $listkan) { ?>
                                                <option <?php echo trim($lb->kdlembur) == trim($listkan->tplembur) ? 'selected' : ''; ?> value="<?php echo trim($listkan->tplembur); ?>" ><?php echo $listkan->tplembur; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script type="text/javascript">
                                            $('#kdgrade').selectize({
                                                plugins: ['hide-arrow'],
                                                options: [],
                                                create: false,
                                                initData: true
                                            });
                                            $("#kdgrade").addClass("selectize-hidden-accessible");
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Jenis Lembur</label>
                                    <div class="col-sm-8">
                                        <select class="form-control input-sm" name="jenis_lembur" id="jenis_lembur" required>
                                            <option <?php echo trim($lb->jenis_lembur) == 'D1' ? 'selected' : ''; ?> value="D1">DURASI ABSEN</option>
                                            <option <?php echo trim($lb->jenis_lembur) == 'D2' ? 'selected' : ''; ?> value="D2">NON-DURASI ABSEN</option>
                                        </select>
                                    </div>
                                    <script type="text/javascript">
                                        $('#jenis_lembur').selectize({
                                            plugins: ['hide-arrow'],
                                            options: [],
                                            create: false,
                                            initData: true
                                        });
                                        $("#jenis_lembur").addClass("selectize-hidden-accessible");
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Tanggal Kerja</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="tgl_kerja" value="<?php echo trim($lb->tgl_kerja1); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy" class="form-control tgl_kerja" onchange="changeLintasHari()" required>
                                    </div>
                                </div>
                                <div class="form-group tgllin">
                                    <label class="col-sm-4">Tanggal Kerja Lintas Hari</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="tgllin" name="tgllin" value="<?php echo trim($lb->tgl_kerja2); ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Jam Awal</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="jam_awal" name="jam_awal" data-inputmask='"mask": "99:99"' data-mask="" onchange="checkConflict()" value="<?php echo trim($lb->jam_awal); ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Jam Selesai</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="jam_selesai" name="jam_selesai" data-inputmask='"mask": "99:99"' data-mask="" onchange="checkConflict()" value="<?php echo trim($lb->jam_akhir); ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Durasi Istirahat (Menit)</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="durasi_istirahat" name="durasi_istirahat" value="<?php echo trim($lb->durasi_istirahat); ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Durasi Waktu (Jam)</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="durasi" name="durasi" value="<?php echo trim($lb->jam); ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Kategori Lembur</label>
                                    <div class="col-sm-8">
                                        <select class="form-control input-sm" name="kdtrx" id="kdtrx" required>
                                            <?php foreach($list_trxtype as $listkan) { ?>
                                                <option <?php echo trim($lb->kdtrx) == trim($listkan->kdtrx) ? 'selected' : ''; ?> value="<?php echo trim($listkan->kdtrx); ?>" ><?php echo $listkan->uraian; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script type="text/javascript">
                                            $('#kdtrx').selectize({
                                                plugins: ['hide-arrow'],
                                                options: [],
                                                create: false,
                                                initData: true
                                            });
                                            $("#kdtrx").addClass("selectize-hidden-accessible");
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Keterangan</label>
                                    <div class="col-sm-8">
                                        <textarea type="text" id="nmdept" name="keterangan" style="text-transform: uppercase; resize: vertical;" class="form-control" rows="3" required><?php echo trim($lb->keterangan); ?></textarea>
                                        <input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s'); ?>" class="form-control" readonly>
                                        <input type="hidden" id="inputby" name="inputby" value="<?php echo $this->session->userdata('nik'); ?>" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-default" href="<?php echo site_url("trans/lembur/index"); ?>"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>
            <button type="submit" id="submit" onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Simpan</button>
        </div>
    </form>
<?php } ?>
