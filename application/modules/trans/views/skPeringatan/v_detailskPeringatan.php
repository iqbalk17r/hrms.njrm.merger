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
                <a href="<?php echo site_url('trans/skPeringatan') ?>" class="btn btn-default dropdown-toggle " style="margin:0px; color:#000000;" type="button"><i class="fa fa-arrow-left"></i> Kembali </a>

        </div>
    </div><!-- /.box-header -->
    <div class="box-body" >
        <form action="<?php echo site_url('#')?>" method="post" id="formInputSkPeringatan" enctype="multipart/form-data" role="form">
        <div class="col-lg-12">
                <input type="hidden" class="form-control" name="type" value="DETAIL">
                <input type="hidden" class="form-control" name="docno" >
                <div class="form-group">
                    <label class="label-form col-sm-2">PILIH KARYAWAN</label>
                    <?php /*<input type="hidden" value="<?php if (isset($dtl['kdregu'])){ echo trim($dtl['kdregu']); } else { echo ''; } ?>" id="kdregu" name="kdregu" style="text-transform:uppercase" maxlength="200" class="form-control" readonly required />
                <input type="hidden" value="<?php echo $blnx;?>" id="bln1" name='bln' style="text-transform:uppercase" maxlength="200" class="form-control" readonly />
                <input type="hidden" value="<?php echo $thnx;?>" id="thn1" name="thn" style="text-transform:uppercase" maxlength="200" class="form-control" readonly /> */ ?>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-leaf"></i>
                            </div>
                            <select class="form-control select2_kary" name="nik" id="nik" disabled>
                            </select>
                        </div>
                    </div>
                    <!--<div class="col-md-1">
                        <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Load </button>
                    </div>-->
                </div>

        </div>
        <div class="col-lg-12">
            <h3 ALIGN="center"> DETAIL SURAT PERINGATAN KARYAWAN </h3>
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
                <label for="uploadFile">Upload Dokumen SP</label>
                <input type="file" id="att_name" name="att_name" DISABLED>
                <a href="#" onclick="window.open('<?php echo site_url('assets/files/skPeringatan').'/'.$dtl['att_name'];?>')"><?php echo $dtl['att_name'];?></a>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Tanggal Awal</label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control datePick zz" name="startdate" id="startdate" data-date-format="dd-mm-yyyy" placeholder="Tanggal Awal" disabled>
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Tanggal Akhir</label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control datePick zz" name="enddate" id="enddate" data-date-format="dd-mm-yyyy" placeholder="Tanggal Akhir" disabled>
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Dokumen Referensi SP</label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                    <input type="text" class="form-control zz" name="docref" id="docref" placeholder="Dokumen Referensi SP" style="text-transform:uppercase" disabled>
                </div>
                <!-- /.input group -->
            </div>
            <div class="form-group">
                <label>Pilih Kategori SP</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </div>
                        <select class="form-control select2 zz" style="width: 100%;" name="doctype" disabled>
                            <?php foreach($msk as $ms) {?>
                                <option <?php if (trim($dtl['doctype']) ===trim($ms->docno)) { echo 'selected'; } ?> value="<?php echo trim($ms->docno);?>" ><?php echo trim($ms->docno);?></option>
                            <?php }?>
                        </select>
                </div>
            </div>
            <div class="form-group">
                <label>Keterangan</label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <textarea class="form-control" name="description" id="description" placeholder="Deskripsi" style="text-transform:uppercase" disabled></textarea>
                </div>
                <!-- /.input group -->
            </div>

        </div>
        <div class="col-lg-6">


        </div>
        </form>
    </div><!-- /.box-body -->
</div><!-- /.box -->


<script type="text/javascript">
    //console.log('kontol' + HOST_URL);
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        //read editable/input
        $.ajax({
            type: 'GET',
            url: HOST_URL + 'trans/skPeringatan/showResultHisSP/?docno=' + '<?= trim($dtl['docno']) ?>',
            dataType: 'json',
            dataFilter: function(data) {
                var json = jQuery.parseJSON(data);
                json.status = json.dataTables.status;
                json.total_count = json.dataTables.total_count;
                json.items = json.dataTables.items;
                json.incomplete_results = json.dataTables.incomplete_results;

                //console.log("On Ready" + json.dataTables.items[0].nik);
                 $('[name="docno"]').val(json.dataTables.items[0].docno);
                 $('[name="startdate"]').val(json.dataTables.items[0].startdate);
                 $('[name="enddate"]').val(json.dataTables.items[0].enddate);
                 $('[name="docref"]').val(json.dataTables.items[0].docref);

                 $('[name="description"]').val(json.dataTables.items[0].description);
                // Fetch the preselected item, and add to the control
                var select2_kary = $('.select2_kary');
                $.ajax({
                    type: 'GET',
                    url: HOST_URL + 'trans/skPeringatan/list_karyawan_by_id' + '?var=' + json.dataTables.items[0].nik,
                    dataType: 'json',
                    delay: 250,
                }).then(function (datax) {
                    // create the option and append to Select2
                    //console.log(datax.items[0].nik + 'KONTOL');
                    var option = new Option(datax.items[0].nmlengkap, datax.items[0].nik, true, true);
                    select2_kary.append(option).trigger('change');

                    // manually trigger the `select2:select` event
                    select2_kary.trigger({
                        type: 'select2:select',
                        params: {
                            data: datax
                        }
                    });
                });
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log("Failed To Loading Data");
            }
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

        $('[name="nik"]').change(function () {
            console.log("INI -> NIKNYA " + $(this).val());
            $.ajax({
                type: 'GET',
                url: HOST_URL + 'trans/skPeringatan/showHisSP' + '?docno=' +'<?= trim($dtl['docno']) ?>',
                dataType: 'json',
                dataFilter: function(data) {
                    var json = jQuery.parseJSON(data);
                    json.status = json.dataTables.status;
                    json.total_count = json.dataTables.total_count;
                    json.items = json.dataTables.items;
                    json.incomplete_results = json.dataTables.incomplete_results;

                    $('[name="department"]').val(json.dataTables.items[0].nmdept);
                    $('[name="jabatan"]').val(json.dataTables.items[0].nmjabatan);
                    $('[name="atasan1"]').val(json.dataTables.items[0].nmatasan1);
                    $('[name="atasan2"]').val(json.dataTables.items[0].nmatasan2);
                    //return JSON.stringify(json); // return JSON string
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log("Failed To Loading Data");
                }
            });

        })

    });


    function close_modal() {
        var validator = $('#form').data('bootstrapValidator');
        validator.resetForm();
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('#form')[0].reset(); // reset form on modals
        //$('.form-group').removeClass('has-error').removeClass('has-success'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show');
    }

    function add_sp_karyawan()
    {
        save_method = 'add';
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Input Data Wilayah'); // Set Title to Bootstrap modal title
        $('[name="type"]').val('INPUT');
        $('[name="kdwilayah"]').prop("required", true);
        $('#btnSave').removeClass("btn-danger").addClass("btn-primary").text('Simpan');
    }



    function formatRepo(repo) {
        if (repo.loading) return repo.text;
        var markup = "<div class='select2-result-repository__title'>" + repo.nik + "</div>";
        if (repo.nmlengkap) {
            markup += "<div class='select2-result-repository__description'>" + repo.nmlengkap +" <i class='fa fa-circle-o'></i> "+ repo.nmdept +"</div>";
        }
        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.nmlengkap || repo.text;
    }

    var defaultInitial = '';
    $(".select2_kary").select2({
        placeholder: "Ketik Nik Atau Nama Karyawan",
        allowClear: true,
        ajax: {
            url: HOST_URL + 'trans/skPeringatan/list_karyawan',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    _search_: params.term, // search term
                    _page_: params.page,
                    _draw_: true,
                    _start_: 1,
                    _perpage_: 2,
                    _paramglobal_: defaultInitial,
                };
            },
            processResults: function(data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
       // minimumInputLength: 1,
        templateResult: formatRepo, // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });

    $('#formInputSkPeringatan').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            startdate: {
                validators: {
                    notEmpty: {
                        message: 'The field can not be empty'
                    }
                }
            },
            enddate: {
                validators: {
                    notEmpty: {
                        message: 'The field can not be empty'
                    }
                }
            },
            docref: {
                validators: {
                    notEmpty: {
                        message: 'The field can not be empty'
                    }
                }
            },
            doctype: {
                validators: {
                    notEmpty: {
                        message: 'The field can not be empty'
                    }
                }
            },
            description: {
                validators: {
                    notEmpty: {
                        message: 'The field can not be empty'
                    }
                }
            },
            att_name: {
                validators: {
                    notEmpty: {
                        message: 'The field can not be empty'
                    }
                }
            },
            nik: {
                validators: {
                    notEmpty: {
                        message: 'The field can not be empty'
                    }
                }
            }
        },
        excluded: [':disabled']
    });
    $('.zz')
        .on('changeDate show change', function(e) {
            $('#formInputSkPeringatan').bootstrapValidator('revalidateField', 'startdate');
            $('#formInputSkPeringatan').bootstrapValidator('revalidateField', 'enddate');
            // $('#formInputSkPeringatan').bootstrapValidator('revalidateField', 'docref');
            // $('#formInputSkPeringatan').bootstrapValidator('revalidateField', 'doctype');
            // $('#formInputSkPeringatan').bootstrapValidator('revalidateField', 'keterangan');
            // $('#formInputSkPeringatan').bootstrapValidator('revalidateField', 'att_name');
            // $('#formInputSkPeringatan').bootstrapValidator('revalidateField', 'nik');
            //alert('TOLELIR');
        });


    function finishInput() {

        var validator = $('#formInputSkPeringatan').data('bootstrapValidator');
        validator.validate();
        if (validator.isValid()) {
            // ajax adding data to database
            var form = $('#formInputSkPeringatan');
            var formdata = false;
            if (window.FormData){
                formdata = new FormData(form[0]);
            }
            $.ajax({
                url: HOST_URL + 'trans/skPeringatan/saveDataSk',
                type: "POST",
                data: formdata ? formdata : form.serialize(),
                cache       : false,
                contentType : false,
                processData : false,
                datatype : "JSON",
                dataFilter: function (data) {
                    var json = jQuery.parseJSON(data);
                    if (json.status) //if success close modal and reload ajax table
                    {
                        //alert(json.messages);
                        var x = confirm(json.messages);
                        if (x) return window.location.replace("<?php echo site_url('/trans/skPeringatan')?>") + ""
                        //else return window.location.replace("<?php echo site_url('/trans/skPeringatan')?>") + "";
                    } else {
                        alert(json.messages);
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
            //alert("FInish Input");
        }
    }
</script>
