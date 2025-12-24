<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />

<legend><?php echo $title;?></legend>
<div class="form-horizontal">
<form action="<?php echo site_url('hrd/hrd/absensi');?>" name="form" role="form" method="post">
    
	<div class="form-group">
		<label class="col-lg-3">Wilayah</label>	
			<div class="col-lg-5">    
				<select class='form-control' name="branch">
					<option value="sby">Surabaya</option>
					<option value="smg">Semarang</option>
					<option value="jkt">Jakarta</option>
				</select>
			</div>
	</div>
	<!--area-->
	
	<div class="form-group">
		 <label class="col-lg-3">Tanggal Awal</label>
		<div class="col-lg-5">
			<div class="input-group">
                <div class="input-group-addon">
					<i class="fa fa-calendar"></i>
                </div>
                <input type="text" id="awal" name="awal" class="datepicker form-control pull-right" data-date-format="yyyymmdd"/>
            </div><!-- /.input group -->
		</div>
	</div>
	
	<div class="form-group">
		 <label class="col-lg-3">Tanggal Akhir</label>
		<div class="col-lg-5">
			<div class="input-group">
                <div class="input-group-addon">
					<i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="datepicker form-control pull-right" id="akhir" name="akhir" data-date-format="yyyymmdd"/>
            </div><!-- /.input group -->
		</div>
	</div>
	
	<!--coba-->	
	<!--<div class="form-group">
		<label class="col-lg-3">Bulan</label>	
			<div class="col-md-5">
				<select class='form-control' name="bulan">
					<option value="jan">Januari</option>				  
					<option value="feb">Februari</option>				  
					<option value="mar">Maret</option>				  
					<option value="apr">April</option>				  
					<option value="mei">Mei</option>				  
					<option value="jun">Juni</option>				  
					<option value="jul">Juli</option>				  
					<option value="ags">Agustus</option>				  
					<option value="sep">September</option>				  
					<option value="okt">Oktober</option>				  
					<option value="nov">November</option>				  
					<option value="des">Desember</option>				  
                </select>
			</div>
	</div>-->
       
    <div class="form-group">
           
        <div class="col-lg-4">
			<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i>Proses</button>
           <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
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