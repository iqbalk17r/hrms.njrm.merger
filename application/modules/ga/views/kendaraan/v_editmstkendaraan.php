<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<style>
    /*-- change navbar dropdown color --*/
    .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu {
        background-color: #008040;
        color:#ffffff;
    }

</style>
<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
        $("#example2").dataTable();
        $("#example3").dataTable();
        $("#example4").dataTable();
        $(".userpakai").selectize();
        $(".kdasuransi").selectize();
        $("#kdsubasuransi").chained('#kdasuransi');
        $("#kdsubasuransied").chained('#kdasuransied');

        //	$("#tglrange").daterangepicker();
    });

    //empty string means no validation error

</script>


<legend><?php echo $title;?></legend>
<?php //echo $message;?>
<div><a href="<?php echo site_url('ga/kendaraan/form_mstkendaraan');?>" type="button"  style="margin:10px; color:#000000;" class="btn btn-default"/><i class="fa fa-arrow-left"></i> Kembali</a>

</div>
</br>

<!-- EDIT KENDARAAN -->
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <form role="form" action="<?php echo site_url('ga/kendaraan/input_mstkendaraan');?>" method="post">
                <div class='row'>
                    <div class='col-sm-4'>
                    <div class="form-group">
                        <label for="inputsm">Nomor Rangka</label>
                        <input type="text" value="<?php echo trim($dtlmst['kdrangka']);?>" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" required readonly>
                        <input type="hidden" class="form-control input-sm" id="type" name="type" value="EDIT">
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Nomor Mesin</label>
                        <input type="text" value="<?php echo trim($dtlmst['kdmesin']);?>" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputsm">NOPOL</label>
                        <input type="text" value="<?php echo trim($dtlmst['nopol']);?>" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB" maxlength="20" >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Kode Group</label>
                        <select class="form-control input-sm" name="kdgroup" id="kdgroup" required>
                            <option value="">---PILIH KODE GROUP--</option>
                            <?php foreach($list_sckendaraan as $sc){?>
                                <option <?php if (trim($dtlmst['kdgroup'])==trim($sc->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Kode Sub Group</label>
                        <select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" required>
                            <option value="">---PILIH KODE SUB GROUP--</option>
                            <?php foreach($list_scsubkendaraan as $sc){?>
                                <option <?php if (trim($dtlmst['kdsubgroup'])==trim($sc->kdsubgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdsubgroup);?>" class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Kode Cabang</label>
                        <select class="form-control input-sm" name="kdgudang" id="kdgudang"  required>
                            <option value="">---PILIH KANTOR CABANG PENEMPATAN--</option>
                            <?php foreach($list_kanwil as $sc){?>
                                <option  <?php if (trim($dtlmst['kdgudang'])==trim($sc->loccode)) { echo 'selected';}?> value="<?php echo trim($sc->loccode);?>" ><?php echo trim($sc->loccode).' || '.trim($sc->locaname);?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Karyawan Pengguna Fasilitas</label>
                        <select class="form-control input-sm userpakai" name="userpakai" id="userpakai"  >
                            <option value="">---PILIH NIK || NAMA KARYAWAN--</option>
                            <?php foreach($list_karyawan as $sc){?>
                                <option <?php if (trim($dtlmst['userpakai'])==trim($sc->nik)) { echo 'selected';}?>  value="<?php echo trim($sc->nik);?>" ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Nama Kendaraan</label>
                        <input type="text" value="<?php echo trim($dtlmst['nmbarang']);?>" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan"  maxlength="30" >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Merk Kendaraan</label>
                        <input type="text" value="<?php echo trim($dtlmst['brand']);?>" class="form-control input-sm" id="brand" style="text-transform:uppercase" name="brand" placeholder="Merk Kendaraan"  maxlength="30" >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Nama Pemilik</label>
                        <input type="text" value="<?php echo trim($dtlmst['nmpemilik']);?>" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="50" >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Alamat Pemilik</label>
                        <textarea  class="textarea" name="addpemilik" placeholder="addpemilik"   maxlength ="100" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($dtlmst['addpemilik']);?></textarea>

                    </div>

                </div> <!---- col 1 -->
                <div class='col-sm-4'>
                    <div class="form-group">
                        <label for="inputsm">Contact Pemilik</label>
                        <input type="text" value="<?php echo trim($dtlmst['hppemilik']);?>" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada"  maxlength="30" >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">TYPE Kendaraan STNKB</label>
                        <input type="text" value="<?php echo trim($dtlmst['typeid']);?>" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20" >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Jenis Kendaraan STNKB</label>
                        <input type="text" value="<?php echo trim($dtlmst['jenisid']);?>" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20" >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Model Kendaraan STNKB</label>
                        <input type="text" value="<?php echo trim($dtlmst['modelid']);?>" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20" >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Tahun Pembuatan</label>
                        <input type="text" value="<?php echo trim($dtlmst['tahunpembuatan']);?>" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"  >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Volume Silinder</label>
                        <input type="text" value="<?php echo trim($dtlmst['silinder']);?>" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20" >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Warna Kendaraan</label>
                        <input type="text" value="<?php echo trim($dtlmst['warna']);?>" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20" >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Bahan Bakar</label>
                        <input type="text" value="<?php echo trim($dtlmst['bahanbakar']);?>" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"  >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Warna TNKB</label>
                        <input type="text" value="<?php echo trim($dtlmst['warnatnkb']);?>" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20"  >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Nomor BPKB</label>
                        <input type="text" value="<?php echo trim($dtlmst['nobpkb']);?>" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20"  >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Lokasi Dari STNKB</label>
                        <input type="text" value="<?php echo trim($dtlmst['kdlokasi']);?>" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20"  >
                    </div>
                </div> <!---- col 2 -->
                <div class='col-sm-4'>
                    <div class="form-group">
                        <label for="inputsm">Tahun Registrasi STNK</label>
                        <input type="text" value="<?php echo trim($dtlmst['tahunreg']);?>" id="tahunreg" name="tahunreg" class="form-control year"  >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
                        <input type="text" value="<?php echo date('d-m-Y', strtotime(trim($dtlmst['expstnkb'])));?>"  class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"  >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
                        <input type="text" value="<?php echo date('d-m-Y', strtotime(trim($dtlmst['exppkbstnkb'])));?>" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"  >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Nomor PKB</label>
                        <input type="text" value="<?php echo trim($dtlmst['nopkb']);?>" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" >
                    </div>
                    <!--div class="form-group">
                      <label for="inputsm">Total Nominal Pajak Kendaraan</label>
                      <input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb" value="0"  maxlength="20" >
                    </div-->
                    <div class="form-group">
                        <label for="inputsm">Pajak Progresif Ke</label>
                        <input type="number" value="<?php echo trim($dtlmst['pprogresif']);?>" class="form-control input-sm" id="pprogresif" style="text-transform:uppercase" name="pprogresif" value="0"  maxlength="20" >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Uji KIR</label>
                        <select class="form-control input-sm" name="ujikir" id="ujikir">
                            <option <?php if (trim($dtlmst['ujikir'])=='NO') { echo 'selected';}?> value="NO">TIDAK</option>
                            <option <?php if (trim($dtlmst['ujikir'])=='YES') { echo 'selected';}?> value="YES">YA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputsm">HOLD</label>
                        <select class="form-control input-sm" name="hold_item" id="hold_item">
                            <option  <?php if (trim($dtlmst['hold_item'])=='NO') { echo 'selected';}?> value="NO">TIDAK</option>
                            <option  <?php if (trim($dtlmst['hold_item'])=='YES') { echo 'selected';}?> value="YES">YA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputsm">ASURANSI</label>
                        <select class="form-control input-sm" name="asuransi" id="asuransi">
                            <option <?php if (trim($dtlmst['asuransi'])=='NO') { echo 'selected';}?> value="NO">TIDAK</option>
                            <option <?php if (trim($dtlmst['asuransi'])=='YES') { echo 'selected';}?> value="YES">YA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputsm">KODE ASURANSI</label>
                        <select class="form-control input-sm " name="kdasuransi" id="kdasuransied">
                            <option value="">-----PILIH ASURANSI JIKA ADA-----</option>
                            <?php foreach($list_asuransi as $sc){?>
                                <option  <?php if (trim($dtlmst['kdasuransi'])==trim($sc->kdasuransi)) { echo 'selected';}?>   value="<?php echo trim($sc->kdasuransi);?>" ><?php echo trim($sc->kdasuransi).' || '.trim($sc->nmasuransi);?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputsm">KODE SUB ASURANSI</label>
                        <select class="form-control input-sm " name="kdsubasuransi" id="kdsubasuransied">
                            <option value="">-----PILIH SUB ASURANSI JIKA ADA-----</option>
                            <?php foreach($list_subasuransi as $sc){?>
                                <option  <?php if (trim($dtlmst['kdsubasuransi'])==trim($sc->kdsubasuransi)) { echo 'selected';}?> value="<?php echo trim($sc->kdsubasuransi);?>" class="<?php echo trim($sc->kdasuransi);?>"><?php echo trim($sc->kdsubasuransi).' || '.trim($sc->nmsubasuransi);?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Exp Asuransi</label>
                        <input type="text" value="<?php echo date('d-m-Y', strtotime(trim($dtlmst['expasuransi'])));?>" id="expasuransi" name="expasuransi" data-date-format="dd-mm-yyyy"  class="form-control tgl"  >
                    </div>
                    <div class="form-group">
                        <label for="inputsm">Keterangan</label>
                        <textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"><?php echo trim($dtlmst['keterangan']);?></textarea>
                    </div>
                </div>
            </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </form>
</div>
</div>
</div>
<!-- END KENDARAAN --->


<script>




    //Date range picker
    $("#tgl").datepicker();
    $(".tgl").datepicker();
    $(".tglan").datepicker();
    $('.year').datepicker({
        format: " yyyy",
        viewMode: "years",
        minViewMode: "years"

    });


</script>