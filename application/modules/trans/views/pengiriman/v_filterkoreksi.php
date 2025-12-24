<legend><?php echo $title;?></legend>
<?php 
if ($this->session->flashdata('message')) {
    if (is_array($this->session->flashdata('message'))) {
        $message_data = $this->session->flashdata('message');
        echo '<div class="alert alert-'.$message_data['type'].'">'.$message_data['text'].'</div>';
    } else {
        echo $this->session->flashdata('message');
    }
}
?>

<?php if($akses['aksesupdate']=='t') { ?>
<div class="row">
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12">
                    <h4>Filter Laporan Pengiriman</h4>
                </div>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <form action="<?php echo site_url('trans/pengiriman/koreksipengiriman');?>" name="form" role="form" method="post">
                        <div class="form-group">
                            <label class="col-lg-3">Pilih Wilayah</label>
                            <div class="col-lg-9">
                                <select name="kanwil" class="pilih-wilayah form-control" required>
                                    <option value="">--Pilih Wilayah--</option>
                                    <?php foreach ($list_kanwil as $ld){ ?>
                                        <option value="<?php echo trim($ld->kdcabang);?>"><?php echo $ld->desc_cabang;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Tanggal</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" id="tgl" name="tgl" class="form-control pull-right">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-9">
                                <button type='submit' class='btn btn-primary'><i class="glyphicon glyphicon-search"></i> Proses Pengiriman</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12">
                    <h4>Filter Helper Gudang</h4>
                </div>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <form action="<?php echo site_url('trans/pengiriman/koreksihelpergudang');?>" name="form_hg" role="form" method="post">
                        <div class="form-group">
                            <label class="col-lg-3">Pilih Wilayah</label>
                            <div class="col-lg-9">
                                <select name="kanwil_hg" class="pilih-wilayah-hg form-control" required>
                                    <option value="">--Pilih Wilayah--</option>
                                    <?php foreach ($list_kanwil as $ld){ ?>
                                        <option value="<?php echo trim($ld->kdcabang);?>"><?php echo $ld->desc_cabang;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Tanggal</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" id="tgl_hg" name="tgl_hg" class="form-control pull-right">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-9">
                                <button type='submit' class='btn btn-primary'><i class="glyphicon glyphicon-search"></i> Proses Helper Gudang</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else { echo 'Anda tidak diperkenankan mengakses modul ini!'; } ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#tgl').daterangepicker({
        locale: { format: 'DD-MM-YYYY' }
    });
    $('#tgl_hg').daterangepicker({
        locale: { format: 'DD-MM-YYYY' }
    });
    $('.pilih-wilayah').select2();
    $('.pilih-wilayah-hg').select2();
});
</script>
