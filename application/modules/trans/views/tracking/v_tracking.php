<script type="text/javascript">
    $(function() {
        $("#example1").dataTable({
            order: [],
            columnDefs: [{
                orderable: false,
                targets: [0]
            }]
        });
    });
</script>

<style>
    thead tr th {
        text-align: center;
        text-transform: uppercase;
        white-space: nowrap;
    }

    thead tr th:first-child,
    thead tr th:last-child {
        padding-right: 8px !important;
    }
</style>

<legend><?= $title . ($tglrange ? " ($tglrange)" : "") ?></legend>
<?= $message ?>

<div class="box">
    <div class="box-header">
        <div class="dropdown pull-left">
            <button class="btn btn-primary dropdown-toggle" style="margin: 0; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Filter &nbsp;<span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter" href="#"><i class="fa fa-filter"></i>Filter Pencarian</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= site_url('trans/tracking')?>"><i class="fa fa-refresh"></i>Reset Filter</a></li>
            </ul>
        </div>
    </div>
    <div class="box-body table-responsive">
        <table id="example1" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="1%">No</th>
                    <th>Dokumen</th>
                    <th>Nik</th>
                    <th>Terlapor</th>
                    <th width="8%">Tgl kejadian</th>
                    <th>Saksi 1</th>
                    <th>Saksi 2</th>
                    <th>Teguran</th>
                    <th width="8%">Tgl selesai</th>
                    <th>SP 1</th>
                    <th width="8%">Tgl selesai</th>
                    <th>SP 2</th>
                    <th width="8%">Tgl selesai</th>
                    <th>SP 3</th>
                    <th width="8%">Tgl selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list_tracking as $k => $v): ?>
                    <tr>
                        <td class="text-nowrap text-center"><?= ($k + 1) ?></td>
                        <td class="text-nowrap"><a target="_blank" href="<?= base_url('trans/sberitaacara/detail') . '/?enc_docno=' . $this->fiky_encryption->enkript(trim($v->docno)) ?>" title="Detail Berita Acara"><?= $v->docno ?></a></td>
                        <td class="text-nowrap"><?= $v->nik ?></td>
                        <td><?= $v->nmlengkap ?></td>
                        <td class="text-nowrap text-center"><?= $v->tgl_dok ?></td>
                        <td><?= $v->nmsaksi1 ?></td>
                        <td><?= $v->nmsaksi2 ?></td>
                        <td class="text-nowrap"><a target="_blank" href="<?= base_url('trans/skperingatan/detail') . '/?enc_docno=' . $this->fiky_encryption->enkript(trim($v->dokumen_tg)) ?>" title="Detail Surat Peringatan"><?= $v->dokumen_tg ?></a></td>
                        <td class="text-nowrap text-center"><?= $v->tgl_tg ?></td>
                        <td class="text-nowrap"><a target="_blank" href="<?= base_url('trans/skperingatan/detail') . '/?enc_docno=' . $this->fiky_encryption->enkript(trim($v->dokumen_sp)) ?>" title="Detail Surat Peringatan"><?= $v->dokumen_sp ?></a></td>
                        <td class="text-nowrap text-center"><?= $v->tgl_sp ?></td>
                        <td class="text-nowrap"><a target="_blank" href="<?= base_url('trans/skperingatan/detail') . '/?enc_docno=' . $this->fiky_encryption->enkript(trim($v->dokumen_sp2)) ?>" title="Detail Surat Peringatan"><?= $v->dokumen_sp2 ?></a></td>
                        <td class="text-nowrap text-center"><?= $v->tgl_sp2 ?></td>
                        <td class="text-nowrap"><a target="_blank" href="<?= base_url('trans/skperingatan/detail') . '/?enc_docno=' . $this->fiky_encryption->enkript(trim($v->dokumen_sp3)) ?>" title="Detail Surat Peringatan"><?= $v->dokumen_sp3 ?></a></td>
                        <td class="text-nowrap text-center"><?= $v->tgl_sp3 ?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Filter Tanggal Dokumen</h4>
            </div>
            <form method="post" id="form-filter" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Tanggal Dokumen</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-sm tglrange" id="tglrange" name="tglrange" value="<?= $tglrange ?>" data-date-format="dd-mm-yyyy" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" id="btn-reset" class="btn btn-warning">Reset</button>
                    <button type="submit" id="btn-filter" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="application/javascript">
    $(".tglrange").daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });
    $(".tglrange").on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
    });

    $(".tglrange").on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
</script>
