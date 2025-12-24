<legend><?php echo $title;?></legend>

<div class="row">
    <div class="col-xs-6">
        <?php echo $message;?>
        <div class="box">
            <div class="box-header">

            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <form action="<?php echo site_url('trans/absensi/input_data');?>" name="form" role="form" method="post">
                        <div class="form-group">
                            <label class="col-lg-3">Tanggal Tarikan Terakhir</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="input" id="tglakhir" name="tglakhir"  class="form-control pull-right" readonly>
                                </div><!-- /.input group -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Wilayah</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="kdcabang" name="kdcabang" placeholder="--- WILAYAH ---" required>
                                    <option value="" class=""></option>
                                    <?php foreach($list_kanwil as $v): ?>
                                        <?php $row = array_map('trim', (array)$v); ?>
                                        <option value="<?= $row['kdcabang'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
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
                                            url : "<?php echo site_url('trans/absensi/ajax_tglakhir_ci')?>/" + cabang,
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
                        <?php if($akses['aksesview']=='t') { ?>
                            <div class="form-group">
                                <label class="col-lg-3">Tanggal</label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="tgl" name="tgl"  data-date-format="yyyy-mm-dd" class="form-control pull-right">
                                    </div><!-- /.input group -->
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-12">
                                    <button type='submit' class='btn btn-primary pull-right'><i class="glyphicon glyphicon-search"></i> Proses</button>
                                </div>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //Date range picker
    $('#tgl').daterangepicker();
</script>
