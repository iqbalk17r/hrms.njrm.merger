<?php 
/*
	@author : Fiky 07/01/2016
*/
?>
<script type="text/javascript">
            $(function() {
                $("#table1").dataTable();
                $("#table2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();
				//$("#tglberangkat").datepicker(); 
				//$("#tglkembali").datepicker(); 				
            });
			
</script>

<legend><?php echo $title;?></legend>



				<div class="col-sm-12">		
					<a href="<?php echo site_url("master/user/add_menugrid/$nik/$username")?>"  class="btn btn-success pull-right" style="margin:10px; color:#ffffff;">Lanjutkan</a>
					
				</div>
<div class="row">	
	<div class="col-xs-6">			
<form role="form" action="<?php echo site_url("master/user/tambah_menu");?>" method="post">
				<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				<h4 align="center"><?php echo $title1;?></h4>
				<!--a href="<?php echo site_url("trans/dinas/cleartmp")?>"  class="btn btn-primary pull-right" style="margin:10px; color:#ffffff;">>> >></a-->
				<button class="btn btn-primary pull-right" onClick="TEST" style="margin:10px; color:#ffffff;" type="submit">>> >></button>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Action</th>	
							<th>MENU</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_menu_child as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td width="8%">
									 <input type="checkbox" name="centang[]" value="<?php echo trim($lu->kodemenu);?>" ><br>
							</td>
							<td><?php echo $lu->menunya;?></td>
														
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				<input type="hidden" name="nik" value="<?php echo trim($nik);?>" >
				<input type="hidden" name="username" value="<?php echo trim($username);?>" >
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</form>	
	</div>	
	<div class="col-xs-6">
<form role="form" action="<?php echo site_url("master/user/kurangi_menu");?>" method="post">
						<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				<h4 align="center"><?php echo $title2;?></h4>
				<!--a href="<?php echo site_url("trans/dinas/cleartmp")?>"  class="btn btn-primary pull-left" style="margin:10px; color:#ffffff;"><< <<</a-->
				<button class="btn btn-primary pull-left" onClick="TEST" style="margin:10px; color:#ffffff;" type="submit" <?php if($cek_user==0) { ?> disabled <?php }?>><< <<</button>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Action</th>	
							<th>MENU</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_menu_user as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td width="8%">
									 <input type="checkbox" name="centang[]" value="<?php echo trim($lu->kodemenu);?>" ><br>
							</td>
							<td><?php echo $lu->menunya;?></td>
														
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				<input type="hidden" name="nik" value="<?php echo trim($nik);?>" >
				<input type="hidden" name="username" value="<?php echo trim($username);?>" >
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
					</div>
</form>



</div>





