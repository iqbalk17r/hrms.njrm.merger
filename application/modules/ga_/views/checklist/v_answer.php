<script type="text/javascript">
    $(function() {
        var t = $("#table-list").DataTable({
            ordering: false,
            paging: false,
            searching: false
        });
    });
</script>

<style>
    thead tr th {
        text-align: center;
        text-transform: uppercase;
        white-space: nowrap;
        padding-right: 8px !important;
    }
</style>

<legend><?= $title ?></legend>
<?= $message ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <legend><?= $checklist->nama_lokasi ?> (<?= date("d-m-Y H:i:s", strtotime($list_hasil[0]->tanggal_mulai)) ?> s/d <?= date("d-m-Y H:i:s", strtotime($list_hasil[0]->tanggal_selesai)) ?>)</legend>
            </div>
            <form action="<?= site_url('ga/checklist/answeradd') ?>" id="formChecklist" name="form" role="form" method="post">
                <input type="hidden" name="id_checklist" value="<?= $checklist->id_checklist ?>">
                <div class="box-body">
                    <table id="table-list" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th style="width: 1%;">No</th>
                                <th>Parameter</th>
                                <th>Target</th>
                                <th style="width: 1%;">Ya / Tidak</th>
                                <th style="width: 15%;">Realisasi</th>
                                <th style="width: 20%;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_hasil as $k => $v): ?>
                                <?php $row = array_map("trim", (array)$v); ?>
                                <tr>
                                    <td class="text-nowrap text-center autonum-posint" style="vertical-align: middle"><?= ($k + 1) ?></td>
                                    <td class="text-nowrap text-left" style="vertical-align: middle"><?= $v->nama_parameter ?></td>
                                    <td class="text-nowrap text-left" style="vertical-align: middle"><?= $v->target_parameter ?></td>
                                    <td class="text-nowrap text-center" style="vertical-align: middle">
                                        <input type="checkbox" name="hasil[]" value="<?= $v->kode_parameter ?>">
                                    </td>
                                    <td class="text-nowrap text-center" style="vertical-align: middle">
                                        <input type="text" class="form-control input-sm" maxlength="30" style="width: 100%; text-transform: uppercase;" name="realisasi[]">
                                    </td>
                                    <td class="text-nowrap text-center" style="vertical-align: middle">
                                        <input type="text" class="form-control input-sm" style="width: 100%; text-transform: uppercase;" name="keterangan[]">
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right" onclick="return confirm('Apakah Anda Yakin ?')" style="margin: 10px;"><i class="fa fa-save"></i>&nbsp; Simpan Hasil</button>
                    <a class="btn btn-default pull-right" href="<?= site_url('ga/checklist/realisasi') ?>" style="margin: 10px;"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
