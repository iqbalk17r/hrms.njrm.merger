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


<body >

<?php echo $message;?>
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
<div class="row">
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<!--<a href="<?php echo site_url("trans/lembur/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
				
				<div class="col-sm-6">
				
				<a href="<?php echo site_url("payroll/ceklembur/index/")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				</div>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
							
							<th>Nomer Dokumen</th>																				
							<th>NIK</th>										
							<th>Nama Karyawan</th>							
							<th>Tanggal Kerja</th>
							<th>Jam Mulai</th>
							<th>Jam Selesai</th>
							<th>Jam Mulai(Mesin)</th>
							<th>Jam Selesai(Mesin)</th>
							<th>Durasi Waktu SPL</th>								
							<th>Durasi Waktu Absen</th>																		
							<th>Nominal</th>																		
							<th>Keterangan</th>																		
							<!--<th>Action</th>-->						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_lembur as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><a href="#" data-toggle="modal" data-target="#dtl<?php echo trim($lu->nodok_ref);?>"><?php echo $lu->nodok_ref;?></a></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->tgl_kerja1;?></td>
							<td><?php echo $lu->jam_mulai;?></td>
							<td><?php echo $lu->jam_selesai;?></td>
							<td><?php echo $lu->jam_mulai_absen;?></td>
							<td><?php echo $lu->jam_selesai_absen;?></td>
							<td><?php echo $lu->jam;?></td>
							<td><?php echo $lu->jam2;?></td>
							<td><?php echo $lu->nominal1;?></td>
							<td><?php echo $lu->ketsts;?></td>
							<!--<td>
								<!--<a href="<?php $nik=trim($lu->nik); echo site_url("trans/lembur/detail/$nik/$lu->nodok")?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>-->
								<?php if (trim($lu->status)<>'C' and trim($lu->status)<>'A') {?>
								<!--<a href="<?php $nik=trim($lu->nik); echo site_url("trans/lembur/final_mst/$lu->nodok/$nik")?>" onclick="return confirm('Anda Yakin Approval Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Final
								</a>
								<!--<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/lembur/hps_lembur/$lu->nodok")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
								<?php } ?>
							<!--</td>-->
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>






<!-- detail -->
<?php foreach ($list_lembur as $lb){?>
<div class="modal fade" id="dtl<?php echo trim($lb->nodok_ref); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail Lembur Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('payroll/ceklembur/edit_lembur')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							
						<div class="form-group">
								<label class="col-sm-4">No. Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="status" name="nodok"  value="<?php echo trim($lb->nodok_ref); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="A" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>			
							<div class="form-group">
								<label class="col-sm-4">Tanggal Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="tgl_dok"  value="<?php echo trim($lb->tgl_nodok_ref);?>"class="form-control" readonly>
									<input type="hidden" id="tgl2" name="tglawal"  value="<?php echo $tglawal;?>"class="form-control" readonly>
									<input type="hidden" id="tgl3" name="tglakhir"  value="<?php echo $tglakhir;?>"class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tipe Lembur</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlembur"  value="<?php echo trim($lb->tplembur); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tipe Lembur</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlembur"  value="<?php echo trim($lb->jenis_lembur); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
								
							<div class="form-group">
								<label class="col-sm-4">Tanggal Kerja</label>	
								<div class="col-sm-8">    
									<input type="text" value="<?php echo trim($lb->tgl_kerja1); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Awal</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="jam_mulai" value="<?php echo trim($lb->jam_mulai1); ?>" placeholder="HH:MM:SS" data-inputmask='"mask": "99:99:99"' data-mask="" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="jam_selesai" value="<?php echo trim($lb->jam_selesai1); ?>" placeholder="HH:MM:SS" data-inputmask='"mask": "99:99:99"' data-mask="" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Mulai (Mesin)</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="jam_mulai_absen" placeholder="HH:MM:SS" value="<?php echo trim($lb->jam_mulai_absen1); ?>" data-inputmask='"mask": "99:99:99"' data-mask="" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Selesai (Mesin)</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="jam_selesai_absen" placeholder="HH:MM:SS" value="<?php echo trim($lb->jam_selesai_absen1); ?>" data-inputmask='"mask": "99:99:99"' data-mask="" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Durasi(jam)</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="durasi" placeholder="0" value="<?php echo trim($lb->jam); ?>"  class="form-control" readonly >
								</div>
							</div>
								
							
							
							
							<div class="form-group">
								<label class="col-sm-4">Nominal</label>	
								<div class="col-sm-8">    
									<input type="text" id="nmdept" name="keterangan"  value="<?php echo $lb->nominal1;?>" class="form-control" readonly>
									
									
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
</body>



