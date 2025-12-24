<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
					<script type="text/javascript" charset="utf-8">
            $(function() {
                $("#example1").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				$("#fc_expedisi").selectize();
				$("#fc_loccode").selectize();
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
			<a href="<?php echo site_url("intern/cr_sj/clear_tmp_inmst")?>"  onclick="return confirm('PERINGATAN KEMBALI AKAN MENGHAPUS SEMUA INPUTAN YG TELAH ANDA BUAT, TEKAN (OK) JIKA ANDA SETUJU, JIKA TIDAK TEKAN (BATAL)')" class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
			<a href="<?php echo site_url("intern/cr_sj/final_input_cr_sj")?>"  onclick="return confirm('Anda Yakin Dengan Inputan Yang Anda Buat?')" class="btn btn-primary pull-right" style="margin:10px; color:#ffffff;">Simpan</a>
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
											<th width="2%">NO.</th>
											<th width="8%">AKSI</th>	
											<th>NOMOR PO</th>
											<th>TGL DOKUMEN</th>
											
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_tmp_T_INMST_WEB as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
									<td width="15%">		
										<a href="#" data-toggle="modal" data-target="#EDINPUTMST<?php echo trim($row->fc_trxno);?>" class="btn btn-primary btn-sm"><i class="fa fa-default"></i> UBAH </a>
										<a href="#" data-toggle="modal" data-target="#DETAILINPUTMST<?php echo trim($row->fc_trxno);?>" class="btn btn-default btn-sm"><i class="fa fa-default"></i> DETAIL </a>
									</td>
									<td><?php echo TRIM($row->fc_fromno);?></td>
									<td><?php if (empty($row->fv_entrydate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->fv_entrydate))); }?></td>
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
</div>	 */ ?>

		<a href="<?php echo site_url("intern/cr_sj/reset_input")?>"  class="btn btn-danger pull-right" onclick="return confirm('Reset info Qty Data Ini?? Akan Otomatis Kembali Ke 0 ')" style="margin:10px; color:#ffffff;">RESET</a>

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
											<th width="2%">NO.</th>
											<th width="8%">AKSI</th>
											<th>NAMA BARANG</th>
											<th>SATUAN</th>
											<th>QTY</th>
											<th>QTY KIRIM</th>
											<th>EXTRA</th>
											<th>EXTRA KIRIM</th>

												
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_tmp_T_INDTL_WEB as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
									<td width="15%">				
										<a href="#" data-toggle="modal" data-target="#EDIT_INDTL<?php echo trim($row->fc_trxno).trim($row->fn_nomor);?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> EDIT </a>
										<a href="#" data-toggle="modal" data-target="#DETAIL_INDTL<?php echo trim($row->fc_trxno).trim($row->fn_nomor);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>
											
									</td>
									<td><?php echo $row->stockname;?></td>
									<td><?php echo $row->packname;?></td>
									<td align="right"><?php echo $row->fn_qty;?></td>
									<td align="right"><?php echo $row->fn_qtyrec;?></td>
									<td align="right"><?php echo $row->fn_extra;?></td>
									<td align="right"><?php echo $row->fn_extrarec;?></td>

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

<?php foreach($list_tmp_T_INMST_WEB as $lb) { ?>
<div class="modal fade" id="EDINPUTMST<?php echo trim($lb->fc_trxno);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
									<input type="hidden" id="fc_trxno" name="fc_trxno"  value="<?php echo trim($lb->fc_trxno);?>" placeholder="0" class="form-control" readonly >
									<input type="text" id="fc_fromno" name="fc_fromno"  value="<?php echo trim($lb->fc_fromno);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="EDINPUT_INMST_WEB" class="form-control" readonly >
								</div>
							</div>
							<?php if (trim($dtl_tmp_PONO['fc_potipe'])=='B') { ?>
							<div class="form-group ">
								<label class="col-sm-4">GUDANG TUJUAN</label>	
								<div class="col-sm-8">    
									<input type="hidden"  name="fc_loccode"  value="<?php echo trim($lb->fc_loccode);?>" placeholder="0" class="form-control" readonly >
									<input type="text" id="fc_locaname" name="fc_locaname"  value="<?php echo trim($lb->fc_locaname);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<?php } else { ?>
							<div class="form-group">
									<label class="col-sm-4">GUDANG TUJUAN</label>		
									<div class="col-sm-8">  
									<select class="form-control input-sm ch" name="fc_loccode" id="fc_loccode">
									 <option value="">---PILIH KODE / NAMA GUDANG--</option> 
									  <?php foreach($list_gudang as $sc){?>					  
									  <option   <?php if (trim($sc->fc_loccode)==trim($lb->fc_loccode)) { echo 'selected';}?>  value="<?php echo trim($sc->fc_loccode);?>" ><?php echo trim($sc->fc_locaname);?></option>						  
									  <?php }?>
									</select>
									</div>
							</div>
							<?PHP } ?>
							<div class="form-group ">
								<label class="col-sm-4">ALAMAT GUDANG TUJUAN</label>	
								<div class="col-sm-8">    
									<input type="text" id="fc_locaadd" name="fc_locaadd"  value="<?php echo trim($lb->fc_locaadd);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA SUPPLIER</label>	
								<div class="col-sm-8">    
									<input type="text" id="fv_suppname" name="fv_suppname"  value="<?php echo trim($lb->fv_suppname);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">KOTA SUPPLIER</label>	
								<div class="col-sm-8">    
									<input type="text" id="fv_suppcity" name="fv_suppcity"  value="<?php echo trim($lb->fv_suppcity);?>" placeholder="Kota supplier" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ALAMAT SUPPLIER</label>	
								<div class="col-sm-8">    
									<input type="text" id="fv_supadd1" name="fv_supadd1"  value="<?php echo trim($lb->fv_suppadd1);?>" placeholder="Alamat Supplier" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA CUSTOMER</label>	
								<div class="col-sm-8">    
									<input type="text" id="fv_custname" name="fv_custname"  value="<?php echo trim($lb->fv_custname);?>" placeholder="Nama Customer" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ALAMAT CUSTOMER</label>	
								<div class="col-sm-8">    
									<input type="text" id="fv_custadd1" name="fv_custadd1"  value="<?php echo trim($lb->fv_custadd1);?>" placeholder="Alamat Customer" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="ft_note" name="ft_note"   style="text-transform:uppercase" class="form-control" disabled readonly><?php echo trim($lb->ft_note);?></textarea>
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
									<input type="text" class="form-control input-sm" id="fv_entrydate" name="fv_entrydate"  data-date-format="dd-mm-yyyy"  value="<?php if (empty($lb->fv_entrydate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($lb->fv_entrydate))); } ?>" READONLY>
								</div>
							</div>					

							<div class="form-group ">
								<label class="col-sm-4">NO SJ REFERENSI</label>	
								<div class="col-sm-8">    
									<input type="input" id="fv_reference" name="fv_reference"  value="<?php echo trim($lb->fv_reference);?>" style="text-transform:uppercase"  placeholder="Masukkan Surat Jalan Referensi" class="form-control"  maxlength="15" required >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL REFERENSI</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="fd_reftgl" name="fd_reftgl"  data-date-format="dd-mm-yyyy"  value="<?php if (empty($lb->fv_reftgl)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($lb->fv_reftgl))); } ?>" required>
								</div>
							</div>	
							<?php /*
							<div class="form-group ">
								<label class="col-sm-4">NAMA EXPEDISI</label>	
								<div class="col-sm-8">    
									<input type="input" id="fc_expedisi" name="fc_expedisi"  value="<?php echo trim($lb->fc_expedisi);?>" placeholder="Nama Expedisi" class="form-control" required >
								</div>
							</div> */ ?>
							
							<div class="form-group">
									<label class="col-sm-4">KODE / NAMA EXPEDISI</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm ch" name="fc_expedisi" id="fc_expedisi">
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
									<input type="input" id="fc_nopol" name="fc_nopol"  value="<?php echo trim($lb->fc_nopol);?>" style="text-transform:uppercase"  placeholder="Isi Nomor Polisi Expedisi" class="form-control"  maxlength="12"  required >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA SUPIR</label>	
								<div class="col-sm-8">    
									<input type="input" id="fc_namedriver" name="fc_namedriver"  value="<?php echo trim($lb->fc_namedriver);?>" style="text-transform:uppercase"  placeholder="Isi Nama Supir Expedisi" class="form-control"  maxlength="100"  required >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NOMOR HP DRIVER</label>	
								<div class="col-sm-8">    
									<input type="number" id="fc_hpdriver" name="fc_hpdriver"  value="<?php echo trim($lb->fc_hpdriver);?>" style="text-transform:uppercase"  placeholder="Isi Nomor HP Supir Expedisi" class="form-control" maxlength="25" required >
								</div>
							</div>
							<div class="form-group">
									<label class="col-sm-4">TIPE PENGIRIMAN</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm ch" name="fc_franco" id="fc_franco" required>
									 <option value="">---PILIH TIPE PENGIRIMAN--</option>									  				  
									  <option   <?php if ('YES'==trim($lb->fc_franco)) { echo 'selected';}?>  value="<?php echo 'YES';?>" ><?php echo 'FRANCO';?></option>						  
									  <option   <?php if ('NO'==trim($lb->fc_franco)) { echo 'selected';}?>  value="<?php echo 'NO';?>" ><?php echo 'LOCO';?></option>						  
									</select>
									</div>
							</div>

						
					
							<div class="form-group">	
								<!--label class="col-sm-4">FOTO SJ</label--->	
								<!--<?php $lp=$dtllamp_dp['file_name']; if ($lp<>'') { echo base_url('assets/attachment/fotoprofil/'.$lp);} else { echo base_url('assets/img/user.png');} ;?>--->
								<div class="col-sm-12">  							
									<!--p align="center"><input align="center" type="file" id="ft_image" name="ft_image" value="<?php $lp=trim($lb->ft_image); if ($lp<>'' or empty($lb)) { echo base_url('/assets/img/foto_sj/'.$lp);} else { } ;?>"> </p--->
									<!--p align="center"><input align="center" type="file" id="ft_image" name="ft_image" value="<?php echo base_url('/assets/img/foto_sj/'.$lp);?>"> </p-->
									<p align="center"><input align="center" type="file" id="ft_image" name="ft_image" > </p>
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


<?php foreach($list_tmp_T_INMST_WEB as $lb) { ?>
<div class="modal fade" id="DETAILINPUTMST<?php echo trim($lb->fc_trxno);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
									<input type="hidden" id="fc_trxno" name="fc_trxno"  value="<?php echo trim($lb->fc_trxno);?>" placeholder="0" class="form-control" readonly >
									<input type="text" id="fc_fromno" name="fc_fromno"  value="<?php echo trim($lb->fc_fromno);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="EDINPUT_INMST_WEB" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">GUDANG TUJUAN</label>	
								<div class="col-sm-8">    
									<input type="text" id="fc_locaname" name="fc_locaname"  value="<?php echo trim($lb->fc_locaname);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ALAMAT GUDANG TUJUAN</label>	
								<div class="col-sm-8">    
									<input type="text" id="fc_locaadd" name="fc_locaadd"  value="<?php echo trim($lb->fc_locaadd);?>" placeholder="0" class="form-control" readonly >
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
									<input type="text" id="FV_SUPPCITY" name="FV_SUPPCITY"  value="<?php echo trim($lb->fv_suppcity);?>" placeholder="Kota supplier" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ALAMAT SUPPLIER</label>	
								<div class="col-sm-8">    
									<input type="text" id="FV_SUPADD1" name="FV_SUPADD1"  value="<?php echo trim($lb->fv_suppadd1);?>" style="text-transform:uppercase" placeholder="Alamat Supplier" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA CUSTOMER</label>	
								<div class="col-sm-8">    
									<input type="text" id="fv_custname" name="fv_custname"  value="<?php echo trim($lb->fv_custname);?>" style="text-transform:uppercase"  placeholder="Nama Customer" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ALAMAT CUSTOMER</label>	
								<div class="col-sm-8">    
									<input type="text" id="fv_custadd1" name="fv_custadd1"  value="<?php echo trim($lb->fv_custadd1);?>" placeholder="Alamat Customer" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="ft_note" name="ft_note"   style="text-transform:uppercase" class="form-control" disabled readonly><?php echo trim($lb->ft_note);?></textarea>
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
									<input type="text" class="form-control input-sm" id="fv_entrydate" name="fv_entrydate"  data-date-format="dd-mm-yyyy"  value="<?php if (empty($lb->fv_entrydate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($lb->fv_entrydate))); } ?>" READONLY>
								</div>
							</div>					

							<div class="form-group ">
								<label class="col-sm-4">NO SJ REFERENSI</label>	
								<div class="col-sm-8">    
									<input type="input" id="fv_reference" name="fv_reference"  value="<?php echo trim($lb->fv_reference);?>" style="text-transform:uppercase"  placeholder="Masukkan Surat Jalan Referensi" class="form-control" maxlength="15" READONLY >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL REFERENSI</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="fv_reftgl" name="fv_reftgl"  data-date-format="dd-mm-yyyy"  value="<?php if (empty($lb->fv_reftgl)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($lb->fv_reftgl))); } ?>" READONLY>
								</div>
							</div>	
							<?PHP /*<div class="form-group ">
								<label class="col-sm-4">NAMA EXPEDISI</label>	
								<div class="col-sm-8">    
									<input type="input" id="fc_expedisi" name="fc_expedisi"  value="<?php echo trim($lb->fc_expedisi);?>" placeholder="Nama Expedisi" class="form-control" READONLY >
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
									<input type="input" id="fc_nopol" name="fc_nopol"  value="<?php echo trim($lb->fc_nopol);?>" style="text-transform:uppercase"  placeholder="Isi Nomor Polisi Expedisi" class="form-control" READONLY >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA SUPIR</label>	
								<div class="col-sm-8">    
									<input type="input" id="fc_namedriver" name="fc_namedriver"  style="text-transform:uppercase"  value="<?php echo trim($lb->fc_namedriver);?>" placeholder="Isi Nama Supir Expedisi" class="form-control" READONLY >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NOMOR HP DRIVER</label>	
								<div class="col-sm-8">    
									<input type="input" id="fc_hpdriver" name="fc_hpdriver"  value="<?php echo trim($lb->fc_hpdriver);?>" style="text-transform:uppercase" placeholder="Isi Nama Contact Supir Expedisi" class="form-control" READONLY >
								</div>
							</div>
							<div class="form-group">
									<label class="col-sm-4">TIPE PENGIRIMAN</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm ch" name="fc_franco" id="fc_franco" disabled readonly>
									 <option value="">---PILIH TIPE PENGIRIMAN--</option>									  				  
									  <option   <?php if ('YES'==trim($lb->fc_franco)) { echo 'selected';}?>  value="<?php echo 'YES';?>" ><?php echo 'FRANCO';?></option>						  
									  <option   <?php if ('NO'==trim($lb->fc_franco)) { echo 'selected';}?>  value="<?php echo 'NO';?>" ><?php echo 'LOCO';?></option>						  
									</select>
									</div>
							</div>					
							<div class="form-group">	
								<!--label class="col-sm-4">FOTO SJ</label--->	
								<!--<?php $lp=$dtllamp_dp['file_name']; if ($lp<>'') { echo base_url('assets/attachment/fotoprofil/'.$lp);} else { echo base_url('assets/img/user.png');} ;?>--->
								<div class="col-sm-12">  							
									<!--p align="center"><input align="center" type="file" id="ft_image" name="ft_image" value="<?php $lp=trim($lb->ft_image); if ($lp<>'' or empty($lb)) { echo base_url('/assets/img/foto_sj/'.$lp);} else { } ;?>"> </p--->
									<!--p align="center"><input align="center" type="file" id="ft_image" name="ft_image" value="<?php echo base_url('/assets/img/foto_sj/'.$lp);?>"> </p-->
									<p align="center"><img src="<?php echo base_url('/assets/img/foto_sj/'.trim($lb->ft_image));?>" class='img-responsive'></p>
									
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


<?php foreach($list_tmp_T_INDTL_WEB as $lb) { ?>
<div class="modal fade" id="EDIT_INDTL<?php echo trim($lb->fc_trxno).trim($lb->fn_nomor); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
									<input type="input" id="fc_trxno" name="fc_trxno"  value="<?php echo trim($lb->fc_trxno);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="fn_nomor" name="fn_nomor"  value="<?php echo trim($lb->fn_nomor);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="fc_docno" name="fc_docno"  value="<?php echo trim($lb->fc_docno);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="EDINPUT_INDTL_WEB" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">KODE BARANG</label>	
								<div class="col-sm-8">    
									<input type="input" id="fc_stockcode" name="fc_stockcode"  value="<?php echo trim($lb->fc_stockcode);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA BARANG</label>	
								<div class="col-sm-8">    
									<input type="input" id="stockname" name="stockname"  value="<?php echo trim($lb->stockname);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">SATUAN</label>	
								<div class="col-sm-8">    
									<input type="input" id="packname" name="packname"  value="<?php echo trim($lb->packname);?>" placeholder="0" class="form-control" readonly >
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
									<input type="text" id="fn_qty" name="fn_qty"  value="<?php echo trim($lb->fn_qty);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>						
						</div>
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4">JUMLAH BARANG DIKIRIM</label>	
								<div class="col-sm-8">    
									<input type="text" id="fn_qtyrec" name="fn_qtyrec"  value="<?php echo trim($lb->fn_qtyrec);?>" placeholder="0" class="form-control" required>
								</div>
							</div>						
						</div>
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4">JUMLAH BARANG EXTRA</label>	
								<div class="col-sm-8">    
									<input type="text" id="fn_extra" name="fn_extra"  value="<?php echo trim($lb->fn_extra);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>						
						</div>
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4">JUMLAH BARANG EXTRA DIKIRIM</label>	
								<div class="col-sm-8">    
									<input type="text" id="fn_extrarec" name="fn_extrarec"  value="<?php echo trim($lb->fn_extrarec);?>" placeholder="0" class="form-control" required>
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

<?php foreach($list_tmp_T_INDTL_WEB as $lb) { ?>
<div class="modal fade" id="DETAIL_INDTL<?php echo trim($lb->fc_trxno).trim($lb->fn_nomor); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
									<input type="input" id="fc_trxno" name="fc_trxno"  value="<?php echo trim($lb->fc_trxno);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="DETAILINPUT_INDTL_WEB" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">KODE BARANG</label>	
								<div class="col-sm-8">    
									<input type="input" id="fc_stockcode" name="fc_stockcode"  value="<?php echo trim($lb->fc_stockcode);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NAMA BARANG</label>	
								<div class="col-sm-8">    
									<input type="input" id="stockname" name="stockname"  value="<?php echo trim($lb->stockname);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">SATUAN</label>	
								<div class="col-sm-8">    
									<input type="input" id="packname" name="packname"  value="<?php echo trim($lb->packname);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	

			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="form-horizontal">
						<div class="box-body">
						<div class="form-group ">
								<label class="col-sm-4">JUMLAH BARANG</label>	
								<div class="col-sm-8">    
									<input type="text" id="fn_qty" name="fn_qty"  value="<?php echo trim($lb->fn_qty);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>						
						</div>
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4">JUMLAH BARANG DIKIRIM</label>	
								<div class="col-sm-8">    
									<input type="text" id="fn_qtyrec" name="fn_qtyrec"  value="<?php echo trim($lb->fn_qtyrec);?>" placeholder="0" class="form-control" readonly>
								</div>
							</div>						
						</div>
					
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4">JUMLAH BARANG EXTRA</label>	
								<div class="col-sm-8">    
									<input type="text" id="fn_extra" name="fn_extra"  value="<?php echo trim($lb->fn_extra);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>						
						</div>
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4">JUMLAH BARANG EXTRA DIKIRIM</label>	
								<div class="col-sm-8">    
									<input type="text" id="fn_extrarec" name="fn_extrarec"  value="<?php echo trim($lb->fn_extrarec);?>" placeholder="0" class="form-control" readonly>
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

<?php /*							<div class="picedit_control_menu form-group"> 
								<div class="picedit_control_menu_container picedit_tooltip picedit_elm_2"> 
								<label>
									<span class="picedit_control picedit_action ico-picedit-checkmark" data-action="resize_image"></span>
									<span class="picedit_control picedit_action ico-picedit-close" data-action=""></span> 
								</label> 
								<label> <span>Width (px)</span> 
									<input type="text" class="picedit_input" data-variable="resize_width" value="400"> 
								</label> 
									<label class="picedit_nomargin"> <span class="picedit_control ico-picedit-link" data-action="toggle_button" data-variable="resize_proportions"></span> </label> 
									<label> <span>Height (px)</span>
									<input type="text" class="picedit_input" data-variable="resize_height" value="400">
									</label> 
								</div>
							</div> 
	*/ 
?>	
<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 	
		$('#ft_image').picEdit({
			maxWidth: 400,
			maxHeight: 400,
			redirectUrl:true,
			formSubmitted: function(response){
				$(location).attr('href','<?php echo site_url('intern/cr_sj/form_cr_sj');?>');
				//$(location).attr('href','<?php echo site_url('recruitment/calonkaryawan/index/rep_succes');?>');
			  }, 

//			  defaultImage: "<?php echo base_url('assets/img/foto_sj/'.'12a78db1d58c2e6538786efe3e9d29c2.jpeg'); ?>",
//			maxWidth: auto, 
//			maxHeight: auto
		});
		/*.change(function() {
				alert( "Handler for .change() called." );
				var _this = this;
					//perform resize begin
					var canvas = document.createElement('canvas');
					var ctx = canvas.getContext("2d");
					canvas.width = 300;
					canvas.height = 300;
					ctx.drawImage(_this._image, 0, 0, canvas.width, canvas.height);
					_this._create_image_with_datasrc(canvas.toDataURL("image/png"), function() {
						_this.hide_messagebox();
					});
		});	*/
		
</script>