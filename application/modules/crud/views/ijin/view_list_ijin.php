<?php 
/*
	@author : hanif_anak_metal \m/
*/
error_reporting(0);
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
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

<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
			<div class="box-header">
			   <a href="<?php echo site_url('hrd/ijin/list_ijin');?>" class="btn btn-primary" style="margin:10px">
			   <i class="glyphicon glyphicon-edit"></i> Input</a>			   
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Action</th>
							<th>No Dokumen</th>
							<th>NIP</th>
							<th>Nama</th>							
							<th>Departemen</th>
							<th>Jabatan</th>
							<th>Tanggal</th>
							<th>Tipe Ijin</th>
							<th>STATUS</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_ijin as $row): $no++;?>
						<tr>
							<td><?php echo $no;?></td>
							<td>
								<!--<a href="<?php echo site_url('poin/admin_poin/detail_toko/'.$lo->outletcode);?>" data-toggle="tooltip" data-placement="top" title="Edit Ijin Ini" onclick="return confirm('Detail data Ijin ini?')"><i class="glyphicon glyphicon-edit"></i></a>-->
								<a href="<?php echo site_url('hrd/ijin/hps/'.$row->id);?>" data-toggle="tooltip" data-placement="top" title="Hapus Ijin" onclick="return confirm('Hapus data ijin ini?')"><i class="glyphicon glyphicon-trash">Hapus</i></a>								
								<?php if (trim($row->kdijin)=='IK') {?>
									<a href="<?php echo site_url('hrd/ijin/ijin_keluar_pdf/'.$row->id);?>" data-toggle="tooltip" data-placement="top" title="Ijin Keluar PDF" onclick="return confirm('Download Surat Ijin Keluar ini?')"><i class="glyphicon glyphicon-trash">Pdf</i></a>
								<?php ;} else { if ($row->status<>'D'){?>
									<a href="<?php echo site_url('hrd/ijin/ijin_pdf/'.$row->id);?>" data-toggle="tooltip" data-placement="top" title="Ijin PDF" onclick="return confirm('Download Pdf data ijin ini?')"><i class="glyphicon glyphicon-trash">Pdf</i></a>
								<?php ;}}?>
									<a href="<?php echo site_url('hrd/ijin/app_ijin/'.$row->id);?>" data-toggle="tooltip" data-placement="top" title="Approve Ijin" onclick="return confirm('Anda Akan Menyetujui ijin ini?')"><i class="fa fa-check-square-o">Approve</i></a>
									<a href="<?php echo site_url('hrd/ijin/ccl_ijin/'.$row->id);?>" data-toggle="tooltip" data-placement="top" title="Cancel Ijin" onclick="return confirm('Anda Akan Menolak ijin ini?')"><i class="fa fa-times">Cancel</i></a>
							</td>
							<!--<td><a href="<?php echo site_url('hrd/hrd/detail_peg/').'/'.$row->list_nip;?>"><?php echo $row->list_nip;?></a></td>-->
							<td><?php echo $row->kdijin.';'.date('ym',strtotime($row->tgl)).$row->id;?></a></td>
							<td><a href="#" data-toggle="modal" data-target=".<?php echo trim(str_replace('.','_',$row->nip));?>"><?php echo $row->nmlengkap;?></a></td>
							<td><?php echo $row->nmlengkap;?></td>							
							<td><?php echo $row->departement;?></td>
							<td><?php echo $row->deskripsi;?></td>
							<td><?php echo $row->tgl;?></td>
							<td><?php echo $row->desc_kdatt;?></td>
							<td><?php 
								if ($row->status=='I'){
									echo 'INPUT';
								} else if ($row->status=='F'){
									echo 'DISETUJUI';
								} else if ($row->status=='C'){
									echo 'TIDAK DI SETUJUI/BATAL';
								} else if ($row->status=='D'){
									echo 'DIHAPUS/DELETE';	
								}									
								?>
							</td>
							<td><?php echo $row->keterangan_ijin;?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>

<!--edit-->
