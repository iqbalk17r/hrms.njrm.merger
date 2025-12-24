<legend>
    <?php echo $title; ?>
</legend>
<div style="padding-bottom: 20px;">
    <a href="<?php echo site_url('pk/pk/download_template_kpi') ?>" class="btn btn-success">Download Template
        Import KPI</a>
</div>
<?php echo $message; ?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <form action="<?php echo site_url('pk/pk/import_kpi') ?>" method="post" enctype="multipart/form-data"
                role="form">
                <div class="box-body">

                    <div class="form-group">
                        <label for="exampleInputFile">File input Data KPI</label>
                        <input type="file" id="import" name="import" required>
                        <p class="help-block">Data Harus Berextensi xls (ms office 2003/Kingsoft 7/Open Office 2.x) atau
                            xlsx (ms office 2007/Kingsoft 2013/Open Office 3.x). Silahkan download template import KPI pada tombol diatas.</p>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" required> Saya Bertanggung Jawab atas data yang saya Upload ke Sistem
                        </label>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" value="Import" name="save" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div><!-- /.box -->
    </div>
</div>