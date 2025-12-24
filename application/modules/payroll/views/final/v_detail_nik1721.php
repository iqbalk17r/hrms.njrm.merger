<?php 
/*
	@author : junis 10-12-2012\m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable( {
					lengthMenu: [
                [5, 15, 20, 50, 100, 500, 1000, -1],
                [5, 15, 20, 50, 100, 500, 1000, 'All'] // change per page values here
            ],	pageLength: 50
			
				}
				);
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
			<?php echo 'Nama : '.$dtl_kary['nmlengkap'].'</h3>';?>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="<?php echo site_url("payroll/final_payroll/detail_1721/$tahun/$kddept/$kdgroup_pg");?>" class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
					<!--form action="<?php echo site_url("payroll/generate/simpan_edit1721");?>" method="post">
					<input type="hidden" id="nik" name="karyawan"  value="<?php echo $nik;?>">
					<button  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</button>
					</form-->
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>								
							<th>Nama Komponen</th>																																
							<th>Keterangan</th>																																
							<th>Nominal (Rp.)</th>								
							<!--th>Action</th-->						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_nik as $lu) {;?>
						<tr>
							
							<td width="2%"><?php echo $lu->no_urut;?></td>																							
							<td width="40%"><?php echo $lu->keterangan;?></td>
							<td align="right" width="10%"><?php echo $lu->tipe;?></td>
							<td align="right" width="10%"><?php echo $lu->nominal;?></td>
							<!--td width="10%"-->
							<!--?php// if (trim($lu->no_urut)=='3' or trim($lu->no_urut)=='2' or trim($lu->no_urut)=='10' ) { ?>
					
								<!--a  <!--?php $nik=trim($lu->nik);?> href="<?php echo site_url("payroll/detail_payroll/detail_tunjangan/$lu->no_urut")?>" class="btn btn-success  btn-sm">
									<i class="fa fa-cloud"></i> Detail
								</a-->
							<!--?php// } ?-->	
							<!--?php if (($lu->no_urut==4) or ($lu->no_urut==6) or ($lu->no_urut==13)or ($lu->no_urut==18) or
									 ($lu->no_urut==24) or ($lu->no_urut==25) or ($lu->no_urut==26) or ($lu->no_urut==29) or ($lu->no_urut==30)) { ?>
							
								<a href="#" data-toggle="modal" data-target="#<?php echo $lu->no_urut;?>" class="btn btn-warning  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<!--<a  href="<?php echo site_url("master/formula/hps_detail/$kdrumus/$lu->no_urut")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
							<!--?php } ?>	
							</td--->
							
						</tr>
						<?php };?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


<!-- modal edit data -->
<?php foreach ($list_nik as $lu) { ?>
<div class="modal fade" id="<?php echo trim($lu->no_urut); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Komponen Pelaporan PPH 21 FORM 1721-A1</h4>
      </div>
	  <form action="<?php echo site_url('payroll/generate/simpan_edit1721')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
						
							<div class="form-group">
								<label class="col-sm-4">Nama Komponen</label>	
								<div class="col-sm-8">    
									
									<input type="text"name="keterangan"  value="<?php echo trim($lu->keterangan);?>" class="form-control" style="text-transform:uppercase" maxlength="50" readonly>
									<input type="hidden" name="no_urut"  value="<?php echo trim($lu->no_urut);?>" class="form-control">
									<input type="hidden" name="nik"  value="<?php echo trim($lu->nik);?>" class="form-control">
									<input type="hidden" id="kdgroup_pg" name="kdgroup_pg"  value="<?php echo trim($kdgroup_pg);?>" class="form-control">
									<input type="hidden" name="kddept"  value="<?php echo trim($kddept);?>" class="form-control">
									<input type="hidden" name="tahun"  value="<?php echo $tahun;?>" class="form-control">

								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Nominal</label>	
								<div class="col-sm-8">    
									
									<input type="text" name="nominal"  placeholder="<?php echo trim($lu->nominal);?>"  data-inputmask='"mask": "99999999"' data-mask="" class="form-control"   >

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






