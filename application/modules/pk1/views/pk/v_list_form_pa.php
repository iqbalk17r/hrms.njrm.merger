<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(function () {
        $("#example1").dataTable();
        var save_method;
        var table;
        table = $('#example2').DataTable({

            "processing": true,
            "serverSide": true,

            "ajax": {
                "url": "<?php echo site_url('ga/permintaan/bbmpagin') ?>",
                "type": "POST"
            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": false,
            },],

        });

        $("#example3").dataTable();
        $("#example4").dataTable();
        $(".inputfill").selectize();
        $('.tglYM').datepicker({
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true,
            startView: "year"
        });

        $('input[name=startPeriode], input[name=endPeriode]').change(function () {
            var namaFormulir = $(this).closest('form').attr('name');
            var startPeriodeInput = $('form[name=' + namaFormulir + '] input[name=startPeriode]');
            var endPeriodeInput = $('form[name=' + namaFormulir + '] input[name=endPeriode]');
            var startDateValue = startPeriodeInput.val();
            var endDateValue = endPeriodeInput.val();
            if (endDateValue < startDateValue) {
                startPeriodeInput.css('border-color', 'red');
                endPeriodeInput.css('border-color', 'red');
                $('form[name=' + namaFormulir + '] #submit').prop('disabled', true);
            } else {
                startPeriodeInput.css('border-color', '');
                endPeriodeInput.css('border-color', '');
                $('form[name=' + namaFormulir + '] #submit').prop('disabled', false);
            }
        });
    });
</script>
<style>
    selectize css .selectize-input {
        overflow: visible;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }

    .selectize-input.dropdown-active {
        min-height: 30px;
        line-height: normal;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }

    .selectize-dropdown,
    .selectize-input,
    .selectize-input input {
        min-height: 30px;
        line-height: normal;
    }

    .loading .selectize-dropdown-content:after {
        content: 'loading...';
        height: 30px;
        display: block;
        text-align: center;
    }
</style>
<div class="pull-right">Versi:
    <?php echo $version; ?>
</div>
<legend>
    <?php echo $title; ?>
</legend>

<?php echo $message; ?>

<div class="row">
    <div class="col-sm-3">
        <div class="dropdown ">
            <button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1"
                type="button" data-toggle="dropdown">Menu Input
                <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Filter"
                        href="#"><i class="fa fa-search"></i>Filter Pencarian</a></li>
                <?php if ($ceknikatasan1 > 0 || $ceknikatasan2 > 0 || $cek_option_pa == 0) { ?>
                    <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal"
                            data-target="#ChoiceOfLetter" href="#"><i class="fa fa-plus"></i>INPUT PA</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
</br>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <div class="box-body table-responsive" style='overflow-x:scroll;'>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="2%">No.</th>
                                    <th>Dokumen</th>
                                    <th>NIK</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>JABATAN</th>
                                    <th>ATASAN</th>
                                    <th>PERIODE</th>
                                    <th>DEPARTMENT</th>
                                    <th>STATUS</th>

                                    <th width="8%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                foreach ($list_tx_pa as $row):
                                    $no++; ?>
                                    <tr>
                                        <td width="2%">
                                            <?php echo $no; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->nodok; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->nik; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->nmlengkap; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->nmjabatan; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->nmatasan; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->periode; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->nmdept; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->nmstatus; ?>
                                        </td>

                                        <td width="8%">
                                            <a href="<?php
                                            $enc_nik = bin2hex($this->encrypt->encode(trim($row->nik)));
                                            $enc_periode = bin2hex($this->encrypt->encode(trim($row->periode)));
                                            echo site_url("pk/pk/detail_generate_pa") . '/' . $enc_nik . '/' . $enc_periode; ?>"
                                                class="btn btn-default  btn-sm" title="DETAIL KATEGORI KRITERIA"><i
                                                    class="fa fa-bars"></i> </a>
                                            <?php if ((in_array(trim($row->statustx), array('A', 'R1', 'R2'))) and ($nama == trim($row->nik_atasan) or $nama == trim($row->nik_atasan2) or $cek_option_pa == 0)) { ?>
                                                <a href="<?php
                                                $enc_nik = bin2hex($this->encrypt->encode(trim($row->nik)));
                                                $enc_periode = bin2hex($this->encrypt->encode(trim($row->periode)));
                                                echo site_url("pk/pk/edit_generate_pa") . '/' . $enc_nik . '/' . $enc_periode; ?>"
                                                    class="btn btn-primary  btn-sm" title="UBAH NILAI"><i
                                                        class="fa fa-gear"></i> </a>

                                                <a href="<?php
                                                $enc_nik = bin2hex($this->encrypt->encode(trim($row->nik)));
                                                $enc_periode = bin2hex($this->encrypt->encode(trim($row->periode)));
                                                echo site_url("pk/pk/delete_generate_pa") . '/' . $enc_nik . '/' . $enc_periode; ?>"
                                                    class="btn btn-danger  btn-sm" title="HAPUS DATA"><i
                                                        class="fa fa-trash-o"></i> </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ChoiceOfLetter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> PILIH PERIODE GENERATE KRITERIA </h4>
            </div>
            <form action="<?php echo site_url('pk/pk/list_nik_from_nik_atasan') ?>" method="post" name="inputPeriode">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <?php if ($range_option == 'FREE'): ?>
                                        <div class="form-horizontal">
                                            <label class="col-sm-4" for="inputsm">PILIH PERIODE</label>
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input type="text" name="startPeriode" id="startDate"
                                                            class="tglYM form-control input-sm startPeriode" readonly
                                                            required>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="endPeriode" id="endDate"
                                                            class="tglYM form-control input-sm startPeriode" readonly
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <?php if ($range_option == 'SEMESTER'): ?>
                                        <div class="form-horizontal">
                                            <label class="col-sm-4" for="inputsm">PERIODE</label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm" name="periode" id="periode" required>
                                                    <?php
                                                    $semesters = ['S1' => 'SEMESTER 1', 'S2' => 'SEMESTER 2'];
                                                    foreach ($semesters as $key => $value) {
                                                        $selected = ($range_option_semester == $key) ? 'selected' : '';

                                                        if ($selected) {
                                                            echo "<option value=\"$key\" $selected>$value</option>";
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <label class="col-sm-4" for="inputsm">TAHUN</label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm" name="tahun" id="tahun" required>
                                                    <option value="<?= date('Y')-$year ?>" selected><?= date('Y')-$year ?></option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="startPeriode" id="startDate" value="">
                                            <input type="hidden" name="endPeriode" id="endDate" value="">
                                            <script>
                                                $(function () {
                                                    var periode = $('form[name=inputPeriode] select[name=periode]').val();
                                                    var tahun = $('form[name=inputPeriode] select[name=tahun]').val();

                                                    if (periode == 'S1') {
                                                        $('form[name=inputPeriode] #startDate').val(tahun + '-01');
                                                        $('form[name=inputPeriode] #endDate').val(tahun + '-06');
                                                    }
                                                    if (periode == 'S2') {
                                                        $('form[name=inputPeriode] #startDate').val(tahun + '-07');
                                                        $('form[name=inputPeriode] #endDate').val(tahun + '-12');
                                                    }

                                                    if ($('form[name=inputPeriode] #endDate').val().length == 7) {
                                                        $('form[name=inputPeriode] #submit').prop('disabled', false);
                                                    }
                                                });
                                            </script>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary submit" disabled>GENERATE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="Filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> FILTER PERFORMA APPRAISAL </h4>
            </div>
            <form action="<?php echo site_url('pk/pk/form_pk') ?>" method="post" name="inputformPbk">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <?php if ($range_option == 'FREE'): ?>
                                        <div class="form-horizontal">
                                            <label class="col-sm-4" for="inputsm">PILIH PERIODE</label>
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input type="text" name="startPeriode" id="startDate"
                                                            class="tglYM form-control input-sm startPeriode" readonly
                                                            required>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="endPeriode" id="endDate"
                                                            class="tglYM form-control input-sm startPeriode" readonly
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <?php if ($range_option == 'SEMESTER'): ?>
                                        <div class="form-horizontal">
                                            <label class="col-sm-4" for="inputsm">PERIODE</label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm" name="periode" id="periode" required>
                                                    <option value=""></option>
                                                    <option value="S1">SEMESTER 1</option>
                                                    <option value="S2">SEMESTER 2</option>
                                                </select>
                                            </div>
                                            <label class="col-sm-4" for="inputsm">TAHUN</label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm" name="tahun" id="tahun" required>
                                                    <option value=""></option>
                                                    <?php
                                                    for ($i = 0; $i <= 6; $i++): ?>
                                                        <option value="<?= 2024 - $i ?>"><?= 2024 - $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <input type="hidden" name="startPeriode" id="startDate" value="">
                                            <input type="hidden" name="endPeriode" id="endDate" value="">
                                            <script>
                                                $(function () {
                                                    $('select[name=periode], select[name=tahun]').change(function () {
                                                        var namaFormulir = $(this).closest('form').attr('name');
                                                        var periode = $('form[name=' + namaFormulir + '] select[name=periode]').val();
                                                        var tahun = $('form[name=' + namaFormulir + '] select[name=tahun]').val();

                                                        if (periode == 'S1') {
                                                            $('form[name=' + namaFormulir + '] #startDate').val(tahun + '-01');
                                                            $('form[name=' + namaFormulir + '] #endDate').val(tahun + '-06');
                                                        }
                                                        if (periode == 'S2') {
                                                            $('form[name=' + namaFormulir + '] #startDate').val(tahun + '-07');
                                                            $('form[name=' + namaFormulir + '] #endDate').val(tahun + '-12');
                                                        }

                                                        if ($('form[name=' + namaFormulir + '] #endDate').val().length == 7) {
                                                            $('form[name=' + namaFormulir + '] #submit').prop('disabled', false);
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary submit">GENERATE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#tgl").datepicker();
    $(".tglan").datepicker();
</script>