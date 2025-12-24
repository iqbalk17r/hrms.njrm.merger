<div class="modal-dialog <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><?php echo $modalTitle ?></h4>
        </div>
        <div class="modal-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-4">Departemen</label>
                    <div class="col-sm-8">
                        <select name="departmentid" class="select2 form-control " id="departmentid">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4">Sub Departemen</label>
                    <div class="col-sm-8">
                        <select name="subdepartmentid" class="select2 form-control " id="subdepartmentid">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4">Jabatan</label>
                    <div class="col-sm-8">
                        <select name="positionid" class="select2 form-control " id="positionid">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4">Regu</label>
                    <div class="col-sm-8">
                        <select name="groupid" class="select2 form-control " id="groupid">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4">Shift </label>
                    <div class="col-sm-8">
                        <select name="shiftid" class="select2 form-control " id="shiftid">
                            <option value="">-Pilih Shift-</option>
                            <option value="OFF">OFF</option>
                            <?php foreach ($getShiftData as $index => $getShiftDatum) {
                                echo '<option value="'.$getShiftDatum->id.'">'.$getShiftDatum->text.'</option>';
                            } ?>
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <div class="btn-toolbar">
                <button type="button" class="btn btn-warning pull-left close-modal" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary pull-right set-filter" >Cari</button>
                <button type="button" class="btn btn-primary pull-right reset-filter" >Hapus Filter</button>
<!--                <button type="button" class="btn btn-info pull-right add-to-participant" >Tambahkan Peserta</button>-->
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        $('select[name=\'shiftid\']').select2({
            width:'100%',
        })
        $('select[name=\'departmentid\']').select2({
            width: '100%',
            ajax: {
                url: '<?php echo site_url('master/department/search'); ?>',
                dataType: 'json',
                delay: 250,
                multiple: false,
                closeOnSelect: false,
                data: function (params) {
                    return {
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
            placeholder: 'Pilih departemen...',
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
    <div class='col-sm-2'>${repo.id}</div>
    <div class='col-sm-6'>${repo.text}</div>
</div>`;
            },
            templateSelection: function (repo) {
                return repo.text || repo.text;
            },
        }).on('change', function(e) {
            $('select[name=\'subdepartmentid\']').val("").trigger('change')
        });
        $('select[name=\'subdepartmentid\']').select2({
            width: '100%',
            ajax: {
                url: '<?php echo site_url('master/subdepartment/search'); ?>',
                dataType: 'json',
                delay: 250,
                multiple: false,
                closeOnSelect: false,
                data: function (params) {
                    return {
                        departmentid: $('select[name=\'departmentid\']').val(),
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
            placeholder: 'Pilih Subdepartemen...',
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
    <div class='col-sm-2'>${repo.id}</div>
    <div class='col-sm-6'>${repo.text}</div>
</div>`;
            },
            templateSelection: function (repo) {
                return repo.text || repo.text;
            },
        }).on('change', function(e) {
            $('select[name=\'positionid\']').val("").trigger('change')
        });
        $('select[name=\'positionid\']').select2({
            width: '100%',
            ajax: {
                url: '<?php echo site_url('master/position/search'); ?>',
                dataType: 'json',
                delay: 250,
                multiple: false,
                closeOnSelect: false,
                data: function (params) {
                    return {
                        departmentid: $('select[name=\'departmentid\']').val(),
                        subdepartmentid: $('select[name=\'subdepartmentid\']').val(),
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
            placeholder: 'Pilih jabatan...',
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
    <div class='col-sm-2'>${repo.id}</div>
    <div class='col-sm-6'>${repo.text}</div>
</div>`;
            },
            templateSelection: function (repo) {
                return repo.text || repo.text;
            },
        }).on('change', function(e) {});
        $('select[name=\'groupid\']').select2({
            width: '100%',
            ajax: {
                url: '<?php echo site_url('master/regu/search'); ?>',
                dataType: 'json',
                delay: 250,
                multiple: false,
                closeOnSelect: false,
                data: function (params) {
                    return {
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
            placeholder: 'Pilih Regu...',
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
    <div class='col-sm-2'>${repo.id}</div>
    <div class='col-sm-6'>${repo.text}</div>
</div>`;
            },
            templateSelection: function (repo) {
                return repo.text || repo.text;
            },
        }).on('change', function(e) {});

        $('button.set-filter').on('click', function () {
            var table = $('table#table-employee').DataTable();
            table.search('').draw();
        });
        $('button.set-filter').on('click', function () {
            var departmentid = $('select#departmentid option:selected').text().trim();  // column 4
            var subdepartmentid = $('select#subdepartmentid option:selected').text().trim();  // column 5
            var positionid = $('select#positionid option:selected').text().trim();  // column 6
            var shiftid = $('select#shiftid option:selected').text().trim();  // column 7
            var groupid = $('select#groupid option:selected').text().trim();  // column 8

            $('table#table-employee thead input').val('');
            $('table#table-employee').find('.dataTables_filter input[type="search"]').val('');

            var table = $('table#table-employee').DataTable();
            table.search('');
            table.columns().search('');
            if (departmentid !== '') {
                table.column(3).search(departmentid);
            }
            if (subdepartmentid !== '') {
                table.column(4).search(subdepartmentid);
            }
            if (positionid !== '') {
                table.column(5).search(positionid);
            }
            if ($('select#shiftid option:selected').val().trim() !== '') {
                table.column(6).search(shiftid);
            }
            if (groupid !== '') {
                table.column(7).search(groupid);
            }
            table.draw();
        });

        $('button.reset-filter').on('click', function (){
            var table = $('table#table-employee').DataTable();
            table.search('');
            table.columns().search('');
            table.draw();
        })
    })
</script>
