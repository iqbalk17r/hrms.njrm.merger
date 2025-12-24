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
        <td class="paddingall fontsize12">Nama</td>
        <td class="fontsize12" colspan="9"><span> : </span><span class="paddingleft paddingleft"><?php echo $employee->nmlengkap ?></span></td>
        <td class="paddingall borderall fontsize12 textcenter" colspan="2"><b><?php echo $dinas->nodok ?></b></td>
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
        <td class="borderleft borderright textleft textmiddle paddingall fontsize14 fontbold" colspan="12">FORMULIR DEKLARASI PERJALANAN DINAS</td>
    </tr>
    <tr>
        <td class="borderleft borderright borderbottom textleft textmiddle paddingall fontsize14 fontbold" colspan="12"></td>
    </tr>
    <tr>
        <td class="borderall fontsize12 paddingall" rowspan="7"></td>
        <td class="borderall fontsize12 paddingall">1. Nomer Dokumen</td>
        <td class="borderall fontsize12 paddingall textcenter backgreen" colspan="10"><b><?php echo $declaration->declarationid ?></b></td>
    </tr>
    <tr>
        <td class="borderall fontsize12 paddingall">2. Kota Tujuan</td>
        <td class="borderall fontsize12 paddingall textcenter backgreen" colspan="10"><?php echo $citycashbon->text ?></td>
    </tr>
    <tr>
        <td class="borderall fontsize12 paddingall">3. Jenis Kota Tujuan</td>
        <td class="borderall fontsize12 paddingall textcenter backgreen" colspan="10"><?php echo $destinationtype->text ?></td>
    </tr>
    <tr>
        <td class="borderall fontsize12 paddingall">4. Sarana Transportasi</td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall" colspan="9"><?php echo $transportasi->text.' ('.$transptype->text.')' ?></td>
    </tr>
    <tr>
        <td class="borderall fontsize12 paddingall">5. Berangkat :</td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall">Tgl.</td>
        <td class="borderall fontsize12 paddingall textright"><?php echo date('d-m-Y', strtotime($dinas->tgl_mulai)) ?></td>
        <td class="borderall fontsize12 paddingall">Jam</td>
        <td class="borderall fontsize12 paddingall textright"><?php echo date('H:i:s', strtotime($dinas->jam_mulai)) ?></td>
        <td class="borderall fontsize12 paddingall">Tiba :</td>
        <td class="borderall fontsize12 paddingall">Tgl.</td>
        <td class="borderall fontsize12 paddingall textright"><?php echo date('d-m-Y', strtotime($dinas->tgl_mulai)) ?></td>
        <td class="borderall fontsize12 paddingall">Jam</td>
        <td class="borderall fontsize12 paddingall textright"><?php echo date('H:i:s', strtotime($dinas->jam_mulai)) ?></td>
    </tr>
    <tr>
        <td class="borderall fontsize12 paddingall">6. Pulang</td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall">Tgl.</td>
        <td class="borderall fontsize12 paddingall textright"><?php echo date('d-m-Y', strtotime($dinas->tgl_selesai)) ?></td>
        <td class="borderall fontsize12 paddingall">Jam</td>
        <td class="borderall fontsize12 paddingall textright"><?php echo date('H:i:s', strtotime($dinas->jam_selesai)) ?></td>
        <td class="borderall fontsize12 paddingall">Tiba :</td>
        <td class="borderall fontsize12 paddingall">Tgl.</td>
        <td class="borderall fontsize12 paddingall textright"><?php echo date('d-m-Y', strtotime($dinas->tgl_selesai)) ?></td>
        <td class="borderall fontsize12 paddingall">Jam</td>
        <td class="borderall fontsize12 paddingall textright"><?php echo date('H:i:s', strtotime($dinas->jam_selesai)) ?></td>
    </tr>
    <tr>
        <td class="borderall fontsize12 paddingall">.</td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall"></td>
        <td class="borderall fontsize12 paddingall"></td>
    </tr>
    <tr>
        <td class="borderleft borderright fontsize12 paddingall" colspan="12">Tujuan / Target Perjalanan Dinas : <?php echo $dinas->keperluan ?></td>
    </tr>
    <tr>
        <td class="borderleft borderright fontsize12 paddingall" colspan="12">.</td>
    </tr>
    <tr>
        <td class="borderleft borderright fontsize12" colspan="12">
            <table class="bordernone" style="width: 100%">
                <colgroup></colgroup>
                <tbody>
                <tr>
                    <td class="bordertop borderright borderbottom fontsize12 paddingall"><b>Tanggal</b></td>
                    <?php foreach ($components as $index => $component) { ?>
                        <td class="borderall fontsize12 paddingall"><b><?php echo $component->description ?></b></td>
                    <?php } ?>
                    <td class="borderall fontsize12 paddingall"><b>Total Nominal</b></td>
                    <td class="bordertop borderleft borderbottom fontsize12 paddingall"><b>Keterangan</b></td>
                </tr>
                <?php
                foreach ((count($declarationcomponents) > 0 ? $declarationcomponents : $declarationcomponentsempty) as $index => $declarationcomponent) {
                    $data[$declarationcomponent->perday][$declarationcomponent->componentid] = $declarationcomponent;
                }
                ?>
                <?php foreach ($days as $index => $day) { ?>
                    <tr>
                        <td class="bordertop borderright borderbottom fontsize12 paddingall"><?php echo $day->dayformat ?></td>
                        <?php $description = array(); ?>
                        <?php foreach ($components as $indexs => $component) { ?>
                            <td class="borderall fontsize12 paddingall textright"><?php echo (!is_null($data[$day->day][$component->componentid]->nominalformat) && !is_nan($data[$day->day][$component->componentid]->nominalformat) && $data[$day->day][$component->componentid]->calculated == 't') ? '' : '' ?> <?php echo $data[$day->day][$component->componentid]->nominalformat ?></td>
                            <?php
                            if ($component->calculated == 't') {
                                $data[$day->day]['totalperday'] = (isset($data[$day->day]['totalperday']) ? $data[$day->day]['totalperday'] : 0) + $data[$day->day][$component->componentid]->nominal;
                                $data['totalpercomponent'][$component->componentid] = (isset($data['totalpercomponent'][$component->componentid]) ? $data['totalpercomponent'][$component->componentid] : 0) + $data[$day->day][$component->componentid]->nominal;
                            }
                            if (!is_null($data[$day->day][$component->componentid]->description) && !is_nan($data[$day->day][$component->componentid]->description) && !empty($data[$day->day][$component->componentid]->description)) {
                                array_push($description, $data[$day->day][$component->componentid]->description);
                            }
                            $data[$day->day]['description'] = join(', ', $description);
                            ?>
                        <?php } ?>
                        <td class="borderall fontsize12 paddingall textright"> <?php echo number_format($data[$day->day]['totalperday'],0,',','.') ?></td>
                        <td class="bordertop borderleft borderbottom fontsize12 paddingall"><?php echo $data[$day->day]['description'] ?></td>
                        <?php
                        $data['total'] = (isset($data['total']) ? $data['total'] : 0) + $data[$day->day]['totalperday'];
                        ?>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="bordertop borderright borderbottom fontsize12 paddingall"><b>Total Deklarasi</b></td>
                    <?php foreach ($components as $index => $component) { ?>
                        <td class="borderall fontsize12 paddingall textright">
                            <?php if ($component->calculated == 't') { ?>
                                <!-- --><?php echo number_format($data['totalpercomponent'][$component->componentid],0,',','.') ?>
                            <?php } ?>
                        </td>
                    <?php } ?>
                    <td class="borderall fontsize12 paddingall textright"><b><?php echo number_format($data['total'],0,',','.') ?></b></td>
                    <td class="bordertop borderleft borderbottom fontsize12 paddingall"><b></b></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td class="borderleft borderright fontsize12 paddingall" colspan="12">.</td>
    </tr>
    <tr>
        <td class="borderleft borderright bordertop fontsize12 paddingall" colspan="12">Biaya Deklarasi Dinas sejumlah : <b><?php echo (isset($declaration->totaldeclaration) ? $declaration->totaldeclarationformat : 0) ?>,-</b> Kasbon yang diberikan sejumlah : <b><?php echo (isset($declaration->totalcashbon) ? $declaration->totalcashbonformat : 0) ?>,-</b>
            <?php
            if ((isset($declaration->totaldeclaration) ? $declaration->totaldeclaration : 0) != (isset($declaration->totalcashbon) ? $declaration->totalcashbon : 0)) {
                if ((isset($declaration->totaldeclaration) ? $declaration->totaldeclaration : 0) > (isset($declaration->totalcashbon) ? $declaration->totalcashbon : 0)) {
                    echo 'Jumlah Kelebihan Deklarasi : <b>-'.number_format((isset($declaration->totaldeclaration) ? $declaration->totaldeclaration : 0) - (isset($declaration->totalcashbon) ? $declaration->totalcashbon : 0),0,',','.').',-</b>';
                }
                if ((isset($declaration->totaldeclaration) ? $declaration->totaldeclaration : 0) < (isset($declaration->totalcashbon) ? $declaration->totalcashbon : 0)) {
                    echo 'Jumlah Kelebihan Kasbon : <b>'.number_format((isset($declaration->totalcashbon) ? $declaration->totalcashbon : 0) - (isset($declaration->totaldeclaration) ? $declaration->totaldeclaration : 0),0,',','.').',-</b>';
                }
            }
            ?>
        </td>
    </tr>
    <tr>
        <td class="borderleft borderright fontsize12 paddingall" colspan="12"></td>
    </tr>
    <tr>
        <td class="borderleft borderright bordertop fontsize12 paddingall" colspan="12"><?php echo $city.date('d-m-Y', strtotime($declaration->approvedate)) ?></td>
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
