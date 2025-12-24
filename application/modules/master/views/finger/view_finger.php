<?php 
/*
	@author : hanif_anak_metal \m/
*/

?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#kantin").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bInfo": true,
                    "bSort": true,
                    "bAutoWidth": false
                });
            });
</script>
<legend><?php echo $title;?></legend>

</br>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">					
		<li class="active"><a href="#tab_1" data-toggle="tab">Master Finger Print</a></li>
<!--		<li><a href="#tab_2" data-toggle="tab">User Finger Karyawan</a></li>		-->
	</ul>
</div>	
<div class="tab-content">
	<div class="chart tab-pane active" id="tab_1" style="position: relative;" >
		<legend>Daftar Finger Print Wilayah</legend>
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					   <button class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> INPUT</a></button>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
								<tr>
								<th>No.</th>
								<th>Branch </th>
								<th>Finger ID</th>
								<th>Wilayah</th>
								<th>Ip Address</th>
								<th>Database</th>
								<th>Inputby</th>
								<th>Editby</th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($list_finger as $row): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>
									<td width='5%'><?php echo $row->branch;?></td>
									<td><?php echo $row->fingerid;?></td>
									<td><?php echo $row->wilayah;?></td>
									<td><?php echo $row->ipaddress;?></td>
									<td><?php echo $row->dbname;?></td>
									<td><?php echo $row->inputby;?></td>
									<td><?php echo $row->editby;?></td>
									<td><a href="<?php echo site_url('master/finger/edit_finger').'/'.$row->fingerid;?>"> Edit </a> || 
									<a href="<?php echo site_url('master/finger/hps_finger').'/'.$row->fingerid;?>" OnClick="return confirm('Anda Yakin Hapus Finger <?php echo trim($row->wilayah);?>?')"> Hapus </a>
									
									</td>
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
	<div class="tab-pane" id="tab_2">
		<!--kantin-->
		<legend>Daftar List User Finger</legend>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					   <button class="btn btn-primary" data-toggle="modal" data-target="#kantinmodal" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> INPUT</a></button>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="kantin" class="table table-bordered table-striped" >
							<thead
								<tr>
								<th>No.</th>								
								<th>Branch</th>
								<th>KD Cabang</th>
								<th>Ip Address</th>
								<th>Nik</th>
								<th>Badgenumber</th>
								<th>Inputby</th>
								<th>Editby</th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($list_userfinger as $lk): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>									
									<td><?php echo $lk->branch;?></td>
									<td><?php echo $lk->kdcabang;?></td>
									<td><?php echo $lk->ipaddress;?></td>
									<td><?php echo $lk->nik;?></td>
									<td><?php echo $lk->badgenumber;?></td>
									<td><?php echo $lk->inputby;?></td>
									<td><?php echo $lk->editby;?></td>
									<td><a href="<?php echo site_url('master/uang/hps_userfinger').'/'.$lk->nik.'/'.$lk->kdcabang;?>" OnClick="return confirm('Anda Yakin Hapus Kantin<?php echo trim($lk>desc_cabang);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
</div>




<!-- Modal Input Finger Wilayah -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Input IP address Wilayah</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('master/finger/add_finger');?>" method="post">
		  <div class="form-group">
			<label for="wilayah">Wilayah</label>
								  
			<select class="form-control input-sm" name="kdcabang" id="kdcabang" required>
			<option value=""><?php echo '--PILIH WILAYAH--';?></option>	
			  <?php foreach($list_wil as $ls){?>
			  <option value="<?php echo $ls->kdcabang;?>"><?php echo $ls->desc_cabang;?></option>						  
			  <?php }?>
			</select>											
		  </div>
		  <div class="form-group">
			<label for="ipaddress">Input IP Address</label>
			<input type="text" class="form-control" id="ipaddress" name="ipaddress" style="text-transform: uppercase;">
			<input type="hidden" value="<?php echo 'INPUT';?>" class="form-control" id="tipe" name="tipe" style="text-transform: uppercase;">
		  </div>
		  <div class="form-group">
			<label for="db">Nama Database</label>
			<input type="text" class="form-control" id="dbname" name="dbname" style="text-transform: uppercase;">
		  </div>
		  <button type="submit" class="btn btn-primary">Simpan</button>
		  <button type="reset" class="btn btn-default">Reset</button>
		</form>
	  </div>
	</div>
  </div>
</div>





<!-- Modal Input Besaran Uang Makan Kantin -->
<div class="modal fade" id="kantinmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Input Besaran Uang Makan Kantin</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('master/uang/add_kantin');?>" method="post">
		  <div class="form-group">
			<label for="jabatan">Wilayah</label>
			<select class="form-control input-sm" name="kantorcabang" id="statusrmh" required>
			  <?php foreach($list_kantin as $listkan){?>
			  <option value="<?php echo $listkan->kodecabang;?>" <?php if ($peg_edit['kdcabang']==$listkan->kodecabang) { echo 'selected';}?>><?php echo $listkan->desc_cabang;?></option>						  
			  <?php }?>
			</select>											
		  </div>
		  <div class="form-group">
			<label for="besaran">Besaran</label>
			<input type="number" class="form-control" id="besaran" name="besaran" required>
		  </div>
		  <button type="submit" class="btn btn-primary">Simpan</button>
		  <button type="reset" class="btn btn-default">Reset</button>
		</form>
	  </div>
	</div>
  </div>
</div>
