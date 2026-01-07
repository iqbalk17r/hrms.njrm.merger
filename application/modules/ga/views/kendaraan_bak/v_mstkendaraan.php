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
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
<?php echo $message;?>

<div class="row">
    <!--div class="col-sm-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Kendaraan</button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
    </div--->
    <div class="col-sm-3">
        <!--div class="container"--->
        <div class="dropdown ">
            <button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
                <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Kendaraan</a></li>
                <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("trans/cuti_karyawan/listkaryawan_iss")?>">Input Cuti</a></li-->
                <!--li role="presentation" class="divider"></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Haduh Us</a></li--->
            </ul>
        </div>
        <!--/div-->
    </div><!-- /.box-header -->

</div>
</br>
<div class="col-sm-12">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <legend><?php echo $title;?></legend>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                    <table id="example1" class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th width="2%">No.</th>
                            <th>KODE KENDARAAN</th>
                            <th>NAMA KENDARAAN</th>
                            <th>NOPOL</th>
                            <th>BASE</th>
                            <th>BERLAKU STNKB</th>
                            <th>BERLAKU PKB STNKB</th>
                            <th>KIR</th>
                            <th>ASURANSI</th>
                            <th>HOLD</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=0; foreach($list_mstkendaraan as $row): $no++;?>
                            <tr>

                                <td width="2%"><?php echo $no;?></td>
                                <td><?php echo $row->nodok;?></td>
                                <td><?php echo $row->nmbarang;?></td>
                                <td><?php echo $row->nopol;?></td>
                                <td><?php echo $row->locaname;?></td>
                                <td><?php echo $row->expstnkb;?></td>
                                <td><?php echo $row->exppkbstnkb;?></td>
                                <td><?php echo $row->ujikir;?></td>
                                <td><?php echo $row->asuransi;?></td>
                                <td><?php echo $row->hold_item;?></td>
                                <td width="10%">
                                    <a href="<?php
                                    $enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
                                    echo site_url('ga/kendaraan/cv_edit_mstkendaraan').'/'.$enc_nodok;?>" class="btn btn-primary  btn-sm" title="Ubah Data Master Kendaraan">	<i class="fa fa-gear"></i> </a>
                                    <?php /*
                                    <a href="<?php
                                    $enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
                                    echo site_url('ga/kendaraan/cv_delete_mstkendaraan').'/'.$enc_nodok;?>" class="btn btn-danger  btn-sm" title="Hapus Data Master Kendaraan">	<i class="fa fa-trash-o"></i> </a>
                                    */ ?>
                                    <a href="<?php
                                    $enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
                                    echo site_url('ga/kendaraan/cv_detail_mstkendaraan').'/'.$enc_nodok;?>" class="btn btn-default  btn-sm" title="Detail Data Master Kendaraan">	<i class="fa fa-bars"></i> </a>


                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</div>

<!-- Modal Input Master Kendaraan & STNKB -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">INPUT KENDARAAN SESUAI STNK</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="<?php echo site_url('ga/kendaraan/input_mstkendaraan');?>" method="post">
                    <div class='row'>
                        <div class='col-sm-4'>
                            <div class="form-group">
                                <label for="inputsm">Nomor Rangka</label>
                                <input type="text" class="form-control input-sm" id="kdrangka" name="kdrangka" style="text-transform:uppercase" placeholder="Nomor Rangka Dari STNKB" maxlength="25" required>
                                <input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Nomor Mesin</label>
                                <input type="text" class="form-control input-sm" id="kdmesin" style="text-transform:uppercase" name="kdmesin" placeholder="Nomor Mesin Dari STNKB" maxlength="25" required>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">NOPOL</label>
                                <input type="text" class="form-control input-sm" id="nopol" style="text-transform:uppercase" name="nopol" placeholder="Nomor Nopol Dari STNKB" maxlength="20" >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Kode Group</label>
                                <select class="form-control input-sm" name="kdgroup" id="kdgroup" required>
                                    <option value="">---PILIH KODE GROUP--</option>
                                    <?php foreach($list_sckendaraan as $sc){?>
                                        <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Kode Sub Group</label>
                                <select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" required>
                                    <option value="">---PILIH KODE SUB GROUP--</option>
                                    <?php foreach($list_scsubkendaraan as $sc){?>
                                        <option value="<?php echo trim($sc->kdsubgroup);?>" class="<?php echo trim($sc->kdgroup);?>"><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Kode Cabang</label>
                                <select class="form-control input-sm" name="kdgudang" id="kdgudang"  required>
                                    <option value="">---PILIH KANTOR GUDANG CABANG PENEMPATAN--</option>
                                    <?php foreach($list_kanwil as $sc){?>
                                        <option value="<?php echo trim($sc->loccode);?>" ><?php echo trim($sc->loccode).' || '.trim($sc->locaname);?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Karyawan Pengguna Fasilitas</label>
                                <select class="form-control input-sm userpakai" name="userpakai" id="userpakai"  >
                                    <option value="">---PILIH NIK || NAMA KARYAWAN--</option>
                                    <?php foreach($list_karyawan as $sc){?>
                                        <option value="<?php echo trim($sc->nik);?>" ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Nama Kendaraan</label>
                                <input type="text" class="form-control input-sm" id="nmkendaraan" style="text-transform:uppercase" name="nmkendaraan" placeholder="Nama Kendaraan"  maxlength="30" >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Merk Kendaraan</label>
                                <input type="text" class="form-control input-sm" id="brand" style="text-transform:uppercase" name="brand" placeholder="Merk Kendaraan"  maxlength="30" >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Nama Pemilik</label>
                                <input type="text" class="form-control input-sm" id="nmpemilik" style="text-transform:uppercase" name="nmpemilik" placeholder="Nama Pemilik" maxlength="50" >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Alamat Pemilik</label>

                                <input type="text" class="form-control input-sm" id="addpemilik" style="text-transform:uppercase" name="addpemilik" placeholder="Alamat Pemilik"  maxlength="100" >
                            </div>

                        </div> <!---- col 1 -->
                        <div class='col-sm-4'>
                            <div class="form-group">
                                <label for="inputsm">Contact Pemilik</label>
                                <input type="number" class="form-control input-sm" id="hppemilik" style="text-transform:uppercase" name="hppemilik" placeholder="No HP Pemilik Jika Ada"  maxlength="30" >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">TYPE Kendaraan STNKB</label>
                                <input type="text" class="form-control input-sm" id="typeid" name="typeid" style="text-transform:uppercase" placeholder="Type Kendaraan Di STNKB" maxlength="20" >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Jenis Kendaraan STNKB</label>
                                <input type="text" class="form-control input-sm" id="jenisid" style="text-transform:uppercase" name="jenisid" placeholder="Jenis Kendaraan Di STNKB" maxlength="20" >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Model Kendaraan STNKB</label>
                                <input type="text" class="form-control input-sm" id="modelid" style="text-transform:uppercase" name="modelid" placeholder="Model Kendaraan Di STNKB" maxlength="20" >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Tahun Pembuatan</label>
                                <input type="text" id="tahunpembuatan" name="tahunpembuatan" class="form-control year"  >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Volume Silinder</label>
                                <input type="text" class="form-control input-sm" id="silinder" style="text-transform:uppercase" name="silinder" placeholder="Silinder CC di STNKB"  maxlength="20" >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Warna Kendaraan</label>
                                <input type="text" class="form-control input-sm" id="warna" style="text-transform:uppercase" name="warna" placeholder="Warna Kendaraan" maxlength="20" >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Bahan Bakar</label>
                                <input type="text" class="form-control input-sm" id="bahanbakar" style="text-transform:uppercase" name="bahanbakar" placeholder="Bahan Bakar"  maxlength="20"  >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Warna TNKB</label>
                                <input type="text" class="form-control input-sm" id="warnatnkb" style="text-transform:uppercase" name="warnatnkb" placeholder="Warna TNKB"  maxlength="20"  >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Nomor BPKB</label>
                                <input type="text" class="form-control input-sm" id="nobpkb" style="text-transform:uppercase" name="nobpkb" placeholder="Nomor BPKB"  maxlength="20"  >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Lokasi Dari STNKB</label>
                                <input type="text" class="form-control input-sm" id="kdlokasi" style="text-transform:uppercase" name="kdlokasi" placeholder="Lokasi Dari STNKB"  maxlength="20"  >
                            </div>
                        </div> <!---- col 2 -->
                        <div class='col-sm-4'>
                            <div class="form-group">
                                <label for="inputsm">Tahun Registrasi STNK</label>
                                <input type="text" id="tahunreg" name="tahunreg" class="form-control year"  >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">MASA PENGURUSAN STNK 5 TAHUNAN</label>
                                <input type="text" class="form-control input-sm tgl" id="expstnkb" name="expstnkb"  data-date-format="dd-mm-yyyy"  >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">MASA PENGURUSAN PKB TAHUNAN</label>
                                <input type="text" class="form-control input-sm tgl" id="exppkbstnkb" name="exppkbstnkb"  data-date-format="dd-mm-yyyy"  >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Nomor PKB</label>
                                <input type="text" class="form-control input-sm" id="nopkb" style="text-transform:uppercase" name="nopkb" placeholder="Nomor Pajak Kendaraan Bermotor"  maxlength="20" >
                            </div>
                            <!--div class="form-group">
                              <label for="inputsm">Total Nominal Pajak Kendaraan</label>
                              <input type="number" class="form-control input-sm" id="nominalpkb" name="nominalpkb" value="0"  maxlength="20" >
                            </div-->
                            <div class="form-group">
                                <label for="inputsm">Pajak Progresif Ke</label>
                                <input type="number" class="form-control input-sm" id="pprogresif" style="text-transform:uppercase" name="pprogresif" value="0"  maxlength="20" >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Uji KIR</label>
                                <select class="form-control input-sm" name="ujikir" id="ujikir">
                                    <option value="NO">TIDAK</option>
                                    <option value="YES">YA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">HOLD</label>
                                <select class="form-control input-sm" name="hold_item" id="hold_item">
                                    <option value="NO">TIDAK</option>
                                    <option value="YES">YA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Asuransi</label>
                                <select class="form-control input-sm" name="asuransi" id="asuransi">
                                    <option value="NO">TIDAK</option>
                                    <option value="YES">YA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">KODE ASURANSI</label>
                                <select class="form-control input-sm " name="kdasuransi" id="kdasuransi">
                                    <option value="">-----PILIH ASURANSI JIKA ADA-----</option>
                                    <?php foreach($list_asuransi as $sc){?>
                                        <option value="<?php echo trim($sc->kdasuransi);?>" ><?php echo trim($sc->kdasuransi).' || '.trim($sc->nmasuransi);?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">KODE SUB ASURANSI</label>
                                <select class="form-control input-sm " name="kdsubasuransi" id="kdsubasuransi">
                                    <option value="">-----PILIH SUB ASURANSI JIKA ADA-----</option>
                                    <?php foreach($list_subasuransi as $sc){?>
                                        <option value="<?php echo trim($sc->kdsubasuransi);?>" class="<?php echo trim($sc->kdasuransi);?>"><?php echo trim($sc->kdsubasuransi).' || '.trim($sc->nmsubasuransi);?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Exp Asuransi</label>
                                <input type="text" id="expasuransi" name="expasuransi" class="form-control tgl"  data-date-format="dd-mm-yyyy"   >
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Keterangan</label>
                                <textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>

        </div>
    </div>
</div>


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