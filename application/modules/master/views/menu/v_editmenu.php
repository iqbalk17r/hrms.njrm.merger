<?php 
/*
	@author : hanif_anak_metal \m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example4").dataTable();
				//datemask
				//$("#datemaskinput").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});                               
				//$("#datemaskinput").daterangepicker();                              
				$("#dateinput").datepicker();                               
            });			
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>

</br>
<form action="<?php echo site_url('master/menu/save')?>" method="post">
<div class="row">
	<div class="col-sm-6">
		<div class="box box-danger">
			<div class="box-body">
				<div class="form-horizontal">							
					<div class="form-group">
						<label class="col-sm-4">KODE MENU</label>	
						<div class="col-sm-8">
							<input type="hidden" class="form-control input-sm" value="edit" id="tipe" name="tipe" required>									
							<input type="text" class="form-control input-sm" value="<?php echo $dtl_menu['kodemenu'];?>" id="tipe" maxlength='10' name="kdmenu" readonly>									
						</div>
					</div>							
					<div class="form-group">
						<label class="col-sm-4">NAMA MENU</label>	
						<div class="col-sm-8">    
							<input type="text" class="form-control input-sm" value="<?php echo trim($dtl_menu['namamenu']);?>" id="tipe" maxlength='25' name="namamenu" required>
						</div>
					</div>	
					<?php if ($dtl_menu['child']=='S' or $dtl_menu['child']=='P'){?>
					<div class="form-group">
						<label class="col-sm-4">PARENT MENU</label>	
						<div class="col-sm-8">    
							<select name="parentmenu" id='pmnu' class="col-sm-12">								
								<?php foreach ($list_menu_opt_utama as $lom){ ?>
								<option value="<?php echo trim($lom->kodemenu);?>" <?php if (trim($dtl_menu['parentmenu'])==trim($lom->kodemenu)) { echo 'selected';}?>><?php echo trim($lom->namamenu);?></option>																																																			
								<?php };?>
							</select>
						</div>
					</div>					
					<?php }?>
					<script type="text/javascript" charset="utf-8">
							  $(function() {	
								$("#pmsu").chained("#pmnu");		
								$("#cjabt").chained("#csubdept");		
							  });
							</script>
					<?php if ($dtl_menu['child']=='P'){?>
					<div class="form-group">
						<label class="col-sm-4">PARENT SUBMENU</label>	
						<div class="col-sm-8">    
							<select name="parentsubmenu" id='pmsu' class="col-sm-12">								
								<?php foreach ($list_menu_opt_sub as $loms){ ?>
								<option value="<?php echo trim($loms->kodemenu);?>" class="<?php echo trim($loms->parentmenu);?>" <?php if (trim($dtl_menu['parentsub'])==trim($loms->kodemenu)) { echo 'selected';}?>><?php echo trim($loms->namamenu);?></option>																																																			
								<?php };?>
							</select>
						</div>
					</div>					
					<?php }?>
					<div class="form-group">
						<label class="col-sm-4">POSISI</label>
						<div class="col-sm-8">
							<input type="text" class="form-control input-sm" value="<?php echo $dtl_menu['urut'];?>" id="urut" name="urut" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">HOLD</label>	
						<div class="col-sm-8">    
							<select name="holdmenu" class="col-sm-12">
								<option value="F" <?php if (trim($dtl_menu['holdmenu'])=='f') { echo 'selected';}?>>TIDAK</option>
								<option value="T" <?php if (trim($dtl_menu['holdmenu'])=='t') { echo 'selected';}?>>IYA</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">LINK MENU</label>	
						<div class="col-sm-8">    
							<input type="text" class="form-control input-sm" value="<?php echo $dtl_menu['linkmenu'];?>" id="tipe" name="linkmenu" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4">ICON MENU</label>	
						<div class="col-sm-8">    
							<input type="text" class="form-control input-sm" value="<?php echo $dtl_menu['iconmenu'];?>" id="tipe" name="iconmenu" required>
						</div>
					</div>																																			
				</div>
			</div><!-- /.box-body -->													
		</div><!-- /.box --> 
	</div>					
</div>
<div class="row">
	<div class="col-sm-6">		
		<a href="<?php echo site_url('master/menu');?>" class="btn btn-primary" style="margin:10px">Kembali</a>
		<button type='submit' onclick="return confirm('Anda Yakin Ubah Data ini?')" class="btn btn-primary" style="margin:10px">Ubah Data</button>
	</div>
	<div class="col-sm-6">		
		
	</div>
</div>
</form>

