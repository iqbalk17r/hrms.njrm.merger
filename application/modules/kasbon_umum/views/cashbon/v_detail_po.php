<table class="table table-responsive">
    <thead>
    <tr>
        <td><b>No</b></td>
        <td><b>Nomor PO</b></td>
        <td><b>Kode Stok</b></td>
        <td><b>Jumlah</b></td>
        <td><b>Harga Satuan</b></td>
        <td><b>Harga Total</b></td>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($detail as $index => $row ) { ?>
            <tr>
                <td><?php echo $index + 1 ?></td>
                <td><?php echo $row->pono?></td>
                <td><?php echo $row->stockcode?></td>
                <td><?php echo $row->qty?></td>
                <td><?php echo $row->pricelist?></td>
                <td class="text-right"><?php echo $row->nettoformat?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5" style="text-align:right">Total:</th>
            <th class="total" data-id="<?=$total?>" style="font-size: medium"><?php echo (isset($total) ? number_format($total, 2, ',', '.') : 0) ?></th>
        </tr>
    </tfoot>
</table>
<script>
    function load_total(){
        setTimeout(function (){
            //var labeltext = $('label#total').text(<?//=$total?>//)
            //$('input[name=\'totalcashbon\']').val(<?//=$total?>//)
        },2000)
    }

    $(document).ready(function() {
        $('.table').DataTable();
        load_total()
    })
</script>