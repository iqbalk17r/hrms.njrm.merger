<?php 
/*
	@author : junis 10-12-2012\m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#kary").selectize();
                $("#moduser").selectize();
                $("#tahun").selectize();
               
				
            });					
</script>

<legend><?php echo $title." Tahun ". $tahune;?></legend>
<?PHP// ECHO $level_akses.$userhr;?>
<div class="row">
			<form class="form-inline"> <!--action="<!--?php// echo site_url('trans/cuti_karyawan/cutibalance');?" method="post" role="form">
								<!--div class="form-group" role="form"-->
									<!--label class="col-sm-2">PERIODE CUTI KARYAWAN</label>	
									<div class="col-sm-2"> 
									<select id="tahun" Name='pilihtahun' required>
										<option value=""><?php// echo $tahune; ?></option>

										<?php/*
										for ($ngantukjeh=2020; $ngantukjeh>2000; $ngantukjeh--)
										  { 
											echo'<option value="'.$ngantukjeh.'">'.$ngantukjeh.'</option>'; 
										  } */
										?> 
									</select>
									</div-->
		
			<!--button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Dengan Data Yang Di Pilih?')">Lihat Data</button-->
		<?php if ($userhr>0 or $level_akses=='A') { ?>
			<a href="#" data-toggle="modal" data-target="#filter" class="btn btn-primary" style="margin:10px; color:#ffffff;">FILTER</a>
			<a href="pr_hitungallcuti" class="btn btn-danger" style="margin:10px; color:#ffffff;"> HITUNG CUTI </a>
			<a href="<?php echo site_url("trans/cuti_karyawan/excel_blc/$tahune")?>"  class="btn btn-default" style="margin:10px;">Export Excel</a>
		<?php } ?>
			</form>
					

	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>NIK</th>
							<th>NAMA</th>	
							<th>DEPARTEMENT</th>	
							<th>SUB DEPART</th>	
							<th>JABATAN</th>	
							<th>LAST DATE</th>
							<!--th>TIPE DOKUMEN</th-->	
							<!--th>IN CUTI</th>					
							<th>OUT CUTI</th-->					
							<th>SISA CUTI</th>					
							<!--th>STATUS</th-->	
							<th>ACTION</th>	
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($listblc as $lb): $no++;?>
						<tr>										
							<td><?php echo $no;?></td>																							
							<td><?php echo $lb->nik;?></td>
							<td><?php echo $lb->nmlengkap;?></td>
							<td><?php echo $lb->nmdept;?></td>
							<td><?php echo $lb->nmsubdept;?></td>
							<td><?php echo $lb->nmjabatan;?></td>
							<td><?php echo $lb->tanggal;?></td>
							<!--td><?php echo $lb->doctype;?></td-->
							<!--td><?php echo $lb->in_cuti;?></td>
							<td><?php echo $lb->out_cuti;?></td-->
							<td align='RIGHT'><b><?php echo $lb->sisacuti;?></b></td>
							<!--td><?php echo $lb->status;?></td-->
							<td><form action="<?php echo site_url('/trans/cuti_karyawan/cutibalancedtl');?>" method="post" >
												<input type="hidden" value="<?php echo trim($lb->nik);?>" name='kdkaryawan'>
												<input type="hidden" value="<?php echo $tahune;?>" name='tahunlek'>
												
												<button type='submit' class="btn btn-success">Detail</button>
								</form>
							</td>
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode Inquiry Cuti</h4>
      </div>
	  <form action="<?php echo site_url('trans/cuti_karyawan/cutibalance')?>" method="post">
      <div class="modal-body">
        <!--div class="form-group input-sm ">		
			<!--label class="label-form col-sm-3">Bulan</label>
			<!--div class="col-sm-9">
				<select class="form-control input-sm" name='bulan'>
					
					<option value="01" <?php// $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
					<option value="02" <?php// $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
					<option value="03" <?php// $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
					<option value="04" <?php// $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
					<option value="05" <?php// $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
					<option value="06" <?php// $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
					<option value="07" <?php// $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
					<option value="08" <?php// $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
					<option value="09" <?php// $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
					<option value="10" <?php// $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
					<option value="11" <?php// $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
					<option value="12" <?php// $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
				</select>
			</div>			
		</div-->
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Tahun</label>
			<div class="col-sm-9">
				<select id="tahun" Name='pilihtahun' required>
										<option value="">--Pilih Tahun--></option>
										<!--option value=""><!--?php echo $tahune; ?></option-->
										<?php
                                        $filterYear = date('Y');
										for ($ngantukjeh = (int)$filterYear; $ngantukjeh>((int)$filterYear-10); $ngantukjeh--)
										  { 
											echo'<option value="'.$ngantukjeh.'">'.$ngantukjeh.'</option>'; 
										  } 
										?> 
				</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Pilih Department</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="dept" name="lsdept" >
				    <option value="">--Pilih Department--></option>
					<?php foreach ($listdepartmen as $db){?>
					<option value="<?php echo trim($db->kddept);?>"><?php echo $db->nmdept;?>
					</option>
					<!--input type="hidden" value="<?php// echo $db->nmdept;?>" name='nmdept'-->	
					<?php }?>
								
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



<!--Hitung Cuti Karyawan-->
	<div class="modal fade baru"  role="dialog" >
	  <div class="modal-dialog modal-sm-12">
		<div class="modal-content">
			<form class="form-horizontal" action="<?php echo site_url('trans/cuti_karyawan/cutibalance');?>" method="post">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
				<h4 class="modal-title" id="myModalLabel">Hitung Ulang Cuti Karyawan</h4>
			</div>
			<div class="modal-body">										
			<div class="row">
				<div class="col-lg-12">
					<div class="box box-danger">
						<div class="box-body">
							<div class="form-horizontal">								
								
								<div class="form-group">
									<label class="col-sm-4">PILIH NIK DAN Karyawan</label>
									<div class="col-sm-8">
										<select id="moduser" name="kdkaryawan" required>
											<option value="">--Pilih NIK || Nama Karyawan--></option>
											<?php foreach ($listkaryawan as $db){?>
											<option value="<?php echo trim($db->nik);?>"><?php echo str_pad($db->nik,50).' || '.str_pad($db->nmlengkap,50);?></option>
											<?php }?>
										</select>	
									</div>				
								</div>
							
							</div>
							</div>
						</div><!-- /.box-body -->													
					</div><!-- /.box --> 
				</div>			
			</div><!--row-->
			
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Akan Di Process?')">Process</button>											
			</div>
			
			</form>
			</div>
		</div> 
	</div>




