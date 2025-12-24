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
<legend><i class="glyphicon glyphicon-envelope"></i> Reminder Mail Notification</legend>

<div class="row">
	<div class="col-xs-12">                            
		<div class="box">
		    <a href="<?php echo site_url('hrd/mail/input');?>" class="btn btn-primary" style=" margin:10px"><i class="glyphicon glyphicon-pencil"></i><font color="#fffff"><b> New Kode Mail</b></font></a>
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Action</th>
							<th>Kode Mail</th>
							<th>Subject</th>
							<th>Isi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($mail as $row): $no++;?>
						<tr>
							<td><?php echo $no;?></td>
							<td>
							<a href="<?php echo site_url('hrd/mail/edit').'/'.trim($row->kdmail);?>" value="<?php echo $row->kdmail;?>" name="kdmail" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
							|<a href="<?php echo site_url('hrd/mail/delete_mail/').'/'.trim($row->kdmail);?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data kode mail ini?')"><i class="glyphicon glyphicon-trash"></i></a></td>
							<td><?php echo $row->kdmail;?></td>
							<td><?php echo $row->subject;?></td>
							<td><?php echo $row->isi;?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
