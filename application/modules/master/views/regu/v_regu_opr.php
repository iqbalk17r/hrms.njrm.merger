<!--link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" /-->
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$('#tgl').datepicker();
				$('#pilihkaryawan').selectize();
				$('#pilihregu2').selectize();
				$('#kdregu1').selectize();
		   });
			
		
</script>


<legend><?php echo $title;?></legend>
<?php echo $message; ?>
				<div class="row">
                    <div class="col-xs-12">
						<div class="box">
							<div class="box-header">
					   <button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> INPUT</a>
					   <button class="btn btn-primary" data-toggle="modal" data-target="#myModal2" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> FILTER</a></button>
					   <a href="<?php echo site_url("master/regu/download_excel_reguopr");?>" class="btn btn-warning"><i class="glyphicon glyphicon-download"></i> Download Excel</a>
					</div><!-- /.box-header -->	
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped" >
                                    <thead>
										<tr>											
											
											<th>No.</th>
											<th>Kode Regu</th>
											<th>Nama Regu</th>
											<th>Nik</th>
											<th>Nama</th>
											<th>Department</th>
											<th>Input Date</th>
											<th>Input By</th>	
											<th>Update Date</th>
											<th>Update By</th>
											<th>Aksi</th>
											<th></th>
													
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_regu_opr as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->kdregu;?></td>
									<td><?php echo $row->nmregu;?></td>
									<td><?php echo $row->nik;?></td>
									<td><?php echo $row->nmlengkap;?></td>
									<td><?php echo $row->nmdept;?></td>
									<td><?php echo $row->input_date;?></td>
									<td><?php echo $row->input_by;?></td>
									<td><?php echo $row->update_date;?></td>
									<td><?php echo $row->update_by;?></td>
									<td><a href="<?php $kdregu=trim($row->kdregu);echo site_url("master/regu/hps_regu_opr").'/'.$row->no_urut.'/'.$row->kdregu;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->kdregu);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a <?php $id=trim($row->no_urut);?> href="<?php echo site_url("master/regu/show_edit/$id");?>" ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>
<!-- Modal Input regu -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">INPUT MASTER REGU OPERATOR</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/regu/add_regu_opr');?>" method="post">
			<div class="row">

			<div class="form-group">
				 <label class="col-sm-12">Kode Regu</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="kdregu" id="kdregu1">
						  <?php foreach($list_regu as $listkan){?>
						  <option value="<?php echo trim($listkan->kdregu).'|'.$listkan->nmregu;?>" ><?php echo $listkan->kdregu.'|'.$listkan->nmregu;?></option>						  
						  <?php }?>
					</select>
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">NIK</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="nik" id="pilihkaryawan" required>
						  <option value="">--PILIH KARYAWAN--</option>
						  <?php foreach($list_nik as $listkan){?>
						  <option value="<?php echo trim($listkan->nik);?>" ><?php echo $listkan->nik.' || '.$listkan->nmlengkap;?></option>						  
						  <?php }?>
					</select>
				</div>
			</div>
		
			<div class="form-group">
				 <label class="col-sm-12">Tanggal Input</label>
				<div class="col-sm-12">
					
						<input type="text" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Input By</label>
				<div class="col-sm-12">
				
						<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<div class="form-group"> 
					<div class="col-lg-12">
						<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
					   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
					</div>
				</div>
			</div>
			</div>
		</form>
  </div>
</div>
</div>  
</div>


<!-- INPUT MODAL FILTER -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">FILTER REGU</h4>
	  </div>
	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/regu/regu_opr');?>" method="post">
			<div class="row">

			<div class="form-group">
				 <label class="col-sm-12">Kode Regu</label>
				<div class="col-sm-12">
					<select class="form-control input-sm" name="kdregu" id="kdgrade">
						  <?php foreach($list_regu_filter as $listkan){?>
						  <option value="<?php echo trim($listkan->kdregu);?>" ><?php echo $listkan->kdregu.'|'.$listkan->nmregu;?></option>						  
						  <?php }?>
					</select>
				</div>
			</div>
			
			</div>
			<div class="modal-footer">
				<div class="form-group"> 
					<div class="col-lg-12">
						<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
					   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
					</div>
				</div>
			</div>
			</div>
		</form>
  </div>
</div>
</div>  
</div>

