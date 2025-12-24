<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function() {
    $('#example1').dataTable({
        lengthMenu: [
            [70, -1],
            [70, "All"]
        ],
        pageLength: 70
    });

    $("#datatableMaster").dataTable();
    $("#example3").dataTable();
    $("#example4").dataTable();
    $(".inputfill").selectize();
    $('.tglYM').datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months"
    });

    $('form').on('focus', 'input[type=number]', function(e) {
        $(this).on('mousewheel.disableScroll', function(e) {
            e.preventDefault()
        })
    })
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
<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
    <?php if (trim($y1->kodemenu) != trim($kodemenu)) { ?>
    <li><a href="<?php echo site_url(trim($y1->linkmenu)); ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i>
            <?php echo trim($y1->namamenu); ?></a></li>
    <?php } else { ?>
    <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
    <?php } ?>
    <?php } ?>
</ol>

<h3><?php echo $title; ?></h3>

<?php echo $message; ?>

<div class="col-sm-11">
    <a href="<?php echo site_url("pk/pk/clear_input_kondite") ?>" class="btn btn-default"
        onclick="return confirm('Kembali Akan Mereset Inputan Yang Anda Buat, Apakah Anda Yakin....???')"
        style="margin:10px; color:#000000;"><i class="fa fa-arrow-left"></i> Kembali</a>
</div>
<div class="col-sm-1 pull-right">
    <a href="<?php echo site_url("pk/pk/final_input_kondite") ?>" class="btn btn-primary"
        onclick="return confirm('Apakah Anda Simpan Data Ini??')" style="margin:10px; color:#ffffff;"> <i
            class="fa fa-save"></i> SIMPAN </a>
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
                        <table id="datarekap" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>NODOK</th>
                                    <th>NIK</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>PERIODE</th>
                                    <th>F SCORE</th>
                                    <th>FS KATEGORI</th>
                                    <th>FS KTG VALUE</th>
                                    <th>FS DESC</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kondite_tmp_rekap as $row): ?>
                                <tr>
                                    <td><?php echo trim($row->nodok); ?></td>
                                    <td><?php echo trim($row->nik); ?></td>
                                    <td><?php echo trim($row->nmlengkap); ?></td>
                                    <td><?php echo trim($row->periode); ?></td>
                                    <td align="right"><?php echo trim($row->f_score_k); ?></td>
                                    <td align="right"><?php echo trim($row->f_ktg_fs); ?></td>
                                    <td align="right"><?php echo trim($row->f_kdvalue_fs); ?></td>
                                    <td align="center"><?php echo trim($row->f_desc_fs); ?></td>
                                    <td align="right"><?php echo trim($row->nmstatus); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" style='overflow-x:scroll;'>
                        <table id="datatableMaster" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="2%">No.</th>
                                    <th>NODOK</th>
                                    <th>NIK</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>PERIODE</th>
                                    <th>F SCORE</th>
                                    <th>FS KATEGORI</th>
                                    <th>FS KTG VALUE</th>
                                    <th>FS DESC</th>
                                    <th>STATUS</th>
                                    <th width="8%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                            foreach ($list_tmp_kondite_mst as $row):
                                $no++; ?>
                                <tr>
                                    <td width="2%"><?php echo $no; ?></td>
                                    <td><?php echo trim($row->nodok); ?></td>
                                    <td><?php echo trim($row->nik); ?></td>
                                    <td><?php echo trim($row->nmlengkap); ?></td>
                                    <td><?php echo trim($row->periode); ?></td>
                                    <td align="right"><?php echo trim($row->f_score_k); ?></td>
                                    <td align="right"><?php echo trim($row->f_ktg_fs); ?></td>
                                    <td align="right"><?php echo trim($row->f_kdvalue_fs); ?></td>
                                    <td align="center"><?php echo trim($row->f_desc_fs); ?></td>
                                    <td align="right"><?php echo trim($row->nmstatus); ?></td>

                                    <td width="8%">
                                        <a href="#" data-toggle="modal"
                                            data-target="#EDMST<?php echo str_replace('.', '', trim($row->nodok)) . str_replace('.', '', trim($row->nik)) . str_replace('.', '', trim($row->periode)); ?>"
                                            class="btn btn-primary  btn-sm" title="Edit Master Kondite"><i
                                                class="fa fa-gear"></i></a>
                                        <a href="#" data-toggle="modal"
                                            data-target="#DTLMST<?php echo str_replace('.', '', trim($row->nodok)) . str_replace('.', '', trim($row->nik)) . str_replace('.', '', trim($row->periode)); ?>"
                                            class="btn btn-default  btn-sm" title="Detail Master Kondite"><i
                                                class="fa fa-bars"></i></a>
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

    <div class="col-sm-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <legend align="center"><?php echo 'PERHITUNGAN'; ?></legend>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" style='overflow-x:scroll;'>
                        <table id="#" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="2%" style="display:none">No.</th>
                                    <th bgcolor="#00cc99">Periode</th>
                                    <th bgcolor="#00cc99">IP</th>
                                    <th bgcolor="#00cc99">SD</th>
                                    <th bgcolor="#00cc99">AL</th>
                                    <th bgcolor="#00cc99">TL</th>
                                    <th bgcolor="#00cc99">DT</th>
                                    <th bgcolor="#00cc99">PA</th>
                                    <th bgcolor="#00cc99">SP1</th>
                                    <th bgcolor="#00cc99">SP2</th>
                                    <th bgcolor="#00cc99">SP3</th>
                                    <th bgcolor="#00cc99">CT</th>
                                    <th bgcolor="#00cc99">IK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                foreach ($list_tmp_kondite_mst as $row):
                                    $no++; ?>
                                <tr>
                                    <td width="2%" style="display:none"><?php echo $no; ?></td>
                                    <td align="right"><?php echo trim($row->periode); ?></td>
                                    <td align="right"><?php echo trim($row->c2_ttlvalueip); ?></td>
                                    <td align="right"><?php echo trim($row->c2_ttlvaluesd); ?></td>
                                    <td align="right"><?php echo trim($row->c2_ttlvalueal); ?></td>
                                    <td align="right"><?php echo trim($row->c2_ttlvaluetl); ?></td>
                                    <td align="right"><?php echo trim($row->c2_ttlvalueitl); ?></td>
                                    <td align="right"><?php echo trim($row->c2_ttlvalueipa); ?></td>
                                    <td align="right"><?php echo trim($row->c2_ttlvaluesp1); ?></td>
                                    <td align="right"><?php echo trim($row->c2_ttlvaluesp2); ?></td>
                                    <td align="right"><?php echo trim($row->c2_ttlvaluesp3); ?></td>
                                    <td align="right"><?php echo trim($row->c2_ttlvaluect); ?></td>
                                    <td align="right"><?php echo trim($row->c2_ttlvalueik); ?></td>
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


<?php foreach ($list_tmp_kondite_mst as $lb) { ?>
<div class="modal fade"
    id="EDMST<?php echo str_replace('.', '', trim($lb->nodok)) . str_replace('.', '', trim($lb->nik)) . str_replace('.', '', trim($lb->periode)); ?>"
    tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> UBAH MASTER KONDITE PER KARYAWAN</h4>
            </div>
            <form action="<?php echo site_url('pk/pk/save_kondite') ?>" method="post" name="Form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">KODE KRITERIA</label>
                                            <div class="col-sm-8">

                                                <input type="hidden" name="nik" id="nik"
                                                    value="<?php echo trim($lb->nik); ?>" class="form-control input-sm"
                                                    readonly>
                                                <input type="input" name="nmlengkap" id="nmlengkap"
                                                    value="<?php echo trim($lb->nmlengkap); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="nodok" id="nodok"
                                                    value="<?php echo trim($lb->nodok); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="periode" id="periode"
                                                    value="<?php echo trim($lb->periode); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="startPeriode" id="startPeriode"
                                                    value="<?php echo trim($startPeriode); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="endPeriode" id="endPeriode"
                                                    value="<?php echo trim($endPeriode); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="nikatasan1" id="nikatasan1"
                                                    value="<?php echo trim($lb->nikatasan1); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="nikatasan2" id="nikatasan2"
                                                    value="<?php echo trim($lb->nikatasan2); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="type" id="type" value="EDITMSTKONDITE"
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">BAGIAN</label>
                                            <div class="col-sm-8">
                                                <input type="input" name="kdsubdept" id="kdsubdept"
                                                    value="<?php echo trim($lb->nmsubdept); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">JABATAN</label>
                                            <div class="col-sm-8">
                                                <input type="input" name="kdjabatan" id="kdjabatan"
                                                    value="<?php echo trim($lb->nmjabatan); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PERIODE</label>
                                            <div class="col-sm-8">
                                                <input type="input" name="periode" id="periode"
                                                    value="<?php echo trim($lb->periode); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">NAMA ATASAN 1</label>
                                            <div class="col-sm-8">
                                                <input type="input" name="nmatasan1" id="nmatasan1"
                                                    value="<?php echo trim($lb->nmatasan1); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">NAMA ATASAN 2</label>
                                            <div class="col-sm-8">
                                                <input type="input" name="nmatasan2" id="nmatasan2"
                                                    value="<?php echo trim($lb->nmatasan2); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">DESKIRPSI KATEGORI</label>
                                            <div class="col-sm-8">
                                                <textarea type="input" name="description" id="description"
                                                    style="text-transform: uppercase;"
                                                    value="<?php echo trim($lb->description); ?> "
                                                    class="form-control input-sm" rows="4" cols="50"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <div class="col-sm-6">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL IJIN(IP)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvalueip" id="ttlvalueip"
                                                    value="<?php echo trim($lb->ttlvalueip); ?>"
                                                    class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL KETERANGAN DOKTER(SD)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluesd" id="ttlvaluesd"
                                                    value="<?php echo trim($lb->ttlvaluesd); ?>"
                                                    class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL ALPHA(AL)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvalueal" id="ttlvalueal"
                                                    value="<?php echo trim($lb->ttlvalueal); ?>"
                                                    class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL TERLAMBAT(TL)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluetl" id="ttlvaluetl"
                                                    value="<?php echo trim($lb->ttlvaluetl); ?>"
                                                    class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL IJIN DATANG
                                                TERLAMBAT(DT)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvalueitl" id="ttlvalueitl"
                                                    value="<?php echo trim($lb->ttlvalueitl); ?>"
                                                    class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL IJIN PULANG AWAL(PA)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvalueipa" id="ttlvalueipa"
                                                    value="<?php echo trim($lb->ttlvalueipa); ?>"
                                                    class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL SP1</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluesp1" id="ttlvaluesp1"
                                                    value="<?php echo trim($lb->ttlvaluesp1); ?>"
                                                    class="form-control input-sm" min="0" max="30">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL SP2</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluesp2" id="ttlvaluesp2"
                                                    value="<?php echo trim($lb->ttlvaluesp2); ?>"
                                                    class="form-control input-sm" min="0" max="30">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL SP3</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluesp3" id="ttlvaluesp3"
                                                    value="<?php echo trim($lb->ttlvaluesp3); ?>"
                                                    class="form-control input-sm" min="0" max="30">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL CUTI(CT)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluect" id="ttlvaluect"
                                                    value="<?php echo trim($lb->ttlvaluect); ?>"
                                                    class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">IJIN KHUSUS(IK)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvalueik" id="ttlvalueik"
                                                    value="<?php echo trim($lb->ttlvalueik); ?>"
                                                    class="form-control input-sm">
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
                    <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-refresh"></i>PROSES
                        DATA</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>


<?php foreach ($list_tmp_kondite_mst as $lb) { ?>
<div class="modal fade"
    id="DTLMST<?php echo str_replace('.', '', trim($lb->nodok)) . str_replace('.', '', trim($lb->nik)) . str_replace('.', '', trim($lb->periode)); ?>"
    tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> DETAIL MASTER KONDITE PER KARYAWAN</h4>
            </div>
            <form action="<?php echo site_url('pk/pk/save_kondite') ?>" method="post" name="Form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">KODE KRITERIA</label>
                                            <div class="col-sm-8">

                                                <input type="hidden" name="nik" id="nik"
                                                    value="<?php echo trim($lb->nik); ?>" class="form-control input-sm"
                                                    readonly>
                                                <input type="input" name="nmlengkap" id="nmlengkap"
                                                    value="<?php echo trim($lb->nmlengkap); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="nodok" id="nodok"
                                                    value="<?php echo trim($lb->periode); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="periode" id="periode"
                                                    value="<?php echo trim($lb->periode); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="startPeriode" id="startPeriode"
                                                    value="<?php echo trim($startPeriode); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="endPeriode" id="endPeriode"
                                                    value="<?php echo trim($endPeriode); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="nikatasan1" id="nikatasan1"
                                                    value="<?php echo trim($lb->nikatasan1); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="nikatasan2" id="nikatasan2"
                                                    value="<?php echo trim($lb->nikatasan2); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="type" id="type" value="EDITMSTKONDITE"
                                                    class="form-control input-sm" readonly>

                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">BAGIAN</label>
                                            <div class="col-sm-8">
                                                <input type="input" name="kdsubdept" id="kdsubdept"
                                                    value="<?php echo trim($lb->nmsubdept); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">JABATAN</label>
                                            <div class="col-sm-8">
                                                <input type="input" name="kdjabatan" id="kdjabatan"
                                                    value="<?php echo trim($lb->nmjabatan); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PERIODE</label>
                                            <div class="col-sm-8">
                                                <input type="input" name="periode" id="periode"
                                                    value="<?php echo trim($lb->periode); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">NAMA ATASAN 1</label>
                                            <div class="col-sm-8">
                                                <input type="input" name="nmatasan1" id="nmatasan1"
                                                    value="<?php echo trim($lb->nmatasan1); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">NAMA ATASAN 2</label>
                                            <div class="col-sm-8">
                                                <input type="input" name="nmatasan2" id="nmatasan2"
                                                    value="<?php echo trim($lb->nmatasan2); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">DESKIRPSI KATEGORI</label>
                                            <div class="col-sm-8">
                                                <textarea type="input" name="description" id="description"
                                                    style="text-transform: uppercase;"
                                                    value="<?php echo trim($lb->description); ?> "
                                                    class="form-control input-sm" rows="4" cols="50" disabled
                                                    readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <div class="col-sm-6">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL IJIN(IP)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvalueip" id="ttlvalueip"
                                                    value="<?php echo trim($lb->ttlvalueip); ?>"
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL KETERANGAN DOKTER(SD)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluesd" id="ttlvaluesd"
                                                    value="<?php echo trim($lb->ttlvaluesd); ?>"
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL ALPHA(AL)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvalueal" id="ttlvalueal"
                                                    value="<?php echo trim($lb->ttlvalueal); ?>"
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL TERLAMBAT(TL)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluetl" id="ttlvaluetl"
                                                    value="<?php echo trim($lb->ttlvaluetl); ?>"
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL IJIN DATANG
                                                TERLAMBAT(DT)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvalueitl" id="ttlvalueitl"
                                                    value="<?php echo trim($lb->ttlvalueitl); ?>"
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL IJIN PULANG AWAL(PA)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvalueipa" id="ttlvalueipa"
                                                    value="<?php echo trim($lb->ttlvalueipa); ?>"
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL SP1</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluesp1" id="ttlvaluesp1"
                                                    value="<?php echo trim($lb->ttlvaluesp1); ?>"
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL SP2</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluesp2" id="ttlvaluesp2"
                                                    value="<?php echo trim($lb->ttlvaluesp2); ?>"
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL SP3</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluesp3" id="ttlvaluesp3"
                                                    value="<?php echo trim($lb->ttlvaluesp3); ?>"
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">TOTAL CUTI(CT)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvaluect" id="ttlvaluect"
                                                    value="<?php echo trim($lb->ttlvaluect); ?>"
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">IJIN KHUSUS(IK)</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="ttlvalueik" id="ttlvalueik"
                                                    value="<?php echo trim($lb->ttlvalueik); ?>"
                                                    class="form-control input-sm" readonly>
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
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>


<script>
//Date range picker
$("#tgl").datepicker();
$(".tglan").datepicker();
</script>