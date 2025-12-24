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
		    <!--Febri 17-04-2015 <a href="<?php echo site_url('hrd/mail/get_mail');?>" class="btn btn-primary" style=" margin:10px"><i class="glyphicon glyphicon-pencil"></i><font color="#fffff"><b> Go To Mail</b></font></a>-->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>NIP</th>
							<th>Nama</th>
							<th>Tgl Reminder</th>
							<th>Email</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($reminder as $row): $no++;?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $row->nip;?></td>
							<td><?php echo $row->nmlengkap;?></td>
							<td><?php echo $row->tglreminder;?></td>
							<td><?php echo $row->email;?></td>
							<td><?php echo $row->subject;?></td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
