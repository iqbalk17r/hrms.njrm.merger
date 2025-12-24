<?php 
/*
	@author : Fiky Ashariza 07/01/2017
*/

?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$(".tgl").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
            });
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
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
					
					<!--a href="<?php echo site_url("trans/dinas/input")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a-->
					
					<a href="#" data-toggle="modal" data-target="#filter" class="btn btn-primary" style="margin:10px; color:#ffffff;">FILTER</a>
					<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php echo site_url("trans/dinas/cetak_tok/$nodok");?>');">CETAK</button>
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
											
										  </tr>
											<tr>
											  
											  <th rowspan="2">No</th>
											  <th  rowspan="2" align="justify"><div align="center">Nodok</div></th>
											  <th  rowspan="2" align="justify"><div align="center">Tanggal </div></th>
											  <th colspan="2" align="justify"><div align="center">Kilometer </div></th>
											  <th colspan="2" align="justify"><div align="center">BBM </div></th>
											  <th colspan="2" align="justify"><div align="center">Penunjang </div></th>
											  <th rowspan="2" align="justify"><div align="center">Uang Saku </div></th>
											  <th rowspan="2" align="justify"><div align="center">Laundry </div></th>	
											  <th rowspan="2" align="justify"><div align="center">Transport </div></th>
											  <th rowspan="2" align="justify"><div align="center">Lain </div></th>
											  <th rowspan="2" align="justify"><div align="center">Total </div></th>
											  <th rowspan="2" align="justify"><div align="center">Uang Muka </div></th>
											  <th rowspan="2" align="justify"><div align="center">Sisa </div></th>
											  <th rowspan="2" align="justify"><div align="center">Keterangan </div></th>
											  <th rowspan="2" align="justify"><div align="center">Aksi </div></th>
											  
								
										  </tr>
											<tr>
											  <th  align="justify"><div align="center">Awal</div></th>
											  <th  align="justify"><div align="center">Akhir</div></th>
											  <th  align="justify"><div align="center">Liter</div></th>
											  <th  align="justify"><div align="center">Rupiah</div></th>
											<th  align="justify"><div align="center">Parkir</div></th>
											  <th  align="justify"><div align="center">Tol</div></th>
								
									      </tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_deklarasi as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><?php echo $lu->nodok;?></td>
							<td width="8%"><?php echo $lu->tgl;?></td>
							<th><?php echo $lu->km_awal;?></th>
							<td><?php echo $lu->km_akhir;?></td>
							
							<td><?php echo $lu->bbm_liter;?></td>
							<td><?php echo $lu->bbm_rupiah;?></td>
							<td><?php echo $lu->parkir;?></td>
							<td><?php echo $lu->tol;?></td>
							<td><?php echo $lu->uangsaku;?></td>
							<td><?php echo $lu->laundry;?></td>
							<td><?php echo $lu->transport;?></td>
							<td><?php echo $lu->lain;?></td>
							<td><?php echo $lu->total;?></td>
							<td><?php echo $lu->uangmuka;?></td>
							<td><?php echo $lu->sisa;?></td>
							<td><?php echo $lu->keterangan;?></td>
							<td>
							
								<a <?php $nodok=trim($lu->nodok);?> href="<?php echo site_url("trans/dinas/detail/$nodok");?>" class="btn btn-success  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>
									
							
								<a  <?php $nodok=trim($lu->nodok);?> href="<?php echo site_url("trans/dinas/edit/$nodok");?>"onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
							
								<a  href="<?php $nodok=trim($lu->nodok); echo site_url("trans/dinas/hapus/$nodok")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
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

<!--Modal Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode DINAS Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('trans/dinas/index')?>" method="post">
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
					<option value="">SEMUA</option>
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

<!--Modal Input Deklarasi-->
<div class="modal fade" id="input" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Deklarasi Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('trans/dinas/input_deklarasi')?>" method="post">
      <div class="modal-body">
	  	<div class="row">
			<div class="col-sm-6">
							<div class="form-group input-sm">
								<label class="col-sm-4">Tanggal Claim</label>	
								<div class="col-sm-8">    
									<input type="text" id="tglclaim" name="tglclaim" data-date-format="dd-mm-yyyy"  class="form-control tgl" required>
								</div>
							</div>	
							<div class="form-group input-sm">
								<label class="col-sm-2">Kilometer Awal :</label>	
								<div class="col-sm-4">    
									<input type="number" id="kmawal" name="kmawal" value=0  class="form-control" >
									<input type="hidden" id="nik" name="nik" value="<?php echo trim($nik);?>"  class="form-control" >
									<input type="hidden" id="nodok" name="nodok" value="<?php echo trim($nodok);?>"  class="form-control" >
								</div>
								<label class="col-sm-2">Kilometer Akhir :</label>	
								<div class="col-sm-4"> 
									<input type="number" id="kmakhir" name="kmakhir" value=0 class="form-control" >
								</div>
							</div>	
							<div class="form-group input-sm">
								<label class="col-sm-2">BBM Liter</label>	
								<div class="col-sm-4">    
									<input type="number" id="bbmliter" name="bbmliter" value=0  class="form-control" >
								</div>
								<label class="col-sm-2">BBM Rupiah</label>	
								<div class="col-sm-4"> 
									<input type="number" id="bbmrupiah" name="bbmrupiah" value=0  class="form-control tambah" >
								</div>
							</div>	
							<div class="form-group input-sm">
								<label class="col-sm-2">Parkir</label>	
								<div class="col-sm-4">    
									<input type="number" id="parkir" name="parkir" value=0 class="form-control tambah" >
								</div>
								<label class="col-sm-2">Tol</label>	
								<div class="col-sm-4"> 
									<input type="number" id="tol" name="tol" value=0  class="form-control tambah" >
								</div>
							</div>	
							<div class="form-group input-sm">
								<label class="col-sm-4">Uang Saku</label>	
								<div class="col-sm-8">    
									<input type="number" id="uangsaku" name="uangsaku" value=0  class="form-control tambah" >
								</div>
							</div>	
							<div class="form-group input-sm">
								<label class="col-sm-4">Laundry</label>	
								<div class="col-sm-8">    
									<input type="number" id="laundry" name="laundry" value=0 class="form-control tambah" >
								</div>
							</div>	
							<div class="form-group input-sm">
								<label class="col-sm-4">Transport</label>	
								<div class="col-sm-8">    
									<input type="number" id="transport" name="transport" value=0 class="form-control tambah" >
								</div>
							</div>	
							<div class="form-group input-sm">
								<label class="col-sm-4">Lain - Lain</label>	
								<div class="col-sm-8">    
									<input type="number" id="lain" name="lain"  value=0 class="form-control tambah" >
								</div>
							</div>	
							
			</div>
						<script type="text/javascript">
										  $(function() {	
										  	var nik=$('#nik').val();
/*
											$.ajax({
													url : "<?php echo site_url('payroll/generate/ajax_cekstatusresign')?>/" + nik,
													type: "GET",
													dataType: "JSON",
													success: function(data)
													{
													    var statusnya=(data.status);   
																	//console.log(data.status);
																	//console.log(statusnya);
													},
													error: function (jqXHR, textStatus, errorThrown)
													{
														alert('Error get data from ajax');
													}
													
													
													
												});
*/							
												//function addCommas(nStr)
												//		{
												//			nStr += '';
												//			x = nStr.split(',');
												//			x1 = x[0];
												//			x2 = x.length > 1 ? ',' + x[1] : '';
												//			var rgx = /(\d+)(\d{3})/;
												//			while (rgx.test(x1)) {
												//				x1 = x1.replace(rgx, '$1' + '.' + '$2');
												//			}
												//			return x1 + x2;
												//		}
													
													//$("#strttlcuti").val(addCommas(parseInt($('#ttlcuti').val())));
													//$("#strttlabsen").val(addCommas(parseInt($('#ttlabsen').val())));
													//$("#strlain").val(addCommas(parseInt($('#lain').val())));
													//$("#strpotongan").val(addCommas(parseInt($('#potongan').val())));
													//$("#strttl_pph21").val(addCommas(parseInt($('#ttl_pph21').val())));
													//$("#strttltarget").val(addCommas(parseInt($('#ttltarget').val())));
													//$("#strttlpph_pesangon").val(addCommas(parseInt($('#ttlpph_pesangon').val())));
													$(".tambah").keyup(function(){
														//int y = (x != null) ? x : -1;
													
														var ttl_bbm = ($('#bbmrupiah').val()) != '' ? parseInt($('#bbmrupiah').val()) : 0;
														var ttl_parkir=($('#parkir').val()) != '' ? parseInt($('#parkir').val()) : 0; 
														var ttl_tol= ($('#tol').val()) != '' ?  parseInt($('#tol').val()) : 0;
														var ttl_uangsaku= ($('#uangsaku').val()) != '' ? parseInt($('#uangsaku').val()) : 0; 
														var ttl_laundry= ($('#laundry').val()) != '' ?  parseInt($('#laundry').val()) : 0;
														var ttl_transport= ($('#transport').val()) != '' ? parseInt($("#transport").val()) : 0; 
														var ttl_lain= ($('#lain').val()) != '' ? parseInt($("#lain").val()): 0; 
														var ttl_uangmuka= ($('#uangmuka').val()) != '' ? parseInt($("#uangmuka").val()): 0; 
														
														
														var ttl_total = (ttl_bbm) + (ttl_parkir) + (ttl_tol) + (ttl_uangsaku) + (ttl_laundry) + (ttl_transport) + (ttl_lain) ;
														
														
														$('[name="total"]').val(ttl_total); 
														$('[name="sisa"]').val(ttl_uangmuka - ttl_total); 
														
													
														
													  });
												 
					
										  });			
						</script>
			
			<div class="col-sm-6">
			
							<div class="form-group input-sm">
								<label class="col-sm-4">Total</label>	
								<div class="col-sm-8">    
									<input type="numeric" id="total" name="total"  class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group input-sm">
								<label class="col-sm-4">Uang Muka</label>	
								<div class="col-sm-8">    
									<input type="numeric" id="uangmuka" name="uangmuka" value=0 class="form-control tambah" >
								</div>
							</div>	
							<div class="form-group input-sm">
								<label class="col-sm-4">Sisa Nominal</label>	
								<div class="col-sm-8">    
									<input type="numeric" id="sisa" name="sisa"  class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group input-sm">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="keterangan" name="keterangan"   style="text-transform:uppercase" class="form-control" required ></textarea>
								</div>
							</div>
			
			</div>
		</div>		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
	  </form>
    </div>
  </div>
</div>








