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

<?php //foreach ($list_lk as $lb){?>
<form name="autoSumForm" action="<?php echo site_url('payroll/generate/add_gajiresign')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">
							
							
												
							<div class="form-group">
								<label class="col-sm-4">NIK : <?php echo $nik; ?></label>	
								
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Lengkap : <?php echo $nmlengkap; ?> </label>	
							
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Bagian : <?php echo $nmdept; ?>  </label>	
								
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Masa Kerja : <?php echo $pesan; ?></label>	
								
							</div>
							<div class="form-group">
								<label class="col-sm-4">Gaji Tetap : <?php echo 'Rp.'.$gajitetap; ?> </label>	
							</div>

							
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
					<a href="<?php echo site_url("payroll/generate/view_pph21_resign/$nik"); ?>" type="button" class="btn btn-primary pull-center">DETAIL PPH21</a>
					<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target="#v_lembur_resign">LEMBUR</a>						
					<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target="#v_shift_resign">SHIFT</a>						
					<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target="#v_absen_resign">ABSEN</a>						
					<a href="#" type="button" class="btn btn-default" data-toggle="modal" data-target="#v_borong_resign">BORONG</a>						
			</div>
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">Gaji Tetap</label>	
								<div class="col-sm-8">    
								<input type="number" id="type1" name="gajitetap" value="<?php echo $gajitetap; ?>"  class="form-control" onFocus="startCalc();" onBlur="stopCalc();" required>				
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pesangon/Tali Asih</label>	
								<div class="col-sm-8">    
									<input type="number" id="type1" name="kom_pesangon"   class="col-sm-2" onFocus="startCalc();" onBlur="stopCalc();" ><label> x Gaji Tetap </label>
									<input type="number" id="ttlpesangon" name="ttlpesangon"   class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Penghargaan Masa Kerja</label>	
								<div class="col-sm-8">    
									<input type="number" id="type1" name="kom_masakerja"   class="col-sm-2" onFocus="startCalc();" onBlur="stopCalc();" ><label> x Gaji Tetap </label>
									<input type="number" id="ttlmasakerja" name="ttlmasakerja"   class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Penggantian Hak</label>	
								<div class="col-sm-8">    
									<input type="number"  id="type1" name="kom_penggantianhak"  class="col-sm-2" onFocus="startCalc();" onBlur="stopCalc();" ><label> % </label>
									<input type="number" id="ttlpenggantianhak" name="ttlpenggantianhak"   class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Sisa Cuti</label>	
								<div class="col-sm-8">    
									<input type="number"  id="type1" name="kom_cuti"  class="col-sm-2" onFocus="startCalc();" onBlur="stopCalc();" ><label> x (Gaji Tetap / 25)</label>
									<input type="number" id="ttlcuti" name="ttlcuti"   class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Hari Aktif Masuk Kerja</label>	
								<div class="col-sm-8">    
									<input type="number" id="type1" name="kom_absen" class="col-sm-2" onFocus="startCalc();" onBlur="stopCalc();" ><label> x (Gaji Tetap / 25)</label>
									<input type="hidden"  name="nik" value="<?php echo trim($nik)?>" class="form-control">
									<input type="hidden"  name="bln" value="<?php //echo trim($bln)?>" class="form-control">
									<input type="number" id="ttlabsen" name="ttlabsen"   class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">LEMBUR</label>	
								<div class="col-sm-8">    
									<!--input type="number"  id="ttllbr1" name="ttllbr1"  class="form-control" onFocus="startCalc();" onBlur="stopCalc();" -->
									<input value="<?php echo $sum_lembur['nominal'];?>"  type="number" id="ttllbr" name="ttllbr"   class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">SHIFT</label>	
								<div class="col-sm-8">    
									<!--input type="number"  id="ttlshift1" name="ttlshift1"  class="form-control" onFocus="startCalc();" onBlur="stopCalc();" -->
									<input value="<?php echo $sum_shift['nominal'];?>" type="number" id="ttlshift" name="ttlshift"   class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">BORONG</label>	
								<div class="col-sm-8">    
									<!--input type="number"  id="borong1" name="borong1"  class="form-control" onFocus="startCalc();" onBlur="stopCalc();" --->
									<input value="<?php echo $sum_borong['nominal'];?>"  type="number" id="ttlborong" name="ttlborong"   class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Lain-lain</label>	
								<div class="col-sm-8">    
									<input type="number"  id="type1" name="tj_lain"  class="form-control" onFocus="startCalc();" onBlur="stopCalc();" >
									<input type="number" id="ttllain" name="ttllain"   class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Potongan</label>	
								<div class="col-sm-8">    
									<input type="number"  id="potongan1" name="potongan1"  class="form-control" onFocus="startCalc();" onBlur="stopCalc();" >
									<input type="number" id="potongan" name="potongan"   class="form-control" readonly>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Total</label>	
								<div class="col-sm-8">    
									<input id="ttltarget" type="number"  name="ttltarget"  value="<?php //echo $gajitetap;?>" class="form-control" readonly>
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
			<a href="<?php echo site_url('payroll/generate/payroll_resign'); ?>" type="button" class="btn btn-default">Close</a>
			<button type="submit"  class="btn btn-primary">SIMPAN</button>
		</div>
      </div>
</form>
    
	
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
function startCalc(){interval=setInterval("calc()",1)}
function calc(){
gajitetap=document.autoSumForm.gajitetap.value;
kom_pesangon=document.autoSumForm.kom_pesangon.value;
kom_masakerja=document.autoSumForm.kom_masakerja.value;
kom_penggantianhak=document.autoSumForm.kom_penggantianhak.value;
kom_cuti=document.autoSumForm.kom_cuti.value;
kom_absen=document.autoSumForm.kom_absen.value;
tj_lain=document.autoSumForm.tj_lain.value;
potongan1=document.autoSumForm.potongan1.value;
var ttllbr1=parseInt($("#ttllbr").val());
var ttlborong1=parseInt($("#ttlborong").val());
var ttlshift1=parseInt($("#ttlshift").val());


document.autoSumForm.ttlpesangon.value=(kom_pesangon*gajitetap)
document.autoSumForm.ttlmasakerja.value=(kom_masakerja*gajitetap)
document.autoSumForm.ttlpenggantianhak.value=(kom_penggantianhak/100.00*(kom_pesangon*gajitetap))+(kom_penggantianhak/100.00*(kom_masakerja*gajitetap))
document.autoSumForm.ttlcuti.value=(kom_cuti*(gajitetap/25))
document.autoSumForm.ttlabsen.value=((gajitetap/25)*kom_absen)
document.autoSumForm.ttllain.value=(tj_lain*1)
document.autoSumForm.potongan.value=(potongan1)
//alert(ttlshift1) ;
document.autoSumForm.ttltarget.value=(kom_penggantianhak/100.00*(kom_pesangon*gajitetap))+(kom_penggantianhak/100.00*(kom_masakerja*gajitetap))+(kom_cuti*(gajitetap/25))+((gajitetap/25)*kom_absen)+(tj_lain*1)+(ttllbr1)+(ttlborong1)+(ttlshift1)-(potongan1)
//document.autoSumForm.ttltarget.value=(ttlpesangon*1)+(ttlmasakerja*1)+(ttlpenggantianhak*1)+(ttlcuti*1)+(ttlabsen)+(ttllain*1)+(tj_lain*1)

}
function stopCalc(){clearInterval(interval)}
</script>
