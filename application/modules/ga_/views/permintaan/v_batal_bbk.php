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
<h5><b><strong><?php echo '  BATAL BBK :: '.TRIM($dtlnik['nmlengkap']);?></strong></b></h5>
<span id="postmessages"></span>
<?php echo $message;?>

<div class="row">
		<div class="col-sm-1">		
			<a href="<?php echo site_url("ga/permintaan/clear_tmp_bbk/$enc_nik")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
		</div>
		<!--div class="col-sm-1 pull-right">		
			<a href="<?php echo site_url("ga/permintaan/final_tmp_bbk/$enc_nodok")?>"  class="btn btn-primary" onclick="return confirm('Apakah Anda Simpan Data Ini??')" style="margin:0px; color:#ffffff;">SIMPAN </a>
		</div--->
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
									<?php $no=0; foreach($list_bbk_tmp_mst as $row): $no++;?>
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
									<a href="#" data-toggle="modal" data-target="#CANCEL<?php echo  str_replace('.','',trim($row->nodok)).trim($row->nodoktmp);?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> PROSES </a>
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
					<h5><b><strong><?php echo 'DETAIL BBK';?></strong></b></h5>
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
											<th>QTY BBK</th>
											<th>STATUS</th>
											<th>KETERANGAN</th>
											<!--th>AKSI</th--->
													
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_bbk_tmp_dtl as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodok;?></td>
									<td><?php echo $row->nodoktmp;?></td>
									<td><?php echo $row->stockcode;?></td>
									<td><?php echo $row->nmbarang;?></td>
									<td><?php echo $row->desc_barang;?></td>
									<td><?php echo $row->qtyonhand;?></td>
									<td><?php echo $row->cqtybbk;?></td>
									<td><?php echo $row->cqtybbk;?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td><?php echo $row->keterangan;?></td>
									<!--td width="15%">
																	
											<!--a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a
											<?php if (trim($row->status)=='A') { ?>
											<a href="#" data-toggle="modal" data-target="#APPRDTL<?php echo  str_replace('.','',trim($row->nodok)).trim($row->kdgroup).trim($row->kdsubgroup).trim($row->stockcode);?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i> APP DTL </a>
											<a href="#" data-toggle="modal" data-target="#REJAPPDTL<?php echo  str_replace('.','',trim($row->nodok)).trim($row->kdgroup).trim($row->kdsubgroup).trim($row->stockcode);?>" class="btn btn-warning  btn-sm"><i class="fa fa-edit"></i> REJ DTL </a>
											<?php } else if (trim($row->status)=='P' OR trim($row->status)=='C') { ?> 
											<a href="#" data-toggle="modal" data-target="#CAPPRDTL<?php echo  str_replace('.','',trim($row->nodok)).trim($row->kdgroup).trim($row->kdsubgroup).trim($row->stockcode);?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> RESET </a>
											<?php } else { echo ' ITEM REJECT ';}?> 
									</td>-->
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
<div class="modal fade" id="CANCEL<?php echo  str_replace('.','',trim($lb->nodok)).trim($lb->nodoktmp);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">BATAL BUKTI BARANG KELUAR</h4>
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
									<input type="hidden" id="type" name="type"  value="CANCELTRXMST" class="form-control" style="text-transform:uppercase">
									
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
									<input type="hidden" id="status" name="status"  value="<?php echo trim($lb->status);?>" class="form-control" style="text-transform:uppercase">																	
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DOKUMEN TMP</label>	
								<div class="col-sm-8">  
									<input type="text" id="nodoktmp" name="nodoktmp"  value="<?php echo trim($lb->nodoktmp);?>" class="form-control" style="text-transform:uppercase" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control"disabled><?php echo trim($lb->keterangan);?></textarea>
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <!--a href="<?php echo site_url('ga/permintaan/list_nikbbk');?>" type="button" class="btn btn-default"/> Kembali</a-->
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-danger">CANCEL</button>
      </div>
	  </form>
</div></div></div>
<?php } ?>


<?php foreach ($list_bbk_tmp_dtl as $lb) { ?>
<div class="modal fade" id="APPRDTL<?php echo  str_replace('.','',trim($lb->nodok)).trim($lb->kdgroup).trim($lb->kdsubgroup).trim($lb->stockcode);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM APPROVAL DETAIL BUKTI BARANG KELUAR</h4>
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
									<input type="hidden" id="type" name="type"  value="APPRDTLTRX" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="nodok" name="nodok"  value="<?php echo trim($row->nodok);?>" class="form-control" style="text-transform:uppercase">								
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
									<select class="form-control input-sm kdbarang " name="kdbarang" id="kdbarang"  readonly disabled>
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
									<input type="text" id="loccode" name="loccode"   value="<?php echo trim($lb->loccode);?>" class="form-control "  readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ON HAND</label>	
								<div class="col-sm-8">    
									<input type="number" id="onhand" name="onhand"  value="<?php echo trim($lb->qtyonhand);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Quantity Permintaan</label>	
								<div class="col-sm-8">    
									<input type="number" id="qtybbk" name="qtybbk"   placeholder="0" class="form-control"  value="<?php echo trim($lb->qtybbk);?>" readonly >
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
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control"disabled><?php echo trim($lb->keterangan);?></textarea>
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <!--a href="<?php echo site_url('ga/permintaan/list_nikbbk');?>" type="button" class="btn btn-default"/> Kembali</a-->
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-success">APPROVAL</button>
      </div>
	  </form>
</div></div></div>
<?php } ?>


<?php foreach ($list_bbk_tmp_dtl as $lb) { ?>
<div class="modal fade" id="REJAPPDTL<?php echo  str_replace('.','',trim($lb->nodok)).trim($lb->kdgroup).trim($lb->kdsubgroup).trim($lb->stockcode);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">REJECT DETAIL PERMINTAAN BARANG</h4>
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
									<input type="hidden" id="type" name="type"  value="REJAPPDTL" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="nodok" name="nodok"  value="<?php echo trim($row->nodok);?>" class="form-control" style="text-transform:uppercase">								
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
									<select class="form-control input-sm kdbarang " name="kdbarang" id="kdbarang"  readonly disabled>
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
									<input type="text" id="loccode" name="loccode"   value="<?php echo trim($lb->loccode);?>" class="form-control "  readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ON HAND</label>	
								<div class="col-sm-8">    
									<input type="number" id="onhand" name="onhand"  value="<?php echo trim($lb->qtyonhand);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Quantity Permintaan</label>	
								<div class="col-sm-8">    
									<input type="number" id="qtybbk" name="qtybbk"   placeholder="0" class="form-control"  value="<?php echo trim($lb->qtybbk);?>" readonly >
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
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control"disabled><?php echo trim($lb->keterangan);?></textarea>
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <!--a href="<?php echo site_url('ga/permintaan/list_nikbbk');?>" type="button" class="btn btn-default"/> Kembali</a-->
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-warning">REJECT</button>
      </div>
	  </form>
</div></div></div>
<?php } ?>


<?php foreach ($list_bbk_tmp_dtl as $lb) { ?>
<div class="modal fade" id="CAPPRDTL<?php echo  str_replace('.','',trim($lb->nodok)).trim($lb->kdgroup).trim($lb->kdsubgroup).trim($lb->stockcode);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM BATAL APPROVAL DETAIL PERMINTAAN BARANG</h4>
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
									<input type="hidden" id="type" name="type"  value="CAPPRDTL" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="nodok" name="nodok"  value="<?php echo trim($row->nodok);?>" class="form-control" style="text-transform:uppercase">								
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
									<select class="form-control input-sm kdbarang " name="kdbarang" id="kdbarang"  readonly disabled>
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
									<input type="text" id="loccode" name="loccode"   value="<?php echo trim($lb->loccode);?>" class="form-control "  readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">ON HAND</label>	
								<div class="col-sm-8">    
									<input type="number" id="onhand" name="onhand"  value="<?php echo trim($lb->qtyonhand);?>" placeholder="0" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Quantity Permintaan</label>	
								<div class="col-sm-8">    
									<input type="number" id="qtybbk" name="qtybbk"   placeholder="0" class="form-control"  value="<?php echo trim($lb->qtybbk);?>" readonly >
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
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control"disabled><?php echo trim($lb->keterangan);?></textarea>
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <!--a href="<?php echo site_url('ga/permintaan/list_nikbbk');?>" type="button" class="btn btn-default"/> Kembali</a-->
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-danger">RESET</button>
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
	  