<script type="text/javascript">
    $(function() {
        $('#pilihkaryawan').selectize();

        $("#example1").dataTable({
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

<legend><?php echo $title;?></legend>
<?php echo $message;?>

<?php if(trim($akses['aksesview'] == 't')) { ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-sm-12">
                        <?php if(trim($akses['aksesinput'] == 't')) { ?>
                            <a href="<?php echo site_url("trans/lembur/karyawan"); ?>"  class="btn btn-success" style="margin: 10px;"><i class="fa fa-plus"></i>&nbsp; Input</a>
                        <?php } ?>
                        <a href="#" data-toggle="modal" data-target="#filter" class="btn btn-info" style="margin: 10px;"><i class="fa fa-search"></i>&nbsp; Filter</a>
                    </div>
                </div>
                <div class="box-body table-responsive" style='overflow-x: scroll;'>
                    <table id="example1" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th style="width: 1%;">No</th>
                                <th>Nomor Dokumen</th>
                                <th>NIK</th>
                                <th>Nama Karyawan</th>
                                <th>Nama Department</th>
                                <th>Tanggal Lembur</th>
                                <th>Durasi Lembur (Jam)</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th style="width: 5%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_lembur as $k => $lu): ?>
                                <tr>
                                    <td class="text-nowrap text-center"><?php echo ($k + 1); ?></td>
                                    <td class="text-nowrap"><?php echo $lu->nodok; ?></td>
                                    <td class="text-nowrap"><?php echo $lu->nik; ?></td>
                                    <td><?php echo $lu->nmlengkap; ?></td>
                                    <td><?php echo $lu->nmdept; ?></td>
                                    <td class="text-nowrap"><?php echo $lu->tgl_kerja1; ?></td>
                                    <td class="text-nowrap"><?php echo $lu->jam; ?></td>
                                    <td class="text-nowrap"><?php echo $lu->status1; ?></td>
                                    <td><?php echo $lu->keterangan; ?></td>
                                    <td class="text-nowrap">
                                        <a href="<?php $nodok = trim($lu->nodok); echo site_url("trans/lembur/detail/$nodok"); ?>" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i>&nbsp; Detail
                                        </a>
                                        <?php if(trim($lu->status) == "A" && (trim($lu->input_by) == trim($nama) || $userhr > 0 || $level_akses == "A")): ?>
                                            <?php if(trim($akses["aksesupdate"]) == "t"): ?>
                                                <a href="<?php $nodok = trim($lu->nodok); echo site_url("trans/lembur/edit/$nodok"); ?>"  class="btn btn-primary btn-sm">
                                                    <i class="fa fa-edit"></i>&nbsp; Edit
                                                </a>
                                            <?php endif; ?>
                                            <?php if(trim($akses["aksesdelete"]) == "t"): ?>
                                                <a href="<?php $nodok = trim($lu->nodok); echo site_url("trans/lembur/hps_lembur/$nodok"); ?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash-o"></i>&nbsp; Hapus
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    echo 'ANDA TIDAK DIPERKENANKAN MENGAKSES MODUL INI..!!';
} ?>


<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Periode Lembur</h4>
            </div>
	        <form action="<?php echo site_url('trans/lembur/index')?>" method="post">
                <div class="modal-body">
                    <div class="form-group input-sm ">
			            <label class="label-form col-sm-3">Periode</label>
			            <div class="col-sm-9">
                            <input type="input" name="periode" id="periode" class="form-control input-sm tglYM" value="<?php echo $periode; ?>">
			            </div>
		            </div>
		            <div class="form-group input-sm ">
			            <label class="label-form col-sm-3">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" id="status" name="status">
                                <option value="">SEMUA</option>
                                <option value="P">DISETUJUI</option>
                                <option value="A">PERLU PERSETUJUAN</option>
                                <option value="C">DIBATALKAN</option>
                                <option value="D">DIHAPUS</option>
                            </select>
                            <script type="text/javascript">
                                $('#status').selectize({
                                    plugins: ['hide-arrow'],
                                    options: [],
                                    create: false,
                                    initData: true
                                });
                                $("#status").addClass("selectize-hidden-accessible");
                                $('#status')[0].selectize.setValue("<?php echo trim($status); ?>");
                            </script>
                        </div>
		            </div>
                    <?php if($karyawan_filter): ?>
                        <div class="form-group input-sm ">
                            <label class="label-form col-sm-3">Karyawan</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" id="pilihkaryawan" name="nik">
                                    <option value="">--SEMUA KARYAWAN--</option>
                                    <?php foreach ($list_karyawan as $v) { ?>
                                        <?php $result = array_map('trim', (array)$v); ?>
                                        <option value="<?php echo $result['nik']; ?>" data-data='<?php echo json_encode($result, JSON_HEX_APOS); ?>'></option>
                                    <?php } ?>
                                </select>
                                <script type="text/javascript">
                                    $('#pilihkaryawan').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'nik',
                                        searchField: ['nik', 'nmlengkap'],
                                        options: [],
                                        create: false,
                                        initData: true,
                                        render: {
                                            option: function(item, escape) {
                                                return '' +
                                                    '<div class=\'row\'>' +
                                                        '<div class=\'col-md-3 text-nowrap\'>' + escape(item.nik) + '</div>' +
                                                        '<div class=\'col-md-9 text-nowrap\'>' + escape(item.nmlengkap) + '</div>' +
                                                    '</div>' +
                                                '';
                                            },
                                            item: function(item, escape) {
                                                return '' +
                                                    '<div>' +
                                                        escape(item.nik) + ' - ' +
                                                        escape(item.nmlengkap) +
                                                    '</div>'
                                                ;
                                            }
                                        }
                                    });
                                    $("#pilihkaryawan").addClass("selectize-hidden-accessible");
                                    $('#pilihkaryawan')[0].selectize.setValue("<?php echo trim($nik); ?>");
                                </script>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="reset" id="btn-reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
	        </form>
        </div>
    </div>
</div>

<script>
    $('.tglYM').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months"
    });
</script>
