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
            });


</script>

<legend><?php echo $title;?></legend>
<h5><b><strong><?php echo '  DETAIL FORM LEGAL ';?></strong></b></h5>

<div class="row">
							
		<div class="col-sm-12">		
			<a href="<?php echo site_url("legal/legality/form_legal")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
			<a href="<?php echo site_url("legal/legality/final_perkara".'/'.$enc_docno)?>"  class="btn btn-warning pull-right" style="margin:0px; color:#ffffff;"><i class="fa fa-save"></i> Final Perkara </a>

		</div>
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header"  align="center">
					<h5><b><strong><?php echo 'Master Legal';?></strong></b></h5>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>
                                            <th width="1%">No.</th>
                                            <th width="4%">Aksi</th>
                                            <th>Nomor Perkara</th>
                                            <th>Dokumen</th>
                                            <th>Tipe</th>
                                            <th>Pelanggan</th>
                                            <th>Wilayah</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Penanganan</th>
                                            <th>Progress</th>
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($mst as $row): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
                                    <td width="8%">
                                        <a href="#" data-toggle="modal" data-target="#dtlMst<?php echo str_replace('/','',trim($row->docno));?>" class="btn btn-default  btn-sm" title="Detail"><i class="fa fa-bars"></i></a>
                                    </td>
									<td><?php echo $row->docref;?></td>
									<td><?php echo $row->docno;?></td>
									<td><?php echo $row->nmtype;?></td>
									<td><?php echo $row->coperatorname;?></td>
									<td><?php echo $row->nmbu;?></td>
									<td><?php if (!empty($row->docdate)) { echo date('d-m-Y H:m:s', strtotime(trim($row->docdate))); } else { echo '';} ;?></td>
                                    <td><?php echo $row->nmstatus;?></td>
                                    <td><?php echo $row->nmdocname;?></td>
                                    <td><?php echo $row->progress;?></td>

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
					<h5><b><strong><?php echo 'DETAIL LEGAL';?></strong></b></h5>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example2" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th width="2%">No.</th>
											<th>Aksi</th>
											<th>Nomor Perkara</th>
											<th>TglDokumen</th>
											<th>TglPenanganan</th>
											<th>Penanganan</th>
											<th>Status</th>
											<th>Lampiran</th>
											<th>Progress</th>
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($dtl as $dt): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
                                    <td width="4%">
                                        <a href="#" data-toggle="modal" data-target="#dtlDtl<?php echo str_replace('/','',trim($dt->docno)).trim($dt->sort);?>" class="btn btn-default  btn-sm" title="Detail"><i class="fa fa-bars"></i> </a>
                                    </td>
                                    <td ><?php echo trim($dt->docref);?></td>
                                    <td ><?php echo date('d-m-Y H:i:s',strtotime($dt->docdate));?></td>
                                    <td ><?php echo date('d-m-Y H:i:s',strtotime($dt->dateoperation));?></td>
                                    <td ><?php echo $dt->nmoperationcategory;?></td>
                                    <td ><?php echo $dt->nmstatus;?></td>
                                    <td ><a class="btn btn-sm btn-success" target="_blank" href="<?= site_url('assets/archive/documenlegal').'/'.$dt->attachment ?>" title="Download"><i class="fa fa-download"></i>
                                        </a></td>
                                    <td ><?php echo $dt->progress;?></td>

								</tr>
								<?php endforeach;?>	
                                    </tbody>		
						</table>

					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
</div>	
<!--  DETAIL MODAL -->
<?php foreach ($mst as $lb) { ?>
<div class="modal fade" id="dtlMst<?php echo str_replace('/','',trim($lb->docno));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"></h4>
	  </div>
<form action="#" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Dokumen Perkara</label>
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($lb->docref); ?>" class="form-control"  readonly>
								</div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-4">Dokumen System</label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo trim($lb->docno); ?>" class="form-control"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Type</label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo trim($lb->nmtype); ?>" class="form-control"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Nama Perkara</label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo trim($lb->docrefname); ?>" class="form-control"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Terlapor</label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo trim($lb->coperatorname); ?>" class="form-control"  readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Area</label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo trim($lb->nmbu); ?>" class="form-control"  readonly>
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
								<label class="col-sm-4">Tanggal Dokumen </label>
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm "   value="<?php if (!empty($lb->docdate)) { echo date('d-m-Y H:i:s', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  disabled readonly>
								</div>
							</div>
                            <div class="form-group ">
                                <label class="col-sm-4">Proses </label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo trim($lb->progress); ?>" class="form-control"  readonly>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-4">Penanganan </label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo trim($lb->nmdocname); ?>" class="form-control"  readonly>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-4">Keterangan </label>
                                <div class="col-sm-8">
                                    <input type="text" value="<?php echo trim($lb->description); ?>" class="form-control"  readonly>
                                </div>
                            </div>
						</div>	
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
	  </form>
</div></div></div>
<?php } ?>



<!--  DETAIL MODAL -->
<?php foreach ($dtl as $lx) { ?>
    <div class="modal fade" id="dtlDtl<?php echo str_replace('/','',trim($lx->docno).trim($lx->sort));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <form action="#" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box box-danger">
                                    <div class="box-body">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-4">Dokumen Perkara</label>
                                                <div class="col-sm-8">
                                                    <input type="text" value="<?php echo trim($lx->docref); ?>" class="form-control"  readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">Dokumen System</label>
                                                <div class="col-sm-8">
                                                    <input type="text" value="<?php echo trim($lx->docno); ?>" class="form-control"  readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">Type</label>
                                                <div class="col-sm-8">
                                                    <input type="text" value="<?php echo trim($lx->nmtype); ?>" class="form-control"  readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4">Terlapor</label>
                                                <div class="col-sm-8">
                                                    <input type="text" value="<?php echo trim($lx->coperatorname); ?>" class="form-control"  readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">Area</label>
                                                <div class="col-sm-8">
                                                    <input type="text" value="<?php echo trim($lx->nmbu); ?>" class="form-control"  readonly>
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
                                                <label class="col-sm-4">Tanggal Dokumen </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm "   value="<?php if (!empty($lx->docdate)) { echo date('d-m-Y H:i:s', strtotime(trim($lb->docdate))); } else { echo '';} ;?>"  disabled readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4">Tanggal Penanganan </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control input-sm "   value="<?php if (!empty($lx->dateoperation)) { echo date('d-m-Y H:i:s', strtotime($lx->dateoperation)); } else { echo '';} ;?>"  disabled readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4">Proses </label>
                                                <div class="col-sm-8">
                                                    <input type="text" value="<?php echo trim($lx->progress); ?>" class="form-control"  readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="col-sm-4">Penanganan </label>
                                                <div class="col-sm-8">
                                                    <input type="text" value="<?php echo trim($lx->nmdocname); ?>" class="form-control"  readonly>
                                                </div>
                                            </div>
                                            <!--<div class="form-group ">
                                                <label class="col-sm-4">Keterangan </label>
                                                <div class="col-sm-8">
                                                    <input type="text" value="<?php /*echo trim($lx->description); */?>" class="form-control"  readonly>
                                                </div>
                                            </div>-->
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </form>
            </div></div></div>
<?php } ?>

<script type="text/javascript">

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

</script>
	  