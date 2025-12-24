<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {

             /*   $('#example1').Tabledit({
                    url: '<!?php echo site_url('pk/pk/php_test')?>',
                    editButton: false,
                    deleteButton: false,
                    hideIdentifier: true,
                    columns: {
                       // identifier: [[1, 'nodok'],[2, 'periode'],[3, 'kdkriteria'],[4, 'nik']],
                        //editable: [[7, 'value1'], [9, 'value2']]
                    }
                }).dataTable({ pageLength: 30 });*/


				$('#example1').dataTable({  lengthMenu: [ [70, -1], [70, "All"] ],pageLength: 70 });

				
				
                $("#datatableMaster").dataTable();
				/*    var table = $('#example1').DataTable({
					   lengthMenu: [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
					   pageLength: 4
					}); */


				$("#example3").dataTable();
				$("#example4").dataTable();
				$(".inputfill").selectize();
				$('.tglYM').datepicker({
				    format: "yyyy-mm",
					viewMode: "months",
					minViewMode: "months"
				});

				$('form').on('focus', 'input[type=number]', function (e) {
					  $(this).on('mousewheel.disableScroll', function (e) {
						e.preventDefault()
					  })
				})	
			  });
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
</style>
<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
        <?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>
            <li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>
        <?php } else { ?>
            <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
        <?php } ?>
    <?php } ?>
</ol>
<h3><?php echo $title; ?></h3>

<?php echo $message;?>

<div class="row">
				<div class="col-sm-12">
					<a href="<?php echo site_url("pk/pk/form_inspeksi")?>"  class="btn btn-default" style="margin:10px; color:#000000;"><i class="fa fa-arrow-left"></i>Kembali</a>
                    <?php if (trim($dtlrow['status'])=='A') { ?>
                    <a href="<?php echo site_url("pk/pk/approval_input_inspek".'/'.trim($dtlrow['nik']).'/'.trim($dtlrow['periode']))?>"  class="btn btn-success pull-right" onclick="return confirm('Apakah Anda APPROVAL Final Data Ini??')" style="margin:10px; color:#ffffff;"><i class="fa fa-save"></i>APPROVAL </a>
                    <?php } ?>
				</div>

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
                        <table id="datatableMaster" class="table table-bordered table-striped" >
                            <thead>
                            <tr>
                                <th width="2%">No.</th>
                                <th>NODOK</th>
                                <th>NIK</th>
                                <th>NAMA LENGKAP</th>
                                <th>ATITUDE</th>
                                <th>SKILL</th>
                                <th>KEPATUHAN</th>
                                <th>AVG IK</th>
                                <th>AVG ASK</th>
								<th>BBT IK</th>
                                <th>BBT ASK</th>
                                <th>FS</th>
                                <th>KTG FS</th>
                                <th>DESC FS</th>
                                <th>PERIODE</th>
                                <th>STATUS</th>
                                <th width="8%">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $no=0; foreach($list_trx_pa_mst as $row): $no++;?>
                                <tr>
                                    <td width="2%"><?php echo $no;?></td>
                                    <td><?php echo $row->nodok;?></td>
                                    <td><?php echo $row->nik;?></td>
                                    <td><?php echo $row->nmlengkap;?></td>
                                    <td align="right"><?php echo $row->ttlvalue1;?></td>
                                    <td align="right"><?php echo $row->ttlvalue2;?></td>
                                    <td align="right"><?php echo $row->ttlvalue3;?></td>
                                    <td align="right"><?php echo $row->f_avg_valueik;?></td>
                                    <td align="right"><?php echo $row->f_avg_valueask;?></td>
									<td align="right"><?php echo $row->b_valueik;?></td>
                                    <td align="right"><?php echo $row->b_valueask;?></td>
                                    <td align="right"><?php echo $row->f_fs;?></td>
                                    <td align="right"><?php echo $row->f_ktg_v_fs;?></td>
                                    <td align="right"><?php echo $row->f_desc_v_fs;?></td>
                                    <td><?php echo $row->periode;?></td>
									<td><?php echo $row->nmstatus;?></td>
                                    <!--td><?php if (empty($row->docdate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->ajustment_date))); }?></td-->

                                    <td width="8%">
										<!--a href="#" data-toggle="modal" data-target="#EDMST<?php echo str_replace('.','',trim($row->nodok)).str_replace('.','',trim($row->nik)).str_replace('.','',trim($row->periode));?>" class="btn btn-primary  btn-sm" title="Edit Master Instruksi Kerja"><i class="fa fa-gear"></i></a---> 
										<a href="#" data-toggle="modal" data-target="#DTLMST<?php echo str_replace('/','',trim($row->nodok)).str_replace('.','',trim($row->nik)).str_replace('.','',trim($row->periode));?>" class="btn btn-default  btn-sm" title="Detail Master Instruksi Kerja"><i class="fa fa-bars"></i></a> 
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
                                            <th  style="display:none">NODOK</th>
                                            <th  style="display:none">PERIODE</th>
                                            <th>KDPA</th>
                                            <th  style="display:none">KDAREA</th>
                                            <th  style="display:none">NIK</th>
                                            <th>DESKRIPSI</th>
											<th>VALUE</th>
											<th>STATUS</th>
											
											<th width="5%">AKSI</th>
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_trx_pa_dtl as $row): $no++;?>
								<tr>
									<td width="2%"><?php echo $no;?></td>
									<td  style="display:none"><?php echo $row->nodok;?></td>
									<td  style="display:none"><?php echo $row->periode;?></td>
									<td><?php echo $row->kdpa;?></td>
									<td  style="display:none"><?php echo $row->kdarea;?></td>
									<td  style="display:none"><?php echo $row->nik;?></td>
									<td><?php echo $row->description;?></td>

									<td align="right"><?php echo $row->valueik;?></td>
<!---?php } ?--->
									<td><?php echo $row->nmstatus;?></td>
									<td width="5%">
									<a href="#" data-toggle="modal" data-target="#EDDTL<?php echo str_replace('/','',trim($row->nodok)).str_replace('.','',trim($row->nik)).str_replace('.','',trim($row->periode)).trim($row->nomor);?>" class="btn btn-default  btn-sm" title="Detail Nilai"><i class="fa fa-bars"></i></a>
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



<?php foreach ($list_trx_pa_mst as $lb) { ?>
<div class="modal fade" id="DTLMST<?php echo str_replace('/','',trim($lb->nodok)).str_replace('.','',trim($lb->nik)).str_replace('.','',trim($lb->periode));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> DETAIL MASTER DARI KATEGORI ASPEK</h4>
	  </div>
<form action="<?php echo site_url('pk/pk/save_pa')?>" method="post" name="Form">
<div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">KODE KRITERIA</label>
                                    <div class="col-sm-8">
                                        
                                        <input type="hidden" name="nik" id="nik" value="<?php echo trim($lb->nik); ?>"class="form-control input-sm"  readonly>
                                        <input type="input" name="nmlengkap" id="nmlengkap" value="<?php echo trim($lb->nmlengkap); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="nodok" id="nodok" value="<?php echo trim($lb->periode); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="periode" id="periode" value="<?php echo trim($lb->periode); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="nikatasan1" id="nikatasan1" value="<?php echo trim($lb->nikatasan1); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="nikatasan2" id="nikatasan2" value="<?php echo trim($lb->nikatasan2); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="type" id="type" value="DETAILPA"class="form-control input-sm"  readonly>
										
                                    </div>
                            </div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">PERIODE</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="periode" id="periode" value="<?php echo trim($lb->periode); ?> "class="form-control input-sm"  readonly>
                                    </div>
                            </div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">NAMA ATASAN 1</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="nmatasan1" id="nmatasan1" value="<?php echo trim($lb->nmatasan1); ?> "class="form-control input-sm"  readonly>
                                    </div>
                            </div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">NAMA ATASAN 2</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="nmatasan2" id="nmatasan2" value="<?php echo trim($lb->nmatasan2); ?> "class="form-control input-sm"  readonly>
                                    </div>
                            </div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">DESKIRPSI KATEGORI</label>
                                    <div class="col-sm-8">
                                        <input type="input" name="description" id="description" value="<?php echo trim($lb->description); ?> "class="form-control input-sm"  readonly>
                                    </div>
                            </div>
							<div class="form-group ">
								
								<label class="col-sm-3" for="inputsm">ATITUDE</label>
                                    <div class="col-sm-3">
                                        <input type="number" name="ttlvalue1" id="ttlvalue1" value="<?php echo trim(round($lb->ttlvalue1)); ?>" style="text-align: right" class="form-control input-sm"  min="1" max="5"  readonly />
                                    </div>
								
								<label class="col-sm-3" for="inputsm">SKILL</label>
                                    <div class="col-sm-3">
                                        <input type="number" name="ttlvalue2" id="ttlvalue2" value="<?php echo trim(round($lb->ttlvalue2)); ?>" style="text-align: right" class="form-control input-sm"  min="1" max="5"  readonly />
                                    </div>
						     </div>
							 <div class="form-group ">							 
								<label class="col-sm-3" for="inputsm">KEPATUHAN</label>
                                    <div class="col-sm-3">
                                        <input type="number" name="ttlvalue3" id="ttlvalue3" value="<?php echo trim(round($lb->ttlvalue3)); ?>" style="text-align: right" class="form-control input-sm"  min="1" max="5"  readonly />
                                    </div>
															 
								<label class="col-sm-3" for="inputsm">TTL IK</label>
                                    <div class="col-sm-3">
                                        <input type="number" name="ttlvalueik" id="ttlvalueik" value="<?php echo trim(round($lb->ttlvalueik)); ?>" style="text-align: right" class="form-control input-sm"  min="1" max="5"  readonly />
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
        <!--button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button--->
      </div>
	  </form>
</div></div></div>
<?php } ?>


<?php foreach ($list_trx_pa_dtl as $lb) { ?>
<div class="modal fade" id="EDDTL<?php echo str_replace('/','',trim($lb->nodok)).str_replace('.','',trim($lb->nik)).str_replace('.','',trim($lb->periode)).trim($lb->nomor);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> DETAIL INSPEKSI</h4>
	  </div>
<form action="<?php echo site_url('pk/pk/save_inspek')?>" method="post" name="Form">
<div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">NOMOR DOKUMEN</label>
                                    <div class="col-sm-12">
                                        <input type="input" name="kdpa" id="kdpa" value="<?php echo trim($lb->kdpa); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="kdarea" id="kdarea" value="<?php echo trim($lb->kdarea); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="nik" id="nik" value="<?php echo trim($lb->nik); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="nodok" id="nodok" value="<?php echo trim($lb->periode); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="periode" id="periode" value="<?php echo trim($lb->periode); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="nikatasan1" id="nikatasan1" value="<?php echo trim($lb->nikatasan1); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="nikatasan2" id="nikatasan2" value="<?php echo trim($lb->nikatasan2); ?>"class="form-control input-sm"  readonly>
                                        <input type="hidden" name="type" id="type" value="EDITDTLINSPEK"class="form-control input-sm"  readonly>
										
                                    </div>
                            </div>
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">DESKIRPSI KATEGORI</label>
                                    <div class="col-sm-12">
                                        <input type="input" name="description" id="description" value="<?php echo trim($lb->description); ?> "class="form-control input-sm"  readonly>
                                    </div>
                            </div>
							<div class="form-group ">
								
								<label class="col-sm-4" for="inputsm">VALUE</label>
                                    <div class="col-sm-12">
                                        <input type="number" name="valueik" id="valueik" value="<?php echo trim(round($lb->valueik)); ?>" style="text-align: right" class="form-control input-sm"  min="1" max="5" READONLY />
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
        <!--button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button-->
      </div>
	  </form>
</div></div></div>
<?php } ?>



<script>
	//Date range picker
    	$("#tgl").datepicker();
    	$(".tglan").datepicker();
</script>