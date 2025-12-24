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
									$('[name="qtyonhand"]').val(data.conhand);                        
								//	$('[name="satkecil"]').val(data.satkecil);                                                          
								//	$('[name="nmsatkecil"]').val(data.nmsatkecil);                                                          
									$('.satkecil').val(data.satkecil);                                                          
									$('.nmsatkecil').val(data.nmsatkecil);   
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
<!--div class="pull-right">Versi: <?php echo $version; ?></div--->
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>


</br>
<div class="row">
		<div class="col-sm-12">		
			<a href="<?php echo site_url("intern/cr_sj/form_cr_sj")?>"  onclick="return confirm('Anda akan kembali ??')" class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
			
			<div class="dropdown pull-right">
				<button class="btn btn-warning dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown"><i class="fa fa-print"> </i> Cetak	<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" target="_blank" href="<?php echo site_url('intern/printer/print_text').'/'.trim($trxno) ;?>"><i class="fa fa-print"> </i> Cetak Bluetoth</a></li--> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#instruction"><i class="fa fa-print"> </i> Cetak Via Bluetooth</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#ChoiceOfLetter"  href="#"><i class="fa fa-edit"> </i> Cetak Via Web</a></a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" target="_blank" href="intent:#Intent;
scheme=id.syifarahmat.androiddesign.printer://open;
package=id.syifarahmat.androiddesign.printer;
S.browser_fallback_url=<?php echo urlencode('market://details?id=id.syifarahmat.androiddesign.printer'); ?>;
end"><i class="fa fa-print"> </i> BUKA PRINTER</a></li--> 


				  
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("intern/cr_sj/i_cr_sj")?>">Input Data Pengiriman</a></li--->		
				</ul>
			</div>
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
											<th>NOMOR PO</th>
											<th>DOKUMEN REV</th>
											<th>TGL DOKUMEN</th>
											<th>STATUS</th>
											<th width="8%">AKSI</th>	
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_trx_t_inmst_web as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo TRIM($row->fc_fromno);?></td>
									<td><?php echo TRIM($row->fv_reference);?></td>
									<td><?php if (empty($row->fv_entrydate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->fv_entrydate))); }?></td>
									<td><?php echo TRIM($row->status);?></td>	
									<td width="15%">		
										<?php /*<a href="#" data-toggle="modal" data-target="#EDINPUTMST<?php echo trim($row->fc_trxno);?>" class="btn btn-primary btn-sm"><i class="fa fa-default"></i> UBAH </a>*/ ?>
										<a href="#" data-toggle="modal" data-target="#DETAILINPUTMST<?php echo str_replace('/','_',trim($row->fc_trxno));?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> DETAIL </a>
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
<?php /*<div class="row">
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

		<a href="<?php echo site_url("intern/cr_sj/reset_input")?>"  class="btn btn-danger pull-right" onclick="return confirm('Reset info Qty Data Ini?? Akan Otomatis Kembali Ke 0 ')" style="margin:10px; color:#ffffff;">RESET</a>
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
											<th>SATUAN</th>
											<th>EXTRA</th>
											<th>EXTRA KIRIM</th>
											<th>QTY</th>
											<th>QTY KIRIM</th>
											<th width="8%">AKSI</th>	
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_trx_t_indtl_web as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->stockname;?></td>
									<td><?php echo $row->packname;?></td>
									<td align="right"><?php echo $row->fn_extra;?></td>
									<td align="right"><?php echo $row->fn_extrarec;?></td>
									<td align="right"><?php echo $row->fn_qty;?></td>
									<td align="right"><?php echo $row->fn_qtyrec;?></td>
									<td width="15%">				
										<?php /*<a href="#" data-toggle="modal" data-target="#EDIT_INDTL<?php echo trim($row->fc_trxno).trim($row->FN_NOMOR);?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT </a>*/ ?>
										<a href="#" data-toggle="modal" data-target="#DETAIL_INDTL<?php echo str_replace('/','_',trim($row->fc_trxno)).trim($row->fn_nomor);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>
											
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

<?php foreach($list_trx_t_inmst_web as $lb) { ?>
<div class="modal fade" id="EDINPUTMST<?php echo str_replace('/','_',trim($lb->fc_trxno));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL DATA PENGIRIMAN</h4>
	  </div>
<form action="<?php echo site_url('intern/cr_sj/save_cr_sj')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group ">
								<label class="col-sm-4">NO DOKUMEN DARI</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="FC_TRXNO" name="FC_TRXNO"  value="<?php echo trim($lb->fc_trxno);?>" placeholder="0" class="form-control" readonly >
									<input type="text" id="FC_FROMNO" name="FC_FROMNO"  value="<?php echo trim($lb->fc_fromno);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="EDINPUT_INMST_WEB" class="form-control" readonly >
								</div>
							</div>
							
							<div class="form-group ">
								<label class="col-sm-4">NAMA SUPPLIER</label>	
								<div class="col-sm-8">    
									<input type="text" id="FV_SUPPNAME" name="FV_SUPPNAME"  value="<?php echo trim($lb->fv_suppname);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">KOTA SUPPLIER</label>	
								<div class="col-sm-8">    
									<input type="text" id="FV_SUPPCITY" name="FV_SUPPCITY"  value="<?php echo trim($lb->fv_suppcity);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ALAMAT SUPPLIER</label>	
								<div class="col-sm-8">    
									<input type="text" id="FV_SUPADD1" name="FV_SUPADD1"  value="<?php echo trim($lb->fv_suppadd1);?>" placeholder="Alamat Supplier" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA CUSTOMER</label>	
								<div class="col-sm-8">    
									<input type="text" id="FV_CUSTNAME" name="FV_CUSTNAME"  value="<?php echo trim($lb->fv_custname);?>" placeholder="Nama Customer" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ALAMAT CUSTOMER</label>	
								<div class="col-sm-8">    
									<input type="text" id="FV_CUSTADD1" name="FV_CUSTADD1"  value="<?php echo trim($lb->fv_custadd1);?>" placeholder="Alamat Customer" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="FV_SUPADD1" name="FV_SUPADD1"   style="text-transform:uppercase" class="form-control" disabled readonly><?php echo trim($lb->fv_suppadd1);?></textarea>
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
								<label class="col-sm-4">TANGGAL DOKUMEN</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm" id="FV_ENTRYDATE" name="FV_ENTRYDATE"  data-date-format="dd-mm-yyyy"  value="<?php if (empty($lb->fv_entrydate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($lb->fv_entrydate))); } ?>" READONLY>
								</div>
							</div>					

							<div class="form-group ">
								<label class="col-sm-4">NO SJ REFERENSI</label>	
								<div class="col-sm-8">    
									<input type="input" id="FV_REFERENCE" name="FV_REFERENCE"  value="<?php echo trim($lb->fv_reference);?>" placeholder="Masukkan Surat Jalan Referensi" class="form-control" required >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL REFERENSI</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="FV_REFTGL" name="FV_REFTGL"  data-date-format="dd-mm-yyyy"  value="<?php if (empty($lb->fv_reftgl)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($lb->fv_reftgl))); } ?>" required>
								</div>
							</div>	
							<?php /*<div class="form-group ">
								<label class="col-sm-4">NAMA EXPEDISI</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_EXPEDISI" name="FC_EXPEDISI"  value="<?php echo trim($lb->FC_EXPEDISI);?>" placeholder="Nama Expedisi" class="form-control" required >
								</div>
							</div> */ ?>
							<div class="form-group">
									<label class="col-sm-4">KODE / NAMA EXPEDISI</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm " disabled readonly>
									 <option value="">---PILIH KODE / NAMA EXPEDISI--</option> 
									  <?php foreach($list_expedisi as $sc){?>					  
									  <option   <?php if (trim($sc->fc_expedisi)==trim($lb->fc_expedisi)) { echo 'selected';}?>  value="<?php echo trim($sc->fc_expedisi);?>" ><?php echo trim($sc->fv_expdname);?></option>						  
									  <?php }?>
									</select>
									</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NOPOL</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_NOPOL" name="FC_NOPOL"  value="<?php echo trim($lb->fc_nopol);?>" placeholder="Isi Nomor Polisi Expedisi" class="form-control" required >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA SUPIR</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_NAMEDRIVER" name="FC_NAMEDRIVER"  value="<?php echo trim($lb->fc_namedriver);?>" placeholder="Isi Nama Supir Expedisi" class="form-control" required >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NOMOR HP DRIVER</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_HPDRIVER" name="FC_HPDRIVER"  value="<?php echo trim($lb->fc_hpdriver);?>" placeholder="Isi Nama Contact Supir Expedisi" class="form-control" required >
								</div>
							</div>
							<div class="form-group">
									<label class="col-sm-4">TIPE PENGIRIMAN</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm ch" name="FC_FRANCO" id="FC_FRANCO" >
									 <option value="">---PILIH TIPE PENGIRIMAN--</option>									  				  
									  <option   <?php if ('Franco'==trim($lb->fc_franco)) { echo 'selected';}?>  value="<?php echo 'Franco';?>" ><?php echo 'FRANCO';?></option>						  
									  <option   <?php if ('Loco'==trim($lb->fc_franco)) { echo 'selected';}?>  value="<?php echo 'Loco';?>" ><?php echo 'LOCO';?></option>						  
									</select>
									</div>
							</div>
						
							<div class="form-group">	
								<!--label class="col-sm-4">FOTO SJ</label--->	
								<?php $lp=trim($lb->ft_image); if ($lp<>'') { echo base_url('assets/img/mobile/sjweb/'.$lp);} else { echo base_url('assets/img/user.png');} ;?>
								<div class="col-sm-12">  							
									<!--p align="center"><input align="center" type="file" id="FT_IMAGE" name="FT_IMAGE" value="<?php $lp=trim($lb->FT_IMAGE); if ($lp<>'' or empty($lb)) { echo base_url('/assets/img/foto_sj/'.$lp);} else { } ;?>"> </p--->
									<!--p align="center"><input align="center" type="file" id="FT_IMAGE" name="FT_IMAGE" value="<?php echo base_url('/assets/img/foto_sj/'.$lp);?>"> </p-->
									<p align="center"><img src="<?php echo base_url('assets/img/mobile/sjweb/'.$lp);?>" class='img-responsive'></p>
									
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


<?php foreach($list_trx_t_inmst_web as $lb) { ?>
<div class="modal fade" id="DETAILINPUTMST<?php echo str_replace('/','_',trim($lb->fc_trxno));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">UBAH DATA PENGIRIMAN</h4>
	  </div>
<form action="<?php echo site_url('intern/cr_sj/save_cr_sj')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group ">
								<label class="col-sm-4">NO DOKUMEN DARI</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="FC_TRXNO" name="FC_TRXNO"  value="<?php echo trim($lb->fc_trxno);?>" placeholder="0" class="form-control" readonly >
									<input type="text" id="FC_FROMNO" name="FC_FROMNO"  value="<?php echo trim($lb->fc_fromno);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="EDINPUT_INMST_WEB" class="form-control" readonly >
								</div>
							</div>
							
							<div class="form-group ">
								<label class="col-sm-4">NAMA SUPPLIER</label>	
								<div class="col-sm-8">    
									<input type="text" id="FV_SUPPNAME" name="FV_SUPPNAME"  value="<?php echo trim($lb->fv_suppname);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">KOTA SUPPLIER</label>	
								<div class="col-sm-8">    
									<input type="text" id="FV_SUPPCITY" name="FV_SUPPCITY"  value="<?php echo trim($lb->fv_suppcity);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ALAMAT SUPPLIER</label>	
								<div class="col-sm-8">    
									<input type="text" id="FV_SUPADD1" name="FV_SUPADD1"  value="<?php echo trim($lb->fv_suppadd1);?>" placeholder="Alamat Supplier" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA CUSTOMER</label>	
								<div class="col-sm-8">    
									<input type="text" id="FV_CUSTNAME" name="FV_CUSTNAME"  value="<?php echo trim($lb->fv_custname);?>" placeholder="Nama Customer" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ALAMAT CUSTOMER</label>	
								<div class="col-sm-8">    
									<input type="text" id="FV_CUSTADD1" name="FV_CUSTADD1"  value="<?php echo trim($lb->fv_custadd1);?>" placeholder="Alamat Customer" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="FV_SUPADD1" name="FV_SUPADD1"   style="text-transform:uppercase" class="form-control" disabled readonly><?php echo trim($lb->fv_suppadd1);?></textarea>
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
								<label class="col-sm-4">TANGGAL DOKUMEN</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm" id="FV_ENTRYDATE" name="FV_ENTRYDATE"  data-date-format="dd-mm-yyyy"  value="<?php if (empty($lb->fv_entrydate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($lb->fv_entrydate))); } ?>" READONLY>
								</div>
							</div>					

							<div class="form-group ">
								<label class="col-sm-4">NO SJ REFERENSI</label>	
								<div class="col-sm-8">    
									<input type="input" id="FV_REFERENCE" name="FV_REFERENCE"  value="<?php echo trim($lb->fv_reference);?>" placeholder="Masukkan Surat Jalan Referensi" class="form-control" READONLY >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL REFERENSI</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="FV_REFTGL" name="FV_REFTGL"  data-date-format="dd-mm-yyyy"  value="<?php if (empty($lb->fv_reftgl)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($lb->fv_reftgl))); } ?>" READONLY>
								</div>
							</div>	
							<?php /*<div class="form-group ">
								<label class="col-sm-4">NAMA EXPEDISI</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_EXPEDISI" name="FC_EXPEDISI"  value="<?php echo trim($lb->FC_EXPEDISI);?>" placeholder="Nama Expedisi" class="form-control" READONLY >
								</div>
							</div>*/ ?>
							<div class="form-group">
									<label class="col-sm-4">KODE / NAMA EXPEDISI</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm " disabled readonly>
									 <option value="">---PILIH KODE / NAMA EXPEDISI--</option> 
									  <?php foreach($list_expedisi as $sc){?>					  
									  <option   <?php if (trim($sc->fc_expedisi)==trim($lb->fc_expedisi)) { echo 'selected';}?>  value="<?php echo trim($sc->fc_expedisi);?>" ><?php echo trim($sc->fv_expdname);?></option>						  
									  <?php }?>
									</select>
									</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NOPOL</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_NOPOL" name="FC_NOPOL"  value="<?php echo trim($lb->fc_nopol);?>" placeholder="Isi Nomor Polisi Expedisi" class="form-control" READONLY >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA SUPIR</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_NAMEDRIVER" name="FC_NAMEDRIVER"  value="<?php echo trim($lb->fc_namedriver);?>" placeholder="Isi Nama Supir Expedisi" class="form-control" READONLY >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NOMOR HP DRIVER</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_HPDRIVER" name="FC_HPDRIVER"  value="<?php echo trim($lb->fc_hpdriver);?>" placeholder="Isi Nama Contact Supir Expedisi" class="form-control" READONLY >
								</div>
							</div>
							<div class="form-group">
									<label class="col-sm-4">TIPE PENGIRIMAN</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm ch" name="FC_FRANCO" id="FC_FRANCO" disabled readonly>
									 <option value="">---PILIH TIPE PENGIRIMAN--</option>									  				  
									  <option   <?php if ('Franco'==trim($lb->fc_franco)) { echo 'selected';}?>  value="<?php echo 'Franco';?>" ><?php echo 'FRANCO';?></option>						  
									  <option   <?php if ('Loco'==trim($lb->fc_franco)) { echo 'selected';}?>  value="<?php echo 'Loco';?>" ><?php echo 'LOCO';?></option>						  
									</select>
									</div>
							</div>
						
							<div class="form-group">	
								<!--label class="col-sm-4">FOTO SJ</label--->	
								<!--<?php $lp=trim($lb->ft_image); if ($lp<>'') { echo base_url('assets/img/mobile/sjweb/'.$lp);} else { echo base_url('assets/img/user.png');} ;?>--->
								<div class="col-sm-12">  							
									<!--p align="center"><input align="center" type="file" id="FT_IMAGE" name="FT_IMAGE" value="<?php $lp=trim($lb->FT_IMAGE); if ($lp<>'' or empty($lb)) { echo base_url('/assets/img/foto_sj/'.$lp);} else { } ;?>"> </p--->
									<!--p align="center"><input align="center" type="file" id="FT_IMAGE" name="FT_IMAGE" value="<?php echo base_url('/assets/img/foto_sj/'.$lp);?>"> </p-->
									<p align="center"><img src="<?php echo base_url('assets/img/mobile/sjweb/'.trim($lb->ft_image));?>" class='img-responsive'></p>
									
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


<?php foreach($list_trx_t_indtl_web as $lb) { ?>
<div class="modal fade" id="EDIT_INDTL<?php echo str_replace('/','_',trim($lb->fc_trxno)).trim($lb->fn_nomor); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM UBAH QTY DETAIL BARANG</h4>
	  </div>
<form action="<?php echo site_url('intern/cr_sj/save_cr_sj')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group ">
								<label class="col-sm-4">NO DOKUMEN</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_TRXNO" name="FC_TRXNO"  value="<?php echo trim($lb->fc_trxno);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="FN_NOMOR" name="FN_NOMOR"  value="<?php echo trim($lb->fn_nomor);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="FC_DOCNO" name="FC_DOCNO"  value="<?php echo trim($lb->fc_docno);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="EDINPUT_INDTL_WEB" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">KODE BARANG</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_STOCKCODE" name="FC_STOCKCODE"  value="<?php echo trim($lb->fc_stockcode);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA BARANG</label>	
								<div class="col-sm-8">    
									<input type="input" id="STOCKNAME" name="STOCKNAME"  value="<?php echo trim($lb->stockname);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">SATUAN</label>	
								<div class="col-sm-8">    
									<input type="input" id="PACKNAME" name="PACKNAME"  value="<?php echo trim($lb->packname);?>" placeholder="0" class="form-control" readonly >
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
								<label class="col-sm-4">JUMLAH BARANG</label>	
								<div class="col-sm-8">    
									<input type="text" id="FN_QTY" name="FN_QTY"  value="<?php echo trim($lb->fn_qty);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>						
						</div>
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4">JUMLAH KIRIM</label>	
								<div class="col-sm-8">    
									<input type="text" id="FN_QTYREC" name="FN_QTYREC"  value="<?php echo trim($lb->fn_qtyrec);?>" placeholder="0" class="form-control" required>
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

<?php foreach($list_trx_t_indtl_web as $lb) { ?>
<div class="modal fade" id="DETAIL_INDTL<?php echo str_replace('/','_',trim($row->fc_trxno)).trim($lb->fn_nomor); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM UBAH QTY DETAIL BARANG</h4>
	  </div>
<form action="<?php echo site_url('intern/cr_sj/save_cr_sj')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group ">
								<label class="col-sm-4">NO DOKUMEN</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_TRXNO" name="FC_TRXNO"  value="<?php echo trim($lb->fc_trxno);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="DETAILINPUT_INDTL_WEB" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">KODE BARANG</label>	
								<div class="col-sm-8">    
									<input type="input" id="FC_STOCKCODE" name="FC_STOCKCODE"  value="<?php echo trim($lb->fc_stockcode);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA BARANG</label>	
								<div class="col-sm-8">    
									<input type="input" id="STOCKNAME" name="STOCKNAME"  value="<?php echo trim($lb->stockname);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">SATUAN</label>	
								<div class="col-sm-8">    
									<input type="input" id="PACKNAME" name="PACKNAME"  value="<?php echo trim($lb->packname);?>" placeholder="0" class="form-control" readonly >
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
								<label class="col-sm-4">JUMLAH BARANG</label>	
								<div class="col-sm-8">    
									<input type="text" id="FN_QTY" name="FN_QTY"  value="<?php echo trim($lb->fn_qty);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>						
						</div>
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4">JUMLAH KIRIM</label>	
								<div class="col-sm-8">    
									<input type="text" id="FN_QTYREC" name="FN_QTYREC"  value="<?php echo trim($lb->fn_qtyrec);?>" placeholder="0" class="form-control" readonly>
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
       <?php /* <button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button> */ ?>
      </div>
	  </form>
</div></div></div>
<?php } ?>




<div class="modal fade" id="instruction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INSTRUKSI / CARA KERJA PRINTER</h4>
	  </div>
<form action="<?php echo site_url('intern/cr_sj/save_cr_sj')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
					<div>SEBELUM MELAKUKAN CETAK PRINTER IKUTI INSTRUKSI LANGKAH KERJA SEBAGAI BERIKUT:</div>
					<div><br/></div>
						<div>	1.	CLICK UNDUH DATA PADA TOMBOL DI BAWAH INI.</div>
						<div>	2.	SETELAH MUNCUL HASIL DOWNLOAD FILE.RPT.</div>
						<div>	3.	CLICK TOMBOL CETAK PADA MENU TOMBOL DI BAWAH INI.</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	

		</div>	
	</div>	
    <div class="modal-footer">
	<a href="<?php echo site_url('intern/printer/print_text').'/'.trim($trxno) ;?>" target="_blank"  class="btn btn-warning pull-left" style="margin:10px; color:#ffffff;"><i class="fa fa-download"> </i>Unduh Data</a>
	<a href="intent:#Intent;
scheme=id.syifarahmat.androiddesign.printer://open;
package=id.syifarahmat.androiddesign.printer;
S.browser_fallback_url=<?php echo urlencode('market://details?id=id.syifarahmat.androiddesign.printer'); ?>;
end" target="_blank" class="btn btn-success pull-right" style="margin:10px; color:#ffffff;"><i class="fa fa-print"> </i>cetak via bluetooth</a>
	 <!--li role="presentation"><a role="menuitem" tabindex="-1" target="_blank" href="<?php echo site_url('intern/printer/print_text').'/'.trim($trxno) ;?>"><i class="fa fa-print"> </i> Unduh Data</a></li--> 
				  
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#ChoiceOfLetter"  href="#"><i class="fa fa-edit"> </i> Cetak Via Web</a></a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" target="_blank" href="intent:#Intent;
scheme=id.syifarahmat.androiddesign.printer://open;
package=id.syifarahmat.androiddesign.printer;
S.browser_fallback_url=<?php echo urlencode('market://details?id=id.syifarahmat.androiddesign.printer'); ?>;
end"><i class="fa fa-print"> </i> BUKA PRINTER</a></li--> 
      </div>
	  </form>
</div></div></div>



<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>