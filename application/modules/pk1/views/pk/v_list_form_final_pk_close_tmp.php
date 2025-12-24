<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {

              /*  $('#example1_1').Tabledit({
                    url: '<!?php echo site_url('pk/pk/php_test')?>',
                    editButton: false,
                    deleteButton: false,
                    hideIdentifier: true,
                    columns: {
                        identifier: [1, 'branch'],
                        editable: [[2, 'nik'],[3, 'nmlengkap'], [4, 'lastname']]
                    }
                }).dataTable(); */




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
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>


<div class="row">
    <div class="col-sm-11">
        <a href="<?php echo site_url("pk/pk/clear_input_penilaian_karyawan")?>" onclick="return confirm('Kembali Akan Mereset Semua Inputan Anda Yakin??')" class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
    </div>
    <?php if(in_array(trim($dtlcoll['status']),array('I','E'))) { ?>
    <div class="col-sm-1">
        <a href="<?php
        $enc_periode=bin2hex($this->encrypt->encode(trim($dtlcoll['periode'])));
        $enc_dept=bin2hex($this->encrypt->encode(trim($dtlcoll['kddept'])));
        echo site_url("pk/pk/hitung_ulang_final_score".'/'.$enc_periode.'/'.$enc_dept)?>" onclick="return confirm('Rebalance Akan Dilakukan , Inputan Tersisa Akan DIsispkan, Anda Yakin..?')" class="btn btn-warning" style="margin:10px; color:#000000;"><i class="fa fa-repeat"></i></a>
    </div>
    <?php } ?>
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
                    <table id="example3" class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th width="2%">No.</th>
                            <th>NIK</th>
                            <th>NAMA LENGKAP</th>
                            <th>JABATAN</th>
                            <th>KPI    </th>
                            <th>KDT</th>
                            <th>PA </th>
                            <th>STATUS</th>

                            <th width="8%">AKSI</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=0; foreach($list_dtl_final_pk as $row): $no++;?>
                            <tr>
                                <td width="2%"><?php echo $no;?></td>
                                <td><?php echo $row->nik;?></td>
                                <td><?php echo $row->nmlengkap;?></td>
                                <td><?php echo $row->nmjabatan;?></td>
                                <td align="right"><?php if ($row->fs1_kpi==''){ echo '0'; } else { echo $row->fs1_kpi; } ?></td>
                                <td align="right"><?php if ($row->fs1_kondite==''){ echo '0'; } else { echo $row->fs1_kondite; } ?></td>
                                <td align="right"><?php if ($row->fs1_pa==''){ echo '0'; } else { echo $row->fs1_pa; } ?></td>
                                <td><?php echo $row->nmstatus;?></td>
                                <!--td><?php if (empty($row->docdate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->ajustment_date))); }?></td-->

                                <td width="8%">
                                    <?php if (in_array(trim($dtlcoll['status']), array('I','E'))) { ?>
                                        <a href="<?php
                                        $enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
                                        $enc_periode=bin2hex($this->encrypt->encode(trim($row->periode)));
                                        echo site_url("pk/pk/edit_final_penilaian_karyawan_tmp").'/'.$enc_nik.'/'.$enc_periode; ?>" class="btn btn-primary  btn-sm" title="UBAH FINAL PENILAIAN KARYAWAN"><i class="fa fa-gear"></i> </a>
                                    <?php } else { ?>
                                        <a href="<?php
                                        $enc_nik=bin2hex($this->encrypt->encode(trim($row->nik)));
                                        $enc_periode=bin2hex($this->encrypt->encode(trim($row->periode)));
                                        echo site_url("pk/pk/detail_final_penilaian_karyawan").'/'.$enc_nik.'/'.$enc_periode; ?>" class="btn btn-default  btn-sm" title="DETAIL FINAL PENILAIAN KARYAWAN"><i class="fa fa-bars"></i> </a>
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
                        <th>Dokumen</th>
                        <th>PERIODE</th>
                        <th>NAMA DEPARTMENT</th>
                        <th>STATUS</th>
                        <th width="8%">AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=0; foreach($list_rkp_final_pk as $row): $no++;?>
                        <tr>
                            <td width="2%"><?php echo $no;?></td>
                            <td><?php echo $row->nodok;?></td>
                            <td><?php echo $row->periode;?></td>
                            <td><?php echo $row->nmdept;?></td>
                            <td><?php echo $row->nmstatus;?></td>
                            <!--td><!?php if (empty($row->docdate)) { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->ajustment_date))); }?></td-->

                            <td width="8%">
                                <a href="<?php
                                $enc_periode=bin2hex($this->encrypt->encode(trim($row->periode)));
                                echo site_url("pk/pk/final_input_penilaian_karyawan").'/'.$enc_periode; ?>" onclick="return confirm('Inputan Akan Diproses Final, Apakah anda yakin data anda benar ?')" class="btn btn-success  btn-sm" title="FINAL"><i class="fa fa-check-circle-o"></i> </a>

                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>


<div class="modal fade" id="ChoiceOfLetter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> PILIH PERIODE PENILAIAN KARYAWAN </h4>
	  </div>

<!--form action="<!?php echo site_url('pk/pk/list_nik_from_nik_atasan_final_pk')?>" method="post" name="inputPeriode"-->
<form action="<?php echo site_url('pk/pk/generate_perdept_final_pk_rekap_tmp')?>" method="post" name="inputPeriode">
<div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">PILIH PERIODE NIK </label>
                                    <div class="col-sm-8">
                                        <input type="input" name="periode" id="periode" class="form-control input-sm  tglYM"  required>
                                    </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-4" for="inputsm">PILIH DEPARTMENT </label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm inputfill" name="dept" id="dept" required>
                                        <option value=""><tr><th width="20%">-- Kode Dept |</th><th width="80%">| Department --</th></tr></option>
                                        <?php foreach($list_dept as $sc){?>
                                            <option value="<?php echo trim($sc->kddept);?>" ><tr><th width="20%"><?php echo trim($sc->kddept);?>  |</th><th width="80%">| <?php echo trim($sc->nmdept);?></th></tr></option>
                                        <?php }?>
                                    </select>
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
        <button type="submit" id="submit"  class="btn btn-primary">PROSES</button>
      </div>
	  </form>
</div></div></div>


<div class="modal fade" id="Filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> FILTER PENILAIAN KARYAWAN </h4>
	  </div>
<form action="<?php echo site_url('pk/pk/form_report_final')?>" method="post" name="inputformPbk">
<div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group ">
									<label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
									<div class="col-sm-8">
										<input type="input" name="periode" id="periode" class="form-control input-sm  tglYM"  required >
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
                            <div class="form-group ">
                                <label class="col-sm-4" for="inputsm">PILIH DEPARTMENT </label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm inputfill" name="dept" id="dept">
                                        <option value=""><tr><th width="20%">-- Kode Dept |</th><th width="80%">| Department --</th></tr></option>
                                        <?php foreach($list_dept as $sc){?>
                                            <option value="<?php echo trim($sc->kddept);?>" ><tr><th width="20%"><?php echo trim($sc->kddept);?>  |</th><th width="80%">| <?php echo trim($sc->nmdept);?></th></tr></option>
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
        <button type="submit" id="submit"  class="btn btn-primary">PROSES</button>
      </div>
	  </form>
</div></div></div>

<script>
	//Date range picker
    	$("#tgl").datepicker();
    	$(".tglan").datepicker();
</script>