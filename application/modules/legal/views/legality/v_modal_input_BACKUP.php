<?php
/*
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 10/21/20, 3:11 PM
 *  * Last Modified: 10/21/20, 3:11 PM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2020 .All rights reserved.
 *
 */

?>

<link rel="stylesheet" href="<?= 'https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css' ?>">
<link rel="stylesheet" href="<?= 'https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css' ?>">
<link rel="stylesheet" href="<?= 'https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css' ?>">

<link rel="stylesheet" href="<?= 'https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css' ?>">
<link rel="stylesheet" href="<?= 'https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css' ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/datatablesEditor/css/editor.dataTables.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/datatablesEditor/resources/syntax/shCore.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/datatablesEditor/resources/demo.css') ?>">





<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <form>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <legend align="center"><?php echo $title ;?></legend>
            <!--?php echo $message;?-->

            <!--h4 class="modal-title" id="myModalLabel">Transaksi Bulan</h4--->
        </div>
        <div class="modal-body">
            <div class="">
                <!--div class="box-header with-border">
                    <h3 class="box-title">Horizontal Form</h3>
                </div>-->
                <!-- /.box-header -->
                <!-- form start -->
                    <div class="box-body">
                        <div class="row col-lg-6">
                            <div class="form-group ">
                                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-lg-6">
                            <div class="form-group ">
                                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="">
                        <table id="dtEditor" class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Extn.</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Extn.</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-footer -->
            </div>
        </div>
        <div class="modal-footer">
                <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Sign in</button>
        </div>

        </form>
    </div>
</div>



<script src="<?= 'https://code.jquery.com/jquery-3.5.1.js' ?>"></script>
<script src="<?= 'https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js' ?>"></script>
<script src="<?= 'https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js' ?>"></script>
<script src="<?= 'https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js' ?>"></script>

<script type="text/javascript" language="javascript" src="<?= base_url('assets/datatablesEditor/js/dataTables.editor.min.js') ?>"></script>
<script type="text/javascript" language="javascript" src="<?= base_url('assets/datatablesEditor/resources/syntax/shCore.js') ?>"></script>
<script type="text/javascript" language="javascript" src="<?= base_url('assets/datatablesEditor/resources/demo.js') ?>"></script>
<script type="text/javascript" language="javascript" src="<?= base_url('assets/datatablesEditor/resources/editor-demo.js') ?>"></script>
<script type="text/javascript">
    //<![CDATA[
    var base = function(url){
        return '<?php echo base_url();?>' + url;
    }
    var site = function(url){
        return base(url) + '';
    }
    var debugmode = function() {
        return <?php echo ($this->config->item('debugmode')) ? 'true' : 'false';?>;
    }

    var languageDatatable = function (){ return { <?php echo $this->fiky_encryption->constant('datatable_language'); ?>  }  }
    //]]>

</script>

<script type="text/javascript" >

    var editor;
    function DatatableEditor(){
        // var lg = languageDatatable;
        var initTableEditor = function () {
            console.log("DatatableEditor Is RUnning");
            editor = new $.fn.DataTable.Editor( {
                ajax: base('api/legality/ajaxtest'),
                table: "#dtEditor",
                fields: [ {
                    label: "First name:",
                    name: "first_name"
                }, {
                    label: "Last name:",
                    name: "last_name"
                }, {
                    label: "Position:",
                    name: "position"
                }, {
                    label: "Office:",
                    name: "office"
                }, {
                    label: "Extension:",
                    name: "extn"
                }, {
                    label: "Start date:",
                    name: "start_date",
                    type: "datetime"
                }, {
                    label: "Salary:",
                    name: "salary"
                }
                ]
            } );

            $('#dtEditor').DataTable( {
                dom: "Bfrtip",
                ajax: base('api/legality/ajaxtest'),
                columns: [
                    { data: null, render: function ( data, type, row ) {
                            // Combine the first and last names into a single table field
                            return data.first_name+' '+data.last_name;
                        } },
                    { data: "position" },
                    { data: "office" },
                    { data: "extn" },
                    { data: "start_date" },
                    { data: "salary", render: $.fn.DataTable.render.number( ',', '.', 0, '$' ) }
                ],
                select: true,
                buttons: [
                    { extend: "create", editor: editor },
                    { extend: "edit",   editor: editor },
                    { extend: "remove", editor: editor }
                ]
            } );

        }
        return initTableEditor();
    }


    $(document).ready(function() {
        DatatableEditor();
    });
</script>
