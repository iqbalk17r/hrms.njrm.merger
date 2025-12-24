<?php
/**
 * *
 *  * Created by PhpStorm.
 *  *  * User: FIKY-PC
 *  *  * Date: 4/29/19 1:34 PM
 *  *  * Last Modified: 12/18/16 10:51 AM.
 *  *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  *  Copyright© 2019 .All rights reserved.
 *  *
 *
 */

/**
 * Created by PhpStorm.
 * User: FIKY-PC
 * Date: 13/04/2019
 * Time: 10:26
 */
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$(".datePick").datepicker();
            });

</script>

<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
        <?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>
            <li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>
        <?php } else { ?>
            <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
        <?php } ?>
    <?php } ?>
</ol>
<h3><?php echo $title; ?></h3>


<!--?php echo $message;?-->


<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
                <a href="<?php echo site_url('trans/skPeringatan/clearDoc') ?>" class="btn btn-default dropdown-toggle " style="margin:0px; color:#000000;" type="button"><i class="fa fa-arrow-left"></i> Kembali </a>
                <button class="btn btn-success dropdown-toggle pull-right" style="margin:0px; color:#ffffff;" type="button" id="btnSave" onclick="finishInput();"> Proses <i class="fa fa-arrow-right"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body" >
        <form action="<?php echo site_url('#')?>" method="post" id="formInputSkPeringatan" enctype="multipart/form-data" role="form">
        <div class="col-lg-12">
                <input type="hidden" class="form-control" name="type" value="INPUT">
                <div class="form-group">
                    <label class="label-form col-sm-2">PILIH KARYAWAN</label>
                    <?php /*<input type="hidden" value="<?php if (isset($dtl['kdregu'])){ echo trim($dtl['kdregu']); } else { echo ''; } ?>" id="kdregu" name="kdregu" style="text-transform:uppercase" maxlength="200" class="form-control" readonly required />
                <input type="hidden" value="<?php echo $blnx;?>" id="bln1" name='bln' style="text-transform:uppercase" maxlength="200" class="form-control" readonly />
                <input type="hidden" value="<?php echo $thnx;?>" id="thn1" name="thn" style="text-transform:uppercase" maxlength="200" class="form-control" readonly /> */ ?>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user-plus"></i>
                            </div>
                            <select class="form-control select2_kary" name="nik" id="nik">
                            </select>
                        </div>
                    </div>
                    <!--<div class="col-md-1">
                        <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Load </button>
                    </div>-->
                </div>

        </div>
        <div class="col-lg-12">
            <h3 ALIGN="center"> INPUT SURAT PERINGATAN KARYAWAN </h3>
        </div>
        <div class="col-lg-6">
            <!-- Date dd/mm/yyyy -->
            <div class="form-group">
                <label>Departement</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-circle-o"></i>
                    </div>
                    <input type="text" class="form-control" name="department" placeholder="Department Karyawan" disabled>
                </div>
                <!-- /.input group -->
            </div>
            <!-- /.form group -->
            <!-- Date dd/mm/yyyy -->
            <div class="form-group">
                <label>Jabatan</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-circle-o"></i>
                    </div>
                    <input type="text" class="form-control" name="jabatan" placeholder="Jabatan Karyawan" disabled>
                </div>
                <!-- /.input group -->
            </div>
            <!-- /.form group -->
            <div class="form-group">
                <label>Atasan 1</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-circle-o"></i>
                    </div>
                    <input type="text" class="form-control" name="atasan1" placeholder="Atasan 1 Karyawan" disabled>
                </div>
                <!-- /.input group -->
            </div>
            <!-- /.form group -->
            <div class="form-group">
                <label>Atasan 2</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-circle-o"></i>
                    </div>
                    <input type="text" class="form-control" name="atasan2" placeholder="Atasan 2 Karyawan" disabled>
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-circle-o"></i>
                    </div>
                    <input type="text" class="form-control" name="alamattinggal" placeholder="Alamat Domisili" disabled>
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Contact</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-circle-o"></i>
                    </div>
                    <input type="text" class="form-control" name="nohp1" placeholder="Contact & Ponsel" disabled>
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-circle-o"></i>
                    </div>
                    <input type="text" class="form-control" name="email" placeholder="Email / Surel" disabled>
                </div>
                <!-- /.input group -->
            </div>


        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Tanggal Awal s/d Tanggal Selesai</label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control dateRangePick" name="startdate" id="startdate" placeholder="Tanggal Periode">
                </div>
                <!-- /.input group -->
            </div>
            <?php /*
            <div class="form-group">
                <label>Tanggal Akhir</label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control datePick zz" name="enddate" id="enddate" data-date-format="dd-mm-yyyy" placeholder="Tanggal Akhir" >
                </div>
                <!-- /.input group -->
            </div> */ ?>
            <div class="form-group">
                <label>Pilih Kategori SP</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <select class="form-control col-sm-12" name="doctype" id="doctype" placeholder="Pilih Kategori SP" >
                    </select>
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Dokumen Referensi SP</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </div>
                    <select class="form-control col-sm-12" name="docref" id="docref" placeholder="Pilih Dokumen Referensi SP" >
                    </select>
                </div>
                <!-- /.input group -->
            </div>
            
            <div class="form-group">
                <label>Keterangan Peringatan / Alasan Teguran</label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <textarea class="form-control" name="description" id="description" placeholder="Deskripsi" style="text-transform:uppercase" ></textarea>
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Solusi/Perbaikan</label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <textarea class="form-control" name="solusi" id="solusi" placeholder="Solusi & Perbaikan" style="text-transform:uppercase" ></textarea>
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label for="uploadFile">Upload Dokumen Pendukung</label>
                <input type="file" id="att_name" name="att_name">
                <a href="#" onclick="window.open('<?php echo site_url('assets/files/skPeringatan').'/'.$dtl['att_name'];?>')"><?php echo $dtl['att_name'];?></a>
            </div>

        </div>
        <div class="col-lg-6">


        </div>
        </form>
    </div><!-- /.box-body -->
</div><!-- /.box -->













<script type="text/javascript" src="<?= base_url('assets/pagejs/trans/skperingatan.js') ?>"></script>
