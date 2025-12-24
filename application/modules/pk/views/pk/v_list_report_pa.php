<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(function () {
        $("#example1").dataTable();
        var save_method; //for save method string
        var table;

        $(".inputfill").selectize();
        $('.tglYM').datepicker({
            format: "yyyy-mm",
            autoclose: true,
            viewMode: "months",
            minViewMode: "months"
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
<div class="pull-right">Versi: <?php echo $version; ?></div>
<legend><?php echo $title; ?></legend>

<?php echo $message; ?>

<div class="row">
    <div class="col-sm-3">
        <div class="dropdown ">
            <button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1"
                type="button" data-toggle="dropdown">Menu Filter
                <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Filter"
                        href="#"><i class="fa fa-search"></i>Filter Pencarian</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Download"
                        href="#"><i class="fa fa-download"></i>Download Xls</a></li>
                <!-- <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal"
                        data-target="#generateReport" href="#"><i class="fa fa-twitter-square"></i>Generate Report</a>
                </li> -->
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
                                    <th>NO</th>
                                    <th>NIK</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>PERIODE</th>
                                    <th>BAGIAN</th>
                                    <th>JABATAN</th>
                                    <th class="tg-yp2e">KRITERIA 1</th>
                                    <th class="tg-yp2e">KRITERIA 2</th>
                                    <th class="tg-yp2e">KRITERIA 3</th>
                                    <th class="tg-yp2e">KRITERIA 4</th>
                                    <th class="tg-yp2e">KRITERIA 5</th>
                                    <th class="tg-yp2e">KRITERIA 6</th>
                                    <th class="tg-yp2e">KRITERIA 7</th>
                                    <th class="tg-yp2e">KRITERIA 8</th>
                                    <th class="tg-yp2e">KRITERIA 9</th>
                                    <th class="tg-yp2e">KRITERIA 10</th>
                                    <th class="tg-yp2e">KRITERIA 11</th>
                                    <th class="tg-yp2e">KRITERIA 12</th>
                                    <th class="tg-yp2e">KRITERIA 13</th>
                                    <th class="tg-lkh3">FS</th>
                                    <th class="tg-lkh3">KATEGORI</th>
                                    <th class="tg-lkh3">DESKRIPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                foreach ($list_report as $row):
                                    $no++; ?>
                                    <tr>
                                        <td width="2%"><?php echo $no; ?></td>
                                        <td><?php echo $row->nik; ?></td>
                                        <td><?php echo $row->nmlengkap; ?></td>
                                        <td><?php echo $row->periode; ?></td>
                                        <td><?php echo $row->nmsubdept; ?></td>
                                        <td><?php echo $row->nmjabatan; ?></td>
                                        <td><?php echo $row->na1; ?></td>
                                        <!-- <td><?php echo $row->nb1; ?></td> -->
                                        <td><?php echo $row->na2; ?></td>
                                        <!-- <td><?php echo $row->nb2; ?></td> -->
                                        <td><?php echo $row->na3; ?></td>
                                        <!-- <td><?php echo $row->nb3; ?></td> -->
                                        <td><?php echo $row->na4; ?></td>
                                        <!-- <td><?php echo $row->nb4; ?></td> -->
                                        <td><?php echo $row->na5; ?></td>
                                        <!-- <td><?php echo $row->nb5; ?></td> -->
                                        <td><?php echo $row->na6; ?></td>
                                        <!-- <td><?php echo $row->nb6; ?></td> -->
                                        <td><?php echo $row->na7; ?></td>
                                        <!-- <td><?php echo $row->nb7; ?></td> -->
                                        <td><?php echo $row->na8; ?></td>
                                        <!-- <td><?php echo $row->nb8; ?></td> -->
                                        <td><?php echo $row->na9; ?></td>
                                        <!-- <td><?php echo $row->nb9; ?></td> -->
                                        <td><?php echo $row->na10; ?></td>
                                        <!-- <td><?php echo $row->nb10; ?></td> -->
                                        <td><?php echo $row->na11; ?></td>
                                        <!-- <td><?php echo $row->nb11; ?></td> -->
                                        <td><?php echo $row->na12; ?></td>
                                        <!-- <td><?php echo $row->nb12; ?></td> -->
                                        <td><?php echo $row->na13; ?></td>
                                        <!-- <td><?php echo $row->nb13; ?></td> -->
                                        <td><?php echo $row->ttlvalue1; ?></td>
                                        <!-- <td><?php echo $row->ttlvalue2; ?></td> -->
                                        <!-- <td><?php echo $row->f_value; ?></td> -->
                                        <td><?php echo $row->f_value_ktg; ?></td>
                                        <!-- <td><?php //echo $row->kdbpa; ?></td> -->
                                        <td><?php echo $row->bpa; ?></td>

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
                <h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN LAPORAN PERFORMA APPRAISAL </h4>
            </div>
            <form action="<?php echo site_url('pk/pk/form_report_pa') ?>" method="post" name="filter">
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
                <h4 class="modal-title" id="myModalLabel"> DOWNLOAD XLS PERFORMA APPRAISAL KARYAWAN </h4>
            </div>
            <form action="<?php echo site_url('pk/pk/excel_report_form_pa') ?>" method="post" name="downloadxls">
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

<div class="modal fade" id="generateReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> GENERATE REPORT PA (PERIODE)</h4>
            </div>
            <form action="<?php echo site_url('pk/pk/generatePaReport') ?>" method="post" name="generate">
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
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit" class="btn btn-warning"><i class="fa fa-twitter-square"></i>
                            GENERATE </button>
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