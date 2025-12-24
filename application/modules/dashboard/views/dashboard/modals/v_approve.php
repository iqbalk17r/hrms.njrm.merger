<?php //var_dump();die(); ?>
<style>
    .ml-3{
        margin-left:3px;
    }
    textarea{
        resize: none;
    }
</style>
<div class="modal-dialog modal-dialog-scrollable <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <div class="modal-content">
        <form role="form" name="formdecision" id="formdecision" action="<?php ?>" method="post" class="m-0">
            <div class="modal-header bg-success">
                <h4 class="modal-title"><?php echo(isset($modalTitle) ? $modalTitle : 'Header') ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input type="text" class="form-control" readonly value="<?php echo '('.$default->nik.') '.$default->fullname ?>">
                    <input type="hidden" name="docno" value="<?php echo $default->docno; ?>">
                    <input type="hidden" name="reject_reason" >
                    <input type="hidden" name="approve_reason" >
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Departemen</label>
                    <input type="text" class="form-control" readonly value="<?php echo $default->department_name ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Subdepartemen</label>
                    <input type="text" class="form-control" readonly value="<?php echo $default->subdepartment_name ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Jabatan</label>
                    <input type="text" class="form-control" readonly value="<?php echo $default->position_name ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Dokumen</label>
                    <input type="text" class="form-control" readonly value="<?php echo trim($default->document_name).' ('.$default->docno.')' ?>" readonly>
                    <input type="hidden" name="documentType" class="form-control" readonly value="<?php echo trim($default->document_type); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Keterangan</label>
                    <textarea name="" id="" cols="30" rows="8" class="form-control" readonly><?php echo trim($default->description).PHP_EOL.trim(strip_tags($default->detail_information)) ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success approve pull-left" data-action="approve" data-href="<?php echo $decisionUrl ?>">Setuju</button>
                <button type="button" class="btn btn-danger cancel pull-left" data-action="cancel" data-href="<?php echo $decisionUrl ?>" >Tolak</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('button.cancel').on('click', function(){
            var row = $(this);
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi Tolak',
                html: 'Konfirmasi tolak <b><?php echo $default->document_name ?></b> ?',
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            }).then(function (result) {
                if (result.isConfirmed) {
                    if ($('input[name=\'documentType\']').val() == 'LB'){
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-md btn-success ml-3',
                                cancelButton: 'btn btn-md btn-warning ml-3',
                                denyButton: 'btn btn-md btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            title: "Masukkan alasan anda !",
                            input: 'textarea',
                            inputAttributes: {
                                autocapitalize: 'off',
                                required: true,
                                oninput: "this.value = this.value.toUpperCase()",
                            },
                            inputValidator: (value) => {
                                if (!value) {
                                    return `<b>Alasan tidak boleh kosong</b>`
                                }
                            },
                            showConfirmButton: true,
                            confirmButtonText: 'Simpan',
                            showCancelButton: true,
                            cancelButtonText: 'Batal',
                        }).then((result) => {
                            $('input[name=\'reject_reason\']').val(result.value);
                            var parameter = {
                                reason: $('input[name=\'reject_reason\']').val(),
                                docno: $('input[name=\'docno\']').val(),
                                action: row.data('action')
                            };
                            if (result.value) {
                                $.ajax({
                                    url: row.data('href'),
                                    data: JSON.stringify(parameter),
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
                                            title: data.statusText,
                                            html: data.message,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            showCloseButton: true,
                                            showConfirmButton: true,
                                            confirmButtonText: `Tutup`,
                                        }).then(function () {
                                            $('div#modify-data').modal('hide');
                                            $('table#table-document-list').DataTable().draw(false);
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
                                            title: 'Gagal simpan',
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
                    }else{
                        $.ajax({
                            url: row.data('href'),
                            data: JSON.stringify(parameter),
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
                                    title: data.statusText,
                                    html: data.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showCloseButton: true,
                                    showConfirmButton: true,
                                    confirmButtonText: `Tutup`,
                                }).then(function () {
                                    $('div#modify-data').modal('hide');
                                    $('table#table-document-list').DataTable().draw(false);
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
                                    title: 'Gagal simpan',
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

                }
            });
        })
        $('button.approve').on('click', function(){
            var row = $(this);
            var parameter = {
                docno: $('input[name=\'docno\']').val(),
                action: row.data('action')
            };
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi Setujui',
                html: 'Konfirmasi persetujuan <b><?php echo $default->document_name ?></b> ?',
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            }).then(function (result) {
                if (result.isConfirmed) {
                    if ($('input[name=\'documentType\']').val() == 'LB'){
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-md btn-success ml-3',
                                cancelButton: 'btn btn-md btn-warning ml-3',
                                denyButton: 'btn btn-md btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            title: "Masukkan alasan anda !",
                            input: 'textarea',
                            inputAttributes: {
                                autocapitalize: 'off',
                                required: true,
                                oninput: "this.value = this.value.toUpperCase()",
                            },
                            inputValidator: (value) => {
                                if (!value) {
                                    return `<b>Alasan tidak boleh kosong</b>`
                                }
                            },
                            showConfirmButton: true,
                            confirmButtonText: 'Simpan',
                            showCancelButton: true,
                            cancelButtonText: 'Batal',
                        }).then((result) => {
                            $('input[name=\'approve_reason\']').val(result.value);
                            var parameter = {
                                reason: $('input[name=\'approve_reason\']').val(),
                                docno: $('input[name=\'docno\']').val(),
                                action: row.data('action')
                            };
                            if (result.value) {
                                $.ajax({
                                    url: row.data('href'),
                                    data: JSON.stringify(parameter),
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
                                            title: data.statusText,
                                            html: data.message,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            showCloseButton: true,
                                            showConfirmButton: true,
                                            confirmButtonText: `Tutup`,
                                        }).then(function () {
                                            $('div#modify-data').modal('hide');
                                            $('table#table-document-list').DataTable().draw(false);
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
                                            title: 'Gagal simpan',
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
                    }else{
                        $.ajax({
                            url: row.data('href'),
                            data: JSON.stringify(parameter),
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
                                    title: data.statusText,
                                    html: data.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showCloseButton: true,
                                    showConfirmButton: true,
                                    confirmButtonText: `Tutup`,
                                }).then(function () {
                                    $('div#modify-data').modal('hide');
                                    $('table#table-document-list').DataTable().draw(false);
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
                                    title: 'Gagal simpan',
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
                }
            });
        })
    })
</script>
