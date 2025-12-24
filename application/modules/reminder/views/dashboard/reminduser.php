<style>
    thead tr th {
        text-align: center;
        text-transform: uppercase;
        vertical-align: middle !important;
        white-space: nowrap;
    }

    thead tr th:first-child {
        padding-right: 8px !important;
    }

    thead tr th,
    tbody tr td {
        border: 0.1px solid #dddddd !important;
    }

    .dataTables_info,
    .dataTables_paginate,
    tbody tr td {
        font-weight: normal;
    }
</style>
<style>
    .eye-icon {
        cursor: pointer;
        position: relative;
    }

    .eye-icon i {
        position: absolute;
        right: 5px;
        top: 5px;
    }
</style>
<div class="modal fade" id="changepassworduser" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" class="formupdatepassword" action="<?php echo site_url('master/user/firstUpdatePassword')?>" method="post">
                <div class="modal-header">
                    <h3 class="modal-title"><?php echo $modalTitle ?></h3>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info alert-dismissible">
                        <h3><i class="icon fa fa-info"></i> Perhatian!</h3>
                        <h4 class="font-weight-bold">Silakan perbaharui kata sandi anda !</h4>
                    </div>
                    <div class="form-horizontal">

                        <div class="form-group">

                            <div class="col-sm-8">
                                <input type="hidden" class="form-control input-sm" value="<?php echo $default['tipe'];?>" id="tipe" name="tipe" required>
                                <input type="hidden" class="form-control input-sm" value="<?php echo $default['user'];?>" name="user" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4">KATA SANDI BARU</label>
                            <div class="col-sm-8">
                                <div class="eye-icon">
                                    <input type="password" class="form-control  password-input" id="password1" name="passwordweb" pattern=".{6,}"  title="Panjang minimal 6 Karakter, dan terdiri dari angka dan huruf" required>
                                    <i class="fa fa-eye-slash"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">ULANGI KATA SANDI BARU</label>
                            <div class="col-sm-8">
                                <div class="eye-icon">
                                    <input type="password" id="password2" class="form-control  password-input" name="passwordweb2" pattern=".{6,}" title="Masukan Ulang Password Sama dengan sebelumnya" required>
                                    <i class="fa fa-eye-slash"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer m-0 p-1">
                    <button type="submit" class="btn btn-md btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if ($this->session->userdata('firstuse')){ ?>
    <script>
        $(document).ready(function(){
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
            $('.eye-icon i').click(function () {
                var passwordField = $(this).siblings('.password-input');
                var passwordFieldType = passwordField.attr('type');

                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).removeClass('far fa-eye-slash').addClass('far fa-eye');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).removeClass('far fa-eye').addClass('far fa-eye-slash');
                }
            });

            $('div.modal#changepassworduser').modal({
                backdrop: 'static',
                keyboard: true,
                show: true
            });
            var password = document.getElementById("password1")
                , confirm_password = document.getElementById("password2");

            function validatePassword(){
                if(password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Password Tidak Sama !!!");
                } else {
                    confirm_password.setCustomValidity('');
                }
            }
            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;
            $('form.formupdatepassword').submit(function(e){
                e.preventDefault();
            }).bind('reset', function(){

            }).validate({
                errorElement: 'span',
                errorClass: 'help-block help-block-error',
                focusInvalid: false,
                ignore: '',
                messages: {},
                rules: {
                    passwordweb: {
                        required: true,
                    },
                    passwordweb2: {
                        required: true,
                        equalTo: "#password1",
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
                        html: `Konfirmasi ubah kata sandi`,
                        icon: 'question',
                        showCloseButton: true,
                        confirmButtonText: 'Konfirmasi',
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: $('form.formupdatepassword').attr('action'),
                                data: $('form.formupdatepassword').serialize(),
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
                                        title: 'Berhasil diubah',
                                        html: `anda akan diarahkan kembali kehalaman login`,
                                        timer: 5000,
                                        timerProgressBar: true,
                                        showCloseButton: true,
                                        showConfirmButton: false,
                                        showDenyButton: true,
                                        denyButtonText: `Tutup`,
                                    }).then(function(){
                                        window.location.href = '<?php echo site_url('dashboard/logout') ?>';
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
            });
        })
    </script>
<?php } ?>


    <div class="row">
        <!--START OF PK-->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title_pk; ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="t_pk" class="display nowrap table table-striped no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="1%">no</th>
                                    <th width="10%">NIK</th>
                                    <th width="10%">Nama</th>
                                    <th width="5%">Bagian</th>
                                    <th width="5%">Jenis</th>
                                    <th width="10%">Akhir</th>
                                    <th width="10%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list_pk as $k => $v):?>
                                    <tr>
                                        <td class="text-nowrap text-center"><?php echo ($k + 1);?></td>
                                        <td class="text-nowrap"><?php echo trim($v->nik);?></td>
                                        <td><?php echo trim($v->nmlengkap);?></td>
                                        <td><?php echo trim($v->nmdept);?></td>
                                        <td><?php echo trim($v->nmkepegawaian);?></td>
                                        <td><?php echo trim($v->tgl_selesai1);?></td>
                                        <td class="text-center"><?php echo empty($v->deskappr) ? 'BELUM DINILAI' : $v->deskappr; ?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!--END OF PK-->

    </div>

    <div class="row">
        <!--START OF SP-->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title_sp; ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="t_sp" class="display nowrap table table-striped no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="1%">no</th>
                                    <th width="10%">NIK</th>
                                    <th width="10%">Nama</th>
                                    <th width="5%">Bagian</th>
                                    <th width="5%">Detail Informasi</th>
                                    <th width="10%">Tanggal berlaku</th>
                                    <th width="10%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list_sp as $k => $v):?>
                                    <tr>
                                        <td class="text-nowrap text-center"><?php echo ($k + 1);?></td>
                                        <td class="text-nowrap"><?php echo trim($v->nik);?></td>
                                        <td><?php echo trim($v->nmlengkap);?></td>
                                        <td><?php echo trim($v->nmdept);?></td>
                                        <td><?php echo trim($v->nmkepegawaian);?></td>
                                        <td><?php echo trim($v->tgl_selesai1);?></td>
                                        <td class="text-center"><?php echo empty($v->deskappr) ? 'BELUM DINILAI' : $v->deskappr; ?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!--END OF SP-->

    </div>
   

<script type="text/javascript">
    $(function() {
        
               $("#t_pk").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
               $("#t_tl").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
    });
</script>
