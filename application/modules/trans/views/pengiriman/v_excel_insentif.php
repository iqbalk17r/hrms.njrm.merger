<?php
// FILE: views/trans/absensi/v_excel_insentif.php

// Set header untuk file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"Laporan Insentif Driver.xls\"");

echo '<table border="1">';
?>
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
    // Inisialisasi Grand Total
    $grand_total_um = 0;
    $grand_total_kehadiran = 0;
    $grand_total_insentif = 0;
    $grand_total_bpjs_k = 0;
    $grand_total_bpjs_tk = 0;
    $grand_total_final = 0;

    foreach ($list_insentif as $row):
        // Akumulasi Grand Total
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
    <tr style="font-weight: bold;">
        <td colspan="3" align="right">GRAND TOTAL</td>
        <td align="right"><?php echo number_format($grand_total_um, 0, ',', '.'); ?></td>
        <td align="right"><?php echo number_format($grand_total_kehadiran, 0, ',', '.'); ?></td>
        <td align="right"><?php echo number_format($grand_total_insentif, 0, ',', '.'); ?></td>
        <td align="right"><?php echo number_format($grand_total_bpjs_k, 0, ',', '.'); ?></td>
        <td align="right"><?php echo number_format($grand_total_bpjs_tk, 0, ',', '.'); ?></td>
        <td align="right"><?php echo number_format($grand_total_final, 0, ',', '.'); ?></td>
    </tr>
</tfoot>
<?php
echo '</table>';
?>