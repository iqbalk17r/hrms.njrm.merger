<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/select2/select2.min.css') ?>">
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #2a5d78;
        border-color: #2e90c8;
        padding: 1px 10px;
        color: #fff;
    }
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

<style>
    .center {
        text-align: center;
        border: 3px solid green;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <a tabindex="-1" data-toggle="modal" data-target="#filter" href="#" class="btn btn-warning" style="margin-bottom:10px; color:#ffffff;">
            <i class="fa fa-filter"> Filter </i></a>
    </div>
    <div class="col-lg-12">

    </div>
    <div class="col-sm-12">
        <!--sby-->
        <div class="box box-success .SBY">
            <div class="box-header with-border">
                <h4 style="text-align:center;"><?php echo $title_sby; ?></h4>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body " style='overflow-x:scroll;'>
                <table id="dtSBY" class="table table-bordered table-striped table-responsive compact nowrap" >
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Perkara</th>
                        <th>Wilayah</th>
                        <th>Pelanggan</th>
                        <th>Negosiasi</th>
                        <th>Klarifikasi</th>
                        <th>SP-1</th>
                        <th>SP-2</th>
                        <th>SP-3</th>
                        <th>Somasi</th>
                        <th>Dokumen</th>
                        <th>Progress</th>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <?php /*
        <!--dmk-->
        <div class="box box-success .DMK">
            <div class="box-header with-border">
                <h4 style="text-align:center;"><?php echo $title_dmk; ?></h4>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body " style='overflow-x:scroll;'>
                <table id="dtDMK" class="table table-bordered table-striped table-responsive" >
                    <thead>
                    <tr>
                        <th width="1%">No.</th>
                        <th>Nomor Perkara</th>
                        <th>Pelanggan</th>
                        <th>Negosiasi</th>
                        <th>Klarifikasi</th>
                        <th>SP-1</th>
                        <th>SP-2</th>
                        <th>SP-3</th>
                        <th>Somasi</th>
                        <th>Dokumen</th>
                        <th>Progress</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=0; foreach($DMK as $ldmk): $no++;?>
                        <tr>
                            <td width="1%"><?php echo $no;?></td>
                            <td><?php echo $ldmk->docno;?></td>
                            <td><?php echo $ldmk->coperatorname;?></td>
                            <td><?php if (!empty($ldmk->negosiasi_date)) { echo date('d-m-Y',strtotime($ldmk->negosiasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ldmk->klarifikasi_date)) { echo date('d-m-Y',strtotime($ldmk->klarifikasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ldmk->sp1_date)) { echo date('d-m-Y',strtotime($ldmk->sp1_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ldmk->sp2_date)) { echo date('d-m-Y',strtotime($ldmk->sp2_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ldmk->sp3_date)) { echo date('d-m-Y',strtotime($ldmk->sp3_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ldmk->somasi_date)) { echo date('d-m-Y',strtotime($ldmk->somasi_date)); } else { echo ''; };?></td>
                            <td><?php echo $ldmk->attachment;?></td>
                            <td><?php echo $ldmk->progress;?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!--smg-->
        <div class="box box-success .SMG">
            <div class="box-header with-border">
                <h4 style="text-align:center;"><?php echo $title_smg; ?></h4>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style='overflow-x:scroll;'>
                <table id="dtSMG" class="table table-bordered table-striped table-responsive" >
                    <thead>
                    <tr>
                        <th width="1%">No.</th>
                        <th>Nomor Perkara</th>
                        <th>Pelanggan</th>
                        <th>Negosiasi</th>
                        <th>Klarifikasi</th>
                        <th>SP-1</th>
                        <th>SP-2</th>
                        <th>SP-3</th>
                        <th>Somasi</th>
                        <th>Dokumen</th>
                        <th>Progress</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=0; foreach($SMG as $lsmg): $no++;?>
                        <tr>
                            <td width="1%"><?php echo $no;?></td>
                            <td><?php echo $lsmg->docno;?></td>
                            <td><?php echo $lsmg->coperatorname;?></td>
                            <td><?php if (!empty($lsmg->negosiasi_date)) { echo date('d-m-Y',strtotime($lsmg->negosiasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lsmg->klarifikasi_date)) { echo date('d-m-Y',strtotime($lsmg->klarifikasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lsmg->sp1_date)) { echo date('d-m-Y',strtotime($lsmg->sp1_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lsmg->sp2_date)) { echo date('d-m-Y',strtotime($lsmg->sp2_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lsmg->sp3_date)) { echo date('d-m-Y',strtotime($lsmg->sp3_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lsmg->somasi_date)) { echo date('d-m-Y',strtotime($lsmg->somasi_date)); } else { echo ''; };?></td>
                            <td><?php echo $lsmg->attachment;?></td>
                            <td><?php echo $lsmg->progress;?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!--jog-->
        <div class="box box-success .JOG">
            <div class="box-header with-border">
                <h4 style="text-align:center;"><?php echo $title_jog; ?></h4>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body " style='overflow-x:scroll;'>
                <table id="dtJOG" class="table table-bordered table-striped table-responsive" >
                    <thead>
                    <tr>
                        <th width="1%">No.</th>
                        <th>Nomor Perkara</th>
                        <th>Pelanggan</th>
                        <th>Negosiasi</th>
                        <th>Klarifikasi</th>
                        <th>SP-1</th>
                        <th>SP-2</th>
                        <th>SP-3</th>
                        <th>Somasi</th>
                        <th>Dokumen</th>
                        <th>Progress</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=0; foreach($JOB as $ljog): $no++;?>
                        <tr>
                            <td width="1%"><?php echo $no;?></td>
                            <td><?php echo $ljog->docno;?></td>
                            <td><?php echo $ljog->coperatorname;?></td>
                            <td><?php if (!empty($ljog->negosiasi_date)) { echo date('d-m-Y',strtotime($ljog->negosiasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ljog->klarifikasi_date)) { echo date('d-m-Y',strtotime($ljog->klarifikasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ljog->sp1_date)) { echo date('d-m-Y',strtotime($ljog->sp1_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ljog->sp2_date)) { echo date('d-m-Y',strtotime($ljog->sp2_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ljog->sp3_date)) { echo date('d-m-Y',strtotime($ljog->sp3_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ljog->somasi_date)) { echo date('d-m-Y',strtotime($ljog->somasi_date)); } else { echo ''; };?></td>
                            <td><?php echo $ljog->attachment;?></td>
                            <td><?php echo $ljog->progress;?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!--skh-->
        <div class="box box-success .SKH">
            <div class="box-header with-border">
                <h4 style="text-align:center;"><?php echo $title_skh; ?></h4>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style='overflow-x:scroll;'>
                <table id="dtSKH" class="table table-bordered table-striped table-responsive" >
                    <thead>
                    <tr>
                        <th width="1%">No.</th>
                        <th>Nomor Perkara</th>
                        <th>Pelanggan</th>
                        <th>Negosiasi</th>
                        <th>Klarifikasi</th>
                        <th>SP-1</th>
                        <th>SP-2</th>
                        <th>SP-3</th>
                        <th>Somasi</th>
                        <th>Dokumen</th>
                        <th>Progress</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=0; foreach($SKH as $lskh): $no++;?>
                        <tr>
                            <td width="1%"><?php echo $no;?></td>
                            <td><?php echo $lskh->docno;?></td>
                            <td><?php echo $lskh->coperatorname;?></td>
                            <td><?php if (!empty($lskh->negosiasi_date)) { echo date('d-m-Y',strtotime($lskh->negosiasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lskh->klarifikasi_date)) { echo date('d-m-Y',strtotime($lskh->klarifikasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lskh->sp1_date)) { echo date('d-m-Y',strtotime($lskh->sp1_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lskh->sp2_date)) { echo date('d-m-Y',strtotime($lskh->sp2_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lskh->sp3_date)) { echo date('d-m-Y',strtotime($lskh->sp3_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lskh->somasi_date)) { echo date('d-m-Y',strtotime($lskh->somasi_date)); } else { echo ''; };?></td>
                            <td><?php echo $lskh->attachment;?></td>
                            <td><?php echo $lskh->progress;?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!--jkt-->
        <div class="box box-success .JKT">
            <div class="box-header with-border">
                <h4 style="text-align:center;"><?php echo $title_jkt; ?></h4>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body " style='overflow-x:scroll;'>
                <table id="dtJKT" class="table table-bordered table-striped table-responsive" >
                    <thead>
                    <tr>
                        <th width="1%">No.</th>
                        <th>Nomor Perkara</th>
                        <th>Pelanggan</th>
                        <th>Negosiasi</th>
                        <th>Klarifikasi</th>
                        <th>SP-1</th>
                        <th>SP-2</th>
                        <th>SP-3</th>
                        <th>Somasi</th>
                        <th>Dokumen</th>
                        <th>Progress</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=0; foreach($JKT as $ljkt): $no++;?>
                        <tr>
                            <td width="1%"><?php echo $no;?></td>
                            <td><?php echo $ljkt->docno;?></td>
                            <td><?php echo $ljkt->coperatorname;?></td>
                            <td><?php if (!empty($ljkt->negosiasi_date)) { echo date('d-m-Y',strtotime($ljkt->negosiasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ljkt->klarifikasi_date)) { echo date('d-m-Y',strtotime($ljkt->klarifikasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ljkt->sp1_date)) { echo date('d-m-Y',strtotime($ljkt->sp1_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ljkt->sp2_date)) { echo date('d-m-Y',strtotime($ljkt->sp2_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ljkt->sp3_date)) { echo date('d-m-Y',strtotime($ljkt->sp3_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($ljkt->somasi_date)) { echo date('d-m-Y',strtotime($ljkt->somasi_date)); } else { echo ''; };?></td>
                            <td><?php echo $ljkt->attachment;?></td>
                            <td><?php echo $ljkt->progress;?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!--nas-->
        <div class="box box-success .NAS">
            <div class="box-header with-border">
                <h4 style="text-align:center;"><?php echo $title_nas; ?></h4>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body " style='overflow-x:scroll;'>
                <table id="dtNAS" class="table table-bordered table-striped table-responsive" >
                    <thead>
                    <tr>
                        <th width="1%">No.</th>
                        <th>Nomor Perkara</th>
                        <th>Pelanggan</th>
                        <th>Negosiasi</th>
                        <th>Klarifikasi</th>
                        <th>SP-1</th>
                        <th>SP-2</th>
                        <th>SP-3</th>
                        <th>Somasi</th>
                        <th>Dokumen</th>
                        <th>Progress</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=0; foreach($NAS as $lnas): $no++;?>
                        <tr>
                            <td width="1%"><?php echo $no;?></td>
                            <td><?php echo $lnas->docno;?></td>
                            <td><?php echo $lnas->coperatorname;?></td>
                            <td><?php if (!empty($lnas->negosiasi_date)) { echo date('d-m-Y',strtotime($lnas->negosiasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lnas->klarifikasi_date)) { echo date('d-m-Y',strtotime($lnas->klarifikasi_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lnas->sp1_date)) { echo date('d-m-Y',strtotime($lnas->sp1_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lnas->sp2_date)) { echo date('d-m-Y',strtotime($lnas->sp2_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lnas->sp3_date)) { echo date('d-m-Y',strtotime($lnas->sp3_date)); } else { echo ''; };?></td>
                            <td><?php if (!empty($lnas->somasi_date)) { echo date('d-m-Y',strtotime($lnas->somasi_date)); } else { echo ''; };?></td>
                            <td><?php echo $lnas->attachment;?></td>
                            <td><?php echo $lnas->progress;?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        */ ?>
    </div>
</div>




<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">FILTER ID BRANCH UNIT</h4>
            </div>
            <form id="form-filter" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group input-sm ">
                        <label class="label-form col-sm-3">Pilih ID Branch Unit</label>
                        <div class="col-sm-9">
                        <select class="form-control  form-control-sm"  style="width: 100%" id="idbu" name="idbu"  multiple="multiple">
                            <?php foreach($listkantor as $ls){?>
                            <option value="<?php echo trim($ls->kdcabang);?>"><?php echo trim($ls->desc_cabang);?></option>
                            <?php } ?>
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
<script src="<?= base_url('assets/pagejs/legal/report_legal.js') ?>"></script>
<script>
    $('#idbu').select2({
        createTag: function (params) {
            var term = $.trim(params.term);

            if (term === '') {
                return null;
            }

            return {
                id: term,
                text: term,
                newTag: true // add additional parameters
            }
        }
    });

 /*   function filter(){
        console.log($('#idbu').val());
        var idbu = $('#idbu');

        console.log();
        var x = $('.SBY');
        /!*if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }*!/


        $('#filter').modal("hide");

    }
    function resetx(){
        location.reload();
        console.log('reset');
    }*/
</script>