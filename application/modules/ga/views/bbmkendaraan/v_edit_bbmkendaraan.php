<?php
//    echo number_format(trim($dtlmst['hargasatuan']), 2, ',', '.');die();
?>
<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />

<style>
    /*-- change navbar dropdown color --*/
    .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu {
        background-color: #008040;
        color: #ffffff;
    }

    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        cursor: default;
    }
</style>

<script type="text/javascript">
    function isNumberKey(evt) {
        var e = evt || window.event; // for trans-browser compatibility
        var charCode = e.which || e.keyCode;
        if (charCode > 31 && (charCode < 47 || charCode > 57))
            return false;
        if (e.shiftKey) return false;
        return true;
    }

    function calculateTotal() {
        if("<?= trim($dtlmst['bahanbakar']) ?>" != "BENSIN") {
            setTimeout(function() {
                var hargasatuan = $('#hargasatuan').val().toString().replace(",00", "").replace(".", "");
                var liters = $('#liters').val().replace(",", ".");
                var ttlvalue = +(hargasatuan * liters).toFixed(0) + ',00';
                $('#ttlvalue').val(ttlvalue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            });
        }
    }

    var firstLoad = true;
</script>
</br>

<legend><?php echo $title;?></legend>
</br>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
            <form role="form" action="<?php echo site_url('ga/bbmkendaraan/save_bbmkendaraan');?>" method="post">
			    <div class="box-body">
					<div class='row'>
                        <div class='col-sm-4'>
						    <div class="form-group">
                                <label for="inputsm">Nomor Rangka</label>
                                <input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($dtlmst['kdrangka']) ;?>" readonly>
                                <input type="hidden" class="form-control input-sm" id="type" name="type" value="EDITBBMKENDARAAN">
						    </div>
						    <div class="form-group">
                                <label for="inputsm">Nomor Mesin</label>
                                <input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" value="<?php echo trim($dtlmst['kdmesin']) ;?>" readonly>
                                <input type="hidden" class="form-control input-sm" id="stockcode" style="text-transform:uppercase" name="stockcode" value="<?php echo trim($dtlmst['stockcode']) ;?>" readonly>
						    </div>
						    <div class="form-group">
                                <label for="inputsm">NOPOL</label>
                                <input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB" value="<?php echo trim($dtlmst['nopol']) ;?>" maxlength="20" readonly>
						    </div>
						    <div class="form-group">
                                <label for="inputsm">Nama Kendaraan</label>
                                <input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan" value="<?php echo trim($dtlmst['nmbarang']) ;?>" maxlength="30" readonly>
						    </div>
						    <div class="form-group">
                                <label for="inputsm">Nama Pemilik</label>
                                <input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="30" value="<?php echo trim($dtlmst['nmpemilik']) ;?>" readonly>
						    </div>
						    <div class="form-group">
                                <label for="inputsm">Alamat Pemilik</label>
                                <input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  value="<?php echo trim($dtlmst['addpemilik']) ;?>" maxlength="100" readonly>
						    </div>
						</div>
						<div class='col-sm-4'>
                            <div class="form-group">
                                <label for="inputsm">Tanggal Input</label>
                                <input type="text" class="form-control input-sm" id="docdate" style="text-transform:uppercase" name="docdate" value="<?php echo date('d-m-Y', strtotime(trim($dtlmst['docdate']))) ;?>"  placeholder="Tanggal Input" data-date-format="dd-mm-yyyy" readonly>
                            </div>
                            <?php if(trim($dtlmst['bahanbakar']) != 'BENSIN'): ?>
                                <div class="form-group">
                                    <label for="inputsm">Bahan Bakar</label>
                                    <select class="form-control input-sm" name="bahanbakar" id="bahanbakar" placeholder="---KETIK JENIS BAHAN BAKAR---" required>
                                        <option value="" class=""></option>
                                        <?php foreach($jenisbbm as $v): ?>
                                            <?php $result = array_map('trim', $v); ?>
                                            <option value="<?= $v['kdjenisbbm'] ?>" data-data='<?= json_encode($result, JSON_FORCE_OBJECT) ?>'></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <script type="text/javascript">
                                    $('#bahanbakar').selectize({
                                        plugins: ['hide-arrow', 'selectable-placeholder'],
                                        valueField: 'kdjenisbbm',
                                        labelField: 'nmjenisbbm',
                                        searchField: ['nmjenisbbm'],
                                        options: [],
                                        create: false,
                                        initData: true,
                                        render: {
                                            option: function(item, escape) {
                                                return '' +
                                                    '<div class=\'row\'>' +
                                                        '<div class=\'col-xs-6 col-md-6 text-nowrap\'>' + escape(item.nmjenisbbm) + '</div>' +
                                                        '<div class=\'col-xs-6 col-md-6 text-nowrap\'>' + escape(item.hargasatuan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")) + '</div>' +
                                                    '</div>' +
                                                '';
                                            }
                                        }
                                    }).on('change', function() {
                                        if($('#bahanbakar').val() != '') {
                                            var hargasatuan = $('#bahanbakar')[0].selectize.options[$('#bahanbakar').val()].hargasatuan;
                                            // $('#hargasatuan').val(hargasatuan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                                            $('#hargasatuan').val(hargasatuan.toString().replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                                        } else {
                                            $('#hargasatuan').val('0');
                                        }
                                        calculateTotal();
                                    });
                                    $("#bahanbakar").addClass("selectize-hidden-accessible");
                                </script>
                            <?php else: ?>
                                <div class="form-group">
                                    <label for="inputsm">Bahan Bakar</label>
                                    <input type="text" class="form-control input-sm" id="bahanbakar" name="bahanbakar"  value="<?php echo trim($dtlmst['bahanbakar']);?>" style="text-transform:uppercase" readonly>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="inputsm">Harga Satuan</label>
                                <input type="text" class="form-control input-sm text-right" id="hargasatuan" name="hargasatuan"  value="<?php echo number_format(trim($dtlmst['hargasatuan']), 2, ',', '.');?>" style="text-transform:uppercase" maxlength="8" readonly>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Liters</label>
                                <input type="text" class="form-control input-sm text-right fikyseparator" id="liters" name="liters"  value="<?php echo number_format(trim($dtlmst['liters']), 2,',','.');?>" style="text-transform:uppercase"  placeholder="Liter" maxlength="8" required onchange="calculateTotal()" onkeyup="calculateTotal()">
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Kode Kupon</label>
                                <input type="text" class="form-control input-sm" id="kupon" name="kupon" value="<?php echo trim($dtlmst['docref']);?>" style="text-transform:uppercase"  placeholder="Isi Kode Kupon Bila Ada" maxlength="20">
                            </div>
						    <div class="form-group">
                                <label for="inputsm">Kilometer Awal</label>
                                <input type="text" class="form-control input-sm text-right fikyseparator" id="km_awal" name="km_awal" style="text-transform:uppercase" value="<?php echo number_format(trim($dtlmst['km_awal']), 0,',','.');?>" placeholder="KM Awal" maxlength="50" required onkeypress='return isNumberKey(event)'>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Kilometer Akhir</label>
                                <input type="text" class="form-control input-sm text-right fikyseparator" id="km_akhir" style="text-transform:uppercase" name="km_akhir"  value="<?php echo number_format(trim($dtlmst['km_akhir']), 0,',','.');?>" placeholder="KM Akhir" maxlength="50" required onkeypress='return isNumberKey(event)'>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Total Biaya</label>
                                <input type="text" class="form-control input-sm text-right fikyseparator" id="ttlvalue" name="ttlvalue" style="text-transform:uppercase" value="<?php echo number_format(trim($dtlmst['ttlvalue']), trim($dtlmst['bahanbakar']) != "BENSIN" ? 2 : 0,',','.');?>"  placeholder="Total Biaya Penggunaan Bahan Bakar" maxlength="12" <?= trim($dtlmst['bahanbakar']) != "BENSIN" ? "readonly" : "required" ?>>
                            </div>
                        </div>
						<div class='col-sm-4'>
                            <div class="form-group">
                                <label for="inputsm">Kode Kategori Supplier</label>
                                <select class="form-control input-sm" name="kdgroupsupplier" id="kdgroupsupplier" placeholder="---KETIK KODE / NAMA KATEGORI SUPPLIER---" required>
                                    <option value="" class=""></option>
                                    <?php foreach($kategorisupplier as $v): ?>
                                        <?php $result = array_map('trim', $v); ?>
                                        <option value="<?= $v['kdjsupplier'] ?>" data-data='<?= json_encode($result, JSON_FORCE_OBJECT) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <script type="text/javascript">
                                $('#kdgroupsupplier').selectize({
                                    plugins: ['hide-arrow', 'selectable-placeholder'],
                                    valueField: 'kdjsupplier',
                                    labelField: 'nmjsupplier',
                                    searchField: ['kdjsupplier', 'nmjsupplier'],
                                    options: [],
                                    create: false,
                                    initData: true,
                                    render: {
                                        option: function(item, escape) {
                                            return '' +
                                                '<div class=\'row\'>' +
                                                    '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.kdjsupplier) + '</div>' +
                                                    '<div class=\'col-xs-10 col-md-10 text-nowrap\'>' + escape(item.nmjsupplier) + '</div>' +
                                                '</div>' +
                                            '';
                                        }
                                    }
                                }).on('change', function() {
                                    if(!firstLoad) {
                                        $('#kdsupplier')[0].selectize.clearOptions();
                                        $.ajax({
                                            url: "get_supplier",
                                            type: "post",
                                            data: {
                                                kdgroup: $('#kdgroupsupplier').val()
                                            },
                                            dataType: 'json',
                                            success: function (data) {
                                                for (var i = 0; i < data.length; i++) {
                                                    $('#kdsupplier')[0].selectize.addOption({
                                                        kdsupplier: data[i].kdsupplier,
                                                        nmsupplier: data[i].nmsupplier
                                                    });
                                                }
                                            }
                                        });
                                    }
                                });
                                $("#kdgroupsupplier").addClass("selectize-hidden-accessible");
                            </script>
                            <div class="form-group">
                                <label for="inputsm">Kode Supplier</label>
                                <select class="form-control input-sm " name="kdsupplier" id="kdsupplier" placeholder="---KETIK KODE / PILIH SUPPLIER---"  required>
                                    <option value="" class=""></option>
                                    <?php foreach($supplier as $v): ?>
                                        <?php $result = array_map('trim', $v); ?>
                                        <option value="<?= $v['kdsupplier'] ?>" data-data='<?= json_encode($result, JSON_FORCE_OBJECT) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <script type="text/javascript">
                                $('#kdsupplier').selectize({
                                    plugins: ['hide-arrow', 'selectable-placeholder'],
                                    valueField: 'kdsupplier',
                                    labelField: 'nmsupplier',
                                    searchField: ['kdsupplier', 'nmsupplier'],
                                    options: [],
                                    create: false,
                                    initData: true,
                                    render: {
                                        option: function(item, escape) {
                                            return '' +
                                                '<div class=\'row\'>' +
                                                    '<div class=\'col-xs-3 col-md-3 text-nowrap\'>' + escape(item.kdsupplier) + '</div>' +
                                                    '<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nmsupplier) + '</div>' +
                                                '</div>' +
                                            '';
                                        }
                                    }
                                }).on('change click', function() {
                                    if(!firstLoad) {
                                        $('#kdsubsupplier')[0].selectize.clearOptions();
                                        $.ajax({
                                            url: "get_subsupplier",
                                            type: "post",
                                            data: {
                                                kdsupplier: $('#kdsupplier').val()
                                            },
                                            dataType: 'json',
                                            success: function (data) {
                                                for (var i = 0; i < data.length; i++) {
                                                    $('#kdsubsupplier')[0].selectize.addOption({
                                                        kdsubsupplier: data[i].kdsubsupplier,
                                                        nmsubsupplier: data[i].nmsubsupplier
                                                    });
                                                }
                                            }
                                        });
                                        firstLoad = !firstLoad;
                                    }
                                });
                                $("#kdsupplier").addClass("selectize-hidden-accessible");
                            </script>
                            <div class="form-group ">
                                <label>Kode Sub Supplier</label>
                                <select class="form-control input-sm ch" name="kdsubsupplier" id="kdsubsupplier"  placeholder="---KETIK KODE / NAMA SUB SUPPLIER---" required>
                                    <option value="" class=""></option>
                                    <?php foreach($subsupplier as $v): ?>
                                        <?php $result = array_map('trim', $v); ?>
                                        <option value="<?= $v['kdsubsupplier'] ?>" data-data='<?= json_encode($result, JSON_FORCE_OBJECT) ?>'></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <script type="text/javascript">
                                $('#kdsubsupplier').selectize({
                                    plugins: ['hide-arrow', 'selectable-placeholder'],
                                    valueField: 'kdsubsupplier',
                                    labelField: 'nmsubsupplier',
                                    searchField: ['kdsubsupplier', 'nmsubsupplier'],
                                    options: [],
                                    create: false,
                                    initData: true,
                                    render: {
                                        option: function(item, escape) {
                                            return '' +
                                                '<div class=\'row\'>' +
                                                    '<div class=\'col-xs-3 col-md-3 text-nowrap\'>' + escape(item.kdsubsupplier) + '</div>' +
                                                    '<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nmsubsupplier) + '</div>' +
                                                '</div>' +
                                            '';
                                        }
                                    }
                                });
                                $("#kdsubsupplier").addClass("selectize-hidden-accessible");
                            </script>
                            <div class="form-group">
                                <label for="inputsm">Keterangan</label>
                                <textarea  class="textarea" name="description" placeholder="Keterangan" maxlength ="159" style="text-transform: uppercase; width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($dtlmst['description']);?></textarea>
                            </div>
						</div>
					</div>
                </div>
                <div class="box-footer text-right">
                    <a href="<?php echo site_url('ga/bbmkendaraan/clear_bbmkendaraan');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
		</div>
	</div>
</div>

<script type="text/javascript">
    if("<?= trim($dtlmst['bahanbakar']) ?>" != "BENSIN") {
        $('#bahanbakar')[0].selectize.setValue("<?= trim($dtlmst['bahanbakar']) ?>");
    }
    $('#kdgroupsupplier')[0].selectize.setValue("<?= trim($dtlmst['kdgroup']) ?>");
    $('#kdsupplier')[0].selectize.setValue("<?= trim($dtlmst['suppcode']) ?>");
    $('#kdsubsupplier')[0].selectize.setValue("<?= trim($dtlmst['subsuppcode']) ?>");
</script>
