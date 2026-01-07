<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
					<script type="text/javascript" charset="utf-8">
            $(function() {
                $("#example1").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				$(".tgl").datepicker();   
				$("#kdsubgroup").chained("#kdgroup");
				$("#stockcode").chained("#kdsubgroup");

				
		/*		$("#kdgroup").change(function (){
					var url = "<?php echo site_url('ga/instock/add_ajax_kdgroup');?>/"+$(this).val();
					$('#kdgroup').load(url);
					return false;
				}) 
				
				$("#kdgroup").change(function (){
					var url = "<?php echo site_url('ga/instock/add_ajax_kdsubgroup');?>/"+$(this).val();
					$('#kdsubgroup').load(url);
					return false;
				})
				
				$("#stockcode").change(function (){
					var url = "<?php echo site_url('ga/instock/add_ajax_stockcode');?>/"+$(this).val();
					$('#stockcode').load(url);
					return false;
				}) */
				
					$('#stockcode').change(function(){
						console.log($('#stockcode').val() != '');
						if 	($('#stockcode').val() != '') {						
							var param1=$('#kdgroup').val();
							var param2=$('#kdsubgroup').val();
							var param3=$('#stockcode').val();
							var param4=$('#loccode').val();
							  $.ajax({
								url : "<?php echo site_url('ga/permintaan/js_viewstock_back')?>/" + param1 + "/" + param2 + "/" + param3 + "/" + param4,
								type: "GET",
								dataType: "JSON",
								success: function(data)
								{			   
							//		$('[name="qtyonhand"]').val(data.conhand);                        
								//	$('[name="satkecil"]').val(data.satkecil);                                                          
								//	$('[name="nmsatkecil"]').val(data.nmsatkecil);                                                          
						//			$('.satkecil').val(data.satkecil);                                                          
						//			$('.nmsatkecil').val(data.nmsatkecil);   
								},
								error: function (jqXHR, textStatus, errorThrown)
								{
									alert('Error get data from ajax');
								}
							}); 
						};				
					});
				
				
				
				
			});



		
				
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>


</br>
<div class="row">
		<div class="col-sm-12">		
			<a href="<?php echo site_url("ga/itemtrans/clear_tmp_itemtrans_in".'/'.trim($trg_mst['nodok']))?>"  onclick="return confirm('PERINGATAN KEMBALI AKAN MENGHAPUS SEMUA INPUTAN YG TELAH ANDA BUAT, TEKAN (OK) JIKA ANDA SETUJU, JIKA TIDAK TEKAN (BATAL)')" class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
			<a href="<?php echo site_url("ga/itemtrans/final_input_itemtrans_in")?>"  onclick="return confirm('Anda Yakin Dengan Inputan Yang Anda Buat?')" class="btn btn-primary pull-right" style="margin:10px; color:#ffffff;">Simpan</a>
		</div>
<div class="col-sm-12">
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example2" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>NODOK</th>
											<th>TANGGAL</th>
											<th>KDGUDANG AWAL</th>
											<th>KDGUDANG TUJUAN</th>
											<th>STATUS</th>
											<th>DESCRIPTION</th>
											<!--th width="8%">AKSI</th--->	
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_master as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodok;?></td>
									<td><?php if (empty($row->nodok_date)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->nodok_date))); }?></td>
									<td><?php echo $row->loccode;?></td>
									<td><?php echo $row->loccode_destination;?></td>	
									<td><?php echo $row->nmstatus;?></td>
									<td><?php echo $row->description;?></td>
									<!--td width="15%">		
										<a href="#" data-toggle="modal" data-target="#EDINPUT_IN_TRGD<?php echo str_replace('.','',trim($row->nodok));?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT </a>
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
<?php /*
<div class="row">
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#INPUT_IN_TRGD_DTL"  href="#">Input Barang Transfer Gudang</a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/ajustment/input_ajustment_in_trgd")?>">Input Transfer Antar Gudang</a></li--->		
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
</div>	
*/ ?>
<div class="col-sm-12">
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example2" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>NAMA BARANG</th>
											<!--th>KDGUDANG AWAL</th-->
											<!--th>KDGUDANG TUJUAN</th--->
											<th>QTY</th>
											<th>QTY SATUAN</th>
											<th>STATUS</th>
											<th>DESCRIPTION</th>
											<th width="8%">AKSI</th>	
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_detail as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nmbarang;?></td>
									<!--td><?php echo $row->loccode;?></td-->
									<!--td><?php echo $row->loccode_destination;?></td--->
									<td align="right"><?php echo $row->qty;?></td>
									<td><?php echo $row->nmsatkecil;?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td><?php echo $row->description;?></td>
									<td width="15%">
																	
											<a href="#" data-toggle="modal" data-target="#DTL_IN_TRGD_DTL<?php echo trim($row->id);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>
											<a href="#" data-toggle="modal" data-target="#EDIT_IN_TRGD_DTL<?php echo trim($row->id);?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT </a>
											<!---a href="#" data-toggle="modal" data-target="#DEL_IN_TRGD_DTL<?php echo trim($row->id);?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> HAPUS </a--->
											
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
</div><!--/ nav -->	

<?php foreach($list_master as $lb) { ?>
<div class="modal fade" id="EDINPUT_IN_TRGD<?php echo str_replace('.','',trim($lb->nodok));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">PEMILIHAN GUDANG TRANSFER ANTAR GUDANG</h4>
	  </div>
<form action="<?php echo site_url('ga/itemtrans/save_itemtrans')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group ">
								<label class="col-sm-4">NODOK</label>	
								<div class="col-sm-8">    
									<input type="input" id="nodok" name="nodok"  value="<?php echo trim($lb->nodok);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="EDINPUT_IN_TRGD" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Pilih Gudang Asal</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm" name="loccode" id="loccode" required>
									 <option  value="">---PILIH KODE GUDANG || NAMA GUDANG--</option> 
									  <?php foreach($desc_gudang as $sc){?>					  
									  <option  <?php if (trim($sc->kdcabang)==trim($lb->loccode)) { echo 'selected';}?>  value="<?php echo trim($sc->kdcabang);?>"><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
									  <?php }?>
									</select>
								</div>
								<!--input type="hidden" name="loccode" id="loccode" value="<?php echo trim($lb->loccode);?>" class="form-control "  --->
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Pilih Gudang Tujuan</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm" name="loccode_destination" id="loccode_destination" required>
									 <option  value="">---PILIH KODE GUDANG || NAMA GUDANG--</option> 
									  <?php foreach($desc_gudang as $sc){?>					  
									  <option  <?php if (trim($sc->kdcabang)==trim($lb->loccode_destination)) { echo 'selected';}?>  value="<?php echo trim($sc->kdcabang);?>"><?php echo trim($sc->kdcabang).' || '.trim($sc->desc_cabang);?></option>						  
									  <?php }?>
									</select>
								</div>
								<!--input type="hidden" name="loccode_destination" id="loccode_destination" value="<?php echo trim($lb->loccode);?>" class="form-control "  -->
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
								<label class="col-sm-4">TANGGAL PENGAJUAN</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="nodok_date" name="nodok_date"  data-date-format="dd-mm-yyyy"  value="<?php if (empty($lb->nodok_date)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($lb->nodok_date))); } ?>" required>
								</div>
							</div>					

							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="description" name="description"   style="text-transform:uppercase" class="form-control"><?php echo trim($lb->description);?></textarea>
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

<!--------------------- INPUT DETAIL AJUSTMENT--------------------------------------------------------->

<div class="modal fade" id="INPUT_IN_TRGD_DTL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT PEMILIHAN ITEM BARANG TRANSFER ANTAR GUDANG DETAIL BARANG</h4>
	  </div>
<form action="<?php echo site_url('ga/itemtrans/save_itemtrans')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group ">
								<label class="col-sm-4">NODOK</label>	
								<div class="col-sm-8">    
									<input type="input" id="nodok" name="nodok"  value="<?php echo trim($trg_mst['nodok']);?>"  class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="INPUT_IN_TRGD_DTL" class="form-control" readonly >
								</div>
							</div>

							<div class="form-group ">
								<label class="col-sm-4">LOKASI KODE</label>	
								<div class="col-sm-8">    
									<input type="input" id="loccode" name="loccode"  value="<?php echo trim($trg_mst['loccode']);?>"  class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">LOKASI KODE TUJUAN</label>	
								<div class="col-sm-8">    
									<input type="input" id="loccode_destination" name="loccode_destination"  value="<?php echo trim($trg_mst['loccode_destination']);?>"  class="form-control" readonly >
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
								<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm  "  name="kdgroup" id="kdgroup"  required>
									 <option value="">---PILIH KODE GROUP--</option> 
									  <?php foreach($list_scgroup as $sc){?>					  
									  <option  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
									  <!--option  <?php if (trim($sc->kdgroup)==trim($lb->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option-->						  
									  <?php }?>
									</select>
									</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm "   name="kdsubgroup" id="kdsubgroup" required>
									 <option  value="">---PILIH KODE SUB GROUP--</option> 
									  <?php foreach($list_scsubgroup as $sc) { ?>					  
									  <option   value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
									  <!--option   <?php if (trim($sc->kdsubgroup)==trim($lb->kdsubgroup)) { echo 'selected';}?>   value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option--->						  
									  <?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm stockcode "  name="stockcode" id="stockcode" required>
									 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
									  <?php foreach($list_stkgdw as $sc) { ?>					  
									  <option value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
										
									  <?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group ">
								<label class="col-sm-4">QTY ONHAND</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtyonhand" name="qtyonhand"  placeholder="0" class="form-control" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil'  class="form-control satkecil" readonly >								
									<input type="input" name='nmsatkecil'class="form-control nmsatkecil" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY TERIMA</label>	
								<div class="col-sm-4">    
									<input type="number" id="qty" name="qty"  placeholder="0" class="form-control" required>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil'  class="form-control satkecil" readonly >								
									<input type="input" name='nmsatkecil' class="form-control nmsatkecil" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DESCRIPTION</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="description" name="description"   style="text-transform:uppercase" class="form-control" required></textarea>
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

<?php foreach($list_detail as $lb) { ?>
<div class="modal fade" id="EDIT_IN_TRGD_DTL<?php echo trim($lb->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM UBAH QTY DETAIL BARANG</h4>
	  </div>
<form action="<?php echo site_url('ga/itemtrans/save_itemtrans')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group ">
								<label class="col-sm-4">NODOK</label>	
								<div class="col-sm-8">    
									<input type="input" id="nodok" name="nodok"  value="<?php echo trim($trg_mst['nodok']);?>"  class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="EDIT_QTY_EDIT_IN_TRGD_DTL" class="form-control" readonly >
								</div>
							</div>

							<div class="form-group ">
								<label class="col-sm-4">LOKASI KODE</label>	
								<div class="col-sm-8">    
									<input type="input" id="loccode" name="loccode"  value="<?php echo trim($trg_mst['loccode']);?>"  class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">LOKASI KODE TUJUAN</label>	
								<div class="col-sm-8">    
									<input type="input" id="loccode_destination" name="loccode_destination"  value="<?php echo trim($trg_mst['loccode_destination']);?>"  class="form-control" readonly >
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
								<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm  "   disabled readonly>
									 <option value="">---PILIH KODE GROUP--</option> 
									  <?php foreach($list_scgroup as $sc){?>					  
									  <option   <?php if (trim($sc->kdgroup)==trim($lb->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
									  <!--option  <?php if (trim($sc->kdgroup)==trim($lb->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option-->						  
									  <?php }?>
									</select>
									</div>
									<input type="hidden" name="kdgroup"  value="<?php echo trim($lb->kdgroup);?>" class="form-control" readonly >
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm "    disabled readonly>
									 <option  value="">---PILIH KODE SUB GROUP--</option> 
									  <?php foreach($list_scsubgroup as $sc) { ?>					  
									  <option   <?php if (trim($sc->kdsubgroup)==trim($lb->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
									  <!--option   <?php if (trim($sc->kdsubgroup)==trim($lb->kdsubgroup)) { echo 'selected';}?>   value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option--->						  
									  <?php } ?>
									</select>
								</div>
								<input type="hidden" name="kdsubgroup"  value="<?php echo trim($lb->kdsubgroup);?>" class="form-control" readonly >
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm stockcode "  disabled readonly>
									 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
									  <?php foreach($list_stkgdw as $sc) { ?>					  
									  <option <?php if (trim($sc->stockcode)==trim($lb->stockcode)) { echo 'selected';}?>  value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
									  <?php } ?>
									</select>
								</div>
								<input type="hidden" name="stockcode"  value="<?php echo trim($lb->stockcode);?>" class="form-control" readonly >
							</div>
							
							<div class="form-group ">
								<label class="col-sm-4">QTY ONHAND</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtyonhand" name="qtyonhand"  placeholder="0" class="form-control"   value="<?php echo trim($lb->qtyonhand);?>" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil'  class="form-control satkecil"  value="<?php echo trim($lb->satkecil);?>"   readonly >								
									<input type="input" name='nmsatkecil'class="form-control nmsatkecil"  value="<?php echo trim($lb->nmsatkecil);?>" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY TERIMA</label>	
								<div class="col-sm-4">    
									<input type="number" id="qty" name="qty"  placeholder="0" class="form-control"  value="<?php echo trim($lb->qty);?>" required>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil'  class="form-control satkecil"  value="<?php echo trim($lb->satkecil);?>" readonly >								
									<input type="input" name='nmsatkecil' class="form-control nmsatkecil"   value="<?php echo trim($lb->nmsatkecil);?>"readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DESCRIPTION</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="description" name="description"   style="text-transform:uppercase" class="form-control" required><?php echo trim($lb->description);?></textarea>
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


<?php foreach($list_detail as $lb) { ?>
<div class="modal fade" id="DEL_IN_TRGD_DTL<?php echo trim($lb->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">HAPUS DETAIL QTY BARANG</h4>
	  </div>
<form action="<?php echo site_url('ga/itemtrans/save_itemtrans')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group ">
								<label class="col-sm-4">NODOK</label>	
								<div class="col-sm-8">    
									<input type="input" id="nodok" name="nodok"  value="<?php echo trim($trg_mst['nodok']);?>"  class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="DEL_IN_TRGD_DTL" class="form-control" readonly >
								</div>
							</div>

							<div class="form-group ">
								<label class="col-sm-4">LOKASI KODE</label>	
								<div class="col-sm-8">    
									<input type="input" id="loccode" name="loccode"  value="<?php echo trim($trg_mst['loccode']);?>"  class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">LOKASI KODE TUJUAN</label>	
								<div class="col-sm-8">    
									<input type="input" id="loccode_destination" name="loccode_destination"  value="<?php echo trim($trg_mst['loccode_destination']);?>"  class="form-control" readonly >
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
								<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm  "   disabled readonly>
									 <option value="">---PILIH KODE GROUP--</option> 
									  <?php foreach($list_scgroup as $sc){?>					  
									  <option   <?php if (trim($sc->kdgroup)==trim($lb->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
									  <!--option  <?php if (trim($sc->kdgroup)==trim($lb->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option-->						  
									  <?php }?>
									</select>
									</div>
									<input type="hidden" name="kdgroup"  value="<?php echo trim($lb->kdgroup);?>" class="form-control" readonly >
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm "    disabled readonly>
									 <option  value="">---PILIH KODE SUB GROUP--</option> 
									  <?php foreach($list_scsubgroup as $sc) { ?>					  
									  <option   <?php if (trim($sc->kdsubgroup)==trim($lb->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
									  <!--option   <?php if (trim($sc->kdsubgroup)==trim($lb->kdsubgroup)) { echo 'selected';}?>   value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option--->						  
									  <?php } ?>
									</select>
								</div>
								<input type="hidden" name="kdsubgroup"  value="<?php echo trim($lb->kdsubgroup);?>" class="form-control" readonly >
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm stockcode "  disabled readonly>
									 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
									  <?php foreach($list_stkgdw as $sc) { ?>					  
									  <option <?php if (trim($sc->stockcode)==trim($lb->stockcode)) { echo 'selected';}?>  value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
									  <?php } ?>
									</select>
								</div>
								<input type="hidden" name="stockcode"  value="<?php echo trim($lb->stockcode);?>" class="form-control" readonly >
							</div>
							
							<div class="form-group ">
								<label class="col-sm-4">QTY ONHAND</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtyonhand" name="qtyonhand"  placeholder="0" class="form-control"   value="<?php echo trim($lb->qtyonhand);?>" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil'  class="form-control satkecil"  value="<?php echo trim($lb->satkecil);?>"   readonly >								
									<input type="input" name='nmsatkecil'class="form-control nmsatkecil"  value="<?php echo trim($lb->nmsatkecil);?>" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY TERIMA</label>	
								<div class="col-sm-4">    
									<input type="number" id="qty" name="qty"  placeholder="0" class="form-control"  value="<?php echo trim($lb->qty);?>" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil'  class="form-control satkecil"  value="<?php echo trim($lb->satkecil);?>" readonly >								
									<input type="input" name='nmsatkecil' class="form-control nmsatkecil"   value="<?php echo trim($lb->nmsatkecil);?>"readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DESCRIPTION</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="description" name="description"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($lb->description);?></textarea>
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
        <button type="submit" id="submit"  class="btn btn-danger">DELETE</button>
      </div>
	  </form>
</div></div></div>
<?php } ?>

<?php foreach($list_detail as $lb) { ?>
<div class="modal fade" id="DTL_IN_TRGD_DTL<?php echo trim($lb->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">HAPUS DETAIL QTY BARANG</h4>
	  </div>
<form action="<?php echo site_url('ga/itemtrans/save_itemtrans')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group ">
								<label class="col-sm-4">NODOK</label>	
								<div class="col-sm-8">    
									<input type="input" id="nodok" name="nodok"  value="<?php echo trim($trg_mst['nodok']);?>"  class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="DEL_IN_TRGD_DTL" class="form-control" readonly >
								</div>
							</div>

							<div class="form-group ">
								<label class="col-sm-4">LOKASI KODE</label>	
								<div class="col-sm-8">    
									<input type="input" id="loccode" name="loccode"  value="<?php echo trim($trg_mst['loccode']);?>"  class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">LOKASI KODE TUJUAN</label>	
								<div class="col-sm-8">    
									<input type="input" id="loccode_destination" name="loccode_destination"  value="<?php echo trim($trg_mst['loccode_destination']);?>"  class="form-control" readonly >
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
								<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm  "   disabled readonly>
									 <option value="">---PILIH KODE GROUP--</option> 
									  <?php foreach($list_scgroup as $sc){?>					  
									  <option   <?php if (trim($sc->kdgroup)==trim($lb->kdgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
									  <!--option  <?php if (trim($sc->kdgroup)==trim($lb->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option-->						  
									  <?php }?>
									</select>
									</div>
									<input type="hidden" name="kdgroup"  value="<?php echo trim($lb->kdgroup);?>" class="form-control" readonly >
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm "    disabled readonly>
									 <option  value="">---PILIH KODE SUB GROUP--</option> 
									  <?php foreach($list_scsubgroup as $sc) { ?>					  
									  <option   <?php if (trim($sc->kdsubgroup)==trim($lb->kdsubgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
									  <!--option   <?php if (trim($sc->kdsubgroup)==trim($lb->kdsubgroup)) { echo 'selected';}?>   value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option--->						  
									  <?php } ?>
									</select>
								</div>
								<input type="hidden" name="kdsubgroup"  value="<?php echo trim($lb->kdsubgroup);?>" class="form-control" readonly >
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm stockcode "  disabled readonly>
									 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
									  <?php foreach($list_stkgdw as $sc) { ?>					  
									  <option <?php if (trim($sc->stockcode)==trim($lb->stockcode)) { echo 'selected';}?>  value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
									  <?php } ?>
									</select>
								</div>
								<input type="hidden" name="stockcode"  value="<?php echo trim($lb->stockcode);?>" class="form-control" readonly >
							</div>
							
							<div class="form-group ">
								<label class="col-sm-4">QTY ONHAND</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtyonhand" name="qtyonhand"  placeholder="0" class="form-control"   value="<?php echo trim($lb->qtyonhand);?>" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil'  class="form-control satkecil"  value="<?php echo trim($lb->satkecil);?>"   readonly >								
									<input type="input" name='nmsatkecil'class="form-control nmsatkecil"  value="<?php echo trim($lb->nmsatkecil);?>" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY TERIMA</label>	
								<div class="col-sm-4">    
									<input type="number" id="qty" name="qty"  placeholder="0" class="form-control"  value="<?php echo trim($lb->qty);?>" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil'  class="form-control satkecil"  value="<?php echo trim($lb->satkecil);?>" readonly >								
									<input type="input" name='nmsatkecil' class="form-control nmsatkecil"   value="<?php echo trim($lb->nmsatkecil);?>"readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DESCRIPTION</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="description" name="description"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($lb->description);?></textarea>
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
     
      </div>
	  </form>
</div></div></div>
<?php } ?>



<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>