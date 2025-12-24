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


<form action="<?php echo site_url('trans/cuti_karyawan/otoritascutibersama')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NO DOKUMEN</label>	
								<div class="col-sm-8">    
								<input type="text" id="nodok1" name="nodok" value="<?php echo trim($dtl['nodok']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">STATUS</label>	
								<div class="col-sm-8">    
								<input type="text" id="tpecuti1" name="tpecuti"  value="<?php echo trim($dtl['status']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
							</div>
							<script type="text/javascript">
								$(function() {                         
									$("#tglmulai").datepicker();                               
									$("#tglselesai").datepicker(); 
																	
								});
							</script>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input value="<?php echo trim($dtl['tgl_awal1']); ?>" type="text" id="tglmulai" name="tgl_awal" data-date-format="dd-mm-yyyy"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input value="<?php echo trim($dtl['tgl_akhir1']); ?>" type="text" id="tglselesai" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jumlah Cuti (Hari)</label>	
								<div class="col-sm-8">    
									<input value="<?php echo trim($dtl['jumlahcuti']); ?>" type="number" id="gaji" name="jumlah_cuti" placeholder="0"   class="form-control" required >
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo trim($dtl['keterangan']);?></textarea>
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

	<div> 
        <a href="<?php echo site_url('trans/cuti_karyawan/cutibersama');?>" type="button" class="btn btn-default"/> Kembali</a>
        <button type="submit" onclick="return confirm('Anda Yakin Untuk Di Save Final---?')" class="btn btn-primary">SIMPAN</button>
    </div>
</form>
