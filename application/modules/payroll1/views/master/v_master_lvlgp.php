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
            <button class="btn btn-success focusnya" onclick="add_kdlvlgp()"><i class="glyphicon glyphicon-plus"></i> Input </button>
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive" style='overflow-x:scroll;'>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="1%" >No.</th>
                <th>Kode Level</th>
                <th>Nominal</th>
                <th>Hold</th>
                <th width="10%">Action</th>
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
                <h3 class="modal-title">Input Level Gaji</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="INPUT" name="type"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">KODE OPTION</label>
                            <div class="col-md-9">
                                <input name="kdlvlgp" placeholder="KODE LEVEL GP" class="form-control inform" type="text" style="text-transform:uppercase;"  MAXLENGTH="4" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">NOMINAL</label>
                            <div class="col-md-9">
                                <input onClick="this.select();" name="nominal" placeholder="INPUT NOMINAL" value="0" class="form-control inform ratakanan c_hold fikyseparator" type="text" MAXLENGTH="18" style="text-transform:uppercase;">  <!-- onkeyup="formatangkaobjek(this)"-->
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
    function formatangkaobjek(objek) {
        a = objek.value.toString();
        //  alert(a);
        //  alert(objek);
        b = a.replace(/[^\d]/g,"");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i-1,1) + "." + c;
            } else {
                c = b.substr(i-1,1) + c;
            }
        }
        objek.value = c;
    }
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
                "url": "<?php echo site_url('payroll/master/list_mas_lvlgp')?>",
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



    function add_kdlvlgp()
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
        $('[name="kdlvlgp"]').focus();
    }

    function ubah_lvlgp(id)
    {
        save_method = 'update';
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('.rmchild').remove();
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('payroll/master/show_mas_lvlgp/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                /*variable untuk kondisi khusus table*/
                var v_nominal = (data.nominal != null ? Math.round(data.nominal.replace(',','.')) : "0");
                var v_chold = (data.c_hold != null ? data.c_hold.trim() : "");

                $('[name="type"]').val('EDIT');
                $('[name="kdlvlgp"]').val(data.kdlvlgp).prop("readonly", true);
                $('[name="nominal"]').val(v_nominal);
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

    function hapus_lvlgp(id)
    {
        save_method = 'delete';
        //$('#modal_form').removeData('bs.modal');
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('payroll/master/show_mas_lvlgp/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                /*variable untuk kondisi khusus table*/
                /*variable untuk kondisi khusus table*/
                var v_nominal = (data.nominal != null ? Math.round(data.nominal.replace(',','.')) : "0");
                var v_chold = (data.c_hold != null ? data.c_hold.trim() : "");

                $('[name="type"]').val('DELETE');
                $('[name="kdlvlgp"]').val(data.kdlvlgp).prop("readonly", true);
                $('[name="nominal"]').val(v_nominal).prop("readonly", true);
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
                url = "<?php echo site_url('payroll/master/save_mas_lvlgp')?>";
            } else if (save_method == 'update') {
                url = "<?php echo site_url('payroll/master/save_mas_lvlgp')?>";
            } else if (save_method == 'delete') {
                url = "<?php echo site_url('payroll/master/save_mas_lvlgp')?>";
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