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
<legend>Tarik Data </legend>

				<div class="row">
                    <div class="col-xs-12">                            
						<div class="box">
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped" >
                                    <thead>
										<tr>
											<th>Wilayah</th>
											<th>IP Address</th>
											<th colspan="3">Action</th>
										</tr>
									</thead>
                                    <tbody>
										<tr>
											<td>Wilayah</td>
											<td>192.168.1.1</td>
											<td>
												<a href="<?php echo site_url('hrd/absensi/tarik');?>"  >
												<i class="glyphicon glyphicon-refresh"></i> Tarik Data</a>
											</td>
											<td>
												<a href="<?php echo site_url('hrd/absensi/tarik');?>"  >
												<i class="glyphicon glyphicon-edit"></i> Edit</a>
											</td>
											<td>
												<a href="<?php echo site_url('hrd/absensi/tarik');?>"  >
												<i class="glyphicon glyphicon-trash"></i> Hapus</a>
											</td>
										</tr>
										<tr>
											<td>Wilayah</td>
											<td>192.168.1.1</td>
											<td>
												<a href="<?php echo site_url('hrd/absensi/tarik');?>"  >
												<i class="glyphicon glyphicon-refresh"></i> Tarik Data</a>
											</td>
											<td>
												<a href="<?php echo site_url('hrd/absensi/tarik');?>"  >
												<i class="glyphicon glyphicon-edit"></i> Edit</a>
											</td>
											<td>
												<a href="<?php echo site_url('hrd/absensi/tarik');?>"  >
												<i class="glyphicon glyphicon-trash"></i> Hapus</a>
											</td>
										</tr>
										<tr>
											<td>Wilayah</td>
											<td>192.168.1.1</td>
											<td>
												<a href="<?php echo site_url('hrd/absensi/tarik');?>"  >
												<i class="glyphicon glyphicon-refresh"></i> Tarik Data</a>
											</td>
											<td>
												<a href="<?php echo site_url('hrd/absensi/tarik');?>"  >
												<i class="glyphicon glyphicon-edit"></i> Edit</a>
											</td>
											<td>
												<a href="<?php echo site_url('hrd/absensi/tarik');?>"  >
												<i class="glyphicon glyphicon-trash"></i> Hapus</a>
											</td>
										</tr>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
				</div>