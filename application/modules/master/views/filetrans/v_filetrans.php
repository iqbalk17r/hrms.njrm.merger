<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
            });
			
			window.onload = function () {
				document.getElementById("password1").onchange = validatePassword;
				document.getElementById("password2").onchange = validatePassword;
			}
			function validatePassword(){
			var pass2=document.getElementById("password2").value;
			var pass1=document.getElementById("password1").value;
			if(pass1!=pass2)
				document.getElementById("password2").setCustomValidity("Passwords Tidak Sama");
			else
				document.getElementById("password2").setCustomValidity(''); 			
			//empty string means no validation error
			}
</script>
<legend><?php echo $title;?></legend>
<?php echo $message; ?>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
		</div><!-- /.box-header -->	
			<div class="box-body">
			<form id="dataForm" name="dataForm" method="post" enctype="multipart/form-data" action="">
				<!--input type="file" name="path" id="path" style="width:300px"/---->
				<!---input type="submit" value="Import" name="actionButton" id="actionButton" --->
				<input type="submit" value="Export" name="actionButton" id="actionButton"   class="btn btn-primary" style="margin:10px; color:#ffffff;">
			</form>
		   </div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>
<!-- Modal Input agama -->


<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>NAMA DB</th>								
							<th>BACKUP TYPE</th>								
							<th>DAY</th>								
							<th>LAST DATE</th>								
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_backup as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nmlisting;?></td>
							<td><?php echo $lu->backup_type;?></td>
							<td><?php echo $lu->dayofbackup;?></td>
							<td><?php echo $lu->lastdate;?></td>
							<td>

			<form id="dataForm" name="dataForm" method="post" enctype="multipart/form-data" action="<?php echo site_url('master/filetrans/backup_db')?>">
				<!--input type="file" name="path" id="path" style="width:300px"/---->
				<input type="hidden" name="dbname" id="dbname" value="<?php echo trim($lu->nmlisting);?>">
				<input type="hidden" name="dbhost" id="dbhost" value="<?php echo trim($lu->host);?>">
				<input type="hidden" name="udb" id="udb" value="<?php echo trim($lu->udb);?>">
				<input type="hidden" name="pdb" id="pdb" value="<?php echo trim($lu->pdb);?>">
				<input type="hidden" name="backup_type" id="backup_type" value="<?php echo trim($lu->backup_type);?>">
				<input type="hidden" name="dayofbackup" id="dayofbackup" value="<?php echo trim($lu->dayofbackup);?>">
				<input type="hidden" name="dir_backup" id="dir_backup" value="<?php echo trim($lu->dir_backup);?>">
				<input type="submit" value="Import" name="actionButton" id="actionButton"   class="btn btn-success btn-sm" style="margin:0px; color:#ffffff;">
				<input type="submit" value="Export" name="actionButton" id="actionButton"   class="btn btn-primary btn-sm" style="margin:0px; color:#ffffff;">
			</form>

							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>





<script>

  $("[data-mask]").inputmask();

	
	//Date range picker
    $('#tgl').datepicker();

  

</script>