<?php 
/*
	@author : junis 10-12-2012\m/
	@update by: fiky 09/04/2016
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
            });
</script>
<script type="text/javascript">
	
    var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table = $('#ajaxcuti').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('trans/cuti_karyawan/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ],

      });
    });
	
	$('#cbxShowHide').click(function(){
			this.checked?$('#block').show(1000):$('#block').hide(1000);
		});

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

  </script>
  <script>
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script>  
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<a href="<?php echo site_url("trans/cuti_karyawan/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
					<a href="#" data-toggle="modal" data-target="#filter" class="btn btn-info" style="margin:10px; color:#ffffff;">FILTER</a>	
				<!--?php //foreach($list_karyawan as $ms){?>
				<?php if (trim($cek_tglmskkerja['ceker'])<>0){?> 	<!--?php// if (trim($ms->tglmasukkerja)==date('Y-m-d')){?-->
				
				<a href="cuti_karyawan/pr_addcutirata" class="btn btn-warning" style="margin:10px; color:#ffffff;"><?php echo $cek_tglmskkerja['ceker'],' Karyawan Mendapat Hak Cuti';?></a>	
				
					<!--a href="cuti_karyawan/pr_addcutikrybr" class="btn btn-warning" style="margin:10px; color:#ffffff;"><!--?php echo $cek_tglmskkerja['ceker'],' Karyawan Mendapat Hak Cuti';?></a>	
				<?php }?>
				<!--?php// } ?-->	
				
				<!--?php $a=date('Y-01-01'); 
				if ($a==date('Y-m-d')){?>
					<a href="cuti_karyawan/pr_addcutirata" class="btn btn-danger" style="margin:10px; color:#ffffff;"> HAK CUTI CUTI TAHUNAN </a>	
				<!--?php } ?-->	
				<!--/div-->
				
				<!--?php/ $a=date('Y-12-31'); 
				if ($a==date('Y-m-d')){?>
					<a href="cuti_karyawan/pr_hanguscuti" class="btn btn-danger" style="margin:10px; color:#ffffff;"> HANGUS CUTI TAHUNAN </a>	
				<!--?php } ?-->	
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
							
							<th>Nomer Dokumen</th>										
							<th>NIK</th>										
							<th>Nama Karyawan</th>										
							<th>Nama Department</th>										
							<th>Tipe Cuti</th>										
							<th>Tanggal Awal Cuti/Ijin</th>										
							<th>Tanggal Akhir Cuti/Ijin</th>										
							<th>Status</th>											
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_cuti_karyawan as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							<td><?php echo $lu->tpcuti1;?></td>
							<td><?php echo $lu->tgl_mulai1;?></td>
							<td><?php echo $lu->tgl_selesai1;?></td>
							<td><?php echo $lu->status1;?></td>
							<td>
								<a data-toggle="modal" data-target="#dtl<?php echo trim($lu->nodok);?>" href='#' class="btn btn-success  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>
								<?php if (trim($lu->status)<>'C' and trim($lu->status)<>'P' and trim($lu->status)<>'D' and trim($lu->status)<>'F' ) {?>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->nodok);?>" href='#' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-warning  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/cuti_karyawan/hps_cuti_karyawan/$nik/$lu->nodok")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-danger  btn-sm">
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

<!--Modal Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode Cuti/Ijin Khusus</h4>
      </div>
	  <form action="<?php echo site_url('trans/cuti_karyawan/index')?>" method="post">
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
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Status</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="status">
					<option value="P">DISETUJUI</option>
					<option value="A">PERLU PERSETUJUAN</option>
					<option value="C">DIBATALKAN</option>				
					<option value="D">DIHAPUS</option>				
				</select>
			</div>			
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-primary">Filter</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<!--Modal Edit Cuti-->
<?php foreach ($list_cuti_karyawan_dtl as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->nodok); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Ijin Khusus/Cuti Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('trans/cuti_karyawan/edit_cuti_karyawan')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">No. Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="status" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="I" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($lb->kdlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="department"  value="<?php echo trim($lb->nmdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="subdepartment"  value="<?php echo trim($lb->nmsubdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="jabatan"  value="<?php echo trim($lb->nmjabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan"  value="<?php echo trim($lb->nmatasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Alamat</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="alamat"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($lb->alamat);?></textarea>
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
							<script type="text/javascript">
							$(function() {
								$("#colorselector<?php echo trim($lb->nodok); ?>").change(function(){
								$(".colors<?php echo trim($lb->nodok); ?>").hide();
								$('#' + $(this).val()).show();
								});
							});
							</script>
							<div class="form-group">
								<label class="col-sm-4">Tipe Cuti</label>	
									<div class="col-sm-8">
										<select class="form-control input-sm" name="tpcuti" id="colorselector<?php echo trim($lb->nodok);?>">
										 <option type="text" <?php if (trim($lb->tpcuti)=="A") { echo 'selected';}?> value="A<?php echo trim($lb->nodok); ?>">CUTI</option>
										<option type="text" <?php if (trim($lb->tpcuti)=="B") { echo 'selected';}?> value="B<?php echo trim($lb->nodok); ?>">IJIN KHUSUS</option>
										<option type="text" <?php if (trim($lb->tpcuti)=="C") { echo 'selected';}?> value="C<?php echo trim($lb->nodok); ?>">IJIN DINAS</option>
										</select>
									</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Subtitusi Cuti</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="statptg" id="<?php echo trim($lb->nik); ?>">
									 <option type="text" <?php if (trim($lb->status_ptg)=="A1") { echo 'selected';}?> value="A1">POTONG CUTI</option> 
									 <option type="text" <?php if (trim($lb->status_ptg)=="A2") { echo 'selected';}?> value="A2">POTONG GAJI</option> 
									 
									</select>
								</div>
							</div>
							<div class="form-group">
							<div id="B<?php echo trim($lb->nodok); ?>" class="colors<?php echo trim($lb->nodok); ?>" style="display:none;">
								<label class="col-sm-4">Tipe Ijin Khusus</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdijin_khusus" id="kdijin_absensi" >
									  <?php foreach($list_ijin_khusus as $listkan){?>
									  <option value="<?php echo trim($listkan->kdijin_khusus);?>" ><?php echo $listkan->nmijin_khusus;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							</div>
							<script type="text/javascript">
								$(function() {                         
									$("#dateinput<?php echo trim($lb->nodok);?>").datepicker();                               
									$("#dateinput1<?php echo trim($lb->nodok);?>").datepicker();                               
								});
							</script>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput<?php echo trim($lb->nodok);?>" value="<?php echo trim($lb->tgl_mulai1); ?>" name="tgl_awal" data-date-format="dd-mm-yyyy"  class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput1<?php echo trim($lb->nodok);?>" value="<?php echo trim($lb->tgl_selesai1); ?>" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Jumlah Cuti(Hari)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="jumlah_cuti" placeholder="0" value="<?php echo trim($lb->jumlah_cuti); ?>"  class="form-control" required  >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="tgl_dok"  value="<?php echo trim($lb->tgl_dok1);?>"class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pelimpahan Pekerjaan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="pelimpahan" id="kdtrx">
									  <?php foreach($list_karyawan as $listkan){?>
									  <option <?php if (trim($lb->pelimpahan)==trim($listkan->nik)) { echo 'selected';}?> value="<?php echo trim($listkan->nik);?>" ><?php echo $listkan->nmlengkap;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>			
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" ><?php echo trim($lb->keterangan);?></textarea>
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
	  </form>
	</div>  
	
    </div>
  </div>
</div>
<?php } ?>


<!--Modal untuk Aproval+detail-->
<?php foreach ($list_cuti_karyawan_dtl as $lb){?>
<div class="modal fade" id="dtl<?php echo trim($lb->nodok); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail Ijin Khusus/Cuti Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('trans/cuti_karyawan/approval')?>" method="post">
		<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">No. Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="status" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
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
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($lb->kdlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>			
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="department"  value="<?php echo trim($lb->nmdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="subdepartment"  value="<?php echo trim($lb->nmsubdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							<!--<div class="form-group">
								<label class="col-sm-4">Level Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlvl"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="jabatan"  value="<?php echo trim($lb->nmjabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan"  value="<?php echo trim($lb->nmatasan1); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Alamat</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($lb->alamat);?></textarea>
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
								<label class="col-sm-4">Tipe Cuti</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdcuti_karyawan"  value="<?php echo trim($lb->tpcuti1); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Subtitusi Cuti</label>	
								<div class="col-sm-8"> 
									<input type="text" id="stsptg" name="statptg"  value="<?php echo trim($lb->status_ptg1); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>								
								</div>
							</div>
							
							<!--<div class="form-group">
								<label class="col-sm-4">Tipe Ijin Khusus</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdcuti_karyawan"  value="<?php echo trim($lb->nmijin_khusus); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl" value="<?php echo trim($lb->tgl_mulai1); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl" value="<?php echo trim($lb->tgl_selesai1); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jumlah Cuti(Hari)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="durasi" placeholder="0" value="<?php echo trim($lb->jumlah_cuti); ?>"  class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pelimpahan</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="kdtrx"  value="<?php echo trim($lb->nmpelimpahan);?>"class="form-control" readonly>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Tanggal Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="tgl_dok"  value="<?php echo trim($lb->tgl_dok1);?>"class="form-control" readonly>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($lb->keterangan);?></textarea>
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
	<?php if (trim($lb->status)=='A' /*OR trim($lb->status)=='P'*/) { ?>
	
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">APPROVAL</button>  
	  </form>
	</div>  
		
	<?php } ?>
	<!---CEKER KETIKA TANGGAL SUDAH LEWAT SETELAH APROVAL TOMBOL BATAL HILANG-->
	<?php if (trim($lb->status)=='P' OR trim($lb->status)=='F' AND trim($lb->tgl_selesai)>=date('Y-m-d'))	{ ?>
	
	   <div class="modal-footer">
         
	  </form>
	</div> 
	<div class="modal-footer">
		<form action="<?php echo site_url('trans/cuti_karyawan/cancel');?>" method="post">
			<input type="hidden" value="<?php echo trim($lb->nodok);?>" name="nodok">
			<input type="hidden" value="<?php echo trim($lb->nik);?>" name="nik">
			<input type="hidden" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
			<input type="hidden" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
			<button type="submit" class="btn btn-danger" OnClick="return confirm('Cuti Ini Sudah Di APROVAL!! Anda Yakin Membatalkan <?php echo $lb->nodok; echo $lb->nik?>?')">Batal Cuti</button>
		</form>
	</div> 
	<?php } ?>
	
	
	
	
    </div>
  </div>
</div>
<?php } ?>
