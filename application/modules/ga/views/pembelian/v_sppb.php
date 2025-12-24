<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(document).ready(function () {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function (evt) { if (evt.persisted) disableBack() }
    });
    $(function () {
        $("#example1").dataTable();
        $("#example2").dataTable();
        $("#example3").dataTable();
        $("#example4").dataTable();
        $("#kdsubgroup").chained("#kdgroup");
        $("#kdbarang").chained("#kdsubgroup");
        $('.kdbarang').change(function () {
            if ($('#kdbarang').val() != '') {
                var param1 = $(this).val();
                $.ajax({
                    url: "<?php echo site_url('ga/pembelian/js_viewstock') ?>/" + param1,
                    type: "GET",
                    dataType: "JSON",
                    success: function (data) {
                        $('[name="onhand"]').val(data.conhand);
                        $('[name="loccode"]').val(data.loccode);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Error get data from ajax');
                    }
                });
            };
        });
        $('.drst').show();
        $('#daristock').on('click', function () {
            if ($(this).val() == 'YES') {
                $('.drst').prop('required', true);
                $('.drst').show();
            } else if ($(this).val() == 'NO') {
                $('.drst').prop('required', false);
                $('.drst').hide();
            }
        });

        $(".tglrange").daterangepicker();
        $(".tglan").datepicker();
    });

</script>
<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
        <?php if (trim($y1->kodemenu) != trim($kodemenu)) { ?>
            <li><a href="<?php echo site_url(trim($y1->linkmenu)); ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i>
                    <?php echo trim($y1->namamenu); ?></a></li>
        <?php } else { ?>
            <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
        <?php } ?>
    <?php } ?>
</ol>
<h3><?php echo $title; ?></h3>
<?php echo $message; ?>

<div class="box">
    <div class="box-header">
        <div class="dropdown ">
            <button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1"
                type="button" data-toggle="dropdown">Menu Input
                <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#FILTER_MODAL"
                        href="#"><i class="fa fa-search"></i> Pencarian</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1"
                        href="<?php echo site_url("ga/pembelian/list_niksppb") ?>"><i class="fa fa-plus"></i> Permintaan
                        PEMBELIAN</a></li>
            </ul>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive" style='overflow-x:scroll;'>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="1%">No.</th>
                    <th>DOKUMEN</th>
                    <th>NIK</th>
                    <th>NAMA LENGKAP</th>
                    <th>NAMA BARANG</th>
                    <th>TANGGAL</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 0;
                foreach ($list_sppb as $row):
                    $no++; ?>
                    <tr>
                        <td width="2%"><?php echo $no; ?></td>
                        <td><?php echo $row->nodok; ?></td>
                        <td><?php echo $row->nik; ?></td>
                        <td><?php echo $row->nmlengkap; ?></td>
                        <td><?php echo $row->nmbarang; ?></td>
                        <!--td><?php echo $row->nmjabatan; ?></td-->
                        <td><?php echo date('d-m-Y', strtotime(trim($row->tgldok))); ?></td>
                        <td><?php echo $row->ketstatus; ?></td>
                        <td width="15%">
                            <a href="<?php
                            $enc_nodok = bin2hex($this->encrypt->encode(trim($row->nodok)));
                            echo site_url("ga/pembelian/detail_sppb/$enc_nodok"); ?>" class="btn btn-default  btn-sm"
                                title="DETAIL SPPB"><i class="fa fa-bars"></i> </a>
                            <?php if (trim($row->status) == 'A') { ?>
                                <a href="<?php
                                $enc_nodok = bin2hex($this->encrypt->encode(trim($row->nodok)));
                                echo site_url("ga/pembelian/edit_sppb/$enc_nodok"); ?>" class="btn btn-primary  btn-sm"
                                    title="UBAH SPPB"><i class="fa fa-gear"></i> </a>
                                <?php if (trim($nama) == trim($row->nik_atasan) or trim($nama) == trim($row->nik_atasan2)) { ?>
                                    <a href="<?php
                                    $enc_nodok = bin2hex($this->encrypt->encode(trim($row->nodok)));
                                    echo site_url("ga/pembelian/approval_sppb/$enc_nodok"); ?>"
                                        class="btn btn-success  btn-sm" title="APPROVAL SPPB"><i class="fa fa-check"></i> </a>
                                <?php }
                            }
                            if ((trim($row->status) == 'QA') and $isSPVGA) { ?>
                                <a href="<?php
                                $sts = trim($row->status);
                                $enc_nodok = bin2hex($this->encrypt->encode(trim($row->nodok)));
                                echo site_url("ga/pembelian/approval_quotation/$enc_nodok/$sts/A2"); ?>"
                                    class="btn btn-success btn-sm" title="APPROVAL QUOTATION"><i class="fa fa-check"></i> </a>
                            <?php } ?>
                            <?php if ((trim($row->status) == 'P' or trim($row->status) == 'S' or trim($row->status) == 'U')) { ?>
                                <button class="button btn btn-warning  btn-sm"
                                    onClick="window.open('<?php echo site_url("ga/pembelian/sti_sppb_final/$enc_nodok"); ?>');"
                                    title="PRINT SPPB"><i class="fa fa-print"></i></button>
                                <?php if ($userhr) { ?>
                                    <a href="<?php
                                    $enc_nodok = bin2hex($this->encrypt->encode(trim($row->nodok)));
                                    echo site_url("ga/pembelian/hangus_sppb/$enc_nodok"); ?>"
                                        class="btn btn-danger  btn-sm" title="HANGUS SPPB"><i class="fa fa-trash-o"></i> </a>
                                    <a href="<?php
                                    $enc_nodok = bin2hex($this->encrypt->encode(trim($row->nodok)));
                                    echo site_url("ga/pembelian/input_quotation/$enc_nodok"); ?>"
                                        class="btn btn-primary btn-sm" title="INPUT QUOTATION"><i class="fa fa-pencil"></i> </a>
                                <?php } ?>
                            <?php } else if (trim($row->status) == 'QP') { ?>
                                    <button class="button btn btn-warning  btn-sm"
                                        onClick="window.open('<?php echo site_url("ga/pembelian/sti_sppb_final/$enc_nodok"); ?>');"
                                        title="PRINT SPPB"><i class="fa fa-print"></i></button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<div class="modal fade" id="FILTER_MODAL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN PERMINTAAN BARANG KELUAR </h4>
            </div>
            <form action="<?php echo site_url('ga/pembelian/form_sppb') ?>" method="post" name="inputformPbk">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
                                            <div class="col-sm-8">
                                                <input type="input" name="tgl" id="tgl"
                                                    class="form-control input-sm tglrange">
                                            </div>
                                        </div>
                                        <!--div class="form-group ">
                                    <label class="col-sm-4" for="inputsm">PILIH NAMA KARYAWAN </label>
                                    <div class="col-sm-8">
                                    <select class="form-control input-sm " name="nik" id="nik">
                                        <option value=""><tr><th width="20%">-- NIK |</th><th width="80%">| NAMA KARYAWAN --</th></tr></option>
                                        <?php //foreach($list_nik as $sc){ ?>
                                        <option value="<?php //echo trim($sc->nik); ?>" ><tr><th width="20%"><?php //echo trim($sc->nik); ?>  |</th><th width="80%">| <?php //echo trim($sc->nmlengkap); ?></th></tr></option>
                                        <?php //} ?>
                                    </select>
                                    </div>
                            </div--->

                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
            </form>
        </div>
    </div>
</div>