<?php
//    var_dump('dddd');die();
?>
<thead>
<tr>
    <td><b>Tanggal</b></td>
    <?php foreach ($components as $index => $component) { ?>
        <td><b><?php echo $component->description ?></b></td>
    <?php } ?>
    <td><b>Total Nominal</b></td>
    <td><b>Keterangan</b></td>
    <?php if (!$approve){
        echo '<td><b></b></td>';
    } ?>

</tr>
</thead>
<tbody>
<?php
foreach ((count($declarationcomponents) > 0 ? $declarationcomponents : $declarationcomponentsempty) as $index => $declarationcomponent) {
    $data[$declarationcomponent->perday][$declarationcomponent->componentid] = $declarationcomponent;
}
?>
<?php foreach ($days as $index => $day) { ?>
    <tr>
        <td><?php echo $day->dayformat ?></td>
        <?php $description = array(); ?>
        <?php foreach ($components as $indexs => $component) { ?>
            <td class="text-right"><?php echo $data[$day->day][$component->componentid]->nominalformat ?></td>
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
        <td class="text-right"><b><?php echo number_format($data[$day->day]['totalperday'],0,',','.') ?></b></td>
        <td><?php echo $data[$day->day]['description'] ?></td>
        <?php if (!$approve){ ?>
            <td><a href="javascript:void(0)" class="btn btn-sm btn-info createdeclarationcomponent" data-href="<?php echo site_url('trans/declarationcashbon/'.(isset($declaration) ? 'updatecomponentpopup' : 'createcomponentpopup').'/'.bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $dinas->nodok, 'cashbonid' => isset($cashbon->cashbonid) ? $cashbon->cashbonid : '', 'declarationid' => $declaration->declarationid, 'perday' => $day->day, )))) ?>"><i class="fa fa-edit"> Input Data</i></a></td>
        <?php } ?>

        <?php
        $data['total'] = (isset($data['total']) ? $data['total'] : 0) + $data[$day->day]['totalperday'];
        ?>
    </tr>
<?php } ?>
<tr>
    <td><b>Total Deklarasi</b></td>
    <?php foreach ($components as $index => $component) { ?>
        <td class="text-right"><b>
            <?php if ($component->calculated == 't') { ?>
                <?php echo number_format($data['totalpercomponent'][$component->componentid],0,',','.') ?>
            <?php } ?>
        </b></td>
    <?php } ?>
    <td class="text-right"><b><?php echo number_format($data['total'],0,',','.') ?></b></td>
    <td><b></b></td>
    <?php if (!$approve){
        echo '<td><b></b></td>';
    } ?>
</tr>
</tbody>