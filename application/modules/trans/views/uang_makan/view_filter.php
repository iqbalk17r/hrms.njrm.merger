<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />

<legend><?php echo $title;?></legend>
<div class="row">
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12">
                    <h4>Laporan Absensi Uang Makan</h4>
                </div>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <form action="<?php echo site_url('trans/uang_makan/list_um');?>" name="form" role="form" method="post">
                        <div class="form-group">
                            <label class="col-lg-3">Wilayah</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="kanwil" name="kanwil" placeholder="--- WILAYAH ---" required>
                                    <option value="" class=""></option>
                                    <?php foreach($kanwil as $v): ?>
                                        <?php $row = array_map('trim', (array)$v); ?>
                                        <option value="<?= $row['kdcabang'] ?>" data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                                <script type="text/javascript">
                                    $('#kanwil').selectize({
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
                                    });
                                    $("#kanwil").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Tanggal</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" id="tgl" name="tgl"  class="form-control pull-right" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3">Borong</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="borong" name="borong" placeholder="--- BORONG ---" required>
                                    <option value="" class=""></option>
                                    <option value="t">YA</option>
                                    <option value="f">TIDAK</option>
                                </select>
                                <script type="text/javascript">
                                    $('#borong').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        options: [],
                                        create: false,
                                        initData: true
                                    }).on('change', function() {
                                        changeCallplan();
                                    });
                                    $("#borong").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                        <div class="form-group callplan-form">
                            <label class="col-lg-3">Callplan</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="callplan" name="callplan" placeholder="--- CALLPLAN ---" required>
                                    <option value="" class=""></option>
                                    <option value="t">YA</option>
                                    <option value="f">TIDAK</option>
                                </select>
                                <script type="text/javascript">
                                    $('#callplan').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        options: [],
                                        create: false,
                                        initData: true
                                    });
                                    $("#callplan").addClass("selectize-hidden-accessible");
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <button type='submit' class='btn btn-primary pull-right'><i class="glyphicon glyphicon-search"></i> Proses</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#tgl').daterangepicker();

    function changeCallplan() {
        if($('#borong').val() == "f") {
            $('.callplan-form').show();
            $('#callplan').prop('required', true);
        } else {
            $('.callplan-form').hide();
            $('#callplan')[0].selectize.setValue("f");
            $('#callplan').prop('required', false);
        }
    }
    changeCallplan();
</script>
