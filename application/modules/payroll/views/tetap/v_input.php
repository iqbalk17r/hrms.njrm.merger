<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 4/25/19 8:57 AM
 *  * Last Modified: 4/24/19 8:28 AM.
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
<h5>Group Penggajian : <?php echo $nmlengkap;?> </h5>

<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3> </h3>
        </div>
        <div class="col-sm-12">
            <a href="<?php echo site_url("payroll/tetap");?>" class="btn btn-default" style="margin:0px; color:#000000;">
                <i class="fa fa-arrow-left"> Kembali </i></a>
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            <button class="btn btn-warning pull-right" onclick="upload_sinkron_data()"><i class="glyphicon glyphicon-refresh"></i> Sinkron Data </button>
            <?php if (trim($setup['value1']) == 'B') { ?>
                <button class="btn btn-default pull-right" onclick="recalculate()"><i class="glyphicon glyphicon-refresh"></i> Recalculate </button>
            <?php } ?>

            <input id="boming" type="hidden" value="<?php// echo $xvar; ?>">
        </div>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive" style='overflow-x:scroll;'>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                        <th>No.</th>
                        <th>Action</th>
                        <th>Nik</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan</th>
                        <th>Wilayah</th>
                        <th>Grade</th>
                        <th>Level</th>
                        <th>Gaji Pokok</th>
                        <th>Tj Jabatan</th>
                        <th>Tj Masa Kerja</th>
                        <th>Tj Prestasi</th>
                        <th>BPJS Kes</th>
                        <th>BPJS Naker</th>
                        <th>Total Gaji Tetap</th>
                        <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<!--Modal Data Detail -->

<div  class="modal fade lod" id="modal_form"  data-backdrop="static">
    <!-- Content will be loaded here from "remote.php" file -->
</div>
<!---End Modal Data --->

<!-- Modal Loader -->
<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="loader"></div>
                <div clas="loader-txt">
                    <h4><p class="saving"><span>Mohon </span><span> Tunggu</span></p></h4>
                    <h5>
                        <p class="saving">Sedang Melakukan Proses  <span>*</span><span>*</span><span>*</span></p>
                    </h5>
                </div>
            </div>
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
                "url": "<?php echo site_url('payroll/tetap/list_detail_gaji'.'/'.$enc_kdgroup_pg)?>",
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
    function recalculate() {
        var xx= confirm('Proses recalculate akan menarik data penggajian master, ' +
            'Keseluruhan data akan terupdate, Anda yakin...? ');
        var p1='KEY';
        if (xx === true) {
            $("#loadMe").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
            $.ajax("<?php echo site_url('payroll/tetap/recalculate_gaji_wilayah')?>", {
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


    function upload_sinkron_data() {
        var xx= confirm('Proses sinkron data akan menyamakan entitas pengikut karyawan kecuali nominal, ' +
            'Keseluruhan data karyawan pada server akan terupdate, Anda yakin...? ');
        if (xx === true) {
            $("#loadMe").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
            var urlx = "http://hrd.nusaboard.co.id:7070/hrdnew/gridview/sinkron_m_karyawan"
            var bm = $('#boming').val();
            //var urlx = "http://localhost/hrdnew/gridview/sinkron_m_karyawan";
            console.log(bm);
            $.ajax(urlx, {
                type: "POST",
                data: JSON.stringify(<?php echo $xvar; ?>),
                contentType: "application/json",
            }).done(function (data) {
                //var js = jQuery.parseJSON(data);

                console.log(data);

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
</script>