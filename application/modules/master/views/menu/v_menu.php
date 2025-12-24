<?php 
/*
	@author : hanif_anak_metal \m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();
				//datemask
				//$("#datemaskinput").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});                               
				//$("#datemaskinput").daterangepicker();                              
				$("#dateinput").datepicker();                               
            });
			//form validation
			
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
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">					
				<li class="active"><a href="#tab_1" data-toggle="tab">MENU UTAMA</a></li>
				<li><a href="#tab_2" data-toggle="tab">SUB-MENU-UTAMA</a></li>
				<li><a href="#tab_3" data-toggle="tab">SUB-MENU-SUB</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<div class="box">
						<div class="box-header">
							<div class="col-sm-12">		
								<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Menu Utama</a>
							</div>
						</div><!-- /.box-header -->
						<div class="box-body table-responsive" style='overflow-x:scroll;'>
							<table id="example1" class="table table-bordered table-striped" >
								<thead>
									<tr>
										<th>No.</th>
										<th>KODE</th>
										<th>Posisi</th>
										<th>Nama Modul</th>
										<th>Hold</th>
										<th>Link Menu</th>						
										<th>Action</th>						
									</tr>
								</thead>
								<tbody>
									<?php $no=0; foreach($list_menu_utama as $lu): $no++;?>
									<tr>										
										<td width="2%"><?php echo $no;?></td>																							
										<td><?php echo $lu->kodemenu;?></td>																								
										<td><?php echo $lu->urut;?></td>
										<td><?php echo $lu->namamenu;?></td>
										<td><?php echo $lu->holdmenu;?></td>											
										<td><?php echo $lu->linkmenu;?></td>											
										<td>
											<a href='<?php echo site_url("master/menu/edit/$lu->kodemenu")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
												<i class="fa fa-edit"></i> Edit
											</a>
											<a href='<?php echo site_url("master/menu/hps/$lu->kodemenu")?>' onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
												<i class="fa fa-trash-o"></i> Hapus
											</a>
										</td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
				<div class="tab-pane" id="tab_2">
					<div class="box">
						<div class="box-header">
							<div class="col-sm-12">		
								<a href="#" data-toggle="modal" data-target="#input-submenu" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Sub Menu</a>
							</div>
						</div><!-- /.box-header -->
						<div class="box-body table-responsive" style='overflow-x:scroll;'>
							<table id="example2" class="table table-bordered table-striped" >
								<thead>
									<tr>
										<th>No.</th>
										<th>KODE</th>
										<th>Posisi</th>
										<th>Nama Modul</th>
										<th>Parent Menu</th>										
										<th>Hold</th>
										<th>Link Menu</th>						
										<th>Action</th>						
									</tr>
								</thead>
								<tbody>
									<?php $no=0; foreach($list_menu_sub as $lus): $no++;?>
									<tr>										
										<td width="2%"><?php echo $no;?></td>																							
										<td><?php echo $lus->kodemenu;?></td>																								
										<td><?php echo $lus->urut;?></td>
										<td><?php echo $lus->namamenu;?></td>
										<td><?php echo $lus->parentmenu;?></td>																																											
										<td><?php echo $lus->holdmenu;?></td>											
										<td><?php echo $lus->linkmenu;?></td>											
										<td>
											<a href='<?php echo site_url("master/menu/edit/$lus->kodemenu")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
												<i class="fa fa-edit"></i> Edit
											</a>
											<a href='<?php echo site_url("master/menu/hps/$lus->kodemenu")?>' onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
												<i class="fa fa-trash-o"></i> Hapus
											</a>
										</td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
				<div class="tab-pane" id="tab_3">
					<div class="box">
						<div class="box-header">
							<div class="col-sm-12">		
								<a href="#" data-toggle="modal" data-target="#input-submenu-sub" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Sub Menu-Sub</a>
							</div>
						</div><!-- /.box-header -->
						<div class="box-body table-responsive" style='overflow-x:scroll;'>
							<table id="example3" class="table table-bordered table-striped" >
								<thead>
									<tr>
										<th>No.</th>
										<th>KODE</th>
										<th>Posisi</th>
										<th>Nama Modul</th>
										<th>Parent Menu</th>
										<th>Parent Submenu</th>
										<th>Hold</th>
										<th>Link Menu</th>						
										<th>Action</th>						
									</tr>
								</thead>
								<tbody>
									<?php $no=0; foreach($list_menu_submenu as $lusm): $no++;?>
									<tr>										
										<td width="2%"><?php echo $no;?></td>																							
										<td><?php echo $lusm->kodemenu;?></td>																								
										<td><?php echo $lusm->urut;?></td>
										<td><?php echo $lusm->namamenu;?></td>
										<td><?php echo $lusm->parentmenu;?></td>																								
										<td><?php echo $lusm->parentsub;?></td>											
										<td><?php echo $lusm->holdmenu;?></td>											
										<td><?php echo $lusm->linkmenu;?></td>											
										<td>
											<a href='<?php echo site_url("master/menu/edit/$lusm->kodemenu")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
												<i class="fa fa-edit"></i> Edit
											</a>
											<a href='<?php echo site_url("master/menu/hps/$lusm->kodemenu")?>' onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
												<i class="fa fa-trash-o"></i> Hapus
											</a>
										</td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
			</div>
	</div>
</div>


<!--Modal untuk Input Menu Utama-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Menu</h4>
      </div>
	  <form action="<?php echo site_url('master/menu/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">KODE MENU</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>									
									<input type="text" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdmenu" required>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">NAMA MENU</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm" value="" id="tipe" maxlength='25' name="namamenu" required>
									<input type="hidden" class="form-control input-sm" value="U" id="tipe" maxlength='25' name="childmenu" required>
									<input type="hidden" class="form-control input-sm" value="" id="tipe" maxlength='25' name="parentmenu" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">POSISI</label>
								<div class="col-sm-8">
									<input type="number" class="form-control input-sm" id="urut" maxlength='4' name="urut" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">HOLD</label>	
								<div class="col-sm-8">    
									<select name="holdmenu" class="col-sm-12">
										<option value="F">TIDAK</option>;																																													
										<option value="T">IYA</option>;																																																							
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">LINK MENU</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm" value="" id="tipe" name="linkmenu" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">ICON MENU</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm" value="" id="tipe" name="iconmenu" required>
								</div>
							</div>																																			
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>					
		</div><!--row-->
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<!--Modal untuk Input Sub Menu-->
<div class="modal fade" id="input-submenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Sub Menu</h4>
      </div>
	  <form action="<?php echo site_url('master/menu/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">KODE MENU</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>									
									<input type="hidden" class="form-control input-sm" value="S" id="tipe" maxlength='25' name="childmenu" required>									
									<input type="text" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdmenu" required>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">NAMA MENU</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm" value="" id="tipe" maxlength='25' name="namamenu" required>
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">PARENT MENU</label>	
								<div class="col-sm-8">    
									<select name="parentmenu" class="col-sm-12">
										<option value="">-KOSONG-</option>
										<?php foreach ($list_menu_opt_utama as $lomu){ ?>
										<option value="<?php echo trim($lomu->kodemenu);?>"><?php echo trim($lomu->namamenu);?></option>																																																			
										<?php };?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">POSISI</label>
								<div class="col-sm-8">
									<input type="number" class="form-control input-sm" id="urut" maxlength='4' name="urut" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">HOLD</label>	
								<div class="col-sm-8">    
									<select name="holdmenu" class="col-sm-12">
										<option value="F">TIDAK</option>;																																													
										<option value="T">IYA</option>;																																																							
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">LINK MENU</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm" value="" id="tipe" name="linkmenu" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">ICON MENU</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm" value="" id="tipe" name="iconmenu" required>
								</div>
							</div>																																			
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>					
		</div><!--row-->
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<!--Modal untuk Input SUB-MENU-SUB-->
<div class="modal fade" id="input-submenu-sub" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Sub Menu-Sub</h4>
      </div>
	  <form action="<?php echo site_url('master/menu/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">KODE MENU</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>									
									<input type="hidden" class="form-control input-sm" value="P" id="tipe" name="childmenu" required>									
									<input type="text" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdmenu" required>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">NAMA MENU</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm" value="" id="tipe" maxlength='25' name="namamenu" required>
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">PARENT MENU</label>	
								<div class="col-sm-8">    
									<select name="parentmenu" id='pmnu' class="col-sm-12">
										<option value="">-KOSONG-</option>
										<?php foreach ($list_menu_opt_utama as $lom){ ?>
										<option value="<?php echo trim($lom->kodemenu);?>"><?php echo trim($lom->namamenu);?></option>																																																			
										<?php };?>
									</select>
								</div>
							</div>
							<script type="text/javascript" charset="utf-8">
							  $(function() {	
								$("#pmsu").chained("#pmnu");		
								$("#cjabt").chained("#csubdept");		
							  });
							</script>
							<div class="form-group">
								<label class="col-sm-4">PARENT SUB MENU</label>	
								<div class="col-sm-8">    
									<select name="parentsubmenu" id='pmsu' class="col-sm-12">
										<option value="">-KOSONG-</option>
										<?php foreach ($list_menu_opt_sub as $lom){ ?>
										<option value="<?php echo trim($lom->kodemenu);?>" class="<?php echo trim($lom->parentmenu);?>"><?php echo trim($lom->namamenu);?></option>																																																			
										<?php };?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">POSISI</label>
								<div class="col-sm-8">
									<input type="number" class="form-control input-sm" id="urut" maxlength='4' name="urut" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">HOLD</label>	
								<div class="col-sm-8">    
									<select name="holdmenu" class="col-sm-12">
										<option value="F">TIDAK</option>;																																													
										<option value="T">IYA</option>;																																																							
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">LINK MENU</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm" value="" id="tipe" name="linkmenu" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">ICON MENU</label>	
								<div class="col-sm-8">    
									<input type="text" class="form-control input-sm" value="" id="tipe" name="iconmenu" required>
								</div>
							</div>																																			
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>					
		</div><!--row-->
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>