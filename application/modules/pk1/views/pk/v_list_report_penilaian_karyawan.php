<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function() {
    $("#example1").dataTable();
    var save_method; //for save method string
    var table;
    table = $('#example2').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "ajax": {
            "url": "<?php echo site_url('ga/permintaan/bbmpagin')?>",
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
        autoclose: true,
        viewMode: "months",
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

.nowrap {
    white-space: nowrap;
}
</style>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>

<div class="row">
    <div class="col-sm-3">
        <!--div class="container"--->
        <div class="dropdown ">
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
                                    <th class="tg-031e nowrap" rowspan="2">FS KPI </th>
                                    <th class="tg-031e nowrap" rowspan="2">FS KONDITE</th>
                                    <th class="tg-031e nowrap" rowspan="2">FS PA </th>
                                    <th class="tg-yp2e" colspan="6">
                                        <center><strong>FINAL SCORE </strong></center>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="tg-wsnc nowrap">B KPI 70%</td>
                                    <td class="tg-wsnc nowrap">B KONDITE 20%</td>
                                    <td class="tg-wsnc nowrap">B PA 10%</td>
                                    <td class="tg-wsnc nowrap">TOTAL SCORE </td>
                                    <td class="tg-lkh3 nowrap">K KATEGORI</td>
                                    <td class="tg-lkh3 nowrap">KATEGORI </td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=0; foreach($list_report as $row): $no++;?>
                                <tr>
                                    <td width="2%"><?php echo $no;?></td>
                                    <td><?php echo $row->nik;?></td>
                                    <td><?php echo $row->nmlengkap;?></td>
                                    <td><?php echo $row->nmsubdept;?></td>
                                    <td><?php echo $row->nmjabatan;?></td>
                                    <td><?php echo $row->periode;?></td>
                                    <td align="right">
                                        <?php if (trim($row->fs1_kpi )=='') { echo '0';} else { echo $row->fs1_kpi ; }?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->fs1_kondite )=='') { echo '0';} else { echo $row->fs1_kondite ; }?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->fs1_pa )=='') { echo '0';} else { echo $row->fs1_pa ; }?>
                                    </td>

                                    <td align="right">
                                        <?php if (trim($row->b1_kpi )=='') { echo '0';} else { echo $row->b1_kpi ; }?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->b1_kondite )=='') { echo '0';} else { echo $row->b1_kondite ; }?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->b1_pa )=='') { echo '0';} else { echo $row->b1_pa ; }?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ttls1 )=='') { echo '0';} else { echo $row->ttls1 ; }?>
                                    </td>
                                    <td align="right">
                                        <?php if (trim($row->ktgs1 )=='0') { echo '';} else { echo $row->ktgs1; }?></td>
                                    <td align="right">
                                        <?php if (trim($row->nmfs1 )=='0') { echo '';} else { echo $row->nmfs1; }?></td>
                                </tr>
                                <?php endforeach;?>
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
                <h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN LAPORAN PENILAIAN AKHIR KARYAWAN </h4>
            </div>
            <form action="<?php echo site_url('pk/pk/report_penilaian_karyawan')?>" method="post" name="filter">
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
                                                    <?php foreach($list_nik as $sc){?>
                                                    <option value="<?php echo trim($sc->nik);?>">
                                                        <tr>
                                                            <th width="20%"><?php echo trim($sc->nik);?> |</th>
                                                            <th width="80%">| <?php echo trim($sc->nmlengkap);?></th>
                                                        </tr>
                                                    </option>
                                                    <?php }?>
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
                <h4 class="modal-title" id="myModalLabel"> DOWNLOAD XLS PERFORMA APPRAISAL KARYAWAN FINAL REPORT</h4>
            </div>
            <form action="<?php echo site_url('pk/pk/excel_report_final_report')?>" method="post" name="xls">
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
                                                    <?php foreach($list_nik as $sc){?>
                                                    <option value="<?php echo trim($sc->nik);?>">
                                                        <tr>
                                                            <th width="20%"><?php echo trim($sc->nik);?> |</th>
                                                            <th width="80%">| <?php echo trim($sc->nmlengkap);?></th>
                                                        </tr>
                                                    </option>
                                                    <?php }?>
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
$("#tgl").datepicker();
$(".tglan").datepicker();
</script>