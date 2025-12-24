<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
/* 
                $('#example1').Tabledit({
                    url: '<?php echo site_url('pk/pk/php_test')?>',
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

.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:10px;padding:10px 0px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:10px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-lkh3{background-color:#9aff99}
.tg .tg-baqh{text-align:center;vertical-align:top}
.tg .tg-wsnc{background-color:#fffc9e}
.tg .tg-yp2e{background-color:#9698ed}
</style>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>

<?php echo $message;?>

<div class="row">
	<div class="col-sm-3">
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Filter
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Filter"  href="#"><i class="fa fa-search"></i>Filter Pencarian</a></li>
				   <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Download"  href="#"><i class="fa fa-download"></i>Download Xls</a></li>
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#ChoiceOfLetter"  href="#"><i class="fa fa-plus"></i>INPUT PA</a></li--->
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("pk/pk/list_nik_from_nik_atasan")?>">Input PA</a></li-->
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
						<table id="example1" class="table table-bordered table-striped tg" >
							<thead>
										   <tr>
											<th class="tg-031e" rowspan="2">NO</th>
											<th class="tg-031e" rowspan="2">NIK</th>
											<th class="tg-031e" rowspan="2">NAMA LENGKAP</th>
											<th class="tg-031e" rowspan="2">BAGIAN</th>
											<th class="tg-031e" rowspan="2">JABATAN</th>
											<th class="tg-031e" rowspan="2">PERIODE</th>
											<th class="tg-031e" rowspan="2">(A)</th>
											<th class="tg-031e" rowspan="2">(S)</th>
											<th class="tg-031e" rowspan="2">(K)</th>
											<th class="tg-yp2e" colspan="70" > <center><strong>NILAI INSTRUKSI KERJA</strong></center> </th>
											<th class="tg-031e" rowspan="2">TTL IK </th>
											<th class="tg-031e" rowspan="2">TTL ASK</th>
											<th class="tg-031e" rowspan="2">BOBOT ASK 30%</th>
											<th class="tg-031e" rowspan="2">BOBOT IK 70%</th>
											<th class="tg-031e" rowspan="2">FS </th>
											<th class="tg-031e" rowspan="2">FS DESC</th>
										  </tr>
										  <tr>
											<td class="tg-wsnc">1</td>
											<td class="tg-lkh3">2</td>
											<td class="tg-wsnc">3</td>
											<td class="tg-lkh3">4</td>
											<td class="tg-wsnc">5</td>
											<td class="tg-lkh3">6</td>
											<td class="tg-wsnc">7</td>
											<td class="tg-lkh3">8</td>
											<td class="tg-wsnc">9</td>
											<td class="tg-lkh3">10</td>
											<td class="tg-wsnc">11</td>
											<td class="tg-lkh3">12</td>
											<td class="tg-wsnc">13</td>
											<td class="tg-lkh3">14</td>
											<td class="tg-wsnc">15</td>
											<td class="tg-lkh3">16</td>
											<td class="tg-wsnc">17</td>
											<td class="tg-lkh3">18</td>
											<td class="tg-wsnc">19</td>
											<td class="tg-lkh3">20</td>
											<td class="tg-wsnc">21</td>
											<td class="tg-lkh3">22</td>
											<td class="tg-wsnc">23</td>
											<td class="tg-lkh3">24</td>
											<td class="tg-wsnc">25</td>
											<td class="tg-lkh3">26</td>
											<td class="tg-wsnc">27</td>
											<td class="tg-lkh3">28</td>
											<td class="tg-wsnc">29</td>
											<td class="tg-lkh3">30</td>
											<td class="tg-wsnc">31</td>
											<td class="tg-lkh3">32</td>
											<td class="tg-wsnc">33</td>
											<td class="tg-lkh3">34</td>
											<td class="tg-wsnc">35</td>
											<td class="tg-lkh3">36</td>
											<td class="tg-wsnc">37</td>
											<td class="tg-lkh3">38</td>
											<td class="tg-wsnc">39</td>
											<td class="tg-lkh3">40</td>
											<td class="tg-wsnc">41</td>
											<td class="tg-lkh3">42</td>
											<td class="tg-wsnc">43</td>
											<td class="tg-lkh3">44</td>
											<td class="tg-wsnc">45</td>
											<td class="tg-lkh3">46</td>
											<td class="tg-wsnc">47</td>
											<td class="tg-lkh3">48</td>
											<td class="tg-wsnc">49</td>
											<td class="tg-lkh3">50</td>
											<td class="tg-wsnc">51</td>
											<td class="tg-lkh3">52</td>
											<td class="tg-wsnc">53</td>
											<td class="tg-lkh3">54</td>
											<td class="tg-wsnc">55</td>
											<td class="tg-lkh3">56</td>
											<td class="tg-wsnc">57</td>
											<td class="tg-lkh3">58</td>
											<td class="tg-wsnc">59</td>
											<td class="tg-lkh3">60</td>
											<td class="tg-wsnc">61</td>
											<td class="tg-lkh3">62</td>
											<td class="tg-wsnc">63</td>
											<td class="tg-lkh3">64</td>
											<td class="tg-wsnc">65</td>
											<td class="tg-lkh3">66</td>
											<td class="tg-wsnc">67</td>
											<td class="tg-lkh3">68</td>
											<td class="tg-wsnc">69</td>
											<td class="tg-lkh3">70</td>
										  </tr>
							</thead>
							<tbody>
									<?php $no=0; foreach($list_report as $row): $no++;?>
								<tr>
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nik;?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->nmsubdept;?></td>
									<td><?php echo $row->nmjabatan;?></td>
									<td><?php echo $row->periode;?></td>
									<td align="right"><?php echo $row->ttlvalue1;?></td>
									<td align="right"><?php echo $row->ttlvalue2;?></td>
									<td align="right"><?php echo $row->ttlvalue3;?></td>
									<td align="right"><?php if (trim($row->na1 )=='0') { echo '';} else { echo $row->na1 ; }?></td>
									<td align="right"><?php if (trim($row->na2 )=='0') { echo '';} else { echo $row->na2 ; }?></td>
									<td align="right"><?php if (trim($row->na3 )=='0') { echo '';} else { echo $row->na3 ; }?></td>
									<td align="right"><?php if (trim($row->na4 )=='0') { echo '';} else { echo $row->na4 ; }?></td>
									<td align="right"><?php if (trim($row->na5 )=='0') { echo '';} else { echo $row->na5 ; }?></td>
									<td align="right"><?php if (trim($row->na6 )=='0') { echo '';} else { echo $row->na6 ; }?></td>
									<td align="right"><?php if (trim($row->na7 )=='0') { echo '';} else { echo $row->na7 ; }?></td>
									<td align="right"><?php if (trim($row->na8 )=='0') { echo '';} else { echo $row->na8 ; }?></td>
									<td align="right"><?php if (trim($row->na9 )=='0') { echo '';} else { echo $row->na9 ; }?></td>
									<td align="right"><?php if (trim($row->na10)=='0') { echo '';} else { echo $row->na10; }?></td>
									<td align="right"><?php if (trim($row->na11)=='0') { echo '';} else { echo $row->na11; }?></td>
									<td align="right"><?php if (trim($row->na12)=='0') { echo '';} else { echo $row->na12; }?></td>
									<td align="right"><?php if (trim($row->na13)=='0') { echo '';} else { echo $row->na13; }?></td>
									<td align="right"><?php if (trim($row->na14)=='0') { echo '';} else { echo $row->na14; }?></td>
									<td align="right"><?php if (trim($row->na15)=='0') { echo '';} else { echo $row->na15; }?></td>
									<td align="right"><?php if (trim($row->na16)=='0') { echo '';} else { echo $row->na16; }?></td>
									<td align="right"><?php if (trim($row->na17)=='0') { echo '';} else { echo $row->na17; }?></td>
									<td align="right"><?php if (trim($row->na18)=='0') { echo '';} else { echo $row->na18; }?></td>
									<td align="right"><?php if (trim($row->na19)=='0') { echo '';} else { echo $row->na19; }?></td>
									<td align="right"><?php if (trim($row->na20)=='0') { echo '';} else { echo $row->na20; }?></td>
									<td align="right"><?php if (trim($row->na21)=='0') { echo '';} else { echo $row->na21; }?></td>
									<td align="right"><?php if (trim($row->na22)=='0') { echo '';} else { echo $row->na22; }?></td>
									<td align="right"><?php if (trim($row->na23)=='0') { echo '';} else { echo $row->na23; }?></td>
									<td align="right"><?php if (trim($row->na24)=='0') { echo '';} else { echo $row->na24; }?></td>
									<td align="right"><?php if (trim($row->na25)=='0') { echo '';} else { echo $row->na25; }?></td>
									<td align="right"><?php if (trim($row->na26)=='0') { echo '';} else { echo $row->na26; }?></td>
									<td align="right"><?php if (trim($row->na27)=='0') { echo '';} else { echo $row->na27; }?></td>
									<td align="right"><?php if (trim($row->na28)=='0') { echo '';} else { echo $row->na28; }?></td>
									<td align="right"><?php if (trim($row->na29)=='0') { echo '';} else { echo $row->na29; }?></td>
									<td align="right"><?php if (trim($row->na20)=='0') { echo '';} else { echo $row->na20; }?></td>
									<td align="right"><?php if (trim($row->na31)=='0') { echo '';} else { echo $row->na31; }?></td>
									<td align="right"><?php if (trim($row->na32)=='0') { echo '';} else { echo $row->na32; }?></td>
									<td align="right"><?php if (trim($row->na33)=='0') { echo '';} else { echo $row->na33; }?></td>
									<td align="right"><?php if (trim($row->na34)=='0') { echo '';} else { echo $row->na34; }?></td>
									<td align="right"><?php if (trim($row->na35)=='0') { echo '';} else { echo $row->na35; }?></td>
									<td align="right"><?php if (trim($row->na36)=='0') { echo '';} else { echo $row->na36; }?></td>
									<td align="right"><?php if (trim($row->na37)=='0') { echo '';} else { echo $row->na37; }?></td>
									<td align="right"><?php if (trim($row->na38)=='0') { echo '';} else { echo $row->na38; }?></td>
									<td align="right"><?php if (trim($row->na39)=='0') { echo '';} else { echo $row->na39; }?></td>
									<td align="right"><?php if (trim($row->na40)=='0') { echo '';} else { echo $row->na40; }?></td>
									<td align="right"><?php if (trim($row->na41)=='0') { echo '';} else { echo $row->na41; }?></td>
									<td align="right"><?php if (trim($row->na42)=='0') { echo '';} else { echo $row->na42; }?></td>
									<td align="right"><?php if (trim($row->na43)=='0') { echo '';} else { echo $row->na43; }?></td>
									<td align="right"><?php if (trim($row->na44)=='0') { echo '';} else { echo $row->na44; }?></td>
									<td align="right"><?php if (trim($row->na45)=='0') { echo '';} else { echo $row->na45; }?></td>
									<td align="right"><?php if (trim($row->na46)=='0') { echo '';} else { echo $row->na46; }?></td>
									<td align="right"><?php if (trim($row->na47)=='0') { echo '';} else { echo $row->na47; }?></td>
									<td align="right"><?php if (trim($row->na48)=='0') { echo '';} else { echo $row->na48; }?></td>
									<td align="right"><?php if (trim($row->na49)=='0') { echo '';} else { echo $row->na49; }?></td>
									<td align="right"><?php if (trim($row->na50)=='0') { echo '';} else { echo $row->na50; }?></td>
									<td align="right"><?php if (trim($row->na51)=='0') { echo '';} else { echo $row->na51; }?></td>
									<td align="right"><?php if (trim($row->na52)=='0') { echo '';} else { echo $row->na52; }?></td>
									<td align="right"><?php if (trim($row->na53)=='0') { echo '';} else { echo $row->na53; }?></td>
									<td align="right"><?php if (trim($row->na54)=='0') { echo '';} else { echo $row->na54; }?></td>
									<td align="right"><?php if (trim($row->na55)=='0') { echo '';} else { echo $row->na55; }?></td>
									<td align="right"><?php if (trim($row->na56)=='0') { echo '';} else { echo $row->na56; }?></td>
									<td align="right"><?php if (trim($row->na57)=='0') { echo '';} else { echo $row->na57; }?></td>
									<td align="right"><?php if (trim($row->na58)=='0') { echo '';} else { echo $row->na58; }?></td>
									<td align="right"><?php if (trim($row->na59)=='0') { echo '';} else { echo $row->na59; }?></td>
									<td align="right"><?php if (trim($row->na60)=='0') { echo '';} else { echo $row->na60; }?></td>
									<td align="right"><?php if (trim($row->na61)=='0') { echo '';} else { echo $row->na61; }?></td>
									<td align="right"><?php if (trim($row->na62)=='0') { echo '';} else { echo $row->na62; }?></td>
									<td align="right"><?php if (trim($row->na63)=='0') { echo '';} else { echo $row->na63; }?></td>
									<td align="right"><?php if (trim($row->na64)=='0') { echo '';} else { echo $row->na64; }?></td>
									<td align="right"><?php if (trim($row->na65)=='0') { echo '';} else { echo $row->na65; }?></td>
									<td align="right"><?php if (trim($row->na66)=='0') { echo '';} else { echo $row->na66; }?></td>
									<td align="right"><?php if (trim($row->na67)=='0') { echo '';} else { echo $row->na67; }?></td>
									<td align="right"><?php if (trim($row->na68)=='0') { echo '';} else { echo $row->na68; }?></td>
									<td align="right"><?php if (trim($row->na69)=='0') { echo '';} else { echo $row->na69; }?></td>
									<td align="right"><?php if (trim($row->na70)=='0') { echo '';} else { echo $row->na70; }?></td>
									<td align="right"><?php echo $row->f_avg_valueik;?></td>
									<td align="right"><?php echo $row->f_avg_valueask;?></td>
									<td align="right"><?php echo $row->b_valueask;?></td>
									<td align="right"><?php echo $row->b_valueik;?></td>
									
									<td align="right"><?php echo $row->kdbpa;?></td>
									<td align="right"><?php echo $row->bpa;?></td>
									
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


<?php /*
<div class="modal fade" id="ChoiceOfLetter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> PILIH PERIODE GENERATE KRITERIA </h4>
	  </div>
<!--form action="<?php echo site_url('pk/pk/list_nik_from_nik_atasan')?>" method="post" name="inputNik"-->
<form action="<?php echo site_url('pk/pk/list_nik_from_nik_atasan')?>" method="post" name="inputPeriode">
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
*/ ?>

<div class="modal fade" id="Filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN LAPORAN INSPEKSI ( INSTRUKSI KERJA ) </h4>
	  </div>
<form action="<?php echo site_url('pk/pk/report_inspeksi')?>" method="post" name="inputformPbk">
<div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group ">
									<label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
									<div class="col-sm-8">
										<input type="input" name="periode" id="periode" class="form-control input-sm  tglYM"  >
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
        <button type="submit" id="submit"  class="btn btn-primary">PROSES</button>
      </div>
	  </form>
</div></div></div></div>
<div class="modal fade" id="Download" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> DOWNLOAD XLS PERFORMA APPRAISAL KARYAWAN </h4>
	  </div>
<form action="<?php echo site_url('pk/pk/excel_report_form_inspeksi')?>" method="post" name="inputformPbk">
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

					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>
      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-primary"><i class="fa fa-download"></i>DOWNLOAD</button>
      </div>
	  </form>
</div></div></div></div>

<script>
	//Date range picker
    	$("#tgl").datepicker();
    	$(".tglan").datepicker();
</script>