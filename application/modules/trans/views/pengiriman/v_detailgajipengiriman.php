<?php 
/*
    @author : Junis
*/
?>

<legend><?php echo $title;?></legend>
<div class="row">
    <div class="col-sm-12">                                  
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Mengubah action form ke controller dan fungsi yang baru -->
                        <form action="<?= site_url('trans/pengiriman/excel_gaji_pengiriman') ?>" method="post">
                                <!-- Mengubah link kembali ke controller yang baru -->
                                <a href="<?= site_url("trans/pengiriman/filter_detail") ?>" class="btn btn-default" style="margin: 5px;"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                                <input type="hidden" name="kdcabang" value="<?= $kdcabang ?>">
                                <input type="hidden" name="tgl1" value="<?= $tgl1 ?>">
                                <input type="hidden" name="tgl2" value="<?= $tgl2 ?>">
                                <input type="hidden" name="ketsts" value="<?= $ketsts ?>">
                               <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> XLS</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive" style='overflow-x:scroll;'>
                <!-- Mengubah ID tabel -->
                <table id="table-gajipengiriman" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>                                        
                            <th width="5%">No.</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Nopol</th>
                            <th>Jabatan</th>
                            <th>Upah Harian</th>
                            <th>Insentf Rit1</th>
                            <th>Insentf Rit2</th>
                            <th>Insentif Toko</th>
                            <th>Insentif Jarak 1</th>
                            <th>Insentif Jarak 2</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $current_nik = null;
                        $previous_name = '';
                        $subtotal_upah = 0;
                        $subtotal_rit1 = 0;
                        $subtotal_rit2 = 0;
                        $subtotal_toko = 0;
                        $subtotal_jarak1 = 0;
                        $subtotal_jarak2 = 0;
                        $subtotal_total = 0;
                        
                        $grand_total_upah = 0;
                        $grand_total_rit1 = 0;
                        $grand_total_rit2 = 0;
                        $grand_total_toko = 0;
                        $grand_total_jarak1 = 0;
                        $grand_total_jarak2 = 0;
                        $grand_total_total = 0;

                        $no = 0;
                        // Mengubah variabel utama dari $list_absen menjadi $list_gaji
                        $total_records = count($list_gaji);

                        foreach ($list_gaji as $index => $la):
                            if ($current_nik !== null && $current_nik !== $la->nik) {
                        ?>
                                <tr style="background-color: #f9f9f9; font-weight: bold;">
                                    <td></td>
                                    <td><?php echo $current_nik; ?></td>
                                    <td><?php echo strtoupper($previous_name); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td align="left" style="padding-left: 10px;">TOTAL</td>
                                    <td align="right"><?php echo number_format($subtotal_upah); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_rit1); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_rit2); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_toko); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_jarak1); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_jarak2); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_total); ?></td>
                                    <td></td>
                                </tr>
                        <?php
                                $subtotal_upah = 0;
                                $subtotal_rit1 = 0;
                                $subtotal_rit2 = 0;
                                $subtotal_toko = 0;
                                $subtotal_jarak1 = 0;
                                $subtotal_jarak2 = 0;
                                $subtotal_total = 0;
                            }

                            $current_nik = $la->nik;
                            $previous_name = $la->nmlengkap;
                            $no++;

                            $subtotal_upah += $la->upah_harian;
                            $subtotal_rit1 += $la->rit1;
                            $subtotal_rit2 += $la->rit2;
                            $subtotal_toko += $la->jml_toko;
                            $subtotal_jarak1 += $la->jml_jarak1;
                            $subtotal_jarak2 += $la->jml_jarak2;
                            $subtotal_total += $la->total;
                            
                            $grand_total_upah += $la->upah_harian;
                            $grand_total_rit1 += $la->rit1;
                            $grand_total_rit2 += $la->rit2;
                            $grand_total_toko += $la->jml_toko;
                            $grand_total_jarak1 += $la->jml_jarak1;
                            $grand_total_jarak2 += $la->jml_jarak2;
                            $grand_total_total += $la->total;
                        ?>
                            <tr>                                                                        
                                <td><?php echo $no;?></td>   
                                <td><?php echo $la->nik;?></td>                                         
                                <td><?php echo $la->nmlengkap;?></td>                                                               
                                <td><?php echo date('d-m-Y', strtotime($la->tanggal));?></td>                                   
                                <td><?php echo $la->nopol;?></td>
                                <td><?php echo $la->nmjabatan;?></td>
                                <td align="right"><?php echo number_format($la->upah_harian);?></td>
                                <td align="right"><?php echo number_format($la->rit1);?></td>
                                <td align="right"><?php echo number_format($la->rit2);?></td>
                                <td align="right"><?php echo number_format($la->jml_toko);?></td>
                                <td align="right"><?php echo number_format($la->jml_jarak1);?></td>
                                <td align="right"><?php echo number_format($la->jml_jarak2);?></td>
                                <td align="right"><?php echo number_format($la->total);?></td>
                                <td>
                                    <button class="btn btn-info btn-sm detail-btn" data-toggle="modal" data-target="#detailModal" data-id="<?php echo $la->id_trx; ?>">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        <?php
                            if ($index === $total_records - 1) {
                        ?>
                                <tr style="background-color: #f9f9f9; font-weight: bold;">
                                    <td></td>
                                    <td><?php echo $current_nik; ?></td>
                                    <td><?php echo strtoupper($previous_name); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td align="left" style="padding-left: 10px;">TOTAL</td>
                                    <td align="right"><?php echo number_format($subtotal_upah); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_rit1); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_rit2); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_toko); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_jarak1); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_jarak2); ?></td>
                                    <td align="right"><?php echo number_format($subtotal_total); ?></td>
                                    <td></td>
                                </tr>
                        <?php
                            }
                        endforeach; 
                        ?>
                        
                        <tr style="background-color: #333; color: #fff; font-weight: bold; font-size: 1.1em;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right">GRAND TOTAL</td>
                            <td align="right"><?php echo number_format($grand_total_upah); ?></td>
                            <td align="right"><?php echo number_format($grand_total_rit1); ?></td>
                            <td align="right"><?php echo number_format($grand_total_rit2); ?></td>
                            <td align="right"><?php echo number_format($grand_total_toko); ?></td>
                            <td align="right"><?php echo number_format($grand_total_jarak1); ?></td>
                            <td align="right"><?php echo number_format($grand_total_jarak2); ?></td>
                            <td align="right"><?php echo number_format($grand_total_total); ?></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->                                             
    </div>
</div>

<!-- Modal Detail Pengiriman -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Pengiriman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="detail-content">
                    <p>Memuat detail...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    // Mengubah ID tabel
    $('#table-gajipengiriman').DataTable({
        "ordering": false
    });

    // Event handler untuk tombol detail
    // Mengubah ID tabel
    $('#table-gajipengiriman').on('click', '.detail-btn', function() {
        var id = $(this).data('id');
        
        // Tampilkan loading
        $('#detail-content').html('<p>Memuat detail...</p>');
        
        // Lakukan AJAX request
        $.ajax({
            // Mengubah URL ajax ke controller dan fungsi yang baru
            url: "<?php echo site_url('trans/pengiriman/detail_pengiriman_ajax'); ?>",
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                $('#detail-content').html(response.html);
            },
            error: function() {
                $('#detail-content').html('<p class="text-danger">Gagal memuat detail.</p>');
            }
        });
    });
});
</script>
