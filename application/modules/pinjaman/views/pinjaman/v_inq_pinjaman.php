<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/4/19 11:39 AM
 *  * Last Modified: 4/23/19 9:59 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */


?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#dateinput").datepicker();
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
            <a href="<?php echo site_url("pinjaman/pinjaman/sub_dtl_pinjaman").'/'.$this->fiky_encryption->enkript(trim($nik));?>"  class="btn btn-default" style="margin:0px; color:#000000;">Kembali</a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive" style='overflow-x:scroll;'>
        <table id="example" class="table table-bordered table-striped" >
            <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nik</th>
                <th>Nama</th>
                <th>Tgl</th>
                <th>Referensi</th>
                <th>Type</th>
                <th>In</th>
                <th>Out</th>
                <th>Sisa</th>
            </tr>
            </thead>
            <tbody>
            <?php $no=0; foreach($list_inq as $lu): $no++;?>
                <tr>
                    <td width="1%"><?php echo $no;?></td>
                    <td><?php echo $lu->docno;?></td>
                    <td><?php echo $lu->nik;?></td>
                    <td><?php echo $lu->nmlengkap;?></td>
                    <td><?php echo $lu->tgl;?></td>
                    <td><?php echo $lu->docref;?></td>
                    <td><?php echo $lu->doctype;?></td>
                    <td><?php echo $lu->in_sld;?></td>
                    <td><?php echo $lu->out_sld;?></td>
                    <td><?php echo $lu->sld;?></td>
                </tr>
            <?php endforeach;?>
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
                <h3 class="modal-title">Input Pinjaman</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="INPUT" name="type"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">KODE PINJAMAN</label>
                            <div class="col-md-9">
                                <input name="docno" placeholder="KODE PINJAMAN" class="form-control inform" type="text" MAXLENGTH="20" style="text-transform:uppercase;" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pilih Karyawan</label>
                            <div class="col-md-9">
                                <select name="nik" class="form-control inform selectizel" style="text-transform:uppercase;" id="nik">
                                    <option value="">--Pilih Karyawan--</option>
                                    <?php foreach($listkaryawan as $lw){?>
                                        <option value="<?php echo trim($lw->nik);?>"> <?php echo trim($lw->nik).' - '.trim($lw->nmlengkap);?> </option>
                                    <?php }?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">DESKRIPSI</label>
                            <div class="col-md-9">
                                <input name="description" placeholder="DESKRIPSI" class="form-control inform" type="text" MAXLENGTH="30" style="text-transform:uppercase;" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">TANGGAL</label>
                            <div class="col-md-9">
                                <input name="tgl" placeholder="TANGGAL" class="form-control inform tgl" type="text" MAXLENGTH="10" style="text-transform:uppercase;" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">NOMINAL</label>
                            <div class="col-md-9">
                                <input onClick="this.select();" name="nominal" placeholder="BANYAK PINJAMAN NOMINAL" class="form-control inform ratakanan c_hold" type="number" MAXLENGTH="18" style="text-transform:uppercase;">  <!-- onkeyup="formatangkaobjek(this)"-->
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">TENOR</label>
                            <div class="col-md-9">
                                <input onClick="this.select();" name="tenor" placeholder="TENOR BERAPA KALI" class="form-control inform ratakanan c_hold" type="number" MAXLENGTH="18" style="text-transform:uppercase;">  <!-- onkeyup="formatangkaobjek(this)"-->
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">POTONGAN / TENOR</label>
                            <div class="col-md-9">
                                <input onClick="this.select();" name="npotong" placeholder="POTONGAN/TENOR NOMINAL" class="form-control inform ratakanan c_hold" type="number" MAXLENGTH="18" style="text-transform:uppercase;">  <!-- onkeyup="formatangkaobjek(this)"-->
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">SISA / KURANG BAYAR</label>
                            <div class="col-md-9">
                                <input onClick="this.select();" name="sisa" placeholder="SISA / KURANG BAYAR" class="form-control inform ratakanan c_hold" type="number" MAXLENGTH="18" style="text-transform:uppercase;">  <!-- onkeyup="formatangkaobjek(this)"-->
                                <span class="help-block"></span>
                            </div>
                        </div>
                       <!-- <div class="form-group">
                            <label class="control-label col-md-3">Hold</label>
                            <div class="col-md-9">
                                <select name="c_hold" class="form-control c_hold inform" style="text-transform:uppercase;" >
                                    <!--option value="">--Pilih Hold--</option
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
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">

$(document).ready(function(){
    $('#form').bootstrapValidator({
//        live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            description: {
                validators: {
                    notEmpty: {
                        title: 'Tidak Boleh Kosong'
                    }
                }
            },
            nik: {
                validators: {
                    notEmpty: {
                        title: 'Tidak Boleh Kosong'
                    }
                }
            },
            tgl: {
                validators: {
                    date: {
                        format: 'DD-MM-YYYY',
                        message: 'Tanggal Tidak Valid'
                    }
                }
            },
            nominal: {
                validators: {
                    notEmpty: {
                        title: 'Tidak Boleh Kosong'
                    },
                    choice:  {
                        min: 0,
                        title: 'Tidak Boleh Kosong / 0'
                    },
                }
            },
            tenor: {
                validators: {
                    notEmpty: {
                        title: 'Tidak Boleh Kosong'
                    },
                    choice:  {
                        min: 0,
                        title: 'Tidak Boleh Kosong / 0'
                    },
                }
            },
            npotong: {
                validators: {
                    notEmpty: {
                        title: 'Tidak Boleh Kosong'
                    },
                    choice:  {
                        min: 0,
                        title: 'Tidak Boleh Kosong / 0'
                    },
                }
            },

        }
    });
});





    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        $('#example').DataTable();
        $('.tgl').datepicker({
            autoclose: true,
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });
        $('.selectizel').selectize();

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
                "url": "<?php echo site_url('pinjaman/pinjaman/list_sub_karyawan_pinjam'.'/'.$nik)?>",
                "type": "POST",
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
        $(".modal").on("hidden.bs.modal", function(){
            $(this)
                .find("input,textarea,select")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end()
                .find("input,textarea,select")
                .prop("disabled",false)
                .end();
                $('[name="nik"]').selectize()[0].selectize.setValue('',true);
                $('#nik').selectize()[0].selectize.enable();

        });

    });



    function hitung_pinjaman() {
        var xx= confirm('Proses recalculate akan memuat waktu, ' +
            'Keseluruhan data akan terupdate, Anda yakin...? ');
        var p1='KEY';
        if (xx === true) {
            $("#loadMe").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
            $.ajax("<?php echo site_url('pinjaman/pinjaman/hitung_pinjaman')?>", {
                type: "POST",
                data: JSON.stringify({ key: p1}),
                contentType: "application/json",
            }).done(function (data) {
                var js = jQuery.parseJSON(data);
                if( js.enkript === p1) {
                    console.log('success');
                } else { console.log('Fail Key');}
                $("#loadMe").modal("hide");
                table.ajax.reload(null,false); //reload datatable ajax
            }).fail(function (xhr, status, error) {
                alert("Could not reach the API: " + error);
                $("#loadMe").modal("hide");
                return true;
            });

        } else {
            //do nothing
            return false;
        }

    }

    function ubah_pinjaman(id)
    {
        save_method = 'update';
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('pinjaman/pinjaman/show_edit_pinjaman/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                var v_nominal = (data.nominal != null ? Math.round(data.nominal.replace(',','.')) : "0");
                var v_npotong = (data.npotong != null ? Math.round(data.npotong.replace(',','.')) : "0");
                var v_sisa = (data.sisa != null ? Math.round(data.sisa.replace(',','.')) : "0");
                var v_nik = (data.nik != null ? data.nik.trim() : "");

                $('[name="type"]').val('EDIT');
                $('[name="docno"]').val(data.docno).prop("readonly", true);
                $('[name="nik"]').selectize()[0].selectize.setValue(v_nik,true);
                $('[name="description"]').val(data.description.trim());
                $('[name="tgl"]').datepicker().datepicker("setDate", new Date(data.tgl)).prop("disabled", true);
                $('[name="nominal"]').val(v_nominal).prop("readonly", false);
                $('[name="tenor"]').val(data.tenor).prop("readonly", false);
                $('[name="npotong"]').val(v_npotong).prop("readonly", false);
                $('[name="sisa"]').val(v_sisa).prop("readonly", true);
                $('#nik').selectize()[0].selectize.disable();


                //$('[name="dob"]').datepicker('update',data.dob);
                $('#btnSave').removeClass("btn-danger").addClass("btn-primary").text('Ubah');
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Data Pinjaman'); // Set title to Bootstrap modal title
                $(".modal").on("hidden.bs.modal", function(){
                    $(this).removeData();
                });

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function hapus_pinjaman(id)
    {
        save_method = 'delete';
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('pinjaman/pinjaman/show_edit_pinjaman/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                var v_nominal = (data.nominal != null ? Math.round(data.nominal.replace(',','.')) : "0");
                var v_npotong = (data.npotong != null ? Math.round(data.npotong.replace(',','.')) : "0");
                var v_sisa = (data.sisa != null ? Math.round(data.sisa.replace(',','.')) : "0");
                var v_nik = (data.nik != null ? data.nik.trim() : "");

                $('[name="type"]').val('DELETE');
                $('[name="docno"]').val(data.docno).prop("readonly", true);
                $('[name="nik"]').selectize()[0].selectize.setValue(v_nik,true);
                $('[name="description"]').val(data.description.trim()).prop("readonly", true);
                $('[name="tgl"]').datepicker().datepicker("setDate", new Date(data.tgl)).prop("disabled", true);
                $('[name="nominal"]').val(v_nominal).prop("readonly", true);
                $('[name="tenor"]').val(data.tenor).prop("readonly", true);
                $('[name="npotong"]').val(v_npotong).prop("readonly", true);
                $('[name="sisa"]').val(v_sisa).prop("readonly", true);
                $('#nik').selectize()[0].selectize.disable();
                $('#btnSave').removeClass("btn-primary").addClass("btn-danger").text('Batalkan');
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

function persetujuan_pinjaman(id)
{
    save_method = 'approve';
    $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
    $('form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('pinjaman/pinjaman/show_edit_pinjaman/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            var v_nominal = (data.nominal != null ? Math.round(data.nominal.replace(',','.')) : "0");
            var v_npotong = (data.npotong != null ? Math.round(data.npotong.replace(',','.')) : "0");
            var v_sisa = (data.sisa != null ? Math.round(data.sisa.replace(',','.')) : "0");
            var v_nik = (data.nik != null ? data.nik.trim() : "");

            $('[name="type"]').val('APPROVE');
            $('[name="docno"]').val(data.docno).prop("readonly", true);
            $('[name="nik"]').selectize()[0].selectize.setValue(v_nik,true);
            $('[name="description"]').val(data.description.trim()).prop("readonly", true);
            $('[name="tgl"]').datepicker().datepicker("setDate", new Date(data.tgl)).prop("disabled", true);
            $('[name="nominal"]').val(v_nominal).prop("readonly", true);
            $('[name="tenor"]').val(data.tenor).prop("readonly", true);
            $('[name="npotong"]').val(v_npotong).prop("readonly", true);
            $('[name="sisa"]').val(v_sisa).prop("readonly", true);
            $('#nik').selectize()[0].selectize.disable();
            $('#btnSave').removeClass("btn-danger").addClass("btn-success").text('Setujui');
            $('#btnSave').removeClass("btn-primary").addClass("btn-success").text('Setujui');
            //$('[name="dob"]').datepicker('update',data.dob);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Persetujuan Pinjaman'); // Set title to Bootstrap modal title

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
        //console.log( validator.isValid());

        if (validator.isValid())
        {
            // do some stuff
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable
            $('[name="description"]').prop('required',true);

            var url;

            if(save_method == 'add') {
                url = "<?php echo site_url('pinjaman/pinjaman/save_pinjaman')?>";
            }else if(save_method == 'update'){
                url = "<?php echo site_url('pinjaman/pinjaman/save_pinjaman')?>";
            }else if(save_method == 'delete') {
                url = "<?php echo site_url('pinjaman/pinjaman/save_pinjaman')?>";
            }else if(save_method == 'approve') {
                url = "<?php echo site_url('pinjaman/pinjaman/save_pinjaman')?>";
            }

            // ajax adding data to database
            $.ajax({
                url : url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data)
                {

                    if(data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        reload_table();
                    }

                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable


                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Gagal Menyimpan / Ubah data / data sudah ada');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable

                }
            });
        } else {
            console.log("Ada data yang belum terpenuhi !!");
        }
    }


</script>