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

<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
					<a href="<?php echo site_url("trans/kenaikan_grade/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				</div>
				<div class="col-sm-6">
				<h5>NIK : <?php echo $nik;?><br>
				<h5>Nama : <?php echo $list_lk['nmlengkap'];?>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
							<th>Nama Grade</th>
							<th>Nomer Dokumen</th>
							<th>Nomer SK</th>
							<th>Tanggal SK</th>
							<th>Nama Group Penggajian</th>											
							<th>Status</th>											
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_kenaikan_grade as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><?php echo $lu->nmgrade;?></td>
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->no_sk;?></td>
							<td><?php echo $lu->tgl_sk;?></td>
							<td><?php echo $lu->nmgroup_pg;?></td>
							<td><?php echo $lu->status1;?></td>
							<td>
								<a data-toggle="modal" data-target="#dtl<?php echo trim($lu->nodok);?>" href='#' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>
								<?php if (trim($lu->status)<>'C' and trim($lu->status)<>'A') {?>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->nodok);?>" href='#' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/kenaikan_grade/hps_kenaikan_grade/$nik/$lu->nodok")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>
								<?php } ?>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


<!--Modal untuk Input Nama Bpjs-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Kenaikan Grade  <?php echo $nik.'|'.$list_lk['nmlengkap'];?></h4>
      </div>
	  <form action="<?php echo site_url('trans/kenaikan_grade/add_kenaikan_grade')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo $nik; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="nodok"  value="<?php echo $nik; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="I" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	

							<div class="form-group">
								<label class="col-sm-4">Nama Grade</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdgrade" id="kdgrade">
									  <?php foreach($list_grade as $listkan){?>
									  <option value="<?php echo trim($listkan->kdgrade);?>" ><?php echo $listkan->nmgrade;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Group Penggajian</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdgroup_pg" id="kdgroup_pg">
									  <?php foreach($list_group_pg as $listkan){?>
									  <option value="<?php echo trim($listkan->kdgroup_pg);?>" ><?php echo $listkan->nmgroup_pg;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>		
							
							
							<div class="form-group">	
								<label class="col-sm-4">Nomer SK</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="no_sk"  class="form-control" style="text-transform:uppercase" maxlength="30" required>
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
								<label class="col-sm-4">Tanggal SK</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput" name="tgl_sk" data-date-format="dd-mm-yyyy"  class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Gaji Pokok (Rp.)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="gaji_pokok" placeholder="0"   class="form-control"  >
								</div>
							</div>								
							<div class="form-group">
								<label class="col-sm-4">Gaji BPJS (Rp.)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="gaji_bpjs" placeholder="0" class="form-control"  >
								</div>
							</div>	
							
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
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
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>



<!--Modal untuk Edit Bpjs Karyawan-->
<?php foreach ($list_kenaikan_grade as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->nodok); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Kenaikan Grade</h4>
      </div>
	  <form action="<?php echo site_url('trans/kenaikan_grade/edit_kenaikan_grade')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Nomer Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nodok" value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo $nik; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama grade</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdgrade" id="kdgrade">
									  <?php foreach($list_grade as $listkan){?>
									  <option <?php if (trim($lb->kdgrade)==trim($listkan->kdgrade)) { echo 'selected';}?> value="<?php echo trim($listkan->kdgrade);?>" ><?php echo $listkan->nmgrade;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Group Penggajian</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdgroup_pg" id="kdgrade">
									  <?php foreach($list_group_pg as $listkan){?>
									  <option <?php if (trim($lb->kdgroup_pg)==trim($listkan->kdgroup_pg)) { echo 'selected';}?> value="<?php echo trim($listkan->kdgroup_pg);?>" ><?php echo $listkan->nmgroup_pg;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							
							<div class="form-group">	
								<label class="col-sm-4">Nomer SK</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="no_sk"  value="<?php echo trim($lb->no_sk); ?>" class="form-control" style="text-transform:uppercase" maxlength="30" required>
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
								<label class="col-sm-4">Tanggal SK</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput2" name="tgl_sk"  value="<?php echo trim($lb->tgl_sk1); ?>" data-date-format="dd-mm-yyyy" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Gaji Pokok (Rp.)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="gaji_pokok" placeholder="0" value="<?php echo trim($lb->gaji_pokok); ?>"  class="form-control" >
								</div>
							</div>								
							<div class="form-group">
								<label class="col-sm-4">Gaji BPJS (Rp.)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="gaji_bpjs" placeholder="0" value="<?php echo trim($lb->gaji_bpjs); ?>"   class="form-control" >
								</div>
							</div>						
													
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo trim($lb->keterangan); ?></textarea>
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
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<?php } ?>


<!--Modal untuk Detail Bpjs Karyawan-->
<?php foreach ($list_kenaikan_grade as $lc){?>
<div class="modal fade" id="dtl<?php echo trim($lc->nodok); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail Kenaikan Grade</h4>
      </div>
	  <form  action="<?php echo site_url('trans/kenaikan_grade/approval')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Nomer Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nodok" value="<?php echo trim($lc->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo $nik; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama grade</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="kdgrade" value="<?php echo trim($lc->nmgrade); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Group Penggajian</label>	
								<div class="col-sm-8">   
									<input type="text" id="kddept" name="kdgroup_pg" value="<?php echo trim($lc->nmgroup_pg); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							<div class="form-group">	
								<label class="col-sm-4">Nomer SK</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="no_sk"  value="<?php echo trim($lc->no_sk); ?>" class="form-control" style="text-transform:uppercase" maxlength="30" readonly>
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
								<label class="col-sm-4">Tanggal SK</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput2" name="tgl_sk"  value="<?php echo trim($lc->tgl_sk1); ?>" data-date-format="dd-mm-yyyy" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Gaji Pokok (Rp.)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="gaji_pokok" placeholder="0" value="<?php echo trim($lc->gaji_pokok); ?>"  class="form-control" readonly>
								</div>
							</div>								
							<div class="form-group">
								<label class="col-sm-4">Gaji BPJS (Rp.)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="gaji_bpjs" placeholder="0" value="<?php echo trim($lc->gaji_bpjs); ?>"   class="form-control" readonly>
								</div>
							</div>						
													
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($lc->keterangan); ?></textarea>
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
	<?php if (trim($lc->status)=='I'){ ?>
	
	
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <button type="submit"  class="btn btn-primary">APPROVAL</button>  
	  </form>
	</div>  
		<div class="modal-footer">
		<form action="<?php echo site_url('trans/kenaikan_grade/cancel');?>" method="post">
			<input type="hidden" value="<?php echo trim($lc->nodok);?>" name="nodok">
			<input type="hidden" value="<?php echo trim($lc->nik);?>" name="nik">
			<button type="submit" class="btn btn-primary" OnClick="return confirm('Anda Yakin, Membatalkan <?php echo $lc->nodok;?>?')">Cancel</button>
		</form>
		</div>

	
	<?php } ?>
    </div>
  </div>
</div>
<?php } ?>
