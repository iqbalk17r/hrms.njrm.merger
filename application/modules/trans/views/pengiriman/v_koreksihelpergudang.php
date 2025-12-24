<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<legend><?php echo $title;?></legend>
<?php 
if ($this->session->flashdata('message')) {
    echo $this->session->flashdata('message');
}
?>

<!-- Load Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-12">  
                    <a href="#" data-toggle="modal" data-target="#inputHelperGudangModal" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Kehadiran Helper Gudang</a>
                    <a href="<?php echo site_url('trans/absensi/filter_koreksi');?>" class="btn btn-default" style="margin:10px;">Kembali ke Filter</a>
                </div>
            </div>
            <div class="box-body table-responsive">
                <p>Menampilkan data untuk wilayah <strong><?php echo html_escape($kanwil_filter); ?></strong> dari tanggal <strong><?php echo html_escape($tgl1_filter); ?></strong> hingga <strong><?php echo html_escape($tgl2_filter); ?></strong>.</p>
                <table id="table-hg" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>NIK</th>
                            <th>Nama Helper Gudang</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($list_helper_gudang as $hg){ ?>
                        <tr>  
                            <td><?php echo $no++;?></td>
                            <td><?php echo date('d-m-Y', strtotime($hg->tanggal));?></td>
                            <td><?php echo $hg->nik;?></td>  
                            <td><?php echo $hg->nmlengkap;?></td>
                            <td>
                                <a href="<?php echo site_url("trans/absensi/hapus_helper_gudang/{$hg->id_koreksi_hg}/".rawurlencode($kanwil_filter)."/{$tgl1_filter}/{$tgl2_filter}");?>" class="btn btn-danger btn-xs" onclick="return confirm('Anda yakin ingin menghapus data kehadiran ini?')"><i class="fa fa-trash-o"></i> Delete</a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL UNTUK INPUT DATA HELPER GUDANG BARU -->
<div class="modal fade" id="inputHelperGudangModal" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo site_url('trans/absensi/input_helper_gudang')?>" method="post" id="helper-gudang-form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Input Kehadiran Helper Gudang</h4>
                </div>
                <div class="modal-body">
                    <!-- Hidden fields untuk membawa parameter filter -->
                    <input type="hidden" name="kanwil_filter" value="<?php echo html_escape($kanwil_filter); ?>">
                    <input type="hidden" name="tgl1_filter" value="<?php echo html_escape($tgl1_filter); ?>">
                    <input type="hidden" name="tgl2_filter" value="<?php echo html_escape($tgl2_filter); ?>">

                    <div class="form-group">
                        <label for="tanggal">Tanggal Kehadiran</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="helpers">Pilih Helper Gudang (bisa lebih dari satu)</label>
                        <select name="helpers[]" id="select-helpers" class="form-control" multiple="multiple" required style="width: 100%;">
                            <?php foreach($list_helper_master as $helper) { ?>
                                <option value="<?php echo trim($helper->nik); ?>"><?php echo trim($helper->nmlengkap); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Load JQuery, Bootstrap, DataTable, Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    $('#table-hg').DataTable();

    // Inisialisasi Select2 untuk dropdown multi-select di dalam modal
    $('#select-helpers').select2({
        placeholder: "Pilih nama helper",
        allowClear: true
    });
});
</script>
