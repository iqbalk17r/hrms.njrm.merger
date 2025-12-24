<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				/*    var table = $('#example1').DataTable({
					   lengthMenu: [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
					   pageLength: 4
					}); */
				var save_method; //for save method string
				var table;
		      table = $('#example2').DataTable({ 
        
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": "<?php echo site_url('ga/permintaan/bbmpagin')?>",
					"type": "POST"
				},

				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
				  "targets": [ -1 ], //last column
				  "orderable": false, //set not orderable
				},
				],

			  });
			  			$modal = $('.pp');
					    $('#example2').on('click', '.show', function () {
								//var data = $('#example1').DataTable().row( this ).data();
								//alert( 'You clicked on '+data[0]+'\'s row' );
								var el = $(this);
								//alert(el.attr('data-url'));
								$modal.load(el.attr('data-url'), '', function(){
								$modal.modal();
							
							
							} );
						} );
			  
			  
			  
			  
				$("#example3").dataTable();
				$("#example4").dataTable();
				$("#kdsubgroup").chained("#kdgroup");
				$("#kdbarang").chained("#kdsubgroup");

			  });		
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>

<div class="row">
	<div class="col-sm-3">	
			<a href="<?php echo site_url("pdca/pdca/form_pdca")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
	</div><!-- /.box-header -->
</div>	
</br>
<div class="row">
<div class="col-sm-12">
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
	<?php if(trim($pdca_mst['lvl_jabatan'])=='C') { ?>
											<th>TANGGAL AWAL</th>
											<th>TANGGAL AKHIR</th>
	<?php } else { ?>							
											<th>TANGGAL</th>
	<?php } ?>
											<th>NAMA LENGKAP</th>
											<th>TIPE</th>
											<th>BAGIAN</th>
											<th>JABATAN</th>
											<th>CATATAN</th>
											<th>STATUS</th>
											<th>INPUT DATE</th>											
											<th>ACTION</th>
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_pdca as $row): $no++;?>
								<tr>									
									<td width="2%"><?php echo $no;?></td>
	<?php if(trim($pdca_mst['lvl_jabatan'])=='C') { ?>	
									<td><?php if (!empty($row->tglawal)) { echo date('d-m-Y', strtotime(trim($row->tglawal))); } else { echo '';} ;?></td>
									<td><?php if (!empty($row->tglakhir)) { echo date('d-m-Y', strtotime(trim($row->tglakhir))); } else { echo '';} ;?></td>
	<?php } else { ?>	
									<td><?php if (!empty($row->docdate)) { echo date('d-m-Y', strtotime(trim($row->docdate))); } else { echo '';} ;?></td>
	<?php } ?>
									
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->nmdoctype;?></td>
									<td><?php echo $row->nmdept;?></td>
									<td><?php echo $row->nmjabatan;?></td>
									<td><?php echo $row->global_desc;?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td width="11%"><?php echo date('d-m-Y H:i:s', strtotime(trim($row->inputdate)));?></td>																		
									<td width="10%">							
									<a href="<?php 
									$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
									$enc_doctype=bin2hex($this->encrypt->encode(trim($row->doctype)));
									$enc_planperiod=bin2hex($this->encrypt->encode(trim($row->planperiod)));
									$enc_docdate=bin2hex($this->encrypt->encode(trim($row->docdate)));
									echo site_url("pdca/pdca/detail_pdca").'/'.$enc_nik.'/'.$enc_doctype.'/'.$enc_docdate ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Detail Data Plan"><i class="fa fa-bars"></i></a>
									<?php if (trim($row->status)=='A' and (trim($dtlnik['nik_atasan'])==trim($nama) or trim($dtlnik['nik_atasan2'])!=trim($nama))) { ?>
									<a href="<?php 
									$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
									$enc_doctype=bin2hex($this->encrypt->encode(trim($row->doctype)));
									$enc_planperiod=bin2hex($this->encrypt->encode(trim($row->planperiod)));
									$enc_docdate=bin2hex($this->encrypt->encode(trim($row->docdate)));
									echo site_url("pdca/pdca/edit_pdca").'/'.$enc_nik.'/'.$enc_doctype.'/'.$enc_docdate ?>" class="btn btn-primary  btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah Data Plan"><i class="fa fa-gear"></i></a>
									<?php } ?>
									<?php if (trim($row->status)=='A' AND (trim($row->nik)==trim($nama))) { ?>
									<a href="<?php 
									$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
									$enc_doctype=bin2hex($this->encrypt->encode(trim($row->doctype)));
									$enc_planperiod=bin2hex($this->encrypt->encode(trim($row->planperiod)));
									$enc_docdate=bin2hex($this->encrypt->encode(trim($row->docdate)));
									echo site_url("pdca/pdca/realisasi_pdca").'/'.$enc_nik.'/'.$enc_doctype.'/'.$enc_docdate ?>" class="btn btn-warning  btn-sm" data-toggle="tooltip" data-placement="top" title="Realisasi Do dan % Data Plan"><i class="fa fa-bookmark"></i></a>
									
									<a href="<?php 
									$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
									$enc_doctype=bin2hex($this->encrypt->encode(trim($row->doctype)));
									$enc_planperiod=bin2hex($this->encrypt->encode(trim($row->planperiod)));
									$enc_docdate=bin2hex($this->encrypt->encode(trim($row->docdate)));
									echo site_url("pdca/pdca/hapus_pdca").'/'.$enc_nik.'/'.$enc_doctype.'/'.$enc_docdate ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus PDCA 1 Periode Master"><i class="fa fa-trash-o"></i></a>
									
									<?PHP } else if (trim($row->status)=='R' AND (trim($row->nik_atasan)==trim($nama))  and (trim($dtlnik['nik_atasan'])==trim($nama) or trim($dtlnik['nik_atasan2'])!=trim($nama))/*or $userhr>0*/) { ?>
									<a href="<?php 
									$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
									$enc_doctype=bin2hex($this->encrypt->encode(trim($row->doctype)));
									$enc_planperiod=bin2hex($this->encrypt->encode(trim($row->planperiod)));
									$enc_docdate=bin2hex($this->encrypt->encode(trim($row->docdate)));
									echo site_url("pdca/pdca/approv_pdca").'/'.$enc_nik.'/'.$enc_doctype.'/'.$enc_docdate ?>" class="btn btn-success  btn-sm" data-toggle="tooltip" data-placement="top" title="Persetujuan PDCA isidentil Harian"><i class="fa fa-check"></i></a>
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
</div><!--/ nav -->	



<div class="modal fade" id="ChoiceOfLetter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> PILIH JENIS UNTUK INPUT PDCA </h4>
	  </div>
<form action="<?php echo site_url('pdca/pdca/list_personal_karyawan')?>" method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">PILIH TIPE PDCA </label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm " name="inputfill" required>
									 <option value="ISD"> ISIDENTIL </option> 
									 <option value="BRK"> BERKALA </option> 
									 <!--option value="AJUSTMENT"> AJUSTMENT IN</option--> 
									</select>
									</div>
									<input type="hidden" name="rr" id="rr" value="#" class="form-control "  >
									
									<!--select class="form-control input-sm "  readonly disabled>
									 <option value="">---PILIH KODE GROUP--</option> 
									  <?php foreach($list_scgroup as $sc){?>					  
									  <option  <?php if (trim($sc->kdgroup)==trim($lb->kdgroup)) { echo 'selected';}?>  value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>						  
									  <?php }?>
									</select--->
							</div>							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
</div></div></div>




<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>