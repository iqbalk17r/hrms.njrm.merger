<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />

<legend><?php echo $title;?></legend>
<div class="row">
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12">
                    <h4><?php echo $title;?></h4>
                </div>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <form action="<?php echo site_url('trans/bbm/list_bbm');?>" name="form" role="form"
                        method="post">
                        <div class="form-group">
                            <label class="col-lg-3">Wilayah</label>
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="kanwil" name="kanwil"
                                    placeholder="--- WILAYAH ---" required>
                                    <option value="" class=""></option>
                                    <?php foreach($kanwil as $v): ?>
                                    <?php $row = array_map('trim', (array)$v); ?>
                                    <option value="<?= $row['kdcabang'] ?>"
                                        data-data='<?= json_encode($row, JSON_HEX_APOS) ?>'></option>
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
                                                '<div class=\'col-md-3 text-nowrap\'>' + escape(item
                                                    .kdcabang) + '</div>' +
                                                '<div class=\'col-md-9 text-nowrap\'>' + escape(item
                                                    .desc_cabang) + '</div>' +
                                                '</div>' +
                                                '';
                                        },
                                        item: function(item, escape) {
                                            return '' +
                                                '<div>' +
                                                escape(item.kdcabang) + ' - ' +
                                                escape(item.desc_cabang) +
                                                '</div>';
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
                                    <input type="text" id="tgl" name="tgl" class="form-control pull-right" required>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group callplan-form">
                            <div class="col-lg-9">
                                <select class="form-control input-sm" id="callplan" name="callplan" required>
                                    <option value="t">YA</option>
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
                        </div> -->
                        <div class="form-group">
                            <div class="col-lg-12">
                                <button type='submit' class='btn btn-primary pull-right'><i
                                        class="glyphicon glyphicon-search"></i> Proses</button>
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
</script>