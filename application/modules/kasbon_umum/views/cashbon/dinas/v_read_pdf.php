
<style type="text/css">
    @page { margin: <?php echo ($marginsize > 0 ? $marginsize : 10) ?>px; }
    .preview {
        margin: <?php echo ($marginsize > 0 ? $marginsize : 10) ?>px;
        font-family: 'Times New Roman';
    }
    .backgreen {
        background: rgba(0, 255, 0, 0.99);
    }
    <?php 
    if ($fontsize > 0) { ?>
    .fontsize12 {
        font-size: <?php echo 12 + $fontsize ?>px;
    }
    .fontsize14 {
        font-size: <?php echo 14 + $fontsize ?>px;
    }
    .fontsize20 {
        font-size: <?php echo 20 + $fontsize ?>px;
    }
    <?php } else { ?>
    .fontsize12 {
        font-size: <?php echo 12 - $fontsize ?>px;
    }
    .fontsize14 {
        font-size: <?php echo 14 - $fontsize ?>px;
    }
    .fontsize20 {
        font-size: <?php echo 20 - $fontsize ?>px;
    }
    <?php } ?>
    .fontbold {
        font-weight: bold;
    }
    .textcenter {
        text-align: center;
    }
    .textleft {
        text-align: left;
    }
    .textright {
        text-align: right;
    }
    .textmiddle {
        vertical-align: middle;
    }
    .texttop {
        vertical-align: top;
    }
    .textbottom {
        vertical-align: bottom;
    }
    .bordernone {
        border: none;
        border-spacing: 0;
        border-collapse: collapse
    }
    .bordertop {
        border-top: 1px solid;
    }
    .borderbottom {
        border-bottom: 1px solid;
    }
    .borderbottomdotted {
        border-bottom: 1px dotted;
    }
    .borderleft {
        border-left: 1px solid;
    }
    .borderright {
        border-right: 1px solid;
    }
    .borderall {
        border: 1px solid;
    }
    .borderdotted {
        border-style: dotted;
    }
    .paddingleft {
        padding-left: <?php echo ($paddingsize > 0 ? $paddingsize : 5) ?>px;
    }
    .paddingright {
        padding-right: <?php echo ($paddingsize > 0 ? $paddingsize : 5) ?>px;
    }
    .paddingtop {
        padding-top: <?php echo ($paddingsize > 0 ? $paddingsize : 5) ?>px;
    }
    .paddingbottom {
        padding-bottom: <?php echo ($paddingsize > 0 ? $paddingsize : 5) ?>px;
    }
    .paddingall {
        padding: <?php echo ($paddingsize > 0 ? $paddingsize : 5) ?>px;
    }
</style>
<table class="bordernone" style="table-layout: fixed; width: 100%">
    <colgroup>
        <col style="width: 50px">
        <col style="width: 50px">
        <col style="width: 50px">
        <col style="width: 50px">
        <col style="width: 50px">
        <col style="width: 50px">
        <col style="width: 50px">
        <col style="width: 50px">
        <col style="width: 50px">
        <col style="width: 50px">
        <col style="width: 50px">
        <col style="width: 50px">
    </colgroup>
    <tbody>
    <tr>
        <td class="paddingall fontsize12">Nomor Dokumen</td>
        <td class="fontsize12" colspan="9"><span> : </span><span class="paddingleft paddingleft"><?php echo $cashbon->cashbonid ?></span></td>
    </tr>
    <tr>
        <td class="paddingall fontsize12">Nama</td>
        <td class="fontsize12" colspan="9"><span> : </span><span class="paddingleft paddingleft"><?php echo $employee->nmlengkap ?></span></td>

    </tr>
    <tr>
        <td class="paddingall fontsize12">Nik</td>
        <td class="fontsize12" colspan="11"><span> : </span><span class="paddingleft paddingleft"><?php echo $employee->nik ?></span></td>
    </tr>
    <tr>
        <td class="paddingall fontsize12">Bagian</td>
        <td class="fontsize12" colspan="11"><span> : </span><span class="paddingleft paddingleft"><?php echo $employee->nmsubdept ?></span></td>
    </tr>
    <tr>
        <td class="paddingall fontsize12">Jabatan</td>
        <td class="fontsize12" colspan="11"><span> : </span><span class="paddingleft paddingleft"><?php echo $employee->nmjabatan ?></span></td>
    </tr>
    <tr>
        <td class="paddingall fontsize12">No.Telepon</td>
        <td class="fontsize12" colspan="11"><span> : </span><span class="paddingleft paddingleft"><?php echo $dinas->no_telp ?></span></td>
    </tr>
    </tbody>
</table>
<table class="bordernone" style="width: 100%">
    <colgroup></colgroup>
    <tbody>
    <tr>
        <td class="borderleft borderright bordertop textleft textmiddle paddingall fontsize14 fontbold" colspan="12"></td>
    </tr>
    <tr>
        <td class="borderleft borderright textleft textmiddle paddingall fontsize14 fontbold" colspan="12">FORMULIR KASBON PERJALANAN DINAS</td>
    </tr>
    <tr>
        <td class="borderleft borderright borderbottom textleft textmiddle paddingall fontsize14 fontbold" colspan="12"></td>
    </tr>

    <tr>
        <td class="borderleft borderright fontsize12 paddingall" colspan="12">.</td>
    </tr>
    <tr>
        <td class="borderleft borderright fontsize12 paddingall" colspan="12"><b>Rincian Dinas</b></td>
    </tr>
    <tr>
        <td class="borderleft borderright fontsize12" colspan="12">
            <table class="bordernone" style="width: 100%">
                <thead>
                <tr>
                    <th class="borderall textmiddle paddingall fontsize12 fontbold" width="10%">Nomor Dinas</th>
                    <th class="borderall textmiddle paddingall fontsize12 fontbold" width="12%">Tanggal Dinas</th>
                    <th class="borderall textmiddle paddingall fontsize12 fontbold" width="15%">Kota Tujuan</th>
                    <th class="borderall textmiddle paddingall fontsize12 fontbold" width="5%">Callplan</th>
                    <th class="borderall textmiddle paddingall fontsize12 fontbold" width="10%">Sarana Transportasi</th>
                    <th class="borderall textmiddle paddingall fontsize12 fontbold" width="8%">Tipe Kendaraan</th>
                    <th class="borderall textmiddle paddingall fontsize12 fontbold">Keperluan</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($dinas as $index => $row) { ?>
                    <tr>
                        <td class="borderall textmiddle paddingall fontsize12"><?php echo $row->nodok ?></td>
                        <td class="borderall textmiddle paddingall fontsize12"><?php echo $row->dutieperiod ?></td>
                        <td class="borderall textmiddle paddingall fontsize12"><?php echo $row->tujuan_kota_text ?></td>
                        <td class="borderall textmiddle paddingall fontsize12"><?php echo $row->callplan_reformat ?></td>
                        <td class="borderall textmiddle paddingall fontsize12"><?php echo $row->transportasi_text ?></td>
                        <td class="borderall textmiddle paddingall fontsize12"><?php echo $row->tipe_transportasi_text ?></td>
                        <td class="borderall textmiddle paddingall fontsize12"><?php echo $row->keperluan ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td class="borderleft borderright fontsize12 paddingall" colspan="12">.</td>
    </tr>
    <tr>
        <td class="borderleft borderright fontsize12 paddingall" colspan="12"><b>Rincian Kasbon</b></td>
    </tr>
    <tr>
        <td class="borderall fontsize12 paddingall textcenter" >No.</td>
        <td class="borderall fontsize12 paddingall textcenter" >Nomor Dinas</td>
        <td class="borderall fontsize12 paddingall textcenter" >Keperluan</td>
        <td class="borderall fontsize12 paddingall textcenter" >Biaya Per Hari</td>
        <td class="borderall fontsize12 paddingall textcenter" >Jml.Satuan Hari</td>
        <td class="borderall fontsize12 paddingall textcenter" >Total</td>
        <td class="borderleft borderright fontsize12 paddingall" colspan="7" rowspan="<?php echo (int)count($cashboncomponents) + 2 ?>"></td>
    </tr>
    <?php foreach ($cashboncomponents as $index => $row ) { ?>
        <tr>
            <td class="borderall fontsize12 paddingall textcenter" ><?php echo $index +1 ?></td>
            <td class="borderall fontsize12 paddingall" ><?php echo $row->dutieid ?></td>
            <td class="borderall fontsize12 paddingall" ><?php echo $row->componentname ?></td>
            <td class="borderall fontsize12 paddingall textright" ><?php echo $row->calculated == 't' ? '' : '' ?> <?php echo $row->nominalformat ?></td>
            <td class="borderall fontsize12 paddingall textright" ><?php echo ($row->multiplication == 't' ? $row->quantityday : '') ?></td>
            <td class="borderall fontsize12 paddingall textright" ><?php echo $row->calculated == 't' ? '' : '' ?> <?php echo $row->totalcashbonformat ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td class="borderall fontsize12 paddingall textright"  colspan="5">Total Yang Bisa Diberikan </td>
        <td class="borderall fontsize12 paddingall textright" > Rp<?php echo (isset($cashbon->totalcashbon) ? $cashbon->totalcashbonformat : 0) ?>,-</td>
    </tr>
    <tr>
        <td class="borderleft borderright fontsize12 paddingall" colspan="12">.</td>
    </tr>
    <tr>
        <td class="borderleft borderright bordertop fontsize12 paddingall" colspan="12">Biaya yang diberikan sejumlah : <b>Rp<?php echo (isset($cashbon->totalcashbon) ? $cashbon->totalcashbonformat : 0) ?>,-</b> dan akan diberikan dengan cara : <?php echo $paymenttype->text ?>, No. Rek. <?php echo $employee->norek ?> a.n. : <?php echo $employee->namapemilikrekening ?></td>
    </tr>
    <tr>
        <td class="borderleft borderright fontsize12 paddingall" colspan="12"></td>
    </tr>
    <tr>
        <td class="borderleft borderright bordertop fontsize12 paddingall" colspan="12"> <?php echo $city. date('d-m-Y', strtotime($cashbon->approvedate)) ?></td>
    </tr>
    <tr>
        <td class="borderleft fontsize12 paddingall" colspan="4">Diajukan Oleh,</td>
        <td class="fontsize12 paddingall" colspan="4">Disetujui Oleh,</td>
        <td class="borderright fontsize12 paddingall" colspan="4">Diketahui oleh,</td>
    </tr>
    <tr>
        <td class="borderleft fontsize12 paddingall" colspan="4">.</td>
        <td class="fontsize12 paddingall" colspan="4">.</td>
        <td class="borderright fontsize12 paddingall" colspan="4">.</td>
    </tr>
    <tr>
        <td class="borderleft fontsize12 paddingall" colspan="4"></td>
        <td class="fontsize12 paddingall" colspan="4"></td>
        <td class="borderright fontsize12 paddingall" colspan="4"></td>
    </tr>
    <tr>
        <td class="borderleft fontsize12 paddingall" colspan="4">( <?php echo $employee->nmlengkap ?> )</td>
        <td class="fontsize12 paddingall" colspan="4">( <?php echo $employee->nmatasan ?> )</td>
        <td class="borderright fontsize12 paddingall" colspan="4">( <?php echo str_repeat('.', 40) ?> )</td>
    </tr>
    <tr>
        <td class="borderleft borderright borderbottom fontsize12 paddingall" colspan="12"></td>
    </tr>
    </tbody>
</table>