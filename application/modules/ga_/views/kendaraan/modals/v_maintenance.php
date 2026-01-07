<?php //var_dump();die(); ?>
<style>
    .ml-3{
        margin-left:3px;
    }
    textarea{
        resize: none;
    }
</style>
<div class="modal-dialog modal-dialog-scrollable <?php echo(isset($modalSize) ? $modalSize : 'modal-md') ?>" role="document">
    <div class="modal-content">
        <form role="form" name="formfilter" id="formfilter" action="<?php echo $actionUrl ?>" method="post" class="m-0 formfilter">
            <div class="modal-header bg-info">
                <h4 class="modal-title"><?php echo(isset($modalTitle) ? $modalTitle : 'Header') ?></h4>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#workorder" data-toggle="tab" aria-expanded="true">SPK</a></li>
                        <li class=""><a href="#submission" data-toggle="tab" aria-expanded="false">PENGAJUAN</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="workorder">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-container" style="overflow-x: scroll">
                                        <table class="table table-hover table-bordered datatable workorder">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">No. Dokumen</th>
                                                <th scope="col">Pemohon</th>
                                                <th scope="col">Bengkel</th>
                                                <th scope="col">Jenis Perawatan</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col" >Total Servis</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($maintenanceData as $index => $item) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $index+1; ?></th>
                                                    <td><?php echo $item->nodok; ?><br>
                                                        <i>Ref: </i><span class="text-info">
                                                            <?php echo $item->nodokref; ?></span>
                                                        <?php if (!empty($item->idfaktur)){ ?>
                                                                <br>
                                                            <i>faktur: </i><span class="text-info">
                                                                <?php echo $item->idfaktur; ?></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo $item->nmmohon; ?></td>
                                                    <td><?php echo $item->nmbengkel; ?></td>
                                                    <td><?php echo $item->nmperawatanasset; ?></td>
                                                    <td><?php echo $item->keterangan; ?></td>
                                                    <td><?php echo $item->uraian_status; ?></td>
                                                    <td class="text-right"><?php echo number_format($item->ttlservis,2); ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="detail-maintenance"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="submission">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover datatable submission">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Pengguna</th>
                                            <th scope="col">Pemohon</th>
                                            <th scope="col">Jenis Perawatan</th>
                                            <th scope="col">Kilometer</th>
                                            <th scope="col">Keterangan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($submissionData as $index => $item) { ?>
                                            <tr>
                                                <th scope="row"><?php echo $index+1; ?></th>
                                                <td><?php echo $item->pemohon; ?></td>
                                                <td><?php echo $item->pengguna; ?></td>
                                                <td><?php echo $item->nmperawatanasset; ?></td>
                                                <td>
                                                    <span class='label mt-5 label-primary' style='font-size: small; '><?php echo $item->km_awal; ?></span>
                                                    <span><i class="fa fa-forward"></i></span>
                                                    <span class='label mt-5 label-primary' style='font-size: small; '><?php echo $item->km_akhir; ?></span>
                                                </td>
                                                <td><?php echo $item->keterangan; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <div class="detail-maintenance"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#modify-data">Tutup</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function (){
        $('table.workorder').DataTable({
            searching: true, // Enable global searching
            
        });
    })
</script>
