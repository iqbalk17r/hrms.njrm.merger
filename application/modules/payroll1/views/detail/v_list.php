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
<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
        <?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>
            <li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>
        <?php } else { ?>
            <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
        <?php } ?>
    <?php } ?>
</ol>
<h3><?php echo $title; ?></h3>
<?php echo $message;?>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Generate Karyawan Susulan</a>
					<!--<a href="<?php echo site_url("payroll/detail_payroll/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>-->
					<a href="<?php echo site_url("payroll/detail_payroll/clear_tmp/$enc_nodok/$enc_kddept")?>"  class="btn btn-danger" onclick="return confirm('Anda Yakin Menghapus Data ini?')" style="margin:10px; color:#ffffff;">CLEAR</a>
					
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<?php //echo '<h2>NIK : '.$nik.'<br>';?>
			<?php //echo 'Nama : '.$nama.'</h2>';?>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Nomer Dokumen</th>							
							<th>Nik</th>								
							<th>Nama Lengkap</th>								
							<th>Total Diterima (Rp.)</th>	
							<th>Total Pendapatan (Rp.)</th>								
							<th>Total Potongan (Rp.)</th>								
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_master as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td align="right"><?php echo $lu->total_upah1;?></td>
							<td align="right"><?php echo $lu->total_pendapatan1;?></td>
							<td align="right"><?php echo $lu->total_potongan1;?></td>
							<td>
								<!--<a href="#"  data-toggle="modal" data-target="#<?php echo trim($lu->kdrumus);?>"  class="btn btn-warning btn-sm">
									<i class="fa fa-edit"></i> Input Detail
								</a>-->
								<a href="<?php $nik=trim($lu->nik);
								$enc_nik = $this->fiky_encryption->enkript($nik);
								echo site_url("payroll/detail_payroll/detail/$enc_nik/$enc_kdgroup_pg/$enc_kddept/$enc_periode/$enc_keluarkerja")?>" class="btn btn-primary  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>
								<!--<a  href="<?php $nik=trim($lu->kdrumus); echo site_url("master/formula/hps_formula/$lu->kdrumus")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
								
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<!--<a href="<?php echo site_url("payroll/detail_payroll/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>-->
					
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
			<?php echo '<h2><center>TOTAL REKAP PAYROLL</center></h2>';?>
			<?php //echo 'Nama : '.$nama.'</h2>';?>
				<table id="example3" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>								
							<th>Nomer Dokumen</th>								
							<th>Total Diterima</th>								
							<th>Total Pendapatan</th>								
							<th>Total Potongan</th>								
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_rekap as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->total_upah1;?></td>
							<td><?php echo $lu->total_pendapatan1;?></td>
							<td><?php echo $lu->total_potongan1;?></td>
							<td>
								<!--<a href="#"  data-toggle="modal" data-target="#<?php echo trim($lu->kdrumus);?>"  class="btn btn-warning btn-sm">
									<i class="fa fa-edit"></i> Input Detail
								</a>-->
								<a <?php $nodok=trim($lu->nodok);?> href="<?php echo site_url("payroll/detail_payroll/harap_tunggu1/$kdgroup_pg/$kddept/$periode/$keluarkerja")?>" onclick="return confirm('Anda Yakin Final Data ini?')" class="btn btn-warning  btn-sm">
									<i class="fa fa-edit"></i> NEXT STEP2
								</a>
								
								<!--<a  href="<?php $nik=trim($lu->kdrumus); echo site_url("master/formula/hps_formula/$lu->kdrumus")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
								
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
			
		</div><!-- /.box -->								
	</div>
</div>

<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Generate Susulan</h4>
      </div>
	  <form action="<?php echo site_url('payroll/detail_payroll/generate_tmp_new')?>" method="post">
      <div class="modal-body">
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">NIK</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="pilihkaryawan" name="nik">
					<option value="">--ALL--</option>
					<?php foreach ($list_karyawan_new as $ld){ ?>
					<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nik.'|'.$ld->nmlengkap;?></option>
					<?php } ?>	
				</select>
				<input type="hidden" id="status" name="kdgroup_pg"  value="<?php echo $kdgroup_pg;?>" class="form-control" readonly>	
				<input type="hidden" id="status" name="kddept"  value="<?php echo $kddept;?>" class="form-control" readonly>	
				<input type="hidden" id="status" name="periode"  value="<?php echo $periode;?>" class="form-control" readonly>	
				<input type="hidden" id="status" name="keluarkerja"  value="<?php echo $keluarkerja;?>" class="form-control" readonly>	
				<!--<input type="hidden" id="status" name="tgl"  value="<?php //echo $tgl;?>" class="form-control" readonly>-->	
			</div>			
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Proses</button>
      </div>
	  </form>
    </div>
  </div>
</div>












