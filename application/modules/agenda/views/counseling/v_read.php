
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
   /* select {
        appearance: none;
    }*/
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
    button.ml-3{
        margin-left: 3px;
    }
</style>
<legend><?php echo $title; ?></legend>
<div class="btn-toolbar container">
    <a href="<?php echo $backUrl?>" class="btn btn-md btn-warning margin-right-10 back">Kembali</a>
    <?php if (($userhr OR $iscounselor) AND $transaction->status <> 'C'){ ?>
        <a href="<?php echo $inputDetailUrl?>" class="btn btn-md btn-success  margin-right-10 input-detail"><i class="fa fa-fw fa-plus"></i>  Input Detail Konseling</a>
    <?php } ?>
</div>
<form id="approve-counseling" class="form approve-counseling" action="" method="post">
    <div class="modal-body">
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4">NIK</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="nik" value="<?php echo trim($employee->nik); ?>"
                                           class="form-control" style="text-transform:uppercase" maxlength="40"
                                           readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Nama Karyawan</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="kdlvl1" value="<?php echo trim($employee->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Department</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="department1"
                                           value="<?php echo trim($employee->nmdept); ?>" class="form-control"
                                           style="text-transform:uppercase" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Konselor</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" name="counselor" id="counselor" disabled>
                                        <?php if (isset($counselor) && count($counselor) > 0) {
                                            foreach ($counselor as $index => $row) { ?>
                                                <option value="<?php echo $row->id ?>" <?php echo ($transaction->counselor == $row->id ? 'selected' : '') ?> ><?php echo $row->text ?></option>
                                            <?php }
                                        } else { ?>
                                            <option></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4">Jabatan</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="jabatan1"
                                           value="<?php echo trim($employee->nmjabatan); ?>" class="form-control"
                                           style="text-transform:uppercase" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Nomor Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="nohp"
                                           value="<?php echo trim($employee->mergephone); ?>" class="form-control"
                                           style="text-transform:uppercase" maxlength="40" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Keterangan</label>
                                <div class="col-sm-8">
                                    <textarea name="description" id="description" class="form-control text-uppercase" cols="30" rows="3" disabled><?php echo $transaction->description?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <?php if ($transaction->status <> 'C'){ ?>
        <div class="box box-info">

            <div class="box-body table-responsive" style='overflow-x:scroll;'>
                <div class="col-sm-12 table-responsive">
                    <?php

                        $this->datatablessp->generatetable();
                        $this->datatablessp->jquery();

                    ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</form>
<script>
    $(document).ready(function () {

        $('table.datatable').DataTable().on( 'draw', function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger : 'mouseover',
            })
        });
        /*table-counseling-detail*/
        $('table#table-counseling-detail tbody').on('click', 'td a.delete', function () {
            var row = $(this);
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                icon: 'question',
                title: `Konfirmasi Hapus`,
                html: `Apakah anda yakin ingin menghapus data ini ?`,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                showDenyButton: true,
                denyButtonText: `Batal`,
            }).then(function (result) {
                if (result.isConfirmed) {
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
                                title: 'Berhasil dihapus',
                                html: data.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            }).then(function () {
                                $('table#table-counseling-detail').DataTable().draw(false);
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
                                icon: 'error',
                                title: 'Gagal Memuat Status',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            }).then(function () {
                            });
                        });
                }
            })
        });
        $('table#table-counseling-detail tbody').on('click', 'td a.edit', function () {
            var row = $(this);
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                icon: 'question',
                title: `Konfirmasi Ubah`,
                html: `Apakah anda yakin ingin mengubah data ini ?`,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                showDenyButton: true,
                denyButtonText: `Batal`,
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location.replace(row.data('href'));
                }
            })
        });
        $('select[name=\'counselor\']').select2({
            allowClear: true,
            ajax: {
                url: '<?php echo site_url('trans/karyawan/search'); ?>',
                dataType: 'json',
                delay: 250,
                multiple: false,
                closeOnSelect: false,
                data: function (params) {
                    return {
                        // level: 'superior',
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
            placeholder: 'Pilih Konselor...',
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
    <div class='col-sm-6'>${repo.nmjabatan}</div>
</div>`;
            },
            templateSelection: function (repo) {
                return repo.text || repo.text;
            },
        }).on('change', function (e) {
            $(this).valid()
        });
        $('table#table-counseling tbody').on('click', 'td a.cancel', function () {
            var row = $(this);
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                icon: 'question',
                title: `Konfirmasi`,
                html: `Apakah anda yakin ingin membatalkan dokumen ini ?`,
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                showDenyButton: true,
                denyButtonText: `Batal`,
            }).then(function (result) {
                if (result.isConfirmed) {
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
                                title: 'Berhasil Dibatalkan',
                                html: data.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            }).then(function () {
                                $('table#table-counseling').DataTable().draw(false);
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
                                icon: 'error',
                                title: 'Gagal Memuat Status',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            }).then(function () {
                            });
                        });
                }
            })
        });
    })
</script>