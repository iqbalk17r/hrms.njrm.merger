<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function() {
    $("#example1").dataTable();

    $(".inputfill").selectize();
    $('.tglYM').datepicker({
        format: "yyyy-mm",
        autoclose: true,
        viewMode: "months",
        minViewMode: "months"
    });
});
</script>
<style>
.selectize-input {
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

.tg {
    border-collapse: collapse;
    border-spacing: 0;
}

.tg td {
    font-family: Arial, sans-serif;
    font-size: 10px;
    padding: 10px 0px;
    border-style: solid;
    border-width: 1px;
    overflow: hidden;
    word-break: normal;
}

.tg th {
    font-family: Arial, sans-serif;
    font-size: 10px;
    font-weight: normal;
    padding: 10px 5px;
    border-style: solid;
    border-width: 1px;
    overflow: hidden;
    word-break: normal;
}

.tg .tg-lkh3 {
    background-color: #9aff99
}

.tg .tg-baqh {
    text-align: center;
    vertical-align: top
}

.tg .tg-wsnc {
    background-color: #fffc9e
}

.tg .tg-yp2e {
    background-color: #9698ed
}
</style>
<div class="pull-right">Versi:
    <?php echo $version; ?>
</div>
<!--div class="nav-tabs-custom"-->
<legend>
    <?php echo $title; ?>
</legend>

<?php echo $message; ?>

<div class="row">
    <div class="col-sm-3">
        <!--div class="container"--->
        <div class="dropdown ">
            <a class="btn btn-default" href="<?= site_url('pk/pk/report_kondite') ?>"><i
                    class="fa fa-arrow-left"></i>Kembali</a>
            <button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1"
                type="button" data-toggle="dropdown">Menu Filter
                <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Filter"
                        href="#"><i class="fa fa-search"></i>Filter Pencarian</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Download"
                        href="#"><i class="fa fa-download"></i>Download Xls</a></li>
            </ul>
        </div>
        <!--/div-->
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
                        <table id="example1" class="table table-bordered table-striped tg">
                            <thead>
                                <tr>
                                    <th class="tg-031e" rowspan="2">NO</th>
                                    <th class="tg-031e" rowspan="2">NIK</th>
                                    <th class="tg-031e" rowspan="2">NAMA LENGKAP</th>
                                    <th class="tg-031e" rowspan="2">BAGIAN</th>
                                    <th class="tg-031e" rowspan="2">JABATAN</th>
                                    <th class="tg-031e" rowspan="2">PERIODE</th>
                                    <th class="tg-yp2e" colspan="11">
                                        <center><strong>NILAI UMUM</strong></center>
                                    </th>
                                    <th class="tg-yp2e" colspan="11">
                                        <center><strong>PERHITUNGAN</strong></center>
                                    </th>
                                    <th class="tg-031e" rowspan="2">FS </th>
                                    <th class="tg-031e" rowspan="2">FS KTG</th>
                                    <th class="tg-031e" rowspan="2">FS DESC</th>
                                </tr>
                                <tr>
                                    <td class="tg-wsnc">IP</td>
                                    <td class="tg-lkh3">SD</td>
                                    <td class="tg-wsnc">AL</td>
                                    <td class="tg-lkh3">TL</td>
                                    <td class="tg-lkh3">DT</td>
                                    <td class="tg-lkh3">PA</td>
                                    <td class="tg-wsnc">SP1</td>
                                    <td class="tg-lkh3">SP2</td>
                                    <td class="tg-wsnc">SP3</td>
                                    <td class="tg-lkh3">CT</td>
                                    <td class="tg-wsnc">IK</td>
                                    <td class="tg-wsnc">IP</td>
                                    <td class="tg-lkh3">SD</td>
                                    <td class="tg-wsnc">AL</td>
                                    <td class="tg-lkh3">TL</td>
                                    <td class="tg-lkh3">DT</td>
                                    <td class="tg-lkh3">PA</td>
                                    <td class="tg-wsnc">SP1</td>
                                    <td class="tg-lkh3">SP2</td>
                                    <td class="tg-wsnc">SP3</td>
                                    <td class="tg-lkh3">CT</td>
                                    <td class="tg-wsnc">IK</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
								foreach ($list_report as $row):
									$no++; ?>
                                <tr>
                                    <td width="2%">
                                        <?php echo $no; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->nik; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->nmlengkap; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->nmsubdept; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->nmjabatan; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->periode; ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttlvalueip) == '0') {
												echo '';
											} else {
												echo $row->ttlvalueip;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttlvaluesd) == '0') {
												echo '';
											} else {
												echo $row->ttlvaluesd;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttlvalueal) == '0') {
												echo '';
											} else {
												echo $row->ttlvalueal;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttlvaluetl) == '0') {
												echo '';
											} else {
												echo $row->ttlvaluetl;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttlvalueitl) == '0') {
												echo '';
											} else {
												echo $row->ttlvalueitl;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttlvalueipa) == '0') {
												echo '';
											} else {
												echo $row->ttlvalueipa;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttlvaluesp1) == '0') {
												echo '';
											} else {
												echo $row->ttlvaluesp1;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttlvaluesp2) == '0') {
												echo '';
											} else {
												echo $row->ttlvaluesp2;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttlvaluesp3) == '0') {
												echo '';
											} else {
												echo $row->ttlvaluesp3;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttlvaluect) == '0') {
												echo '';
											} else {
												echo $row->ttlvaluect;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttlvalueik) == '0') {
												echo '';
											} else {
												echo $row->ttlvalueik;
											} ?>
                                    </td>

                                    <td align="right">
                                        <?php if (trim($row->c2_ttlvalueip) == '0') {
												echo '';
											} else {
												echo $row->c2_ttlvalueip;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->c2_ttlvaluesd) == '0') {
												echo '';
											} else {
												echo $row->c2_ttlvaluesd;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->c2_ttlvalueal) == '0') {
												echo '';
											} else {
												echo $row->c2_ttlvalueal;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->c2_ttlvaluetl) == '0') {
												echo '';
											} else {
												echo $row->c2_ttlvaluetl;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->c2_ttlvalueitl) == '0') {
												echo '';
											} else {
												echo $row->c2_ttlvalueitl;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->c2_ttlvalueipa) == '0') {
												echo '';
											} else {
												echo $row->c2_ttlvalueipa;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->c2_ttlvaluesp1) == '0') {
												echo '';
											} else {
												echo $row->c2_ttlvaluesp1;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->c2_ttlvaluesp2) == '0') {
												echo '';
											} else {
												echo $row->c2_ttlvaluesp2;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->c2_ttlvaluesp3) == '0') {
												echo '';
											} else {
												echo $row->c2_ttlvaluesp3;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->c2_ttlvaluect) == '0') {
												echo '';
											} else {
												echo $row->c2_ttlvaluect;
											} ?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->c2_ttlvalueik) == '0') {
												echo '';
											} else {
												echo $row->c2_ttlvalueik;
											} ?>
                                    </td>

                                    <td align="right">
                                        <?php echo $row->f_score_k; ?>
                                    </td>
                                    <td align="right">
                                        <?php echo $row->f_ktg_fs; ?>
                                    </td>
                                    <td align="right">
                                        <?php echo $row->bpa; ?>
                                    </td>


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
<!--/ nav -->

<div class="modal fade" id="Filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN LAPORAN KONDITE KARYAWAN</h4>
            </div>
            <form action="<?php echo site_url('pk/pk/report_kondite_karyawan') ?>" method="post" name="inputformPbk">
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
                                                <input type="hidden" name="nik" value="<?= $fnik ?>">
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
</div>

<div class="modal fade" id="Download" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> DOWNLOAD XLS KONDITE KARYAWAN </h4>
            </div>
            <form action="<?php echo site_url('pk/pk/excel_report_form_kondite') ?>" method="post" name="inputformPbk">
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
                                            <input type="hidden" name="nik" value="<?= $fnik ?>">
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit" class="btn btn-primary"><i
                                    class="fa fa-download"></i>DOWNLOAD</button>
                        </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
//Date range picker
$("#tgl").datepicker();
$(".tglan").datepicker();
</script>