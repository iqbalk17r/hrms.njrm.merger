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
<h5><b><strong><?php echo '  UBAH DETAIL FORM LEGAL ';?></strong></b></h5>

<div class="row">
							
		<div class="col-sm-12">		
			<a href="<?php echo site_url("legal/legality/form_legal")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>

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
                <div class="dropdown ">
                    <button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input Detail
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
                        <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#inputDetailLegal"  href="#"><i class="fa fa-pencil">  Input Detail</i></a></li>
                    </ul>
                </div>
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
											<th>TglDokumen</th>
											<th>TglPenanganan</th>
											<th>Penanganan</th>
											<th>Status</th>
											<th>Lampiran</th>
											<th>Progress</th>
											<th>Description</th>
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($dtl as $dt): $no++;?>
								<tr>
									
									<td width="2%"><?php echo $no;?></td>
                                    <td width="8%">
                                        <a href="#" data-toggle="modal" data-target="#dtlDtl<?php echo str_replace('/','',trim($dt->docno)).trim($dt->sort);?>" class="btn btn-default  btn-sm" title="Detail"><i class="fa fa-bars"></i> </a>
                                        <?php if (trim($dt->status)==='A') { ?>
                                            <a href="#" data-toggle="modal" data-target="#dtlDtlDelete<?php echo str_replace('/','',trim($dt->docno)).trim($dt->sort);?>" class="btn btn-danger  btn-sm" title="Hapus Detail"><i class="fa fa-trash"></i> </a>
                                        <?php } ?>

                                    </td>
                                    <td width="8%"><?php echo date('d-m-Y',strtotime($dt->docdate));?></td>
                                    <td width="8%"><?php echo date('d-m-Y',strtotime($dt->dateoperation));?></td>
                                    <td ><?php echo $dt->nmoperationcategory;?></td>
                                    <td ><?php echo $dt->nmstatus;?></td>
                                    <td >
                                        <?php if (empty($dt->attachment)) { ?>
                                            <a class="btn btn-sm btn-default" href="#" title="Download"><i class="fa fa-download"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a class="btn btn-sm btn-success" target="_blank" href="<?= site_url('assets/archive/documenlegal').'/'.$dt->attachment ?>" title="Download"><i class="fa fa-download"></i>
                                            </a>
                                        <?php }?>


                                    </td>
                                    <td ><?php echo $dt->progress;?></td>
                                    <td ><?php echo $dt->description;?></td>

								</tr>
								<?php endforeach;?>	
                                    </tbody>		
						</table>

					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
</div>

<!-- INPUTAN DETAIL -->
<div class="modal fade" id="inputDetailLegal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Input Detail Legalitas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo site_url('legal/legality/save_legal') ?>" id="formdetail" class="form-horizontal formdetail"  method="post" role="form" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="box-body">
                        <div class="form-group">
                            <label for="docno_mdl">Sistem Document</label>
                            <input type="hidden" class="form-control form-control-sm" id="type" name="type" value="<?= 'INPUT_DETAIL_HIS' ?>" readonly>
                            <input type="hidden" class="form-control form-control-sm" id="sort" name="sort" value="<?= $mstRow['sort'] ?>" readonly>
                            <input type="text" class="form-control form-control-sm" id="docno" name="docno" value="<?= $mstRow['docno'] ?>" placeholder="System Document" readonly>
                        </div>
                        <div class="form-group">
                            <label for="docno_mdl">Reference Document</label>
                            <input type="text" class="form-control form-control-sm" id="docref" name="docref" value="<?= $mstRow['docref'] ?>" placeholder="Reference Document" readonly>
                        </div>

                        <div class="form-group">
                            <label>Pilih Tanggal Penyelesaian</label>
                            <input type="text" class="form-control form-control-sm" id="dateoperation" name="dateoperation" placeholder="Tanggal Penyelesaian">
                        </div>
                        <div class="form-group">
                            <label>Kategori Penanganan</label>
                            <select class="form-control" style="width: 100%;" id="operationcategory" name="operationcategory" >

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Progress</label>
                            <input type="text" class="form-control" style="width: 100%;text-transform: uppercase;" id="progress" name="progress" maxlength="50" required>

                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea type="text" class="form-control" style="width: 100%;text-transform: uppercase;" id="description" name="description" maxlength="100" ></textarea>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="attachment" name="attachment">
                                    <label class="custom-file-label" for="attachment">Pilih File/Dokumen</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary float-right" id="saveDetail" ><i class="fa fa-save"></i> Tambah Detail </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- INPUTAN DETAIL -->






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
                    <h4 class="modal-title" id="myModalLabel">Detail Legal</h4>
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
                                                    <input type="hidden" class="form-control form-control-sm" id="type" name="type" value="<?= 'xx' ?>" readonly>
                                                    <input type="hidden" class="form-control form-control-sm" id="sort" name="sort" value="<?php echo trim($lx->sort); ?>" readonly>
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



<!--  DETAIL DELETE MODAL -->
<?php foreach ($dtl as $lx) { ?>
    <div class="modal fade" id="dtlDtlDelete<?php echo str_replace('/','',trim($lx->docno).trim($lx->sort));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel"> Hapus Detail Legal</h4>
                </div>
                <form action="<?php echo site_url('legal/legality/save_legal') ?>" id="formdetail" class="form-horizontal formdetail"  method="post" role="form" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box box-danger">
                                    <div class="box-body">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-4">Dokumen Perkara</label>
                                                <div class="col-sm-8">
                                                    <input type="hidden" class="form-control form-control-sm" id="type" name="type" value="<?= 'DEL_DETAIL_HIS' ?>" readonly>
                                                    <input type="hidden" class="form-control form-control-sm" id="sort" name="sort" value="<?php echo trim($lx->sort); ?>" readonly>
                                                    <input type="text"  name="docref" value="<?php echo trim($lx->docref); ?>" class="form-control"  readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">Dokumen System</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="docno" value="<?php echo trim($lx->docno); ?>" class="form-control"  readonly>
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
                        <button type="submit" class="btn btn-danger float-right" id="delDetail" ><i class="fa fa-trash"></i> Hapus Detail </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </form>
            </div></div></div>
<?php } ?>


<script type="text/javascript">
    $('#dateoperation').datepicker();

    /* START KATEGORI PENANGANAN */
    var defaultInitialOperationCategory = " and jenistrx='I.D.A.1_KTG'";
    $("#operationcategory").select2({
        placeholder: "Pilih Dokumen Kategori Penanganan",
        allowClear: true,
        ajax: {
            url: base('api/globalmodule/option_trxtype'),
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    _search_: params.term, // search term
                    _page_: params.page,
                    _draw_: true,
                    _start_: 1,
                    _perpage_: 2,
                    _paramglobal_: defaultInitialOperationCategory,
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 0,
        templateResult: formatRepoOperationCategory,
        templateSelection: formatRepoSelectionOperationCategory
    });

    function formatRepoOperationCategory(repo) {
        if (repo.loading) return repo.text;
        var markup = "<div class='select2-result-repository__title'>" + repo.kdtrx + " || " + repo.uraian + "</div>";
        return markup;
    }
    function formatRepoSelectionOperationCategory(repo) {
        return repo.uraian || repo.text;
    }

    /* END KATEGORI PENANGANAN */

</script>
	  