<div class="modal-dialog <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <form id="update-agenda" class="form update-agenda" action="<?php echo $formAction ?>" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo $modalTitle ?></h4>
            </div>
            <div class="modal-body">
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
                            <input type="text" class="form-control text-uppercase" name="agenda_type" id="agenda_type" value="<?php echo $transaction->agenda_type_name ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Tipe Penyelenggara</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" name="organizer_type" id="organizer_type" value="<?php echo $transaction->organizer_type_name ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Nama Penyelenggara</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" name="organizer_name" id="organizer_name" value="<?php echo $transaction->organizer_name ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Jumlah Peserta</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" name="organizer_name" id="organizer_name" value="<?php echo $transaction->participant_count ?>" readonly>
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
                    <?php if (!is_null($agendaData) && $agendaData->nik == trim($this->session->userdata('nik')) ){ ?>
                        <div class="form-group">
                            <label class="col-sm-4">Konfirmasi Undangan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-uppercase" value="<?php echo $agendaData->confirm_status_text ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Kehadiran Acara</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-uppercase" value="<?php echo $agendaData->attend_status_text ?>" readonly>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar">
                    <button type="button" class="btn btn-warning pull-left close-modal" data-dismiss="modal">Tutup</button>
                    <button type="reset" class="btn btn-warning cancel" >Batal</button>
                    <button type="submit" class="btn btn-success save" >Simpan</button>
                    <?php if ($userhr){ ?>
                    <button type="button" class="btn btn-linkedin send-notification" data-href="<?php echo $notificationUrl?>"><i class="fa fa-fw fa-bell-o"></i> Kirim Notif</button>

                    <button type="button" class="btn btn-info participant" data-href="<?php echo $participantUrl?>">Peserta</button>
                        <?php if($canmodifyresult){ ?>

                            <button type="button" class="btn btn-success event-result" data-href="<?php echo $eventResult ?>">Hasil</button>
                        <?php }else{ ?>
                            <button type="button" class="btn btn-primary update" data-href="<?php echo $updateUrl?>">Ubah data</button>
                        <?php } ?>
                    <?php } ?>


                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function (){
        $('button.save').hide()
        $('button.cancel').hide()
        $('button.update').on('click', function (){
            var row = $(this)
            window.location.replace(row.data('href'))
            /*$('button.save').show()
            $('button.cancel').show()
            $('button.close-modal').hide()
            $('button.update').hide()
            $('button.participant').hide()
            $('button.result').hide()
            $('input[name=\'agenda_name\']').attr("readonly", false);
            $('input[name=\'begin_date\']').attr("readonly", false);
            $('input[name=\'end_date\']').attr("readonly", false);
            $('input[name=\'location\']').attr("readonly", false);
            $('textarea[name=\'description\']').attr("readonly", false);*/
        })
        $('button.participant-result').on('click', function () {
            var row = $(this)
            window.location.replace(row.data('href'))
        });
        $('button.participant').on('click', function () {
            var row = $(this)
            window.location.replace(row.data('href'))
        });
        $('button.event-result').on('click', function () {
            var row = $(this)
            window.location.replace(row.data('href'))
        });
        $('button.attendance').on('click', function (){
            var row = $(this);
            $.getJSON(row.attr('data-href'), {})
                .done(function (data) {
                    if (data.canupdate) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statusText,
                            html: data.message,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: data.confirmText,
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isConfirmed){
                                $.ajax({
                                    url: data.next.confirm,
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
                                            title: 'Berhasil Disimpan',
                                            html: data.message,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            showCloseButton: true,
                                            showConfirmButton: false,
                                            showDenyButton: true,
                                            denyButtonText: `Tutup`,
                                        }).then(function () {

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
                                            showConfirmButton: false,
                                            showDenyButton: true,
                                            denyButtonText: `Tutup`,
                                        }).then(function () {
                                        });
                                    },
                                });
                            }
                        });
                    }
                    if (data.cancreate) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-danger ml-3',
                                denyButton: 'btn btn-sm btn-primary ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statusText,
                            html: data.message,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: data.confirmText,
                            showDenyButton: true,
                            denyButtonText: data.denyText,
                            showCancelButton: true,
                            cancelButtonText: 'Tutup',
                        }).then(function (result) {
                            if (result.isConfirmed){
                                $.ajax({
                                    url: data.next.accept,
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
                                            title: 'Berhasil Disimpan',
                                            html: data.message,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            showCloseButton: true,
                                            showConfirmButton: false,
                                            showDenyButton: true,
                                            denyButtonText: `Tutup`,
                                        }).then(function () {

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
                                            showConfirmButton: false,
                                            showDenyButton: true,
                                            denyButtonText: `Tutup`,
                                        }).then(function () {
                                        });
                                    },
                                });
                            }
                            if (result.isDenied){
                                $.ajax({
                                    url: data.next.reject,
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
                                            title: 'Berhasil Disimpan',
                                            html: data.message,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            showCloseButton: true,
                                            showConfirmButton: true,
                                            confirmButtonText: `Tutup`,
                                        }).then(function () {

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
                                            showConfirmButton: false,
                                            showDenyButton: true,
                                            denyButtonText: `Tutup`,
                                        }).then(function () {
                                        });
                                    },
                                });
                            }
                        });
                    }
                    if (data.canattend) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-danger ml-3',
                                denyButton: 'btn btn-sm btn-primary ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statusText,
                            html: data.message,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: data.confirmText,
                            showCancelButton: true,
                            cancelButtonText: 'Tutup',
                        }).then(function (result) {
                            if (result.isConfirmed){
                                $.ajax({
                                    url: data.next.confirm,
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
                                            title: 'Berhasil Disimpan',
                                            html: data.message,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            showCloseButton: true,
                                            showConfirmButton: false,
                                            showDenyButton: true,
                                            denyButtonText: `Tutup`,
                                        }).then(function () {

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
                                            showConfirmButton: false,
                                            showDenyButton: true,
                                            denyButtonText: `Tutup`,
                                        }).then(function () {
                                        });
                                    },
                                });
                            }
                            if (result.isDenied){
                                $.ajax({
                                    url: data.next.reject,
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
                                            title: 'Berhasil Disimpan',
                                            html: data.message,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            showCloseButton: true,
                                            showConfirmButton: true,
                                            confirmButtonText: `Tutup`,
                                        }).then(function () {

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
                                            showConfirmButton: false,
                                            showDenyButton: true,
                                            denyButtonText: `Tutup`,
                                        }).then(function () {
                                        });
                                    },
                                });
                            }
                        });
                    }
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
                        icon: (xhr.responseJSON && xhr.responseJSON.icon ? 'warning' : 'error'),
                        title: (xhr.responseJSON && xhr.responseJSON.statusText ? xhr.responseJSON.statusText : 'Terjadi Kesalahan'),
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: true,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                    });
                });
        })
        $('button.send-notification').on('click', function (){
            var row = $(this);
            $.getJSON(row.attr('data-href'), {})
                .done(function (data) {
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
                        title: 'Berhasil Disimpan',
                        html: data.message,
                        timer: 3000,
                        timerProgressBar: true,
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function () {
                    });
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
                        icon: (xhr.responseJSON && xhr.responseJSON.icon ? 'warning' : 'error'),
                        title: (xhr.responseJSON && xhr.responseJSON.statusText ? xhr.responseJSON.statusText : 'Terjadi Kesalahan'),
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: true,
                        confirmButtonText: `Tutup`,
                    }).then(function () {
                    });
                });
        })


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
                    $.getJSON('<?php echo site_url('agenda/event/doreset') ?>', {})
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
                agenda_name: {
                    required: true,
                },
                agenda_type: {
                    required: true,
                },
                organizer_type: {
                    required: true,
                },
                organizer_name: {
                    required: true,
                },
                begin_date: {
                    required: true,
                },
                end_date: {
                    required: true,
                },
                location: {
                    required: true,
                },
                description: {
                    required: true,
                },

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
                                    title: 'Berhasil Dibuat',
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
                $('input[name=\'organizer_name\']').attr('readonly','readonly')
            }else{
                $('input[name=\'organizer_name\']').removeAttr('readonly');
                $('input[name=\'organizer_name\']').val('');
            }
            $(this).valid()
        });
    })
</script>
