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
				
					$('#jumlah_cuti1').on('blur', function(){
						var jumlah_cuti1 = parseInt($(this).val());
						var sisacuti=parseInt($('#sisacuti').val());
						var tpecuti=$('#tpecuti').val();
						var statusptg=$('#statptg1').val();
						
						
						if((sisacuti<jumlah_cuti1) && (tpecuti=="A") && (statusptg=="A1")){
							$('#postmessages').empty().append("<div class='alert alert-success'>PERINGATAN !! SISA CUTI= "+sisacuti+" SILAHKAN MASUKKAN SESUAI SISA CUTI /SILAHKAN PILIH OPSI LAIN POTONG GAJI / CUTI KHUSUS</div>");
							//alert('PERINGATAN !! SISA CUTI= '+sisacuti' TIDAK MENCUKUPI SILAHKAN PILIH OPSI LAIN POTONG GAJI / CUTI KHUSUS');
							$('#submit').prop('disabled', true);
						} else {
							$('#postmessages').empty();
							$('#submit').prop('disabled', false);
						}
					
				});
            });
		
</script>

<legend><?php echo $title;?></legend>
<span id="postmessages"></span>

<?php foreach ($list_lk as $lb) { ?>
<form action="<?php echo site_url('trans/cuti_karyawan/add_cuti_karyawan')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="I" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="nodok"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($lb->lvl_jabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="department1"  value="<?php echo trim($lb->nmdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="department"  value="<?php echo trim($lb->bag_dept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="subdepartment1"  value="<?php echo trim($lb->nmsubdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="subdepartment"  value="<?php echo trim($lb->subbag_dept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="jabatan1"  value="<?php echo trim($lb->nmjabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="jabatan"  value="<?php echo trim($lb->jabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan1</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan1"  value="<?php echo trim($lb->nmatasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan"  value="<?php echo trim($lb->nik_atasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan2"  value="<?php echo trim($lb->nmatasan2); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan2"  value="<?php echo trim($lb->nik_atasan2); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
	
							<div class="form-group">
								<label class="col-sm-4">Alamat</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="alamat"   style="text-transform:uppercase" class="form-control"></textarea>
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
								$("#colorselector<?php echo trim($lb->nik); ?>").change(function(){
								$(".colors<?php echo trim($lb->nik); ?>").hide();
								$('#' + $(this).val()).show();
								});
							});
							</script>
							
							<div class="form-group">
								<label class="col-sm-4">Sisa Cuti</label>	
								<div class="col-sm-8">    
									<input type="text" id="sisacuti"  value="<?php echo trim($lb->sisacuti); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							<div class="form-group">
								<label class="col-sm-4">Tipe Cuti</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="tpcuti" id="tpecuti">
									 <option value="A">CUTI</option> 
									 <option value="B">IJIN KHUSUS</option> 
									 <option value="C">DINAS</option> 
									</select>
								</div>
							</div>
							<script type="text/javascript" charset="utf-8">
							$(function() {
		
											$('#tpecuti').change(function(){
												//$('#subcuti').show();
												var tpecuti=$('#tpecuti').val();
						
													if(tpecuti=='A'){
														$('#subcuti').show();
														$('#statptg1').prop('required',true);
													} else if((tpecuti=='B')||(tpecuti=='C')){
														$('#subcuti').hide();
														$('#statptg1').removeAttr('required');
														
													}
									
												//$('.subcuti' + $(this).val()).hide().find('#statptg1').removeAttr('required');
												 
												//$('#subcuti' + $(this).val()).show().find('#statptg1').attr('required');
												
												
												$('.ijin' + $(this).val()).hide();
												$('#ijin' + $(this).val()).show();
											
											});
										});	
							</script>
							<div class="form-group">
								<div id="subcuti" class="subcutiB subcutiC" >
								<label class="col-sm-4">Subtitusi Cuti</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="statptg" id="statptg1" required="required">
									 <option value="">--Pilih Potong Cuti/Gaji--</option> 
									 <option value="A1">POTONG CUTI</option> 
									 <option value="A2">POTONG GAJI</option> 
									</select>
								</div>
								</div>
							</div>
							<div class="form-group">
							<div id="ijinB" class="ijinA ijinC" style="display:none;">
								<label class="col-sm-4">Tipe Ijin Khusus</label>	
								<div class="col-sm-8">  
									<select class="form-control input-sm" name="kdijin_khusus" id="kdijin_absensi" >
									<option value="">Input Type Ijin Khusus</option>
									  <?php foreach($list_ijin_khusus as $listkan){?>
									  <option value="<?php echo trim($listkan->kdijin_khusus);?>" ><?php echo $listkan->nmijin_khusus;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							</div>
							<script type="text/javascript">
								$(function() {                         
									$("#dateinput<?php echo trim($lb->nik);?>").datepicker();                               
									$("#dateinput1<?php echo trim($lb->nik);?>").datepicker(); 
									$("#pelimpahan<?php echo trim($lb->nik); ?>").selectize();										
								});
							</script>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput<?php echo trim($lb->nik);?>" name="tgl_awal" data-date-format="dd-mm-yyyy"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput1<?php echo trim($lb->nik);?>" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jumlah Cuti (Hari)</label>	
								<div class="col-sm-8">    
									<input type="number" id="jumlah_cuti1" name="jumlah_cuti" placeholder="0"   class="form-control" required >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pelimpahan Pekerjaan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="pelimpahan" id="pelimpahan<?php echo trim($lb->nik); ?>" required>
									  <option value="">--PILIH KARYAWAN--</option>
									  <?php foreach($list_pelimpahan as $listkan){ ?>
									  <option value="<?php echo trim($listkan->nik);?>" ><?php echo $listkan->nmlengkap;?></option>						  
									  <?php }?>
									</select>
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
      <div class="modal-footer">
        <a href="<?php echo site_url('trans/cuti_karyawan/karyawan');?>" type="button" class="btn btn-default"/> Kembali</a>
        <button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
<?php } ?>	  