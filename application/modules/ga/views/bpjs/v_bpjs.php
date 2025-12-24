<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				$("#example2").dataTable();
				$("#example3").dataTable();
				$("#example4").dataTable();
            });
					
			//empty string means no validation error
			}
</script>
<div class="nav-tabs-custom">
<legend><?php echo $title;?></legend>
<div class="row">
	<div class="col-sm-12">
		<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Input SMS</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>

	</div>
</div>	
</br>
<div class="row">
	<div class="col-sm-12">
	<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">					
		<li class="active"><a href="#tab_1" data-toggle="tab">Inbox</a></li>
		<li><a href="#tab_2" data-toggle="tab">Sent Items</a></li>	
		<li><a href="#tab_3" data-toggle="tab">Trash Inbox</a></li>
		<li><a href="#tab_4" data-toggle="tab">Trash Outbox</a></li>
	</ul>
</div>	
<div class="tab-content">
	<div class="chart tab-pane active" id="tab_1" style="position: relative; height: 300px;" >
		
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header">
					 <legend><?php echo $title1;?></legend>
						<?php echo $message;?>
						
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example1" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th>No.</th>
											<th>Nomor Pengirim</th>
											<th>Nama</th>
											<th>Keterangan</th>
											<th>Isi SMS</th>	
											<th>Tanggal Masuk</th>
											<th>Aksi</th>
											<th></th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_sms as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->no_pengirim;?></td>
									<td><?php echo $row->nama;?></td>
									<td><?php echo $row->ket;?></td>
									<td><?php echo $row->isi_sms;?></td>
									<td><?php echo $row->tanggal_masuk;?></td>
									<td><a href="<?php echo site_url('hrd/sms/hps_sms').'/'.$row->id;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->id);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a data-toggle="modal" data-target="#<?php echo trim($row->id);?>" href="#" ><i class="fa  fa-envelope-o"><i> Balas</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>		
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>
<!--tab sent items-->	
<div class="tab-pane" id="tab_2" style="position: relative; height: 300px;" >
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header">
					<legend><?php echo $title2;?></legend>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example2" class="table table-bordered table-striped" >
							 <thead>
										<tr>											
											<th>No.</th>
											<th>Nomer Penerima</th>
											<th>Nama Penerima</th>
											<th>Keterangan</th>
											<th>Isi SMS</th>
											<th>Status</th>	
											<th>Tanggal kirim</th>
											<th>Aksi</th>
											<th>Aksi</th>												
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_outbox as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->no_penerima;?></td>
									<td><?php echo $row->nama;?></td>
									<td><?php echo $row->ket;?></td>
									<td><?php echo $row->isi_sms;?></td>
									<td><?php echo $row->status;?></td>
									<td><?php echo $row->tanggal_kirim;?></td>
									<td><a href="<?php echo site_url('hrd/sms/hps_sentitem').'/'.$row->id;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->id);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
									<td><a data-toggle="modal" data-target="#<?php echo trim($row->id);?>" href="#" ><i class="fa  fa-envelope-o"><i> Kirim Ulang</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>

<!--tab trash inbox-->	
<div class="tab-pane" id="tab_3" style="position: relative; height: 300px;" >
		<legend><?php echo $title3;?></legend>
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header">
					  <a button class="btn btn-primary"  href="<?php echo site_url('hrd/sms/empty_trash_inbox');?>" style="margin:10px" OnClick="return confirm('Anda Yakin Hapus semua?')"><i class="glyphicon glyphicon-trash"></i> EMPTY TRASH</a>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example3" class="table table-bordered table-striped" >
							 <thead>
										<tr>											
											<th>No.</th>
											<th>Nomer Pengirim</th>
											<th>Nama Pengirim</th>
											<th>Isi SMS</th>
											<th>Tanggal Masuk</th>
											<th>Aksi</th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_trash_inbox as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->no_pengirim;?></td>
									<td><?php echo $row->nama;?></td>
									<td><?php echo $row->isi_sms;?></td>									
									<td><?php echo $row->tanggal_masuk;?></td>
									<td><a href="<?php echo site_url('hrd/sms/hps_trash_inbox').'/'.$row->id;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->id);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
								</tr>
								<?php endforeach;?>	
                                    </tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</div>
	
<!--tab trash outbox-->	
<div class="tab-pane" id="tab_4" style="position: relative; height: 300px;" >
		<legend><?php echo $title4;?></legend>
		<?php echo $message;?>
		<div class="row">
			<div class="col-xs-12">                            
				<div class="box">
					<div class="box-header">
					 <a button class="btn btn-primary"  href="<?php echo site_url('hrd/sms/empty_trash_outbox');?>" style="margin:10px" OnClick="return confirm('Anda Yakin Hapus semua?')"><i class="glyphicon glyphicon-trash"></i> EMPTY TRASH</a>
					</div><!-- /.box-header -->	
					<div class="box-body table-responsive" style='overflow-x:scroll;'>
						<table id="example4" class="table table-bordered table-striped" >
							<thead>
										<tr>											
											<th>No.</th>
											<th>Nomor Penerima</th>
											<th>Nama Penerima</th>
											<th>Keterangan</th>
											<th>Isi SMS</th>
											<th>Tanggal Kirim</th>
											<th>Aksi</th>		
										</tr>
									</thead>
                                    <tbody>
									<?php $no=0; foreach($list_trash_outbox as $row): $no++;?>
								<tr>
									
									<td><?php echo $no;?></td>
									<td><?php echo $row->no_penerima;?></td>
									<td><?php echo $row->nama;?></td>
									<td><?php echo $row->ket;?></td>
									<td><?php echo $row->isi_sms;?></td>									
									<td><?php echo $row->tanggal_kirim;?></td>
									<td><a href="<?php echo site_url('hrd/sms/hps_trash_outbox').'/'.$row->id;?>" OnClick="return confirm('Anda Yakin Hapus <?php echo trim($row->id);?>?')"><i class="fa  fa-trash-o"><i> Hapus</a></td>
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
</div>
</div><!--/ nav -->	
<!-- Modal Input Kirim SMS -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Kirim SMS</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('sms/smscenter/input_sms');?>" method="post">
		  <div class="form-group">
			<label for="besaran">Nomer Penerima</label>
			<input type="number" class="form-control" id="penerima" name="penerima" placeholder="Masukan Nomer Penerima">
		  </div>
		  <div>
          <textarea  class="textarea" name="isi" placeholder="Message"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
          </div>
		  
		  <button type="submit" class="btn btn-primary">Kirim</button>
		  <button type="reset" class="btn btn-default">Reset</button>
		</form>
	  </div>
	</div>
  </div>
</div>				
<!--replay sms -->

<!-- Modal BROADCAST SMS -->
<div class="modal fade" id="smsBroadcast" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Kirim SMS</h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('sms/smscenter/broadcast_sms');?>" method="post">
		  <div class="form-group">
			<label for="besaran">PENERIMA SELURUH KARYAWAN NUSA YG MASIH AKTIF</label>
			<input type="number" class="form-control" id="penerima" name="penerima" placeholder="All Employe Nusa Unggul" disabled>
		  </div>
		  <div>
          <textarea  class="textarea" name="isi" placeholder="Message"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
          </div>
		  
		  <button type="submit" OnClick="return confirm('SMS INI AKAN TERKIRIM KE SEMUA NOMOR KARYAWAN PT NUSA UNGGUL SARANA ADICIPTA, APAKAH ANDA YAKIN??')" class="btn btn-warning">BROADCAST SMS</button>
		  <button type="reset" class="btn btn-default">Reset</button>
		</form>
	  </div>
	</div>
  </div>
</div>				
<!--replay sms -->


<?php foreach ($list_sms as $ls){?>

<div class="modal fade" id="<?php echo trim($ls->id);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Kirim SMS <?php echo $ls->no_pengirim;?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('hrd/sms/input_sms');?>" method="post">
		  <div class="form-group">
			<label for="besaran">Nomer Penerima</label>
			<input type="text" class="form-control"  name="penerima" value="<?php echo $ls->no_pengirim;?>" readonly>
		  </div>
		  <div>
          <textarea  class="textarea" name="isi" placeholder="Message"   maxlength ="159" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;"></textarea>
          </div>
		  
		  <button type="submit" class="btn btn-primary">Kirim</button>	
		  <button type="reset" class="btn btn-default">Reset</button>
		</form>
	  </div>
	</div>
  </div>
</div>									
<?php }?>
<!--resend sms -->
<?php foreach ($list_outbox as $lo){?>

<div class="modal fade" id="<?php echo trim($lo->id);?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Kirim SMS <?php echo $lo->no_penerima;?></h4>
	  </div>
	  <div class="modal-body">
		<form role="form" action="<?php echo site_url('hrd/sms/input_sms');?>" method="post">
		  <div class="form-group">
			<label for="besaran">Nomer Penerima</label>
			<input type="text" class="form-control"  name="penerima" value="<?php echo $lo->no_penerima;?>" readonly>
		  </div>
		  <div class="form-group">
			<label for="besaran">Isi SMS</label>
			<input type="textarea" class="form-control"  style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px ;" name="isi" value="<?php echo $lo->isi_sms;?>" readonly>
		  </div>
		  
		  
		  <button type="submit" class="btn btn-primary">Kirim</button>	
		  <button type="reset" class="btn btn-default">Reset</button>
		</form>
	  </div>
	</div>
  </div>
</div>									
<?php }?>

<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode Cuti</h4>
      </div>
	  <form action="<?php site_url('hrd/sms/index')?>" method="post">
      <div class="modal-body">
        <div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name='bulan'>
					
					<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
					<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
					<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
					<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
					<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
					<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
					<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
					<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
					<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
					<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
					<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
					<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
				</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Tahun</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="tahun">
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Filter</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<script>

  

	
	//Date range picker
    $('#tgl').daterangepicker();
	$('#tgl1').daterangepicker();

  

</script>