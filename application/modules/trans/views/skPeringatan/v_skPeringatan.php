<script type="text/javascript">
    $(function() {
        $("#table").dataTable({
            order: [],
            columnDefs: [{
                orderable: false,
                targets: [0, 10]
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
            <button class="btn btn-primary dropdown-toggle" style="margin: 0; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input &nbsp;<span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= site_url('trans/skperingatan/input')?>"><i class="fa fa-plus"></i>Input</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter" href="#"><i class="fa fa-filter"></i>Filter Pencarian</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= site_url('trans/skperingatan')?>"><i class="fa fa-refresh"></i>Reset Filter</a></li>
            </ul>
        </div>
    </div>
    <div class="box-body table-responsive">
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="1%">No</th>
                    <th width="8%">Dokumen</th>
                    <th width="5%">Nik</th>
                    <th>Nama</th>
                    <th width="8%">Tgl Dok</th>
                    <th>Referensi</th>
                    <th>Kategori Peringatan</th>
                    <th width="8%">Tgl Awal</th>
                    <th width="8%">Tgl Akhir</th>
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
                        <td class="text-nowrap text-center"><?= trim($v->docref) ?></td>
                        <td class="text-nowrap text-center"><?= trim($v->spname) ?></td>
                        <td class="text-nowrap text-center"><?= date("d-m-Y", strtotime(trim($v->startdate))) ?></td>
                        <td class="text-nowrap text-center"><?= date("d-m-Y", strtotime(trim($v->enddate))) ?></td>
                        <td class="text-nowrap text-center"><?= trim($v->nmstatus) ?></td>
                        <td class="text-nowrap">
                            <a class="btn btn-sm btn-default" href="<?= base_url('trans/skperingatan/detail') . '/?enc_docno=' . $enc_docno ?>" title="Detail Surat Peringatan"><i class="fa fa-bars"></i></a>
                            <?php if(trim($v->inputby) == $nik && trim($v->status) == "A"): ?>
                                <a class="btn btn-sm btn-primary" href="<?= base_url('trans/skperingatan/edit') . '/?enc_docno=' . $enc_docno ?>" title="Edit Surat Peringatan"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?>
                            <?php if(trim($v->status) == "A" && ((trim($v->nikatasan1) == $nik) || ($nik == '3100680'))): ?>
                                <a class="btn btn-sm btn-success" href="<?= base_url('trans/skperingatan/atasan') . '/?enc_docno=' . $enc_docno ?>" title="Approval Surat Peringatan"><i class="fa fa-check"></i></a>
                            <?php endif; ?>
                            <?php if($nik == $nikhr && trim($v->status) == "B"): ?>
                                <a class="btn btn-sm btn-success" href="<?= base_url('trans/skperingatan/hrd') . '/?enc_docno=' . $enc_docno ?>" title="Approval HR Surat Peringatan"><i class="fa fa-check"></i></a>
                            <?php elseif(trim($v->status) == "P"): ?>
                                <a class="btn btn-sm btn-warning" target="_blank" href="<?= base_url('trans/skperingatan/cetak') . '/?enc_docno=' . $enc_docno ?>" title="Cetak Surat Peringatan"><i class="fa fa-print"></i></a>
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
