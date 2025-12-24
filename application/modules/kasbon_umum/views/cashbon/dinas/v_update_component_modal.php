<?php
?>
<style>
    div.modal-content div.modal-body input{
        font-size: 20px;
    }
    div.modal-content div.modal-body label{
        font-size: medium;
    }
    .modal-body {
        max-height: 60vh; overflow-y: auto;
    }
</style>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" class="formupdatecashboncomponent" action="<?php echo site_url('kasbon_umum/cashbondinas/doupdatecomponentpopup/'.bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $dutieid, 'cashbonid' => $cashbon->cashbonid ))))?>" method="post">
            <div class="modal-header">
                <h3 class="modal-title"><?php echo $title ?></h3>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <?php foreach ($dinas as $index => $item) { ?>
                    <span class="h3 text-blue"><b><?php echo $item->nodok ?></b></span>
                    <?php foreach ((count($cashboncomponents) > 0 ? $cashboncomponents : $cashboncomponentsempty) as $index => $row ) { ?>
                        <?php if($row->dutieid == $item->nodok){ ?>
                    <div class="form-group">
                        <input type="hidden" name="id[]" class="form-control" value="<?php echo $row->componentid ?>" readonly/>
                        <input type="hidden" name="dutieid[]" class="form-control" value="<?php echo $row->dutieid ?>" readonly/>
                        <label class="col-sm-3"><?php echo $row->componentname ?></label>
                        <div class="col-sm-3">
                            <input type="text" name="nominal[]" class="form-control text-right autonumeric" value="<?php echo $row->nominal ?>" <?php echo ($row->readonly == 't' ? 'readonly' : '') ?> autocomplete="off"/>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="description[]" class="form-control" value="<?php echo $row->description ?>" <?php echo ($row->readonly == 't' ? 'readonly' : '') ?> autocomplete="off"/>
                        </div>
                    </div>
                            <?php } ?>
                    <?php } ?>
                        <hr class="hr text-info" />
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
            </form>
        </div>
    </div>
<script>
    $(document).ready(function() {
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
        AutoNumeric.multiple('input.autonumeric', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: 0,
            unformatOnSubmit: true,
        });
        $('form.formupdatecashboncomponent').on('keypress', function(e) {
            return e.which !== 13;
        }).submit(function(e){
            e.preventDefault();
        }).bind('reset', function(){
        }).validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: '',
            messages: {},
            rules: {},
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
                    title: 'Konfirmasi Simpan',
                    html: 'Konfirmasi simpan data <b>Detail Biaya Kasbon</b> ?',
                    icon: 'question',
                    showCloseButton: true,
                    confirmButtonText: 'Konfirmasi',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $('form.formupdatecashboncomponent').attr('action'),
                            data: $('form.formupdatecashboncomponent').serialize(),
                            type: 'POST',
                            success: function (data) {
                                $('div.modal#updatecashboncomponent').modal('hide');
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
                                    title: 'Berhasil Dirubah',
                                    html: data.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    showDenyButton: true,
                                    denyButtonText: `Tutup`,
                                }).then(function(){ });
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
                                    title: 'Gagal Dirubah',
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
