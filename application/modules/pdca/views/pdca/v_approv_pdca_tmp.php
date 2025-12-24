<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
				$(".tgl").datepicker();                               
				$(".tglrange").daterangepicker();
				$(".tglrangetime").datetimepicker({ format: 'DD-MM-YYYY H:mm' });
				/*$(".tglrangetime").daterangepicker({
					    timePicker: true,
						timePicker24Hour: true,
						timePickerIncrement: 30,
						format: 'MM-DD-YYYY H:mm'
						/*locale: {
							format: 'MM/DD/YYYY H:mm'
						}*
				});       */                        
				$(".clock").clockpicker({
					autoclose: true
				});
					$('.ch').change(function(){
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
									$('[name="satkecil"]').val(data.satkecil);                                                          
									$('[name="satminta"]').val(data.satkecil);                                                          
									$('[name="nmsatkecil"]').val(data.nmsatkecil);                                                          
									$('[name="nmsatminta"]').val(data.nmsatkecil);                                                          
									$('[name="desc_barang"]').val(data.nmbarang);                                                          
						
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
				$('form').on('focus', 'input[type=number]', function (e) {
					  $(this).on('mousewheel.disableScroll', function (e) {
						e.preventDefault()
					  })
				})		
					
			});
			
function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	if(rowCount < 10){							// limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i<colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				$(".tgl").datepicker();                               
				$(".tglrange").daterangepicker();
				$(".tglrangetime").datetimepicker({ format: 'DD-MM-YYYY H:mm' });
				/*$(".tglrangetime").daterangepicker({
					    timePicker: true,
						timePicker24Hour: true,
						timePickerIncrement: 30,
						format: 'MM-DD-YYYY H:mm'
						/*locale: {
							format: 'MM/DD/YYYY H:mm'
						}*
				}); */                              
				$(".clock").clockpicker({
					autoclose: true
				});
		}
	}else{
		 alert("HALLO MAKSIMAL 10 TOLONG JANGAN BERLEBIHAN  !!!");
			   
	}
}

function deleteRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	for(var i=1; i<rowCount; i++) {
		var row = table.rows[i];
			if(rowCount <= 1) { 						// limit the user from removing all the fields
				alert("Cannot remove all the form.");
				break;
			} else {
				console.log(rowCount);
				console.log(i);
				table.deleteRow(i);
				break;
				//rowCount--;
				///i--;
			}

			
	}
}
</script>
<style>
.selectize-input {
    overflow: visible;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}
.selectize-input.dropdown-active {
    min-height: 30px;
    line-height: normal;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}
.selectize-dropdown, .selectize-input, .selectize-input input {
    min-height: 30px;
    line-height: normal;
}
.loading .selectize-dropdown-content:after {
    content: 'loading...';
    height: 30px;
    display: block;
    text-align: center;
}
@media (min-width: 768px) {
  .modal-xl {
	width: 100%;
   max-width:1800px;
  }
}
</style>
<legend><?php echo $title;?></legend>
<h5><b><strong><?php echo '  DETAIL DATA PLAN DO CHECK ACTION (PDCA)';?></strong></b></h5>
<?php echo $message;?>

<div class="row">							
		<div class="col-sm-12">		
			<a href="<?php echo site_url("pdca/pdca/clear_tmp_pdca")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
			<a href="<?php echo site_url("pdca/pdca/final_input_pdca")?>" onclick="return confirm('Akan Disimpan Final Seluruh Detail Yang Anda Buat? Anda Yakin?')" class="btn btn-success pull-right" style="margin:10px; color:#ffffff;"><i class="fa fa-save">  Final Checking</i></a>
			
		</div>
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header"  align="center">
					<h5><b><strong><?php echo 'MASTER PLAN DO CHECK ACTION (PDCA)';?></strong></b></h5>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
<?php if(trim($pdca_mst['lvl_jabatan'])=='C') { ?>
					<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>DOCUMENT</th>
											<th>NAMA LENGKAP</th>
											<th>TIPE</th>
											<th>BAGIAN</th>
											<th>JABATAN</th>
											<th>TANGGAL AWAL</th>
											<th>TANGGAL AKHIR</th>
											<th>CATATAN</th>
											<th>TTL %</th>
											<th>PLAN</th>
											<th>AVG</th>
											<th>STATUS</th>
											<th>ACTION</th>
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_tmp_pdca_mst as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->docno;?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->nmdoctype;?></td>
									<td><?php echo $row->nmdept;?></td>
									<td><?php echo $row->nmjabatan;?></td>
									<td><?php if (!empty($row->tglawal)) { echo date('d-m-Y', strtotime(trim($row->tglawal))); } else { echo '';} ;?></td>
									<td><?php if (!empty($row->tglakhir)) { echo date('d-m-Y', strtotime(trim($row->tglakhir))); } else { echo '';} ;?></td>
									<td><?php echo $row->global_desc;?></td>
									<td align="right"><?php echo $row->ttlpercent;?></td>
									<td align="right"><?php echo $row->ttlplan;?></td>
									<td align="right"><?php echo $row->avgvalue;?></td>
									<td><?php echo trim($row->nmstatus);?></td>
																	
									<td width="10%">
									<a href="#" data-toggle="modal" data-target="#INPUTMSTPDCA<?php echo str_replace('.','',trim($row->docno));?>" class="btn btn-default  btn-sm" data-toggle="tooltip" data-placement="top" title="DETAIL MASTER PLAN"><i class="fa fa-bars"></i></a>
									</td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>		
						</table>
<?php } else { ?>
					<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>DOCUMENT</th>
											<th>NAMA LENGKAP</th>
											<th>TIPE</th>
											<th>BAGIAN</th>
											<th>JABATAN</th>
											<th>TANGGAL</th>
											<th>CATATAN</th>
											<th>TTL %</th>
											<th>PLAN</th>
											<th>AVG</th>
											<th>STATUS</th>
											<th>ACTION</th>
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_tmp_pdca_mst as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->docno;?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->nmdoctype;?></td>
									<td><?php echo $row->nmdept;?></td>
									<td><?php echo $row->nmjabatan;?></td>
									<td><?php if (!empty($row->docdate)) { echo date('d-m-Y', strtotime(trim($row->docdate))); } else { echo '';} ;?></td>
									<td><?php echo $row->global_desc;?></td>
									<td align="right"><?php echo $row->ttlpercent;?></td>
									<td align="right"><?php echo $row->ttlplan;?></td>
									<td align="right"><?php echo $row->avgvalue;?></td>
									<td><?php echo trim($row->nmstatus);?></td>
									
									<td width="10%">
									<a href="#" data-toggle="modal" data-target="#INPUTMSTPDCA<?php echo str_replace('.','',trim($row->docno));?>" class="btn btn-default  btn-sm" data-toggle="tooltip" data-placement="top" title="DETAIL MASTER PLAN"><i class="fa fa-bars"></i></a>
									</td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>		
						</table>
<?php } ?>

					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div><!-- END ROW 1 --->
<!--div class="col-sm-12">	
	<div class="dropdown ">
		<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
		<span class="caret"></span></button>
		<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
		  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#inputDetailPDCA"  href="#">Input Detail</a></li> 
		</ul>
	</div>
</div----><!-- /.box-header -->

			<div class="col-xs-12"> 
				<div class="box">
					<div class="box-header"  align="center">
					<h5><b><strong><?php echo 'DETAIL PLAN DO CHECK ACTION (PDCA)';?></strong></b></h5>
					<a href="<?php echo site_url("pdca/pdca/rollback_approval")?>" onclick="return confirm('Reset Data Detail Yang Anda Inputkan Akan Tereset, Anda Yakin?')" class="btn btn-warning pull-right" style="margin:10px; color:#ffffff;"><i class="fa fa-repeat"> Reset All</i></a>
					<a href="<?php echo site_url("pdca/pdca/approval_all_detail")?>" onclick="return confirm('Akan Ada Proses Approval Keseluruhan Detail?')" class="btn btn-success pull-right" style="margin:10px; color:#ffffff;"><i class="fa fa-check"> Approve All</i></a>
					
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
<?php if(trim($pdca_mst['lvl_jabatan'])=='C') { ?>
						<table id="example2" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>IDBU</th>
											<th>PLAN</th>
											<th>QTY/TIME</th>
											<th>DO</th>
											<th>%</th>
											<th>REMARK</th>
											<th>STATUS</th>
											<th>INPUT DATE</th>											
											<th>AKSI</th>		
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_tmp_pdca_dtl as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo trim($row->idbu);?></td>
									<td><?php echo trim($row->descplan);?></td>
									<td><?php echo trim($row->qtytime);?></td>
									<td><?php echo trim($row->do_c);?></td>
									<td align="right"><?php echo trim($row->percentage);?></td>
									<td><?php echo trim($row->remark);?></td>
									<td><?php echo trim($row->nmstatus);?></td>
									<td width="11%"><?php echo date('d-m-Y H:i:s', strtotime(trim($row->inputdate)));?></td>
									<td width="15%">
									<?php if (trim($row->status)=='R') { ?>
									<a href="#" data-toggle="modal" data-target="#REJECT_APPROV_DTL<?php echo str_replace('.','',trim($row->docno)).trim($row->nomor);?>" class="btn btn-danger  btn-sm"><i class="fa fa-ban" data-toggle="tooltip" data-placement="top" title="TIDAK SELESAI DARI PLAN PLAN PDCA"></i></a>	
									<a href="#" data-toggle="modal" data-target="#PROSES_APPROV_DTL<?php echo str_replace('.','',trim($row->docno)).trim($row->nomor);?>" class="btn btn-success  btn-sm"><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="PERSETUJUAN PLANNING PDCA"></i></a>	
									<?php } else if ((trim($row->status)=='B') OR (trim($row->status)=='O')) { ?>
									<a href="#" data-toggle="modal" data-target="#RESET_APPROV_DTL<?php echo str_replace('.','',trim($row->docno)).trim($row->nomor);?>" class="btn btn-warning  btn-sm"><i class="fa fa-repeat" data-toggle="tooltip" data-placement="top" title="RESET STATUS PLAN"></i></a>	
									<?php } ?>
									<a href="#" data-toggle="modal" data-target="#DETAIL_DTL<?php echo str_replace('.','',trim($row->docno)).trim($row->nomor);?>" class="btn btn-default  btn-sm"><i class="fa fa-bars" data-toggle="tooltip" data-placement="top" title="DETAIL LIST PLAN"></i></a>	
								
								
									</td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>		
					</table>
<?php } else { ?>
					<table id="example2" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>TANGGAL</th>
											<th>IDBU</th>
											<th>PLAN</th>
											<th>QTY/TIME</th>
											<th>DO</th>
											<th>%</th>
											<th>REMARK</th>
											<th>STATUS</th>
											<th>INPUT DATE</th>												
											<th>AKSI</th>		
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_tmp_pdca_dtl as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
									<td><?php if (!empty($row->docdate)) { echo date('d-m-Y', strtotime(trim($row->docdate))); } else { echo '';} ;?></td>
									<td><?php echo trim($row->idbu);?></td>
									<td><?php echo trim($row->descplan);?></td>
									<td><?php echo trim($row->qtytime);?></td>
									<td><?php echo trim($row->do_c);?></td>
									<td align="right"><?php echo trim($row->percentage);?></td>
									<td><?php echo trim($row->remark);?></td>
									<td><?php echo trim($row->nmstatus);?></td>
									<td width="11%"><?php echo date('d-m-Y H:i:s', strtotime(trim($row->inputdate)));?></td>
									<td width="15%">
									<?php if (trim($row->status)=='R') { ?>
									<a href="#" data-toggle="modal" data-target="#REJECT_APPROV_DTL<?php echo str_replace('.','',trim($row->docno)).trim($row->nomor);?>" class="btn btn-danger  btn-sm"><i class="fa fa-ban" data-toggle="tooltip" data-placement="top" title="TIDAK SELESAI DARI PLAN PLAN PDCA"></i></a>	
									<a href="#" data-toggle="modal" data-target="#PROSES_APPROV_DTL<?php echo str_replace('.','',trim($row->docno)).trim($row->nomor);?>" class="btn btn-success  btn-sm"><i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="PERSETUJUAN PLANNING PDCA"></i></a>	
									<?php } else if ((trim($row->status)=='B') OR (trim($row->status)=='O')) { ?>
									<a href="#" data-toggle="modal" data-target="#RESET_APPROV_DTL<?php echo str_replace('.','',trim($row->docno)).trim($row->nomor);?>" class="btn btn-warning  btn-sm"><i class="fa fa-repeat" data-toggle="tooltip" data-placement="top" title="RESET STATUS PLAN"></i></a>	
									<?php } ?>
									<a href="#" data-toggle="modal" data-target="#DETAIL_DTL<?php echo str_replace('.','',trim($row->docno)).trim($row->nomor);?>" class="btn btn-default  btn-sm"><i class="fa fa-bars" data-toggle="tooltip" data-placement="top" title="DETAIL LIST PLAN"></i></a>	
								
								
									</td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>		
					</table>
<?php } ?>

					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
</div>	
<!-- INPUT MASTER PDCA TANGGAL DAN KETERANGAN PER HARI-->	
<?php foreach ($list_tmp_pdca_mst as $lb) { ?>
<div class="modal fade" id="INPUTMSTPDCA<?php echo str_replace('.','',trim($lb->docno));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">DETAIL DATA MASTER PDCA</h4>
	  </div>
<form action="<?php echo site_url('pdca/pdca/save_pdca')?>" method="post" name="inputformPbk">
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
									<input type="hidden" id="type" name="type"  value="EDIT_MST_PDCA_ISL" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="docno" name="docno"  value="<?php echo trim($lb->docno);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="doctype" name="doctype"  value="<?php echo trim($lb->doctype);?>" class="form-control" style="text-transform:uppercase">								
									
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
									<input type="text" value="<?php echo trim($lb->nmatasan1); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
<?php if(trim($pdca_mst['lvl_jabatan'])=='C') { ?>
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL </label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tglrange" id="docdaterange" name="docdaterange"   value="<?php if (empty($lb->tglawal) or empty($lb->tglakhir)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($lb->tglawal))).' - '.date('d-m-Y', strtotime(trim($lb->tglakhir))); } ?>"  readonly disabled>									
								</div>
							</div>

<?php } else { ?>							
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL </label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="docdate" name="docdate"  data-date-format="dd-mm-yyyy"   value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly disabled>
								</div>
							</div>
<?php } ?>
						
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="global_desc" name="global_desc"   style="text-transform:uppercase" class="form-control" DISABLED READONLY><?php echo trim($lb->global_desc);?></textarea>
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
        <!--button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button--->
      </div>
	  </form>
</div></div></div>
<?php } ?>

<!-----------------XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX--------------->



<?php foreach ($list_tmp_pdca_dtl as $lb) { ?>
<div class="modal fade" id="DETAIL_DTL<?php echo str_replace('.','',trim($lb->docno)).trim($lb->nomor);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM DETAIL (PDCA)</h4>
	  </div>
			<form action="<?php echo site_url('pdca/pdca/save_pdca')?>" method="post">
			<div class="modal-body">										
			<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($pdca_mst['nik']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									<input type="hidden" id="type" name="type"  value="DEL_2EDIT_DTL_PDCA_ISL" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="docno" name="docno"  value="<?php echo trim($pdca_mst['docno']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="docref" name="docref"  value="<?php echo trim($pdca_mst['docref']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="doctype" name="doctype"  value="<?php echo trim($pdca_mst['doctype']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden"  id="planperiod" name="planperiod"  value="<?php echo trim($pdca_mst['planperiod']);?>"  class="form-control" style="text-transform:uppercase">
									<input type="hidden"  id="nomor" name="nomor"  value="<?php echo trim($lb->nomor);?>"  class="form-control" style="text-transform:uppercase">
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($pdca_mst['nmlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($pdca_mst['nmlengkap']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($pdca_mst['lvl_jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="department"  value="<?php echo trim($pdca_mst['bag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmsubdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="subdepartment"  value="<?php echo trim($pdca_mst['subbag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($pdca_mst['nmjabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="jabatan"  value="<?php echo  trim($pdca_mst['jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan1</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmatasan1']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan"  value="<?php echo  trim($pdca_mst['nik_atasan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($pdca_mst['nmatasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan2"  value="<?php echo  trim($pdca_mst['nik_atasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
<?php if(trim($pdca_mst['lvl_jabatan'])=='C') { ?>
<?php } else { ?>							
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL </label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="docdate" name="docdate"  data-date-format="dd-mm-yyyy"   value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly disabled>
								</div>
							</div>
<?php } ?>
							<div class="form-group">
								<label class="col-sm-4">IDBU</label>	
								<div class="col-sm-8">    
									<input type="text" id="idbu" name="idbu" value="<?php echo trim($lb->idbu);?>" class="form-control" style="text-transform:uppercase" maxlength="12" READONLY>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">PLAN</label>	
								<div class="col-sm-8">    
									<!--input type="text"  id="descplan" name="descplan"  value="<?php echo trim($lb->descplan);?>"  class="form-control" style="text-transform:uppercase" maxlength="150" required-->
									<textarea type="text" id="descplan" name="descplan"   style="text-transform:uppercase"  maxlength="100" class="form-control" READONLY DISABLED><?php echo trim($lb->descplan);?></textarea>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">QTY/TIME</label>	
								<div class="col-sm-8">    
									<input type="text" id="qtytime" name="qtytime"  value="<?php echo trim($lb->qtytime);?>" class="form-control clock" READONLY DISABLED >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DO</label>	
								<div class="col-sm-8">    
									<input type="text" id="do_c" name="do_c"   value="<?php echo trim($lb->do_c);?>" class="form-control clock" READONLY DISABLED>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">PERCENTAGE %</label>	
								<div class="col-sm-8">    
									<input type="number" id="percentage" name="percentage"   value="<?php echo trim($lb->percentage);?>" class="form-control" maxlength="3"  READONLY >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Remark</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="remark" name="remark"   style="text-transform:uppercase"  maxlength="100" class="form-control" READONLY DISABLED><?php echo trim($lb->remark);?></textarea>
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
					<!--button type="submit" id="submit"  class="btn btn-danger">HAPUS</button---->
				  </div>
			  </form>
		</div>
	</div>
</div>
<?php } ?>




<?php foreach ($list_tmp_pdca_dtl as $lb) { ?>
<div class="modal fade" id="DETAIL_DTL<?php echo str_replace('.','',trim($lb->docno)).trim($lb->nomor);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM DETAIL (PDCA)</h4>
	  </div>
			<form action="<?php echo site_url('pdca/pdca/save_pdca')?>" method="post">
			<div class="modal-body">										
			<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($pdca_mst['nik']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									<input type="hidden" id="type" name="type"  value="DEL_2EDIT_DTL_PDCA_ISL" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="docno" name="docno"  value="<?php echo trim($pdca_mst['docno']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="docref" name="docref"  value="<?php echo trim($pdca_mst['docref']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="doctype" name="doctype"  value="<?php echo trim($pdca_mst['doctype']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden"  id="planperiod" name="planperiod"  value="<?php echo trim($pdca_mst['planperiod']);?>"  class="form-control" style="text-transform:uppercase">
									<input type="hidden"  id="nomor" name="nomor"  value="<?php echo trim($lb->nomor);?>"  class="form-control" style="text-transform:uppercase">
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($pdca_mst['nmlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($pdca_mst['nmlengkap']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($pdca_mst['lvl_jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="department"  value="<?php echo trim($pdca_mst['bag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmsubdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="subdepartment"  value="<?php echo trim($pdca_mst['subbag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($pdca_mst['nmjabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="jabatan"  value="<?php echo  trim($pdca_mst['jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan1</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmatasan1']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan"  value="<?php echo  trim($pdca_mst['nik_atasan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($pdca_mst['nmatasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan2"  value="<?php echo  trim($pdca_mst['nik_atasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
<?php if(trim($pdca_mst['lvl_jabatan'])=='C') { ?>

<?php } else { ?>							
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL </label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="docdate" name="docdate"  data-date-format="dd-mm-yyyy"   value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly disabled>
								</div>
							</div>
<?php } ?>
							<div class="form-group">
								<label class="col-sm-4">IDBU</label>	
								<div class="col-sm-8">    
									<input type="text" id="idbu" name="idbu" value="<?php echo trim($lb->idbu);?>" class="form-control" style="text-transform:uppercase" maxlength="12" READONLY>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">PLAN</label>	
								<div class="col-sm-8">    
									<!--input type="text"  id="descplan" name="descplan"  value="<?php echo trim($lb->descplan);?>"  class="form-control" style="text-transform:uppercase" maxlength="150" required-->
									<textarea type="text" id="descplan" name="descplan"   style="text-transform:uppercase"  maxlength="100" class="form-control" READONLY DISABLED><?php echo trim($lb->descplan);?></textarea>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">QTY/TIME</label>	
								<div class="col-sm-8">    
									<input type="text" id="qtytime" name="qtytime"  value="<?php echo trim($lb->qtytime);?>" class="form-control clock" READONLY DISABLED >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DO</label>	
								<div class="col-sm-8">    
									<input type="text" id="do_c" name="do_c"   value="<?php echo trim($lb->do_c);?>" class="form-control clock" READONLY DISABLED>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">PERCENTAGE %</label>	
								<div class="col-sm-8">    
									<input type="number" id="percentage" name="percentage"   value="<?php echo trim($lb->percentage);?>" class="form-control" maxlength="3"  READONLY >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Remark</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="remark" name="remark"   style="text-transform:uppercase"  maxlength="100" class="form-control" READONLY DISABLED><?php echo trim($lb->remark);?></textarea>
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
					<!--button type="submit" id="submit"  class="btn btn-danger">HAPUS</button---->
				  </div>
			  </form>
		</div>
	</div>
</div>
<?php } ?>



<?php foreach ($list_tmp_pdca_dtl as $lb) { ?>
<div class="modal fade" id="RESET_APPROV_DTL<?php echo str_replace('.','',trim($lb->docno)).trim($lb->nomor);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM RESET DETAIL (PDCA)</h4>
	  </div>
			<form action="<?php echo site_url('pdca/pdca/save_pdca')?>" method="post">
			<div class="modal-body">										
			<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($pdca_mst['nik']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									<input type="hidden" id="type" name="type"  value="RESET_APPROV_DTL_PDCA_ISL" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="docno" name="docno"  value="<?php echo trim($pdca_mst['docno']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="docref" name="docref"  value="<?php echo trim($pdca_mst['docref']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="doctype" name="doctype"  value="<?php echo trim($pdca_mst['doctype']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden"  id="planperiod" name="planperiod"  value="<?php echo trim($pdca_mst['planperiod']);?>"  class="form-control" style="text-transform:uppercase">
									<input type="hidden"  id="nomor" name="nomor"  value="<?php echo trim($lb->nomor);?>"  class="form-control" style="text-transform:uppercase">
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($pdca_mst['nmlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($pdca_mst['nmlengkap']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($pdca_mst['lvl_jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="department"  value="<?php echo trim($pdca_mst['bag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmsubdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="subdepartment"  value="<?php echo trim($pdca_mst['subbag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($pdca_mst['nmjabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="jabatan"  value="<?php echo  trim($pdca_mst['jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan1</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmatasan1']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan"  value="<?php echo  trim($pdca_mst['nik_atasan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($pdca_mst['nmatasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan2"  value="<?php echo  trim($pdca_mst['nik_atasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
<?php if(trim($pdca_mst['lvl_jabatan'])=='C') { ?>
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL </label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl"  data-date-format="dd-mm-yyyy"   value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly disabled>
									<input type="hidden" class="form-control input-sm" id="docdate" name="docdate" data-date-format="dd-mm-yyyy"  value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly>
								</div>
							</div>

<?php } else { ?>							
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL </label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl"  data-date-format="dd-mm-yyyy"   value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly disabled>
									<input type="hidden" class="form-control input-sm" id="docdate" name="docdate" data-date-format="dd-mm-yyyy"  value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly>
								</div>
							</div>
<?php } ?>
							<div class="form-group">
								<label class="col-sm-4">IDBU</label>	
								<div class="col-sm-8">    
									<input type="text" id="idbu" name="idbu" value="<?php echo trim($lb->idbu);?>" class="form-control" style="text-transform:uppercase" maxlength="12" READONLY>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">PLAN</label>	
								<div class="col-sm-8">    
									<!--input type="text"  id="descplan" name="descplan"  value="<?php echo trim($lb->descplan);?>"  class="form-control" style="text-transform:uppercase" maxlength="150" required-->
									<textarea type="text" id="descplan" name="descplan"   style="text-transform:uppercase"  maxlength="100" class="form-control" READONLY DISABLED><?php echo trim($lb->descplan);?></textarea>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">QTY/TIME</label>	
								<div class="col-sm-8">    
									<input type="text" id="qtytime" name="qtytime"  value="<?php echo trim($lb->qtytime);?>" class="form-control clock" READONLY DISABLED >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DO</label>	
								<div class="col-sm-8">    
									<input type="text" id="do_c" name="do_c"   value="<?php echo trim($lb->do_c);?>" class="form-control clock" READONLY DISABLED>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">PERCENTAGE %</label>	
								<div class="col-sm-8">    
									<input type="number" id="percentage" name="percentage"   value="<?php echo trim($lb->percentage);?>" class="form-control" maxlength="3"  READONLY >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Remark</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="remark" name="remark"   style="text-transform:uppercase"  maxlength="100" class="form-control" READONLY DISABLED><?php echo trim($lb->remark);?></textarea>
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
					<button type="submit" id="submit"  class="btn btn-warning">RESET</button>
				  </div>
			  </form>
		</div>
	</div>
</div>
<?php } ?>

<?php foreach ($list_tmp_pdca_dtl as $lb) { ?>
<div class="modal fade" id="REJECT_APPROV_DTL<?php echo str_replace('.','',trim($lb->docno)).trim($lb->nomor);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM REJECT DETAIL (PDCA)</h4>
	  </div>
			<form action="<?php echo site_url('pdca/pdca/save_pdca')?>" method="post">
			<div class="modal-body">										
			<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($pdca_mst['nik']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									<input type="hidden" id="type" name="type"  value="REJECT_APPROV_DTL_PDCA_ISL" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="docno" name="docno"  value="<?php echo trim($pdca_mst['docno']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="docref" name="docref"  value="<?php echo trim($pdca_mst['docref']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="doctype" name="doctype"  value="<?php echo trim($pdca_mst['doctype']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden"  id="planperiod" name="planperiod"  value="<?php echo trim($pdca_mst['planperiod']);?>"  class="form-control" style="text-transform:uppercase">
									<input type="hidden"  id="nomor" name="nomor"  value="<?php echo trim($lb->nomor);?>"  class="form-control" style="text-transform:uppercase">
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($pdca_mst['nmlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($pdca_mst['nmlengkap']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($pdca_mst['lvl_jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="department"  value="<?php echo trim($pdca_mst['bag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmsubdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="subdepartment"  value="<?php echo trim($pdca_mst['subbag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($pdca_mst['nmjabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="jabatan"  value="<?php echo  trim($pdca_mst['jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan1</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmatasan1']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan"  value="<?php echo  trim($pdca_mst['nik_atasan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($pdca_mst['nmatasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan2"  value="<?php echo  trim($pdca_mst['nik_atasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
<?php if(trim($pdca_mst['lvl_jabatan'])=='C') { ?>
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL </label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl"  data-date-format="dd-mm-yyyy"   value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly disabled>
									<input type="hidden" class="form-control input-sm" id="docdate" name="docdate" data-date-format="dd-mm-yyyy"  value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly>
								</div>
							</div>

<?php } else { ?>							
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL </label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="docdate" name="docdate"  data-date-format="dd-mm-yyyy"   value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly disabled>
								</div>
							</div>
<?php } ?>
							<div class="form-group">
								<label class="col-sm-4">IDBU</label>	
								<div class="col-sm-8">    
									<input type="text" id="idbu" name="idbu" value="<?php echo trim($lb->idbu);?>" class="form-control" style="text-transform:uppercase" maxlength="12" READONLY>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">PLAN</label>	
								<div class="col-sm-8">    
									<!--input type="text"  id="descplan" name="descplan"  value="<?php echo trim($lb->descplan);?>"  class="form-control" style="text-transform:uppercase" maxlength="150" required-->
									<textarea type="text" id="descplan" name="descplan"   style="text-transform:uppercase"  maxlength="100" class="form-control" READONLY DISABLED><?php echo trim($lb->descplan);?></textarea>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">QTY/TIME</label>	
								<div class="col-sm-8">    
									<input type="text" id="qtytime" name="qtytime"  value="<?php echo trim($lb->qtytime);?>" class="form-control" READONLY  >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DO</label>	
								<div class="col-sm-8">    
									<input type="text" id="do_c" name="do_c"   value="<?php echo trim($lb->do_c);?>" class="form-control"  >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">PERCENTAGE %</label>	
								<div class="col-sm-8">    
									<!--input type="number" id="percentage" name="percentage"   value="<?php echo trim($lb->percentage);?>" class="form-control" maxlength="3" min="0" max="100" required --->
									<input type="number" id="percentage" name="percentage"   value="<?php echo '0';?>" class="form-control" maxlength="3" min="0" max="100" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Remark</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="remark" name="remark"   style="text-transform:uppercase"  maxlength="100" class="form-control" ><?php echo trim($lb->remark);?></textarea>
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
					<button type="submit" id="submit"  class="btn btn-danger">BELUM SELESAI</button>
				  </div>
			  </form>
		</div>
	</div>
</div>
<?php } ?>

<?php foreach ($list_tmp_pdca_dtl as $lb) { ?>
<div class="modal fade" id="PROSES_APPROV_DTL<?php echo str_replace('.','',trim($lb->docno)).trim($lb->nomor);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FORM APPROV DETAIL (PDCA)</h4>
	  </div>
			<form action="<?php echo site_url('pdca/pdca/save_pdca')?>" method="post">
			<div class="modal-body">										
			<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($pdca_mst['nik']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									<input type="hidden" id="type" name="type"  value="PROSES_APPROV_DTL_PDCA_ISL" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="docno" name="docno"  value="<?php echo trim($pdca_mst['docno']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="docref" name="docref"  value="<?php echo trim($pdca_mst['docref']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden" id="doctype" name="doctype"  value="<?php echo trim($pdca_mst['doctype']);?>" class="form-control" style="text-transform:uppercase">								
									<input type="hidden"  id="planperiod" name="planperiod"  value="<?php echo trim($pdca_mst['planperiod']);?>"  class="form-control" style="text-transform:uppercase">
									<input type="hidden"  id="nomor" name="nomor"  value="<?php echo trim($lb->nomor);?>"  class="form-control" style="text-transform:uppercase">
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($pdca_mst['nmlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($pdca_mst['nmlengkap']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($pdca_mst['lvl_jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="department"  value="<?php echo trim($pdca_mst['bag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmsubdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="subdepartment"  value="<?php echo trim($pdca_mst['subbag_dept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($pdca_mst['nmjabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="jabatan"  value="<?php echo  trim($pdca_mst['jabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan1</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($pdca_mst['nmatasan1']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan"  value="<?php echo  trim($pdca_mst['nik_atasan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text"  value="<?php echo  trim($pdca_mst['nmatasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan2"  value="<?php echo  trim($pdca_mst['nik_atasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
<?php if(trim($pdca_mst['lvl_jabatan'])=='C') { ?>
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL </label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl"  data-date-format="dd-mm-yyyy"   value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly disabled>
									<input type="hidden" class="form-control input-sm" id="docdate" name="docdate" data-date-format="dd-mm-yyyy"  value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly>
								</div>
							</div>

<?php } else { ?>							
							<div class="form-group ">
								<label class="col-sm-4">TANGGAL </label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm tgl" id="docdate" name="docdate"  data-date-format="dd-mm-yyyy"   value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  readonly disabled>
								</div>
							</div>
<?php } ?>
							<div class="form-group">
								<label class="col-sm-4">IDBU</label>	
								<div class="col-sm-8">    
									<input type="text" id="idbu" name="idbu" value="<?php echo trim($lb->idbu);?>" class="form-control" style="text-transform:uppercase" maxlength="12" READONLY>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">PLAN</label>	
								<div class="col-sm-8">    
									<!--input type="text"  id="descplan" name="descplan"  value="<?php echo trim($lb->descplan);?>"  class="form-control" style="text-transform:uppercase" maxlength="150" required-->
									<textarea type="text" id="descplan" name="descplan"   style="text-transform:uppercase"  maxlength="100" class="form-control" READONLY DISABLED><?php echo trim($lb->descplan);?></textarea>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">QTY/TIME</label>	
								<div class="col-sm-8">    
									<input type="text" id="qtytime" name="qtytime"  value="<?php echo trim($lb->qtytime);?>" class="form-control clock" READONLY DISABLED >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">DO</label>	
								<div class="col-sm-8">    
									<input type="text" id="do_c" name="do_c"   value="<?php echo trim($lb->do_c);?>" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">PERCENTAGE %</label>	
								<div class="col-sm-8">    
									<input type="number" id="percentage" name="percentage"   value="<?php echo trim($lb->percentage);?>" class="form-control" maxlength="3" min="0" max="100" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Remark</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="remark" name="remark"   style="text-transform:uppercase"  maxlength="100" class="form-control"><?php echo trim($lb->remark);?></textarea>
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
					<button type="submit" id="submit"  class="btn btn-success">PROSES</button>
				  </div>
			  </form>
		</div>
	</div>
</div>
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
	  