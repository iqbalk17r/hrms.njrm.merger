<?php
?>
<style>
    .ml-3{
        margin-left: 3px;
    }
    li.select2-selection__choice{
        background-color: blue !important;
    }
    span.select2-selection__choice__remove{
        color: white !important;
    }
</style>
<form role="form" class="formcreatedeclarationcashbon" action="<?php echo site_url('kasbon_umum/declarationcashbon/docreate/'.bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $cashbon->dutieid ))))?>" method="post">
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
                                    <input type="text" name="" class="form-control userid" value="<?php echo $employee->nik ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Nama Karyawan</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo $employee->nmlengkap ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">No.Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" name="emp_phone" class="form-control" value="<?php echo (strlen($employee->nohp2) > 0 ? $employee->nohp1.', '.$employee->nohp2 : $employee->nohp1) ?>" readonly/>
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
                                <label class="col-sm-4">Jenis Pembayaran</label>
                                <div class="col-sm-8">
                                    <select name="paymenttype" class="select2 form-control " id="paymenttype">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Dokumen Dinas</label>
                                <div class="col-sm-8">
                                    <select name="dutieid[]" class="select2 form-control " id="dutieid[]" multiple="multiple">
                                        <option></option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-info" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Dokumen Dinas</h3>
                        <button type="button" class="btn btn-sm btn-warning pull-right reset-select">reset seleksi</button>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12 table-responsive">
                            <?php
                            $this->datatablessp->generatetable();
                            $this->datatablessp->jquery();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-success" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data Detail Deklarasi Kasbon</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped" id="declarationcomponent">
                                <?php include APPPATH.'\modules\kasbon_umum\views\declaration_cashbon\direct\v_component_read.php' ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-info" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data Kasbon Karyawan</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped" id="cashboncomponent">
                                <?php include APPPATH.'\modules\kasbon_umum\views\cashbon\v_component_read.php' ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-danger" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data Detail Pengembalian</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-horizontal" id="cashboncomponentbalance">
                            <?php include APPPATH.'\modules\kasbon_umum\views\declaration_cashbon\v_component_balance.php' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-success ml-3 pull-right">Simpan</button>
            <button type="reset" class="btn btn-danger ml-3 pull-right">Batal</button>
        </div>
    </div>
</div>
</form>
<div class="modal fade" id="createdeclarationcomponent" role="dialog" aria-hidden="true"></div>
<script>
    $(document).ready(function() {
        $('button.reset-select').on('click', function (){
            $('select[name=\'dutieid[]\']').empty().trigger("change")
        })
        function checkdocno(docno) {
            var docno
            $('#table-dutie')
                .DataTable()
                .ajax.url('<?php echo base_url('kasbon_umum/cashbondinas/create')?>?docno=' + docno +'')
                .load();
        }
        function loadDocno(docno){
            var docno;
            $.ajax({
                url:'<?php echo $loadDocnoUrl ?>',
                method: 'POST',
                data: {docno:docno},
                success: function (data){
                    $('table.table#declarationcomponent')
                        .empty()
                        .load(data.data.url, {}, function (response, status, xhr) {
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
                }
            })
        }

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

        $('select[name=\'dutieid[]\']').select2({
            allowClear:true,
            ajax: {
                url: '<?php echo site_url('trans/dinas/search'); ?>',
                dataType: 'json',
                delay: 250,
                multiple: true,
                closeOnSelect: false,
                data: function (params) {
                    return {
                        config : 'CREATE',
                        user: $('input.userid').val(),
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
            placeholder: 'Pilih dokumen dinas...',
            escapeMarkup: function (markup) {
                return markup;
            },
            maximumSelectionLength: 3,
            minimumInputLength: 0,
            templateResult: function (repo) {
                if (repo.loading) {
                    return repo.text;
                }
                return `
<div class='row' style='width: 400px'>
    <div class='col-sm-3'>${repo.id}</div>
    <div class='col-sm-8'>${repo.text}</div>
</div>`;
            },
            templateSelection: function (repo) {
                return repo.id || repo.id;
            },
        }).on('change', function(e) {
            if($('select[name=\'dutieid[]\']').val() != null){
                checkdocno($('select[name=\'dutieid[]\']').val().join(','))
                loadDocno($('select[name=\'dutieid[]\']').val().join(','))
            }else{
                checkdocno(null)
                loadDocno(null)
            }
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
        $('form.formcreatedeclarationcashbon').submit(function(e){
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
                html: 'Konfirmasi reset data <b>Deklarasi Kasbon Karyawan</b> ?',
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.getJSON('<?php echo site_url('kasbon_umum/declarationcashbon/docancel/') ?>', {})
                        .done(function(data) {
                            window.location.replace('<?php echo site_url('kasbon_umum/declarationcashbon/') ?>');
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

                $.ajax({
                    url: '<?php echo site_url('kasbon_umum/declarationcashbon/checkcomponenttemporary/'.bin2hex(json_encode(array('cashbonid'=>$cashbon->cashbonid,'schema'=>'temporary')))); ?>',
                    method: 'POST',
                    success: function (data) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            title: 'Konfirmasi Simpan',
                            html: `<div>Konfirmasi simpan data<br/><b>Deklarasi Kasbon Karyawan</b> ?</div><br/><div class=\'text-nowrap\'><h4>${$('div.returnamount').find('label').html()} : <b>${$('div.returnamount').find('input[type=\'text\']').val()}</b></h4></div>`,
                            icon: 'question',
                            showCloseButton: true,
                            confirmButtonText: 'Konfirmasi',
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: $('form.formcreatedeclarationcashbon').attr('action'),
                                    data: $('form.formcreatedeclarationcashbon').serialize(),
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
                                            showConfirmButton: false,
                                            showDenyButton: true,
                                            denyButtonText: `Tutup`,
                                        }).then(function(){
                                            window.location.replace('<?php echo site_url('kasbon_umum/declarationcashbon/') ?>');
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
                                            showConfirmButton: false,
                                            showDenyButton: true,
                                            denyButtonText: `Tutup`,
                                        }).then(function(){ });
                                    },
                                });
                            }
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
                        }).then(function(){ });
                    }
                });

            },
        });
        $(document).on('click', 'a.createdeclarationcomponent', function () {
            var row = $(this);
           $('div.modal#createdeclarationcomponent')
               .empty()
               .load(row.attr('data-href'), {}, function (response, status, xhr) {
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
                       $('div.modal#createdeclarationcomponent').modal('show');
                   }
               });
        });
        $('div.modal#createdeclarationcomponent').on('hide.bs.modal', function(){
            /* Pace.restart(); */
            $('table.table#declarationcomponent')
                .empty()
                .load('<?php echo site_url('kasbon_umum/declarationcashbon/createcomponent/'.bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $cashbon->dutieid, 'cashbonid' => isset($cashbon->cashbonid) ? $cashbon->cashbonid : '', 'schema' => 'temporary','createoption'=>'DI' )))) ?>', {}, function (response, status, xhr) {
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
            $('div#cashboncomponentbalance')
                .empty()
                .load('<?php echo site_url('kasbon_umum/declarationcashbon/componentbalance/'.bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $cashbon->dutieid, 'cashbonid' => isset($cashbon->cashbonid) ? $cashbon->cashbonid : '', 'schema' => 'temporary' )))) ?>', {}, function (response, status, xhr) {
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
    });
</script>
