<?php
?>
<thead>
<tr>
    <td><b>No</b></td>
    <td><b>Nama Biaya</b></td>
    <td><b>Keterangan</b></td>
    <td><b>Nominal</b></td>
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
        <td class="text-right"><?php echo $row->totalcashbonformat ?></td>
    </tr>
<?php } ?>
<tr><td colspan="4" class="text-center"><b>Total Kasbon Karyawan</b></td><td class="text-right "><b class="cashbontotal"><?php echo (isset($cashbon->totalcashbon) ? $cashbon->totalcashbonformat : 0) ?></b></td></tr>
</tbody>
<script>
    $('label#totalcashbon').text('<?php echo (isset($cashbon->totalcashbon) ? $cashbon->totalcashbonformat : 0) ?>')
</script>