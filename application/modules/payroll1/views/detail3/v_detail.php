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
<?php echo '<h3>NIK : '.$nik.'<br>';?>
			<?php echo 'Nama : '.$nama.'</h3>';?>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<form action="<?php echo site_url('payroll/detail_payroll/master');?>" method="post">
					<input type="hidden" id="nik" name="karyawan"  value="<?php echo $nik;?>">
					<button  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</button>
					</form>
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>								
							<th>Keterangan</th>																
							<th>Nominal</th>								
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_detail as $lu) {;?>
						<tr>										
							<td width="2%"><?php echo $lu->no_urut;?></td>																							
							<td><?php echo $lu->keterangan;?></td>
							<td><?php echo $lu->nominal;?></td>
							<td>
							<?php if (trim($lu->no_urut)=='4' or trim($lu->no_urut)=='10' or trim($lu->no_urut)=='11' or trim($lu->no_urut)=='4' or trim($lu->no_urut)=='6') { ?>
								<!--<a href="#" data-toggle="modal" data-target="#<?php echo $lu->no_urut;?>" class="btn btn-warning  btn-sm">
									<i class="fa fa-edit"></i> edit
								</a>-->
								<a  href="<?php echo site_url("payroll/detail_payroll/detail_tunjangan/$lu->no_urut/$lu->nik")?>" class="btn btn-success  btn-sm">
									<i class="fa fa-cloud"></i> Detail
								</a>
							<?php } ?>	
							<?php if (trim($lu->tipe)=='INPUT MANUAL') { ?>
								<a href="#" data-toggle="modal" data-target="#<?php echo $lu->no_urut;?>" class="btn btn-warning  btn-sm">
									<i class="fa fa-edit"></i> edit
								</a>
								<!--<a  href="<?php echo site_url("master/formula/hps_detail/$kdrumus/$lu->no_urut")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
							<?php } ?>	
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
<?php foreach ($list_detail as $lu) { ?>
<div class="modal fade" id="<?php echo trim($lu->no_urut); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Detail Payroll</h4>
      </div>
	  <form action="<?php echo site_url('payroll/detail_payroll/update_detail')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
						
							<div class="form-group">
								<label class="col-sm-4">Nama Komponen</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="keterangan"  value="<?php echo trim($lu->keterangan);?>" class="form-control" style="text-transform:uppercase" maxlength="50" >
									<input type="hidden" id="nik" name="no_urut"  value="<?php echo trim($lu->no_urut);?>" class="form-control">
									<input type="hidden" id="nik" name="nik"  value="<?php echo trim($lu->nik);?>" class="form-control">
									
									
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Nominal</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="nominal"  placeholder="<?php echo trim($lu->nominal);?>"  data-inputmask='"mask": "99999999"' data-mask="" class="form-control"   >
									
									
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






