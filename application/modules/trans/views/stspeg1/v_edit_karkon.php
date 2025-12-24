<!--Modal status kepegawaian-->
				
	  <div class="modal-header">
        <h3 class="modal-title" id="myModalLabel">Edit Status Kepegawaian</h3>
		<h4>NIK : <?php echo $nik;?><br>
		<h4>Nama : <?php echo $list_lk['nmlengkap'];?>
      </div>
	  <form action="<?php echo site_url('trans/stspeg/edit_stspeg')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">No.Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nodok"  value="<?php echo trim($list_karkon['nodok']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($list_karkon['nik']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	

							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmdept"  value="<?php echo $list_lk['nmdept']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmjabatan"  value="<?php echo $list_lk['nmjabatan']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmatasan"  value="<?php echo $list_lk['nmatasan']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
								<label class="col-sm-4">Nama Kepegawaian</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdkepegawaian" id="kdkepegawaian">
									<option value="">--Pilih Kepegawaian--></option>
									  <?php foreach($list_kepegawaian as $listkan){?>
									  <option <?php if(trim($listkan->kdkepegawaian)==trim($list_karkon['kdkepegawaian'])){ echo 'selected';} ?>
									  value="<?php echo trim($listkan->kdkepegawaian);?>" ><?php echo $listkan->nmkepegawaian;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<script type="text/javascript" charset="utf-8">
							$(function() {
		
										$('#kdkepegawaian1').change(function(){
												//$('.tglselesai').show();
												//$('#tglselesai' + $(this).val()).hide();											
												//$('#bolehcuti' + $(this).val()).hide();
												
												$('#tglmulai').show();												
												$('#tglselesai').show();												
												$('#bolehcuti').show();												
												$('.tglmulai' +$(this).val()).hide();																							
												$('.tglselesai' +$(this).val()).hide();																							
												$('.bolehcuti' +$(this).val()).hide();																							
											
											});
										});	
							</script>
							<div id="tglmulai" class="tglmulaiKO" >
								<div class="form-group">
									<label class="col-sm-4">Tanggal Mulai</label>	
									<div class="col-sm-8">    
										<input type="text" id="dateinput2" value="<?php echo $list_karkon['tgl_mulai1'];?>" name="tgl_mulai" data-date-format="dd-mm-yyyy"  class="form-control" required>
									</div>
								</div>
							</div>
							<div id="tglselesai" class="tglselesaiKT" >
								<div class="form-group">	
									<label class="col-sm-4">Tanggal Selesai</label>	
									<div class="col-sm-8">    
										<input type="text" id="dateinput3" value="<?php echo $list_karkon['tgl_selesai1'];?>" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control">
									</div>
								</div>	
							</div>
							<div id="bolehcuti" class="bolehcutiKO bolehcutiMG" >
							<!--<div class="form-group">
								<div id="bolehcuti" class="bolehcuti" >
									<label class="col-sm-4">Boleh Cuti</label>	
									<div class="col-sm-8">    
										<select class="form-control input-sm" name="cuti" id="kdbahasa">
											<option <?php if(trim($list_karkon['cuti'])=='T'){ echo 'selected';} ?>  value="T" >YA</option>	
											<option  <?php if(trim($list_karkon['cuti'])=='F'){ echo 'selected';} ?>  value="F" >TIDAK</option>
										</select>	
									</div>
								</div>
							</div>	-->
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo trim($list_karkon['keterangan']); ?></textarea>
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
        <a type="button" class="btn btn-default" href="<?php echo site_url('trans/stspeg/list_karkon');?>">Close</a>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
  
  
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

