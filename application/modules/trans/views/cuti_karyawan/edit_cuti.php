<script type="text/javascript">
    $(function() {
        $("#tgl_awal").datepicker({
            startDate: '<?= $userhr > 0 ? "" : "+6d" ?>'
        });
        $("#tgl_selesai").datepicker({
            startDate: '<?= $userhr > 0 ? "" : "+6d" ?>'
        });
        $("#tpcuti").selectize();
        $("#statptg").selectize();
        $("#kdijin_khusus").selectize();
        $("#pelimpahan").select2();

        cekCuti();
    });

    function cekCuti() {
        var nodok = $('#nodok').val();
        var nik = $('#nik').val();
        var sisacuti = parseInt($('#sisacuti').val());
        var tpcuti = $('#tpcuti').val();
        var statptg = $('#statptg').val();
        var tgl_awal = $('#tgl_awal').val();
        var tgl_selesai = $('#tgl_selesai').val();

        if(tpcuti == "A") {
            $('.statptg_label').show();
            $('.kdijin_khusus_label').hide();
            $('#statptg').prop('required', true);
            $('#kdijin_khusus').prop('required', false);
            $('#kdijin_khusus').val(null);
        } else if(tpcuti == "B") {
            $('.statptg_label').hide();
            $('.kdijin_khusus_label').show();
            $('#statptg').prop('required', false);
			 $('#statptg').val(null);
            $('#kdijin_khusus').prop('required', true);
        }

        $('#postmessages').empty();
        $('#submit').prop('disabled', false);
        if(tgl_awal != '' && tgl_selesai != '') {
            var date1 = new Date(tgl_awal.split("-").reverse().join("-"));
            var date2 = new Date(tgl_selesai.split("-").reverse().join("-"));
            var difference = (date2.getTime() - date1.getTime()) / (1000 * 3600 * 24) + 1;

            if(difference < 1) {
                $('#postmessages').empty().append("<div class='alert alert-danger'>PERINGATAN !! TANGGAL SELESAI HARUS LEBIH BESAR / SAMA DENGAN TANGAN MULAI.</div>");
                $('#submit').prop('disabled', true);
            } else if(tpcuti == "A" && statptg == "A1" && difference > sisacuti) {
                if('<?= $userhr ?>' > 0) {
                    $('#postmessages').empty().append("<div class='alert alert-danger'>PERINGATAN !! SISA CUTI = " + sisacuti + " SILAHKAN MASUKKAN SESUAI SISA CUTI / SILAHKAN PILIH OPSI LAIN POTONG GAJI / CUTI KHUSUS.</div>");
                } else {
                    $('#postmessages').empty().append("<div class='alert alert-danger'>PERINGATAN !! SISA CUTI = " + sisacuti + " SILAHKAN MASUKKAN SESUAI SISA CUTI / SILAHKAN HUBUNGI HRD UNTUK PILIH OPSI LAIN.</div>");
                }
                $('#submit').prop('disabled', true);
            } else {
                $.ajax({
                    url: HOST_URL + "trans/cuti_karyawan/check_tanggal",
                    type: "post",
                    data: {
                        nodok: nodok,
                        nik: nik,
                        tgl_awal: tgl_awal,
                        tgl_selesai: tgl_selesai
                    },
                    dataType  : 'json',
                    success: function(data) {
                        if(data.length > 0) {
                            var li = "";
                            for(var i = 0; i < data.length; i++) {
                                li += "<li>" + data[i].nodok + " (" + data[i].tgl_mulai + " S/D " + data[i].tgl_selesai + ") - " + data[i].status + "</li>"
                            }
                            $('#postmessages').empty().append("" +
                                "<div class='alert alert-danger'>" +
                                "PERINGATAN !! ANDA SUDAH MELAKUKAN INPUT CUTI PADA TANGGAL TERSEBUT." +
                                "<ul>" +
                                li +
                                "</ul>" +
                                "</div>" +
                                "");
                            $('#submit').prop('disabled', true);
                        }
                    }
                });
            }
        }
    }
</script>

<legend><?= $title ?></legend>
<span>
    <?php
    if ($this->session->flashdata('messageStart')){
        echo $this->session->flashdata('messageStart');
    } ?>
</span>
<span id="postmessages"></span>

<form action="<?= site_url('trans/cuti_karyawan/edit_cuti_karyawan') ?>" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-danger">
                    <div class="box-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4">No. Dokumen</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nodok" name="nodok" value="<?= trim($dtl['nodok']) ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">NIK</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="nik" value="<?= trim($dtl['nik']) ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Nama Karyawan</label>
                                <div class="col-sm-8">
                                    <input type="hidden" id="kdlvl1" name="kdlvl1" value="<?= trim($dtl['nmlvljabatan']) ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                    <input type="text" id="kdlvl1" name="kdlvl1" value="<?= trim($dtl['nmlengkap']) ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                    <input type="hidden" id="kdlvl" name="kdlvl" value="<?= trim($dtl['kdlvljabatan']) ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Department</label>
                                <div class="col-sm-8">
                                    <input type="text" id="department" name="department" value="<?= trim($dtl['nmdept']) ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Sub Department</label>
                                <div class="col-sm-8">
                                    <input type="text" id="subdepartment" name="subdepartment" value="<?= trim($dtl['nmsubdept']) ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Jabatan</label>
                                <div class="col-sm-8">
                                    <input type="text" id="jabatan" name="jabatan" value="<?= trim($dtl['nmjabatan']) ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">NIK Atasan</label>
                                <div class="col-sm-8">
                                    <input type="text" id="atasan" name="atasan" value="<?= trim($dtl['nmatasan1']) ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">NIK Atasan2</label>
                                <div class="col-sm-8">
                                    <input type="text" id="atasan2" name="atasan2" value="<?= trim($dtl['nmatasan2']) ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Alamat</label>
                                <div class="col-sm-8">
                                    <textarea type="text" id="keterangan" name="keterangan"  style="text-transform: uppercase;" class="form-control" readonly><?= trim($dtl['alamat']) ?></textarea>
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
                                <label class="col-sm-4">Sisa Cuti</label>
                                <div class="col-sm-8">
                                    <input type="text" id="sisacuti" value="<?= trim($dtl['sisacuti']) ?>" class="form-control" style="text-transform: uppercase;" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tipe Cuti</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm" name="tpcuti" id="tpcuti" onchange="cekCuti()">
                                        <option value="A" <?= trim($dtl['tpcuti']) == 'A' ? 'selected' : '' ?>>CUTI</option>
                                        <?php if($userhr > 0): ?>
                                            <option value="B" <?= trim($dtl['tpcuti']) == 'B' ? 'selected' : '' ?>>IJIN KHUSUS</option>
                                            <option value="C" <?= trim($dtl['tpcuti']) == 'C' ? 'selected' : '' ?>>DINAS</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group statptg_label">
                                <label class="col-sm-4">Subtitusi Cuti</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm" name="statptg" id="statptg" onchange="cekCuti()">
                                        <option value="A1" <?= trim($dtl['status_ptg']) == 'A1' ? 'selected' : '' ?>>POTONG CUTI</option>
                                        <?php if($userhr > 0): ?>
                                            <option value="A2" <?= trim($dtl['status_ptg']) == 'A2' ? 'selected' : '' ?>>POTONG GAJI</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group kdijin_khusus_label">
                                <label class="col-sm-4">Tipe Ijin Khusus</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm" name="kdijin_khusus" id="kdijin_khusus" onchange="cekCuti()">
                                        <?php foreach($list_ijin_khusus as $listkan): ?>
                                            <option value="<?= trim($listkan->kdijin_khusus) ?>" <?= trim($dtl['kdijin_khusus']) == trim($listkan->kdijin_khusus) ? 'selected' : '' ?>><?= $listkan->nmijin_khusus?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tanggal Mulai</label>
                                <div class="col-sm-8">
                                    <input type="text" id="tgl_awal" value="<?= trim($dtl['tgl_mulai1']) ?>" name="tgl_awal" data-date-format="dd-mm-yyyy" class="form-control" onchange="cekCuti()">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tanggal Selesai</label>
                                <div class="col-sm-8">
                                    <input type="text" id="tgl_selesai" value="<?= trim($dtl['tgl_selesai1']) ?>" name="tgl_selesai" data-date-format="dd-mm-yyyy" class="form-control" onchange="cekCuti()">
                                </div>
                            </div>

                            <!--                                        <div class="form-group">-->
                            <!--                                            <label class="col-sm-4">Jumlah Cuti(Hari)</label>-->
                            <!--                                            <div class="col-sm-8">-->
                            <!--                                                <input type="number" id="gaji" name="jumlah_cuti" placeholder="0" value="--><?php //echo trim($dtl['jumlah_cuti']) ?><!--" class="form-control" required  >-->
                            <!--                                            </div>-->
                            <!--                                        </div>-->
                            <div class="form-group">
                                <label class="col-sm-4">Tanggal Dokumen</label>
                                <div class="col-sm-8">
                                    <input type="text" id="tgl_dok" name="tgl_dok" value="<?= trim($dtl['tgl_dok1']) ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Pelimpahan Pekerjaan</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm" name="pelimpahan" id="pelimpahan" required>
                                        <?php foreach($list_karyawan as $listkan): ?>
                                            <option <?= trim($dtl['pelimpahan']) == trim($listkan->nik) ? 'selected' : '' ?> value="<?= trim($listkan->nik) ?>" ><?= $listkan->nmlengkap ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Keterangan</label>
                                <div class="col-sm-8">
                                    <textarea type="text" id="keterangan" name="keterangan"  style="text-transform: uppercase;" class="form-control" ><?= trim($dtl['keterangan']) ?></textarea>
                                    <input type="hidden" id="tgl" name="tgl" value="<?= date('d-m-Y H:i:s') ?>" class="form-control" readonly>
                                    <input type="hidden" id="inputby" name="inputby" value="<?= $this->session->userdata('nik') ?>" class="form-control" readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="<?= site_url("trans/cuti_karyawan/") ?>" class="btn btn-default">Kembali</a>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function (){
        $('#tgl_selesai').on('change',function (){
            if ($("#tgl_awal").val().length == 0){
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm btn-success ml-3',
                        cancelButton: 'btn btn-sm btn-warning ml-3',
                        denyButton: 'btn btn-sm btn-default ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Peringatan',
                    html: 'Pilih tanggal awal terlebih dahulu',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showConfirmButton: false,
                    showDenyButton: true,
                    denyButtonText: `Tutup`,
                }).then(function (result) {
                    $("#tgl_selesai").val('')
                })
            }else{
                var fillData = {
                    'key': '1203jD0j120dkjjKODNOoimdi)D(J)Jmjid0sjd0ijme09wjei0kjisdjfDSojiodksOjO',
                    'body': {
                        begindate: $('#tgl_awal').val(),
                        enddate: $('#tgl_selesai').val(),
                        nik: $('#nik').val()
                    },
                };
                $.ajax({
                    url: '<?php echo site_url('trans/dinas/dutiecheck') ?>',
                    method: 'POST',
                    dataType: 'json',
                    contentType: "application/json",
                    data: JSON.stringify(fillData),
                    success: function (data) {
                        console.log(data)
                    },
                    error: (function (xhr, status, thrown) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-default ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            position: 'top',
                            icon: 'error',
                            title: 'Peringatan',
                            html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showCloseButton: false,
                            showConfirmButton: false,
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isDenied) {
                                $('#tgl_selesai').val('');
                            }
                        })
                    })
                })
            }
        });
    })
</script>

