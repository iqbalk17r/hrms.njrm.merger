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
<legend>Daftar Absensi </legend>


<div class="row">
					<div class="col-xs-1">
						<button class="btn btn-primary btn-sm"><a href="<?php echo site_url('hrd/hrd/pdf');?>"><i class='fa fa-file-text-o'></i> <label>PDF</label></a></button>
					</div>
					
</div></br>

<div class="row">
                        <div class="col-xs-12">                            
                            <div class="box">
                                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                                    <table id="example1" class="table table-bordered table-striped" >
                                        <thead>
											<tr>
											<th>No.</th>
											<th>Nama</th>
											<th>Checktime</th>
											</tr>
										</thead>
                                        <tbody>
                                            <?php $no=0; foreach($userosin as $row): $no++;?>
											<tr>
												<td><?php echo $no;?></td>
												<td><?php echo $row->fv_nmlengkap;?></td>
												<td><?php echo $row->checktime;?></td>
											</tr>
											<?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
</div>