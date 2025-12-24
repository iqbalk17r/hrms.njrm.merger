<?php 
/*
	@author : Fiky 07/01/2016
*/
?>
<script type="text/javascript">
            $(function() {
                $("#table1").dataTable({   lengthMenu: [ [70, -1], [70, "All"] ], pageLength: 70 });
                $("#table2").dataTable({  pageLength: 70 });
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
<?php echo $message; ?>
<legend><?php echo $title;?></legend>



				<div class="col-sm-12">		
					<a href="<?php echo site_url("pk/pk/clear_tmp_mapping/$enc_nik/$enc_periode")?>" onClick="return confirm('Kembali Akan Mereset Semua Inputan Mapping Yang Anda Buat, Anda Yakin??')"   class="btn btn-default" style="margin:10px; color:#000000;">Kembali</a>
					<a href="<?php echo site_url("pk/pk/add_mapping_for_generate_inspek/$enc_nik/$enc_periode")?>"   onClick="return confirm('Apakah Data Yang Anda Inputkan Sudah Valid??')" class="btn btn-success pull-right" style="margin:10px; color:#ffffff;">Lanjutkan</a>
					
				</div>
<div class="row">	
	<div class="col-xs-6">			
<form role="form" action="<?php echo site_url("pk/pk/tambah_mapping_inspek");?>" method="post">
				<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				<h4 align="center"><?php echo $title1;?></h4>
				<!--a href="<?php echo site_url("trans/dinas/cleartmp")?>"  class="btn btn-primary pull-right" style="margin:10px; color:#ffffff;">>> >></a-->
				<button class="btn btn-primary pull-right" onClick="Apakah Yakin Akan Melanjutkan" style="margin:10px; color:#ffffff;" type="submit">>> >></button>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Act</th>	
							<th>NO DOC</th>
							<th>AREA</th>
							<th>DESCRIPTION</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_q_dokumen as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td width="2%">
									 <input type="checkbox" name="centang[]" value="<?php echo bin2hex($this->encrypt->encode(trim($lu->kdpa)));?>" ><br>
							</td>
							<td><?php echo trim($lu->kdpa);?></td>
							<td><?php echo trim($lu->kdarea);?></td>
							<td><?php echo trim($lu->description);?></td>
														
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				<input type="hidden" name="nik" value="<?php echo  trim($nik);?>" >
				<input type="hidden" name="periode" value="<?php echo trim($periode);?>" >
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</form>	
	</div>	
	<div class="col-xs-6">
<form role="form" action="<?php echo site_url("pk/pk/kurangi_mapping_inspek");?>" method="post">
						<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				<h4 align="center"><?php echo $title2;?></h4>
				<button class="btn btn-primary pull-left" onClick="Apa Anda Yakin Akan Menghapus Item" style="margin:10px; color:#ffffff;" type="submit" <?php if($cek_trmap==0) { ?> disabled <?php }?>><< <<</button>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Act</th>	
							<th>NO DOC</th>
							<th>AREA</th>
							<th>DESCRIPTION</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_tmp_mapping as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td width="2%">
									 <input type="checkbox" name="centang[]" value="<?php echo bin2hex($this->encrypt->encode(trim($lu->kdpa)));?>" checked><br>
							</td>
							<td><?php echo trim($lu->kdpa);?></td>
							<td><?php echo trim($lu->kdarea);?></td>
							<td><?php echo trim($lu->description);?></td>
														
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				<input type="hidden" name="nik" value="<?php echo  trim($nik);?>" >
				<input type="hidden" name="periode" value="<?php echo trim($periode);?>" >
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
					</div>
</form>



</div>





