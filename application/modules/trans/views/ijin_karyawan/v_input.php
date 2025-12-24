<script type="text/javascript">
    $(function () {
        $("#example1").dataTable();
        $("#example2").dataTable();
        $("#example3").dataTable();
        $("#dateinput").datepicker();
        $("#dateinput1").datepicker();
        $("#dateinput2").datepicker();
        $("#dateinput3").datepicker();
        $("#jam_awal").clockpicker();
        $("#jam_selesai").clockpicker();
        $("#jam_telat").clockpicker();
        $("[data-mask]").inputmask();
    });
</script>
<legend><?php echo $title; ?></legend>
<span id="postmessages"></span>
<?php foreach ($list_lk as $lb) { ?>
    <form class="formupdate" action="<?php echo site_url('trans/ijin_karyawan/add_ijin_karyawan') ?>" method="post">
        <div class="modal-body">
            <?php echo $message; ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-4">NIK</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nik" name="nik" value="<?php echo trim($lb->nik); ?>"
                                               class="form-control" style="text-transform:uppercase" maxlength="40"
                                               readonly>
                                        <input type="hidden" id="status" name="status" value="I" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                        <input type="hidden" id="status" name="nodok"
                                               value="<?php echo trim($lb->nik); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Nama Karyawan</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" id="nik" name="kdlvl1"
                                               value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                        <input type="text" id="nik" name="kdlvl1"
                                               value="<?php echo trim($lb->nmlengkap); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                        <input type="hidden" id="nik" name="kdlvl"
                                               value="<?php echo trim($lb->lvl_jabatan); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Department</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nik" name="department1"
                                               value="<?php echo trim($lb->nmdept); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                        <input type="hidden" id="nik" name="department"
                                               value="<?php echo trim($lb->bag_dept); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Sub Department</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nik" name="subdepartment1"
                                               value="<?php echo trim($lb->nmsubdept); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                        <input type="hidden" id="nik" name="subdepartment"
                                               value="<?php echo trim($lb->subbag_dept); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Jabatan</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nik" name="jabatan1"
                                               value="<?php echo trim($lb->nmjabatan); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                        <input type="hidden" id="nik" name="jabatan"
                                               value="<?php echo trim($lb->jabatan); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Nama Atasan</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nik" name="atasan1"
                                               value="<?php echo trim($lb->nmatasan); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                        <input type="hidden" id="nik" name="atasan"
                                               value="<?php echo trim($lb->nik_atasan); ?>" class="form-control"
                                               style="text-transform:uppercase" maxlength="40" readonly>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
                <div class="col-sm-6">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-4">Tipe Ijin</label>
                                    <div class="col-sm-8">
                                        <select class="form-control input-sm" name="kdijin_absensi" id="kdijin_absensi">
                                            <option value=""><?php echo '-- PILIH TYPE IJIN ---'; ?></option>
                                            <?php foreach ($list_ijin as $listkan) { ?>
                                                <option
                                                        value="<?php echo trim($listkan->kdijin_absensi); ?>"><?php echo $listkan->nmijin_absensi; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Kategori</label>
                                    <div class="col-sm-8">
                                        <select class="form-control input-sm" name="ktgijin" id="ktgijin">
                                            <option value="">-- PILIH KATEGORI IJIN ---</option>
                                            <option value="PB"><?php echo 'IJIN PRIBADI'; ?></option>
                                            <option value="DN"><?php echo 'IJIN DINAS'; ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group a tgl_kerja">
                                    <label class="col-sm-4">Tanggal Kerja</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="tgl_kerja" name="tgl_kerja" data-date-format="dd-mm-yyyy"
                                               class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group a jam_awal">
                                    <label class="col-sm-4">Jam Awal</label>
                                    <div class="col-sm-4 tgl_jam_awal">
                                        <input type="text" id="tgl_jam_awal" name="tgl_jam_awal"
                                               data-date-format="dd-mm-yyyy" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="jam_awal" name="jam_awal" class="form-control"
                                               onchange="cekTanggal();" required>
                                    </div>
                                </div>
                                <div class="form-group a jam_selesai">
                                    <label class="col-sm-4">Jam Selesai</label>
                                    <div class="col-sm-4 tgl_jam_selesai">
                                        <input type="text" id="tgl_jam_selesai" name="tgl_jam_selesai"
                                               data-date-format="dd-mm-yyyy" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="jam_selesai" name="jam_selesai" class="form-control"
                                               onchange="cekTanggal();" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Jenis Kendaraan</label>
                                    <div class="col-sm-8">
                                        <select class="form-control input-sm" name="kendaraan" id="kendaraan">
                                            <option
                                                    value=""><?php echo '-- PILIH JENIS KENDARAAN DIPAKAI ---'; ?></option>
                                            <option value="PRIBADI"><?php echo 'PRIBADI'; ?></option>
                                            <option value="DINAS"><?php echo 'DINAS'; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Nomor Polisi</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="nopol" name="nopol" class="form-control"
                                               placeholder=" Masukkan Nopol Kendaraan" style="text-transform: uppercase"
                                               required>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Keterangan</label>
                                    <div class="col-sm-8">
                                        <textarea type="text" id="nmdept" name="keterangan"
                                                  style="text-transform:uppercase" class="form-control"
                                                  required></textarea>
                                        <input type="hidden" id="tgl1" name="tgl"
                                               value="<?php echo date('d-m-Y H:i:s'); ?>" class="form-control" readonly>
                                        <input type="hidden" id="tgl1" name="tgl_dok"
                                               value="<?php echo date('d-m-Y H:i:s'); ?>" class="form-control" readonly>
                                        <input type="hidden" id="inputby" name="inputby"
                                               value="<?php echo $this->session->userdata('nik'); ?>"
                                               class="form-control" readonly>
                                        <!---------------AKSES USER--------------->
                                        <input type="hidden" <?php $date = date('d-m-Y');
                                        $date = strtotime($date); ?> id="tgl7"
                                               value="<?php echo date('m/d/Y', $date); ?>" class="form-control">
                                        <input type="hidden" class="userhr" id="userhr"
                                               value="<?php echo trim($userhr); ?>">
                                        <input type="hidden" class="level_akses" id="level_akses"
                                               value="<?php echo trim($level_akses); ?>">
                                    </div>
                                </div>

                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-default back" href="<?php echo site_url("trans/ijin_karyawan/karyawan"); ?>">Close</a>
            <button type="submit" id="submit" class="btn btn-primary save">SIMPAN</button>
        </div>
    </form>


<?php } ?>
<script type="text/javascript" charset="utf-8">
    function cekTanggal() {
        checkDateIsEmpty()
        $('#postmessages').empty();
        var type = $('#kdijin_absensi').val()
        $('#submit').prop('disabled', true);
        if ($('#tgl_kerja').val() != "" && ($('#kdijin_absensi').val() == 'DT' || $('#kdijin_absensi').val() == 'PA' || $('#kdijin_absensi').val() == 'IK')) {
            var fillData = {
                'success': true,
                'key': '1203jD0j120dkjjKODNOoimdi)D(J)Jmjid0sjd0ijme09wjei0kjisdjfDSojiodksOjO',
                'message': '',
                'body': {
                    category : $('#ktgijin').val(),
                    type: $('#kdijin_absensi').val(),
                    awal: $('#jam_awal').val(),
                    selesai: $('#jam_selesai').val(),
                    tanggal: $('#tgl_kerja').val().toString(),
                    nik: $('#nik').val()
                },
            };
            if ($('#ktgijin').val().length === 0){
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
                    html: 'Pilih kategori ijin',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showConfirmButton: false,
                    showDenyButton: true,
                    denyButtonText: `Tutup`,
                }).then(function (result) {
                    if (result.isDenied) {
                        // $('#tgl_kerja').val('')
                        $('#jam_awal').val('')
                        $('#jam_selesai').val('')
                    }
                })
            }
            if ($('#tgl_kerja').val().length > 0 && ( $('#jam_awal').val().length > 0 || $('#jam_selesai').val().length > 0 ) ){
                $.ajax({
                    type: "POST",
                    url: HOST_URL + 'trans/ijin_karyawan/getJadwal',
                    dataType: 'json',
                    contentType: "application/json",
                    data: JSON.stringify(fillData),
                    success: function (datax) {
                        if (!datax.status || datax.kode === "OFF") {
                            $('#submit').prop('disabled', false);
                        } else {
                        }
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
                                $('#jam_awal').val('')
                                $('#jam_selesai').val('')
                                // $('#tgl_kerja').val('')
                            }
                        })
                    })
                });
            }

        } else {
            $('#submit').prop('disabled', false);
        }
    }
    function checkDateIsEmpty(){
        console.log('fff')
        if ($('#tgl_kerja').val().length === 0){
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
                html: 'Pilih tanggal',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCloseButton: false,
                showConfirmButton: false,
                showDenyButton: true,
                denyButtonText: `Tutup`,
            }).then(function (result) {
                if (result.isDenied) {
                    $('#jam_awal').val('')
                    $('#jam_selesai').val('')
                    $('#tgl_kerja').val('')
                }
            })
        }
    }
    $(document).on('ready', function (){

        $('input[name=\'tgl_kerja\']').on('change',function (){
            if ($("#tgl_kerja").val().length == 0){
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
                    html: 'Pilih tanggal terlebih dahulu',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCloseButton: false,
                    showConfirmButton: false,
                    showDenyButton: true,
                    denyButtonText: `Tutup`,
                }).then(function (result) {
                    $("#tgl_kerja").val('')
                })
            }else{
                var fillData = {
                    'key': '1203jD0j120dkjjKODNOoimdi)D(J)Jmjid0sjd0ijme09wjei0kjisdjfDSojiodksOjO',
                    'body': {
                        begindate: $('#tgl_kerja').val(),
                        enddate: $('#tgl_kerja').val(),
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
                                $('#tgl_kerja').val('');
                            }
                        })
                    })
                })
            }
        });
        var beginsetup = new Date();
        var endsetup = new Date();
        $(function () {
            $("#tgl_kerja").datepicker();
            $('.a').hide();
            $('#submit').prop('disabled', true);
            $('select#ktgijin').on('change', function (){
                var category = $(this).val();
                var tpeijin = $('#kdijin_absensi').val();
                if (category.length > 0 && tpeijin.length > 0 ){
                    var userhr = $('#userhr').val();
                    var level_akses = $('#level_akses').val();
                    var nik = $('#nik').val();
                    var tpeijin = $('#kdijin_absensi').val();
                    $.ajax({
                        url: '<?php echo $checkType ?>',
                        method: 'POST',
                        data: {type: tpeijin, nik: nik, category: category},
                        success: function (data) {
                            $("#tgl_kerja").datepicker('remove');
                            if (userhr == 0 && level_akses != 'A') {
                                $("#tgl_kerja").datepicker({
                                }).on('changeDate', function (ev) {
                                    if (category.length > 0 && tpeijin.length > 0 ) {
                                        var tglpicker1 = ($(this).val().toString());
                                        var tglpicker2 = tglpicker1.substring(5, 3) + '/' + tglpicker1.substring(0, 2) + '/' + tglpicker1.substring(10, 6);
                                        var tglm = new Date(Date.parse(tglpicker2));
                                        var tgl7 = new Date($('#tgl7').val());
                                        if ((tgl7) > (tglm) && userhr == 0 && level_akses != 'A') {
                                            $('#postmessages').empty().append("<div class='alert alert-danger'>PERINGATAN MAKSIMAL TANGGAL H-1</div>");
                                            $('#submit').prop('disabled', true);
                                        } else {
                                            $('#postmessages').empty();
                                            $('#submit').prop('disabled', false);
                                        }

                                        $('#kdijin_absensi').on('change', function () {
                                            if ($('#kdijin_absensi').val() == "DT") {
                                                $('#tgl_kerja').val('')
                                                $('#tgl_jam_awal').val('');
                                                $('#jam_awal').val('');
                                            } else if ($('#kdijin_absensi').val() == "PA") {
                                                $('#tgl_kerja').val('')
                                                $('#tgl_jam_selesai').val('');
                                                $('#jam_selesai').val('');
                                            }
                                        })
                                        if ($('#kdijin_absensi').val() == "DT") {
                                            $('#tgl_jam_awal').val($('#tgl_kerja').val());
                                            $('#jam_awal').val('');
                                        } else if ($('#kdijin_absensi').val() == "PA") {
                                            $('#tgl_jam_selesai').val($('#tgl_kerja').val());
                                            $('#jam_selesai').val('');
                                        }
                                        cekTanggal();
                                    }
                                });
                            } else {
                                $("#tgl_kerja").datepicker().on('changeDate', function (ev) {
                                    if (category.length > 0 && tpeijin.length > 0 ) {
                                        var tglpicker1 = ($(this).val().toString());
                                        var tglpicker2 = tglpicker1.substring(5, 3) + '/' + tglpicker1.substring(0, 2) + '/' + tglpicker1.substring(10, 6);
                                        var tglm = new Date(Date.parse(tglpicker2));
                                        var tgl7 = new Date($('#tgl7').val());
                                        if ((tgl7) > (tglm) && userhr == 0 && level_akses != 'A') {
                                            $('#postmessages').empty().append("<div class='alert alert-danger'>PERINGATAN MAKSIMAL TANGGAL H-1</div>");
                                            $('#submit').prop('disabled', true);
                                        } else {
                                            $('#postmessages').empty();
                                            $('#submit').prop('disabled', false);
                                        }
                                        $('#kdijin_absensi').on('change', function () {
                                            if ($('#kdijin_absensi').val() == "DT") {
                                                $('#tgl_kerja').val(data.setup.begin)
                                                $('#tgl_jam_awal').val($('#tgl_kerja').val());
                                                $('#jam_awal').val('');
                                            } else if ($('#kdijin_absensi').val() == "PA") {
                                                $('#tgl_kerja').val(data.setup.begin)
                                                $('#tgl_jam_selesai').val($('#tgl_kerja').val());
                                                $('#jam_selesai').val('');
                                            }
                                        })
                                    }
                                    // cekTanggal();
                                });
                            }

                        }
                    });

                    if (tpeijin == 'DT') {
                        $('.tgl_kerja').show();

                        $('.tgl_jam_awal').show();
                        $('#tgl_jam_awal').val($('#tgl_kerja').val());
                        $('.jam_awal').show();
                        $('#jam_awal').prop('required', true);

                        $('.tgl_jam_selesai').hide();
                        $('#tgl_jam_selesai').val('');
                        $('.jam_selesai').hide();
                        $('#jam_selesai').removeAttr('required');
                        $('#jam_selesai').val('');

                        $('#submit').prop('disabled', false);
                    } else if (tpeijin == 'IK') {
                        $('.tgl_kerja').show();

                        $('.tgl_jam_awal').hide();
                        $('#tgl_jam_awal').val('');
                        $('.jam_awal').show();
                        $('#jam_awal').prop('required', true);

                        $('.tgl_jam_selesai').hide();
                        $('#tgl_jam_selesai').val('');
                        $('.jam_selesai').show();
                        $('#jam_selesai').prop('required', true);

                        $('#submit').prop('disabled', false);
                    } else if (tpeijin == '') {
                        $('.a').hide();
                        $('#submit').prop('disabled', true);
                    } else if (tpeijin == 'PA') {
                        $('.tgl_kerja').show();

                        $('.tgl_jam_awal').hide();
                        $('#tgl_jam_awal').val('');
                        $('.jam_awal').hide();
                        $('#jam_awal').removeAttr('required');
                        $('#jam_awal').val('');

                        $('.tgl_jam_selesai').show();
                        $('#tgl_jam_selesai').val($('#tgl_kerja').val());
                        $('.jam_selesai').show();
                        $('#jam_selesai').prop('required', true);

                        $('#submit').prop('disabled', false);
                    } else if (tpeijin == 'AL' || tpeijin == 'KD' || tpeijin == 'IM') {
                        $('.tgl_kerja').show();

                        $('.tgl_jam_awal').hide();
                        $('#tgl_jam_awal').val('');
                        $('.jam_awal').hide();
                        $('#jam_awal').removeAttr('required');
                        $('#jam_awal').val('');

                        $('.tgl_jam_selesai').hide();
                        $('#tgl_jam_selesai').val('');
                        $('.jam_selesai').hide();
                        $('#jam_selesai').removeAttr('required');
                        $('#jam_selesai').val('');

                        $('#submit').prop('disabled', false);
                    }else{
                        $('.tgl_kerja').show();
                        $('#tgl_jam_awal').val('');
                        $('.jam_awal').hide();
                        $('#jam_awal').removeAttr('required');
                        $('#jam_awal').val('');

                        $('.tgl_jam_selesai').hide();
                        $('#tgl_jam_selesai').val($('#tgl_kerja').val());
                        $('.jam_selesai').hide();
                        $('#jam_selesai').removeAttr('required');
                        $('#submit').prop('disabled', false);
                    }
                }else{
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
                        html: 'Pilih tipe ijin terlebih dahulu',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showCloseButton: false,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function (result) {
                        if (result.isDenied) {
                            $('select#ktgijin').val('')
                        }
                    })

                }
            })
            $('#kdijin_absensi').change(function () {
                $('select#ktgijin').val('')
                $('input#tgl_kerja').val('')
            });
        });

        $('form.formupdate').on('submit', function (){
            $('button.save').attr("disabled", true)
            $('a.back').attr("disabled", true)
        })
    })
</script>
