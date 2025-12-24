<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function() {
    $("#example1").dataTable();
    var save_method; //for save method string
    var table;
    table = $('#example2').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "ajax": {
            "url": "<?php echo site_url('ga/permintaan/bbmpagin') ?>",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [-1], //last column
            "orderable": false, //set not orderable
        }, ],
    });

    $("#example3").dataTable();
    $("#example4").dataTable();
    $(".inputfill").selectize();
    $('.tglYM').datepicker({
        format: "yyyy-mm",
        viewMode: "months",
		autoclose: true,
        minViewMode: "months"
    });
	
	$('input[name=startPeriode], input[name=endPeriode]').change(function() {
        var namaFormulir = $(this).closest('form').attr('name');
        var startPeriodeInput = $('form[name='+namaFormulir+'] input[name=startPeriode]');
        var endPeriodeInput = $('form[name='+namaFormulir+'] input[name=endPeriode]');
        var startDateValue = startPeriodeInput.val();
        var endDateValue = endPeriodeInput.val();
        if (endDateValue < startDateValue) {
            startPeriodeInput.css('border-color', 'red'); 
            endPeriodeInput.css('border-color', 'red'); 
            $('form[name='+namaFormulir+'] #submit').prop('disabled', true); 
        } else {
            startPeriodeInput.css('border-color', ''); 
            endPeriodeInput.css('border-color', '');             
            $('form[name='+namaFormulir+'] #submit').prop('disabled', false);
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
<div class="pull-right">Versi: <?php echo $version; ?></div>
<legend><?php echo $title; ?></legend>

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
                <?php if ($userhr > 0) { ?>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal"
                        data-target="#ChoiceOfLetter" href="#"><i class="fa fa-plus"></i>GENERATE FS PK</a></li>
                <?php } ?>
            </ul>
        </div>
    </div><!-- /.box-header -->
</div>
</br>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" style='overflow-x:scroll;'>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="1    %">No.</th>
                                    <th>Dokumen</th>
                                    <th>PERIODE</th>
                                    <th>NAMA DEPARTMENT</th>
                                    <th>STATUS</th>
                                    <th width="8%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
								foreach ($list_tx_final_pk as $row) : $no++; ?>
                                <tr>
                                    <td width="1%"><?php echo $no; ?></td>
                                    <td><?php echo $row->nodok; ?></td>
                                    <td><?php echo $row->periode; ?></td>
                                    <td><?php echo $row->nmdept; ?></td>
                                    <td><?php echo $row->nmstatus; ?></td>
                                    <td width="8%">

                                        <a href="<?php
														$enc_periode = bin2hex($this->encrypt->encode(trim($row->periode)));
														$enc_kddept = bin2hex($this->encrypt->encode(trim($row->kddept)));
														$enc_type = bin2hex($this->encrypt->encode(trim('DETAILREKAPFS')));
														echo site_url("pk/pk/router_final_score_rekap") . '/' . $enc_periode . '/' . $enc_kddept . '/' . $enc_type; ?>"
                                            class="btn btn-default  btn-sm" title="DETAIL FINAL PENILAIAN KARYAWAN"><i
                                                class="fa fa-bars"></i> </a>

                                        <?php if (trim($row->status) == 'A' and $approver) { ?>
                                        <a href="<?php
															$enc_periode = bin2hex($this->encrypt->encode(trim($row->periode)));
															$enc_kddept = bin2hex($this->encrypt->encode(trim($row->kddept)));
															$enc_type = bin2hex($this->encrypt->encode(trim('APPROVREKAPFS')));
															echo site_url("pk/pk/router_final_score_rekap") . '/' . $enc_periode . '/' . $enc_kddept . '/' . $enc_type; ?>"
                                            class="btn btn-success  btn-sm" title="APPROV FINAL PENILAIAN KARYAWAN"><i
                                                class="fa fa-check"></i> </a>

                                        <a href="<?php
															$enc_periode = bin2hex($this->encrypt->encode(trim($row->periode)));
															$enc_kddept = bin2hex($this->encrypt->encode(trim($row->kddept)));
															$enc_type = bin2hex($this->encrypt->encode(trim('EDITREKAPFS')));
															echo site_url("pk/pk/router_final_score_rekap") . '/' . $enc_periode . '/' . $enc_kddept . '/' . $enc_type; ?>"
                                            class="btn btn-primary  btn-sm" title="EDIT FINAL PENILAIAN KARYAWAN"><i
                                                class="fa fa-gear"></i> </a>

                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
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
                <h4 class="modal-title" id="myModalLabel"> PILIH PERIODE PENILAIAN KARYAWAN </h4>
            </div>

            <form action="<?php echo site_url('pk/pk/generate_perdept_final_pk_rekap_tmp') ?>" method="post"
                name="inputPeriode">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input type="text" name="startPeriode" id="startDate"
                                                            class="tglYM form-control input-sm" readonly required>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="endPeriode" id="endDate"
                                                            class="tglYM form-control input-sm" readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH DEPARTMENT </label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm inputfill" name="dept" id="dept"
                                                    required>
                                                    <option value="">
                                                        <tr>
                                                            <th width="20%">-- Kode Dept |</th>
                                                            <th width="80%">| Department --</th>
                                                        </tr>
                                                    </option>
                                                    <?php foreach ($list_dept as $sc) { ?>
                                                    <option value="<?php echo trim($sc->kddept); ?>">
                                                        <tr>
                                                            <th width="20%"><?php echo trim($sc->kddept); ?> |</th>
                                                            <th width="80%">| <?php echo trim($sc->nmdept); ?></th>
                                                        </tr>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary">PROSES</button>
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
                <h4 class="modal-title" id="myModalLabel"> FILTER PENILAIAN KARYAWAN </h4>
            </div>
            <form action="<?php echo site_url('pk/pk/form_report_final_close') ?>" method="post" name="inputformPbk">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <input type="text" name="startPeriode" id="startDate"
                                                            class="tglYM form-control input-sm" readonly required>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="endPeriode" id="endDate"
                                                            class="tglYM form-control input-sm" readonly required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH NAMA KARYAWAN </label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm inputfill" name="nik" id="nik">
                                                    <option value="">
                                                        <tr>
                                                            <th width="20%">-- NIK |</th>
                                                            <th width="80%">| NAMA KARYAWAN --</th>
                                                        </tr>
                                                    </option>
                                                    <?php foreach ($list_nik as $sc) { ?>
                                                    <option value="<?php echo trim($sc->nik); ?>">
                                                        <tr>
                                                            <th width="20%"><?php echo trim($sc->nik); ?> |</th>
                                                            <th width="80%">| <?php echo trim($sc->nmlengkap); ?></th>
                                                        </tr>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH DEPARTMENT </label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm inputfill" name="dept" id="dept">
                                                    <option value="">
                                                        <tr>
                                                            <th width="20%">-- Kode Dept |</th>
                                                            <th width="80%">| Department --</th>
                                                        </tr>
                                                    </option>
                                                    <?php foreach ($list_dept as $sc) { ?>
                                                    <option value="<?php echo trim($sc->kddept); ?>">
                                                        <tr>
                                                            <th width="20%"><?php echo trim($sc->kddept); ?> |</th>
                                                            <th width="80%">| <?php echo trim($sc->nmdept); ?></th>
                                                        </tr>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit" class="btn btn-primary">PROSES</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script>
$("#tgl").datepicker();
$(".tglan").datepicker();
</script>