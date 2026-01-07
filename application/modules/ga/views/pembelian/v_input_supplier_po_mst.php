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
				$("#podate").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
				$("#kdsupplier").chained("#kdgroupsupplier");
				$("#kdsubsupplier").chained("#kdsupplier");

				$('.ch').change(function () {
					var param1 = $('#kdgroupsupplier').val().trim();
					var param2 = $('#kdsupplier').val().trim();
					var param3 = $('#kdsubsupplier').val().trim();
					console.log(param1 + param2 + param3);
					if ((param1 != '') && (param2 != '') && (param3 != '')) {
						$.ajax({
							url: "<?php echo site_url('ga/pembelian/js_supplier') ?>" + '/' + param1 + '/' + param2 + '/' + param3,
							type: "GET",
							dataType: "JSON",
							success: function (data) {
								$('[name="kdcabangsupplier"]').val(data.kdcabang);
								$('[name="pkp"]').val(data.pkp);
								$('[name="checkppn"]').val(data.pkp);
							},
							error: function (jqXHR, textStatus, errorThrown) {
								alert('Error get data from ajax');
							}
						});
					};
				});
				
				$('#ttlbrutto').keyup(function(){
				//$('#ttlbrutto').ready(function(){
						
						if ($(this).val()=='') {	var param1 = parseInt(0);
							$('#satminta').prop('disabled', false); 
							$('#checkdiskon').prop('disabled', false);
							$('#checkppn').prop('disabled', false);
							$('#checkexppn,#disc1,#disc2,#disc3').prop('disabled', false);
						} else { var param1 = parseInt($(this).val().replace(/\./g,''));
							$('#satminta').prop('disabled', true);
							$('#checkdiskon').prop('disabled', true);
							$('#checkppn').prop('disabled', true);
							$('#checkexppn,#disc1,#disc2,#disc3').prop('disabled', true);
						}
						if ($('#qtyminta').val()=='') {	var param2 = parseInt(0); } else { var param2 = parseInt($('#qtyminta').val().replace(/\./g,'')); }
						
						var paramcheckdiskon = $('#checkdiskon').val();
						var paramcheckppn = $('#checkppn').val();
						var paramcheckexppn = $('#checkexppn').val();
						var paramdisc1 = parseInt($('#disc1').val().trim());
						var paramdisc2 = parseInt($('#disc2').val().trim());
						var paramdisc3 = parseInt($('#disc3').val().trim());
						///console.log(param1);
						var subtotal = param1 * param2;
						
						
						//console.log(paramcheckdiskon=='YES');
						if(paramcheckdiskon=='YES'){
							var totaldiskon=Math.round((param1*(paramdisc1/100))+((param1*(paramdisc1/100))*(paramdisc2/100))+(((param1*(paramdisc1/100))*(paramdisc2/100))*(paramdisc3/100)));
						} else {
							var totaldiskon=Math.round((param1*(0/100))+(param1*(0/100))+(param1*(0/100)));
						}
							
						if(paramcheckppn=='YES'){
							if(paramcheckexppn=='EXC'){
								var totaldpp=Math.round((param1-totaldiskon)/1.1);
								var totalppn=Math.round(((param1-totaldiskon)/1.1)*(10/100));
								var vattlnetto=totaldpp+totalppn;
							} else if (paramcheckexppn=='INC') {
								var totaldpp=Math.round((param1-totaldiskon)/1.1);;
								var totalppn=Math.round(((param1-totaldiskon)/1.1)*(10/100));
								var vattlnetto=(param1-totaldiskon);
							}
								
						} else if (paramcheckppn=='NO') {
								var totaldpp=0;
								var totalppn=0;
								var vattlnetto=(param1-totaldiskon);
						}
					


					var test = formatangkavalue(subtotal);
						
						
						console.log(totaldpp);
						console.log(totalppn);
						
						
						$('#ttldpp').val(formatangkavalue(totaldpp));   
						$('#ttlppn').val(formatangkavalue(totalppn));   
						$('#ttlnetto').val(formatangkavalue(vattlnetto));   
						  
					//	$('#ttlbruttoview').val(test);
					//	var subtotal = formatangka(subtotalv);
					//	console.log(subtotal);
					//	console.log(test);
					//	console.log($('#satminta').val());
						$('[name="satminta"]').val($('#satminta').val());
					///alert($('#ttlbrutto'));
					});

				$('.diskonform').hide();
				$('#checkdiskon').change(function(){
					console.log($(this).val().trim()=="YES");
					
					if($(this).val().trim()=="YES"){
						$('.diskonform').show();
					} else {
						$('.diskonform').hide();
					}
					
				}); 	
			});
			
			

			
				// memformat angka ribuan
function formatangkaobjek(objek) {
   a = objek.value.toString();
 //  alert(a);
 //  alert(objek);
   b = a.replace(/[^\d]/g,"");
   c = "";
   panjang = b.length;
   j = 0;
   for (i = panjang; i > 0; i--) {
     j = j + 1;
     if (((j % 3) == 1) && (j != 1)) {
       c = b.substr(i-1,1) + "." + c;
     } else {
       c = b.substr(i-1,1) + c;
     }
   }
   objek.value = c;
}	

function formatangkavalue(objek) {
   a = objek.toString();
 //  alert(a);
  // alert(objek);
   b = a.replace(/[^\d]/g,"");
   c = "";
   panjang = b.length;
   j = 0;
   for (i = panjang; i > 0; i--) {
     j = j + 1;
     if (((j % 3) == 1) && (j != 1)) {
       c = b.substr(i-1,1) + "." + c;
     } else {
       c = b.substr(i-1,1) + c;
     }
   }
  objek = c;
 ///  alert(objek);
  return objek;
 
}
			
</script>

<legend><?php echo $title;?></legend>
<span id="postmessages"></span>

<div class="box">
	<div class="box-content">
	  <div class="box-header">
		<h4 class="box-title" id="myModalLabel">INPUT/EDIT SUPPLIER PEMBELIAN BARANG</h4>
	  </div>
<form action="<?php echo site_url('ga/pembelian/save_po')?>" method="post" name="inputformPbk">
<div class="box-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group">
								<label class="col-sm-4">NO DOKUMEN</label>	
								<div class="col-sm-8"> 
									<?php if(trim($po_mst['status'])=='I') { ?>
									<input type="hidden" id="type" name="type"  value="ADD_SUPPLIER_MST" class="form-control" style="text-transform:uppercase">								
									<?php } else if (trim($po_mst['status'])=='E') { ?>	
									<input type="hidden" id="type" name="type"  value="EDIT_SUPPLIER_MST" class="form-control" style="text-transform:uppercase">								
									<?php } ?>
									<input type="text" id="nodok" name="nodok"  value="<?php echo trim($po_mst['nodok']);?>" class="form-control" style="text-transform:uppercase" readonly>
								</div>
							</div>
							<div class="form-group drst">
								<label class="col-sm-4" for="inputsm">Tanggal PO</label>	
									<div class="col-sm-8">  
										<input type="text" id="podate" name="podate"  value=<?php echo date('d-m-Y', strtotime(trim ($po_mst['podate'])));?> class="form-control" style="text-transform:uppercase"  data-date-format="dd-mm-yyyy" required>								
									</div>
							</div>
							<div class="form-group drst">
								<label class="col-sm-4" for="inputsm">Kode Kategori Supplier</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm ch" name="kdgroupsupplier" id="kdgroupsupplier" required>
									 <option value="">---PILIH KODE KATEGORI SUPPLIER--</option> 
									  <?php foreach($trxsupplier as $sc){?>					  
									  <option   <?php if (trim($sc->kdtrx)==trim($po_mst['kdgroupsupplier'])) { echo 'selected';}?>  value="<?php echo trim($sc->kdtrx);?>" ><?php echo trim($sc->kdtrx).' || '.trim($sc->uraian);?></option>						  
									  <?php }?>
									</select>
									</div>
							</div>
							<div class="form-group drst">
								<label class="col-sm-4" for="inputsm">Kode Supplier</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm ch" name="kdsupplier" id="kdsupplier" required>
									 <option value="">---PILIH KODE SUPPLIER || NAMA SUPPLIER--</option> 
									  <?php foreach($list_msupplier as $sc){?>					  
									  <option   <?php if (trim($sc->kdsupplier)==trim($po_mst['kdsupplier'])) { echo 'selected';}?>  value="<?php echo trim($sc->kdsupplier);?>"  class="<?php echo trim($sc->kdgroup);?>"  ><?php echo trim($sc->kdsupplier).' || '.trim($sc->nmsupplier);?></option>						  
									  <?php }?>
									</select>
									</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">Kode Sub Supplier</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm ch" name="kdsubsupplier" id="kdsubsupplier"  required>
									 <option  value="">---PILIH KODE SUB GROUP SUPPLIER--</option> 
									  <?php foreach($list_msubsupplier as $sc){?>					  
									  <option  <?php if (trim($sc->kdsubsupplier)==trim($po_mst['kdsubsupplier'])) { echo 'selected';}?>  value="<?php echo trim($sc->kdsubsupplier);?>"  class="<?php echo trim($sc->kdsupplier);?>" ><?php echo trim($sc->kdsubsupplier).' || '.trim($sc->nmsubsupplier);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">LOKASI CABANG SUPPLIER</label>	
								<div class="col-sm-8">    
									<input type="text" id="kdcabangsupplier" name="kdcabangsupplier"   value="<?php echo trim($po_mst['kdcabangsupplier']);?>" class="form-control "  readonly >
								</div>
							</div>
							<div class="form-group ">
								<label class="col-sm-4">STATUS PKP</label>	
								<div class="col-sm-8">    
									<input type="text" id="pkp" name="pkp"   value="<?php echo trim($po_mst['pkp']);?>" class="form-control "  readonly >
								</div>
							</div>
								<div class="form-group row">
								<label class="col-sm-4">Harga Total Brutto(Rp)</label>	
								<div class="col-sm-4"> 
									<input type="input"  id="ttlbrutto" name="ttlbrutto"  value="<?php echo trim($po_mst['ttlbrutto']);?>"  onkeyup="formatangkaobjek(this)" placeholder="0" class="form-control ratakanan" readonly>
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
									<input type="input" id="ttldpp" name="ttldpp" value="<?php echo trim($po_mst['ttldpp']);?>"  placeholder="0" class="form-control ratakanan" readonly >
								</div>	
								<span class="col-sm-4"> 	
									<label class="col-sm-4">PPN</label>
									<span class="col-sm-6"> 
										<input type="input" id="checkppn" name="checkppn" value="<?php echo trim($po_mst['pkp']);?>"  class="form-control col-sm-12" readonly >
									</span>
								</span>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Sub Total PPN (Rp)</label>	
								<div class="col-sm-4">    
									<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
									<input type="input" id="ttlppn" name="ttlppn"  value="<?php echo trim($po_mst['ttlppn']);?>"  placeholder="0" class="form-control ratakanan" readonly >
								</div>
								<span class="col-sm-4"> 	
									<label class="col-sm-4">INCLUDE/EXCLUDE</label>
									<span class="col-sm-6"> 
									<select class="form-control col-sm-12"  name="exppn" id="checkexppn">
									 <option  <?php if ('INC'==trim($po_mst['exppn'])) { echo 'selected';}?> value="INC"> INCLUDE </option> 
									 <option  <?php if ('EXC'==trim($po_mst['exppn'])) { echo 'selected';}?>  value="EXC"> EXCLUDE </option> 
									</select>
									</span>
								</span>								
							</div>
							<div class="form-group">
								<label class="col-sm-4">Sub Total Netto (Rp)</label>	
								<div class="col-sm-4">    
									<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
									<input type="input" id="ttlnetto" name="ttlnetto"  value="<?php echo trim($po_mst['ttlnetto']);?>"  placeholder="0" class="form-control ratakanan" readonly >
								</div>							
							</div>
							<div class="form-group ">
								<label class="col-sm-4">JATUH TEMPO</label>	
								<div class="col-sm-2">    
									<input type="text" id="payterm" name="payterm"   value="<?php echo trim($po_mst['payterm']);?>" class="form-control "  required >
								</div>
								<span class="col-sm-2"> 	
									<label class="col-sm-4">DAYS/HARI</label>
								</span>	
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo trim($po_mst['keterangan']);?></textarea>
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="box-footer">
	  	<?php if(trim($po_mst['status'])=='I') { ?>
			<a href="<?php echo site_url('ga/pembelian/input_po');?>" type="button" class="btn btn-default"/> Kembali</a>
		<?php } else if (trim($po_mst['status'])=='E') { ?>	
			<a href="<?php $enc_nodoktmp=bin2hex($this->encrypt->encode(trim($po_mst['nodoktmp'])));
			echo site_url("ga/pembelian/edit_po_atk/$enc_nodoktmp");?>" type="button" class="btn btn-default"/> Kembali</a>
		<?php } ?>
  
		<!--button type="button" class="btn btn-default" data-dismiss="box">Close</button--->
        <button type="submit" id="submit"  class="btn btn-primary pull-right">SIMPAN</button>
      </div>
	  </form>
</div></div>



