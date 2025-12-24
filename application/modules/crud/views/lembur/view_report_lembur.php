<?php 
/*
	@author : hanif_anak_metal \m/
*/

?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
				<?php foreach($list_lembur as $lbur){
					echo '$("#'.trim($lbur->nip).'").dataTable();';
				}?>
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bInfo": true,
                    "bSort": true,
                    "bAutoWidth": false
                });
            });
</script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-2">		
		<button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter Periode</button>
	</div>
	<div class="col-sm-2">		
		<form action="<?php echo site_url('hrd/lembur/excel07');?>" method="post">
			<input type="hidden" value="<?php echo $bulane;?>" name="bulan">
			<input type="hidden" value="<?php echo $tahun;?>" name="tahun">
			<button type="submit" class="btn btn-primary">Excel 07</button>
		</form>
	</div>
</div>
</br>
<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-body table-responsive" >
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th>Nama</th>									
							<th width="10%">Lama Lembur</th>																	
							<th>Gaji</th>
							<th>Lembur</th>					
							<th>Total</th>
						</tr>
					</thead>
					
					<tbody>
					<?php $no=0; foreach($list_lembur as $lmbur){$no++;?>
						<tr>
							<td><?php echo $no;?></td>
							<td><a href="#" data-toggle="modal" data-target=".<?php echo str_replace(".",'',$lmbur->nip);?>"><?php echo $lmbur->nmlengkap;?></a></td>																												
							<td><?php echo $lmbur->lamalembur;?></td>							
							<td><?php echo $lmbur->gajipokok;?></td>
							<td><?php echo $lmbur->gajilembur;?></td>
							<td><?php echo $lmbur->totalgaji;?></td>
						</tr>
					<?php }?>
					</tbody>					
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>
				
<!-- Modal -->
<?php $no=0; foreach($list_lembur as $lembur): $no++;?>
	<div class="modal fade <?php echo str_replace(".",'',$lmbur->nip);?>" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Persetujuan Lembur <?php echo $lembur->nmlengkap;?></h4>
			  </div>
			  <div class="modal-body">
				<div class="row">
					<div class="col-xs-12">                            
						<div class="box">
							<div class="box-body table-responsive" >
								<table  class="table table-bordered table-striped" >
									<thead>
										<tr>
											<th width="5%">No.</th>
											<th>Nama</th>									
											<th width="10%">No Lembur</th>																	
											<th width="10%">Tanggal</th>																	
											<th>Jam Pulang</th>
											<th>Lama Lembur</th>				
											<th>Jenis Pekerjaan</th>
										</tr>
									</thead>
									<?php $no=0; foreach($list_lembur_dtl as $lb_dtl): ?>
									<tbody>
										<tr>
											<?php if (trim($lembur->nip)==trim($lb_dtl->nip)) { $no++;?>
											
											<td><?php echo $no;?></td>
											<td><?php echo $lb_dtl->nmlengkap;?></td>																												
											<td><?php echo $lb_dtl->notransaksi;?></td>							
											<td><?php echo $lb_dtl->tanggal;?></td>							
											<td><?php echo $lb_dtl->jampulang;?></td>
											<td><?php echo $lb_dtl->ttl_waktulembur;?></td>
											<td><?php echo $lb_dtl->jenis_pekerjaan;?></td>
											<td><?php 
													 echo $lb_dtl->gajipokok+$lb_dtl->gajilembur;
											?></td>
											<?php }?>
										</tr>
									</tbody>
									<?php endforeach;?>
								</table>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
				</div>
				<form role="form" action="<?php echo site_url('hrd/lembur/proses_lembur');?>" name="Form" method="post">
				<div class="row">				
					<div class="col-lg-6">						
						<div class="form-group">						
							<label class="col-sm-5 control-label">Gaji</label>
							<div class="col-sm-7">								
							  <input type="text" id="gaji" name="gaji" class="form-control" required/>							  
							  <input type="hidden" id="jamlembur" name="jamlembur" value="<?php echo $lembur->jamlembur;?>" class="form-control input-sm" />
							  <input type="hidden" id="jamlembur" name="nip" value="<?php echo $lembur->nip;?>" class="form-control input-sm" />
							</div>							
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="inputby" class="col-sm-5 control-label">Lembur</label>
							<div class="col-sm-7">
							  <input type="numeric" id="gajilembur" name="gajilembur" class="form-control" readonly/>
							</div>							
						</div>
					</div>
				</div>
			  </div>
			  <div class="modal-footer">
				<div class="col-sm-6">
					<label for="inputby" class="col-sm-3 control-label">Total Gaji</label>
					<div class="col-sm-9">
						<input type="text" id="totalgaji"  name="totalgaji" class="form-control input-lg" readonly/>
					</div>										
				</div>
				<div class="col-sm-6">
					<button type="submit" class="btn btn-primary" onclick="return confirm('Anda Yakin Menyetujui Lembur <?php echo $lembur->nmlengkap;?>?');">Setuju</button>
				</form>
					<button type="button" class="btn btn-danger">Hapus</button>
					<button class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>
			</div>
		  </div>
		
	</div>
<script>
 
// memformat angka ribuan
function formatAngka(angka) {
 if (typeof(angka) != 'string') angka = angka.toString();
 var reg = new RegExp('([0-9]+)([0-9]{3})');
 while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');
 return angka;
}
  
// nilai total ditulis langsung, bisa dari hasil perhitungan lain
var  
 jam =<?php echo (float)$lembur->jamlembur;?>,
 menit =<?php echo (float)$lembur->menitlembur;?>,
 total = 4500,
 bayar = 0,
 kembali = 0;
 
// masukkan angka total dari variabel
//$('#input-total').val(formatAngka(total));
 
// tambah event keypress untuk input bayar
$('#gaji').on('keypress', function(e) {
 var c = e.keyCode || e.charCode;
 switch (c) {
  case 8: case 9: case 27: case 13: return;
  case 65:
   if (e.ctrlKey === true) return;
 }
 if (c < 48 || c > 57) e.preventDefault();
}).on('keyup', function() {
 var inp = $(this).val().replace(/\./g, '');
  
 // set nilai ke variabel bayar
 bayar = new Number(inp);
 $(this).val(formatAngka(inp));
  
 // set kembalian, validasi
 
 if (bayar > total) kembali = bayar - total;
 if (total > bayar) kembali = 0;
 $('#input-kembali').val(formatAngka(kembali));
 if (jam > 1) jamsisa = jam - 1;
 if (jam = 1) jamsisa = 0;
 lemburjam1 = ((bayar/173)* 1.5);
 lemburjamsisa=((bayar/173)*2*jamsisa);
 lemburmenit=((bayar/10380)*2*menit);
 lembur= lemburjam1+lemburjamsisa+lemburmenit;
 $('#gajilembur').val(formatAngka(Math.round(lembur)));
 ttlembur=bayar+lembur;
 $('#totalgaji').val(formatAngka(Math.round(ttlembur)));
});
</script>
<?php endforeach;?>

<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode Lembur</h4>
      </div>
	  <form action="<?php site_url('hrd/lembur/index')?>"  method="post">
      <div class="modal-body">
        <div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm input-sm" name='bulan'>
					
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
				<select class="form-control input-sm input-sm" name="tahun">
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

	//Date picker
    $('#tgl').datepicker();

</script>

<script type="text/javascript">
function startCalc(){interval=setInterval("calc()",1)}
function calc(){
gapok=document.Form.gaji.value;
jamlembur=document.Form.jamlembur.value;
document.Form.gajilembur.value=((gapok*1)/173)*(jamlembur*1);
galur=document.Form.gajilembur.value;
//sum perbulan
document.Form.totalgaji.value=(gapok*1)+(galur*1);

}
function stopCalc(){clearInterval(interval)}
</script>