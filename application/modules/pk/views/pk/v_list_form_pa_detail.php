<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {

                $('#example1').Tabledit({
                    url: '<?php echo site_url('pk/pk/php_test')?>',
                    editButton: false,
                    deleteButton: false,
                    hideIdentifier: true,
                    columns: {
                        identifier: [1, 'branch'],
                        editable: [[3, 'value1'], [5, 'value2']]
                    }
                }).dataTable({ pageLength: 30 });




                $("#datatableMaster").dataTable();
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

				$("#example3").dataTable();
				$("#example4").dataTable();
				$(".inputfill").selectize();
				$('.tglYM').datepicker({
				    format: "yyyy-mm",
					viewMode: "months",
					minViewMode: "months"
				});


			  });
</script>
<style> selectize css
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
<!--div class="pull-right">Versi: <?php echo $version; ?></div--->
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>

<div class="row">
	<div class="col-sm-3">
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Filter"  href="#"><i class="fa fa-search"></i>Filter Pencarian</a></li>
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#ChoiceOfLetter"  href="#"><i class="fa fa-plus"></i>INPUT PA</a></li>
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/ajustment/input_ajustment_in_trgd")?>">Input Transfer Antar Gudang</a></li-->
				</ul>
			</div>
		<!--/div-->
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
                        <table id="datatableMaster" class="table table-bordered table-striped" >
                            <thead>
                            <tr>
                                <th width="2%">No.</th>
                                <th>NIK</th>
                                <th>NAMA LENGKAP</th>
                                <th>PERIODE</th>
                                <th width="8%">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $no=0; foreach($list_tx_pa_mst as $row): $no++;?>
                                <tr>
                                    <td width="2%"><?php echo $no;?></td>
                                    <td><?php echo $row->nik;?></td>
                                    <td><?php echo $row->nmlengkap;?></td>
                                    <td><?php echo $row->periode;?></td>
                                    <!--td><?php if (empty($row->docdate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->ajustment_date))); }?></td-->

                                    <td width="8%">
                                        <a href="<?php
                                        $enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
                                        $enc_periode=bin2hex($this->encrypt->encode(trim($row->periode)));
                                        echo site_url("pk/pk/form_detail_pa").'/'.$enc_nik.'/'.$enc_periode; ?>" class="btn btn-default  btn-sm" title="DETAIL KATEGORI KRITERIA"><i class="fa fa-bars"></i> </a>
                                        <?php /*	<!--a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->docno);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a-->

									<?php if (($row->lvl_jabatan)=='C' and trim($row->doctype)=='ISD') { ?>
										<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php
										$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
										$enc_doctype=bin2hex($this->encrypt->encode(trim($row->doctype)));
										$enc_planperiod=bin2hex($this->encrypt->encode(trim($row->planperiod)));
										echo site_url('pdca/pdca/sti_pdca_isidentil_spv/'.$enc_nik.'/'.$enc_doctype.'/'.$enc_planperiod);?>');"><i class="fa fa-print"></i>CETAK</button>
									<?php } else if (($row->lvl_jabatan)!='C' and trim($row->doctype)=='ISD') { ?>
										<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php
										$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
										$enc_doctype=bin2hex($this->encrypt->encode(trim($row->doctype)));
										$enc_planperiod=bin2hex($this->encrypt->encode(trim($row->planperiod)));
										echo site_url('pdca/pdca/sti_pdca_isidentil/'.$enc_nik.'/'.$enc_doctype.'/'.$enc_planperiod);?>');"><i class="fa fa-print"></i>CETAK</button>
									<?php } else if (trim($row->doctype)=='BRK') { ?>
										<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php
										$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
										$enc_doctype=bin2hex($this->encrypt->encode(trim($row->doctype)));
										$enc_planperiod=bin2hex($this->encrypt->encode(trim($row->planperiod)));
										echo site_url('pdca/pdca/sti_pdca_berkala/'.$enc_nik.'/'.$enc_doctype.'/'.$enc_planperiod);?>');"><i class="fa fa-print"></i>CETAK</button>
									<?php } ?>
								*/ ?>
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
                                            <th>DESKRIPSI</th>
                                            <th>NAMA ATASAN1</th>
                                            <th>VALUE1</th>
											<th>NAMA ATASAN2</th>
											<th>VALUE2</th>
											<th width="8%">AKSI</th>
										</tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_tx_pa_dtl as $row): $no++;?>
								<tr>
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->description;?></td>
									<td><?php echo $row->nmatasan1;?></td>
									<td><?php echo $row->value1;?></td>
									<td><?php echo $row->nmatasan2;?></td>
									<td><?php echo $row->value2;?></td>
									<!--td><?php if (empty($row->docdate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->ajustment_date))); }?></td-->

									<td width="8%">
									<a href="<?php
									$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
									$enc_periode=bin2hex($this->encrypt->encode(trim($row->periode)));
									echo site_url("pk/pk/form_detail_pa").'/'.$enc_nik.'/'.$enc_periode; ?>" class="btn btn-default  btn-sm" title="DETAIL KATEGORI KRITERIA"><i class="fa fa-bars"></i> </a>
                                <?php /*	<!--a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->docno);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a-->

									<?php if (($row->lvl_jabatan)=='C' and trim($row->doctype)=='ISD') { ?>
										<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php
										$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
										$enc_doctype=bin2hex($this->encrypt->encode(trim($row->doctype)));
										$enc_planperiod=bin2hex($this->encrypt->encode(trim($row->planperiod)));
										echo site_url('pdca/pdca/sti_pdca_isidentil_spv/'.$enc_nik.'/'.$enc_doctype.'/'.$enc_planperiod);?>');"><i class="fa fa-print"></i>CETAK</button>
									<?php } else if (($row->lvl_jabatan)!='C' and trim($row->doctype)=='ISD') { ?>
										<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php
										$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
										$enc_doctype=bin2hex($this->encrypt->encode(trim($row->doctype)));
										$enc_planperiod=bin2hex($this->encrypt->encode(trim($row->planperiod)));
										echo site_url('pdca/pdca/sti_pdca_isidentil/'.$enc_nik.'/'.$enc_doctype.'/'.$enc_planperiod);?>');"><i class="fa fa-print"></i>CETAK</button>
									<?php } else if (trim($row->doctype)=='BRK') { ?>
										<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php
										$enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
										$enc_doctype=bin2hex($this->encrypt->encode(trim($row->doctype)));
										$enc_planperiod=bin2hex($this->encrypt->encode(trim($row->planperiod)));
										echo site_url('pdca/pdca/sti_pdca_berkala/'.$enc_nik.'/'.$enc_doctype.'/'.$enc_planperiod);?>');"><i class="fa fa-print"></i>CETAK</button>
									<?php } ?>
								*/ ?>
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
		<h4 class="modal-title" id="myModalLabel"> PILIH PERIODE GENERATE KRITERIA </h4>
	  </div>
<!--form action="<?php echo site_url('pk/pk/list_nik_from_nik_atasan')?>" method="post" name="inputNik"-->
<form action="<?php echo site_url('pk/pk/pk_generate_all_karyawan_kriteria')?>" method="post" name="inputNik">
<div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">PILIH PERIODE PDCA </label>
                                    <div class="col-sm-8">
                                        <input type="input" name="periode" id="periode" class="form-control input-sm  tglYM"  >
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
        <button type="submit" id="submit"  class="btn btn-primary">GENERATE</button>
      </div>
	  </form>
</div></div></div>


<div class="modal fade" id="Filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN UNTUK PDCA </h4>
	  </div>
<form action="<?php echo site_url('pdca/pdca/form_pdca')?>" method="post" name="inputformPbk">
<div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group ">
									<label class="col-sm-4" for="inputsm">PILIH TIPE PDCA </label>
									<div class="col-sm-8">
										<select class="form-control input-sm inputfill" name="inputfill " required>
											<option value="ISD"> ISIDENTIL </option>
											<option value="BRK"> BERKALA </option>
										</select>
									</div>
							</div>
							<div class="form-group ">
									<label class="col-sm-4" for="inputsm">PILIH PERIODE PDCA </label>
									<div class="col-sm-8">
										<input type="input" name="tglYM" id="tglYM" class="form-control input-sm  tglYM"  >
									</div>
							</div>
							<div class="form-group ">
									<label class="col-sm-4" for="inputsm">PILIH NAMA KARYAWAN </label>
									<div class="col-sm-8">
									<select class="form-control input-sm inputfill" name="nik" id="nik">
										<option value=""><tr><th width="20%">-- NIK |</th><th width="80%">| NAMA KARYAWAN --</th></tr></option>
										<?php foreach($list_nik as $sc){?>
										<option value="<?php echo trim($sc->nik);?>" ><tr><th width="20%"><?php echo trim($sc->nik);?>  |</th><th width="80%">| <?php echo trim($sc->nmlengkap);?></th></tr></option>
										<?php }?>
									</select>
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