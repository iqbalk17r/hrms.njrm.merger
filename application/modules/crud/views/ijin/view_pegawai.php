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
<legend>Daftar Pegawai </legend>

<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-header">
			   <a href="#" data-toggle="modal" data-target=".input_ijin" class="btn btn-primary" style="margin:10px">
			   <i class="glyphicon glyphicon-edit"></i>INPUT IJIN</a>			   
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
							<td><a href="<?php echo site_url('hrd/hrd/detail_peg/').'/'.$row->list_nip;?>"><?php echo $row->list_nip;?></a></td>
							<td><a href="#" data-toggle="modal" data-target=".ijin<?php echo $row->list_nip;?>"><?php echo $row->nmlengkap;?></a></td>
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
			<?php foreach ($list_pegawai as $lp) {?>
			<div class="modal fade ijin<?php echo trim($lp->list_nip);?>" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Input Ijin <?php echo $lp->nmlengkap;?></h4>
						</div>
						<div class="modal-body">
							
							<div class="row">
							  <div class="col-sm-12">								
								<div class="form-group">
									<label for="tujuan" class="col-sm-4 control-label">Ijin</label>
									<div class="col-sm-6">
									  <select class='form-control input-sm' name="tujuan" id="tujuan">		
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
									  <input type="text" class="form-control input-sm" id="tgl<?php echo trim($lp->list_nip);?>" name="tglm">
									</div>
									<div class="col-sm-10"></div>
								</div>
								<div class="form-group">
									<label for="ketm" class="col-sm-4 control-label">Keterangan</label>
									<div class="col-sm-6">
									  <textarea class="form-control input-sm" id="ketm" name="keterangan"></textarea>
									</div>
									<div class="col-sm-10"></div>
								</div>
								-->
							  </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save</button>
						</div>
					</div>
				  </div>
				</div>
			<?php }?>
		
		
		
		
	</div>
</div>



<script>

    $(function() {
		$("[data-mask]").inputmask();
		<?php foreach ($list_pegawai as $lptgl){?>
			$('#tgl<?php echo trim($lptgl->list_nip);?>').datepicker();
		<?php }?>
		$('#tgl').datepicker();
		
		$('#masuk').datepicker();
		$('#keluar').datepicker();
		$('#tglm').datepicker();
		$('#berlaku').daterangepicker();
		});
		
</script>