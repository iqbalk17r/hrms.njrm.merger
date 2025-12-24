<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<style>
  /*-- change navbar dropdown color --*/
  .navbar-default .navbar-nav .open .dropdown-menu>li>a,.navbar-default .navbar-nav .open .dropdown-menu {
  	background-color: #008040;
    color:#ffffff;
  }

</style>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
			
			//	$("#tglrange").daterangepicker(); 
            });
					
			//empty string means no validation error
			}
</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
	
<div class="row">
	<!--div class="col-sm-3">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Kendaraan</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div--->
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"  href="#">Filter Pencarian</a></li> 
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Asuransi</a></li> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("trans/cuti_karyawan/listkaryawan_iss")?>">Input Cuti</a></li-->
				  <!--li role="presentation" class="divider"></li>	
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Haduh Us</a></li---> 
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
	
</div>	
</br>
<div class="col-sm-12">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">					
			<li class="active"><a href="#tab_1" data-toggle="tab">Input Asuransi</a></li>
			<!--li><a href="#tab_2" data-toggle="tab">Schema Kendaraan2</a></li--->	
		</ul>
		
	<div class="tab-content">
		<div class="chart tab-pane active" id="tab_1" style="position: relative; height: 300px;" >
			
			<div class="row">
				<div class="col-xs-12">                            
					<div class="box">
						<div class="box-header">
						 <legend><?php echo $title;?></legend>							
						</div><!-- /.box-header -->	
						<div class="box-body table-responsive" style='overflow-x:scroll;'>
							<table id="example1" class="table table-bordered table-striped" >
								<thead>
											<tr>											
												<th width="2%">No.</th>
												<th>KODE ASURANSI</th>
												<th>NAMA ASURANSI</th>
												<th>KODE GROUP</th>
												<th>ALAMAT</th>
												<th>PHONE 1</th>
												<th>PHONE 2</th>
												<th>AKSI</th>		
											</tr>
								</thead>
										<tbody>
										<?php $no=0; foreach($list_mstasuransi as $row): $no++;?>
									<tr>
										
										<td width="2%"><?php echo $no;?></td>
										<td><?php echo $row->kdasuransi;?></td>
										<td><?php echo $row->nmasuransi;?></td>
										<td><?php echo $row->kdgroup;?></td>
										<td><?php echo $row->addasuransi;?></td>
										<td><?php echo $row->phone1;?></td>
										<td><?php echo $row->phone2;?></td>
										<td width="15%">
												<a href="#" data-toggle="modal" data-target="#ED<?php echo trim($row->kdasuransi);?>" class="btn btn-success  btn-sm">
													<i class="fa fa-edit"></i> EDIT
												</a>
												<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->kdasuransi);?>" class="btn btn-danger  btn-sm">
													<i class="fa fa-edit"></i> HAPUS
												</a>
												
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
</div>
<!-- Modal Input Skema Barang -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">MASTER ASURANSI</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_mstasuransi');?>" method="post">
		  <div class="form-group">
			<label for="besaran">Nomer Skema</label>
			<input type="text" class="form-control" id="kdasuransi" name="kdasuransi" style="text-transform:uppercase" placeholder="DOKUMEN SKEMA">
		  </div>
		  <div class="form-group">
			<label for="besaran">Nama Skema</label>
			<input type="text" class="form-control" id="nmsckendaraan" style="text-transform:uppercase" name="nmsckendaraan" placeholder="DOKUMEN SKEMA">
		  </div>
		  <div class="form-group">
			<label for="besaran">Tanggal</label>
			<input type="text" class="form-control" id="tgl" name="tgl"  data-date-format="dd-mm-yyyy">
		  </div>
		  <div class="form-group">
			<label for="besaran">Keterangan</label>
			<textarea  class="textarea" name="isi" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
          </div>
		</div>  
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
		</form>
	  </div>

  </div>
</div>	
</div>			
<!-- -->

<!-- EDIT KENDARAAN -->
<?php foreach ($list_mstasuransi as $ls){ ?>
<div class="modal fade" id="ED<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">EDIT MASTER ASURANSI</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_sckendaraan');?>" method="post">
		  <div class="form-group">
			<label for="besaran">Nomer Dokumen</label>
			<input type="text" class="form-control" id="nodok" name="nodok" style="text-transform:uppercase" value=<?php echo trim($ls->nodok);?> placeholder="DOKUMEN SKEMA">
		  </div>
		  <div class="form-group">
			<label for="besaran">Nama Dokumen</label>
			<input type="text" class="form-control" id="nmsckendaraan" style="text-transform:uppercase" name="nmsckendaraan"  value=<?php echo trim($ls->nmdok);?>  placeholder="DOKUMEN SKEMA">
		  </div>
		  <div class="form-group">
			<label for="besaran">Tanggal</label>
			<input type="text" class="form-control tglan" id="tgl" name="tgl"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($ls->tgldok)));?> >
		  </div>
		  <div>
		  <div class="form-group">
			<label for="besaran">Keterangan</label>
			<textarea  class="textarea" name="isi" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
          </div>
		  
		  <button type="submit" class="btn btn-primary">Simpan</button>
		  <button type="reset" class="btn btn-default">Reset</button>
		</form>
	  </div>
	</div>
  </div>
</div>
</div>									
<?php } ?>
<!-- END KENDARAAN --->

<!-- DELETE KENDARAAN -->
<?php foreach ($list_mstasuransi as $ls){ ?>
<div class="modal fade" id="DEL<?php echo trim($ls->nodok);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">APAKAH ANDA YAKIN AKAN HAPUS DATA INI</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('ga/kendaraan/input_sckendaraan');?>" method="post">
		  <div class="form-group">
			<label for="besaran">Nomer Skema</label>
			<input type="text" class="form-control" id="nodok" name="nodok" style="text-transform:uppercase" value=<?php echo trim($ls->nodok);?> placeholder="DOKUMEN SKEMA" readonly>
		  </div>
		  <div class="form-group">
			<label for="besaran">Nama Skema</label>
			<input type="text" class="form-control" id="nmsckendaraan" style="text-transform:uppercase" name="nmsckendaraan"  value=<?php echo trim($ls->nmdok);?>  placeholder="DOKUMEN SKEMA"readonly>
		  </div>
		  <div class="form-group">
			<label for="besaran">Tanggal</label>
			<input type="text" class="form-control tglan" id="tgl" name="tgl"  data-date-format="dd-mm-yyyy"  value=<?php echo date('d-m-Y', strtotime(trim($ls->tgldok)));?> >
		  </div>
		  <div>
		  <div class="form-group">
			<label for="besaran">Keterangan</label>
			<textarea  class="textarea" name="isi" placeholder="Keterangan"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
          </div>
		  
		  <button type="submit" class="btn btn-danger">Delete</button>
		  <button type="reset" class="btn btn-default">Reset</button>
		</form>
	  </div>
	</div>
  </div>
</div>
</div>									
<?php } ?>
<!-- END KENDARAAN --->



<script>

  

	
	//Date range picker
    	$("#tgl").datepicker(); 
    	$(".tglan").datepicker(); 

  

</script>