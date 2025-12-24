<?php
?>
<thead>
<tr>
    <td><b>Nomor</b></td>
    <td><b>Nomor PO</b></td>
    <td><b>Nama Barang</b></td>
    <td><b>Jumlah</b></td>
    <td><b>Harga</b></td>
    <td><b>Total</b></td>
    <?php if (!$approve){ echo '<td><b>Aksi</b></td>'; } ?>
</tr>
</thead>
<tbody>
<?php foreach ($cashboncomponentspo as $index => $row ) { ?>
    <tr>
        <td><?php echo ($index +1) ?></td>
        <td ><?php echo $row->pono ?></td>
        <td><?php echo $row->stockname ?></td>
        <td class="text-right"><?php echo $row->qty ?></td>
        <td class="text-right"><?php echo $row->pricelistformat ?></td>
        <td class="text-right"><?php echo $row->nettoformat ?></td>
        <?php if (!$approve){ ?>
            <td >
                <a href="javascript:void(0)" class="deletecomponentpo" data-id="<?php echo $row->pono ?>" data-href="<?php echo site_url('kasbon_umum/cashbon/deletecomponentpo/'.bin2hex(json_encode(array('pono' => $row->pono,'cashbondid'=>$row->cashbonid,'type'=>'PO')))) ?>"><span class="text-danger"><i class="fa fa-trash"></i> Hapus</span></a>
            </td>
        <?php } ?>

    </tr>
<?php } ?>
<tr><td colspan="5" class="text-center"><b>Total PO</b></td><td class="text-right "><b class="pototal"><?php echo $row->sumnettoformat ?></b></td><?php echo (!$approve)?'<td></td>':'' ?></tr>
</tbody>
<script>

    /*$('a.deletecomponentpo').on('click', function () {
        var selected = $(this)
        Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
            },
            buttonsStyling: false,
        }).fire({
            title: 'Konfirmasi Hapus',
            html: 'Hapus PO Nomor <b>'+ selected.data('id') +'</b> ?',
            icon: 'question',
            showCloseButton: true,
            confirmButtonText: 'Konfirmasi',
        }).then(function (result) {
            var response
            if (result.isConfirmed) {
                $.ajax({
                    url: $('a.deletecomponentpo').data('href'),
                    data: 'hapus',
                    type: 'POST',
                    success: function (data) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm ml-3',
                                cancelButton: 'btn btn-sm ml-3',
                                denyButton: 'btn btn-sm ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Berhasil Dibuat',
                            html: data.message,
                            timer: 3000,
                            timerProgressBar: true,
                            showCloseButton: true,
                            showConfirmButton: false,
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        })
                    },
                    error: function (xhr, status, thrown) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: 'Gagal Dihapus',
                            text: xhr.statusText,
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    },
                });
            }
        });
    })*/
</script>