<?php
//var_dump($this->session->userdata('nik'));
//die();
?>
<style>
    .actionbutton {
        margin-left: 3px;
    }

    .notification {
        background-color: #E74032;
    }

    thead tr th {
        text-align: center;
        text-transform: uppercase;
    }

    thead tr th:first-child {
        padding-right: 8px !important;
    }

    thead tr th,
    tbody tr td {
        border: 0.1px solid #dddddd !important;
    }

    .dataTables_info,
    .dataTables_paginate,
    tbody tr td {
        font-weight: normal;
    }
</style>
<?php if(!is_null($dtlbroadcast)) { ?>
    <div class="row">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" onclick="this.parentNode.parentNode.removeChild(this.parentNode);" class="close"
                    data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h4><strong><i class="fa fa-bullhorn"></i>&nbsp; MOHON PERHATIAN !!!</h4>
            <marquee>
                <h1>
                    <?= trim($dtlbroadcast['keterangan']) ?>
                </h1>
            </marquee>
        </div>
    </div>
<?php } ?>
<?php if(!$isUserhr) { ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $cutiunapproved['title'];
                        if($cutiunapproved['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$cutiunapproved['count'].' Dokumen baru" class="badge badge-success notification" >'.$cutiunapproved['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $cutiunapproved['generatetable'];
                        echo $cutiunapproved['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <div class="box-footer">
                    <a href="<?php echo site_url('trans/cuti_karyawan') ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $ijinunapproved['title'];
                        if($ijinunapproved['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$ijinunapproved['count'].' Dokumen baru" class="badge badge-success notification" >'.$ijinunapproved['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $ijinunapproved['generatetable'];
                        echo $ijinunapproved['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="<?php echo site_url('trans/ijin_karyawan') ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $lemburunapproved['title'];
                        if($lemburunapproved['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$lemburunapproved['count'].' Dokumen baru" class="badge badge-success notification" >'.$lemburunapproved['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $lemburunapproved['generatetable'];
                        echo $lemburunapproved['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="<?php echo site_url('trans/lembur') ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $dinasunapproved['title'];
                        if($dinasunapproved['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$dinasunapproved['count'].' Dokumen baru" class="badge badge-success notification" >'.$dinasunapproved['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $dinasunapproved['generatetable'];
                        echo $dinasunapproved['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="<?php echo site_url('trans/dinas') ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $paunapproved['title'];
                        if($paunapproved['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$paunapproved['count'].' Dokumen baru" class="badge badge-success notification" >'.$paunapproved['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $paunapproved['generatetable'];
                        echo $paunapproved['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="<?php echo site_url('pk/form_pk') ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $konditeunapproved['title'];
                        if($konditeunapproved['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$konditeunapproved['count'].' Dokumen baru" class="badge badge-success notification" >'.$konditeunapproved['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $konditeunapproved['generatetable'];
                        echo $konditeunapproved['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="<?php echo site_url('pk/form_kondite') ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $fpkunapproved['title'];
                        if($fpkunapproved['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$fpkunapproved['count'].' Dokumen baru" class="badge badge-success notification" >'.$fpkunapproved['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $fpkunapproved['generatetable'];
                        echo $fpkunapproved['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="<?php echo site_url('pk/form_report_final_close') ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $investigationReportTable['title'];
                        if($investigationReportTable['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$investigationReportTable['count'].' Dokumen" class="badge badge-success notification" >'.$investigationReportTable['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $investigationReportTable['generatetable'];
                        echo $investigationReportTable['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <div class="box-footer">
                    <a href="<?php echo $investigationReportTable['linkmenu'] ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $warningLetterTable['title'];
                        if($warningLetterTable['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$warningLetterTable['count'].' Dokumen" class="badge badge-success notification" >'.$investigationReportTable['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $warningLetterTable['generatetable'];
                        echo $warningLetterTable['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <div class="box-footer">
                    <a href="<?php echo $warningLetterTable['linkmenu'] ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

<?php } ?>
<?php if($rowakses > 0) { ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $vehicleTable['title'];
                        if($vehicleTable['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$vehicleTable['count'].' Dokumen" class="badge badge-success notification" >'.$vehicleTable['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $vehicleTable['generatetable'];
                        echo $vehicleTable['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <div class="box-footer">
                    <a href="<?php echo $vehicleTable['linkmenu'] ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $vehicleKirTable['title'];
                        if($vehicleKirTable['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$vehicleKirTable['count'].' Dokumen baru" class="badge badge-success notification" >'.$vehicleKirTable['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $vehicleKirTable['generatetable'];
                        echo $vehicleKirTable['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="<?php echo $vehicleKirTable['linkmenu'] ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $vehicleAsnTable['title'];
                        if($vehicleAsnTable['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$vehicleAsnTable['count'].' Dokumen" class="badge badge-success notification" >'.$vehicleTable['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $vehicleAsnTable['generatetable'];
                        echo $vehicleAsnTable['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <div class="box-footer">
                    <a href="<?php echo $vehicleAsnTable['linkmenu'] ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        echo $attendanceTable['title'];
                        if($attendanceTable['count'] > 0) {
                            echo ' <span data-toggle="tooltip" title="'.$attendanceTable['count'].' Dokumen" class="badge badge-success notification" >'.$attendanceTable['count'].'</span>';
                        }
                        ?>
                    </h3>
                    <div class="box-tools pull-right">

                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        echo $attendanceTable['generatetable'];
                        echo $attendanceTable['jquery'];
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <div class="box-footer">
                    <a href="<?php echo $attendanceTable['linkmenu'] ?>"
                       class="btn btn-md btn-soundcloud pull-right m-3">Selengkapnya</a>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <!-- START OF OJT -->
        <?php if($OJT > 0) { ?>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <?php echo $title_ojt; ?>
                        </h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="t_ojt" class="display nowrap table table-striped no-margin" style="width:100%">
                                <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="10%">NIK</th>
                                    <th>Nama</th>
                                    <th>Bagian</th>
                                    <th width="10%">Akhir</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($list_ojt as $k => $v): ?>
                                    <tr>
                                        <td class="text-nowrap text-center">
                                            <?php echo ($k + 1); ?>
                                        </td>
                                        <td class="text-nowrap">
                                            <?php echo trim($v->nik); ?>
                                        </td>
                                        <td>
                                            <?php echo trim($v->nmlengkap); ?>
                                        </td>
                                        <td>
                                            <?php echo trim($v->nmdept); ?>
                                        </td>
                                        <td class="text-nowrap text-center">
                                            <?php echo date('d-m-Y', strtotime($v->tgl_selesai)); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="#" onclick="window.open('<?php echo site_url('trans/stspeg/excel_ojt'); ?>','_blank')"
                           class="btn btn-sm btn-success btn-flat pull-left"><i class="fa fa-download"></i>&nbsp;
                            Download Xls </a>
                        <a href="#"
                           onclick="window.open('<?php echo site_url('trans/stspeg/list_ojt'); ?>', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=200,width=1200,height=700')"
                           class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-eye"></i>&nbsp; View All</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        <?php } ?>
        <!-- END OF OJT -->

        <!--START OF KONTRAK-->
        <?php if($KONTRAK > 0) { ?>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <?php echo $title_kontrak; ?>
                        </h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="t_kontrak" class="display nowrap table table-striped no-margin" style="width:100%">
                                <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="10%">NIK</th>
                                    <th>Nama</th>
                                    <th>Bagian</th>
                                    <th width="10%">Akhir</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($list_kontrak as $k => $v): ?>
                                    <tr>
                                        <td class="text-nowrap text-center">
                                            <?php echo ($k + 1); ?>
                                        </td>
                                        <td class="text-nowrap">
                                            <?php echo trim($v->nik); ?>
                                        </td>
                                        <td>
                                            <?php echo trim($v->nmlengkap); ?>
                                        </td>
                                        <td>
                                            <?php echo trim($v->nmdept); ?>
                                        </td>
                                        <td class="text-nowrap text-center">
                                            <?php echo date('d-m-Y', strtotime($v->tgl_selesai1)); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="#" onclick="window.open('<?php echo site_url('trans/stspeg/excel_kontrak'); ?>','_blank')"
                           class="btn btn-sm btn-success btn-flat pull-left"><i class="fa fa-download"></i>&nbsp;
                            Download Xls </a>
                        <a href="#"
                           onclick="window.open('<?php echo site_url('trans/stspeg/list_karkon'); ?>', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=200,width=1200,height=700')"
                           class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-eye"></i>&nbsp; View All</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        <?php } ?>
        <!--END OF KONTRAK-->
    </div>

    <div class="row">
        <!--START OF PENSIUN-->
        <?php if($PENSIUN > 0) { ?>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <?php echo $title_pensiun; ?>
                        </h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="t_pensiun" class="display nowrap table table-striped no-margin" style="width:100%">
                                <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="10%">Nik</th>
                                    <th>Nama</th>
                                    <th>Bagian</th>
                                    <th width="5%">Umur</th>
                                    <th width="10%">Keterangan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($list_pensiun as $k => $v): ?>
                                    <tr>
                                        <td class="text-nowrap text-center">
                                            <?php echo ($k + 1); ?>
                                        </td>
                                        <td class="text-nowrap">
                                            <?php echo trim($v->nik); ?>
                                        </td>
                                        <td>
                                            <?php echo trim($v->nmlengkap); ?>
                                        </td>
                                        <td>
                                            <?php echo trim($v->nmdept); ?>
                                        </td>
                                        <td class="text-nowrap text-right">
                                            <?php echo $v->umur; ?>
                                        </td>
                                        <td class="text-nowrap text-center">
                                            <?php echo 'TELAH MEMASUKI MASA PENSIUN'; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="#" onclick="window.open('<?php echo site_url('trans/stspeg/excel_pensiun'); ?>','_blank')"
                           class="btn btn-sm btn-success btn-flat pull-left"><i class="fa fa-download"></i>&nbsp;
                            Download Xls </a>
                        <a href="#"
                           onclick="window.open('<?php echo site_url('trans/stspeg/list_karpen'); ?>', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=200,width=1200,height=700')"
                           class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-eye"></i>&nbsp; View All</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
        <?php } ?>
        <!--END OF PENSIUN-->

        <!--START OF MAGANG-->
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo $title_magang; ?>
                    </h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="t_magang" class="display nowrap table table-striped no-margin" style="width:100%">
                            <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="10%">NIK</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th width="10%">Akhir</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($list_magang as $k => $v): ?>
                                <tr>
                                    <td class="text-nowrap text-center">
                                        <?php echo ($k + 1); ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php echo trim($lk->nik); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($lk->nmlengkap); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($lk->nmdept); ?>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <?php echo date('d-m-Y', strtotime($lk->tgl_selesai)); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!--END OF MAGANG-->
    </div>
    <div class="row">
        <!-- START OF CUTI -->
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo $title_cuti; ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="t_cuti" class="display nowrap table table-striped no-margin" style="width:100%">
                            <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="10%">NIK</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th width="10%">Tanggal</th>
                                <th width="20%">Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($list_cuti as $k => $v): ?>
                                <tr>
                                    <td class="text-nowrap text-center">
                                        <?php echo ($k + 1); ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php echo trim($v->nik); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($v->nmlengkap); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($v->bagian); ?>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <?php echo date('d-m-Y', strtotime($v->tgl)); ?>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <?php echo trim($v->keterangan); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- END OF CUTI -->

        <!--START OF IJIN-->
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo $title_ijin; ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="t_ijin" class="display nowrap table table-striped no-margin" style="width:100%">
                            <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="10%">Nik</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th width="10%">Dokumen</th>
                                <th width="10%">Type</th>
                                <th width="10%">Awal</th>
                                <th width="10%">Akhir</th>
                                <th width="10%">Kategori</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($list_ijin as $k => $v): ?>
                                <tr>
                                    <td class="text-nowrap text-center">
                                        <?php echo ($k + 1); ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php echo trim($v->nik); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($v->nmlengkap); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($v->bagian); ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php echo trim($v->nodok); ?>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <?php echo trim($v->tipe_ijin); ?>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <?php echo empty($v->jam_awal) ? '' : date('d-m-Y', strtotime($v->jam_awal)); ?>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <?php echo empty($v->jam_akhir) ? '' : date('d-m-Y', strtotime($v->jam_akhir)); ?>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <?php echo trim($v->kategori); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!--END OF IJIN-->
    </div>
    <div class="row">
        <!--START OF LEMBUR-->
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo $title_lembur; ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="t_lembur" class="display nowrap table table-striped no-margin" style="width:100%">
                            <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="10%">Nik</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th width="10%">Dokumen</th>
                                <th width="10%">Jam</th>
                                <th width="10%">Jenis</th>
                                <th>Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($list_lembur as $k => $v): ?>
                                <tr>
                                    <td class="text-nowrap text-center">
                                        <?php echo ($k + 1); ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php echo trim($v->nik); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($v->nmlengkap); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($v->nmdept); ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php echo trim($v->nodok); ?>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <?php echo trim($v->jam); ?>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <?php echo trim($v->nmjenis_lembur); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($v->keterangan); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!--END OF LEMBUR-->

        <!--START OF DINAS-->
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo $title_dinas; ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="t_dinas" class="display nowrap table table-striped no-margin" style="width:100%">
                            <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="10%">NIK</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th width="10%">Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($list_dinas as $k => $v): ?>
                                <tr>
                                    <td class="text-nowrap text-center">
                                        <?php echo ($k + 1); ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php echo trim($v->nik); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($v->nmlengkap); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($v->bagian); ?>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <?php echo date('d-m-Y', strtotime($v->tgl)); ?>
                                    </td>
                                    <td>
                                        <?php echo trim($v->tujuan); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!--END OF DINAS-->

    </div>
<?php } ?>


<!-- /.box -->
<a id="schedule-redirect" target="_blank"></a>
<script type="text/javascript">
    $(function() {
        $("#t_ojt").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [
                [5, 25, 50, -1],
                [5, 25, 50, "All"]
            ],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_kontrak").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [
                [5, 25, 50, -1],
                [5, 25, 50, "All"]
            ],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_pensiun").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [
                [5, 25, 50, -1],
                [5, 25, 50, "All"]
            ],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_magang").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [
                [5, 25, 50, -1],
                [5, 25, 50, "All"]
            ],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_recent").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [
                [5, 25, 50, -1],
                [5, 25, 50, "All"]
            ],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_cuti").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [
                [5, 25, 50, -1],
                [5, 25, 50, "All"]
            ],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_dinas").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [
                [5, 25, 50, -1],
                [5, 25, 50, "All"]
            ],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_ijin").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [
                [5, 25, 50, -1],
                [5, 25, 50, "All"]
            ],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_lembur").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [
                [5, 25, 50, -1],
                [5, 25, 50, "All"]
            ],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
    });

    function actionpopup(param) {
        var row = param;
        $.getJSON(row.attr('data-href'), {
            type: 'dashboard'
        })
            .done(function(data) {
                if (data.canapprove) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3 actionbutton',
                            cancelButton: 'btn btn-sm btn-default ml-3 actionbutton',
                            denyButton: 'btn btn-sm btn-danger ml-3 actionbutton',
                        },
                        buttonsStyling: false,
                    }).fire({
                        icon: 'question',
                        title: data.statustext,
                        html: (data.investigationReport ?
                                `Anda akan dialihkan ke halaman persetujuan<br> <b>${data.type} Untuk dokumen ${data.data.docno}</b>` :
                                `Anda akan dialihkan ke halaman persetujuan<br> <b>${data.type} ${data.data.nodok}</b> `
                        ),
                        showCloseButton: true,
                        showConfirmButton: true,
                        confirmButtonText: 'Ya, lanjutkan',
                        showCancelButton: true,
                        cancelButtonText: `Tutup`,
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            window.location.replace(data.next.approve);
                        }
                    });
                }
                if (data.cancreate) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-primary ml-3 actionbutton',
                            cancelButton: 'btn btn-sm btn-default ml-3 actionbutton',
                            denyButton: 'btn btn-sm btn-info ml-3 actionbutton',
                        },
                        buttonsStyling: false,
                    }).fire({
                        icon: 'question',
                        title: `Perhatian`,
                        html: `Buat dokumen perizinan atau koreksi absensi <br> <b>` + data.data.nmlengkap +
                            `</b> <br> tanggal ` + data.data.formatdate,
                        showCloseButton: true,
                        showConfirmButton: true,
                        confirmButtonText: 'Buat dokumen perizinan',
                        showCancelButton: true,
                        cancelButtonText: `Tutup`,
                        showDenyButton: true,
                        denyButtonText: `Koreksi absensi`,
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-primary ml-3 actionbutton',
                                    cancelButton: 'btn btn-sm btn-default ml-3 actionbutton',
                                    denyButton: 'btn btn-sm btn-info ml-3 actionbutton',
                                },
                                buttonsStyling: false,
                            }).fire({
                                icon: 'question',
                                title: data.statustext,
                                html: `Buat dokumen cuti / ijin`,
                                showCloseButton: true,
                                showConfirmButton: true,
                                confirmButtonText: 'Buat Cuti',
                                showCancelButton: true,
                                cancelButtonText: `Tutup`,
                                showDenyButton: true,
                                denyButtonText: `Buat Ijin`,
                            }).then(function(result) {

                                if (result.isConfirmed) {
                                    window.location.replace(data.next.urlcuti);
                                }
                                if (result.isDenied) {
                                    window.location.replace(data.next.urlijin);
                                }
                            })

                        }
                        if (result.isDenied) {
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-primary ml-3 actionbutton',
                                    cancelButton: 'btn btn-sm btn-default ml-3 actionbutton',
                                    denyButton: 'btn btn-sm btn-info ml-3 actionbutton',
                                },
                                buttonsStyling: false,
                            }).fire({
                                icon: 'question',
                                title: data.statustext,
                                html: `Koreksi absensi / Lihat jadwal `,
                                showCloseButton: true,
                                showConfirmButton: true,
                                confirmButtonText: 'Koreksi absensi',
                                showCancelButton: true,
                                cancelButtonText: `Tutup`,
                                showDenyButton: true,
                                denyButtonText: `Lihat jadwal`,
                            }).then(function(result) {

                                if (result.isConfirmed) {
                                    window.location.replace(data.next.urlkoreksi)
                                }
                                if (result.isDenied) {
                                    var nik = data.data.nik;
                                    var schedule = data.data.tgl;
                                    $.ajax({
                                        url: data.next.urlschedule,
                                        method: 'POST',
                                        data: {
                                            nik: data.data.nik,
                                            schedule: data.data.tgl
                                        },
                                        success: function(data) {
                                            Swal.mixin({
                                                customClass: {
                                                    confirmButton: 'btn btn-sm btn-primary ml-3 actionbutton',
                                                    cancelButton: 'btn btn-sm btn-default ml-3 actionbutton',
                                                    denyButton: 'btn btn-sm btn-info ml-3 actionbutton',
                                                },
                                                buttonsStyling: false,
                                            }).fire({
                                                icon: 'question',
                                                title: data.title,
                                                html: data.message,
                                                showCloseButton: false,
                                                showDenyButton: true,
                                                showConfirmButton: false,
                                                showCancelButton: true,
                                                cancelButtonText: `Tutup`,
                                                denyButtonText: `Cek absensi`,
                                            }).then(function(result) {
                                                if (result.isDenied) {
                                                    $('a#schedule-redirect').attr(
                                                        'href',
                                                        '<?php echo base_url('trans/finger/filterschedule') ?>?userid=' +
                                                        nik + '&schedule=' +
                                                        schedule + '')
                                                    $('a#schedule-redirect')[0]
                                                        .click()
                                                }
                                            });
                                        },
                                        error: function(xhr, status, thrown) {
                                            Swal.mixin({
                                                customClass: {
                                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                                    denyButton: 'btn btn-sm btn-default ml-3',
                                                },
                                                buttonsStyling: false,
                                            }).fire({
                                                position: 'top',
                                                icon: 'error',
                                                title: 'Gagal Memuat Status',
                                                html: (xhr.responseJSON && xhr
                                                    .responseJSON.message ? xhr
                                                    .responseJSON.message : xhr
                                                    .statusText),
                                                showCloseButton: true,
                                                showConfirmButton: false,
                                                showDenyButton: true,
                                                denyButtonText: `Tutup`,
                                            }).then(function() {});
                                        }
                                    })
                                }
                            })
                        }

                    });
                }
            })
            .fail(function(xhr, status, thrown) {
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm btn-success ml-3',
                        cancelButton: 'btn btn-sm btn-warning ml-3',
                        denyButton: 'btn btn-sm btn-default ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Gagal Memuat Status',
                    html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr
                        .statusText),
                    showCloseButton: true,
                    showConfirmButton: false,
                    showDenyButton: true,
                    denyButtonText: `Tutup`,
                }).then(function() {});
            });
    }
    $(document).on('ready', function() {
        var tablecuti = $('#table-cuti-unapproved');
        var tableijin = $('#table-ijin-unapproved');
        var tablelembur = $('#table-lembur-unapproved');
        var tabledinas = $('#table-dinas-unapproved');
        var tablepa = $('#table-pa-unapproved');
        var tablekondite = $('#table-kondite-unapproved');
        var tablefpk = $('#table-fpk-unapproved');
        $('table#table-cuti-unapproved tbody').on('click', 'td a.actionpopup', function() {
            actionpopup($(this))
        });
        $('table#table-ijin-unapproved tbody').on('click', 'td a.actionpopup', function() {
            actionpopup($(this))
        });
        $('table#table-dinas-unapproved tbody').on('click', 'td a.actionpopup', function() {
            actionpopup($(this))
        });
        $('table#table-lembur-unapproved tbody').on('click', 'td a.actionpopup', function() {
            actionpopup($(this))
        });
        $('table#table-attendance tbody').on('click', 'td a.actionpopup', function() {
            actionpopup($(this))
        });
        $('table#table-investigation-report tbody').on('click', 'td a.actionpopup', function() {
            actionpopup($(this))
        });
        $('table#table-warning-letter tbody').on('click', 'td a.actionpopup', function() {
            actionpopup($(this))
        });
        $('table#table-pa-unapproved tbody').on('click', 'td a.actionpopup', function() {
            actionpopup($(this))
        });
        $('table#table-kondite-unapproved tbody').on('click', 'td a.actionpopup', function() {
            actionpopup($(this))
        });
        $('table#table-fpk-unapproved tbody').on('click', 'td a.actionpopup', function() {
            actionpopup($(this))
        });
    })
</script>