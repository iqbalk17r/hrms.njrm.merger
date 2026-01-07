<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<style>
  /*-- change navbar dropdown color --*/
  .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu {
  	background-color: #008040;
    color:#ffffff;
  }

</style>
<script type="text/javascript">
            $(function() {
				$("#example1").dataTable({
					"autoWidth": false
				});
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				/*$('#example1').bootstrapTable({
						resizable: true,
						headerOnly: true,
						data: data
				});*/
			//	$("#tglrange").daterangepicker();
            });

			//empty string means no validation error

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
<?php echo $message;?>
<div class="row">
	<!--div class="col-sm-3">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Kendaraan</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div--->
	<div class="col-sm-3">
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li>
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filterinput"  href="#">Input Pengarsipan</a></li>
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Kendaraan</a></li-->
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("trans/cuti_karyawan/listkaryawan_iss")?>">Input Cuti</a></li-->
				  <!--li role="presentation" class="divider"></li>
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Haduh Us</a></li--->
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->

</div>
</br>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
			 <!--legend><?php echo $title;?></legend--->
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped uk-overflow-container" >
					<thead>
								<tr>
									<th width="2%">No.</th>
                                    <th width="2%">LINK</th>
									<th>NO DOKUMEN</th>
									<th>ID ARSIP</th>
									<th>NAMA ARSIP</th>
									<th>EXPIRE </th>
									<th>PEMILIK ARSIP</th>
									<th>STATUS</th>
									<th>KETERANGAN</th>

									<th>AKSI</th>
								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_trx_mst as $row): $no++;?>
						<tr>

							<td width="2%"><?php echo $no;?></td>
                            <td WIDTH="2%"><a href="#"
                                              <?php if (trim($row->att_name)!=='') { ?>
                                              onclick="window.open('<?php echo site_url('assets/files/arsipDokumen').'/'.trim($row->att_name);?>')"
                                              <?php } ?>
                                              class="btn btn-info  btn-sm" title="Lihat Lampiran">	<i class="fa fa-eye"></i> </a>

                            </td>
							<td><?php echo trim($row->docno);?></td>
                            <td><?php echo trim($row->arsip_asli);?></td>
                            <td><?php echo trim($row->archives_name);?></td>
                            <td><?php if(trim($row->archives_exp)=='') { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->archives_exp))); } ?></td>
							<td><?php echo trim($row->archives_own);?></td>
							<td><?php echo trim($row->nmstatus);?></td>
							<td><?php echo trim($row->description);?></td>

							<td width="8%">
                                    <a href="<?php
                                    $enc_docno=bin2hex($this->encrypt->encode(trim($row->docno)));
                                    $enc_archives_id=bin2hex($this->encrypt->encode(trim($row->archives_id)));
                                    echo site_url('ga/arsipdokumen/detail_arsipdokumen').'/'.$enc_docno;?>" class="btn btn-default  btn-sm" title="Detail Data Arsip">	<i class="fa fa-bars"></i> </a>

                                <?php IF (trim($row->status)==='A') { ?>
                                    <a href="<?php
									$enc_docno=bin2hex($this->encrypt->encode(trim($row->docno)));
                                    $enc_archives_id=bin2hex($this->encrypt->encode(trim($row->archives_id)));
                                    echo site_url('ga/arsipdokumen/edit_arsipdokumen').'/'.$enc_docno.'/'.$enc_archives_id;?>" class="btn btn-primary  btn-sm" title="Ubah Data Arsip">	<i class="fa fa-gear"></i> </a>

                                    <a href="<?php
                                    $enc_docno=bin2hex($this->encrypt->encode(trim($row->docno)));
                                    $enc_archives_id=bin2hex($this->encrypt->encode(trim($row->archives_id)));
                                    echo site_url('ga/arsipdokumen/approval_arsipdokumen').'/'.$enc_docno.'/'.$enc_archives_id;?>" class="btn btn-success  btn-sm" title="Approval Data Arsip">	<i class="fa fa-check"></i> </a>

                                    <a href="<?php
                                    $enc_docno=bin2hex($this->encrypt->encode(trim($row->docno)));
                                    $enc_archives_id=bin2hex($this->encrypt->encode(trim($row->archives_id)));
                                    echo site_url('ga/arsipdokumen/cancel_arsipdokumen').'/'.$enc_docno.'/'.$enc_archives_id;?>" class="btn btn-danger  btn-sm" title="Pembatalan Data Arsip">	<i class="fa fa-trash-o"></i> </a>

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



<!--Modal untuk Filter PENGARSIPAN DOKUMEN-->
<div class="modal fade" id="filterinput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">INPUT & PILIH PENGARSIPAN DOKUMEN</h4>
      </div>
	  <form action="<?php echo site_url('ga/arsipdokumen/input_arsipdokumen')?>" method="post">
      <div class="modal-body">
        <!--div class="form-group input-sm ">
			<label class="label-form col-sm-3">Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name='bulan'>

					<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
					<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
					<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
					<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
					<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
					<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
					<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
					<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
					<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
					<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
					<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
					<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
				</select>
			</div>
		</div--->
		<div class="form-group">
				<label for="inputsm">PILIH WILAYAH</label>
					<select class="form-control input-sm" name="kdgudang" id="kdgudang">
					<option value="">---PILIH KANTOR CABANG --</option>
					<?php foreach($list_kanwil as $sc){?>
						<option value="<?php echo trim($sc->loccode);?>" ><?php echo trim($sc->loccode).' || '.trim($sc->locaname);?></option>
					<?php }?>
					</select>
		</div>
<script type="text/javascript">
$(function() {

	 $('#kdgudang').selectize().on('change click', function() {
        console.log('kdbarang >> clear');
       $('#kdbarang')[0].selectize.clearOptions();
    });


			});
</script>
<!--input type="hidden" id="kdgudang" name="kdgudang"  value="SBYMRG" class="form-control" readonly-->
<input type="hidden" id="type" name="type"  value="INPUTTMPARSIPDOKUMEN" class="form-control" readonly>
<input type="hidden" id="kdgroup" name="kdgroup"  value="DCN" class="form-control" readonly>
		<div class="form-group">
			<label  for="inputsm">NAMA ARSIP DOKUMEN</label>
				<select name="kdbarang" class="form-control input-sm ch" placeholder="---KETIK KODE ARSIP ATAU NAMA ARSIP--" id="kdbarang">
					<option value="" class=""></option>
				</select>
		</div>
<script type="text/javascript">
$(function() {
	 var totalCount,
        page,
        perPage = 7;
	//$('[name=\'mpkdbarang\']').selectize({
	$('[name=\'kdbarang\']').selectize({
        plugins: ['hide-arrow', 'selectable-placeholder', 'infinite-scroll'],
        valueField: 'docno',
        labelField: 'archives_name',
        searchField: ['docno', 'archives_name'],
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                return '' +
                 '<div class=\'row\'>' +
                    '<div class=\'col-xs-6 col-md-6 text-nowrap\'>' + escape(item.archives_id) + '</div>' +
                    '<div class=\'col-xs-6 col-md-6 text-nowrap\'>' + escape(item.archives_name) + '</div>' +
                  '</div>' +
                 '';
            }
        },
        load: function(query, callback) {
            query = JSON.parse(query);
            page = query.page || 1;

            //if( ! totalCount || totalCount > ( (page - 1) * perPage) ){
            $.post(base('ga/indoc/add_archive_ajax'), {
                _search_: query.search,
                _perpage_: perPage,
                _page_: page,
				_kdgroup_: $('#kdgroup').val(),
				_kdgudang_: $('#kdgudang').val()
            })
            .done(function(json) {
                  console.log('JSON Data: ' + JSON.stringify(json, null, '\t'));
                  totalCount = json.totalcount;
                  callback(json.group);
            })
            .fail(function( jqxhr, textStatus, error ) {
                  callback();
            });
            /*} else {
                callback();
            }*/
        }
    });
	/*.on('change', function() {
        console.log('_officeid_ >> on.change');
        console.log('mpkdgroup >> clear');
        $('[name=\'mpkdgroup\']')[0].selectize.clearOptions();
    }); */


			});
</script>
		<!--div class="form-group">
				<label for="inputsm">JENIS PENGURUSAN STNKB</label>
				<select class="form-control input-sm" name="jenispkb">
					<option value='<!?php echo '1T'; ?>'><!?php echo ' PAJAK TAHUNAN KENDARAAN '; ?></option>
					<option value='<!?php echo '5T'; ?>'><!?php echo ' PAJAK 5 TAHUNAN & GANTI PLAT KENDARAAN '; ?></option>

				</select>
		</div--->
<?php /*		<div class="form-group">
				<label for="inputsm">TAHUN</label>
				<select class="form-control input-sm" name="tahun">
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>
				</select>
		</div> */ ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i>PROSES</button>
      </div>
	  </form>
    </div>
  </div>
</div>


<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">FILTER PENCARIAN ARSIP DOKUMEN</h4>
            </div>
            <form action="<?php echo site_url('ga/arsipdokumen/form_arsipdokumen')?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputsm">PILIH WILAYAH</label>
                        <select class="form-control input-sm" name="kdgudang_acv" id="kdgudang_acv">
                            <option value="">---PILIH KANTOR CABANG --</option>
                            <?php foreach($list_kanwil as $sc){?>
                                <option value="<?php echo trim($sc->loccode);?>" ><?php echo trim($sc->loccode).' || '.trim($sc->locaname);?></option>
                            <?php }?>
                        </select>
                    </div>
                    <script type="text/javascript">
                        $(function() {

                            $('#kdgudang_acv').selectize().on('change click', function() {
                                console.log('id_acv >> clear');
                                $('#kdbarang')[0].selectize.clearOptions();
                            });


                        });
                    </script>
                    <!--input type="hidden" id="kdgudang" name="kdgudang"  value="SBYMRG" class="form-control" readonly-->
                    <input type="hidden" id="type" name="type"  value="INPUTTMPARSIPDOKUMEN" class="form-control" readonly>
                    <input type="hidden" id="kdgroup_acv" name="kdgroup_acv"  value="DCN" class="form-control" readonly>
                    <div class="form-group">
                        <label  for="inputsm">NAMA ARSIP DOKUMEN</label>
                        <select name="id_acv" class="form-control input-sm ch" placeholder="---KETIK KODE ARSIP ATAU NAMA ARSIP--" id="id_acv">
                            <option value="" class=""></option>
                        </select>
                    </div>
                    <script type="text/javascript">
                        $(function() {
                            var totalCount,
                                page,
                                perPage = 7;
                            //$('[name=\'mpkdbarang\']').selectize({
                            $('[name=\'id_acv\']').selectize({
                                plugins: ['hide-arrow', 'selectable-placeholder', 'infinite-scroll'],
                                valueField: 'docno',
                                labelField: 'archives_name',
                                searchField: ['docno', 'archives_name'],
                                options: [],
                                create: false,
                                render: {
                                    option: function(item, escape) {
                                        return '' +
                                            '<div class=\'row\'>' +
                                            '<div class=\'col-xs-6 col-md-6 text-nowrap\'>' + escape(item.archives_id) + '</div>' +
                                            '<div class=\'col-xs-6 col-md-6 text-nowrap\'>' + escape(item.archives_name) + '</div>' +
                                            '</div>' +
                                            '';
                                    }
                                },
                                load: function(query, callback) {
                                    query = JSON.parse(query);
                                    page = query.page || 1;

                                    //if( ! totalCount || totalCount > ( (page - 1) * perPage) ){
                                    $.post(base('ga/indoc/add_archive_ajax'), {
                                        _search_: query.search,
                                        _perpage_: perPage,
                                        _page_: page,
                                        _kdgroup_: $('#kdgroup_acv').val(),
                                        _kdgudang_: $('#kdgudang_acv').val()
                                    })
                                        .done(function(json) {
                                            console.log('JSON Data: ' + JSON.stringify(json, null, '\t'));
                                            totalCount = json.totalcount;
                                            callback(json.group);
                                        })
                                        .fail(function( jqxhr, textStatus, error ) {
                                            callback();
                                        });
                                    /*} else {
                                        callback();
                                    }*/
                                }
                            });
                            /*.on('change', function() {
                                console.log('_officeid_ >> on.change');
                                console.log('mpkdgroup >> clear');
                                $('[name=\'mpkdgroup\']')[0].selectize.clearOptions();
                            }); */


                        });
                    </script>
                    <!--div class="form-group">
                            <label for="inputsm">JENIS PENGURUSAN STNKB</label>
                            <select class="form-control input-sm" name="jenispkb">
                                <option value='<!?php echo '1T'; ?>'><!?php echo ' PAJAK TAHUNAN KENDARAAN '; ?></option>
                                <option value='<!?php echo '5T'; ?>'><!?php echo ' PAJAK 5 TAHUNAN & GANTI PLAT KENDARAAN '; ?></option>

                            </select>
                    </div--->
                    <?php /*		<div class="form-group">
				<label for="inputsm">TAHUN</label>
				<select class="form-control input-sm" name="tahun">
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>
				</select>
		</div> */ ?>
                    <div class="form-group">
                        <label  for="inputsm">PERIODE</label>
                        <input type="text" id="periode" name="periode"  class="form-control tglYM ratakanan" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i>PROSES</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
	//Date range picker
    	$("#tgl").datepicker();
    	$(".tgl").datepicker();
    	$(".tglan").datepicker();
				$('.year').datepicker({
					format: " yyyy",
					viewMode: "years",
					minViewMode: "years"
				});
    $('.tglYM').datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months"
    });
</script>
