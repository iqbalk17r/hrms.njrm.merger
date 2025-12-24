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

    .selectize-input:after {
        display: none !important;
    }
</style>
</br>

<legend><?php echo $title;?></legend>
</br>


<div class="row">
	<div class="col-xs-12">
		<div class="box">
            <div class="box-body">
                <div class='row'>
                    <div class='col-sm-4'>
                        <div class="form-group">
                            <label for="inputsm">Nomor Rangka</label>
                            <input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" value="<?php echo trim($dtlmst['kdrangka']) ;?>" readonly>
                            <input type="hidden" class="form-control input-sm" id="type" name="type" value="APPROVALBBMKENDARAAN">
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
                            <input type="text" class="form-control input-sm tgl" id="docdate" style="text-transform:uppercase" name="docdate" value="<?php echo date('d-m-Y', strtotime(trim($dtlmst['docdate']))) ;?>"  placeholder="Tanggal Input" data-date-format="dd-mm-yyyy" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Bahan Bakar</label>
                            <input type="text" class="form-control input-sm " id="bahanbakar" name="bahanbakar" style="text-transform:uppercase" value="<?php echo trim($dtlmst['nmbahanbakar']);?>" placeholder="Bahan Bakar" maxlength="50" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Harga Satuan</label>
                            <input type="text" class="form-control input-sm text-right" id="hargasatuan" name="hargasatuan"  value="<?php echo number_format(trim($dtlmst['hargasatuan']), 2, ',', '.');?>" style="text-transform:uppercase" maxlength="8" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Liters</label>
                            <input type="text" class="form-control input-sm text-right" id="liters" name="liters"  value="<?php echo number_format(trim($dtlmst['liters']), 2, ',', '.');?>" style="text-transform:uppercase"  placeholder="Liter" maxlength="8" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Kode Kupon</label>
                            <input type="text" class="form-control input-sm" id="kupon" name="kupon" value="<?php echo trim($dtlmst['docref']);?>" style="text-transform:uppercase" maxlength="20" readonly>
                        </div>
                         <div class="form-group">
                            <label for="inputsm">Kilometer Awal</label>
                            <input type="number" class="form-control input-sm text-right" id="km_awal" name="km_awal" style="text-transform:uppercase" value="<?php echo number_format(trim($dtlmst['km_awal']), 0, ',', '.');?>" placeholder="KM Awal" maxlength="50" readonly>
                          </div>
                          <div class="form-group">
                            <label for="inputsm">Kilometer Akhir</label>
                            <input type="number" class="form-control input-sm text-right" id="km_akhir" style="text-transform:uppercase" name="km_akhir"  value="<?php echo number_format(trim($dtlmst['km_akhir']), 0, ',', '.');?>" placeholder="KM Akhir" data-date-format="dd-mm-yyyy" readonly>
                          </div>
                        <div class="form-group">
                            <label for="inputsm">Total Biaya</label>
                            <input type="text" class="form-control input-sm text-right" id="ttlvalue" name="ttlvalue" style="text-transform:uppercase" value="<?php echo number_format(trim($dtlmst['ttlvalue']), 2, ',', '.');?>"  placeholder="Total Biaya Penggunaan Bahan Bakar" maxlength="12" readonly>
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        <div class="form-group">
                            <label for="inputsm">Kode Kategori Supplier</label>
                            <select class="form-control input-sm" name="kdgroupsupplier" id="kdgroupsupplier"  placeholder="---KETIK KODE / NAMA JENIS SUPPLIER---" disabled>
                                <option value="<?php echo trim($dtlmst['kdgroup']);?>" class=""><?php echo trim($dtlmst['nmgroup']);?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Kode Supplier</label>
                            <select class="form-control input-sm " name="kdsupplier" id="kdsupplier"   placeholder="---KETIK KODE / PILIH SUPPLIER---"  disabled>
                                <option value="<?php echo trim($dtlmst['suppcode']);?>" class=""><?php echo trim($dtlmst['nmsupplier']);?></option>
                            </select>
                        </div>
                        <div class="form-group ">
                            <label>Kode Sub Supplier</label>
                            <select class="form-control input-sm ch" name="kdsubsupplier" id="kdsubsupplier" placeholder="---KETIK KODE / NAMA SUPPLIER---" disabled>
                                <option value="<?php echo trim($dtlmst['subsuppcode']);?>" class=""><?php echo trim($dtlmst['nmsubsupplier']);?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputsm">Keterangan</label>
                            <textarea  class="textarea" name="description" placeholder="Keterangan" maxlength ="159" style="text-transform: uppercase; width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px; background-color: #eeeeee; border-color: #cccccc;" disabled><?php echo trim($dtlmst['description']);?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer text-right">
                <a href="<?php echo site_url('ga/bbmkendaraan/form_bbmkendaraan');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/> Kembali</a>
            </div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $('#kdgroupsupplier').selectize();
    $('#kdsupplier').selectize();
    $('#kdsubsupplier').selectize();
</script>
