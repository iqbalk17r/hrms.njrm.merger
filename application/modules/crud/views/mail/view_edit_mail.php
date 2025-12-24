<?php 
/*
	@author : hanif_anak_metal \m/
*/
error_reporting(0);
?>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<?php echo validation_errors();?>
<form action="<?php echo site_url('hrd/mail/edit_mail');?>" name="form" role="form" method="post">
<div class="row clearfix">	
	<div class="col-lg-6">
		<div class="form-group">
			<label for="inputkdmail" class="col-sm-3 control-label">Kode Mail</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="kdmail" name="kdmail" style="text-transform:uppercase" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputsubject" class="col-sm-3 control-label">Subject</label>
			<div class="col-sm-6">
			  <input type="text" class="form-control input-sm" id="subject" name="subject" required>
			</div>
			<div class="col-sm-10"></div>
		</div>
		<div class="form-group">
			<label for="inputisi" class="col-sm-3 control-label">Isi</label>
			<div class="col-md-12">
			  <textarea class="form-control input-sm" id="isi" name="isi" style="text-transform:uppercase" required></textarea>
			</div>
			<div class="col-sm-10"></div>
		</div>
	</div><!-- ./col -->						
</div><!-- /.row -->
	
<div class="row clearfix">
	<div class="col-lg-6" style="margin: 10px">
		<div class="form-group">		
		  <button type="submit" class="btn btn-primary">Simpan</button>
		  <button type="button" class="btn btn-default" onclick="history.back();">Kembali</button>
		</div>
	</div>
</div>

</form>

<script type="text/javascript">
            $(function() {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('isi');
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
            });
        </script>