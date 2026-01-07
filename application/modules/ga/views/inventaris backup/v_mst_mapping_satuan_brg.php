<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<style>
  /*-- change navbar dropdown color --*/
  .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu {
  	background-color: #008040;
    color:#ffffff;
  }

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
</style>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
			////	$("#satkecil").selectize();
				
				$("#kdsubgroup").chained("#kdgroup");
				$("#kdbarang").chained("#kdsubgroup");
				$("#edkdsubgroup").chained("#edkdgroup");
				
			//	$("#tglrange").daterangepicker(); 
			
			
						$('.ch').change(function(){
							var param1=$('#kdgroup_inp').val().trim();
							var param2=$('#kdsubgroup_inp').val().trim();
							var param3=$('#kdbarang_inp').val().trim();
							console.log(param1+param2+param3);
							  $.ajax({
								url : "<?php echo site_url('ga/inventaris/js_master_stock')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3,
								type: "GET",
								dataType: "JSON",
								success: function(data)
								{		
									
									console.log(data.satkecil);
									console.log(data.nmsatkecil);
									console.log("<?php echo site_url('ga/inventaris/js_master_stock')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3)
									//$('[name="onhand"]').val(data.conhand);                        
									$('[name="satkecil"]').val(data.satkecil);                                                                              
									$('[name="nmsatkecil"]').val(data.nmsatkecil);                                                                              
									$('[name="qtykecil"]').val(data.qtykecilmap);                                                                              
								
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							}); 
					});
					
					$('.ch2').change(function(){
							var param1=$('#kdgroup_ed').val().trim();
							var param2=$('#kdsubgroup_ed').val().trim();
							var param3=$('#kdbarang_ed').val().trim();
							console.log(param1+param2+param3);
							  $.ajax({
								url : "<?php echo site_url('ga/inventaris/js_master_stock')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3,
								type: "GET",
								dataType: "JSON",
								success: function(data)
								{		
									
									console.log(data.satkecil);
									console.log(data.nmsatkecil);
									console.log("<?php echo site_url('ga/inventaris/js_master_stock')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3)
									//$('[name="onhand"]').val(data.conhand);                        
									$('[name="satkecil"]').val(data.satkecil);                                                                              
									$('[name="nmsatkecil"]').val(data.nmsatkecil);                                                                              
									$('[name="qtykecil"]').val(data.qtykecilmap);                                                                              
								
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							}); 
					});
            });
					
			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
<?php echo $message; ?>	
	
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
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Mapping Satuan</a></li> 
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
			 <legend><?php echo $title;?></legend>							
			</div><!-- /.box-header -->	
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
								<tr>											
									<th width="2%">No.</th>
									<th>ID BARANG</th>
									<th>NAMA BARANG</th>
									<th>QTY KECIL</th>
									<th>SATUAN KECIL</th>
									<th>QTY KONVERSI</th>
									<th>SATUAN BESAR</th>
									<th>Aksi</th>		
								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_mapping as $row): $no++;?>
						<tr>
							
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo $row->stockcode;?></td>
							<td><?php echo $row->nmbarang;?></td>
							<td><?php echo $row->qtykecil;?></td>
							<td><?php echo $row->nmsatbesar;?></td>
							<td><?php echo $row->qty;?></td>
							<td><?php echo $row->nmsatkecil;?></td>
							<td width="15%">
									<a href="<?php echo site_url('ga/inventaris/detail_view_mapping_satuan_brg').'/'.bin2hex($this->encrypt->encode(trim($row->id)));?>" class="btn btn-default  btn-sm" title="DETAIL MAPPING BARANG"><i class="fa fa-bars"></i> </a>
								<?php if (trim($row->referensinya)==0 and (trim($row->qtykecil)!=trim($row->qty))) { ?>
									<a href="<?php echo site_url('ga/inventaris/edit_view_mapping_satuan_brg').'/'.bin2hex($this->encrypt->encode(trim($row->id)));?>" class="btn btn-primary  btn-sm" title="UBAH MAPPING BARANG"><i class="fa fa-gear"></i> </a>
									<a href="<?php echo site_url('ga/inventaris/hapus_view_mapping_satuan_brg').'/'.bin2hex($this->encrypt->encode(trim($row->id)));?>" class="btn btn-danger  btn-sm" title="HAPUS MAPPING BARANG"><i class="fa fa-trash-o"></i> </a>
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

<!-- Modal Input Master Mapping ATK -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Input Mapping Satuan</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/inventaris/input_mapping_satuan_brg');?>" method="post">
		<div class='row'>
			<div class='col-sm-6'>	
			 	<input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
							<div class="form-group">
									<label for="inputsm">Kode Group Barang</label>	
									 
                                    <select name="kdgroup" class="form-control input-sm ch" placeholder="---KETIK KODE / NAMA GROUP---" id="kdgroup_inp">
                                        <option value="" class=""></option>
                                    </select>
									
							</div>
							
<script type="text/javascript">
$(function() {
	 
					 
	 var totalCount, 
        page, 
        perPage = 7;				 
	 ///$('[name=\'kdgroup_inp\']').selectize({
	 $('#kdgroup_inp').selectize({
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
        console.log('kdgroup_inp >> on.change');
        console.log('kdsubgroup_inp >> clear');
		//$('[name=\'kdsubgroup_inp\']')[0].selectize.clearOptions();
        $('#kdsubgroup_inp')[0].selectize.clearOptions();
    });
					 
					 
			});
</script>
							<div class="form-group">
								<label for="inputsm">Kode Sub Group Barang</label>	
									 
                                    <select name="kdsubgroup" class="form-control input-sm ch" placeholder="---KETIK / NAMA SUB GROUP---" id="kdsubgroup_inp">
                                        <option value="" class=""></option>
                                    </select>
									
							</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 7;				 
	/// $('[name=\'kdsubgroup_inp\']').selectize({
	 $('#kdsubgroup_inp').selectize({
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
				_kdgroup_: $('#kdgroup_inp').val(),
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
        console.log('kdgroup_inp >> clear');
        //$('[name=\'kdgroup_inp\']')[0].selectize.clearOptions();
        $('#kdbarang_inp')[0].selectize.clearOptions();
    });
					 
					 
			});
</script>							
							<div class="form-group">
								<label for="inputsm">Kode Barang</label>	
									
                                    <select name="kdbarang" class="form-control input-sm ch" placeholder="---KETIK / NAMA BARANG--" id="kdbarang_inp">
                                        <option value="" class=""></option>
                                    </select>
									
							</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 7;				 
	//$('[name=\'kdbarang_inp\']').selectize({
	$('#kdbarang_inp').selectize({
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
				_kdgroup_: $('#kdgroup_inp').val(),
				_kdsubgroup_: $('#kdsubgroup_inp').val()
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


<?php /*
			<div class="form-group">
				<label for="inputsm">Kode Group Barang</label>	
					<select class="form-control input-sm ch" name="kdgroup" id="kdgroup" required>
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group">
				<label for="inputsm">Kode Sub Group Barang</label>	
					<select class="form-control input-sm ch" name="kdsubgroup" id="kdsubgroup">
					 <option value="">---PILIH KODE GROUP--</option> 
					  <?php foreach($list_scsubgroup as $sc){?>					  
					  <option value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
					  <?php }?>
					</select>
			</div>
			<div class="form-group ">
				<label for="inputsm">Kode Stock Barang</label>		
			
					<select class="form-control input-sm ch" name="kdbarang" id="kdbarang">
					 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
					  <?php foreach($list_mstbarang as $sc){?>					  
					  <option  value="<?php echo trim($sc->nodok);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->nodok).' || '.trim($sc->nmbarang);?></option>						  
					  <?php }?>
					</select>
				
			</div>
*/ ?>
			
			</div> <!---- col 1 -->
			<div class='col-sm-6'>
			<div class="form-group">
			<div class="row">
				<label  class="col-sm-4">SATUAN DASAR BARANG</label>	
				<div class="col-sm-4">  
					<input type="text" class="form-control input-sm" id="qtykecil" name="qtykecil" readonly>
				</div>
				<div class="col-sm-4"> 
					<input type="text" class="form-control input-sm" id="nmsatkecil" name="nmsatkecil" readonly>
				</div>
				<input type="hidden" class="form-control input-sm" id="satkecil" name="satkecil" readonly>
			</div>	
			</div>
			<div class="form-group">
				<label for="inputsm">QTY SATUAN DASAR DARI SATUAN BESAR</label>	
				<input type="number" class="form-control input-sm" id="qty" name="qty" required>
			</div>
			<div class="form-group">
				<label for="inputsm">SATUAN BESAR</label>	
					<select class="form-control input-sm " name="satbesar" id="satbesar" required>
					 <option value="">---PILIH SATUAN PERMINTAAN MAPPING BARANG--</option> 
					  <?php foreach($list_satuan as $sc){?>					  
					  <option value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
					  <?php }?>
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
		<h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN MAPPING BARANG </h4>
	  </div>
<form action="<?php echo site_url('ga/inventaris/master_mapping_satuan_brg')?>" method="post" name="inputformPbk">
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