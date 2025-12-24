<?php
?>
<style>

    .ml-3{
        margin-left: 3px;
    }
</style>
<form role="form" class="formupdatecashbon" action="<?php echo site_url('kasbon_umum/cashbon/doupdate/'.bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $cashbon->dutieid, 'cashbonid' => $cashbon->cashbonid, ))))?>" method="post">
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3 class="pull-left"><?php echo $title ?></h3>
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
                                <label class="col-sm-4">Nik</label>
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
                                    <input type="text" name="emp_phone" class="form-control" value="<?php echo $employee->merge_phone ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">No. Rekening</label>
                                <div class="col-sm-8">
                                    <input type="text" name="emp_account" class="form-control" value="<?php echo (!$employee->norek)?'(belum diatur)':$employee->norek.' ['.$employee->namabank.']' ?>" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-primary" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data Kasbon</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4">No. Kasbon</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="<?php echo $cashbon->cashbonid ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tipe</label>
                                <div class="col-sm-8">
                                    <input type="text" name="documenttype" class="form-control" value="<?php echo $cashbon->typetext ?>" readonly/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-4">Jenis Pembayaran</label>
                                <div class="col-sm-8">
                                    <select name="paymenttype" class="select2 form-control " id="paymenttype">
                                        <?php if (isset($paymenttype) && count($paymenttype) > 0) {
                                            foreach ($paymenttype as $index => $row) { ?>
                                                <option value="<?php echo $row->id ?>" selected ><?php echo $row->text ?></option>
                                            <?php }
                                        } else { ?>
                                            <option></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Jumlah Kasbon</label>
                                <div class="col-sm-8">
<!--                                    <input type="text" name="totalcashbon" readonly class="form-control autonumeric" value="--><?php //echo $cashbon->totalcashbonformat ?><!--" placeholder="masukkan nominal kasbon"/>-->
                                    <label for="totalcashbon" id="totalcashbon"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-success" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data Detail Kasbon</h3>
                        <a href="javascript:void(0)" class="btn btn-warning pull-right updatecashboncomponent">Edit Detail</a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped" id="cashboncomponent">
                                <?php include APPPATH.'\modules\kasbon_umum\views\cashbon\v_component_read.php';?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-success ml-3 pull-right">Simpan</button>
            <a type="button" data-href="<?php echo site_url('kasbon_umum/cashbon/doinvalidate/'.bin2hex(json_encode(array('cashbonid'=>$cashbon->cashbonid)))) ?>" class="btn btn-danger ml-3 pull-right cancel-cashbon">Batal Kasbon</a>
            <button type="reset" class="btn btn-warning ml-3 pull-right">Kembali</button>


        </div>
    </div>
</div>
</form>
<div class="modal fade" id="updatecashboncomponent" role="dialog" aria-hidden="true"></div>
<script>
    $(document).ready(function() {
        $('select[name=\'paymenttype\']').select2({
            ajax: {
                url: '<?php echo site_url('trans/transactiontype/search'); ?>',
                dataType: 'json',
                delay: 250,
                multiple: false,
                closeOnSelect: false,
                data: function (params) {
                    return {
                        group: 'PAYTYPE',
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
            placeholder: 'Pilih jenis pembayaran...',
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
        $('form.formupdatecashbon').submit(function(e){
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
                title: 'Konfirmasi Reset',
                html: 'Konfirmasi reset data <b>Kasbon Karyawan</b> ?',
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.getJSON('<?php echo site_url('kasbon_umum/cashbon/docancel/') ?>', {})
                        .done(function(data) {
                            window.location.replace('<?php echo site_url('kasbon_umum/cashbon/') ?>');
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
                                title: 'Gagal Direset',
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
            rules: {
                paymenttype: {
                    required: true,
                },
            },
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
                    title: 'Konfirmasi Ubah',
                    html: 'Konfirmasi ubah data <b>Kasbon Karyawan</b> ?',
                    icon: 'question',
                    showCloseButton: true,
                    confirmButtonText: 'Konfirmasi',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $('form.formupdatecashbon').attr('action'),
                            data: $('form.formupdatecashbon').serialize(),
                            type: 'POST',
                            success: function (data) {
                                Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-sm ml-3',
                                        cancelButton: 'btn btn-sm ml-3',
                                        denyButton: 'btn btn-sm ml-3',
                                    },
                                    buttonsStyling: false,
                                }).fire({
                                    position: 'top',
                                    icon: 'success',
                                    title: 'Berhasil Diubah',
                                    html: data.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    showDenyButton: true,
                                    denyButtonText: `Tutup`,
                                }).then(function(){
                                    window.location.replace('<?php echo site_url('kasbon_umum/cashbon/') ?>');
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
                                    title: 'Gagal Diubah',
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
        $('a.updatecashboncomponent').on('click', function () {
           $('div.modal#updatecashboncomponent')
               .empty()
               .load('<?php echo site_url('kasbon_umum/cashbon/updatecomponentpopup/'.bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $cashbon->dutieid, 'cashbonid' => $cashbon->cashbonid, 'type' => $cashbon->type )))) ?>', {}, function (response, status, xhr) {
                   if (status === 'error') {
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
                           title: 'Gagal Memuat Form',
                           html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                           showCloseButton: true,
                           showConfirmButton: false,
                           showDenyButton: true,
                           denyButtonText: `Tutup`,
                       }).then(function(){ });
                   } else {
                       $('div.modal#updatecashboncomponent').modal('show');
                   }
               });
        });
        $('div.modal#updatecashboncomponent').on('hide.bs.modal', function(){
            $('table.table#cashboncomponent')
                .empty()
                .load('<?php echo site_url('kasbon_umum/cashbon/updatecomponent/'.bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $cashbon->dutieid, 'cashbonid' => $cashbon->cashbonid, 'type' => $cashbon->type )))) ?>', {}, function (response, status, xhr) {
                    if (status === 'error') {
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
                            title: 'Gagal Memuat Detail',
                            html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                            showCloseButton: true,
                            showConfirmButton: false,
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function(){ });
                    }
                });
        });

        $('a.cancel-cashbon').on('click',function (){
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi Batal',
                html: 'Konfirmasi batal <b>Kasbon</b> ?',
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $('a.cancel-cashbon').data('href'),
                        type: 'POST',
                        success: function (data) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm ml-3',
                                    cancelButton: 'btn btn-sm ml-3',
                                    denyButton: 'btn btn-sm ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'success',
                                title: 'Berhasil Dibatalkan',
                                html: data.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            }).then(function(){
                                window.location.replace('<?php echo site_url('kasbon_umum/cashbon/') ?>');
                            });
                        },
                        error: function (xhr, status, thrown) {
                            console.log((xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText))
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
                                title: 'Gagal Diubah',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            });
                        },
                    });
                }
            });
        })
    });
</script>
