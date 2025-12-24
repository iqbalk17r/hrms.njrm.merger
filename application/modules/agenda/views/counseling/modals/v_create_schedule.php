<style>
</style>
<div class="modal-dialog <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <form id="create-schedule" class="form create-schedule" action="<?php echo $formAction ?>" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo $modalTitle ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" name="session_date" placeholder="Pilih tanggal">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Jam Mulai</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" name="begin_time" placeholder="Pilih jam mulai">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Jam Selesai</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" name="end_time" placeholder="Pilih jam selesai">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Lokasi</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" name="location" placeholder="Lokasi">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-warning" >Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
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

        $('form.create-schedule').submit(function (e) {
            e.preventDefault();
        }).bind('reset', function () {
            $.getJSON('<?php echo site_url('agenda/counseling/doreset') ?>', {})
                .done(function (data) {
                    $('div#modal-schedule').modal('hide');
                    $('table#table-counseling').DataTable().draw(false);
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
        }).validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: '',
            messages: {},
            rules: {
                session_id: {
                    required: true,
                },
                session_date: {
                    required: true,
                },
                begin_time: {
                    required: true,
                    time : true,
                },
                end_time: {
                    required: true,
                    time : true,
                },
                location: {
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
                    html: `Konfirmasi simpan data<br/><b>Konseling</b> ?`,
                    icon: 'question',
                    showCloseButton: true,
                    confirmButtonText: 'Konfirmasi',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $('form.create-schedule').attr('action'),
                            data: $('form.create-schedule').serialize(),
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
                                    $('div#modal-schedule').modal('hide');
                                    $('table#table-counseling').DataTable().draw(false);
                                });
                            },
                            error: function (xhr, status, thrown) {
                                console.log(xhr)
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

        $('input[name=\'session_date\']').datepicker({
            startDate: '-2m',
            constrainInput: false,
            gotoCurrent: true,
            format: 'dd-mm-yyyy',
        })
        $('input[name="begin_time"]').clockpicker({
            donetext: `<b><i class="fa fa-fw fa-check"></i> PILIH</b>`,
            constrainInput: false,
            twelvehour: false
        }).on('change', function () {
            if ($('input[name="session_date"]').val().length == 0) {
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
                    title: `Pilih tanggal terlebih dahulu`,
                    showCloseButton: true,
                    showConfirmButton: true,
                    confirmButtonText: `Tutup`,
                }).then(function () {
                    $('input[name="begin_time"]').clockpicker('clear'); // Clear using clockpicker method if available
                });
            } else {
                $(this).valid(); // Trigger validation
                $('input[name="end_time"]').val(''); // Clear end_time input
            }
        });
        $('input[name=\'end_time\']').clockpicker({
            donetext: `<b><i class="fa fa-fw fa-check"></i> PILIH</b>`,
            twelvehour: false
        }).on('change',function (){
            if ($('input[name=\'begin_time\']').val().length == 0){
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
                    title: `Pilih jam mulai terlebih dahulu`,
                    showCloseButton: true,
                    showConfirmButton: true,
                    confirmButtonText: `Tutup`,
                }).then(function () {
                    $('input[name=\'end_time\']').val('')
                });
            }else{
                $(this).valid()
                var begin = $('input[name=\'begin_time\']').val()
                var end = $('input[name=\'end_time\']').val()
                $.ajax({
                    url: '<?php echo $timeCheckUrl ?>',
                    type: 'POST',
                    data:{begin:begin,end:end},
                    success: function (data) {

                    },
                    error: function (xhr, status, thrown) {
                        console.log(xhr)
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
                            title: xhr.responseJSON.statusText,
                            html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: `Tutup`,
                        }).then(function () {
                            $('input[name=\'end_time\']').val('')
                        });
                    },
                })
            }

        });
    })

</script>