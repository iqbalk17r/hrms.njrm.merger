<div class="modal-dialog <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <form id="update-event-result" class="update-event-result" action="<?php echo $formAction ?>" method="post" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo $modalTitle ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4">NIK</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="nik" value="<?php echo trim($employee->nik); ?>"
                                           class="form-control" style="text-transform:uppercase"
                                           readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Nama Karyawan</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="kdlvl1" value="<?php echo trim($employee->nmlengkap); ?>" class="form-control" style="text-transform:uppercase"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Department</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="department1"
                                           value="<?php echo trim($employee->nmdept); ?>" class="form-control"
                                           style="text-transform:uppercase"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Jabatan</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="jabatan1"
                                           value="<?php echo trim($employee->nmjabatan); ?>" class="form-control"
                                           style="text-transform:uppercase"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="jabatan1"
                                           value="<?php echo trim($employee->mergephone); ?>" class="form-control"
                                           style="text-transform:uppercase"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Penyelenggara</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="atasan1"
                                           value="<?php echo trim($transaction->organizer_name); ?>" class="form-control"
                                           style="text-transform:uppercase"  readonly>
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
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4">Lokasi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" name="location" id="location" value="<?php echo $transaction->location ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Pretest</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="pretest" id="pretest"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Posttest</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="posttest" id="posttest"  >
                                </div>
                            </div>
                            <div class="form-group hide">
                                <label class="col-sm-4">Nilai</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="score" id="score"  >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Hasil</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" name="result_text" id="result_text"  >
                                </div>
                            </div>
                            <?php if($transaction->agenda_type == 'COACH') { ?>
                                <div class="form-group">
                                    <label class="col-sm-4">Sertifikat</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control" id="customFile" name="sertificate" accept="application/pdf" required>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar">
                    <button type="reset" class="btn btn-warning cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success save" >Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function (){
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
        $('form.update-event-result').submit(function (e) {
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
                html: 'Konfirmasi reset data <b>Hasil</b> ?',
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.getJSON('<?php echo site_url('agenda/counseling/doreset') ?>', {})
                        .done(function (data) {
                            $('div#modal-event-result').modal('hide');
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
                pretest: {
                    required: true,
                    number: true,
                },
                posttest: {
                    required: true,
                    number: true,
                },
                score: {
                    required: false,
                    number: true,
                },
                result_text: {
                    required: true,
                    alphanumeric: true,
                },
                <?php if($transaction->agenda_type == 'SERT') { ?>
                sertificate: {
                    required: true,
                    extension: "pdf",
                },
                <?php } ?>

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
                var formData = new FormData(form);
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm btn-success ml-3',
                        cancelButton: 'btn btn-sm btn-warning ml-3',
                        denyButton: 'btn btn-sm btn-danger ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    title: 'Konfirmasi Simpan',
                    html: `Konfirmasi simpan data<br/><b>Hasil</b> ?`,
                    icon: 'question',
                    showCloseButton: true,
                    confirmButtonText: 'Konfirmasi',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $('form.update-event-result').attr('action'),
                            data: formData,
                            type: 'POST',
                            cache: false,
                            contentType: false,
                            processData: false,
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
                                    title: 'Berhasil Dibuat',
                                    html: data.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showCloseButton: true,
                                    showConfirmButton: true,
                                    showDenyButton: false,
                                    confirmButtonText: `Tutup`,
                                }).then(function () {
                                    $('div#modal-event-result').modal('hide');
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
    })
</script>
