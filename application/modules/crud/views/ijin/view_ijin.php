<?php 
/*
	@author : hanif_anak_metal \m/
*/
error_reporting(0);
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
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

<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-header">
				<a href="<?php echo site_url('hrd/ijin');?>" class="btn btn-primary" style="margin:10px">
			   <i class="glyphicon glyphicon-edit"></i>Kembali</a>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>NIP</th>
							<th>Nama</th>
							<th>Alamat</th>
							<th>Departemen</th>
							<th>Jabatan</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_pegawai as $row): $no++;?>
						<tr>
							<td><?php echo $no;?></td>
							<!--<td><a href="<?php echo site_url('hrd/hrd/detail_peg/').'/'.trim($row->list_nip);?>"><?php echo $row->list_nip;?></a></td>-->
							<td><a href="#" data-toggle="modal" data-target=".<?php echo trim(str_replace('.','_',$row->list_nip));?>"><?php echo $row->nmlengkap;?></a></td>
							<td><?php echo $row->nmlengkap;?></td>
							<td><?php echo $row->alamat;?></td>
							<td><?php echo $row->departement;?></td>
							<td><?php echo $row->deskripsi;?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
							
		<!--Modal untuk edit-->
		<?php $no=0; foreach($list_pegawai as $row){ $no++;?>
			<div class="modal fade <?php echo trim(str_replace('.','_',$row->list_nip));?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">DATA PEGAWAI: <?php echo $row->nmlengkap;?></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<form action="<?php echo site_url('hrd/ijin/input_ijin');?>" method="post">
							<input type="hidden" name="nip" value="<?php echo $row->list_nip;?>">
							<input type="hidden" name="jabt" value="<?php echo $row->kdjabatan;?>">
							<input type="hidden" name="dept" value="<?php echo $row->kddept;?>">
							<div class="col-sm-12">							
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Ijin</label>
									<div class="col-sm-6">
									  <select class='form-control input-sm' name="ijin" id="tujuan">		
										<?php
											if(empty($qkodeatt))
											{
												echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
											} else {
												foreach($qkodeatt as $column)
											{
											?>
											<option value="<?php echo $column->kdatt; ?>"><?php echo $column->desc_kdatt; ?></option>
											<?php }} ?>
									  </select>
									</div>
									<div class="col-sm-10"></div>
								</div>	
								<!--
								<div class="form-group">
									<label for="tglm" class="col-sm-4 control-label">Tanggal</label>
									<div class="col-sm-6">
									  <input type="text" class="form-control input-sm" id="tgl<?php echo trim(str_replace('.','_',$row->list_nip));?>" data-date-format="dd-mm-yyyy" name="tglijin" required>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tglm" class="col-sm-4 control-label">Jam Awal</label>
									<div class="col-sm-6">
										<select class="form-control" required="" name="mulai" type="text">
											<option value="08:00" type="text">08:00</option>
											<option value="09:00" type="text">09:00</option>
											<option value="10:00" type="text">10:00</option>
											<option value="11:00" type="text">11:00</option>
											<option value="12:00" type="text">12:00</option>
											<option value="13:00" type="text">13:00</option>
											<option value="14:00" type="text">14:00</option>
											<option value="15:00" type="text">15:00</option>
											<option value="16:00" type="text">16:00</option>
											<option value="17:00" type="text">17:00</option>
											<option value="18:00" type="text">18:00</option>											
										</select>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="tglm" class="col-sm-4 control-label">Jam Akhir</label>
									<div class="col-sm-6">
										<select class="form-control" required="" name="akhir" type="text">
											<option value="08:00" type="text">08:00</option>
											<option value="09:00" type="text">09:00</option>
											<option value="10:00" type="text">10:00</option>
											<option value="11:00" type="text">11:00</option>
											<option value="12:00" type="text">12:00</option>
											<option value="13:00" type="text">13:00</option>
											<option value="14:00" type="text">14:00</option>
											<option value="15:00" type="text">15:00</option>
											<option value="16:00" type="text">16:00</option>
											<option value="17:00" type="text">17:00</option>
											<option value="18:00" type="text">18:00</option>
										</select>
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
									<div class="col-sm-6">
									  <textarea class="form-control input-sm" id="ketm" name="keterangan" required></textarea>
									</div>
									<div class="col-sm-10"></div>
								</div>
								-->
							</div>		
						</div>													
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-default" onclick="return confirm('Simpan Data ini?')">Simpan Data</button>											
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>											
					</div>
					</form>
				</div>
			  </div>
			</div>			
		<?php }?>
		
		
		
	</div>
</div>



<script>

    $(function() {
		$("[data-mask]").inputmask();
		<?php foreach($list_pegawai as $row){ ?>
		$('#tgl<?php echo trim(str_replace('.','_',$row->list_nip));?>').datepicker();
		<?php } ?>
		$('#masuk').datepicker();
		$('#keluar').datepicker();
		$('#tglm').datepicker();
		$('#berlaku').daterangepicker();
		//Timepicker
		<?php foreach($list_pegawai as $row){ ?>
		$(".timepicker<?php echo trim(str_replace('.','_',$row->list_nip));?>").timepicker({
			showInputs: false
		});
		<?php } ?>
		
		});
		
		
</script>