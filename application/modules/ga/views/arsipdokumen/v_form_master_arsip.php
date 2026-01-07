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
				$("#example1").dataTable({
					"autoWidth": false
				});
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
				/*$('#example1').bootstrapTable({
						resizable: true,
						headerOnly: true,
						data: data
				});*/
			//	$("#tglrange").daterangepicker(); 
            });
					
			//empty string means no validation error

</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
</br>

<legend><?php echo $title;?></legend>
	
<?php echo $message;?>
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
				  <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filterinput"  href="#">Input Pengarsipan</a></li>
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#myModal1"  href="#">Input Kendaraan</a></li--> 
				  <!--li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url("trans/cuti_karyawan/listkaryawan_iss")?>">Input Cuti</a></li-->
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
			<div class="box-header">
			 <!--legend><?php echo $title;?></legend--->
			</div><!-- /.box-header -->	
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped uk-overflow-container" >
					<thead>
								<tr>											
									<th width="2%">No.</th>
									<th>NO DOKUMEN</th>
									<th>ID ARSIP</th>
									<th>NAMA ARSIP</th>
									<th>PEMILIK ARSIP</th>
									<th>LOKASI</th>
                                    <th>TGL INPUT</th>
									<th>AKSI</th>
								</tr>
					</thead>
							<tbody>
							<?php $no=0; foreach($list_trx_mst as $row): $no++;?>
						<tr>
							
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo trim($row->docno);?></td>
                            <td><?php echo trim($row->archives_id);?></td>
                            <td><?php echo trim($row->archives_name);?></td>
							<td><?php echo trim($row->archives_own);?></td>
							<td><?php echo trim($row->locaname);?></td>
                            <td><?php if(trim($row->docdate)=='') { echo ''; } else { echo date('d-m-Y', strtotime(trim($row->docdate))); } ?></td>
							<td width="8%">
                                    <a href="<?php
                                    $enc_docno=bin2hex($this->encrypt->encode(trim($row->docno)));
                                    $enc_archives_id=bin2hex($this->encrypt->encode(trim($row->archives_id)));
                                    echo site_url('ga/arsipdokumen/detail_master_arsipdokumen').'/'.$enc_docno;?>" class="btn btn-default  btn-sm" title="Detail Data Arsip">	<i class="fa fa-bars"></i> </a>



                                <?php /*	<?php IF (trim($row->status)=='A' or trim($row->status)=='I') { ?>
									<a href="<?php 
									$enc_nodok=bin2hex($this->encrypt->encode(trim($row->nodok)));
									$enc_jenispengurusan=bin2hex($this->encrypt->encode(trim($row->jenispengurusan)));
									echo site_url('ga/kendaraan/approv_stnktmp').'/'.$enc_nodok.'/'.$enc_jenispengurusan;?>" class="btn btn-success  btn-sm" title="PERSETUJUAN INPUT PEMBAHARUAN STNKB">	<i class="fa fa-check"></i>
									
									
									<a href="#" data-toggle="modal" data-target="#DEL<?php echo trim($row->nodok);?>" class="btn btn-danger  btn-sm" title="HAPUS/BATAL PEMBAHARUAN STNKB">
										<i class="fa fa-trash-o"></i></a>
									<?php } ?>
									<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php echo site_url('ga/kendaraan/sti_pengajuan_stnkb/'.trim($row->nodok));?>');"><i class="fa fa-print"></i></button>
									<a href="#" data-toggle="modal" data-target="#DETAIL<?php echo trim($row->nodok);?>" class="btn btn-default  btn-sm" title="DETAIL PEMBAHARUAN STNKB"><i class="fa fa-bars"></i></a>
                                */?>
							</td>
						</tr>
						<?php endforeach;?>	
							</tbody>		
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>


<!-- Modal Input Master Barang ATK -->
<div class="modal fade" id="filterinput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">INPUT MASTER DOKUMEN ARSIP</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="<?php echo site_url('ga/arsipdokumen/save_master_arsip');?>" method="post">
                    <div class='row'>
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <label for="inputsm">KODE ARSIP ASLI</label>
                                <input type="text" class="form-control input-sm"  style="text-transform:uppercase" id="archives_id" style="text-transform:uppercase" name="archives_id" placeholder="Inputkan Kode Dokumen Arsip" maxlength="30" required>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">NAMA ARSIP</label>
                                <input type="text" class="form-control input-sm"  style="text-transform:uppercase" id="archives_name" style="text-transform:uppercase" name="archives_name" placeholder="Inputkan Nama Dokumen Arsip" maxlength="30" required>
                                <input type="hidden" class="form-control input-sm" id="type" name="type" value="INPUT">
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Lokasi Arsip</label>
                                <select class="form-control input-sm" name="loccode" id="loccode" required>
                                    <option value="">---PILIH LOKASI ARSIP---</option>
                                    <?php foreach($list_gudang as $sc){?>
                                        <option value="<?php echo trim($sc->loccode);?>" ><?php echo trim($sc->loccode).' || '.trim($sc->locaname);?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Kode Group</label>
                                <select class="form-control input-sm" name="kdgroup" id="kdgroup" required>
                                    <option value="">---PILIH KODE GROUP--</option>
                                    <?php foreach($list_scgroup as $sc){?>
                                        <option value="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdgroup).' || '.trim($sc->nmgroup);?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Kode Sub Group</label>
                                <select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup">
                                    <option value="">---PILIH KODE SUB GROUP--</option>
                                    <?php foreach($list_scsubgroup as $sc){?>
                                        <option value="<?php echo trim($sc->kdsubgroup);?>"  class="<?php echo trim($sc->kdgroup);?>" ><?php echo trim($sc->kdsubgroup).' || '.trim($sc->nmsubgroup);?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div> <!---- col 1 -->
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <label for="inputsm">Nama Pemilik Arsip</label>
                                <input type="text" class="form-control input-sm"  style="text-transform:uppercase" id="archives_own" style="text-transform:uppercase" name="archives_own" placeholder="Inputkan Nama Pemilik Arsip" maxlength="30" required>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">Tanggal Pembaharuan Arsip</label>
                                <input type="text" class="form-control input-sm tgl" id="archives_exp" style="text-transform:uppercase" name="archives_exp"   placeholder="Exp Archive" data-date-format="dd-mm-yyyy" required>
                            </div>
                            <div class="form-group">
                                <label for="inputsm">HOLD</label>
                                <select class="form-control input-sm" name="chold" id="chold">
                                    <option value="NO">TIDAK</option>
                                    <option value="YES">YA</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="inputsm">Keterangan</label>
                                <textarea  class="textarea" name="description" placeholder="Keterangan"  maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ; text-transform: uppercase"></textarea>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>

        </div>
    </div>
</div>

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
    $('.tglYM').datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months"
    });
</script>