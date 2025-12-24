<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
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
<!--div class="pull-right">Versi: <?php echo $version; ?></div--->
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>

<div class="col-sm-11">
    <a href="<?php
    $enc_periode=bin2hex($this->encrypt->encode(trim($dtlrow['periode'])));
    $enc_dept=bin2hex($this->encrypt->encode(trim($dtlrow['kddept'])));
    echo site_url("pk/pk/form_report_final_close_trx".'/'.$enc_periode.'/'.$enc_dept)?>" class="btn btn-default"
        style="margin:10px; color:#000000;">Kembali</a>
</div>
<?php if ((trim($dtlrow['a1_approved'])=='f' and trim($dtlrow['a2_approved'])=='f' and trim($dtlrow['nikatasan1'])==$nama) or 
(trim($dtlrow['a1_approved'])=='t' and trim($dtlrow['a2_approved'])=='f' and trim($dtlrow['nikatasan2'])==$nama) or
(trim($dtlrow['a1_approved'])=='f' and trim($dtlrow['a2_approved'])=='f' and (trim($dtlrow['nikatasan1'])==$nama and trim($dtlrow['nikatasan2'])==$nama))) { ?>
<div class="col-sm-1 pull-right">		
	<a href="<?php 
	$enc_nik=bin2hex($this->encrypt->encode(trim($dtlrow['nik'])));
    $enc_periode=bin2hex($this->encrypt->encode(trim($dtlrow['periode'])));
    if (trim($dtlrow['nikatasan1'])==$nama && trim($dtlrow['nikatasan2'])==$nama) $code=bin2hex($this->encrypt->encode('p')); 
    if (trim($dtlrow['nikatasan1'])==$nama) $code=bin2hex($this->encrypt->encode('a2')); 
    if (trim($dtlrow['nikatasan2'])==$nama) $code=bin2hex($this->encrypt->encode('p'));
	echo site_url("pk/pk/approval_input_penilaian_karyawan/$enc_nik/$enc_periode/$code"); ?>"  class="btn btn-success" onclick="return confirm('Apakah Anda Simpan Final Data Ini??')" style="margin:10px; color:#ffffff;">Approval </a>
</div>
<?php } ?>	
</br>
<div class="row">
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
                                    <th>NODOK </th>
                                    <th>NIK </th>
                                    <th>NAMA LENGKAP </th>
                                    <th>PERIODE </th>
                                    <th>KPI </th>
                                    <th>KONDITE </th>
                                    <th>PA </th>
                                    <th>STATUS </th>
                                    <th>DESKRIPSI </th>
                                    <th width="8%">AKSI </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                foreach ($list_tmp_final_pk as $row) : $no++; ?>
                                    <tr>
                                        <td width="2%"><?php echo $no; ?></td>
                                        <td><?php echo trim($row->nodok); ?></td>
                                        <td><?php echo trim($row->nik); ?></td>
                                        <td><?php echo trim($row->nmlengkap); ?></td>
                                        <td><?php echo trim($row->periode); ?></td>
                                        <td align="right"><?php echo trim($row->fs1_kpi); ?></td>
                                        <td align="right"><?php echo trim($row->fs1_kondite); ?></td>
                                        <td align="right"><?php echo trim($row->fs1_pa); ?></td>
                                        <td><?php echo trim($row->nmstatus); ?></td>
                                        <td><?php echo trim($row->description); ?></td>

                                        <!--td><?php if (empty($row->docdate)) {
                                                    echo '';
                                                } else {
                                                    echo date('d-m-Y', strtotime(trim($row->ajustment_date)));
                                                } ?></td-->

                                        <td width="8%">
                                            <a href="#" data-toggle="modal" data-target="#DTLMST<?php echo str_replace('/', '', trim($row->nodok)) . str_replace('.', '', trim($row->nik)) . str_replace('.', '', trim($row->periode)); ?>" class="btn btn-default  btn-sm" title="Detail Master Instruksi Kerja"><i class="fa fa-bars"></i></a>
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
                        <legend align="center"><?php echo 'FINAL SCORE'; ?></legend>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" style='overflow-x:scroll;'>
                        <table id="#" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="2%" style="display:none">No.</th>
                                    <th bgcolor="#ffcc99">BOBOT KPI (<?php echo trim($dtl_mst_trx['p1_kpi']); ?>%)</th>
                                    <th bgcolor="#ffcc99">BOBOT KONDITE (<?php echo trim($dtl_mst_trx['p1_kondite']); ?>%)</th>
                                    <th bgcolor="#ffcc99">BOBOT PA (<?php echo trim($dtl_mst_trx['p1_pa']); ?>%)</th>
                                    <th bgcolor="#ffcc99">TOTAL SCORE </th>
                                    <th bgcolor="#ffcc99">KATEGORI SCORE </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                foreach ($list_tmp_final_pk as $row) : $no++; ?>
                                    <tr>
                                        <td width="2%" style="display:none"><?php echo $no; ?></td>
                                        <td align="right"><?php echo trim($row->b1_kpi); ?></td>
                                        <td align="right"><?php echo trim($row->b1_kondite); ?></td>
                                        <td align="right"><?php echo trim($row->b1_pa); ?></td>
                                        <td align="right"><?php echo trim($row->ttls1); ?></td>
                                        <td align="right"><?php echo trim($row->nmfs1); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
</div><!--/ nav -->


<?php foreach ($list_tmp_final_pk as $lb) { ?>
    <div class="modal fade" id="DTLMST<?php echo str_replace('/', '', trim($lb->nodok)) . str_replace('.', '', trim($lb->nik)) . str_replace('.', '', trim($lb->periode)); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel"> DETAIL MASTER KONDITE PER KARYAWAN</h4>
                </div>
                <form action="<?php echo site_url('pk/pk/save_penilaian_karyawan') ?>" method="post" name="Form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box box-danger">
                                    <div class="box-body">
                                        <div class="form-horizontal">
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">KODE KRITERIA</label>
                                                <div class="col-sm-8">
    
                                                    <input type="hidden" name="nik" id="nik" value="<?php echo trim($lb->nik); ?>" class="form-control input-sm" readonly>
                                                    <input type="input" name="nmlengkap" id="nmlengkap" value="<?php echo trim($lb->nmlengkap); ?>" class="form-control input-sm" readonly>
                                                    <input type="hidden" name="nodok" id="nodok" value="<?php echo trim($lb->nodok); ?>" class="form-control input-sm" readonly>
                                                    <input type="hidden" name="periode" id="periode" value="<?php echo trim($lb->periode); ?>" class="form-control input-sm" readonly>
                                                    <input type="hidden" name="nikatasan1" id="nikatasan1" value="<?php echo trim($lb->nikatasan1); ?>" class="form-control input-sm" readonly>
                                                    <input type="hidden" name="nikatasan2" id="nikatasan2" value="<?php echo trim($lb->nikatasan2); ?>" class="form-control input-sm" readonly>
                                                    <input type="hidden" name="type" id="type" value="EDITMSTFINALPK" class="form-control input-sm" readonly>

                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">BAGIAN</label>
                                                <div class="col-sm-8">
                                                    <input type="input" name="kdsubdept" id="kdsubdept" value="<?php echo trim($lb->nmsubdept); ?> " class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">JABATAN</label>
                                                <div class="col-sm-8">
                                                    <input type="input" name="kdjabatan" id="kdjabatan" value="<?php echo trim($lb->nmjabatan); ?> " class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">PERIODE</label>
                                                <div class="col-sm-8">
                                                    <input type="input" name="periode" id="periode" value="<?php echo trim($lb->periode); ?> " class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">NAMA ATASAN 1</label>
                                                <div class="col-sm-8">
                                                    <input type="input" name="nmatasan1" id="nmatasan1" value="<?php echo trim($lb->nmatasan1); ?> " class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">NAMA ATASAN 2</label>
                                                <div class="col-sm-8">
                                                    <input type="input" name="nmatasan2" id="nmatasan2" value="<?php echo trim($lb->nmatasan2); ?> " class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">DESKIRPSI KATEGORI</label>
                                                <div class="col-sm-8">
                                                    <textarea type="input" name="description" id="description" style="text-transform: uppercase;" class="form-control input-sm" rows="4" cols="50" disabled readonly> <?php echo trim($lb->description); ?> </textarea>
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
                                                <label class="col-sm-4" for="inputsm">TOTAL KEY PERFORMANCE INDICATOR (KPI)</label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="fs1_kpi" id="fs1_kpi" value="<?php echo trim($lb->fs1_kpi); ?>" class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">TOTAL KONDITE (KDT)</label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="fs1_kondite" id="fs1_kondite" value="<?php echo trim($lb->fs1_kondite); ?>" class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">TOTAL PERFORMANCE APPRAISAL (PA)</label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="fs1_pa" id="fs1_pa" value="<?php echo trim($lb->fs1_pa); ?>" class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">CATATAN</label>
                                                <div class="col-sm-8">
                                                    <textarea type="input" name="note" id="description" style="text-transform: uppercase;" class="form-control input-sm" <?php if ((trim($lb->nikatasan1) != $nama and trim($lb->nikatasan2) != $nama) or trim($lb->status) == 'P') echo 'readonly' ?> > <?php echo $lb->note; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">SARAN</label>
                                                <div class="col-sm-8">
                                                    <textarea type="input" name="suggestion" id="description" style="text-transform: uppercase;" class="form-control input-sm" <?php if ((trim($lb->nikatasan1) != $nama and trim($lb->nikatasan2) != $nama) or trim($lb->status) == 'P') echo 'readonly' ?> ><?php echo $lb->suggestion; ?></textarea>
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
                            <?php if ((trim($lb->nikatasan1) == $nama or trim($lb->nikatasan2) == $nama) and trim($lb->status) != 'P') { ?> <button type="submit" class="btn btn-primary" >Save</button> <?php } ?>
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