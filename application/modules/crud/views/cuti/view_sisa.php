<?php 
/*
	@author : hanif_anak_metal \m/
*/
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
<legend>Sisa Cuti </legend>

<div class="row">
                        <div class="col-xs-12">                            
                            <div class="box">
                                <div class="box-header">
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive" style='overflow-x:scroll;'>
                                    <table id="example1" class="table table-bordered table-striped" >
                                        <thead>
											<tr>
											<th>No.</th>
											<th>NIP</th>
											<th>CUTI</th>
											<th>Nama</th>
											<th>Alamat</th>
											<th>Departemen</th>
											<th>Tahun</th>
											<th>Sisa Cuti</th>
											</tr>
										</thead>
                                        <tbody>
                                            <?php $no=0; foreach($userosin as $row): $no++;?>
											<tr>
												<td><?php echo $no;?></td>
												<td><?php echo $row->nip;?></td>
												<td>
												<form action="<?php echo site_url('hrd/cuti/input');?>" method="post" >
												<input type="hidden" value="<?php echo $row->nip;?>" name='nip'>
												<button type='submit' class="button-default">Ambil Cuti</button>
												</form>
												</td>
												<td><?php echo $row->nmlengkap;?></td>
												<td><?php echo $row->alamat;?></td>
												<td><?php echo $row->departement;?></td>
												<td><?php echo $row->tahun;?></td>
												<td><?php echo $row->sisacuti;?></td>
											</tr>
											<?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
</div>