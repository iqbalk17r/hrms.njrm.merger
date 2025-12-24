<?php 
/*
	@author : Junis
*/
?>
<script type="text/javascript">

    var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table = $('#table').DataTable();
    });

    function add_person()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Tarik Data Absen'); // Set Title to Bootstrap modal title
    }

    function edit_person(id)
    {
      save_method = 'update';
	  
	  $('#editform')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('trans/absensi/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           
			$('[name="kdkepegawaian"]').val(data.kdkepegawaian);
            $('[name="nmkepegawaian"]').val(data.nmkepegawaian);                                    			
            // show bootstrap modal when complete loaded
			$('#modal_form').modal('hide');
			$('#edit_form').modal('show');
            $('.modal-title').text('Edit Status Kepegawaian'); // Set title to Bootstrap modal title
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');			
        }
    });
    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

   

    function delete_person(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
          $.ajax({
            url : "<?php echo site_url('trans/absensi/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
				$("#message").html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b> Hapus Data Sukses</b></div>");
			},
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
				
            }
        });
         
      }
    }

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
<h3><?php echo ' Total Tunjangan Shift = Rp. '.$total_nominal;?></h3>
<div id="message" >	
	<?php echo $message;?>
</div>
<div><?php //echo 'Total data: '.$ttldata['jumlah']; ?></div>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="<?php echo site_url("payroll/ceklembur/lihat_shift_all/$tglawal/$tglakhir/$kddept");?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-success" style="margin:10px; color:#ffffff;">INPUT</a>
					<!--<button class="btn btn-primary" onclick="add_person()" style="margin:10px; color:#ffffff;"><i class="glyphicon glyphicon-plus"></i> Data Mesin Absen</button>-->
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>							
																
							<th width="5%">No.</th>
							<th>Nama</th>
							<th>NIK</th>
							<th>Tanggal</th>
							<th>Shift</th>
							<th>Jam Masuk</th>
							<th>Jam Pulang</th>
							<th>Nominal</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach ($list_shift as $la): $no++ ?>
							<tr>																					
								<td><?php echo $no;?></td>																
								<td><?php echo $la->nmlengkap;?></td>																
								<td><?php echo $la->nik;?></td>								
								<td><?php echo $la->tgl_kerja;?></td>								
								<td><?php echo $la->tpshift;?></td>								
								<td><?php echo $la->jam_mulai_absen;?></td>	
								<td><?php echo $la->jam_selesai_absen;?></td>	
								<td><?php echo $la->nominal1;?></td>	
								<!--<td><?php echo $la->ketsts;?></td>-->	
								<td>
								<a  data-toggle="modal" data-target="#<?php echo trim($la->urut);?>" href='#'  class="btn btn-default  btn-sm">
									<i class="fa fa-pencil"></i> Edit
								</a>
								<a  href="<?php  $nik=trim($la->nik); echo site_url("payroll/ceklembur/hapus_shift/$nik/$la->tgl_kerja")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Delete
								</a>
							</td>	
							</tr>
						<?php endforeach ?>
					</tbody>
					
						
					
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

<!-- INPUT MODAL FILTER -->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Absensi Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('payroll/ceklembur/input_shift')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo $nik; ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="A" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Kerja</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl"  name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control" >
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
								<label class="col-sm-4">Kode Jam Kerja</label>	
								<div class="col-sm-8">    
									<select id="shift" name="kdjamkerja" class="form-control" required>
									<?php foreach ($list_jamkerja as $ld){ ?>
									<option value='<?php echo trim($ld->kdjam_kerja); ?>'><?php  echo $ld->nmjam_kerja; ?></option>
									<?php } ?>	
									</select>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Jam Masuk Absen</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="jam_mulai"   placeholder="HH:MM:SS" data-inputmask='"mask": "99:99:99"' data-mask="" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Selesai Absen</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="jam_selesai"  placeholder="HH:MM:SS" data-inputmask='"mask": "99:99:99"' data-mask="" class="form-control" >
									<input type="hidden" id="tgl2" name="tglawal"  value="<?php echo $tglawal;?>"class="form-control" readonly>
									<input type="hidden" id="tgl3" name="tglakhir"  value="<?php echo $tglakhir;?>"class="form-control" readonly>
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


<?php foreach ($list_shift as $lb) {?>
<div class="modal fade" id="<?php echo trim($lb->urut); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail Absensi Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('payroll/ceklembur/edit_shift')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="A" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
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
								<label class="col-sm-4">Tanggal Kerja</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl" value="<?php echo trim($lb->tgl_kerja); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Shift</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->tpshift); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Jam Masuk Absen</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="jam_mulai"  value="<?php echo trim($lb->jam_mulai_absen); ?>" placeholder="HH:MM:SS" data-inputmask='"mask": "99:99:99"' data-mask="" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Selesai Absen</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="jam_selesai"  value="<?php echo trim($lb->jam_selesai_absen); ?>" placeholder="HH:MM:SS" data-inputmask='"mask": "99:99:99"' data-mask="" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nominal</label>	
								<div class="col-sm-8">    
									<input type="text" id="nmdept" name="keterangan"   value="<?php echo trim($lb->nominal1);?>" class="form-control" readonly>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
									<input type="hidden" id="tgl2" name="tglawal"  value="<?php echo $tglawal;?>"class="form-control" readonly>
									<input type="hidden" id="tgl3" name="tglakhir"  value="<?php echo $tglakhir;?>"class="form-control" readonly>
									<input type="hidden" id="tgl3" name="kddept"  value="<?php echo $kddept;?>"class="form-control" readonly>
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

 
  
 
 <script>

  

	
	//Date range picker
    $('#tgl').datepicker();
	$('#pilihkaryawan').selectize();
	$("[data-mask]").inputmask();

</script>