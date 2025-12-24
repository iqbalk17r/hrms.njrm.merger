<!--Edit Department -->
<legend><?php echo $title;?></legend>
<?php echo $message; ?>


<div class="row">

	  
		<div class="modal-body">
		<form role="form" action="<?php echo site_url('master/regu/edit_regu_opr');?>" method="post">
			<div class="row">
			
			<script>
				$('#pilihkaryawan2').selectize();
				$('#pilihregu2').selectize();
			</script>
				
			<div class="form-group">
				 <label class="col-sm-12">NIK </label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" name="nik"  value="<?php echo trim($lk['nik']);?>"  class="form-control" readonly>
					<!--<select class="form-control input-sm" name="nik" id="pilihkaryawan2<?php echo trim($lk['no_urut']);?>">
							
						 <?php foreach($list_nik as $listkan){?>
						  <option <?php if (trim($lk['nik'])==trim($listkan->nik)) { echo 'selected';}?> 
						  value="<?php echo trim($listkan->nik).'|'.trim($listkan->nmlengkap);?>">
						  <?php echo trim($listkan->nik).'|'.$listkan->nmlengkap;?>
						  </option>						  
						  <?php }?>
					</select>-->
				</div>
			</div>
			
			<div class="form-group">
				 <label class="col-sm-12">Nama Lengkap</label>
				<div class="col-sm-12">
					<input type="text" id="nmdept" name="nmlengkap"  value="<?php echo $lk['nmlengkap'];?>"  class="form-control" readonly>
				</div>
			</div>
			
			<div class="form-group">
				 <label class="col-sm-12">Kode Regu</label>
				<div class="col-sm-12">
					<!--<input type="text" id="nmdept" name="kdregu"  value="<?php echo $lk['kdregu'];?>"  class="form-control" readonly>-->
					<select class="form-control input-sm" name="kdregu" id="pilihregu2">
						  <?php foreach($list_regu as $listkan){?>
						  <option <?php if (trim($lk['kdregu'])==trim($listkan->kdregu)) { echo 'selected';}?> value="<?php echo trim($listkan->kdregu);?>" ><?php echo $listkan->kdregu.'|'.$listkan->nmregu;?></option>						  
						  <?php }?>
					</select>
					<input type="hidden" id="nmdept" name="no_urut"  value="<?php echo $lk['no_urut'];?>"  class="form-control" readonly>
				</div>
			</div>
			
			<div class="form-group">
				 <label class="col-sm-12">Tanggal Update</label>
				<div class="col-sm-12">
					
						<input type="text" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
					
					<!-- /.input group -->
				</div>
			</div>
			<div class="form-group">
				 <label class="col-sm-12">Update By</label>
				<div class="col-sm-12">
				
						<input type="text" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >

					<!-- /.input group -->
				</div>
			</div>
			</div>
			<div class="modal-footer">
				<div class="form-group"> 
					<div class="col-lg-12">
						<a href="<?php echo site_url('master/regu/regu_opr');?>" class='btn btn-warning' > Kembali</a>
						<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
						
					   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
					</div>
				</div>
			</div>
		</div>
		</form>
  </div>


						
