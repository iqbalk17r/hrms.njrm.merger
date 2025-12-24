<?php 
/*
	@author : junis 10-12-2012\m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
            });
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Komponen Bpjs</a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode Bpjs</th>
							<th>Kode Komponen Bpjs</th>																	
							<th>Nama Komponen Bpjs</th>																	
							<th>Besaran Perusahan</th>																	
							<th>Besaran Karyawan</th>																	
							<th>Total Besaran</th>																	
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_bpjs as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->kode_bpjs;?></td>
							<td><?php echo $lu->kodekomponen;?></td>
							<td><?php echo $lu->namakomponen;?></td>
							<td align="right"><?php echo $lu->besaranperusahaan.' %';?></td>
							<td align="right"><?php echo $lu->besarankaryawan.' %';?></td>
							<td align="right"><?php echo $lu->totalbesaran.' %';?></td>
							<td>
								<a href='<?php echo site_url("master/bpjskomponen/edit/$lu->kodekomponen")?>' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a href='<?php echo site_url("master/bpjskomponen/hps/$lu->kodekomponen")?>' onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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


<!--Modal untuk Input Nama Bpjs-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Bpjs</h4>
      </div>
	  <form action="<?php echo site_url('master/bpjskomponen/save')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Kode Bpjs</label>	
								<div class="col-sm-8">									
									<select type="text" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdbpjs" required>
										<?php foreach ($list_opt_bpjs as $lob){?>
										<option value='<?php echo trim($lob->kode_bpjs);?>'><?php echo trim($lob->nama_bpjs);?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Komponen Bpjs</label>	
								<div class="col-sm-8">
									<input type="hidden" class="form-control input-sm" value="input" id="tipe" name="tipe" required>									
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe" maxlength='10' name="kdkompbpjs" required>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Nama Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" style="text-transform:uppercase;" class="form-control input-sm" value="" id="tipe"  name="namakompbpjs" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Besaran Perusahan</label>	
								<div class="col-sm-8"> 
									<div class="input-group">
										<input type="number" step="0.01" min="0" class="form-control input-sm" value="" id="type1" onkeyup="kalkulatorTambah(this.value,getElementById('type2').value);"  name="perusahaan" required>
										<span class="input-group-addon">%</span>																														
										<script>
										function kalkulatorTambah(type1,type2){
										var hasil = eval(type1) + eval(type2);										
										document.getElementById('ttlbesaran').value = hasil;										
										}
										</script>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Besaran Karyawan</label>	
								<div class="col-sm-8">    
									<div class="input-group">
										<input type="number" step="0.01" min="0" class="form-control input-sm" value="" id="type2" onkeyup="kalkulatorTambah(getElementById('type1').value,this.value);"  name="karyawan" required>
									<span class="input-group-addon">%</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total Besaran</label>	
								<div class="col-sm-8">    
									<div class="input-group">
										<input type="number" class="form-control input-sm" value="" id="ttlbesaran"  name="total" required readonly>
										<span class="input-group-addon">%</span>
									</div>
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
