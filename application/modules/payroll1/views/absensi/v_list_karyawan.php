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


<body onLoad="noBack();" onpageshow="if (event.persisted) noBack();" onUnload="">
<legend><?php echo $title;?></legend>

<div class="row">
				<div class="col-sm-12">		
					<!--<a href="<?php echo site_url("payroll/cuti/karyawan/")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>-->	
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
							<th>Action</th>	
							<th>NIK</th>
							<th>Nama Karyawan</th>					
							<th>Department</th>					
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_karyawan as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->nik);?>" href="#" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail Absensi 
								</a>
							</td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

<?php foreach ($list_lk as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->nik); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">FILTER ABSENSI</h4>
      </div>
	  <form action="<?php echo site_url('payroll/absensi/index')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
						 <div class="form-group">		
							<label class="label-form col-sm-3">Bulan</label>
							<div class="col-sm-9">
							<input type="hidden" value="<?php echo trim($lb->nik);?>" name="nik">
								<select class="form-control input-sm" name='bulan'>
									
									<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
									<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
									<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
									<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
									<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
									<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
									<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
									<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
									<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
									<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
									<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
									<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
								</select>
							</div>			
						</div>
						<div class="form-group ">		
							<label class="label-form col-sm-3">Tahun</label>
							<div class="col-sm-9">
								<select class="form-control input-sm" name="tahun">
									<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
									<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
									<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
								</select>
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
        <button type="submit"  class="btn btn-primary">PROSES</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<?php } ?>
</body>




