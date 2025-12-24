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


<form action="<?php echo site_url('trans/cuti_karyawan/savecutibersama')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
						
							<div class="form-group">
								<label class="col-sm-4">INPUT CUTI BERSAMA</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="tpcuti" id="tpecuti">
									 <option value="I">CUTI BERSAMA</option>

									</select>
								</div>
							</div>
							<script type="text/javascript" charset="utf-8">
							$(function() {
		
											$('#tpecuti').change(function(){
												//$('#subcuti').show();
												$('.subcuti' + $(this).val()).hide();
												$('.subcuti' + $(this).val()).hide();
												$('#subcuti' + $(this).val()).show();
											
											});
										});	
							</script>
						
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
									<input type="text" id="tglmulai" name="tgl_awal" data-date-format="dd-mm-yyyy"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="tglselesai" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jumlah Cuti (Hari)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="jumlah_cuti" placeholder="0"   class="form-control" required >
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
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
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
    </div>
</form>
