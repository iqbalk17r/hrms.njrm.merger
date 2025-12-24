<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/2/19 1:27 PM
 *  * Last Modified: 4/23/19 9:09 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#dateinput").datepicker();
                $('form').attr("autocomplete", "off");
                $(".focusnya").focus();
            });

</script>
<style>
    .ratakanan { text-align : right; }
</style>

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

<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3> </h3>
        </div>
        <div class="col-sm-12">
            <button class="btn btn-success focusnya" onclick="add_grade_jabatan()"><i class="glyphicon glyphicon-plus"></i> Input </button>
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive" style='overflow-x:scroll;'>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th rowspan="2"  width="1%">No.</th>
                <th rowspan="2">Grouping</th>
                <th rowspan="2">Kode Grade</th>
                <th rowspan="2">Nama Grade</th>
                <th colspan="4" class="text-center">Faktor</th>
                <th colspan="4" class="text-center">Nilai</th>
                <th rowspan="2">Nominal</th>
                <th rowspan="2">Hold</th>
                <th rowspan="2" width="1%">Action</th>
            </tr>
            <tr>
                <td>Tanggung jawab</td>
                <td>Keterampilan/Skill</td>
                <td>Tuntutan Fisik</td>
                <td>Lingkungan Kerja</td>
                <td>Tanggung jawab</td>
                <td>Keterampilan/Skill</td>
                <td>Tuntutan Fisik</td>
                <td>Lingkungan Kerja</td>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Input Level Grade Jabatan</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="INPUT" name="type"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">KODE GROUPING</label>
                            <div class="col-md-9">
                                <input name="groupgradejabatan" id="groupgradejabatan" placeholder="KODE GROUPING" class="form-control inform" type="text" style="text-transform:uppercase;"  MAXLENGTH="6" REQUIRED>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">KODE GRADE JABATAN</label>
                            <div class="col-md-9">
                                <input name="kdgradejabatan" id="kdgradejabatan" placeholder="KODE LEVELING GRADE JABATAN" class="form-control inform" type="text" style="text-transform:uppercase;"  MAXLENGTH="6" REQUIRED>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">NAMA GRADE JABATAN</label>
                            <div class="col-md-9">
                                <input name="nmgradejabatan" id="nmgradejabatan" placeholder="NAMA GRADE JABATAN" class="form-control inform" type="text" style="text-transform:uppercase;"  MAXLENGTH="25" REQUIRED>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Hold</label>
                            <div class="col-md-9">
                                <select name="c_hold" class="form-control c_hold inform" style="text-transform:uppercase;" >
                                    <!--option value="">--Pilih Hold--</option-->
                                    <option value="NO"> NO </option>
                                    <option value="YES">YES </option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div  class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">NILAI TANGGUNG JAWAB</label>
                                <div class="col-md-9">
                                    <input onClick="this.select();" name="fx_a" placeholder="INPUT TANGGUNG JAWAB" value="0" class="form-control inform ratakanan c_hold fikyseparator" type="text" MAXLENGTH="2" style="text-transform:uppercase;">  <!-- onkeyup="formatangkaobjek(this)"-->
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">NILAI KETERAMPILAN/SKILL</label>
                                <div class="col-md-9">
                                    <input onClick="this.select();" name="fx_b" placeholder="INPUT KETERAMPILAN/SKILL" value="0" class="form-control inform ratakanan c_hold fikyseparator" type="text" MAXLENGTH="2" style="text-transform:uppercase;">  <!-- onkeyup="formatangkaobjek(this)"-->
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">NILAI TUNTUTAN KERJA</label>
                                <div class="col-md-9">
                                    <input onClick="this.select();" name="fx_c" placeholder="INPUT TUNTUTAN KERJA" value="0" class="form-control inform ratakanan c_hold fikyseparator" type="text" MAXLENGTH="2" style="text-transform:uppercase;">  <!-- onkeyup="formatangkaobjek(this)"-->
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">NILAI LINGKUNGAN KERJA</label>
                                <div class="col-md-9">
                                    <input onClick="this.select();" name="fx_d" placeholder="LINGKUNGAN KERJA" value="0" class="form-control inform ratakanan c_hold fikyseparator" type="text" MAXLENGTH="2" style="text-transform:uppercase;">  <!-- onkeyup="formatangkaobjek(this)"-->
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div  class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">NOMINAL TANGGUNG JAWAB</label>
                                <div class="col-md-9">
                                    <input onClick="this.select();" name="sn_a" placeholder=" NOMINAL TANGGUNG JAWAB" value="0" class="form-control inform ratakanan c_hold fikyseparator" type="text" MAXLENGTH="18" >  <!-- onkeyup="formatangkaobjek(this)"-->
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">NOMINAL KETERAMPILAN/SKILL</label>
                                <div class="col-md-9">
                                    <input onClick="this.select();" name="sn_b" placeholder="NOMINAL KETERAMPILAN/SKILL" value="0" class="form-control inform ratakanan c_hold fikyseparator" type="text" MAXLENGTH="18" >  <!-- onkeyup="formatangkaobjek(this)"-->
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">NOMINAL TUNTUTAN KERJA</label>
                                <div class="col-md-9">
                                    <input onClick="this.select();" name="sn_c" placeholder="NOMINAL TUNTUTAN KERJA" value="0" class="form-control inform ratakanan c_hold fikyseparator" type="text" MAXLENGTH="18" ">  <!-- onkeyup="formatangkaobjek(this)"-->
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">NOMINAL LINGKUNGAN KERJA</label>
                                <div class="col-md-9">
                                    <input onClick="this.select();" name="sn_d" placeholder="NOMINAL LINGKUNGAN KERJA" value="0" class="form-control inform ratakanan c_hold fikyseparator" type="text" MAXLENGTH="18" ">  <!-- onkeyup="formatangkaobjek(this)"-->
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
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

    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        $('form').on('focus', 'input[type=number]', function (e) {
            $(this).on('mousewheel.disableScroll', function (e) {
                e.preventDefault()
            })
        })


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
                "url": "<?php echo site_url('payroll/master/list_mas_m_grade_jabatan')?>",
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
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });

    });



    function add_grade_jabatan()
    {
        save_method = 'add';
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        }); // show bootstrap modal
        $('.modal-title').text('Input Kode Level & Nominal'); // Set Title to Bootstrap modal title
        $('[name="type"]').val('INPUT');
        $('#btnSave').removeClass("btn-danger").addClass("btn-primary").text('Simpan');
        $('[name="kdlvlgp"]').prop("required", true);
    }

    function ubah_grade_jabatan(id)
    {
        save_method = 'update';
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('.rmchild').remove();
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('payroll/master/show_mas_m_grade_jabatan/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                /*variable untuk kondisi khusus table*/
                var v_fx_a = (data.fx_a != null ? Math.round(data.fx_a.replace(',','.')) : "0");
                var v_fx_b = (data.fx_b != null ? Math.round(data.fx_b.replace(',','.')) : "0");
                var v_fx_c = (data.fx_c != null ? Math.round(data.fx_c.replace(',','.')) : "0");
                var v_fx_d = (data.fx_d != null ? Math.round(data.fx_d.replace(',','.')) : "0");
                var v_fx_e = (data.fx_e != null ? Math.round(data.fx_e.replace(',','.')) : "0");
                var v_sn_a = (data.sn_a != null ? Math.round(data.sn_a.replace(',','.')) : "0");
                var v_sn_b = (data.sn_b != null ? Math.round(data.sn_b.replace(',','.')) : "0");
                var v_sn_c = (data.sn_c != null ? Math.round(data.sn_c.replace(',','.')) : "0");
                var v_sn_d = (data.sn_d != null ? Math.round(data.sn_d.replace(',','.')) : "0");
                var v_sn_e = (data.sn_e != null ? Math.round(data.sn_e.replace(',','.')) : "0");
                var v_chold = (data.c_hold != null ? data.c_hold.trim() : "");

                $('[name="type"]').val('EDIT');
                $("#groupgradejabatan").val(data.groupgradejabatan).prop("required", false);
                $("#kdgradejabatan").val(data.kdgradejabatan).prop("required", false);
                $('[name="groupgradejabatan"]').val(data.groupgradejabatan).prop("readonly", true);
                $('[name="kdgradejabatan"]').val(data.kdgradejabatan).prop("readonly", true);
                $('[name="nmgradejabatan"]').val(data.kdgradejabatan);
                $('[name="fx_a"]').val(v_fx_a);
                $('[name="fx_b"]').val(v_fx_b);
                $('[name="fx_c"]').val(v_fx_c);
                $('[name="fx_d"]').val(v_fx_d);
                $('[name="fx_e"]').val(v_fx_e);
                $('[name="sn_a"]').val(v_sn_a);
                $('[name="sn_b"]').val(v_sn_b);
                $('[name="sn_c"]').val(v_sn_c);
                $('[name="sn_d"]').val(v_sn_d);
                $('[name="sn_e"]').val(v_sn_e);
                //$('[name=""]').val(v_nominal);
                $('[name="c_hold"]').val(v_chold);

                $('#btnSave').removeClass("btn-danger").addClass("btn-primary").text('Ubah');
                $('#modal_form').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                }); // show bootstrap modal
                $('.modal-title').text('Ubah Level Nominal'); // Set title to Bootstrap modal title

                //console.log(data.golongan);
                //console.log(v_nominal);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function hapus_grade_jabatan(id)
    {
        save_method = 'delete';
        //$('#modal_form').removeData('bs.modal');
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('payroll/master/show_mas_m_grade_jabatan/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                /*variable untuk kondisi khusus table*/
                var v_fx_a = (data.fx_a != null ? Math.round(data.fx_a.replace(',','.')) : "0");
                var v_fx_b = (data.fx_b != null ? Math.round(data.fx_b.replace(',','.')) : "0");
                var v_fx_c = (data.fx_c != null ? Math.round(data.fx_c.replace(',','.')) : "0");
                var v_fx_d = (data.fx_d != null ? Math.round(data.fx_d.replace(',','.')) : "0");
                var v_fx_e = (data.fx_e != null ? Math.round(data.fx_e.replace(',','.')) : "0");
                var v_sn_a = (data.sn_a != null ? Math.round(data.sn_a.replace(',','.')) : "0");
                var v_sn_b = (data.sn_b != null ? Math.round(data.sn_b.replace(',','.')) : "0");
                var v_sn_c = (data.sn_c != null ? Math.round(data.sn_c.replace(',','.')) : "0");
                var v_sn_d = (data.sn_d != null ? Math.round(data.sn_d.replace(',','.')) : "0");
                var v_sn_e = (data.sn_e != null ? Math.round(data.sn_e.replace(',','.')) : "0");
                var v_chold = (data.c_hold != null ? data.c_hold.trim() : "");

                $('[name="type"]').val('DELETE');
                $("#groupgradejabatan").val(data.groupgradejabatan).prop("required", false);
                $("#kdgradejabatan").val(data.kdgradejabatan).prop("required", false);
                $('[name="groupgradejabatan"]').val(data.groupgradejabatan).prop("readonly", true);
                $('[name="kdgradejabatan"]').val(data.kdgradejabatan).prop("readonly", true);
                $('[name="nmgradejabatan"]').val(data.kdgradejabatan);
                $('[name="fx_a"]').val(v_fx_a);
                $('[name="fx_b"]').val(v_fx_b);
                $('[name="fx_c"]').val(v_fx_c);
                $('[name="fx_d"]').val(v_fx_d);
                $('[name="fx_e"]').val(v_fx_e);
                $('[name="sn_a"]').val(v_sn_a);
                $('[name="sn_b"]').val(v_sn_b);
                $('[name="sn_c"]').val(v_sn_c);
                $('[name="sn_d"]').val(v_sn_d);
                $('[name="sn_e"]').val(v_sn_e);
                //$('[name=""]').val(v_nominal);
                $('[name="c_hold"]').val(v_chold);
                $('.c_hold').prop("disabled", true);
                $('#btnSave').removeClass("btn-primary").addClass("btn-danger").text('Hapus');
                //$('[name="dob"]').datepicker('update',data.dob);
                $('#modal_form').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                }); // show bootstrap modal
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
                url = "<?php echo site_url('payroll/master/save_mas_m_grade_jabatan')?>";
            } else if (save_method == 'update') {
                url = "<?php echo site_url('payroll/master/save_mas_m_grade_jabatan')?>";
            } else if (save_method == 'delete') {
                url = "<?php echo site_url('payroll/master/save_mas_m_grade_jabatan')?>";
            }

            // ajax adding data to database
            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
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