<script type="text/javascript">
    // Fungsi ini akan dipanggil saat tombol download ditekan
    function download() {
        // Mengubah teks tombol dan menonaktifkannya untuk mencegah klik ganda
        $('#download').text('Processing....!!').attr('disabled', true);

        // Menyiapkan URL dan data dari form
        // Mengubah URL ke controller pengiriman
        var url = "<?php echo site_url('trans/pengiriman/pr_report_gaji_pengiriman')?>";
        var data = $('#downloadform').serialize();

        // Mengirim data ke server menggunakan AJAX
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "JSON",
            success: function(data) {
                // Jika berhasil, ambil nilai bulan dan tahun
                var blndl = $('#blndl').val();
                var thndl = $('#thndl').val();
                
                // Sembunyikan modal
                $('#modal_form').modal('hide');

                // Sembunyikan pesan notifikasi setelah 5 detik
                setTimeout(function() {
                    $("#message").hide('blind', {}, 500)
                }, 5000);

                // Kembalikan tombol ke keadaan semula
                $('#download').text('Download').attr('disabled', false);
                
                // Buka laporan di tab baru
                // Mengubah URL ke controller pengiriman
                window.open("<?php echo site_url('trans/pengiriman/report_gaji_pengiriman')?>/" + blndl + '/' + thndl, '_blank');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Jika terjadi error, sembunyikan modal dan tampilkan pesan error
                $('#modal_form').modal('hide');
                alert('Error: Gagal memproses data');
                
                // Kembalikan tombol ke keadaan semula
                $('#download').text('Download').attr('disabled', false);
            }
        });
    }
</script>

<legend><?php echo $title;?></legend>

<div class="row">
    <?php if($akses['aksesview']=='t') { ?>
    <!-- Form Filter Laporan Gaji -->
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12">
                    <h4>Filter Laporan Gaji Pengiriman Per Wilayah</h4>
                </div>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <!-- Mengubah action form ke controller dan fungsi yang baru -->
                    <form action="<?php echo site_url('trans/pengiriman/detailgajipengiriman');?>" name="form" role="form" method="post">
                        <!-- Pilih Wilayah -->
                        <div class="form-group">
                            <label class="col-lg-3">Pilih Wilayah</label>
                            <div class="col-lg-9">
                                <!-- Menggunakan class="pilih-wilayah" bukan id -->
                                <select name="kanwil" class="pilih-wilayah" required>
                                    <option value="">--Pilih Wilayah--</option>
                                    <?php foreach ($list_kanwil as $ld){ ?>
                                        <option value="<?php echo trim($ld->kdcabang);?>"><?php echo $ld->desc_cabang;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- Tanggal -->
                        <div class="form-group">
                            <label class="col-lg-3">Tanggal</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" id="tgl" name="tgl" class="form-control pull-right">
                                </div>
                            </div>
                        </div>
                        <!-- Pilih Jabatan -->
                        <div class="form-group">
                            <label class="col-lg-3">PILIH JABATAN</label>
                            <div class="col-lg-9">
                                <select id="ketsts" name="ketsts" class="sl">
                                    <option value="">--ALL--</option>
                                    <!-- Mengubah variabel dari $list_trxabsen menjadi $list_trxpengiriman -->
                                    <?php foreach ($list_trxpengiriman as $ld){ ?>
                                        <option value="<?php echo trim($ld->kdtrx);?>"><?php echo trim($ld->kdtrx).' || '.trim($ld->uraian);?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- Tombol Proses -->
                        <div class="form-group">
                            <div class="col-lg-4">
                                <button type='submit' class='btn btn-primary'><i class="glyphicon glyphicon-search"></i> Proses</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Filter Laporan Insentif -->
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12">
                    <h4>Filter Laporan Insentif per Wilayah</h4>
                </div>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                     <!-- Mengubah action form ke controller dan fungsi yang baru -->
                       <form action="<?php echo site_url('trans/pengiriman/laporan_insentif_driver');?>" name="form_insentif" role="form" method="post">
                        <div class="form-group">
                            <label class="col-lg-3">Pilih Wilayah</label>
                            <div class="col-lg-9">
                                <select name="kanwil" class="pilih-wilayah" required>
                                    <option value="">--Pilih Wilayah--</option>
                                    <?php foreach ($list_kanwil as $ld){ ?>
                                        <option value="<?php echo trim($ld->kdcabang);?>"><?php echo $ld->desc_cabang;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Tanggal Uang Makan (UM)</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" id="tgl_um" name="tgl_um" class="form-control pull-right" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Tanggal Tunj. Kehadiran</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" id="tgl_kehadiran" name="tgl_kehadiran" class="form-control pull-right" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Tanggal Insentif</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" id="tgl_insentif" name="tgl_insentif" class="form-control pull-right" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-9">
                                <button type='submit' class='btn btn-primary'><i class="glyphicon glyphicon-search"></i> Proses</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">TUNGGU SEBENTAR BOSSS</h3>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script>
    // Inisialisasi Date range picker
    $('#tgl').daterangepicker();
    $('#tgl2').daterangepicker();
    $('#tgl3').daterangepicker();
    $('#tgl4').daterangepicker();

    $('#tgl_um').daterangepicker();
    $('#tgl_kehadiran').daterangepicker();
    $('#tgl_insentif').daterangepicker();

    // Inisialisasi Selectize
    // PERBAIKAN: Menggunakan selector class (titik) untuk menargetkan semua elemen dengan class "pilih-wilayah"
    $('.pilih-wilayah').selectize(); 
    
    $('#pilihdept').selectize();
    $('#pilihdept1').selectize();
    $('#pilihregu').selectize();
    $('.sl').selectize();
</script>
