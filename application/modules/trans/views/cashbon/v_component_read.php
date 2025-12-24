<?php
?>
<thead>
<tr>
    <td><b>No</b></td>
    <td><b>Nama Biaya</b></td>
    <td><b>Keterangan</b></td>
    <td><b>Nominal</b></td>
    <td><b>Hari Dinas</b></td>
    <td><b>Total</b></td>
</tr>
</thead>
<tbody>
<?php foreach ((count($cashboncomponents) > 0 ? $cashboncomponents : $cashboncomponentsempty) as $index => $row ) { ?>
    <tr>
        <td><?php echo $index +1 ?></td>
        <td><?php echo $row->componentname ?></td>
        <td><?php echo $row->description ?></td>
        <td class="text-right"><?php echo $row->nominalformat ?></td>
        <td class="text-right"><?php echo ($row->multiplication == 't')? $row->quantityday : '' ?></td>
        <td class="text-right"><?php echo $row->totalcashbonformat ?></td>
    </tr>
<?php } ?>
<tr><td colspan="5" class="text-center"><b>Total Kasbon Dinas Karyawan</b></td><td class="text-right"><b><?php echo (isset($cashbon->totalcashbon) ? $cashbon->totalcashbonformat : 0) ?></b></td></tr>
</tbody>