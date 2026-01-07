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
								url : "<?php echo site_url('ga/permintaan/js_viewstock')?>/" + param1,
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
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#FILTER_MODAL"  href="#">Filter Pencarian</a></li>
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#ChoiceOfLetter"  href="#">Input BBK</a></li> 
				  <!---li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/permintaan/list_pbk_final")?>">Buat BBK PERMINTAAN</a></li-->
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
		<li class="active"><a href="#tab_1" data-toggle="tab">FORM BUKTI BARANG KELUAR</a></li>

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
											<th>DOKUMEN</th>
											<th>NO REF</th>
											<th>TGL</th>
											<th>NAMA LENGKAP</th>
											<th>TYPE</th>
											<th>STATUS</th>
											<th>KETERANGAN</th>
											<th>AKSI</th>		
										</tr>
							</thead>
                                    <tbody>
									<?php $no=0; foreach($list_bbk as $row): $no++;?>
								<tr>	
									<td width="2%"><?php echo $no;?></td>
									<td><?php echo $row->nodok;?></td>
									<td><?php echo $row->nodokref;?></td>
                                    <td><?php echo date('d-m-Y', strtotime(trim($row->nodokdate)));?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->nodoktype;?></td>
									<td><?php echo $row->nmstatus;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td width="10%">
										<a href="<?php 
										$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
										echo site_url("ga/permintaan/detail_bbk/$enc_nodok");?>" class="btn btn-default  btn-sm" title="DETAIL"><i class="fa fa-bars"></i> </a>
										<?php if (trim($row->status)=='A') { ?>
										<a href="<?php 
										$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
										echo site_url("ga/permintaan/edit_bbk/$enc_nodok");?>" class="btn btn-primary  btn-sm" title="UBAH"><i class="fa fa-gear"></i> </a>
											<?php if (trim($nama)==trim($row->nik_atasan) or $userhr>0 or trim($nama)==trim($row->nik_atasan2) ) { ?>
											<a href="<?php 
											$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
											echo site_url("ga/permintaan/approval_bbk/$enc_nodok");?>" class="btn btn-success  btn-sm" title="APPROVAL"><i class="fa fa-check"></i> </a>
											<?php } ?>
										<a href="<?php 
										$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
										echo site_url("ga/permintaan/batal_bbk/$enc_nodok");?>" class="btn btn-danger  btn-sm" title="BATALKAN"><i class="fa fa-trash-o"></i> </a>
										<?php } ?>	
										<!--a href="#" data-toggle="modal" data-target="#DTL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm"><i class="fa fa-edit"></i> DETAIL </a-->
										<!--?php if (trim($row->status)=='P') { ?>
										<a href="<?php 
										$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
										echo site_url("ga/permintaan/hangus_bbk/$enc_nodok");?>" class="btn btn-danger  btn-sm"><i class="fa fa-edit"></i> HANGUS </a---->
										<!--->
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

<div class="modal fade" id="ChoiceOfLetter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"> PILIH DOKUMEN UNTUK INPUT BBK </h4>
	  </div>
<form action="<?php echo site_url('ga/permintaan/chose_optionbbk')?>" method="post" name="inputformPbk">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">	
							<div class="form-group ">
								<label class="col-sm-4" for="inputsm">PILIH DOKUMEN INPUT BUKTI BARANG KELUAR</label>	
									<div class="col-sm-8">  
									<select class="form-control input-sm " name="inputfill" required>
									 <option value="PBK"> PERMINTAAN BARANG KELUAR</option> 
									 <option value="AJS"> AJUSTMENT OUT</option> 
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
<div class="modal fade" id="FILTER_MODAL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN BUKTI BARANG KELUAR </h4>
            </div>
            <form action="<?php echo site_url('ga/permintaan/form_bbk')?>" method="post" name="inputformbbk">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
                                            <div class="col-sm-8">
                                                <input type="input" name="tgl" id="tgl" class="form-control input-sm tglrange"  >
                                            </div>
                                        </div>
                                        <!--div class="form-group ">
									<label class="col-sm-4" for="inputsm">PILIH NAMA KARYAWAN </label>
									<div class="col-sm-8">
									<select class="form-control input-sm " name="nik" id="nik">
										<option value=""><tr><th width="20%">-- NIK |</th><th width="80%">| NAMA KARYAWAN --</th></tr></option>
										<!?php foreach($list_nik as $sc){?>
										<option value="<!?php echo trim($sc->nik);?>" ><tr><th width="20%"><!?php echo trim($sc->nik);?>  |</th><th width="80%">| <?php echo trim($sc->nmlengkap);?></th></tr></option>
										<!?php }?>
									</select>
									</div>
							</div--->

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
    	//$("#tgl").datepicker();
    	$(".tglan").datepicker();
        $(".tglrange").daterangepicker();
</script>