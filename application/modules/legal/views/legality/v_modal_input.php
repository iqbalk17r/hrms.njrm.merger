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

<!-- Font Awesome -->
<link rel="stylesheet" href="<?= base_url('assets/alte3/plugins/fontawesome-pro/css/all.min.css') ?>">
<!-- Ionicons -->
<link rel="stylesheet" href="<?= base_url('assets/alte3/datatablesEditor/css/ionicons.min.css') ?>">
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets/alte3/plugins/datatables-bs4/css/dataTables.bootstrap4.css') ?>">
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('assets/alte3/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/alte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<!-- daterange picker -->
<link rel="stylesheet" href="<?= base_url('assets/alte3/plugins/daterangepicker/daterangepicker.css') ?>">
<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url('assets/alte3/dist/css/adminlte.min.css') ?>">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- bootstrap validator -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/fiky-validator/css/bootstrapValidator4.css') ?>" type="text/css" />
<!--
<link rel="stylesheet" href="<?/*= 'https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css' */?>">--><!--
<link rel="stylesheet" href="<?/*= 'https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css' */?>">
<link rel="stylesheet" href="<?/*= 'https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css' */?>">-->
<!--<link rel="stylesheet" type="text/css" href="<?/*= base_url('assets/datatablesEditor/css/editor.dataTables.min.css') */?>">-->
<!--<link rel="stylesheet" type="text/css" href="<?/*= base_url('assets/datatablesEditor/resources/syntax/shCore.css') */?>">
<link rel="stylesheet" type="text/css" href="<?/*= base_url('assets/datatablesEditor/resources/demo.css') */?>">
-->

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/alte3/datatablesEditor/css/buttons.bootstrap4.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/alte3/datatablesEditor/css/select.bootstrap4.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/alte3/datatablesEditor/css/editor.bootstrap4.css') ?>">
<style>

    .mb-3, .my-3 {
        margin-bottom: 0rem!important;
    }
    .form-group {
        margin-bottom: 0rem;
    }
</style>


<!-- form start -->
<div class="card card-secondary">
    <div class="card-header">
        <h5 class="card-title text-center"><?= $title ?></h5>
    </div>
    <!-- card start -->
    <form action="#" id="form" class="form-horizontal zform" role="form">
    <div class="card-body">
        <div class="row">
            <div class="row col-sm-12">
            <div class="col-sm-6">
               <!-- <div class="form-group mb-3">
                    <label for="docno">Sistem Document</label>

                </div>-->
                <div class="form-group mb-3">
                    <label>Type Perkara</label>
                    <input type="hidden" class="form-control" id="docno" name="docno" placeholder="System Document"  >
                    <select class="form-control  form-control-sm insv" id="doctype" name="doctype">
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Pilih Pelanggan</label>
                    <select class="form-control  form-control-sm intl insv" id="coperator" name="coperator" >
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Nama Pelanggan/Lainya</label>
                    <input type="text" class="form-control insv" id="coperatorname" name="coperatorname" placeholder="Nama Pelanggan"  style="text-transform:uppercase" readonly>
                </div>
                <div class="form-group mb-3">
                    <label>Pilih Wilayah</label>
                    <select class="form-control mb-3 insv" id="idbu" name="idbu" >

                    </select>
                    <input type="hidden" class="form-control insv" id="nmbu"  name="nmbu" placeholder="IDBUNAME" MAXLENGTH="20" style="text-transform:uppercase" READONLY >
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group mb-3">
                    <label for="docref">Input Dokumen Perkara</label>
                    <input type="text" class="form-control mb-3 insv" id="docref" name="docref" placeholder="Dokumen Perkara" style="text-transform:uppercase"  MAXLENGTH="20" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="docrefname">Input Nama Perkara</label>
                    <input type="text" class="form-control mb-3 insv" id="docrefname" name="docrefname" placeholder="Nama Perkara" style="text-transform:uppercase"  MAXLENGTH="20">
                </div>
                <div class="form-group mb-3">
                    <label for="docrefname">Input Keterangan</label>
                    <textarea type="text" class="form-control insv" id="description" name="description" rows="4" placeholder="Input Keterangan" style="text-transform:uppercase" ></textarea>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6 mb-3">
                        <label for="docref">Upaya Permulaan</label>
                        <input type="hidden" class="form-control insv" id="docname"  name="docname" placeholder="Upaya Dokumen" MAXLENGTH="20" style="text-transform:uppercase" READONLY >
                        <input type="text" class="form-control insv" id="nmdocname"  name="nmdocname" placeholder="Upaya Permulaan" MAXLENGTH="20" style="text-transform:uppercase" READONLY >
                    </div>
                    <div class="form-group col-sm-6 mb-3">
                        <label for="docref">Status</label>
                        <input type="hidden" class="form-control insv" id="status"  name="status" placeholder="Status Dokumen" MAXLENGTH="20" style="text-transform:uppercase" READONLY >
                        <input type="text" class="form-control insv" id="nmstatus"  name="nmstatus" placeholder="Status" MAXLENGTH="20" style="text-transform:uppercase" READONLY >
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="docref">Progres</label>
                    <input type="text" class="form-control insv" id="progress"  name="progress" placeholder="progress"  style="text-transform:uppercase" READONLY >
                </div>
                <!--<div class="form-group">
                    <label for="exampleInputFile">Dokumen Attachment</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Upload Dokumen Pendukung Perkara</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                        </div>
                    </div>
                </div>-->
            </div>
            </div>
            <div class="col-sm-12 " >
                <div class="card-footer">
                    <button class="btn btn-warning float-lg-right" id="finaldata" onclick="finalisasi_entry()"><i class="fa fa-repeat"></i> Final </button>
                    <button class="btn btn-primary float-lg-right" id="btnSave" onclick="save()" ><i class="fa fa-save"></i> Simpan Master </button>

                </div>
            </div>
            <div class="col-sm-12 " >
                <button type="button" class="btn btn-primary" onclick="reload_table()">
                    <i class="fa fa-sync"></i> Reload
                </button>
                <button type="button" class="btn btn-primary" onclick="detailLegalInput()">
                    <i class="fa fa-plus"></i> Add
                </button>
                <table id="dtEditor" class="display table table-striped" style="width:100%">
                    <thead  class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Action</th>
                        <th>Dokumen Ref</th>
                        <th>Docdate</th>
                        <th>Tanggal Penyelesaian</th>
                        <th>Penanganan</th>
                        <th>Status</th>
                        <th>Lampiran</th>
                        <th>Progress</th>
                    </tr>
                    </thead>
                    <tfoot  class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Action</th>
                        <th>Dokumen Ref</th>
                        <th>Docdate</th>
                        <th>Tanggal Penyelesaian</th>
                        <th>Penanganan</th>
                        <th>Status</th>
                        <th>Lampiran</th>
                        <th>Progress</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
    </div>
    </div>
    <!-- /.card-body -->
    </form>
</div>

<!--<div id="customForm">
    <fieldset class="name">
        <legend>Name</legend>
        <editor-field name="first_name"></editor-field>
        <editor-field name="last_name"></editor-field>
    </fieldset>
    <fieldset class="office">
        <legend>Office</legend>
        <editor-field name="office"></editor-field>
        <editor-field name="extn"></editor-field>
    </fieldset>
    <fieldset class="hr">
        <legend>HR info</legend>
        <editor-field name="position"></editor-field>
        <editor-field name="salary"></editor-field>
        <editor-field name="start_date"></editor-field>
    </fieldset>
</div>-->

<div class="modal fade" id="modal-lg-detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Legalitas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="formdetail" class="form-horizontal formdetail" role="form" enctype="multipart/form-data">
            <div class="modal-body">

                    <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="docno_mdl">Sistem Document</label>
                                    <input type="hidden" class="form-control form-control-sm" id="type" name="type" >
                                    <input type="hidden" class="form-control form-control-sm" id="sort" name="sort" >
                                    <input type="text" class="form-control form-control-sm" id="docno" name="docno" placeholder="System Document" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="docno_mdl">Reference Document</label>
                                    <input type="text" class="form-control form-control-sm" id="docref" name="docref" placeholder="Reference Document" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Pilih Tanggal Penyelesaian</label>
                                <input type="text" class="form-control form-control-sm" id="dateoperation" name="dateoperation" placeholder="Tanggal Penyelesaian">
                            </div>
                        <div class="form-group">
                            <label>Kategori Penanganan</label>
                            <select class="form-control" style="width: 100%;" id="operationcategory" name="operationcategory" >

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Progress</label>
                            <input type="text" class="form-control" style="width: 100%;text-transform: uppercase;" id="progress" name="progress" maxlength="50" required>

                        </div>
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="attachment" name="attachment">
                                        <label class="custom-file-label" for="attachment">Pilih File/Dokumen</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- /.card-body -->

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary float-right" id="saveDetail"  onclick="savedet()"><i class="fa fa-save"></i> Save changes</button>
                <!--<button type="button" class="btn btn-warning float-right" id="finalDetail"  onclick="savedet()"><i class="fa fa-check"></i> Final</button>-->
                <button type="button" class="btn btn-danger float-right" id="deleteDetail"  onclick="savedet()"><i class="fa fa-trash"></i>Delete</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




<!-- jQuery -->
<script type="text/javascript" language="javascript" src="<?= base_url('assets/alte3/jquery/jquery-3.5.1.js') ?>"></script>

<!--<script src="<?/*= base_url('assets/alte3/plugins/jquery/jquery.min.js') */?>"></script>-->
<!-- InputMask -->
<script src="<?= base_url('assets/alte3/plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/alte3/plugins/inputmask/min/jquery.inputmask.bundle.min.js') ?>"></script>


<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/alte3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- bs-custom-file-input -->
<script src="<?= base_url('assets/alte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
<!-- DataTables -->
<script src="<?= base_url('assets/alte3/plugins/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?= base_url('assets/alte3/plugins/datatables-bs4/js/dataTables.bootstrap4.js') ?>"></script>
<!--Validator -->
<script type="text/javascript" src="<?= base_url('assets/plugins/fiky-validator/js/bootstrapValidator.js') ?>">></script>
<!-- Select2 -->
<script type="text/javascript" src="<?= base_url('assets/alte3/plugins/select2/js/select2.full.min.js') ?>"></script>
<!-- date-range-picker -->
<script src="<?= base_url('assets/alte3/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!-- bs-custom-file-input -->
<script src="<?= base_url('assets/alte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/alte3/dist/js/adminlte.min.js') ?>"></script>


<script src="<?= base_url('assets/alte3/datatablesEditor/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/alte3/datatablesEditor/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/alte3/datatablesEditor/js/dataTables.select.min.js') ?>"></script>
<script src="<?= base_url('assets/alte3/datatablesEditor/js/dataTables.editor.js') ?>"></script>
<script src="<?= base_url('assets/alte3/datatablesEditor/js/editor.bootstrap4.js') ?>"></script>
<!--
<script type="text/javascript" language="javascript" src="<?/*= base_url('assets/datatablesEditor/resources/syntax/shCore.js') */?>"></script>
<script type="text/javascript" language="javascript" src="<?/*= base_url('assets/datatablesEditor/resources/demo.js') */?>"></script>
<script type="text/javascript" language="javascript" src="<?/*= base_url('assets/datatablesEditor/resources/editor-demo.js') */?>"></script>-->
<!--<script src="<?/*= 'https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js' */?>"></script>
<script src="<?/*= 'https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js' */?>"></script>
<script src="<?/*= 'https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js' */?>"></script>-->

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
<script src="<?= base_url('assets/pagejs/legal/input_form_legal.js') ?>"></script>
