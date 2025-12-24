<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <?php if(in_array(trim($this->session->userdata('nama')), array('ARBI', 'RANDY', 'BAGOS'))): ?>
                    <button class="btn btn-default"data-toggle="modal" data-target="#filter_option"><i class="fa fa-gear"></i></button>
                <?php endif; ?>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <form action="<?php echo site_url('trans/absensi/show_mobile_attendance');?>" name="form" role="form" method="post">
                        <div class="form-group">
                            <label class="col-lg-3">Tanggal Tarikan Terakhir</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="input" id="tglakhir" name="tglakhir"  class="form-control pull-right" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Wilayah</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="kdcabang" name="kdcabang" placeholder="--- WILAYAH ---" required>
                                    <option value="" class=""></option>
                                    <?php foreach($list_kanwil as $v): ?>
                                        <?php $result = array_map("trim", (array)$v); ?>
                                        <option value="<?= $result['kdcabang'] ?>" data-data='<?= json_encode($result, JSON_HEX_APOS) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                                <script type="text/javascript">
                                    $('#kdcabang').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'kdcabang',
                                        searchField: ['kdcabang', 'desc_cabang'],
                                        options: [],
                                        create: false,
                                        initData: true,
                                        render: {
                                            option: function(item, escape) {
                                                return '' +
                                                    '<div class=\'row\'>' +
                                                        '<div class=\'col-md-3 text-nowrap\'>' + escape(item.kdcabang) + '</div>' +
                                                        '<div class=\'col-md-9 text-nowrap\'>' + escape(item.desc_cabang) + '</div>' +
                                                    '</div>' +
                                                '';
                                            },
                                            item: function(item, escape) {
                                                return '' +
                                                    '<div>' +
                                                        escape(item.kdcabang) + ' - ' +
                                                        escape(item.desc_cabang) +
                                                    '</div>'
                                                ;
                                            }
                                        }
                                    }).on('change', function() {
                                        var cabang = $('#kdcabang').val();

                                        $.ajax({
                                            url : "<?= site_url('trans/absensi/ajax_tglakhir_mobile_cabang') ?>/" + cabang,
                                            type: "GET",
                                            dataType: "JSON",
                                            success: function(data) {
                                                $('[name="tglakhir"]').val(data.lastdate);
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                                alert('Error get data from ajax');
                                            }
                                        });
                                    });
                                    $("#kdcabang").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Aplikasi Mobile</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="maplikasi" name="maplikasi" placeholder="--- APLIKASI MOBILE ---" required>
                                    <option value="" class=""></option>
                                    <option value="MCRM">MOBILE CRM</option>
                                    <option value="MABS">MOBILE ABSENSI</option>
                                </select>
                                <script type="text/javascript">
                                    $('#maplikasi').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        options: [],
                                        create: false,
                                        initData: true
                                    });
                                    $("#maplikasi").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                        <?php if($akses['aksesconvert'] == 't') { ?>
                            <div class="form-group">
                                <label class="col-lg-3">Tanggal</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="tgl" name="tgl"  class="form-control pull-right">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <button type='submit' class='btn btn-primary pull-right' ><i class="glyphicon glyphicon-search"></i> Proses</button>
                                </div>
                            </div>
                        <?php } else { echo 'anda tidak diperkenankan mengakses modul ini!!!!';} ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="filter_option" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> SETTING OPTION PENGATURAN SERVER DIRECT </h4>
            </div>
            <form action="<?php echo site_url('trans/absensi/save_option')?>" method="post" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">BRANCH</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="branch" id="branch" value="<?php echo trim($dtl_opt['branch']); ?>" class="form-control input-sm ratakanan" required >
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">HOST ADDRESS</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="c_hostaddr" id="c_hostaddr" value="<?php echo trim(base64_decode($dtl_opt['c_hostaddr'])); ?>" class="form-control input-sm ratakanan" required >
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">DB NAME</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="c_dbname" id="c_dbname" value="<?php echo trim(base64_decode($dtl_opt['c_dbname'])); ?>" class="form-control input-sm ratakanan" required >
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">USERDB</label>
                                            <div class="col-sm-8">
                                                <input type="password" name="c_userpg" id="c_userpg" value="" class="form-control input-sm ratakanan" required >
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PASSDB</label>
                                            <div class="col-sm-8">
                                                <input type="password" name="c_passpg" id="c_passpg" value="" class="form-control input-sm ratakanan" required >
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">KETERANGAN</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="description" id="description" value="<?php echo trim($dtl_opt['description']); ?>" class="form-control input-sm ratakanan" required >
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit"  class="btn btn-success">SIMPAN</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script>
    //Date range picker
    $('#tgl').daterangepicker();
</script>
