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
<?php echo $message;?>
</br>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">					
		<li class="active"><a href="#tab_1" data-toggle="tab">Uang Makan</a></li>
		<li><a href="#tab_2" data-toggle="tab">Uang Makan Kantin</a></li>
	</ul>
</div>	
<div class="tab-content">
	<div class="chart tab-pane active" id="tab_1" style="position: relative;" >
		<legend>Daftar Uang Makan</legend>
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
								<th>Kode </th>
								<th>Level Jabatan</th>
								<th>Besaran</th>
								<th>Inputby</th>
								<th>Editby</th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($userosin as $row): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>
									<td width='5%'><?php echo $row->kdlvl;?></td>
									<td><?php echo $row->keterangan;?></td>
									<td><?php echo $row->besaran;?></td>
									<td><?php echo $row->Inputby;?></td>
									<td><?php echo $row->editby;?></td>
									<td><a href="<?php echo site_url('master/uang/hps_um').'/'.$row->kdlvl;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->keterangan);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
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
		<legend>Daftar List Besaran Makan Kantin</legend>
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
								<th>Kantor Wilayah</th>
								<th>Besaran</th>
								<th></th>
								</tr>
							</thead>
							<tbody>
								<?php $no=0; foreach($kantin as $lk): $no++;?>
								<tr>
									<td width='5%'><?php echo $no;?></td>									
									<td><?php echo $lk->desc_cabang;?></td>
									<td><?php echo $lk->besaran;?></td>
									<td><a href="<?php echo site_url('master/uang/hps_kantin').'/'.$lk->id;?>" OnClick="return confirm('Anda Yakin Hapus Kantin<?php echo trim($lk>desc_cabang);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
</div>




<!-- Modal Input Besaran Uang Makan -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Input Uang Makan</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('master/uang/add_um');?>" method="post">
		  <div class="form-group">
			<label for="jabatan">Kode Level Jabatan</label>
			<input type="text" class="form-control" id="kdlvl" name="kdlvl" style="text-transform: uppercase;">
		  </div>
		  <div class="form-group">
			<label for="jabatan">Jabatan</label>
			<input type="text" class="form-control" id="keterangan" name="keterangan" style="text-transform: uppercase;">
		  </div>
		  <div class="form-group">
			<label for="besaran">Besaran</label>
			<input type="number" class="form-control" id="besaran" name="besaran">
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
