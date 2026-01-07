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
				$("#kdbarang").chained("#kdsubgroup");
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
<h5><b><strong><?php echo '  INPUT BBM PENGAJUAN BBM BARANG MASUK ';?></strong></b></h5>
<?php echo $message;?>

<div class="row">
		<div class="col-sm-12">		
			<!--a href="<?php echo site_url("ga/permintaan/clear_tmp_bbm/$enc_nodok")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a-->
			<a href="<?php echo site_url("ga/permintaan/form_bbm")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
		</div>
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header"  align="center">
					<h5><b><strong><?php echo 'MASTER BUKTI BARANG MASUK';?></strong></b></h5>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>NODOK</th>
											<th>REF DOKUMEN PO</th>
											<th>DOKUMEN TYPE</th>
											<th>LOCCODE</th>
											<th>TOTAL BRUTTO</th>
											<th>TOTAL NETTO</th>
											<th>STATUS</th>
											<th>KETERANGAN</th>
											<th>ACTION</th>
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_bbm_trx_mst as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodok;?></td>
									<td><?php echo $row->nodokref;?></td>
									<td><?php echo $row->nodoktype;?></td>
									<td><?php echo $row->loccode;?></td>
									<td align="right"><?php echo number_format($row->ttlbrutto, 2);?></td>
									<td align="right"><?php echo number_format($row->ttlnetto, 2);?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td>
									<a href="#" data-toggle="modal" data-target="#INPUTTRX<?php echo str_replace('.','',trim($row->nodok)).trim($row->nodokref);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>
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
					<h5><b><strong><?php echo 'DETAIL BUKTI BARANG MASUK';?></strong></b></h5>
					<!--a href="<?php echo site_url("ga/permintaan/cancel_tmp_bbk_dtl/$enc_nodok")?>"  class="btn btn-danger pull-right" onclick="return confirm('Reset info Qty BBK Data Ini??')" style="margin:0px; color:#ffffff;">CANCEL</a--->
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example2" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>NODOK REF</th>
											<th>NAMA BARANG</th>
											<th>LOCCODE</th>
											<th>QTYMINTA</th>
											<th>SATMINTA</th>
											<th>QTYBBM</th>
											<th>SATBBM</th>
											<th>STATUS</th>
											<th>AKSI</th>		
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_bbm_trx_dtl as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodokref;?></td>
									<td><?php echo $row->nmbarang;?></td>
									<td><?php echo $row->loccode;?></td>
									<td><?php echo $row->qtyrec;?></td>
									<td><?php echo $row->nmsatminta;?></td>
									<td><?php echo $row->qtybbm;?></td>
									<td><?php echo $row->nmsatminta;?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td width="10%">
											<!--a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a-->
											<a href="#" data-toggle="modal" data-target="#DTL<?php echo str_replace('.','',trim($row->nodok)).trim($row->kdgroup).trim($row->kdsubgroup).trim($row->stockcode).trim($row->id);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>	

									</td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>		
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
			
			<div class="col-xs-12"> 
				<div class="box">
					<div class="box-header"  align="center">
					<h5><b><strong><?php echo 'DETAIL REVERENSI BARANG MASUK';?></strong></b></h5>
					<!--a href="<?php echo site_url("ga/permintaan/cancel_tmp_bbm_dtl/$enc_nodok")?>"  class="btn btn-danger pull-right" onclick="return confirm('Reset info Qty BBK Data Ini??')" style="margin:0px; color:#ffffff;">RESET</a--->
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example2" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>NODOK REF</th>
											<th>FROM REF</th>
											<th>NAMA BARANG</th>
											<th>LOCCODE</th>
											<th>QTYMINTA</th>
											<th>SATMINTA</th>
											<th>QTYBBM</th>
											<th>SATBBM</th>
											<th>STATUS</th>
											<th>AKSI</th>		
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_bbm_trx_dtlref as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodokref;?></td>
									<td><?php echo $row->fromcode;?></td>
									<td><?php echo $row->nmbarang;?></td>
									<td><?php echo $row->loccode;?></td>
									<td><?php echo $row->qtyrec;?></td>
									<td><?php echo $row->nmsatminta;?></td>
									<td><?php echo $row->qtybbm;?></td>
									<td><?php echo $row->nmsatminta;?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td width="10%">
										<a href="#" data-toggle="modal" data-target="#EDDTLREF<?php echo str_replace('.','',trim($row->nodok)).trim($row->kdgroup).trim($row->kdsubgroup).trim($row->stockcode);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> Detail </a>	
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
	
<?php foreach ($list_bbm_trx_mst as $lb) { ?>
<div class="modal fade" id="INPUTTRX<?php echo str_replace('.','',trim($lb->nodok)).trim($row->nodokref);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">MASTER BUKTI BARANG MASUK</h4>
	  </div>
<form action="<?php echo site_url('ga/permintaan/save_bbm')?>" method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-4">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group ">
								<label class="col-sm-4">DOKUMEN</label>	
								<div class="col-sm-8">    
									<input type="text" id="nodok" name="nodok"  value="<?php echo trim($lb->nodok);?>" class="form-control" style="text-transform:uppercase" readonly>								
									<input type="hidden" id="type" name="type"  value="EDITFINALBBM" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">NODOK PBK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nodokref" name="nodokref"  value="<?php echo trim($lb->nodokref);?>" class="form-control" style="text-transform:uppercase" readonly>								
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL PENGAJUAN</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="inputdate" name="inputdate"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($lb->inputdate)));?> readonly>
								</div>
							</div>
						
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
			<div class="col-sm-8">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<?php if ($nodoktype!='AJS') { ?>						
							<div class="form-group ">
								<label class="col-sm-4">STATUS PKP</label>	
								<div class="col-sm-8">    
									<input type="text" id="pkp" name="pkp"   value="<?php echo trim($lb->pkp);?>" class="form-control "  readonly >
								</div>
							</div>
								<div class="form-group row">
								<label class="col-sm-4">Harga Total Brutto(Rp)</label>	
								<div class="col-sm-4"> 
									<input type="input"  id="ttlbrutto" name="ttlbrutto"  value="<?php echo trim($lb->ttlbrutto);?>"  onkeyup="formatangkaobjek(this)" placeholder="0" class="form-control ratakanan" readonly>
								</div>
								<!--span class="col-sm-4"> 
									<label class="col-sm-4">DISKON (%)</label>
									<span class="col-sm-6"> 
									<select class="form-control col-sm-12"  id="checkdiskon">
									 <option  value="NO"> NO  </option> 
									 <option  value="YES">  YES  </option> 
									</select>
									</span>
								</span--->		

								<!--span  class="col-sm-3"> 
									<label class="col-sm-2">DISKON</label>
									<span class="col-sm-4"> 
									<input type="checkbox" name="checkdiskon" class="col-sm-1" value="" >
									</span>
								</span--->
							</div>
							<!--div class="form-group row diskonform">
								<label class="col-sm-4">DISKON</label>
								<span class="col-sm-2"> 
									<label class="col-sm-2">1+</label>
									<input type="input" id="disc1" value="<?php echo trim($po_mst['disc1']);?>" name="disc1" placeholder="0" value="0" class="form-control col-sm-1 ratakanan" >
								</span>	                                                                                          
								<span class="col-sm-2">                                                                           
									<label class="col-sm-4">2+</label>                                                
									<input type="input" id="disc2"  value="<?php echo trim($po_mst['disc2']);?>" name="disc2" placeholder="0" value="0" class="form-control col-sm-1 ratakanan" >
								</span>	                                                                                           
								<span class="col-sm-2">                                                                            
									<label class="col-sm-4">3+</label>                                                 
									<input type="input" id="disc3" value="<?php echo trim($po_mst['disc3']);?>" name="disc3" placeholder="0" value="0" class="form-control col-sm-1 ratakanan" >
								</span>									
							</div---->
							<div class="form-group row">
								<label class="col-sm-4">Sub Total DPP (Rp)</label>	
								<div class="col-sm-4">    
									<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
									<input type="input" id="ttldpp" name="ttldpp" value="<?php echo trim($lb->ttldpp);?>"  placeholder="0" class="form-control ratakanan" readonly >
								</div>	
								<span class="col-sm-4"> 	
									<label class="col-sm-4">PPN</label>
									<span class="col-sm-12"> 
										<input type="input" id="checkppn" name="checkppn" value="<?php echo trim($lb->pkp);?>"  class="form-control col-sm-12" readonly >
									</span>
								</span>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Sub Total PPN (Rp)</label>	
								<div class="col-sm-4">    
									<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
									<input type="input" id="ttlppn" name="ttlppn"  value="<?php echo trim($lb->ttlppn);?>"  placeholder="0" class="form-control ratakanan" readonly >
								</div>
								<span class="col-sm-4"> 	
									<label class="col-sm-4">INCLUDE/EXCLUDE</label>
									<span class="col-sm-12"> 
									<select class="form-control col-sm-12"  name="exppn" id="checkexppn" readonly disabled>
									 <option  <?php if ('INC'==trim($lb->exppn)) { echo 'selected';}?> value="INC"> INCLUDE </option> 
									 <option  <?php if ('EXC'==trim($lb->exppn)) { echo 'selected';}?>  value="EXC"> EXCLUDE </option> 
									</select>
									</span>
								</span>								
							</div>
							<div class="form-group">
								<label class="col-sm-4">Sub Total Netto (Rp)</label>	
								<div class="col-sm-4">    
									<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
									<input type="input" id="ttlnetto" name="ttlnetto"  value="<?php echo trim($lb->ttlnetto);?>"  placeholder="0" class="form-control ratakanan" readonly >
								</div>							
							</div>
							<?php } else { ?>
								<div class="form-group ">
									<label class="col-sm-4">DOKUMEN NO</label>	
									<div class="col-sm-8">    
										<input type="text" id="nodokfrom" name="nodokfrom"   value="<?php echo trim($lb->nodokfrom);?>" class="form-control " disabled readonly >
									</div>
								</div>	
							<?php } ?>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control"  disabled readonly><?php echo trim($lb->keterangan);?></textarea>
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
        <!--button type="submit" id="submit"  class="btn btn-primary">UBAH DATA</button--->
      </div>
	  </form>
</div></div></div>
<?php } ?>


<?php foreach ($list_bbm_trx_dtl as $lb) { ?>
<div class="modal fade" id="DTL<?php echo str_replace('.','',trim($lb->nodok)).trim($lb->kdgroup).trim($lb->kdsubgroup).trim($lb->stockcode).trim($lb->id);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM DETAIL BUKTI BARANG MASUK</h4>
	  </div>
<form action="<?php echo site_url('ga/permintaan/save_bbm')?>" method="post">
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
									<input type="hidden" id="id" name="id"  value="<?php echo trim($lb->id);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="EDTMPDTLREFBBM" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">DOKUMEN REFERENSI</label>	
								<div class="col-sm-8">    
									<input type="input" id="nodokref" name="nodokref"  value="<?php echo trim($lb->nodokref);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">LOKASI KODE</label>	
								<div class="col-sm-8">    
									<input type="input" id="loccode" name="loccode"  value="<?php echo trim($lb->loccode);?>" placeholder="0" class="form-control" readonly >
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
								<label class="col-sm-4">QTY PO KECIL</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtyreckecil" name="qtyreckecil"  value="<?php echo trim($lb->qtyreckecil);?>" placeholder="0" class="form-control" readonly >
								</div>
								<div class="col-sm-4">    
									<input type="hidden" value="<?php echo trim($lb->nmsatkecil);?>" class="form-control" readonly >
									<input type="input" value="<?php echo trim($lb->nmsatkecil);?>" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY PO MINTA</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtyrec" name="qtyrec"  value="<?php echo trim($lb->qtyrec);?>" placeholder="0" class="form-control" readonly >
								</div>
								<div class="col-sm-4">  
									<input type="hidden" value="<?php echo trim($lb->satminta);?>" class="form-control" readonly >								
									<input type="input" value="<?php echo trim($lb->nmsatminta);?>" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY TERIMA KECIL</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtybbmkecil" name="qtybbmkecil"  value="<?php echo trim($lb->qtybbmkecil);?>" placeholder="0" class="form-control" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" value="<?php echo trim($lb->satminta);?>" class="form-control" readonly >								
									<input type="input" value="<?php echo trim($lb->nmsatminta);?>" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY TERIMA</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtybbm" name="qtybbm"  value="<?php echo trim($lb->qtybbm);?>" placeholder="0" class="form-control" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil' value="<?php echo trim($lb->satminta);?>" class="form-control" readonly >								
									<input type="input" name='nmsatminta' value="<?php echo trim($lb->nmsatminta);?>" class="form-control" readonly >
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
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control" readonly disabled><?php echo trim($lb->keterangan);?></textarea>
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
        <?php /*<button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>*/ ?>
      </div>
	  </form>
</div></div></div>
<?php } ?>





	
<?php foreach ($list_bbm_trx_dtlref as $lb) { ?>
<div class="modal fade" id="EDDTLREF<?php echo str_replace('.','',trim($lb->nodok)).trim($lb->kdgroup).trim($lb->kdsubgroup).trim($lb->stockcode);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM INPUT BUKTI BARANG MASUK</h4>
	  </div>
<form action="<?php echo site_url('ga/permintaan/save_bbm')?>" method="post">
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
									<input type="hidden" id="nodoktmp" name="nodoktmp"  value="<?php echo trim($lb->nodoktmp);?>" class="form-control" readonly >
									<input type="hidden" id="id" name="id"  value="<?php echo trim($lb->id);?>" placeholder="0" class="form-control" readonly >
									<input type="hidden" id="type" name="type"  value="EDTRXDTLREFBBM" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">DOKUMEN REFERENSI</label>	
								<div class="col-sm-8">    
									<input type="input" id="nodokref" name="nodokref"  value="<?php echo trim($lb->nodokref);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">REFERENSI DETAIL</label>	
								<div class="col-sm-8">    
									<input type="input" id="fromcode" name="fromcode"  value="<?php echo trim($lb->fromcode);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">LOKASI KODE</label>	
								<div class="col-sm-8">    
									<input type="input" id="loccode" name="loccode"  value="<?php echo trim($lb->loccode);?>" placeholder="0" class="form-control" readonly >
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
								<label class="col-sm-4">QTY PO KECIL</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtyreckecil" name="qtyreckecil"  value="<?php echo trim($lb->qtyreckecil);?>" placeholder="0" class="form-control" readonly >
								</div>
								<div class="col-sm-4">    
									<input type="hidden" value="<?php echo trim($lb->nmsatkecil);?>" class="form-control" readonly >
									<input type="input" value="<?php echo trim($lb->nmsatkecil);?>" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY PO MINTA</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtyrec" name="qtyrec"  value="<?php echo trim($lb->qtyrec);?>" placeholder="0" class="form-control" readonly >
								</div>
								<div class="col-sm-4">  
									<input type="hidden" value="<?php echo trim($lb->satminta);?>" class="form-control" readonly >								
									<input type="input" value="<?php echo trim($lb->nmsatminta);?>" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY TERIMA KECIL</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtybbmkecil" name="qtybbmkecil"  value="<?php echo trim($lb->qtybbmkecil);?>" placeholder="0" class="form-control" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" value="<?php echo trim($lb->satminta);?>" class="form-control" readonly >								
									<input type="input" value="<?php echo trim($lb->nmsatminta);?>" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">QTY TERIMA</label>	
								<div class="col-sm-4">    
									<input type="number" id="qtybbm" name="qtybbm"  value="<?php echo trim($lb->qtybbm);?>" placeholder="0" class="form-control" readonly>
								</div>
								<div class="col-sm-4">  
									<input type="hidden" name='satkecil' value="<?php echo trim($lb->satminta);?>" class="form-control" readonly >								
									<input type="input" name='nmsatminta' value="<?php echo trim($lb->nmsatminta);?>" class="form-control" readonly >
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
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control" disabled readonly><?php echo trim($lb->keterangan);?></textarea>
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
        <!--button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button------>
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
	  