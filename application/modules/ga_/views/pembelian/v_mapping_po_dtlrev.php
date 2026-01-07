<script type="text/javascript">
            $(function() {
                $("#example1").dataTable({
									language: {
									aria: {
									sortAscending: ': activate to sort column ascending',
									sortDescending: ': activate to sort column descending',
									},
									emptyTable: 'Tidak ada data yang dapat ditampilkan dari tabel ini...',
									info: 'Menampilkan _START_  sampai _END_  dari _TOTAL_ baris data...',
									infoEmpty: 'Tidak ada baris data...',
									infoFiltered: '(_TOTAL_  terfilter dari _MAX_ total baris data)',
									lengthMenu: '_MENU_ baris...',
									search: 'Pencarian:',
									zeroRecords: 'Tidak ada baris data yang cocok...',
									buttons: {
									copyTitle: 'Menyalin ke clipboard',
									copySuccess: {
									_: 'Disalin %d baris ke clipboard...',
									1: 'Disalin 1 baris ke clipboard...',
									}
									},
									paginate: {
									first: '<i class=\'fa fa-angle-double-left\'></i>',
									previous: '<i class=\'fa fa-angle-left\'></i>',
									next: '<i class=\'fa fa-angle-right\'></i>',
									last: '<i class=\'fa fa-angle-double-right\'></i>',
									},
									processing: 'Memproses...',
									},
									orderCellsTop: true,
									stateSave: false, //state cache
									stateDuration: 60 * 60 * 2,
									responsive: false,
									select: false,
									pagingType: 'full_numbers',
									order: [
									[0, 'asc']
									],
									lengthMenu: [
									[5,10, 15, 20, 50, 100, 500, 1000, -1],
									[5,10, 15, 20, 50, 100, 500, 1000, 'Semua']
									],
									pageLength: 5,
									columnDefs: [{
									orderable: false,
									targets: [-1]
									}, {
									searchable: false,
									targets: [-1]
									},{
									// visible: false,
									// targets: [5]
									}]
				});	
                $("#example2").dataTable({
									language: {
									aria: {
									sortAscending: ': activate to sort column ascending',
									sortDescending: ': activate to sort column descending',
									},
									emptyTable: 'Tidak ada data yang dapat ditampilkan dari tabel ini...',
									info: 'Menampilkan _START_  sampai _END_  dari _TOTAL_ baris data...',
									infoEmpty: 'Tidak ada baris data...',
									infoFiltered: '(_TOTAL_  terfilter dari _MAX_ total baris data)',
									lengthMenu: '_MENU_ baris...',
									search: 'Pencarian:',
									zeroRecords: 'Tidak ada baris data yang cocok...',
									buttons: {
									copyTitle: 'Menyalin ke clipboard',
									copySuccess: {
									_: 'Disalin %d baris ke clipboard...',
									1: 'Disalin 1 baris ke clipboard...',
									}
									},
									paginate: {
									first: '<i class=\'fa fa-angle-double-left\'></i>',
									previous: '<i class=\'fa fa-angle-left\'></i>',
									next: '<i class=\'fa fa-angle-right\'></i>',
									last: '<i class=\'fa fa-angle-double-right\'></i>',
									},
									processing: 'Memproses...',
									},
									orderCellsTop: true,
									stateSave: false, //state cache
									stateDuration: 60 * 60 * 2,
									responsive: false,
									select: false,
									pagingType: 'full_numbers',
									order: [
									[0, 'asc']
									],
									lengthMenu: [
									[5,10, 15, 20, 50, 100, 500, 1000, -1],
									[5,10, 15, 20, 50, 100, 500, 1000, 'Semua']
									],
									pageLength: 5,
									columnDefs: [{
									orderable: false,
									targets: [-1]
									}, {
									searchable: false,
									targets: [-1]
									},{
									// visible: false,
									// targets: [5]
									}]
				});	
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
			//	$("#kdsubgroup").chained("#kdgroup");
			//	$("#kdbarang").chained("#kdsubgroup");
			//	
			//	$("#mpkdsubgroup").chained("#mpkdgroup");
			//	$("#mpkdbarang").chained("#mpkdsubgroup");
			////	$("#onhand").chained("#kdbarang");
			//alert ($('#kdsubgroup').val() != '');

			
			
			
				$('.ch').change(function(){
						console.log($('#loccode').val() != '');
										
							var param1=$('#mpkdgroup').val().trim();
							var param2=$('#mpkdsubgroup').val().trim();
							var param3=$('#mpkdbarang').val().trim();
							var param4=$('#mploccode').val().trim();
							console.log(param1+param2+param3+param4);
						if 	((param1 != '') && (param2 != '') && (param3 != '') && (param4 != '')) {		
							  $.ajax({
								url : "<?php echo site_url('ga/pembelian/js_viewstock_back')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3 +'/'+ param4,
								type: "GET",
								dataType: "JSON",
								success: function(data)
								{		
									console.log(data.conhand);
									console.log(data.satkecil);
									console.log(data.nmsatkecil);
									console.log("<?php echo site_url('ga/pembelian/js_viewstock_back')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3 +'/'+ param4)
									$('[name="onhand"]').val(data.conhand);                        
									$('[name="satkecil"]').val(data.satkecil);                        
									//$('#mpsatkecil').val(data.satkecil);                             
									$('[name="mpnmsatkecil"]').val(data.nmsatkecil);                        
									//$('[name="loccode"]').val(data.loccode);                                                          
						
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							}); 
						};				
					});
					
					$('#satminta').change(function(){
						console.log($('#satminta').val().trim());
						console.log($('#mpsatkecil').val().trim());
							var param1=$('#mpkdgroup').val().trim();
							var param2=$('#mpkdsubgroup').val().trim();
							var param3=$('#mpkdbarang').val().trim();
							var param4=$('#mpsatkecil').val().trim();
							var param5=$('#satminta').val().trim();
							var qtMintatmp=parseInt($('#qtyminta').val().trim());
							if ($('#qtyminta').val()=='undefined'){ var qtMinta=0; } else { var qtMinta=parseInt($('#qtyminta').val().trim());  }
								
								console.log(qtMinta);
					$.ajax({
						url : "<?php echo site_url('ga/pembelian/js_mapping_satuan')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3 +'/'+ param4+'/'+ param5,
								type: "GET",
								dataType: "JSON",
								success: function(data)
								{		
									console.log(param1+param2+param3+param4+param5);
									console.log("<?php echo site_url('ga/pembelian/js_mapping_satuan')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3 +'/'+ param4+'/'+ param5)
									//var dataqtybesar=$(this).val(data.qty);
									console.log(data.qty);
									var qtymap=(data.qty);
									var hasil=(qtMinta*qtymap);
									
									//console.log(qtymap);
									console.log(param3);
									//alert(qtymap);
									if ((qtymap=='undefined' || qtymap=='' || qtymap==null) && (param3!=null || param3!='') ) { 
										if (window.confirm('Peringatan Kode Satuan Permintaan Tersebut Masih Belum Termapping, Click OK Untuk Melakukan Mapping Pada Tab Baru Browser Anda')) {
												///window.location.href='https://www.google.com/chrome/browser/index.html';
												window.open("<?php echo site_url('ga/inventaris/master_mapping_satuan_brg')?>", '_blank');
											};
										console.log(qtymap=='undefined' || qtymap=='' || qtymap==null);
										$('#submit').prop('disabled', true);
									} else {
										$('#submit').prop('disabled', false);
									}
									$('[name="qtykecil"]').val(hasil);
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							});
					});
		
				$('#mpkdbarang').change(function(){
						console.log($('#satminta').val().trim());
						console.log($('#mpsatkecil').val().trim());
							var param1=$('#mpkdgroup').val().trim();
							var param2=$('#mpkdsubgroup').val().trim();
							var param3=$('#mpkdbarang').val().trim();
							$.ajax({
							url : "<?php echo site_url('ga/pembelian/js_mbarang')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3,
									type: "GET",
									dataType: "JSON",
									success: function(data)
									{		
										//$('[name="satkecilmaster"]')=(data.satkecil);
										console.log("<?php echo site_url('ga/pembelian/js_mbarang')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3)
										console.log(data.satkecil.trim());
										var param4=(data.satkecil.trim());
								
										
										var param5=$('#satminta').val().trim();
										var qtMintatmp=parseInt($('#qtyminta').val().trim());
										if ($('#qtyminta').val()=='undefined'){ var qtMinta=0; } else { var qtMinta=parseInt($('#qtyminta').val().trim());  }
										
											console.log(qtMinta);
											console.log(param3!='');
											if (param3!='') {
													$.ajax({
													url : "<?php echo site_url('ga/pembelian/js_mapping_satuan')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3 +'/'+ param4+'/'+ param5,
															type: "GET",
															dataType: "JSON",
															success: function(data)
															{		
																console.log(param1+param2+param3+param4+param5);
																console.log("<?php echo site_url('ga/pembelian/js_mapping_satuan')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3 +'/'+ param4+'/'+ param5)
																//var dataqtybesar=$(this).val(data.qty);
																console.log(data.qty);
																var qtymap=(data.qty);
																var hasil=(qtMinta*qtymap);
																
																//console.log(qtymap);
																console.log(param3);
																//alert(qtymap);
																if ((qtymap=='undefined' || qtymap=='' || qtymap==null) && (param3!=null || param3!='') ) { 
																	if (window.confirm('Peringatan Kode Satuan Permintaan Tersebut Masih Belum Termapping, Click OK Untuk Melakukan Mapping Pada Tab Baru Browser Anda Atau Ubah Kode Satuan Permintaan Dengan Satuan Yang Sesuai')) {
																			///window.location.href='https://www.google.com/chrome/browser/index.html';
																			window.open("<?php echo site_url('ga/inventaris/master_mapping_satuan_brg')?>", '_blank');
																		};
																	console.log(qtymap=='undefined' || qtymap=='' || qtymap==null);
																	$('#submit').prop('disabled', true);
																} else {
																	$('#submit').prop('disabled', false);
																}
																$('[name="qtykecil"]').val(hasil);
															},
															error: function (jqXHR, textStatus, errorThrown)
															{
																alert('Error get data from ajax');
															}
														});
											}	


								},
									error: function (jqXHR, textStatus, errorThrown)
									{
										alert('Error get data from ajax');
									}
								});
							
					
										
					});

					 $('#submit').click(function(){
					//$('[name="inputformPbk"]').on('submit', function (e) {
						console.log($('#satminta').val().trim());
						console.log($('#mpnmsatkecil').val().trim());
						console.log($('#mpnmsatkecil').val().trim());
							var param1=$('#mpkdgroup').val().trim();
							var param2=$('#mpkdsubgroup').val().trim();
							var param3=$('#mpkdbarang').val().trim();
							$.ajax({
							url : "<?php echo site_url('ga/pembelian/js_mbarang')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3,
									type: "GET",
									dataType: "JSON",
									success: function(data)
									{		
										//$('[name="satkecilmaster"]')=(data.satkecil);
										console.log("<?php echo site_url('ga/pembelian/js_mbarang')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3)
										console.log(data.nmsatkecil);
										var param4=(data.satkecil.trim());
								
										$('[name="mpnmsatkecil"]').val(data.nmsatkecil);   
										var param5=$('#satminta').val().trim();
										var qtMintatmp=parseInt($('#qtyminta').val().trim());
										if ($('#qtyminta').val()=='undefined'){ var qtMinta=0; } else { var qtMinta=parseInt($('#qtyminta').val().trim());  }
										
											console.log(qtMinta);
											console.log(param3!='');
											if (param3!='') {
													$.ajax({
													url : "<?php echo site_url('ga/pembelian/js_mapping_satuan')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3 +'/'+ param4+'/'+ param5,
															type: "GET",
															dataType: "JSON",
															success: function(data)
															{		
																console.log(param1+param2+param3+param4+param5);
																console.log("<?php echo site_url('ga/pembelian/js_mapping_satuan')?>" +'/'+ param1 +'/'+ param2 +'/'+ param3 +'/'+ param4+'/'+ param5)
																//var dataqtybesar=$(this).val(data.qty);
																console.log(data.qty);
																var qtymap=(data.qty);
																var hasil=(qtMinta*qtymap);
																
																//console.log(qtymap);
																console.log(param3);
																//alert(qtymap);
																if ((qtymap=='undefined' || qtymap=='' || qtymap==null) && (param3!=null || param3!='') ) { 
																	if (window.confirm('Peringatan Kode Satuan Permintaan Tersebut Masih Belum Termapping, Click OK Untuk Melakukan Mapping Pada Tab Baru Browser Anda Atau Ubah Kode Satuan Permintaan Dengan Satuan Yang Sesuai')) {
																			///window.location.href='https://www.google.com/chrome/browser/index.html';
																			window.open("<?php echo site_url('ga/inventaris/master_mapping_satuan_brg')?>", '_blank');
																															
																		} else {return false; }
																	console.log(qtymap=='undefined' || qtymap=='' || qtymap==null);
																	$('#submit').prop('disabled', true);
																} else {
																	$('#submit').prop('disabled', false);
																	 $('[name="inputformPbk"]').submit();
																}
																$('[name="qtykecil"]').val(hasil);
															},
															error: function (jqXHR, textStatus, errorThrown)
															{
																alert('Error get data from ajax');
															}
														});
											}	


								},
									error: function (jqXHR, textStatus, errorThrown)
									{
										alert('Error get data from ajax');
									}
								});					
					});
		
		
		/*			//////////////////////////////////////////////
					$('#qtyunitprice').change(function(){
						if ($(this).val()=='') {	var param1 = parseInt(0); } else { var param1 = parseInt($(this).val()); }
						if ($('#qtypo').val()=='') {	var param2 = parseInt(0); } else { var param2 = parseInt($('#qtypo').val()); }
						
						$('#qtytotalprice').val(param1 * param2);   
					});
					//////////////////////////////////////////////
					$('#qtypo').change(function(){
						if ($(this).val()=='') {	var param2 = parseInt(0); } else { var param2 = parseInt($(this).val()); }
						if ($('#qtyunitprice').val()=='') {	var param1 = parseInt(0); } else { var param1 = parseInt($('#qtyunitprice').val()); }
						
						$('#qtytotalprice').val(param1 * param2);      
					}); 
			*/		
				$('form').on('focus', 'input[type=number]', function (e) {
					  $(this).on('mousewheel.disableScroll', function (e) {
						e.preventDefault()
					  })
				})			
			});
</script>
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
<span id="postmessages"></span>

<div class="box">
	<div class="box-content">
	  <div class="box-header">
		<h4 class="box-title" id="myModalLabel">MAPPING PEMBELIAN BARANG</h4>
	  </div>
<form action="<?php echo site_url('ga/pembelian/save_po')?>" method="post" name="inputformPbk">
<div class="box-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($po_dtlref['nik']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									<input type="hidden" id="type" name="type"  value="MAPREVITEM" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="nodok" name="nodok"  value="<?php echo trim($po_dtlref['nodok']);?>" class="form-control" style="text-transform:uppercase">
									<input type="hidden" id="id" name="id"  value="<?php echo trim($po_dtlref['rowid']);?>" class="form-control" style="text-transform:uppercase">
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
								<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($po_dtlref['nmlengkap']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($po_dtlref['nmdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="department"  value="<?php echo trim($po_dtlref['bag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($po_dtlref['nmsubdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="subdepartment"  value="<?php echo trim($po_dtlref['subbag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo trim($po_dtlref['nmjabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="jabatan"  value="<?php echo trim($po_dtlref['jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan1</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($po_dtlref['nmatasan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan"  value="<?php echo trim($po_dtlref['nik_atasan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo trim($po_dtlref['nmatasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan2"  value="<?php echo trim($po_dtlref['nik_atasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	

			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group">
								<label class="col-sm-4">NO DOKUMEN REFERENSI</label>	
								<div class="col-sm-8">  
									<input type="text" id="nodokref" name="nodokref"  value="<?php echo trim($po_dtlref['nodokref']);?>" class="form-control" style="text-transform:uppercase" readonly>																	
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Barang Dari User</label>	
								<div class="col-sm-8">    
									<input type="text" id="desc_barang" name="desc_barang"   value="<?php echo trim($po_dtlref['desc_barang']);?>" style="text-transform:uppercase" class="form-control" readonly >
								</div>
							</div>
<?php /*
							<div class="form-group drst">
								<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm ch" name="kdgroup" id="mpkdgroup">
									 <option value="">---PILIH KODE GROUP--</option> 
									  <?php foreach($list_scgroup as $sc){?>					  
									  <option   <?php if (trim($sc->kdgroup)==trim($po_dtlref['kdgroup'])) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
									  <?php }?>
									</select>
									</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm ch" name="kdsubgroup" id="mpkdsubgroup">
									 <option  value="">---PILIH KODE SUB GROUP--</option> 
									  <?php foreach($list_scsubgroup as $sc){?>					  
									  <option  <?php if (trim($sc->kdsubgroup)==trim($po_dtlref['kdsubgroup'])) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm ch" name="kdbarang" id="mpkdbarang">
									 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
									  <?php foreach($list_stkgdw as $sc){?>					  
									  <option  <?php if (trim($sc->stockcode)==trim($po_dtlref['stockcode'])) { echo 'selected';}?>  value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
*/ ?>
							<div class="form-group drst">
								<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
									<div class="col-sm-8">  
                                    <select name="kdgroup" class="form-control input-sm ch" placeholder="---KETIK KODE / NAMA GROUP---" id="mpkdgroup">
                                        <option value="" class=""></option>
                                    </select>
									</div>
							</div>
							
<script type="text/javascript">
$(function() {
	 
					 
	 var totalCount, 
        page, 
        perPage = 7;				 
	 ///$('[name=\'mpkdgroup\']').selectize({
	 $('#mpkdgroup').selectize({
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
				_paramkdgroupmodul_: " and kdgroup='BRG' "
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
        console.log('mpkdgroup >> on.change');
        console.log('mpkdsubgroup >> clear');
		//$('[name=\'mpkdsubgroup\']')[0].selectize.clearOptions();
        $('#mpkdsubgroup')[0].selectize.clearOptions();
    });
					 
					 
			});
</script>
							<div class="form-group drst">
								<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
									<div class="col-sm-8">  
                                    <select name="kdsubgroup" class="form-control input-sm ch" placeholder="---KETIK / NAMA SUB GROUP---" id="mpkdsubgroup">
                                        <option value="" class=""></option>
                                    </select>
									</div>
							</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 7;				 
	/// $('[name=\'mpkdsubgroup\']').selectize({
	 $('#mpkdsubgroup').selectize({
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
				//_kdgroup_: $('[name=\'mpkdgroup\']').val()
				_kdgroup_: $('#mpkdgroup').val()
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
        console.log('mpkdgroup >> clear');
        //$('[name=\'mpkdgroup\']')[0].selectize.clearOptions();
        $('#mpkdbarang')[0].selectize.clearOptions();
    });
					 
					 
			});
</script>							
							<div class="form-group drst">
								<label class="col-sm-4" for="inputsm">Kode Barang</label>	
									<div class="col-sm-8">  
                                    <select name="kdbarang" class="form-control input-sm ch" placeholder="---KETIK / NAMA BARANG--" id="mpkdbarang">
                                        <option value="" class=""></option>
                                    </select>
									</div>
							</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 7;				 
	//$('[name=\'mpkdbarang\']').selectize({
	$('#mpkdbarang').selectize({
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
				_kdgroup_: $('#mpkdgroup').val(),
				_kdsubgroup_: $('#mpkdsubgroup').val()
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
    }); */
					 
					 
			});
</script>													
								
							
							<?php if (empty(trim($po_dtlref['stockcode']))) { ?>
							<div class="form-group">
								<label class="col-sm-4">INPUT MASTER BARANG</label>	
								<div class="col-sm-8">  
									<!--a href="<?php echo site_url('ga/pembelian/input_po');?>" type="button" class="btn btn-info"/> Master Barang</a--->
									<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php echo site_url('ga/inventaris/form_mstbarang');?>');">INPUT BARANG TIDAK TERDAFTAR</button>
								</div>
							</div>
							<?php } ?>
							<div class="form-group ">
								<label class="col-sm-4">LOKASI GUDANG</label>	
								<div class="col-sm-8">    
									<input type="text" id="mploccode" name="loccode"   value="<?php echo trim($po_dtlref['loccode']);?>" class="form-control "  readonly >
									
								</div>
							</div>
							<div class="form-group drst">
								<label class="col-sm-4">Quantity Permintaan</label>	
								<div class="col-sm-8">    
									<input type="number" id="qtyminta" name="qtyminta"  value="<?php echo trim($po_dtlref['qtyminta']);?>"   placeholder="0" class="form-control drst" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4" for="inputsm">Kode Satuan Permintaan</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm" name="satminta" id="satminta">
									  <option  <?php if (trim($po_dtlref['satminta'])=='' or trim($po_dtlref['satminta'])== null) { echo 'selected';}?>  value="">---PILIH KDSATUAN || NAMA SATUAN--</option> 
									  <?php foreach($trxqtyunit as $sc){?>					  
									  <option <?php if (trim($sc->kdtrx)==trim($po_dtlref['satminta'])) { echo 'selected';}?>  value="<?php echo trim($sc->kdtrx);?>"><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>

							<div class="form-group drst">
								<label class="col-sm-4">Quantity Konversi</label>	
								<div class="col-sm-5">    
									<input type="number" id="qtykecil" name="qtykecil"  value="<?php echo trim($po_dtlref['qtykecil']);?>"   placeholder="0" class="form-control drst" readonly >
								</div>
								<div class="col-sm-3">    
									<input type="text" name="mpnmsatkecil" id="mpnmsatkecil" class="form-control" readonly >
									<input type="hidden" id="mpsatkecil" name="satkecil"  value="<?php echo trim($po_dtlref['satkecil']);?>"  class="form-control drst" readonly >
									<input type="hidden" id="satkecilmaster" name="satkecilmaster"  class="form-control drst" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control" disabled readonly><?php echo trim($po_dtlref['keterangan']);?></textarea>
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>
 </form>	
      <div class="box-footer">
        <a href="<?php echo site_url('ga/pembelian/input_po');?>" type="button" class="btn btn-default"/> Kembali</a>
		<!--button type="button" class="btn btn-default" data-dismiss="box">Close</button--->
        <button id="submit"  class="btn btn-primary pull-right">SIMPAN</button>
      </div>
	 
</div></div>



