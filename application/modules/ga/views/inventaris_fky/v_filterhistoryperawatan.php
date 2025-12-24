<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
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
</style>
<legend><?php echo $title;?></legend>
				<div class="row">
                    <div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>HISTORY SERVIS & SPK PERAWATAN ASSET KENDARAAN</h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('ga/inventaris/history_perawatan');?>" name="form" role="form" method="post">										
										<div class="form-group">
										 <label class="col-lg-3">Periode Servis Barang</label>
											<div class="col-lg-9">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" id="tgl" name="tgl"  class="form-control pull-right" required>
												</div><!-- /.input group -->
											</div>
										</div>
										
							
							<div class="form-group ">
								<label class="col-sm-3" for="inputsm">Kode Group Asset</label>	
									<div class="col-sm-9">  
                                    <select name="kdgroup" class="form-control input-sm ch" placeholder="---KETIK KODE GROUP/ NAMA GROUP---" id="kdgroup">
                                        <option value="" class=""></option>
                                    </select>
									</div>
							</div>
							
<script type="text/javascript">
$(function() {
	 
					 
	 var totalCount, 
        page, 
        perPage = 4;				 
	 ///$('[name=\'kdgroup\']').selectize({
	 $('#kdgroup').selectize({
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
				_paramkdgroupmodul_: " and kdgroup in ('KDN') "
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
        console.log('kdgroup >> on.change');
        console.log('kdsubgroup >> clear');
		//$('[name=\'kdsubgroup\']')[0].selectize.clearOptions();
        $('#kdsubgroup')[0].selectize.clearOptions();
    });
					 
					 
			});
</script>
							<div class="form-group ">
								<label class="col-sm-3" for="inputsm">Kode Sub Group Asset</label>	
									<div class="col-sm-9">  
                                    <select name="kdsubgroup" class="form-control input-sm ch" placeholder="---KETIK KODE SUB/ NAMA SUB GROUP---" id="kdsubgroup">
                                        <option value="" class=""></option>
                                    </select>
									</div>
							</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 4;				 
	/// $('[name=\'kdsubgroup\']').selectize({
	 $('#kdsubgroup').selectize({
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
				//_kdgroup_: $('[name=\'kdgroup\']').val()
				_kdgroup_: $('#kdgroup').val()
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
        console.log('kdgroup >> clear');
        //$('[name=\'kdgroup\']')[0].selectize.clearOptions();
        $('#kdbarang')[0].selectize.clearOptions();
    });
					 
					 
			});
</script>							
							<div class="form-group ">
								<label class="col-sm-3" for="inputsm">Kode Asset</label>	
									<div class="col-sm-9">  
                                    <select name="kdbarang" class="form-control input-sm ch" placeholder="---KETIK KODE ASSET/ NAMA ASSET / NOPOL--" id="kdbarang">
                                        <option value="" class=""></option>
                                    </select>
									</div>
							</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 4;				 
	//$('[name=\'kdbarang\']').selectize({
	$('#kdbarang').selectize({
        plugins: ['hide-arrow', 'selectable-placeholder', 'infinite-scroll'],
        valueField: 'nodok',
        labelField: 'nmbarang',
        searchField: ['nodok', 'nmbarang','nopol'],
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                return '' +
                 '<div class=\'row\'>' +
                  /*  '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.nodok) + '</div>' +*/
                    '<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nmbarang) + '</div>' +
					'<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nopol) + '</div>' +
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
				_kdgroup_: $('#kdgroup').val(),
				_kdsubgroup_: $('#kdsubgroup').val()
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
        console.log('kdgroup >> clear');
        $('[name=\'kdgroup\']')[0].selectize.clearOptions();
    }); */
					 
					 
			});
</script>		
										
										<div class="form-group">
											<label class="col-lg-3">NIK & KARYAWAN</label>	
											<div class="col-sm-9">  
												<select name="nik" class="form-control input-sm ch" placeholder="---KETIK NIK / NAMA KARYAWAN--" id="nik">
													<option value="" class=""></option>
												</select>
											</div>
										</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 4;				 
	//$('[name=\'kdbarang\']').selectize({
	$('#nik').selectize({
        plugins: ['hide-arrow', 'selectable-placeholder', 'infinite-scroll'],
        valueField: 'nik',
        labelField: 'nmlengkap',
        searchField: ['nik', 'nmlengkap'],
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                return '' +
                 '<div class=\'row\'>' +
                   '<div class=\'col-xs-2 col-md-2 text-nowrap\'>' + escape(item.nik) + '</div>' +
                    '<div class=\'col-xs-5 col-md-5 text-nowrap\'>' + escape(item.nmlengkap) + '</div>' +
                  '</div>' +
                 '';
            }
        },
        load: function(query, callback) {
            query = JSON.parse(query);
            page = query.page || 1;
        
            if( ! totalCount || totalCount > ( (page - 1) * perPage) ){
            $.post(base('ga/instock/add_karyawan'), {
                _search_: query.search,
                _perpage_: perPage,
                _page_: page
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
        console.log('kdgroup >> clear');
        $('[name=\'kdgroup\']')[0].selectize.clearOptions();
    }); */
					 
					 
			});
</script>	
										<div class="form-group"> 
											<div class="col-lg-4">
												<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
											   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
		
	

<script>

  

	
	//Date range picker
    $('#tgl').daterangepicker();

  

</script>