<script type="text/javascript">
            $(function() {
                $("#test1").dataTable();
                $("#example1").dataTable();
                $("#example3").dataTable();
				$("#dateinput").datepicker();
				$("#dateinput1").datepicker();
				$("#dateinput2").datepicker();
				$("#dateinput3").datepicker();
				$("[data-mask]").inputmask();
				<?php foreach($listhiscuti as $jvascpt){
					echo	'$("#'.trim($jvascpt->nodok).'").dataTable(); ';
					//echo	'$("#tgl'.trim().'").datepicker(); ';-->
				}?>
            });

</script>

<legend><?php echo $title;?></legend>
<?php echo $message;?>
	<label class="control-label col-sm-3">Click No Dokumen Untuk List Karyawan Yang Ikut/Batal Cuti Bersama</label>
<div class="row">
	<div class="col-sm-12">

		<div class="box">
			<div class="box-header">

				<div class="col-sm-12">
				<a href="<?php echo site_url("trans/cuti_karyawan/addcutibersama")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;"><i class="fa fa-plus"></i> Input</a>
			</div>
		</div>
	<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->

							<th>Nomer Dokumen</th>
							<th>TGL DOKUMEN</th>
							<th>TGL AWAL</th>
							<th>TGL AKHIR</th>
							<th>Jumlah Cuti</th>
							<th>STATUS</th>
							<th>KETERANGAN</th>

							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($listhiscuti as $lu): $no++;?>
						<tr>
							<td width="2%"><?php echo $no;?></td>
							<td><a href="<?php echo site_url("trans/cuti_karyawan/list_tmp_cb/".trim($lu->nodok)."");?>"><?php echo $lu->nodok;?></a></td>
							<!--td><?php echo $lu->nodok;?></td-->
							<td><?php echo $lu->tgl_dok;?></td>


							<td><?php echo $lu->awal;?></td>
							<td><?php echo $lu->akhir;?></td>
							<td><?php echo $lu->jumlahcuti;?></td>
							<td><?php echo $lu->status1;?></td>
							<td><?php echo $lu->keterangan;?></td>

							<td>
								<?php if (trim($lu->status)<>'C') { ?>
									<?php if (trim($lu->status)<>'P' and trim($lu->status)<>'F') {?>
									<a href="<?php echo site_url("trans/cuti_karyawan/cutibersamaoto/$lu->nodok");?>"  onclick="return confirm('Anda Yakin Dokumen Akan Dilakukan Save Final Maka Cuti Karyawan Akan Berkurang??')" class="btn btn-success">Final/Edit</a>
									<a href="<?php echo site_url("trans/cuti_karyawan/hps_cutibersama/$lu->nodok");?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-danger">Hapus</a>
									<?php } ?>
									<?php if (trim($lu->status)=='P' and trim($lu->tgl_awal)>=date('Y-m-d')) {?>
									<a href="<?php echo site_url("trans/cuti_karyawan/hps_cutibersama/$lu->nodok");?>" onclick="return confirm('Anda Yakin Hapus Data ini? Dokumen Ini Sudah Di Final LHOOO!!!!')" class="btn btn-danger">Hapus</a>
									<?php } ?>
								<?php } ?>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
		</div><!-- /.box-body -->
	</div>
</div>
</div>

