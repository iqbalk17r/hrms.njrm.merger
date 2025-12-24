<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#table1").dataTable({
				  "pageLength": 100,
				 // "scrollY": 1800,
				  "scrollX": true,
			      "ordering": false
				});
				$modal = $('.pp');
				$('#table1').on('click', '.show', function () {
						//var data = $('#example1').DataTable().row( this ).data();
						//alert( 'You clicked on '+data[0]+'\'s row' );
						var el = $(this);
						//alert(el.attr('data-url'));
						$modal.load(el.attr('data-url'), '', function(){
						$modal.modal();
					
					
					} );
				} );
				
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
</style>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title;?></legend>


<?php echo $message;?>

<div class="row">
	<div class="col-sm-12">	
		<!--div class="container"--->
		<!--a href="<?php echo site_url("pdca/pdca/form_pdca")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a-->
		<a href="<?php echo site_url("pdca/pdca/clear_tmp_pdca_berkala/$nik/$periode")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
		
		<a href="<?php echo site_url("pdca/pdca/final_input_pdca_berkala/$nik/$periode")?>" onclick="return confirm('Akan Disimpan Final Seluruh Detail Yang Anda Buat? Anda Yakin?')" class="btn btn-success pull-right" style="margin:10px; color:#ffffff;">Final Input</a>
			<!--div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#Filter"  href="#"><i class="fa fa-search"></i>Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#ChoiceOfLetter"  href="#"><i class="fa fa-plus"></i>INPUT TYPE PDCA</a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/ajustment/input_ajustment_in_trgd")?>">Input Transfer Antar Gudang</a></li-->		
				<!--/ul>
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
							<table id="table1" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>																
										<th>No.</th>
										<th>Nik</th>
										<th>NAMA LENGKAP</th>
										<th>JABATAN</th>
										<th>PERIODE</th>
										<th>DESCPLAN</th>
										<th>CATEGORY</th>
										<th bgcolor="#70dbdb">1</th>
										<th>2</th>
										<th bgcolor="#70dbdb">3</th>
										<th>4</th>
										<th bgcolor="#70dbdb">5</th>
										<th>6</th>
										<th bgcolor="#70dbdb">7</th>
										<th>8</th>
										<th bgcolor="#70dbdb">9</th>
										<th>10</th>
										<th bgcolor="#70dbdb">11</th>
										<th>12</th>
										<th bgcolor="#70dbdb">13</th>
										<th>14</th>
										<th bgcolor="#70dbdb">15</th>
										<th>16</th>
										<th bgcolor="#70dbdb">17</th>
										<th>18</th>
										<th bgcolor="#70dbdb">19</th>
										<th>20</th>
										<th bgcolor="#70dbdb">21</th>
										<th>22</th>
										<th bgcolor="#70dbdb">23</th>
										<th>24</th>
										<th bgcolor="#70dbdb">25</th>
										<th>26</th>
										<th bgcolor="#70dbdb">27</th>
										<?php $a_date=$tglperiod;$cekdate=date("t",strtotime($a_date)); if($cekdate>=28){ ?><th>28</th><?php } ?> <!-- Fleksibel tanggal bro-->
										<?php $a_date=$tglperiod;$cekdate=date("t",strtotime($a_date)); if($cekdate>=29){ ?><th bgcolor="#70dbdb">29</th><?php } ?> <!-- Fleksibel tanggal bro-->
										<?php $a_date=$tglperiod;$cekdate=date("t",strtotime($a_date)); if($cekdate>=30){ ?><th>30</th><?php } ?> <!-- Fleksibel tanggal bro-->
										<?php $a_date=$tglperiod;$cekdate=date("t",strtotime($a_date)); if($cekdate>=31){ ?><th bgcolor="#70dbdb">31</th><?php } ?> <!-- Fleksibel tanggal bro-->
										<th>REMARK</th>

									</tr>
								</thead>
								<tbody>
									<?php $no=0; foreach ($list_pdca as $ls): $no++ ?>
										<tr>																													
											<!--td><?php echo $no;?></td-->	
											<td><?php if (trim($ls->urutcategory)>1) { echo ''; } else { echo $ls->urutnye; } ?></td>	
											<td ><?php if (trim($ls->urutcategory)>1) { echo ''; } else { echo $ls->nik; } ?></td>								
											<td><?php  if (trim($ls->urutcategory)>1) { echo ''; } else { echo $ls->nmlengkap; } ?></td>
											<td><?php  if (trim($ls->urutcategory)>1) { echo ''; } else { echo $ls->nmjabatan; } ?></td>								
											<td><?php  if (trim($ls->urutcategory)>1) { echo ''; } else { echo $ls->planperiod;} ?></td>								
											<td><?php  if (trim($ls->urutcategory)>1) { echo ''; } else { echo $ls->descplan; } ?></td>								
											<td><?php  echo $ls->category;?></td>															
											<!--td bgcolor="#70dbdb"><a <?php $nik=trim($ls->nik); $bln=substr(trim($ls->planperiod),-2); $thn=substr(trim($ls->planperiod),4); $tgl=$thn.'-'.$bln.'-01'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl1;?></a></td-->
											<!--a data-url="<?php $custcode=trim($lj->custcode); $outletcode=trim($lj->outletcode); $mperiode=11; echo site_url("/poin/report/modal_reportdisbdtl/$custcode/$outletcode/$mperiode")?>" class="btn btn-primary show" style="margin-left:10px;  margin-top:5px" data-toggle="modal" data-target=".pp"--->
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='01'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl1;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='02'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl2;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='03'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl3;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='04'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl4;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='05'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl5;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='06'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl6;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='07'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl7;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='08'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl8;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='09'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl9;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='10'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl10;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='11'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl11;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='12'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl12;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='13'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl13;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='14'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl14;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='15'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl15;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='16'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl16;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='17'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl17;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='18'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl18;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='19'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl19;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='20'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl20;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='21'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl21;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='22'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl22;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='23'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl23;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='24'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl24;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='25'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl25;?></a></td>
											<td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='26'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl26;?></a></td>
											<td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='27'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl27;?></a></td>																
											<?php $a_date=$tglperiod;$cekdate=date("t",strtotime($a_date)); if($cekdate>=28){ ?><td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='28'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl28;?></a></td><?php } ?>			<!-- Fleksibel tanggal bro-->					
											<?php $a_date=$tglperiod;$cekdate=date("t",strtotime($a_date)); if($cekdate>=29){ ?><td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='29'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl29;?></a></td><?php } ?>			<!-- Fleksibel tanggal bro-->					
											<?php $a_date=$tglperiod;$cekdate=date("t",strtotime($a_date)); if($cekdate>=30){ ?><td ><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='30'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl30;?></a></td><?php } ?>			<!-- Fleksibel tanggal bro-->					
											<?php $a_date=$tglperiod;$cekdate=date("t",strtotime($a_date)); if($cekdate>=31){ ?><td bgcolor="#70dbdb"><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='31'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->tgl31;?></a></td><?php } ?>			<!-- Fleksibel tanggal bro-->					
											<td><a href="#" data-url="<?php $nik=trim($ls->nik); $planperiod=trim($ls->planperiod); $nomor=trim($ls->nomor); $urutcategory=trim($ls->urutcategory); $dy='XX'; echo site_url("pdca/pdca/edit_detail_pdca_berkala/$nik/$nomor/$planperiod/$urutcategory/$dy"); ?>" class="show" data-toggle="modal" data-target=".pp"><?php echo $ls->remark;?></a></td>		
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>	
</div>
</div><!--/ nav -->	

<!--Modal Data Detail -->

    <div  class="modal fade pp">
                <!-- Content will be loaded here from "remote.php" file -->
    </div>

<!---End Modal Data --->
<?php /*
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
									<select class="form-control input-sm inputfill" name="inputfill"  required>
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
 */ ?>
<script>
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 
</script>