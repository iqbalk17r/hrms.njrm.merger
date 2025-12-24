<?php 
/*
	Author : Bukan Jomblo 
*/

?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#kantin").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bInfo": true,
                    "bSort": true,
                    "bAutoWidth": false
                });
            });
</script>
<legend><?php echo $title;?></legend>

</br>

<!-- Modal Input Finger Wilayah -->

  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h4 class="modal-title" id="myModalLabel">Input IP address Wilayah</h4>
	  </div>

	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('master/finger/add_finger');?>" method="post">
		  <div class="form-group">
			<label for="kdcabang">Wilayah</label>
			<input type="input" value="<?php echo $dtl['fingerid'];?>" class="form-control" id="kdcabang" name="kdcabang" style="text-transform: uppercase;" readonly>
			<input type="hidden" value="<?php echo 'EDIT';?>" class="form-control" id="tipe" name="tipe" style="text-transform: uppercase;">
		  </div>
		  <div class="form-group">
			<label for="ipaddress">Input IP Address</label>
			<input type="input"  value="<?php echo $dtl['ipaddress'];?>"  class="form-control" id="ipaddress" name="ipaddress" style="text-transform: uppercase;">
		  </div>
		  <div class="form-group">
			<label for="db">Nama Database</label>
			<input type="input"  value="<?php echo $dtl['dbname'];?>"  class="form-control" id="dbname" name="dbname" style="text-transform: uppercase;">
		  </div>
		  <button type="submit" class="btn btn-primary">Simpan</button>
			
		<a href="<?php echo site_url("master/finger/index")?>"  class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
	
		</form>
	  </div>
	</div>
  </div>
