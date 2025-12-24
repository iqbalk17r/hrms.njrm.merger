<style>
    .form-control {
        display: block;
        width: 100%;
        height: 20px;
        padding: 6px 12px;
        font-size: 8px;
        line-height: 1.428571429;
        color: #555555;
        vertical-align: middle;
        background-color: #ffffff;
        background-image: none;
        border: 1px solid #cccccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
        transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    }
    table {
        width:100%;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size:10px;
    }
    th, td {
        padding: 5px;
        text-align: left;
    }
    .row {
        margin-right: -15px;
        margin-left: -15px;
    }

    .row:before,
    .row:after {
        display: table;
        content: " ";
    }

    .row:after {
        clear: both;
    }

    .row:before,
    .row:after {
        display: table;
        content: " ";
    }

    .row:after {
        clear: both;
    }
</style>

<!---p><strong> Laporan Uang Makan Wilayah <?php echo $cabang;?> </strong></p></br>Periode: <!?php echo $tgl1.' hingga '.$tgl2;?-->
<p><img src="http://www.nusaboard.co.id/wp-content/uploads/2015/02/newlogo-nusaboard.jpg" width="200" height="45" /><strong> Laporan Uang Makan Wilayah <?php echo $cabang;?> </strong></p></br>Periode: <?php echo $tgl1.' hingga '.$tgl2;?>
</br>
<div class="row">
    <table >
        <thead>
        <tr>
            <th bgcolor="#CCCCCC"><div align="center">No</div></th>
            <th bgcolor="#CCCCCC"><div align="center">Nama</div></th>
            <th bgcolor="#CCCCCC"><div align="center">Departement</div></th>
            <th bgcolor="#CCCCCC"><div align="center">Tanggal</div></th>
            <th bgcolor="#CCCCCC"><div align="center">Checktime</div></th>
            <?php if($callplan == "t"): ?>
                <th bgcolor="#CCCCCC"><div align="center">Callplan</div></th>
                <th bgcolor="#CCCCCC"><div align="center">Realisasi</div></th>
            <?php endif; ?>
            <th bgcolor="#CCCCCC"><div align="center">Status</div></th>
            <th bgcolor="#CCCCCC"><div align="center">Keterangan</div></th>
            <th bgcolor="#CCCCCC"><div align="center">Uang Makan</div></th>
            <?php if($callplan == "t"): ?>
            <th bgcolor="#CCCCCC"><div align="center">BBM</div></th>
            <th bgcolor="#CCCCCC"><div align="center">Sewa Kendaraan</div></th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php $no=1; foreach($list_um as $ph){?>
            <?php if (trim($ph->keterangan)=='TOTAL') {?>
                <tr bgcolor="#66FF99">
                    <td colspan='3'></td>
                    <td>TOTAL UANG MAKAN <?php echo $ph->nmlengkap;?>: <?php echo $ph->nominalrp;?></td>
                    <td>Tanda Tangan</td>
                    <td colspan="<?= $callplan == "t" ? 7 : 3 ?>"></td>
                </tr>
            <?php } else if ($ph->nmlengkap=='GRAND TOTAL UANG MAKAN'){?>
                <tr bgcolor="#CCCCCC">
                    <td colspan='3'></td>
                    <td><b>GRAND TOTAL UANG MAKAN:</b></td>
                    <td colspan="   <?= $callplan == "t" ? 6 : 4 ?>"><b><?php echo $ph->nominalrp;?></b></td>
                </tr>
            <?php } else {?>
                <tr >
                    <td><?php echo $no;?></td>
                    <td><?php echo $ph->nmlengkap;?></td>
                    <td><?php echo $ph->nmdept;?></td>
                    <td><?php echo $ph->tglhari;?></td>
                    <td><?php echo $ph->checktime;?></td>
                    <?php if($callplan == "t"): ?>
                        <td><?php echo $ph->rencanacallplan;?></td>
                        <td><?php echo $ph->realisasicallplan;?></td>
                    <?php endif; ?>
                    <td></td>
                    <td><?php echo $ph->keterangan;?></td>
                    <td><?php echo $ph->nominalrp;?></td>
                    <?php if($callplan == "t"): ?>
                    <td><?php echo $ph->bbm;?></td>
                    <td><?php echo $ph->sewa_kendaraan;?></td>
                    <?php endif; ?>
                </tr>
            <?php }$no++; }?>
        </tbody>
    </table>
</div>
<p>&nbsp;</p>
<div style="margin-top:50px;">
    <p>
    <table border="0">
        <tbody>
        <tr>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
            <td style="font-size:14px;"><?php echo date('d F Y');?><td>
        </tr>
        <tr>
            <td><td>
            <td style="font-size:14px;">Dibuat,<td>
            <td><td>
            <td style="font-size:14px;">Diperiksa,<td>
            <td><td>
            <td style="font-size:14px;">Disetujui,<td>
        </tr>
        <tr>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
        </tr>
        <tr>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
        </tr>
        <tr>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
        </tr>
        <tr>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
            <td><td>
        </tr>
        <tr>
            <td><td>
            <td style="font-size:14px;"><?php $pembuat=strtolower($this->session->userdata('nama'));
            $buatan=ucfirst($pembuat);
            echo $buatan; ?><td>
            <td><td>
            <td style="font-size:14px;">(.......................)<td>
            <td><td>
            <td style="font-size:14px;">(.......................)<td>
        </tr>
        </tbody>
    </table>
    </p>
</div>

<script type="text/php">

if ( isset($pdf) ) {

  $font = Font_Metrics::get_font("helvetica", "bold");
  $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));

}
</script>
