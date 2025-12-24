<legend><?php echo $title;?></legend>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <form action="<?= site_url('trans/absensi/excel_insentif_driver') ?>" method="post">
                    <a href="<?= site_url("trans/absensi/filter_detail") ?>" class="btn btn-default" style="margin: 5px;"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                    <input type="hidden" name="kdcabang" value="<?= $kdcabang ?>">
                    <input type="hidden" name="tgl_um" value="<?= $tgl_um_raw ?>">
                    <input type="hidden" name="tgl_kehadiran" value="<?= $tgl_kehadiran_raw ?>">
                    <input type="hidden" name="tgl_insentif" value="<?= $tgl_insentif_raw ?>">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> XLS</button>
                </form>
            </div><div class="box-body table-responsive">
                <table id="table-insentif" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: middle; text-align: center;">NIK</th>
                            <th rowspan="2" style="vertical-align: middle; text-align: center;">NAMA LENGKAP</th>
                            <th rowspan="2" style="vertical-align: middle; text-align: center;">JABATAN</th>
                            <th colspan="3" style="text-align: center;">INSENTIF</th>
                            <th colspan="2" style="text-align: center;">POTONGAN</th>
                            <th rowspan="2" style="vertical-align: middle; text-align: center;">TOTAL</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">UM <br> (<?= $tgl_um_raw ?>)</th>
                            <th style="text-align: center;">TUNJ. KEHADIRAN <br> (<?= $tgl_kehadiran_raw ?>)</th>
                            <th style="text-align: center;">INSENTIF <br> (<?= $tgl_insentif_raw ?>)</th>
                            <th style="text-align: center;">BPJS - K</th>
                            <th style="text-align: center;">BPJS - TK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grand_total_um = 0;
                        $grand_total_kehadiran = 0;
                        $grand_total_insentif = 0;
                        $grand_total_bpjs_k = 0;
                        $grand_total_bpjs_tk = 0;
                        $grand_total_final = 0;

                        foreach ($list_insentif as $row):
                            $grand_total_um += $row->um;
                            $grand_total_kehadiran += $row->tunj_kehadiran;
                            $grand_total_insentif += $row->insentif;
                            $grand_total_bpjs_k += $row->bpjs_k;
                            $grand_total_bpjs_tk += $row->bpjs_tk;
                            $grand_total_final += $row->total;
                        ?>
                        <tr>
                            <td><?php echo $row->nik; ?></td>
                            <td><?php echo $row->nmlengkap; ?></td>
                            <td><?php echo $row->nmjabatan; ?></td>
                            <td align="right"><?php echo number_format($row->um, 0, ',', '.'); ?></td>
                            <td align="right"><?php echo number_format($row->tunj_kehadiran, 0, ',', '.'); ?></td>
                            <td align="right"><?php echo number_format($row->insentif, 0, ',', '.'); ?></td>
                            <td align="right"><?php echo number_format($row->bpjs_k, 0, ',', '.'); ?></td>
                            <td align="right"><?php echo number_format($row->bpjs_tk, 0, ',', '.'); ?></td>
                            <td align="right"><?php echo number_format($row->total, 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #333; color: #fff; font-weight: bold;">
                            <td colspan="3" align="right">GRAND TOTAL</td>
                            <td align="right"><?php echo number_format($grand_total_um, 0, ',', '.'); ?></td>
                            <td align="right"><?php echo number_format($grand_total_kehadiran, 0, ',', '.'); ?></td>
                            <td align="right"><?php echo number_format($grand_total_insentif, 0, ',', '.'); ?></td>
                            <td align="right"><?php echo number_format($grand_total_bpjs_k, 0, ',', '.'); ?></td>
                            <td align="right"><?php echo number_format($grand_total_bpjs_tk, 0, ',', '.'); ?></td>
                            <td align="right"><?php echo number_format($grand_total_final, 0, ',', '.'); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#table-insentif').DataTable({
        "ordering": false,
        "pageLength": 25
    });
});
</script>