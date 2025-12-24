<?php

?>
<style>
	.space {
		margin: 2px;
	}
</style>
<form role="form" class="formupdatedinas" action="<?php echo site_url('trans/dinas/doapprove/'.bin2hex(json_encode(array('branch' => $employee->branch, 'nik' => $default->transaction->nik, 'nodok' => $default->transaction->nodok, ))))?>" method="post">
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3 class="pull-left"><?php echo $title ?></h3>
        </div>
        <div class="col-sm-12">
            <a href="<?php echo site_url('trans/dinas') ?>" class="btn btn-warning pull-right">Kembali</a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-warning" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data Karyawan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4">NIK</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo $employee->nik ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Nama Karyawan</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo $employee->nmlengkap ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Departemen</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo $employee->employee.' '.$employee->nmsubdept ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Jabatan</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo $employee->nmjabatan ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">No.Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo (!empty($default->transaction->no_telp) ? $default->transaction->no_telp : $employee->nohp1) ?>" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-primary" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data Dinas</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4">Jenis Tujuan</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo (!empty($default->destinationtype->text) ? $default->destinationtype->text : 'Lainnya' ) ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tujuan Kota</label>
                                <div class="col-sm-8">
                                    <select name="tujuan_kota[]" class="select2 form-control " id="tujuan_kota[]" multiple readonly>
                                        <?php if (isset($default->citycashbon) && count($default->citycashbon) > 0) {
                                            foreach ($default->citycashbon as $index => $row) { ?>
                                                <option value="<?php echo $row->id ?>" selected ><?php echo $row->text ?></option>
                                            <?php }
                                        } else { ?>
                                            <option></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Kategori Keperluan</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo $default->kategori->text ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Callplan</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo $default->transaction->callplan_reformat ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Keperluan Dinas</label>
                                <div class="col-sm-8">
                                    <textarea name="" rows="10" class="form-control textarea-noresize" readonly><?php echo $default->transaction->keperluan ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tanggal Berangkat</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo date('d-m-Y H:i', strtotime($default->transaction->tgl_mulai.' '.$default->transaction->jam_mulai)) ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tanggal Pulang</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo date('d-m-Y H:i', strtotime($default->transaction->tgl_selesai.' '.$default->transaction->jam_selesai)) ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tipe Transportasi</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo (!empty($default->tipe_transportasi->text) ? $default->tipe_transportasi->text : 'Lainnya') ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Transportasi</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo (!empty($default->transportasi->text) ? $default->transportasi->text : 'Lainnya') ?>" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="col-sm-12">
            <?php if (trim($default->transaction->status) == 'A' AND $canapprove) { ?>
            <button type="submit" class="btn btn-success ml-3 pull-right space">Setujui</button>
            <?php } ?>
            <button type="reset" class="btn btn-danger ml-3 pull-right space">Batal Dinas</button>
        </div>
    </div>
</div>
</form>
<script>
    $(document).ready(function() {
        $('select[name=\'tujuan_kota[]\']').select2({
            disabled:true,
            ajax: {
                url: '<?php echo site_url('trans/citycashbon/search'); ?>',
                dataType: 'json',
                delay: 250,
                multiple: true,
                closeOnSelect: false,
                data: function (params) {
                    return {
                        group: $('[name=\'jenis_tujuan\']').val(),
                        search: params.term,
                        page: params.page,
                        perpage: 7
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.location,
                        pagination: {
                            more: (params.page * 7) < data.totalcount
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Pilih tujuan kota...',
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 0,
            templateResult: function (repo) {
                if (repo.loading) {
                    return repo.text;
                }
                return `
<div class='row' style='width: 400px'>
    <div class='col-sm-2'>${repo.id}</div>
    <div class='col-sm-4'>${repo.text}</div>
</div>`;
            },
            templateSelection: function (repo) {
                return repo.text || repo.text;
            },
        }).on('change', function(e) {});
        $.extend($.validator.messages, {
            required: 'Bagian ini diperlukan...',
            remote: 'Harap perbaiki bidang ini...',
            email: 'Harap masukkan email yang valid...',
            url: 'Harap masukkan URL yang valid...',
            date: 'Harap masukkan tanggal yang valid...',
            dateISO: 'Harap masukkan tanggal yang valid (ISO)...',
            birthdate: 'Harap masukkan tanggal lahir tidak lebih dari 120 tahun...',
            time: 'Harap masukkan waktu yang valid...',
            number: 'Harap masukkan nomor valid...',
            digits: 'Harap masukkan hanya digit angka...',
            creditcard: 'Harap masukkan nomor kartu kredit yang benar...',
            equalTo: 'Harap masukkan nilai yang sama lagi...',
            accept: 'Harap masukkan nilai dengan ekstensi valid...',
            maxlength: $.validator.format('Harap masukkan tidak lebih dari {0} karakter...'),
            minlength: $.validator.format('Harap masukkan sedikitnya {0} karakter...'),
            rangelength: $.validator.format('Harap masukkan nilai antara {0} dan {1} karakter...'),
            range: $.validator.format('Harap masukkan nilai antara {0} dan {1}...'),
            max: $.validator.format('Harap masukkan nilai kurang dari atau sama dengan {0}...'),
            min: $.validator.format('Harap masukkan nilai lebih besar dari atau sama dengan {0}...'),
            alphanumeric: 'Harap masukkan hanya huruf dan angka',
            longlat: 'Harap masukkan hanya latitude dan longitude',
        });
        $.validator.addMethod('greaterThan', function(value, element, params) {
            if ($(params[0]).val().length && value.length) {
                return $(element).data('DateTimePicker').date().toDate() > $(params[0]).data('DateTimePicker').date().toDate();
            }
            return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val()));
        }, 'Nilai harus lebih besar dari {1}');
        $.validator.addMethod('lessThan', function(value, element, params) {
            if ($(params[0]).val().length && value.length) {
                return $(element).data('DateTimePicker').date().toDate() < $(params[0]).data('DateTimePicker').date().toDate();
            }
            return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val()));
        }, 'Nilai harus lebih kecil dari {1}');
        $('form.formupdatedinas').submit(function(e){
            e.preventDefault();
        }).bind('reset', function(){
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi Batal Dinas',
                html: 'Konfirmasi batal data <b>Dinas Karyawan</b> ?',
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.getJSON('<?php echo site_url('trans/dinas/dodelete/'.bin2hex(json_encode(array('branch' => $employee->branch, 'nik' => $default->transaction->nik, 'nodok' => $default->transaction->nodok, )))) ?>', {})
                        .done(function(data) {
                            window.location.replace('<?php echo site_url('trans/dinas') ?>');
                        })
                        .fail(function(xhr, status, thrown) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Gagal Batal Dinas',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            }).then(function () {
                            });
                        });
                }
            });
        }).validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: '',
            messages: {},
            rules: { },
            onfocusout: function(element) {
                $(element).valid();
            },
            invalidHandler: function(event, validator) { },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2') && element.next('.select2-container').length) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.is(':checkbox')) {
                    error.insertAfter(element.closest('.md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline'));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest('.md-radio-list, .md-radio-inline, .radio-list,.radio-inline'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
            },
            submitHandler: function(form) {
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm btn-success ml-3',
                        cancelButton: 'btn btn-sm btn-warning ml-3',
                        denyButton: 'btn btn-sm btn-danger ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    title: 'Konfirmasi Setujui',
                    html: 'Konfirmasi setujui data <b>Dinas Karyawan</b> ?',
                    icon: 'question',
                    showCloseButton: true,
                    confirmButtonText: 'Konfirmasi',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $('form.formupdatedinas').attr('action'),
                            data: $('form.formupdatedinas').serialize(),
                            type: 'POST',
                            success: function (data) {
                                Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-sm btn-success ml-3',
                                        cancelButton: 'btn btn-sm btn-warning ml-3',
                                        denyButton: 'btn btn-sm btn-danger ml-3',
                                    },
                                    buttonsStyling: false,
                                }).fire({
                                    position: 'top',
                                    icon: 'success',
                                    title: 'Berhasil Disetujui',
                                    html: data.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    showDenyButton: true,
                                    denyButtonText: `Tutup`,
                                }).then(function(){
                                    window.location.replace('<?php echo site_url('trans/dinas') ?>');
                                });
                            },
                            error: function (xhr, status, thrown) {
                                Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-sm btn-success ml-3',
                                        cancelButton: 'btn btn-sm btn-warning ml-3',
                                        denyButton: 'btn btn-sm btn-danger ml-3',
                                    },
                                    buttonsStyling: false,
                                }).fire({
                                    position: 'top',
                                    icon: 'error',
                                    title: 'Gagal Disetujui',
                                    html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    showDenyButton: true,
                                    denyButtonText: `Tutup`,
                                }).then(function(){ });
                            },
                        });
                    }
                });
            },
        });
    });
</script>
