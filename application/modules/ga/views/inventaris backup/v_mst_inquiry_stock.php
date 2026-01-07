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
            });
					
			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>


<legend><?php echo $title;?></legend>
<?php echo $message; ?>	

<div class="row">
	<!--div class="col-sm-3">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input Kendaraan</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div--->
	<div class="col-sm-3">	
		<!--div class="container"--->
			<div class="dropdown ">
				<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1" type="button" data-toggle="dropdown"> Menu
				<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1" >
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#FILTER_MODAL"  href="#"><i class="fa fa-search"></i> Filter Pencarian</a></li>
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("ga/inventaris/excel_inquiry_stock".'/'.$kdcabang)?>"><i class="fa fa-download"></i> Unduh XLS</a></li>
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Mapping Satuan</a></li----> 
				  
				  <!--li role="presentation" class="divider"></li>	
				  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Haduh Us</a></li---> 
				</ul>
			</div>
		<!--/div-->
	</div><!-- /.box-header -->
</div> 
</br>

<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
								<tr>											
									<th width="2%">No.</th>
									<th>KODE BARANG</th>
									<th>NAMA BARANG</th>
									<th>GUDANG WILAYAH</th>
									<th>SALDO</th>
									<th>SATUAN</th>
									<th>AKSI</th>

								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_stgblcoitem as $row): $no++;?>
						<tr>
							
							<td width="2%"><?php echo $no;?></td>
							
							<td><?php echo $row->stockcode;?></td>
							<td><?php echo $row->nmbarang;?></td>
							<td><?php echo $row->locaname;?></td>
							<td align="right"><?php echo $row->qty_sld;?></td>
							<td align="right"><?php echo $row->nmsatkecil;?></td>
							<td width="15%">

									<a href="<?php echo site_url('ga/inventaris/inquiry_stock_detail').'/'.trim($row->kdgroup).'/'.trim($row->kdsubgroup).'/'.trim($row->stockcode).'/'.trim($row->loccode);?>" class="btn btn-default  btn-sm">
										<i class="fa fa-edit"></i> DETAIL
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
<!-- FILTER -->
<div class="modal fade" id="FILTER_MODAL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> FILTER PENCARIAN </h4>
            </div>
            <form action="<?php echo site_url('ga/inventaris/inquiry_stock')?>" method="post" name="inputformPbk">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <!----div class="form-group ">
                                                <label class="col-sm-4" for="inputsm">PILIH PERIODE </label>
                                                <div class="col-sm-8">
                                                    <input type="input" name="tgl" id="tgl" class="form-control input-sm tglrange"  >
                                                </div>
                                        </div--->
                                        <div class="form-group">
                                            <label class="col-sm-4" for="inputsm">PILIH GUDANG WILAYAH </label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm " name="loccode" id="loccode" required>
                                                    <option  value="">---PILIH KODE WILAYAH/GUDANG---</option>
                                                    <?php foreach($list_kanwil as $sc){?>
                                                        <option value="<?php echo trim($sc->loccode);?>" ><?php echo  trim($sc->locaname);?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <!--div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PILIH GUDANG WILAYAH </label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm " name="kdcabang" id="kdcabang">
                                                    <option value="MJKCNI"><tr><th width="20%">-- MJKCNI |</th><th width="80%">| MOJOKERTO --</th></tr></option>
                                                    <option value="SBYCNI"><tr><th width="20%">-- SBYCNI |</th><th width="80%">| SURABAYA  --</th></tr></option>
                                                    <option value="MKTMJK"><tr><th width="20%">-- MKTMJK |</th><th width="80%">| MARKETING MOJOKERTO  --</th></tr></option>
                                                    <option value="MKTSBY"><tr><th width="20%">-- MKTSBY |</th><th width="80%">| MARKETING SURABAYA  --</th></tr></option>
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
    	$("#tgl").datepicker(); 
    	$(".tgl").datepicker(); 
    	$(".tglan").datepicker(); 
				$('.year').datepicker({
					format: " yyyy",
					viewMode: "years", 
					minViewMode: "years"
				
				});
  

</script>