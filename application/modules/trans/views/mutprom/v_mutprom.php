<?php 
/*
	@author : Junis
*/
?>
<script type="text/javascript">
	$(function() {
                $("#table").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#tglsk").datepicker();                               
				$("#tglmemo").datepicker();                               
				$("#tglefektif").datepicker();                               
            });
			
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Mutasi Promosi</a>					
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No.</th>
							<th>Kode</th>
							<th>NIK</th>
							<th>Departement Lama</th>																								
							<th>Subdepartement Lama</th>																								
							<th>Jabatan Lama</th>																								
							<th>Level Lama</th>																								
							<th>Atasan Lama</th>
							<th>Departement Baru</th>																								
							<th>Subdepartement Baru</th>																								
							<th>Jabatan Baru</th>																								
							<th>Level Baru</th>																								
							<th>Atasan Baru</th>
							<th>No Dok SK</th>
							<th>Tgl SK</th>
							<th>Tgl Memo</th>
							<th>Tgl Efektif</th>
							<th>Keterangan</th>							
							<th>Action</th>						
						</tr>
					</thead>					
					<tbody>
						<?php if (empty($list_mutasi)){
							echo '<td colspan="19">Data tidak ada</td>';
						} ?>
						<?php $no=1; foreach ($list_mutasi as $lm) {?>
						<tr>
							<td><?php echo $no; $no++;?></td>
							<td><?php echo $lm->nodokumen;?></td>
							<td><?php echo $lm->nik;?>|<?php echo $nama;?></td>
							<td><?php echo $lm->olddept;?></td>
							<td><?php echo $lm->oldsubdept;?></td>							
							<td><?php echo $lm->oldjabatan;?></td>							
							<td><?php echo $lm->oldlevel;?></td>							
							<td><?php echo $lm->oldatasan;?></td>							
							<td><?php echo $lm->newdept;?></td>
							<td><?php echo $lm->newsubdept;?></td>							
							<td><?php echo $lm->newjabatan;?></td>							
							<td><?php echo $lm->newlevel;?></td>							
							<td><?php echo $lm->newatasan;?></td>							
							<td><?php echo $lm->nodoksk;?></td>							
							<td><?php echo $lm->tglsk;?></td>							
							<td><?php echo $lm->tglmemo;?></td>							
							<td><?php echo $lm->tglefektif;?></td>							
							<td><?php echo $lm->ket;?></td>							
							<td><?php if ($lm->tipe=='A'){?><a class="btn btn-sm btn-success" href="<?php echo site_url('trans/mutprom/approve/').'/'.trim($lm->nodokumen).'/'.trim($lm->nik);?>" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Approve</a>
								<a class="btn btn-sm btn-danger" href="<?php echo site_url('trans/mutprom/delete').'/'.trim($lm->nodokumen).'/'.trim($lm->nik);?>" title="Hapus" onclick="return_confirm('<?php echo trim($lm->nodokumen);?>')"><i class="glyphicon glyphicon-trash"></i> Delete</a><?php }?></td>							
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


 <!-- Bootstrap modal -->
  <div class="modal fade" id="input" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Input Mutasi dan Promosi Baru</h3>
      </div>
      <div class="modal-body form">
        <form action="<?php echo site_url('trans/mutprom/save');?>" method="post" class="form-horizontal">
          <!--<input type="hidden" value="" name="id"/> -->
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">NIK</label>
              <div class="col-md-9">
                <input name="type" value="input" class="form-control" type="hidden">
                <input name="nik" placeholder="NIK" value="<?php echo $nik;?>" style="text-transform:uppercase;" class="form-control" type="text" readonly>
              </div>
            </div>
			<div class="form-group">
				<label class="control-label col-sm-3">Department</label>	
				<div class="col-sm-8">    
					<select name="newkddept" id='dept' class="form-control col-sm-12" >										
						<?php foreach ($list_opt_dept as $lodept){ ?>
						<option value="<?php echo trim($lodept->kddept);?>" ><?php echo trim($lodept->nmdept);?></option>																																																			
						<?php };?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3">Sub Department</label>	
				<div class="col-sm-8">    
					<select name="newkdsubdept" id='subdept' class="form-control col-sm-12" >
						<option value="">-KOSONG-</option>
						<?php foreach ($list_opt_subdept as $losdept){ ?>
						<option value="<?php echo trim($losdept->kdsubdept);?>" class="<?php echo trim($losdept->kddept);?>"><?php echo trim($losdept->nmsubdept);?></option>																																																			
						<?php };?>
					</select>
				</div>
			</div>
			<script type="text/javascript" charset="utf-8">
			  $(function() {	
				$("#subdept").chained("#dept");										
				$("#jabatan").chained("#subdept");																		
				$("#jobgrade").chained("#lvljabatan");																		
			  });
			</script>
			<div class="form-group">
				<label class="control-label col-sm-3">Jabatan</label>	
				<div class="col-sm-8">    
					<select name="newkdjabatan" id='jabatan' class="form-control col-sm-12" >	
						<option value="">-KOSONG-</option>
						<?php foreach ($list_opt_jabt as $lojab){ ?>
						<option value="<?php echo trim($lojab->kdjabatan);?>" class="<?php echo trim($lojab->kdsubdept);?>"><?php echo trim($lojab->nmjabatan);?></option>																																																			
						<?php };?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3">Level Jabatan</label>	
				<div class="col-sm-8">    
					<select name="newkdlevel" id='lvljabatan' class="form-control col-sm-12" >										
						<?php foreach ($list_opt_lvljabt as $loljab){ ?>
						<option value="<?php echo trim($loljab->kdlvl);?>" ><?php echo trim($loljab->nmlvljabatan);?></option>																																																			
						<?php };?>
					</select>
				</div>
			</div>			
			<div class="form-group">
				<label class="control-label col-sm-3">Atasan</label>	
				<div class="col-sm-8">    
					<select name="newnikatasan" class="form-control col-sm-12" required>										
						<?php foreach ($list_opt_atasan as $loan){ ?>
						<option value="<?php echo trim($loan->nik);?>" ><?php echo trim($loan->nmlengkap);?></option>																																																			
						<?php };?>
					</select>
				</div>
			</div>
			<div class="form-group">
              <label class="control-label col-md-3">No SK</label>
              <div class="col-md-9">
                <input name="nosk" placeholder="Nomor Surat Keputusan" style="text-transform:uppercase;" class="form-control" type="text">
              </div>
            </div>
			<div class="form-group">
			  <label class="control-label col-sm-3">Tanggal SK</label>
			  <div class="col-sm-9">
				<input name="tglsk" style="text-transform:uppercase;" placeholder="Tanggal Surat Keputusan" id="tglsk" data-date-format="dd-mm-yyyy" class="form-control" type="text" required>
			  </div>
			</div>
			<div class="form-group">
			  <label class="control-label col-sm-3">Tanggal Memo</label>
			  <div class="col-sm-9">
				<input name="tglmemo" style="text-transform:uppercase;" placeholder="Tanggal Memo Mutasi/Promosi" id="tglmemo" data-date-format="dd-mm-yyyy" class="form-control" type="text" required>
			  </div>
			</div>
			<div class="form-group">
			  <label class="control-label col-sm-3">Tanggal Efektif</label>
			  <div class="col-sm-9">
				<input name="tglefektif" style="text-transform:uppercase;" placeholder="Tanggal Masuk Karyawan" id="tglefektif" data-date-format="dd-mm-yyyy" class="form-control" type="text" required>
			  </div>
			</div>
			<div class="form-group">
			  <label class="control-label col-sm-3">Keterangan</label>
			  <div class="col-sm-9">
				<textarea name="ket" style="text-transform:uppercase;" placeholder="Keterangan Mutasi / Promosi pegawai" id="tglmasuk" data-date-format="dd-mm-yyyy" class="form-control" type="text"></textarea>
			  </div>
			</div>
          </div>
        
          </div>
          <div class="modal-footer">
            <button  type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
		  </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal --> 
  
  <!-- Bootstrap modal -->
  <div class="modal fade" id="edit_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Form Kode kepegawaiantype</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="editform" class="form-horizontal">
          <!--<input type="hidden" value="" name="id"/> -->
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Kode Mutasi / Promosi</label>
              <div class="col-md-9">
                <input name="nodokumen" placeholder="Kode kepegawaiantype" class="form-control" type="text" readonly>
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Mutasi / Promosi</label>
              <div class="col-md-9">
                <input name="nik" placeholder="Jenis kepegawaiantype" style="text-transform:uppercase;" class="form-control" type="text">
              </div>
            </div>						           
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
