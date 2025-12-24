<?php 
/*
	@author : junis 10-12-2012\m/
	@update : fiky 24-12-2016
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#datemulai").datepicker();                               
				$("#dateselesai").datepicker(); 
				$("#datemulai2").datepicker(); 
				$("#dateselesai2").datepicker(); 
				$("[data-mask]").inputmask();	
            });
</script>

<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">	
					<?php if($akses['aksesinput']=='t') { ?>
<!--					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<?php } ?>
					<a href="<?php echo site_url("trans/stspeg/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				</div>
				<div class="col-sm-6">
				<h5>NIK : <?php echo $nik;?><br>
				<h5>Nama : <?php echo $list_lk['nmlengkap'];?>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
							<th>No Dokumen</th>
							<th>No. SK</th>
							<th>Nama Status</th>							
							<th>Tanggal Mulai</th>							
							<th>Tanggal Berakhir</th>							
							<th>Keterangan</th>											
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_stspeg as $lu): $no++;?>
                            <?php $enc_docno = $this->fiky_encryption->enkript(trim($lu->nodok)); ?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->nosk;?></td>
							<td><?php echo $lu->nmkepegawaian;?></td>
							<td><?php echo $lu->tgl_mulai1;?></td>
							<td><?php echo $lu->tgl_selesai1;?></td>
							<td><?php echo $lu->keterangan;?></td>
							<td style="<?php echo ($lu->status == 'B' ? 'background-color: yellow' : '' ) ?>">
								<?php echo $lu->nmstatus;?>
							</td>

							<td>
								<!--<a href='<?php  $nik=trim($lu->nik); echo site_url("trans/stspeg/detail/$nik/$lu->no_urut")?>' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>-->
								<a data-toggle="modal" data-target="#dtl<?php echo trim($lu->nodok);?>" href='#'  class="btn btn-default  btn-sm" title="Detail">
									<i class="fa fa-bars"></i> Rincian
								</a>
								<?php if($akses['aksesupdate']=='t') { ?>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->nodok);?>" href='#'  class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<?php } ?>
								<?php if($akses['aksesdelete']=='t') { ?>
								<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/stspeg/hps_stspeg/$nik/$lu->nodok")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>
								<?php } ?>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


<!--Modal untuk input status kepegawaian-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Status Kepegawaian <?php echo $nik.'|'.$list_lk['nmlengkap'];?></h4>
      </div>
	  <form action="<?php echo site_url('trans/stspeg/add_stspeg')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" name="nik"  value="<?php echo $nik; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text"  name="nmdept"  value="<?php echo $list_lk['nmdept']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmsubdept"  value="<?php echo $list_lk['nmsubdept']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmjabatan"  value="<?php echo $list_lk['nmjabatan']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nosk"  value="<?php echo $list_lk['nmjabatan']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmatasan"  value="<?php echo $list_lk['nmatasan']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Nama Kepegawaian</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdkepegawaian" id="kdkepegawaian1">
									<option value="">--Pilih Kepegawaian--></option>
									  <?php foreach($list_kepegawaian as $listkan){?>
									  <!--option value=""> Masukkan Opsi </option-->
									  <option value="<?php echo trim($listkan->kdkepegawaian);?>" ><?php echo $listkan->nmkepegawaian;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>	
							<script type="text/javascript" charset="utf-8">
							$(function() {
		
											$('#kdkepegawaian1').change(function(){
												
												var kdkepegawaian=$('#kdkepegawaian1').val();
						
													if(kdkepegawaian=='KT'){
														$('#tglselesai').hide();
															$('#tglmulai').show();
														$('#dateselesai').removeAttr('required');
														//$('#statptg1').prop('required',true);
													} else if(kdkepegawaian=='KK'){
														$('#tglmulai').show();	
															$('#datemulai').prop('required',true);														
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
													} else if(kdkepegawaian=='HL'){
														$('#tglmulai').show();	
															$('#datemulai').prop('required',true);														
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
													}  else if(kdkepegawaian=='MG'){
														$('#tglmulai').show();	
															$('#datemulai').prop('required',true);														
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
													}	else if(kdkepegawaian=='KO'){
														$('#datemulai').removeAttr('required');	
														$('#tglmulai').hide();													
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
														$('#bolehcuti').hide();		
													}else if(kdkepegawaian=='PK'){
														$('#tglmulai').show();	
															$('#datemulai').prop('required',true);														
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
													}else if(kdkepegawaian=='P1'){
														$('#tglmulai').show();	
															$('#datemulai').prop('required',true);														
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
													}else if(kdkepegawaian=='P2'){
														$('#tglmulai').show();	
															$('#datemulai').prop('required',true);														
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
													}else if(kdkepegawaian=='P3'){
														$('#tglmulai').show();	
															$('#datemulai').prop('required',true);														
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
													}else if(kdkepegawaian=='P4'){
														$('#tglmulai').show();	
															$('#datemulai').prop('required',true);														
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
													}else if(kdkepegawaian=='P5'){
														$('#tglmulai').show();	
															$('#datemulai').prop('required',true);														
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
													}else if(kdkepegawaian=='H1'){
														$('#tglmulai').show();	
															$('#datemulai').prop('required',true);														
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
													}else if(kdkepegawaian=='H2'){
														$('#tglmulai').show();	
															$('#datemulai').prop('required',true);														
														$('#tglselesai').show();
															$('#dateselesai').prop('required',true);
													}
												
												
											});
										});	
							</script>
							<div id="tglmulai" class="tglmulaiKO" >
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="datemulai" name="tgl_mulai" data-date-format="dd-mm-yyyy"  class="form-control" required>
								</div>
							</div>
							</div>
							<div class="form-group">
							<div id="tglselesai" class="tglselesaiKT" >
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateselesai" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control" required>
								</div>
							</div>	
							</div>
							<div class="form-group">
								<label class="col-sm-4">No. SK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nosk" name="nosk" class="form-control" style="text-transform:uppercase" maxlength="10">
								</div>
							</div>	
							<div class="form-group">
							<div id="bolehcuti" class="bolehcutiKO bolehcutiMG" >
								<label class="col-sm-4">Boleh Cuti</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="cuti" id="kdbahasa">
										<option  value="F" >TIDAK</option>
										<option  value="T" >YA</option>	
									</select>	
								</div>
							</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>					
							
						
				
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>



<!--Modal status kepegawaian edit-->
<?php foreach ($list_stspeg as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->nodok); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">EDIT STATUS KEPEGAWAIAN KARYAWAN</h4>
      </div>
	  <form action="<?php echo site_url('trans/stspeg/edit_stspeg')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">No.Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo $nik; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	

							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmdept"  value="<?php echo $list_lk['nmdept']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmsubdept"  value="<?php echo $list_lk['nmsubdept']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmjabatan"  value="<?php echo $list_lk['nmjabatan']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nmatasan"  value="<?php echo $list_lk['nmatasan']; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Nama Kepegawaian</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdkepegawaian" id="kdkepegawaian">
									  <?php foreach($list_kepegawaian as $listkan){?>
                                          <?php if(trim($listkan->kdkepegawaian)==trim($lb->kdkepegawaian)) {?>
                                              <option <?php if(trim($listkan->kdkepegawaian)==trim($lb->kdkepegawaian)){ echo 'selected';} ?>
                                              value="<?php echo trim($listkan->kdkepegawaian);?>" ><?php echo $listkan->nmkepegawaian;?></option>
                                          <?php }?>
									  <?php }?>
									</select>
								</div>
							</div>	
							<script type="text/javascript" charset="utf-8">
							
							$(function() {
		
											$('#kdkepegawaian').change(function(){
												
												var kdkepegawaian=$('#kdkepegawaian').val();
						
													if(kdkepegawaian=='KT'){
														$('#tglselesai2').hide();
														$('#tglmulai2').show();	
														$('#dateselesai2').removeAttr('required');
														//$('#statptg1').prop('required',true);
													} else if(kdkepegawaian=='KK'){
														$('#tglmulai2').show();	
															$('#datemulai2').prop('required',true);														
														$('#tglselesai2').show();
															$('#dateselesai2').prop('required',true);
																										
													} else if(kdkepegawaian=='HL'){
														$('#tglmulai2').show();	
															$('#datemulai2').prop('required',true);														
														$('#tglselesai2').show();
															$('#dateselesai2').prop('required',true);
													}  else if(kdkepegawaian=='MG'){
														$('#tglmulai2').show();	
															$('#datemulai2').prop('required',true);														
														$('#tglselesai2').show();
															$('#dateselesai2').prop('required',true);
													}	else if(kdkepegawaian=='KO'){
														$('#datemulai2').removeAttr('required');	
														$('#tglmulai2').hide();													
														$('#tglselesai2').show();
															$('#dateselesai2').prop('required',true);
														$('#bolehcuti2').hide();		
													}
												
												
											});
										});	
							

							</script>
							<div id="tglmulai2" class="tglmulaiKO" >
								<div class="form-group">
									<label class="col-sm-4">Tanggal Mulai</label>
									<div class="col-sm-8">    
										<input type="text" id="" value="<?php echo $lb->tgl_mulai1;?>" name="tgl_mulai" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
									</div>
								</div>
							</div>
							<div id="tglselesai2" class="tglselesaiKT" >
								<div class="form-group">	
									<label class="col-sm-4">Tanggal Selesai</label>	
									<div class="col-sm-8">    
										<input type="text" id="" value="<?php echo $lb->tgl_selesai1;?>" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
									</div>
								</div>	
							</div>
                            <div class="form-group">
                                <label class="col-sm-4">No. SK</label>
                                <div class="col-sm-8">
                                    <input name="nosk" style="text-transform:uppercase;" placeholder="" class="form-control" type="text" value="<?php echo $lb->nosk?>">
                                </div>
                            </div>
							<div id="bolehcuti2" class="bolehcutiKO bolehcutiMG" >
							<div class="form-group">
								<div id="bolehcuti" class="bolehcuti" >
									<label class="col-sm-4">Boleh Cuti</label>	
									<div class="col-sm-8">    
										<select class="form-control input-sm" name="cuti" id="kdbahasa">
											<option <?php if(trim($lb->cuti)=='T'){ echo 'selected';} ?>  value="T" >YA</option>	
											<option  <?php if(trim($lb->cuti)=='F'){ echo 'selected';} ?>  value="F" >TIDAK</option>
										</select>	
									</div>
								</div>
							</div>	
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo trim($lb->keterangan); ?></textarea>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
									
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<?php } ?>
	<!--Modal status kepegawaian edit-->
<?php foreach ($list_stspeg as $ld) { ?>
	<div class="modal fade" id="dtl<?php echo trim($ld->nodok); ?>" tabindex="-1" role="dialog"
		 aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">DETAIL STATUS KEPEGAWAIAN KARYAWAN</h4>
				</div>
				<!--form action="<!?php echo site_url('trans/stspeg/edit_stspeg')?>" method="post"-->
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="box box-danger">
								<div class="box-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label class="col-sm-4">No.Dokumen</label>
											<div class="col-sm-8">
												<input type="text" id="nik" name="nodok"
													   value="<?php echo trim($ld->nodok); ?>" class="form-control"
													   style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4">NIK</label>
											<div class="col-sm-8">
												<input type="text" id="nik" name="nik" value="<?php echo $nik; ?>"
													   class="form-control" style="text-transform:uppercase"
													   maxlength="40" readonly>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-4">Department</label>
											<div class="col-sm-8">
												<input type="text" id="nik" name="nmdept"
													   value="<?php echo $list_lk['nmdept']; ?>" class="form-control"
													   style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4">Sub Department</label>
											<div class="col-sm-8">
												<input type="text" id="nik" name="nmsubdept"
													   value="<?php echo $list_lk['nmsubdept']; ?>" class="form-control"
													   style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4">Jabatan</label>
											<div class="col-sm-8">
												<input type="text" id="nik" name="nmjabatan"
													   value="<?php echo $list_lk['nmjabatan']; ?>" class="form-control"
													   style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4">Nama Atasan</label>
											<div class="col-sm-8">
												<input type="text" id="nik" name="nmatasan"
													   value="<?php echo $list_lk['nmatasan']; ?>" class="form-control"
													   style="text-transform:uppercase" maxlength="40" readonly>
											</div>
										</div>


									</div>
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div>
						<div class="col-sm-6">
							<div class="box box-danger">
								<div class="box-body">
									<div class="form-horizontal">
										<div class="form-group">
											<label class="col-sm-4">Nama Kepegawaian</label>
											<div class="col-sm-8">
												<select class="form-control input-sm" name="kdkepegawaian"
														id="kdkepegawaian" disabled>
													<option value="">--Pilih Kepegawaian--></option>
													<?php foreach ($list_kepegawaian as $listkan) { ?>
														<option <?php if (trim($listkan->kdkepegawaian) == trim($ld->kdkepegawaian)) {
															echo 'selected';
														} ?>
															value="<?php echo trim($listkan->kdkepegawaian); ?>"><?php echo $listkan->nmkepegawaian; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<script type="text/javascript" charset="utf-8">

											$(function () {

												$('#kdkepegawaian').change(function () {

													var kdkepegawaian = $('#kdkepegawaian').val();

													if (kdkepegawaian == 'KT') {
														$('#tglselesai2').hide();
														$('#tglmulai2').show();
														$('#dateselesai2').removeAttr('required');
														//$('#statptg1').prop('required',true);
													} else if (kdkepegawaian == 'KK') {
														$('#tglmulai2').show();
														$('#datemulai2').prop('required', true);
														$('#tglselesai2').show();
														$('#dateselesai2').prop('required', true);

													} else if (kdkepegawaian == 'HL') {
														$('#tglmulai2').show();
														$('#datemulai2').prop('required', true);
														$('#tglselesai2').show();
														$('#dateselesai2').prop('required', true);
													} else if (kdkepegawaian == 'MG') {
														$('#tglmulai2').show();
														$('#datemulai2').prop('required', true);
														$('#tglselesai2').show();
														$('#dateselesai2').prop('required', true);
													} else if (kdkepegawaian == 'KO') {
														$('#datemulai2').removeAttr('required');
														$('#tglmulai2').hide();
														$('#tglselesai2').show();
														$('#dateselesai2').prop('required', true);
														$('#bolehcuti2').hide();
													}


												});
											});


										</script>
										<div id="tglmulai2" class="tglmulaiKO">
											<div class="form-group">
												<label class="col-sm-4">Tanggal Mulai</label>
												<div class="col-sm-8">
													<input type="text" id="datemulai2"
														   value="<?php echo $ld->tgl_mulai1; ?>" name="tgl_mulai"
														   data-date-format="dd-mm-yyyy" class="form-control" disabled>
												</div>
											</div>
										</div>
										<div id="tglselesai2" class="tglselesaiKT">
											<div class="form-group">
												<label class="col-sm-4">Tanggal Selesai</label>
												<div class="col-sm-8">
													<input type="text" id="datemulai2"
														   value="<?php echo $ld->tgl_selesai1; ?>" name="tgl_selesai"
														   data-date-format="dd-mm-yyyy" class="form-control" disabled>
												</div>
											</div>
										</div>
										<div id="bolehcuti2" class="bolehcutiKO bolehcutiMG">
											<div class="form-group">
												<div id="bolehcuti" class="bolehcuti" disabled="">
													<label class="col-sm-4">Boleh Cuti</label>
													<div class="col-sm-8">
														<select class="form-control input-sm" name="cuti" id="kdbahasa"
																disabled>
															<option <?php if (trim($ld->cuti) == 'T') {
																echo 'selected';
															} ?> value="T">YA
															</option>
															<option <?php if (trim($ld->cuti) == 'F') {
																echo 'selected';
															} ?> value="F">TIDAK
															</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4">Keterangan</label>
											<div class="col-sm-8">
                                                <textarea type="text" id="nmdept" name="keterangan"
														  style="text-transform:uppercase" class="form-control"
														  disabled><?php echo trim($ld->keterangan); ?></textarea>

											</div>
										</div>

									</div>
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
					<?php if (trim($ld->status) == 'A') { ?>
						<a href='<?php $nik = trim($ld->nik);
						$enc_nik = bin2hex($this->encrypt->encode(trim($nik)));
						$enc_nodok = bin2hex($this->encrypt->encode(trim($ld->nodok)));
						echo site_url("trans/stspeg/activated/$enc_nik/$enc_nodok") ?>' class="btn btn-success  btn-sm">
							<i class="fa fa-check"></i> Aktifkan
						</a>
					<?php } ?>
				</div>
				<!--/form--->
			</div>
		</div>
	</div>
<?php } ?>