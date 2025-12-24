<legend><?php echo $title;?></legend>
<div class="form-horizontal">
<form action="<?php echo site_url('hrd/report/filter');?>" name="form" role="form" method="post">
    
	<div class="form-group">
		<label class="col-lg-3">Branch</label>	
			<div class="col-lg-5">    
				<select class='form-control' name="branch">
					<option value="SBYNSA">SBYNSA</option>
				</select>
			</div>
	</div>
	<!--coba-->
	
	<!--coba-->
	<div class="form-group">
		<label class="col-lg-3">Tahun</label>	
			<div class="col-lg-5">    
				<select class='form-control' name="tahun">
				  <option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
				  <option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
				  <option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>
				  <option value='<?php $tgl=date('Y')-3; echo $tgl; ?>'><?php $tgl=date('Y')-3; echo $tgl; ?></option>
				  <option value='<?php $tgl=date('Y')-4; echo $tgl; ?>'><?php $tgl=date('Y')-4; echo $tgl; ?></option>
				  <option value='<?php $tgl=date('Y')-5; echo $tgl; ?>'><?php $tgl=date('Y')-5; echo $tgl; ?></option>
				  
                </select>
			</div>
			
	</div>

	
	<div class="form-group">
		<label class="col-lg-3">Bulan</label>	
			<div class="col-lg-5">    
				<select class='form-control' name="bulan">
				  <option value="1">Januari</option>				  
					<option value="2">Februari</option>				  
					<option value="3">Maret</option>				  
					<option value="4">April</option>				  
					<option value="5">Mei</option>				  
					<option value="6">Juni</option>				  
					<option value="7">Juli</option>				  
					<option value="8">Agustus</option>				  
					<option value="9">September</option>				  
					<option value="10">Oktober</option>				  
					<option value="11">November</option>				  
					<option value="12">Desember</option>
				 
                </select>
			</div>
			
			
	</div>
	
	<div class="form-group">
		<label class="col-lg-3">Kantor</label>	
			<div class="col-lg-5">    
				<select class='form-control' name="kantor">
					<option value="NA">NASIONAL</option>
					<?php
							 //Menampilkan data kantor yang ada
							 if(empty($kantor))
							 {
							 echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
							 }else
							 {
							 foreach($kantor as $kan)
							 {
							?>
						  <option value="<?php echo $kan->kodecabang; ?>"><?php echo $kan->desc_cabang; ?></option>
					<?php }} ?>				  
                </select>
			</div>
	</div>
	<div class="form-group">
		<label class="col-lg-3">Laporan</label>	
			<div class="col-lg-5">    
				<select class='form-control' name="laporan">
					<?php
							 //Menampilkan data laporan yang ada
							 if(empty($qlaporan))
							 {
							 echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
							 }else
							 {
							 foreach($qlaporan as $qlap)
							 {
							?>
						  <option value="<?php echo $qlap->kdreporthrd; ?>"><?php echo $qlap->desc_reporthrd; ?></option>
					<?php }} ?>
						  
				  
                </select>
			</div>
	</div>
       
    <div class="form-group">
        
        
        <div class="col-lg-4">
			<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i>Proses</button>           
        </div>
    </div>
</div>
</form>

<div id="tampil"></div>