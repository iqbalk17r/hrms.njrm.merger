


<legend><?php echo $title;?></legend>
<?php echo $message; ?>
<div class="box-header">
<div class="box-body">
	
					<a data-toggle="modal" data-target=".baru" class="btn btn-primary" style="margin:5px"><i class="glyphicon glyphicon-plus"></i> Tambah</a>				
				</div><!-- /.box-header -->
                                <table id="example1" class="table table-bordered table-striped" >
                                    <thead>
										<tr>											
											
											<th>No.</th>
											<th>Kode</th>
											<th>Config Name</th>
											<th>Val Num</th>
											<th>Val Char</th>
											<th>Val Date</th>	
											<th>Status</th>
											<th></th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($opt as $opti): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $opti->kode;?></td>
									<td><?php echo $opti->configname;?></td>
									<td><?php echo $opti->valnum;?></td>
									<td><?php echo $opti->valchar;?></td>
									<td><?php echo $opti->valdate;?></td>
									<td><?php echo $opti->status;?></td>
									<td><a href="<?php echo site_url("options/hps/$opti->kode"); ?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($opti->kode);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a data-toggle="modal" data-target=".<?php echo trim($opti->kode);?>" href="#" ><i class="fa  fa-edit"><i>Edit</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
                                </table>
                            </div>

<!--input baru-->
	<div class="modal fade baru"  role="dialog" >
	  <div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" action="<?php echo site_url('options/simpan');?>" method="post">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
				<h4 class="modal-title" id="myModalLabel">INPUT CONFIG</h4>
			</div>
			<div class="modal-body">										
			<div class="row">
				<div class="col-sm-12">
					<div class="box box-danger">
						<div class="box-body">
							<div class="form-horizontal">								
								<div class="form-group">
									<label class="col-sm-4">Kode</label>	
										<div class="col-sm-8">    
											<input type="hidden" name="type" value="input"/>
											<input type="text" name="kode1" title="Masukan Kode"></input>
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Konfig Name</label>	
										<div class="col-sm-8">    
											<input type="text" name="configname1" title="Masukan Config"></input>
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Val Num</label>	
										<div class="col-sm-8">    
											<input type="text" name="valnum1"  title="Masukan Config"></input>
										</div>
								</div><div class="form-group">
									<label class="col-sm-4">Val Char</label>	
										<div class="col-sm-8">    
											<input type="text" name="valchar1"  title="Masukan Config"></input>
										</div>
								</div><div class="form-group">
									<label class="col-sm-4">Valdate</label>	
										<div class="col-sm-8">    
											<input type="text" name="valdate1"   title="Masukan Config"></input>
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Status</label>	
										  <input name='status1' type="checkbox" value="T">Hold
										  <input name='status1' type="checkbox" value="F">No
									</label>
									 
								</div>
							</div>
						</div><!-- /.box-body -->													
					</div><!-- /.box --> 
				</div>			
			</div><!--row-->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Akan Di Simpan?')">Simpan</button>											
			</div>
			</form>
		</div>
	  </div>
	</div>
	
<!--edit user-->	
	<!-- Modal -->
<?php foreach ($opt as $op) { ?>
	<div class="modal fade <?php echo trim($op->kode);?>"  role="dialog" >
	  <div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal" action="<?php echo site_url('options/simpan');?>" method="post">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
				<h4 class="modal-title" id="myModalLabel">INPUT CONFIG</h4>
			</div>
			<div class="modal-body">										
			<div class="row">
				<div class="col-sm-12">
					<div class="box box-danger">
						<div class="box-body">
							<div class="form-horizontal">								
								<div class="form-group">
									<label class="col-sm-4">Kode</label>	
										<div class="col-sm-8">    
											<input type="hidden" name="type" required value="edit"/>
											<input type="text" name="kode1" readonly  value="<?php echo $op->kode;?>" title="Masukan Kode"></input>
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Konfig Name</label>	
										<div class="col-sm-8">    
											<input type="text" name="configname1" value="<?php echo $op->configname;?>" required title="Masukan Config"></input>
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Val Num</label>	
										<div class="col-sm-8">    
											<input type="text" name="valnum1" value="<?php echo $op->valnum;?>" required title="Masukan Config"></input>
										</div>
								</div><div class="form-group">
									<label class="col-sm-4">Val Char</label>	
										<div class="col-sm-8">    
											<input type="text" name="valchar1" value="<?php echo $op->valchar;?>" required title="Masukan Config"></input>
										</div>
								</div><div class="form-group">
									<label class="col-sm-4">Valdate</label>	
										<div class="col-sm-8">    
											<input type="text" name="valdate1" value="<?php echo $op->valdate;?>" required title="Masukan Config"></input>
										</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4">Status</label>	
										<div class="col-sm-8">    
											<input type="text" name="status1" value="<?php echo $op->status;?>" required title="Masukan Config"></input>
										</div>
								</div>
							</div>
						</div><!-- /.box-body -->													
					</div><!-- /.box --> 
				</div>			
			</div><!--row-->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Akan Di Simpan?')">Simpan</button>											
			</div>
			</form>
		</div>
	  </div>
	</div>
<?php } ?>

