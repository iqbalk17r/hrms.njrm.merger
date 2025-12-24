<?php 
/*
	@author : Fiky 07/01/2016
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
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
    <a href="<?php echo site_url("trans/dinas/cleartmp")?>"  class="btn btn-danger" style="margin:10px; color:#ffffff;"><i class="fa fa-signal"></i> Clear</a>

</div>
<div class="row">	
	<div class="col-xs-6">			
 <form role="form" action="<?php echo site_url("trans/dinas/final_dinas_dtl");?>" method="post">
				<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Action</th>	
							<th>NIK</th>
							<th>Nama Karyawan</th>					
							<th>Department</th>					
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_dtl as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td width="8%">
									 <input type="checkbox" name="centang[]" value="<?php echo $lu->nik;?>" checked><br>
							</td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
	</div>	
	<div class="col-xs-6">
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>VIEW DINAS KARYAWAN</h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
								
				<div class="box box-primary">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-4">Kategori Keperluan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdkategori" id="kdkategori" disabled>
									  <option value="">--PILIH KATEGORI KEPERLUAN--</option>
									  <?php foreach($list_kategori as $listkan){ ?>
									  <option <?php if (trim($dtl_dn['kdkategori'])==trim($listkan->kdkategori)) { echo 'selected';}?> value="<?php echo trim($listkan->kdkategori);?>" ><?php echo $listkan->kdkategori.' || '.$listkan->nmkategori;?></option>						  
									  <!--option <?php if (trim($lb->kdlembur)==trim($listkan->tplembur)) { echo 'selected';}?> value="<?php echo trim($listkan->tplembur);?>" ><?php echo $listkan->tplembur;?></option--->						  
									  <?php }?>
									</select>
								</div>
							</div>
						
							<div class="form-group">
								<label class="col-sm-4">Keperluan Dinas</label>	
								<div class="col-sm-8">    
									<textarea type="text" style="text-transform:uppercase" class="form-control" readonly ><?php echo $dtl_dn['keperluan'];?></textarea>
									<input type="hidden" id="kepdinas" name="kepdinas" value="<?php echo $dtl_dn['keperluan'];?>"  class="form-control" readonly>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Tujuan Dinas</label>	
								<div class="col-sm-8">    
									<textarea type="text" style="text-transform:uppercase" class="form-control" readonly ><?php echo $dtl_dn['tujuan'];?></textarea>
									<input type="hidden" id="tujdinas" name="tujdinas" value="<?php echo $dtl_dn['tujuan'];?>"  class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Berangkat</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="tglberangkat" name="tglberangkat" value="<?php echo $dtl_dn['tgl_mulai'];?>"  data-date-format="dd-mm-yyyy"  class="form-control" readonly>
									<input type="text" value="<?php echo date('d-m-Y',strtotime($dtl_dn['tgl_mulai']));?>"  data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Kembali</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="tglkembali" name="tglkembali" value="<?php echo $dtl_dn['tgl_selesai'];?>"  data-date-format="dd-mm-yyyy"  class="form-control" readonly>
                                    <input type="text" value="<?php echo date('d-m-Y',strtotime($dtl_dn['tgl_selesai']));?>"  data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>								
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
								<button class="btn btn-success"  onclick="return confirm('Simpan Final Akan Menyimpan Semua Data, Yakin?')" type="submit"><i class="fa fa-save"></i> Simpan Final</button>
									</div>
							</div>
						</div>
					</div>
</form>



</div>





