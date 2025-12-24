<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function() {
    $("#table").dataTable();

    $(".inputfill").selectize();
    $('.tglYM').datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
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
</style>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<legend><?php echo $title; ?></legend>

<?php echo $message; ?>

<div class="row">
    <div class="col-sm-3">
        <!--div class="container"--->
        <div class="dropdown ">
            <button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1"
                type="button" data-toggle="dropdown">Menu Filter
                <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                <!-- <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Filter" href="#"><i class="fa fa-search"></i>Filter Pencarian</a></li> -->
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
                        <table id="table" class="table table-bordered table-striped tg">
                            <thead>
                                <tr>
                                    <td class="tg-031e">NO</td>
                                    <td class="tg-031e">NIK</td>
                                    <td class="tg-031e">NAMA LENGKAP</td>
                                    <td class="tg-031e">BAGIAN</td>
                                    <td class="tg-031e">JABATAN</td>
                                    <!-- <td class="tg-031e" >PERIODE</td>
									<td class="tg-031e" >NILAI KPI</td>
									<td class="tg-031e" >SCORE KPI</td>
									<td class="tg-031e" >KATEGORI</td> -->
                                    <td class="tg-031e">AKSI</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
								foreach ($list_nik as $row) : $no++; ?>
                                <tr>
                                    <td width="2%"><?php echo $no; ?></td>
                                    <td><?php echo $row->nik; ?></td>
                                    <td><?php echo $row->nmlengkap; ?></td>
                                    <td><?php echo $row->nmsubdept; ?></td>
                                    <td><?php echo $row->nmjabatan; ?></td>
                                    <!-- <td><?php //echo $row->periode; ?></td>
										<td align="right"><?php //echo round($row->kpi_point,2); ?></td>
										<td align="right"><?php //echo round($row->kpi_score,2); ?></td>
										<td align="right"><?php //echo $row->kpi_ktg_fs; ?></td> -->
                                    <td><a href="<?= base_url("pk/pk/report_kondite_karyawan/$row->nik"); ?>"
                                            class="btn btn-default btn-sm"><i class="fa fa-bars"></i></a></td>
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
                <h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN LAPORAN KPI </h4>
            </div>
            <form action="<?php echo site_url('pk/pk/form_report_kpi') ?>" method="post" name="inputformPbk">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <!-- <div class="form-group ">
											<label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
											<div class="col-sm-8">
												<input type="input" name="periode" id="periode" class="form-control input-sm  tglYM">
											</div>
										</div> -->
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
                                                            <th width="80%">| <?php echo trim($sc->nmlengkap); ?>
                                                            </th>
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
<script>
//Date range picker
$("#tgl").datepicker();
$(".tglan").datepicker();
</script>