<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<style>
    /*-- change navbar dropdown color --*/
    .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu {
        background-color: #008040;
        color:#ffffff;
    }

    #example1 thead tr th {
        text-align: center;
    }
    .ml-3{
        margin-left: 3px;
    }
</style>
<script type="text/javascript">
    $(function() {
        $("#example1").dataTable({
            "autoWidth": false,
            "order": []
        });
    });
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-3">
        <div class="dropdown ">
            <button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter" href="#">Filter Pencarian</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filterinput" href="#">Input Pemakaian BBM</a></li>
            </ul>
            <a href="<?php echo site_url('ga/bbmkendaraan/excel_bbmkendaraan').'/'.$enc_param_excel;?>" class="btn btn-success " title="Unduh Excel Laporan BBM"> <i class="fa fa-download"></i> Excel </a>
        </div>
	</div>
</div>
</br>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped uk-overflow-container" >
					<thead>
                        <tr>
                            <th width="2%">NO</th>
                            <th>NO DOKUMEN</th>
                            <th>TGL INPUT</th>
                            <th>NAMA KENDARAAN</th>
                            <th>NOPOL</th>
                            <th>BAHAN BAKAR</th>
                            <th>HARGA SATUAN</th>
                            <th>LITER</th>
                            <th>KM AWAL</th>
                            <th>KM AKHIR</th>
                            <th>BIAYA</th>
                            <th>STATUS</th>
                            <th width="1%">CETAK</th>
                            <th>KETERANGAN</th>
                            <th width="8%">AKSI</th>
                        </tr>
					</thead>
                    <tbody>
                        <?php $no=0; foreach($list_trx_mst as $row): $no++;?>
						    <tr>
                                <td class="text-nowrap text-center"><?php echo number_format($no, 0, ',', '.');?></td>
                                <td class="text-nowrap"><?php echo trim($row->docno);?></td>
                                <td class="text-nowrap"><?php echo date('d-m-Y', strtotime(trim($row->docdate)));?></td>
                                <td><?php echo trim($row->nmbarang);?></td>
                                <td class="text-nowrap"><?php echo trim($row->nopol);?></td>
                                <td><?php echo trim($row->nmbahanbakar);?></td>
                                <td class="text-nowrap text-right"><?php echo number_format(trim($row->hargasatuan), 2,',','.');?></td>
                                <td class="text-nowrap text-right"><?php echo number_format(trim($row->liters), 2,',','.');?></td>
                                <td class="text-nowrap text-right"><?php echo number_format(trim($row->km_awal), 0,',','.');?></td>
                                <td class="text-nowrap text-right"><?php echo number_format(trim($row->km_akhir), 0,',','.');?></td>
                                <td class="text-nowrap text-right" ><?php echo number_format(trim($row->ttlvalue), 2,',','.');?></td>
                                <td><?php echo trim($row->nmstatus);?></td>
                                <td width="1%"><?php echo trim($row->printyes);?></td>
                                <td><?php echo trim($row->description);?></td>
                                <td class="text-nowrap">
                                    <a href="<?php
                                    $enc_docno=$this->fiky_encryption->enkript((trim($row->docno)));
                                    $enc_stockcode=$this->fiky_encryption->enkript((trim($row->stockcode)));
                                    echo site_url('ga/bbmkendaraan/detail_bbmkendaraan').'/'.$enc_docno.'/'.$enc_stockcode;?>" class="btn btn-default  btn-sm" title="Detail Data Bahan Bakar">	<i class="fa fa-bars"></i> </a>

                                    <?php IF (trim($row->status)=='A') { ?>
                                        <a href="<?php
                                        $enc_docno=$this->fiky_encryption->enkript((trim($row->docno)));
                                        $enc_stockcode=$this->fiky_encryption->enkript((trim($row->stockcode)));
                                        echo site_url('ga/bbmkendaraan/edit_bbmkendaraan').'/'.$enc_docno.'/'.$enc_stockcode;?>" class="btn btn-primary  btn-sm" title="Ubah Data Penggunaan Bahan Bakar">	<i class="fa fa-gear"></i> </a>

                                        <a href="<?php
                                        $enc_docno=$this->fiky_encryption->enkript((trim($row->docno)));
                                        $enc_stockcode=$this->fiky_encryption->enkript((trim($row->stockcode)));
                                        echo site_url('ga/bbmkendaraan/approval_bbmkendaraan').'/'.$enc_docno.'/'.$enc_stockcode;?>" class="btn btn-success  btn-sm" title="Approval BBM Kendaraan"> <i class="fa fa-check"></i> </a>

                                        <a href="<?php
                                        $enc_docno=$this->fiky_encryption->enkript((trim($row->docno)));
                                        $enc_stockcode=$this->fiky_encryption->enkript((trim($row->stockcode)));
                                        echo site_url('ga/bbmkendaraan/cancel_bbmkendaraan').'/'.$enc_docno.'/'.$enc_stockcode;?>" class="btn btn-danger  btn-sm" title="Pembatalan Input">	<i class="fa fa-trash-o"></i> </a>
                                        <?php IF (trim($row->printyes)=== 'NO') { ?>

                                            <a href="<?php
                                            $enc_docno=$this->fiky_encryption->enkript((trim($row->docno)));
                                            $enc_stockcode=$this->fiky_encryption->enkript((trim($row->stockcode)));
                                            echo site_url('ga/bbmkendaraan/sti_bbmkendaraan').'/'.$enc_docno.'/'.$enc_stockcode;?>" class="btn btn-warning  btn-sm hide" target="_blank" title="Cetak Nominal Kosong">	<i class="fa fa-print"></i> </a>
                                            <a href="<?php
                                            $enc_docno=$this->fiky_encryption->enkript((trim($row->docno)));
                                            $enc_stockcode=$this->fiky_encryption->enkript((trim($row->stockcode)));
                                            echo site_url('ga/bbmkendaraan/sti_bbmkendaraan').'/'.$enc_docno.'/'.$enc_stockcode;?>" class="btn btn-instagram  btn-sm hide" target="_blank" title="Cetak Nominal Normal">	<i class="fa fa-print"></i> </a>

                                            <a href="javascript:void(0)" data-id="<?php echo trim($row->docno); ?>" data-href="<?php
                                            $encrypt = bin2hex(json_encode(array('docno' => trim($row->docno), 'stockcode' => trim($row->stockcode) )));
                                            echo site_url('ga/bbmkendaraan/chooseprinttype/'.$encrypt);?>" class="btn btn-warning bg-orange btn-sm choose-print" title="Cetak">	<i class="fa fa-print"></i> </a>
                                        <?php }else{ ?>
                                            <?php if ($isCanReopenPrint){ ?>
                                                <a href="javascript:void(0)" data-id="<?php echo trim($row->docno); ?>" data-href="<?php
                                                $encrypt = bin2hex(json_encode(array('docno' => trim($row->docno), 'stockcode' => trim($row->stockcode) )));
                                                echo site_url('ga/bbmkendaraan/reopenprint/'.$encrypt);?>" class="btn btn-github btn-sm re-open" title="Aktifkan cetak ulang">	<i class="fa fa-refresh"></i> </a>
                                            <?php }?>
                                        <?php } ?>
                                    <?php } ELSE IF (trim($row->status)==='P') { ?>
                                        <?php IF (trim($row->printyes)=== 'NO') { ?>

                                            <a href="<?php
                                            $enc_docno=$this->fiky_encryption->enkript((trim($row->docno)));
                                            $enc_stockcode=$this->fiky_encryption->enkript((trim($row->stockcode)));
                                            echo site_url('ga/bbmkendaraan/sti_bbmkendaraan').'/'.$enc_docno.'/'.$enc_stockcode;?>" class="btn btn-warning  btn-sm hide" target="_blank" title="Cetak Nominal Kosong">	<i class="fa fa-print"></i> </a>
                                            <a href="<?php
                                            $enc_docno=$this->fiky_encryption->enkript((trim($row->docno)));
                                            $enc_stockcode=$this->fiky_encryption->enkript((trim($row->stockcode)));
                                            echo site_url('ga/bbmkendaraan/sti_bbmkendaraan').'/'.$enc_docno.'/'.$enc_stockcode;?>" class="btn btn-instagram  btn-sm hide" target="_blank" title="Cetak Nominal Normal">	<i class="fa fa-print"></i> </a>

                                            <a href="javascript:void(0)" data-id="<?php echo trim($row->docno); ?>" data-href="<?php
                                            $encrypt = bin2hex(json_encode(array('docno' => trim($row->docno), 'stockcode' => trim($row->stockcode) )));
                                            echo site_url('ga/bbmkendaraan/chooseprinttype/'.$encrypt);?>" class="btn btn-warning bg-orange btn-sm choose-print" title="Cetak">	<i class="fa fa-print"></i> </a>
                                        <?php }else{ ?>
                                            <?php if ($isCanReopenPrint){ ?>
                                                <a href="javascript:void(0)" data-id="<?php echo trim($row->docno); ?>" data-href="<?php
                                                $encrypt = bin2hex(json_encode(array('docno' => trim($row->docno), 'stockcode' => trim($row->stockcode) )));
                                                echo site_url('ga/bbmkendaraan/reopenprint/'.$encrypt);?>" class="btn btn-github btn-sm re-open" title="Aktifkan cetak ulang">	<i class="fa fa-refresh"></i> </a>
                                            <?php }?>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
						    </tr>
                        <?php endforeach;?>
                    </tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>

<!--Modal untuk Filter ASET KENDARAAN WILAYAH-->
<div class="modal fade" id="filterinput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">INPUT & PILIH KENDARAAN</h4>
            </div>
	        <form action="<?php echo site_url('ga/bbmkendaraan/input_bbmkendaraan')?>" method="post">
                <div class="modal-body">
		            <div class="form-group">
				        <label for="inputsm">PILIH KANTOR CABANG</label>
                        <select class="form-control input-sm" name="kdgudang" id="kdgudang" required>
                            <option value="">---PILIH KANTOR CABANG --</option>
                            <?php foreach($list_kanwil as $v){?>
                                <option value="<?= trim($v->kdcabang) ?>" data-data='<?= json_encode($v, JSON_FORCE_OBJECT) ?>'></option>
                            <?php }?>
                        </select>
		            </div>
                    <script type="text/javascript">
                        $('#kdgudang').selectize({
                            plugins: ['hide-arrow', 'selectable-placeholder'],
                            valueField: 'kdcabang',
                            labelField: 'desc_cabang',
                            searchField: ['kdcabang', 'desc_cabang'],
                            options: [],
                            create: false,
                            initData: true,
                            render: {
                                option: function(item, escape) {
                                    return '' +
                                        '<div class=\'row\'>' +
                                            '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.kdcabang) + '</div>' +
                                            '<div class=\'col-xs-10 col-md-10 text-nowrap\'>' + escape(item.desc_cabang) + '</div>' +
                                        '</div>' +
                                    '';
                                }
                            }
                        }).on('change', function() {
                            $('#kdbarang')[0].selectize.clearOptions();
                            $.ajax({
                                url: "get_barang",
                                type: "post",
                                data: {
                                    kdgroup: $('#kdgroup').val(),
                                    kdgudang: $('#kdgudang').val()
                                },
                                dataType  : 'json',
                                success: function(data) {
                                    for(var i = 0; i < data.length; i++) {
                                        $('#kdbarang')[0].selectize.addOption({
                                            nodok: data[i].nodok,
                                            nopol: data[i].nopol,
                                            nmbarang: data[i].nmbarang
                                        });
                                    }
                                }
                            });
                        });
                        $("#kdgudang").addClass("selectize-hidden-accessible");
                    </script>
                    <input type="hidden" id="type" name="type"  value="INPUTBBMKENDARAAN" class="form-control" readonly>
                    <input type="hidden" id="kdgroup" name="kdgroup"  value="KDN" class="form-control" readonly>
                    <div class="form-group">
                        <label  for="inputsm">NAMA KENDARAAN & NOPOL</label>
                        <select name="kdbarang" class="form-control input-sm ch" placeholder="---KETIK / NOPOL / NAMA KENDARAAN--" id="kdbarang" required>
                            <option value="" class=""></option>
                        </select>
                    </div>
                    <script type="text/javascript">
                        $('#kdbarang').selectize({
                            plugins: ['hide-arrow', 'selectable-placeholder'],
                            valueField: 'nodok',
                            labelField: 'nopol',
                            searchField: ['nopol', 'nmbarang'],
                            options: [],
                            create: false,
                            initData: true,
                            render: {
                                option: function(item, escape) {
                                    return '' +
                                        '<div class=\'row\'>' +
                                            '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.nopol) + '</div>' +
                                            '<div class=\'col-xs-10 col-md-10 text-nowrap\'>' + escape(item.nmbarang) + '</div>' +
                                        '</div>' +
                                    '';
                                }
                            }
                        });
                        $("#kdbarang").addClass("selectize-hidden-accessible");
                    </script>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i> PROSES</button>
                </div>
	        </form>
        </div>
    </div>
</div>


<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> FILTER PERIODE PENCARIAN </h4>
            </div>
            <form action="<?php echo site_url('ga/bbmkendaraan/form_bbmkendaraan')?>" method="post" name="inputformPbk">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-group ">
                                        <label for="inputsm">PILIH PERIODE BERDASARKAN TANGGAL INPUT </label>
                                        <input type="input" name="periode" id="periode" class="form-control input-sm tglYM"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="inputsm">PILIH KANTOR CABANG</label>
                                        <select class="form-control input-sm" name="kdgudangfl" id="kdgudangfl">
                                            <option value="">---PILIH KANTOR CABANG --</option>
                                            <?php foreach($list_kanwil as $v){?>
                                                <option value="<?= trim($v->kdcabang) ?>" data-data='<?= json_encode($v, JSON_FORCE_OBJECT) ?>'></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <script type="text/javascript">
                                        $('#kdgudangfl').selectize({
                                            plugins: ['hide-arrow', 'selectable-placeholder'],
                                            valueField: 'kdcabang',
                                            labelField: 'desc_cabang',
                                            searchField: ['kdcabang', 'desc_cabang'],
                                            options: [],
                                            create: false,
                                            initData: true,
                                            render: {
                                                option: function(item, escape) {
                                                    return '' +
                                                        '<div class=\'row\'>' +
                                                            '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.kdcabang) + '</div>' +
                                                            '<div class=\'col-xs-10 col-md-10 text-nowrap\'>' + escape(item.desc_cabang) + '</div>' +
                                                        '</div>' +
                                                    '';
                                                }
                                            }
                                        }).on('change', function() {
                                            $('#kdbarangfl')[0].selectize.clearOptions();
                                            $.ajax({
                                                url: "get_barang",
                                                type: "post",
                                                data: {
                                                    kdgroup: $('#kdgroupfl').val(),
                                                    kdgudang: $('#kdgudangfl').val()
                                                },
                                                dataType  : 'json',
                                                success: function(data) {
                                                    for(var i = 0; i < data.length; i++) {
                                                        $('#kdbarangfl')[0].selectize.addOption({
                                                            nodok: data[i].nodok,
                                                            nopol: data[i].nopol,
                                                            nmbarang: data[i].nmbarang
                                                        });
                                                    }
                                                }
                                            });
                                        });
                                        $("#kdgudangfl").addClass("selectize-hidden-accessible");
                                    </script>
                                    <input type="hidden" id="kdgroupfl" name="kdgroupfl"  value="KDN" class="form-control" readonly>
                                    <div class="form-group">
                                        <label  for="inputsm">NAMA KENDARAAN & NOPOL</label>
                                        <select name="kdbarangfl" class="form-control input-sm ch" placeholder="---KETIK / NOPOL / NAMA KENDARAAN--" id="kdbarangfl">
                                            <option value="" class=""></option>
                                        </select>
                                    </div>
                                    <script type="text/javascript">
                                        $('#kdbarangfl').selectize({
                                            plugins: ['hide-arrow', 'selectable-placeholder'],
                                            valueField: 'nodok',
                                            labelField: 'nopol',
                                            searchField: ['nopol', 'nmbarang'],
                                            options: [],
                                            create: false,
                                            initData: true,
                                            render: {
                                                option: function(item, escape) {
                                                    return '' +
                                                        '<div class=\'row\'>' +
                                                            '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.nopol) + '</div>' +
                                                            '<div class=\'col-xs-10 col-md-10 text-nowrap\'>' + escape(item.nmbarang) + '</div>' +
                                                        '</div>' +
                                                    '';
                                                }
                                            }
                                        });
                                        $("#kdbarangfl").addClass("selectize-hidden-accessible");
                                    </script>
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary"><i class="fa fa-search"></i></i> CARI</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('.tglYM').datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months"
    });
    $(document).ready(function(){
        <?php if ($isCanReopenPrint){ ?>
        $('a.re-open').on('click',function (){
            var row = $(this)
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi',
                html: 'KONFIRMASI TAMPILKAN KEMBALI TOMBOL PRINT DOKUMEN <b>'+ row.data('id') +'</b> ?',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: false,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        html: '<h3>Sedang proses...</h3>',
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    })
                    $.ajax({
                        url: row.data('href'),
                        type: 'POST',
                        success: function (data) {
                            Swal.close();
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm ml-3',
                                    cancelButton: 'btn btn-sm ml-3',
                                    denyButton: 'btn btn-sm ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'success',
                                title: 'Berhasil Diubah',
                                html: data.message,
                                timer: 3000,
                                timerProgressBar: true,
                                showCloseButton: true,
                                showConfirmButton: false,
                                showDenyButton: true,
                                denyButtonText: `Tutup`,
                            }).then(function(){
                                window.location.replace(data.redirect);
                            });
                        },
                        error: function (xhr, status, thrown) {
                            Swal.close();
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Gagal Diubah',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: true,
                                showDenyButton: false,
                                confirmButtonText: `Tutup`,
                            });
                        },
                    });
                }
            });
        })
        <?php } ?>

        $('a.choose-print').on('click', function (){
            var row = $(this)
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'PILIH JENIS CETAKAN',
                html: `<table style="width: 100%; text-align: left">
    <tr>
        <td>NOMINAL NORMAL</td>
        <td>SAMA SEPERTI NOMINAL DOKUMEN</td>
    </tr>
    <tr>
        <td>NOMINAL KOSONG</td>
        <td>NOMINAL DIGANTI MENJADI Rp 0</td>
    </tr>
</table>`,
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                cancelButtonText: 'BATAL',
                confirmButtonText: 'NOMINAL NORMAL',
                denyButtonText: 'NOMINAL KOSONG',
            }).then(function (result) {
                if (result.isConfirmed) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        html: '<h3>Sedang proses...</h3>',
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });
                    $.ajax({
                        url: row.data('href'),
                        data: {printype : 'nonzero'},
                        type: 'POST',
                        success: function (data) {
                            Swal.close();
                            window.open(data.url, '_blank');
                            window.location.reload();
                        },
                        error: function (xhr, status, thrown) {
                            Swal.close();
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: true,
                                showDenyButton: false,
                                confirmButtonText: `Tutup`,
                            });
                        },
                    });

                }
                if (result.isDenied) {
                    console.log('kosong')
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success ml-3',
                            cancelButton: 'btn btn-sm btn-warning ml-3',
                            denyButton: 'btn btn-sm btn-danger ml-3',
                        },
                        buttonsStyling: false,
                    }).fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        html: '<h3>Sedang proses...</h3>',
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    })
                    $.ajax({
                        url: row.data('href'),
                        data: {printype : 'zero'},
                        type: 'POST',
                        success: function (data) {
                            Swal.close();
                            window.open(data.url, '_blank');
                            window.location.reload();
                        },
                        error: function (xhr, status, thrown) {
                            Swal.close();
                            Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-success ml-3',
                                    cancelButton: 'btn btn-sm btn-warning ml-3',
                                    denyButton: 'btn btn-sm btn-danger ml-3',
                                },
                                buttonsStyling: false,
                            }).fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                showCloseButton: true,
                                showConfirmButton: true,
                                showDenyButton: false,
                                confirmButtonText: `Tutup`,
                            });
                        },
                    });
                }
            })
        })
    })

</script>
