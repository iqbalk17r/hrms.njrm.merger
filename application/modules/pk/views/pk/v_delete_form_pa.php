<script type="text/javascript">
    $(function () {

        $('#example1').dataTable({
            "paging": true,
            "pageLength": 3,
            "lengthMenu": [[3, 6, 9, -1], [3, 6, 9, "Semua"]],
            "searching": false,
            "ordering": false,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ daftar penilaian",
            }
        });
        // $("#datatableMaster").dataTable();

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

    .grey-label {
        color: grey;
    }
</style>
<legend><?php echo $title; ?></legend>

<?php echo $message; ?>

<div class="row">
    <div class="col-sm-9">
        <a href="<?php echo site_url("pk/pk/form_pk") ?>" class="btn btn-default"
            style="margin:10px; color:#000000;">Kembali</a>
    </div>
    <div class="col-sm pull-right">
        <a href="<?php
        $enc_nik = bin2hex($this->encrypt->encode(trim($dtlrow['nik'])));
        $enc_periode = bin2hex($this->encrypt->encode(trim($dtlrow['periode'])));
        echo site_url("pk/pk/delete_input_pa") . '/' . $enc_nik . '/' . $enc_periode; ?>" class="btn btn-danger"
            onclick="return confirm('Apakah Anda Menghapus Data Ini??')" style="margin:10px; color:#ffffff;"> Hapus </a>
    </div>


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
                        <table id="datatableMaster" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="2%">No.</th>
                                    <th>NODOK</th>
                                    <th>NIK</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>NAMA ATASAN1</th>
                                    <th>FS</th>
                                    <th>FS KTG</th>
                                    <th>FS DESC</th>
                                    <th>PERIODE</th>
                                    <th>STATUS</th>
                                    <!-- <th width="8%">AKSI</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                foreach ($list_trx_pa_mst as $row):
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
                                        <!-- <td width="8%">
                                            <a href="#" data-toggle="modal" data-target="#DTLMST<?php echo str_replace('/', '', trim($row->nodok)) . str_replace('.', '', trim($row->nik)) . str_replace('.', '', trim($row->periode)); ?>" class="btn btn-default  btn-sm" title="Detail Master PA"><i class="fa fa-bars"></i></a>
                                        </td> -->
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
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="2%">No.</th>
                                    <th width="25%">DESKRIPSI</th>
                                    <?php if ($cek_option_pa == 0 or trim($dtlrow['nikatasan1']) == $nama) { ?>
                                        <th>PENILAIAN ATASAN</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                foreach ($list_trx_pa_dtl as $row):
                                    $no++; ?>
                                    <tr>
                                        <td width="2%"><?php echo $no; ?></td>
                                        <td width="25%">
                                            <h6><strong><?php echo strtoupper($row->description); ?></strong></h6>
                                            <p><?php echo strtoupper($row->fulldescription); ?></p>
                                        </td>
                                        <?php if ($cek_option_pa == 0 or trim($dtlrow['nikatasan1']) == $nama) { ?>
                                            <td>
                                                <?php foreach ($list_question as $lq) {
                                                    if ($lq->kdkriteria == $row->kdkriteria) { ?>
                                                        <div class="form-check">
                                                            <div class="col-sm-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="value<?= trim($row->kdkriteria) ?>" value="<?= $lq->point ?>"
                                                                    <?= trim($row->value1) == $lq->point ? 'checked' : 'disabled' ?>>
                                                            </div>
                                                            <div class="col-sm-11">
                                                                <label
                                                                    class="form-check-label <?= trim($row->value1) == $lq->point ? '' : 'grey-label' ?>">
                                                                    <?= $lq->description ?>
                                                                </label>
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
                                        <textarea name="note" id="note" style="width: 100%; resize: none;"
                                            class="form-control" disabled><?php echo $dtlrow['note']; ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="2%"><?php echo $no + 2; ?></td>
                                    <td width="25%">
                                        <h6><strong>SARAN UNTUK KARYAWAN</strong></h6>
                                    </td>
                                    <td>
                                        <textarea name="suggestion" id="suggestion" style="width: 100%; resize: none;"
                                            class="form-control"
                                            disabled><?php echo $dtlrow['suggestion']; ?></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
</div><!--/ nav -->

<?php foreach ($list_trx_pa_mst as $lb) { ?>
    <div class="modal fade"
        id="DTLMST<?php echo str_replace('/', '', trim($lb->nodok)) . str_replace('.', '', trim($lb->nik)) . str_replace('.', '', trim($lb->periode)); ?>"
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
                                                    <input type="input" name="description" id="description"
                                                        value="<?php echo strtoupper($lb->description); ?> "
                                                        class="form-control input-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <!--?php// if (trim($lb->nikatasan1)==$nama) { ?--->
                                            <label class="col-sm-3" for="inputsm">NILAI 1 (Atasan 1)</label>
                                            <div class="col-sm-3">
                                                <input type="number" name="ttlvalue1" id="ttlvalue1"
                                                    value="<?php echo trim(round($lb->ttlvalue1)); ?>"
                                                    style="text-align: right" class="form-control input-sm" min="1"
                                                    max="5" readonly />
                                            </div>
                                            <!--?php ///} if (trim($lb->nikatasan2)==$nama) { ?--->
                                            <label class="col-sm-3" for="inputsm">NILAI 2 (Atasan 2)</label>
                                            <div class="col-sm-3">
                                                <input type="number" name="ttlvalue2" id="ttlvalue2"
                                                    value="<?php echo trim(round($lb->ttlvalue2)); ?>"
                                                    style="text-align: right" class="form-control input-sm" min="1"
                                                    max="5" readonly />
                                            </div>
                                            <!--?php ///} ?--->
                                        </div>
                                        <div class="form-group ">
                                            <!--?php// if (trim($lb->nikatasan1)==$nama) { ?--->
                                            <label class="col-sm-3" for="inputsm">FINAL SCORE</label>
                                            <div class="col-sm-3">
                                                <input type="number" name="f_value" id="f_value"
                                                    value="<?php echo trim(round($lb->f_value)); ?>"
                                                    style="text-align: right" class="form-control input-sm" readonly />
                                            </div>
                                            <!--?php// } if (trim($lb->nikatasan2)==$nama) { ?-->
                                                <label class="col-sm-3" for="inputsm">NILAI KATEGORI FS</label>
                                                <div class="col-sm-3">
                                                    <input type="number" name="f_value_ktg" id="f_value_ktg"
                                                        value="<?php echo trim(round($lb->f_value_ktg)); ?>"
                                                        style="text-align: right" class="form-control input-sm" readonly />
                                                </div>
                                                <!--?php// } ?--->
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


<?php foreach ($list_trx_pa_dtl as $lb) { ?>
<div class="modal fade"
    id="EDDTL<?php echo str_replace('/', '', trim($lb->nodok)) . str_replace('.', '', trim($lb->nik)) . str_replace('.', '', trim($lb->periode)) . trim($lb->nomor); ?>"
    tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> DETAIL NILAI DARI KATEGORI ASPEK</h4>
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
                                                <input type="hidden" name="nikatasan2" id="nikatasan2"
                                                    value="<?php echo trim($lb->nikatasan2); ?>"
                                                    class="form-control input-sm" readonly>
                                                <input type="hidden" name="type" id="type" value="EDITDTLPA"
                                                    class="form-control input-sm" readonly>

                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">DESKIRPSI KATEGORI</label>
                                            <div class="col-sm-12">
                                                <input type="input" name="description" id="description"
                                                    value="<?php echo strtoupper($lb->description); ?> "
                                                    class="form-control input-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <!--?php// if (trim($lb->nikatasan1)==$nama) { ?--->
                                            <label class="col-sm-3" for="inputsm">NILAI 1 (Atasan 1)</label>
                                            <div class="col-sm-3">
                                                <input type="number" name="value1" id="value1"
                                                    value="<?php echo trim(round($lb->value1)); ?>"
                                                    style="text-align: right" class="form-control input-sm" min="1"
                                                    max="5" readonly />
                                            </div>
                                            <!--?php// } if (trim($lb->nikatasan2)==$nama) { ?-->
                                                <label class="col-sm-3" for="inputsm">NILAI 2 (Atasan 2)</label>
                                                <div class="col-sm-3">
                                                    <input type="number" name="value2" id="value2"
                                                        value="<?php echo trim(round($lb->value2)); ?>"
                                                        style="text-align: right" class="form-control input-sm" min="1"
                                                        max="5" readonly />
                                                </div>
                                                <!--?php// } ?--->
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