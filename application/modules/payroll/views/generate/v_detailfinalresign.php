

<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("#tgl_bayar").datepicker(); 
				$("[data-mask]").inputmask();	
			
            });
			

</script>


<legend><?php echo $title;?></legend>

<?php foreach ($detail as $dt){?>
<form name="autoSumForm" action="<?php echo site_url('payroll/generate/final_slipgaji_resign')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">NIK : <?php echo $dt->nik; ?></label>	
								
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Lengkap : <?php echo $dt->nmlengkap; ?> </label>	
							
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Bagian : <?php echo $dt->nmdept; ?>  </label>	
								
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Masa Kerja : <?php echo $dt->lama_bekerja; ?></label>	
								
							</div>
							<div class="form-group">
								<label class="col-sm-4">Gaji Tetap : <?php echo 'Rp.'.$dt->gajitetap; ?> </label>	
							
							</div>
							<div class="form-group">
							<label class="col-sm-4">Tgl Bayar</label>	
								<input  value="<?php echo $dt->tgl_bayar;?>" class="col-sm-4" type="text" id="tgl_bayar" name="tgl_bayar"   data-date-format="dd-mm-yyyy" class="form-control" required <?php $stat=trim($dt->status); if ($stat=='P') { ?> disabled <?php } else {}?>>
							</div>
							
						</div>
						<a href="<?php echo site_url("payroll/generate/view_pph21_resign_slip/$nik"); ?>" type="button" class="btn btn-primary pull-center">DETAIL PPH21</a>
						<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target="#v_lembur_resign">LEMBUR</a>						
					<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target="#v_shift_resign">SHIFT</a>						
					<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target="#v_absen_resign">ABSEN</a>						
					<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target="#v_borong_resign">BORONG</a>						
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<!--<div class="form-group">
								<label class="col-sm-4">Gaji Tetap</label>	
								<div class="col-sm-8">    
								<input type="number" id="type1" name="gajitetap" value="<?php echo $dt->gajitetap; ?>"  class="form-control" onFocus="startCalc();" onBlur="stopCalc();" readonly>				
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pesangon/Tali Asih</label>	
								<div class="col-sm-8">    
									<input type="number" id="type2" name="kom_pesangon"    value="<?php echo $dt->kom_pesangon;?>" class="form-control" readonly><label> x Gaji Tetap </label>
									<input type="number" id="ttlpesangon" name="ttlpesangon"  value="<?php echo $dt->tj_pesangon;?>" class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Penghargaan Masa Kerja</label>	
								<div class="col-sm-8">    
									<input type="number" id="type3" name="kom_masakerja"    value="<?php echo $dt->kom_masakerja;?>"  class="form-control" readonly ><label> x Gaji Tetap </label>
									<input type="number" id="ttlmasakerja" name="ttlmasakerja"   value="<?php echo $dt->tj_masakerja;?>"  class="form-control" readonly>
								</div>
							</div>-->
			<script type="text/javascript">
										  $(function() {	
										  	var nik=$('#nik').val();

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
							
												function addCommas(nStr)
														{
															nStr += '';
															x = nStr.split(',');
															x1 = x[0];
															x2 = x.length > 1 ? ',' + x[1] : '';
															var rgx = /(\d+)(\d{3})/;
															while (rgx.test(x1)) {
																x1 = x1.replace(rgx, '$1' + '.' + '$2');
															}
															return x1 + x2;
														}
													
													$("#strttlcuti").val(addCommas(parseInt($('#ttlcuti').val())));
													$("#strttlabsen").val(addCommas(parseInt($('#ttlabsen').val())));
													$("#strlain").val(addCommas(parseInt($('#lain').val())));
													$("#strpotongan").val(addCommas(parseInt($('#potongan').val())));
													$("#strttl_pph21").val(addCommas(parseInt($('#ttl_pph21').val())));
													$("#strttltarget").val(addCommas(parseInt($('#ttltarget').val())));
													$("#strttlpph_pesangon").val(addCommas(parseInt($('#ttlpph_pesangon').val())));
													$("#ttlpenggantianhak").keyup(function(){
														
														var ttl_hak=parseInt($('#ttlpenggantianhak').val());
														var ttl_cuti=parseInt($('#ttlcuti').val());
														var ttl_absen=parseInt($('#ttlabsen').val());
														var lain_lain=parseInt($('#lain').val());
														var ttl_pph21=parseInt($('#ttl_pph21').val());
														var ttllbr=parseInt($("#tj_lembur").val());
														var ttlborong=parseInt($("#tj_borong").val());
														var ttlshift=parseInt($("#tj_shift").val());
														var ttlpotongan=parseInt($("#potongan").val());
														
														
														var ttl_pesangon=(ttl_hak + ttl_cuti + ttl_absen + lain_lain + ttllbr + ttlborong + ttlshift + ttlpotongan) + ttl_pph21;
																												
														if ((ttl_hak-50000000.00)<=0){
															var pertama = ((0.00/100.00)*(ttl_hak));
														}else {var pertama = 0.00;};
														
														if ((ttl_hak-50000000) >=0 && (ttl_hak-100000000) <=0){
															var kedua = (ttl_hak-50000000) * (5/100);
														} else if ((ttl_hak-50000000) >=0 && (ttl_hak-100000000) >0){
															var kedua = (50000000) * (5/100);
														} else {var kedua = 0;} ;
														
														if ((ttl_hak-100000000) >=0 && (ttl_hak-500000000) <=0){
															var ketiga = (ttl_hak-100000000) * (15/100);
														} else if ((ttl_hak-100000000) >=0 && (ttl_hak-500000000) >0){
															var ketiga = (400000000) * (15/100);
														} else {var ketiga = 0;} ;
														
														if((ttl_hak-500000000) >=0){
															var keempat = (ttl_hak-500000000) * (25/100);
														} else {var keempat = 0;};
														var pph_pesangon=pertama + kedua + ketiga + keempat;
														
														strttl_pesangon=addCommas(ttl_pesangon);
														strpph_pesangon=addCommas(pph_pesangon);
														
														$('[name="ttltarget"]').val(ttl_pesangon); 
														$('[name="ttlpph_pesangon"]').val(pph_pesangon); 
														
														
														$('[name="strttltarget"]').val(strttl_pesangon);
														$('[name="strttlpph_pesangon"]').val(strpph_pesangon); 
														
													  });
												 
					
										  });			
								</script>							
							<div class="form-group">
								<label class="col-sm-4">Penggantian Hak Pesangon + Masa Kerja</label>	
								<div class="col-sm-8">    
									<!--<input type="number"  id="type4" name="kom_penggantianhak"  value="<?php echo $dt->kom_penggantianhak;?>" class="form-control"   readonly><label> % </label>-->
									<input type="number" id="ttlpenggantianhak" name="ttlpenggantianhak"   value="<?php echo $dt->tj_penggantianhak;?>" class="form-control" 
									<?php $stat=trim($dt->status); if ($stat=='P') { ?> readonly <?php } else {}?>>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Sisa Cuti</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="ttlcuti" name="ttlcuti"   value="<?php echo $dt->tj_cuti;?>" class="form-control" readonly>
									<input type="text" id="strttlcuti" name="strttlcuti"   value="<?php echo $dt->tj_cuti;?>" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Gaji Bulan Ini</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="ttlabsen" name="ttlabsen"  value="<?php echo $dt->tj_absen;?>" class="form-control" readonly>
									<input type="text" id="strttlabsen" name="strttlabsen"  value="<?php echo $dt->tj_absen;?>" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Lain-lain</label>	
								<div class="col-sm-8">    
									<input type="hidden"  id="lain" name="tj_lain"  class="form-control" value="<?php echo $dt->tj_lain;?>" readonly>
									<input type="text"  id="strlain" name="strtj_lain"  class="form-control" value="<?php echo $dt->tj_lain;?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Lembur</label>	
								<div class="col-sm-8">    
									<input type="hidden"  id="tj_lembur" name="tj_lembur"  class="form-control" value="<?php echo $dt->tj_lembur;?>" readonly>
									<input type="text"  id="strtj_lembur" name="strtj_lembur"  class="form-control" value="<?php echo $dt->tj_lembur;?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Shift</label>	
								<div class="col-sm-8">    
									<input type="hidden"  id="tj_shift" name="tj_shift"  class="form-control" value="<?php echo $dt->tj_shift;?>" readonly>
									<input type="text"  id="strtj_shift" name="strtj_shift"  class="form-control" value="<?php echo $dt->tj_shift;?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Borong</label>	
								<div class="col-sm-8">    
									<input type="hidden"  id="tj_borong" name="tj_borong"  class="form-control" value="<?php echo $dt->tj_borong;?>" readonly>
									<input type="text"  id="strtj_borong" name="strtj_borong"  class="form-control" value="<?php echo $dt->tj_borong;?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total Potongan</label>	
								<div class="col-sm-8">    
									<input id="potongan" type="hidden"  name="potongan"  value="<?php echo $dt->potongan;?>" class="form-control" readonly>
									<input id="strpotongan" type="text"  name="strpotongan"  value="<?php echo $dt->potongan;?>" class="form-control" readonly>

								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total PPH 21</label>	
								<div class="col-sm-8">    
									<input id="ttl_pph21" type="hidden"  name="ttl_pph21"  value="<?php echo $dt->ttl_pph21;?>" class="form-control" readonly>	
									<input id="strttl_pph21" type="text"  name="strttl_pph21"  value="<?php echo $dt->ttl_pph21;?>" class="form-control" readonly>	
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total Upah</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="ttltarget"  name="ttltarget"  value="<?php echo $dt->total_upah;?>" class="form-control" readonly>
									<input id="strttltarget"  name="strttltarget"  value="<?php echo $dt->total_upah;?>" class="form-control" readonly>
									<input type="hidden" id="nik" name="nik" value="<?php echo trim($dt->nik);?>" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4">Total PPH Pesangon</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="ttlpph_pesangon"  name="ttlpph_pesangon"  value="<?php echo $dt->ttl_pph_resign;?>" class="form-control" readonly>	
									<input id="strttlpph_pesangon"  name="strttlpph_pesangon"  value="<?php echo $dt->ttl_pph_resign;?>" class="form-control" readonly>	
								</div>
							</div>
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <div class="col-sm-6">
			<a href="<?php echo site_url('payroll/generate/view_finalresign'); ?>" type="button" class="btn btn-default">Close</a>
			<?php $stat=trim($dt->status); if ($stat=='P') { ?> <a href="<?php $nik=trim($dt->nik); echo site_url("payroll/generate/pdf_slipgaji_resign/$nik"); ?>" type="button" class="btn btn-default">CETAK</a> <?php } else { ?>
			<button type="submit"  class="btn btn-primary">FINAL</button> <?php } ?>
			
			
			
		</div>
      </div>
</form>
    


<?php } ?>

	
<!-------------modal dialog untuk karyawan ------------->	
 <div class="modal fade" id="v_lembur_resign" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">DATA LEMBUR KARYAWAN RESIGN</h3>
      </div>
      <div class="modal-body form">
        <form action="<?php echo site_url('trans/generate/excel_lembur_resign');?>" method="post" class="form-horizontal">
          
         <div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Nomer Dokumen</th>																				
							<th>NIK</th>										
							<th>Nama Karyawan</th>							
							<th>Tanggal Kerja</th>
							<th>Jam Mulai</th>
							<th>Jam Selesai</th>
							<th>Jam Mulai(Mesin)</th>
							<th>Jam Selesai(Mesin)</th>
							<th>Durasi Waktu SPL</th>								
							<th>Durasi Waktu Absen</th>																		
							<th>Nominal</th>																		
							<th>Keterangan</th>																		
												
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_lembur as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><a href="#" data-toggle="modal" data-target="#dtl<?php echo trim($lu->nodok_ref);?>"><?php echo $lu->nodok_ref;?></a></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->tgl_kerja1;?></td>
							<td><?php echo $lu->jam_mulai;?></td>
							<td><?php echo $lu->jam_selesai;?></td>
							<td><?php echo $lu->jam_mulai_absen;?></td>
							<td><?php echo $lu->jam_selesai_absen;?></td>
							<td><?php echo $lu->jam;?></td>
							<td><?php echo $lu->jam2;?></td>
							<td><?php echo $lu->nominal1;?></td>
							<td><?php echo $lu->ketsts;?></td>
						
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
        
          </div>
          <div class="modal-footer">
            <button  type="submit" class="btn btn-primary">DOWNLOAD XLS</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
		  </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal --> 
  
 <!-------------modal dialog untuk karyawan ------------->	
 <div class="modal fade" id="v_shift_resign" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">DATA SHIFT KARYAWAN RESIGN</h3>
      </div>
      <div class="modal-body form">
        <form action="<?php echo site_url('trans/generate/excel_lembur_resign');?>" method="post" class="form-horizontal">
          
         <div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
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
							<!--th>Aksi</th--->
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
								<!---td>
								<a  data-toggle="modal" data-target="#<?php echo trim($la->urut);?>" href='#'  class="btn btn-default  btn-sm">
									<i class="fa fa-pencil"></i> Edit
								</a>
								<a  href="<?php  $nik=trim($la->nik); echo site_url("payroll/ceklembur/hapus_shift/$nik/$la->tgl_kerja")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Delete
								</a>
							</td--->	
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
        
          </div>
          <div class="modal-footer">
            <button  type="submit" class="btn btn-primary">DOWNLOAD XLS</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
		  </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal --> 

 <!-------------modal dialog untuk karyawan ------------->	
 <div class="modal fade" id="v_absen_resign" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">DATA ABSEN KARYAWAN RESIGN</h3>
      </div>
      <div class="modal-body form">
        <form action="<?php echo site_url('trans/generate/excel_lembur_resign');?>" method="post" class="form-horizontal">
          
         <div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>-->
							<th>Action</th>																		
							<th>NIK</th>										
							<th>Nama Karyawan</th>							
							<th>Tanggal Kerja</th>
							<th>Shift</th>																					
							<th>Nominal</th>																		
							<th>Keterangan</th>																		
							<!--<th>Action</th>-->						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_absen as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><a href="#" data-toggle="modal" data-target="#dtl<?php echo trim($lu->urut);?>">Edit Absen</a></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->tgl_kerja;?></td>
							<td><?php echo $lu->shiftke;?></td>
							<td><?php echo $lu->cuti_nominal;?></td>
							<td><?php echo $lu->ketsts;?></td>
							<!--<td>
								<!--<a href="<?php $nik=trim($lu->nik); echo site_url("trans/lembur/detail/$nik/$lu->nodok")?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>-->
								<?php if (trim($lu->status)<>'C' and trim($lu->status)<>'A') {?>
								<!--<a href="<?php $nik=trim($lu->nik); echo site_url("trans/lembur/final_mst/$lu->nodok/$nik")?>" onclick="return confirm('Anda Yakin Approval Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Final
								</a>
								<!--<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/lembur/hps_lembur/$lu->nodok")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
								<?php } ?>
							<!--</td>-->
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
        
          </div>
          <div class="modal-footer">
            <button  type="submit" class="btn btn-primary">DOWNLOAD XLS</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
		  </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal --> 
  
<!-------------modal dialog untuk karyawan ------------->	
 <div class="modal fade" id="v_borong_resign" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">DATA BORONG KARYAWAN RESIGN</h3>
      </div>
      <div class="modal-body form">
        <form action="<?php echo site_url('trans/generate/excel_lembur_resign');?>" method="post" class="form-horizontal">
          
         <div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
							
							<th>Nomer Dokumen</th>										
							<th>Tanggal Kerja</th>										
							<th>NIK</th>										
							<th>Nama Karyawan</th>										
							<th>Total Upah</th>											
							<!--<th>Action</th>-->						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_borong as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<!--<td><a href="#" data-toggle="modal" data-target="#dtl<?php echo trim($lu->nodok_ref);?>"><?php echo $lu->nodok_ref;?></a></td>-->
							<td><a <?php echo $nodok=trim($lu->nodok_ref);$nik=trim($lu->nik);?> href="<?php echo site_url("payroll/ceklembur/edit_borong/$nodok/$tglawal/$tglakhir/$nik/$kddept");?>"><?php echo $lu->nodok_ref;?></a></td>
							<td><?php echo $lu->tgl_kerja;?></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->total_upah;?></td>
							<!--<td>
								<!--<a href="<?php $nik=trim($lu->nik); echo site_url("trans/upah_borong/detail/$nik/$lu->nodok")?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>-->
								<?php if (trim($lu->status)<>'C' and trim($lu->status)<>'A') {?>
								<!--<a href="<?php $nik=trim($lu->nik); echo site_url("trans/upah_borong/final_mst/$lu->nodok/$nik")?>" onclick="return confirm('Anda Yakin Approval Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Final
								</a>
								<!--<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/upah_borong/hps_upah_borong/$lu->nodok")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>-->
								<?php } ?>
							<!--</td>-->
						</tr>
						<?php endforeach;?>
					</tbody>
						
				</table>
				</table>
			</div><!-- /.box-body -->
        
          </div>
          <div class="modal-footer">
            <button  type="submit" class="btn btn-primary">DOWNLOAD XLS</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
		  </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
  
  


<script type="text/javascript">
/*
function startCalc(){interval=setInterval("calc()",1)}
function calc(){

}
function stopCalc(){clearInterval(interval)} */
</script>
