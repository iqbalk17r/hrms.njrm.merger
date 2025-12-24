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
<?php //echo $message;?>
<?php //echo '<h3>NIK : '.$nik.'<br>';?>
			<?php //echo 'Nama : '.$nama.'</h3>';?>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<a href="<?php echo site_url("payroll/detail_payroll/detail/$nik");?>" class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
					
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No. Dokumen</th>								
							<th>NIK</th>								
							<th>Tanggal Kerja</th>																
							<th>Jam Awal</th>																
							<th>Jam Akhir</th>																
							<th>Durasi (Menit)</th>																
							<th>Nominal</th>								
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($detail_lembur as $lu) {;?>
						<tr>										
							<td><?php echo $lu->nodok;?></td>																							
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->tgl_kerja;?></td>
							<td><?php echo $lu->jam_mulai;?></td>
							<td><?php echo $lu->jam_selesai;?></td>
							<td><?php echo $lu->jumlah_jam;?></td>
							<td align="right"><?php echo $lu->nominal1;?></td>
							<td>
							
								<a href="#" data-toggle="modal" data-target="#<?php echo trim($lu->urut); ?>" class="btn btn-warning  btn-sm">
									<i class="fa fa-edit"></i> edit
								</a>
								<!--<a  href="<?php echo site_url("master/formula/hps_detail/$kdrumus/$lu->no_urut")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
							
							</td>
						</tr>
						<?php };?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


<!-- modal edit data -->
<?php foreach ($detail_lembur as $lu) { ?>
<div class="modal fade" id="<?php echo trim($lu->urut); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Detail Payroll</h4>
      </div>
	  <form action="<?php echo site_url('payroll/detail_payroll/update_detail_lembur')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
						
							<div class="form-group">
								<label class="col-sm-4">Nama Komponen</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="tgl_kerja"  value="<?php echo trim($lu->tgl_kerja);?>" class="form-control" style="text-transform:uppercase" maxlength="50" readonly>
									<input type="hidden" id="nik" name="urut"  value="<?php echo trim($lu->urut);?>" class="form-control">
									<input type="hidden" id="nik" name="nik"  value="<?php echo trim($lu->nik);?>" class="form-control">
									<input type="hidden" id="nik" name="no_urut"  value="<?php echo trim($no_urut);?>" class="form-control">
									
									
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Nominal</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="nominal"  placeholder="<?php echo trim($lu->nominal1);?>"  data-inputmask='"mask": "99999999"' data-mask="" class="form-control"   >
									
									
								</div>
							</div>
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	
			<!--<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">

							
							
						</div>													
					</div>												
				</div>	
			</div>-->	
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






