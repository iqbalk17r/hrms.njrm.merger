<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
    $(function () {
        $("#example1").dataTable();
    });

    window.onload = function () {
        document.getElementById("password1").onchange = validatePassword;
        document.getElementById("password2").onchange = validatePassword;
    }

    function validatePassword() {
        var pass2 = document.getElementById("password2").value;
        var pass1 = document.getElementById("password1").value;
        if (pass1 != pass2)
            document.getElementById("password2").setCustomValidity("Passwords Tidak Sama");
        else
            document.getElementById("password2").setCustomValidity('');
        //empty string means no validation error
    }
</script>
<legend><?php echo $title; ?></legend>
<?php echo $message; ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" style="margin:10px"><i
                            class="glyphicon glyphicon-plus"></i> INPUT
                </button>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <!--<th>Nama Level Jabatan</th>-->
                        <th>Kode Level Grade</th>
                        <th>Nama Level grade</th>
                        <th>Bobot-1</th>
                        <th>Bobot-2</th>
                        <th>Keterangan</th>
                        <th>Lvl Gp Min</th>
                        <th>Lvl Gp Max</th>
                        <th>LVL Jab</th>
                        <th>Aksi</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 0;
                    foreach ($list_jobgrade as $row): $no++; ?>
                        <tr>

                            <td><?php echo $no; ?></td>
                            <!--<td><?php echo $row->nmlvljabatan; ?></td>-->
                            <td><?php echo $row->kdgrade; ?></td>
                            <td><?php echo $row->nmgrade; ?></td>
                            <td><?php echo $row->bobot1; ?></td>
                            <td><?php echo $row->bobot2; ?></td>
                            <td><?php echo $row->keterangan; ?></td>
                            <td><?php echo $row->kdlvlgpmin; ?></td>
                            <td><?php echo $row->kdlvlgpmax; ?></td>
                            <td><?php echo $row->kdlvl; ?></td>
                            <td><a href="<?php echo site_url('master/jabatan/hps_jobgrade') . '/' . $row->kdgrade; ?>"
                                   OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->kdgrade); ?>?')"><i
                                            class="fa  fa-trash-o"><i> Hapus</a></td>
                            <td><a data-toggle="modal" data-target="#<?php echo trim($row->kdgrade); ?>" href="#"><i
                                            class="fa  fa-edit"><i>Edit</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
<!-- Modal Input jobgrade -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">INPUT MASTER LEVEL GRADE</h4>
            </div>

            <div class="modal-body">
                <form role="form" action="<?php echo site_url('master/jabatan/add_jobgrade'); ?>" method="post">
                    <div class="row">
                        <!--<div class="form-group">
						<label  class="col-sm-12">Level jabatan</label>
						<div class="col-sm-12">
							<select class="form-control" name="kdlvl" id="kdlvl" required>
							  <?php foreach ($list_lvljabatan as $listkan) { ?>
							  <option value="<?php echo trim($listkan->kdlvl); ?>" ><?php echo $listkan->nmlvljabatan; ?></option>
							  <?php } ?>
							</select>
						</div>
			</div>-->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-12">Kode Level Grade</label>
                                <div class="col-sm-24">

                                    <input type="text" id="kdgrade" name="kdgrade" class="form-control" maxlength="2"
                                           style="text-transform:uppercase" required>

                                    <!-- /.input group -->
                                </div>
                            </div>
                            <script type="text/javascript" charset="utf-8">
                                $(function () {
                                    $("#csubdept").chained("#cdept");
                                    $("#cjabt").chained("#csubdept");

                                });
                            </script>
                            <div class="form-group">
                                <label class="col-sm-12">Nama Level Grade</label>
                                <div class="col-sm-24">

                                    <input type="text" id="nmjg" name="nmjg" class="form-control" maxlength="20"
                                           style="text-transform:uppercase" required>

                                    <!-- /.input group -->
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="form-group">
                                <label class="col-sm-12">Bobot-1</label>
                                <div class="col-sm-24">

                                    <input type="text" id="bobot1" name="bobot1" data-inputmask='"mask": "999"'
                                           data-mask="" class="form-control">

                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Bobot-2</label>
                                <div class="col-sm-24">

                                    <input type="text" id="bobot2" name="bobot2" data-inputmask='"mask": "999"'
                                           data-mask="" class="form-control">

                                    <!-- /.input group -->
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Job Grade</label>
                            <div class="col-sm-12">
                                <select class="form-control input-sm" name="kdlvl" id="kdlvl" required>
                                    <option value=""><?php echo '-- PILIH JOB GRADE ---'; ?></option>
                                    <?php foreach ($list_lvljabatan as $lkd) { ?>
                                        <option value="<?php echo trim($lkd->kdlvl); ?>"><?php echo $lkd->kdlvl . ' | | ' . $lkd->nmlvljabatan; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Level Gp Min </label>
                            <div class="col-sm-12">
                                <select class="form-control input-sm" name="kdlvlgpmin" id="kdlvlgpmin" required>
                                    <option value=""><?php echo '-- PILIH GP MINIMAL RANGE ---'; ?></option>
                                    <?php foreach ($list_kdlvl as $lkd) { ?>
                                        <option value="<?php echo trim($lkd->kdlvlgp); ?>"><?php echo $lkd->kdlvlgp; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Level Gp Max </label>
                            <div class="col-sm-12">
                                <select class="form-control input-sm" name="kdlvlgpmax" id="kdlvlgpmax" required>
                                    <option value=""><?php echo '-- PILIH GP MAKSIMAL RANGE ---'; ?></option>
                                    <?php foreach ($list_kdlvl as $lkd) { ?>
                                        <option value="<?php echo trim($lkd->kdlvlgp); ?>"><?php echo $lkd->kdlvlgp; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Keterangan</label>
                            <div class="col-sm-12">
                                <div>
                                    <textarea class="form-control" name="ket"
                                              style="text-transform:uppercase"></textarea>
                                    <input type="hidden" id="tgl1" name="tgl" value="<?php echo date('d-m-Y H:i:s'); ?>"
                                           class="form-control" readonly>
                                    <input type="hidden" id="inputby" name="inputby"
                                           value="<?php echo $this->session->userdata('nik'); ?>" class="form-control"
                                           readonly>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <div class="col-lg-12">
                                <button type='submit' class='btn btn-primary'><i class="glyphicon glyphicon-search"></i>
                                    Proses
                                </button>
                                <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>


<!--Edit JOB GRADE -->
<?php foreach ($list_jobgrade as $lg) { ?>

    <div class="modal fade" id="<?php echo trim($lg->kdgrade); ?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit MASTER LEVEL GRADE</h4>
                </div>

                <div class="modal-body">
                    <form role="form" action="<?php echo site_url('master/jabatan/edit_jobgrade'); ?>" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-12">Kode Level Grade</label>
                                    <div class="col-sm-24">

                                        <input type="text" id="kdgrade" name="kdgrade"
                                               value="<?php echo $lg->kdgrade; ?>" class="form-control" readonly>

                                        <!-- /.input group -->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12">Nama Level Grade</label>
                                    <div class="col-sm-24">

                                        <input type="text" id="nmjg" name="nmjg" value="<?php echo $lg->nmgrade; ?>"
                                               class="form-control" style="text-transform:uppercase">

                                        <!-- /.input group -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-sm-12">Bobot-1</label>
                                    <div class="col-sm-12">

                                        <input type="text" id="bobot1" name="bobot1" value="<?php echo $lg->bobot1; ?>"
                                               data-inputmask='"mask": "999"' data-mask="" class="form-control">

                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Bobot-2</label>
                                    <div class="col-sm-12">

                                        <input type="text" id="bobot2" name="bobot2" value="<?php echo $lg->bobot2; ?>"
                                               data-inputmask='"mask": "999"' data-mask="" class="form-control">

                                        <!-- /.input group -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Job Grade</label>
                                <div class="col-sm-12">
                                    <select class="form-control input-sm" name="kdlvl" id="kdlvl" required>
                                        <option value=""><?php echo '-- PILIH JOB GRADE ---'; ?></option>
                                        <?php foreach ($list_lvljabatan as $lkd) { ?>
                                            <option <?php if (trim($lkd->kdlvl) == trim($lg->kdlvl)) {
                                                echo 'selected';
                                            } ?> value="<?php echo trim($lkd->kdlvl); ?>"><?php echo $lkd->kdlvl . ' | | ' . $lkd->nmlvljabatan; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Level Gp Min </label>
                                <div class="col-sm-12">
                                    <select class="form-control input-sm" name="kdlvlgpmin" id="kdlvlgpmin" required>
                                        <option value=""><?php echo '-- PILIH GP MINIMAL RANGE ---'; ?></option>
                                        <?php foreach ($list_kdlvl as $lkd) { ?>
                                            <option <?php if (trim($lkd->kdlvlgp) == trim($lg->kdlvlgpmin)) {
                                                echo 'selected';
                                            } ?> value="<?php echo trim($lkd->kdlvlgp); ?>"><?php echo $lkd->kdlvlgp; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Level Gp Max </label>
                                <div class="col-sm-12">
                                    <select class="form-control input-sm" name="kdlvlgpmax" id="kdlvlgpmax" required>
                                        <option value=""><?php echo '-- PILIH GP MAKSIMAL RANGE ---'; ?></option>
                                        <?php foreach ($list_kdlvl as $lkd) { ?>
                                            <option <?php if (trim($lkd->kdlvlgp) == trim($lg->kdlvlgpmax)) {
                                                echo 'selected';
                                            } ?> value="<?php echo trim($lkd->kdlvlgp); ?>"><?php echo $lkd->kdlvlgp; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Keterangan</label>
                                <div class="col-sm-12">

                                    <div>
                                        <textarea class="form-control" name="ket"
                                                  style="text-transform:uppercase"><?php echo $lg->keterangan; ?></textarea>
                                    </div>

                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Tanggal Update</label>
                                <div class="col-sm-12">

                                    <input type="text" id="tgl1" name="tgl" value="<?php echo date('d-m-Y H:i:s'); ?>"
                                           class="form-control" readonly>

                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">Update By</label>
                                <div class="col-sm-12">

                                    <input type="text" id="inputby" name="inputby"
                                           value="<?php echo $this->session->userdata('nik'); ?>" class="form-control"
                                           readonly>

                                    <!-- /.input group -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <button type='submit' class='btn btn-primary'><i
                                                class="glyphicon glyphicon-search"></i> Proses
                                    </button>
                                    <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>


    $("[data-mask]").inputmask();

    //Date range picker
    $('#tgl').datepicker();


</script>
