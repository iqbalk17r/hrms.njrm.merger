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
								url : "<?php echo site_url('ga/pembelian/js_viewstock')?>/" + param1,
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
					//////////////////////////////////////////////
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
					
			});
</script>

<legend><?php echo $title;?></legend>
<span id="postmessages"></span>

<form action="<?php echo site_url('ga/pembelian/save_po')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<input type="hidden" id="type" name="type" class="form-control" value="INPUT"></input>						
							<div class="form-group">
								<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm" name="kdgroup" id="kdgroup" required>
									 <option value="">---PILIH KODE GROUP--</option> 
									  <?php foreach($list_scgroup as $sc){?>					  
									  <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
									  <?php }?>
									</select>
									</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm " name="kdsubgroup" id="kdsubgroup" required>
									 <option  value="">---PILIH KODE SUB GROUP--</option> 
									  <?php foreach($list_scsubgroup as $sc){?>					  
									  <option value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4" for="inputsm">Kode Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm kdbarang" name="kdbarang" id="kdbarang" required>
									 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
									  <?php foreach($list_stkgdw as $sc){?>					  
									  <option value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4" for="inputsm">Satuan QTY</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm " name="qtyunit" id="qtyunit" required>
									 <option  value="">---PILIH KDSATUAN || NAMA SATUAN--</option> 
									  <?php foreach($trxqtyunit as $sc){?>					  
									  <option value="<?php echo trim($sc->kdtrx);?>"><?php echo trim($sc->kdtrx).' || '.trim($sc->uraian);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">LOKASI GUDANG</label>	
								<div class="col-sm-8">    
									<input type="text" id="loccode" name="loccode"   class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Deskripsi Barang</label>	
								<div class="col-sm-8">    
									<input type="text" id="desc_barang" name="desc_barang"   style="text-transform:uppercase" class="form-control" required >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Harga Per QTY</label>	
								<div class="col-sm-8">    
									<input type="number" id="qtyunitprice" name="qtyunitprice"   placeholder="0" class="form-control" required >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Quantity Permintaan</label>	
								<div class="col-sm-8">    
									<input type="number" id="qtypo" name="qtypo"   placeholder="0" class="form-control" required >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total Harga/Sub Total</label>	
								<div class="col-sm-8">    
									<input type="number" id="qtytotalprice" name="qtytotalprice"   placeholder="0" class="form-control" readonly >
								</div>
							</div>
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>
<script type="text/javascript">
            $(function() {
				$("#kdsupplier").chained("#kdgroupsupplier");
				$("#kdsubsupplier").chained("#kdsupplier");
				
			});
</script>			
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-4" for="inputsm">MASTER GROUP SUPPLIER</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm " name="kdgroupsupplier" id="kdgroupsupplier" required>
									 <option  value="">---PILIH KDGROUP || NAMA GROUP--</option> 
									  <?php foreach($trxsupplier as $sc){?>					  
									  <option value="<?php echo trim($sc->kdtrx);?>"><?php echo trim($sc->kdtrx).' || '.trim($sc->uraian);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>						
							<div class="form-group">
								<label class="col-sm-4" for="inputsm">MASTER SUPPLIER</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm " name="kdsupplier" id="kdsupplier" required>
									 <option  value="">---PILIH KDSUPPLIER || NAMA SUPPLIER--</option> 
									  <?php foreach($list_msupplier as $sc){?>					  
									  <option value="<?php echo trim($sc->kdsupplier);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsupplier).' || '.trim($sc->nmsupplier);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4" for="inputsm">CABANG SUPPLIER</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm " name="kdsubsupplier" id="kdsubsupplier" required>
									 <option  value="">---PILIH KDSUPPLIER || NAMA CABANG SUPPLIER--</option> 
									  <?php foreach($list_msubsupplier as $sc){?>					  
									  <option value="<?php echo trim($sc->kdsubsupplier);?>"  class="<?php echo trim($sc->kdsupplier);?>" ><?php echo trim($sc->kdsubsupplier).' || '.trim($sc->nmsubsupplier);?></option>						  
									  <?php }?>
									</select>
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
        <a href="<?php echo site_url('ga/pembelian/form_pembelian');?>" type="button" class="btn btn-default"/> Kembali</a>
        <button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
</form>