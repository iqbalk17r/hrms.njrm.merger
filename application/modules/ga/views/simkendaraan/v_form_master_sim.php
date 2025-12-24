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
                $("#nik").selectize();
                $("#typesim").selectize();
                $(".sl").selectize();
            });
					
			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>

<legend><?php echo $title;?></legend>
	
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
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filterinput"  href="#">Input Master SIM</a></li>
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
									<th>NAMA LENGKAP</th>
									<th>NIK</th>
									<th>DEPARTMENT</th>
									<th>SIM</th>
									<th>TGL BUAT</th>
									<th>TGL BERAKHIR</th>

									<th>AKSI</th>
								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_trx_mst as $row): $no++;?>
						<tr>
							
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo trim($row->nmlengkap);?></td>
							<td><?php echo trim($row->nik);?></td>
							<td><?php echo trim($row->nmdept);?></td>
							<td align="center"><?php echo trim($row->typesim);?></td>
							<td><?php echo date('d-m-Y', strtotime(trim($row->datecreate)));?></td>
							<td><?php echo date('d-m-Y', strtotime(trim($row->expsim)));?></td>

							<td width="8%">
                                    <a href="<?php
                                    $enc_typesim=bin2hex($this->encrypt->encode(trim($row->typesim)));
                                    $enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
                                    echo site_url('ga/simkendaraan/detail_master_simkendaraan').'/'.$enc_typesim.'/'.$enc_nik;?>" class="btn btn-default  btn-sm" title="Detail Data SIM">	<i class="fa fa-bars"></i> </a>

                                    <a href="<?php
                                    $enc_typesim=bin2hex($this->encrypt->encode(trim($row->typesim)));
                                    $enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
                                    echo site_url('ga/simkendaraan/delete_master_simkendaraan').'/'.$enc_typesim.'/'.$enc_nik;?>" class="btn btn-danger  btn-sm" title="Penghapusan Data SIM" onclick="return confirm('Apa Kamu Yakin Akan Menghapus Data Ini ?')">	<i class="fa fa-trash-o"></i> </a>

                                <?php /*	<?php IF (trim($row->status)=='A' or trim($row->status)=='I') { ?>
									<a href="<?php 
									$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
									$enc_jenispengurusan=bin2hex($this->encrypt->encode(trim($row->jenispengurusan)));
									echo site_url('ga/kendaraan/approv_stnktmp').'/'.$enc_nodok.'/'.$enc_jenispengurusan;?>" class="btn btn-success  btn-sm" title="PERSETUJUAN INPUT PEMBAHARUAN STNKB">	<i class="fa fa-check"></i>
									
									
									<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->nodok);?>" class="btn btn-danger  btn-sm" title="HAPUS/BATAL PEMBAHARUAN STNKB">
										<i class="fa fa-trash-o"></i></a>
									<?php } ?>
									<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php echo site_url('ga/kendaraan/sti_pengajuan_stnkb/'.trim($row->nodok));?>');"><i class="fa fa-print"></i></button>
									<a href="#" data-toggle="modal" data-target="#DETAIL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm" title="DETAIL PEMBAHARUAN STNKB"><i class="fa fa-bars"></i></a>
                                */?>
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
        <h4 class="modal-title" id="myModalLabel">INPUT & PILIH KARYAWAN UNTUK KEPEMILIKAN SIM</h4>
      </div>
	  <!--form action="<?php echo site_url('ga/kendaraan/list_kendaraanwil')?>" method="post"--->
	  <form action="<?php echo site_url('ga/simkendaraan/input_master_simkendaraan')?>" method="post">
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
              <label for="inputsm">PILIH NIK KARYAWAN</label>
              <select class="form-control input-sm" name="nik" id="nik" required>
                  <option value="">---PILIH KARYAWAN --</option>
                  <?php foreach($list_karyawan as $sc){?>
                      <option value="<?php echo trim($sc->nik);?>" ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>
                  <?php }?>
              </select>
          </div>
          <div class="form-group">
              <label for="inputsm">PILIH TYPE SIM</label>
              <select class="form-control input-sm" name="typesim" id="typesim" required>
                  <option value="">---PILIH TYPE SIM --</option>
                  <?php foreach($list_sim as $sc){?>
                      <option value="<?php echo trim($sc->kdtrx);?>" >
                          <?php echo trim($sc->kdtrx).' || '.trim($sc->uraian);?></option>
                  <?php }?>
              </select>
          </div>

          <?php /*
          <script type="text/javascript">
$(function() {				 

	 $('#kdgudang').selectize().on('change click', function() {
        console.log('kdbarang >> clear');
        $('#kdbarang')[0].selectize.clearOptions();
    });
					 
					 
			});
</script>	
<!--input type="hidden" id="kdgudang" name="kdgudang"  value="SBYMRG" class="form-control" readonly-->
<input type="hidden" id="type" name="type"  value="INPUTTMPUJIKIR" class="form-control" readonly>
<input type="hidden" id="kdgroup" name="kdgroup"  value="KDN" class="form-control" readonly>
		<div class="form-group">
			<label  for="inputsm">NAMA KENDARAAN & NOPOL</label>
				<select name="kdbarang" class="form-control input-sm ch" placeholder="---KETIK / NOPOL / NAMA KENDARAAN--" id="kdbarang">
					<option value="" class=""></option>
				</select>
		</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 7;				 
	//$('[name=\'mpkdbarang\']').selectize({
	$('#kdbarang').selectize({
        plugins: ['hide-arrow', 'selectable-placeholder', 'infinite-scroll'],
        valueField: 'nodok',
        labelField: 'nmbarang',
        searchField: ['nodok', 'nmbarang'],
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                return '' +
                 '<div class=\'row\'>' +
                    '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.nopol) + '</div>' +
                    '<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nmbarang) + '</div>' +
                  '</div>' +
                 '';
            }
        },
        load: function(query, callback) {
            query = JSON.parse(query);
            page = query.page || 1;
        
            if( ! totalCount || totalCount > ( (page - 1) * perPage) ){
            $.post(base('ga/instock/add_stock_ajax_kendaraan_wilayah'), {
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
            } else {
                callback();
            }
        }
    });
	/*.on('change', function() {
        console.log('_officeid_ >> on.change');
        console.log('mpkdgroup >> clear');
        $('[name=\'mpkdgroup\']')[0].selectize.clearOptions();
    }); */ /*
	$('#jenispkb').selectize();				 
					 
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
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel"> FILTER KEPEMILIKAN SIM KENDARAAN </h4>
                </div>
            <form action="<?php echo site_url('ga/simkendaraan/form_master_sim')?>" method="post" name="InputSimKendaraan">
                <div class="modal-body">
                        <div class="form-group">
                            <label for="inputsm">PILIH NIK KARYAWAN</label>
                            <select class="form-control input-sm sl" name="nik" id="nik" required>
                                <option value="">---PILIH KARYAWAN --</option>
                                <?php foreach($list_karyawan as $sc){?>
                                    <option value="<?php echo trim($sc->nik);?>" ><?php echo trim($sc->nik).' || '.trim($sc->nmlengkap);?></option>
                                <?php }?>
                            </select>
                        </div>
                </div>
            </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit"  class="btn btn-primary"><i class="fa fa-search"></i></i>CARI</button>
                </div>

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