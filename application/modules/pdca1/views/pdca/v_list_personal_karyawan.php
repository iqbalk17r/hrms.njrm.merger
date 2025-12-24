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
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();

				$('.tglYM').datepicker({
				    format: "yyyy-mm",
					viewMode: "months", 
					minViewMode: "months",
					autoclose: true
				});				
            });
		
</script>

<legend><?php echo $title.'  TIPE   '; if($inputfill=='ISD'){ ECHO 'ISIDENTAL'; } else if ($inputfill=='BRK'){ ECHO 'BERKALA'; } ?></legend>

<div class="row">
				<div class="col-sm-12">		
					<a href="<?php echo site_url("pdca/pdca/form_pdca")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				</div>
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>AKSI</th>	
							<th>NIK</th>
							<th>Nama Karyawan</th>					
							<th>Department</th>					
							<th>TIPE PDCA</th>					
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_nikpbk as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td>
							<?php if ($inputfill=='ISD') { ?>
								<a href="<?php 
								$enc_nik=bin2hex($this->encrypt->encode(trim($lu->nik)));
								$enc_inputfill=bin2hex($this->encrypt->encode(trim($inputfill)));
								echo site_url('pdca/pdca/input_pdca').'/'.trim($enc_nik).'/'.trim($enc_inputfill);?>"  class="btn btn-info  btn-sm">
									<i class="fa fa-edit"></i> Buat PDCA
								</a>	
							<?php } else if ($inputfill=='BRK') { ?>	
								<a href="#" data-toggle="modal" data-target="#INPUTMSTPDCA<?php echo str_replace('.','',trim($lu->nik));?>" class="btn btn-primary  btn-sm"><i class="fa fa-edit"></i> Buat PDCA</a>
							<?php } ?>	
							</td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							<td><?php if($inputfill=='ISD'){ ECHO 'ISIDENTAL'; } else if ($inputfill=='BRK'){ ECHO 'BERKALA'; };?></td>
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


<!-- INPUT MASTER PDCA TANGGAL DAN KETERANGAN PER HARI-->	
<?php foreach ($list_nikpbk as $lb) { ?>
<div class="modal fade" id="INPUTMSTPDCA<?php echo str_replace('.','',trim($lb->nik));?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">PILIH PERIODE INPUT PDCA DAILY</h4>
	  </div>
<form action="<?php echo site_url('pdca/pdca/input_pdca_berkala')?>" method="post" name="inputform">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									<input type="hidden" id="doctype" name="doctype"  value="BRK" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
									<input type="hidden" id="type" name="type"  value="INPUT_MST_PDCA_BRK" class="form-control" style="text-transform:uppercase">								
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>	
							<div class="form-group ">
									<label class="col-sm-4" for="inputsm">PILIH PERIODE PDCA </label>	
									<div class="col-sm-8"> 
										<input type="input" name="tglYM" id="tglYM" class="form-control input-sm  tglYM"  >
									</div>
							</div>			
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	

		</div>	
	</div>	
      <div class="modal-footer">
        <!--a href="<?php echo site_url('ga/permintaan/list_personalnikpbk');?>" type="button" class="btn btn-default"/> Kembali</a-->
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
</div></div></div>
<?php } ?>



