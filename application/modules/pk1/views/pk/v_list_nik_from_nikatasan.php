<?php
/**
 * Created by PhpStorm.
 * User: FIKY-PC
 * Date: 20/01/2018
 * Time: 10.24
 */
?>
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
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true
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

<div class="row">
    <div class="col-sm-12">
        <a href="<?php echo site_url("pk/form_pk")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
    </div>
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">

            </div><!-- /.box-header -->
            <div class="box-body table-responsive" style='overflow-x:scroll;'>
                <table id="table" class="table table-bordered table-striped" >
                    <thead>
                    <tr>
                        <th  width="1%">No.</th>
                        <th>Action</th>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
                        <th>Department</th>
                        <th>PERIODE</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php /*$no=0; foreach($list_nik as $lu): $no++;*/?><!--
                        <tr>
                            <td width="1%"><?php /*echo $no;*/?></td>
                            <td>

                                    <a href="<?php
/*                                    $enc_nik=bin2hex($this->encrypt->encode(trim($lu->nik)));
                                    $enc_periode=bin2hex($this->encrypt->encode(trim($periode)));
                                    echo site_url('pk/pk/input_generate_pa').'/'.trim($enc_nik).'/'.trim($enc_periode);*/?>"  class="btn btn-info  btn-sm">
                                        <i class="fa fa-edit"></i> Buat PA
                                    </a>

                            </td>
                            <td><?php /*echo $lu->nik;*/?></td>
                            <td><?php /*echo $lu->nmlengkap;*/?></td>
                            <td><?php /*echo $lu->nmdept;*/?></td>
                            <td><?php /*echo $periode; */?></td>


                        </tr>
                    --><?php /*endforeach;*/?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
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
                "url": "<?php echo site_url('pk/pk/list_paginate_input_nik_pa').'/'.$periode?>",
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

</script>
