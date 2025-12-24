<?php 
/*
	@author : junis 10-12-2012\m/
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
    $(function() {

        $('#table1').dataTable({
            "paging": true,
            "searching": true,
            "ordering": false,
        });
         $("#datatableMaster").dataTable();
    });
</script>

<legend><?php echo $title;?></legend>

<div class="row">
				<div class="col-sm-6">		
					<a href="<?php echo $_SERVER['HTTP_REFERER'];?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				</div>
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>
                            <th>Action</th>
							<th>NIK</th>	
							<th>Nama Karyawan</th>
							<th>Atasan 1</th>
							<th>Atasan 2</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_karyawan as $row): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td><a href="<?php echo htmlspecialchars(site_url("pk/list_pk/?nik=$row->nik"), ENT_QUOTES, 'UTF-8'); ?>"  class="btn btn-warning" style="margin:10px; padding:10px; color:#ffffff;">Pilih Dokumen <i class="fa fa-check-square-o" style="margin-left:5px;" aria-hidden="true"></i></a></td>
							<td><?php echo $row->nik;?></td>
							<td><?php echo $row->nmlengkap;?></td>
							<td><?php echo $row->nmlengkapatasan1;?></td>
							<td><?php echo $row->nmlengkapatasan2;?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>






