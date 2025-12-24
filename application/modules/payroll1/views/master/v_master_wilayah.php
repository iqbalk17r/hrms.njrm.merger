<?php
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
            <button class="btn btn-success" onclick="add_wilayah()"><i class="glyphicon glyphicon-plus"></i> Input </button>
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive" style='overflow-x:scroll;'>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="1%" >No.</th>
                <th>Kode Wilayah</th>
                <th>Nama Wilayah</th>
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
                <h3 class="modal-title">Input Data Wilayah</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="INPUT" name="type"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">KODE WILAYAH</label>
                            <div class="col-md-9">
                                <input name="kdwilayah" placeholder="KODE WILAYAH" class="form-control inform" type="text" MAXLENGTH="6" style="text-transform:uppercase;" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">NAMA WILAYAH</label>
                            <div class="col-md-9">
                                <input name="nmwilayah" placeholder="NAMA WILAYAH" class="form-control inform" type="text" MAXLENGTH="30" style="text-transform:uppercase;">
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
                "url": "<?php echo site_url('payroll/master/list_maswil')?>",
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



    function add_wilayah()
    {
        save_method = 'add';
        var validator = $('#form').data('bootstrapValidator');
        validator.resetForm();
        $('.inform').removeAttr("disabled").removeAttr("readonly").removeAttr("text");
        $('#form')[0].reset(); // reset form on modals
        //$('.form-group').removeClass('has-error').removeClass('has-success'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Input Data Wilayah'); // Set Title to Bootstrap modal title
        $('[name="type"]').val('INPUT');
        $('[name="kdwilayah"]').prop("required", true);
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
                $('[name="kdwilayah"]').val(data.kdwilayah);
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
                url = "<?php echo site_url('payroll/master/save_wilayah')?>";
            } else if (save_method == 'update') {
                url = "<?php echo site_url('payroll/master/save_wilayah')?>";
            } else if (save_method == 'delete') {
                url = "<?php echo site_url('payroll/master/save_wilayah')?>";
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