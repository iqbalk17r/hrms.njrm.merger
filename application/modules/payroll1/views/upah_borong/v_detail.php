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
					<!--<a href="<?php echo site_url("trans/upah_borong/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
				
				<div class="col-sm-6">
				<h5>NIK : <?php echo $nik;?><br>
				<h5>Nama : <?php echo $list_karyawan['nmlengkap'];?><br>
				<a href="<?php echo site_url("payroll/upah_borong/karyawan/")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
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
							<th>Tanggal Kerja</th>										
							<th>NIK</th>										
							<th>Nama Karyawan</th>										
							<th>Nama Department</th>	
							<th>Total Upah</th>	
							<th>Status</th>											
							<!--<th>Action</th>-->						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_upah_borong as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><a href="#" data-toggle="modal" data-target="#dtl<?php echo trim($lu->nodok);?>"><?php echo $lu->nodok;?></a></td>
							<td><?php echo $lu->tgl_kerja1;?></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							<td><?php echo $lu->total_upah;?></td>
							<td><?php echo $lu->status1;?></td>
							<!--<td>
								<!--<a href="<?php $nik=trim($lu->nik); echo site_url("trans/upah_borong/detail/$nik/$lu->nodok")?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>-->
								<?php if (trim($lu->status)<>'C' and trim($lu->status)<>'A') {?>
								<!--<a href="<?php $nik=trim($lu->nik); echo site_url("trans/upah_borong/final_mst/$lu->nodok/$nik")?>" onclick="return confirm('Anda Yakin Approval Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Final
								</a>
								<!--<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/upah_borong/hps_upah_borong/$lu->nodok")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
								<?php } ?>
							<!--</td>-->
						</tr>
						<?php endforeach;?>
					</tbody>
					<tfoot>
						<tr>
						<td class="right" colspan="6">Total Upah:</td><td class="right"><?php echo $total_upah['total_upah'];?></td>
						
						</tr>
					</tfoot>	
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

<!-- data tabel 2 --->
<!--<div class="row">
				<div class="col-sm-12">		
					<a data-toggle="modal" data-target="#modal1" href='#'  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
					<!--<a href="<?php echo site_url("trans/upah_borong/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>-->
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
							<td><?php echo $lu->upah_borong;?></td>
							<td><?php echo $lu->catatan;?></td>
							<td>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->no_urut);?>" href='#' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a  href="<?php $nik=trim($lu->nik);$nodok=trim($lu->nodok);echo site_url("trans/upah_borong/hps_upah_borong_dtl/$lu->no_urut/$nik")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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




<!-- modal input data -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Detail Upah Borong Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('trans/upah_borong/add_upah_borong_dtl')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo $lb->nik; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="I" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>	
							
							<div class="form-group">
								<label class="col-sm-4">Nomor Dokumen</label>	
								<div class="col-sm-8">    
									
									<input type="text" id="nik" name="nodok"  value="<?php echo $lb->nodok; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="total_upah"  value="<?php echo $total_upah['total_upah'];?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Kategori</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdborong" id="kdborong">
									  <?php foreach($list_borong as $listkan){?>
									  <option value="<?php echo trim($listkan->kdborong);?>" ><?php echo $listkan->nmborong;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Sub Kategori</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdsub_borong" id="kdsub_borong">
									  <?php foreach($list_sub_borong as $listkan){?>
									  <option value="<?php echo trim($listkan->kdsub_borong);?>" class="<?php echo trim($listkan->kdborong);?>" ><?php echo $listkan->nmsub_borong;?></option>						  
									  <?php }?>
									</select>
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
								$("#kdsub_borong").chained("#kdborong");		
								$("#metrix").chained("#kdsub_borong");	
								$("#satuan").chained("#kdsub_borong");	
								$("#tarif_satuan").chained("#kdsub_borong");	
								$("#total_target").chained("#kdsub_borong");	
								$("#kodekomponen").chained("#kode_bpjs");					
							  });
							</script>	
							
							<div class="form-group">
								<label class="col-sm-4">Metriks</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="metrix" id="metrix">
									  <?php foreach($list_sub_borong as $listkan){?>
									  <option value="<?php echo trim($listkan->metrix);?>" class="<?php echo trim($listkan->kdsub_borong);?>" ><?php echo $listkan->metrix;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Satuan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="satuan" id="satuan">
									  <?php foreach($list_sub_borong as $listkan){?>
									  <option value="<?php echo trim($listkan->satuan);?>" class="<?php echo trim($listkan->kdsub_borong);?>" ><?php echo $listkan->satuan;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tarif Satuan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="tarif_satuan" id="tarif_satuan">
									  <?php foreach($list_sub_borong as $listkan){?>
									  <option value="<?php echo trim($listkan->tarif_satuan);?>" class="<?php echo trim($listkan->kdsub_borong);?>" ><?php echo $listkan->tarif_satuan;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total Target</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="total_target" id="total_target">
									  <?php foreach($list_target_borong as $listkan){?>
									  <option value="<?php echo trim($listkan->total_target);?>" class="<?php echo trim($listkan->kdsub_borong);?>" ><?php echo $listkan->total_target;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pencapaian</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="pencapaian" placeholder="0"   class="form-control" required>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Upah Borong</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="upah_borong" placeholder="0"   class="form-control" required>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Catatan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="catatan"   style="text-transform:uppercase" class="form-control"></textarea>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
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




<!-- detail -->
<?php foreach ($list_upah_borong as $lb){?>
<div class="modal fade" id="dtl<?php echo trim($lb->nodok); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail Upah Borong Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('trans/upah_borong/edit_upah_borong_dtl_2')?>" method="post">
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
								<label class="col-sm-4">Periode</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="periode"  value="<?php echo trim($lb->periode); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<!--<div class="form-group">
								<label class="col-sm-4">Tipe Ijin Khusus</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdupah_borong"  value="<?php echo trim($lb->nmijin_khusus); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Kerja</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl" value="<?php echo trim($lb->tgl_kerja1); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total Upah (Rupiah)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="durasi" placeholder="<?php echo $lb->total_upah;?>" value="<?php echo $lb->total_upah; ?>"  class="form-control" readonly >
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



