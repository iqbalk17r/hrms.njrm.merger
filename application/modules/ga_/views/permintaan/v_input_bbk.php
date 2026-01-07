<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
				//$("#kdsubgroup").chained("#kdgroup");
				//$("#kdbarang").chained("#kdsubgroup");
			////	$("#onhand").chained("#kdbarang");
			//alert ($('#kdsubgroup').val() != '');
					$('.ch').change(function(){
						console.log($('#kdbarang').val() != '');
						if 	($('#kdbarang').val() != '') {						
							var param1=$(this).val();
							  $.ajax({
								url : "<?php echo site_url('ga/permintaan/js_viewstock')?>/" + param1,
								type: "GET",
								dataType: "JSON",
								success: function(data)
								{			   
									$('[name="onhand"]').val(data.conhand);                        
									$('[name="loccode"]').val(data.loccode);                                                          
									$('[name="satkecil"]').val(data.satkecil);                                                          
									$('[name="satminta"]').val(data.satkecil);                                                          
									$('[name="nmsatkecil"]').val(data.nmsatkecil);                                                          
									$('[name="nmsatminta"]').val(data.nmsatkecil);                                                          
									$('[name="desc_barang"]').val(data.nmbarang);                                                          
						
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							}); 
						};				
					});
				$('.drst').hide();
				$('#daristock').on('click', function() {
					if ($(this).val()=='YES') {
						console.log($(this).val());
						$('.drst').prop('required',true);
						$('.drst').show();
					} else if ($(this).val()=='NO') {
						console.log($(this).val());
						$('.drst').prop('required',false);
						$('.drst').hide();
					}
				});
				$('#daristockED').on('click', function() {
					if ($(this).val()=='YES') {
						console.log($(this).val());
						$('.drst').prop('required',true);
						$('.drst').show();
					} else if ($(this).val()=='NO') {
						console.log($(this).val());
						$('.drst').prop('required',false);
						$('.drst').hide();
					}
				});
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
<h5><b><strong><?php echo '  INPUT BBK & PENGAJUAN BBK';?></strong></b></h5>
<?php echo $message;?>

<div class="row">
		<div class="col-sm-12">		
			<a href="<?php echo site_url("ga/permintaan/clear_tmp_bbk/$enc_nodok")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
		</div>
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header"  align="center">
					<h5><b><strong><?php echo 'MASTER BBK';?></strong></b></h5>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>NODOK</th>
											<th>REF DOKUMEN PBK</th>
											<th>NIK</th>
											<th>NAMA LENGKAP</th>
											<th>LOCCODE</th>
											<th>STATUS</th>
											<th>KETERANGAN</th>
											<th>ACTION</th>
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_bbk_tmp_mst as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodok;?></td>
									<td><?php echo $row->nodokref;?></td>
									<td><?php echo $row->nik;?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->loccode;?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td>
									<a href="#" data-toggle="modal" data-target="#INPUTTRX<?php echo str_replace('.','',trim($row->nodok)).trim($row->nodokref);?>" class="btn btn-primary  btn-sm"><i class="fa fa-edit"></i> SIMPAN BBK </a>
									</td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>		
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div><!-- END ROW 1 --->
<?php if (trim($bbk_mst['nodoktype'])=='AJS') { ?>	
<div class="row">
	<div class="col-sm-3">	
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#inputDetailBRG"  href="#">Input Detail</a></li> 
				</ul>
			</div>
	</div><!-- /.box-header -->
</div>	
<?php } ?>			
			<div class="col-xs-12"> 
				<div class="box">
					<div class="box-header"  align="center">
					<h5><b><strong><?php echo 'DETAIL BBK';?></strong></b></h5>
					<a href="<?php echo site_url("ga/permintaan/cancel_tmp_bbk_dtl/$enc_nodok")?>"  class="btn btn-danger pull-right" onclick="return confirm('Reset info Qty BBK Data Ini??')" style="margin:0px; color:#ffffff;">CANCEL</a>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example2" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>STOCK CODE</th>
											<th>NAMA BARANG</th>
											<th>DESC BARANG</th>
											<!--th>QTY ONHAND</th-->
											<th>ONHAND TMP</th>
											<th>QTY PBK</th>
											<th>QTY BBK</th>
											<th>STATUS</th>
											<th>KETERANGAN</th>
											<th>AKSI</th>		
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_bbk_tmp_dtl as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->stockcode;?></td>
									<td><?php echo $row->nmbarang;?></td>
									<td><?php echo $row->desc_barang;?></td>
									<!--td><?php echo $row->qtyonhand;?></td-->
									<td><?php echo $row->onhand_tmp;?></td>
									<td><?php echo $row->qtypbk;?></td>
									<td><?php echo $row->qtybbk1;?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td width="15%">
															
											<!--a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a-->
											<?php if (trim($row->qtybbk1)>0) { ?>
												<a href="#" data-toggle="modal" data-target="#ED<?php echo str_replace('.','',trim($row->nodok)).trim($row->kdgroup).trim($row->kdsubgroup).trim($row->stockcode);?>" class="btn btn-primary  btn-sm"><i class="fa fa-edit"></i> UBAH QTY BBK </a>	
											<?php } else { ?>
												<a href="#" data-toggle="modal" data-target="#ED<?php echo str_replace('.','',trim($row->nodok)).trim($row->kdgroup).trim($row->kdsubgroup).trim($row->stockcode);?>" class="btn btn-success  btn-sm"><i class="fa fa-pencil"></i> INPUT QTY BBK </a>
											<?php } ?>
											<!--a href="#" data-toggle="modal" data-target="#DEL<?php echo str_replace('.','',trim($row->nodok)).trim($row->kdgroup).trim($row->kdsubgroup).trim($row->stockcode);?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> HAPUS </a-->
											
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
	
<?php foreach ($list_bbk_tmp_mst as $lb) { ?>
<div class="modal fade" id="INPUTTRX<?php echo str_replace('.','',trim($lb->nodok)).trim($row->nodokref);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">SIMPAN INPUT BBK</h4>
	  </div>
<form action="<?php echo site_url('ga/permintaan/save_bbk')?>" method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									<input type="hidden" id="type" name="type"  value="MOVETRX" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="nodok" name="nodok"  value="<?php echo trim($lb->nodok);?>" class="form-control" style="text-transform:uppercase">								
									
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($lb->lvl_jabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($lb->nmdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="department"  value="<?php echo trim($lb->bag_dept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($lb->nmsubdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="subdepartment"  value="<?php echo trim($lb->subbag_dept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo trim($lb->nmjabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="jabatan"  value="<?php echo trim($lb->jabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan1</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($lb->nmatasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan"  value="<?php echo trim($lb->nik_atasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo trim($lb->nmatasan2); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan2"  value="<?php echo trim($lb->nik_atasan2); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
							<div class="form-group ">
								<label class="col-sm-4">DOKUMEN PBK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nodokref" name="nodokref"  value="<?php echo trim($lb->nodokref);?>" class="form-control" style="text-transform:uppercase" readonly>								
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL PENGAJUAN</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="inputdate" name="inputdate"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($lb->nodokdate)));?> readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo trim($lb->keterangan);?></textarea>
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <!--a href="<?php echo site_url('ga/permintaan/list_personalnikpbk');?>" type="button" class="btn btn-default"/> Kembali</a-->
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
</div></div></div>
<?php } ?>

<!-----------------XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX--------------->

<div class="modal fade" id="inputDetailBRG" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM INPUT DETAIL BUKTI BARANG KELUAR</h4>
	  </div>
			<form action="<?php echo site_url('ga/permintaan/save_bbk')?>" method="post">
			<div class="modal-body">										
			<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($bbk_mst['nik']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									<input type="hidden" id="type" name="type"  value="INPUTTMPDTLBBK_NO_REFERENSI" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="nodok" name="nodok"  value="<?php echo trim($bbk_mst['nodok']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="nodokref" name="nodokref"  value="<?php echo trim($bbk_mst['nodokref']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="nodoktype" name="nodoktype"  value="<?php echo trim($bbk_mst['nodoktype']);?>" class="form-control" style="text-transform:uppercase">								
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($bbk_mst['nmlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($bbk_mst['nmlengkap']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($bbk_mst['lvl_jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($bbk_mst['nmdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="department"  value="<?php echo trim($bbk_mst['bag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($bbk_mst['nmsubdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="subdepartment"  value="<?php echo trim($bbk_mst['subbag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($bbk_mst['nmjabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="jabatan"  value="<?php echo  trim($bbk_mst['jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan1</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($bbk_mst['nmatasan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan"  value="<?php echo  trim($bbk_mst['nik_atasan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($bbk_mst['nmatasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan2"  value="<?php echo  trim($bbk_mst['nik_atasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
							<?php /*
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm "  name="kdgroup" id="kdgroup" required>
									 <option value="">---PILIH KODE GROUP--</option> 
									  <?php foreach($list_scgroup as $sc){?>					  
									  <option  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
									  <?php }?>
									</select>
									</div>
									
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm "  name="kdsubgroup" id="kdsubgroup"  required>
									 <option  value="">---PILIH KODE SUB GROUP--</option> 
									  <?php foreach($list_scsubgroup as $sc){?>					  
									  <option  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm kdbarang " name="kdbarang" id="kdbarang"  required>
									 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
									  <?php foreach($list_stkgdw as $sc){?>					  
									  <option value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							*/ ?>
							
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
									<div class="col-sm-8">  
                                    <select name="kdgroup" class="form-control input-sm ch" placeholder="---KETIK KODE / NAMA GROUP---" id="kdgroup">
                                        <option value="" class=""></option>
                                    </select>
									</div>
							</div>
							
<script type="text/javascript">
$(function() {
	 
					 
	 var totalCount, 
        page, 
        perPage = 7;				 
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
        console.log('kdgroup >> on.change');
        console.log('kdsubgroup >> clear');
		//$('[name=\'kdsubgroup\']')[0].selectize.clearOptions();
        $('#kdsubgroup')[0].selectize.clearOptions();
    });
					 
					 
			});
</script>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
									<div class="col-sm-8">  
                                    <select name="kdsubgroup" class="form-control input-sm ch" placeholder="---KETIK / NAMA SUB GROUP---" id="kdsubgroup">
                                        <option value="" class=""></option>
                                    </select>
									</div>
							</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 7;				 
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
								<label class="col-sm-4" for="inputsm">Kode Barang</label>	
									<div class="col-sm-8">  
                                    <select name="kdbarang" class="form-control input-sm ch" placeholder="---KETIK / NAMA BARANG--" id="kdbarang">
                                        <option value="" class=""></option>
                                    </select>
									</div>
							</div>
<script type="text/javascript">
$(function() {				 
	 var totalCount, 
        page, 
        perPage = 7;				 
	//$('[name=\'kdbarang\']').selectize({
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
							
										
							
							
							<div class="form-group ">
								<label class="col-sm-4">LOKASI GUDANG</label>	
								<div class="col-sm-8">    
									<input type="text" id="loccode" name="loccode"    value="<?php echo trim($bbk_mst['loccode']); ?>" class="form-control "  readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY ONHAND</label>	
								<div class="col-sm-4">    
									<input type="number" id="onhand" name="onhand" placeholder="0" class="form-control" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil' class="form-control" readonly >								
									<input type="input" name='nmsatkecil' class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY PERMINTAAN</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtypbk" name="qtypbk" placeholder="0" class="form-control" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil' class="form-control" readonly >								
									<input type="input" name='nmsatkecil' class="form-control" readonly >
								</div>
							</div>
						<div class="form-group ">
								<label class="col-sm-4">QTY BBK</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtybbk" name="qtybbk" placeholder="0" class="form-control" required>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil' class="form-control" readonly >								
									<input type="input" name='nmsatkecil' class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Deskripsi Barang</label>	
								<div class="col-sm-8">    
									<input type="text" id="desc_barang" name="desc_barang"  style="text-transform:uppercase" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
								</div>
							</div>								
								</div>
							</div><!-- /.box-body -->													
						</div><!-- /.box --> 
					</div>
				</div>	
				</div>	
				  <div class="modal-footer">
					<!--a href="<?php echo site_url('ga/permintaan/list_personalnikpbk');?>" type="button" class="btn btn-default"/> Kembali</a-->
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
					<button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
				  </div>
			  </form>
		</div>
	</div>
</div>



	
<?php foreach ($list_bbk_tmp_dtl as $lb) { ?>
<div class="modal fade" id="ED<?php echo str_replace('.','',trim($lb->nodok)).trim($lb->kdgroup).trim($lb->kdsubgroup).trim($lb->stockcode);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM INPUT BUKTI BARANG KELUAR</h4>
	  </div>
<form action="<?php echo site_url('ga/permintaan/save_bbk')?>" method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									<input type="hidden" id="type" name="type"  value="EDITTMP" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="nodok" name="nodok"  value="<?php echo trim($lb->nodok);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="nodokref" name="nodokref"  value="<?php echo trim($lb->nodokref);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="nodoktype" name="nodoktype"  value="<?php echo trim($lb->nodoktype);?>" class="form-control" style="text-transform:uppercase">								
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($lb->lvl_jabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($lb->nmdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="department"  value="<?php echo trim($lb->bag_dept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($lb->nmsubdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="subdepartment"  value="<?php echo trim($lb->subbag_dept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo trim($lb->nmjabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="jabatan"  value="<?php echo trim($lb->jabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan1</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($lb->nmatasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan"  value="<?php echo trim($lb->nik_atasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo trim($lb->nmatasan2); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan2"  value="<?php echo trim($lb->nik_atasan2); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
							<!--div class="form-group">
								<label class="col-sm-4" for="inputsm">Pilih Dari Stock</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm" name="daristock" id="daristockED" required>
									 <option value="">---PILIH DARI STOCK--</option> 
									 <option value="YES"> YA </option> 
								
									</select>
									</div>
							</div--->
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm "  readonly disabled>
									 <option value="">---PILIH KODE GROUP--</option> 
									  <?php foreach($list_scgroup as $sc){?>					  
									  <option  <?php if (trim($sc->kdgroup)==trim($lb->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
									  <?php }?>
									</select>
									</div>
									<input type="hidden" name="kdgroup" id="kdgroup" value="<?php echo trim($lb->kdgroup);?>" class="form-control "  >
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm "   readonly disabled>
									 <option  value="">---PILIH KODE SUB GROUP--</option> 
									  <?php foreach($list_scsubgroup as $sc){?>					  
									  <option   <?php if (trim($sc->kdsubgroup)==trim($lb->kdsubgroup)) { echo 'selected';}?>   value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
									  <?php }?>
									</select>
								</div>
								<input type="hidden" name="kdsubgroup" id="kdsubgroup" value="<?php echo trim($lb->kdsubgroup);?>" class="form-control "  >
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm kdbarang " readonly disabled>
									 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
									  <?php foreach($list_stkgdw as $sc){?>					  
									  <option  <?php if (trim($sc->stockcode)==trim($lb->stockcode)) { echo 'selected';}?>  value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
									  <?php }?>
									</select>
								</div>
								<input type="hidden" name="kdbarang" id="kdbarang" value="<?php echo trim($lb->stockcode);?>" class="form-control "  >
							</div>
							<div class="form-group ">
								<label class="col-sm-4">LOKASI GUDANG</label>	
								<div class="col-sm-8">    
									<input type="text" id="loccode" name="loccode"   value="<?php echo trim($lb->loccode);?>" class="form-control "  readonly disabled >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ON HAND</label>	
								<div class="col-sm-8">    
									<input type="number" id="onhand" name="onhand"  value="<?php echo trim($lb->onhand_tmp);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Quantity Permintaan</label>	
								<div class="col-sm-8">    
									<input type="number" id="qtypbk" name="qtypbk"   placeholder="0" class="form-control"  value="<?php echo trim($lb->qtypbk);?>" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Quantity BBK</label>	
								<div class="col-sm-8">    
									<input type="number" id="qtybbk" name="qtybbk"  value="<?php echo trim($lb->qtybbk1);?>"  placeholder="0" class="form-control" required >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Deskripsi Barang</label>	
								<div class="col-sm-8">    
									<input type="text" id="desc_barang" name="desc_barang"   value="<?php echo trim($lb->desc_barang);?>" style="text-transform:uppercase" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo trim($lb->keterangan);?></textarea>
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <!--a href="<?php echo site_url('ga/permintaan/list_personalnikpbk');?>" type="button" class="btn btn-default"/> Kembali</a-->
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
</div></div></div>
<?php } ?>

<script type="text/javascript">
            $(function() {
			/* 		var rad = document.inputformPbk.optradio;
					var prev = null;
					for(var i = 0; i < rad.length; i++) {
						rad[i].onclick = function() {
							(prev)? console.log(prev.value):null;
							if(this !== prev) {
								prev = this;
							}
							console.log(this.value)
						};
					}
			
			
				$('#lookstockno').on('click change', function(e) {
					console.log(e.type);
				});
				
				$('#lookstockyes').onclick(function(){
						console.log('yes1');
			
					});
					 */	
			});
</script>
	  