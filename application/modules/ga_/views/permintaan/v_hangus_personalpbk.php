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
				$("#kdsubgroup").chained("#kdgroup");
				//$("#kdbarang").chained("#kdsubgroup");
			////	$("#onhand").chained("#kdbarang");
			//alert ($('#kdsubgroup').val() != '');
					$('.kdbarang').change(function(){
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
					
					
			});
</script>

<legend><?php echo $title;?></legend>
<h5><b><strong><?php echo '  PERSETUJUAN PERMINTAAN OLEH :: '.TRIM($dtlnik['nmlengkap']);?></strong></b></h5>
<span id="postmessages"></span>
<?php echo $message;?>

<div class="row">
		<div class="col-sm-1">		
			<a href="<?php echo site_url("ga/permintaan/clear_tmp_pbk_hangus/$enc_nik")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
		</div>
		<!--div class="col-sm-1 pull-right">		
			<a href="<?php echo site_url("ga/permintaan/final_tmp_pbk/$enc_nodok")?>"  class="btn btn-primary" onclick="return confirm('Apakah Anda Simpan Data Ini??')" style="margin:0px; color:#ffffff;">SIMPAN </a>
		</div--->
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header"  align="center">
					<h5><b><strong><?php echo 'MASTER PBK';?></strong></b></h5>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>NODOK</th>
											<th>NOMOR TR</th>
											<th>NIK</th>
											<th>NAMA LENGKAP</th>
											<th>LOCCODE</th>
											<th>STATUS</th>
											<th>KETERANGAN</th>
											<th>AKSI</th>
											
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_pbk_trx_mst as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodok;?></td>
									<td><?php echo $row->nodoktmp;?></td>
									<td><?php echo $row->nik;?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->loccode;?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td>
									<a href="#" data-toggle="modal" data-target="#HANGUS<?php echo  str_replace('.','',trim($row->nodok)).trim($row->nodoktmp);?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> HANGUS </a>
									</td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>		
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div><!-- END ROW 1 --->
			<div class="col-xs-12"> 
		
				<div class="box">
					<div class="box-header"  align="center">
					<h5><b><strong><?php echo 'DETAIL PBK';?></strong></b></h5>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example2" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>NODOK</th>
											<th>NOMOR DOKUMEN</th>
											<th>STOCK CODE</th>
											<th>NAMA BARANG</th>
											<th>DESC BARANG</th>
											<th>QTY ONHAND</th>
											<th>QTY KELUAR</th>
											<th>QTY TERIMA</th>
											<th>STATUS</th>
											<th>KETERANGAN</th>
											<!--th>AKSI</th--->
													
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_pbk_trx_dtl as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodok;?></td>
									<td><?php echo $row->nodoktmp;?></td>
									<td><?php echo $row->stockcode;?></td>
									<td><?php echo $row->nmbarang;?></td>
									<td><?php echo $row->desc_barang;?></td>
									<td><?php echo $row->qtyonhand;?></td>
									<td><?php echo $row->cqtypbk;?></td> <!-- view penghangusan -->
									<td><?php echo $row->cqtybbk;?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td><?php echo $row->keterangan;?></td>
									<!--td width="15%">
																	
											<?php if (trim($row->status)=='A') { ?>
											<a href="#" data-toggle="modal" data-target="#APPRDTL<?php echo  str_replace('.','',trim($row->nodok)).trim($row->kdgroup).trim($row->kdsubgroup).trim($row->stockcode);?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> APP DTL </a>
											<a href="#" data-toggle="modal" data-target="#REJAPPDTL<?php echo  str_replace('.','',trim($row->nodok)).trim($row->kdgroup).trim($row->kdsubgroup).trim($row->stockcode);?>" class="btn btn-warning  btn-sm"><i class="fa fa-edit"></i> REJ DTL </a>
											<?php } else if (trim($row->status)=='P') { ?> 
											<a href="#" data-toggle="modal" data-target="#CAPPRDTL<?php echo  str_replace('.','',trim($row->nodok)).trim($row->kdgroup).trim($row->kdsubgroup).trim($row->stockcode);?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> RE APPROV </a>
											<?php } else { echo ' ITEM REJECT ';}?>
									</td--->
								</tr>
								<?php endforeach;?>	
                                    </tbody>		
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>	
</div>	

<?php foreach ($list_pbk_trx_mst as $lb) { ?>
<div class="modal fade" id="HANGUS<?php echo  str_replace('.','',trim($lb->nodok)).trim($lb->nodoktmp);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">PERSETUJUAN PENGHANGUSAN PERMINTAAN BARANG</h4>
	  </div>
<form action="<?php echo site_url('ga/permintaan/save_personalpbk')?>" method="post" name="inputformPbk">
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
									<input type="hidden" id="type" name="type"  value="HANGUSFINAL" class="form-control" style="text-transform:uppercase">
									
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
							<div class="form-group">
								<label class="col-sm-4">NO DOKUMEN</label>	
								<div class="col-sm-8">  
									<input type="text" id="nodok" name="nodok"  value="<?php echo trim($lb->nodok);?>" class="form-control" style="text-transform:uppercase" readonly>																	
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DOKUMEN TMP</label>	
								<div class="col-sm-8">  
									<input type="text" id="nodoktmp" name="nodoktmp"  value="<?php echo trim($lb->nodoktmp);?>" class="form-control" style="text-transform:uppercase" readonly>
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
        <button type="submit" id="submit"  class="btn btn-danger">HANGUS SISA PBK</button>
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
	  