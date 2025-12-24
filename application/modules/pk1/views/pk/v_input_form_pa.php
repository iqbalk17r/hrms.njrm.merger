<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(document).ready(function () {
        // $("#datatableMaster").dataTable();

        var table = $('#evaluation').dataTable({
            "paging": true,
            "pageLength": 3,
            "lengthMenu": [[3, 6, 9, -1], [3, 6, 9, "Semua"]],
            "searching": false,
            "ordering": false,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ daftar pertanyaan",
            }
        });

        $('#submit').on('click', function (event) {
            event.preventDefault();
            var radioValues = [];

            table.$('input[type="radio"]').each(function () {
                if ($(this).prop('checked')) {
                    radioValues.push($(this).val());
                }
            });
            var formData = table.$('input,textarea').not(':radio').serializeArray();
            formData.push({ name: 'value1', value: JSON.stringify(radioValues) });
            formData.push({ name: 'nikatasan1', value: $('#ajaxForm #nikatasan1').val() });
            formData.push({ name: 'type', value: $('#ajaxForm #type').val() });

            $.ajax({
                url: "<?php echo site_url('pk/pk/save_pa') ?>",
                type: "POST",
                data: formData,
                success: function (response) {
                    Swal.fire({
                        title: JSON.parse(response).type,
                        text: JSON.parse(response).message,
                        icon: JSON.parse(response).type,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed && JSON.parse(response).type != 'error') {
                            location.reload();
                        }
                    });
                },
            });
        });

        $('#saveFinal').on('click', function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'Save Final',
                text: 'Anda yakin akan melakukan save final?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "Simpan",
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo site_url('pk/pk/final_input_pa') ?>",
                        type: "GET",
                        success: function (response) {
                            Swal.fire({
                                title: JSON.parse(response).type,
                                text: JSON.parse(response).message,
                                icon: JSON.parse(response).type,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed && JSON.parse(response).type != 'error') {
                                    location.reload();
                                }
                            });
                        },
                    });
                }
            });
        });

        $("#example3").dataTable();
        $("#example4").dataTable();
        $(".inputfill").selectize();
        $('.tglYM').datepicker({
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"
        });

        $('form').on('focus', 'input[type=number]', function (e) {
            $(this).on('mousewheel.disableScroll', function (e) {
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
<legend><?php echo $title; ?></legend>

<?php echo $message; ?>

<div class="row">
    <div class="col-sm-9">
        <a href="<?php echo site_url("pk/pk/clear_input_pa") ?>" class="btn btn-default"
            onclick="return confirm('Kembali Akan Mereset Inputan Yang Anda Buat, Apakah Anda Yakin....???')"
            style="margin:10px; color:#000000;">Kembali</a>
    </div>
    <div class="col-sm pull-right">
        <a class="btn btn-primary" id="saveFinal" style="margin:10px; color:#ffffff;"><i class="fa fa-save"></i> SIMPAN
        </a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <h5 class="text-center">SUMMARY KONDITE</h5>
            </div>
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
                            <th class="tg-031e" rowspan="2">TOTAL SCORE</th>
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
                        foreach ($list_report_kondite as $row):
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
                                <td>
                                    <?php echo $row->total_score; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>

    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <h5 class="text-center">SUMMARY KPI</h5>
            </div>
            <div class="box-body table-responsive" style='overflow-x:scroll;'>
                <table id="example1" class="table table-bordered table-striped tg">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NIK</th>
                            <th>NAMA LENGKAP</th>
                            <th>BAGIAN</th>
                            <th>JABATAN</th>
                            <th>TAHUN</th>
                            <th class="tg-yp2e">JANUARI</th>
                            <th class="tg-yp2e">FEBRUARI</th>
                            <th class="tg-yp2e">MARET</th>
                            <th class="tg-yp2e">APRIL</th>
                            <th class="tg-yp2e">MEI</th>
                            <th class="tg-yp2e">JUNI</th>
                            <th class="tg-yp2e">JULI</th>
                            <th class="tg-yp2e">AGUSTUS</th>
                            <th class="tg-yp2e">SEPTEMBER</th>
                            <th class="tg-yp2e">OKTOBER</th>
                            <th class="tg-yp2e">NOVEMBER</th>
                            <th class="tg-yp2e">DESEMBER</th>
                            <th class="tg-lkh3">RATA-RATA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0;
                        foreach ($list_report_kpi as $row):
                            $no++; ?>
                            <tr>
                                <td width="2%"><?php echo $no; ?></td>
                                <td><?php echo $row->nik; ?></td>
                                <td><?php echo $row->nmlengkap; ?></td>
                                <td><?php echo $row->nmsubdept; ?></td>
                                <td><?php echo $row->nmjabatan; ?></td>
                                <td><?php echo $row->tahun; ?></td>
                                <td><?php echo $row->januari; ?></td>
                                <td><?php echo $row->februari; ?></td>
                                <td><?php echo $row->maret; ?></td>
                                <td><?php echo $row->april; ?></td>
                                <td><?php echo $row->mei; ?></td>
                                <td><?php echo $row->juni; ?></td>
                                <td><?php echo $row->juli; ?></td>
                                <td><?php echo $row->agustus; ?></td>
                                <td><?php echo $row->september; ?></td>
                                <td><?php echo $row->oktober; ?></td>
                                <td><?php echo $row->november; ?></td>
                                <td><?php echo $row->desember; ?></td>
                                <td><?php echo $row->average; ?></td>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>

    <div class="col-sm-12">
        <div class="box">
            <div class="box-body table-responsive" style='overflow-x:scroll;'>
                <table id="datatableMaster" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="2%">No.</th>
                            <th>NODOK</th>
                            <th>NIK</th>
                            <th>NAMA LENGKAP</th>
                            <th>NAMA ATASAN</th>
                            <th>FS</th>
                            <th>FS KTG</th>
                            <th>FS DESC</th>
                            <th>PERIODE</th>
                            <th>STATUS</th>
                            <th width="8%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0;
                        foreach ($list_tmp_pa_mst as $row):
                            $no++; ?>
                            <tr>
                                <td width="2%"><?php echo $no; ?></td>
                                <td><?php echo $row->nodok; ?></td>
                                <td><?php echo $row->nik; ?></td>
                                <td><?php echo $row->nmlengkap; ?></td>
                                <td><?php echo $row->nmatasan1; ?></td>
                                <td align='right'><?php echo $row->f_value_ktg; ?></td>
                                <td><?php echo $row->f_kdvalue_ktg; ?></td>
                                <td><?php echo $row->f_desc_ktg; ?></td>
                                <td><?php echo $row->periode; ?></td>
                                <td><?php echo $row->nmstatus; ?></td>

                                <td width="8%">
                                    <a href="#" data-toggle="modal"
                                        data-target="#DTLMST<?php echo str_replace('.', '', trim($row->nodok)) . str_replace('.', '', trim($row->nik)) . str_replace('.', '', trim($row->periode)); ?>"
                                        class="btn btn-default  btn-sm" title="Detail Master PA"><i
                                            class="fa fa-bars"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>

    <div class="col-sm-12">
        <form id="ajaxForm">
            <input type="hidden" name="nikatasan1" id="nikatasan1" value="<?php echo trim($dtlrow['nikatasan1']); ?>"
                class="form-control input-sm" readonly>
            <input type="hidden" name="type" id="type" value="INPUTDTLPA" class="form-control input-sm">
            <div class="box">
                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                    <table id="evaluation" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="2%">No.</th>
                                <th width="25%" class="text-center">DESKRIPSI</th>
                                <?php if ($cek_option_pa == 0 or trim($dtlrow['nikatasan1']) == $nama) { ?>
                                    <th class="text-center">PENILAIAN ATASAN</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                            foreach ($list_tmp_pa_dtl as $row):
                                $no++; ?>
                                <tr>
                                    <input type="hidden" name="nodok" id="nodok" value="<?php echo trim($row->nodok); ?>"
                                        style="text-align: right" class="form-control input-sm-1">
                                    <input type="hidden" name="periode" id="periode"
                                        value="<?php echo trim($row->periode); ?>" style="text-align: right"
                                        class="form-control input-sm-1">
                                    <input type="hidden" name="kdkriteria[]" id="kdkriteria[]"
                                        value="<?php echo trim($row->kdkriteria); ?>" style="text-align: right"
                                        class="form-control input-sm-1">
                                    <input type="hidden" name="nik" id="nik" value="<?php echo trim($row->nik); ?>"
                                        style="text-align: right" class="form-control input-sm-1">
                                    <td width="2%"><?php echo $no; ?></td>
                                    <td width="25%">
                                        <h6><strong><?php echo strtoupper($row->description); ?></strong></h6>
                                        <p class="capitalize-first"><?php echo $row->fulldescription; ?></p>
                                    </td>
                                    <!-- <input type="number" name="value1[]" id="value1[]"
                                                value="<?php //echo strtoupper(trim($row->value1)); ?>" style="text-align: right"
                                                class="form-control input-sm-1" max="5"> -->
                                    <?php if ($cek_option_pa == 0 or trim($dtlrow['nikatasan1']) == $nama) { ?>
                                        <td>
                                            <?php foreach ($list_question as $lq) {
                                                if ($lq->kdkriteria == $row->kdkriteria) { ?>
                                                    <div class="form-check">
                                                        <div class="col-sm-1">
                                                            <input class="form-check-input" type="radio"
                                                                name="value<?= trim($row->kdkriteria) ?>" value="<?= $lq->point ?>"
                                                                <?= trim($row->value1) == $lq->point ? 'checked' : '' ?> required>
                                                        </div>
                                                        <div class="col-sm-11">
                                                            <p class="capitalize-first">
                                                                <?= $lq->description ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                <?php }
                                            } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td width="2%"><?php echo $no + 1; ?></td>
                                <td width="25%">
                                    <h6><strong>CATATAN UNTUK KARYAWAN</strong></h6>
                                </td>
                                <td>
                                    <textarea name="note" id="note"
                                        style="width: 100%; resize: none;"
                                        class="form-control"><?php echo $dtlrow['note']; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td width="2%"><?php echo $no + 2; ?></td>
                                <td width="25%">
                                    <h6><strong>SARAN UNTUK KARYAWAN</strong></h6>
                                </td>
                                <td>
                                    <textarea name="suggestion" id="suggestion"
                                        style="width: 100%; resize: none;"
                                        class="form-control"><?php echo $dtlrow['suggestion']; ?></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            <button type="submit" id="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-gear"></i> SAVE
                ALL DETAIL</button>
        </form>
    </div>
</div>
<!--/ nav -->

<?php foreach ($list_tmp_pa_mst as $lb) { ?>
    <div class="modal fade"
        id="DTLMST<?php echo str_replace('.', '', trim($lb->nodok)) . str_replace('.', '', trim($lb->nik)) . str_replace('.', '', trim($lb->periode)); ?>"
        tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel"> DETAIL MASTER DARI KATEGORI ASPEK</h4>
                </div>
                <form action="<?php echo site_url('pk/pk/save_pa') ?>" method="post" name="Form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box box-danger">
                                    <div class="box-body">
                                        <div class="form-horizontal">
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">NAMA KARYAWAN</label>
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
                                                    <input type="hidden" name="nikatasan1" id="nikatasan1"
                                                        value="<?php echo trim($lb->nikatasan1); ?>"
                                                        class="form-control input-sm" readonly>
                                                    <input type="hidden" name="nikatasan2" id="nikatasan2"
                                                        value="<?php echo trim($lb->nikatasan2); ?>"
                                                        class="form-control input-sm" readonly>
                                                    <input type="hidden" name="type" id="type" value="DETAILPA"
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
                                                <label class="col-sm-4" for="inputsm">NAMA ATASAN</label>
                                                <div class="col-sm-8">
                                                    <input type="input" name="nmatasan1" id="nmatasan1"
                                                        value="<?php echo trim($lb->nmatasan1); ?> "
                                                        class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">DESKIRPSI KATEGORI</label>
                                                <div class="col-sm-8">
                                                    <input type="input" name="description" id="description"
                                                        value="<?php echo trim($lb->description); ?> "
                                                        class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <?php if (trim($lb->nikatasan1) == $nama) { ?>
                                                    <label class="col-sm-4" for="inputsm">NILAI</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" name="ttlvalue1" id="ttlvalue1"
                                                            value="<?php echo trim(round($lb->ttlvalue1)); ?>"
                                                            class="form-control input-sm" min="1" max="5" readonly />
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <!--button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button--->
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>


<?php foreach ($list_tmp_pa_dtl as $lb) { ?>
<div class="modal fade"
    id="EDDTL<?php echo str_replace('.', '', trim($lb->nodok)) . str_replace('.', '', trim($lb->nik)) . str_replace('.', '', trim($lb->periode)) . trim($lb->nomor); ?>"
    tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> UBAH NILAI DARI KATEGORI ASPEK</h4>
            </div>
            <form action="<?php echo site_url('pk/pk/save_pa') ?>" method="post" name="Form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">KODE KRITERIA</label>
                                            <div class="col-sm-12">
                                                <input type="hidden" name="kdaspek" id="kdaspek"
                                                    value="<?php echo trim($lb->kdaspek); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="input" name="kdkriteria" id="kdkriteria"
                                                    value="<?php echo trim($lb->kdkriteria); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="nik" id="nik"
                                                    value="<?php echo trim($lb->nik); ?>" class="form-control input-sm"
                                                    readonly>
                                                <input type="hidden" name="nodok" id="nodok"
                                                    value="<?php echo trim($lb->periode); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="periode" id="periode"
                                                    value="<?php echo trim($lb->periode); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="nikatasan1" id="nikatasan1"
                                                    value="<?php echo trim($lb->nikatasan1); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="type" id="type" value="INPUTDTLPA"
                                                    class="form-control input-sm" readonly>

                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">DESKIRPSI KATEGORI</label>
                                            <div class="col-sm-12">
                                                <input type="input" name="description" id="description"
                                                    value="<?php echo trim($lb->description); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <?php if (trim($lb->nikatasan1) == $nama) { ?>
                                            <label class="col-sm-4" for="inputsm">NILAI</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="value1" id="value1"
                                                    value="<?php echo trim(round($lb->value1)); ?>"
                                                    class="form-control input-sm" min="1" max="5" />
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
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
    function capitalizeFirstWord(element) {
        const text = element.innerText;
        element.innerText = text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
    }

    const elements = document.querySelectorAll(".capitalize-first");
    elements.forEach(capitalizeFirstWord);
</script>