<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 4/25/19 1:40 PM
 *  * Last Modified: 4/12/19 11:32 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

?>

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
<div class="row">
    <div class="col-sm-3">
        <!--div class="container"--->
        <div class="dropdown ">
            <button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu
                <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Filter"  href="#"><i class="fa fa-search"></i>Filter Pencarian</a></li>
            </ul>
        </div>
        <!--/div-->
    </div><!-- /.box-header -->
</div>
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3> </h3>
        </div>
        <div class="col-sm-12">
           <!-- <a href="<!?php /*echo site_url("payroll/tetap");*/?>" class="btn btn-default" style="margin:0px; color:#000000;">
                <i class="fa fa-arrow-left"> Kembali </i></a>-->
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive" style='overflow-x:scroll;'>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="1%">No.</th>
                <th>Nik</th>
                <th>Nama Lengkap</th>
                <th>Group</th>
                <th>Periode</th>
                <th>Gaji Pokok</th>
                <th>Gaji Tetap</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<div class="modal fade" id="Filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN PERIODE </h4>
            </div>
            <form action="<?php echo site_url('payroll/setting/index')?>" method="post" name="FORMX">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH FILTER PERIODE </label>
                                            <div class="col-sm-8">
                                                <input type="input" name="periode" id="tglYM" class="form-control input-sm  tglYM"  >
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
        $("#example2").dataTable();
        $("#example3").dataTable();
        $("#dateinput").datepicker();
        $("#dateinput1").datepicker();
        $("#dateinput2").datepicker();
        $("#dateinput3").datepicker();
        $("[data-mask]").inputmask();
        $('.tglYM').datepicker({
            format: "yyyymm",
            viewMode: "months",
            minViewMode: "months"
        });

        $modal = $('.lod');
        $('#table').on('click', '.showon', function () {
            //var data = $('#example1').DataTable().row( this ).data();
            //alert( 'You clicked on '+data[0]+'\'s row' );
            var el = $(this);
            //alert(el.attr('data-url'));
            $modal.load(el.attr('data-url'), '', function(){
                $modal.modal();
            } );
        } );

        table = $('#table').DataTable({


            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "language": {
                <?php echo $this->fiky_encryption->constant('datatable_language'); ?>
            },
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('payroll/setting/list_gaji_per_periode'.'/'.$enc_periode)?>",
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
    });
    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }

</script>