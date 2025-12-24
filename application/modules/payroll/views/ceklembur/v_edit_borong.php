<?php 
/*
	@author : junis 10-12-2012\m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
            });
		
</script>
<script>
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<!-- data tabel 2 --->
<div class="row">
				<div class="col-sm-12">		
					<!--<a data-toggle="modal" data-target="#modal1" href='#'  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
					<!--<a href="<?php echo site_url("trans/upah_borong/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>-->
				</div>
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama Kategori</th>
							<th>Nama Sub-Kategori</th>					
							<th>Metriks</th>					
							<th>Satuan Metriks</th>					
							<th>Target Kerja</th>					
							<th>Pencapaian</th>
							<th>Upah Borong</th>
							<!--<th>Catatan</th>-->
							<th>Action</th>
							
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_upah_dtl as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nmborong;?></td>
							<td><?php echo $lu->nmsub_borong;?></td>
							<td><?php echo $lu->metrix;?></td>
							<td><?php echo $lu->satuan;?></td>
							<td><?php echo $lu->total_target;?></td>
							<td><?php echo $lu->pencapaian;?></td>
							<td><?php echo $lu->upah_borong;?></td>
							<!--<td><?php echo $lu->catatan;?></td>-->
							<td>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->no_urut);?>" href='#' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<!--<a  href="<?php $nik=trim($lu->nik);$nodok=trim($lu->nodok);echo site_url("trans/upah_borong/hps_upah_borong_dtl/$lu->no_urut/$nik")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
							</td>
						
						</tr>
						<?php endforeach;?>
						
					</tbody>
					<tfoot>
						<tr>
						<td class="right" colspan="7">Total Upah:</td><td class="right"><?php echo $total_upah['total_upah'];?></td>
						
						</tr>
					</tfoot>	
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
	<div class="col-sm-12">
		<a <?php $nodok2=trim($this->session->userdata('nik'));?> href="<?php echo site_url("payroll/ceklembur/lihat_borong_detail/$tglawal/$tglakhir/$nik/$kddept")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
	</div>
</div>







<!-- modal edit data -->
<?php foreach ($list_upah_dtl as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->no_urut); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Detail Upah Borong Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('payroll/ceklembur/edit_borong_detail')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="I" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>	
							
							<div class="form-group">
								<label class="col-sm-4">Nomor Dokumen</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Kategori</label>	
								<div class="col-sm-8">    
									<input type="text" id="kdborong" name="kdborong"  value="<?php echo trim($lb->nmborong);?>" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Sub Kategori</label>	
								<div class="col-sm-8">    
									<input type="text" id="kdborong" name="kdborong"  value="<?php echo trim($lb->nmsub_borong);?>" class="form-control" readonly>
								</div>
							</div>	
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							
							
							<script type="text/javascript">
								 $(function() {	
								$("#kdsub_borong<?php echo $lb->no_urut;?>").chained("#kdborong<?php echo $lb->no_urut;?>");		
								$("#metrix<?php echo $lb->no_urut;?>").chained("#kdsub_borong<?php echo $lb->no_urut;?>");	
								$("#satuan<?php echo $lb->no_urut;?>").chained("#kdsub_borong<?php echo $lb->no_urut;?>");	
								$("#tarif_satuan<?php echo $lb->no_urut;?>").chained("#kdsub_borong<?php echo $lb->no_urut;?>");	
								$("#total_target<?php echo $lb->no_urut;?>").chained("#kdsub_borong<?php echo $lb->no_urut;?>");	
								$("#kodekomponen").chained("#kode_bpjs");					
							  });
							</script>	
							
							<div class="form-group">
								<label class="col-sm-4">Metriks</label>	
								<div class="col-sm-8">    
									<input type="text" id="kdborong" name="kdborong"  value="<?php echo trim($lb->metrix);?>" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Satuan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kdborong" name="kdborong"  value="<?php echo trim($lb->satuan);?>" class="form-control" readonly>
									<input type="hidden" id="tgl2" name="tglawal"  value="<?php echo $tglawal;?>"class="form-control" readonly>
									<input type="hidden" id="tgl3" name="tglakhir"  value="<?php echo $tglakhir;?>"class="form-control" readonly>
									<input type="hidden" id="tgl4" name="kdgroup_pg"  value="<?php //echo $kdgroup_pg;?>"class="form-control" readonly>
									<input type="hidden" id="tgl4" name="kddept"  value="<?php echo $kddept;?>"class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tarif Satuan</label>	
								<div class="col-sm-8">    
									<input type="text" id="kdborong" name="tarif_satuan"  value="<?php echo trim($lb->tarif_satuan);?>" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total Target</label>	
								<div class="col-sm-8">    
									<input type="text" id="kdborong" name="total_target"  value="<?php echo trim($lb->total_target);?>" class="form-control" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pencapaian</label>	
								<div class="col-sm-8">    
									<input type="numeric"  id="gaji" name="pencapaian" placeholder="Contoh(50.00)"   value="<?php echo trim($lb->pencapaian);?>" class="form-control" required>
								</div>
							</div>	
							<!--<div class="form-group">
								<label class="col-sm-4">Upah Borong</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" value="<?php echo $lb->upah_borong ;?>" name="upah_borong" placeholder="<?php echo $lb->upah_borong ;?>"   class="form-control" required>
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Catatan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="catatan"   style="text-transform:uppercase" class="form-control"><?php echo $lb->catatan ;?></textarea>
									<input type="hidden" id="tgl1" name="no_urut"  value="<?php echo $lb->no_urut;?>"class="form-control" readonly>
									<input type="hidden" id="tgl1" name="tgl_dok"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
									
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<?php } ?>





