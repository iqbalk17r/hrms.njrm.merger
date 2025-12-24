<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />

<legend><?php echo $title;?></legend>
<div class="form-horizontal">
<form action="<?php echo site_url('hrd/cuti/submit');?>" name="form" role="form" method="post">
    
	<div class="form-group">
		<label class="col-lg-2">Nama Karyawan</label>	
			<div class="col-lg-3">  
			  <select class='form-control' name="nama" id="nama">		
				<?php
					//Menampilkan data jabatan yang ada
					if(empty($qpegawai))
					{
					echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
					}else
					{
					foreach($qpegawai as $column)
					{
					?>
					<option value="<?php echo $column->fc_nip; ?>"><?php echo $column->fv_nmlengkap; ?> | <?php echo $column->fc_nip; ?></option>
					<?php }} ?>
				  </select>
			</div>
	</div>

	<div class="form-group">
		 <label class="col-lg-2">Departemen</label>
		<div class="col-lg-3">
			<div class="input-group">
                <input type="text" id="dept" name="dept" class="form-control"/>
            </div><!-- /.input group -->
		</div>
	</div>
	
	<div class="form-group">
		 <label class="col-lg-2">Jabatan</label>
		<div class="col-lg-3">
			<div class="input-group">
                <input type="text" id="jabt" name="jabt" class="form-control"/>
            </div><!-- /.input group -->
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-lg-2">Atasan Karyawan</label>	
			<div class="col-lg-3">  
			  <select class='form-control' name="atasan" id="atasan">		
				<?php
					//Menampilkan data jabatan yang ada
					if(empty($qpegawai))
					{
					echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
					}else
					{
					foreach($qpegawai as $column)
					{
					?>
					<option value="<?php echo $column->fc_nip; ?>"><?php echo $column->fv_nmlengkap; ?> | <?php echo $column->fc_nip; ?></option>
					<?php }} ?>
				  </select>
			</div>
	</div>
	
	<div class="form-group">
		 <label class="col-lg-2">Tanggal</label>
		<div class="col-lg-3">
			<div class="input-group">
                <div class="input-group-addon">
					<i class="fa fa-calendar"></i>
                </div>
                <input type="text" id="awal" name="awal" class="datepicker form-control pull-right" data-date-format="yyyymmdd"/>
            </div><!-- /.input group -->
		</div>
		  <label class="col-sm-1">s/d</label>
		<div class="col-lg-3">
			<div class="input-group">
                <div class="input-group-addon">
					<i class="fa fa-calendar"></i>
                </div>
                <input type="text" id="akhir" name="akhir" class="datepicker form-control pull-right" data-date-format="yyyymmdd"/>
            </div><!-- /.input group -->
		</div>
	</div>
	
	<div class="form-group">
		 <label class="col-lg-2">Jumlah Cuti</label>
		<div class="col-lg-3">
			<div class="input-group">
                <input type="text" id="jml" name="jml" class="form-control" required/>
            </div><!-- /.input group -->
		</div>
		 <label class="col-lg-2">Sisa Cuti</label>
		<div class="col-lg-3">
			<div class="input-group">
                <input type="text" id="sisa" name="sisa" class="form-control"/>
            </div><!-- /.input group -->
		</div>
	</div>
	
	<div class="form-group">
		 <label class="col-lg-2">Pekerjaan dilimpahkan</label>
		<div class="col-lg-3">  
			  <select class='form-control' name="atasan" id="atasan">		
				<?php
					//Menampilkan data jabatan yang ada
					if(empty($qpegawai))
					{
					echo "<tr><td colspan=\"6\">Data tidak tersedia</td></tr>";
					}else
					{
					foreach($qpegawai as $column)
					{
					?>
					<option value="<?php echo $column->fc_nip; ?>"><?php echo $column->fv_nmlengkap; ?> | <?php echo $column->fc_nip; ?></option>
					<?php }} ?>
				  </select>
			</div>
	</div>
	
	<div class="form-group">
		 <label class="col-lg-2">Keterangan</label>
		<div class="col-lg-5">
			<div class="input-group">
                <textarea id="ket" name="ket" class="form-control"/></textarea>
            </div><!-- /.input group -->
		</div>
	</div>
	
	<div class="form-group">
		 <label class="col-lg-2">No Telp</label>
		<div class="col-lg-3">
			<div class="input-group">
                <input type="text" id="telp" name="telp" class="form-control"/>
            </div><!-- /.input group -->
		</div>
	</div>
	
    <div class="form-group">
        <div class="col-lg-4">
			<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i>Proses</button>
			<button type='reset' class='btn btn-default' >Reset</button>
        </div>
    </div>
</div>
</form>

<div id="tampil"></div>

<script>
$.getScript("https://raw.github.com/eternicode/bootstrap-datepicker/master/js/bootstrap-datepicker.js", function(){
  
    $('.datepicker').datepicker({
    })
    
    $('#awal').datepicker()
    .on("changeDate", function(e){
        
      alert(e.format('dd-MM-yyyy'));
      
    });
    
    $('#akhir').datepicker()
    .on("changeDate", function(e){
        
      alert(e.format('dd-MM-yyyy'));
      
    });

  
});
</script>