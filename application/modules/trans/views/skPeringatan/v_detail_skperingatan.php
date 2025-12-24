<style>
    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        cursor: default;
    }

    .selectize-input:after {
        display: none !important;
    }
</style>

<script type="text/javascript">
    var firstLoad = true;
</script>

<legend><?= $title ?></legend>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="col-lg-6">
                    <input type="hidden" class="form-control" id="type" name="type" value="<?= $type ?>">
                    <input type="hidden" class="form-control" id="docno" name="docno" value="<?= $dtl->docno ?>">
                    <div class="form-group">
                        <label>Karyawan</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $employee->nik.' | '.$employee->nmlengkap ?>" disabled>

                    </div>
                    <div class="form-group">
                        <label>Departemen</label>
                        <input type="text" class="form-control" id="department" name="department" placeholder="DEPARTEMEN" value="<?php echo $employee->nmdept ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="JABATAN" value="<?php echo $employee->nmjabatan ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Atasan 1</label>
                        <input type="text" class="form-control" id="atasan1" name="atasan1" placeholder="ATASAN 1" value="<?php echo $employee->nmatasan ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Atasan 2</label>
                        <input type="text" class="form-control" id="atasan2" name="atasan2" placeholder="ATASAN 2" value="<?php echo $employee->nmatasan2 ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" id="alamattinggal" name="alamattinggal" placeholder="ALAMAT"  disabled style="resize: none;" rows="3"><?php echo $employee->alamattinggal ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Kontak</label>
                        <input type="text" class="form-control" id="nohp1" name="nohp1" placeholder="KONTAK" value="<?php echo $employee->mergephone ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="EMAIL" value="<?php echo $employee->email ?>" disabled>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Dokumen</label>
                        <input type="text" class="form-control" value="<?= $dtl->docno ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Awal s/d Tanggal Selesai</label>
                        <input type="text" class="form-control" id="startdate" name="startdate" placeholder="TANGGAL" value="<?= $dtl->startdatex ?>" disabled>
                    </div>
                    <div class="form-group tindakan">
                        <label>Kategori SP</label>
                        <input type="text" class="form-control" id="tindakan" name="tindakan" placeholder="Kategori SP" value="<?= $dtl->spname ?>" disabled>
                    </div>
                    <div class="form-group tindakan">
                        <label>Dokumen Referensi SP</label>
                        <input type="text" class="form-control" id="docref" name="docref" placeholder="DOKUMEN REFERENSI SP" value="<?= $dtl->docref ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Keterangan Peringatan / Alasan Teguran</label>
                        <textarea class="form-control" id="description" name="description" placeholder="KETERANGAN PERINGATAN / ALASAN TEGURAN" style=" resize: none;" rows="5" disabled><?= $dtl->description ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Solusi / Perbaikan</label>
                        <textarea class="form-control" id="solusi" name="solusi" placeholder="SOLUSI / PERBAIKAN" style=" resize: vertical;" rows="5" disabled><?= $dtl->solusi ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="uploadFile">Dokumen Pendukung</label>
                        <br>
                        <?php if($dtl->att_name == ''): ?>
                            tidak tersedia
                        <?php else: ?>
                            <a href="#" onclick="window.open('<?= site_url('assets/files/skperingatan') . '/' . $dtl->att_name; ?>')"><?= $dtl->att_name ?></a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <a href="<?php echo site_url('trans/skperingatan') ?>" class="btn btn-default" style="margin: 10px 5px;" type="button">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
