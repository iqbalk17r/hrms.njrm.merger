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

<!--Modal untuk Aproval+detail-->

<div class="row" id="dtl" >
  <div>
    <div>
	   <a href="<?php echo site_url("trans/cuti_karyawan/")?>"  class="btn btn-default"> Kembali </a>
	  <form action="<?php echo site_url('trans/cuti_karyawan/approval')?>" method="post">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">No. Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="status" name="nodok"  value="<?php echo trim($dtl['nodok']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($dtl['nik']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<!--input type="hidden" id="status" name="status"  value="A" class="form-control" style="text-transform:uppercase" maxlength="40" readonly-->
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($dtl['nmlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($dtl['nmlengkap']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($dtl['kdlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>			
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="department"  value="<?php echo trim($dtl['nmdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="subdepartment"  value="<?php echo trim($dtl['nmsubdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							<!--<div class="form-group">
								<label class="col-sm-4">Level Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlvl"  value="<?php echo trim($dtl['nmlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="jabatan"  value="<?php echo trim($dtl['nmjabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan"  value="<?php echo trim($dtl['nmatasan1']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan2"  value="<?php echo trim($dtl['nmatasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Alamat</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($dtl['alamat']);?></textarea>
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
								<label class="col-sm-4">Tipe Cuti</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdcuti_karyawan"  value="<?php echo trim($dtl['tpcuti1']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Subtitusi Cuti</label>	
								<div class="col-sm-8"> 
									<input type="text" id="stsptg" name="statptg"  value="<?php echo trim($dtl['status_ptg1']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Tipe Ijin Khusus</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdcuti_karyawan"  value="<?php echo trim($dtl['nmijin_khusus']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl" value="<?php echo trim($dtl['tgl_mulai1']); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl" value="<?php echo trim($dtl['tgl_selesai1']); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jumlah Cuti(Hari)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="durasi" placeholder="0" value="<?php echo trim($dtl['jumlah_cuti']); ?>"  class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pelimpahan</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="kdtrx"  value="<?php echo trim($dtl['nmpelimpahan']);?>"class="form-control" readonly>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Tanggal Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="tgl_dok"  value="<?php echo trim($dtl['tgl_dok1']);?>"class="form-control" readonly>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($dtl['keterangan']);?></textarea>
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
	<div >
	<?php if (trim($dtl['status'])=='A' and trim($akses['aksesapprove']=='t')/*OR trim($dtl[status)=='P'*/) { $var_status='P'; ?>
				
				
		<button type="submit"  class="btn btn-success">APPROVAL</button>
		<input type="hidden" id="status" name="status"  value="P" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>	
	  </form>
	</div> 
	<?php } ?>
	</div>
	<!---CEKER KETIKA TANGGAL SUDAH LEWAT SETELAH APROVAL TOMBOL BATAL HILANG-->
	<?php if ((trim($dtl['status'])=='P' OR trim($dtl['status'])=='F')/* AND trim($dtl['tgl_dok'])<=trim($cekclosing['value1'])
	AND trim($dtl[tgl_selesai)>=date('Y-m-d')*/)	{ ?>
	   <div>
	  </form>
	</div> 
	<div> 
		<form action="<?php echo site_url('trans/cuti_karyawan/cancel');?>" method="post">
			<input type="hidden" value="<?php echo trim($dtl['nodok']);?>" name="nodok">
			<input type="hidden" value="<?php echo trim($dtl['nik']);?>" name="nik">
			<input type="hidden" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
			<input type="hidden" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
			<button type="submit" class="btn btn-danger" OnClick="return confirm('Cuti Ini Sudah Di APROVAL!! Anda Yakin Membatalkan <?php echo $dtl['nodok']; echo $dtl['nik']?>?')">Batal Cuti</button>
			
		</form>
	</div> 
	<?php } ?>
 </div>


