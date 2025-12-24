<?php

?>
<style>
    .has-error .help-block,
    .has-error .control-label,
    .has-error .radio,
    .has-error .checkbox,
    .has-error .radio-inline,
    .has-error .checkbox-inline,
    .has-error.radio label,
    .has-error.checkbox label,
    .has-error.radio-inline label,
    .has-error.checkbox-inline label {
        color: #e73d4a;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
    select[multiple], select[size] {
        height: 34px;
        overflow: hidden;
    }
    select {
        appearance: none;
    }
    .select2-container--bootstrap {
        z-index: 9999;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        visibility: hidden;
    }

    .select2-container--bootstrap .select2-selection {
        border: 1px dashed #c2cad8;
    }
    .select2-container--bootstrap .select2-selection--single .select2-selection__rendered {
        padding: 0 0 0 12px;
    }
</style>
<legend><?php echo $title; ?></legend>
<form id="update-agenda" class="form update-agenda" action="<?php echo $formAction ?>" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-danger">
                    <div class="box-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4">Nama Agenda</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" name="agenda_name" id="agenda_name" value="<?php echo $transaction->agenda_name ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tipe Agenda</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" name="agenda_type_name" id="agenda_type_name" value="<?php echo $transaction->agenda_type_name ?>" readonly>
                                    <input type="hidden" class="form-control text-uppercase" name="agenda_type" id="agenda_type" value="<?php echo $transaction->agenda_type ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tipe Penyelenggara</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" name="organizer_type_name" id="organizer_type_name" value="<?php echo $transaction->organizer_type_name ?>" readonly>
                                    <input type="hidden" class="form-control text-uppercase" name="organizer_type" id="organizer_type" value="<?php echo $transaction->organizer_type ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Nama Penyelenggara</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" name="organizer_name" id="organizer_name" value="<?php echo $transaction->organizer_name ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tanggal mulai</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="begin_date" id="begin_date" value="<?php echo $transaction->begin_date ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tanggal selesai</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="end_date" id="end_date" value="<?php echo $transaction->end_date ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Lokasi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" name="location" id="location" value="<?php echo $transaction->location ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Keterangan</label>
                                <div class="col-sm-8">
                                    <textarea name="description" id="description" class="form-control text-uppercase" cols="30" rows="9" readonly><?php echo $transaction->description ?></textarea>
                                </div>
                            </div>

                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-sm-6">
                <div class="box box-success">
                    <div class="box-body" style="min-height: ">
                        <div class="form-horizontal">

                            <?php if ($canmodifyresult AND $transaction->agenda_type == 'MEET'){ ?>
                                <div class="form-group">
                                    <label class="col-sm-4">Hasil Meeting</label>
                                    <div class="col-sm-8">
                                        <textarea name="resulttext" id="resulttext" class="form-control text-uppercase" cols="30" rows="23" ><?php echo $transaction->resulttext ?></textarea>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="btn-toolbar">
                            <button type="submit" class="btn btn-md btn-success pull-right margin-right-10">Simpan</button>
                            <button type="reset" class="btn btn-md btn-warning pull-right margin-right-10">Kembali</button>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
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
        $.validator.addMethod('greaterThan', function (value, element, params) {
            if ($(params[0]).val().length && value.length) {
                return $(element).data('DateTimePicker').date().toDate() > $(params[0]).data('DateTimePicker').date().toDate();
            }
            return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val()));
        }, 'Nilai harus lebih besar dari {1}');
        $.validator.addMethod('lessThan', function (value, element, params) {
            if ($(params[0]).val().length && value.length) {
                return $(element).data('DateTimePicker').date().toDate() < $(params[0]).data('DateTimePicker').date().toDate();
            }
            return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val()));
        }, 'Nilai harus lebih kecil dari {1}');
        $('form.update-agenda').submit(function (e) {
            e.preventDefault();
        }).bind('reset', function () {
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi Reset',
                html: 'Konfirmasi reset data <b>Agenda</b> ?',
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.getJSON('<?php echo site_url('agenda/event/doreset/'.bin2hex(json_encode(array('agenda_id'=>$transaction->agenda_id)))) ?>', {})
                            .done(function (data) {
                            window.location.replace('<?php echo site_url('agenda/event/') ?>');
                        })
                        .fail(function (xhr, status, thrown) {
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
                                title: 'Gagal Direset',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: true,
                                showDenyButton: false,
                                confirmButtonText: `Tutup`,
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
            rules: {
                <?php if ($canmodifyresult AND $transaction->agenda_type == 'MEET'){
                    echo 'resulttext: {
                        required: true,
                    },';
                }?>

            },
            onfocusout: function (element) {
                $(element).valid();
            },
            invalidHandler: function (event, validator) {
            },
            errorPlacement: function (error, element) {
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
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
            },
            submitHandler: function (form) {
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm btn-success ml-3',
                        cancelButton: 'btn btn-sm btn-warning ml-3',
                        denyButton: 'btn btn-sm btn-danger ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    title: 'Konfirmasi Simpan',
                    html: `Konfirmasi simpan data<br/><b>Agenda</b> ?`,
                    icon: 'question',
                    showCloseButton: true,
                    confirmButtonText: 'Konfirmasi',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $('form.update-agenda').attr('action'),
                            data: $('form.update-agenda').serialize(),
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
                                    title: 'Berhasil disimpan',
                                    html: data.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showCloseButton: true,
                                    showConfirmButton: true,
                                    showDenyButton: false,
                                    confirmButtonText: `Tutup`,
                                }).then(function () {
                                    window.location.replace('<?php echo site_url('agenda/event') ?>');
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
                                    title: 'Gagal Dibuat',
                                    html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                    showCloseButton: true,
                                    showConfirmButton: true,
                                    showDenyButton: false,
                                    confirmButtonText: `Tutup`,
                                }).then(function () {
                                });
                            },
                        });
                    }
                });
            },
        });
        $('input[name=\'begin_date\']').datetimepicker({
            locale: 'id',
            format:'DD-MM-YYYY HH:mm:ss',
            useCurrent: false,
        }).on("dp.change", function (e) {
            $('input[name=\'end_date\']').data("DateTimePicker").minDate(e.date);
        }).on('dp.hide', function (){
            var begin = $('input[name=\'begin_date\']').val()
            var end = $('input[name=\'end_date\']').val()
            if (begin == end){
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
                    title: `tanggal awal dan akhir tidak boleh sama`,
                    showCloseButton: true,
                    showConfirmButton: true,
                    confirmButtonText: `Tutup`,
                }).then(function (result) {
                    if(result.isConfirmed){
                        $('input[name=\'begin_date\']').val('')
                    }
                });
            }else{
                $(this).valid()
            }
        })
        $('input[name=\'end_date\']').datetimepicker({
            locale: 'id',
            format:'DD-MM-YYYY HH:mm:ss',
            useCurrent: false,
        }).on("dp.change", function (e) {
            $('input[name=\'begin_date\']').data("DateTimePicker").maxDate(e.date);
            // $(this).valid()
        }).on('dp.hide', function (){
            var begin = $('input[name=\'begin_date\']').val()
            var end = $('input[name=\'end_date\']').val()
            if (begin == end){
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
                    title: `tanggal awal dan akhir tidak boleh sama`,
                    showCloseButton: true,
                    showConfirmButton: true,
                    confirmButtonText: `Tutup`,
                }).then(function (result) {
                    if(result.isConfirmed){
                        $('input[name=\'end_date\']').val('')
                    }
                });
            }else{
                $(this).valid()
            }
        });
        $('select[name=\'agenda_type\']').select2({
            readOnly: true,
            allowClear: true,
            ajax: {
                url: '<?php echo site_url('master/trxtype/search'); ?>',
                dataType: 'json',
                delay: 250,
                multiple: false,
                closeOnSelect: false,
                data: function (params) {
                    return {
                        type :'EVENT',
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
            placeholder: 'Pilih tipe agenda...',
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
        }).on('change', function (e) {
            $(this).valid()
        });
        $('select[name=\'organizer_type\']').select2({
            allowClear: true,
            ajax: {
                url: '<?php echo site_url('master/trxtype/search'); ?>',
                dataType: 'json',
                delay: 250,
                multiple: false,
                closeOnSelect: false,
                data: function (params) {
                    return {
                        type :'ORGANIZERTYPE',
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
            placeholder: 'Pilih tipe penyelenggara...',
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
        }).on('change', function (e) {
            if ($(this).val() == 'IN'){
                $('input[name=\'organizer_name\']').val('<?php echo $branch->branchname ?>')
                $('input[name=\'organizer_name\']').attr("readonly", true);
            }else{
                $('input[name=\'organizer_name\']').attr("readonly", false);
                $('input[name=\'organizer_name\']').val('');
            }
            $(this).valid()
        });


    })
</script>