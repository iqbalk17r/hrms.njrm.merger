<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 2/20/20, 11:19 AM
 *  * Last Modified: 7/17/17, 9:10 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */

?>
<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
        $("#dateinput").datepicker();

        $("#tgl").datepicker();
        $(".tglan").datepicker();
        $(".tglrange").daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $(".tglrange").on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        });

        $(".tglrange").on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

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
            <h3> </h3>
        </div>
        <div class="col-sm-12">
            <!--div class="container"--->
            <div class="dropdown ">
                <button class="btn btn-default pull-right" style="margin:10px; color:#000000;"  onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            </div>

            <!--/div-->
        </div><!-- /.box-header -->
        <!--<div class="col-sm-9">
            <button class="btn btn-success" onclick="add_upload_anajab()"><i class="glyphicon glyphicon-plus"></i> Input </button>
            <button class="btn btn-default pull-right" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        </div>-->

    </div><!-- /.box-header -->
    <div class="box-body table-responsive" style='overflow-x:scroll;'>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="1%" >No.</th>
                <!--<th width="10%">Tgl</th>-->
                <th>Departement</th>
                <th>Sub Department</th>
                <th>Jabatan</th>
                <th>No Dokumen</th>
                <th>Status</th>
                <th width="5%">Action</th>

            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Input & Upload Data Anajab</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal" method="post" action="#" enctype="multipart/form-data" >
                    <input type="hidden" value="INPUT" name="type"/>
                    <div class="form-body">
                        <!--<div class="form-group">
                            <label class="control-label col-md-3">Pilih Jabatan Anajab</label>
                            <div class="col-md-9">
                                <select name="nik" class="form-control inform selectizel" style="text-transform:uppercase;" id="nik">
                                    <option value="">--Pilih Karyawan--</option>
                                    <?php /*foreach($list_jabatan as $lw){*/?>
                                        <option value="<?php /*echo trim($lw->kdjabatan);*/?>"> <?php /*echo trim($lw->alljabatan );*/?> </option>
                                    <?php /*}*/?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label col-sm-3" valign="left">Nomor Dokumen</label>
                            <div class="col-sm-8">
                                <input name="docno" placeholder="NOMOR DOKUMEN" class="form-control inform" type="text" MAXLENGTH="20" style="text-transform:uppercase;" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Department</label>
                            <div class="col-sm-8">
                                <select name="kddept" id='kddept' class="form-control col-sm-12"  required>
                                    <option value="">-Pilih Department-</option>
                                    <?php foreach ($list_opt_dept as $lodept){ ?>
                                        <option value="<?php echo trim($lodept->kddept);?>" ><?php echo trim($lodept->nmdept);?></option>
                                    <?php };?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Sub Department</label>
                            <div class="col-sm-8">
                                <select name="kdsubdept" id='kdsubdept' class="form-control col-sm-12"  required>
                                    <option value="dfn3nnIOOJI">-Pilih Sub Department-</option>
                                    <?php foreach ($list_opt_subdept as $losdept){ ?>
                                        <option value="<?php echo trim($losdept->kdsubdept);?>" class="<?php echo trim($losdept->kddept);?>"><?php echo trim($losdept->nmsubdept);?></option>
                                    <?php };?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <script type="text/javascript" charset="utf-8">
                            $(function() {
                                $('#kddept').selectize();
                                //$('#jobgrade').selectize();
                                $("#kdsubdept").chained("#kddept");
                                //$('#subdept').selectize();
                                $("#kdjabatan").chained("#kdsubdept");

                            });
                        </script>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Jabatan</label>
                            <div class="col-sm-8">
                                <select name="kdjabatan" id='kdjabatan' class="form-control col-sm-12" required>
                                    <option value="">-Pilih Jabatan-</option>
                                    <?php foreach ($list_opt_jabt as $lojab){ ?>
                                        <option value="<?php echo trim($lojab->kdjabatan);?>" class="<?php echo trim($lojab->kdsubdept);?>"><?php echo trim($lojab->nmjabatan);?></option>
                                    <?php };?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Upload Data Anajab</label>
                            <div class="col-sm-8">
                                    <input type="file" id="uploadAnajab" name="uploadAnajab" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Keterangan</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="control-label col-md-3">Hold</label>
                            <div class="col-md-9">
                                <select name="c_hold" class="form-control c_hold inform" style="text-transform:uppercase;" >

                                    <option value="NO"> NO </option>
                                    <option value="YES">YES </option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>-->

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><i class="fa fa-save"> Save </i></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"> Cancel</i></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">FILTER ANAJAB</h4>
            </div>
            <form id="form-filter" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Department</label>
                        <div class="col-sm-8">
                            <select name="fkddept" id='fkddept' class="form-control col-sm-12"  required>
                                <option value="">-Pilih Department-</option>
                                <?php foreach ($list_opt_dept as $lodept){ ?>
                                    <option value="<?php echo trim($lodept->kddept);?>" ><?php echo trim($lodept->nmdept);?></option>
                                <?php };?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Sub Department</label>
                        <div class="col-sm-8">
                            <select name="fkdsubdept" id='fkdsubdept' class="form-control col-sm-12"  required>
                                <option value="dfn3nnIOOJI">-Pilih Sub Department-</option>
                                <?php foreach ($list_opt_subdept as $losdept){ ?>
                                    <option value="<?php echo trim($losdept->kdsubdept);?>" class="<?php echo trim($losdept->kddept);?>"><?php echo trim($losdept->nmsubdept);?></option>
                                <?php };?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <script type="text/javascript" charset="utf-8">
                        $(function() {
                            $('#fkddept').selectize();
                            //$('#jobgrade').selectize();
                            $("#fkdsubdept").chained("#fkddept");
                            //$('#subdept').selectize();
                            $("#fkdjabatan").chained("#fkdsubdept");

                        });
                    </script>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Jabatan</label>
                        <div class="col-sm-8">
                            <select name="fkdjabatan" id='fkdjabatan' class="form-control col-sm-12" required>
                                <option value="">-Pilih Jabatan-</option>
                                <?php foreach ($list_opt_jabt as $lojab){ ?>
                                    <option value="<?php echo trim($lojab->kdjabatan);?>" class="<?php echo trim($lojab->kdsubdept);?>"><?php echo trim($lojab->nmjabatan);?></option>
                                <?php };?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <!--<div class="form-group input-sm ">
                        <label class="label-form col-sm-3">TANGGAL DOKUMEN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-sm tglrange" id="tglrange" name="tglrange" value="" data-date-format="dd-mm-yyyy" required>
                        </div>
                    </div>-->
                    <!--<div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Bulan</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name='bln' id="bln" required>
                                <option value="01" <?php /*$tgl=date('m'); if($tgl=='01') echo "selected"; */?>>Januari</option>
                                <option value="02" <?php /*$tgl=date('m'); if($tgl=='02') echo "selected"; */?>>Februari</option>
                                <option value="03" <?php /*$tgl=date('m'); if($tgl=='03') echo "selected"; */?>>Maret</option>
                                <option value="04" <?php /*$tgl=date('m'); if($tgl=='04') echo "selected"; */?>>April</option>
                                <option value="05" <?php /*$tgl=date('m'); if($tgl=='05') echo "selected"; */?>>Mei</option>
                                <option value="06" <?php /*$tgl=date('m'); if($tgl=='06') echo "selected"; */?>>Juni</option>
                                <option value="07" <?php /*$tgl=date('m'); if($tgl=='07') echo "selected"; */?>>Juli</option>
                                <option value="08" <?php /*$tgl=date('m'); if($tgl=='08') echo "selected"; */?>>Agustus</option>
                                <option value="09" <?php /*$tgl=date('m'); if($tgl=='09') echo "selected"; */?>>September</option>
                                <option value="10" <?php /*$tgl=date('m'); if($tgl=='10') echo "selected"; */?>>Oktober</option>
                                <option value="11" <?php /*$tgl=date('m'); if($tgl=='11') echo "selected"; */?>>November</option>
                                <option value="12" <?php /*$tgl=date('m'); if($tgl=='12') echo "selected"; */?>>Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Tahun</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm" name="thn" required>
                                <option value='<?php /*$tgl=date('Y'); echo $tgl; */?>'><?php /*$tgl=date('Y'); echo $tgl; */?></option>
                                <option value='<?php /*$tgl=date('Y')-1; echo $tgl; */?>'><?php /*$tgl=date('Y')-1; echo $tgl; */?></option>
                                <option value='<?php /*$tgl=date('Y')-2; echo $tgl; */?>'><?php /*$tgl=date('Y')-2; echo $tgl; */?></option>
                                <option value='<?php /*$tgl=date('Y')+1; echo $tgl; */?>'><?php /*$tgl=date('Y')+1; echo $tgl; */?></option>
                            </select>
                        </div>
                    </div>-->
                    <!--<div class="form-group input-sm ">
                        <label class="label-form col-sm-3">KARYAWAN</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm selet" id="nik" name="nik">
                                <option value="">--PILIH KARYAWAN--</option>
                                <?php /*foreach ($list_karyawan as $ld){ */?>
                                    <option value="<?php /*echo trim($ld->nik);*/?>"><?php /*echo trim($ld->nik).'||'.$ld->nmlengkap;*/?></option>
                                <?php /*} */?>
                            </select>
                        </div>
                    </div>-->
                    <!--<div class="form-group input-sm ">
                        <label class="label-form col-sm-3">REGU</label>
                        <div class="col-sm-9">
                            <select class="form-control input-sm  selet" id="kdregu" name="kdregu">
                                <option value="">--Pilih Nama Regu--</option>
                                <?php /*foreach ($list_regu as $ld){ */?>
                                    <option value="<?php /*echo trim($ld->kdregu);*/?>"><?php /*echo $ld->nmregu;*/?></option>
                                <?php /*} */?>
                            </select>
                        </div>
                    </div>-->
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                    <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        //datatables
        table = $('#table').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "language": {
                <?php echo $this->fiky_encryption->constant('datatable_language'); ?>
            },

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('anajab/c_anajab/list_upload_anajab')?>",
                "type": "POST",
                "data": function(data) {
                    data.kddept = $('#fkddept').val();
                    data.kdsubdept = $('#fkdsubdept').val();
                    data.kdjabatan = $('#fkdjabatan').val();
                },
                "dataFilter": function(data) {
                    var json = jQuery.parseJSON(data);
                    json.draw = json.dataTables.draw;
                    json.recordsTotal = json.dataTables.recordsTotal;
                    json.recordsFiltered = json.dataTables.recordsFiltered;
                    json.data = json.dataTables.data;
                    return JSON.stringify(json); // return JSON string
                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [ -1 ], //last column
                    "orderable": false, //set not orderable
                },
            ],

        });

        //datepicker
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });

        $('#btn-filter').click(function(){ //button filter event click
            table.ajax.reload();  //just reload table
            $('#filter').modal('hide');
        });
        $('#btn-reset').click(function(){ //button reset event click
            $('#form-filter')[0].reset();
            table.ajax.reload();  //just reload table
            $('#filter').modal('hide');
        });
    });



    function add_upload_anajab()
    {
        save_method = 'add';
        var validator = $('#form').data('bootstrapValidator');
        validator.resetForm();
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('#form')[0].reset(); // reset form on modals
        //$('.form-group').removeClass('has-error').removeClass('has-success'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Input Data Anajab'); // Set Title to Bootstrap modal title
        $('[name="type"]').val('INPUT');
        //$('[name="kdwilayah"]').prop("required", true);
        $('#btnSave').removeClass("btn-danger").addClass("btn-primary").text('Simpan');
    }

    function ubah_wilayah(id)
    {
        save_method = 'update';
        var validator = $('#form').data('bootstrapValidator');
        validator.resetForm();
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('payroll/master/show_edit_wilayah/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                $('[name="type"]').val('EDIT');
                $('[name="kdwilayah"]').val(data.kdwilayah).prop("readonly", true);
                $('[name="nmwilayah"]').val(data.nmwilayah);
                $('[name="c_hold"]').val(data.c_hold.trim());
                //$('[name="dob"]').datepicker('update',data.dob);
                $('#btnSave').removeClass("btn-danger").addClass("btn-primary").text('Ubah');
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Data Wilayah'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function hapus_wilayah(id)
    {
        save_method = 'delete';
        //$('#modal_form').removeData('bs.modal');
        var validator = $('#form').data('bootstrapValidator');
        validator.resetForm();
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('payroll/master/show_del_wilayah/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                $('[name="type"]').val('DELETE');
                $('[name="kdwilayah"]').val(data.kdwilayah).prop("readonly", true);
                $('[name="nmwilayah"]').val(data.nmwilayah).prop("readonly", true);
                $('[name="c_hold"]').val(data.c_hold.trim());
                $('.c_hold').prop("disabled", true);
                $('#btnSave').removeClass("btn-primary").addClass("btn-danger").text('Hapus');
                //$('[name="dob"]').datepicker('update',data.dob);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Hapus Data Wilayah'); // Set title to Bootstrap modal title

                //.removeClass("btn-primary").addClass("btn-danger"); // set button

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }

    function save()
    {
        var validator = $('#form').data('bootstrapValidator');
        validator.validate();
        if (validator.isValid()) {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable
            var url;

            if (save_method == 'add') {
                url = "<?php echo site_url('anajab/c_anajab/save_anajab')?>";
            } else if (save_method == 'update') {
                url = "<?php echo site_url('anajab/c_anajab/save_anajab')?>";
            } else if (save_method == 'delete') {
                url = "<?php echo site_url('anajab/c_anajab/save_anajab')?>";
            }

            var file = $('#uploadAnajab')[0].files[0];
            var formdata = new FormData($('#form')[0]);
            console.log(formdata.append("uploadAnajab", file));

            // ajax adding data to database
            $.ajax({
                url: url,
                type: "POST",
                // data: $('#form').serialize(),
                // dataType: "JSON",
                data: formdata,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (data) {

                    if (data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        reload_table();
                    }

                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable


                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Gagal Menyimpan / Ubah data / data sudah ada');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable

                }
            });
        }
    }


</script>
