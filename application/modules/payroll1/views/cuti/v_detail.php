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
<legend><?php echo $title;?></legend>
<?php echo $message;?>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<!--<a href="<?php echo site_url("trans/lembur/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
				
				<div class="col-sm-6">
				<h5>NIK : <?php echo $nik;?><br>
				<h5>Nama : <?php echo $list_karyawan['nmlengkap'];?><br>
				<a href="<?php echo site_url("payroll/cuti/karyawan/")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
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
							<th>Tanggal Mulai</th>										
							<th>Tanggal Selesai</th>										
							<th>NIK</th>										
							<th>Nama Karyawan</th>										
							<th>Nama Department</th>	
							<th>Status</th>											
							<!--<th>Action</th>-->						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_cuti as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><a href="#" data-toggle="modal" data-target="#dtl<?php echo trim($lu->nodok);?>"><?php echo $lu->nodok;?></a></td>
							<td><?php echo $lu->tgl_mulai1;?></td>
							<td><?php echo $lu->tgl_selesai1;?></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							<td><?php echo $lu->status1;?></td>
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

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="<?php echo site_url('payroll/absensi/karyawan');?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
					<a href="#" data-toggle="modal" data-target="#filter" class="btn btn-success" style="margin:10px; color:#ffffff;">Filter</a>
					<!--<button class="btn btn-primary" onclick="add_person()" style="margin:10px; color:#ffffff;"><i class="glyphicon glyphicon-plus"></i> Data Mesin Absen</button>-->
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>							
																
							<th width="5%">No.</th>
							<th>Nama</th>
							<th>NIK</th>
							<th>Tanggal</th>
							<th>Shift</th>
							<th>Jam Masuk</th>
							<th>Jam Pulang</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach ($list_absensi as $la): $no++ ?>
							<tr>																					
								<td><?php echo $no;?></td>																
								<td><?php echo $la->nmlengkap;?></td>																
								<td><?php echo $la->nik;?></td>								
								<td><?php echo $la->tgl;?></td>								
								<td><?php echo $la->shiftke;?></td>								
								<td><?php echo $la->jam_masuk_absen;?></td>	
								<td><?php echo $la->jam_pulang_absen;?></td>	
								<td><?php echo $la->ketsts;?></td>	
								<!--<td>
								<a  data-toggle="modal" data-target="#<?php echo trim($la->id);?>" href='#' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-pencil"></i> Edit
								</a>
								<a  href="<?php echo site_url("trans/absensi/hapus_absensi/$la->id")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Delete
								</a>
							</td>-->	
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>
<!-- data tabel 2 --->
<!--<div class="row">
				<div class="col-sm-12">		
					<a data-toggle="modal" data-target="#modal1" href='#'  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
					<!--<a href="<?php echo site_url("trans/lembur/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>-->
				</div>
	<!--<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->
			<!--<div class="box-body table-responsive" style='overflow-x:scroll;'>
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
							<th>Catatan</th>
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
							<td><?php echo $lu->lembur;?></td>
							<td><?php echo $lu->catatan;?></td>
							<td>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->no_urut);?>" href='#' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a  href="<?php $nik=trim($lu->nik);$nodok=trim($lu->nodok);echo site_url("trans/lembur/hps_lembur_dtl/$lu->no_urut/$nik")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>
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
	<!--</div>
</div>-->







<!-- detail -->
<?php foreach ($list_cuti as $lb){?>
<div class="modal fade" id="dtl<?php echo trim($lb->nodok); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail Cuti Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('trans/lembur/edit_lembur_dtl_2')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							
						<div class="form-group">
								<label class="col-sm-4">No. Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="status" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($lb->kdlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>			
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="department"  value="<?php echo trim($lb->nmdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="subdepartment"  value="<?php echo trim($lb->nmsubdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							<!--<div class="form-group">
								<label class="col-sm-4">Level Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlvl"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="jabatan"  value="<?php echo trim($lb->nmjabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan"  value="<?php echo trim($lb->nmatasan1); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
								<label class="col-sm-4">Tipe Cuti</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="tpcuti"  value="<?php echo trim($lb->tpcuti); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Ijin Khusus</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdijin_khusus"  value="<?php echo trim($lb->nmijin_khusus); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
								<div class="form-group">
								<label class="col-sm-4">Jumlah Cuti(Hari)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="durasi" placeholder="0" value="<?php echo trim($lb->jumlah_cuti); ?>"  class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pelimpahan</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="kdtrx"  value="<?php echo trim($lb->nmpelimpahan);?>"class="form-control" readonly>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Tanggal Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="tgl_dok"  value="<?php echo trim($lb->tgl_dok1);?>"class="form-control" readonly>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($lb->keterangan);?></textarea>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
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
        <!--<button type="submit"  class="btn btn-primary">SIMPAN</button>-->
      </div>
	  </form>
    </div>
  </div>
</div>
<?php } ?>
</body>



