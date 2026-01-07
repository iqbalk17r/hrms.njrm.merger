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
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				$("#satkecil").selectize();
				
				$("#kdsubgroup").chained("#kdgroup");
				$("#edkdsubgroup").chained("#edkdgroup");
				
			//	$("#tglrange").daterangepicker(); 
            });
					
			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
	
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
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#FILTER_MODAL"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Barang</a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("trans/cuti_karyawan/listkaryawan_iss")?>">Input Cuti</a></li-->
				  <!--li role="presentation" class="divider"></li>	
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Haduh Us</a></li---> 
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
	
</div>	
</br>
<div class="col-sm-12">

			<div class="row">
				<div class="col-xs-12">                            
					<div class="box">
						<div class="box-header">
						 <legend><?php echo $title;?></legend>							
						</div><!-- /.box-header -->	
						<div class="box-body table-responsive" style='overflow-x:scroll;'>
							<table id="example1" class="table table-bordered table-striped" >
								<thead>
											<tr>											
												<th width="2%">No.</th>
												<th>ID BARANG</th>
												<th>NAMA BARANG</th>
												<th>TIPE BARANG</th>
												<th>HOLD ITEM</th>
												<th>Aksi</th>		
											</tr>
								</thead>
										<tbody>
										<?php $no=0; foreach($list_mstbarang as $row): $no++;?>
									<tr>
										
										<td width="2%"><?php echo $no;?></td>
										<td><?php echo $row->nodok;?></td>
										<td><?php echo $row->nmbarang;?></td>
										<td><?php echo $row->nmtypebarang;?></td>
										<td><?php echo $row->hold_item;?></td>
										<td width="15%">
												<a href="<?php echo site_url('ga/inventaris/detail_view_mst_brg').'/'.bin2hex($this->encrypt->encode(trim($row->nodok)));?>" class="btn btn-default  btn-sm" title="DETAIL BARANG"><i class="fa fa-bars"></i> </a>
												
												<a href="<?php echo site_url('ga/inventaris/edit_view_mst_brg').'/'.bin2hex($this->encrypt->encode(trim($row->nodok)));?>" class="btn btn-primary  btn-sm" title="UBAH NAMA BARANG"><i class="fa fa-gear"></i> </a>
												<?php if (trim($row->rowstock)==0) { ?>	
												<a href="<?php echo site_url('ga/inventaris/hapus_view_mst_brg').'/'.bin2hex($this->encrypt->encode(trim($row->nodok)));?>" class="btn btn-danger  btn-sm" title="HAPUS BARANG"><i class="fa fa-trash-o"></i> </a>
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
</div>
<!-- Modal Input Master Barang ATK -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER BARANG</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mstbarang');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 <!--div class="form-group">
				<label for="inputsm">Nomor Dokumen Barang</label>
				<input type="text" class="form-control input-sm" id="nodok" name="nodok" style="text-transform:uppercase" placeholder="Dokumen Barang" maxlength="50" required>
				
			  </div--->
			  <div class="form-group">
				<label for="inputsm">NAMA BARANG</label>
				<input type="text" class="form-control input-sm" id="nmbarang" style="text-transform:uppercase" name="nmbarang" placeholder="Inputkan Nama Barang" maxlength="50" required>
				<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
			  </div>
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm" name="kdgroup" id="kdgroup" required>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup">
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Type Barang</label>	
					<select class="form-control input-sm" name="typebarang" id="typebarang" >
					<option value="">---PILIH TYPE BARANG--</option> 
					<option value="LJ">LJ || BARANG BERKELANJUTAN </option> 
					<option value="SP">SP || BARANG SEKALI PAKAI </option> 
					</select>
			</div>	
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
				<label for="inputsm">SATUAN DASAR BARANG</label>	
					<select class="form-control input-sm satkecil" name="satkecil" id="satkecil" required>
					 <option value="">---PILIH SATUAN DASAR BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
					</select>
			</div>
			  <div class="form-group">
				<label for="inputsm">HOLD</label>	
					<select class="form-control input-sm" name="hold_item" id="hold_item">
					 <option value="NO">TIDAK</option> 
					 <option value="YES">YA</option> 
					</select>
			  </div>

			<div class="form-group">
				<label for="inputsm">Keterangan</label>
				<textarea  class="textarea" name="keterangan" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
			  </div>
			</div> 
		</div>
		</div>
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Submit</button>
      </div>
		</form>
		
		</div>  
	  </div>
	</div>
		


<div class="modal fade" id="FILTER_MODAL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN BARANG </h4>
	  </div>
<form action="<?php echo site_url('ga/inventaris/form_mstbarang')?>" method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<!--div class="form-group ">
									<label class="col-sm-4" for="inputsm">PILIH PERIODE </label>	
									<div class="col-sm-8"> 
										<input type="input" name="tgl" id="tgl" class="form-control input-sm tglrange"  >
									</div>
							</div---->		
							<!--div class="form-group ">
									<label class="col-sm-4" for="inputsm">PILIH NAMA KARYAWAN </label>
									<div class="col-sm-8"> 
									<select class="form-control input-sm " name="nik" id="nik">
										<option value=""><tr><th width="20%">-- NIK |</th><th width="80%">| NAMA KARYAWAN --</th></tr></option> 
										<?php foreach($list_nik as $sc){?>					  
										<option value="<?php echo trim($sc->nik);?>" ><tr><th width="20%"><?php echo trim($sc->nik);?>  |</th><th width="80%">| <?php echo trim($sc->nmlengkap);?></th></tr></option>						  
										<?php }?>
									</select>
									</div>
							</div--->
							<div class="form-group">
									<label for="inputsm">Kode Group Barang</label>	
									 
                                    <select name="kdgroup" class="form-control input-sm ch2" placeholder="---KETIK KODE / NAMA GROUP---" id="kdgroup_ed" required>
                                        <option value="" class=""></option>
                                    </select>
									
							</div>
							
<script type="text/javascript">
$(function() {
	 
					 
	 var totalCount, 
        page, 
        perPage = 7;				 
	 ///$('[name=\'kdgroup_inp\']').selectize({
	 $('#kdgroup_ed').selectize({
        plugins: ['hide-arrow', 'selectable-placeholder', 'infinite-scroll'],
        valueField: 'kdgroup',
        labelField: 'nmgroup',
        searchField: ['kdgroup', 'nmgroup'],
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                return '' +
                 '<div class=\'row\'>' +
                    '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.kdgroup) + '</div>' +
                    '<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nmgroup) + '</div>' +
                  '</div>' +
                 '';
            }
        },
        load: function(query, callback) {
            query = JSON.parse(query);
            page = query.page || 1;
        
            if( ! totalCount || totalCount > ( (page - 1) * perPage) ){
            $.post(base('ga/instock/add_stock_ajax_kdgroup'), {
                _search_: query.search,
                _perpage_: perPage,
                _page_: page,
				_paramkdgroupmodul_: " and kdgroup NOT IN ('KDN') "
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
    }).on('change click', function() {
        console.log('kdgroup_ed >> on.change');
        console.log('kdsubgroup_ed >> clear');
		//$('[name=\'kdsubgroup_inp\']')[0].selectize.clearOptions();
        $('#kdsubgroup_ed')[0].selectize.clearOptions();
    });
					 
					 
			});
</script>
							<div class="form-group">
								<label for="inputsm">Kode Sub Group Barang</label>	
									 
                                    <select name="kdsubgroup" class="form-control input-sm ch2" placeholder="---KETIK / NAMA SUB GROUP---" id="kdsubgroup_ed" required>
                                        <option value="" class=""></option>
                                    </select>
									
							</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 7;				 
	/// $('[name=\'kdsubgroup_inp\']').selectize({
	 $('#kdsubgroup_ed').selectize({
        plugins: ['hide-arrow', 'selectable-placeholder', 'infinite-scroll'],
        valueField: 'kdsubgroup',
        labelField: 'nmsubgroup',
        searchField: ['kdsubgroup', 'nmsubgroup'],
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                return '' +
                 '<div class=\'row\'>' +
                    '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.kdsubgroup) + '</div>' +
                    '<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nmsubgroup) + '</div>' +
                  '</div>' +
                 '';
            }
        },
        load: function(query, callback) {
            query = JSON.parse(query);
            page = query.page || 1;
        
            if( ! totalCount || totalCount > ( (page - 1) * perPage) ){
            $.post(base('ga/instock/add_stock_ajax_kdsubgroup'), {
                _search_: query.search,
                _perpage_: perPage,
                _page_: page,
				//_kdgroup_: $('[name=\'kdgroup_inp\']').val()
				_kdgroup_: $('#kdgroup_ed').val(),
				_parammodul_: " and kdsubgroup IS NOT NULL "
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
    }).on('change click', function() {
        console.log('_officeid_ >> on.change');
        console.log('kdgroup_ed >> clear');
        //$('[name=\'kdgroup_inp\']')[0].selectize.clearOptions();
        $('#kdbarang_ed')[0].selectize.clearOptions();
    });
					 
					 
			});
</script>							
							<div class="form-group">
								<label for="inputsm">Kode Barang</label>	
									
                                    <select name="kdbarang" class="form-control input-sm ch" placeholder="---KETIK / NAMA BARANG--" id="kdbarang_ed" required>
                                        <option value="" class=""></option>
                                    </select>
									
							</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 7;				 
	//$('[name=\'kdbarang_inp\']').selectize({
	$('#kdbarang_ed').selectize({
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
                  /*  '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.nodok) + '</div>' +*/
                    '<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nmbarang) + '</div>' +
                  '</div>' +
                 '';
            }
        },
        load: function(query, callback) {
            query = JSON.parse(query);
            page = query.page || 1;
        
            if( ! totalCount || totalCount > ( (page - 1) * perPage) ){
            $.post(base('ga/instock/add_stock_ajax_mbarang'), {
                _search_: query.search,
                _perpage_: perPage,
                _page_: page,
				_kdgroup_: $('#kdgroup_ed').val(),
				_kdsubgroup_: $('#kdsubgroup_ed').val()
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
        console.log('kdgroup_inp >> clear');
        $('[name=\'kdgroup_inp\']')[0].selectize.clearOptions();
    }); */
					 
					 
			});
</script>					
							
						
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-primary"><i class="fa fa-search"></i> PROSES </button>
      </div>
	  </form>
</div></div></div>


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
  

</script>