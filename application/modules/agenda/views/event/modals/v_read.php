<?php
// var_dump($agendaData);
// die();
?>
<style>
    .canceled {
        border: 2px dashed #DD4B39; /* btn-info border color */
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 5px;
    }
</style>
<div class="modal-dialog <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <form id="update-agenda" class="form update-agenda" action="<?php echo $formAction ?>" method="post">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title pull-left" id="myModalLabel"><?php echo $modalTitle ?></h4>
                <?php if ($transaction->status == 'C'){
                    echo '<h4 class="pull-right"><span class="label <?php echo $transaction->status_color ?>"><?php echo $transaction->status_text ?></span></h4>';
                } ?>

            </div>
            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4">Nomor Agenda</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" name="agenda_name" id="agenda_id" value="<?php echo $transaction->agenda_id ?>" readonly>
                        </div>
                    </div>
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
                    <?php if (strtoupper($transaction->agenda_type_name) != 'EVALUASI OJT') { ?>
                    <div class="form-group">
                        <label class="col-sm-4">Nama Penyelenggara</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" name="organizer_name" id="organizer_name" value="<?php echo $transaction->organizer_name ?>" readonly>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label class="col-sm-4">Jumlah Peserta</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" name="organizer_name"  value="<?php echo $transaction->participant_count ?>" readonly>
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
                        <label class="col-sm-4">Link</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control " name="link" id="link" value="<?php echo $transaction->link ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Keterangan</label>
                        <div class="col-sm-8">
                            <textarea name="description" id="description" class="form-control text-uppercase" cols="30" rows="9" readonly><?php echo $transaction->description ?></textarea>
                        </div>
                    </div>
                    <?php if ($transaction->status == 'C') { ?>
                        <div class="canceled">
                            <div class="form-group">
                                <label class="col-sm-4">Dibatalkan Oleh</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="cancel_by" id="cancel_by" value="<?php echo $transaction->cancel_by_name ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Alasan Pembatalan</label>
                                <div class="col-sm-8">
                                    <textarea name="cancel_reason" id="cancel_reason" class="form-control text-uppercase" cols="30" rows="9" readonly><?php echo $transaction->cancel_reason ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (!is_null($agendaData) && $agendaData->nik == trim($this->session->userdata('nik'))) { ?>
                        <div class="form-group">
                            <label class="col-sm-4">Konfirmasi Undangan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-uppercase"
                                       value="<?php echo $agendaData->confirm_status_text ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Kehadiran Acara</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-uppercase"
                                       value="<?php echo $agendaData->attend_status_text ?>" readonly>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <div class="modal-footer">
                <?php if ($transaction->status == 'C'){ ?>
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-warning pull-left close-modal" data-toggle="tooltip" title="Tutup" data-dismiss="modal"><i class="fa fa-close"></i></button>
                        <?php if ($userhr) { ?>
                            <button type="button" class="btn btn-instagram check-attendance pull-right bg-maroon-gradient" data-href="<?php echo $checkAttendanceUrl ?>" data-toggle="tooltip" title="Cek Kehadiran"><i class="fa fa-check"></i></button>
                            <button type="button" class="btn btn-instagram check-confirmation pull-right bg-green"  data-href="<?php echo $checkConfirmationUrl ?>" data-toggle="tooltip" title="Cek Konfirmasi"><i class="fa fa-square"></i></button>
                        <?php } ?>
                    </div>
                <?php }else{ ?>
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-warning pull-left close-modal" data-toggle="tooltip" title="Tutup" data-dismiss="modal"><i class="fa fa-close"></i></button>
                        <button type="button" class="btn btn-danger cancel" data-toggle="tooltip" title="Batal" data-href="<?php echo $cancelUrl ?>"><i class="fa fa-trash-o"></i></button>
                        <button type="submit" class="btn btn-success save">Simpan</button>
                        <?php if ($userhr) { ?>
                            <button type="button" class="btn btn-linkedin send-notification" data-toggle="tooltip" title="Kirim Notif" data-href="<?php echo $notificationUrl ?>"><i class="fa fa-fw fa-bell-o"></i></button>
                            <button type="button" class="btn btn-instagram check-attendance pull-right bg-maroon-gradient" data-href="<?php echo $checkAttendanceUrl ?>" data-toggle="tooltip" title="Cek Kehadiran"><i class="fa fa-check"></i></button>
                            <button type="button" class="btn btn-instagram check-confirmation pull-right bg-green"  data-href="<?php echo $checkConfirmationUrl ?>" data-toggle="tooltip" title="Cek Konfirmasi"><i class="fa fa-square"></i></button>
                            <?php if ($transaction->agenda_type_name == 'EVALUASI OJT') { ?>
                                <button type="button" class="btn btn-warning add-ojt-employee" data-toggle="tooltip" title="Tambah Karyawan OJT" data-href="<?php echo $addojt ?>">
                                    <i class="fa fa-user-plus"></i>
                                </button>
                            <?php } ?>
                            <?php if ($canmodifyresult) { ?>
                                <?php if ($agendaData->attend_status === 't' && $transaction->agenda_type_name == 'EVALUASI OJT') { ?>
                                    <button type="button" class="btn btn-success event-result" data-toggle="tooltip" title="Hasil" data-href="<?php echo site_url('ojt/list_result?param=' . $transaction->nikparam  .'&event=y'); ?>"><i class="fa fa-adjust"></i></button>
                                <?php } elseif ($agendaData->attend_status === 't') { ?>
                                    <button type="button" class="btn btn-success event-result" data-toggle="tooltip" title="Hasil" data-href="<?php echo $eventResult ?>"><i class="fa fa-adjust"></i></button>
                                <?php } ?>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary update" data-toggle="tooltip" title="Ubah data" data-href="<?php echo $updateUrl ?>"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-info participant" data-toggle="tooltip" title="Peserta" data-href="<?php echo $participantUrl ?>"><i class="fa fa-users"></i></button>
                            <?php } ?>
                        <?php } ?>
                        <?php if (!is_null($agendaData) && $agendaData->nik == trim($this->session->userdata('nik'))) { ?>
                            <?php if ($canmodifyresult) { ?>
                                <?php if ($agendaData->attend_status === 't' && $transaction->agenda_type_name == 'EVALUASI OJT') { ?>
                                    <button type="button" class="btn btn-success participant-result" data-href="<?php echo site_url('ojt/list_result?param=' . $transaction->nikparam  .'&event=y'); ?>">Hasil</button>
                                <?php } elseif ($agendaData->attend_status === 't') { ?>
                                    <button type="button" class="btn btn-success participant-result" data-href="<?php echo $eventResult ?>">Hasil</button>
                                <?php } ?>
                            <?php } else { ?>
                                <button type="button" class="btn btn-instagram attendance" data-toggle="tooltip" title="Kehadiran" data-href="<?php echo $attendUrl ?>"><i class="fa fa-check-circle"></i></button>
                            <?php } ?>
                        <?php } ?>

                    </div>
                <?php } ?>

            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger : 'mouseover',
        });
        $('button.save').hide()
        // $('button.cancel').hide()
        $('button.update').on('click', function () {
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

        $('button.cancel').on('click', async function () {
            const modal = $('.modal');
            modal.attr('inert', '');  // Add inert attribute to the modal to disable it

            const { value: reason } = await Swal.fire({
                input: "textarea",
                inputLabel: "Alasan Pembatalan",
                inputPlaceholder: "Tuliskan alasan pembatalan di sini...",
                inputAttributes: {
                    "aria-label": "Tuliskan alasan pembatalan di sini"
                },
                showCancelButton: true,
                cancelButtonText: 'Tutup',  // Correct option for cancel button text
                confirmButtonText: 'Simpan', // Add confirm button text
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
                willClose: () => {
                    modal.removeAttr('inert');  // Remove inert attribute to re-enable modal
                },
                preConfirm: (inputValue) => {
                    if (!inputValue.trim()) {
                        Swal.showValidationMessage('<b>Anda harus mengisi alasan pembatalan</b>');
                    }
                    return inputValue;
                }
            });

            if (reason) {
                Swal.fire({
                    icon: 'info',
                    position:'middle',
                    title: "Harap tunggu data sedang di proses, jangan tutup halaman ini",
                    allowEscapeKey: false,
                    allowOutsideClick:false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
                $.ajax({
                    url: $(this).data('href'),
                    type: 'POST',
                    data: { reason: reason },
                    success: function (data) {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Berhasil Disimpan',
                            html: data.message,
                            timer: 3000,
                            timerProgressBar: true,
                            showCloseButton: true,
                            confirmButtonText: `Tutup`,
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3'
                            },
                            buttonsStyling: false
                        });
                        $('div#modal-event').modal('hide');
                    },
                    error: function (xhr) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                            showCloseButton: true,
                            confirmButtonText: `Tutup`,
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3'
                            },
                            buttonsStyling: false
                        });
                    }
                });
            }
        });


        $('button.attendance').on('click', function () {
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
                            if (result.isConfirmed) {
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
                                            title: 'Terjadi Kesalahan',
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
                            if (result.isConfirmed) {
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
                                            title: 'Terjadi Kesalahan',
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
                            if (result.isDenied) {
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
                                            title: 'Terjadi Kesalahan',
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
                            if (result.isConfirmed) {
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
                                            title: 'Terjadi Kesalahan',
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
                            if (result.isDenied) {
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
                                            title: 'Terjadi Kesalahan',
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
        $('button.send-notification').on('click', function () {
            var row = $(this);
            Swal.fire({
                title: 'Konfirmasi',
                html: `Apakah anda ingin mengirim notifikasi Email dan WA ke semua peserta ?`,
                icon: 'question',
                showCloseButton: true,
                showConfirmButton: true,
                showDenyButton: true,
                showCancelButton:true,
                confirmButtonText: 'Ya, Lanjutkan',
                denyButtonText: `Tidak, Tertentu saja`,
                cancelButtonText:`tambah kalender`,
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                    cancelButton: 'btn btn-sm btn-info ml-3'
                },
                buttonsStyling: false,
                didRender: () => {
                    $('#addCalendar').on('click', function () {
                        // Aksi ketika tombol tambahan diklik
                        window.location.href = '<?php echo $sendcalendarUrl ?>'; // Ganti dengan URL sesuai kebutuhan Anda
                    });
                }
            }).then(function (result) {
                console.log(result)
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'info',
                        position:'middle',
                        title: "Harap tunggu data sedang di proses, jangan tutup halaman ini",
                        allowEscapeKey: false,
                        allowOutsideClick:false,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    $.getJSON(row.attr('data-href'), {})
                        .done(function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Disimpan',
                                html: data.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                showConfirmButton: true,
                                confirmButtonText: `Tutup`,
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3'
                                },
                                buttonsStyling: false,
                            });
                        })
                        .fail(function (xhr) {
                            Swal.fire({
                                icon: (xhr.responseJSON && xhr.responseJSON.icon ? 'warning' : 'error'),
                                title: (xhr.responseJSON && xhr.responseJSON.statusText ? xhr.responseJSON.statusText : 'Terjadi Kesalahan'),
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: true,
                                confirmButtonText: `Tutup`,
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3'
                                },
                                buttonsStyling: false,
                            });
                        });
                } else if (result.isDenied) {
                    window.location.replace('<?php echo $participantList ?>');
                } else if (result.isDismissed === true && result.dismiss === 'cancel' ){
                    Swal.fire({
                        icon: 'info',
                        position:'middle',
                        title: "Harap tunggu data sedang di proses, jangan tutup halaman ini",
                        allowEscapeKey: false,
                        allowOutsideClick:false,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    $.getJSON('<?php echo $sendcalendarUrl ?>', {})
                        .done(function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Disimpan',
                                html: data.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                showConfirmButton: true,
                                confirmButtonText: `Tutup`,
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3'
                                },
                                buttonsStyling: false,
                            });
                        })
                        .fail(function (xhr) {
                            Swal.fire({
                                icon: (xhr.responseJSON && xhr.responseJSON.icon ? 'warning' : 'error'),
                                title: (xhr.responseJSON && xhr.responseJSON.statusText ? xhr.responseJSON.statusText : 'Terjadi Kesalahan'),
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: true,
                                confirmButtonText: `Tutup`,
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3'
                                },
                                buttonsStyling: false,
                            });
                        });
                }
            });
        });


        $('button.send-notificationss').on('click', function () {
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
                                    title: 'Terjadi Kesalahan',
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
            format: 'DD-MM-YYYY HH:mm:ss',
            useCurrent: false,
        }).on("dp.change", function (e) {
            $('input[name=\'end_date\']').data("DateTimePicker").minDate(e.date);
        }).on('dp.hide', function () {
            var begin = $('input[name=\'begin_date\']').val()
            var end = $('input[name=\'end_date\']').val()
            if (begin == end) {
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
                    if (result.isConfirmed) {
                        $('input[name=\'begin_date\']').val('')
                    }
                });
            } else {
                $(this).valid()
            }
        })
        $('input[name=\'end_date\']').datetimepicker({
            locale: 'id',
            format: 'DD-MM-YYYY HH:mm:ss',
            useCurrent: false,
        }).on("dp.change", function (e) {
            $('input[name=\'begin_date\']').data("DateTimePicker").maxDate(e.date);
            // $(this).valid()
        }).on('dp.hide', function () {
            var begin = $('input[name=\'begin_date\']').val()
            var end = $('input[name=\'end_date\']').val()
            if (begin == end) {
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
                    if (result.isConfirmed) {
                        $('input[name=\'end_date\']').val('')
                    }
                });
            } else {
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
                        type: 'EVENT',
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
                        type: 'ORGANIZERTYPE',
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
            if ($(this).val() == 'IN') {
                $('input[name=\'organizer_name\']').val('<?php echo $branch->branchname ?>')
                $('input[name=\'organizer_name\']').attr('readonly', 'readonly')
            } else {
                $('input[name=\'organizer_name\']').removeAttr('readonly');
                $('input[name=\'organizer_name\']').val('');
            }
            $(this).valid()
        });
        $('button.check-confirmation').on('click', function (){
            var row = $(this);
            $('div#modal-event').modal('hide');
            loadmodal(row.data('href'));
        })
        $('button.add-ojt-employee').on('click', function (){
            var row = $(this);
            $('div#modal-event').modal('hide');
            loadmodal(row.data('href'));
        })
        $('button.check-attendance').on('click', function (){
            var row = $(this);
            $('div#modal-event').modal('hide');
            loadmodal(row.data('href'));
        })

    })
</script>
