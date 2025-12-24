<script type="text/javascript">
    $(function() {
        $("#tberitaacara").dataTable({
            order: [],
            columnDefs: [{
                orderable: false,
                targets: [0, 9]
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
            <button class="btn btn-primary dropdown-toggle" style="margin: 0; color: #ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input &nbsp;<span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= site_url('trans/sberitaacara/input')?>"><i class="fa fa-plus"></i>Input</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter" href="#"><i class="fa fa-filter"></i>Filter Pencarian</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= site_url('trans/sberitaacara')?>"><i class="fa fa-refresh"></i>Reset Filter</a></li>
            </ul>
        </div>
    </div>
    <div class="box-body table-responsive">
        <table id="tberitaacara" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="1%">No</th>
                    <th width="8%">Dokumen</th>
                    <th width="5%">Nik</th>
                    <th>Nama</th>
                    <th width="8%">Tgl Dok</th>
                    <th>Laporan</th>
                    <th>Tindakan</th>
                    <th width="8%">Tgl Input</th>
                    <th width="5%">Status</th>
                    <th width="5%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listtrx as $k => $v): ?>
                    <?php $enc_docno = $this->fiky_encryption->enkript(trim($v->docno)); ?>
                    <tr>
                        <td class="text-nowrap text-center"><?= ($k + 1) ?></td>
                        <td class="text-nowrap"><?= trim($v->docno) ?></td>
                        <td class="text-nowrap"><?= trim($v->nik) ?></td>
                        <td><?= trim($v->nmlengkap) ?></td>
                        <td class="text-nowrap text-center"><?= date("d-m-Y", strtotime(trim($v->docdate))) ?></td>
                        <td class="text-nowrap text-center"><?= trim($v->nmlaporan) ?></td>
                        <td class="text-nowrap text-center"><?= trim($v->nmtindakan) ?></td>
                        <td class="text-nowrap text-center"><?= date("d-m-Y", strtotime(trim($v->inputdate))) ?></td>
                        <td class="text-nowrap text-center"><?= trim($v->nmstatus) ?></td>
                        <td class="text-nowrap">
                            <a class="btn btn-sm btn-default" href="<?= base_url('trans/sberitaacara/detail') . '/?enc_docno=' . $enc_docno ?>" title="Detail Berita Acara"><i class="fa fa-bars"></i></a>
                            <?php if(trim($v->inputby) == $nik && (trim($v->saksi) == "f" ? trim($v->status) == "A" : trim($v->status) == "S1")): ?>
                                <a class="btn btn-sm btn-primary" href="<?= base_url('trans/sberitaacara/edit') . '/?enc_docno=' . $enc_docno ?>" title="Edit Berita Acara"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?>
                            <?php if(trim($v->status) == "S1" && trim($v->saksi1) == $nik): ?>
                                <a class="btn btn-sm btn-success" href="<?= base_url('trans/sberitaacara/saksi1') . '/?enc_docno=' . $enc_docno ?>" title="Approval Berita Acara"><i class="fa fa-check"></i></a>
                            <?php elseif(trim($v->status) == "S2" && trim($v->saksi2) == $nik): ?>
                                <a class="btn btn-sm btn-success" href="<?= base_url('trans/sberitaacara/saksi2') . '/?enc_docno=' . $enc_docno ?>" title="Approval Berita Acara"><i class="fa fa-check"></i></a>
                            <?php elseif(trim($v->status) == "A1" && ((trim($v->nikatasan1) == $nik) || ($superuser > 0))): ?>
                                <a class="btn btn-sm btn-success" href="<?= base_url('trans/sberitaacara/atasan') . '/?enc_docno=' . $enc_docno ?>" title="Approval Berita Acara"><i class="fa fa-check"></i></a>
                             <?php elseif(trim($v->status) == "A2" && ((trim($v->nikatasan2) == $nik) || ($superuser > 0))): ?>
                                <a class="btn btn-sm btn-success" href="<?= base_url('trans/sberitaacara/atasan2') . '/?enc_docno=' . $enc_docno ?>" title="Approval Berita Acara"><i class="fa fa-check"></i></a>
                            <?php elseif(trim($v->status) == "B" && ($userhr == $nik)): ?>
                                <a class="btn btn-sm btn-success" href="<?= base_url('trans/sberitaacara/hrd') . '/?enc_docno=' . $enc_docno ?>" title="Approval Berita Acara"><i class="fa fa-check"></i></a>
                            <?php elseif(trim($v->status) == "P"): ?>
                                <a class="btn btn-sm btn-warning" target="_blank" href="<?= base_url('trans/sberitaacara/cetak') . '/?enc_docno=' . $enc_docno ?>" title="Cetak Berita Acara"><i class="fa fa-print"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
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
