<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/select2/select2.min.css') ?>">
<style>
    .selectize-input {
        overflow: visible;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
    .selectize-input.dropdown-active {
        min-height: 30px;
        line-height: normal;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
    .selectize-dropdown, .selectize-input, .selectize-input input {
        min-height: 30px;
        line-height: normal;
    }
    .loading .selectize-dropdown-content:after {
        content: 'loading...';
        height: 30px;
        display: block;
        text-align: center;
    }

    .select2-selection--single {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        /* transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s; */
    }

    .select2-selection--single {
        border-radius: 0;
        box-shadow: none;
        border-color: #d2d6de;
        font-size: 14px;
        line-height: 2;
        color: #555;
    }

    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 34px;
        width: 405px;
        user-select: none;
        -webkit-user-select: none;
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
<?php echo $message;?>

<div class="box">
    <div class="box-header">
        <input type="hidden" value="<?= $cektmp ?>" id="cektmplegal">
        <input type="hidden" id="fortriggerframe">
            <a tabindex="-1" data-toggle="modal" data-target="#filter"  href="#" class="btn btn-default" style="margin:0px; color:#000000;">
                <i class="fa fa-filter"> Filter </i></a>
            <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            <a data-toggle="modal" data-url="<?php echo site_url('legal/legality/input_form_legal') ;?>" class="btn btn-warning pull-right buttonLoadModal"><i class="fa fa-plus"></i> Input Data </a>
            <!--<a data-toggle="modal" data-target="#modal_frame" class="btn btn-warning pull-right"><i class="fa fa-plus"></i> Kontol </a>-->
    </div><!-- /.box-header -->
    <div class="box-body  table-responsive" style='overflow-x:scroll;'>
        <table id="legalDatatable" class="table table-bordered table-striped" >
            <thead>
            <tr>
                <th width="1%">No.</th>
                <th width="8%">Aksi</th>
                <th>Nomor Perkara</th>
                <th>Dokumen</th>
                <th>Tipe</th>
                <th>Pelanggan</th>
                <th>Wilayah</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Penanganan</th>
                <th>Progress</th>

            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<!--Modal Data Detail -->

<!--<div  class="modal fade lod" id="modal_form"  data-backdrop="static">
 content
</div>-->

<!-- Bootstrap modal -->
<div  class="modal fade lod" id="modal_form"  data-backdrop="static">
    <div class="modal-dialog  modal-xl">
        <!--<div class="modal-content">
            <iframe src="<?php /*echo site_url('legal/legality/input_form_legal') ;*/?>" width="100%" height="500%"></iframe>
        </div>-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="buttonDismiss"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">INPUT DATA </h4>
            </div>
            <div class="modal-body">
                <!-- 21:9 aspect ratio -->
                <!--<div class="embed-responsive embed-responsive-21by9">
                    <iframe class="embed-responsive-item" src="<?php /*echo site_url('legal/legality/input_form_legal') ;*/?> "></iframe>
                </div>-->

                <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                    <iframe class="embed-responsive-item embeding" src="#" allowfullscreen></iframe>
                </div>

                <!--<div style="--aspect-ratio: 16/9;">
                    <iframe
                            src="<?php /*echo site_url('legal/legality/input_form_legal') ;*/?>"
                            width="1000"
                            height="600"
                            frameborder="0"
                    >
                    </iframe>
                </div>-->
            </div>
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!---End Modal Data --->
<!--<style>
    [style*="--aspect-ratio"] > :first-child {
        width: 100%;
    }
    [style*="--aspect-ratio"] > img {
        height: auto;
    }
    @supports (--custom:property) {
        [style*="--aspect-ratio"] {
            position: relative;
        }
        [style*="--aspect-ratio"]::before {
            content: "";
            display: block;
            padding-bottom: calc(100% / (var(--aspect-ratio)));
        }
        [style*="--aspect-ratio"] > :first-child {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
        }
    }
</style>-->
<!-- Bootstrap modal -->
<div class="modal fade"  data-backdrop="static" id="modal_frame" role="dialog">
    <div class="modal-dialog  modal-xl">
        <!--<div class="modal-content">
            <iframe src="<?php /*echo site_url('legal/legality/input_form_legal') ;*/?>" width="100%" height="500%"></iframe>
        </div>-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">INPUT DATA </h4>
            </div>
            <div class="modal-body">
                <!-- 21:9 aspect ratio -->
                <!--<div class="embed-responsive embed-responsive-21by9">
                    <iframe class="embed-responsive-item" src="<?php /*echo site_url('legal/legality/input_form_legal') ;*/?> "></iframe>
                </div>-->

                <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                   <!-- <iframe class="embed-responsive-item" src="<?php /*echo site_url('legal/legality/input_form_legal') ;*/?>" allowfullscreen></iframe>-->
                </div>

                <!--<div style="--aspect-ratio: 16/9;">
                    <iframe
                            src="<?php /*echo site_url('legal/legality/input_form_legal') ;*/?>"
                            width="1000"
                            height="600"
                            frameborder="0"
                    >
                    </iframe>
                </div>-->
            </div>
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">FILTER TANGGAL DOKUMEN</h4>
            </div>
            <form id="form-filter" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Tanggal Dokumen</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm tglrange" id="tglrange" name="tglrange" value="" data-date-format="dd-mm-yyyy" required>
                        </div>
                    </div>
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Pilih Pelanggan</label>
                        <div class="col-sm-9">
                        <select class="form-control  form-control-sm"  style="width: 100%" id="fcoperator" name="fcoperator" >
                        </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                    <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Select2 -->
<script src="<?= base_url('assets/plugins/select2/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/pagejs/legal/form_legal.js') ?>"></script>
