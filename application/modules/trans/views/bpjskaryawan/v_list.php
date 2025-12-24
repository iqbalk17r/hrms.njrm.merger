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

                $("#kode_bpjs").change(function (){
                    if ($(this).val()==='BPJSTK'){
                        $(".xhide").hide();
                    } else {
                        $(".xhide").show();
                    }


                })
            });
</script>
<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
        <?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>
            <li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>
        <?php } else { ?>
            <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
        <?php } ?>
    <?php } ?>
</ol>
<h3><?php echo $title; ?></h3>
<?php echo $message;?>
<div class="row">
    <div class="col-sm-5">
            <a  href="<?php echo site_url("trans/bpjskaryawan/karyawan")?>"  class="btn btn-default" style="margin:00px; color:#000000;"><i class="fa fa-arrow-left"></i> Kembali</a>
        <?php if (trim($akses_list['aksesinput'])=='t') {?>
            <a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:0px; color:#ffffff;"><i class="fa fa-download"></i> Input Bpjs</a>
        <?php } ?>

    </div>
    <div class="col-sm-3 pull-right">
        <h4 class="pull-right">NIK : <?php echo $nik .' ::  '.$list_lk['nmlengkap'];?> </h4>
    </div>
</div><!-- /.box-header -->
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama Komponen Bpjs</th>
							<th>Id Bpjs</th>
							<th>Tanggal Berlaku</th>
							<th>Keterangan</th>																	
							<th width="8%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_bpjskaryawan as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>
							<td><?php echo $lu->namakomponen;?></td>
							<td><?php echo $lu->id_bpjs;?></td>
							<td><?php echo $lu->tgl_berlaku;?></td>
							<td><?php echo $lu->keterangan;?></td>
							<td width="8%">
							<?php if (trim($akses_list['aksesupdate'])=='t') {?>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->id_bpjs);?>" href='#'  class="btn btn-primary  btn-sm"  title="Ubah Bpjs">
									<i class="fa fa-gear"></i>
								</a>
							<?php } ?>	
							<?php if (trim($akses_list['aksesdelete'])=='t') {?>
								<a  href="<?php
                                $enc_nik=$this->fiky_encryption->enkript(trim($nik));
								$id_bpjs=$this->fiky_encryption->enkript(trim($lu->id_bpjs));
								echo  site_url("trans/bpjskaryawan/hps_bpjs/$enc_nik/$id_bpjs")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-danger  btn-sm" title="Hapus Bpjs">
									<i class="fa fa-trash-o"></i>
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


<!--Modal untuk Input Nama Bpjs-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Bpjs</h4>
      </div>
	  <form action="<?php echo site_url('trans/bpjskaryawan/add_bpjs')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<script type="text/javascript" charset="utf-8">
							  $(function() {	
								$("#kodekomponen").chained("#kode_bpjs");		
								$("#cjabt").chained("#csubdept");	
												
							  });
							</script>
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									
									 <input type="text" id="nik" name="nik"  value="<?php echo $nik; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kode Bpjs</label>	
								<div class="col-sm-8">
									<select class="form-control input-sm" name="kode_bpjs" id="kode_bpjs">
                                        <option value="" > --PILIH KODE BPJS</option>
                                        <?php foreach($list_bpjs as $listkan){?>
									    <option value="<?php echo trim($listkan->kode_bpjs)?>" ><?php echo $listkan->kode_bpjs.'|'.$listkan->nama_bpjs;?></option>
									    <?php }?>
									</select>									
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Kode Komponen Bpjs</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kodekomponen" id="kodekomponen">
									  <?php foreach($list_bpjskomponen as $listkan){?>
									  <option value="<?php echo trim($listkan->kodekomponen);?>" class="<?php echo trim($listkan->kode_bpjs);?>"><?php echo $listkan->kodekomponen.'|'.$listkan->namakomponen;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Id Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="id_bpjs" class="form-control" style="text-transform:uppercase" maxlength="15" required>
									
								</div>
							</div>	
							<div class="form-group xhide">
                                <label class="col-sm-4">Faskes Pertama</label>
                                <div class="col-sm-8">
                                    <input type="text" id="kodefaskes" name="kodefaskes" class="form-control" style="text-transform:uppercase">

                                </div>
							</div>
							<div class="form-group xhide">
                                <label class="col-sm-4">Faskes Kedua</label>
                                <div class="col-sm-8">
                                    <input type="text" id="kodefaskes2" name="kodefaskes2" class="form-control" style="text-transform:uppercase">

                                </div>
							</div>
							<div class="form-group xhide">
								<label class="col-sm-4">Kelas</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kelas" id="kelas">
									  <?php foreach($list_kelas as $listkan){?>
									  <option value="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->uraian;?></option>						  
									  <?php }?>
									</select>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai Berlaku</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput" name="tgl_berlaku"   data-date-format="dd-mm-yyyy" class="form-control" required>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >	
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
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

<!--Modal untuk Edit Bpjs Karyawan-->
<?php foreach ($list_bpjskaryawan as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->id_bpjs); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Bpjs</h4>
      </div>
	  <form action="<?php echo site_url('trans/bpjskaryawan/edit_bpjs')?>" method="post">
      <div class="modal-body">										
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="nik"  value="<?php echo trim($lb->nik);?>" class="form-control" style="text-transform:uppercase" maxlength="15" readonly>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Kode Bpjs</label>	
								<div class="col-sm-8">
									<input type="text" id="nmdept" name="kode_bpjs" value="<?php echo $lb->kode_bpjs;?>"  style="text-transform:uppercase" class="form-control" readonly>								
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4">Kode Komponen Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="nmdept" name="kodekomponen" value="<?php echo $lb->kodekomponen;?>"  style="text-transform:uppercase" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Id Bpjs</label>	
								<div class="col-sm-8">    
									<input type="text" id="kddept" name="id_bpjs"  value="<?php echo $lb->id_bpjs;?>" class="form-control" style="text-transform:uppercase" maxlength="15" readonly>
								</div>
							</div>
                            <?php if (trim($lb->kode_bpjs)=='BPJSKES') { ?>
							<div class="form-group">

								<label class="col-sm-4">Faskes Utama</label>
                                <div class="col-sm-8">
                                    <input type="text" id="kodefaskes" name="kodefaskes" class="form-control" value="<?php echo trim($lb->kodefaskes); ?>" style="text-transform:uppercase">

                                </div>
							</div>
							<div class="form-group">
                                <label class="col-sm-4">Faskes Kedua</label>
                                <div class="col-sm-8">
                                    <input type="text" id="kodefaskes2" name="kodefaskes2" class="form-control" value="<?php echo trim($lb->kodefaskes2); ?>" style="text-transform:uppercase">

                                </div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Kelas</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kelas" id="kelas">
									  <?php foreach($list_kelas as $listkan){?>
									  <option <?php if (trim($lb->kelas)==trim($listkan->kdtrx)) {echo 'selected';}?> value="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->uraian;?></option>						  
									  <?php }?>
									</select>
									
								</div>
							</div>
                            <?php } ?>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai Berlaku</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput1" name="tgl_berlaku"  value="<?php echo $lb->tgl_berlaku1;?>" data-date-format="dd-mm-yyyy" class="form-control">
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"><?php echo $lb->keterangan;?></textarea>
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
<?php } ?>
