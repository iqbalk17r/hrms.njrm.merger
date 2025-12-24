<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				$("#kdsubgroup").chained("#kdgroup");
				$("#kdbarang").chained("#kdsubgroup");
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
				$('.drst').show();
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
			
            });
					
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>
<?php echo $message;?>

<div class="row">
	<!--div class="col-sm-12">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Schema Barang & Asset</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>

	</div--->
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#inputModal"  href="#">Input Supplier</a></li--> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/pembelian/list_niksppb")?>">Buat Permintaan PEMBELIAN</a></li>
				  <!--li role="presentation" class="divider"></li>	
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Haduh Us</a></li---> 
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
</div>	
</br>
<div class="row">
<div class="col-sm-12">
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">					
		<li class="active"><a href="#tab_1" data-toggle="tab">FORM PERMINTAAN PEMBELIAN BARANG</a></li>
		<!--li><a href="#tab_2" data-toggle="tab">Schema Barang & Asset2</a></li-->	
	</ul>
</div>	
<div class="tab-content">
	<div class="chart tab-pane active" id="tab_1" style="position: relative; height: 300px;" >
		
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>NODOK</th>
											<th>NIK</th>
											<th>NAMA LENGKAP</th>
											<th>STATUS</th>
											<th>KETERANGAN</th>
											<th>AKSI</th>		
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_sppb as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodok;?></td>
									<td><?php echo $row->nik;?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->ketstatus;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td width="15%">

										<a href="<?php 
										$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
										echo site_url("ga/pembelian/detail_sppb/$enc_nodok");?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a>
										<?php if (trim($row->status)=='A') { ?>
										<a href="<?php 
										$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
										echo site_url("ga/pembelian/edit_sppb/$enc_nodok");?>" class="btn btn-primary  btn-sm"><i class="fa fa-edit"></i> EDIT </a>
										<?php if (trim($nama)==trim($row->nik_atasan) or $userhr>0 or trim($nama)==trim($row->nik_atasan2) ) { ?>
										<a href="<?php 
											$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
											echo site_url("ga/pembelian/approval_sppb/$enc_nodok");?>" class="btn btn-success  btn-sm"><i class="fa fa-edit"></i>APPROV</a>
										<?php } ?>	
										<a href="<?php 
										$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
										echo site_url("ga/pembelian/hapus_sppb/$enc_nodok");?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i>BATAL</a>										
										<?php } ?>	
										<?php if ((trim($row->status)=='P' or trim($row->status)=='S') and $userhr>0 ) { ?>
										<a href="<?php 
										$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
										echo site_url("ga/pembelian/hangus_sppb/$enc_nodok");?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> HANGUS </a>
										
										<?php } ?>
										<?php if ((trim($row->status)=='P' or trim($row->status)=='S' or trim($row->status)=='U')) { ?>
										<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php echo site_url('ga/pembelian/sti_sppb_final/'.trim($row->nodok));?>');">CETAK</button>
										<?php } ?>
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


</div>	
</div>
</div><!--/ nav -->	
<!-- Modal Input Skema Barang -->

<!-- Modal EDIT MASTER SUPPLIER -->
<?php foreach ($list_sppb as $lb) { ?>
<div class="modal fade" id="ED<?php echo trim($lb->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT PERMINTAAN BARANG MASUK</h4>
	  </div>
	  <form action="<?php echo site_url('ga/pembelian/save_personalsppb')?>" method="post">
		<div class="modal-body">										
			<div class="row">
				<div class="col-sm-6">
							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-4">NODOK</label>	
									<div class="col-sm-8">    
										<input type="text" id="nodok" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									</div>
								</div>								
								<div class="form-group">
									<label class="col-sm-4">NIK</label>	
									<div class="col-sm-8">    
										<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
										<input type="hidden" id="type" name="type"  value="EDIT" class="form-control" style="text-transform:uppercase">								
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
								</div><!-- /.box-body -->													
							</div><!-- /.box -->													
				</div>	
				<div class="col-sm-6">
							<div class="form-horizontal">	
							<div class="form-group">
								<label class="col-sm-4" for="inputsm">Pilih Dari Stock</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm" name="daristock" id="daristock" required>
									 <option value="">---PILIH DARI STOCK--</option> 
									 <option value="YES"> YA </option> 
									 <!--option value="NO"> TIDAK </option--> 
									</select>
									</div>
							</div>
						
							<div class="form-group drst">
								<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm drst" name="kdgroup" id="kdgroup" required>
									 <option value="">---PILIH KODE GROUP--</option> 
									  <?php foreach($list_scgroup as $sc){?>					  
									  <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
									  <?php }?>
									</select>
									</div>
							</div>
							<div class="form-group drst">
								<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm drst" name="kdsubgroup" id="kdsubgroup" required>
									 <option  value="">---PILIH KODE SUB GROUP--</option> 
									  <?php foreach($list_scsubgroup as $sc){?>					  
									  <option value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group drst">
								<label class="col-sm-4" for="inputsm">Kode Barang</label>	
								<div class="col-sm-8"> 
									<select class="form-control input-sm kdbarang drst" name="kdbarang" id="kdbarang" required>
									 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
									  <?php foreach($list_stkgdw as $sc){?>					  
									  <option value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group drst">
								<label class="col-sm-4">LOKASI GUDANG</label>	
								<div class="col-sm-8">    
									<input type="text" id="loccode" name="loccode"   class="form-control drst" readonly >
								</div>
							</div>
							<div class="form-group drst">
								<label class="col-sm-4">ON HAND</label>	
								<div class="col-sm-8">    
									<input type="number" id="onhand" name="onhand"   placeholder="0" class="form-control drst" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Quantity Permintaan</label>	
								<div class="col-sm-8">    
									<input type="number" id="qtysppb" name="qtysppb"   placeholder="0" class="form-control" required >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Deskripsi Barang</label>	
								<div class="col-sm-8">    
									<input type="text" id="desc_barang" name="desc_barang"   style="text-transform:uppercase" class="form-control" required >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
							</div>
							</div>		
							
						</div> 
				</div>
			</div>	
		</div>	
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Submit</button>
      </div>
		</form>
		</div>  
	  </div>
</div>
<?php } ?>	 		
<!-- -->

<!-- Modal DETAIL -->
<?php foreach ($list_sppb as $lb) { ?>
<div class="modal fade" id="DTL<?php echo trim($lb->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL PERMINTAAN BARANG MASUK</h4>
	  </div>
	  <form action="<?php echo site_url('ga/pembelian/save_personalsppb')?>" method="post">
		<div class="modal-body">										
			<div class="row">
				<div class="col-sm-6">
							<div class="form-horizontal">	
								<div class="form-group">
									<label class="col-sm-4">NODOK</label>	
									<div class="col-sm-8">    
										<input type="text" id="nodok" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									</div>
								</div>							
								<div class="form-group">
									<label class="col-sm-4">NIK</label>	
									<div class="col-sm-8">    
										<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
										<input type="hidden" id="type" name="type"  value="APPROVAL" class="form-control" style="text-transform:uppercase">								
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
								</div><!-- /.box-body -->													
							</div><!-- /.box -->													
				</div>	
				<div class="col-sm-6">
							<div class="form-horizontal">	
								<div class="form-group">
									<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
										<div class="col-sm-8">  
										<select class="form-control input-sm" name="kdgroup" id="kdgroup" disabled>
										 <option value="">---PILIH KODE GROUP--</option> 
										  <?php foreach($list_scgroup as $sc){?>					  
										  <option  <?php if (trim($lb->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
										  <?php }?>
										</select>
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
									<div class="col-sm-8"> 
										<select class="form-control input-sm " name="kdsubgroup" id="kdsubgroup" disabled>
										 <option  value="">---PILIH KODE SUB GROUP--</option> 
										  <?php foreach($list_scsubgroup as $sc){?>					  
										  <option <?php if (trim($lb->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
										  <?php }?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4" for="inputsm">Kode Barang</label>	
									<div class="col-sm-8"> 
										<select class="form-control input-sm kdbarang" name="kdbarang" id="kdbarang" disabled>
										 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
										  <?php foreach($list_stkgdw as $sc){?>					  
										  <option <?php if (trim($lb->stockcode)==trim($sc->stockcode)) { echo 'selected';}?> value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
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
									<label class="col-sm-4">ON HAND</label>	
									<div class="col-sm-8">    
										<input type="number" id="onhand" name="onhand"   placeholder="0" class="form-control" readonly >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Quantity Permintaan</label>	
									<div class="col-sm-8">    
										<input type="number"  value="<?php echo trim($lb->qty);?>"  id="qty" name="qty"   placeholder="0" class="form-control" readonly >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Deskripsi Barang</label>	
									<div class="col-sm-8">    
										<input type="text" value="<?php echo trim($lb->desc_barang);?>"  id="desc_barang" name="desc_barang"   style="text-transform:uppercase" class="form-control" readonly >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Keterangan</label>	
									<div class="col-sm-8">    
										<textarea type="text"  id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control" disabled> <?php echo trim($lb->keterangan);?></textarea>
								</div>
						</div><!-- /.box-body -->													
					</div><!-- /.box --> 
				</div>
			</div>	
		</div>	
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<?php if(trim($lb->status)=='A') { ?>
		<button type="submit" class="btn btn-primary">APPROVAL</button>
		<?php } ?>
		</div>
		</form>
		</div>  
	  </div>
</div>
<?php } ?>


<!-- Modal DETAIL -->
<?php foreach ($list_sppb as $lb) { ?>
<div class="modal fade" id="DEL<?php echo trim($lb->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">HAPUS DETAIL PERMINTAAN BARANG MASUK</h4>
	  </div>
	  <form action="<?php echo site_url('ga/pembelian/save_personalsppb')?>" method="post">
		<div class="modal-body">										
			<div class="row">
				<div class="col-sm-6">
							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-4">NODOK</label>	
									<div class="col-sm-8">    
										<input type="text" id="nodok" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									</div>
								</div>								
								<div class="form-group">
									<label class="col-sm-4">NIK</label>	
									<div class="col-sm-8">    
										<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
										<input type="hidden" id="type" name="type"  value="DELETE" class="form-control" style="text-transform:uppercase">								
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
								</div><!-- /.box-body -->													
							</div><!-- /.box -->													
				</div>	
				<div class="col-sm-6">
							<div class="form-horizontal">	
								<div class="form-group">
									<label class="col-sm-4" for="inputsm">Kode Group Barang</label>	
										<div class="col-sm-8">  
										<select class="form-control input-sm" name="kdgroup" id="kdgroup" disabled>
										 <option value="">---PILIH KODE GROUP--</option> 
										  <?php foreach($list_scgroup as $sc){?>					  
										  <option  <?php if (trim($lb->kdgroup)==trim($sc->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
										  <?php }?>
										</select>
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>	
									<div class="col-sm-8"> 
										<select class="form-control input-sm " name="kdsubgroup" id="kdsubgroup" disabled>
										 <option  value="">---PILIH KODE SUB GROUP--</option> 
										  <?php foreach($list_scsubgroup as $sc){?>					  
										  <option <?php if (trim($lb->kdsubgroup)==trim($sc->kdsubgroup)) { echo 'selected';}?> value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>						  
										  <?php }?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4" for="inputsm">Kode Barang</label>	
									<div class="col-sm-8"> 
										<select class="form-control input-sm kdbarang" name="kdbarang" id="kdbarang" disabled>
										 <option  value="">---PILIH KDBARANG || NAMA BARANG--</option> 
										  <?php foreach($list_stkgdw as $sc){?>					  
										  <option <?php if (trim($lb->stockcode)==trim($sc->stockcode)) { echo 'selected';}?> value="<?php echo trim($sc->stockcode);?>"  class="<?php echo trim($sc->kdsubgroup);?>" ><?php echo trim($sc->stockcode).' || '.trim($sc->nmbarang);?></option>						  
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
									<label class="col-sm-4">ON HAND</label>	
									<div class="col-sm-8">    
										<input type="number" id="onhand" name="onhand"   placeholder="0" class="form-control" readonly >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Quantity Permintaan</label>	
									<div class="col-sm-8">    
										<input type="number"  value="<?php echo trim($lb->qty);?>"  id="qty" name="qty"   placeholder="0" class="form-control" readonly >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Deskripsi Barang</label>	
									<div class="col-sm-8">    
										<input type="text" value="<?php echo trim($lb->desc_barang);?>"  id="desc_barang" name="desc_barang"   style="text-transform:uppercase" class="form-control" readonly >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Keterangan</label>	
									<div class="col-sm-8">    
										<textarea type="text"  id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control" disabled> <?php echo trim($lb->keterangan);?></textarea>
								</div>
						</div><!-- /.box-body -->													
					</div><!-- /.box --> 
				</div>
			</div>	
		</div>	
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-danger">HAPUS</button>
      </div>
		</form>
		</div>  
	  </div>
</div>
<?php } ?>

<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>