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
<form role="form" class="formcreatecashbon" action="<?php echo site_url('kasbon_umum/cashbon/docreate/'.bin2hex(json_encode(array('type' => $code_type))))?>" method="post">
    <div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3 class="pull-left">Buat <?php echo $title ?></h3>

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
                                    <select name="emp_nik" class="select2 form-control " id="employee">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Nama Karyawan</label>
                                <div class="col-sm-8">
                                    <input type="text" name="emp_name" class="form-control" value="" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Departemen</label>
                                <div class="col-sm-8">
                                    <input type="text" name="emp_dept" class="form-control" value="" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Jabatan</label>
                                <div class="col-sm-8">
                                    <input type="text" name="emp_position" class="form-control" value="" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">No.Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" name="emp_phone" class="form-control" value="" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">No. Rekening</label>
                                <div class="col-sm-8">
                                    <input type="text" name="emp_account" class="form-control" value="" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-primary" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data <?php echo $title ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="form-horizontal">

                            <div class="form-group">
                                <label class="col-sm-4">Tipe</label>
                                <div class="col-sm-8">
                                    <input type="text" name="documenttype" class="form-control" value="<?php echo $code_type ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Jenis Pembayaran</label>
                                <div class="col-sm-8">
                                    <select name="paymenttype" class="select2 form-control " id="paymenttype">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Jumlah Kasbon</label>
                                <div class="col-sm-8">
                                    <label for="totalcashbon" id="totalcashbon" class="font-size-medium"></label>
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
                        <h3 class="box-title text-muted">Data Detail PO</h3>
                        <a href="javascript:void(0)" class="btn btn-warning pull-right createcashboncomponentpo">Tambah PO</a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive table-detail">
                            <table class="table table-hover table-bordered table-striped" id="cashboncomponentpo">
                                <?php include APPPATH.'\modules\kasbon_umum\views\cashbon\v_component_po_read.php';?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="box box-success" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data Detail <?php echo $title_detail?></h3>
                        <a href="javascript:void(0)" class="btn btn-warning pull-right createcashboncomponent">Edit Detail</a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive table-detail">
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
            <button type="reset" class="btn btn-danger ml-3 pull-right reset">Batal</button>

        </div>
    </div>
</div>
</form>
<div class="modal fade" id="createcashboncomponent" role="dialog" aria-hidden="true"></div>
<div class="modal fade" id="createcashboncomponentpo" role="dialog" aria-hidden="true"></div>
<script>
    $('table#cashboncomponentpo').on('click','a.deletecomponentpo', function () {
        var emp = $("select[name=\'emp_nik\']").val()
        $.ajax({
            url: $(this).data('href'),
            data: 'hapus',
            type: 'POST',
            success: function (data) {
                $('table.table#cashboncomponentpo')
                    .empty()
                    .load('<?php echo site_url('kasbon_umum/cashbon/createcomponentpo/'.bin2hex(json_encode(array('type'=>$code_type, 'schema' => 'temporary' )))) ?>', {data: emp}, function (response, status, xhr) {
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
                $('table.table#cashboncomponent')
                    .empty()
                    .load('<?php echo site_url('kasbon_umum/cashbon/createcomponent/'.bin2hex(json_encode(array('type'=>$code_type, 'schema' => 'temporary' )))) ?>', {data: emp}, function (response, status, xhr) {
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
            },
            error: function (xhr, status, thrown) {
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Gagal Dihapus',
                    text: xhr.statusText,
                    showConfirmButton: false,
                    timer: 3000,
                });
            },
        });
    });

    $(document).ready(function() {
        $('a.createcashboncomponent').on('click', function () {
            var emp = $("select[name=\'emp_nik\']").val()
            if (!emp){
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm ml-3',
                        cancelButton: 'btn btn-sm ml-3',
                        denyButton: 'btn btn-sm ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    position: 'top',
                    icon: 'warning',
                    title: 'Belum memilih karyawan',
                    html: 'Pilih karyawan untuk melakukan input kasbon',
                    timer: 3000,
                    timerProgressBar: true,
                    showCloseButton: true,
                    showConfirmButton: false,
                    showDenyButton: true,
                    denyButtonText: `Tutup`,
                })
            } else {
                $('div.modal#createcashboncomponent')
                    .empty()
                    .load('<?php echo site_url('kasbon_umum/cashbon/createcomponentpopup/' . bin2hex(json_encode(array('type' => $code_type)))) ?>', {data: emp}, function (response, status, xhr) {
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
                            }).then(function () {
                            });
                        } else {
                            $('div.modal#createcashboncomponent').modal('show');
                        }
                    });
            }
        });
        $('div.modal#createcashboncomponent').on('hide.bs.modal', function(){
            var emp = $("select[name=\'emp_nik\']").val()
            $('table.table#cashboncomponent')
                .empty()
                .load('<?php echo site_url('kasbon_umum/cashbon/createcomponent/'.bin2hex(json_encode(array('type'=>$code_type, 'schema' => 'temporary' )))) ?>', {data: emp}, function (response, status, xhr) {
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

            $('table.table#cashboncomponentpo')
                .empty()
                .load('<?php echo site_url('kasbon_umum/cashbon/createcomponentpo/'.bin2hex(json_encode(array('type'=>$code_type, 'schema' => 'temporary' )))) ?>', {data: emp}, function (response, status, xhr) {
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

        $('a.createcashboncomponentpo').on('click', function () {
            var emp = $("select[name=\'emp_nik\']").val()
            if (!emp){
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm ml-3',
                        cancelButton: 'btn btn-sm ml-3',
                        denyButton: 'btn btn-sm ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    position: 'top',
                    icon: 'warning',
                    title: 'Belum memilih karyawan',
                    html: 'Pilih karyawan untuk melakukan tambah PO',
                    timer: 3000,
                    timerProgressBar: true,
                    showCloseButton: true,
                    showConfirmButton: false,
                    showDenyButton: true,
                    denyButtonText: `Tutup`,
                })
            } else {
                $('div.modal#createcashboncomponentpo')
                    .empty()
                    .load('<?php echo site_url('kasbon_umum/cashbon/createcomponentpopuppo/' . bin2hex(json_encode(array('type' => $code_type)))) ?>', {data: emp}, function (response, status, xhr) {
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
                            }).then(function () {
                            });
                        } else {
                            $('div.modal#createcashboncomponentpo').modal('show');
                        }
                    });
            }
        });
        $('div.modal#createcashboncomponentpo').on('hide.bs.modal', function(){
            var emp = $("select[name=\'emp_nik\']").val()
            $('table.table#cashboncomponentpo')
                .empty()
                .load('<?php echo site_url('kasbon_umum/cashbon/createcomponentpo/'.bin2hex(json_encode(array('type'=>$code_type, 'schema' => 'temporary' )))) ?>', {data: emp}, function (response, status, xhr) {
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
            $('table.table#cashboncomponent')
                .empty()
                .load('<?php echo site_url('kasbon_umum/cashbon/createcomponent/'.bin2hex(json_encode(array('type'=>$code_type, 'schema' => 'temporary' )))) ?>', {data: emp}, function (response, status, xhr) {
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

        $('select[name=\'emp_nik\']').on('change',function (){
            var selected = $(this).val()
            var response
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('kasbon_umum/cashbon/employeeautofill')?>',
                data: {nik: selected},
                success: function (data,status) {
                    response = JSON.parse(data)
                    $('input[name=\'emp_name\']').val(response['name'])
                    $('input[name=\'emp_dept\']').val(response['deptname'])
                    $('input[name=\'emp_position\']').val(response['positionname'])
                    $('input[name=\'emp_phone\']').val(response['phone'])
                    $('input[name=\'emp_account\']').val(response['account'])
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        })
        $('select[name=\'emp_nik\']').select2({
            ajax: {
                url: '<?php echo site_url('kasbon_umum/cashbon/searchemployee')?>',
                dataType: 'json',
                delay: 250,
                multiple: false,
                closeOnSelect: false,
                data: function (params) {
                    return {
                        // group: $('select[name=\'documentid\']').data('type'),
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
            placeholder: 'Pilih NIK karyawan...',
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 0,
            templateResult: function (repo) {
                if (repo.loading) {
                    return repo.text;
                }
                return `
<div class='row' style='width: 600px'>
    <div class='col-sm-1'>${repo.id}</div>
    <div class='col-sm-3'>${repo.text}</div>
</div>`;
            },
            templateSelection: function (repo) {
                return repo.id || repo.text;
            },
        }).on('change', function(e) {});



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

        jQuery.extend(jQuery.validator.messages, {
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
            maxlength: jQuery.validator.format('Harap masukkan tidak lebih dari {0} karakter...'),
            minlength: jQuery.validator.format('Harap masukkan sedikitnya {0} karakter...'),
            rangelength: jQuery.validator.format('Harap masukkan nilai antara {0} dan {1} karakter...'),
            range: jQuery.validator.format('Harap masukkan nilai antara {0} dan {1}...'),
            max: jQuery.validator.format('Harap masukkan nilai kurang dari atau sama dengan {0}...'),
            min: jQuery.validator.format('Harap masukkan nilai lebih besar dari atau sama dengan {0}...'),
            alphanumeric: 'Harap masukkan hanya huruf dan angka',
            longlat: 'Harap masukkan hanya latitude dan longitude',
        });
        // new AutoNumeric('.autonumeric', { currencySymbol : 'Rp' });
        AutoNumeric.multiple('input.autonumeric', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: 0,
            minimumValue: 0,
            unformatOnSubmit: true,
        });
        $('form.formcreatecashbon').submit(function(e){
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
                var emp = $("select[name=\'emp_nik\']").val()
                if (result.isConfirmed) {
                    $.getJSON('<?php echo site_url('kasbon_umum/cashbon/docancel/') ?>', {data:emp})
                        .done(function(data) {
                            $("select[name=\'emp_nik\']").empty().trigger('change')
                            // $("select[name=\'documentid\']").empty().trigger('change')
                            $("select[name=\'paymenttype\']").empty().trigger('change')
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
                documentid: {
                    required: true,
                },
                emp_nik: {
                    required: true,
                },
                documenttype:{
                    required: true,
                },
                totalcashbon:{
                    required: true,
                },
                paymenttype:{
                    required: true,
                }
            },
            invalidHandler: function(event, validator) {

            },
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
                console.log('simpan')
                $.ajax({
                    url: '<?php echo site_url('kasbon_umum/cashbon/checkcomponenttemporary/'.bin2hex(json_encode(array('cashbonid'=>$cashbon->cashbonid,'schema'=>'temporary', 'type'=> (isset($cashbon->type)) ? $cashbon->type : $code_type)))); ?>',
                    method: 'POST',
                    success: function (data) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                            buttonsStyling: false,
                        }).fire({
                            title: 'Konfirmasi Simpan',
                            html: 'Konfirmasi simpan data <b>Kasbon</b> ?',
                            icon: 'info',
                            showCloseButton: true,
                            confirmButtonText: 'Konfirmasi',
                        }).then(function (result) {
                            var response
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: $('form.formcreatecashbon').attr('action'),
                                    data: $('form.formcreatecashbon').serialize(),
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
                                            title: 'Berhasil Dibuat',
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
                                        Swal.fire({
                                            position: 'top',
                                            icon: 'error',
                                            title: 'Gagal Disimpan',
                                            text: xhr.statusText,
                                            showConfirmButton: false,
                                            timer: 3000,
                                        });
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
    });
</script>
