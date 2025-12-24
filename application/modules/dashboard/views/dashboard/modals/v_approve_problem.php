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
        <form role="form" name="update-outlet-period" id="update-outlet-period" action="<?php ?>" method="post" class="m-0">
            <div class="modal-header bg-success">
                <h4 class="modal-title"><?php echo(isset($modalTitle) ? $modalTitle : 'Header') ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input type="text" class="form-control" readonly value="<?php echo '('.$default->nik.') '.$default->fullname ?>">
                    <input type="hidden" name="docno" value="<?php echo $default->docno; ?>">
                    <input type="hidden" name="type" value="<?php echo $type; ?>">
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
                <?php if(in_array(trim($dtl->status), ['AP', 'BP'])): ?>
                    <div class="form-group">
                        <label>Apakah Perlu Surat Peringatan?</label>
                        <select id="peringatan" name="peringatan" style="width: 100%;" class="form-control" required>
                            <option value="n">TIDAK</option>
                            <option value="y">YA</option>
                        </select>
                        <script type="text/javascript">
                            $('#peringatan').selectize({
                                plugins: ['hide-arrow'],
                                options: [],
                                create: false,
                                initData: true
                            }).on('change', function() {
                                $('.tindakan').hide();
                                $('.tindaklanjut').hide();
                                document.getElementById("tindakan").required = false;
                                document.getElementById("tindaklanjut").required = false;

                                if($('#peringatan').val() == 'y') {
                                    $('.tindakan').show();
                                    document.getElementById("tindakan").required = true;
                                } else if($('#peringatan').val() == 'n') {
                                    $('.tindaklanjut').show();
                                    document.getElementById("tindaklanjut").required = true;
                                }
                            });
                            $("#peringatan").addClass("selectize-hidden-accessible");
                        </script>
                    </div>
                    <div class="form-group tindakan">
                        <label>Tindakan</label>
                        <select class="form-control" name="tindakan" id="tindakan" placeholder="--- TINDAKAN ---" required>
                            <option value="" class=""></option>
                            <?php foreach($list_tindakan as $v): ?>
                                <?php $result = array_map('trim', $v); ?>
                                <option value="<?= $v['docno'] ?>" data-data='<?= json_encode($result, JSON_HEX_APOS) ?>'></option>
                            <?php endforeach; ?>
                        </select>
                        <script type="text/javascript">
                            $('#tindakan').selectize({
                                plugins: ['hide-arrow', 'selectable-placeholder'],
                                valueField: 'docno',
                                labelField: 'docname',
                                searchField: ['docname'],
                                options: [],
                                create: false,
                                initData: true
                            });
                            $("#tindakan").addClass("selectize-hidden-accessible");
                        </script>
                    </div>
                    <div class="form-group tindaklanjut">
                        <label>Tindaklanjut</label>
                        <textarea class="form-control zz" id="tindaklanjut" name="tindaklanjut" placeholder="TINDAKLANJUT" style="text-transform: uppercase; resize: none;" rows="5" required><?= trim($dtl->tindaklanjut) ?></textarea>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success approve pull-left" data-action="approve" data-href="<?php echo $decisionUrl ?>">Setuju</button>
                <button type="button" class="btn btn-danger cancel pull-left" data-action="cancel" data-href="<?php echo $decisionUrl ?>" >Tolak</button>
                <button type="button" class="btn btn-default clear-temporary" data-href="<?php echo $clearTemporaryUrl ?>">Tutup</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#peringatan')[0].selectize.setValue("<?= trim($dtl->peringatan) ?: 'n' ?>");
        $('#tindakan')[0].selectize.setValue("<?= trim($dtl->tindakan) ?>");
        $('button.cancel').on('click', function(){
            var row = $(this);
            var parameter = {
                docno: $('input[name=\'docno\']').val(),
                action: row.data('action'),
                needReminder: $('select[name=\'peringatan\']').val(),
                documentAction: $('select[name=\'tindakan\']').val(),
                typeApproval: $('input[name=\'type\']').val(),
            };
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
        })
        $('button.approve').on('click', function(){
            var row = $(this);
            var parameter = {
                docno: $('input[name=\'docno\']').val(),
                action: row.data('action'),
                needReminder: $('select[name=\'peringatan\']').val(),
                documentAction: $('select[name=\'tindakan\']').val(),
                typeApproval: $('input[name=\'type\']').val(),
                followUp: $('textarea[name=\'tindaklanjut\']').val(),
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
                                //$('div#modify-data').modal('hide');
                                //$('table#table-document-list').DataTable().draw(false);
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
        });

        $('button.clear-temporary').on('click', function(){
            var row = $(this)
            $.getJSON(row.data('href'), {})
                .done(function(data) {
                    $('div#modify-data').modal('hide');
                })
                .fail(function(xhr, status, thrown) {
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
                        title: 'Gagal Memuat Data',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr
                            .statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function() {});
                });
        })
    })
</script>
